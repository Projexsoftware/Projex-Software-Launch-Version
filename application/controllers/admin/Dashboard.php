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
         $this->stencil->title('Dashboard');
         $data['total_companies'] = count($this->mod_common->get_all_records("project_users", "*", 0, 0, array("company_id" => 0, "user_status" => 1), "user_id"));
         $data['total_users'] = count($this->mod_common->get_all_records("project_admin_users", "*", 0, 0, array("created_by >" => 0, "status" => 1)));
         $data['total_templates'] = count($this->mod_common->get_all_records("project_admin_templates", "*", 0, 0, array("template_status" => 1), "template_id"));
	     $this->stencil->paint('admin/dashboard/dashboard', $data);
	}
}
