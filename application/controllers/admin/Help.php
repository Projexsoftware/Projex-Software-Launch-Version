<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {

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

             $this->stencil->layout('admin_default_layout');

             $this->stencil->slice('admin_header_script');
             $this->stencil->slice('admin_header');
             $this->stencil->slice('admin_sidebar');
             $this->stencil->slice('admin_footer_script');
             $this->stencil->slice('admin_footer');

             $this->load->model("admin/mod_common", "mod_common");

             $this->mod_common->verify_is_admin_login();

        }
	public function index()
	{
        $data['help'] = $this->mod_common->get_all_records("project_help_section","*");
        $this->stencil->title('Help');
	    $this->stencil->paint('admin/help/manage_help', $data);
	}

	public function add_help() {
        $this->stencil->title('Add Help Section');
        $this->stencil->paint('admin/help/add_new_help_section');
    }
	
	 public function add_new_help_section_process() {
		 
        $this->form_validation->set_rules('help_category', 'Help Category', 'required');
        if (!(isset($_FILES['file']['name'])) && $_FILES['file']['name'] == "") {
           $this->form_validation->set_rules('file', 'File', 'required'); 
        }
	    if ($this->form_validation->run() == FALSE)
			{
                $this->stencil->title('Add Help Section');
                $this->stencil->paint('admin/help/add_new_help_section');
			}
		else{
		    
		    	    $filename= "";

					if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
						
						$projects_folder_path = './assets/help_uploads/';
						$projects_folder_path_main = './assets/help_uploads/';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'pdf|PDF';
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
						}
					}
			$table = "project_help_section";

			$help_category = $this->input->post('help_category');		
			$status = $this->input->post('status');
            $created_by = $this->session->userdata("admin_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
                        
            $ins_array = array(
                "help_category" => $help_category,
				"help_uploads" => $filename,
				"status" => $status,
				"created_by" => $created_by,
                "ip_address" => $ip_address,
				"status" => 1
			);
					
		   $add_new_help_section = $this->mod_common->insert_into_table($table, $ins_array);
           if ($add_new_help_section) {
				$this->session->set_flashdata('ok_message', 'New Help Section added successfully.');
				redirect(AURL . 'help');
			} else {
				$this->session->set_flashdata('err_message', 'New Help Section is not added. Something went wrong, please try again.');
				redirect(AURL . 'help');
			}
		}
    }
	
	public function edit_help($help_id) {

       
	    if($help_id=="" || !(is_numeric($help_id))){
            redirect("nopage");
        }
		
        $table = "project_help_section";
        $where = "`id` ='" . $help_id."'";

        $data['help_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['help_edit']) == 0) {
            redirect("nopage");
        } else {

            $this->stencil->title("Edit Help Section");

            $this->stencil->paint('admin/help/edit_help_section', $data);
        }
    }

    public function edit_help_section_process() {
		
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_help_section'))
            redirect(AURL);
            
            $help_id= $this->input->post('help_id');
            $status = $this->input->post('status');
			$filename = $this->input->post('old_file');
			$help_category = $this->input->post('help_category');
			$created_by = $this->session->userdata("admin_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
						
						$projects_folder_path = './assets/help_uploads/';
						$projects_folder_path_main = './assets/help_uploads/';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'pdf|PDF';
						$config['overwrite'] = false;
						$config['encrypt_name'] = false;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('file')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							$this->session->set_flashdata('err_message', $error_file_arr['error']);
				            redirect(AURL . 'help/edit_help/'.$help_id);
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
						}
					}

                        $upd_array = array(
					        "help_category" => $help_category,
					        "help_uploads" => $filename,
					        "status" => $status,
			                "created_by" => $created_by,
                            "ip_address" => $ip_address
			             );
                                                        
			$table = "project_help_section";
			$where = "`id` ='" . $help_id . "'";
			$update_help_section = $this->mod_common->update_table($table, $where, $upd_array);
			

			if ($update_help_section) {
				$this->session->set_flashdata('ok_message', 'Help Section updated successfully.');
				redirect(AURL . 'help');
			} else {
				$this->session->set_flashdata('err_message', 'Help Section is not updated. Something went wrong, please try again.');
				redirect(AURL . 'admin/help/edit_help/' . $checklist_id);
			}
    }
	
	public function delete_help() {
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
        $table = "project_help_section";
        $where = "`id` ='" . $id . "'";

        $help = $this->mod_common->select_single_records($table, $where);
        
        $file_name="./assets/help_uploads/".$help['help_uploads'];
    		if(file_exists($file_name)){
    			unlink($file_name);
    		}
        $this->mod_common->delete_record($table, $where);
    }
 
}
