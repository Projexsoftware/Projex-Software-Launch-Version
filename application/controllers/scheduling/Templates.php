<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends CI_Controller {

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
	     $this->mod_common->is_company_page_accessible(155);
        $data['templates'] = $this->mod_common->get_all_records("project_scheduling_templates", "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));
        $this->stencil->title('Templates');
	    $this->stencil->paint('scheduling/templates/manage_templates', $data);
	}

	public function add_template() {
	    $this->mod_common->is_company_page_accessible(155);
        $this->stencil->title('Add Template');
        $this->stencil->paint('scheduling/templates/add_template');
    }
        
    public function view_template() {
        $this->stencil->title('View Template');
        $this->stencil->paint('scheduling/templates/view_template');
    }
	
	public function add_new_template_process() {
		$this->mod_common->is_company_page_accessible(155);
	    $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
	    if ($this->form_validation->run() == FALSE)
	        {
	          
                  $this->stencil->title('Add Template');
                  $this->stencil->paint('scheduling/templates/add_template');
		}
		else{
			$table = "project_scheduling_templates";
					
			$name = $this->input->post('name');
                        $description = $this->input->post('description');
                        
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        $company_id = $this->session->userdata("company_id");
 
                        $ins_array = array(
            				"name" => $name,
                           "description" => $description,
            				"created_by" => $created_by,
                            "ip_address" => $ip_address,
            				"status" => 1,
            				"company_id" => $company_id
            			);
					
		        $add_new_template = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_template) {
				$this->session->set_flashdata('ok_message', 'New Template added successfully.');
				redirect(SURL . 'buildz/templates/edit_template/'.$add_new_template);
			} else {

				$this->session->set_flashdata('err_message', 'New Template is not added. Something went wrong, please try again.');

				redirect(SURL . 'buildz/templates/add_template');
			}
		}
    }
	
	public function edit_template($template_id) {
	$this->mod_common->is_company_page_accessible(155);
	if($template_id=="" || !(is_numeric($template_id))){
            redirect("nopage");
        }
		
        $table = "project_stages";
        $data['stages'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")), "stage_id");

        $table = "project_scheduling_checklists";
        $data['checklists'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id" =>  $this->session->userdata("company_id")));

        $table = "project_scheduling_tasks";
        $data['tasks'] = $this->mod_common->get_all_records($table, "*");

        $table = "project_scheduling_template_items";
        $data['template_stages'] = $this->mod_scheduling->get_template_stages($template_id);

        $table = "project_scheduling_templates";
        $where = "`id` ='" . $template_id."'";

        $data['template_edit'] = $this->mod_common->select_single_records($table, $where);
        
        $data["exttemplates"] = $this->mod_scheduling->get_existing_templates();
        $data["extprojects"] = $this->mod_scheduling->get_existing_projects_for_buildz();
        $data["extsupplierzbuildztemplates"] = $this->mod_scheduling->get_existing_supplierz_buildz_templates();
        
        if (count($data['template_edit']) == 0) {
            redirect("nopage");
        } else {
        $this->stencil->title('Edit Template');
        $this->stencil->paint('scheduling/templates/view_template', $data);
        }
    }
    
    public function update_template_info(){
        $id = $this->input->post("id");
        $value = $this->input->post("value");
        $type = $this->input->post("type");
        
        $table = "project_scheduling_templates";
        
        $where = array(
            'id !=' => $id,
            'name' => $value,
            "company_id" =>  $this->session->userdata("company_id")
        );
        
        $is_already_exists = $this->mod_common->select_single_records($table, $where);
        
        if($type == "name" && empty($is_already_exists)){
            $this->mod_common->update_table($table, array("id" => $id), array($type => $value));
            echo "Template name updated!";
        }
        else if($type == "description"){
            $this->mod_common->update_table($table, array("id" => $id), array($type => $value));
            echo "Template description updated!";
        }
        else{
            echo "error";
        }
        
    }

    public function add_new_template_item() {
		$this->mod_common->is_company_page_accessible(155);
        $this->mod_scheduling->is_viewer();
	    $this->form_validation->set_rules('stage_id', 'Stage', 'required');
            if($this->input->post('task_type')==0){
              $this->form_validation->set_rules('task_id', 'Task', 'required');
            }
            else{
              $this->form_validation->set_rules('task_name', 'Task Name', 'required');
            }
            /*$this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');*/
	    if ($this->form_validation->run() == FALSE)
	        {
	          echo '<p class="text-danger">All Fields are required</p>';
		}
		else{
			$table = "project_scheduling_template_items";
					
			$stage_id = $this->input->post('stage_id');
                        $task_id = $this->input->post('task_id');
                        $template_id = $this->input->post('template_id');
                        $task_type = $this->input->post('task_type');
                        $created_by = $this->session->userdata("user_id");
                        $company_id = $this->session->userdata("company_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        if($task_type == "1"){
                        $task_name = $this->input->post('task_name');
                           $ins_array = array(
                                "name"=>$task_name,
				                "created_by" => $created_by,
                                "ip_address" => $ip_address,
                                "company_id" => $company_id,
                                "status" => 1
			   );
					
		           $this->mod_common->insert_into_table("project_scheduling_tasks", $ins_array);
                           $task_id = $this->db->insert_id();

                        }
                        $priority_info = $this->mod_common->select_single_records($table, array("stage_id"=>$stage_id,"template_id"=>$template_id), "MAX(priority) as priority");

                        $ins_array = array(
                                "template_id"=>$template_id,
				"stage_id" => $stage_id,
                                "task_id" => $task_id,
                                "priority" => $priority_info["priority"]+1
			);
					
		        $add_new_template_item = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_template_item) {
                           
                              echo "<span class='text-success'>Task Added Successfully</span>";  
		        }
                }
    }
	
    public function get_template_items(){ 
       $this->mod_common->is_company_page_accessible(155);
       $template_id = $this->input->post("template_id");
       $data['template_id'] = $template_id;

       $table = "project_scheduling_checklists";
       $data['checklists'] = $this->mod_common->get_all_records($table, "*");

       $table = "project_scheduling_templates";
       $where = "`id` ='" . $template_id."'";

       $data['template_edit'] = $this->mod_common->select_single_records($table, $where);

       $table = "project_scheduling_template_items";
       $data['template_stages'] = $this->mod_scheduling->get_template_stages($template_id);
       $this->load->view("scheduling/templates/template_items", $data);
    }

    public function get_stage_status(){
       $template_id = $this->input->post("template_id");
       $data['template_id'] = $template_id;

       $stage_id = $this->input->post("stage_id");
       $data['stage_id'] = $stage_id;

       $item_count = $this->input->post("item_count");
       $data['item_count'] = $item_count;

       $this->load->view("scheduling/templates/stage_status_ajax", $data);
    }
    
    public function delete_template() {
        $this->mod_common->is_company_page_accessible(155);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	$table = "project_scheduling_templates";
        $where = "`id` ='" . $id . "'";
		
        $this->mod_common->delete_record($table, $where);

        //Delete Items
        $table = "project_scheduling_template_items";
        $where = "`template_id` ='" . $id . "'";
		
        $this->mod_common->delete_record($table, $where);

      //Delete Checklists

     $table = "project_scheduling_template_item_checklists";
     $where = "`template_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Notes

     $table = "project_scheduling_template_item_notes";
     $where = "`template_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Reminders

     $table = "project_scheduling_template_item_reminders";
     $where = "`template_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Files

     $table = "project_scheduling_template_item_files";
     $where = "`template_id` ='" . $id . "'";

     $this->mod_common->delete_record($table, $where);

    }

    public function remove_task(){
     
     $item_id = $this->input->post("item_id");

     $table = "project_scheduling_template_items";
     $where = "`id` ='" . $item_id. "'";
		
     $this->mod_common->delete_record($table, $where);

     //Delete Checklists

     $table = "project_scheduling_template_item_checklists";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Notes

     $table = "project_scheduling_template_item_notes";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Reminders

     $table = "project_scheduling_template_item_reminders";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     //Delete Files

     $table = "project_scheduling_template_item_files";
     $where = "`item_id` ='" . $item_id. "'";

     $this->mod_common->delete_record($table, $where);

     $template_id = $this->input->post("template_id");
       $data['template_id'] = $template_id;

       $table = "project_scheduling_checklists";
       $data['checklists'] = $this->mod_common->get_all_records($table, "*");

       $table = "project_scheduling_templates";
       $where = "`id` ='" . $template_id."'";

       $data['template_edit'] = $this->mod_common->select_single_records($table, $where);

       $table = "project_scheduling_template_items";
       $data['template_stages'] = $this->mod_scheduling->get_template_stages($template_id);
       $this->load->view("scheduling/templates/template_items", $data);

    }
	
    public function verify_name() {

        $name = $this->input->post("name");
        
        $table = "project_scheduling_templates";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'name' => $name,
            "company_id" =>  $this->session->userdata("company_id")
          );
        }
        else{
          $where = array(
            'name' => $name,
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

    public function update_task_checklist(){

      $task_id = $this->input->post("task_id");
      $checklist = $this->input->post("checklist");
      $status = $this->input->post("status");
      $upd_array = array(
         "checklist" => implode(",", $checklist),
         "status" => $status
      );
      $where = array("id" => $task_id);
      $table = "project_scheduling_template_items";
      $this->mod_common->update_table($table, $where, $upd_array);

    }

    public function add_new_checklist(){
     
     $table = "project_scheduling_template_item_checklists";

			$item_id = $this->input->post('item_id');
                        $template_id = $this->input->post('template_id');		
			$name = $this->input->post('checklist');
                        $created_by = $this->session->userdata("user_id");
 
                        $ins_array = array(
                                "item_id" => $item_id,
				"template_id" => $template_id,
				"user_id" => $created_by,
				"name" => $name
			);
					
		        $add_new_checklist = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_checklist) {

                                $check_list_id = $this->db->insert_id();

                                $table = "project_scheduling_template_items";
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

     $table = "project_scheduling_template_items";
     $where = "`id` ='" . $rowno . "'";

     $checklist_item_info = $this->mod_common->select_single_records($table, $where);

                              $data['template_id'] = $template_id;
                              $data['item_id'] = $checklist_item_info['id'];
                              $data['task_id'] = $checklist_item_info['task_id'];
                              $data['checklist_items'] = $checklist_item_info['checklist'];
                              $data['template_id'] = $checklist_item_info['template_id'];
                               $this->load->view("scheduling/templates/checklist", $data);
                        }

    }

    public function add_new_note(){
      $table = "project_scheduling_template_item_notes";

			$item_id = $this->input->post('note_item_id');
                        $template_id = $this->input->post('note_template_id');
                        $data['item_id'] = $item_id;
                        $data['template_id'] = $template_id;
                        $task_info = $this->mod_common->select_single_records("project_scheduling_template_items", "`id` ='" . $item_id . "'");
                        $data['task_id'] = $task_info['task_id'];
	
                        $author = $this->input->post('author');
                        $date = DateTime::createFromFormat('d/m/Y', $this->input->post('date'));
                        $date = $date->format('Y-m-d');	
			$note = $this->input->post('note');
 
                        $ins_array = array(
                                "item_id" => $item_id,
				"template_id" => $template_id,
				"author" => $author,
                                "date " => $date,
				"note " => $note 
			);
					
		        $add_new_note = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_note) {

                              $this->load->view("scheduling/templates/notes", $data);
                        }

    }

    public function remove_note(){

     $id = $this->input->post("id");

     $table = "project_scheduling_template_item_notes";
     $where = "`id` ='" . $id . "'";

     $note_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);
     
     $data['item_id'] = $note_info['item_id'];
     $data['template_id'] = $note_info['template_id'];
   
     $task_info = $this->mod_common->select_single_records("project_scheduling_template_items", "`id` ='" . $note_info['item_id'] . "'");
     $data['task_id'] = $task_info['task_id'];

     $this->load->view("scheduling/templates/notes", $data);
     
    }

    public function remove_checklist(){

     $id = $this->input->post("id");
     $rowno = $this->input->post("rowno");

     $table = "project_scheduling_template_items";
     $where = "`id` ='" . $rowno . "'";

     $checklist_item_info = $this->mod_common->select_single_records($table, $where);

     $table = "project_scheduling_template_item_checklists";
     $where = "`id` ='" . $id . "'";

     $checklist_info = $this->mod_common->select_single_records($table, $where);

     $table = "project_scheduling_template_items";

     $where = "`id` ='" . $checklist_info['item_id']."'";

     $checklists = $this->mod_common->get_all_records($table, '*', 0, 0, $where);

     $data['item_id'] = $checklist_item_info['id'];
     $data['checklist_items'] = $checklist_item_info['checklist'];
     $data['template_id'] = $checklist_item_info['template_id'];
     $data['task_id'] = $checklist_item_info['task_id'];

     $total_checklists = $this->mod_common->get_all_records("project_scheduling_template_item_checklists", '*', 0, 0, array("item_id"=> $checklist_info['item_id']));
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
$total_checklists = $this->mod_common->get_all_records("project_scheduling_template_item_checklists", '*', 0, 0, array("item_id"=> $checklist_info['item_id'], "id !="=>$id));
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
        $table = "project_scheduling_template_item_checklists";
        $where = "`id` ='" . $id . "'";
        $delete_checklist = $this->mod_common->delete_record($table, $where);
     
        $this->load->view("scheduling/templates/checklist", $data);
     
    }

    public function upload_file(){

       $item_id = $this->input->post("file_item_id");
       $template_id = $this->input->post("file_template_id");

       $data['item_id'] = $item_id;
       $data['template_id'] = $template_id;

       $task_info = $this->mod_common->select_single_records("project_scheduling_template_items", "`id` ='" . $item_id . "'");
       $data['task_id'] = $task_info['task_id'];

       $filename= "";

       if (isset($_FILES['task_file']['name']) && $_FILES['task_file']['name'] != "") {
						
						$templates_folder_path = './assets/scheduling/template_task_uploads/files';
						$templates_folder_path_main = './assets/scheduling/template_task_uploads/files/';

						$thumb = $templates_folder_path_main . 'thumb';

						$config['upload_path'] = $templates_folder_path;
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
							
							create_optimize($filename, $full_path, $templates_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
                            
							
						}
					}
    $ins_array = array(
                   "item_id" => $item_id,
                   "template_id" => $template_id,
                   "file" => $filename,
                   "file_original_name" => $_FILES['task_file']['name'],
                 );
    $this->mod_common->insert_into_table("project_scheduling_template_item_files", $ins_array);
    $this->load->view("scheduling/templates/files", $data);

    }

    public function remove_file(){

     $id = $this->input->post("id");

     $table = "project_scheduling_template_item_files";
     $where = "`id` ='" . $id . "'";

     $file_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);

     $file_name="./assets/scheduling/template_task_uploads/files/".$file_info['file'];

     if(file_exists($file_name)){
	unlink($file_name);
     }
     
     $data['item_id'] = $file_info['item_id'];
     $data['template_id'] = $file_info['template_id'];

     $task_info = $this->mod_common->select_single_records("project_scheduling_template_items", "`id` ='" . $file_info['item_id'] . "'");
     $data['task_id'] = $task_info['task_id'];

     $this->load->view("scheduling/templates/files", $data);
     
    }

    //Upload Task Image

    public function upload_image(){

       $item_id = $this->input->post("image_item_id");
       $template_id = $this->input->post("image_template_id");
       $description = $this->input->post("image_description");

       $data['item_id'] = $item_id;
       $data['template_id'] = $template_id;

       $task_info = $this->mod_common->select_single_records("project_scheduling_template_items", "`id` ='" . $item_id . "'");
       $data['task_id'] = $task_info['task_id'];

       $filename= "";

       if (isset($_FILES['task_image']['name']) && $_FILES['task_image']['name'] != "") {
						
						$templates_folder_path = './assets/scheduling/template_task_uploads/images';
						$templates_folder_path_main = './assets/scheduling/template_task_uploads/images/';

						$thumb = $templates_folder_path_main . 'thumb';

						$config['upload_path'] = $templates_folder_path;
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
							
							create_optimize($filename, $full_path, $templates_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
                            
							
						}
					}
    $ins_array = array(
                   "item_id" => $item_id,
                   "template_id" => $template_id,
                   "file" => $filename,
                   "description" => $description,
                   "file_type" => 1,
                   "file_original_name" => $_FILES['task_image']['name'],
                 );
    $this->mod_common->insert_into_table("project_scheduling_template_item_files", $ins_array);
    $this->load->view("scheduling/templates/images", $data);

    }

    public function remove_image(){

     $id = $this->input->post("id");

     $table = "project_scheduling_template_item_files";
     $where = "`id` ='" . $id . "'";

     $file_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);

     $file_name="./assets/scheduling/template_task_uploads/images/".$file_info['file'];

     if(file_exists($file_name)){
	unlink($file_name);
     }
     
     $data['item_id'] = $file_info['item_id'];
     $data['template_id'] = $file_info['template_id'];

     $task_info = $this->mod_common->select_single_records("project_scheduling_template_items", "`id` ='" . $file_info['item_id'] . "'");
     $data['task_id'] = $task_info['task_id'];

     $this->load->view("scheduling/templates/images", $data);
     
    }

    public function add_new_reminder(){
      $table = "project_scheduling_template_item_reminders";

			$item_id = $this->input->post('reminder_item_id');
                        $task_id = $this->input->post('reminder_task_id');
                        $template_id = $this->input->post('reminder_template_id');
                        $data['item_id'] = $item_id;
                        $data['template_id'] = $template_id;	
                        $to_id = $this->input->post('to_id');
                        $date = DateTime::createFromFormat('d/m/Y', $this->input->post('date'));
                        $date = $date->format('Y-m-d');	
			$message = $this->input->post('message');

                        $reminder_type = $this->input->post('reminder_type');
                        $remindertype = $this->input->post('remindertype');
                        $no_of_days = $this->input->post('no_of_days');

                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        $company_id = $this->session->userdata("company_id");

                        if($reminder_type == "1"){
                           $to_email = $this->input->post('to_email');
                           $ins_array = array(
                                "email"=>$to_email,
                				"task_id"=>$task_id,
                				"created_by" => $created_by,
                                "ip_address" => $ip_address,
                                "company_id" => $company_id,
                                "status" => 1
			   );
					
		           $this->mod_common->insert_into_table("project_scheduling_reminder_users", $ins_array);
                           $to_id = $this->db->insert_id();

                        }
 
                        $ins_array = array(
                                "item_id" => $item_id,
                				"template_id" => $template_id,
                				"to_id" => $to_id,
                                "reminder_type" => $remindertype,
                                "no_of_days" => $no_of_days,
                                "date " => $date,
			                 	"message" => $message
			);
					
		        $add_new_reminder = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_reminder) {

                              $id = $item_id;
                              $table = "project_scheduling_template_items";
                              $where = "`id` ='" . $id . "'";
                              $reminder_info = $this->mod_common->select_single_records($table, $where);
                              $data['task_id'] = $reminder_info['task_id'];
                              $data['reminder_date'] = $date;

                              $this->load->view("scheduling/templates/reminders", $data);
                        }

    }

    public function remove_reminder(){

     $id = $this->input->post("id");

     $table = "project_scheduling_template_item_reminders";
     $where = "`id` ='" . $id . "'";

     $reminder_info = $this->mod_common->select_single_records($table, $where);
		
     $this->mod_common->delete_record($table, $where);
     
     $data['item_id'] = $reminder_info['item_id'];
     $data['template_id'] = $reminder_info['template_id'];

     $table = "project_scheduling_template_items";
     $where = "`id` ='" . $reminder_info['item_id'] . "'";
     $reminder_task_info = $this->mod_common->select_single_records($table, $where);
     $data['task_id'] = $reminder_task_info['task_id'];
     $data['reminder_date'] = $reminder_task_info['start_date'];

     $this->load->view("scheduling/templates/reminders", $data);
     
    }
    
    public function sort_item(){
      $id = $this->input->post("id");
      $priority = $this->input->post("priority");
      $table="project_scheduling_template_items";
      $where = array("id" => $id);
      $upd_array = array("priority" => $priority);
      $this->mod_common->update_table($table, $where, $upd_array);
    }

    public function sort_stages(){
        $stages = explode(",", $this->input->post("stages"));
        $template_id = $this->input->post("template_id");
        $table="project_scheduling_template_items";
        $j=1;
        for($i=0;$i<count($stages);$i++){
          if($stages[$i]!=""){
           $where = array("template_id" => $template_id, "stage_id" => $stages[$i]);
           $upd_array = array("stages_priority" => $j);
           $this->mod_common->update_table($table, $where, $upd_array);
           $j++;
          }
      }
    }

    public function verify_checklist() {

        $name = $this->input->post("name");
        
        $table = "project_scheduling_template_item_checklists";

        $item_id = $this->input->post("item_id");

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'item_id' => $item_id,
            'name' => $name
           );
        }
        else{
          $where = array(
            'name' => $name,
            'item_id' => $item_id
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    public function download_image($filename=""){
        if($filename==""){
            redirect("nopage");
        }
        $this->load->helper('download');
        /*make sure here $img2 contains full path of image file*/
        $data = file_get_contents(TEMPLATE_TASK_PATH.'images/'.$filename);
        force_download($filename, $data);
    }
    
    public function download_file($filename=""){
        if($filename==""){
            redirect("nopage");
        }
        $this->load->helper('download');
        /*make sure here $img2 contains full path of image file*/
        $data = file_get_contents(TEMPLATE_TASK_PATH.'files/'.$filename);
        force_download($filename, $data);
    }
    
   /* public function test(){
        $this->db1 = $this->load->database('wizard', true); 
        $items_query = $this->db1->query("SELECT t.* FROM wiz_tasks t INNER JOIN wiz_template_items i ON i.task_id = t.id GROUP BY i.task_id");
        $items_list = $items_query->result_array();
        
        foreach($items_list as $val){
            $where = array("name" => $val["name"]);
            $is_task_exist = $this->mod_common->select_single_records("project_scheduling_tasks", $where);
            if(count($is_task_exist)==0){
                $table = "scheduling_tasks";
					
			            $name = $val["name"];
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
					
		                $task_id = $this->mod_common->insert_into_table($table, $ins_array);
            }
            else{
                $task_id = $is_task_exist["id"];
            }
             $where = array("task_id" => $val["id"], "is_task_changed" => 0);
             $upd_array = array("task_id" => $task_id, "is_task_changed" => 1);
             $table = "project_scheduling_template_items";
             $this->mod_common->update_table($table, $where, $upd_array);
            
        }
    }
    public function test2(){
        $this->db1 = $this->load->database('wizard', true); 
        $items_query = $this->db1->query("SELECT s.* FROM wiz_stages s INNER JOIN wiz_template_items i ON i.stage_id = s.id GROUP BY i.stage_id");
        $items_list = $items_query->result_array();
        foreach($items_list as $val){
            $where = array("stage_name" => $val["name"]);
            $is_stage_exist = $this->mod_common->select_single_records("project_stages", $where);
            if(count($is_stage_exist)==0){
            $table = "stages";
					
			$name = $val["name"];
			$description = $val["description"];
			$stage_status = $val["status"];
            $created_by = $this->session->userdata("user_id");
            $user_id = $this->session->userdata("user_id");
            $company_id = $this->session->userdata("company_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
            				"stage_name" => $name,
            				"stage_description" => $description,
            				"created_by" => $created_by,
            				"user_id" => $user_id,
            				"company_id" => $company_id,
                            "ip_address" => $ip_address,
            				"stage_status" => $stage_status
            			);
					
		        $stage_id = $this->mod_common->insert_into_table($table, $ins_array);
            }
            else{
                $stage_id = $is_stage_exist["stage_id"];
            }
            
             $where = array("stage_id" => $val["id"], "is_stage_changed" => 0);
             $upd_array = array("stage_id" => $stage_id, "is_stage_changed" => 1);
             $table = "project_scheduling_template_items";
             $this->mod_common->update_table($table, $where, $upd_array);
             
            
        }
    }*/
    
    
    public function import_template_from_project(){
      $import_project_id = $this->input->post("import_project_id");
      $template_id = $this->input->post("template_id");

     //Template Info 
  
     $table = "project_scheduling_templates";
     $where = "`id` ='" . $template_id . "'";

     $template_info = $this->mod_common->select_single_records($table, $where);

      //items
      $items = $this->mod_common->get_all_records("project_scheduling_items","*",0,0,array("project_id"=>$import_project_id));
      
      foreach($items as $item){
            $table = "project_scheduling_template_items";

			$priority_info = $this->mod_common->select_single_records($table, array("stage_id"=>$item['stage_id'],"template_id"=>$template_id), "MAX(priority) as priority");
		
			            $stage_id = $item['stage_id'];
                        $task_id = $item['task_id'];
                        $checklist = $item['checklist'];
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "stage_id" => $stage_id,
                                "task_id" => $task_id,
                                "checklist" => $checklist,
                                "status" => 0,
                                "priority" => $priority_info["priority"]+1,
                                "stages_priority" => $item['stages_priority']
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      $item_id = $this->db->insert_id();

      //item checklist 

      $item_checklists = $this->mod_common->get_all_records("project_scheduling_item_checklists","*",0,0,array("project_id"=>$import_project_id, "item_id"=>$item['id']));
      foreach($item_checklists as $val){
                        $table = "project_scheduling_template_item_checklists";
					
			            $item_id = $item_id;
                        $name = $val['name'];
                       
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "item_id" => $item_id,
                                "name"   => $name,
                                "user_id" => $this->session->userdata("user_id")
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 


      //item notes 

      $item_notes = $this->mod_common->get_all_records("project_scheduling_item_notes","*",0,0,array("project_id"=>$import_project_id, "item_id"=>$item['id']));
      foreach($item_notes as $val){
                        $table = "project_scheduling_template_item_notes";
					
			$item_id = $item_id;
                        $author = $val['author'];
                        $date = $val['date'];
                        $note = $val['note'];
                        $privacy_settings = $val['privacy_settings'];
                       
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "item_id" => $item_id,
                                "author" => $author,
                                "date" => $date,
                                "note"   => $note,
                                "user_id" => $this->session->userdata("user_id"),
                                "privacy_settings" => $privacy_settings
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 

    }//end of item foreach 
}

    public function import_template_from_template(){
      $import_template_id = $this->input->post("import_template_id");
      $template_id = $this->input->post("template_id");

     //Template Info 
  
     $table = "project_scheduling_templates";
     $where = "`id` ='" . $template_id . "'";

     $template_info = $this->mod_common->select_single_records($table, $where);

      //items
      $items = $this->mod_common->get_all_records("project_scheduling_template_items","*",0,0,array("template_id"=>$import_template_id));
      
      foreach($items as $item){
            $table = "project_scheduling_template_items";

			$priority_info = $this->mod_common->select_single_records($table, array("stage_id"=>$item['stage_id'],"template_id"=>$template_id), "MAX(priority) as priority");
		
			            $stage_id = $item['stage_id'];
                        $task_id = $item['task_id'];
                        $checklist = $item['checklist'];
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "stage_id" => $stage_id,
                                "task_id" => $task_id,
                                "checklist" => $checklist,
                                "status" => 0,
                                "priority" => $priority_info["priority"]+1,
                                "stages_priority" => $item['stages_priority']
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      $item_id = $this->db->insert_id();

      //item checklist 

      $item_checklists = $this->mod_common->get_all_records("project_scheduling_template_item_checklists","*",0,0,array("template_id"=>$import_template_id, "item_id"=>$item['id']));
      foreach($item_checklists as $val){
                        $table = "project_scheduling_template_item_checklists";
					
			            $item_id = $item_id;
                        $name = $val['name'];
                       
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "item_id" => $item_id,
                                "name"   => $name,
                                "user_id" => $this->session->userdata("user_id")
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 


      //item notes 

      $item_notes = $this->mod_common->get_all_records("project_scheduling_template_item_notes","*",0,0,array("template_id"=>$import_template_id, "item_id"=>$item['id']));
      foreach($item_notes as $val){
                        $table = "project_scheduling_template_item_notes";
					
			$item_id = $item_id;
                        $author = $val['author'];
                        $date = $val['date'];
                        $note = $val['note'];
                        $privacy_settings = $val['privacy_settings'];
                       
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "item_id" => $item_id,
                                "author" => $author,
                                "date" => $date,
                                "note"   => $note,
                                "user_id" => $this->session->userdata("user_id"),
                                "privacy_settings" => $privacy_settings
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 

    }//end of item foreach 
}

    public function import_template_from_supplierz_buildz_template(){
      $import_template_id = $this->input->post("import_template_id");
      $template_id = $this->input->post("template_id");

     //Template Info 
  
     $table = "project_scheduling_templates";
     $where = "`id` ='" . $template_id . "'";

     $template_info = $this->mod_common->select_single_records($table, $where);

      //items
      $items = $this->mod_common->get_all_records("project_buildz_template_items","*",0,0,array("template_id"=>$import_template_id));
      
      foreach($items as $item){
            $table = "project_scheduling_template_items";

			$priority_info = $this->mod_common->select_single_records($table, array("stage_id"=>$item['stage_id'],"template_id"=>$template_id), "MAX(priority) as priority");
		
			            $stage_id = $item['stage_id'];
                        $task_id = $item['task_id'];
                        $checklist = $item['checklist'];
                        $created_by = $this->session->userdata("user_id");
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "stage_id" => $stage_id,
                                "task_id" => $task_id,
                                "checklist" => $checklist,
                                "status" => 0,
                                "priority" => $priority_info["priority"]+1,
                                "stages_priority" => $item['stages_priority']
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      $item_id = $this->db->insert_id();

      //item checklist 

      $item_checklists = $this->mod_common->get_all_records("project_buildz_template_item_checklists","*",0,0,array("template_id"=>$import_template_id, "item_id"=>$item['id']));
      foreach($item_checklists as $val){
                        $table = "project_scheduling_template_item_checklists";
					
			            $item_id = $item_id;
                        $name = $val['name'];
                       
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "item_id" => $item_id,
                                "name"   => $name,
                                "user_id" => $this->session->userdata("user_id")
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 


      //item notes 

      $item_notes = $this->mod_common->get_all_records("project_buildz_template_item_notes","*",0,0,array("template_id"=>$import_template_id, "item_id"=>$item['id']));
      foreach($item_notes as $val){
                        $table = "project_scheduling_template_item_notes";
					
			$item_id = $item_id;
                        $author = $val['author'];
                        $date = $val['date'];
                        $note = $val['note'];
                        $privacy_settings = $val['privacy_settings'];
                       
                        
                        $ins_array = array(
                                "template_id"=>$template_id,
				                "item_id" => $item_id,
                                "author" => $author,
                                "date" => $date,
                                "note"   => $note,
                                "user_id" => $this->session->userdata("user_id"),
                                "privacy_settings" => $privacy_settings
			);

		       $this->mod_common->insert_into_table($table, $ins_array);

      }                 

    }//end of item foreach 
}


}
