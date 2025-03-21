<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

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
	    $this->mod_common->is_company_page_accessible(131);
        $data['tasks'] = $this->mod_common->get_all_records("scheduling_tasks","*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Tasks');
	    $this->stencil->paint('scheduling/tasks/manage_tasks', $data);
	}

	public function add_task() {
        $this->mod_common->is_company_page_accessible(131);
        $this->mod_scheduling->is_viewer();
        $this->stencil->title('Add Task');
        $this->stencil->paint('scheduling/tasks/add_new_task');
    }
	
	 public function add_new_task_process() {
		 
         $this->mod_scheduling->is_viewer();
		$this->form_validation->set_rules('name', 'Task', 'required');
	    if ($this->form_validation->run() == FALSE)
			{
			     $this->stencil->title('Add Task');
                 $this->stencil->paint('scheduling/tasks/add_new_task');
			}
		else{
			$table = "scheduling_tasks";
					
			$name = $this->input->post('name');
                        $created_by = $this->session->userdata("user_id");
                        $company_id = $this->session->userdata("company_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
				"name" => $name,
				"created_by" => $created_by,
                "ip_address" => $ip_address,
                "company_id" => $company_id,
				"status" => 1
			);
					
		        $add_new_task = $this->mod_common->insert_into_table($table, $ins_array);
            if ($add_new_task) {
			    
			    $table = "project_scheduling_checklists";		
			    $checklists = $this->input->post('checklists');
			    
                    for($i=0;$i<count($checklists);$i++){
                        if($checklists[$i]!=""){
                            $ins_array = array(
                                    "task_id" => $add_new_task,
                    				"name" => $checklists[$i],
                    				"created_by" => $created_by,
                    				"company_id" => $company_id,
                                    "ip_address" => $ip_address,
    			                	"status" => 1
    			            );
		                    $add_new_checklist = $this->mod_common->insert_into_table($table, $ins_array);
                        }
                    }
                    
				$this->session->set_flashdata('ok_message', 'New Task added successfully.');
				redirect(SURL . 'buildz/tasks');
			}
		    else {

				$this->session->set_flashdata('err_message', 'New Task is not added. Something went wrong, please try again.');

				redirect(SURL . 'buildz/tasks');
			}
		}
    }
	
	public function edit_task($task_id) {
	    
	$this->mod_common->is_company_page_accessible(131);
	if($task_id=="" || !(is_numeric($task_id))){
            redirect("nopage");
        }
		
        $table = "scheduling_tasks";
        $where = array("id" => $task_id, "company_id" => $this->session->userdata("company_id"));

        $data['task_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['task_edit']) == 0) {
            redirect("nopage");
        } else {
            $this->stencil->title("Edit Task");

            $this->stencil->paint('scheduling/tasks/edit_task', $data);
        }
    }

    public function edit_task_process() {
	    $this->mod_common->is_company_page_accessible(131);
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_task'))
            redirect(SURL."buildz/tasks");

	    $task_id = $this->input->post('task_id');
		
        $table = "scheduling_tasks";
	    $where = array("id" => $task_id, "company_id" => $this->session->userdata("company_id"));

	    $data['task_edit'] = $this->mod_common->select_single_records($table, $where);
		
            $original_value = $data['task_edit']['name'];
		
        if($this->input->post('name') != $original_value) {
            $is_unique =  '|is_unique[project_scheduling_tasks.name]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('name', 'Task', 'required'.$is_unique);
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Task");
                   $this->stencil->paint('scheduling/tasks/edit_task', $data);
		    
		}
		
		else{	
			$table = "tasks";
					
			$name = $this->input->post('name');
			$created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
					"name" => $name,
			                "created_by" => $created_by,
                                        "ip_address" => $ip_address
			);
                                                        
							
			$table = "scheduling_tasks";
			$where = "`id` ='" . $task_id . "'";
			$update_task = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_task) {
				$this->session->set_flashdata('ok_message', 'Task updated successfully.');
				redirect(SURL . 'buildz/tasks');
			} else {
				$this->session->set_flashdata('err_message', 'Task is not updated. Something went wrong, please try again.');
				redirect(SURL . 'buildz/tasks/edit_task/' . $task_id);
			}
		}
    }
	
	public function delete_task() {
    $this->mod_common->is_company_page_accessible(131);

	$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "scheduling_tasks";
        $where = "`id` ='" . $id . "'";
		
        $delete_task = $this->mod_common->delete_record($table, $where);

        $table = "scheduling_items";
        $where = "`task_id` ='" . $id . "'";
        
        $item = $this->mod_common->select_single_records($table, $where);
		
        $this->mod_common->delete_record($table, $where);
        
        //Delete Item Checklists
        
        $table = "scheduling_item_checklists";
        $where = "`item_id` ='" . $item['id'] . "'";
		
        $delete_task = $this->mod_common->delete_record($table, $where);
        
        //Delete Checklists
        
        $table = "scheduling_checklists";
        $where = "`task_id` ='" . $id . "'";
		
        $this->mod_common->delete_record($table, $where);

        //Delete Notes

       $table = "scheduling_item_notes";
       $where = "`item_id` ='" . $item['id'] . "'";

       $this->mod_common->delete_record($table, $where);

       //Delete Reminders

       $table = "scheduling_item_reminders";
       $where = "`item_id` ='" . $item['id'] . "'";

       $this->mod_common->delete_record($table, $where);

       //Delete Files

       $table = "scheduling_item_files";
       $where = "`item_id` ='" . $item['id'] . "'";

       $this->mod_common->delete_record($table, $where);

    }
	
    public function verify_task() {

        $name = $this->input->post("name");
        
        $table = "scheduling_tasks";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'name' => $name,
            'company_id' =>  $this->session->userdata("company_id")
          );
        }
        else{
          $where = array(
            'name' => $name,
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
