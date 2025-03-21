<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('mod_common', 'common');
        $this->load->model('mod_project');
        $this->load->model("mod_variation");
        $this->load->model("mod_reports");
        $this->load->model('mod_saleinvoice');
        if(!$this->session->userdata('user_id')){
			$this->index();
		}
    }
	
	function index(){
		redirect(SURL);
	}
	
	//Get Filter Components
	function components(){
        $term = $this->input->post("searchTerm");
		$components = $this->common->get_filter_components($term);
    	if(count($components)){
    	 foreach($components as $val){
    	 $component_info = get_component_info($val->component_id);
		 if($val->image == ""){
    	     $component_image = "";
    	 }
    	 else{
    	     $component_image = SURL.'assets/components/thumbnail/'.$val->image;
    	 }
    	 $component_name = escapeString($val->component_name).' ('.escapeString($component_info["supplier_name"]).'|'.$val->component_uc.')';
    	 $results['results'][] = array('id' => $val->component_id,'text' =>  $component_name,'image' => $component_image);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Components Found.'); 
    	 }
    	echo json_encode($results);
    }
	
	//Get Filter Stages
	function stages(){
        $term = $this->input->post("searchTerm");
    	if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1, 'stage_name LIKE ' => '%'.$term.'%');
    	}else{
    	   $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1, 'stage_name LIKE ' => '%'.$term.'%');
    	 }
         $stages = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
        
    	 if(count($stages)){
    	 foreach($stages as $val){
    	 $results['results'][] = array('id' => $val['stage_id'],'text' =>  $val['stage_name']);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Stages Found.'); 
    	 }
    	echo json_encode($results);
    }
    
    //Get Filter Existing Projects
    function existingProjects(){
        $term = $this->input->post("searchTerm");
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT cp.*,p.project_title,p.project_id FROM project_costing cp,project_projects p WHERE cp.project_id=p.project_id AND project_title LIKE '%".$term."%' AND cp.company_id='" . $company_id . "'");
    	$projects = $q->result_array();
    	/*if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1, 'stage_name LIKE ' => '%'.$term.'%');
    	}else{
    	   $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1, 'stage_name LIKE ' => '%'.$term.'%');
    	 }*/
         //$stages = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
        
    	 if(count($projects)){
    	 foreach($projects as $val){
    	 $results['results'][] = array('id' => $val['project_id'],'text' =>  $val['project_title']);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Existing Projects Found.'); 
    	 }
    	echo json_encode($results);
    }
    function existingTemplates(){
        $term = $this->input->post("searchTerm");
    	if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'template_status' => 1, 'template_name LIKE ' => '%'.$term.'%');
    	}else{
    	   $cwhere = array('user_id' => $this->session->userdata('user_id'), 'template_status' => 1, 'template_name LIKE ' => '%'.$term.'%');
    	 }
         $templates = $this->common->get_all_records('project_templates', "*", 0, 0, $cwhere, "template_id");
        
    	 if(count($templates)){
    	 foreach($templates as $val){
    	 $results['results'][] = array('id' => $val['template_id'],'text' =>  $val['template_name']);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Existing Templates Found.'); 
    	 }
    	echo json_encode($results);
    }
    function componentSuppliers(){
        $term = $this->input->post("searchTerm");
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'supplier_status' => 1, 'parent_supplier_id' => 0, 'supplier_name LIKE ' => '%'.$term.'%');
    
         $suppliers = $this->common->get_all_records('project_suppliers', "*", 0, 0, $cwhere, "supplier_id");
        
    	 if(count($suppliers)){
    	 foreach($suppliers as $val){
    	 $results['results'][] = array('id' => $val['supplier_id'],'text' =>  $val['supplier_name']);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Suppliers Found.'); 
    	 }
    	echo json_encode($results);
    }
    
    //Get Suppliers List
    public function getsupplier() {
        $prj_costing_id = $this->input->post('costing_id');
        $suppliers = $this->mod_project->get_costing_suppliers_by_costing_id($prj_costing_id);
        $html = '<select class="selectpicker" data-live-search="true" data-style="select-with-transition" name="supplier_id" id="supplier_id" required>';
        foreach ($suppliers AS $k => $v) {
            $html.= '<option value="' . $v['costing_supplier'] . '" >' . $v['supplier_name'] . '</option>';
        }
        $html.='</select>';
        print_r($html);
    }
    
    //Get Project Costing Tracking
    public function get_project_costing_tracking($id = 0) {

      $lastRow = isset($_GET['last_row']) ? $_GET['last_row'] : 0;
      if ($id > 0) {
            $data['prjprts'] = $this->mod_project->get_tracking_costing_parts_by_project_id($id);
              
            $counter = count($data['prjprts']);
        
            $data['counter'] = $lastRow;
            $html = $this->load->view('reports/tracking/populate_stages_for_tracking', $data, true);
            $rArray = array(
              "rData" => $html,
              "counter" => $counter
            );
            echo json_encode($rArray);
        } else {
        
        }
    }
    
    //Get Filter Supplierz Components
    function getSupplierzComponents(){
        $term = $this->input->post("searchTerm");
		
    	$components = $this->common->get_supplierz_filter_components($term);
        
    	 if(count($components)){
    	 foreach($components as $val){
    	 $component_info = get_supplierz_component_info($val->component_id);
		 if($component_info["image"] == ""){
    	     $component_image = "";
    	 }
    	 else{
    	     $component_image = SURL.'assets/price_books/thumbnail/'.$component_info["image"];
    	 }
    	 $component_name = escapeString($val->component_name).' ('.escapeString($this->session->userdata("company_name")).'|'.$val->component_sale_price.')';
    	 $results['results'][] = array('id' => $val->pricebook_component_id,'text' =>  $component_name,'image' => $component_image);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Components Found.'); 
    	 }
    	echo json_encode($results);
    }
    
    //Get Filter Supplierz Stages
    function getSupplierzStages(){
        $term = $this->input->post("searchTerm");
		
    	if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1, 'stage_name LIKE ' => '%'.$term.'%');
    	}else{
    	   $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1, 'stage_name LIKE ' => '%'.$term.'%');
    	 }
         $stages = $this->common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");

    	 if(count($stages)){
    	 foreach($stages as $val){
    	 $results['results'][] = array('id' => $val['stage_id'],'text' =>  $val['stage_name']);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Stages Found.'); 
    	 }
    	echo json_encode($results);
    }
    
    function update_invoice_amount(){
        $projectId =  $_POST['projectId'];
        $type = $_POST['type'];
        $amount = $_POST['amount'];
        $id = $_POST['id'];
        $invoice_amount_checkbox  = $_POST['invoice_amount_checkbox'];
        
        if ($projectId > 0) {
            if($type == "allowance"){
                $this->common->update_table("project_costing_parts", array("costing_part_id" => $id), array("invoice_amount_checkbox" => $invoice_amount_checkbox, "amount_before_creating_invoice" => $amount));
            }
                /*$data['pc_detail'] = $this->mod_project->get_project_costing_info($projectId);
                $data['tax']=$data['pc_detail']->tax_percent;
                $data['balance1']=$balance1=$part_balance=$data['pc_detail']->contract_price;
                $data['prjprts'] = $prjparts= $this->mod_project->get_costing_parts_by_project_id($projectId, "allowance");
                $this->session->set_userdata('balance', $data['pc_detail']->contract_price);
                $totaldiff=0;
                $total_invoice_amount = 0;
                $total_invoice_owing = 0;
                $total_invoice_amount_allowances= 0;
                $total_invoice_amount_paid_allowances= 0;
                $total_invoice_amount_owing_allowances = 0;
                foreach ($prjparts as $ka => $va){
    
                    $invoiced = $this->mod_reports->gettotalactualamount($data['prjprts'][$ka]->costing_part_id);
                    $allocated_allowance_amount = $this->mod_reports->gettotalallowanceamount($data['prjprts'][$ka]->costing_part_id);
    
    
                    $data['prjprts'][$ka]->invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
                    $data['prjprts'][$ka]->payed_ammount=$invoiced['total'];
                    
                    if(isset($invoiced['completely_invoiced'])){
                    $data['prjprts'][$ka]->completely_invoiced=$invoiced['completely_invoiced'];
                    }
    
    
                    $data['prjprts'][$ka]->sales_invoice_item=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($data['prjprts'][$ka]->costing_part_id, 'apd');
    
                    if(count($data['prjprts'][$ka]->sales_invoice_item)){
                        $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($data['prjprts'][$ka]->sales_invoice_item[0]->id);
    
                        $data['prjprts'][$ka]->sales_invoice_item[0]->outstanding=$result_arr[0]['outstanding'] ;
                        $data['prjprts'][$ka]->sales_invoice_item[0]->payment=$result_arr[0]['payment'] ;
    
                    }
    
                    if(count($data['prjprts'][$ka]->sales_invoice_item))
                        $balance1+= $data['prjprts'][$ka]->sales_invoice_item[0]->outstanding;
                    if (isset($data['prjprts'][$ka]->invoiced_amount)) {
                        $totaldiff+= $data['prjprts'][$ka]->invoiced_amount - $va->line_margin;
    
                    }
                    else{
                        $totaldiff+=-$va->line_margin;
                    }
                    //Maria Code
                     $credit_notes_total = 0;
      if(count($data['prjprts'][$ka]->sales_invoice_item)>0){
          $invoiceType = check_invoice_type($data['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id);
          $credit_notes = get_sales_credit_notes($data['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id, $invoiceType);
                            foreach($credit_notes as $credit_note_detail){ 
                               if($invoiceType=="CN-"){
                                   $credit_notes_total +=$credit_note_detail['total'];
                                }
                                else{
                                    $credit_notes_total = (-1)*$credit_note_detail['total'];
                                }
                                
                            }
    }
                    $tax = 15;
                    
                    if(count($data['prjprts'][$ka]->sales_invoice_item)==0){
                    
                    $invoice_amount = 0;
                    }
                    else{
                        $invoice_amount = (($tax/100)*$data['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount)+$data['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount;
                    }
                        
                    $total_invoice_amount_allowances += $invoice_amount;
                    
                    if(!count($data['prjprts'][$ka]->sales_invoice_item)){
                    
                   
                    $invoice_payment = 0+(-1)*$credit_notes_total;
                    }
                    else{
                        if($data['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount<0){
                        $sales_invoice_payment = $data['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                        $invoice_payment = ($data['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($data['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                        }
                    else{
                        $sales_invoice_payment = $data['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                        $invoice_payment = ($data['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($data['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                    }
                }
                    $total_invoice_amount_paid_allowances += $invoice_payment;
                
                    $owing_amount = $invoice_amount - $invoice_payment;
                    $total_invoice_amount_owing_allowances += $owing_amount;
                    $part_balance+=$invoice_amount;
                    
                }
                $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
                $data['component'] = $this->common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");
                if($type == "allowance"){
                   echo $this->load->view('sales_invoices/part_invoices', $data, true);
                }*/
            
           if($type == "variation"){ 
                $this->common->update_table("project_variations", array("id" => $id), array("invoice_amount_checkbox" => $invoice_amount_checkbox, "amount_before_creating_invoice" => $amount));
           }
                /*$costing_id=$this->mod_project->get_costing_id_from_project_id($projectId);
                $costing_id=$costing_id['costing_id'];
    
                $totalvars=0;
                $approvedvar= $this->mod_variation->getaprovedvarbycosid1($costing_id,'all');
    
                $variationarr = array();
    
                foreach ($approvedvar as $key => $var) {
                    $variationarr[$key]['id']= $var;
                    $extracostvari=$this->mod_reports->getextracostvarebyvarid($var, $costing_id,'sales');
                    $cwhere = array('id' => $var);
                    $variation_detail = $this->common->select_single_records('project_variations', $cwhere);
        
                    $variationarr[$key]['var_number']=$variation_detail["var_number"];
                    $variationarr[$key]['invoice_amount_checkbox']=$variation_detail["invoice_amount_checkbox"];
                    $variationarr[$key]['amount_before_creating_invoice']=$variation_detail["amount_before_creating_invoice"];
                    $variationarr[$key]['variation_description']=$variation_detail["variation_description"];
                    $variationarr[$key]['invoiced_amount']=$variation_detail["project_contract_price"];
                    if(isset($extracostvari['completely_invoiced'])){
                        $variationarr[$key]['completely_invoiced']=$extracostvari['completely_invoiced'];
                    }
                    $sales_invoiceitems=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($var, 'var');
                    $variationarr[$key]['sales_invoices_items']=$sales_invoiceitems;
    
                    if(count($variationarr[$key]['sales_invoices_items'])){
                        $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($variationarr[$key]['sales_invoices_items'][0]->id);
    
                        $variationarr[$key]['sales_invoices_items'][0]->outstanding=$result_arr[0]['outstanding'] ;
                        $variationarr[$key]['sales_invoices_items'][0]->payment=$result_arr[0]['payment'] ;
                    }
                }
                $vardata = array();
                $vardata['variationarr']=$variationarr;
                $vardata['prjprts']=$data['prjprts'];
                $vardata['balance2']=$part_balance;
                $var_balance = $part_balance;
                //print_r($vardata['prjprts']);exit;
                //print_r($variationarr);exit;
                $totalvars = 0;
                $total_invoice_payment = 0;
                foreach ($variationarr as $key => $var) {
                   
                    //Maria Code
                    $credit_notes_total = 0;
                    if(count($var['sales_invoices_items'])>0){
                       $invoiceType = check_invoice_type($var['sales_invoices_items'][0]->sale_invoice_id);
                       $credit_notes = get_sales_credit_notes($var['sales_invoices_items'][0]->sale_invoice_id, $invoiceType);
                                                    
                        foreach($credit_notes as $credit_note_detail){ 
                            if($invoiceType=="CN-"){
                                   $credit_notes_total +=$credit_note_detail['total'];
                            }
                            else{
                                    $credit_notes_total = (-1)*$credit_note_detail['total'];
                            }
                                            
                        }
                    }
                    
                    if (isset($var['invoiced_amount'] ))
                {
                    $totalvars+=$var['invoiced_amount'];
                    $total_cost = $var['invoiced_amount'];
    
                }
                else {
                    $totalvars+=0;
                    $total_cost = 0;
                }
                if(!count($var['sales_invoices_items'])){
                   
                    $invoice_amount = 0;
                }
                else{
                    
                    $invoice_amount = $var['sales_invoices_items'][0]->part_invoice_amount;
                }
                $total_invoice_amount +=$invoice_amount;
                
                    if(!count($var['sales_invoices_items'])){
                    
                    $invoice_payment = 0+(-1)*$credit_notes_total;
                }
                else{
                    if($var['sales_invoices_items'][0]->part_invoice_amount<0){
                    $invoice_payment = ($var['sales_invoices_items'][0]->part_invoice_amount-($var['sales_invoices_items'][0]->outstanding-$credit_notes_total));   
                        
                    }
                    else{
                    $invoice_payment = ($var['sales_invoices_items'][0]->part_invoice_amount-($var['sales_invoices_items'][0]->outstanding-$credit_notes_total));
                    }
                }
                $total_invoice_payment +=$invoice_payment;
                $prev_balance = $invoice_amount - $invoice_payment;
                $total_invoice_owing +=$prev_balance;
                   
                $var_balance+= $total_cost;
                    
                
                }
            
            echo $this->load->view('sales_invoices/variations', $vardata, true);
            }*/
    }
}

    function filterSupplierzComponents(){
        $term = $this->input->post("searchTerm");
		$components = $this->common->filter_supplierz_components($term);
    	if(count($components)){
    	 foreach($components as $val){
    	 $component_info = get_supplierz_component_details($val->component_id);
		 if($val->image == ""){
    	     $component_image = "";
    	 }
    	 else{
    	     $component_image = SURL.'assets/supplierz/components/thumbnail/'.$val->image;
    	 }
    	 $component_name = escapeString($val->component_name).' ('.escapeString($component_info["supplier_name"]).'|'.$val->component_uc.')';
    	 $results['results'][] = array('id' => $val->component_id,'text' =>  $component_name,'image' => $component_image);
    	 }
    	 }
    	 else{
    		$results['results'][] = array('id' =>'','text' => 'No Components Found.'); 
    	 }
    	echo json_encode($results);
    }
}
