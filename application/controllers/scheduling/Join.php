<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join extends CI_Controller {

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
             //$this->mod_common->is_company_page_accessible(134);

        }
	public function project($token="")
	{  
           $table = "project_scheduling_team";
           $where = array("token" => $token);

           $team_info = $this->mod_common->select_single_records($table, $where);

           if(count($team_info)>0){
               
                if($team_info['is_invitation_send']==1){
    
                       $upd_array = array("is_invitation_send" => 2);
            
                       $this->mod_common->update_table($table, $where, $upd_array);
            
                       //Notification Code Starts Here
            
                       $notification_text = " joined ";
                       $ins_array = array(
            				"user_id" => $team_info['team_id'],
                                            "project_id" => $team_info['project_id'],
                                            "notification_text" => $notification_text
            			);
            					
                       $this->mod_common->insert_into_table("project_scheduling_notifications", $ins_array);
                       //Notification Code Ends Here
                       
                       $this->session->set_flashdata('ok_message', 'You have joined this project successfully!');
                       redirect(SCURL."projects/edit_project/".$team_info['project_id']);
                }
                else{
                    $this->session->set_flashdata('err_message', 'You have already joined this project!');
                    redirect(SCURL."projects/edit_project/".$team_info['project_id']);
            }
           }
           else{
            redirect(SURL."nopage");
           }
	}

}
