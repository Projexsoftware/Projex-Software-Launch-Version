<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_credits_notes extends CI_Controller {

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
             $this->load->model("mod_variation");
             $this->load->model('mod_saleinvoice');
             
             $this->load->library('xero');

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(30);

    }
    
    //Manage Sales Credit Notes
    public function index() {
        $xero_credentials = get_xero_credentials();
        if(count($xero_credentials)>0){
           $this->mod_common->is_company_page_accessible(36);
           $data['credit_notes'] = $this->mod_project->get_all_credit_notes("sales", 1);
           $this->stencil->title('Manage Sales Credits Notes');
	       $this->stencil->paint('sales_credits_notes/manage_sales_credits_notes', $data);
        }
        else{
             $this->session->set_flashdata('err_message', 'Sorry! You cannot perform this action');
             redirect(SURL.'dashboard');
        }
        
    }

    //Get Completed Job Sales Credit Notes
    public function get_completed_job_sales_credits_notes() {
        $xero_credentials = get_xero_credentials();
        if(count($xero_credentials)>0){
           $this->mod_common->is_company_page_accessible(36);
           $data['credit_notes'] = $this->mod_project->get_all_credit_notes("sales", 3);
           $this->load->view('sales_credits_notes/manage_sales_credits_notes_ajax', $data);
        }
        else{
             $this->session->set_flashdata('err_message', 'Sorry! You cannot perform this action');
             redirect(SURL.'dashboard');
        }
    }
    
    //View Sales Credit Notes Details
    public function viewsalescreditnote($credit_note_id) {
        $xero_credentials = get_xero_credentials();
        
        if(count($xero_credentials)==0){
             $this->session->set_flashdata('err_message', 'Sorry! You cannot perform this action');
             redirect(SURL.'dashboard');
        }
        $this->mod_common->is_company_page_accessible(37);
        
        $data['credit_note_detail'] = $this->mod_project->get_credit_note_detail_by_id($credit_note_id, "sales");

        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'status' => "APPROVED", 'xero_invoice_id !=' =>"", 'project_id' => $data['credit_note_detail']->project_id);
       
        $data['sales_invoices'] = $this->mod_common->get_all_records('project_sales_invoices', "*", 0, 0, $cwhere);

       
        $data['credit_note_items'] = $this->mod_project->getcredit_note_items_by_credit_note_id($credit_note_id, "sales");

        $data['projectinfo'] = $this->mod_project->get_project_info($data['credit_note_detail']->project_id);

        $this->stencil->title('View Sales Credits Notes');
	    $this->stencil->paint('sales_credits_notes/view_sales_credits_notes', $data);

    }
    
    //Update Sales Credit Notes
    public function updatecreditnote($credit_note_id) {
        $xero_credentials = get_xero_credentials();
        if(count($xero_credentials)==0){
             $this->session->set_flashdata('err_message', 'Sorry! You cannot perform this action');
             redirect(SURL.'dashboard');
        }
        $this->mod_common->is_company_page_accessible(37);
        
        $sales_invoice_id = $this->input->post("sales_invoice_id");
        
        if($this->input->post('status')!="Allocated"){
            $sales_invoice_id = 0;
        }
            
            //Xero Implementation                     
                   
                if($this->input->post('status')=='Approved' || $this->input->post('status')=='Allocated'){
                    
                    $date = explode("-", str_replace("/", "-", $this->input->post('date')));
                    
                    $date = $date[2]."-".$date[1]."-".$date[0];
                    
		            if($this->input->post('status')=='Allocated'){
		                
		                  $new_credit_note_arr = array(
                            'allocated_invoice_id' => $sales_invoice_id,
                            'status' => $this->input->post('status')
                           );
                           $where = array('id' =>$credit_note_id );
                           $this->mod_common->update_table('project_sales_credit_notes', $where, $new_credit_note_arr);
                         
                         $cwhere = array('id' => $sales_invoice_id);
                         $fields = '`xero_invoice_id`';
                         $sales_invoice_details = $this->mod_common->select_single_records('project_sales_credits_notes', $cwhere);
                         
                         $new_credit_note = array("Allocations" => array(
                                					"Amount" => $this->input->post('total'),
                                                    "Date" => $date,
                                                    "Invoice" => array(
                                					"InvoiceID" => $sales_invoice_details["xero_invoice_id"]
                                			    	)  
                                			    )
                                		);
                		 $cwhere = array('id' => $credit_note_id);
                         $fields = '`xero_creditnote_id`';
                         $credit_note_details = $this->mod_common->select_single_records('project_sales_credit_notes', $fields, $cwhere);
                         
                		 $xero_creditnote_id = $credit_note_details["xero_creditnote_id"];
                		
                		 $xero_credentials = get_xero_credentials();
                		 if(count($xero_credentials)>0){
                		     $credit_result = $this->xero->CreditNotes($new_credit_note, $xero_creditnote_id, "Allocations");
                		 }
		            }
                		     
                    }
                    

            $this->session->set_flashdata('ok_message', 'Credit Note updated succesfully');
            redirect(SURL.'sales_credits_notes/viewsalescreditnote/'.$credit_note_id);
    }
}