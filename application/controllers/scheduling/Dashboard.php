<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
             $this->load->model("mod_scheduling");

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(134);

        }
	public function index()
	{
	        $this->mod_common->is_company_page_accessible(152);
            $this->stencil->title('Dashboard');
            $data['projects'] = $this->mod_scheduling->get_all_dashboard_projects();
            $data['total_projects'] = count($this->mod_scheduling->get_dashboard_projects_count());
            $data['total_users'] = count($this->mod_common->get_all_records("users","*",0,0,array("company_id" => $this->session->userdata("company_id")), "user_id"));
            $data['total_stages'] = count($this->mod_common->get_all_records("stages","*", 0, 0, array("company_id" => $this->session->userdata("company_id")), "stage_id"));
            $data['activities'] = $this->mod_scheduling->get_all_activities();
            $this->stencil->paint('scheduling/dashboard/dashboard', $data);
	}
}
