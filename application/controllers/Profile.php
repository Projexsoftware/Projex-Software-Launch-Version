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

            $this->stencil->layout('default_layout');

             $this->stencil->slice('header_script');
             $this->stencil->slice('header');
             $this->stencil->slice('sidebar');
             $this->stencil->slice('footer_script');
             $this->stencil->slice('footer');

             $this->load->model("mod_common");

             $this->mod_common->verify_is_user_login();

        }
        
    //User Profile Setting Page
	public function index()
	{
            $id = $this->session->userdata("user_id");
            $table = "project_users";
            $where = "`user_id` ='" . $id."'";
            $data['profile'] = $this->mod_common->select_single_records($table, $where);
            $this->stencil->title('My Profile');
	        $this->stencil->paint('profile/profile', $data);
    }

    //Update User Profile
    public function update_profile() {
		

		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$company_id = $this->session->userdata("company_id");
					
		if($this->session->userdata('user_id')==$company_id){ 
    		$this->form_validation->set_rules('com_name', 'Company Name', 'required');
    		$this->form_validation->set_rules('com_street_address', 'Company Street Address', 'required');
    		$this->form_validation->set_rules('com_postal_address', 'Company Postal Address', 'required');
    		$this->form_validation->set_rules('com_email', 'Company Email', 'required');
    		$this->form_validation->set_rules('com_gst_number', 'Company GST Number', 'required');
    		$this->form_validation->set_rules('com_tax', 'Company Tax', 'required');
		}
        $id = $this->session->userdata("user_id");
        if($id!=""){
        $table = "project_users";
		$where = "`user_id` ='" . $id."'";

		$data['profile'] = $data['user_edit'] = $this->mod_common->select_single_records($table, $where);
		

		if ($this->form_validation->run() == FALSE)
			{
		           $this->stencil->title("My Profile");
                   $this->stencil->paint('profile/profile', $data);
			}
			else{

				$table = "users";
					
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
                $email = $this->input->post('email');
                $com_name = $this->input->post('com_name');
                $com_email = $this->input->post('com_email');
                $com_street_address = $this->input->post('com_street_address');
                $com_postal_address = $this->input->post('com_postal_address');
                $com_website = $this->input->post('com_website');
                $com_gst_number = $this->input->post('com_gst_number');
                $com_phone_no = $this->input->post('com_phone_no');
                $com_tax = $this->input->post('com_tax');
                                        
				$user_img= "project_avatar.png";

				if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
						
						$projects_folder_path = './assets/profile_images/';
						$projects_folder_path_main = './assets/profile_images/';

						$thumb = $projects_folder_path_main . 'thumbnail';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|JPG|JPEG|GIF|TIFF|TIF|PNG';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('profile_image')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							
							$this->session->set_flashdata('err_message', $error_file_arr['error']);
							redirect(SURL . 'profile');
							
						} else {
                            if($data['user_edit']['user_img']!="project_avatar.png"){		
                    				$ext_file_name="./assets/profile_images/".$data['user_edit']['user_img'];
                    				if(file_exists($ext_file_name)){
                    					unlink($ext_file_name);
                    				}
            						$thumb_file_name="./assets/profile_images/thumbnail/".$data['user_edit']['user_img'];
            						if(file_exists($thumb_file_name)){
            							unlink($thumb_file_name);
            						}
            				}
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $user_img = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
					}
					else{
					    if($this->input->post('old_image')!=""){
						$user_img = $this->input->post('old_image');
					    }
					}
					
					//Company Logo
					
					$com_logo= "";

				if (isset($_FILES['com_logo']['name']) && $_FILES['com_logo']['name'] != "") {
						
						$projects_folder_path = './assets/company/';
						$projects_folder_path_main = './assets/company/';

						$thumb = $projects_folder_path_main . 'thumbnail';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|JPG|JPEG|GIF|TIFF|TIF|PNG';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('com_logo')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							$this->session->set_flashdata('err_message', $error_file_arr['error']);
							redirect(SURL . 'profile');
							
						} else {
						    if($data['user_edit']['com_logo']!="homeworx_logo.png"){
                    				$ext_file_name="./assets/company/".$data['user_edit']['com_logo'];
                    				if(file_exists($ext_file_name)){
                    					unlink($ext_file_name);
                    				}
            						$thumb_file_name="./assets/company/thumbnail/".$data['user_edit']['com_logo'];
            						if(file_exists($thumb_file_name)){
            							unlink($thumb_file_name);
            						}
            				}
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $com_logo = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
					}
					else{
						$com_logo = $this->input->post('old_com_logo');
					}
					
						if($this->session->userdata('user_id')==$company_id){ 
                            $upd_array = array(
								"user_fname" => $first_name,
						        "user_lname" => $last_name,
						        "user_img" => $user_img,
						        "com_logo" => $com_logo,
                                "com_name" => $com_name,
                                "com_street_address" => $com_street_address,
                                "com_postal_address" => $com_postal_address,
                                "com_website" => $com_website,
						        "com_email" => $com_email,
						        "com_gst_number" => $com_gst_number,
						        "com_phone_no" => $com_phone_no,
						        "com_tax" => $com_tax
							);
							
							$subUsersUpdateArray = array(
						        "com_logo" => $com_logo,
                                "com_name" => $com_name,
                                "com_street_address" => $com_street_address,
                                "com_postal_address" => $com_postal_address,
                                "com_website" => $com_website,
						        "com_email" => $com_email,
						        "com_gst_number" => $com_gst_number,
						        "com_phone_no" => $com_phone_no,
						        "com_tax" => $com_tax
							);
							$table = "users";
							$where = "`company_id` ='" . $id . "'";
							$update_sub_users = $this->mod_common->update_table($table, $where, $subUsersUpdateArray);
						}
						else{
						    $upd_array = array(
								"user_fname" => $first_name,
						        "user_lname" => $last_name,
						        "user_img" => $user_img
							);
						}
                                                        
							
							$table = "users";
							$where = "`user_id` ='" . $id . "'";
							$update_user = $this->mod_common->update_table($table, $where, $upd_array);
							
							
							if ($update_user) {
					            $query = $this->db->query("SELECT u.*, r.role_title, r.permissions FROM project_users u INNER JOIN project_roles r ON r.id = u.role_id WHERE user_id =".$this->session->userdata('user_id')." AND com_email!=''");
							    $chk_isvalid_user = $query->row_array();
							    if(count($chk_isvalid_user)>0){
    							    $login_sess_array = array(
                                        'logged_in' => true,
                                        'user_id' => $chk_isvalid_user['user_id'],
                                        'user_role_id' => $chk_isvalid_user['role_id'],
                                        'firstname' => $chk_isvalid_user['user_fname'],
                                        'lastname' => $chk_isvalid_user['user_lname'],
                                        'company_name' => $chk_isvalid_user['com_name'],
                                        'email' => $chk_isvalid_user['user_email'],
                                        'last_signin' => $chk_isvalid_user['last_signin'],
                                        'signing_ip' => $chk_isvalid_user['signing_ip'],
                                        'avatar' => $chk_isvalid_user['user_img'],
                                        'parent_id' => $chk_isvalid_user['company_id'],
                    		            'permissions'=>explode(";",$chk_isvalid_user['permissions'])
                                    );
                                    $this->session->set_userdata($login_sess_array);
							    }
								$this->session->set_flashdata('ok_message', 'Profile updated successfully!');
								$this->session->set_userdata("firstname", $first_name);
								$this->session->set_userdata("lastname", $last_name);
								$this->session->set_userdata("avatar", $user_img);
								redirect(SURL . 'profile');
							} else {
								$this->session->set_flashdata('err_message', 'Error in updating Profile please try again!');
								redirect(SURL . 'profile');
							}
					
			}
      }
      else{
           redirect("nopage");
      }
    }
     

}
