<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_transfers extends CI_Controller {

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
             $this->load->model("mod_project");

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(42);

    }
    
    //Manage Cash Transfers
    public function index()
	{
	    $this->mod_common->is_company_page_accessible(43);
	    
	    $data['cash_transfers'] = $this->mod_project->get_all_cash_transfers();
        
        $this->stencil->title('Cash Transfers');
	    $this->stencil->paint('cash_transfers/manage_cash_transfers', $data);
	}
	
	//Get Completed Job Cash Transfers
	function get_completed_job_cash_transfers()
	{
	   $this->mod_common->is_company_page_accessible(43);
	   $data['cash_transfers'] = $this->mod_project->get_all_cash_transfers(3);
       $this->load->view('cash_transfers/manage_cash_transfers_ajax', $data);
	}
	
	//Add Cash Transfer Screen
	function add_cash_transfer(){
	    $this->mod_common->is_company_page_accessible(44);
        $data['projects'] = $this->mod_project->get_active_project(); 
        
        $this->stencil->title('Add Cash Transfer');
	    $this->stencil->paint('cash_transfers/add_cash_transfer', $data);
	}
	
	//Add New Cash Transfer
	function insertcashtransfer(){
	    
        $costing_id = $this->mod_project->get_costing_id_from_project_id($this->input->post('project_id'));
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $data = array(
                'created_by' => $this->session->userdata('user_id'),
                'authorised_by' => $this->session->userdata('user_id'),
                'company_id' => $this->session->userdata('company_id'),
                'costing_id' => $costing_id["costing_id"],
                'project_id' => $this->input->post('project_id'),
                'supplier_id' => $this->input->post('supplier_id'),
                'transfer_amount' => $this->input->post('transfer_amount'),
                'comment' => $this->input->post('comment'),
                'ip_address' => $ip_address
                );
        $insert_cash_transfer = $this->mod_common->insert_into_table('project_cash_transfers', $data);
        $cash_transfer_id = $insert_cash_transfer;
                        
        $this->session->set_flashdata("ok_message", "Cash Transfer added successfully");
        redirect(SURL.'cash_transfers/view_cash_transfer/'. $cash_transfer_id);

        
	}
	
	//Update Cash Transfer
	function updatecashtransfers($cash_transfer_id){
	   
	    $where = array(
	        "id" => $cash_transfer_id
	        );
	       $costing_id = $this->mod_project->get_costing_id_from_project_id($this->input->post('project_id'));
	     $ip_address = $_SERVER['REMOTE_ADDR'];
	    $data = array(
                'created_by' => $this->session->userdata('user_id'),
                'authorised_by' => $this->session->userdata('user_id'),
                'costing_id' => $costing_id['costing_id'],
                'project_id' => $this->input->post('project_id'),
                'supplier_id' => $this->input->post('supplier_id'),
                'transfer_amount' => $this->input->post('transfer_amount'),
                'comment' => $this->input->post('comment'),
                'ip_address' => $ip_address
                    );
        $this->mod_common->update_table('project_cash_transfers', $where, $data);
        $data['cashtransfer_detail'] = $this->mod_common->select_single_records('cash_transfers', $where);
        $data['projects'] = $this->mod_project->get_active_project(); 
        $data['suppliers'] = $this->mod_project->get_costing_suppliers_by_costing_id($data['cashtransfer_detail']["id"]);
        
        $this->session->set_flashdata("ok_message", "Cash Transfer has been updated successfully");
    
        redirect(SURL."cash_transfers");
	}
	
	//View Cash Transfer Details
	function view_cash_transfer($cash_transfer_id){
	    $this->mod_common->is_company_page_accessible(43);
	    
        $where = array(
            "id" => $cash_transfer_id
            );
        $data['cashtransfer_detail'] = $this->mod_common->select_single_records('cash_transfers', $where);
        $data['projects'] = $this->mod_project->get_active_project(); 
        $data['suppliers'] = $this->mod_project->get_costing_suppliers_by_costing_id($data['cashtransfer_detail']['id']);
        
        $this->stencil->title('Cash Transfer Details');
	    $this->stencil->paint('cash_transfers/view_cash_transfer', $data);
	}
	
		//View Cash Transfer Details
	function view_cash_transfer_details($cash_transfer_id){
	    $this->mod_common->is_company_page_accessible(43);
	    
        $where = array(
            "id" => $cash_transfer_id
            );
        $data['cashtransfer_detail'] = $this->mod_common->select_single_records('cash_transfers', $where);
        $data['suppliers'] = $this->mod_project->get_costing_suppliers_by_costing_id($data['cashtransfer_detail']['id']);
        
        $this->stencil->title('Cash Transfer Details');
	    $this->stencil->paint('cash_transfers/view_cash_transfer_details', $data);
	}
}
