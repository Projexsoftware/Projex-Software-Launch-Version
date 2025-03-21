<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_and_conditions extends CI_Controller {

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
		     $this->load->model('mod_terms');

             $this->mod_common->verify_is_user_login();

    }
    
    //Manage Terms & Conditions
    function index()
	{		
		$this->stencil->title('Terms & Conditions');
	    $this->stencil->paint('terms_and_conditions/terms_and_conditions');
	}
	
	/*function index()
	{		
		$data['terms'] = $this->mod_terms->get_terms_and_condition();
		$this->stencil->title('Terms & Conditions');
	    $this->stencil->paint('terms_and_conditions/manage_terms_and_conditions', $data);
	}*/
    
    //Edit Terms & Condition Screen
	public function edit(){
		
		$data['terms'] = $this->mod_terms->get_terms_and_condition();
		#--------------- load view--------------#
		$this->stencil->title('Edit Terms & Conditions');
	    $this->stencil->paint('terms_and_conditions/edit_terms_and_conditions', $data);
		
	}
	
	//Update Terms & Conditions
	public function update()
	{
		if($this->input->post('term_id')){
			$this->mod_terms->update_terms_and_condition();
		}else{
			$this->mod_terms->add_terms_and_condition();
		}
		
		 redirect(SURL . 'terms_and_conditions');
	
	}
}