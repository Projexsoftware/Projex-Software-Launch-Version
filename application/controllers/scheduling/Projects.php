<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

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
             $this->load->model("mod_project");
             
             $this->session->unset_userdata("daterange");

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(134);

        }
	public function index()
	{
            $data['pending_projects'] = $this->mod_project->get_all_projects_list("pending");
            $data['active_projects'] = $this->mod_project->get_all_projects_list("active");
            $data['completed_projects'] = $this->mod_project->get_all_projects_list("completed");
            $data['inactivate_projects'] = $this->mod_project->get_all_projects_list("inactive");
            $this->stencil->title('Buildz');
	        $this->stencil->paint('scheduling/projects/manage_projects', $data);
	}
	
	public function edit_project($project_id="") {
		
	    if($project_id=="" || !(is_numeric($project_id))){
            redirect(SCURL."nopage");
        }
        
        $table = "project_stages";
        $data['stages'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" => $this->session->userdata("company_id"), "	stage_status" => 1), "stage_id");

        $data['templates'] = $this->mod_scheduling->get_existing_templates();
        
        $data['projects'] = $this->mod_scheduling->get_existing_projects_for_buildz();

        $table = "project_scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" => $this->session->userdata("company_id"), "status" => 1));

        $table = "project_scheduling_items";
        $data['project_stages'] = $this->mod_scheduling->get_project_stages($project_id);

        $table = "project_projects";
        $where = "`project_id` ='" . $project_id."'";

        $data['project_edit'] = $this->mod_common->select_single_records($table, $where);
        
        $data['project_logs'] = $this->mod_common->get_all_records("project_logs", "*", 0, 0, $where);

        if (count($data['project_edit']) == 0) {
            redirect("nopage");
        } else {
        $this->stencil->title('Edit Buildz');
        $this->stencil->paint('scheduling/projects/view_project', $data);
        }
    }
    
    public function update_project($id="") {

        if($id=="" || !(is_numeric($id))){
          redirect(SURL."nopage");
        }
        
        $this->mod_scheduling->is_project_accessible($id);
			
        $table = "project_scheduling_projects";
        $where = "`id` ='" . $id."'";

        $data['project_edit'] = $this->mod_common->select_single_records($table, $where);
        

        if (count($data['project_edit']) == 0) {
            redirect(SURL."nopage");
        } else {
            $this->stencil->title("Edit Project");

            $this->stencil->paint('scheduling/projects/edit_project', $data);
        }
    }
	
    public function update_project_process() {
      
		$this->mod_scheduling->is_viewer();

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('end_date', 'End Date', 'required');
                
                $id = $this->input->post('project_id');
                if($id!=""){
                $table = "project_scheduling_projects";
		$where = "`id` ='" . $id."'";

		$data['project_edit'] = $this->mod_common->select_single_records($table, $where);

			if ($this->form_validation->run() == FALSE)
				{
				   $this->stencil->title("Update Project");
                        $this->stencil->paint('scheduling/project/edit_project', $data);
				}
				else{

					$table = "project_scheduling_projects";
					
					$name = $this->input->post('name');
					$status = $this->input->post('status');
					$description = $this->input->post('description');
					$start_date = DateTime::createFromFormat('d/m/Y', $this->input->post('start_date'));
                    $start_date = $start_date->format('Y-m-d');
                    $end_date = DateTime::createFromFormat('d/m/Y', $this->input->post('end_date'));
                    $end_date = $end_date->format('Y-m-d');
					
                                        
					$filename= "";

					if (isset($_FILES['project_image']['name']) && $_FILES['project_image']['name'] != "") {
						
						
						$ext_file_name="./assets/scheduling/project_images/".$data['project_edit']['image'];
						if(file_exists($ext_file_name)){
							unlink($ext_file_name);
						}
						$thumb_file_name="./assets/scheduling/project_images/thumb/".$data['project_edit']['image'];
						if(file_exists($thumb_file_name)){
							unlink($thumb_file_name);
						}
						
						$projects_folder_path = './assets/scheduling/project_images/';
						$projects_folder_path_main = './assets/scheduling/project_images/';

						$thumb = $projects_folder_path_main . 'thumb';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|JPG|JPEG|GIF|TIFF|TIF|PNG';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('project_image')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							
							print_r($error_file_arr);exit;
							
						} else {
                            
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
					}
					else{
						$filename = $this->input->post('old_image');
					}
                                                        
                                                             $upd_array = array(
                                								 "name" => $name,
                                						         "description" => $description,
                                						         "start_date" => $start_date,
                                						         "end_date" => $end_date,
                                						         "status" => $status,
                                						         "image" => $filename
                                							     );
                                                        
							
							$table = "project_scheduling_projects";
							$where = "`id` ='" . $id . "'";
							$update_user = $this->mod_common->update_table($table, $where, $upd_array);
							
							if ($update_user) {
								$this->session->set_flashdata('ok_message', 'Project updated successfully!');
								redirect(SCURL . 'projects');
							} else {
								$this->session->set_flashdata('err_message', 'Error in updating Project please try again!');
								redirect(SCURL . 'projects/update_project/' . $id);
							}
					
			}
      }
      else{
           redirect(SURL."nopage");
      }
    }
    
    public function verify_name() {

        $name = $this->input->post("name");
        
        $table = "project_scheduling_projects";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'name' => $name,
            'company_id' => $this->session->userdata("company_id"),
          );
        }
        else{
          $where = array(
            'name' => $name,
            'company_id' => $this->session->userdata("company_id"),
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }

    public function add_new_project_item() {
		 
	    $this->form_validation->set_rules('stage_id', 'Stage', 'required');
            if($this->input->post('task_type')==0){
              $this->form_validation->set_rules('task_id', 'Task', 'required');
            }
            else{
              $this->form_validation->set_rules('task_name', 'Task Name', 'required');
            }
            
    	    if ($this->form_validation->run() == FALSE)
    	        {
    	          echo '<p class="text-danger">All Fields are required</p>';
    		}
	    	else{
			$table = "project_scheduling_items";
					
			$stage_id = $this->input->post('stage_id');
                        $task_id = $this->input->post('task_id');
                        $project_id = $this->input->post('project_id');
                        $task_type = $this->input->post('task_type');
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        if($task_type == "1"){
                        $task_name = $this->input->post('task_name');
                           $ins_array = array(
                                "name"=>$task_name,
				                "created_by" => $created_by,
                                "ip_address" => $ip_address,
                                "status" => 1
			                 );
					
		                $this->mod_common->insert_into_table("project_scheduling_tasks", $ins_array);
                        $task_id = $this->db->insert_id();

                        }
                        $priority_info = $this->mod_common->select_single_records($table, array("stage_id"=>$stage_id,"project_id"=>$project_id), "MAX(priority) as priority");
                        $checklists = $this->mod_common->get_all_records("project_scheduling_checklists", "*", 0, 0, array("task_id" => $task_id));
                       
                        $ins_array = array(
                                "project_id"=>$project_id,
				               "stage_id" => $stage_id,
                                "task_id" => $task_id,
                                "priority" => $priority_info["priority"]+1,
                                "user_id" => $this->session->userdata("user_id")
		             	);
					
		        $add_new_project_item = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_project_item) {

                              $item_id = $this->db->insert_id();
                              
                              $table = "project_scheduling_item_checklists";
					
        		                if(count($checklists)>0){
                                    foreach($checklists as $checklist){
                                        $ins_array = array(
                                        "project_id"=>$project_id,
        				                "item_id" => $item_id,
                                        "name"   => $checklist['name'],
                                        "user_id" => $this->session->userdata("user_id")
        		            	        );
        		                        $this->mod_common->insert_into_table($table, $ins_array);
                                    }
                                }
                                else{
                                    $ins_array = array(
                                        "project_id"=>$project_id,
        				                "item_id" => $item_id,
                                        "name"   => "In Progress",
                                        "user_id" => $this->session->userdata("user_id")
        		            	        );
        		                    $this->mod_common->insert_into_table($table, $ins_array);
        		                    $ins_array = array(
                                        "project_id"=>$project_id,
        				                "item_id" => $item_id,
                                        "name"   => "Complete",
                                        "user_id" => $this->session->userdata("user_id")
        		            	        );
        		                    $this->mod_common->insert_into_table($table, $ins_array);
                                }

                            $ins_array = array(
                                "project_id"=>$project_id,
				                "item_id" => $item_id,
                                "activity_type" => "add_task",
                                "activity_id" => $task_id,
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			                );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                           
                              /*$table = "project_scheduling_items";
                               $where = "`project_id` ='" . $project_id . "'";

                               $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date");
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "last_updated" => date('Y-m-d G:i:s')
			       );

                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		               $this->mod_common->update_table($table, $where, $upd_array);
                           
                               echo date("d/m/Y", strtotime($task_info['end_date']));*/ 
		        }
                }
    }
	
    public function update_project_item(){
       $this->mod_scheduling->is_viewer();
       $this->mod_common->is_company_page_accessible(153);
			$table = "project_scheduling_items";

                        $task_id = $this->input->post('task_item_id');
                        $project_id = $this->input->post('project_item_id');
			
                        $start_date = DateTime::createFromFormat('d/m/Y', $this->input->post('start_date'));
                        $start_date = $start_date->format('Y-m-d');

                        $end_date = DateTime::createFromFormat('d/m/Y', $this->input->post('end_date'));
                        $end_date = $end_date->format('Y-m-d');
                        
                        $duration = dateDifference($start_date, $end_date);
 
                        
                        $upd_array = array(
                                "start_date" => $start_date,
                                "end_date"   => $end_date,
                                "duration" => $duration
			            );

                        $where = array("id"=>$task_id);
					
		        $update_project_item = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_project_item) {
                               $table = "project_scheduling_items";
                               $where = "`project_id` ='" . $project_id . "'";

                               $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date");
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "last_updated" => date('Y-m-d G:i:s')
			                    );

                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		                       $this->mod_common->update_table($table, $where, $upd_array);
		              
                           
                               echo date("d/m/Y", strtotime($task_info['end_date']));  
		        }
                }
                
    public function get_project_items(){
       $project_id = $this->input->post("project_id");
       $data['project_id'] = $project_id;

       $table = "project_scheduling_items";
       $data['project_stages'] = $this->mod_scheduling->get_project_stages($project_id);

       $table = "project_scheduling_projects";
        $where = "`id` ='" . $project_id."'";

        $data['project_edit'] = $this->mod_common->select_single_records($table, $where);

       $this->load->view("scheduling/projects/project_items", $data);
    }
    
    public function delete_project($id) {
		//$this->mod_common->is_company_page_accessible(153);
		
		//$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
        
        $project_info = $this->mod_common->select_single_records("project_scheduling_projects", array("id" => $id));
        	
        	
        $file_name="./assets/scheduling/project_images/".$project_info['image'];   
        		         
        if(file_exists($file_name) && $project_info['image']!=""){
            unlink($file_name);
            $thumb_file_name="./assets/scheduling/project_images/thumb/".$project_info['image']; 
            if(file_exists($thumb_file_name)){
                unlink($thumb_file_name);
            }
        }
		
	    $table = "project_scheduling_projects";
        $where = "`id` ='" . $id . "'";
		
        $this->mod_common->delete_record($table, $where);

        $table = "project_scheduling_team";
        $where = "`project_id` ='" . $id . "'";
        $this->mod_common->delete_record($table, $where);

        //Delete Items
        $table = "project_scheduling_items";
        $where = "`project_id` ='" . $id . "'";
		
        $this->mod_common->delete_record($table, $where);

    //Delete Checklists

     $table = "project_scheduling_item_checklists";
     $where = "`project_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Notes

     $table = "project_scheduling_item_notes";
     $where = "`project_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Reminders

     $table = "project_scheduling_item_reminders";
     $where = "`project_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);
     
     //Delete Project Logs

     $table = "project_logs";
     $where = "`project_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Files
     
     $scheduling_files = $this->mod_common->get_all_records('project_scheduling_item_files',"*",0,0,array("project_id" => $id));
		     foreach($scheduling_files as $scheduling_file){
		         if($scheduling_file['file_type']==0){
		            $file_name="./assets/scheduling/task_uploads/files/".$scheduling_file['file'];
		         }
		         else{
		           $file_name="./assets/scheduling/task_uploads/images/".$scheduling_file['file'];   
		         }
                 if(file_exists($file_name) && $file_name!=""){
            	   unlink($file_name);
                 }
		     }
		     
	 //Delete Project Documents
	 
	 $table = "project_plans_and_specifications";
     $where = "`project_id` ='" . $id . "'";

     $project_documents = $this->mod_common->get_all_records($table,"*",0,0,array("project_id" => $id));
     
     foreach($project_documents as $document_info){
         $document_name="./assets/project_plans_and_specifications/".$document_info['document'];

         if(file_exists($document_name)){
         	unlink($document_name);
         }
     }
		
     $this->mod_common->delete_record($table, $where);


     $table = "project_scheduling_item_files";
     $where = "`project_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);
     
     $this->session->set_flashdata('ok_message', 'Project has been reset successfully!');
	 redirect(SURL . 'buildz/edit_buildz/' . $id);

    }

    public function remove_task(){

     $item_id = $this->input->post("item_id");

     $table = "project_scheduling_items";
     $where = "`id` ='" . $item_id. "'";

     $task_info = $this->mod_common->select_single_records($table, $where);

     //Delete Checklists

     $table = "project_scheduling_item_checklists";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Notes

     $table = "project_scheduling_item_notes";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Reminders

     $table = "project_scheduling_item_reminders";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Files

     $table = "project_scheduling_item_files";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     $project_id = $this->input->post("project_id");
       $data['project_id'] = $project_id;

       $table = "project_scheduling_items";
       $data['project_stages'] = $this->mod_scheduling->get_project_stages($project_id);

       $table = "project_scheduling_projects";
        $where = "`id` ='" . $project_id."'";

        $data['project_edit'] = $this->mod_common->select_single_records($table, $where);

       $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "activity_type" => "remove_task",
                                "activity_id" => $task_info['task_id'],
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                             
        $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
      );
      $where = array("id" => $project_id);
      $table = "project_scheduling_projects";
      $this->mod_common->update_table($table, $where, $upd_array);
      
      //Delete Task
      $table = "project_scheduling_items";
      $where = "`id` ='" . $item_id. "'";
      $this->mod_common->delete_record($table, $where);
      
      $data['project_id'] = $project_id;
      $this->load->view("scheduling/projects/project_items", $data);

    }
	
    public function update_task_checklist(){

      $task_id = $this->input->post("task_id");
      $checklist = $this->input->post("checklist");
      $status = $this->input->post("status");
      $upd_array = array(
         "checklist" => implode(",", $checklist),
         "status" => $status
      );
      $where = array("id" => $task_id);
      $table = "project_scheduling_items";
      $this->mod_common->update_table($table, $where, $upd_array);
      
      $project_item = $this->mod_common->select_single_records("project_scheduling_items", $where);
      
      $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
      );
      $where = array("id" => $project_item['project_id']);
      $table = "project_scheduling_projects";
      $this->mod_common->update_table($table, $where, $upd_array);
      
      

    }

    public function add_new_checklist(){
     
     $table = "project_scheduling_item_checklists";

			$item_id = $this->input->post('item_id');
                        $project_id = $this->input->post('project_id');		
			$name = $this->input->post('checklist');
                        $created_by = $this->session->userdata("user_id");
 
                        $ins_array = array(
                                "item_id" => $item_id,
				"project_id" => $project_id,
				"user_id" => $created_by,
				"name" => $name
			);
					
		        $add_new_checklist = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_checklist) {

                                $check_list_id = $this->db->insert_id();

                                $table = "project_scheduling_items";
                                $where = "`id` ='" . $item_id."'";

                                $checklists = $this->mod_common->get_all_records($table, '*', 0, 0, $where);
                                foreach($checklists as $val){
                                  if($val['checklist']!=""){
                                    $ck = explode(",", $val['checklist']);
                                    if(!(in_array($check_list_id, $ck))){
                                      $this->mod_common->update_table($table, array("id"=>$val['id']), array("status"=>1));
                                    }
                                  }
                                }
                              $rowno = $this->input->post("rowno");

     $table = "project_scheduling_items";
     $where = "`id` ='" . $rowno . "'";

     $checklist_item_info = $this->mod_common->select_single_records($table, $where);
     
      $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
      );
      $where = array("id" => $project_id);
      $table = "project_scheduling_projects";
      $this->mod_common->update_table($table, $where, $upd_array);

                              $data['project_id'] = $project_id;
                              $data['item_id'] = $checklist_item_info['id'];
                              $data['task_id'] = $checklist_item_info['task_id'];
                              $data['checklist_items'] = $checklist_item_info['checklist'];
                              $data['project_id'] = $checklist_item_info['project_id'];
                               $this->load->view("scheduling/projects/checklist", $data);
                        }

    }

    public function add_new_note(){
      $table = "project_scheduling_item_notes";

			$item_id = $this->input->post('note_item_id');
                        $project_id = $this->input->post('note_project_id');
                        $data['item_id'] = $item_id;
                        $data['project_id'] = $project_id;
                       
                        $task_info = $this->mod_common->select_single_records("project_scheduling_items", "`id` ='" . $item_id . "'");
                        $data['task_id'] = $task_info['task_id'];	
                        $author = $this->input->post('author');
                        $date = DateTime::createFromFormat('d/m/Y', $this->input->post('date'));
                        $date = $date->format('Y-m-d');	
			            $note = $this->input->post('note');
			            
			            //Get Project Role
			            /*$project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
                        $current_role = $project_role['team_role'];
                        if($current_role==""){*/
                            $current_role = 1;
                        //}
                        $privacy_settings = 0;
                        if($current_role>2){
                            $privacy_settings = 1;
                        }
                        $ins_array = array(
                                "item_id" => $item_id,
				                "project_id" => $project_id,
				                "author" => $author,
                                "date " => $date,
				                "note " => $note,
                                "user_id" => $this->session->userdata("user_id"),
                                "privacy_settings" => $privacy_settings
			            );
					
		        $add_new_note = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_note) {

                            $ins_array = array(
                                       "project_id" => $project_id,
                                       "notes" => $note,
                                       "entity_type" => "Notes (".get_task_name($task_info['task_id']).")",
                                       "user_id" => $this->session->userdata("user_id")
                            );
                                
                            $this->mod_common->insert_into_table("project_logs", $ins_array);
                        
        
                              $ins_array = array(
                                "project_id"=>$project_id,
				                "item_id" => $item_id,
                                "activity_type" => "add_note",
                                "activity_id" => $this->db->insert_id(),
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                             
                             $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
      );
      $where = array("id" => $project_id);
      $table = "project_scheduling_projects";
      $this->mod_common->update_table($table, $where, $upd_array);

                              $this->load->view("scheduling/projects/notes", $data);
                        }

    }

    public function remove_note(){

     $id = $this->input->post("id");

     $table = "project_scheduling_item_notes";
     $where = "`id` ='" . $id . "'";

     $note_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);
     
     $data['item_id'] = $note_info['item_id'];
     $data['project_id'] = $note_info['project_id'];
     $task_info = $this->mod_common->select_single_records("project_scheduling_items", "`id` ='" . $note_info['item_id'] . "'");
     $data['task_id'] = $task_info['task_id'];

                $ins_array = array(
                   "project_id"=>$data['project_id'],
				    "item_id" => $data['item_id'],
                    "activity_type" => "remove_note",
                    "activity_id" => $id,
                    "user_id" => $this->session->userdata("user_id"),
                    "created_at" => date('Y-m-d G:i:s')
			    );

    $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                             
     $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
      );
      $where = array("id" => $note_info['project_id']);
      $table = "project_scheduling_projects";
      $this->mod_common->update_table($table, $where, $upd_array);

     $this->load->view("scheduling/projects/notes", $data);
     
    }

    public function remove_checklist(){

     $id = $this->input->post("id");
     $rowno = $this->input->post("rowno");

     $table = "project_scheduling_items";
     $where = "`id` ='" . $rowno . "'";

     $checklist_item_info = $this->mod_common->select_single_records($table, $where);

     $table = "project_scheduling_item_checklists";
     $where = "`id` ='" . $id . "'";

     $checklist_info = $this->mod_common->select_single_records($table, $where);

     $table = "project_scheduling_items";

     $where = "`id` ='" . $checklist_info['item_id']."'";

     $checklists = $this->mod_common->get_all_records($table, '*', 0, 0, $where);

     $data['item_id'] = $checklist_item_info['id'];
     $data['checklist_items'] = $checklist_item_info['checklist'];
     $data['project_id'] = $checklist_item_info['project_id'];
     $data['task_id'] = $checklist_item_info['task_id'];

     $total_checklists = $this->mod_common->get_all_records("project_scheduling_item_checklists", '*', 0, 0, array("item_id"=> $checklist_info['item_id']));
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
if(in_array($id, $ck)){
                                    $this->mod_common->update_table($table, array("id"=>$val['id']), array("status"=>$status, "checklist"=>$checklist_array));
                                   }
else{
$total_checklists = $this->mod_common->get_all_records("project_scheduling_item_checklists", '*', 0, 0, array("item_id"=> $checklist_info['item_id'], "id !="=>$id));
$updated_checklist = $this->mod_common->select_single_records($table, array("id"=>$val['id']));
$ck_new = explode(",", $updated_checklist['checklist']);
if(count($ck_new)<count($total_checklists)){
                                      $status = 1;
                                    }
                                    else if(count($ck_new)==count($total_checklists)){
                                      $status = 2;
                                    }
else{
$status = 0;
}
$this->mod_common->update_table($table, array("id"=>$val['id']), array("status"=>$status));
}
                                  }
                                }
        $table = "project_scheduling_item_checklists";
        $where = "`id` ='" . $id . "'";
        $delete_checklist = $this->mod_common->delete_record($table, $where);
        
        $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
        $where = array("id" => $checklist_info['project_id']);
        $table = "project_scheduling_projects";
        $this->mod_common->update_table($table, $where, $upd_array);
     
        $this->load->view("scheduling/projects/checklist", $data);
     
    }

    public function upload_file(){

       $item_id = $this->input->post("file_item_id");
       $project_id = $this->input->post("file_project_id");

       $data['item_id'] = $item_id;
       $data['project_id'] = $project_id;

       $task_info = $this->mod_common->select_single_records("project_scheduling_items", "`id` ='" . $item_id . "'");
       $data['task_id'] = $task_info['task_id'];

       $filename= "";

       if (isset($_FILES['task_file']['name']) && $_FILES['task_file']['name'] != "") {
						
						$projects_folder_path = './assets/scheduling/task_uploads/files';
						$projects_folder_path_main = './assets/scheduling/task_uploads/files/';

						$thumb = $projects_folder_path_main . 'thumb';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('task_file')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							print_r($error_file_arr);exit;
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
                            
                            $source = './assets/scheduling/task_uploads/files/'.$filename;
                            $destination = './assets/project_plans_and_specifications/'.$filename;
                            
						    if (file_exists($source)) {
                             copy($source, $destination);
						    }
						    
						}
					}
	                    //Get Project Role
			            /*$project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
                        $current_role = $project_role['team_role'];
                        if($current_role==""){*/
                            $current_role = 1;
                        //}
                        $privacy_settings = 0;
                        if($current_role>2){
                            $privacy_settings = 1;
                        }
    $ins_array = array(
                   "item_id" => $item_id,
                   "project_id" => $project_id,
                   "file" => $filename,
                   "file_original_name" => $_FILES['task_file']['name'],
                   "user_id" => $this->session->userdata("user_id"),
                   "privacy_settings" => $privacy_settings,
                   "uploaded_by" => $this->session->userdata("user_id"),
                   "uploaded_at" => date('Y-m-d G:i:s')
                 );
    $this->mod_common->insert_into_table("project_scheduling_item_files", $ins_array);
    
    $ins_array = array(
                   "project_id" => $project_id,
                   "document" => $filename,
                 );
    $this->mod_common->insert_into_table("project_plans_and_specifications", $ins_array);

                            $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "activity_type" => "add_file",
                                "activity_id" => $this->db->insert_id(),
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                             
                             $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
        $where = array("id" => $project_id);
        $table = "project_scheduling_projects";
        $this->mod_common->update_table($table, $where, $upd_array);

    $this->load->view("scheduling/projects/files", $data);

    }

    public function remove_file(){

     $id = $this->input->post("id");

     $table = "project_scheduling_item_files";
     $where = "`id` ='" . $id . "'";

     $file_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);

     $file_name="./assets/scheduling/task_uploads/files/".$file_info['file'];

     if(file_exists($file_name)){
	unlink($file_name);
     }
     
     $data['item_id'] = $file_info['item_id'];
     $data['project_id'] = $file_info['project_id'];

     $task_info = $this->mod_common->select_single_records("project_scheduling_items", "`id` ='" . $file_info['item_id'] . "'");
     $data['task_id'] = $task_info['task_id'];

     $ins_array = array(
                                "project_id"=>$data['project_id'],
				"item_id" => $data['item_id'],
                                "activity_type" => "remove_file",
                                "activity_id" => $id,
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                             
        $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
        $where = array("id" => $file_info['project_id']);
        $table = "project_scheduling_projects";
        $this->mod_common->update_table($table, $where, $upd_array);

     $this->load->view("scheduling/projects/files", $data);
     
    }

    //Upload Task Image

    public function upload_image(){

       $item_id = $this->input->post("image_item_id");
       $description = $this->input->post("image_description");
       $project_id = $this->input->post("image_project_id");

       $data['item_id'] = $item_id;
       $data['project_id'] = $project_id;

       $task_info = $this->mod_common->select_single_records("project_scheduling_items", "`id` ='" . $item_id . "'");
       $data['task_id'] = $task_info['task_id'];

       $filename= "";

       if (isset($_FILES['task_image']['name']) && $_FILES['task_image']['name'] != "") {
						
						$projects_folder_path = './assets/scheduling/task_uploads/images';
						$projects_folder_path_main = './assets/scheduling/task_uploads/images/';

						$thumb = $projects_folder_path_main . 'thumb';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('task_image')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							print_r($error_file_arr);exit;
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
                            
                            $source = $projects_folder_path_main.$filename;
                            $destination = "./assets/scheduling/project_logs/".$filename;
                            
                            $source_thumb = $projects_folder_path_main."thumb/".$filename;
                            $destination_thumb = "./assets/scheduling/project_logs/thumb/".$filename;
                            
                            if (file_exists($source)) {
                             copy($source, $destination);
                            }
                            if (file_exists($source_thumb)) {
                             copy($source_thumb, $destination_thumb);
                            }	
						}
					}
	                    //Get Project Role
			            /*$project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
                        $current_role = $project_role['team_role'];
                        if($current_role==""){*/
                            $current_role = 1;
                        //}
                        $privacy_settings = 0;
                        if($current_role>2){
                            $privacy_settings = 1;
                        }
                        
                        $ins_array = array(
                                       "item_id" => $item_id,
                                       "project_id" => $project_id,
                                       "description" => $description,
                                       "file" => $filename,
                                       "file_type" => 1,
                                       "file_original_name" => $_FILES['task_image']['name'],
                                       "user_id" => $this->session->userdata("user_id"),
                                       "privacy_settings" => $privacy_settings,
                                       "uploaded_by" => $this->session->userdata("user_id"),
                                       "uploaded_at" => date('Y-m-d G:i:s')
                                     );
                        $this->mod_common->insert_into_table("project_scheduling_item_files", $ins_array);
    
                            $ins_array = array(
                                       "project_id" => $project_id,
                                       "notes" => $description,
                                       "image" => $filename,
                                       "entity_type" => "Images (".get_task_name($task_info['task_id']).")",
                                       "user_id" => $this->session->userdata("user_id")
                            );
                                
                            $this->mod_common->insert_into_table("project_logs", $ins_array);
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				                "item_id" => $item_id,
                                "activity_type" => "add_image",
                                "activity_id" => $this->db->insert_id(),
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			            );

                        $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
    
    $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $project_id);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);

    $this->load->view("scheduling/projects/images", $data);

    }
    
    public function remove_image(){

     $id = $this->input->post("id");

     $table = "project_scheduling_item_files";
     $where = "`id` ='" . $id . "'";

     $file_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);

     $file_name="./assets/scheduling/task_uploads/images/".$file_info['file'];

     if(file_exists($file_name)){
	unlink($file_name);
     }
     
     $data['item_id'] = $file_info['item_id'];
     $data['project_id'] = $file_info['project_id'];

     $task_info = $this->mod_common->select_single_records("project_scheduling_items", "`id` ='" . $file_info['item_id'] . "'");
     $data['task_id'] = $task_info['task_id'];

     $ins_array = array(
                                "project_id"=>$data['project_id'],
				"item_id" => $data['item_id'],
                                "activity_type" => "remove_image",
                                "activity_id" => $id,
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);

      $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $file_info['project_id']);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);

     $this->load->view("scheduling/projects/images", $data);
     
    }

    public function add_new_reminder(){
      $table = "project_scheduling_item_reminders";

			$item_id = $this->input->post('reminder_item_id');
                        $task_id = $this->input->post('reminder_task_id');
                        $project_id = $this->input->post('reminder_project_id');
                        $data['item_id'] = $item_id;
                        $data['project_id'] = $project_id;	
                        $to_id = $this->input->post('to_id');
                        $date = DateTime::createFromFormat('d/m/Y', $this->input->post('date'));
                        $date = $date->format('Y-m-d');	
			$message = $this->input->post('message');
                        $reminder_type = $this->input->post('reminder_type');
                        $remindertype = $this->input->post('remindertype');
                        $no_of_days = $this->input->post('no_of_days');
                        
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];

                        if($reminder_type == "1"){
                           $to_email = $this->input->post('to_email');
                           $ins_array = array(
                                "email"=>$to_email,
				"task_id"=>$task_id,
				"created_by" => $created_by,
                                "ip_address" => $ip_address,
                                "status" => 1
			   );
					
		           $this->mod_common->insert_into_table("scheduling_reminder_users", $ins_array);
                           $to_id = $this->db->insert_id();

                        }

                        $ins_array = array(
                                "item_id" => $item_id,
				"project_id" => $project_id,
				"to_id" => $to_id,
                                "reminder_type" => $remindertype,
                                "no_of_days" => $no_of_days,
                                "date " => $date,
				"message" => $message,
                                "user_id" => $this->session->userdata("user_id")
			);
					
		        $add_new_reminder = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_reminder) {

                              $id = $item_id;
                              $table = "project_scheduling_items";
                              $where = "`id` ='" . $id . "'";
                              $reminder_info = $this->mod_common->select_single_records($table, $where);
                              $data['task_id'] = $reminder_info['task_id'];
                              $data['reminder_date'] = $date;

                              $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "activity_type" => "add_reminder",
                                "activity_id" => $this->db->insert_id(),
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                             
                              $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $project_id);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);

                              $this->load->view("scheduling/projects/reminders", $data);
                        }

    }

    public function remove_reminder(){

     $id = $this->input->post("id");

     $table = "project_scheduling_item_reminders";
     $where = "`id` ='" . $id . "'";

     $reminder_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);
     
     $data['item_id'] = $reminder_info['item_id'];
     $data['project_id'] = $reminder_info['project_id'];

     $table = "project_scheduling_items";
     $where = "`id` ='" . $reminder_info['item_id'] . "'";
     $reminder_task_info = $this->mod_common->select_single_records($table, $where);
     $data['task_id'] = $reminder_task_info['task_id'];
     $data['reminder_date'] = $reminder_task_info['start_date'];

     $ins_array = array(
                                "project_id"=>$data['project_id'],
				"item_id" => $data['item_id'],
                                "activity_type" => "remove_reminder",
                                "activity_id" => $id,
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

                             $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
                             
      $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $reminder_info['project_id']);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);

     $this->load->view("scheduling/projects/reminders", $data);
     
    }

    public function get_stage_status(){
       $project_id = $this->input->post("project_id");
       $data['project_id'] = $project_id;

       $stage_id = $this->input->post("stage_id");
       $data['stage_id'] = $stage_id;

       $item_count = $this->input->post("item_count");
       $data['item_count'] = $item_count;

       $this->load->view("scheduling/projects/stage_status_ajax", $data);
    }

    public function add_from_template(){
      $template_id = $this->input->post("template_id");
      $project_id = $this->input->post("project_id");

      
  
     $table = "project_scheduling_projects";
     $where = "`id` ='" . $project_id . "'";

     $project_info = $this->mod_common->select_single_records($table, $where);

      
      $items = $this->mod_common->get_all_records("project_scheduling_template_items","*",0,0,array("template_id"=>$template_id));
      foreach($items as $item){
                        
                        $table = "project_scheduling_items";
		        $priority_info = $this->mod_common->select_single_records($table, array("stage_id"=>$item['stage_id'],"project_id"=>$project_id), "MAX(priority) as priority");	
			$stage_id = $item['stage_id'];
                        $task_id = $item['task_id'];
                        $project_id = $project_id;
                        $checklist = $item['checklist'];
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				                "stage_id" => $stage_id,
                                "task_id" => $task_id,
                                "checklist" => "",
                                "status" => 0,
                                "priority" => $priority_info["priority"]+1,
                                "stages_priority" => $item['stages_priority'],
                                "user_id" => $this->session->userdata("user_id")
			);
			

		       $this->mod_common->insert_into_table($table, $ins_array);

      $item_id = $this->db->insert_id();

      //item checklists

      $item_checklists = $this->mod_common->get_all_records("project_scheduling_template_item_checklists","*", 0, 0, array("template_id"=>$template_id, "item_id"=>$item['id']));
      if(count($item_checklists)>0){
          foreach($item_checklists as $val){
                            $table = "project_scheduling_item_checklists";
    					
    		             	$item_id = $item_id;
                            $project_id = $project_id;
                            $name = $val['name'];
                           
                            
                            $ins_array = array(
                                    "project_id"=>$project_id,
    				                "item_id" => $item_id,
                                    "name"   => $name,
                                    "user_id" => $this->session->userdata("user_id")
    		            	);
    
    		       $this->mod_common->insert_into_table($table, $ins_array);
    
          }  
      }
      else{
            $table = "project_scheduling_item_checklists";
            $ins_array = array(
                "project_id"=>$project_id,
        		"item_id" => $item_id,
                "name"   => "In Progress",
                "user_id" => $this->session->userdata("user_id")
            );
        	$this->mod_common->insert_into_table($table, $ins_array);
        	$ins_array = array(
                "project_id"=>$project_id,
        		"item_id" => $item_id,
                "name"   => "Complete",
                "user_id" => $this->session->userdata("user_id")
        	);
        	$this->mod_common->insert_into_table($table, $ins_array);
        }
      
      //item notes 

      $item_notes = $this->mod_common->get_all_records("project_scheduling_template_item_notes","*",0,0,array("template_id"=>$template_id, "item_id"=>$item['id']));
      foreach($item_notes as $val){
                        $table = "project_scheduling_item_notes";
					
			$item_id = $item_id;
                        $author = $val['author'];
                        $project_id = $project_id;
                        $date = $val['date'];
                        $note = $val['note'];
                       
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "author" => $author,
                                "date" => $date,
                                "note"   => $note,
                                "user_id" => $this->session->userdata("user_id")
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 

      //template_item_reminders
     
      $item_reminders = $this->mod_common->get_all_records("project_scheduling_template_item_reminders","*",0,0,array("template_id"=>$template_id, "item_id"=>$item['id']));
      foreach($item_reminders as $val){
                        $table = "project_scheduling_item_reminders";
					
			$item_id = $item_id;
                        $to_id = $val['to_id'];
                        $no_of_days = $val['no_of_days'];
                        $reminder_type = $val['reminder_type'];
                        $project_id = $project_id;
                        $date = $val['date'];
                        $message = $val['message'];
                        $status = $val['status'];
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "to_id" => $to_id,
                                "no_of_days" => $no_of_days,
                                "reminder_type" => $reminder_type,
                                "date" => $date,
                                "message"   => $message,
                                "status" => $status,
                                "user_id" => $this->session->userdata("user_id")
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }

    

    }//end of item foreach 
    
    $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $project_id);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);
      
      
    }
    
    public function add_project_team(){
      $project_id = $this->input->post('project_team_project_id');
      $data['project_id'] = $project_id;
      $leaders = $this->input->post('leaders');
      $members = $this->input->post('members');
      $guest = $this->input->post('guest');

                                //Leaders
                                if(isset($leaders) && count($leaders)>0){
                                for($i=0;$i<count($leaders);$i++){
                                $ins_array = array(
				                        "project_id" => $project_id,
				                        "team_id" => $leaders[$i],
                                        "team_role" => 2,
                                        "token" => md5($project_id.$leaders[$i])
			        );
					
		                $this->mod_common->insert_into_table("project_scheduling_team", $ins_array);
                                }
                                }

                                //Members
                                if(isset($members) && count($members)>0){
                                for($i=0;$i<count($members);$i++){
                                $ins_array = array(
				  "project_id" => $project_id,
				  "team_id" => $members[$i],
                                  "team_role" => 3,
                                  "token" => md5($project_id.$members[$i])
			        );
					
		                $this->mod_common->insert_into_table("project_scheduling_team", $ins_array);
                                }
                                }
                                //Guest
                                if(isset($guest) && count($guest)){
                                for($i=0;$i<count($guest);$i++){
                                $ins_array = array(
				  "project_id" => $project_id,
				  "team_id" => $guest[$i],
                                  "team_role" => 4,
                                  "token" => md5($project_id.$guest[$i])
			        );
					
		                $this->mod_common->insert_into_table("project_scheduling_team", $ins_array);
                                }
                                }
        
        
        $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $project_id);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);
    
    $data["scheduling_users"] =  $this->mod_scheduling->get_scheduling_users();
        
    $data["scheduling_members"] =  $this->mod_scheduling->get_scheduling_members();
    
    $this->load->view("scheduling/projects/project_team", $data);
    }

    public function remove_project_team(){

     $id = $this->input->post("id");

     $table = "project_scheduling_team";
     $where = "`id` ='" . $id . "'";

     $note_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);

     $data['project_id'] = $project_id = $this->input->post("project_id");

    $data["scheduling_users"] =  $this->mod_scheduling->get_scheduling_users();
        
    $data["scheduling_members"] =  $this->mod_scheduling->get_scheduling_members();
     
     $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $project_id);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);

     $this->load->view("scheduling/projects/project_team", $data);
     
    }

    function get_reminder_message(){

     $id = $this->input->post("id");
     $table = "reminders";
     $where = "`id` ='" . $id . "'";

     $reminder_info = $this->mod_common->select_single_records($table, $where);
		
     echo $reminder_info['message'];
    }
     
    public function upload_document(){

       $parent_project_id = $this->input->post("document_parent_project_id");
       $project_id = $this->input->post("document_project_id");

       $data['project_id'] = $project_id;
       $data['parent_project_id'] = $parent_project_id;

       $filename= "";

       if (isset($_FILES['document_file']['name']) && $_FILES['document_file']['name'] != "") {
						
						$projects_folder_path = './assets/project_plans_and_specifications';
						$projects_folder_path_main = './assets/project_plans_and_specifications/';

						$thumb = $projects_folder_path_main . 'thumb';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('document_file')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							print_r($error_file_arr);exit;
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
                            
							
						}
					}
    $ins_array = array(
                   "project_id" => $parent_project_id,
                   "document" => $filename,
                 );
    $this->mod_common->insert_into_table("project_plans_and_specifications", $ins_array);
    $ins_array = array(
                                "project_id"=>$project_id,
                                "activity_type" => "add_document",
                                "activity_id" => $this->db->insert_id(),
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

    $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
    
    $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $project_id);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);
    
    $this->load->view("scheduling/projects/project_documents", $data);

    }
    
    public function project_documents(){

       $parent_project_id = $this->input->post("project_id");
       $project_id = $this->input->post("project_id");

       $data['project_id'] = $project_id;
       $data['parent_project_id'] = $parent_project_id;

       $this->load->view("scheduling/projects/project_documents", $data);

    }

    public function remove_document(){

     $id = $this->input->post("id");
     $parent_project_id = $this->input->post("document_parent_project_id");
     $project_id = $this->input->post("project_id");

     $table = "project_plans_and_specifications";
     $where = "`id` ='" . $id . "'";

     $document_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);

     $document_name="./assets/project_plans_and_specifications/".$document_info['document'];

     if(file_exists($document_name)){
     	unlink($document_name);
     }
     
     $data['project_id'] = $project_id;
     $data['parent_project_id'] = $parent_project_id;

     $ins_array = array(
                                "project_id"=>$data['project_id'],
                                "activity_type" => "remove_document",
                                "activity_id" => $id,
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

    $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
    
    $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $document_info['project_id']);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);

     $this->load->view("scheduling/projects/project_documents", $data);
     
    }

    public function add_from_project(){
      $import_project_id = $this->input->post("import_project_id");
      $project_id = $this->input->post("project_id");

      //Project Info 
  
     $table = "project_scheduling_projects";
     $where = "`id` ='" . $project_id . "'";

     $project_info = $this->mod_common->select_single_records($table, $where);

      //items
      $items = $this->mod_common->get_all_records("project_scheduling_items","*",0,0,array("project_id"=>$import_project_id));
      foreach($items as $item){
                        $table = "project_scheduling_items";

			$priority_info = $this->mod_common->select_single_records($table, array("stage_id"=>$item['stage_id'],"project_id"=>$project_id), "MAX(priority) as priority");
		
			$stage_id = $item['stage_id'];
                        $task_id = $item['task_id'];
                        $project_id = $project_id;
                        $checklist = $item['checklist'];
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				"stage_id" => $stage_id,
                                "task_id" => $task_id,
                                "checklist" => $checklist,
                                "status" => 0,
                                "priority" => $priority_info["priority"]+1,
                                "stages_priority" => $item['stages_priority'],
                                "user_id" => $this->session->userdata("user_id")
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      $item_id = $this->db->insert_id();

      //item checklist 

      $item_checklists = $this->mod_common->get_all_records("project_scheduling_item_checklists","*",0,0,array("project_id"=>$import_project_id, "item_id"=>$item['id']));
      foreach($item_checklists as $val){
                        $table = "project_scheduling_item_checklists";
					
			$item_id = $item_id;
                        $project_id = $project_id;
                        $name = $val['name'];
                       
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "name"   => $name,
                                "user_id" => $this->session->userdata("user_id")
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 


      //item notes 

      $item_notes = $this->mod_common->get_all_records("project_scheduling_item_notes","*",0,0,array("project_id"=>$import_project_id, "item_id"=>$item['id']));
      foreach($item_notes as $val){
                        $table = "project_scheduling_item_notes";
					
			$item_id = $item_id;
                        $author = $val['author'];
                        $project_id = $project_id;
                        $date = $val['date'];
                        $note = $val['note'];
                        $privacy_settings = $val['privacy_settings'];
                       
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "author" => $author,
                                "date" => $date,
                                "note"   => $note,
                                "user_id" => $this->session->userdata("user_id"),
                                "privacy_settings" => $privacy_settings
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 

      //template_item_reminders
     
      $item_reminders = $this->mod_common->get_all_records("project_scheduling_item_reminders","*",0,0,array("project_id"=>$import_project_id, "item_id"=>$item['id']));
      foreach($item_reminders as $val){
                        $table = "project_scheduling_item_reminders";
					
			$item_id = $item_id;
                        $to_id = $val['to_id'];
                        $project_id = $project_id;
                        $no_of_days = $val['no_of_days'];
                        $reminder_type= $val['reminder_type'];
                        $date = $val['date'];
                        $message = $val['message'];
                        $status = $val['status'];
                        $privacy_settings = $val['privacy_settings'];
  
                        
                        $ins_array = array(
                                "project_id"=>$project_id,
				"item_id" => $item_id,
                                "to_id" => $to_id,
                                "reminder_type" => $reminder_type,
                                "no_of_days" => $no_of_days,
                                "date" => $date,
                                "message"   => $message,
                                "status" => $status,
                                "user_id" => $this->session->userdata("user_id"),
                                "privacy_settings" => $privacy_settings
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }

    }//end of item foreach 
      
    $upd_array = array(
         "last_updated" => date('Y-m-d G:i:s')
        );
    $where = array("id" => $project_id);
    $table = "project_scheduling_projects";
    $this->mod_common->update_table($table, $where, $upd_array);
      
    }

    public function sort_item(){
      $id = $this->input->post("id");
      $priority = $this->input->post("priority");
      $table="project_scheduling_items";
      $where = array("id" => $id);
      $upd_array = array("priority" => $priority);
      $this->mod_common->update_table($table, $where, $upd_array);
    }
    
    public function sort_stages(){
        $stages = explode(",", $this->input->post("stages"));
        $project_id = $this->input->post("project_id");
        $table="project_scheduling_items";
        $j=1;
        for($i=0;$i<count($stages);$i++){
          if($stages[$i]!=""){
           $where = array("project_id" => $project_id, "stage_id" => $stages[$i]);
           $upd_array = array("stages_priority" => $j);
           $this->mod_common->update_table($table, $where, $upd_array);
           $j++;
          }
      }
    }

    public function invite_project_team(){

     $id = $this->input->post("id");
     $project_id = $this->input->post("project_id");

     $table = "project_scheduling_team";
     $where = "`id` ='" . $id . "'";

     $team_info = $this->mod_common->select_single_records($table, $where);

     $upd_array = array("is_invitation_send" => 1);

     $this->mod_common->update_table($table, $where, $upd_array);

     $table = "project_users";
     $where = "`user_id` ='" . $team_info['team_id'] . "'";

     $user_info = $this->mod_common->select_single_records($table, $where);

     $email = $user_info['user_email'];

     
     $email_content['token'] = $team_info['token'];
     $email_content['firstname'] = $user_info['user_fname'];

     $table = "project_scheduling_projects";
     $where = "`id` ='" . $project_id . "'";

     $project_info = $this->mod_common->select_single_records($table, $where);

     $email_content['project_name'] = $project_info['name'];
     $email_content['project_description'] = $project_info['description'];
    
     $table = "project_scheduling_team";
     $where = "`team_id` ='" . $this->session->userdata("user_id") . "' AND `project_id` ='" . $project_id . "'";

     $from_team_info = $this->mod_common->select_single_records($table, $where);
     
     $email_content['from_username'] = $this->session->userdata("firstname").' '.$this->session->userdata("lastname");
      
      if($from_team_info['team_role']==1){
        $designation = "Project Manager";
      }
      else{
        $designation = "Project Leader";
      }
     
     $email_content['from_designation'] = $designation;

     $message = $this->load->view("email_templates/invite_to_project", $email_content, TRUE); 
		   
                   $subject = "Project Invitation";
                   
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
                   $this->email->to($email);
                   //$this->email->from($this->session->userdata("email"));
                   $this->email->from("info@wizard.net.nz");
                   $this->email->subject($subject);
                   $this->email->message($message);
		           $this->email->send();

     $data['project_id'] = $project_id = $this->input->post("project_id");

     //Notification Code Starts Here

     $notification_text = " been invited to join ";
     $ins_array = array(
				"user_id" => $team_info['team_id'],
                "project_id" => $project_id,
                "notification_text" => $notification_text
			);
					
     $this->mod_common->insert_into_table("project_scheduling_notifications", $ins_array);

     //Notification Code Ends Here

    $data["scheduling_users"] =  $this->mod_scheduling->get_scheduling_users();
        
    $data["scheduling_members"] =  $this->mod_scheduling->get_scheduling_members();

     $this->load->view("scheduling/projects/project_team", $data);

    }

    public function update_event_from_calendar(){
$table = "project_scheduling_items";
$start_date = $this->input->post('start_date');
$end_date = $this->input->post('end_date');
$end_date = date('Y-m-d', strtotime($end_date.' -1 day'));
$task_id = $this->input->post('id');
$project_id = $this->input->post('project_id');
 
                        $upd_array = array(
                                "start_date" => $start_date,
                                "end_date"   => $end_date
			);

                        $where = array("id"=>$task_id);
					
		        $update_project_item = $this->mod_common->update_table($table, $where, $upd_array);

                               $table = "project_scheduling_items";
                               $where = "`project_id` ='" . $project_id . "'";

                               $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date");
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "last_updated" => date('Y-m-d G:i:s')
			       );

                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		               $this->mod_common->update_table($table, $where, $upd_array);
                           
                               echo date("d/m/Y", strtotime($task_info['end_date']));  
		        
}

    public function set_privacy(){

 $id = $this->input->post("id");

 $privacy_settings = $this->input->post("privacy_settings");

 $type = strtolower($this->input->post("type"));

 if($type == "image"){
     $type = "file";
 }  

 $table = "project_scheduling_item_".$type."s";

 if($type == "document"){
     $table = "project_plans_and_specifications";
 }

 $where = "`id` ='" . $id . "'";

 $upd_array = array(
                 "privacy_settings" => $privacy_settings
               );
if($type == "document"){
    $upd_array = array(
                 "privacy" => $privacy_settings
               );
}
 $this->mod_common->update_table($table, $where, $upd_array);
}

    public function verify_checklist() {

        $name = $this->input->post("name");
        
        $table = "project_scheduling_item_checklists";

        $item_id = $this->input->post("item_id");

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'item_id' => $item_id,
            'name' => $name,
          );
        }
        else{
          $where = array(
            'name' => $name,
            'item_id' => $item_id,
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    public function data($project_id, $daterange=""){
     
    if($daterange!=""){   
        $daterange = str_replace("%20"," ", $daterange);
        $daterange = explode(" - ", $daterange);
        $from_date = explode("-", $daterange[0]);
        $from_date = $from_date[2]."-".$from_date[1]."-".$from_date[0];
        $to_date = explode("-", $daterange[1]);
        $to_date = $to_date[2]."-".$to_date[1]."-".$to_date[0];
    }
    
    echo '[';
   
    $query = $this->db->query("SELECT pi.stage_id, pi.stages_priority, pi.id, s.name as stage_name FROM project_scheduling_items pi INNER JOIN project_scheduling_stages s ON s.id = pi.stage_id WHERE pi.project_id ='".$project_id."' GROUP BY pi.stage_id ORDER BY pi.stages_priority ASC, pi.id DESC");
     
    $stages = $query->result_array();
    
    $str = "";
    $stage_index =1;
    foreach($stages as $stage){
        
    echo '{
    "id": "s_'.$stage["stage_id"].'",
    "name": "'.$stage["stage_name"].'",
    "who": "",
    "rowHeight": 30,
    "actual": {
            "fill": "grey"
        },
    },';
    if($daterange==""){
       $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' ORDER BY pi.priority ASC");
       $items = $query->result_array();
    }
    else{
        $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' AND (pi.start_date >= '".$from_date."' AND pi.end_date <= '".$to_date."') ORDER BY pi.priority ASC");
       
        $items = $query->result_array();
    }
    if(count($items)>0){
    $i = 1;
    for($j=0;$j<count($items);$j++){
    if($items[$j]["status"]==0){
    $item_color = "#f44336";
    }else if($items[$j]["status"]==1){ 
    $item_color = "#ff9800";
    }else{ 
    $item_color = "#4caf50";
    } 
    $duration = 4;
    $start_date = $items[$j]['start_date'];
    $end_date = $items[$j]['end_date'];
    $who = get_user_info($items[$j]['assign_to_user']);
    echo '{
    "id": '.$items[$j]["id"].',
    "name": "'.$items[$j]["task_name"].'",
    "who":"'.$who.'",
    "duration":"'.$duration.'",
    "parent": "s_'.$stage["stage_id"].'",
    "actualStart": "'.$start_date.'",
    "actualEnd": "'.$end_date.'",
    "actual": {
            "fill": "'.$item_color.'"
        },
    "rowHeight": 30,';
    if(isset($items[$i]["id"])){
    echo '"connectTo": '.$items[$i]["id"];
    }
    else{
        
      if($daterange==""){
       $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stages[$stage_index]['stage_id']."' ORDER BY pi.priority ASC");
       $next_items = $query->result_array();
    }
    else{
        $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stages[$stage_index]['stage_id']."' AND (pi.start_date >= '".$from_date."' AND pi.end_date <= '".$to_date."') ORDER BY pi.priority ASC");
        $next_items = $query->result_array();
    }
      if(isset($next_items[0]['id'])){
         echo '"connectTo": '.$next_items[0]['id']; 
      }
    }
    echo ' },'; 
    $i++;
    }
    }
    
    $stage_index++;
}
echo ']';
    }
    
    public function update_project_item_duration(){
       $this->mod_scheduling->is_viewer();
       $this->mod_common->is_company_page_accessible(153);
       
		$table = "project_scheduling_items";

        $id = $this->input->post('id');
        $project_id = $this->input->post('project_id');
        $field = $this->input->post('field');
			
        $value = DateTime::createFromFormat('m/d/Y', $this->input->post('value'));
        $value = $value->format('Y-m-d');
                        
        if($field == "actualStart"){
            $upd_array = array(
                   "start_date" => $value
    		);
        }
        else{
    		$upd_array = array(
                    "end_date" => $value
    		);
        }

        $where = array("id"=>$id);
					
		$update_project_item = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_project_item) {
                               $table = "project_scheduling_items";
                               $where = "`project_id` ='" . $project_id . "'";

                               $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date, MIN(start_date) as start_date");
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "start_date"   => $task_info['start_date'],
                                "last_updated" => date('Y-m-d G:i:s')
                                
			       );
			        

                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		               $this->mod_common->update_table($table, $where, $upd_array);
                           
                        echo date("d/m/Y", strtotime($task_info['start_date']))."|".date("d/m/Y", strtotime($task_info['end_date']));  
		        }
    }
    
    public function update_project_item_connecting_duration(){
       $this->mod_scheduling->is_viewer();
       $this->mod_common->is_company_page_accessible(153);
       
		$table = "project_scheduling_items";

        $id = $this->input->post('id');
        $project_id = $this->input->post('project_id');
			
        $actualStart = DateTime::createFromFormat('m/d/Y', $this->input->post('actualStart'));
        $actualStart = $actualStart->format('Y-m-d');
        
        $actualEnd = DateTime::createFromFormat('m/d/Y', $this->input->post('actualEnd'));
        $actualEnd = $actualEnd->format('Y-m-d');
                        
            $upd_array = array(
                   "start_date" => $actualStart,
                   "end_date" => $actualEnd
    		);
    		

        $where = array("id"=>$id);
					
		$update_project_item = $this->mod_common->update_table($table, $where, $upd_array);
       
			if ($update_project_item) {
                               $table = "project_scheduling_items";
                               $where = "`project_id` ='" . $project_id . "'";

                               $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date, MIN(start_date) as start_date");
                               
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "start_date"   => $task_info['start_date'],
                                "last_updated" => date('Y-m-d G:i:s')
                               );

                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		               $this->mod_common->update_table($table, $where, $upd_array);
                           
                        echo date("d/m/Y", strtotime($task_info['start_date']))."|".date("d/m/Y", strtotime($task_info['end_date']));   
		        }
    }
    
    public function download_image($filename=""){
        if($filename==""){
            redirect("nopage");
        }
        $this->load->helper('download');
        
        $data = file_get_contents(TASK_PATH.'images/'.$filename);
        force_download($filename, $data);
    }
    
    public function download_file($filename=""){
        if($filename==""){
            redirect("nopage");
        }
        $this->load->helper('download');
        
        $data = file_get_contents(TASK_PATH.'files/'.$filename);
        force_download($filename, $data);
    }
    
    public function add_new_user()
	{   
            $this->mod_scheduling->is_viewer();
		    $this->mod_common->is_company_page_accessible(153);
		    $table="project_roles";
            $data['roles'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id'), "status" => 1));
			    
		        $this->form_validation->set_rules('first_name', 'First Name', 'required');
		        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
				$this->form_validation->set_rules('role_id', 'Role', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[project_users.user_email]');

				
			    if ($this->form_validation->run() == FALSE)
				{
				   echo '<p class="text-danger">All mandatory fields are required!</p>';
				}
				else{

					$table = "project_users";
					
					$first_name = $this->input->post('first_name');
					$last_name = $this->input->post('last_name');
					$email = $this->input->post('email');
					$role_id = $this->input->post('role_id');
					$is_sent_activation_email = ($this->input->post('is_sent_activation_email')!="") ? 1 : 0;
					$created_by = $this->session->userdata("user_id");
                    $ip_address = $_SERVER['REMOTE_ADDR'];
					$password = random_password_generator();

					$filename= "project_avatar.png";

					$ins_array = array(
						"user_fname" => $first_name,
						"user_lname" => $last_name,
                        "user_email" => $email,
						"user_password" => md5($password),
						"user_img" => $filename,
						"role_id" => $role_id,
						"user_role" => 1,
						"company_id" => $this->session->userdata("company_id"),
						"created_by" => $created_by,
                        "ip_address" => $ip_address,
                        "is_sent_activation_email" => $is_sent_activation_email
					);
					
		            $add_user = $this->mod_common->insert_into_table($table, $ins_array);
					
					if ($add_user) {
                                    if($is_sent_activation_email==1){
                                                $subject = "Confirm Registration";
                                                $data['password'] = $password;
                                                $data['email'] = $email;
                                                $data['firstname'] = $first_name;
                                                $data['id'] = $this->db->insert_id();

		                                        $message = $this->load->view("email_templates/register_template", $data, TRUE); 
		   
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
                                                
                                                $this->email->to($email);
                                                $this->email->from('info@wizard.net.nz');
                                                $this->email->subject($subject);
                                                $this->email->message($message);
		                                        $this->email->send();
                                    }
						$item_id = $this->input->post('user_item_id');
                        $project_id = $this->input->post('user_project_id');
                        $data['item_id'] = $item_id;
                        $data['project_id'] = $project_id;
                       
                        $task_info = $this->mod_common->select_single_records("project_scheduling_items", "`id` ='" . $item_id . "'");
                        $data['task_id'] = $task_info['task_id'];
                        $data['assign_to_user'] = $task_info['assign_to_user'];
                        $this->load->view("scheduling/projects/users", $data);
                        
					} else {
						
						echo '<p class="text-danger">Error in adding User please try again!</p>';
					}
				}
	}
	
	public function assign_task_to_user(){
	    $assign_to_user = $this->input->post("user_id");
	    $item_id = $this->input->post("item_id");
	    
	    $upd_array = array(
	        "assign_to_user" => $assign_to_user
	        );
	        
	    $where = array("id" => $item_id);
	    
	    $this->mod_common->update_table("project_scheduling_items", $where, $upd_array);
	}
	
	public function get_all_users($type){
	   $data["type"] = $type;
	   $this->load->view("scheduling/projects/project_scheduling_team_users", $data);
	}
	
	public function gantt_tasks($project_id, $daterange=""){
    
    $result = array();
    
    if($daterange!=""){   
        $daterange = str_replace("%20"," ", $daterange);
        $daterange = explode(" - ", $daterange);
        $start_date = explode("-", $daterange[0]);
        $start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];
        $end_date = explode("-", $daterange[1]);
        $end_date = $end_date[2]."-".$end_date[1]."-".$end_date[0];
    }
   
    $query = $this->db->query("SELECT pi.stage_id, pi.stages_priority, pi.id, s.name as stage_name FROM project_scheduling_items pi INNER JOIN project_scheduling_stages s ON s.id = pi.stage_id WHERE pi.project_id ='".$project_id."' GROUP BY pi.stage_id ORDER BY pi.stages_priority ASC, pi.id DESC");
     
    $stages = $query->result_array();
    
    
    $str = "";
    $stage_index =1;
    foreach($stages as $key => $stage){

      // rows
      $result[$key]["id"] = $stage["stage_id"];
      $result[$key]["text"] = htmlspecialchars($stage["stage_name"]);
      $result[$key]["start"] = "";
      $result[$key]["end"] ="";
      $result[$key]["type"] =null;
        
    if($daterange==""){
       $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' ORDER BY pi.priority ASC");
       $items = $query->result_array();
    }
    else{
        $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' AND (pi.start_date >= '".$start_date."' AND pi.end_date <= '".$end_date."') ORDER BY pi.priority ASC");
        $items = $query->result_array();
    }
    if(count($items)>0){
    $i = 1;
        for($j=0;$j<count($items);$j++){
            if($items[$j]["status"]==0){
            $item_color = "#f44336";
            }else if($items[$j]["status"]==1){ 
            $item_color = "#ff9800";
            }else{ 
            $item_color = "#4caf50";
            } 
            $start_date = $items[$j]['start_date'];
            $end_date = $items[$j]['end_date'];
            $who = get_user_info($items[$j]['assign_to_user']);
            
            $result[$key]["children"][$j]["id"] = $items[$j]['id'];
            $result[$key]["children"][$j]["text"] = $items[$j]['task_name'];
            $result[$key]["children"][$j]["start"] = $start_date;
            $result[$key]["children"][$j]["end"] = $end_date;
            $result[$key]["children"][$j]["type"] = $who;
            $result[$key]["children"][$j]["color"] = $item_color;
            $i++;
        }
    }
    
    $stage_index++;
    
    }

    echo json_encode($result);
    
}

public function gantt_task_move($project_id){
       $json = file_get_contents('php://input');
       $params = json_decode($json);
       
       $this->mod_scheduling->is_viewer();
       $this->mod_common->is_company_page_accessible(153);
       
		$table = "project_scheduling_items";

        $id = $params->id;
        
			
        $start = explode("T", $params->start);
        $end = explode("T", $params->end);
        
        
                        
    		$upd_array = array(
    		        "start_date" => $start[0],
                    "end_date" => $end[0]
    		);
        

        $where = array("id"=>$id);
					
		$update_project_item = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_project_item) {
                               $table = "project_scheduling_items";
                               $where = "`project_id` ='" . $project_id . "'";

                               $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date, MIN(start_date) as start_date");
                               
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "start_date"   => $task_info['start_date'],
                                "last_updated" => date('Y-m-d G:i:s')
                                
			       );
			        

                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		               $this->mod_common->update_table($table, $where, $upd_array);
		               
                        $response["start_date"] = $task_info['start_date'];
                        $response["end_date"] = $task_info['end_date'];
                        
                        //header('Content-Type: application/json');
                        echo json_encode($response);
                        
		        }
    }
    
    public function getData($project_id, $daterange=""){
    
    $result = array();
    
    if($daterange!=""){   
        $daterange = str_replace("%20"," ", $daterange);
        $daterange = explode(" - ", $daterange);
        $start_date = explode("-", $daterange[0]);
        $start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];
        $end_date = explode("-", $daterange[1]);
        $end_date = $end_date[2]."-".$end_date[1]."-".$end_date[0];
    }
   
    $query = $this->db->query("SELECT pi.stage_id, pi.stages_priority, pi.id, s.name as stage_name FROM project_scheduling_items pi INNER JOIN project_scheduling_stages s ON s.id = pi.stage_id WHERE pi.project_id ='".$project_id."' GROUP BY pi.stage_id ORDER BY pi.stages_priority ASC, pi.id DESC");
     
    $stages = $query->result_array();
    
    $stages_array = $query->result_array();
    
    $str = "";
    $arrayIndex = 0;
    $stage_index =1;
    foreach($stages as $key => $stage){

      // rows
      $result[$arrayIndex]["taskID"] = $stage_index;
      $result[$arrayIndex]["taskName"] = htmlspecialchars($stage["stage_name"]);
      $result[$arrayIndex]["startDate"] = "";
      $result[$arrayIndex]["endDate"] ="";
      $result[$arrayIndex]["parentID"] =null;
      $result[$arrayIndex]["who"] =null;
      $parentID = $stage_index;
    if($daterange==""){
       $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' ORDER BY pi.priority ASC");
       $items = $query->result_array();
    }
    else{
        $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' AND (pi.start_date >= '".$start_date."' AND pi.end_date <= '".$end_date."') ORDER BY pi.priority ASC");
        $items = $query->result_array();
    }
    if(count($items)>0){
    $i = 1;
    
        for($j=0;$j<count($items);$j++){
            $arrayIndex++;
            $stage_index++;
            
            $start_date = $items[$j]['start_date'];
            $end_date = $items[$j]['end_date'];
            $who = get_user_info($items[$j]['assign_to_user']);
            
            $result[$arrayIndex]["taskID"] = $stage_index;
            $result[$arrayIndex]["taskName"] = $items[$j]['task_name'];
            $result[$arrayIndex]["startDate"] = $start_date;
            $result[$arrayIndex]["endDate"] = $end_date;
            $result[$arrayIndex]["parentID"] = $parentID;
            $result[$arrayIndex]["who"] = $who;
            $i++;
        }
    }
    $arrayIndex++;
    $stage_index++;
    
    }
    
    echo json_encode($result);
}

function getStages(){
    $table = "stages";
    $data['stages'] = $this->mod_common->get_all_records($table, "id, name", 0, 0, array("status" => 1));
    echo json_encode($data['stages']);
}

function getHolidays(){
    $public_holidays = $this->mod_common->get_all_records("project_scheduling_public_holidays");
    $holidays = array();
    foreach($public_holidays as $key => $val){
        $date = explode("/", $val["date"]);
        $holidays[] = array("month" => str_replace("0", "", $date[1])-1, "day" => str_replace("0", "", $date[0]), "year" => $date[2], "label" => $val["title"]);
    }
   
    echo json_encode($holidays);
}

public function get_project_dates(){
    $project_id = $this->input->post("project_id");
     $table = "project_scheduling_items";
                               $where = "`project_id` ='" . $project_id . "'";

                               $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date, MIN(start_date) as start_date");
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "start_date"   => $task_info['start_date'],
                                "last_updated" => date('Y-m-d G:i:s')
                                
			       );
			        

                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		               $this->mod_common->update_table($table, $where, $upd_array);
                           
                        echo date("d/m/Y", strtotime($task_info['start_date']))."|".date("d/m/Y", strtotime($task_info['end_date']));
}

public function ganttTasks($project_id, $daterange=""){
     
    if($daterange!=""){   
        $daterange = str_replace("%20"," ", $daterange);
        $daterange = explode(" - ", $daterange);
        $from_date = explode("-", $daterange[0]);
        $from_date = $from_date[2]."-".$from_date[1]."-".$from_date[0];
        $to_date = explode("-", $daterange[1]);
        $to_date = $to_date[2]."-".$to_date[1]."-".$to_date[0];
    }
    $query = $this->db->query("SELECT pi.stage_id, pi.stages_priority, pi.id, s.name as stage_name FROM project_scheduling_items pi INNER JOIN project_scheduling_stages s ON s.id = pi.stage_id WHERE pi.project_id ='".$project_id."' GROUP BY pi.stage_id ORDER BY pi.stages_priority ASC, pi.id DESC");
     
    $stages = $query->result_array();
    echo "[";
    $str = "";
    $stage_index =1;
        foreach($stages as $stage){
            if($daterange==""){
               $query = $this->db->query("SELECT MIN(pi.start_date) as p_start_date, MAX(pi.end_date) as p_end_date, t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' ORDER BY pi.priority ASC");
               $items = $query->result_array();
            }
            else{
                $query = $this->db->query("SELECT MIN(pi.start_date) as p_start_date, MAX(pi.end_date) as p_end_date, t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' AND (pi.start_date >= '".$from_date."' AND pi.end_date <= '".$to_date."') ORDER BY pi.priority ASC");
                
                $items = $query->result_array();
            }
            
            if(count($items)>0){
                $start_date = strtotime($items[0]["p_start_date"])*1000;
                $end_date = strtotime($items[0]["p_end_date"])*1000;
                
                $date1 = new DateTime($items[0]["p_start_date"]);
                $date2 = new DateTime($items[0]["p_end_date"]);
                $interval = $date1->diff($date2);

                $duration = $interval->days;
                
                echo '{"id": -'.$stage["stage_id"].', "name": "'.$stage["stage_name"].'", "progress": 0, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "", "level": 0, "status": "STATUS_UNDEFINED", "depends": "", "canWrite": true, "start": '.$start_date.', "duration": '.$duration.', "end": '.$end_date.', "startIsMilestone": false, "endIsMilestone": false, "collapsed": false, "assigs": [], "hasChild": true}';
                $i = 0;
            }
            
            $stage_index++;
        }
        
    echo "]";
    }
    
    public function set_daterange(){
        $this->session->set_userdata("daterange", $this->input->post("date_range"));
        $data["project_id"] = $this->input->post("project_id");
        $data["is_full_screen"] = false;
        $this->load->view("scheduling/projects/gantt_chart_ajax", $data);
    }
    
    public function print_gantt($project_id){
        $data["project_id"] = $project_id;
        
        $table = "project_scheduling_projects";
        $where = "`id` ='" . $project_id . "'";
        $data["project_info"] = $this->mod_common->select_single_records($table, $where);
        if($this->session->userdata("daterange")){
           $data["daterange"] = $this->session->userdata("daterange");
        }
        else{
            $start_date = explode("-", $data["project_info"]["start_date"]);
            $end_date = explode("-", $data["project_info"]["end_date"]);
            $data["daterange"] = $start_date[1]."/".$start_date[2]."/".$start_date[0]." - ".$end_date[1]."/".$end_date[2]."/".$end_date[0];
        }
        echo $this->load->view('projects/gantt_chart_pdf', $data, true);
    }
    
    public function load_gantt_chart($project_id, $is_full_screen=false){
        $data["project_id"] = $project_id;
        $data["is_full_screen"] = $is_full_screen;
        $this->load->view("scheduling/projects/gantt_chart_ajax", $data);
    }
    
    public function assignTaskToUser()
    {
        $id = $this->input->post("item_id");
        $user_id = $this->input->post("user_id");
        $table = "project_scheduling_items";
        $where = array("id" => $id);
        $upd_array = array("assign_to_user" => $user_id);
        $this->mod_common->update_table($table, $where, $upd_array);
        
    }
    
    public function update_project_tasks(){
       $this->mod_scheduling->is_viewer();
       $this->mod_common->is_company_page_accessible(153);
       
		$table = "project_scheduling_items";

        $prj = $this->input->post('prj');
        $project_id = $this->input->post('project_id');
        
        $results = json_decode($prj);
        
        $priority = 1;
        
        $stages_priority = 0;
        
        $dependent_id = 0;
        
        $scheduling_items = $this->mod_common->get_all_records($table, "id", 0, 0, array("project_id" => $project_id));
        
        $scheduling_items_list = array();
        
        foreach($results->tasks as $task){
            if($task->level==0){
               $stages_priority++; 
               $dependent_id++;
            }
            else if($task->level>0){
                
                $dependent_id++;
                $id = $task->id;
                $scheduling_items_list[] = $id;
                $start = $task->start;
                $end = $task->end;
                $depends = $task->depends;
                
                $actualStart = date('Y-m-d', ceil($start/1000));
                
                $mili = ceil($end/1000);
            
                $actualEnd = date('Y-m-d', strtotime('-1 day', $mili));
                
               
                 $upd_array = array(
                       "start_date" => $actualStart,
                       "end_date" => $actualEnd,
                       "dependent_id" => $dependent_id,
                       "depends" => $depends,
                       "startDateInMiliseconds" => $start,
                       "endDateInMiliseconds" => $end,
                       "duration" => $task->duration,
                       "priority" => $priority,
                       "stages_priority"  => $stages_priority
        		);
    
                $where = array("id"=>$id);
        					
        		$update_project_item = $this->mod_common->update_table($table, $where, $upd_array);
        		$priority ++;
            }
        }
        
        foreach($scheduling_items as $item){
            if(!in_array($item["id"], $scheduling_items_list)){
                $this->mod_common->delete_record($table, array("id" => $item["id"]));
            }
        }
        
            $table = "project_scheduling_items";
            $where = "`project_id` ='" . $project_id . "'";

            $task_info = $this->mod_common->select_single_records($table, $where, "MAX(end_date) as end_date, MIN(start_date) as start_date");
                               
                               $upd_array = array(
                                "end_date"   => $task_info['end_date'],
                                "start_date"   => $task_info['start_date'],
                                "last_updated" => date('Y-m-d G:i:s')
                               );
                               
                               $table = "project_scheduling_projects";

                               $where = array("id"=>$project_id);
					
		               $this->mod_common->update_table($table, $where, $upd_array);
                           
                        echo date("d/m/Y", strtotime($task_info['start_date']))."|".date("d/m/Y", strtotime($task_info['end_date']));   
		        
    }
    
    public function editSchedulingTask(){
        $data["project_id"] = $this->input->post("projectId");
        $data["item_id"] = $rowno = $this->input->post("taskId");
         $table = "project_scheduling_items";
     $where = "`id` ='" . $rowno . "'";

     $data["item"] = $checklist_item_info = $this->mod_common->select_single_records($table, $where);
     $data["task_id"] = $checklist_item_info['task_id'];
     $data['checklist_items'] = $checklist_item_info['checklist'];
     $this->load->view("scheduling/projects/editSchedulingTask", $data);
    }
    
    public function getTaskUsers(){
        $data["project_id"] = $this->input->post("projectId");
        $data["item_id"] = $rowno = $this->input->post("taskId");
        $data["selectedUser"] = $this->input->post("selectedUser");
        $table = "project_scheduling_items";
        $where = "`id` ='" . $rowno . "'";

        $data["item"] = $checklist_item_info = $this->mod_common->select_single_records($table, $where);
        $data["task_id"] = $checklist_item_info['task_id'];
        $data["users"] = $this->mod_common->get_all_records("project_users", "*", 0, 0, array("user_status" => 1, "company_id" => $this->session->userdata("company_id")), "user_id");
        $this->load->view("scheduling/projects/usersList", $data);
    }
    
    public function add_new_log(){
        $data["count"] = $this->input->post("count");
        $data["date"] = date("d/m/Y");
        $data["user"] = get_user_name($this->session->userdata("user_id"));
        $this->load->view("scheduling/projects/add_new_log", $data);
    }
    
    //Add New Project Log Process
     public function new_log_process(){

       $notes = $this->input->post("log_notes");
       $project_id = $this->input->post("project_id");

       $filename= "";

       if (isset($_FILES['log_image']['name']) && $_FILES['log_image']['name'] != "") {
						
						$projects_folder_path = './assets/scheduling/project_logs/';
						$projects_folder_path_main = './assets/scheduling/project_logs/';

						$thumb = $projects_folder_path_main . 'thumb';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('log_image')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							print_r($error_file_arr);exit;
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
                            
							
						}
					}
					
            $ins_array = array(
                   "project_id" => $project_id,
                   "notes" => $notes,
                   "image" => $filename,
                   "user_id" => $this->session->userdata("user_id")
            );
        $this->mod_common->insert_into_table("project_logs", $ins_array);
                        
        $ins_array = array(
                                "project_id"=>$project_id,
				                "item_id" => 0,
                                "activity_type" => "add_new_log",
                                "activity_id" => $this->db->insert_id(),
                                "user_id" => $this->session->userdata("user_id"),
                                "created_at" => date('Y-m-d G:i:s')
			     );

    $this->mod_common->insert_into_table("project_scheduling_activities", $ins_array);
    
    
    $where = "`project_id` ='" . $project_id."'";

    $data['project_logs'] = $this->mod_common->get_all_records("project_logs", "*", 0, 0, $where);

    $this->load->view("scheduling/projects/project_logs", $data);

    }
    
    public function project_logs(){
        
    $project_id = $this->input->post("project_id");
    
    $where = "`project_id` ='" . $project_id."'";

    $data['project_logs'] = $this->mod_common->get_all_records("project_logs", "*", 0, 0, $where);

    $this->load->view("scheduling/projects/project_logs", $data);
    }

   
}
