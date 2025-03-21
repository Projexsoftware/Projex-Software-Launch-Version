<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {

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
             
             $this->mod_common->is_company_page_accessible(134);
             $this->mod_common->is_company_page_accessible(154);

        }
	public function index()
	{      
	    $this->mod_common->is_company_page_accessible(158);
        $this->stencil->title('Scheduling Notifications');
             
	     $this->stencil->paint('scheduling/notifications/notifications');
	}

       public function get_latest_notifications(){
            $this->mod_common->is_company_page_accessible(158);
            $this->load->view('scheduling/notifications/notifications_ajax');
       }

         public function view($notification_id){
            $this->mod_common->is_company_page_accessible(158);
            if($notification_id=="" || !(is_numeric($notification_id))){
               redirect("nopage");
            }

            
             $table = "project_scheduling_notifications";

             $where = array("id"=>$notification_id);
					
             $notification_info = $this->mod_common->select_single_records($table, $where);

            
            
               $upd_array = array(
                                "is_read"   => $notification_info['is_read'].$this->session->userdata("user_id").":1,"
			       );
        

             $this->mod_common->update_table($table, $where, $upd_array);

             redirect(SCURL."projects/edit_project/".$notification_info['project_id']);
         }
         
         public function read_all_notifications(){
             $this->mod_common->is_company_page_accessible(158);
             $table = "project_scheduling_notifications";
             
             
               $upd_array = array(
                                "is_read"   => $notification_info['is_read'].$this->session->userdata("user_id").":1,"
			       );
            

             $this->mod_common->update_table($table, array(1 => 1), $upd_array);
             $this->load->view('scheduling/notifications/notifications_ajax');
         }
}
