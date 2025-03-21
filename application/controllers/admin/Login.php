<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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

            $this->stencil->layout('admin_login_layout');
			
            $this->stencil->slice('admin_header_script');
            $this->stencil->slice('admin_header');
            $this->stencil->slice('admin_login_footer_script');
            $this->stencil->slice('admin_footer');

            $this->load->model("admin/mod_login", "mod_login");
            $this->load->model("admin/mod_common", "mod_common");

        }
	public function index()
	{
         $this->stencil->title('Admin Login');
	     $this->stencil->paint('admin/login/login');
	}

        public function validate_admin() {

        if (!$this->input->post()){
        redirect(AURL . "login");
        }
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        if ($email == "" || $password == "") {

            $this->session->set_flashdata('err_message', '- Email or Password is empty. Please try again!');
            redirect(AURL . "login");

        } 
        else {
            
            $chk_isvalid_user = $this->mod_login->validate_credentials($email, $password);
           
            if ($chk_isvalid_user) {
                
                if($chk_isvalid_user["status"]==0){
                   $this->session->set_flashdata('err_message', 'Please activate your account!');
                   redirect(AURL . 'login');
                }
                
                if($this->input->post('remember')=="1") {
				
				setcookie('admin_remember_me', $this->input->post('email'), time() + 3600 * 24 * 365, "/");
				setcookie('admin_remember_me_pass', $this->input->post('password'), time() + 3600 * 24 * 365, "/");
			
				}
				else {
					if(isset($_COOKIE['admin_remember_me'])) {
						$past = time() - 3600;
						setcookie('admin_remember_me','', $past, "/");
						setcookie('admin_remember_me_pass','', $past, "/");
					}
				}
                $login_sess_array = array(
                    'admin_logged_in' => true,
                    'admin_id' => $chk_isvalid_user['id'],
                    'admin_role_id' => $chk_isvalid_user['role_id'],
                    'admin_firstname' => $chk_isvalid_user['first_name'],
                    'admin_lastname' => $chk_isvalid_user['last_name'],
                    'admin_email' => $chk_isvalid_user['email'],
                    'admin_last_signin' => $chk_isvalid_user['last_signin'],
                    'admin_signing_ip' => $chk_isvalid_user['signing_ip'],
                    'admin_avatar' => $chk_isvalid_user['profile_image'],
		            'admin_permissions'=>explode(";",$chk_isvalid_user['permissions'])
                );
                
                $this->session->set_userdata($login_sess_array);
                
                

                $ref_url = isset($_GET['url_ref'])?$_GET['url_ref']:""; 
                
                if($ref_url==""){
                redirect(AURL . 'dashboard');
                }else{
                    redirect($ref_url);
                }
            } else {

                $this->session->set_flashdata('err_message', 'Invalid Email or Password. Please try again!');
                redirect(AURL . 'login');
            }//end if($chk_isvalid_user) 
        }
    }

    public function activate() {
         $url =  explode("-",$this->uri->segment(4));
         if(count($url)==0){
            redirect("nopage");
         }
         $id = $url[0];
         $password = $url[1];
         $is_already_activated = $this->mod_common->select_single_records("project_admin_users", array("id" => $id));
         if($is_already_activated['status']==0){
            $table = "project_admin_users";
	    $where = "`id` ='" . $id. "'";
            $upd_array = array("status" => 1);
	    $update_status = $this->mod_common->update_table($table, $where, $upd_array);
            $this->session->set_flashdata('ok_message', 'Account activated successfully!');
	    redirect(AURL . 'login');
         }
         else{
            
            $this->session->set_flashdata('err_message', 'You cannot activate your account again!');
            redirect(AURL . 'login');
         }

    }
}
