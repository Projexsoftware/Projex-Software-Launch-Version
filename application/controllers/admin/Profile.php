<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
             $id = $this->session->userdata("admin_id");
             $table = "project_admin_users";
             $where = "`id` ='" . $id."'";
             $data['profile'] = $this->mod_common->select_single_records($table, $where);
             $this->stencil->title('My Profile');
	         $this->stencil->paint('admin/profile/profile', $data);
        }

        public function update_profile() {
		

		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $id = $this->session->userdata("admin_id");
                if($id!=""){
                $table = "project_admin_users";
		$where = "`id` ='" . $id."'";

		$data['profile'] = $this->mod_common->select_single_records($table, $where);
		

		if ($this->form_validation->run() == FALSE)
			{
		           $this->stencil->title("My Profile");
                   $this->stencil->paint('admin/profile/profile', $data);
			}
			else{

				$table = "project_admin_users";
					
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
                                $landline_no = $this->input->post('landline_no');
                                $mobile_no = $this->input->post('mobile_no');
                                $address = $this->input->post('address');
				$about_me= $this->input->post('about_me');
                                        
				$filename= "";

				if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
						
				if($data['profile']['profile_image']!="admin-project-software-avatar.jpg"){		
        				$ext_file_name="./assets/admin/profile_images/".$data['profile']['profile_image'];
        				if(file_exists($ext_file_name)){
        					unlink($ext_file_name);
        				}
						$thumb_file_name="./assets/admin/profile_images/thumb/".$data['user_edit']['profile_image'];
						if(file_exists($thumb_file_name)){
							unlink($thumb_file_name);
						}
				}
						
						$projects_folder_path = './assets/admin/profile_images/';
						$projects_folder_path_main = './assets/admin/profile_images/';

						$thumb = $projects_folder_path_main . 'thumb';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|JPG|JPEG|GIF|TIFF|TIF|PNG';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('profile_image')) {
							
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
                            								  "first_name" => $first_name,
                            						          "last_name" => $last_name,
                                                               "mobile_no" => $mobile_no,
                                                                "address" => $address,
                                                                "landline_no" => $landline_no,
                                                                "about_me" => $about_me,
						                                        "profile_image" => $filename
							     );
                                                        
							$this->session->set_userdata("admin_avatar", $filename);
							$this->session->set_userdata("admin_firstname", $first_name);
							$this->session->set_userdata("admin_lastname", $last_name);
							$table = "project_admin_users";
							$where = "`id` ='" . $id . "'";
							$update_user = $this->mod_common->update_table($table, $where, $upd_array);
							
							if ($update_user) {
								$this->session->set_flashdata('ok_message', 'Profile updated successfully!');
								redirect(AURL . 'profile');
							} else {
								$this->session->set_flashdata('err_message', 'Error in updating Profile please try again!');
								redirect(AURL . 'profile');
							}
					
			}
      }
      else{
           redirect(AURL."nopage");
      }
    }
     

}
