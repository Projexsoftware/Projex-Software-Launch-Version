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
             $this->load->model("mod_dashboard");
             $this->load->model("mod_project");
             $this->load->model("mod_reports");

             $this->mod_common->verify_is_user_login();
             $this->mod_common->is_company_page_accessible(125);

        }
    
    //Dashboard
	public function index()
	{
             $this->stencil->title('Dashboard');
             
	       	$DB = mysqli_connect("localhost", "projexsoftware", "ikWKo2*xZZ88", "projexsoftware");
	       	
             $where = array('company_id' => $this->session->userdata('company_id'));
             $data['total_clients'] = count($this->mod_common->get_all_records("project_clients","*",0,0,$where,"client_id"));
             $data['total_projects'] = count($this->mod_common->get_all_records("project_projects","*",0,0,$where,"project_id"));
             $data['total_users'] = count($this->mod_common->get_all_records("project_users","*",0,0,$where,"user_id"));
             $data['total_suppliers'] = count($this->mod_common->get_all_records("project_suppliers","*",0,0,$where,"supplier_id"));
             $data['total_templates'] = count($this->mod_common->get_all_records("project_templates","*",0,0,$where,"template_id"));
             $data['total_stages'] = count($this->mod_common->get_all_records("project_stages","*",0,0,$where,"stage_id"));
             $data['total_components'] = count($this->mod_common->get_all_records("project_components","*",0,0,$where,"component_id"));
             $data['total_suppliers'] = count($this->mod_common->get_all_records("project_suppliers","*",0,0,$where,"supplier_id"));
             $data['total_takeoffdata'] = count($this->mod_common->get_all_records("project_takeoffdata","*",0,0,$where,"takeof_id"));
             
             $data['clients'] = $this->mod_common->get_latest_clients();
            
            $data['total_sales_invoices'] = $this->mod_dashboard->get_total_sales_invoices();
    		$data['total_sales_credits'] = $this->mod_dashboard->get_total_sales_credits();
    		$data['total_supplier_invoices'] = $this->mod_dashboard->get_total_supplier_invoices();
    		$data['total_supplier_credits'] = $this->mod_dashboard->get_total_supplier_credits();
    		
    		$project_variations = $this->mod_dashboard->get_project_variations();
    		$projects ="";
    		$variations="";
    		foreach($project_variations as $val){
    			$projects .="'".mysqli_real_escape_string($DB, htmlspecialchars($val['project_title']))."',";
    			$variations .=$val['variation_count'].",";
    		}
    		$project_sales_invoices = $this->mod_dashboard->get_project_sales_invoice();
    		$sales_invoice_projects="";
    		$invoice_amount = "";
    		foreach($project_sales_invoices as $val){
    			$sales_invoice_projects .="'".mysqli_real_escape_string($DB, htmlspecialchars($val['project_title']))."',";
    			$invoice_amount .=$val['invoice_amount'].",";
    		}
    		$project_suppliers_invoices = $this->mod_dashboard->get_project_supplier_invoice();
    		$suppliers_invoice_projects="";
    		$suppliers_invoice_amount = "";
    		foreach($project_suppliers_invoices as $val){
    			$suppliers_invoice_projects .="'".mysqli_real_escape_string($DB, htmlspecialchars($val['project_title']))."',";
    			$suppliers_invoice_amount .=$val['invoice_amount'].",";
    		}
    		
            $projects_list = $this->mod_project->get_dashboard_project_costing();
    		$bank_account_projects="";
    		$bank_account_amount = "";
    		
    		foreach($projects_list as $pro){
    		    
    		
    		
    		$costing_id = $pro['costing_id'];
    		
    		
            $project_id=$this->mod_project->get_project_id_from_costing_id($costing_id);
            
            
            $pc_detail = $this->mod_project->get_project_costing_info($project_id['project_id']);
            
            $cwhere = array('user_id' => $this->session->userdata('company_id'));
            $data['company_info'] = $this->mod_common->select_single_records('project_users',  $cwhere);
    		
    		$project_name = $this->mod_project->get_project_by_name($project_id['project_id']);
    		if($project_name['project_title']!=""){
    		$bank_account_projects .="'".mysqli_real_escape_string($DB, htmlspecialchars($project_name['project_title']))."',";
    		}
            
            $totalsupplierinvoicepaid=$this->mod_reports->gettotalsupplierinvoicepaidbycosting_id($costing_id);
            $totalsalesinvoicepaid=$this->mod_reports->gettotalsaleinvoicepaidbyproject_id($project_id['project_id']);
            
            
            $totalcashtransfers=$this->mod_reports->gettotalcashtransfersbyproject_id($project_id['project_id']);
            
            $returnarr= array(
                'costing_tax' => $pc_detail->tax_percent,
                'totalsupplierinvoicepaid' => $totalsupplierinvoicepaid,
                'totalsalesinvoicepaid' => $totalsalesinvoicepaid,
                'totalcashtransferspaid' => $totalcashtransfers
            );
            
            $result= $returnarr;
            	if($project_name['project_title']!=""){
            $bank_account_amount .=number_format(($result['totalsalesinvoicepaid'])-($result['totalsupplierinvoicepaid']*((100+$result['costing_tax'])/100))-($result['totalcashtransferspaid']), 2, '.', '').",";
            	}
            
    		}
    		
    		$data['projects']= rtrim($projects, ",");
    		$data['variations']= rtrim($variations, ",");
    		
    		$data['bank_account_projects']= rtrim($bank_account_projects, ",");
    		$data['bank_account_amount']= rtrim($bank_account_amount, ",");
    		
    		$data['sales_invoice_projects']= rtrim($sales_invoice_projects, ",");
    		$data['invoice_amount']= rtrim($invoice_amount, ",");
    		
    		$data['suppliers_invoice_projects']= rtrim($suppliers_invoice_projects, ",");
    		$data['suppliers_invoice_amount']= rtrim($suppliers_invoice_amount, ",");
    		
    		$where_user = array('company_id' => $this->session->userdata('company_id'), 'project_status' => 1);
    		$total_projects = $this->mod_dashboard->get_all_projects('project_projects',$where_user);
    		$total_profit=0;
    		$total_profit_diff = 0;
    		$myprofithtml ="";
    		$myprofitdiffhtml ="";
    		$myprofitpendinghtml = "";
    		foreach($total_projects as $project_id){
    		$pc_detail = $this->mod_project->get_project_costing_info($project_id['project_id']);
    		if($pc_detail){
        		$total_cost = $pc_detail->project_subtotal_1;
        
        		$costing_tax = $pc_detail->tax_percent;
        		
    		
    		
    		 /* Normal Variation   */
    		
    				if($this->mod_reports->get_extra_variation_cost($project_id['project_id'])){
    				  $total_extra_cost_variation = $this->mod_reports->get_extra_variation_cost($project_id['project_id']);
    				}
    				else{
    				   $total_extra_cost_variation = 0;
    				}
    				
    				if($this->mod_reports->get_extra_sales_variation_cost($project_id['project_id'])){
    					$total_extra_sales_variation_cost = $this->mod_reports->get_extra_sales_variation_cost($project_id['project_id']);
    				}
    				else{
    				   $total_extra_sales_variation_cost = 0;
    				}
    		
    				/*  Purchase Order Variation   */
    		
    				
    				if($this->mod_reports->get_extra_po_variation_cost($project_id['project_id'])){
    				   $total_extra_po_cost_variation = $this->mod_reports->get_extra_po_variation_cost($project_id['project_id']);
    				}
    				else{
    				  $total_extra_po_cost_variation = 0;
    				}
    		
    				
    				if($this->mod_reports->get_extra_po_sales_variation_cost($project_id['project_id'])){
    				   $total_extra_po_sales_variation_cost = $this->mod_reports->get_extra_po_sales_variation_cost($project_id['project_id']);
    				} 
    				else{
    				  $total_extra_po_sales_variation_cost = 0;
    				}
    			   
    				/*  Supplier Variation   */
    		
    				if($this->mod_reports->get_extra_sup_variation_cost($project_id['project_id'])){
    				   $total_extra_sup_cost_variation = $this->mod_reports->get_extra_sup_variation_cost($project_id['project_id']);
    				}
    				else{
    					$total_extra_sup_cost_variation = 0;
    				}
    			   
    				if($this->mod_reports->get_extra_sup_sales_variation_cost($project_id['project_id'])){
    				  $total_extra_sup_sales_variation_cost = $this->mod_reports->get_extra_sup_sales_variation_cost($project_id['project_id']);
    				}
    				else{
    				  $total_extra_sup_sales_variation_cost = 0;
    				}
    				
    				/*  Supplier Credit Variation   */
    
                    if($this->mod_reports->get_extra_sup_credit_variation_cost($project_id['project_id'])){
                       $total_extra_sup_credit_cost_variation = $this->mod_reports->get_extra_sup_credit_variation_cost($project_id['project_id']);
                    }
                    else{
                        $total_extra_sup_credit_cost_variation = 0;
                    }
    				
    				
    				/* Allowances  */
    				
    				if($this->mod_project->get_project_costing_info($project_id['project_id'])){
    				   $total_extra_allowance_cost = $this->mod_reports->get_extra_allowance_cost($pc_detail->costing_id);
    				   
    				   $total_extra_allowance_cost = 0;
               
               
               $pc_detail = $this->mod_project->get_project_costing_info($project_id['project_id']);
               $tax =$pc_detail->tax_percent;
               $type = "allowance";
               $allowance_prjprts = $this->mod_project->get_costing_parts_by_project_id($project_id['project_id'], $type);
               
               foreach($allowance_prjprts as $allowance_prjprt){
                   //$allowance_cost = ($allowance_prjprt->line_margin)+($allowance_prjprt->line_margin*($tax/100));
                   $allowance_cost = $allowance_prjprt->line_margin;
                   //$total_extra_allowance_cost += $allowance_prjprt->line_margin;
                   $allocated_allowance_amount = $this->mod_reports->gettotalallowanceamount($allowance_prjprt->costing_part_id);
                   $invoiced = $this->mod_reports->gettotalactualamount($allowance_prjprt->costing_part_id);
                  
                   $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
                   
                   //$total_extra_allowance_cost+=number_format((($invoiced_amount)+($invoiced_amount*($tax/100))), 2, ".", "") - $allowance_cost;
                   $total_extra_allowance_cost+=$invoiced_amount - $allowance_cost;
               }
    				}
    				else{
    					$total_extra_allowance_cost = 0;
    				}
    			   
    				if($this->mod_reports->get_extra_allowance_sales_cost($project_id['project_id'])){
    				  $total_extra_allowance_sales_cost = $this->mod_reports->get_extra_allowance_sales_cost($project_id['project_id']);
    				}
    				else{
    				  $total_extra_allowance_sales_cost = 0;
    				}
    				
    				
    				if($this->mod_reports->get_total_credit_notes($pc_detail->costing_id)){
                          $total_credit_notes = $this->mod_reports->get_total_credit_notes($pc_detail->costing_id);
                    }
                    else{
                          $total_credit_notes = 0;
                    }
    				
    				$total_supplier_credits = ($total_credit_notes*($costing_tax/100))+$total_credit_notes;
    				
    				if($this->mod_reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id'])){
    				  $total_extra_sup_credit_sales_variation_cost = $this->mod_reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id']);
    				}
    				else{
    				  $total_extra_sup_credit_sales_variation_cost = 0;
    				}
    				
    				$updated_project_cost = (number_format(($total_cost*((100+$costing_tax)/100)), 2, '.', '')+number_format(($total_extra_cost_variation*((100+$costing_tax)/100)), 2, '.', '')+number_format($total_extra_po_cost_variation*((100+$costing_tax)/100), 2, '.', '')+number_format(($total_extra_sup_cost_variation*((100+$costing_tax)/100)), 2, '.', '')+number_format($total_extra_allowance_cost*((100+$costing_tax)/100), 2, '.', ''))-number_format(($total_extra_sup_credit_cost_variation*((100+$costing_tax)/100)), 2, '.', '');
    			    
    			    $updated_project_contract_price = (number_format($pc_detail->contract_price, 2, '.', '')+number_format($total_extra_sales_variation_cost, 2, '.', '') +  number_format($total_extra_po_sales_variation_cost, 2, '.', '')+number_format($total_extra_sup_sales_variation_cost, 2, '.', '')+number_format($total_extra_allowance_cost*((100+$costing_tax)/100), 2, '.', ''))-number_format($total_extra_sup_credit_sales_variation_cost, 2, '.', '');
                  	
                    $total_updated_profit = number_format($updated_project_contract_price, 2, '.', '')-number_format($updated_project_cost, 2, '.', '');
    	
    				$total_profit += $total_updated_profit;
    				
    				$total_profit_for_diff = number_format($pc_detail->contract_price,2,'.','')-number_format(($total_cost*(100+$costing_tax)/100),2,'.','');
    				
    				$profit_difference = number_format($total_updated_profit, 2, '.', '')-number_format($total_profit_for_diff, 2, '.', '');
    				
    				$total_profit_diff += $profit_difference;
    				$dashbaord_project_name = $this->mod_project->get_project_by_name($project_id['project_id']);
    				$dashbaord_project_name = $dashbaord_project_name['project_title'];
    				$project_profit = $total_updated_profit;
    				$myprofithtml .= $dashbaord_project_name."|".$project_profit."^";
    				$myprofitdiffhtml .= $dashbaord_project_name."|".$profit_difference."^";
    				}
		}
				/* For pending */
				
				$where_user = array('company_id' => $this->session->userdata('company_id'), 'project_status' => 2);
		$total_projects = $this->mod_dashboard->get_all_projects('project_projects',$where_user);
		$total_profit_for_pending=0;
		foreach($total_projects as $project_id){
    		$pc_detail = $this->mod_project->get_project_costing_info($project_id['project_id']);
    		if($pc_detail){
        		$total_cost = $pc_detail->project_subtotal_1;
        		$costing_tax = $pc_detail->tax_percent;
        		
        				
        				$new_total_updated_profit_amount = number_format($pc_detail->project_subtotal_2, 2, '.', '') - number_format($pc_detail->project_subtotal_1, 2, '.', '');
        				$new_total_updated_profit_gst = (15/100)*$new_total_updated_profit_amount;
        				$new_total_updated_profit = number_format($new_total_updated_profit_amount + $new_total_updated_profit_gst, 2, ".", "");
        				
        				$total_profit_for_pending += $new_total_updated_profit;
        				
        				$dashbaord_project_name = $this->mod_project->get_project_by_name($project_id['project_id']);
        				$dashbaord_project_name = $dashbaord_project_name['project_title'];
        				
        				$project_profit_pending = $new_total_updated_profit;
        				$myprofitpendinghtml .= $dashbaord_project_name."|".$project_profit_pending."^";
        				
        		}
	    }
		$data['project_profit']= $total_profit;
		$data['profit_difference']= $total_profit_diff;
		$data['total_profit_for_pending'] = $total_profit_for_pending;
		$data['myprofithtml']= rtrim($myprofithtml, "^");
		$data['myprofitdiffhtml']= rtrim($myprofitdiffhtml, "^");
		$data['myprofitpendinghtml']= rtrim($myprofitpendinghtml, "^");
             

	     $this->stencil->paint('dashboard/dashboard', $data);
	}
}
