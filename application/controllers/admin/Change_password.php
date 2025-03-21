<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends CI_Controller {

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
        $this->stencil->title('Change Password');
	    $this->stencil->paint('admin/change_password/change_password');
    }

        public function set_password() {
		
        if ($this->input->post("btnsubmitpass")) {
            $oldpassword = strip_quotes(md5($this->input->post("oldpassword")));

			//Get Admin Profile
			 $where = array(
            	'id' => $this->session->userdata('admin_id'),
       		 );
        	$data['user_data'] = $this->mod_common->select_single_records("project_admin_users", $where);
            if ($data['user_data'] ['password'] == $oldpassword) {

                if ($this->input->post("newpassword") != $this->input->post("renewpassword")) {
                    $this->session->set_flashdata('err_message', '- New password mismatched, please try again!.');
                    redirect(AURL . "change_password/set_password");
                }

                if ($this->input->post("newpassword") == $this->input->post("oldpassword")) {
                    $this->session->set_flashdata('err_message', '- You cannot set the current password again, please try different!.');
                    redirect(AURL . "change_password/set_password");
                }

                $update_array = array(
                    "password" => strip_quotes(md5($this->input->post("newpassword"))),
                );
                $where = array(
                    "id" => $this->session->userdata('admin_id'),
                );
                $table = "project_admin_users";
                $updatesetting = $this->mod_common->update_table($table,  $where,$update_array);
				 
                if ($updatesetting) {
                    $this->session->set_flashdata('ok_message', '- Password changed successfully.');
                    redirect(AURL . "change_password/set_password");
                } else {
                    $this->session->set_flashdata('err_message', '- Error in updating please try again!.');
                    redirect(AURL . "change_password/set_password");
                }
                exit;
            } else {
                $this->session->set_flashdata('err_message', '- Old password is incorrect, please try again!.');
                redirect(AURL . "change_password/set_password");
            }
        }
     
        $this->stencil->title('Change Password');
        $this->stencil->paint('change_password/change_password');	

       }
       public function verify_password() {

        $password = $this->input->post("password");
        
        $table = "project_admin_users";

        $id = $this->session->userdata("admin_id");

        if($id!=""){
           $where = array(
            'id =' => $id,
            'password' => md5($password),
          );
        }
        else{
          $where = array(
            'password' => $password,
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (!(empty($data['row']))) {
            echo "0";
        } else {
            echo "1";
        }
    }
     

}
