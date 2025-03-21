<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

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

    //Logout User    
	public function index()
	{
	     
        $sess_items = array(
             'logged_in' => false,
             'user_id' => '',
             'user_role_id' => '',
             'firstname' => '',
             'lastname' => '',
             'email' => '',
             'parent_id' => '',
             'last_signin' => '',
             'signing_ip' => '',
             'avatar' => '',
             'permissions' => ''
        );
        $this->session->unset_userdata($sess_items);
        $this->session->sess_destroy();
        
        redirect(SURL."login");
	}

}
