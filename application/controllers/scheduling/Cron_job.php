<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends CI_Controller {

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
             $this->load->model("mod_common");

        }
	public function index()
	{
	    redirect("nopage");
	}

    public function send_reminder_email()
	{   
           $current_date = date("Y-m-d");
           $table="project_scheduling_item_reminders";
           $reminders_list = $this->mod_common->get_all_records($table, "*", 0, 0, array("status" => 0));
           if(count($reminders_list)>0){
               foreach($reminders_list as $val){ 
              if($val['reminder_type']==0){
                $reminder_date = $val['date'];
              }
              else if($val['reminder_type']==1){
                $task_date = new DateTime($val['date']);
                $no_of_days = $val['no_of_days']+1;
                $task_date->modify("+".$no_of_days." days");
                $reminder_date = $task_date->format("Y-m-d");
              }
              else if($val['reminder_type']==2){
                $task_date = new DateTime($val['date']);
                $no_of_days = $val['no_of_days']+1;
                $task_date->modify("-".$no_of_days." days");
                $reminder_date = $task_date->format("Y-m-d");
              }
              
              if($reminder_date==$current_date){
                  
              $reminder_user = $this->mod_common->select_single_records("project_scheduling_reminder_users", array("id" => $val['to_id']));

              $data['project_info'] = get_project_details($val['project_id']);
              
              $where = array("id"=>$val['id']);
              $upd_array = array("status"=>1);
              $this->mod_common->update_table($table, $where, $upd_array);
                                                $subject = "Reminder";
                                                $data['reminder_text'] = $val['message'];
                                                $data['email'] = $reminder_user['email'];

		                                $message = $this->load->view("email_templates/reminder_template", $data, TRUE);
		   
                                                /*$this->load->library('email');

                                                $config['charset'] = 'utf-8';
                                                $config['wordwrap'] = TRUE;
                                                $config['mailtype'] = 'html';
                                                $this->email->initialize($config);*/
                                                
                                                 $config = Array(
                                                    'protocol' => 'smtp',
                                                    'smtp_host' => 'mail.wizard.net.nz',
                                                    'smtp_port' => 587,
                                                    'smtp_user' => 'info@wizard.net.nz', // change it to yours
                                                    'smtp_pass' => '{SGwI8a~GDMJ', // change it to yours
                                                    'mailtype' => 'html',
                                                    'charset' => 'utf-8',
                                                    'wordwrap' => TRUE
                                                  );
                                                
                                                       
                                                $this->load->library('email', $config);
                                                $this->email->set_newline("\r\n"); 
                                                $this->email->set_mailtype("html");

                                                $this->email->to($reminder_user['email']);
                                                $this->email->from('info@wizard.net.nz');
                                                $this->email->subject($subject);
                                                $this->email->message($message);
        		                                if($this->email->send()){
                                                        echo "success";
                                                }
                                          }
                        }
           }
					
	     
	}
	public function send_daily_summary_email()
	{   
	    
           $current_date = date('Y-m-d', strtotime("-1 days"));
           //$current_date = date('Y-m-d');
           $query = $this->db->query("SELECT t.team_id, u.user_email as email, u.user_fname as first_name, u.user_lname as last_name FROM project_scheduling_team t INNER JOIN project_users u ON u.user_id = t.team_id WHERE t.project_id IN (SELECT project_id FROM project_scheduling_activities WHERE DATE_FORMAT(created_at, '%Y-%m-%d') ='".$current_date."') AND (t.team_role =1 OR (t.team_role=2 AND t.is_invitation_send=2))");
           $users_list = $query->result_array();
           
           $config = Array(
                                                    'protocol' => 'smtp',
                                                    'smtp_host' => 'mail.wizard.net.nz',
                                                    'smtp_port' => 587,
                                                    'smtp_user' => 'info@wizard.net.nz', // change it to yours
                                                    'smtp_pass' => '{SGwI8a~GDMJ', // change it to yours
                                                    'mailtype' => 'html',
                                                    'charset' => 'utf-8',
                                                    'wordwrap' => TRUE
                                                  );
                                                
                                                       
            $this->load->library('email', $config);
                                                
            //print_r($users_list);exit;
            
           foreach($users_list as $val){ 
                  $subject = "WIZARD: Project Update";
                  $data["current_date"] = $current_date;
                  $data["firstname"] = $val["first_name"];
		          $message = $this->load->view("email_templates/daily_summary_template", $data, TRUE);
		   
                                                $this->email->set_newline("\r\n"); 
                                                $this->email->set_mailtype("html");

                                                $this->email->to($val['email']);
                                                //$this->email->to("maria.satti7@gmail.com");
                                                $this->email->from('info@wizard.net.nz');
                                                $this->email->subject($subject);
                                                $this->email->message("$message");
        		                                if($this->email->send()){
        		                                    echo "success";
                                                }
                                          }
	}

}
