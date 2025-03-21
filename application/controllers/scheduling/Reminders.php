<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminders extends CI_Controller {

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
	    $this->mod_common->is_company_page_accessible(141);
        $data['reminder_users'] = $this->mod_common->get_all_records("scheduling_reminders","*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Reminders');
	    $this->stencil->paint('scheduling/reminders/manage_reminders', $data);
	}

	public function add_reminder() {
	    $this->mod_common->is_company_page_accessible(141);
        $this->mod_scheduling->is_viewer();
        $table = "scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));
        $this->stencil->title('Add Reminder');
        $this->stencil->paint('scheduling/reminders/add_new_reminder', $data);
    }
	
	 public function add_new_reminder_process() {
		 
            $this->mod_scheduling->is_viewer();
            $this->form_validation->set_rules('task_id', 'Task', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
	    if ($this->form_validation->run() == FALSE)
			{
			    $table = "scheduling_tasks";
                $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));
                $this->stencil->title('Add Reminder');
                $this->stencil->paint('scheduling/reminders/add_new_reminder', $data);
			}
		else{
			$table = "scheduling_reminders";

			$task_id = $this->input->post('task_id');
                        $message = $this->input->post('message');
                        $created_by = $this->session->userdata("user_id");
                        $company_id = $this->session->userdata("company_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
                                "task_id" => $task_id,
                                "message" => $message,
				                "created_by" => $created_by,
				                "company_id" => $company_id,
                                "ip_address" => $ip_address,
				                "status" => 1
			);
					
		        $add_new_reminder = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_reminder) {
				$this->session->set_flashdata('ok_message', 'New Reminder added successfully.');
				redirect(SCURL . 'reminders');
			} else {

				$this->session->set_flashdata('err_message', 'New Reminder is not added. Something went wrong, please try again.');

				redirect(SCURL . 'reminders');
			}
		}
    }
	
	public function edit_reminder($reminder_id) {
		$this->mod_common->is_company_page_accessible(141);
	if($reminder_id=="" || !(is_numeric($reminder_id))){
            redirect("nopage");
        }
		
        $table = "scheduling_reminders";
        $where = "`id` ='" . $reminder_id."'";

        $data['reminder_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['reminder_edit']) == 0) {
            redirect("nopage");
        } else {

            $table = "scheduling_tasks";
            $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));

            $this->stencil->title("Edit Reminder");

            $this->stencil->paint('scheduling/reminders/edit_reminder', $data);
        }
    }

    public function edit_reminder_process() {
		$this->mod_common->is_company_page_accessible(141);
        $this->mod_scheduling->is_viewer();

        $table = "scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id"), "status" => 1));

        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_reminder'))
            redirect(SCURL);
	    $reminder_id= $this->input->post('reminder_id');
		
        $table = "scheduling_reminders";
	    $where = array("id" => $reminder_id, "company_id" => $this->session->userdata("company_id"));

	    $data['reminder_edit'] = $this->mod_common->select_single_records($table, $where);
		

        $this->form_validation->set_rules('message', 'Message', 'required');

		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Reminder");
           $this->stencil->paint('scheduling/reminders/edit_reminder', $data);
		    
		}
		
		else{	
			$table = "scheduling_reminders";

			$task_id = $this->input->post('task_id');
                        $message = $this->input->post('message');
			$created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
                                        "message" => $message,
			                "created_by" => $created_by,
                                        "ip_address" => $ip_address
			);
                                                        
							
			$table = "scheduling_reminders";
			$where = "`id` ='" . $reminder_id . "'";
			$update_reminder = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_reminder) {
				$this->session->set_flashdata('ok_message', 'Reminder updated successfully.');
				redirect(SCURL . 'reminders');
			} else {
				$this->session->set_flashdata('err_message', 'Reminder is not updated. Something went wrong, please try again.');
				redirect(SCURL . 'reminders/edit_reminder/' . $reminder_id);
			}
		}
    }
	
	public function delete_reminder() {
		$this->mod_common->is_company_page_accessible(141);
        $this->mod_scheduling->is_viewer();
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	
        $table = "scheduling_reminders";
        $where = "`id` ='" . $id . "'";
        $delete_reminder = $this->mod_common->delete_record($table, $where);

    }
 
}
