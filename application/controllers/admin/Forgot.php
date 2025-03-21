<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot extends CI_Controller {

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
         $this->stencil->title('Reset Password');
	     $this->stencil->paint('admin/forgot/forgot');
	}

        public function reset_password(){
		    
                 $email = $this->input->post("email");
                 if($email==""){
                   $this->session->set_flashdata('err_message', 'Please enter Email');
		           redirect(AURL . 'forgot');
                 }
		 $table = "project_admin_users";
                 $where = "`email` ='" . $email."'";

                 $data['user'] = $this->mod_common->select_single_records($table, $where);
			
		 if(count($data['user'])>0){
			    
		 $newpassword = random_password_generator();
                
                 $update_array = array(
                    "password" => md5($newpassword),
                 );
                
                 $where = array(
                    "id" => $data['user']['id'],
                 );
    
                $table = "project_admin_users";
                $resetpassword = $this->mod_common->update_table($table, $where, $update_array);
            
		if($resetpassword){

                   $data['password'] = $newpassword;
                   $data['firstname'] = $data['user']['first_name'];

		   $message = $this->load->view("email_templates/admin_forgot_template", $data, TRUE); 
		   
                   $subject = "Your Project Software Password";
                   
                   /*$this->load->library('email');

                   $config['charset'] = 'utf-8';
                   $config['wordwrap'] = TRUE;
                   $config['mailtype'] = 'html';
                   $this->email->initialize($config);*/
                   
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

		   if($this->email->send()){
				$this->session->set_flashdata('ok_message', 'Your password has been reset and an email has been sent to you.');
				redirect(AURL . 'forgot');	 
			     }
		   else{
			 $this->session->set_flashdata('err_message', 'Something went wrong try again later!');
			 redirect(AURL . 'forgot');				 
			}
		}
		else{
                      $this->session->set_flashdata('err_message', 'Something went wrong try again later!');
		      redirect(AURL . 'forgot');
					
		  }
	   }
			else{
				
			$this->session->set_flashdata('err_message', 'This account is not registered with us, please try again!');
		        redirect(AURL . 'forgot');
				}
		}

    public function verify_email() {

        $email = $this->input->post("email");
        
        $table = "project_admin_users";
        
          $where = array(
            'email' => $email,
            'status' => 1,
          );
        

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (!(empty($data['row']))) {
            echo "0";
        } else {
            echo "1";
        }
    }
     
}
