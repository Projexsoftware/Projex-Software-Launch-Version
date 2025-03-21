<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminder_users extends CI_Controller {

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

        }

        
	public function index()
	{
        $data['reminder_users'] = $this->mod_common->get_all_records("scheduling_reminder_users","*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Reminder Users');
	    $this->stencil->paint('scheduling/reminder_users/manage_reminder_users', $data);
	}

	public function add_user() {
        $this->mod_scheduling->is_viewer();
        $table = "scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));
        $this->stencil->title('Add Reminder User');
        $this->stencil->paint('scheduling/reminder_users/add_new_reminder_user', $data);
    }
	
	 public function add_new_reminder_user_process() {
		 
            $this->mod_scheduling->is_viewer();
	    //$this->form_validation->set_rules('email', 'Email', 'required|is_unique[reminder_users.email]');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('task_id', 'Task', 'required');
	    if ($this->form_validation->run() == FALSE)
			{
			     $table = "scheduling_tasks";
                             $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));
                             $this->stencil->title('Add Reminder User');
                             $this->stencil->paint('checklists/add_new_reminder_user', $data);
			}
		else{
			$table = "scheduling_reminder_users";

			$task_id = $this->input->post('task_id');		
			$email = $this->input->post('email');
                        $message = $this->input->post('message');
                        $created_by = $this->session->userdata("user_id");
                        $company_id = $this->session->userdata("company_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
                                "task_id" => $task_id,
                				"email" => $email,
                                "message" => $message,
                				"created_by" => $created_by,
                				"company_id" => $company_id,
                                "ip_address" => $ip_address,
                				"status" => 1
			);
					
		        $add_new_reminder_user = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_reminder_user) {
				$this->session->set_flashdata('ok_message', 'New Reminder User added successfully.');
				redirect(SURL . 'reminder_users');
			} else {

				$this->session->set_flashdata('err_message', 'New Reminder User is not added. Something went wrong, please try again.');

				redirect(SURL . 'reminder_users');
			}
		}
    }
	
	public function edit_user($reminder_id) {
		
	if($reminder_id=="" || !(is_numeric($reminder_id))){
            redirect("nopage");
        }
		
        $table = "scheduling_reminder_users";
        $where = array("id" => $reminder_id, "company_id" => $this->session->userdata("company_id"));

        $data['reminder_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['reminder_edit']) == 0) {
            redirect("nopage");
        } else {

            $table = "scheduling_tasks";
            $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));

            $this->stencil->title("Edit Reminder User");

            $this->stencil->paint('scheduling/reminder_users/edit_reminder_user', $data);
        }
    }

    public function edit_reminder_user_process() {
		
        $this->mod_scheduling->is_viewer();

        $table = "scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));

        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_reminder'))
            redirect(SURL);
	    $reminder_id= $this->input->post('reminder_id');
		
        $table = "scheduling_reminder_users";
	    $where = array("id" => $reminder_id, "company_id" => $this->session->userdata("company_id"));

	    $data['reminder_edit'] = $this->mod_common->select_single_records($table, $where);
		
            $original_value = $data['reminder_edit']['email'];
		
        if($this->input->post('email') != $original_value) {
            $is_unique =  '|is_unique[reminder_users.email]';
        } else {
            $is_unique =  '';
        }
      
        //$this->form_validation->set_rules('email', 'Email', 'required'.$is_unique);

        $this->form_validation->set_rules('email', 'Email', 'required');

		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Reminder User");
                   $this->stencil->paint('scheduling/reminder_users/edit_reminder_user', $data);
		    
		}
		
		else{	
			$table = "scheduling_reminder_users";

			$task_id = $this->input->post('task_id');
			$email = $this->input->post('email');
                        $message = $this->input->post('message');
			$created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
					"email" => $email,
                                        "message" => $message,
			                "created_by" => $created_by,
                                        "ip_address" => $ip_address
			);
                                                        
							
			$table = "scheduling_reminder_users";
			$where = array("id" => $reminder_id, "company_id" => $this->session->userdata("company_id"));
			$update_reminder = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_reminder) {
				$this->session->set_flashdata('ok_message', 'Reminder User updated successfully.');
				redirect(SURL . 'reminder_users');
			} else {
				$this->session->set_flashdata('err_message', 'Reminder User is not updated. Something went wrong, please try again.');
				redirect(SURL . 'reminder_users/edit_user/' . $reminder_id);
			}
		}
    }
	
	public function delete_user() {
		
                $this->mod_scheduling->is_viewer();

		$this->mod_common->is_company_page_accessible(20);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	
        $table = "scheduling_reminder_users";
        $where = "`id` ='" . $id . "'";
        $delete_checklist = $this->mod_common->delete_record($table, $where);

    }
	
    public function verify_email() {

        $email = $this->input->post("email");
        
        $table = "scheduling_reminder_users";

        $task_id = $this->input->post("task_id");

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'task_id' => $task_id,
            'email' => $email,
            "company_id" =>  $this->session->userdata("company_id")
          );
        }
        else{
          $where = array(
            'email' => $email,
            'task_id' => $task_id,
            'email' => $email,
            "company_id" =>  $this->session->userdata("company_id")
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
