<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NoPage extends CI_Controller {

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

             $this->stencil->slice('admin_header_script');
             $this->stencil->slice('admin_header_top');
             $this->stencil->slice('admin_header_navigation');
             $this->stencil->slice('admin_sidebar');
             $this->stencil->slice('admin_footer_script');
             $this->stencil->slice('admin_footer');

             $this->load->model("mod_common");

             //$this->mod_common->verify_is_admin_login();

        }
	public function index()
	{
	     $this->load->view('nopage');
	}
}
