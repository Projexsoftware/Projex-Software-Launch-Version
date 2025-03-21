<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
             $this->load->model("mod_dashboard");
             $this->load->model("mod_project");
             $this->load->model("mod_reports");

             $this->mod_common->verify_is_user_login();

        }
    
    //Master Page
	public function index()
	{
             $this->stencil->title('Projex Software');
             $data['welcomeText'] = "Congratulations ".ucfirst($this->session->userdata('firstname'))."! Welcome to Projex Software.";
             $this->stencil->paint('master/master', $data);
	}
}
