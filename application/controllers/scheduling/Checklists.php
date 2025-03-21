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
             $this->load->model("mod_scheduling");

             $this->mod_common->verify_is_user_login();
             $this->mod_common->is_company_page_accessible(134);
             $this->mod_common->is_company_page_accessible(154);

        }
	public function index()
	{
	    $this->mod_common->is_company_page_accessible(138);
        $data['checklists'] = $this->mod_common->get_all_records("scheduling_checklists","*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Checklists');
	    $this->stencil->paint('scheduling/checklists/manage_checklists', $data);
	}

	public function add_checklist() {
	     $this->mod_common->is_company_page_accessible(138);
        $this->mod_scheduling->is_viewer();
        $table = "scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Add Checklist');
        $this->stencil->paint('scheduling/checklists/add_new_checklist', $data);
    }
	
	 public function add_new_checklist_process() {
		 
        $this->mod_scheduling->is_viewer();
	    //$this->form_validation->set_rules('name', 'Checklist', 'required|is_unique[checklists.name]');
            //$this->form_validation->set_rules('name[]', 'Checklist', 'required');
            $this->form_validation->set_rules('task_id', 'Task', 'required');
	    if ($this->form_validation->run() == FALSE)
			{
			     $table = "scheduling_tasks";
                             $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
                             $this->stencil->title('Add Checklist');
                             $this->stencil->paint('scheduling/checklists/add_new_checklist', $data);
			}
		else{
			$table = "scheduling_checklists";

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

                                $check_list_id = $this->db->insert_id();

                                $table = "scheduling_items";
                                $where = "`task_id` ='" . $task_id."'";

                                $checklists = $this->mod_common->get_all_records($table, '*', 0, 0, $where);
                                foreach($checklists as $val){
                                  if($val['checklist']!=""){
                                    $ck = explode(",", $val['checklist']);
                                    if(!(in_array($check_list_id, $ck))){
                                      $this->mod_common->update_table($table, array("id"=>$val['id']), array("status"=>1));
                                    }
                                  }
                                }

				$this->session->set_flashdata('ok_message', 'New Checklist added successfully.');
				redirect(SURL . 'buildz/checklists');
			} else {

				$this->session->set_flashdata('err_message', 'New Checklist is not added. Something went wrong, please try again.');

				redirect(SURL . 'buildz/checklists');
			}
		}
    }
	
	public function edit_checklist($checklist_id) {
	 $this->mod_common->is_company_page_accessible(138);
	if($checklist_id=="" || !(is_numeric($checklist_id))){
            redirect("nopage");
        }
		
        $table = "scheduling_checklists";
        $where = array("id" => $checklist_id, "company_id" => $this->session->userdata("company_id"));

        $data['checklist_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['checklist_edit']) == 0) {
            redirect("nopage");
        } else {

            $table = "scheduling_tasks";
            $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" => $this->session->userdata("company_id")));

            $this->stencil->title("Edit Checklist");

            $this->stencil->paint('scheduling/checklists/edit_checklist', $data);
        }
    }

    public function edit_checklist_process() {

        $table = "scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" => $this->session->userdata("company_id")));

        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_checklist'))
            redirect(SURL."buildz/checklists");
	    $checklist_id= $this->input->post('checklist_id');
		
        $table = "scheduling_checklists";
	    $where = array("id" => $checklist_id, "company_id" => $this->session->userdata("company_id"));

	    $data['checklist_edit'] = $this->mod_common->select_single_records($table, $where);
		
            $original_value = $data['checklist_edit']['name'];
		
        if($this->input->post('name') != $original_value) {
            $is_unique =  '|is_unique[scheduling_checklists.name]';
        } else {
            $is_unique =  '';
        }
      
        //$this->form_validation->set_rules('name', 'Checklist', 'required'.$is_unique);

        $this->form_validation->set_rules('name', 'Checklist', 'required');

		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Checklist");
                   $this->stencil->paint('scheduling/checklists/edit_checklist', $data);
		    
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
                                                        
							
			$table = "scheduling_checklists";
			$where = "`id` ='" . $checklist_id . "'";
			$update_checklist = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_checklist) {
				$this->session->set_flashdata('ok_message', 'Checklist updated successfully.');
				redirect(SURL . 'buildz/checklists');
			} else {
				$this->session->set_flashdata('err_message', 'Checklist is not updated. Something went wrong, please try again.');
				redirect(SURL . 'buildz/checklists/edit_checklist/' . $checklist_id);
			}
		}
    }
	
	public function delete_checklist() {
	    
		$this->mod_common->is_company_page_accessible(138);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "scheduling_checklists";
        $where = "`id` ='" . $id . "'";

        $checklist_info = $this->mod_common->select_single_records($table, $where);
        $table = "scheduling_items";
                                $where = "`task_id` ='" . $checklist_info['task_id']."'";

                                $checklists = $this->mod_common->get_all_records($table, '*', 0, 0, $where);
                                $total_checklists = $this->mod_common->get_all_records("scheduling_checklists", '*', 0, 0, array("task_id"=> $checklist_info['task_id']));
                                foreach($checklists as $val){
                                  if($val['checklist']!=""){
                                    $ck = explode(",", $val['checklist']);
                                    unset($ck[array_search($id,$ck)]);
                                    $checklist_array = implode(",", $ck);
                                    if($checklist_array==""){
                                      $status = 0;
                                    }
                                    else if(count($ck)<count($total_checklists)){
                                      $status = 1;
                                    }
                                    else if(count($ck)==count($total_checklists)){
                                      $status = 2;
                                    }
                                    $this->mod_common->update_table($table, array("id"=>$val['id']), array("status"=>$status, "checklist"=>$checklist_array));
                                   
                                  }
                                }
        $table = "scheduling_checklists";
        $where = "`id` ='" . $id . "'";
        $delete_checklist = $this->mod_common->delete_record($table, $where);

    }
	
    public function verify_checklist() {

        $name = $this->input->post("name");
        
        $table = "scheduling_checklists";

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
