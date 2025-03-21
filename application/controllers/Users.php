<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
             $this->mod_common->is_company_page_accessible(88);

        }
        
    //Manage Users
	public function index()
	{
	    $this->mod_common->is_company_page_accessible(89);
        $table="users";
        $data['users'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id')), "user_id");
        $this->stencil->title('Users');
	    $this->stencil->paint('users/manage_users', $data);
	}
    
    //Add New User
    public function add_user()
	{   
            $this->mod_common->is_company_page_accessible(90);
            
		    $table="roles";
            $data['roles'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id'), "status" => 1));
	       $this->stencil->title('Add User');	
             if ($this->input->post("add_new_user")) {
			    
		        $this->form_validation->set_rules('first_name', 'First Name', 'required');
		        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
				$this->form_validation->set_rules('role_id', 'Role', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.user_email]');

				
			    if ($this->form_validation->run() == FALSE)
				{
				   $this->stencil->title("Add User");
                   $this->stencil->paint('users/add_user', $data);
				}
				else{

					$table = "users";
					
					$first_name = $this->input->post('first_name');
					$last_name = $this->input->post('last_name');
					$email = $this->input->post('email');
					$role_id = $this->input->post('role_id');
					$created_by = $this->session->userdata("user_id");
                    $ip_address = $_SERVER['REMOTE_ADDR'];
					$password = random_password_generator();

					$filename= "project_avatar.png";

					if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
						
						$projects_folder_path = './assets/profile_images/';
						$projects_folder_path_main = './assets/profile_images/';

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
                        "ip_address" => $ip_address
					);
					
		            $add_user = $this->mod_common->insert_into_table($table, $ins_array);
					
					if ($add_user) {

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
						$this->session->set_flashdata('ok_message', 'User added successfully!');
						redirect(SURL . 'users');
					} else {
						
						$this->session->set_flashdata('err_message', 'Error in adding User please try again!');
						redirect(SURL . "users/add_user");
					}
				}
        }

        else{
	        $this->stencil->title("Add User");
            $this->stencil->paint('users/add_user', $data);
	    }
	     
	}
    
    //Edit User Screen
    public function edit_user($id="") {
		
		$this->mod_common->is_company_page_accessible(89);

        if($id=="" || !(is_numeric($id))){
          redirect("nopage");
        }

		$table="roles";
        $data['roles'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id'), "status" => 1));
			
        $table = "project_users";
        $where = "`user_id` ='" . $id."'";

        $data['user_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['user_edit']) == 0) {
            redirect("nopage");
        } else {
            $this->stencil->title("Edit User");

            $this->stencil->paint('users/edit_user', $data);
        }
    }

    //Update User
    public function update_user() {
      
		$this->mod_common->is_company_page_accessible(89);

		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('role_id', 'Role', 'required');
                
        $id = $this->input->post('user_id');
                if($id!=""){
                $table = "project_users";
		$where = "`user_id` ='" . $id."'";

		$data['user_edit'] = $this->mod_common->select_single_records($table, $where);
		
		$table="roles";
        $data['roles'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id'), "status" => 1));

                $original_value = $data['user_edit']['user_email'];
                if($this->input->post('email') != $original_value) {
                   $is_unique =  '|is_unique[users.user_email]';
                } else {
                   $is_unique =  '';
                }

                
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email'.$is_unique);

			if ($this->form_validation->run() == FALSE)
				{
				   $this->stencil->title("Edit User");
                   $this->stencil->paint('users/edit_user', $data);
				}
				else{

					$table = "users";
					
					$first_name = $this->input->post('first_name');
					$last_name = $this->input->post('last_name');
					$email = $this->input->post('email');
					$role_id = $this->input->post('role_id');
					$user_status = $this->input->post("user_status");
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                                        
					$filename= "";

					if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
						
						if($data['user_edit']['user_img']!="project_avatar.png"){
    						$ext_file_name="./assets/profile_images/".$data['user_edit']['user_img'];
    						if(file_exists($ext_file_name)){
    							unlink($ext_file_name);
    						}
    						$thumb_file_name="./assets/profile_images/thumb/".$data['user_edit']['user_img'];
    						if(file_exists($thumb_file_name)){
    							unlink($thumb_file_name);
    						}
						}
						$projects_folder_path = './assets/profile_images/';
						$projects_folder_path_main = './assets/profile_images/';

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
								"user_fname" => $first_name,
						        "user_lname" => $last_name,
                                "user_email" => $email,
						        "user_img" => $filename,
						        "role_id" => $role_id,
						        "user_status" => $user_status,
                                "ip_address" => $ip_address
							     );
							
							$table = "users";
							$where = "`user_id` ='" . $id . "'";
							$update_user = $this->mod_common->update_table($table, $where, $upd_array);
							
							if ($update_user) {
								$this->session->set_flashdata('ok_message', 'User updated successfully!');
								redirect(SURL . 'users');
							} else {
								$this->session->set_flashdata('err_message', 'Error in updating User please try again!');
								redirect(SURL . 'users/edit_user/' . $id);
							}
					
			}
      }
      else{
           redirect("nopage");
      }
    }

    //Delete User
    public function delete_user() {
		
    $this->mod_common->is_company_page_accessible(89);

        $id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
		$table = "users";
		$where = "`user_id` ='" . $id ."'";
			
		$data['user_edit'] = $this->mod_common->select_single_records($table, $where);

		if($data['user_edit']['user_img']!="project_avatar.png"){
    		$file_name="./assets/profile_images/".$data['user_edit']['user_img'];
    		if(file_exists($file_name)){
    			unlink($file_name);
    		}
    		$thumb_file_name="./assets/profile_images/thumb/".$data['user_edit']['user_img'];
    		if(file_exists($thumb_file_name)){
    			unlink($thumb_file_name);
    		}
		}
       
        $delete_user = $this->mod_common->delete_record($table, $where);

    }
    
    //Verify User Email
    public function verify_email() {

        $email = $this->input->post("email");
        
        $table = "project_users";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'user_id !=' => $id,
            'user_email' => $email,
          );
        }
        else{
          $where = array(
            'user_email' => $email,
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
}
