<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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

             $this->stencil->layout('home_layout');

             $this->stencil->slice('home_header_script');
             $this->stencil->slice('home_header');
             $this->stencil->slice('home_features');
             $this->stencil->slice('home_teams');
             $this->stencil->slice('home_projects');
             $this->stencil->slice('home_pricing');
             $this->stencil->slice('home_contactus');
             $this->stencil->slice('home_testimonials');
             $this->stencil->slice('home_footer_script');
             $this->stencil->slice('home_footer');

             $this->load->model("mod_common");


    }
    
    //Home Screen
	public function index()
	{
	    redirect(SURL . 'nopage');
        $this->stencil->title("Project Software");
	    $this->stencil->paint('home/home');
	}
}
