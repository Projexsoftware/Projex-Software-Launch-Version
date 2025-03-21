<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklists extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

        public function __construct() {
             parent::__construct();

             $this->stencil->layout('default_layout');

             $this->stencil->slice('header_script');
             $this->stencil->slice('header');
             $this->stencil->slice('sidebar');
             $this->stencil->slice('footer_script');
             $this->stencil->slice('footer');

             $this->load->model("mod_common");

             $this->mod_common->verify_is_user_login();
             $this->mod_common->is_company_page_accessible(126);

        }
	public function index()
	{
	    $this->mod_common->is_company_page_accessible(163);
        $data['checklists'] = $this->mod_common->get_all_records("project_buildz_checklists","*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Buildz Checklists');
	    $this->stencil->paint('supplierz_buildz/checklists/manage_checklists', $data);
	}

	public function add_checklist() {
	     $this->mod_common->is_company_page_accessible(163);
        $table = "project_buildz_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Add Buildz Checklist');
        $this->stencil->paint('supplierz_buildz/checklists/add_new_checklist', $data);
    }
	
	 public function add_new_checklist_process() {
	    //$this->form_validation->set_rules('name', 'Checklist', 'required|is_unique[checklists.name]');
            //$this->form_validation->set_rules('name[]', 'Checklist', 'required');
            $this->form_validation->set_rules('task_id', 'Task', 'required');
	    if ($this->form_validation->run() == FALSE)
			{
			     $table = "project_buildz_tasks";
                             $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
                             $this->stencil->title('Add Buildz Checklist');
                             $this->stencil->paint('supplierz_buildz/checklists/add_new_checklist', $data);
			}
		else{
			$table = "project_buildz_checklists";

			$task_id = $this->input->post('task_id');		
			$name = $this->input->post('name');
                        $created_by = $this->session->userdata("user_id");
                        $company_id = $this->session->userdata("company_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        for($i=0;$i<count($name);$i++){
                        if($name[$i]!=""){
                        $ins_array = array(
                                "task_id" => $task_id,
                				"name" => $name[$i],
                				"created_by" => $created_by,
                				"company_id" => $company_id,
                                "ip_address" => $ip_address,
			                	"status" => 1
			);
					
		        $add_new_checklist = $this->mod_common->insert_into_table($table, $ins_array);

                       }
                       }

			if ($add_new_checklist) {

				$this->session->set_flashdata('ok_message', 'New Checklist added successfully.');
				redirect(SURL . 'supplierz_buildz/checklists');
			} else {

				$this->session->set_flashdata('err_message', 'New Checklist is not added. Something went wrong, please try again.');

				redirect(SURL . 'supplierz_buildz/checklists');
			}
		}
    }
	
	public function edit_checklist($checklist_id) {
	 $this->mod_common->is_company_page_accessible(163);
	if($checklist_id=="" || !(is_numeric($checklist_id))){
            redirect("nopage");
        }
		
        $table = "project_buildz_checklists";
        $where = array("id" => $checklist_id, "company_id" => $this->session->userdata("company_id"));

        $data['checklist_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['checklist_edit']) == 0) {
            redirect("nopage");
        } else {

            $table = "project_buildz_tasks";
            $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" => $this->session->userdata("company_id")));

            $this->stencil->title("Edit Checklist");

            $this->stencil->paint('supplierz_buildz/checklists/edit_checklist', $data);
        }
    }

    public function edit_checklist_process() {

        $table = "project_buildz_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" => $this->session->userdata("company_id")));

        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_checklist'))
            redirect(SURL."supplierz_buildz/checklists");
	    $checklist_id= $this->input->post('checklist_id');
		
        $table = "project_buildz_checklists";
	    $where = array("id" => $checklist_id, "company_id" => $this->session->userdata("company_id"));

	    $data['checklist_edit'] = $this->mod_common->select_single_records($table, $where);
		
            $original_value = $data['checklist_edit']['name'];
		
        if($this->input->post('name') != $original_value) {
            $is_unique =  '|is_unique[project_buildz_checklists.name]';
        } else {
            $is_unique =  '';
        }
      
        //$this->form_validation->set_rules('name', 'Checklist', 'required'.$is_unique);

        $this->form_validation->set_rules('name', 'Checklist', 'required');

		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Checklist");
                   $this->stencil->paint('supplierz_buildz/checklists/edit_checklist', $data);
		    
		}
		
		else{	
			$table = "checklists";

			$task_id = $this->input->post('task_id');
			$name = $this->input->post('name');
			$created_by = $this->session->userdata("admin_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
					"name" => $name,
			                "created_by" => $created_by,
                                        "ip_address" => $ip_address
			);
                                                        
							
			$table = "project_buildz_checklists";
			$where = "`id` ='" . $checklist_id . "'";
			$update_checklist = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_checklist) {
				$this->session->set_flashdata('ok_message', 'Checklist updated successfully.');
				redirect(SURL . 'supplierz_buildz/checklists');
			} else {
				$this->session->set_flashdata('err_message', 'Checklist is not updated. Something went wrong, please try again.');
				redirect(SURL . 'supplierz_buildz/checklists/edit_checklist/' . $checklist_id);
			}
		}
    }
	
	public function delete_checklist() {
	    
		$this->mod_common->is_company_page_accessible(163);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
        
        $table = "project_buildz_checklists";
        $where = "`id` ='" . $id . "'";
        $delete_checklist = $this->mod_common->delete_record($table, $where);

    }
	
    public function verify_checklist() {

        $name = $this->input->post("name");
        
        $table = "project_buildz_checklists";

        $task_id = $this->input->post("task_id");

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'task_id' => $task_id,
            'name' => $name,
            'company_id' =>  $this->session->userdata("company_id")
          );
        }
        else{
          $where = array(
            'name' => $name,
            'task_id' => $task_id,
            'company_id' =>  $this->session->userdata("company_id")
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
 
}
