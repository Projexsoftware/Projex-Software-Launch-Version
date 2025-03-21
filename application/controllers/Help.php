<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {

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
    
    //Help Screen
    public function index()
	{
	    $this->stencil->title('Help');
	    $this->stencil->paint('help/help_section');
	}
	
	public function view_help_section($category){
	    $data['help_section'] = $this->mod_common->get_all_records('project_help_section', "*", 0, 0, array("status"=>1, "help_category" => str_replace("-", " ", $category)));
        $this->stencil->title('View Help Details');
	    $this->stencil->paint('help/view_help_section', $data);
	}
}
