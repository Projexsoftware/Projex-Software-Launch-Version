<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashflow extends CI_Controller {

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

             $this->stencil->layout('cashflow_layout');

             $this->stencil->slice('header_script');
             $this->stencil->slice('cashflow_header');
             $this->stencil->slice('footer_script');
             $this->stencil->slice('cashflow_footer');

             $this->load->model("mod_common");

        }
	public function index()
	{
        $this->stencil->title('Cash Flow');
	    $this->stencil->paint('cashflow/cashflow_form');
	}
	
	public function add_new_cashflow_process() {
	    
			$table = "cashflow";
					
			    $your_name = $this->input->post('your_name');
                $business_name = $this->input->post('business_name');  
                $email = $this->input->post('email');
                
                $total_cash_in_your_bank_account = $this->input->post('total_cash_in_your_bank_account');
                $current_overdraft_limit = $this->input->post('current_overdraft_limit');
                $value_of_employee_subsidy = $this->input->post('value_of_employee_subsidy');
                $wages_and_drawings_to_be_paid = $this->input->post('wages_and_drawings_to_be_paid');
                $other_costs_to_be_paid = $this->input->post('other_costs_to_be_paid');
                $tax_and_gst_to_be_paid = $this->input->post('tax_and_gst_to_be_paid');
                $any_revenue_expected = $this->input->post('any_revenue_expected');
                
                $project_name = $this->input->post('project_name');
                $project_contract_price = $this->input->post('project_contract_price');
                $value_of_contract_variations = $this->input->post('value_of_contract_variations');
                $total_value_of_sales_invoices_issued = $this->input->post('total_value_of_sales_invoices_issued');
                $total_value_of_outstanding_sales_invoices = $this->input->post('total_value_of_outstanding_sales_invoices');
                $project_contract_budget = $this->input->post('project_contract_budget');
                $value_of_extra_cost_due_to_variations = $this->input->post('value_of_extra_cost_due_to_variations');
                $total_bills_received_from_suppliers_and_subbies = $this->input->post('total_bills_received_from_suppliers_and_subbies');
                $total_value_of_unpaid_bill = $this->input->post('total_value_of_unpaid_bill');
                
                $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
				               "your_name" => $your_name,
                                "business_name" => $business_name,
                                "email" => $email,
                                "total_cash_in_your_bank_account"   => $total_cash_in_your_bank_account,
                                "current_overdraft_limit" => $current_overdraft_limit,
				                "value_of_employee_subsidy" => $value_of_employee_subsidy,
				                "wages_and_drawings_to_be_paid" => $wages_and_drawings_to_be_paid,
				                "other_costs_to_be_paid" => $other_costs_to_be_paid,
				                "tax_and_gst_to_be_paid" => $tax_and_gst_to_be_paid,
				                "any_revenue_expected" => $any_revenue_expected,
                                "ip_address" => $ip_address
		            	);
					
		        $add_new_cashflow = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_cashflow) {

                                $cashflow_id = $this->db->insert_id();

                                //Project Detaisl
                                
                                for($i=0;$i<count($project_name);$i++){
                                    $ins_array = array(
    				                   "cashflow_id" => $cashflow_id,
    				                   "project_name" => $project_name[$i],
    				                   "project_contract_price" => $project_contract_price[$i],
    				                   "value_of_contract_variations" => $value_of_contract_variations[$i],
    				                   "total_value_of_sales_invoices_issued" => $total_value_of_sales_invoices_issued[$i],
    				                   "total_value_of_outstanding_sales_invoices" => $total_value_of_outstanding_sales_invoices[$i],
    				                   "project_contract_budget" => $project_contract_budget[$i],
    				                   "value_of_extra_cost_due_to_variations" => $value_of_extra_cost_due_to_variations[$i],
    				                   "total_bills_received_from_suppliers_and_subbies" => $total_bills_received_from_suppliers_and_subbies[$i],
    				                   "total_value_of_unpaid_bill" => $total_value_of_unpaid_bill[$i],
    			                     );
    					
    		                        $this->mod_common->insert_into_table("cashflow_project_details", $ins_array);
                                }
				           $this->session->set_flashdata('cok_message', 'New Cash Flow added successfully.');
				           redirect(SURL . 'cashflow/report/'.urlencode(base64_encode($cashflow_id)));
			} else {

				$this->session->set_flashdata('cerr_message', 'New Cash Flow is not added. Something went wrong, please try again.');

				redirect(SURL . 'cashflow');
			}
    }
    
    public function report($id){
        $this->stencil->title('Cash Flow Report', $data);
        $data["id"] = $id;
        $cashflow_id = base64_decode(urldecode($id));
        $data["report"] = $this->mod_common->select_single_records("cashflow", array("id"=>$cashflow_id));
        $data["projects"] = $this->mod_common->get_all_records("cashflow_project_details", "*", 0, 0, array("cashflow_id"=>$cashflow_id));
        $this->stencil->paint('cashflow/cashflow_report', $data);
    }
    
    public function export($id){

        $cashflow_id = base64_decode(urldecode($id));
        $data["report"] = $this->mod_common->select_single_records("cashflow", array("id"=>$cashflow_id));
        $data["projects"] = $this->mod_common->get_all_records("cashflow_project_details", "*", 0, 0, array("cashflow_id"=>$cashflow_id));
        if(count($data["report"])>0){
        $current_contract_price = 0;
        $cash_received_from_client = 0;
        $total_value_of_sales_invoices_issued = 0;
        $current_contract_budget = 0;
        $bills_paid_by_builder = 0;
        $total_bills_received_from_suppliers_and_subbies = 0;
        $total_value_of_outstanding_sales_invoices = 0;
        $total_value_of_unpaid_bill = 0;
        
        foreach($data["projects"] as $project){
            $current_contract_price += $project["project_contract_price"] + $project["value_of_contract_variations"];
            $total_value_of_sales_invoices_issued +=$project["total_value_of_sales_invoices_issued"];
            $total_value_of_outstanding_sales_invoices +=$project["total_value_of_outstanding_sales_invoices"];
            $cash_received_from_client += $project["total_value_of_sales_invoices_issued"] - $project["total_value_of_outstanding_sales_invoices"];
            $current_contract_budget += $project["project_contract_budget"] + $project["value_of_extra_cost_due_to_variations"];
            $bills_paid_by_builder += $project["total_bills_received_from_suppliers_and_subbies"] - $project["total_value_of_unpaid_bill"];
            $total_bills_received_from_suppliers_and_subbies +=$project["total_bills_received_from_suppliers_and_subbies"];
            $total_value_of_unpaid_bill +=$project["total_value_of_unpaid_bill"];
        }
        
        if($current_contract_price>0){
           $percent_complete_cash = $cash_received_from_client/$current_contract_price;
        }
        else{
            $percent_complete_cash = 0;
        }
        
        if($current_contract_price>0){
            $percent_complete_sales = $total_value_of_sales_invoices_issued/$current_contract_price;
        }
        else{
            $percent_complete_sales = 0;
        }
        if($current_contract_budget>0){
           $percent_bills_paid = $bills_paid_by_builder/$current_contract_budget;
        }
        else{
            $percent_bills_paid = 0;
        }
        if($current_contract_budget>0){
            $percent_bills_received = $total_bills_received_from_suppliers_and_subbies/$current_contract_budget;
        }
        else{
            $percent_bills_received = 0;
        }
        
        $cash_belonging_to_project = $bills_paid_by_builder - ($current_contract_budget * $percent_complete_cash);
        
        $project_work_in_progress = $total_bills_received_from_suppliers_and_subbies - ($current_contract_budget * $percent_complete_sales);
        
        $available_funds_today = $data["report"]["total_cash_in_your_bank_account"]+$cash_belonging_to_project+$data["report"]["current_overdraft_limit"];
        
        $war_chest_now = ($available_funds_today + $total_value_of_outstanding_sales_invoices + $project_work_in_progress +	$data["report"]["value_of_employee_subsidy"])- $cash_belonging_to_project - $total_value_of_unpaid_bill;
        
        $your_expected_war_chest_at_the_end_of_shut_down = ($war_chest_now - $data["report"]["wages_and_drawings_to_be_paid"] - $data["report"]["other_costs_to_be_paid"]  - $data["report"]["tax_and_gst_to_be_paid"]) + $data["report"]["any_revenue_expected"];
        
        $data["current_overdraft_limit"] = $data["report"]["current_overdraft_limit"];
        $data["available_funds_today"] = $available_funds_today;
        $data["your_expected_war_chest_at_the_end_of_shut_down"] = $your_expected_war_chest_at_the_end_of_shut_down;
        $data["war_chest_now"] = $war_chest_now;
        
        $html = $this->load->view('cashflow/cashflow_pdf', $data, true); // render the view into HTML
        $pdfFilePath = "war_chest_report.pdf";

        //load mPDF library
        $this->load->library('M_pdf');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I"); 
        }
        else{
          redirect(SURL."nopage");
        }
}
}