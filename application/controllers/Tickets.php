<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

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
             $this->load->model("mod_project");
             $this->load->model("mod_template");
             $this->load->model("mod_component");
             
             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(101);

    }
    
    //Manage Tickets
    public function index() {
        
      $this->mod_common->is_company_page_accessible(102);

      $id = $this->session->userdata("user_id");
	  
	  $where = array("ticket_parent" => 0,
	                 "from_id" => $id);
	  $data['tickets'] = $this->mod_common->get_all_records('project_tickets', "*", 0, 0, $where);

      $this->stencil->title('Your Tickets');
	  $this->stencil->paint('tickets/manage_tickets', $data);
    }
     
    //Add Ticket Screen
    public function add_ticket()
	{
	    $this->mod_common->is_company_page_accessible(103);
	    
	    $ticket_files = explode(",", rtrim($this->session->userdata("ticket_files"),","));
	    
		    for($i=0;$i<count($ticket_files);$i++){
		        $file_name = $ticket_files[$i];
		        if($file_name!=""){
    		        if(file_exists("./assets/tickets/".$file_name)){
    	                unlink("./assets/tickets/".$file_name);
    	                unlink("./assets/tickets/thumbnail/".$file_name);
    	                $new_img = str_replace($file_name.",", "", $this->session->userdata("ticket_files"));
    	                $this->session->set_userdata("ticket_files", $new_img);
    	            }
		        }
		    }
		$this->session->unset_userdata("ticket_files");
	
        $this->stencil->title('Add Ticket');
	    $this->stencil->paint('tickets/add_ticket');
	}
	
	//Create New Ticket
	public function create_new_ticket_process(){
	    $ticket_title = $this->input->post("ticket_title");
	    $ticket_priority = $this->input->post("ticket_priority");
	    $ticket_category = $this->input->post("ticket_category");
	    $ticket_body = $this->input->post("ticket_body");
	    $ticket_status = "New";
	    $from_id = $this->session->userdata("user_id");
	    $to_id = 1;
	    $company_id = $this->session->userdata("company_id");
	    $ticket_files = $this->input->post('ticket_files');
	    
		$data = array(
		    "ticket_title" => $ticket_title,
		    "ticket_priority" => $ticket_priority,
		    "ticket_category" => $ticket_category,
		    "ticket_body" => $ticket_body,
		    "ticket_status" => $ticket_status,
		    "from_id" => $from_id,
		    "to_id" => $to_id,
		    "company_id" => $company_id,
		    "is_read" => 0,
		    
		 );
		$create_new_ticket = $this->mod_common->insert_into_table('tickets',$data);
		if($create_new_ticket){
		    $ticket_id = $this->db->insert_id();
		    $ticket_files_array = explode(",", $ticket_files[0]);
		    if(count($ticket_files_array)>0){
                for($i=0;$i<count($ticket_files_array);$i++){
                    if(file_exists("./assets/tickets/".$ticket_files_array[$i])){
                		    $ticket_file_array = array(
                		         "ticket_file" => $ticket_files_array[$i],
                		         "ticket_id" => $ticket_id
                		        );
                		    $this->mod_common->insert_into_table('ticket_files',$ticket_file_array);
        		    }
    		    }
		    }
		    $this->session->unset_userdata("ticket_files");
		    $notification = array(
		         "notify_from" => $this->session->userdata("user_id"),
		         "notify_ticket_id" => $ticket_id,
		        );
		   $this->mod_common->insert_into_table('tickets_notifications',$notification);
		   $this->session->set_flashdata('ok_message', "New Ticket created successfully");
		   redirect("tickets");
		}
	}
	
	//Upload Ticket File
	public function upload_ticket_file($type="new_ticket"){
	    $ticket_file = "";
	                        $projects_folder_path = './assets/tickets/';
						    $projects_folder_path_main = './assets/tickets/';
						    $thumb = $projects_folder_path_main . 'thumbnail';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = false;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('file')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							
							print_r($error_file_arr);exit;
							
						} else {
                            
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
						
						$ticket_file = $filename;
	                        
								if($type=="new_ticket"){
								  if($this->session->userdata("ticket_files")==""){
	                                   $this->session->set_userdata("ticket_files", $_FILES['file']['name'].",");
	                              }
	                              else{
	                                    $filename = $this->session->userdata("ticket_files").$_FILES['file']['name'].",";
	                                    $this->session->set_userdata("ticket_files", $filename);
	                               }
								}
								else{
								        if($this->session->userdata("ticket_reply_files")==""){
	                                          $this->session->set_userdata("ticket_reply_files", $_FILES['file']['name'].",");
	                                     }
                                	    else{
                                	        $filename = $this->session->userdata("ticket_reply_files").$_FILES['file']['name'].",";
                                	        $this->session->set_userdata("ticket_reply_files", $filename);
                                	    }
								}
	    
	    
	    echo "Image Uploaded";
	    
	}
	
	//View Ticket Details
	public function view($id=0, $type=""){
	    $this->mod_common->is_company_page_accessible(102);
	     $ticket_reply_files = explode(",", rtrim($this->session->userdata("ticket_reply_files"),","));
	    
		    for($i=0;$i<count($ticket_reply_files);$i++){
		        $file_name = $ticket_reply_files[$i];
		        if($file_name!=""){
    		        if(file_exists("./assets/tickets/".$file_name)){
    	                unlink("./assets/tickets/".$file_name);
    	                unlink("./assets/tickets/thumbnail/".$file_name);
    	                $new_img = str_replace($file_name.",", "", $this->session->userdata("ticket_reply_files"));
    	                $this->session->set_userdata("ticket_reply_files", $new_img);
    	            }
		        }
		    }
		$this->session->unset_userdata("ticket_reply_files");
		
	    $last_reply = get_last_reply($id);
	    
	    if($last_reply["from_id_role"]!="user" && $type==""){
    	    $ticket_data = array('is_read'=>1);
    		$where 	= array('id' => $id);
    		$this->mod_common->update_table('tickets',$ticket_data,$where);
	    }
		
	    $where	= array("ticket_parent" => $id);
		$data['ticket_replies'] = $this->mod_common->get_all_records('project_tickets', "*", 0, 0, $where);
		
		$where	= array("ticket_id" => $id);
		$data['ticket_files'] = $this->mod_common->get_all_records('project_ticket_files', "*", 0, 0, $where);
		
	    $fields 		= '*';
		$where 			= array("id" => $id);
		$data['ticket_detail'] 	= $this->mod_common->select_single_records('project_tickets', $where);
        
        $this->stencil->title('Ticket Details');
	    $this->stencil->paint('tickets/view_ticket', $data);
	}
	
	//Load Notifications
	public function load_notifications(){
        $this->load->view('tickets/notifications');
	}
	
	//View Notification Details
	public function view_notification($notification_id, $ticket_id){
	    $ticket_data = array('is_read'=>0);
		$where 	= array('id' => $notification_id);
		$this->mod_common->update_table('tickets_notifications', $where, $ticket_data);
		redirect(SURL."tickets/view/".$ticket_id."/notification");
	}
	
	//Remove Ticket File
	public function remove_file(){
	    $file_name = $this->input->post("filename");
	    if(file_exists("./assets/tickets/".$file_name)){
	        unlink("./assets/tickets/".$file_name);
	        unlink("./assets/tickets/thumbnail/".$file_name);
	        $new_img = str_replace($file_name.",", "", $this->session->userdata("ticket_files"));
	        $this->session->set_userdata("ticket_files", $new_img);
	        $new_img2 = str_replace($file_name.",", "", $this->session->userdata("ticket_reply_files"));
	        $this->session->set_userdata("ticket_reply_files", $new_img2);
	    }
	}
	
	//Reply To Ticket
	public function reply_to_ticket(){
	    
	    $ticket_title = $this->input->post("ticket_title");
	    $ticket_priority = $this->input->post("ticket_priority");
	    $ticket_category = $this->input->post("ticket_category");
	    $ticket_body = $this->input->post("content");
	    $ticket_parent = $this->input->post("ticket_parent");
	    $from_id = $this->session->userdata("user_id");
	    $company_id = $this->session->userdata("company_id");
	    $ticket_files = $this->input->post('ticket_files');
	    $to_id = 1;
	    
		$data = array(
		    "ticket_title" => $ticket_title,
		    "ticket_category" => $ticket_category,
		    "ticket_priority" => $ticket_priority,
		    "ticket_body" => $ticket_body,
		    "from_id" => $from_id,
		    "to_id" => $to_id,
		    "company_id" => $company_id,
		    "ticket_parent" => $ticket_parent,
		 );
		 $this->mod_common->insert_into_table('tickets',$data);
		 
		 $ticket_id = $this->db->insert_id();
		 
		 $ticket_files_array = explode(",", $ticket_files[0]);
		    if(count($ticket_files_array)>0){
                for($i=0;$i<count($ticket_files_array);$i++){
                    if(file_exists("./assets/tickets/".$ticket_files_array[$i])){
                		    $ticket_file_array = array(
                		         "ticket_file" => $ticket_files_array[$i],
                		         "ticket_id" => $ticket_id
                		        );
                		    $this->mod_common->insert_into_table('ticket_files',$ticket_file_array);
        		    }
    		    }
		    }
		    $this->session->unset_userdata("ticket_reply_files");
		    
		 $where	= array("ticket_parent" => $ticket_parent);
		 $data['ticket_replies'] = $this->mod_common->get_all_records('tickets', "*", 0, 0, $where);
		 
		 $ticket_data = array(
							'ticket_updated_date'	=>date("Y-m-d G:i:s"),
							'is_read' => 0);
						
		$where 			= array('id' => $ticket_parent);
		$this->mod_common->update_table('tickets', $ticket_data, $where);
		
		$notification = array(
		         "notify_from" => $this->session->userdata("user_id"),
		         "notify_ticket_id" => $ticket_parent,
		         "notify_type" => 2
		        );
		        
		 $this->mod_common->insert_into_table('tickets_notifications',$notification);
		 
        $this->load->view('tickets/ticket_replies', $data);

	}
    
}