<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_settings extends CI_Controller {

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
    
    //Payment Details Page
    
    function index(){
        
        $this->mod_common->is_company_page_accessible(164);
        
		$this->stencil->title('Payment Settings');
		
		$where 	= array("company_id" => $this->session->userdata('company_id'));
		$data['payment_settings'] 	= $this->mod_common->select_single_records('project_payment_details',$where);
		
		$this->stencil->paint('payment_settings/payment_details',$data);
		
    }
	
    //Update Payment Details
	public function update_payment_details()
	{
	    
		$this->mod_common->is_company_page_accessible(164);
		
		$card_number = $this->input->post('card_number');
		$expiry_month = $this->input->post('expiry_month');
		$expiry_year = $this->input->post('expiry_year');
		$cvc = $this->input->post('cvc');
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$created_by = $this->session->userdata("user_id");
		
	            $payment_array = array(
					'card_number'	=> $card_number,
					'expiry_month'=> $expiry_month,
					'expiry_year'	=> $expiry_year,
					'cvc'	=> $cvc,
					'company_id'	=> $this->session->userdata('company_id'),
					'created_by' => $created_by,
					'created_by_ip' => $ip_address
					);
					
		$where 	= 'company_id ="'. $this->session->userdata('company_id').'"';
		
		$data['payment_settings'] 	= $this->mod_common->select_single_records('project_payment_details',$where);
			
		if(count($data['payment_settings'])==0){			
		$id = $this->mod_common->insert_into_table('project_payment_details', $payment_array);
		}
		else{
		    $where 	= array('company_id' => $this->session->userdata('company_id'));
			$this->mod_common->update_table('project_payment_details', $where, $payment_array);
		}
		$this->session->set_flashdata("ok_message", "Payment Details Updated Successfully!");
								
		redirect(SURL."payment_settings");
						
	}
	
	

   //Delete Payment Details
    public function delete_payment() {
  
        $this->mod_common->is_company_page_accessible(164);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "project_payment_details";
        $where = "`id` ='" . $id . "'";
		
        $this->mod_common->delete_record($table, $where);

    }

}

