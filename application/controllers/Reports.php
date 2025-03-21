<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Controller {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        
        $this->stencil->layout('default_layout');

        $this->stencil->slice('header_script');
        $this->stencil->slice('header');
        $this->stencil->slice('sidebar');
        $this->stencil->slice('footer_script');
        $this->stencil->slice('footer');
             
        $this->load->model('mod_common', 'common');
        $this->load->model('mod_project', 'project');
         $this->load->model('mod_reports', 'reports');
        $this->load->model('mod_variation', 'variation');
        $this->load->model('mod_saleinvoice', 'saleinvoice');
        ini_set('post_max_size', '500M');
        
        $this->common->verify_is_user_login();
             
        $this->common->is_company_page_accessible(47);
    }
    
    public function index(){
        redirect(SURL."nopage");
    }
    
    /* Supplier Components Report Section Starts Here */
    
    //Supplier components Screen
    function supplier_components() {
        $this->common->is_company_page_accessible(120);
        $table = "project_suppliers";
        $data['suppliers'] = $this->common->get_all_records($table, "*", 0, 0, array("company_id" => $this->session->userdata('company_id'), "supplier_status" => 1), "supplier_name");
        
        $this->stencil->title('Supplier Components Report');
	   $this->stencil->paint('reports/supplier_components/supplier_components_report', $data);
    }
    
    //Get Supplier Components 
    function get_supplier_components() {
        $this->common->is_company_page_accessible(120);
        if (!empty($this->input->post("supplier_id"))) {
            
            $table = "project_components";
            $data['supplier_components'] = $this->common->get_all_records($table, "*", 0, 0, array("supplier_id" => $this->input->post("supplier_id")), "component_id");
            
            $table = "project_suppliers";
            $data['supplier_info'] = $this->common->select_single_records($table, array("supplier_id" => $this->input->post("supplier_id")));
             
            $this->load->view('reports/supplier_components/supplier_components_report_ajax', $data);
        }
    }
    
    //Export Supplier Components
    public function export_supplier_components(){
		$this->common->is_company_page_accessible(120);
		$supplier_id = $this->input->post("report_supplier_id");
		$report_type = $this->input->post("report_type");
		
		$table = "project_suppliers";
		$data["suppliers"] = $suppliers = $this->common->select_single_records($table, array("supplier_id" => $supplier_id));
		
		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$table = "project_components";
        $data["supplier_components"] = $supplier_components = $this->common->get_all_records($table, "*", 0, 0, array("supplier_id" => $supplier_id), "component_id");
               
		if($report_type == "excel"){
		    
		        $this->load->library("excel");
                
                $my_data_titles = array(
                    array(
                    'sr_no'                  =>  '',
                    'component_name'         =>  '',
                    'description'            =>  'Supplier :',
        			'unit_of_measure'        =>  stripslashes($suppliers['supplier_name']),
        			'unit_cost'              =>  '',
        			'date'                   =>  ''
                    )
                );
                
                $my_data = array();
               
        		$count = 1;
        		$key=0;
        		$i=2;
        	             $my_data[$key]['sr_no'] = "";
        				 $my_data[$key]['component_name'] = "";
        				 $my_data[$key]['description'] = "";
        				 $my_data[$key]['unit_of_measure'] = ""; 
        				 $my_data[$key]['unit_cost'] = "";
        				 $my_data[$key]['date'] = "";
        				 
        				 $key++;
                
        		         $my_data[$key]['sr_no'] = "Sr No";
        				 $my_data[$key]['component_name'] = "Component Name";
        				 $my_data[$key]['description'] = "Description";
        				 $my_data[$key]['unit_of_measure'] = "Unit of Measure"; 
        				 $my_data[$key]['unit_cost'] = "Unit Cost";
        				 $my_data[$key]['date'] = "Date";
        				 
            	
                foreach($supplier_components as $supplier_component){
        				 $key++;
                         $my_data[$key]['sr_no'] = $count;
        				 $my_data[$key]['component_name'] = $supplier_component['component_name'];
        				 $my_data[$key]['description'] = $supplier_component['component_des'];
        				 $my_data[$key]['unit_of_measure'] = $supplier_component['component_uom']; 
        				 $my_data[$key]['unit_cost'] = $supplier_component['component_uc']." ";
        				 $my_data[$key]['date'] =  date("d/M/Y", strtotime($supplier_component['date_created']))." ";
                	   
        			 $count++;
        		}
        							
        		$all_data = array_merge($my_data_titles, $my_data);
        		$total_records = $key+3;
        		
                //activate worksheet number 1
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle("Supplier's Components Lists");
        
                $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
                // read data to active sheet
                $this->excel->getActiveSheet()->fromArray($all_data);
         
                $filename="supplier's_components_lists.xls"; //save our workbook as this file name
         
                header('Content-Type: application/vnd.ms-excel'); //mime type
         
                header('Content-Disposition: attachment;filename="'.$filename.'"'); 
                //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
         
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
		}else{
		    $this->load->library("M_pdf");
	    
    		$html = $this->load->view('reports/supplier_components/supplier_components_report_pdf', $data, true);
    
    		$pdfFilePath = "supplier_components_report_".date('Y-m-d').".pdf";
            
    		$this->m_pdf->pdf->WriteHTML($html);
     
            //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
	}
	
	/* Supplier Components Report Section Ends Here */
    
    /* Project Report Section Starts Here */
    
    //Project Report Screen
    public function project_report() {
        $this->common->is_company_page_accessible(48);
        $data['projects'] = $this->project->get_existing_project(); 
        
        $this->stencil->title('Project Report');
	    $this->stencil->paint('reports/project_report/view_project_report', $data);
    }
    
    //Get Project Report Details
    public function get_report_by_project_id(){
		
		$this->session->unset_userdata('reportdata');
        
        $costing_id = $_POST['project_id'];
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
        
        $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);

        $tcegst=0; $ia=0;
        
        $prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id']);
        foreach($prjprts as $key => $val){   
            $invoice_amount = $this->reports->getiabycpidandcq($val->costing_part_id,$val->costing_quantity);
            $ia += $invoice_amount;
        }
        $extracostvare=0;
        
        $approvedvar = $this->variation->getaprovedvarbycosid($costing_id,'normal');
        
        
        foreach ($approvedvar as $key => $value) {
            
            $cost = $this->reports->getextracostvarebyvarid($value, $costing_id);
            $extracostvare += $cost;
            
        }
        
        $sum_norvar_contract_price=$this->reports-> getsoavbycid($costing_id,'normal');
        $sum_norvar_contract_price[0]->sum_var_contract_price=($sum_norvar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_norvar_contract_price[0]->sum_var_contract_price:0;
        
        $extracostpovare=0;
        
        $approvedpovar = $this->variation->getPurchaseOrderCost($project_id['project_id']);
		if(count($approvedpovar)>0){
		  $extracostpovare = $approvedpovar[0]['total_line_cost'];
		}
        
        $sum_povar_contract_price=$this->reports-> getsoavbycid($costing_id,'purord');
        $sum_povar_contract_price[0]->sum_var_contract_price=($sum_povar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_povar_contract_price[0]->sum_var_contract_price:0;
    
        $extracostsivare=0;
        
        $approvedsivar = $this->variation->getaprovedvarbycosid($costing_id,'suppinvo');
        

        foreach ($approvedsivar as $key => $value) {
            $cost = $this->reports->getextracostvarebyvarid($value, $costing_id);
            $extracostsivare += $cost;
        }
        
        $extracostscvare=0;
        
        $approvedscvar = $this->variation->getaprovedvarbycosid($costing_id,'supcredit');
        

        foreach ($approvedscvar as $key => $value) {
            $cost = $this->reports->getextracostvarebyvarid($value, $costing_id);
            $extracostscvare += $cost;
        }
        
        $sum_sivar_contract_price=$this->reports-> getsoavbycid($costing_id,'suppinvo');
        $sum_sivar_contract_price[0]->sum_var_contract_price=($sum_sivar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_sivar_contract_price[0]->sum_var_contract_price:0;

            
        $totalsupplierinvoicepaid=$this->reports->gettotalsupplierinvoicepaidbycosting_id($costing_id);
        $totalsalesinvoicepaid=$this->reports->gettotalsaleinvoicepaidbyproject_id($project_id['project_id']);
        $totalsalescredits=$this->reports->gettotalsalecreditsbyproject_id($project_id['project_id']);
        
        $totalsupplierinvoicecreated=$this->reports->gettotalsupplierinvoicebycosting_id($costing_id);
        $totalsalesinvoicecreated=$this->reports->gettotalsaleinvoicebyproject_id($project_id['project_id']);

        /* Normal Variation   */

        if($this->reports->get_extra_variation_cost($project_id['project_id'])){
          $total_extra_cost_variation = $this->reports->get_extra_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_cost_variation = 0;
        }
        
        if($this->reports->get_extra_sales_variation_cost($project_id['project_id'])){
            $total_extra_sales_variation_cost = $this->reports->get_extra_sales_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_sales_variation_cost = 0;
        }

        /*  Purchase Order Variation   */

        
        if($this->reports->get_extra_po_variation_cost($project_id['project_id'])){
           $total_extra_po_cost_variation = $this->reports->get_extra_po_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_po_cost_variation = 0;
        }

        
        if($this->reports->get_extra_po_sales_variation_cost($project_id['project_id'])){
           $total_extra_po_sales_variation_cost = $this->reports->get_extra_po_sales_variation_cost($project_id['project_id']);
        } 
        else{
          $total_extra_po_sales_variation_cost = 0;
        }
       
        /*  Supplier Variation   */

        if($this->reports->get_extra_sup_variation_cost($project_id['project_id'])){
           $total_extra_sup_cost_variation = $this->reports->get_extra_sup_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_sales_variation_cost = $this->reports->get_extra_sup_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_sales_variation_cost = 0;
        }
        
        /*  Supplier Credit Variation   */

        if($this->reports->get_extra_sup_credit_variation_cost($project_id['project_id'])){
           $total_extra_sup_credit_cost_variation = $this->reports->get_extra_sup_credit_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_credit_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_credit_sales_variation_cost = $this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_credit_sales_variation_cost = 0;
        }
        
        /* Allowances  */
        
        if($this->project->get_project_costing_info($project_id['project_id'])){
           //$total_extra_allowance_cost = $this->reports->get_extra_allowance_cost($pc_detail->costing_id);
           
           $total_extra_allowance_cost = 0;
           
           
           $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
           $tax =$pc_detail->tax_percent;
           $type = "allowance";
           $allowance_prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id'], $type);
           
           foreach($allowance_prjprts as $allowance_prjprt){
               $allowance_cost = $allowance_prjprt->line_margin;
               $allocated_allowance_amount = $this->reports->gettotalallowanceamount($allowance_prjprt->costing_part_id);
               $invoiced = $this->reports->gettotalactualamount($allowance_prjprt->costing_part_id);
              
               $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
               
               $total_extra_allowance_cost+=$invoiced_amount - $allowance_cost;
           }
          
           
        }
        else{
            $total_extra_allowance_cost = 0;
        }
       
        if($this->reports->get_extra_allowance_sales_cost($project_id['project_id'])){
          $total_extra_allowance_sales_cost = $this->reports->get_extra_allowance_sales_cost($project_id['project_id']);
        }
        else{
          $total_extra_allowance_sales_cost = 0;
        }
        
        if($this->reports->get_total_credit_invoices($pc_detail->costing_id)){
          $total_credit_invoices = $this->reports->get_total_credit_invoices($pc_detail->costing_id);
        }
        else{
          $total_credit_invoices = 0;
        }
        
        if($this->reports->get_total_credit_notes($pc_detail->costing_id)){
          $total_credit_notes = $this->reports->get_total_credit_notes($pc_detail->costing_id);
        }
        else{
          $total_credit_notes = 0;
        }
 
        
         $totalcashtransfers = $this->reports->gettotalcashtransfersbyproject_id($project_id['project_id']);
         $totalbankinterest = $this->reports->gettotalbankinterestbyproject_id($project_id['project_id']);
        
        $returnarr= array(
            'tcegst' => $ia,
            'total_cost' => $pc_detail->project_subtotal_1,
            'overhead_margin' => $pc_detail->over_head_margin,
            'profit_margin' => $pc_detail->porfit_margin,
            'total_cost2' => $pc_detail->project_subtotal_2,
            'costing_tax' => $pc_detail->tax_percent,
            'total_cost3' => $pc_detail->project_subtotal_3,
            'price_rounding' => $pc_detail->price_rounding,
            'contract_price' => $pc_detail->contract_price,
            'extracostvare' => $total_extra_cost_variation ,
            'extrasalevar' => $total_extra_sales_variation_cost,
            'extracostpovare' => $total_extra_po_cost_variation ,
            'extrasalepovar' =>$total_extra_po_sales_variation_cost,
            'extracostsivare' => $total_extra_sup_cost_variation ,
            'extracostscvare' => $total_extra_sup_credit_cost_variation ,
            'extrasalesivar' => $total_extra_sup_sales_variation_cost ,
            'extrasalescvar' => $total_extra_sup_credit_sales_variation_cost ,
            'extracostallowe' => $total_extra_allowance_cost ,
            'extrasaleallow' => $total_extra_allowance_sales_cost ,
            'totalsupplierinvoicepaid' => $totalsupplierinvoicepaid,
            'totalsalesinvoicepaid' => $totalsalesinvoicepaid,
            'totalsupplierinvoicecreated' => $totalsupplierinvoicecreated,
            'totalsalesinvoicecreated' => $totalsalesinvoicecreated,
            'totalcashtransfers' => $totalcashtransfers,
            'totalbankinterest' => $totalbankinterest,
            'total_credit_invoices' => $total_credit_invoices,
            'total_credit_notes' => $total_credit_notes,
            'totalsalescredits' => $totalsalescredits
        );
        
        echo json_encode($returnarr);
         
    }
    
    //View Project Report Details
    public function view_project_report_details(){
		
		if($this->session->userdata('reportdata')){
			 $reportdata = $this->session->userdata('reportdata');
			 $costing_id = $reportdata['project_id'];
			 $data['bankinterest']=$reportdata['bankinterest'];
		}
		else{
			$costing_id = $_POST['project_id'];
			$data['bankinterest']=$this->input->post('bankinterest');
			$reportdata = array(
					   'project_id' => $costing_id,
					   'bankinterest' => $this->input->post('bankinterest')
			);		
			$this->session->set_userdata('reportdata', $reportdata);
		}
		
		
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
        
        $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
		
		$data['project_name'] = $this->project->get_project_by_name($project_id['project_id']);
        
        //total cost excluding gst
        $tcegst=0; $ia=0;
        $prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id']);
        
        foreach($prjprts as $key => $val){   
            //getinoviceamount by cpart id and costing quantity
            $ia+=$this->reports->getiabycpidandcq($val->costing_part_id,$val->costing_quantity);
        }
        $extracostvare=0;
        
        $approvedvar = $this->variation->getaprovedvarbycosid($costing_id,'normal');
        
        
        foreach ($approvedvar as $key => $value) {
            
            $extracostvare += $this->reports->getextracostvarebyvarid($value, $costing_id);
            
        }
        
        // get sum of contract price of approved variations by project id 
        $sum_norvar_contract_price=$this->reports-> getsoavbycid($costing_id,'normal');
        $sum_norvar_contract_price[0]->sum_var_contract_price=($sum_norvar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_norvar_contract_price[0]->sum_var_contract_price:0;
//        print_r($sum_var_contract_price);
        
        /*$extracostpovare=0;
        
        $approvedpovar = $this->variation->getaprovedvarbycosid($costing_id,'purord');
        
        
        foreach ($approvedpovar as $key => $value) {
            $extracostpovare += $this->reports->getextracostvarebyvarid($value, $costing_id);
        }*/
		
		$approvedpovar = $this->variation->getPurchaseOrderCost($project_id['project_id']);
		if(count($approvedpovar)>0){
		  $extracostpovare = $approvedpovar[0]['total_line_cost'];
		}
        
        
        $sum_povar_contract_price=$this->reports-> getsoavbycid($costing_id,'purord');
        $sum_povar_contract_price[0]->sum_var_contract_price=($sum_povar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_povar_contract_price[0]->sum_var_contract_price:0;
//      
        $extracostsivare=0;
        
        $approvedsivar = $this->variation->getaprovedvarbycosid($costing_id,'suppinvo');
        
//        print_r($approvedsivar);
        foreach ($approvedsivar as $key => $value) {
            $extracostsivare += $this->reports->getextracostvarebyvarid($value, $costing_id);
//            print_r($extracostsivare);
        }
        
        $sum_sivar_contract_price=$this->reports-> getsoavbycid($costing_id,'suppinvo');
        $sum_sivar_contract_price[0]->sum_var_contract_price=($sum_sivar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_sivar_contract_price[0]->sum_var_contract_price:0;

//      
        $totalsupplierinvoicepaid=$this->reports->gettotalsupplierinvoicepaidbycosting_id($costing_id);
        $totalsalesinvoicepaid=$this->reports->gettotalsaleinvoicepaidbyproject_id($project_id['project_id']);
        
        $totalsalescredits=$this->reports->gettotalsalecreditsbyproject_id($project_id['project_id']);
        
        $totalsupplierinvoicecreated=$this->reports->gettotalsupplierinvoicebycosting_id($costing_id);
        $totalsalesinvoicecreated=$this->reports->gettotalsaleinvoicebyproject_id($project_id['project_id']);


         /* Normal Variation   */

        if($this->reports->get_extra_variation_cost($project_id['project_id'])){
          $total_extra_cost_variation = $this->reports->get_extra_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_cost_variation = 0;
        }
        
        if($this->reports->get_extra_sales_variation_cost($project_id['project_id'])){
            $total_extra_sales_variation_cost = $this->reports->get_extra_sales_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_sales_variation_cost = 0;
        }

        /*  Purchase Order Variation   */

        
        if($this->reports->get_extra_po_variation_cost($project_id['project_id'])){
           $total_extra_po_cost_variation = $this->reports->get_extra_po_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_po_cost_variation = 0;
        }

        
        if($this->reports->get_extra_po_sales_variation_cost($project_id['project_id'])){
           $total_extra_po_sales_variation_cost = $this->reports->get_extra_po_sales_variation_cost($project_id['project_id']);
        } 
        else{
          $total_extra_po_sales_variation_cost = 0;
        }
       
        /*  Supplier Variation   */

        if($this->reports->get_extra_sup_variation_cost($project_id['project_id'])){
           $total_extra_sup_cost_variation = $this->reports->get_extra_sup_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_sales_variation_cost = $this->reports->get_extra_sup_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_sales_variation_cost = 0;
        }
        
        /*  Supplier Credit Variation   */

        if($this->reports->get_extra_sup_credit_variation_cost($project_id['project_id'])){
           $total_extra_sup_credit_cost_variation = $this->reports->get_extra_sup_credit_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_credit_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_credit_sales_variation_cost = $this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_credit_sales_variation_cost = 0;
        }
        
        /* Allowances  */
        
        if($this->project->get_project_costing_info($project_id['project_id'])){
           //$total_extra_allowance_cost = $this->reports->get_extra_allowance_cost($pc_detail->costing_id);
           
           $total_extra_allowance_cost = 0;
           
           
           $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
           $tax =$pc_detail->tax_percent;
           $type = "allowance";
           $allowance_prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id'], $type);
           
           foreach($allowance_prjprts as $allowance_prjprt){
               //$allowance_cost = ($allowance_prjprt->line_margin)+($allowance_prjprt->line_margin*($tax/100));
               $allowance_cost = $allowance_prjprt->line_margin;
               //$total_extra_allowance_cost += $allowance_prjprt->line_margin;
               $allocated_allowance_amount = $this->reports->gettotalallowanceamount($allowance_prjprt->costing_part_id);
               $invoiced = $this->reports->gettotalactualamount($allowance_prjprt->costing_part_id);
              
               $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
               
               //$total_extra_allowance_cost+=number_format((($invoiced_amount)+($invoiced_amount*($tax/100))), 2, ".", "") - $allowance_cost;
               $total_extra_allowance_cost+=$invoiced_amount - $allowance_cost;
           }
           
        }
        else{
            $total_extra_allowance_cost = 0;
        }
       
        if($this->reports->get_extra_allowance_sales_cost($project_id['project_id'])){
          $total_extra_allowance_sales_cost = $this->reports->get_extra_allowance_sales_cost($project_id['project_id']);
        }
        else{
          $total_extra_allowance_sales_cost = 0;
        }
        
        $totalcashtransfers=$this->reports->gettotalcashtransfersbyproject_id($project_id['project_id']);
        
        if($this->reports->get_total_credit_invoices($pc_detail->costing_id)){
          $total_credit_invoices = $this->reports->get_total_credit_invoices($pc_detail->costing_id);
        }
        else{
          $total_credit_invoices = 0;
        }
        
        if($this->reports->get_total_credit_notes($pc_detail->costing_id)){
          $total_credit_notes = $this->reports->get_total_credit_notes($pc_detail->costing_id);
        }
        else{
          $total_credit_notes = 0;
        }
        
        $returnarr= array(
            'tcegst' => $ia,
            'total_cost' => $pc_detail->project_subtotal_1,
            'overhead_margin' => $pc_detail->over_head_margin,
            'profit_margin' => $pc_detail->porfit_margin,
            'total_cost2' => $pc_detail->project_subtotal_2,
            'costing_tax' => $pc_detail->tax_percent,
            'total_cost3' => $pc_detail->project_subtotal_3,
            'price_rounding' => $pc_detail->price_rounding,
            'contract_price' => $pc_detail->contract_price,
            'extracostvare' => $total_extra_cost_variation ,
            'extrasalevar' => $total_extra_sales_variation_cost,
            'extracostpovare' => $total_extra_po_cost_variation ,
            'extrasalepovar' =>$total_extra_po_sales_variation_cost,
            'extracostsivare' => $total_extra_sup_cost_variation ,
            'extracostscvare' => $total_extra_sup_credit_cost_variation ,
            'extrasalesivar' => $total_extra_sup_sales_variation_cost ,
            'extrasalescvar' => $total_extra_sup_credit_sales_variation_cost ,
            'extracostallowe' => $total_extra_allowance_cost ,
            'extrasaleallow' => $total_extra_allowance_sales_cost ,
            'totalsupplierinvoicepaid' => $totalsupplierinvoicepaid,
            'totalsalesinvoicepaid' => $totalsalesinvoicepaid,
            'totalsupplierinvoicecreated' => $totalsupplierinvoicecreated,
            'totalsalesinvoicecreated' => $totalsalesinvoicecreated,
            'totalcashtransferspaid' => $totalcashtransfers,
            'total_credit_invoices' => $total_credit_invoices,
            'total_credit_notes' => $total_credit_notes,
            'totalsalescredits' => $totalsalescredits
        );
        
        $data['result']= $returnarr;
		$this->stencil->title('Project Report Details');
	    $this->stencil->paint('reports/project_report/view_project_report_details', $data);
		
	}
	
	//Export Report As PDF
	public function pdf_report(){
		
		
		$this->load->library('M_pdf');
		
		$reportdata = $this->session->userdata('reportdata');
		$costing_id = $reportdata['project_id'];
		$data['bankinterest'] = $reportdata['bankinterest'];
		
		
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
        
        $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
        
        $cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$data['project_name'] = $this->project->get_project_by_name($project_id['project_id']);
        
        //total cost excluding gst
        $tcegst=0; $ia=0;
        $prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id']);
        
        foreach($prjprts as $key => $val){   
            //getinoviceamount by cpart id and costing quantity
            $ia+=$this->reports->getiabycpidandcq($val->costing_part_id,$val->costing_quantity);
        }
        $extracostvare=0;
        
        $approvedvar = $this->variation->getaprovedvarbycosid($costing_id,'normal');
        
        
        foreach ($approvedvar as $key => $value) {
            
            $extracostvare += $this->reports->getextracostvarebyvarid($value, $costing_id);
            
        }
        
        // get sum of contract price of approved variations by project id 
        $sum_norvar_contract_price=$this->reports-> getsoavbycid($costing_id,'normal');
        $sum_norvar_contract_price[0]->sum_var_contract_price=($sum_norvar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_norvar_contract_price[0]->sum_var_contract_price:0;
//        print_r($sum_var_contract_price);
        
        $extracostpovare=0;
        
        /*$approvedpovar = $this->variation->getaprovedvarbycosid($costing_id,'purord');
        
        
        foreach ($approvedpovar as $key => $value) {
            $extracostpovare += $this->reports->getextracostvarebyvarid($value, $costing_id);
        }*/
		
		$approvedpovar = $this->variation->getPurchaseOrderCost($project_id['project_id']);
		if(count($approvedpovar)>0){
		  $extracostpovare = $approvedpovar[0]['total_line_cost'];
		}
        
        
        $sum_povar_contract_price=$this->reports-> getsoavbycid($costing_id,'purord');
        $sum_povar_contract_price[0]->sum_var_contract_price=($sum_povar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_povar_contract_price[0]->sum_var_contract_price:0;
//      
        $extracostsivare=0;
        
        $approvedsivar = $this->variation->getaprovedvarbycosid($costing_id,'suppinvo');
        
//        print_r($approvedsivar);
        foreach ($approvedsivar as $key => $value) {
            $extracostsivare += $this->reports->getextracostvarebyvarid($value, $costing_id);
//            print_r($extracostsivare);
        }
        
        $sum_sivar_contract_price=$this->reports-> getsoavbycid($costing_id,'suppinvo');
        $sum_sivar_contract_price[0]->sum_var_contract_price=($sum_sivar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_sivar_contract_price[0]->sum_var_contract_price:0;

//      
        $totalsupplierinvoicepaid=$this->reports->gettotalsupplierinvoicepaidbycosting_id($costing_id);
        $totalsalesinvoicepaid=$this->reports->gettotalsaleinvoicepaidbyproject_id($project_id['project_id']);
        
        $totalsalescredits=$this->reports->gettotalsalecreditsbyproject_id($project_id['project_id']);
        
        $totalsupplierinvoicecreated=$this->reports->gettotalsupplierinvoicebycosting_id($costing_id);
        $totalsalesinvoicecreated=$this->reports->gettotalsaleinvoicebyproject_id($project_id['project_id']);


        /* Normal Variation   */

        if($this->reports->get_extra_variation_cost($project_id['project_id'])){
          $total_extra_cost_variation = $this->reports->get_extra_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_cost_variation = 0;
        }
        
        if($this->reports->get_extra_sales_variation_cost($project_id['project_id'])){
            $total_extra_sales_variation_cost = $this->reports->get_extra_sales_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_sales_variation_cost = 0;
        }

        /*  Purchase Order Variation   */

        
        if($this->reports->get_extra_po_variation_cost($project_id['project_id'])){
           $total_extra_po_cost_variation = $this->reports->get_extra_po_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_po_cost_variation = 0;
        }

        
        if($this->reports->get_extra_po_sales_variation_cost($project_id['project_id'])){
           $total_extra_po_sales_variation_cost = $this->reports->get_extra_po_sales_variation_cost($project_id['project_id']);
        } 
        else{
          $total_extra_po_sales_variation_cost = 0;
        }
       
        /*  Supplier Variation   */

        if($this->reports->get_extra_sup_variation_cost($project_id['project_id'])){
           $total_extra_sup_cost_variation = $this->reports->get_extra_sup_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_sales_variation_cost = $this->reports->get_extra_sup_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_sales_variation_cost = 0;
        }
        
        /*  Supplier Credit Variation   */

        if($this->reports->get_extra_sup_credit_variation_cost($project_id['project_id'])){
           $total_extra_sup_credit_cost_variation = $this->reports->get_extra_sup_credit_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_credit_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_credit_sales_variation_cost = $this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_credit_sales_variation_cost = 0;
        }
        
        /* Allowances  */
        
        if($this->project->get_project_costing_info($project_id['project_id'])){
           //$total_extra_allowance_cost = $this->reports->get_extra_allowance_cost($pc_detail->costing_id);
           
           $total_extra_allowance_cost = 0;
           
           
           $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
           $tax =$pc_detail->tax_percent;
           $type = "allowance";
           $allowance_prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id'], $type);
           
           foreach($allowance_prjprts as $allowance_prjprt){
               //$allowance_cost = ($allowance_prjprt->line_margin)+($allowance_prjprt->line_margin*($tax/100));
               $allowance_cost = $allowance_prjprt->line_margin;
               //$total_extra_allowance_cost += $allowance_prjprt->line_margin;
               $allocated_allowance_amount = $this->reports->gettotalallowanceamount($allowance_prjprt->costing_part_id);
               $invoiced = $this->reports->gettotalactualamount($allowance_prjprt->costing_part_id);
              
               $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
               
               //$total_extra_allowance_cost+=number_format((($invoiced_amount)+($invoiced_amount*($tax/100))), 2, ".", "") - $allowance_cost;
               $total_extra_allowance_cost+=$invoiced_amount - $allowance_cost;
           }
           
        }
        else{
            $total_extra_allowance_cost = 0;
        }
       
        if($this->reports->get_extra_allowance_sales_cost($project_id['project_id'])){
          $total_extra_allowance_sales_cost = $this->reports->get_extra_allowance_sales_cost($project_id['project_id']);
        }
        else{
          $total_extra_allowance_sales_cost = 0;
        }
        
        $totalcashtransfers=$this->reports->gettotalcashtransfersbyproject_id($project_id['project_id']);
        
        if($this->reports->get_total_credit_invoices($pc_detail->costing_id)){
          $total_credit_invoices = $this->reports->get_total_credit_invoices($pc_detail->costing_id);
        }
        else{
          $total_credit_invoices = 0;
        }
        
        if($this->reports->get_total_credit_notes($pc_detail->costing_id)){
          $total_credit_notes = $this->reports->get_total_credit_notes($pc_detail->costing_id);
        }
        else{
          $total_credit_notes = 0;
        }
        
        $returnarr= array(
            'tcegst' => $ia,
            'total_cost' => $pc_detail->project_subtotal_1,
            'overhead_margin' => $pc_detail->over_head_margin,
            'profit_margin' => $pc_detail->porfit_margin,
            'total_cost2' => $pc_detail->project_subtotal_2,
            'costing_tax' => $pc_detail->tax_percent,
            'total_cost3' => $pc_detail->project_subtotal_3,
            'price_rounding' => $pc_detail->price_rounding,
            'contract_price' => $pc_detail->contract_price,
            'extracostvare' => $total_extra_cost_variation ,
            'extrasalevar' => $total_extra_sales_variation_cost,
            'extracostpovare' => $total_extra_po_cost_variation ,
            'extrasalepovar' =>$total_extra_po_sales_variation_cost,
            'extracostsivare' => $total_extra_sup_cost_variation ,
            'extracostscvare' => $total_extra_sup_credit_cost_variation ,
            'extrasalesivar' => $total_extra_sup_sales_variation_cost ,
            'extrasalescvar' => $total_extra_sup_credit_sales_variation_cost ,
            'extracostallowe' => $total_extra_allowance_cost ,
            'extrasaleallow' => $total_extra_allowance_sales_cost ,
            'totalsupplierinvoicepaid' => $totalsupplierinvoicepaid,
            'totalsalesinvoicepaid' => $totalsalesinvoicepaid,
            'totalsupplierinvoicecreated' => $totalsupplierinvoicecreated,
            'totalsalesinvoicecreated' => $totalsalesinvoicecreated,
            'totalcashtransferspaid' => $totalcashtransfers,
            'total_credit_invoices' => $total_credit_invoices,
            'total_credit_notes' => $total_credit_notes,
            'totalsalescredits' => $totalsalescredits
        );
        
        $data['result']= $returnarr;
		

		$html = $this->load->view('reports/project_report/project_report_pdf', $data, true);

		$pdfFilePath = "project_report_".date('Y-m-d').".pdf";

		$this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 

	}
	
	//Export Report as Excel
	public function excel_report(){
		
		$this->load->library('excel');
		$reportdata = $this->session->userdata('reportdata');
		$costing_id = $reportdata['project_id'];
		$bankinterest = $reportdata['bankinterest'];
		
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
        
        $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
		
		$data['project_name'] = $this->project->get_project_by_name($project_id['project_id']);
        
        //total cost excluding gst
        $tcegst=0; $ia=0;
        $prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id']);
        
        foreach($prjprts as $key => $val){   
            //getinoviceamount by cpart id and costing quantity
            $ia+=$this->reports->getiabycpidandcq($val->costing_part_id,$val->costing_quantity);
        }
        $extracostvare=0;
        
        $approvedvar = $this->variation->getaprovedvarbycosid($costing_id,'normal');
        
        
        foreach ($approvedvar as $key => $value) {
            
            $extracostvare += $this->reports->getextracostvarebyvarid($value, $costing_id);
            
        }
        
        // get sum of contract price of approved variations by project id 
        $sum_norvar_contract_price=$this->reports-> getsoavbycid($costing_id,'normal');
        $sum_norvar_contract_price[0]->sum_var_contract_price=($sum_norvar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_norvar_contract_price[0]->sum_var_contract_price:0;
//        print_r($sum_var_contract_price);
        
        $extracostpovare=0;
        
        /*$approvedpovar = $this->variation->getaprovedvarbycosid($costing_id,'purord');
        
        
        foreach ($approvedpovar as $key => $value) {
            $extracostpovare += $this->reports->getextracostvarebyvarid($value, $costing_id);
        }*/
		
		$approvedpovar = $this->variation->getPurchaseOrderCost($project_id['project_id']);
		if(count($approvedpovar)>0){
		  $extracostpovare = $approvedpovar[0]['total_line_cost'];
		}
        
        
        $sum_povar_contract_price=$this->reports-> getsoavbycid($costing_id,'purord');
        $sum_povar_contract_price[0]->sum_var_contract_price=($sum_povar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_povar_contract_price[0]->sum_var_contract_price:0;
//      
        $extracostsivare=0;
        
        $approvedsivar = $this->variation->getaprovedvarbycosid($costing_id,'suppinvo');
        
//        print_r($approvedsivar);
        foreach ($approvedsivar as $key => $value) {
            $extracostsivare += $this->reports->getextracostvarebyvarid($value, $costing_id);
//            print_r($extracostsivare);
        }
        
        $sum_sivar_contract_price=$this->reports-> getsoavbycid($costing_id,'suppinvo');
        $sum_sivar_contract_price[0]->sum_var_contract_price=($sum_sivar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_sivar_contract_price[0]->sum_var_contract_price:0;

//      
        $totalsupplierinvoicepaid=$this->reports->gettotalsupplierinvoicepaidbycosting_id($costing_id);
        $totalsalesinvoicepaid=$this->reports->gettotalsaleinvoicepaidbyproject_id($project_id['project_id']);
        
        $totalsalescredits=$this->reports->gettotalsalecreditsbyproject_id($project_id['project_id']);
        
        $totalsupplierinvoicecreated=$this->reports->gettotalsupplierinvoicebycosting_id($costing_id);
        $totalsalesinvoicecreated=$this->reports->gettotalsaleinvoicebyproject_id($project_id['project_id']);


        /* Normal Variation   */

        if($this->reports->get_extra_variation_cost($project_id['project_id'])){
          $total_extra_cost_variation = $this->reports->get_extra_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_cost_variation = 0;
        }
        
        if($this->reports->get_extra_sales_variation_cost($project_id['project_id'])){
            $total_extra_sales_variation_cost = $this->reports->get_extra_sales_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_sales_variation_cost = 0;
        }

        /*  Purchase Order Variation   */

        
        if($this->reports->get_extra_po_variation_cost($project_id['project_id'])){
           $total_extra_po_cost_variation = $this->reports->get_extra_po_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_po_cost_variation = 0;
        }

        
        if($this->reports->get_extra_po_sales_variation_cost($project_id['project_id'])){
           $total_extra_po_sales_variation_cost = $this->reports->get_extra_po_sales_variation_cost($project_id['project_id']);
        } 
        else{
          $total_extra_po_sales_variation_cost = 0;
        }
       
        /*  Supplier Variation   */

        if($this->reports->get_extra_sup_variation_cost($project_id['project_id'])){
           $total_extra_sup_cost_variation = $this->reports->get_extra_sup_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_sales_variation_cost = $this->reports->get_extra_sup_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_sales_variation_cost = 0;
        }
        
        /*  Supplier Credit Variation   */

        if($this->reports->get_extra_sup_credit_variation_cost($project_id['project_id'])){
           $total_extra_sup_credit_cost_variation = $this->reports->get_extra_sup_credit_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_credit_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_credit_sales_variation_cost = $this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_credit_sales_variation_cost = 0;
        }
        
        /* Allowances  */
        
        if($this->project->get_project_costing_info($project_id['project_id'])){
           //$total_extra_allowance_cost = $this->reports->get_extra_allowance_cost($pc_detail->costing_id);
           
           $total_extra_allowance_cost = 0;
           
           
           $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
           $tax =$pc_detail->tax_percent;
           $type = "allowance";
           $allowance_prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id'], $type);
           
           foreach($allowance_prjprts as $allowance_prjprt){
               //$allowance_cost = ($allowance_prjprt->line_margin)+($allowance_prjprt->line_margin*($tax/100));
               $allowance_cost = $allowance_prjprt->line_margin;
               //$total_extra_allowance_cost += $allowance_prjprt->line_margin;
               $allocated_allowance_amount = $this->reports->gettotalallowanceamount($allowance_prjprt->costing_part_id);
               $invoiced = $this->reports->gettotalactualamount($allowance_prjprt->costing_part_id);
              
               $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
               
               //$total_extra_allowance_cost+=number_format((($invoiced_amount)+($invoiced_amount*($tax/100))), 2, ".", "") - $allowance_cost;
               $total_extra_allowance_cost+=$invoiced_amount - $allowance_cost;
           }
           
        }
        else{
            $total_extra_allowance_cost = 0;
        }
       
        if($this->reports->get_extra_allowance_sales_cost($project_id['project_id'])){
          $total_extra_allowance_sales_cost = $this->reports->get_extra_allowance_sales_cost($project_id['project_id']);
        }
        else{
          $total_extra_allowance_sales_cost = 0;
        }
       
        $totalcashtransfers=$this->reports->gettotalcashtransfersbyproject_id($project_id['project_id']);
        
        if($this->reports->get_total_credit_invoices($pc_detail->costing_id)){
          $total_credit_invoices = $this->reports->get_total_credit_invoices($pc_detail->costing_id);
        }
        else{
          $total_credit_invoices = 0;
        }
        
        if($this->reports->get_total_credit_notes($pc_detail->costing_id)){
          $total_credit_notes = $this->reports->get_total_credit_notes($pc_detail->costing_id);
        }
        else{
          $total_credit_notes = 0;
        }
        
        $result = array(
            'tcegst' => $ia,
            'total_cost' => $pc_detail->project_subtotal_1,
            'overhead_margin' => $pc_detail->over_head_margin,
            'profit_margin' => $pc_detail->porfit_margin,
            'total_cost2' => $pc_detail->project_subtotal_2,
            'costing_tax' => $pc_detail->tax_percent,
            'total_cost3' => $pc_detail->project_subtotal_3,
            'price_rounding' => $pc_detail->price_rounding,
            'contract_price' => $pc_detail->contract_price,
            'extracostvare' => $total_extra_cost_variation ,
            'extrasalevar' => $total_extra_sales_variation_cost,
            'extracostpovare' => $total_extra_po_cost_variation ,
            'extrasalepovar' =>$total_extra_po_sales_variation_cost,
            'extracostsivare' => $total_extra_sup_cost_variation ,
            'extracostscvare' => $total_extra_sup_credit_cost_variation ,
            'extrasalesivar' => $total_extra_sup_sales_variation_cost ,
            'extrasalescvar' => $total_extra_sup_credit_sales_variation_cost ,
            'extracostallowe' => $total_extra_allowance_cost ,
            'extrasaleallow' => $total_extra_allowance_sales_cost ,
            'totalsupplierinvoicepaid' => $totalsupplierinvoicepaid,
            'totalsalesinvoicepaid' => $totalsalesinvoicepaid,
            'totalsupplierinvoicecreated' => $totalsupplierinvoicecreated,
            'totalsalesinvoicecreated' => $totalsalesinvoicecreated,
            'totalcashtransfers' => $totalcashtransfers,
            'total_credit_invoices' => $total_credit_invoices,
            'total_credit_notes' => $total_credit_notes,
            'totalsalescredits' => $totalsalescredits
        );
        
       
        
		
        $my_data = array();
       
		$count = 1;
		$key=0;
		$my_data[$key]['td1']="Project Title :";
		$my_data[$key]['td2']=$data['project_name']['project_title'];
		$key++;
		$my_data[$key]['td1']="Project Costing subtotal";
		$my_data[$key]['td2']="$".number_format($result['total_cost'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Overhead margin";
		$my_data[$key]['td2']=$result['overhead_margin']."%";
		$key++;
		$my_data[$key]['td1']="Profit margin";
		$my_data[$key]['td2']=$result['profit_margin']."%";
		$key++;
		$my_data[$key]['td1']="Project subtotal";
		$my_data[$key]['td2']="$".number_format($result['total_cost2'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Tax";
		$my_data[$key]['td2']=$result['costing_tax']."%";
		$key++;
		$my_data[$key]['td1']="Project subtotal";
		$my_data[$key]['td2']="$".number_format($result['total_cost3'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Project price rounding";
		$my_data[$key]['td2']="$".number_format($result['price_rounding'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Project contract price";
		$my_data[$key]['td2']="$".number_format($result['contract_price'], 2, '.', ',')." ";
		$key++;
		$total_profit = number_format($result['contract_price'],2,'.','')-number_format(($result['total_cost']*(100+$result['costing_tax'])/100),2,'.','');
		$my_data[$key]['td1']="Projected profit";
		$my_data[$key]['td2']="$".number_format($total_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from variations excluding GST";
		$my_data[$key]['td2']="$".number_format($result['extracostvare'], 2, '.', ',')." ";
		$key++;
		
		$my_data[$key]['td1']="Extra costs from variations including GST";
		$my_data[$key]['td2']="$".number_format($result['extracostvare']*((100+$result['costing_tax'])/100), 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra sales from variations";
		$my_data[$key]['td2']="$".number_format($result['extrasalevar'], 2, '.', '')." ";
		$key++;
		$my_data[$key]['td1']="Profit from variations including GST";
                $sale_profit = number_format($result['extrasalevar']-($result['extracostvare']*((100+$result['costing_tax'])/100)), 2, '.', '');
		$my_data[$key]['td2']="$".number_format($sale_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from purchase orders variations excluding GST";
		$my_data[$key]['td2']="$".number_format($result['extracostpovare'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from purchase orders variations including GST";
		$my_data[$key]['td2']="$".number_format($result['extracostpovare']*((100+$result['costing_tax'])/100), 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra sales from purchase orders variations";
		$my_data[$key]['td2']="$".number_format($result['extrasalepovar'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Profit from purchase orders variations including GST";
                $po_profit = number_format($result['extrasalepovar']-($result['extracostpovare']*((100+$result['costing_tax'])/100)), 2, '.', '');
		$my_data[$key]['td2']="$".number_format($po_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from supplier invoices variations excluding GST";
		$my_data[$key]['td2']="$".number_format($result['extracostsivare'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from supplier invoices variations including GST";
		$my_data[$key]['td2']="$".number_format($result['extracostsivare']*((100+$result['costing_tax'])/100), 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra sales from supplier invoices variations";
		$my_data[$key]['td2']="$".number_format($result['extrasalesivar'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Profit from supplier invoices variations";
                $supplier_profit = number_format($result['extrasalesivar']-($result['extracostsivare']*((100+$result['costing_tax'])/100)), 2, '.', '');
		$my_data[$key]['td2']="$".number_format($supplier_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from supplier credits variations excluding GST";
		$my_data[$key]['td2']="$".number_format($result['extracostscvare'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from supplier credits variations including GST";
		$extracostsuppliercreditsvar = number_format($result['extracostscvare']*((100+$result['costing_tax'])/100), 2, '.', '');
		$my_data[$key]['td2']="$".number_format($result['extracostscvare']*((100+$result['costing_tax'])/100), 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra sales from supplier credits variations";
		$my_data[$key]['td2']="$".number_format($result['extrasalescvar'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Profit from supplier credits variations";
                $supplier_profit = number_format($result['extrasalescvar']-($result['extracostscvare']*((100+$result['costing_tax'])/100)), 2, '.', '');
		$my_data[$key]['td2']="$".number_format($supplier_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from allowances excluding GST";
		$my_data[$key]['td2']="$".number_format($result['extracostallowe'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Extra costs from allowances including GST";
		$my_data[$key]['td2']="$".number_format($result['extracostallowe']*((100+$result['costing_tax'])/100), 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Current and Pending Sales from Allowances";
		$my_data[$key]['td2']="$".number_format($result['extracostallowe']*((100+$result['costing_tax'])/100), 2, '.', ',')." ";
		//$my_data[$key]['td2']="$".number_format($result['extrasaleallow'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Profit from allowances";
                $allowance_profit = number_format(($result['extracostallowe']*((100+$result['costing_tax'])/100))-($result['extracostallowe']*((100+$result['costing_tax'])/100)), 2, '.', '');
		$my_data[$key]['td2']="$".number_format($allowance_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Updated Project Cost including GST";
		$updated_project_cost = (number_format(($result['total_cost']*((100+$result['costing_tax'])/100)), 2, '.', '')+number_format(($result['extracostvare']*((100+$result['costing_tax'])/100)), 2, '.', '')+number_format($result['extracostpovare']*((100+$result['costing_tax'])/100), 2, '.', '')+number_format(($result['extracostsivare']*((100+$result['costing_tax'])/100)), 2, '.', '')+number_format($result['extracostallowe']*((100+$result['costing_tax'])/100), 2, '.', ''))-$extracostsuppliercreditsvar;
        $my_data[$key]['td2']="$".number_format($updated_project_cost, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Updated Project Contract Price including GST";
        $updated_project_contract_price = (number_format($result['contract_price'], 2, '.', '')+number_format($result['extrasalevar'], 2, '.', '')+number_format($result['extrasalepovar'], 2, '.', '')+number_format($result['extrasalesivar'], 2, '.', '')+number_format(($result['extracostallowe']*((100+$result['costing_tax'])/100)), 2, '.', ''))-number_format($result['extrasalescvar'], 2, '.', '');
        $my_data[$key]['td2']="$".number_format($updated_project_contract_price, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Updated Profit including GST";
        //$total_updated_profit = number_format($total_profit, 2, '.', '')+number_format($sale_profit, 2, '.', '') +number_format($po_profit, 2, '.', '')+number_format($supplier_profit, 2, '.', '')+number_format($allowance_profit, 2, '.', ',');
		$total_updated_profit = number_format($updated_project_contract_price, 2, '.', '')-number_format($updated_project_cost, 2, '.', '');
		$my_data[$key]['td2']="$".number_format($total_updated_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="PROFIT DIFFERENCE including GST";
        $profit_difference = number_format($total_updated_profit, 2, '.', '')-number_format($total_profit, 2, '.', '');
		$my_data[$key]['td2']="$".number_format($profit_difference, 2, '.', ',')." ";
		$key++;
		/*$my_data[$key]['td1']="Total Supplier Invoices Created including GST";
        $supplier_invoices_created = ($result['totalsupplierinvoicecreated']*((100+$result['costing_tax'])/100));
        $my_data[$key]['td2']="$".number_format($supplier_invoices_created, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Total Supplier credits created including GST";
        $total_supplier_credits = ($result['total_credit_notes']*($result['costing_tax']/100))+$result['total_credit_notes'];
        $my_data[$key]['td2']="$".number_format($total_supplier_credits, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Supplier Invoices paid from bank including GST";
        $supplier_invoices_paid = ($result['totalsupplierinvoicepaid']*((100+$result['costing_tax'])/100)); 
		$my_data[$key]['td2']="$".number_format($supplier_invoices_paid, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Supplier Invoices paid by Supplier Credit including GST";
        $supplier_invoices_paid_by_supplier_credit = $result['extracostscvare']*((100+$result['costing_tax'])/100);
		$my_data[$key]['td2']="$".number_format($supplier_invoices_paid_by_supplier_credit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Supplier Invoices unpaid including GST";
        $supplier_invoices_unpaid = number_format($supplier_invoices_created,2,'.','')-number_format($supplier_invoices_paid,2,'.','')-number_format($supplier_invoices_paid_by_supplier_credit,2,'.',''); 
        $my_data[$key]['td2']="$".number_format($supplier_invoices_unpaid, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Future Supplier Invoices including GST";
		$futuresupplierinvoices = number_format($updated_project_cost,2,'.','')-number_format($supplier_invoices_created,2,'.','')-number_format($total_supplier_credits,2,'.','');
		$my_data[$key]['td2']="$".number_format($futuresupplierinvoices, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Total Sales Invoices Created including GST";
		$my_data[$key]['td2']="$".number_format($result['totalsalesinvoicecreated'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Total Sales Credits Created including GST";
		$my_data[$key]['td2']="$".number_format($result['totalsalescredits'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Sales Invoices Paid including GST";
		$my_data[$key]['td2']="$".number_format($result['totalsalesinvoicepaid'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Sales Invoices Unpaid including GST";
        $salesinunpaid = number_format($result['totalsalesinvoicecreated'], 2, '.', '')-number_format($result['totalsalescredits'], 2, '.', '')-number_format($result['totalsalesinvoicepaid'], 2, '.', '');
        $my_data[$key]['td2']="$".number_format($salesinunpaid, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Future Sales Invoices including GST";
        $futuresalesinvoices = number_format($updated_project_contract_price, 2, '.', '')-number_format($result['totalsalesinvoicepaid'], 2, '.', ''); 
		$my_data[$key]['td2']="$".number_format($futuresalesinvoices, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Total Cash Transfers";
		$my_data[$key]['td2']="$".number_format($result['totalcashtransfers'], 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Bank Interest";
		$my_data[$key]['td2']="$".number_format($bankinterest, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Bank Balance";
		$bank_balance = number_format($total_supplier_credits+($result['totalsalesinvoicepaid'])-($supplier_invoices_paid)-($result['totalcashtransfers'])+$bankinterest, 2, '.', '');
		$my_data[$key]['td2']="$".number_format($bank_balance, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="FUTURE CASH REQUIRED";
		$future_cash_required = number_format($supplier_invoices_unpaid, 2, '.', '') + number_format($futuresupplierinvoices, 2, '.', '');
		$my_data[$key]['td2']="$".number_format($future_cash_required, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="FUTURE CASH AVAILABLE";
		$future_cash_available = number_format($salesinunpaid, 2, '.', '') + number_format($futuresalesinvoices, 2, '.', '') + number_format($bank_balance, 2, '.', '');
		$my_data[$key]['td2']="$".number_format($future_cash_available, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="PROJECTED FINAL CASH";
		$projected_final_cash = number_format($future_cash_available, 2, '.', '') - number_format($future_cash_required, 2, '.', '');	
		$my_data[$key]['td2']="$".number_format($projected_final_cash, 2, '.', ',')." ";
		$key++;*/
		
		$all_data = $my_data;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Project Report');

        /*$this->excel->getActiveSheet()
        ->getStyle('A1:B1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('#f56700');
		$this->excel->getActiveSheet()->getStyle('A1:B1')->getFont()->getColor()->setARGB('#FFFFFF');
		
		$this->excel->getActiveSheet()
        ->getStyle('A2:B34')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('#fcfc4d');
		
		
		$this->excel->getActiveSheet()
        ->getStyle('A1:B1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('#ffc000');*/
		
		

        $this->excel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B2:B'.$key)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $styleArray = array(
           'font'  => array(
             'color' => array('rgb' => '0000ff')
        ));
        $this->excel->getActiveSheet()->getStyle('A31')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A32')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A33')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A34')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('B31')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('B32')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('B33')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('B34')->applyFromArray($styleArray);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename="project_report_".date('Y-m-d').".xls"; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		//print($tofile);
		}
	
	//Get Variations used in Project Report
	public function get_variations(){
	    $costing_id = $this->input->post('project_id');
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
	    $type = $this->input->post('type');
        $data['variations'] = $this->reports->get_variations($project_id['project_id'], $type);
        foreach($data['variations'] as $key => $val){

            $extracostvari=$this->reports->getextracostvarebyvarid($val->id, $val->costing_id,'sales');

            $project_title = $this->project->get_project_by_name($val->project_id);

            $data['variations'][$key]->project_title = $project_title['project_title'];

            $data['variations'][$key]->variation_amount=$extracostvari['total'];



        }
        $data['type']=$type;
        $this->load->view('reports/project_report/variation_table', $data);
	    
	}
	
	//Get Cash Transfers used in Project Report
	public function get_cash_transfers(){
	    $costing_id = $this->input->post('project_id');
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
	    
        $data['cash_transfers'] = $this->reports->get_cash_transfers($project_id['project_id']);
        $data['project_info'] = $this->project->get_project_by_name($project_id['project_id']);
        $this->load->view('reports/project_report/cash_transfers_table', $data);
	    
	}
	
	//Get Sales Credits used in Project Report
	public function get_sales_credits(){
	    $costing_id = $this->input->post('project_id');
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
	    
        $data['credit_notes'] = $this->reports->get_sales_credits($project_id['project_id']);
        
        $data['project_info'] = $this->project->get_project_by_name($project_id['project_id']);
        $this->load->view('reports/project_report/sales_credits_table', $data);
        
		}
	
	//Get Sales Invoices used in Project Report
	public function get_sales_invoices(){
	    $costing_id = $this->input->post('project_id');
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
	    
        $data['sales_invoices'] = $this->reports->get_sales_invoices($project_id['project_id']);
       
        
        foreach ($data['sales_invoices'] as $key => $value) {


            $cwhere= array('company_id'=> $value['created_by'] );
            $usersname = $this->common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['cuser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['cuser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['created']= count($usersname);


            $cwhere= array('company_id'=> $value['approved_by'] );
            $usersname = $this->common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['auser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['auser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['approved']= count($usersname);


            $cwhere= array('company_id'=> $value['exported_by'] );
            $usersname = $this->common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['euser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['euser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['exported']= count($usersname);
        }

       
        $data['project_info'] = $this->project->get_project_by_name($project_id['project_id']);
        $this->load->view('reports/project_report/sales_invoices_table', $data);
	    
	}
	
	//Get Supplier Invoices used in Project Report
	public function get_credit_invoices(){
	    $costing_id = $this->input->post('project_id');
	    $type = $this->input->post('type');
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
	    
        $data['credit_invoices'] = $this->reports->get_credit_invoices($costing_id, $type);
       
        $data['project_info'] = $this->project->get_project_by_name($project_id['project_id']);
    
        if($type==""){
          $this->load->view('reports/project_report/credit_invoices_table', $data);
        }
        else{
          $this->load->view('reports/project_report/allowance_invoices_table', $data);  
        }
	    
	}
	
	public function get_allowance_invoices(){
	    $costing_id = $this->input->post('project_id');
	    $project_id=$this->project->get_project_id_from_costing_id($costing_id);
	    $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
        $data["tax"] =$pc_detail->tax_percent;
	    $data['allowance_costing_parts'] = $this->reports->getAllowanceInvoicesParts($costing_id);
	    $costing_part_invoices = array();
	    if(count($data['allowance_costing_parts'])>0){
    	    foreach($data['allowance_costing_parts'] as $key => $costing_part){
    	        $invoices = $this->reports->get_allowance_invoices($costing_id, $costing_part["costing_part_id"]);
    	        if(count($invoices)>0){
    	            foreach($invoices as $invoice){
    	               $data['allowance_costing_parts'][$key][$costing_part["costing_part_id"]][] = $invoice;
    	            }
    	        }
    	    }
	    }
	    $this->load->view('reports/project_report/allowance_invoices_table', $data);  
	}
	
	//Get Supplier Credit Notes used in Project Report
	public function get_credit_notes(){
	    $costing_id = $this->input->post('project_id');
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
	    
        $data['credit_notes'] = $this->reports->get_credit_notes($costing_id);
        $project_id = $this->project->get_project_id_from_costing_id($costing_id);
        $data['project_info'] = $this->project->get_project_by_name($project_id["project_id"]);
        $this->load->view('reports/project_report/credit_notes_table', $data);
	}
	
	/* Project Report Section Ends Here */
	
	/* Project Summary Report Section Starts Here */
	
	//Project Summary Report Screen
	public function project_summary(){
        $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
        $this->stencil->title('Project Summary');
	    $this->stencil->paint('reports/project_summary/view_project_summary', $data);
	}
	
	//Get Project Summary
	public function get_project_summary(){
		
		$project_id = $this->input->post('project_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		
		$data['project_name'] = $this->project->get_project_by_name($project_id);
		
		$data['supplier_invoices'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "supplier_invoices");
		
		$data['supplier_credit_notes'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "supplier_credit_notes");
		
		$data['sales_invoices'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "sales_invoices");
		
		$data['sales_credit_notes'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "sales_credit_notes");
		
        $html = $this->load->view('reports/project_summary/project_summary_ajax', $data);
	}
	
	//Export Project Summary Report
	function project_summary_report(){
       	
		$project_id = $this->input->post('project_id');
		$start_date = $this->input->post('invoice_start_date');
		$end_date = $this->input->post('invoice_end_date');
		
		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
        
        $data['project_name'] = $this->project->get_project_by_name($project_id);
		
		$data['supplier_invoices'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "supplier_invoices");
		
		$data['supplier_credit_notes'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "supplier_credit_notes");
		
		$data['sales_invoices'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "sales_invoices");
		
		$data['sales_credit_notes'] = $this->reports->get_project_summary($project_id, $start_date, $end_date, "sales_credit_notes");
		
		if(isset($_POST['pdf_report'])){
		    
		$this->load->library('M_pdf');
		
        $html = $this->load->view('reports/project_summary/project_summary_pdf', $data, true);

		$pdfFilePath = "project_summary_report_".date('Y-m-d').".pdf";
		$this->m_pdf->pdf->WriteHTML($html); 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
		else{
		    
		    $this->load->library('excel');
		    
		    $my_data_titles = array(
            array(
            'sr_no'                  =>  '',
            'Date'                   =>  'Date',
            'Supplier'               =>  'Supplier',
			'Amount'                 =>  'Amount'
            )
        );
        $my_data = array();
		$key=0;
		         $my_data[$key]['sr_no'] = "";
				 $my_data[$key]['Date'] = stripslashes($data['project_name']['project_title']);
				 $my_data[$key]['Supplier'] ="";
				 $my_data[$key]['Amount'] = "";
				 if(count($data['sales_invoices'])>0){
				 $row = 0;
				 $total_sales_invoices = 0;
				 foreach($data['sales_invoices'] as $val){
				 $key++;
				 if($row==0){
                 $my_data[$key]['sr_no'] = "Sales Invoices";
				 }
				 else{
				    $my_data[$key]['sr_no'] =""; 
				 }
				 $my_data[$key]['Date'] = date("d-M-Y", strtotime($val['date_created']));
				 $my_data[$key]['Supplier'] =$val['supplier_name'];
				 $my_data[$key]['Amount'] = "$".number_format($val['invoice_amount'],2,'.',',');
				 $row++;
				 $total_sales_invoices += $val['invoice_amount'];
				 }
				 $key++;
				 $my_data[$key]['sr_no'] = "Total";
				 $my_data[$key]['Date'] = "";
				 $my_data[$key]['Supplier'] ="";
				 $my_data[$key]['Amount'] = "$".number_format($total_sales_invoices,2,'.',',');
		         }
		         else{
		            $key++;
		            $my_data[$key]['sr_no'] = "Sales Invoices";
		            $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "";
				    $key++;
				    $my_data[$key]['sr_no'] = "Total";
				    $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "$".number_format(0,2,'.',',');
		         }
		         $key++;
		            $my_data[$key]['sr_no'] = "";
		            $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "";
		         if(count($data['sales_credit_notes'])>0){
				 $row = 0;
				 $total_sales_credit_notes = 0;
				 foreach($data['sales_credit_notes'] as $val){
				 $key++;
				 if($row==0){
                 $my_data[$key]['sr_no'] = "Sales Credit Notes";
				 }
				 else{
				    $my_data[$key]['sr_no'] =""; 
				 }
				 $my_data[$key]['Date'] = date("d-M-Y", strtotime($val['date']));
				 $my_data[$key]['Supplier'] =$val['supplier_name'];
				 $my_data[$key]['Amount'] = "$".number_format($val['subtotal'],2,'.',',');
				 $row++;
				 $total_sales_credit_notes += $val['subtotal'];
				 }
				 $key++;
				 $my_data[$key]['sr_no'] = "Total";
				 $my_data[$key]['Date'] = "";
				 $my_data[$key]['Supplier'] ="";
				 $my_data[$key]['Amount'] = "$".number_format($total_sales_credit_notes,2,'.',',');
		         }
		         else{
		            $key++;
		            $my_data[$key]['sr_no'] = "Sales Credit Notes";
		            $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "";
				    $key++;
				    $my_data[$key]['sr_no'] = "Total";
				    $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "$".number_format(0,2,'.',',');
		         }
		         $key++;
		            $my_data[$key]['sr_no'] = "";
		            $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "";
		         if(count($data['supplier_invoices'])>0){
				 $row = 0;
				 $total_supplier_invoices = 0;
				 foreach($data['supplier_invoices'] as $val){
				 $key++;
				 if($row==0){
                 $my_data[$key]['sr_no'] = "Supplier Invoices";
				 }
				 else{
				    $my_data[$key]['sr_no'] =""; 
				 }
				 
                 $invoice_date = str_replace("/", "-", $val['invoice_date']);
                 $invoice_date = date("Y-m-d", strtotime($invoice_date));
                
				 $my_data[$key]['Date'] =  date("d-M-Y", strtotime($invoice_date));
				 $my_data[$key]['Supplier'] =$val['supplier_name'];
				 $my_data[$key]['Amount'] = "$".number_format($val['invoice_amount'],2,'.',',');
				 $row++;
				 $total_supplier_invoices += $val['invoice_amount'];
				 }
				 $key++;
				 $my_data[$key]['sr_no'] = "Total";
				 $my_data[$key]['Date'] = "";
				 $my_data[$key]['Supplier'] ="";
				 $my_data[$key]['Amount'] = "$".number_format($total_supplier_invoices,2,'.',',');
		         }
		         else{
		            $key++;
		            $my_data[$key]['sr_no'] = "Supplier Invoices";
		            $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "";
				    $key++;
				    $my_data[$key]['sr_no'] = "Total";
				    $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "$".number_format(0,2,'.',',');
		         }
				 $key++;
		            $my_data[$key]['sr_no'] = "";
		            $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "";
				 if(count($data['supplier_credit_notes'])>0){
				 $row = 0;
				 
				 $total_supplier_credit_notes = 0;
				 
				 foreach($data['supplier_credit_notes'] as $val){
				 $key++;
				 if($row==0){
                 $my_data[$key]['sr_no'] = "Supplier Credit Notes";
				 }
				 else{
				    $my_data[$key]['sr_no'] =""; 
				 }
				 $my_data[$key]['Date'] =  date("d-M-Y", strtotime($val['date']));
				 $my_data[$key]['Supplier'] =$val['supplier_name'];
				 $my_data[$key]['Amount'] = "$".number_format($val['subtotal'],2,'.',',');
				 $row++;
				 $total_supplier_credit_notes += $val['subtotal'];
				 }
				 $key++;
				 $my_data[$key]['sr_no'] = "Total";
				 $my_data[$key]['Date'] = "";
				 $my_data[$key]['Supplier'] ="";
				 $my_data[$key]['Amount'] = "$".number_format($total_supplier_credit_notes,2,'.',',');
		         }
		         else{
		            $key++;
		            $my_data[$key]['sr_no'] = "Supplier Credit Notes";
		            $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "";
				    $key++;
				    $my_data[$key]['sr_no'] = "Total";
				    $my_data[$key]['Date'] = "";
				    $my_data[$key]['Supplier'] ="";
				    $my_data[$key]['Amount'] = "$".number_format(0,2,'.',',');
		         }
				
		
		$all_data = array_merge($my_data_titles, $my_data);

		$total_records = $key+3;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Project Summary Report');


		$this->excel->getActiveSheet()->getStyle('A2:D2')->getFont()->getColor()->setRGB('FFFFFF');
		
		$this->excel->getActiveSheet()
        ->getStyle('A2:D2')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('000000');
		
	
        $this->excel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D2:D'.$total_records)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename='project_summary_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		
		}
   }
   
    /* Project Summary Report Section Ends Here */
    
    //Update Bank Interest via Project Report
    function update_bank_interest(){
        
        $costing_id = $this->input->post("project_id");
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
        $bank_interest = $this->input->post("bank_interest");
        $where = array('project_id' => $project_id['project_id']);
        $upd_array = array(
                       "bank_interest" => $bank_interest
                     );
        $this->common->update_table('project_projects', $where, $upd_array);
    }
   
   /* Work In Progress Report Section Starts Here */
   
   //Work In Progress Report Screen
   public function workInProgress() {
        $this->common->is_company_page_accessible(48);
        $data['projects'] = $this->project->get_existing_project(); 
        $this->stencil->title('Work In Progress Report');
	    $this->stencil->paint('reports/workInProgress/view_work_in_progress', $data);
    }
    
   //Get Work In Progress Report 
   public function getworkinprogressbyprj_id(){
        
        $costing_id = $_POST['project_id'];
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
        
        $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
        
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        
        //print_r($pc_detail);exit;
        
        //total cost excluding gst
        $tcegst=0; $ia=0;
        $prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id']);
        foreach($prjprts as $key => $val){   
            //getinoviceamount by cpart id and costing quantity
            $ia+=$this->reports->getiabycpidandcq($val->costing_part_id,$val->costing_quantity);
        }
        $extracostvare=0;
        
        $approvedvar = $this->variation->getaprovedvarbycosid($costing_id,'normal');
        
        
        foreach ($approvedvar as $key => $value) {
            
            $extracostvare += $this->reports->getextracostvarebyvarid($value, $costing_id);
            
        }
        
        // get sum of contract price of approved variations by project id 
        $sum_norvar_contract_price=$this->reports-> getsoavbycid($costing_id,'normal');
        $sum_norvar_contract_price[0]->sum_var_contract_price=($sum_norvar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_norvar_contract_price[0]->sum_var_contract_price:0;
//        print_r($sum_var_contract_price);
        
        $extracostpovare=0;
        
        /*$approvedpovar = $this->variation->getaprovedvarbycosid($costing_id,'purord');*/
        
        
        /*foreach ($approvedpovar as $key => $value) {
            $extracostpovare += $this->reports->getextracostvarebyvarid($value, $costing_id);
        }*/
        $approvedpovar = $this->variation->getPurchaseOrderCost($project_id['project_id']);
		if(count($approvedpovar)>0){
		  $extracostpovare = $approvedpovar[0]['total_line_cost'];
		}
        
        $sum_povar_contract_price=$this->reports-> getsoavbycid($costing_id,'purord');
        $sum_povar_contract_price[0]->sum_var_contract_price=($sum_povar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_povar_contract_price[0]->sum_var_contract_price:0;
//      
        $extracostsivare=0;
        
        $approvedsivar = $this->variation->getaprovedvarbycosid($costing_id,'suppinvo');
        

        foreach ($approvedsivar as $key => $value) {
            $extracostsivare += $this->reports->getextracostvarebyvarid($value, $costing_id);
        }
        
        $extracostscvare=0;
        
        $approvedscvar = $this->variation->getaprovedvarbycosid($costing_id,'supcredit');
        

        foreach ($approvedscvar as $key => $value) {
            $extracostscvare += $this->reports->getextracostvarebyvarid($value, $costing_id);
        }
        
        $sum_sivar_contract_price=$this->reports-> getsoavbycid($costing_id,'suppinvo');
        $sum_sivar_contract_price[0]->sum_var_contract_price=($sum_sivar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_sivar_contract_price[0]->sum_var_contract_price:0;

            
        $totalsupplierinvoicepaid=$this->reports->gettotalsupplierinvoicepaidbycosting_id($costing_id);
        $totalsalesinvoicepaid=$this->reports->gettotalsaleinvoicepaidbyproject_id($project_id['project_id']);
        $totalsalescredits=$this->reports->gettotalsalecreditsbyproject_id($project_id['project_id']);
        
        $totalsupplierinvoicecreated=$this->reports->gettotalsupplierinvoicebycosting_id($costing_id, $start_date, $end_date);
        $totalsalesinvoicecreated=$this->reports->gettotalsaleinvoicebyproject_id($project_id['project_id'], $start_date, $end_date);

        /* Normal Variation   */

        if($this->reports->get_extra_variation_cost($project_id['project_id'])){
          $total_extra_cost_variation = $this->reports->get_extra_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_cost_variation = 0;
        }
        
        if($this->reports->get_extra_sales_variation_cost($project_id['project_id'])){
            $total_extra_sales_variation_cost = $this->reports->get_extra_sales_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_sales_variation_cost = 0;
        }

        /*  Purchase Order Variation   */

        
        if($this->reports->get_extra_po_variation_cost($project_id['project_id'])){
           $total_extra_po_cost_variation = $this->reports->get_extra_po_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_po_cost_variation = 0;
        }

        
        if($this->reports->get_extra_po_sales_variation_cost($project_id['project_id'])){
           $total_extra_po_sales_variation_cost = $this->reports->get_extra_po_sales_variation_cost($project_id['project_id']);
        } 
        else{
          $total_extra_po_sales_variation_cost = 0;
        }
       
        /*  Supplier Variation   */

        if($this->reports->get_extra_sup_variation_cost($project_id['project_id'])){
           $total_extra_sup_cost_variation = $this->reports->get_extra_sup_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_sales_variation_cost = $this->reports->get_extra_sup_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_sales_variation_cost = 0;
        }
        
        /*  Supplier Credit Variation   */

        if($this->reports->get_extra_sup_credit_variation_cost($project_id['project_id'])){
           $total_extra_sup_credit_cost_variation = $this->reports->get_extra_sup_credit_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_credit_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_credit_sales_variation_cost = $this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_credit_sales_variation_cost = 0;
        }
        
        /* Allowances  */
        
        if($this->project->get_project_costing_info($project_id['project_id'])){
           //$total_extra_allowance_cost = $this->reports->get_extra_allowance_cost($pc_detail->costing_id);
           
           $total_extra_allowance_cost = 0;
           
           
           $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
           $tax =$pc_detail->tax_percent;
           $type = "allowance";
           $allowance_prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id'], $type);
           
           foreach($allowance_prjprts as $allowance_prjprt){
               //$allowance_cost = ($allowance_prjprt->line_margin)+($allowance_prjprt->line_margin*($tax/100));
               $allowance_cost = $allowance_prjprt->line_margin;
               //$total_extra_allowance_cost += $allowance_prjprt->line_margin;
               $allocated_allowance_amount = $this->reports->gettotalallowanceamount($allowance_prjprt->costing_part_id);
               $invoiced = $this->reports->gettotalactualamount($allowance_prjprt->costing_part_id);
              
               $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
               
               //$total_extra_allowance_cost+=number_format((($invoiced_amount)+($invoiced_amount*($tax/100))), 2, ".", "") - $allowance_cost;
               $total_extra_allowance_cost+=$invoiced_amount - $allowance_cost;
           }
          
           
        }
        else{
            $total_extra_allowance_cost = 0;
        }
       
        if($this->reports->get_extra_allowance_sales_cost($project_id['project_id'])){
          $total_extra_allowance_sales_cost = $this->reports->get_extra_allowance_sales_cost($project_id['project_id']);
        }
        else{
          $total_extra_allowance_sales_cost = 0;
        }
        
        if($this->reports->get_total_credit_invoices($pc_detail->costing_id)){
          $total_credit_invoices = $this->reports->get_total_credit_invoices($pc_detail->costing_id);
        }
        else{
          $total_credit_invoices = 0;
        }
        
        if($this->reports->get_total_credit_notes($pc_detail->costing_id)){
          $total_credit_notes = $this->reports->get_total_credit_notes($pc_detail->costing_id);
        }
        else{
          $total_credit_notes = 0;
        }
 
        
         $totalcashtransfers = $this->reports->gettotalcashtransfersbyproject_id($project_id['project_id']);
         $totalbankinterest = $this->reports->gettotalbankinterestbyproject_id($project_id['project_id']);
        
        $returnarr= array(
            'tcegst' => $ia,
            'total_cost' => $pc_detail->project_subtotal_1,
            'overhead_margin' => $pc_detail->over_head_margin,
            'profit_margin' => $pc_detail->porfit_margin,
            'total_cost2' => $pc_detail->project_subtotal_2,
            'costing_tax' => $pc_detail->tax_percent,
            'total_cost3' => $pc_detail->project_subtotal_3,
            'price_rounding' => $pc_detail->price_rounding,
            'contract_price' => $pc_detail->contract_price,
            'extracostvare' => $total_extra_cost_variation ,
            'extrasalevar' => $total_extra_sales_variation_cost,
            'extracostpovare' => $total_extra_po_cost_variation ,
            'extrasalepovar' =>$total_extra_po_sales_variation_cost,
            'extracostsivare' => $total_extra_sup_cost_variation ,
            'extracostscvare' => $total_extra_sup_credit_cost_variation ,
            'extrasalesivar' => $total_extra_sup_sales_variation_cost ,
            'extrasalescvar' => $total_extra_sup_credit_sales_variation_cost ,
            'extracostallowe' => $total_extra_allowance_cost ,
            'extrasaleallow' => $total_extra_allowance_sales_cost ,
            'totalsupplierinvoicepaid' => $totalsupplierinvoicepaid,
            'totalsalesinvoicepaid' => $totalsalesinvoicepaid,
            'totalsupplierinvoicecreated' => $totalsupplierinvoicecreated,
            'totalsalesinvoicecreated' => $totalsalesinvoicecreated,
            'totalcashtransfers' => $totalcashtransfers,
            'totalbankinterest' => $totalbankinterest,
            'total_credit_invoices' => $total_credit_invoices,
            'total_credit_notes' => $total_credit_notes,
            'totalsalescredits' => $totalsalescredits
        );
        
        echo json_encode($returnarr);
         
    }
    
   //Export Work In Progress Report
   public function export_work_in_progress_report(){
		
		$data["contigency_of_contract_budget"] = $contigency_of_contract_budget = $this->input->post('contigency_of_contract_budget');
		$data["start_date"] = $start_date = $this->input->post('start_date');
		$data["end_date"] = $end_date = $this->input->post('end_date');
		$costing_id = $this->input->post('project_id');
		
		
        $project_id=$this->project->get_project_id_from_costing_id($costing_id);
        
        $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
        
        $cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$data['project_name'] = $this->project->get_project_by_name($project_id['project_id']);
        
        //total cost excluding gst
        $tcegst=0; $ia=0;
        $prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id']);
        
        foreach($prjprts as $key => $val){   
            //getinoviceamount by cpart id and costing quantity
            $ia+=$this->reports->getiabycpidandcq($val->costing_part_id,$val->costing_quantity);
        }
        $extracostvare=0;
        
        $approvedvar = $this->variation->getaprovedvarbycosid($costing_id,'normal');
        
        
        foreach ($approvedvar as $key => $value) {
            
            $extracostvare += $this->reports->getextracostvarebyvarid($value, $costing_id);
            
        }
        
        // get sum of contract price of approved variations by project id 
        $sum_norvar_contract_price=$this->reports-> getsoavbycid($costing_id,'normal');
        $sum_norvar_contract_price[0]->sum_var_contract_price=($sum_norvar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_norvar_contract_price[0]->sum_var_contract_price:0;
//        print_r($sum_var_contract_price);
        
        $extracostpovare=0;
        
        /*$approvedpovar = $this->variation->getaprovedvarbycosid($costing_id,'purord');
        
        
        foreach ($approvedpovar as $key => $value) {
            $extracostpovare += $this->reports->getextracostvarebyvarid($value, $costing_id);
        }*/
		
		$approvedpovar = $this->variation->getPurchaseOrderCost($project_id['project_id']);
		if(count($approvedpovar)>0){
		  $extracostpovare = $approvedpovar[0]['total_line_cost'];
		}
        
        
        $sum_povar_contract_price=$this->reports-> getsoavbycid($costing_id,'purord');
        $sum_povar_contract_price[0]->sum_var_contract_price=($sum_povar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_povar_contract_price[0]->sum_var_contract_price:0;
//      
        $extracostsivare=0;
        
        $approvedsivar = $this->variation->getaprovedvarbycosid($costing_id,'suppinvo');
        
//        print_r($approvedsivar);
        foreach ($approvedsivar as $key => $value) {
            $extracostsivare += $this->reports->getextracostvarebyvarid($value, $costing_id);
//            print_r($extracostsivare);
        }
        
        $sum_sivar_contract_price=$this->reports-> getsoavbycid($costing_id,'suppinvo');
        $sum_sivar_contract_price[0]->sum_var_contract_price=($sum_sivar_contract_price[0]->sum_var_contract_price!=NULL)?$sum_sivar_contract_price[0]->sum_var_contract_price:0;

        $totalsupplierinvoicecreated=$this->reports->gettotalsupplierinvoicebycosting_id($costing_id, $start_date, $end_date);
        $totalsalesinvoicecreated=$this->reports->gettotalsaleinvoicebyproject_id($project_id['project_id'], $start_date, $end_date);


        /* Normal Variation   */

        if($this->reports->get_extra_variation_cost($project_id['project_id'])){
          $total_extra_cost_variation = $this->reports->get_extra_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_cost_variation = 0;
        }
        
        if($this->reports->get_extra_sales_variation_cost($project_id['project_id'])){
            $total_extra_sales_variation_cost = $this->reports->get_extra_sales_variation_cost($project_id['project_id']);
        }
        else{
           $total_extra_sales_variation_cost = 0;
        }

        /*  Purchase Order Variation   */

        
        if($this->reports->get_extra_po_variation_cost($project_id['project_id'])){
           $total_extra_po_cost_variation = $this->reports->get_extra_po_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_po_cost_variation = 0;
        }

        
        if($this->reports->get_extra_po_sales_variation_cost($project_id['project_id'])){
           $total_extra_po_sales_variation_cost = $this->reports->get_extra_po_sales_variation_cost($project_id['project_id']);
        } 
        else{
          $total_extra_po_sales_variation_cost = 0;
        }
       
        /*  Supplier Variation   */

        if($this->reports->get_extra_sup_variation_cost($project_id['project_id'])){
           $total_extra_sup_cost_variation = $this->reports->get_extra_sup_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_sales_variation_cost = $this->reports->get_extra_sup_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_sales_variation_cost = 0;
        }
        
        /*  Supplier Credit Variation   */

        if($this->reports->get_extra_sup_credit_variation_cost($project_id['project_id'])){
           $total_extra_sup_credit_cost_variation = $this->reports->get_extra_sup_credit_variation_cost($project_id['project_id']);
        }
        else{
            $total_extra_sup_credit_cost_variation = 0;
        }
       
        if($this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id'])){
          $total_extra_sup_credit_sales_variation_cost = $this->reports->get_extra_sup_credit_sales_variation_cost($project_id['project_id']);
        }
        else{
          $total_extra_sup_credit_sales_variation_cost = 0;
        }
        
        /* Allowances  */
        
        if($this->project->get_project_costing_info($project_id['project_id'])){
           //$total_extra_allowance_cost = $this->reports->get_extra_allowance_cost($pc_detail->costing_id);
           
           $total_extra_allowance_cost = 0;
           
           
           $pc_detail = $this->project->get_project_costing_info($project_id['project_id']);
           $tax =$pc_detail->tax_percent;
           $type = "allowance";
           $allowance_prjprts = $this->project->get_costing_parts_by_project_id($project_id['project_id'], $type);
           
           foreach($allowance_prjprts as $allowance_prjprt){
               //$allowance_cost = ($allowance_prjprt->line_margin)+($allowance_prjprt->line_margin*($tax/100));
               $allowance_cost = $allowance_prjprt->line_margin;
               //$total_extra_allowance_cost += $allowance_prjprt->line_margin;
               $allocated_allowance_amount = $this->reports->gettotalallowanceamount($allowance_prjprt->costing_part_id);
               $invoiced = $this->reports->gettotalactualamount($allowance_prjprt->costing_part_id);
              
               $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
               
               //$total_extra_allowance_cost+=number_format((($invoiced_amount)+($invoiced_amount*($tax/100))), 2, ".", "") - $allowance_cost;
               $total_extra_allowance_cost+=$invoiced_amount - $allowance_cost;
           }
           
        }
        else{
            $total_extra_allowance_cost = 0;
        }
       
        if($this->reports->get_extra_allowance_sales_cost($project_id['project_id'])){
          $total_extra_allowance_sales_cost = $this->reports->get_extra_allowance_sales_cost($project_id['project_id']);
        }
        else{
          $total_extra_allowance_sales_cost = 0;
        }
        
        $returnarr= array(
            'tcegst' => $ia,
            'total_cost' => $pc_detail->project_subtotal_1,
            'costing_tax' => $pc_detail->tax_percent,
            'contract_price' => $pc_detail->contract_price,
            'extracostvare' => $total_extra_cost_variation ,
            'extrasalevar' => $total_extra_sales_variation_cost,
            'extracostpovare' => $total_extra_po_cost_variation ,
            'extrasalepovar' =>$total_extra_po_sales_variation_cost,
            'extracostsivare' => $total_extra_sup_cost_variation ,
            'extracostscvare' => $total_extra_sup_credit_cost_variation ,
            'extrasalesivar' => $total_extra_sup_sales_variation_cost ,
            'extrasalescvar' => $total_extra_sup_credit_sales_variation_cost ,
            'extracostallowe' => $total_extra_allowance_cost ,
            'extrasaleallow' => $total_extra_allowance_sales_cost ,
            'totalsupplierinvoicecreated' => $totalsupplierinvoicecreated,
            'totalsalesinvoicecreated' => $totalsalesinvoicecreated,
        );
        
        $data['result']= $result = $returnarr;
        
        //print_r($result);exit;
		
        if(isset($_POST['work_in_progress_pdf'])){
            
            $this->load->library('M_pdf');
            
    		$html = $this->load->view('reports/workInProgress/work_in_progress_report_pdf', $data, true);
    
    		$pdfFilePath = "work_in_progress_report_".date('Y-m-d').".pdf";
    
    		$this->m_pdf->pdf->WriteHTML($html);
     
            //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
        }
        else{
        $this->load->library('excel');
        //Updated Project Budget Including GST
        $total_cost = number_format($result["total_cost"], 2, '.', '')*((100+$result["costing_tax"])/100);
        $extra_cost_var = number_format($result["extracostvare"], 2, '.', '')*((100+$result["costing_tax"])/100);
        $extra_cost_po = number_format($result["extracostpovare"], 2, '.', '')*((100+$result["costing_tax"])/100);
        $extra_cost_si = number_format($result["extracostsivare"], 2, '.', '')*((100+$result["costing_tax"])/100);
        $extra_cost_allowance= number_format($result["extracostallowe"], 2, '.', '')*((100+$result["costing_tax"])/100);
        $extracostscvari = number_format($result["extracostscvare"], 2, '.', '')*((100+$result["costing_tax"])/100);
        $updated_project_cost = (number_format($total_cost, 2, '.', '')+number_format($extra_cost_var, 2, '.', '')+number_format($extra_cost_po, 2, '.', '')+number_format($extra_cost_si, 2, '.', '')+number_format($extra_cost_allowance, 2, '.', ''))-number_format($extracostscvari, 2, '.', '');
        
        //Updated Project Contract 
        $contract_price = $result["contract_price"];
        $extra_sale_var = number_format($result["extrasalevar"], 2, '.', '');
        $extra_sale_po = number_format($result["extrasalepovar"], 2, '.', '');
        $extra_sale_si = number_format($result["extrasalesivar"], 2, '.', '');
        $extra_sale_allowance = number_format($result["extrasaleallow"], 2, '.', '');
        $extrasalescvar = number_format($result["extrasalescvar"], 2, '.', '');
        $updated_project_contract_price = (number_format($contract_price, 2, '.', '')+number_format($extra_sale_var, 2, '.', '')+number_format($extra_sale_po, 2, '.', '')+number_format($extra_sale_si, 2, '.', '')+number_format($extra_cost_allowance, 2, '.', ''))-number_format($extrasalescvar, 2, '.', '');
                      
        $total_profit = number_format($updated_project_contract_price, 2, '.', '') - number_format($updated_project_cost, 2, '.', '');
        
        $contigency_of_contract_budget = $contigency_of_contract_budget;
            if($contigency_of_contract_budget==""){
                $contigency_of_contract_budget = 0;
            }
            $contigency_value_including_gst = number_format($updated_project_cost, 2, '.', '')*($contigency_of_contract_budget/100);
            
            $projected_profit_after_contigency = number_format($total_profit, 2, '.', '') - number_format($contigency_value_including_gst, 2, '.', '');
            
            $supplierinvoicecreated = number_format($result["totalsupplierinvoicecreated"], 2, '.', '')*((100+$result["costing_tax"])/100);
            $salesinvoicecreated = number_format($result["totalsalesinvoicecreated"], 2, '.', '');
            
            $job_completion_progress = (number_format($salesinvoicecreated, 2, '.', '')/number_format($updated_project_contract_price, 2, '.', ''))*100;
            
            
            $upd_cont_bud_inc_con_gst = number_format($updated_project_cost, 2, '.', '')+number_format($contigency_value_including_gst, 2, '.', '');
            
            $supplier_invoices_based_on_per_completed = (number_format($job_completion_progress, 2, '.', '')/100)*(number_format($upd_cont_bud_inc_con_gst, 2, '.', ''));
            
            $work_in_progress_value = number_format($supplier_invoices_based_on_per_completed, 2, '.', '')-number_format($supplierinvoicecreated, 2, '.', '');
            
            
        $my_data = array();
       
		$count = 1;
		$key=0;
		$my_data[$key]['td1']="Project Title :";
		$my_data[$key]['td2']=$data['project_name']['project_title'];
		$key++;
		$my_data[$key]['td1']="Start Date :";
		$my_data[$key]['td2']=$start_date;
		$key++;
		$my_data[$key]['td1']="End Date :";
		$my_data[$key]['td2']=$end_date;
		$key++;
		$my_data[$key]['td1']="Updated Contract Price Including GST";
		$my_data[$key]['td2']="$".number_format($updated_project_contract_price, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Updated Contract Budget including GST";
		$my_data[$key]['td2']="$".number_format($updated_project_cost, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Projected Profit";
		$my_data[$key]['td2']="$".number_format($total_profit, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Contingency % of Contract Budget";
		$my_data[$key]['td2']= $data["contigency_of_contract_budget"]."% ";
		$key++;
		$my_data[$key]['td1']="Contingency Value Including GST";
		$my_data[$key]['td2']="$".number_format($contigency_value_including_gst, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Projected Profit after Contingency";
		$my_data[$key]['td2']="$".number_format($projected_profit_after_contigency, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Sales Invoices Created in Date Range Including GST";
		$my_data[$key]['td2']="$".number_format($salesinvoicecreated, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="JOB Completion Progress %";
		$my_data[$key]['td2']=number_format($job_completion_progress, 2, '.', ',')."% ";
		$key++;
		$my_data[$key]['td1']="Updated Contract Budget including Contingency & GST";
		$my_data[$key]['td2']="$".number_format($upd_cont_bud_inc_con_gst, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Supplier Invoices Created In Date Range Including GST";
        $my_data[$key]['td2']="$".number_format($supplierinvoicecreated, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="Supplier Invoices Based on % Complete";
		$my_data[$key]['td2']="$".number_format($supplier_invoices_based_on_per_completed, 2, '.', ',')." ";
		$key++;
		$my_data[$key]['td1']="WORK IN PROGRESS VALUE";
		$my_data[$key]['td2']="$".number_format($work_in_progress_value, 2, '.', ',')." ";
		
		$all_data = $my_data;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Work in Progress Report');
		
        $this->excel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:B2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3:B3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B2:B15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename='work_in_progress_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        }

	}
	
	/* Work In Progress Report Section Ends Here */
	
	/* Budget VS Actual Report Section Starts Here */
	
	//Budget VS Actual Report
    public function budget_vs_actual(){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
        $this->stencil->title('Budget VS Actual Report');
	    $this->stencil->paint('reports/budget_vs_actual_report/project_budget_vs_actual', $data);
	}
	
	//Get Budget VS Actual Report Details
	public function get_project_budget_vs_actual_report(){
		$id = $this->input->post('project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		
		$data['prjprts'] = $this->project->get_project_uninvoiced_items($id);
	
        $html = $this->load->view('reports/budget_vs_actual_report/project_budget_vs_actual_report_ajax', $data);
	}
	
	//Export Budget VS Actual Report
	public function export_budget_vs_actual_report(){
		
		$id = $this->input->post('report_project_id');
		
		$data['project_name'] = $this->project->get_project_by_name($id);
		
		$data['prjprts'] = $this->project->get_project_uninvoiced_items($id);

		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$prjprts = $data['prjprts'];
		
		$report_type= $this->input->post('report_type');
		
		if($report_type=="excel"){
		    
		$this->load->library("excel");
		
        $my_data_titles = array(
			

            array(
            'stage_name'             =>  'Stage',
            'part'                   =>  'Part',
			'component'              =>  'Component',
			'supplier'               =>  'Supplier',
			'costing_budget'       	 =>  'Project Costing Amount',
			'variations_value'       =>  'Variations (+/-)',
			'subtotal_value'       	 =>  'Budget Amount',
			'invoiced_value'       	 =>  'Invoices Amount',
			'uninvoiced_budget'      =>  'Variance'
            )
        );
        $my_data = array();
       
		$count = 1;
		$key=0;
		$i=2;
				 $my_data[$key]['stage_name'] = "";
				 $my_data[$key]['part'] ="";
				 $my_data[$key]['component'] = ""; 
				 $my_data[$key]['supplier'] = "";
				 $my_data[$key]['costing_budget'] = stripslashes($data['project_name']['project_title']);
				 $my_data[$key]['variations_value'] = "";
				 $my_data[$key]['subtotal_value'] = "";
				 $my_data[$key]['invoiced_value'] = "";
				 $my_data[$key]['uninvoiced_budget'] = "";
				 

            foreach ($prjprts as $key => $prjprt) { 
		     $parts = get_uninvoiced_components($prjprt->costing_part_id);
             $variation_amount = get_variation_amount_excluding_sale_summary($prjprt->costing_part_id);
			 $invoiced_quantity = get_supplier_ordered_quantity($prjprt->costing_part_id);
			 $invoiced_amount = get_supplier_invoice_amount($prjprt->costing_part_id);
             if($parts){
                $variation_type = get_variation_type($parts->variation_id);
				if($parts->change_quantity!="" && $parts->variation_id!=0 && $variation_type['var_type']=="normal"){
					$variations = $parts->change_quantity;
				}
				else{
					$variations =0; 
				}
			 }
			 else{
					$variations =0; 
				}
			$variation_info = get_variation_info_by_costing_id($prjprt->costing_part_id);
				if(count($variation_info)>0){
				foreach($variation_info as $vinfo){
				    $variations += $vinfo['change_quantity'];
				}
				}
				
        if($prjprt->is_variated==0){
            $subtotal = $prjprt->costing_quantity + $variations;
        }else{
             $subtotal = $prjprt->costing_quantity;
        }

        if($prjprt->part_costing_type!="normal"){
          $prjprt->project_costing_cost = 0;
        }
        
           $uninvoiced_quantity = $subtotal - $invoiced_quantity;
				//if($uninvoiced_quantity>0){	
				 $key++;
				 $my_data[$key]['stage_name'] = $prjprt->stage_name;
				 $my_data[$key]['part'] =$prjprt->costing_part_name;
				 $my_data[$key]['component'] = $prjprt->component_name; 
				 $my_data[$key]['supplier'] = $prjprt->supplier_name;
				 $my_data[$key]['costing_budget'] = "$".number_format($prjprt->project_costing_cost, 2, ".", ",");
				 $my_data[$key]['variations_value'] = "$".number_format($variation_amount, 2, ".", ",");
				 $my_data[$key]['subtotal_value'] = "$".number_format($prjprt->project_costing_cost + $variation_amount, 2, ".", ",");
				 $my_data[$key]['invoiced_value'] = "$".number_format($invoiced_amount, 2, ".", "");
				 $my_data[$key]['uninvoiced_budget'] = "$".number_format(($prjprt->project_costing_cost + $variation_amount)-$invoiced_amount, 2, ".", ",");
			 $count++;						
				//}
			}
				
		
		$all_data = array_merge($my_data_titles, $my_data);

		//print_r($all_data);exit;
		$total_records = $key+3;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Budget VS Actual Report');

		$this->excel->getActiveSheet()->getStyle('A2:I2')->getFont()->getColor()->setRGB('#FFFFFF');
		
		$this->excel->getActiveSheet()
        ->getStyle('A2:I2')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('#000000');
		
		

        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename='project_budget_vs_actual_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		//print($tofile);
		}
		else{
		 
		$this->load->library("M_pdf");
		$html = $this->load->view('reports/budget_vs_actual_report/project_budget_vs_actual_report_pdf', $data, true);

		$pdfFilePath = "project_budget_vs_actual__report_".date('Y-m-d').".pdf";
		$this->m_pdf->pdf->WriteHTML($html); 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
	}
	
	//Get Variations
	public function variations($costing_part_id){
	    $this->common->is_company_page_accessible(6);
	    $data['variations'] = get_variations_used_in_budget($costing_part_id);
	    
	    
	    foreach($data['variations'] as $key => $val){

            $extracostvari=$this->reports->getextracostvarebyvarid($val["id"], $val["costing_id"],'sales');
            $project_title = $this->project->get_project_by_name($val["project_id"]);
            
            $data['variations'][$key]["project_title"] = $project_title['project_title'];
            $data['variations'][$key]["variation_amount"] =$extracostvari['total'];
        }
        $this->stencil->title('Project Variations');
	    $this->stencil->paint('project_variations/manage_variations', $data);
	}
	
	//Get Supplier Invoices
	public function supplierinvoices($costing_part_id) {
        $this->common->is_company_page_accessible(19);
        $data['supplier_invoices'] = get_supplier_invoices_used_in_budget($costing_part_id);
        print_r($data['supplier_invoices']);
        foreach($data['supplier_invoices'] as $key => $val){
            $prject_id = $this->project->get_project_id_from_costing_id($val["project_id"]);
            $project_title = $this->project->get_project_by_name($prject_id['project_id']);
            $data['supplier_invoices'][$key]["project_title"] = $project_title['project_title'];
            $data['supplier_invoices'][$key]["supplier_name"]=get_supplier_name($val["supplier_id"]);
        }
        $this->stencil->title('Supplier Invoices');
	    $this->stencil->paint('supplier_invoices/manage_supplier_invoices', $data);
    }
    
    /* Budget VS Actual Report Section Ends Here */
    
    /* Project Unordered Items Section Starts Here*/
    
    //Project Unordered Items Report
    public function project_unordered_items(){
        $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
		$this->stencil->title('Project Unordered Items Report');
	    $this->stencil->paint('reports/project_unordered_items/projectunordereditems', $data);
	}
	
	//Get Project Unordered Items Report Details
	public function get_project_unordered_items(){
		$id = $this->input->post('project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		$data['prjprts'] = $this->project->get_project_unordered_items($id);
		$cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        $data['stages'] = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
        $html = $this->load->view('reports/project_unordered_items/projectunordereditems_ajax', $data);
	}
	
	//Export Project Unordered Items Report
	public function export_unordered_items(){
		
		$id = $this->input->post('report_project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		$cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        $data['stages'] = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
        
		$data['prjprts'] = $this->project->get_project_unordered_items($id);

		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $fields = '`com_logo`';
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$stages = $data['stages'];
		
		$prjprts = $data['prjprts'];
		
		$report_type= $this->input->post('report_type');
		
		if($report_type=="excel"){
		    
		$this->load->library("excel");
		
        $my_data_titles = array(

            array(
            'sr_no'                  =>  'Sr No',
            'stage_name'             =>  'Stage name',
            'part'                   =>  'Part',
			'component'              =>  'Component',
			'supplier'               =>  'Supplier',
			'qty'                    =>  'QTY',
			'unit_of_measure'        =>  'Unit Of Measure',
			'variations'             =>  'Variations',
			'subtotal'               =>  'Subtotal',
			'purchase_orders'        =>  'Purchase Orders',
			'unordered_quantity'     =>  'Unordered Quantity'
            )
        );
        $my_data = array();
       
		$count = 1;
		$key=0;
		$i=2;
		         $my_data[$key]['sr_no'] = "";
				 $my_data[$key]['stage_name'] = "";
				 $my_data[$key]['part'] ="";
				 $my_data[$key]['component'] = ""; 
				 $my_data[$key]['supplier'] = "";
				 $my_data[$key]['qty'] = stripslashes($data['project_name']['project_title']);
				 $my_data[$key]['unit_of_measure'] = "";
				 $my_data[$key]['variations'] = "";
				 $my_data[$key]['subtotal'] = "";
				 $my_data[$key]['purchase_orders'] = "";
				 $my_data[$key]['unordered_quantity'] = "";
				 
		foreach ($stages as $key => $stage){
            foreach ($prjprts as $key => $prjprt) { 
				if ($prjprt->stage_id == $stage["stage_id"]) {
				    
				$ordered_quantity = get_ordered_quantity($prjprt->costing_part_id);
				
				 $parts = get_uninvoiced_components($prjprt->costing_part_id);
				 
				if($parts){
    			    $variation_type = get_variation_type($parts->variation_id);
    			    
    			       if($parts->change_quantity!="" && $parts->variation_id!=0 && $variation_type['var_type']=="normal"){
    					$variations = $parts->change_quantity;
    				}
    				else{
    					$variations =0; 
    				} 
				}
				else{
    					$variations =0; 
    				}
				
				$variation_info = get_variation_info_by_costing_id($prjprt->costing_part_id);
				if(count($variation_info)>0){
				foreach($variation_info as $vinfo){
				    $variations += $vinfo['change_quantity'];
				}
				}
				
				if($prjprt->is_variated==0){
								$subtotal = $prjprt->costing_quantity + $variations;
							}else{
								$subtotal = $prjprt->costing_quantity;
							}
				 
				 $unordered_quantity = $subtotal-$ordered_quantity;
				 $variation_quantity = ($prjprt->is_variated==0) ? $variations : $prjprt->costing_quantity;
				 $qty = ($prjprt->is_variated==0) ? $prjprt->costing_quantity : 0;
				 $key++;
                 $my_data[$key]['sr_no'] = $count;
				 $my_data[$key]['stage_name'] = $stage["stage_name"];
				 $my_data[$key]['part'] =$prjprt->costing_part_name;
				 $my_data[$key]['component'] = $prjprt->component_name; 
				 $my_data[$key]['supplier'] = $prjprt->supplier_name;
				 $my_data[$key]['qty'] =  $qty." ";
				 $my_data[$key]['unit_of_measure'] = $prjprt->costing_uom;
				 $my_data[$key]['variations'] = $variation_quantity." ";
				 $my_data[$key]['subtotal'] = $subtotal." ";
				 $my_data[$key]['purchase_orders'] = $ordered_quantity." ";
				 $my_data[$key]['unordered_quantity'] = $unordered_quantity." ";
        	   
			 $count++;
					}
							
				}
						    
		    }	
			
		$all_data = array_merge($my_data_titles, $my_data);
		$total_records = $key+3;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Project Unordered Items Report');

		$this->excel->getActiveSheet()->getStyle('A2:L2')->getFont()->getColor()->setARGB('#FFFFFF');
		
		$this->excel->getActiveSheet()
        ->getStyle('A2:L2')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('#000000');
		

        $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename='project_unordered_items_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		//print($tofile);
		}
		else{
		    
	    $this->load->library("M_pdf");
	    
		$html = $this->load->view('reports/project_unordered_items/projectunordereditems_pdf', $data, true);

		$pdfFilePath = "project_unordered_items_report_".date('Y-m-d').".pdf";

		$this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
	}
	
	/* Project Unordered Items Section Ends Here*/

	/* Component Unordered Items Section Starts Here*/
	
	//Component Unordered Items Report
	public function component_items_unordered(){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
        $this->stencil->title('Component Items Unordered Report');
	    $this->stencil->paint('reports/component_items_unordered/componentunordereditems', $data);
	}
	
	//Get Component Unordered Items Report
	function get_component_unordered_items(){
		$id = $this->input->post('project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		$cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        $data['stages'] = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
		$data['prjprts'] = $this->project->get_project_unordered_items($id);
        $html = $this->load->view('reports/component_items_unordered/componentunordereditems_ajax', $data);
	}
	
	//Export Component Unordered Items Report
	function export_component_unordered_items(){
		
		$id = $this->input->post('report_project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		$data['prjprts'] = $this->project->get_project_unordered_items($id);
		
		$cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        $data['stages'] = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");

		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$stages = $data['stages'];
		
		$prjprts = $data['prjprts'];
		
		$report_type= $this->input->post('report_type');
		
		if($report_type=="excel"){
		 
		$this->load->library("excel");
		
        $my_data_titles = array(
            array(
            'sr_no'                  =>  'Sr No',
            'stage_name'             =>  'Stage name',
            'part'                   =>  'Part',
			'component'              =>  'Component',
			'supplier'               =>  'Supplier',
			'qty'                    =>  'QTY',
			'unit_of_measure'        =>  'Unit Of Measure',
			'variations'             =>  'Variations',
			'subtotal'               =>  'Subtotal',
			'purchase_orders'        =>  'Purchase Orders',
			'unordered_quantity'     =>  'Unordered Quantity'
            )
        );
        $my_data = array();
       
		$count = 1;
		$key=0;
		$i=2;
		         $my_data[$key]['sr_no'] = "";
				 $my_data[$key]['stage_name'] = "";
				 $my_data[$key]['part'] ="";
				 $my_data[$key]['component'] = ""; 
				 $my_data[$key]['supplier'] = "";
				 $my_data[$key]['qty'] = stripslashes($data['project_name']['project_title']);
				 $my_data[$key]['unit_of_measure'] = "";
				 $my_data[$key]['variations'] = "";
				 $my_data[$key]['subtotal'] = "";
				 $my_data[$key]['purchase_orders'] = "";
				 $my_data[$key]['unordered_quantity'] = "";
				 
		foreach ($stages as $key => $stage){
            foreach ($prjprts as $key => $prjprt) { 
				if ($prjprt->stage_id == $stage["stage_id"]) { 
				  $parts = get_uninvoiced_components($prjprt->costing_part_id);
			    if($parts){
			       $variation_type = get_variation_type($parts->variation_id);
			       if($parts->change_quantity!="" && $parts->variation_id!=0 && $variation_type['var_type']=="normal"){
					$variations = $parts->change_quantity;
    				}
    				else{
    					$variations =0; 
    				} 
				}
				else{
				    $variations = 0;
				}
				
					$variation_info = get_variation_info_by_costing_id($prjprt->costing_part_id);
				if(count($variation_info)>0){
				foreach($variation_info as $vinfo){
				    $variations += $vinfo['change_quantity'];
				}
				}
			    
				
				$ordered_quantity = get_ordered_quantity($prjprt->costing_part_id);
				
						
							if($prjprt->is_variated==0){
								$subtotal = $prjprt->costing_quantity + $variations;
							}else{
								$subtotal = $prjprt->costing_quantity;
							}
						
								$unordered_quantity = $subtotal-$ordered_quantity;

				 if($unordered_quantity > 0){
				 $key++;
                 $my_data[$key]['sr_no'] = $count;
				 $my_data[$key]['stage_name'] = $stage["stage_name"];
				 $my_data[$key]['part'] =$prjprt->costing_part_name;
				 $my_data[$key]['component'] = $prjprt->component_name; 
				 $my_data[$key]['supplier'] = $prjprt->supplier_name;
				 $my_data[$key]['qty'] = $prjprt->costing_quantity;
				 $my_data[$key]['unit_of_measure'] = $prjprt->costing_uom;
				 $my_data[$key]['variations'] = $subtotal-$prjprt->costing_quantity." ";
				 $my_data[$key]['subtotal'] = $subtotal." ";
				 $my_data[$key]['purchase_orders'] = $ordered_quantity." ";
				 $my_data[$key]['unordered_quantity'] = $unordered_quantity." ";
        	   
			 $count++;
					}
				}			
				}
						    
		    }	
							
		$all_data = array_merge($my_data_titles, $my_data);
		$total_records = $key+3;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Component Items Unordered Report');

        $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename='component_items_unordered_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		//print($tofile);
		}
		else{
		    
		$this->load->library("M_pdf");
		
		$html = $this->load->view('reports/component_items_unordered/componentunordereditems_pdf', $data, true);

		$pdfFilePath = "component_items_unordered_report_".date('Y-m-d').".pdf";

		$this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
	}
	
	/* Component Unordered Items Section Ends Here*/
	
	/* Project Uninvoiced Component Report Section Starts Here*/
	
	//Project Uninvoiced Component Report
	public function project_uninvoiced_component(){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
        $this->stencil->title('Project Uninvoiced Components Report');
	    $this->stencil->paint('reports/uninvoiced_components_report/project_univoiced_items', $data);
	}	
	
	//Get Project Uninvoiced Component Report Details
	public function get_project_uninvoiced_components(){
		$id = $this->input->post('project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		
		$data['prjprts'] = $this->project->get_project_uninvoiced_items($id);
	
        $html = $this->load->view('reports/uninvoiced_components_report/project_uninvoiced_components_ajax', $data);
	}
	
	//Export Project Uninvoiced Component Report
	public function export_project_uninvoiced_components(){
		
		$id = $this->input->post('report_project_id');
		
		$data['project_name'] = $this->project->get_project_by_name($id);
		
		$data['prjprts'] = $this->project->get_project_uninvoiced_items($id);

		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$prjprts = $data['prjprts'];
		
		$report_type= $this->input->post('report_type');
		
		if($report_type=="excel"){
		    
		$this->load->library("excel");
		
        $my_data_titles = array(
			

            array(
            'sr_no'                  =>  'Sr No',
            'stage_name'             =>  'Stage name',
            'part'                   =>  'Part',
			'component'              =>  'Component',
			'supplier'               =>  'Supplier',
			'costing_qty'       	 =>  'Costing QTY',
			'variations'             =>  'Variations',
			'subtotal'               =>  'Subtotal',
			'invoiced_qty'        	 =>  'Invoiced QTY',
			'uninvoiced_qty'         =>  'Uninvoiced QTY',
			'uninvoiced_budget'      =>  'Uninvoiced Budget'
            )
        );
        $my_data = array();
       
		$count = 1;
		$key=0;
		$i=2;
		         $my_data[$key]['sr_no'] = "";
				 $my_data[$key]['stage_name'] = "";
				 $my_data[$key]['part'] ="";
				 $my_data[$key]['component'] = ""; 
				 $my_data[$key]['supplier'] = "";
				 $my_data[$key]['costing_qty'] = stripslashes($data['project_name']['project_title']);;
				 $my_data[$key]['variations'] = "";
				 $my_data[$key]['subtotal'] = "";
				 $my_data[$key]['invoiced_qty'] = "";
				 $my_data[$key]['uninvoiced_qty'] = "";
				 $my_data[$key]['uninvoiced_budget'] = "";
				 

            foreach ($prjprts as $key => $prjprt) { 
		    $variations = 0;
             
             $variation_amount = get_variation_amount($prjprt->costing_part_id);
            
			 $invoiced_quantity = get_supplier_ordered_quantity($prjprt->costing_part_id);
			 
			
			 $invoiced_amount = get_supplier_invoice_amount($prjprt->costing_part_id);
                
				
		
			$variation_info = get_variation_info_by_costing_id($prjprt->costing_part_id);
			 $recent_quantity = get_recent_variation_quantity($prjprt->costing_part_id, $prjprt->costing_supplier);
                $recent_total = 0;
                foreach($recent_quantity as $val){
                    $recent_total += $val['total'];
                }
                $updated_total = 0;
                foreach($recent_quantity as $val){
                    $updated_total = $val['updated_quantity'];
                }
                if(count($recent_quantity)>0){
                if($prjprt->part_costing_type=="normal" || $prjprt->part_costing_type=="autoquote"){
            					$variations = $prjprt->costing_quantity+$recent_total;
            				}
            				else{
            					$variations =$updated_total;
            				}
            	$subtotal = $variations;
                }
                else{
                    $variations = 0;
                    $subtotal = $prjprt->costing_quantity;
                }
            
                $uninvoiced_quantity = $subtotal - $invoiced_quantity;
            
				if($uninvoiced_quantity>0){	
				 $key++;
                 $my_data[$key]['sr_no'] = $count;
				 $my_data[$key]['stage_name'] = $prjprt->stage_name;
				 $my_data[$key]['part'] =$prjprt->costing_part_name;
				 $my_data[$key]['component'] = $prjprt->component_name; 
				 $my_data[$key]['supplier'] = $prjprt->supplier_name;
				 $my_data[$key]['costing_qty'] = ($prjprt->is_variated==0) ? $prjprt->costing_quantity : 0;
				 $my_data[$key]['variations'] = ($prjprt->is_variated==0) ? $variations : $prjprt->costing_quantity;
				 $my_data[$key]['subtotal'] = number_format($subtotal, 2, ".", "")." ";
				 $my_data[$key]['invoiced_qty'] = $invoiced_quantity;
				 $my_data[$key]['uninvoiced_qty'] = number_format($uninvoiced_quantity, 2, ".", "");
				  $my_data[$key]['uninvoiced_budget'] = number_format(($prjprt->project_costing_cost + $variation_amount)-$invoiced_amount, 2, ".", "");
        	   
			 $count++;						
				}
			}
				
		
		$all_data = array_merge($my_data_titles, $my_data);

		//print_r($all_data);exit;
		$total_records = $key+3;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Project Uninvoiced Components Report');

		$this->excel->getActiveSheet()->getStyle('A2:L2')->getFont()->getColor()->setRGB('#FFFFFF');
		
		$this->excel->getActiveSheet()
        ->getStyle('A2:L2')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('#000000');
		
		

        $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename='project_uninvoiced_components_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		//print($tofile);
		}
		else{
		    
		$this->load->library("M_pdf");
		
		//$this->load->view('reports/project_univoiced_item_pdf.php', $data);
		$html = $this->load->view('reports/uninvoiced_components_report/project_uninvoiced_components_pdf', $data, true);

		$pdfFilePath = "project_uninvoiced_components_report_".date('Y-m-d').".pdf";
		$this->m_pdf->pdf->WriteHTML($html); 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
	}
	
	/* Project Uninvoiced Component Report Section Ends Here*/
	
    /* Project Suppliers Report Section Starts Here*/
	
	//Project Supplier Report
	public function project_suppliers_report(){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
        $this->stencil->title('Project Suppliers Report');
	    $this->stencil->paint('reports/project_suppliers/project_suppliers_report', $data);
	}
	
	//Get Project Supplier Report Details
	public function get_project_suppliers(){
		$returnhtml='';
		$id = $this->input->post('project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		$data['prjprts'] = $this->project->get_project_supplier($id);
		foreach($data['prjprts'] as $val){
		    $stages = $this->db->query("SELECT s.stage_name FROM project_costing_parts p INNER JOIN project_stages s ON s.stage_id = p.stage_id WHERE p.costing_supplier='".$val->costing_supplier."' AND p.costing_id IN (SELECT costing_id FROM project_costing WHERE project_id='".$id."') GROUP BY p.stage_id");
		    $data['stages'][$val->costing_supplier] = $stages->result();
		}
        $html = $this->load->view('reports/project_suppliers/project_suppliers_report_ajax', $data);
	}
	
	//Export Project Supplier Report
	public function export_project_suppliers_report(){
		$id = $this->input->post('report_project_id');
		$data['project_name'] = $this->project->get_project_by_name($id);
		$data['prjprts'] = $this->project->get_project_supplier($id);
		foreach($data['prjprts'] as $val){
		    $stages = $this->db->query("SELECT s.stage_name FROM project_costing_parts p INNER JOIN project_stages s ON s.stage_id = p.stage_id WHERE p.costing_supplier='".$val->costing_supplier."' AND p.costing_id IN (SELECT costing_id FROM project_costing WHERE project_id='".$id."') GROUP BY p.stage_id");
		    $data['stages'][$val->costing_supplier] = $stages->result();
		}
		

		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$stages = $data['stages'];
		
		$prjprts = $data['prjprts'];
		
		$project_name = $data['project_name'];
		
		$report_type= $this->input->post('report_type');
		
		if($report_type=="excel"){
		  
		$this->load->library("excel");
		
        $my_data_titles = array(
			
            array(
                 'sr_no'                  =>   stripslashes($data['project_name']['project_title']),
                 'supplier'               =>  '',
                 'stages'                 =>  ''
                ),
            array(
                 'sr_no'                  =>  $project_name['street_pobox'].", ".$project_name['suburb'].", ".$project_name['project_address_city'].", ".$project_name['project_address_state'].", ".$project_name['project_address_country'].", ".$project_name['project_zip'],
                 'supplier'               =>  '',
                 'stages'                 =>  ''
                ),
            array(
            'sr_no'                  =>  'Sr No',
            'supplier'               =>  'Supplier',
            'stages'                 =>  'Stages Required'
            )
        );
        $my_data = array();
       
		$count = 1;
		$key=0;
		$i=2;
				 
				
				 if(count($prjprts)>0){
			     $count = 1;
			     $cell_index = 4;
			     foreach ($prjprts As $key => $prjprt) {
		
				 $key++;
                 $my_data[$key]['sr_no'] = $count;
				 $my_data[$key]['supplier'] = $prjprt->supplier_name."\n".$prjprt->supplier_contact_person."\n".$prjprt->supplier_web."\n".$prjprt->supplier_contact_person_mobile."\n".$prjprt->supplier_phone."\n".$prjprt->supplier_email;
				 if(count($stages[$prjprt->costing_supplier])>0){
				 $stages_string = "";
				 foreach($stages[$prjprt->costing_supplier] as $stage){
				  $stages_string.=$stage->stage_name."\n";
				 }
				 $my_data[$key]['stages'] = rtrim($stages_string,"\n");
				 }else{
				    $my_data[$key]['stages'] = ""; 
				 }
				 $cell = "A".$cell_index.":"."C".$cell_index;
        	     $this->excel->getActiveSheet()->getStyle($cell)->getAlignment()->setWrapText(true);
        	     $this->excel->getActiveSheet()->getStyle($cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			     $count++;
			     $cell_index++;
				 }
				}			
		
		$all_data = array_merge($my_data_titles, $my_data);
		$total_records = $key+3;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Project Suppliers Report');
		
        $this->excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3:C3')->getFont()->setBold(true);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
        $this->excel->getActiveSheet()->mergeCells('A1:C1');
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->mergeCells('A2:C2');
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f56700');
        $this->excel->getActiveSheet()->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f56700');
	
        $styleArray = array(
           'font'  => array(
             'color' => array('rgb' => 'ffffff')
        ));
        $this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);
 
        $filename='project_suppliers_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		//print($tofile);
		}
		else{
		    
		$this->load->library("M_pdf");
		$html = $this->load->view('reports/project_suppliers/project_suppliers_report_pdf', $data, true);

		$pdfFilePath = "project_suppliers_report_".date('Y-m-d').".pdf";

		$this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
	}
	
	/* Project Suppliers Report Section Ends Here*/
	
	/* Updated Project Costing Report Section Starts Here*/
	
	//Updated Project Costing Report
	public function updated_project_costing_report(){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
		$this->stencil->title('Updated Project Costing Report');
	    $this->stencil->paint('reports/updated_project_costing/updated_project_costing_report', $data);
	}
	
	//Get Updated Project Costing Report Details
	public function get_updated_project_costing(){
	    
		$costing_id = $this->input->post('project_id');
		
		$project_id=$this->project->get_project_id_from_costing_id($costing_id);
		
		$id = $project_id["project_id"];
		
		$data['project_name'] = $this->project->get_project_by_name($id);
		
		$data['costing_id'] = $costing_id;
		
		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
        
        $data['project_info'] = $this->project->get_project_info($id);
		
		$data['prjprts'] = $this->project->get_updated_project_costing($costing_id);
		
		$data['pc_detail'] = $this->project->get_project_costing_info($id);
		
        $html = $this->load->view('reports/updated_project_costing/updated_project_costing_report_ajax', $data);
	}
	
	//Export Updated Project Costing Report
	public function export_updated_project_costing(){
		
		$costing_id = $this->input->post('report_project_id');
		
		$project_id = $this->project->get_project_id_from_costing_id($costing_id);
		
		$id = $project_id["project_id"];
		
		$data['project_name'] = $this->project->get_project_by_name($id);
        
        $data['project_info'] = $this->project->get_project_info($id);
		
		
		$data['prjprts'] = $this->project->get_updated_project_costing($costing_id);
		
	
		$data['pc_detail'] = $this->project->get_project_costing_info($id);

		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		$prjprts = $data['prjprts'];
		
		$this->load->library("M_pdf");
		
		$html = $this->load->view('reports/updated_project_costing/updated_project_costing_report_pdf', $data, true);

		$pdfFilePath = "updated_project_costing_report_".date('Y-m-d').".pdf";
		$this->m_pdf->pdf->WriteHTML($html); 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
	}
	
	/* Updated Project Costing Report Section Ends Here*/
	
	/* Updated Specifications Report Section Starts Here*/
	
	//Updated Specification Report
	function updated_specifications_report(){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
        $this->stencil->title('Updated Specifictions Report');
	    $this->stencil->paint('reports/updated_specifications/updated_specifications_report', $data);
	}
	
	//Get Updated Specification Report Details
	function get_updated_specifications(){
		
		$costing_id = $this->input->post('project_id');
		
		$project_id=$this->project->get_project_id_from_costing_id($costing_id);
		
		$id = $project_id["project_id"];
		
		$data['project_name'] = $this->project->get_project_by_name($id);
		
		
		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
        
        
          $data['project_info'] = $this->project->get_project_info($id);
		
		$data['costing_id'] = $costing_id;
		
		$data['prjprts'] = $this->project->get_updated_specifications($costing_id);
		
		$saved_stages = array();
		
        foreach ($data['prjprts'] as $projctprt_with_stage) {
            $saved_stages[] = $projctprt_with_stage->stage_id;
        }
        $data['saved_stages'] = $saved_stages;
  
		if($this->session->userdata('company_id')>0){
            $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
         }else{
           $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1);
         }  
		$data['stages'] = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
		
        $html = $this->load->view('reports/updated_specifications/updated_specifications_report_ajax', $data);
	}
	
	//Export Updated Specification Report
	function export_updated_specifications(){
		
		$costing_id = $this->input->post('report_project_id');
		
		$project_id=$this->project->get_project_id_from_costing_id($costing_id);
		
		$id = $project_id["project_id"];
		
		$data['project_name'] = $this->project->get_project_by_name($id);
		
		 $cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
        
        
          $data['project_info'] = $this->project->get_project_info($id);
		
		$data['prjprts'] = $this->project->get_updated_specifications($costing_id);
		
			$saved_stages = array();
		
        foreach ($data['prjprts'] as $projctprt_with_stage) {
            $saved_stages[] = $projctprt_with_stage->stage_id;
        }
        $data['saved_stages'] = $saved_stages;
  
		if($this->session->userdata('company_id')>0){
            $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
         }else{
           $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1);
         }  
        $data['stages'] = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
		
		$prjprts = $data['prjprts'];
		
		$this->load->library("M_pdf");
		
		$html = $this->load->view('reports/updated_specifications/updated_specifications_report_pdf', $data, true);

		$pdfFilePath = "updated_specifications_report_".date('Y-m-d').".pdf";
		$this->m_pdf->pdf->WriteHTML($html); 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
	}
	
	/* Updated Specifications Report Section Ends Here*/
	
	/* Project Transaction Report Section Starts Here*/
	
	//Project Transaction Report
	public function project_transactions_report(){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
		$supplier_invoices = $this->project->get_supplier_invoices();
		$salesinvoices = $this->project->get_salesinvoices();
		$project_all = $this->project->get_project();
		if($supplier_invoices){
			foreach($supplier_invoices as $s_record){
				$supplier_rec_project[$s_record['prj_id']][] = $s_record;
			}
		}else{
			$supplier_rec_project = array();
		}
		if($salesinvoices){
			foreach($salesinvoices as $sale_record){
				$sales_rec_project[$sale_record['project_id']][] = $sale_record;
			}
		}else{
			$sales_rec_project = array();
		}
		$data['supplier_rec_project'] = $supplier_rec_project;
		$data['sales_rec_project'] = $sales_rec_project;
                if($project_all){
		$data['project_all'] = $project_all;
                }
        $this->stencil->title('Project Transactions Report');
	    $this->stencil->paint('reports/project_transactions_report/view_project_transactions_report', $data);
	}
	
	//Get Project Transaction Report Details
	public function get_filter_projects(){
		
		$project_id = $this->input->post('project_id');
		$transaction_type = $this->input->post('transaction_type');
		if(($project_id=="all" && $transaction_type=="all") || $project_id=="all" && $transaction_type=="paid"){
		   $project_all = $this->project->get_project();
		}
		else{
		   $project_all = $this->project->get_filter_projects($project_id);
		}
		$supplier_invoices = $this->project->get_supplier_invoices();
		$salesinvoices = $this->project->get_salesinvoices();
		$data['projects'] = $this->project->get_existing_project();
		
		if($supplier_invoices){
			foreach($supplier_invoices as $s_record){
				$supplier_rec_project[$s_record['prj_id']][] = $s_record;
			}
		}else{
			$supplier_rec_project = array();
		}
		if($salesinvoices){
			foreach($salesinvoices as $sale_record){
				$sales_rec_project[$sale_record['project_id']][] = $sale_record;
			}
		}else{
			$sales_rec_project = array();
		}
		$data['supplier_rec_project'] = $supplier_rec_project;
		$data['sales_rec_project'] = $sales_rec_project;
		$data['project_all'] = $project_all;
		$data['proj_id'] = $project_id;
		$data['transaction_type'] = $transaction_type;
        $this->load->view('reports/project_transactions_report/project_transactions_report_ajax', $data);
	}
	
	//Export Project Transaction Report
	public function export_project_transactions_report(){
		
		$project_id =  $this->input->post('report_project_id');
		$transaction_type = $this->input->post('report_transaction_type');
		if(($project_id=="all" && $transaction_type=="all") || ($project_id=="all" && $transaction_type=="paid")){
		   $project_all = $this->project->get_project();
		}
		else{
		   $project_all = $this->project->get_filter_projects($project_id);
		   
		}
		
		$supplier_invoices = $this->project->get_supplier_invoices();
		$salesinvoices = $this->project->get_salesinvoices();
		$data['projects'] = $this->project->get_existing_project();

		$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);
		
		if($supplier_invoices){
			foreach($supplier_invoices as $s_record){
				$supplier_rec_project[$s_record['prj_id']][] = $s_record;
			}
		}else{
			$supplier_rec_project = array();
		}
		if($salesinvoices){
			foreach($salesinvoices as $sale_record){
				$sales_rec_project[$sale_record['project_id']][] = $sale_record;
			}
		}else{
			$sales_rec_project = array();
		}
		$data['supplier_rec_project'] = $supplier_rec_project;
		$data['sales_rec_project'] = $sales_rec_project;
		$data['project_all'] = $project_all;
		$data['proj_id'] = $project_id;
		$data['transaction_type'] = $transaction_type;
		
		$report_type= $this->input->post('report_type');
		
		if($report_type=="excel"){
		    
		$this->load->library("excel");
		
        $my_data_titles = array(
			

            array(
            'sr_no'                  =>  'Sr No',
            'supplier'               =>  'Supplier',
            'supplier_reference'     =>  'Supplier reference',
			'supplier_invoice'       =>  'Supplier invoice',
			'supplier_credits'       =>  'Supplier Credits',
			'status'                 =>  'Status',
			'sales_invoice'          =>  'Sales invoice',
			'sales_invoice_paid'     =>  'Sales invoice paid',
			'sales_credits'          =>  'Sales Credits',
			's_status'               =>  'Status',
			'balance'                =>  'Balance'
            )
        );
        $my_data = array();
       
		$count = 1;
		$key=0;
		$i=2;
		$indexes = array();
		$prjprt_specifications = array();
		
		foreach($project_all as $p => $project) {
			if(array_key_exists($project['project_id'],$supplier_rec_project) || array_key_exists($project['project_id'],$sales_rec_project)){
				 $indexes[] = $i;
				 $my_data[$key]['sr_no'] = "";
				 $my_data[$key]['supplier'] = "";
				 $my_data[$key]['supplier_reference'] ="";
				 $my_data[$key]['supplier_invoice'] = ""; 
				 $my_data[$key]['supplier_credits'] = "";
				 $my_data[$key]['status'] = stripslashes($project['project_title']);
				 $my_data[$key]['sales_invoice'] = "";
				 $my_data[$key]['sales_invoice_paid'] = "";
				 $my_data[$key]['sales_credits'] = "";
				 $my_data[$key]['s_status'] = "";
				 $my_data[$key]['balance'] = "";
				$balance=0;
			   
		    if(array_key_exists($project['project_id'],$supplier_rec_project)){
			
				
			 foreach($supplier_rec_project[$project['project_id']] as $s_record){
				$supplier_amount = number_format(($s_record['invoice_amount']*($s_record['va_tax']/100))+$s_record['invoice_amount'], 2, '.', '');
										$supplier_credits = number_format(get_total_supplier_credits($s_record['id']),2,".","");
										$balance -=($supplier_amount-$supplier_credits);
				if(($transaction_type=="paid" && ($s_record['status']=="Paid" || $s_record['status']=="PAID")) || $transaction_type=="all"){
				$key++;
				$prjprt_specifications[] = $project;
				
			   $my_data[$key]['sr_no'] = $count;
			   $my_data[$key]['supplier'] = $s_record['supplier_name'];
			   $my_data[$key]['supplier_reference'] = $s_record['supplierrefrence'];
			   $my_data[$key]['supplier_invoice'] = "$".number_format(($s_record['invoice_amount']*($s_record['va_tax']/100))+$s_record['invoice_amount'], 2, '.', ',')." "; 
			   $my_data[$key]['supplier_credits'] = "-$".number_format(get_total_supplier_credits($s_record['id']),2,".",",")." ";
			   $my_data[$key]['status'] = $s_record['status'];
			   $my_data[$key]['sales_invoice'] = "";
			   $my_data[$key]['sales_invoice_paid'] = "";
			   $my_data[$key]['sales_credits'] = "";
			   $my_data[$key]['s_status'] = "";
			   $my_data[$key]['balance'] = "$".number_format($balance, 2, '.', ',')." "; 
               $count++;
			   $i++;
              			   
			 }
			 }
			 
			}
			
			if(array_key_exists($project['project_id'],$sales_rec_project)){
				foreach($sales_rec_project[$project['project_id']] as $sales_record){
				$balance +=(number_format(($sales_record['invoice_amount']*($sales_record['va_tax']/100))+$sales_record['invoice_amount'], 2, '.', '')-number_format(get_total_sales_credits($sales_record['id']),2,".",""));
									
				if(($transaction_type=="paid" && ($sales_record['status']=="Paid" || $sales_record['status']=="PAID")) || $transaction_type=="all"){
				$key++;	
				$prjprt_specifications[] = $project;
				$my_data[$key]['sr_no'] = $count;
			    $my_data[$key]['supplier'] = "";
			    $my_data[$key]['supplier_reference'] = "";
			    $my_data[$key]['supplier_invoice'] = ""; 
			    $my_data[$key]['supplier_credits'] = "";
			    $my_data[$key]['status'] = "";
			    $my_data[$key]['sales_invoice'] = $sales_record['notes'];
			    $my_data[$key]['sales_invoice_paid'] = "$".number_format(($sales_record['invoice_amount']*($sales_record['va_tax']/100))+$sales_record['invoice_amount'], 2, '.', '');
			    $my_data[$key]['sales_credits'] = "-$".number_format(get_total_sales_credits($sales_record['id']),2,".",",");
			    $my_data[$key]['s_status'] = $sales_record['status'];
			    $my_data[$key]['balance'] = "$".number_format($balance, 2, '.', ',')." "; 
                $count++;
				$i++;
                			
				}
				}
			}
			$key++;
			$i++;
			}
		
		}
		
		$all_data = array_merge($my_data_titles, $my_data);
		$total_records = $key+2;
		
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Project Transactions Report');
		
		for($i=0;$i<count($indexes);$i++){
		$this->excel->getActiveSheet()
        ->getStyle('A'.$indexes[$i].':K'.$indexes[$i])
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('#000000');
		$this->excel->getActiveSheet()->getStyle('A'.$indexes[$i].':K'.$indexes[$i])->getFont()->getColor()->setARGB('#FFFFFF');
		}

        $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($all_data);
 
        $filename='project_transactions_report.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
		//print($tofile);
		}
		else{
		$this->load->library("M_pdf");
		$html = $this->load->view('reports/project_transactions_report/project_transactions_report_pdf', $data, true);

		$pdfFilePath = "project_transactions_report_".date('Y-m-d').".pdf";

		$this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		}
	}
	
	/* Project Transaction Report Section Ends Here*/
	
	/* Tracking Report Section Starts Here */
	
	//Verify Tracking Report Name
	public function verify_tracking_report() {

        $title = $this->input->post("title");
        
        $table = "project_tracking_report";
        
        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'title' => $title,
            'company_id' =>  $this->session->userdata('company_id')
          );
        }
        else{
        $where = array(
            'title' => $title,
            'company_id' =>  $this->session->userdata('company_id')
        );
        }

        $data['row'] = $this->common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
	
	//Get Tracking Report
	function tracking(){
	    $this->common->is_company_page_accessible(48);
		#----------------- get tracking group and project ----------------#
		$get_tracking_reports = $this->reports->get_tracking_groups();
		$data['tracking_reports'] = $get_tracking_reports;
        $this->stencil->title('Tracking Report');
	    $this->stencil->paint('reports/tracking/re_tracking', $data);
	}
    
    //Add Tracking Report Screen
	function add_tracking(){
	    $this->common->is_company_page_accessible(49);
		$data['projects'] = $this->project->get_existing_project();
        $this->stencil->title('Add Tracking');
	    $this->stencil->paint('reports/tracking/create_tracking_group', $data);
	}
	
	//Edit Tracking Report
	function edit_tracking_report($id){
	    $this->common->is_company_page_accessible(48);
		$data['projects'] = $this->project->get_existing_project();
        $data['tracking_item'] = $this->common->select_single_records('project_tracking_report', array("id"=>$id));
        
        if(count($data['tracking_item'])==0){
            $this->session->set_flashdata('err_message', 'No Data Found!');
            redirect(SURL."reports/tracking");
        }
        
        $id = $data['tracking_item']["project_id"];
        
        $lastRow = isset($_GET['last_row']) ? $_GET['last_row'] : 0;
        if ($id > 0) {
            $data['prjprts'] = $this->project->get_tracking_costing_parts_by_project_id($id);
            $counter = count($data['prjprts']);
            $data['counter'] = $lastRow;
        } else {
        
        }
        
		$this->stencil->title('Edit Tracking Report');
	    $this->stencil->paint('reports/tracking/edit_tracking_group', $data);
	}
	
	//Save Tracking Report
	function save_tracking_report(){
		
		$this->form_validation->set_rules('project_id', 'Project', 'required');
		$this->form_validation->set_rules('title', 'Tracking Report Name', 'required|is_unique[project_tracking_report.title]');
		
		if ($this->form_validation->run() == FALSE)
			{
			    $data['projects'] = $this->project->get_existing_project();
                $this->stencil->title('Add Tracking');
        	    $this->stencil->paint('reports/tracking/create_tracking_group', $data);
			}
		else{
		
		$save_tracking_report = $this->reports->save_tracking_report();
		$this->session->set_flashdata('ok_message', 'New Tracking Report created successfully.');
		
		 redirect(SURL . 'reports/tracking');
		 
		}
	}

    //Update Tracking Report
	function update_tracking_report($id){
	    
	    $table = "project_tracking_report";
	    $where = "`id` ='" . $id."'";

	    $data['tracking_report_edit'] = $this->common->select_single_records($table, $where);
	    $original_value = $data['tracking_report_edit']['title'];
		
        if($this->input->post('title') != $original_value) {
            $is_unique =  '|is_unique[project_tracking_report.title]';
        } else {
            $is_unique =  '';
        }
        $this->form_validation->set_rules('title', 'Tracking Report Name', 'required'.$is_unique);
        
        if ($this->form_validation->run() == FALSE){
                $this->common->is_company_page_accessible(48);
        		$data['projects'] = $this->project->get_existing_project();
                $data['tracking_item'] = $this->common->select_single_records('project_tracking_report', array("id"=>$id));
                
                if(count($data['tracking_item'])==0){
                    $this->session->set_flashdata('err_message', 'No Data Found!');
                    redirect(SURL."reports/tracking");
                }
                
                $id = $data['tracking_item']["project_id"];
                
                $lastRow = isset($_GET['last_row']) ? $_GET['last_row'] : 0;
                if ($id > 0) {
                    $data['prjprts'] = $this->project->get_tracking_costing_parts_by_project_id($id);
                    $counter = count($data['prjprts']);
                    $data['counter'] = $lastRow;
                } else {
                
                }
                $this->stencil->title('Edit Tracking Report');
	            $this->stencil->paint('reports/tracking/edit_tracking_group', $data);
        }
        else{
        		
		$save_tracking_report = $this->reports->update_tracking_report($id);
		
		$this->session->set_flashdata('ok_message', 'Tracking Report updated successfully.');
		
		 redirect(SURL.'reports/tracking_report/'.$id);
        }
	}
    
    //Delete Tracking Report
	function delete_tracking(){
		$id = $this->input->post('id');
		$delete_tracking = $this->reports->delete_tracking($id);
	}
    
    //Get Tracking Report
	function tracking_report($id){
		
		#----------------- get tracking group and project ----------------#
		$get_tracking_reports = $this->reports->get_tracking_reports($id);
		$data['tracking_report'] = $get_tracking_reports;

		#----------------- get soting parts fgor that group----------------#
		$costing_part_ids = explode(',', $get_tracking_reports->costing_part_ids);
		$get_group_parts = $this->reports->get_group_parts($costing_part_ids);
		foreach($get_group_parts as $key => $val){
		    $updated_quantity = get_recent_quantity($val->costing_part_id);

            if(count($updated_quantity)>0){
                        if($updated_quantity['total']==$updated_quantity['updated_quantity']){
                          $updated_quantity['total'] = 0;  
                        }
                        else{
                            $costing_quantity = $val->costing_quantity+$updated_quantity['total'];
                        }
            }
            else if(count($updated_quantity)==0 && $val->is_variated==1){
                $costing_quantity=0;
            }
            else{
               $costing_quantity = $val->costing_quantity;
            }
		    $get_group_parts[$key]->budget = $val->costing_uc * $costing_quantity;
		}
		$data['group_parts'] = json_encode($get_group_parts);
		
		$get_group_parts_stages = $this->reports->get_group_parts_stages($costing_part_ids);
		$data['group_parts_stages'] = json_encode($get_group_parts_stages);
		$data['tracking_id'] = $id;

        $this->stencil->title('Tracking Report');
	    $this->stencil->paint('reports/tracking/re_tracking_report', $data);
	}
    
    //Save Charts
	public function savecharts(){
		echo $this->input->post('url');			
	}
    
    //Export Tracking Report as PDF
	public function pdf_tracking($id){
		
       	$cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->common->select_single_records('project_users', $cwhere);

        #----------------- get tracking group and project ----------------#
		$get_tracking_reports = $this->reports->get_tracking_reports($id);
		$data['tracking_report'] = $get_tracking_reports;

		#----------------- get soting parts fgor that group----------------#
		$costing_part_ids = explode(',', $get_tracking_reports->costing_part_ids);
		$get_group_parts = $this->reports->get_group_parts($costing_part_ids);
		foreach($get_group_parts as $key => $val){
		    $updated_quantity = get_recent_quantity($val->costing_part_id);

            if(count($updated_quantity)>0){
                        if($updated_quantity['total']==$updated_quantity['updated_quantity']){
                          $updated_quantity['total'] = 0;  
                        }
                        else{
                            $costing_quantity = $val->costing_quantity+$updated_quantity['total'];
                        }
            }
            else if(count($updated_quantity)==0 && $val->is_variated==1){
                $costing_quantity=0;
            }
            else{
               $costing_quantity = $val->costing_quantity;
            }
		    $get_group_parts[$key]->budget = $val->costing_uc * $costing_quantity;
		}
		$data['group_parts'] = $get_group_parts;
		$data['line_chart'] = $this->input->post('line_chart');
		$data['bar_chart'] = $this->input->post('bar_chart');
		
		$this->load->library("M_pdf");

		$html = $this->load->view('reports/tracking/re_tracking_pdf', $data, true);
		$project = str_replace(' ', '-', $get_tracking_reports->project_title);
		$pdfFilePath = "Tracking_Report_".$project.'_'.date('Y-m-d').".pdf";

		$this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 

	}
	
	/* Tracking Report Section Ends Here */
}