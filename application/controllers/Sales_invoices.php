<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoices extends CI_Controller {

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
             $this->load->model("mod_reports");
             $this->load->model('mod_saleinvoice');
             
             $this->load->library('xero');

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(30);

    }
    
    // Get all Sales Invoices
    
    public function index() {

        $this->mod_common->is_company_page_accessible(31);
        
        $data['sales_invoices'] = $this->mod_saleinvoice->get_all_sales_invoices();

        foreach ($data['sales_invoices'] as $key => $value) {


            $cwhere= array('user_id'=> $value['created_by'] );
            $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['cuser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['cuser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['created']= count($usersname);


            $cwhere= array('user_id'=> $value['approved_by'] );
            $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['auser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['auser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['approved']= count($usersname);


            $cwhere= array('user_id'=> $value['exported_by'] );
            $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['euser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['euser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['exported']= count($usersname);

        }


        $this->stencil->title('Sales Invoices');
	    $this->stencil->paint('sales_invoices/manage_sales_invoices', $data);
    }
    
    // Get All Completed Job Sales Invoices
    
    public function get_completed_job_sales_invoices() {

        $this->mod_common->is_company_page_accessible(31);
        
        $data['sales_invoices'] = $this->mod_saleinvoice->get_all_sales_invoices(3);

        foreach ($data['sales_invoices'] as $key => $value) {

            $fields= array('user_fname','user_lname' );
            $cwhere= array('user_id'=> $value['created_by'] );
            $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['cuser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['cuser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['created']= count($usersname);


            $cwhere= array('user_id'=> $value['approved_by'] );
            $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['auser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['auser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['approved']= count($usersname);


            $cwhere= array('user_id'=> $value['exported_by'] );
            $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

            $data['sales_invoices'][$key]['euser_fname']=(count($usersname))? $usersname["user_fname"]: '';
            $data['sales_invoices'][$key]['euser_lname']=(count($usersname))? $usersname["user_lname"]: '';
            $data['sales_invoices'][$key]['exported']= count($usersname);


        }

        $this->load->view('sales_invoices/manage_sales_invoices_ajax', $data);
    }
    
    // Get Project Sales Summary
    
    public function project_sales_summary($curr_proj=0)
	{
	    $this->mod_common->is_company_page_accessible(31);
	    $this->session->unset_userdata('projectdataa');
        $data['projects'] = $this->mod_project->get_active_project_for_sales_summary();
        
        $data['curr_proj']=$curr_proj;
        
        $this->stencil->title('Project Sales Summary');
	    $this->stencil->paint('sales_invoices/project_sales_summary', $data);
	}
	
	 // Get Costing Parts By Selected Project
	public function get_all_by_project() {

        $projectId =  $_POST['projectId'];
        $type = $_POST['type'];
        
        
        if ($projectId > 0) {

            $data['pc_detail'] = $this->mod_project->get_project_costing_info($projectId);
            $data['tax']=$data['pc_detail']->tax_percent;
            $data['balance1']=$balance1=$part_balance=$data['pc_detail']->contract_price;
            $data['prjprts'] = $prjparts= $this->mod_project->get_costing_parts_by_project_id($projectId, $type);
        
            $this->session->set_userdata('balance', $data['pc_detail']->contract_price);
            $totaldiff=0;
            $total_invoice_amount = 0;
            $total_invoice_owing = 0;
            $total_invoice_amount_allowances= 0;
            $total_invoice_amount_paid_allowances= 0;
            $total_invoice_amount_owing_allowances = 0;
            foreach ($prjparts as $ka => $va){
                //print_r($data['prjprts'][$ka]);
                //echo $data['prjprts'][$ka]->costing_part_id;
                $invoiced = $this->mod_reports->gettotalactualamount($data['prjprts'][$ka]->costing_part_id);
                //echo $invoiced['total'];
                
                $allocated_allowance_amount = $this->mod_reports->gettotalallowanceamount($data['prjprts'][$ka]->costing_part_id);
                /*echo "<br>";
                echo $allocated_allowance_amount['total'];
                exit;*/

                $data['prjprts'][$ka]->invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
                $data['prjprts'][$ka]->payed_ammount=$invoiced['total'];
                //print_r($prjparts);exit;
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
                 if($data['prjprts'][$ka]->invoice_amount_checkbox==1){
                    $invoice_amount = $data['prjprts'][$ka]->amount_before_creating_invoice;
                 }
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
                $allowance_cost = ($data['prjprts'][$ka]->line_margin)+($data['prjprts'][$ka]->line_margin*($tax/100));
                $diff=(($data['prjprts'][$ka]->invoiced_amount)+($data['prjprts'][$ka]->invoiced_amount*($tax/100))) - $allowance_cost;
                $part_balance+=$diff<0?($invoice_amount + $diff):($invoice_amount - $diff);
                
            }
            $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
            $data['component'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");
            $allowance = $this->load->view('sales_invoices/part_invoices', $data, true);
            

            $costing_id=$this->mod_project->get_costing_id_from_project_id($projectId);
            $costing_id=$costing_id['costing_id'];

            $totalvars=0;
            $approvedvar= $this->mod_variation->getaprovedvarbycosid1($costing_id,'all');

            $variationarr = array();

            foreach ($approvedvar as $key => $var) {
                $variationarr[$key]['id']= $var;
                $extracostvari=$this->mod_reports->getextracostvarebyvarid($var, $costing_id,'sales');
                $cwhere = array('id' => $var);
                $variation_detail = $this->mod_common->select_single_records('project_variations', $cwhere);
    
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
                if(($var['variation_description']=="Variation From Supplier Credit"))
                {
                    $totalvars-=$var['invoiced_amount'];
                    $total_cost = (-1)*$var['invoiced_amount'];
                }
                else{
                    $totalvars+=$var['invoiced_amount'];
                    $total_cost = $var['invoiced_amount'];
                }

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
            
            $variation = $this->load->view('sales_invoices/variations', $vardata, true);
            
            $data["allowance_balance"] = $var_balance;
            $allowance_invoices_payments = $this->load->view('sales_invoices/part_invoices_payments', $data, true);


            $paydata['prjprts']= $this->mod_saleinvoice->gettemppaymentsbycosid($costing_id);

            foreach ($paydata['prjprts'] as $key => $var) {


                $sales_invoice_items=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($var->payment_id, 'pay');
                
                if(count($sales_invoice_items)){

                $paydata['prjprts'][$key]->sales_invoices_items = $sales_invoice_items;
                }
                else{
                   $paydata['prjprts'][$key]->sales_invoices_items = array(); 
                }

                if(count( $paydata['prjprts'][$key]->sales_invoices_items)){
                    $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($paydata['prjprts'][$key]->sales_invoices_items[0]->id);

                    $paydata['prjprts'][$key]->sales_invoices_items[0]->outstanding=$result_arr[0]['outstanding'] ;
                    $paydata['prjprts'][$key]->sales_invoices_items[0]->payment=$result_arr[0]['payment'] ;
                }

            }


            $paydata['type']=2;
            $paydata['curr_proj']=$_POST['projectId'];
            $paydata['last_row']=$_POST['last_row'];
            $paydata['variationarr']=$variationarr;
            $paydata['balance']=$var_balance;
            $paydata['variation_total_cost'] = $totalvars;
            $paydata['variation_total_invoice_amount_paid'] = $total_invoice_payment;
            $paydata['total_invoice_amount_paid_allowances'] = $total_invoice_amount_paid_allowances;
            $paydata['total_invoice_amount_allowances'] = $total_invoice_amount_allowances;
            $paydata['total_invoice_amount_owing_allowances'] = $total_invoice_amount_owing_allowances;
            $paydata['variation_total_invoice_amount'] = $total_invoice_amount;
            $paydata['variation_total_invoice_owing'] = $total_invoice_owing;
            $payment = $this->load->view('sales_invoices/newitem', $paydata, true);
            $rArray = array("allowance" => $allowance, "allowance_invoices_payments" => $allowance_invoices_payments, "contractprice" => number_format($data['pc_detail']->contract_price, 2, ".", ","), 'totaldiff' => $totaldiff, "variation" => $variation, "totalvars" => $totalvars, "payment"=> $payment, "project_id"=>$projectId );

            echo json_encode($rArray);
        } else {
            echo "";
        }
    }
    
    //Report
    
    public function report($projectId) {

        $data['project_name'] = $this->mod_project->get_project_by_name($projectId);
        $data['project_id'] = $projectId;
        $type = 'allowance';


        $dataa['pc_detail'] = $this->mod_project->get_project_costing_info($projectId);
        $data['contract_price'] = number_format($dataa['pc_detail']->contract_price, 2, ".", ",");
        $dataa['tax']=$dataa['pc_detail']->tax_percent;
        $dataa['balance']=$balance=$part_balance=$dataa['pc_detail']->contract_price;
        $dataa['prjprts'] = $prjparts= $this->mod_project->get_costing_parts_by_project_id($projectId, $type);
        $this->session->set_userdata('balance', $dataa['pc_detail']->contract_price);
        $totaldiff=0;
        
        $total_invoice_amount_allowances=0;
        $total_invoice_amount_paid_allowances=0;
        $total_invoice_amount = 0;
        $total_invoice_owing = 0;
        $total_invoice_amount_owing_allowances = 0;
        
        foreach ($prjparts as $ka => $va){

//                print_r($data['prjprts'][$ka]->costing_part_id);
            //$invoiced=$this->mod_reports->getiabycpidandcq($dataa['prjprts'][$ka]->costing_part_id,$dataa['prjprts'][$ka]->costing_quantity,'sales' );
//                print_r($invoiced);
            $invoiced = $this->mod_reports->gettotalactualamount($dataa['prjprts'][$ka]->costing_part_id);
            
            $allocated_allowance_amount = $this->mod_reports->gettotalallowanceamount($dataa['prjprts'][$ka]->costing_part_id);
            
            $dataa['prjprts'][$ka]->invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
            if(isset($invoiced['completely_invoiced'])){
            $dataa['prjprts'][$ka]->completely_invoiced=$invoiced['completely_invoiced'];
            }

            $dataa['prjprts'][$ka]->sales_invoice_item=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($dataa['prjprts'][$ka]->costing_part_id, 'apd');

            if(count($dataa['prjprts'][$ka]->sales_invoice_item)){
                $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($dataa['prjprts'][$ka]->sales_invoice_item[0]->id);

                $dataa['prjprts'][$ka]->sales_invoice_item[0]->outstanding=$result_arr[0]['outstanding'] ;
                $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment=$result_arr[0]['payment'] ;
            }




            if(count($dataa['prjprts'][$ka]->sales_invoice_item))
                $balance+= $dataa['prjprts'][$ka]->sales_invoice_item[0]->outstanding;
            if (isset($dataa['prjprts'][$ka]->invoiced_amount)) {
                $totaldiff+= $dataa['prjprts'][$ka]->invoiced_amount - $va->line_margin;

            }
            else{
                $totaldiff+=-$va->line_margin;
            }
            
            //Maria Code
                 $credit_notes_total = 0;
  if(count($dataa['prjprts'][$ka]->sales_invoice_item)>0){
    $invoiceType = check_invoice_type($dataa['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id);
    $credit_notes = get_sales_credit_notes($dataa['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id, $invoiceType);
                        foreach($credit_notes as $credit_note_detail){ 
                            if($invoiceType == "CN-"){
                                $credit_notes_total +=$credit_note_detail['total'];
                            }
                            else{
                                $credit_notes_total = (-1)*$credit_note_detail['total'];
                            }
                            
                        }
}
                $tax = 15;
                
                if(count($dataa['prjprts'][$ka]->sales_invoice_item)==0){
                
                $invoice_amount = 0;
                if($dataa['prjprts'][$ka]->invoice_amount_checkbox==1){
                    $invoice_amount = $dataa['prjprts'][$ka]->amount_before_creating_invoice;
                 }
                
                }
                else{
                    $invoice_amount = (($tax/100)*$dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount)+$dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount;
                }
                    
                $total_invoice_amount_allowances += $invoice_amount;
                
                if(!count($dataa['prjprts'][$ka]->sales_invoice_item)){
                
               
                $invoice_payment = 0+(-1)*$credit_notes_total;
                }
                else{
                    if($dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount<0){
                    $sales_invoice_payment = $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                    $invoice_payment = ($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                    }
                else{
                    $sales_invoice_payment = $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                    $invoice_payment = ($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                }
            }
            
            $total_invoice_amount_paid_allowances += $invoice_payment;
            
                $owing_amount = $invoice_amount - $invoice_payment;
               
                $part_balance+=$invoice_amount;
                
                
            }


        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
        $dataa['component'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");


       
        $allowance = $this->load->view('sales_invoices/part_invoices_report', $dataa, true);

        $data['allowance'] = $allowance;

        $costing_id=$this->mod_project->get_costing_id_from_project_id($projectId);
        $costing_id=$costing_id['costing_id'];

        $totalvars=0;
        $approvedvar= $this->mod_variation->getaprovedvarbycosid1($costing_id,'all');

        $variationarr = array();

        foreach ($approvedvar as $key => $var) {
            $variationarr[$key]['id']= $var;
            $extracostvari=$this->mod_reports->getextracostvarebyvarid($var, $costing_id,'sales');
            $cwhere = array('id' => $var);
            $variation_detail = $this->mod_common->select_single_records('project_variations', $cwhere);
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
        $vardata['balance']=$part_balance;
        $var_balance = $part_balance;
        
        $totalvars = 0;
        $total_invoice_payment = 0;
        
        foreach ($variationarr as $key => $var) {
               
                //Maria Code
                
                $credit_notes_total = 0;
                if(count($var['sales_invoices_items'])>0){
                    $invoiceType = check_invoice_type($var['sales_invoices_items'][0]->sale_invoice_id);
                    $credit_notes = get_sales_credit_notes($var['sales_invoices_items'][0]->sale_invoice_id, $invoiceType);
                        foreach($credit_notes as $credit_note_detail){ 
                            if($invoiceType == "CN-"){
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
                
                if(($var['variation_description']=="Variation From Supplier Credit"))
                {
                    $totalvars-=$var['invoiced_amount'];
                    $total_cost = (-1)*$var['invoiced_amount'];
                }
                else{
                $totalvars+=$var['invoiced_amount'];
                $total_cost = $var['invoiced_amount'];
                }

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

        $variation = $this->load->view('sales_invoices/variations_report', $vardata, true);

        $data['variation'] = $variation;


        $paydata['prjprts']= $this->mod_saleinvoice->gettemppaymentsbycosid($costing_id);

        foreach ($paydata['prjprts'] as $key => $var) {


            $sales_invoice_items=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($var->payment_id, 'pay');
            if(count($sales_invoice_items)){
            $paydata['prjprts'][$key]->sales_invoices_items = $sales_invoice_items;
            }
            else{
                $paydata['prjprts'][$key]->sales_invoices_items = array();
            }

            if(count( $paydata['prjprts'][$key]->sales_invoices_items)){
                $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($paydata['prjprts'][$key]->sales_invoices_items[0]->id);

                $paydata['prjprts'][$key]->sales_invoices_items[0]->outstanding=$result_arr[0]['outstanding'] ;
                $paydata['prjprts'][$key]->sales_invoices_items[0]->payment=$result_arr[0]['payment'] ;
            }

        }


        $paydata['type']=2;
        $paydata['variationarr']=$variationarr;
        $paydata['balance']=$var_balance;
        $paydata['variation_total_cost'] = $totalvars;
        $paydata['variation_total_invoice_amount_paid'] = $total_invoice_payment;
        $paydata['total_invoice_amount_paid_allowances'] = $total_invoice_amount_paid_allowances;
        $paydata['total_invoice_amount_allowances'] = $total_invoice_amount_allowances;
        $paydata['total_invoice_amount_owing_allowances'] = $total_invoice_amount_owing_allowances;
        $paydata['variation_total_invoice_amount'] = $total_invoice_amount;
        $paydata['variation_total_invoice_owing'] = $total_invoice_owing;

		
        $payment = $this->load->view('sales_invoices/newitem_report', $paydata, true);
        $data['payment'] = $payment;
        $data['totalvars']=$totalvars;
        $data['totaldiff']=$totaldiff;

        $this->stencil->title('Project Sales Summary Report');
	    $this->stencil->paint('sales_invoices/project_sales_summary_report', $data);
    }
    
    //Report in PDF Format
    function pdf_report($projectId){
       
        //load mPDF library
        $this->load->library('M_pdf');
        
        $data['project_name'] = $this->mod_project->get_project_by_name($projectId);
        $data['project_id'] = $projectId;
        $type = 'allowance';


        $dataa['pc_detail'] = $this->mod_project->get_project_costing_info($projectId);
        $data['contract_price'] = number_format($dataa['pc_detail']->contract_price, 2, ".", ",");
        $dataa['tax']=$dataa['pc_detail']->tax_percent;
        $dataa['balance']=$balance=$part_balance=$dataa['pc_detail']->contract_price;
        $dataa['prjprts'] = $prjparts= $this->mod_project->get_costing_parts_by_project_id($projectId, $type);
        $this->session->set_userdata('balance', $dataa['pc_detail']->contract_price);
        $totaldiff=0;
        $total_invoice_amount = 0;
        $total_invoice_owing = 0;
        $total_invoice_amount_allowances= 0;
        $total_invoice_amount_paid_allowances= 0;
        $total_invoice_amount_owing_allowances = 0;
        
        foreach ($prjparts as $ka => $va){

//                print_r($data['prjprts'][$ka]->costing_part_id);
            //$invoiced=$this->mod_reports->getiabycpidandcq($dataa['prjprts'][$ka]->costing_part_id,$dataa['prjprts'][$ka]->costing_quantity,'sales' );
//                print_r($invoiced);
            $invoiced = $this->mod_reports->gettotalactualamount($dataa['prjprts'][$ka]->costing_part_id);
            
            $allocated_allowance_amount = $this->mod_reports->gettotalallowanceamount($dataa['prjprts'][$ka]->costing_part_id);

            $dataa['prjprts'][$ka]->invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
            if(isset($invoiced['completely_invoiced'])){
               $dataa['prjprts'][$ka]->completely_invoiced=$invoiced['completely_invoiced'];
             }

            $dataa['prjprts'][$ka]->sales_invoice_item=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($dataa['prjprts'][$ka]->costing_part_id, 'apd');

            if(count($dataa['prjprts'][$ka]->sales_invoice_item)){
                $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($dataa['prjprts'][$ka]->sales_invoice_item[0]->id);

                $dataa['prjprts'][$ka]->sales_invoice_item[0]->outstanding=$result_arr[0]['outstanding'] ;
                $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment=$result_arr[0]['payment'] ;
            }




            if(count($dataa['prjprts'][$ka]->sales_invoice_item))
                $balance+= $dataa['prjprts'][$ka]->sales_invoice_item[0]->outstanding;
            if (isset($dataa['prjprts'][$ka]->invoiced_amount)) {
                $totaldiff+= $dataa['prjprts'][$ka]->invoiced_amount - $va->line_margin;

            }
            else{
                $totaldiff+=-$va->line_margin;
            }
            
            //Maria Code
          $credit_notes_total = 0;
          if(count($dataa['prjprts'][$ka]->sales_invoice_item)>0){
                $invoiceType = check_invoice_type($dataa['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id);
                $credit_notes = get_sales_credit_notes($dataa['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id, $invoiceType);
                foreach($credit_notes as $credit_note_detail){ 
                    if($invoiceType == "CN-"){
                        $credit_notes_total +=$credit_note_detail['total'];
                    }
                    else{
                        $credit_notes_total = (-1)*$credit_note_detail['total'];
                    }
                                    
                }
        }
                $tax = 15;
                
                if(count($dataa['prjprts'][$ka]->sales_invoice_item)==0){
                
                    $invoice_amount = 0;
                    if($dataa['prjprts'][$ka]->invoice_amount_checkbox==1){
                        $invoice_amount = $dataa['prjprts'][$ka]->amount_before_creating_invoice;
                     }
                }
                else{
                    $invoice_amount = (($tax/100)*$dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount)+$dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount;
                }
                    
                $total_invoice_amount_allowances += $invoice_amount;
                
                if(!count($dataa['prjprts'][$ka]->sales_invoice_item)){
                
               
                $invoice_payment = 0+(-1)*$credit_notes_total;
                }
                else{
                    if($dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount<0){
                    $sales_invoice_payment = $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                    $invoice_payment = ($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                    }
                else{
                    $sales_invoice_payment = $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                    $invoice_payment = ($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                }
            }
            
                $total_invoice_amount_paid_allowances += $invoice_payment;
                
                $owing_amount = $invoice_amount - $invoice_payment;
               
                  $part_balance+=$invoice_amount;
               
                
            }


        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
        $dataa['component'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");



        $allowance = $this->load->view('sales_invoices/part_invoices_pdf_report', $dataa, true);

        $data['allowance'] = $allowance;

        $costing_id=$this->mod_project->get_costing_id_from_project_id($projectId);
        $costing_id=$costing_id['costing_id'];

        $totalvars=0;
        $approvedvar= $this->mod_variation->getaprovedvarbycosid1($costing_id,'all');

        $variationarr = array();

        foreach ($approvedvar as $key => $var) {
            $variationarr[$key]['id']= $var;
            $extracostvari=$this->mod_reports->getextracostvarebyvarid($var, $costing_id,'sales');
            $cwhere = array('id' => $var);
            $variation_detail = $this->mod_common->select_single_records('project_variations', $cwhere);
            
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
        $var_balance = $part_balance;
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
                    if($invoiceType == "CN-"){
                        $credit_notes_total +=$credit_note_detail['total'];
                    }
                    else{
                        $credit_notes_total = (-1)*$credit_note_detail['total'];
                    }
                                    
                }
            }
                
            if (isset($var['invoiced_amount'] ))
            {
                if(($var['variation_description']=="Variation From Supplier Credit"))
                {
                    $totalvars-=$var['invoiced_amount'];
                    $total_cost = (-1)*$var['invoiced_amount'];
                }
                else{
                    $totalvars+=$var['invoiced_amount'];
                    $total_cost = $var['invoiced_amount'];
                }

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
            
            $total_invoice_payment += $invoice_payment;
                $prev_balance = $invoice_amount - $invoice_payment;
                $total_invoice_owing +=$prev_balance;
                $var_balance+= $total_cost;
            
            }


        $vardata['balance']=$part_balance;

        $variation = $this->load->view('sales_invoices/variations_pdf_report', $vardata, true);

        $data['variation'] = $variation;


        $paydata['prjprts']= $this->mod_saleinvoice->gettemppaymentsbycosid($costing_id);

        foreach ($paydata['prjprts'] as $key => $var) {


            $sales_invoice_items=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($var->payment_id, 'pay');
            if(count($sales_invoice_items)){
            $paydata['prjprts'][$key]->sales_invoices_items = $sales_invoice_items;
            }
            else{
                $paydata['prjprts'][$key]->sales_invoices_items = array(); 
            }

            if(count( $paydata['prjprts'][$key]->sales_invoices_items)){
                $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($paydata['prjprts'][$key]->sales_invoices_items[0]->id);

                $paydata['prjprts'][$key]->sales_invoices_items[0]->outstanding=$result_arr[0]['outstanding'] ;
                $paydata['prjprts'][$key]->sales_invoices_items[0]->payment=$result_arr[0]['payment'] ;
            }

        }


        $paydata['type']=2;
        $paydata['variationarr']=$variationarr;
        $paydata['balance']=$var_balance;
        $paydata['variation_total_cost'] = $totalvars;
        $paydata['variation_total_invoice_amount_paid'] = $total_invoice_payment;
        $paydata['total_invoice_amount_paid_allowances'] = $total_invoice_amount_paid_allowances;
        $paydata['total_invoice_amount_allowances'] = $total_invoice_amount_allowances;
        $paydata['total_invoice_amount_owing_allowances'] = $total_invoice_amount_owing_allowances;
        $paydata['variation_total_invoice_amount'] = $total_invoice_amount;
        $paydata['variation_total_invoice_owing'] = $total_invoice_owing;

		
        $payment = $this->load->view('sales_invoices/newitem_pdf_report', $paydata, true);
        $data['payment'] = $payment;
        $data['totalvars']=$totalvars;
        $data['totaldiff']=$totaldiff;

        $cwhere = array('user_id' => $this->session->userdata('company_id'));
        $data['company_info'] = $this->mod_common->select_single_records('project_users', $cwhere);
        
        $html = $this->load->view('sales_invoices/sales_summary_pdf', $data, true);
        
        $pdfFilePath = "sales_summary_report_".date('Y-m-d').".pdf";

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 

    }
    
    //Report in Excel Format
    function excel_report($projectId){

        $data['project_name'] = $this->mod_project->get_project_by_name($projectId);
        $data['project_id'] = $projectId;
        $type = 'allowance';


        $dataa['pc_detail'] = $this->mod_project->get_project_costing_info($projectId);
        $data['contract_price'] = number_format($dataa['pc_detail']->contract_price, 2, ".", ",");
        $dataa['tax']=$dataa['pc_detail']->tax_percent;
        $dataa['balance']=$balance=$part_balance=$dataa['pc_detail']->contract_price;
        $dataa['prjprts'] = $prjparts= $this->mod_project->get_costing_parts_by_project_id($projectId, $type);
        $this->session->set_userdata('balance', $dataa['pc_detail']->contract_price);
        $totaldiff=0;
        $total_invoice_amount_allowances=0;
        $total_invoice_amount_paid_allowances=0;
        $total_invoice_amount = 0;
        $total_invoice_owing = 0;
        $total_invoice_amount_owing_allowances = 0;
        foreach ($prjparts as $ka => $va){


            $invoiced = $this->mod_reports->gettotalactualamount($dataa['prjprts'][$ka]->costing_part_id);
            
            $allocated_allowance_amount = $this->mod_reports->gettotalallowanceamount($dataa['prjprts'][$ka]->costing_part_id);

            $dataa['prjprts'][$ka]->invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
            if(isset($invoiced['completely_invoiced'])){
               $dataa['prjprts'][$ka]->completely_invoiced=$invoiced['completely_invoiced'];
            }

            $dataa['prjprts'][$ka]->sales_invoice_item=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($dataa['prjprts'][$ka]->costing_part_id, 'apd');

            if(count($dataa['prjprts'][$ka]->sales_invoice_item)){
                $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($dataa['prjprts'][$ka]->sales_invoice_item[0]->id);

                $dataa['prjprts'][$ka]->sales_invoice_item[0]->outstanding=$result_arr[0]['outstanding'] ;
                $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment=$result_arr[0]['payment'] ;
            }

            if(count($dataa['prjprts'][$ka]->sales_invoice_item))
                $balance+= $dataa['prjprts'][$ka]->sales_invoice_item[0]->outstanding;
            if (isset($dataa['prjprts'][$ka]->invoiced_amount)) {
                $totaldiff+= $dataa['prjprts'][$ka]->invoiced_amount - $va->line_margin;

            }
            else{
                $totaldiff+=-$va->line_margin;
            }
            
             //Maria Code
                 $credit_notes_total = 0;
          if(count($dataa['prjprts'][$ka]->sales_invoice_item)>0){
              $invoiceType = check_invoice_type($dataa['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id);
                        $credit_notes = get_sales_credit_notes($dataa['prjprts'][$ka]->sales_invoice_item[0]->sale_invoice_id, $invoiceType);
                        foreach($credit_notes as $credit_note_detail){ 
                            if($invoiceType == "CN-"){
                                $credit_notes_total +=$credit_note_detail['total'];
                            }
                            else{
                                $credit_notes_total = (-1)*$credit_note_detail['total'];
                            }
                                            
                        }
        }
                $tax = 15;
                
                if(count($dataa['prjprts'][$ka]->sales_invoice_item)==0){
                
                $invoice_amount = 0;
                if($dataa['prjprts'][$ka]->invoice_amount_checkbox==1){
                    $invoice_amount = $dataa['prjprts'][$ka]->amount_before_creating_invoice;
                 }
                }
                else{
                    $invoice_amount = (($tax/100)*$dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount)+$dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount;
                }
                    
                $total_invoice_amount_allowances += $invoice_amount;
                
                if(!count($dataa['prjprts'][$ka]->sales_invoice_item)){
                
               
                $invoice_payment = 0+(-1)*$credit_notes_total;
                }
                else{
                    if($dataa['prjprts'][$ka]->sales_invoice_item[0]->part_invoice_amount<0){
                    $sales_invoice_payment = $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                    $invoice_payment = ($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                    }
                else{
                    $sales_invoice_payment = $dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                    $invoice_payment = ($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)+(($dataa['prjprts'][$ka]->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                }
            }
            
                $total_invoice_amount_paid_allowances += $invoice_payment;
                
                $owing_amount = $invoice_amount - $invoice_payment;
               
                  $part_balance+=$invoice_amount;
               
                
            }


        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
        $dataa['component'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");



        $allowance = $this->load->view('sales_invoices/part_invoices_pdf_report', $dataa, true);

        $data['allowance'] = $allowance;

        $costing_id=$this->mod_project->get_costing_id_from_project_id($projectId);
        $costing_id=$costing_id['costing_id'];

        $totalvars=0;
        $approvedvar= $this->mod_variation->getaprovedvarbycosid1($costing_id,'all');

        $variationarr = array();

        foreach ($approvedvar as $key => $var) {
            $variationarr[$key]['id']= $var;
            $extracostvari=$this->mod_reports->getextracostvarebyvarid($var, $costing_id,'sales');
            $cwhere = array('id' => $var);
            $variation_detail = $this->mod_common->select_single_records('project_variations', $cwhere);
            
            $variationarr[$key]['var_number']=$variation_detail["var_number"];
            $variationarr[$key]['invoice_amount_checkbox']=$variation_detail["invoice_amount_checkbox"];
            $variationarr[$key]['amount_before_creating_invoice']=$variation_detail["amount_before_creating_invoice"];
            $variationarr[$key]['variation_description']=$variation_detail["variation_description"];
            $variationarr[$key]['invoiced_amount']=$variation_detail["project_contract_price"];
            if(isset($extracostvari['completely_invoiced'])){
               $variationarr[$key]['completely_invoiced']=$extracostvari['completely_invoiced'];
            }
            // $cwhere = array('type_id' => $var , 'type' => 'var');
            // $sales_invoices = $this->common->get_data_by_where('sales_invoices_items', $fields = false, $cwhere);
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
        $var_balance = $part_balance;
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
                        if($invoiceType == "CN-"){
                            $credit_notes_total +=$credit_note_detail['total'];
                        }
                        else{
                            $credit_notes_total = (-1)*$credit_note_detail['total'];
                        }
                    }
                }
                
                if (isset($var['invoiced_amount'] ))
            {
                if(($var['variation_description']=="Variation From Supplier Credit"))
                {
                    $totalvars-=$var['invoiced_amount'];
                    $total_cost = (-1)*$var['invoiced_amount'];
                }
                else{
                    $totalvars+=$var['invoiced_amount'];
                    $total_cost = $var['invoiced_amount'];
                }

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
            
            $total_invoice_payment += $invoice_payment;
                $prev_balance = $invoice_amount - $invoice_payment;
                $total_invoice_owing +=$prev_balance;
                $var_balance+= $total_cost;
            
            }


        $vardata['balance']=$part_balance;

        $variation = $this->load->view('sales_invoices/variations_pdf_report', $vardata, true);

        $data['variation'] = $variation;


        $paydata['prjprts']= $this->mod_saleinvoice->gettemppaymentsbycosid($costing_id);

        foreach ($paydata['prjprts'] as $key => $var) {


            $sales_invoice_items=$this->mod_saleinvoice->get_sale_invoice_items_by_type_and_type_id($var->payment_id, 'pay');

            $paydata['prjprts'][$key]->sales_invoices_items = $sales_invoice_items;

            if(count( $paydata['prjprts'][$key]->sales_invoices_items)){
                $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($paydata['prjprts'][$key]->sales_invoices_items[0]->id);

                $paydata['prjprts'][$key]->sales_invoices_items[0]->outstanding=$result_arr[0]['outstanding'] ;
                $paydata['prjprts'][$key]->sales_invoices_items[0]->payment=$result_arr[0]['payment'] ;
            }

        }


        $paydata['type']=2;
        $paydata['variationarr']=$variationarr;
        $paydata['balance']=$var_balance;
        $paydata['variation_total_cost'] = $totalvars;
        $paydata['variation_total_invoice_amount_paid'] = $total_invoice_payment;
        $paydata['total_invoice_amount_paid_allowances'] = $total_invoice_amount_paid_allowances;
        $paydata['total_invoice_amount_allowances'] = $total_invoice_amount_allowances;
        $paydata['total_invoice_amount_owing_allowances'] = $total_invoice_amount_owing_allowances;
        $paydata['variation_total_invoice_amount'] = $total_invoice_amount;
        $paydata['variation_total_invoice_owing'] = $total_invoice_owing;
        $payment = $this->load->view('sales_invoices/newitem_pdf_report', $paydata, true);
        $data['payment'] = $payment;
        $data['totalvars']=$totalvars;
        $data['totaldiff']=$totaldiff;
        $cwhere = array('user_id' => $this->session->userdata('company_id'));
        $fields = '`com_logo`';
        $data['company_info'] = $this->mod_common->select_single_records('project_users', $cwhere);
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;Filename=sales_summary_report_".date('Y-m-d').".xls");

        echo "<html>";
        echo "";
        echo "<body>";
         echo $html = $this->load->view('sales_invoices/sales_summary_excel', $data, true);
        echo "</body>";
        echo "</html>";
       
        
    }
    
    public function exportinvoiceswizard($invoice_id){
        $data['file_ids'] =$this->mod_saleinvoice->get_file_ids('sale','PENDING');
        $data['invoice_id'] = $invoice_id;

        $this->stencil->title('Export Sales Invoice');
	    $this->stencil->paint('sales_invoices/saleinvoiceexportwizard', $data);
    }
    
    // Update Sales Invoice Status
    function update_status(){
        $xero_credentials = get_xero_credentials();
        $id=$this->input->post('id');
        $status=$this->input->post('status');
        $approved_by = 0;
        if($status == "APPROVED"){
            $approved_by = $this->session->userdata('user_id');
        }
        $where= array(

                'id' => $id

            );
       $salesinvoices = array(

                'status' => $status,
                'approved_by' => $approved_by

            );
        
        $data['order_status'] = $status;
        $data['order_id'] = $id;
        $cwhere = array('id' => $id);
        $invoiceDetails = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        
        $exstinginvoiceamount=$invoiceDetails["invoice_amount"];
        $exstingduedate=date('d/m/Y',strtotime($invoiceDetails["due_date"]));
        $exstingcreateddate=date('d/m/Y',strtotime($invoiceDetails["date_created"]));
        $exstingnote=$invoiceDetails["notes"];
        $exstinginvoicestatus = $invoiceDetails["status"];
        $account_number = $invoiceDetails["account_number"];
        $company_name = $invoiceDetails["company_name"];
        $company_postal_address = $invoiceDetails["company_postal_address"];
        $company_street_address = $invoiceDetails["company_street_address"];
        $company_phone_number = $invoiceDetails["company_phone_number"];
        $company_email = $invoiceDetails["company_email"];
        $company_website = $invoiceDetails["company_website"];
        $company_gst_number = $invoiceDetails["company_gst_number"];
      
        if($status=='APPROVED' &&  $exstinginvoicestatus=='PENDING' ){
            
            $invoice_id = $id;
            
            $cwhere = array('id' => $id);
            $invoice_detail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
            
            $invoice_number = $invoice_detail["id"] + 2000000;
            
            $invoice_date = date("Y-m-d", strtotime($invoice_detail["date_created"]));

            if($invoice_detail["due_date"]!=""){ 
                $invoice_due_date = date("Y-m-d", strtotime($invoice_detail["due_date"])); 
                
            } else{ 
                $invoice_due_date = date('Y-m-d');  
                
            }
            
            
            $cwhere = array('project_id' => $invoice_detail["project_id"]);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            
            $where 	= array('project_id' => $invoice_detail["project_id"]);
		    $project_tax = $this->mod_common->select_single_records('project_costing', $where);
            
            $tracking_name = $xero_credentials["tracking_category_name"];
            
            $quantity = 1;
            $k=0;
            $line_items = array();
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'apd');
            $data['apdsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*",  0, 0, $cwhere);
            
            if(count($data['apdsiis'])>0){
                foreach ($data['apdsiis']  as $key => $apdsii) {
                    
                    $p_amount = $apdsii["part_invoice_amount"];
                     
                    $part_amount = $p_amount+($p_amount*($project_tax["tax_percent"]/100));
                
                    $line_items[$k]["Description"]= 'Allowance Part difference for (Part name: ' . $apdsii["part_name"] . ' ) against  (Component: ' . $apdsii["description"] . ')';
        		    $line_items[$k]["Quantity"]= $quantity;
        		    $line_items[$k]["UnitAmount"]= $part_amount;
        		    $line_items[$k]["LineAmount"]= $part_amount;
        		    $line_items[$k]["TaxType"]= "OUTPUT2";
        		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
        		    $line_items[$k]["AccountCode"]= "200";
        		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                    $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                    $k++; 
                }
            }
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'var');
            $data['varsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);

            foreach ($data['varsiis']  as $key => $varsii) {
                $part_amount = $varsii["part_invoice_amount"];
            
                $line_items[$k]["Description"]= ' Variation # '.($varsii["type_id"]+1000000) .': '.$varsii["description"];
    		    $line_items[$k]["Quantity"]= $quantity;
    		    $line_items[$k]["UnitAmount"]= $part_amount;
    		    $line_items[$k]["LineAmount"]= $part_amount;
    		    $line_items[$k]["TaxType"]= "OUTPUT2";
    		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
    		    $line_items[$k]["AccountCode"]= "200";
    		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                $k++; 
            }
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'pay');
            $data['paysiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
            
            foreach ($data['paysiis']  as $key => $paysii) {
                
                $part_amount = $paysii["part_invoice_amount"];
                
                
                $line_items[$k]["Description"]= 'Payment # '.$paysii["type_id"] .': '.$paysii["description"];
    		    $line_items[$k]["Quantity"]= $quantity;
    		    $line_items[$k]["UnitAmount"]= $part_amount;
    		    $line_items[$k]["LineAmount"]= $part_amount;
    		    $line_items[$k]["TaxType"]= "OUTPUT2";
    		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
    		    $line_items[$k]["AccountCode"]= "200";
    		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                $k++; 
            }
            
            
		               
		    $where 			= array('client_id' => $project_title["client_id"]);
		    $client_info = $this->mod_common->select_single_records('project_clients', $where);
			
			
				$InvoiceNumber = "INV-".$invoice_number;
			
                       $new_invoice = array("Invoices" => array(
                                			array(
                                				"Type"=>"ACCREC",
                                				"Contact" => array(
                                					"Name" => $client_info["client_fname1"].' '.$client_info["client_surname1"].' '.$client_info["client_fname2"].' '.$client_info["client_surname2"]
                                				),
                                				"Date" => $invoice_date,
                                				"DueDate" => $invoice_due_date,
                                				"InvoiceNumber" => $InvoiceNumber,
                                				"Status" => "AUTHORISED",
                                				"LineAmountTypes" => "Inclusive",
                                				"LineItems"=> $line_items
                                			)
                                		)
                                	   );
                      
                     
                       $new_contact = array(
                			array(
                				"Name" => $client_info["client_fname1"]." ".$client_info["client_surname1"]." ".$client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"FirstName" => $client_info["client_fname1"]." ".$client_info["client_surname1"],
                				"LastName" => $client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"Addresses" => array(
                					"Address" => array(
                						array(
                							"AddressType" => "POBOX",
                							"AddressLine1" => $client_info["post_street_pobox"],
                							"City" => $client_info["client_postal_city"],
                							"PostalCode" => $client_info["client_postal_zip"]
                						),
                						array(
                							"AddressType" => "STREET",
                							"AddressLine1" => $client_info["street_pobox"],
                							"City" => $client_info["client_city"],
                							"PostalCode" => $client_info["client_zip"]
                						)
                					)
                				)
                			)
                		);
                		 if(count($xero_credentials)>0){
                		// create the contact
                		$contact_result = $this->xero->Contacts($new_contact);
                		
                		// create the invoice
                    	$invoice_result = $this->xero->Invoices($new_invoice);
                    	
                    	$xero_invoice_id = $invoice_result['Invoices']['Invoice']['InvoiceID'];
                    	
                    	$partispp=array('xero_invoice_id' => $xero_invoice_id);
                        $wherepp = array('id' => $invoice_id);
                        $this->mod_common->update_table('project_sales_invoices', $wherepp, $partispp);
                        
                		 }
        }
        
        $this->mod_common->update_table('project_sales_invoices', array("id" => $invoice_id), $salesinvoices);
        
        $html = $this->load->view('sales_invoices/status_ajax.php', $data, true);
        echo $html;
    }
    
    // Add New Payment Row
    public function add_new_temp_payment(){


        $data['prjprts']=array();
        $obj=(object) 'obj'; $data['prjprts'][0]=$obj;

        $data['type']=1;
        $data['balance']=$_POST['balance'];
        $data['project_id']=$_POST['project_id'];
        $data['last_row']=$_POST['last_row'];
        $data['prjprts'][0]->sales_invoices_items=array();
        $newitem = $this->load->view('sales_invoices/newitem', $data, true);

        $rArray = array("newitem" => $newitem);
        echo json_encode($rArray);

    }
    
    //Update Sales Invoice Status
    public function updatecomsinvoicestatus($invoice_id){
        
        $xero_credentials = get_xero_credentials();
        $cwhere = array('id' => $invoice_id);
        $invoiceDetails = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        
        $exstinginvoiceamount=$invoiceDetails["invoice_amount"];
        $exstingduedate=date('d/m/Y',strtotime($invoiceDetails["due_date"]));
        $exstingcreateddate=date('d/m/Y',strtotime($invoiceDetails["date_created"]));
        $exstingnote=$invoiceDetails["notes"];
        $exstinginvoicestatus = $invoiceDetails["status"];
        $account_number = $invoiceDetails["account_number"];
        $company_name = $invoiceDetails["company_name"];
        $company_postal_address = $invoiceDetails["company_postal_address"];
        $company_street_address = $invoiceDetails["company_street_address"];
        $company_phone_number = $invoiceDetails["company_phone_number"];
        $company_email = $invoiceDetails["company_email"];
        $company_website = $invoiceDetails["company_website"];
        $company_gst_number = $invoiceDetails["company_gst_number"];

        if($exstinginvoicestatus!=$_POST['status']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('status'=> $_POST['status']));
        }
        if($exstingduedate!=$_POST['due_date']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('due_date'=> date('Y-m-d H:i:s', DateTime::createFromFormat('d/m/Y', $this->input->post('due_date'))->getTimestamp())));
        }
        if($exstingcreateddate!=$_POST['created_date']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('date_created'=>  date('Y-m-d H:i:s', DateTime::createFromFormat('d/m/Y', $this->input->post('created_date'))->getTimestamp())));
        }
        if($exstinginvoicestatus!=$_POST['notes']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('notes'=> $_POST['notes']));
        }

        if($account_number!=$_POST['account_number']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('account_number'=> $_POST['account_number']));
        }

        if($company_name!=$_POST['company_name']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_name'=> $_POST['company_name']));
        }

        if($company_postal_address!=$_POST['company_postal_address']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_postal_address'=> $_POST['company_postal_address']));
        }

        if($company_street_address!=$_POST['company_street_address']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_street_address'=> $_POST['company_street_address']));
        }

        if($company_phone_number!=$_POST['company_phone_number']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_phone_number'=> $_POST['company_phone_number']));
        }

        if($company_email!=$_POST['company_email']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_email'=> $_POST['company_email']));
        }

        if($company_website!=$_POST['company_website']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_website'=> $_POST['company_website']));
        }

        if($company_gst_number!=$_POST['company_gst_number']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('company_gst_number'=> $_POST['company_gst_number']  ) , array('id'=> $invoice_id));
        }
        
        if($_POST['status']=='APPROVED' &&  $exstinginvoicestatus=='PENDING' ){
            
            $cwhere = array('id' => $invoice_id);
            $invoice_detail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
            
            $invoice_number = $invoice_detail["id"] + 2000000;
            
            $invoice_date = date("Y-m-d", strtotime($invoice_detail["date_created"]));

            if($invoice_detail["due_date"]!=""){ 
                $invoice_due_date = date("Y-m-d", strtotime($invoice_detail["due_date"])); 
                
            } else{ 
                $invoice_due_date = date('Y-m-d');  
                
            }
            
            
            $cwhere = array('project_id' => $invoice_detail["project_id"]);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            
            $where 	= array('project_id' => $invoice_detail["project_id"]);
		    $project_tax = $this->mod_common->select_single_records('project_costing', $where);
            
            $tracking_name = $xero_credentials["tracking_category_name"];
            
            $quantity = 1;
            $k=0;
            $line_items = array();
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'apd');
            $data['apdsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*",  0, 0, $cwhere);
            
            if(count($data['apdsiis'])>0){
                foreach ($data['apdsiis']  as $key => $apdsii) {
                    
                    $p_amount = $apdsii["part_invoice_amount"];
                     
                    $part_amount = $p_amount+($p_amount*($project_tax["tax_percent"]/100));
                
                    $line_items[$k]["Description"]= 'Allowance Part difference for (Part name: ' . $apdsii["part_name"] . ' ) against  (Component: ' . $apdsii["description"] . ')';
        		    $line_items[$k]["Quantity"]= $quantity;
        		    $line_items[$k]["UnitAmount"]= $part_amount;
        		    $line_items[$k]["LineAmount"]= $part_amount;
        		    $line_items[$k]["TaxType"]= "OUTPUT2";
        		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
        		    $line_items[$k]["AccountCode"]= "200";
        		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                    $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                    $k++; 
                }
            }
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'var');
            $data['varsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);

            foreach ($data['varsiis']  as $key => $varsii) {
                $part_amount = $varsii["part_invoice_amount"];
            
                $line_items[$k]["Description"]= ' Variation # '.($varsii["type_id"]+1000000) .': '.$varsii["description"];
    		    $line_items[$k]["Quantity"]= $quantity;
    		    $line_items[$k]["UnitAmount"]= $part_amount;
    		    $line_items[$k]["LineAmount"]= $part_amount;
    		    $line_items[$k]["TaxType"]= "OUTPUT2";
    		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
    		    $line_items[$k]["AccountCode"]= "200";
    		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                $k++; 
            }
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'pay');
            $data['paysiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
            
            foreach ($data['paysiis']  as $key => $paysii) {
                
                $part_amount = $paysii["part_invoice_amount"];
                
                
                $line_items[$k]["Description"]= 'Payment # '.$paysii["type_id"] .': '.$paysii["description"];
    		    $line_items[$k]["Quantity"]= $quantity;
    		    $line_items[$k]["UnitAmount"]= $part_amount;
    		    $line_items[$k]["LineAmount"]= $part_amount;
    		    $line_items[$k]["TaxType"]= "OUTPUT2";
    		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
    		    $line_items[$k]["AccountCode"]= "200";
    		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                $k++; 
            }
            
            
		               
		    $where 			= array('client_id' => $project_title["client_id"]);
		    $client_info = $this->mod_common->select_single_records('project_clients', $where);
			
			
				$InvoiceNumber = "INV-".$invoice_number;
			
                       $new_invoice = array("Invoices" => array(
                                			array(
                                				"Type"=>"ACCREC",
                                				"Contact" => array(
                                					"Name" => $client_info["client_fname1"].' '.$client_info["client_surname1"].' '.$client_info["client_fname2"].' '.$client_info["client_surname2"]
                                				),
                                				"Date" => $invoice_date,
                                				"DueDate" => $invoice_due_date,
                                				"InvoiceNumber" => $InvoiceNumber,
                                				"Status" => "AUTHORISED",
                                				"LineAmountTypes" => "Inclusive",
                                				"LineItems"=> $line_items
                                			)
                                		)
                                	   );
                      
                     
                       $new_contact = array(
                			array(
                				"Name" => $client_info["client_fname1"]." ".$client_info["client_surname1"]." ".$client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"FirstName" => $client_info["client_fname1"]." ".$client_info["client_surname1"],
                				"LastName" => $client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"Addresses" => array(
                					"Address" => array(
                						array(
                							"AddressType" => "POBOX",
                							"AddressLine1" => $client_info["post_street_pobox"],
                							"City" => $client_info["client_postal_city"],
                							"PostalCode" => $client_info["client_postal_zip"]
                						),
                						array(
                							"AddressType" => "STREET",
                							"AddressLine1" => $client_info["street_pobox"],
                							"City" => $client_info["client_city"],
                							"PostalCode" => $client_info["client_zip"]
                						)
                					)
                				)
                			)
                		);
                		 $xero_credentials = get_xero_credentials();
                		 if(count($xero_credentials)>0){
                		// create the contact
                		$contact_result = $this->xero->Contacts($new_contact);
                		
                		// create the invoice
                    	$invoice_result = $this->xero->Invoices($new_invoice);
                    	
                    	$xero_invoice_id = $invoice_result['Invoices']['Invoice']['InvoiceID'];
                    	
                    	$partispp=array('xero_invoice_id' => $xero_invoice_id);
                        $wherepp = array('id' => $invoice_id);
                        $this->mod_common->update_table('project_sales_invoices', $wherepp, $partispp);
                        
                		 }
        }

        

        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('err_message', 'Some thing went wrong, Invoice could not be updated');

        }else{

            $this->session->set_flashdata('ok_message',  'Invoice status updated succesfully');
        }
        redirect(SURL.'sales_invoices/viewsalesinvoice/'. $invoice_id);

    }

    //Update Sales Invoice Company Information
    public function updatecomsinvoice($invoice_id){
        
        $cwhere = array('id' => $invoice_id);
        $invoiceDetails = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        
        $exstinginvoiceamount=$invoiceDetails["invoice_amount"];
        $exstingduedate=date('d/m/Y',strtotime($invoiceDetails["due_date"]));
        $exstingcreateddate=date('d/m/Y',strtotime($invoiceDetails["date_created"]));
        $exstingnote=$invoiceDetails["notes"];
        $exstinginvoicestatus = $invoiceDetails["status"];
        $account_number = $invoiceDetails["account_number"];
        $company_name = $invoiceDetails["company_name"];
        $company_postal_address = $invoiceDetails["company_postal_address"];
        $company_street_address = $invoiceDetails["company_street_address"];
        $company_phone_number = $invoiceDetails["company_phone_number"];
        $company_email = $invoiceDetails["company_email"];
        $company_website = $invoiceDetails["company_website"];
        $company_gst_number = $invoiceDetails["company_gst_number"];

        $cwhere = array('sale_invoice_id' => $invoice_id);
        $exstingsi_items = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere); $esi_itemsarr= array();

        foreach ($exstingsi_items as $key => $exstingsi_item) {
            array_push($esi_itemsarr, $exstingsi_item["id"]);
        }

        $deletearrs=array_diff($esi_itemsarr, $_POST['item_number']);


        foreach ($deletearrs as $key => $deleteitem) {
            $where = array('id' => $deleteitem);
            $this->mod_common->delete_record('project_sales_invoices_items', $where);
        }

        if($exstinginvoiceamount!=$_POST['invoice_total_amount']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('invoice_amount'=> (float) str_replace(',', '', $this->input->post('invoice_total_amount') )));
        }

        if($exstinginvoicestatus!=$_POST['status']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('status'=> $_POST['status']));

            if($_POST['status']=='APPROVED' &&  $exstinginvoicestatus=='PENDING' ){

                $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('approved_by'=> $this->session->userdata('user_id')));
            }
        }
        
        if($exstingduedate!=$_POST['due_date']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('due_date'=> date('Y-m-d H:i:s', DateTime::createFromFormat('d/m/Y', $this->input->post('due_date'))->getTimestamp())));
        }
        if($exstingcreateddate!=$_POST['created_date']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('date_created'=>  date('Y-m-d H:i:s', DateTime::createFromFormat('d/m/Y', $this->input->post('created_date'))->getTimestamp())));
        }
        if($exstinginvoicestatus!=$_POST['notes']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('notes'=> $_POST['notes']));
        }

        if($account_number!=$_POST['account_number']){

            $part = $this->mod_common->update_table('project_sales_invoices' ,array('id'=> $invoice_id), array('account_number'=> $_POST['account_number']));
        }

        if($company_name!=$_POST['company_name']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_name'=> $_POST['company_name']));
        }

        if($company_postal_address!=$_POST['company_postal_address']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_postal_address'=> $_POST['company_postal_address']));
        }

        if($company_street_address!=$_POST['company_street_address']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_street_address'=> $_POST['company_street_address']));
        }

        if($company_phone_number!=$_POST['company_phone_number']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_phone_number'=> $_POST['company_phone_number']));
        }

        if($company_email!=$_POST['company_email']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_email'=> $_POST['company_email']));
        }

        if($company_website!=$_POST['company_website']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_website'=> $_POST['company_website']));
        }

        if($company_gst_number!=$_POST['company_gst_number']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $invoice_id), array('company_gst_number'=> $_POST['company_gst_number']));
        }
        
        // Xero Implementation
        
        
        $xero_credentials = get_xero_credentials();
        
        
        if($_POST['status']=='APPROVED' &&  $exstinginvoicestatus=='PENDING' ){
            
            $cwhere = array('id' => $invoice_id);
            $invoice_detail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
            
            $invoice_number = $invoice_detail["id"] + 2000000;
            
            $invoice_date = date("Y-m-d", strtotime($invoice_detail["date_created"]));

            if($invoice_detail["due_date"]!=""){ 
                $invoice_due_date = date("Y-m-d", strtotime($invoice_detail["due_date"])); 
                
            } else{ 
                $invoice_due_date = date('Y-m-d');  
                
            }
            
            
            $cwhere = array('project_id' => $invoice_detail["project_id"]);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            
            $where 	= array('project_id' => $invoice_detail["project_id"]);
		    $project_tax = $this->mod_common->select_single_records('project_costing', $where);
            
            $tracking_name = $xero_credentials["tracking_category_name"];
               
            $quantity = 1;
            $k=0;
            $line_items = array();
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'apd');
            $data['apdsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*",  0, 0, $cwhere);
            
            if(count($data['apdsiis'])>0){
                foreach ($data['apdsiis']  as $key => $apdsii) {
                    
                    $p_amount = $apdsii["part_invoice_amount"];
                     
                    $part_amount = $p_amount+($p_amount*($project_tax["tax_percent"]/100));
                
                    $line_items[$k]["Description"]= 'Allowance Part difference for (Part name: ' . $apdsii["part_name"] . ' ) against  (Component: ' . $apdsii["description"] . ')';
        		    $line_items[$k]["Quantity"]= $quantity;
        		    $line_items[$k]["UnitAmount"]= $part_amount;
        		    $line_items[$k]["LineAmount"]= $part_amount;
        		    $line_items[$k]["TaxType"]= "OUTPUT2";
        		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
        		    $line_items[$k]["AccountCode"]= "200";
        		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                    $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                    $k++; 
                }
            }
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'var');
            $data['varsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);

            foreach ($data['varsiis']  as $key => $varsii) {
                $part_amount = $varsii["part_invoice_amount"];
            
                $line_items[$k]["Description"]= ' Variation # '.($varsii["type_id"]+1000000) .': '.$varsii["description"];
    		    $line_items[$k]["Quantity"]= $quantity;
    		    $line_items[$k]["UnitAmount"]= $part_amount;
    		    $line_items[$k]["LineAmount"]= $part_amount;
    		    $line_items[$k]["TaxType"]= "OUTPUT2";
    		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
    		    $line_items[$k]["AccountCode"]= "200";
    		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                $k++; 
            }
            
            $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'pay');
            $data['paysiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
            
            foreach ($data['paysiis']  as $key => $paysii) {
                
                $part_amount = $paysii["part_invoice_amount"];
                
                
                $line_items[$k]["Description"]= 'Payment # '.$paysii["type_id"] .': '.$paysii["description"];
    		    $line_items[$k]["Quantity"]= $quantity;
    		    $line_items[$k]["UnitAmount"]= $part_amount;
    		    $line_items[$k]["LineAmount"]= $part_amount;
    		    $line_items[$k]["TaxType"]= "OUTPUT2";
    		    $line_items[$k]["TaxAmount"]= ($part_amount*3)/23;
    		    $line_items[$k]["AccountCode"]= "200";
    		    $line_items[$k]["Tracking"][0]["Name"]= $tracking_name;
                $line_items[$k]["Tracking"][0]["Option"]= $project_title["project_title"];
                $k++; 
            }
            
            
		               
		    $where 			= array('client_id' => $project_title["client_id"]);
		    $client_info = $this->mod_common->select_single_records('project_clients', $where);
			
			
				$InvoiceNumber = "INV-".$invoice_number;
			
                       $new_invoice = array("Invoices" => array(
                                			array(
                                				"Type"=>"ACCREC",
                                				"Contact" => array(
                                					"Name" => $client_info["client_fname1"].' '.$client_info["client_surname1"].' '.$client_info["client_fname2"].' '.$client_info["client_surname2"]
                                				),
                                				"Date" => $invoice_date,
                                				"DueDate" => $invoice_due_date,
                                				"InvoiceNumber" => $InvoiceNumber,
                                				"Status" => "AUTHORISED",
                                				"LineAmountTypes" => "Inclusive",
                                				"LineItems"=> $line_items
                                			)
                                		)
                                	   );
                      
                     
                       $new_contact = array(
                			array(
                				"Name" => $client_info["client_fname1"]." ".$client_info["client_surname1"]." ".$client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"FirstName" => $client_info["client_fname1"]." ".$client_info["client_surname1"],
                				"LastName" => $client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"Addresses" => array(
                					"Address" => array(
                						array(
                							"AddressType" => "POBOX",
                							"AddressLine1" => $client_info["post_street_pobox"],
                							"City" => $client_info["client_postal_city"],
                							"PostalCode" => $client_info["client_postal_zip"]
                						),
                						array(
                							"AddressType" => "STREET",
                							"AddressLine1" => $client_info["street_pobox"],
                							"City" => $client_info["client_city"],
                							"PostalCode" => $client_info["client_zip"]
                						)
                					)
                				)
                			)
                		);
                		 $xero_credentials = get_xero_credentials();
                		 if(count($xero_credentials)>0){
                		// create the contact
                		$contact_result = $this->xero->Contacts($new_contact);
                		
                		// create the invoice
                    	$invoice_result = $this->xero->Invoices($new_invoice);
                    	
                    	$xero_invoice_id = $invoice_result['Invoices']['Invoice']['InvoiceID'];
                    	
                    	$partispp=array('xero_invoice_id' => $xero_invoice_id);
                        $wherepp = array('id' => $invoice_id);
                        $this->mod_common->update_table('project_sales_invoices', $wherepp, $partispp);
                        
                		 }
        }
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('err_message', 'Some thing went wrong, Invoice could not be updated');

        }else{

            $this->session->set_flashdata('ok_message',  'Invoice updated succesfully');
        }


        redirect(SURL.'sales_invoices/viewsalesinvoice/'. $invoice_id);

    }

    //View Sales Invoice
    public function viewsalesinvoice($invoice_id) {

        $data['receipt_ids'] =$this->mod_saleinvoice->get_receipt_ids_by_saleinvoice_id($invoice_id,'PENDING');
        
        $cwhere = array('id' => $invoice_id);
        $data['invoice_detail'] = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        if(count($data['receipt_ids'])){
        $cwhere = array('sales_receipt_id' => $data['receipt_ids'][0]['id']);
        $data['payment_history'] = $this->mod_common->get_all_records('project_payment_history', "*", 0, 0, $cwhere); 
        }
        else{
            $data['payment_history'] = array();
        }
        $cwhere= array('user_id'=>  $data['invoice_detail']["approved_by"] );
        $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

        $data['invoice_detail']["auser_fname"] = (count($usersname))? $usersname["user_fname"]: '';
        $data['invoice_detail']["auser_lname"] =(count($usersname))? $usersname["user_lname"]: '';
        $data['invoice_detail']["approved"] = count($usersname);

        $cwhere= array('user_id'=>  $data['invoice_detail']["exported_by"] );
        $usersname = $this->mod_common->select_single_records('project_users', $cwhere);

        $data['invoice_detail']["euser_fname"] = (count($usersname))? $usersname["user_fname"]: '';
        $data['invoice_detail']["euser_lname"] =(count($usersname))? $usersname["user_lname"]: '';
        $data['invoice_detail']["exported"] = count($usersname);

        $fields=array('project_title','bank_acount');
        $cwhere = array('project_id' => $data['invoice_detail']["project_id"] );
        $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
        $data['project_title']=$project_title["project_title"];
        $data['bank_acount']=$project_title["bank_acount"];



        $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'apd');
        $data['apdsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
        foreach ($data['apdsiis']  as $key => $apdsii) {
            $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($apdsii["id"]);
            

            $data['apdsiis'][$key]["outstanding"] = $result_arr[0]['outstanding'] ;
            $data['apdsiis'][$key]["payment"] = $result_arr[0]['payment'] ;
            
            $data['sale_invoice_item_id']=$apdsii["id"];
            $data['invoice_amount']= $apdsii["part_invoice_amount"];
            $data['payment']= $data['apdsiis'][$key]["payment"];
            
            if(count($data['receipt_ids'])==0){
            $data['work'] = "C";
            }
            else{
            $data['work'] = "U";
            }
        }

        $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'var');
        $data['varsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
        foreach ($data['varsiis']  as $key => $varsii) {
            $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($varsii["id"]);

            $data['varsiis'][$key]["outstanding"] = $result_arr[0]['outstanding'] ;
            $data['varsiis'][$key]["payment"] =$result_arr[0]['payment'] ;
            $data['sale_invoice_item_id']=$varsii["id"];
            $data['invoice_amount']= $varsii["part_invoice_amount"];
            $data['payment']= $data['varsiis'][$key]["payment"];
            if(count($data['receipt_ids'])==0){
            $data['work'] = "C";
            }
            else{
            $data['work'] = "U";
            }
        }
        
        $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'pay');
        $data['paysiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
        //print_r( $data['paysiis']);exit;
        foreach ($data['paysiis']  as $key => $paysii) {
            $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($paysii["id"]);

            $data['paysiis'][$key]["outstanding"]=$result_arr[0]['outstanding'] ;
            $data['paysiis'][$key]["payment"]=$result_arr[0]['payment'];
            
            $data['sale_invoice_item_id']=$paysii["id"];
            $data['invoice_amount']= $paysii["part_invoice_amount"];
            $data['payment']= $data['paysiis'][$key]["payment"];
            
            if(count($data['receipt_ids'])==0){
            $data['work'] = "C";
            }
            else{
            $data['work'] = "U";
            }
        }

        $fields='`client_id`';
        $cwhere = array('project_id' => $data['invoice_detail']["project_id"]);
        $client_id = $this->mod_common->select_single_records('project_projects', $cwhere);
        $client_id= $client_id["client_id"];


        $fields='`client_fname1`, `client_fname2`, `client_surname1`, `client_surname2`, `post_street_pobox`,`client_postal_city` , `client_postal_zip`, `pstate`, `pcountry` ';
        $cwhere = array('client_id' => $client_id);
        $data['printit']['clientinfo'] = $this->mod_common->select_single_records('project_clients', $cwhere);

        $data['pc_detail'] = $this->mod_project->get_project_costing_info($data['invoice_detail']["project_id"]);
        $data['project_tax']=$data['pc_detail']->tax_percent;

        $data['company_info'] = get_company_info();
        
        
        $this->stencil->title('View Sales Invoice');
	    $this->stencil->paint('sales_invoices/view_sales_invoice', $data);
    }

    public function receiptsibysid($invoice_id) {


        $data['msg'] = ($this->session->flashdata('ok_message'))?  $this->session->flashdata('ok_message')  : '';
        $data['error'] = ($this->session->flashdata('err_message'))?  $this->session->flashdata('err_message') : '';


        $cwhere = array('id' => $invoice_id);
        $data['invoice_detail'] = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);

        $fields=array('project_title');
        $cwhere = array('project_id' => $data['invoice_detail']["project_id"] );
        $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
        $data['project_title']=$project_title["project_title"];

        $data['receipt_ids'] =$this->mod_saleinvoice->get_receipt_ids_by_saleinvoice_id($invoice_id,'ALL');

        $this->stencil->title('View Sales Invoice Receipt');
	    $this->stencil->paint('sales_invoices/view_sales_invoice_receipt', $data);
    }
    
    public function exportinvoiceswizard2(){

        $cwhere = array('id' => $this->input->post('invoice_id'));
        $invoicedetail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);

        $cwhere = array('sale_invoice_id' => $this->input->post('invoice_id'));
        $sales_invoiceitems= $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);

        if(isset($_POST['addtoexisting']) &&  $_POST['addtoexisting']==1 ){
            $file_id = $this->input->post('file_id');
        }

        if(isset($_POST['creatnewcsv']) &&  $_POST['creatnewcsv']==1 ){

            $csvfile = array(
                'type' => 'sale',
                'status' => 'PENDING',

            );

            $file_id = $this->mod_common->insert_into_table('project_exported_files', $csvfile);

        }


    foreach($sales_invoiceitems as $key => $sales_invoiceitem){
            $csvfile_item = array(
                'file_id' => $file_id,
                'InvoiceNumber' =>  $this->input->post('invoice_id'),
                'InventoryItemCode' => $sales_invoiceitem["id"],
                'DueDate' => ($invoicedetail["due_date"]!="")?date('Y-m-d',strtotime($invoicedetail["due_date"])):"",
                'referenceno' => $invoicedetail["id"],

                'UnitAmount' => $sales_invoiceitem["part_invoice_amount"],
                'InvoiceDate' => date('Y-m-d',strtotime($invoicedetail["date_created"]))
            );

            if($sales_invoiceitem["type"]=='apd')
                $csvfile_item['Description'] = 'Allowance Part difference for (Part name: ' . $sales_invoiceitem["part_name"] . ' ) against  (Component: ' . $sales_invoiceitem["description"] . ')';
            if($sales_invoiceitem["type"]=='var')
                $csvfile_item['Description'] =' Variation # '.($sales_invoiceitem["type_id"]+1000000) .': '.$sales_invoiceitem["description"];
            if($sales_invoiceitem["type"]=='pay')
                $csvfile_item['Description'] ='Payment # '.$sales_invoiceitem["type_id"] .': '.$sales_invoiceitem["description"];


            $file_item_id = $this->mod_common->insert_into_table('project_exported_files_items', $csvfile_item);
            $this->mod_common->update_table('project_sales_invoices', array('exported_by'=> $this->session->userdata('company_id')),array('id' => $this->input->post('invoice_id')  ) );
        }

        if($this->db->trans_status() === FALSE)
            $this->session->set_flashdata('err_message', 'CSV file could not be updated');
        else {
            $this->session->set_flashdata('ok_message', 'Items added in CSV file succesfully');
        }
        redirect(SURL.'sales_invoices/manage_csv_files');
    }

    public function manage_csv_files(){

        $data['csv_files'] = $this->mod_saleinvoice->get_all_csv_files();
        
        $this->stencil->title('Manage CSV Files');
	    $this->stencil->paint('sales_invoices/manage_csvs', $data);
    }

    public function exportascsv($file_id=0){

        if($file_id>0){
                $file_items = $this->mod_saleinvoice->get_allfile_items_by_file_id($file_id);
        
        
                $inv_arr[0]['customer_name'] = "*ContactName";
                $inv_arr[0]['EmailAddress'] = "EmailAddress";
                $inv_arr[0]['POAddressLine1'] = "POAddressLine1";
                $inv_arr[0]['POAddressLine2'] = "POAddressLine2";
                $inv_arr[0]['POAddressLine3'] = "POAddressLine3";
                $inv_arr[0]['POAddressLine4'] = "POAddressLine4";
                $inv_arr[0]['POCity'] = "POCity";
                $inv_arr[0]['PORegion'] = "PORegion";
                $inv_arr[0]['POPostalCode'] = "POPostalCode";
                $inv_arr[0]['POCountry'] = "POCountry";
                $inv_arr[0]['InvoiceNumber'] = "InvoiceNumber";
                $inv_arr[0]['Reference'] = "Reference";
                $inv_arr[0]['InvoiceDate'] = "InvoiceDate";
                $inv_arr[0]['DueDate'] = "DueDate";
                $inv_arr[0]['Total'] = "Total";
                $inv_arr[0]['InventoryItemCode'] = "InventoryItemCode";
                $inv_arr[0]['Description'] = "Description";
                $inv_arr[0]['Quantity'] = "Quantity";
                $inv_arr[0]['UnitAmount'] = "UnitAmount";
                $inv_arr[0]['Discount'] = "Discount";
                $inv_arr[0]['AccountCode'] = "AccountCode";
                $inv_arr[0]['TaxType'] = "TaxType";
                $inv_arr[0]['TaxAmount'] = "TaxAmount";
                $inv_arr[0]['TrackingName1'] = "Supplier_invoice_item_id";
                $inv_arr[0]['TrackingOption1'] = "TrackingOption1";
                $inv_arr[0]['TrackingName2'] = "TrackingName2";
                $inv_arr[0]['TrackingOption2'] = "TrackingOption2";
                $inv_arr[0]['Currency'] = "Currency";
        
        
        
                $i = 1;
        
                foreach ($file_items AS $k => $p) {
        
                    $inv_arr[$i]['customer_name'] =  $p['client_fname1'].' '.$p['client_fname2'].' '.$p['client_surname1'].' '.$p['client_surname2'];
                    $inv_arr[$i]['EmailAddress'] =   $p['client_email_primary'];
                    $inv_arr[$i]['POAddressLine1'] = $p['street_pobox'];
                    $inv_arr[$i]['POAddressLine2'] = $p['street_pobox'];
                    $inv_arr[$i]['POAddressLine3'] = $p['street_pobox'];
                    $inv_arr[$i]['POAddressLine4'] = $p['street_pobox'];
                    $inv_arr[$i]['POCity'] = $p['client_postal_city'];
                    $inv_arr[$i]['PORegion'] = "";
                    $inv_arr[$i]['POPostalCode'] = $p['client_postal_zip'];
                    $inv_arr[$i]['POCountry'] = $p['pcountry'];
                    $inv_arr[$i]['InvoiceNumber'] = $p['InvoiceNumber'];
                    $inv_arr[$i]['Reference'] = $p['InvoiceNumber'];
                    $inv_arr[$i]['InvoiceDate'] = date('m/d/Y', strtotime($p['InvoiceDate']));
                    $inv_arr[$i]['DueDate'] = date('m/d/Y', strtotime($p['DueDate']));
                    $inv_arr[$i]['Total'] = '';
                    $inv_arr[$i]['InventoryItemCode'] = 'Sale'.$p['InventoryItemCode'];;
                    $inv_arr[$i]['Description'] = $p['Description'];
                    $inv_arr[$i]['Quantity'] = 1;
                    $inv_arr[$i]['UnitAmount'] = $p['UnitAmount']/ 1;
                    $inv_arr[$i]['Discount'] = 0;
                    $inv_arr[$i]['AccountCode'] = "";
                    $inv_arr[$i]['TaxType'] = "";
                    $inv_arr[$i]['TaxAmount'] = 0;
                    $inv_arr[$i]['TrackingName1'] = "file_number";
                    $inv_arr[$i]['TrackingOption1'] = $p['file_id'];
                    $inv_arr[$i]['TrackingName2'] = "file_item_number";
                    $inv_arr[$i]['TrackingOption2'] = $p['id'];
                    $inv_arr[$i]['Currency'] = "USD";
                    $inv_arr[$i]['BrandingTheme'] = "";
        
                    $i++;
                }
        
        
                $this->mod_common->update_table('project_exported_files', array('id'=> $file_id), array('status'=>'EXPORTED') );
                $output = fopen("php://output", 'w') or die("Can't open php://output");
                header("Content-Type:application/csv");
                header("Content-Disposition:attachment;filename=saleinvoices".$file_id."-".date("Y/m/d H:i:s",time()).".csv");
        
                foreach ($inv_arr as $product) {
                    fputcsv($output, $product);
                }
                fclose($output) or die("Can't close php://output");
        
                exit;
        }
        else{
             $this->session->set_flashdata('err_message', 'No Record Found!');
            redirect(SURL."sales_invoices/manage_csv_files");
        }

    }

    public function viewcsv($file_id){
        $data['file_items'] = $this->mod_saleinvoice->get_allfile_items_by_file_id($file_id);

        $data['file_detail'] = $this->mod_common->select_single_records('project_exported_files', array('id'=> $file_id ));
        
        $this->stencil->title('View CSV File');
	    $this->stencil->paint('sales_invoices/view_csv', $data);
        
    }
    
    //Add Sales Invoice
    
    public function addsalesinvoice() {

        $projectID = $this->input->post('project_id');
        
        $dataa['pc_detail'] = $this->mod_project->get_project_costing_info($projectID);
        $tax =$dataa['pc_detail']->tax_percent;
        
        $where= array(
             "user_id" => $this->session->userdata("company_id")
            );
        $company_info = $this->mod_common->select_single_records('project_users', $where);

            $Saleinvoice = array(
                'project_id' => $projectID,
                'invoice_amount' => $this->input->post('invoice_amount'),
                'created_by' => $this->session->userdata('user_id'),
                'company_id' => $this->session->userdata('company_id'),
                'company_name' => $company_info["com_name"],
                'company_logo' => $company_info["com_logo"],
                'company_website' => $company_info["com_website"],
                'company_phone_number' => $company_info["com_phone_no"],
                'company_street_address' =>$company_info["com_street_address"],
                'company_postal_address' => $company_info["com_postal_address"],
                'company_gst_number' => $company_info["com_gst_number"],
                'company_email' => $company_info["com_email"],
                'notes' => ''
            );

        $sale_invoice_id = $this->mod_common->insert_into_table('project_sales_invoices', $Saleinvoice);
        $invoice_number = $sale_invoice_id + 2000000;
        $this->mod_common->update_table('project_sales_invoices', array("id" => $sale_invoice_id), array("invoice_number" => $invoice_number));

        $Saleinvoice_item = array(
            'sale_invoice_id' => $sale_invoice_id,
            'type_id' => $this->input->post('type_id'),
            'description' => $this->input->post('description'),

            'part_invoice_amount' =>(float) str_replace(',', '',  $this->input->post('invoice_amount')),
            'type' => $this->input->post('type')
        );
        if($this->input->post('type')=='apd')
            $Saleinvoice_item['part_name']=$this->input->post('part_name');
        $sale_invoiceitem_id = $this->mod_common->insert_into_table('sales_invoices_items', $Saleinvoice_item);




        if($sale_invoiceitem_id){
            $this->session->set_flashdata('ok_message', 'Sale Invoice item added succesfully');
            if($this->input->post('invoice_amount')<0){
                
            if($this->input->post('type')=="apd"){
            // Automatically Variation Script Starts
            
             $costing_id=$this->mod_project->get_costing_id_from_project_id($projectID);
             $invoice_amount = (float) str_replace(',', '',  $this->input->post('invoice_amount'));
       $var_number_q = $this->db->query("SELECT MAX(id) as var_number FROM project_variations");
       $var_number = $var_number_q->row_array();
        $vdata = array(
            'created_by' => $this->session->userdata('user_id'),
            'variation_name' => "Allowance invoice number ".($sale_invoice_id+2000000),
            'variation_description' => $this->input->post('descriptiondes'),
            'project_id' => $this->input->post('project_id'),
            'var_number' => $var_number['var_number']+1+10000000,
            'costing_id' => $costing_id['costing_id'],
            'project_subtotal1' => $invoice_amount,
            'overhead_margin' => 0.00,
            'profit_margin' => 0.00,
            'project_subtotal2' => $invoice_amount,
            'tax' => 15,
            'project_subtotal3' => ((15/100)*$invoice_amount)+$invoice_amount,
            'project_price_rounding' => 0.00,
            'project_contract_price' => ((15/100)*$invoice_amount)+$invoice_amount,
            'status' => "APPROVED",
            'hide_from_sales_summary' => 0,
            'is_variation_locked' => 0,
            'company_id' => $this->session->userdata('company_id'),
            'var_type' => 'salecredit'
        );

        $tablename = 'project_variations';
        $insert_variations = $this->mod_common->insert_into_table($tablename, $vdata);
        $vId = $this->db->insert_id();
        $costing_partid = $this->input->post("type_id");
        $partDetail = $this->mod_project->get_part_detail_by_cost_part_id($costing_partid);
        
        if($vId>0){
            
             $recent_quantity = get_recent_quantity($costing_partid);
            $supplier_ordered_quantity = get_supplier_ordered_quantity($partDetail->costing_part_id, "pc");
            $invoicedquantity = $supplier_ordered_quantity;
            $purchase_ordered_quantity = get_purchase_ordered_items_quantity($costing_partid);
            if(count($recent_quantity)>0){
              if($partDetail->costing_type=="normal"){
               $uninvoicedquantity = (($partDetail->costing_quantity+$recent_quantity['total']) - $invoicedquantity)-$purchase_ordered_quantity;
               
              }
              else{
                  $uninvoicedquantity = ($recent_quantity['updated_quantity'] - $invoicedquantity)-$purchase_ordered_quantity;
              }
            }
            else{
               $uninvoicedquantity = ($partDetail->costing_quantity - $invoicedquantity)-$purchase_ordered_quantity;
            }
             $part = array(                    
                    'project_id' => $projectID,
                    'costing_id' => $costing_id['costing_id'],
                    'is_including_pc' => 1,
                    'variation_id' => $vId,
                    'stage_id' => $partDetail->stage_id,
                    'costing_part_id' => $costing_partid,
                    'component_id' => $partDetail->component_id,
                    'part_name' => $this->input->post("part_name"),
                    'component_uom' => $partDetail->costing_uom,
                    'allowance_check' => 1,
                    'margin' => $partDetail->margin,
                    'linetotal' => $partDetail->line_cost,
                    'quantity_type' => "manual",
                    'formulaqty' => "",
                    'formulatext' => "",
                    'margin_line' => $partDetail->line_margin,
                    'type_status' => $partDetail->type_status,
                    'is_line_locked' => 0,
                    'include_in_specification' => $partDetail->include_in_specification,
                    'component_uc' => $partDetail->costing_uc,
                    'supplier_id' => $partDetail->costing_supplier,
                    'quantity' => $partDetail->costing_quantity,
                    'status_part' => 1,
                    'available_quantity' => $uninvoicedquantity,
                    'change_quantity' => $uninvoicedquantity*(-1),
                    'updated_quantity' => 0,
                    'useradditionalcost' => 0,
                    'marginaddcost_line' => 0
                );

                $parts = $this->mod_common->insert_into_table('project_variation_parts', $part);
        }

        $partispp=array('var_number' => $insert_variations+10000000 );
        $wherepp = array('id' => $insert_variations);
        $this->mod_common->update_table('project_variations', $wherepp, $partispp);
            
        }
            // Automatically Variation Script Ends
                
            $cwhere = array('project_id' => $projectID);
            $project_info = $this->mod_common->select_single_records('project_projects', $cwhere);
            
            $where 	= array('client_id' => $project_info["client_id"]);
		           $k = 0; 
		           $p_amount = (float) str_replace(',', '',  $this->input->post('invoice_amount'))*(-1);
		           $part_amount_without_gst = ($p_amount)/(1+($tax/100));
		           $totalTaxAmount =  $part_amount_without_gst + ($part_amount_without_gst *($tax/100));
		           
		           //$part_amount = $p_amount;
                
                    $line_items[$k]["Description"]= $this->input->post('descriptiondes');
        		    $line_items[$k]["Quantity"]= 1;
        		    $line_items[$k]["UnitAmount"]= $totalTaxAmount;
        		    $line_items[$k]["LineAmount"]= $totalTaxAmount;
        		    $line_items[$k]["TaxType"]= "OUTPUT2";
        		    $line_items[$k]["TaxAmount"]= ($totalTaxAmount*3)/23;
        		    $line_items[$k]["AccountCode"]= "200";
        		    $line_items[$k]["Tracking"][0]["Name"]= "Homes";
            
            $cwhere = array('id' => $sale_invoice_id);
            $invoice_detail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
            
            $invoice_number = $invoice_detail["id"] + 2000000;
            
            $invoice_date = date("Y-m-d", strtotime($invoice_detail["date_created"]));
            
            $cwhere = array('project_id' => $projectID);
		           
		    
            
		    $client_info = $this->mod_common->select_single_records('project_clients', $where);
		            
                       $new_credit_note = array("CreditNotes" => array(
                                			array(
                                				"Type"=>"ACCRECCREDIT",
                                			"Contact" => array(
                                					"Name" => $client_info["client_fname1"].' '.$client_info["client_surname1"].' '.$client_info["client_fname2"].' '.$client_info["client_surname2"]
                                				),
                                				"Date" => $invoice_date,
                                				"Status" => "AUTHORISED",
                                				"CreditNoteNumber" => "CN-".$invoice_number, 
                                				"Reference" => "CN-".$invoice_number,
                                				"LineAmountTypes" => "Inclusive",
                                				"LineItems"=> $line_items 
                                			)
                                		  )
                                		);
                                		
                         $new_contact = array(
                			array(
                				"Name" => $client_info["client_fname1"]." ".$client_info["client_surname1"]." ".$client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"FirstName" => $client_info["client_fname1"]." ".$client_info["client_surname1"],
                				"LastName" => $client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"Addresses" => array(
                					"Address" => array(
                						array(
                							"AddressType" => "POBOX",
                							"AddressLine1" => $client_info["post_street_pobox"],
                							"City" => $client_info["client_postal_city"],
                							"PostalCode" => $client_info["client_postal_zip"]
                						),
                						array(
                							"AddressType" => "STREET",
                							"AddressLine1" => $client_info["street_pobox"],
                							"City" => $client_info["client_city"],
                							"PostalCode" => $client_info["client_zip"]
                						)
                					)
                				)
                			)
                		);
                		$xero_credentials = get_xero_credentials();
                		if(count($xero_credentials)>0){
                		// create the contact
                		$contact_result = $this->xero->Contacts($new_contact);
                    	$credit_result = $this->xero->CreditNotes($new_credit_note);
                    	$xero_creditnote_id = $credit_result['CreditNotes']['CreditNote']['CreditNoteID'];
                    	
                     $new_credit_note_arr = array(
            'project_id' => $projectID,
            'date' => $invoice_date,
            'reference' => "CN-".$invoice_number,
            'subtotal' => $part_amount_without_gst,
            'tax' => ($totalTaxAmount*3)/23,
            'tax_type' => "Inclusive",
            'total' => $totalTaxAmount,
            'totalamountentered' => $totalTaxAmount,
            'status' => 'Approved',
            'company_id' => $this->session->userdata('company_id'),
            'created_date' => date('Y-m-d G:i:s'),
            'xero_creditnote_id' => $xero_creditnote_id,
            'created_by_invoice_id' => $sale_invoice_id
        );
        $credit_note = $this->mod_common->insert_into_table('sales_credit_notes', $new_credit_note_arr);
        
        $item_array = array(
                        'credit_note_id' => $credit_note,
                        'quantity' => 1,
                        'unit_cost' => $part_amount_without_gst,
                        'amount' => $part_amount_without_gst,
                        'part' => $this->input->post("part_name"),
                        'costing_part_id' => 0
                    );

                    $credit_note_item = $this->mod_common->insert_into_table('sales_credit_note_items', $item_array);
                    //echo "<pre>"; print_r($credit_result);exit;
                		}
            }
                 
    }   
        else {
            $this->session->set_flashdata('err_message', 'Sale invoice could not be updated');
        }
        	/*echo "<pre>";
            print_r($new_credit_note);
            print_r($credit_result['CreditNotes']);exit;*/
        redirect(base_url().'sales_invoices/viewsalesinvoice/'.$sale_invoice_id);
    }
    
    //Update Sales Invoice
    public function updatesalesinvoice() {


        $fields=array('part_invoice_amount');
        $cwhere = array('id' => $_POST['invoice_item_number']);
        $existingpartamount = $this->mod_common->select_single_records('project_sales_invoices_items', $cwhere);
        $existingpartamount=$existingpartamount["part_invoice_amount"];


        $where = array('id' => $_POST['invoice_item_number']);
        $sale_invoice_id = $this->mod_common->update_table('project_sales_invoices_items', array('id' => $_POST['invoice_item_number']), array('part_invoice_amount'=> $_POST['invoice_amount']));

        $update_sale_invoice =  $this->mod_saleinvoice->updatesalesinvoice($_POST['id'],  $_POST['invoice_amount']-$existingpartamount);

        

        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('err_message', 'Sale invoice item could not be updated');

        }else{

            $this->session->set_flashdata('ok_message',  'Sale Invoice item updated succesfully');
        }

        $fields=array('project_id');
        $cwhere = array('id' => $_POST['id']);
        $project_id = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        $project_id = $project_id["project_id"];

        redirect(SURL.'sales_invoices/project_sales_summary/'. $project_id);
    }
    
    //Create New Sales Invoice
    public function creatinvoice() {

        if($_POST['type']=='apd')
        {
            $fields=array('costing_id');
            $cwhere = array('costing_part_id' => $_POST['type_id']);
            $costing_id = $this->mod_common->select_single_records('project_costing_parts', $cwhere);



            $costing_id=$costing_id["costing_id"];
            $project_id=$this->mod_project->get_project_id_from_costing_id($costing_id);
            $data['project_id']=$project_id=$project_id['project_id'];

            $data['ids'] =$this->mod_saleinvoice->get_sale_invoice_ids_by_project_id($project_id);


            $fields=array('project_title');
            $cwhere = array('project_id' => $project_id);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            $data['project_title']=$project_title["project_title"];



            $data['partname']=$_POST['partname'];
            $data['description']= $description = $_POST['description'];
            $data['type']=$_POST['type'];
            $data['invoice_amount']= $invoiceAmount = $_POST['invoice_amount'];
            $data['type_id']=$_POST['type_id'];
            $data['work']='I';
        }
        else if($_POST['type']=='var')
        {
            $fields=array('costing_id');
            $cwhere = array('id' => $_POST['type_id']);
            $costing_id = $this->mod_common->select_single_records('project_variations', $cwhere);



            $costing_id=$costing_id["costing_id"];
            $project_id=$this->mod_project->get_project_id_from_costing_id($costing_id);
            $data['project_id']=$project_id=$project_id['project_id'];

            $data['ids'] =$this->mod_saleinvoice->get_sale_invoice_ids_by_project_id($project_id);


            $fields=array('project_title');
            $cwhere = array('project_id' => $project_id);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            $data['project_title']=$project_title["project_title"];




            $data['description']= $description = $_POST['description'];
            $data['type']=$_POST['type'];
            $data['invoice_amount']= $invoiceAmount = $_POST['invoice_amount'];
            $data['type_id']=$_POST['type_id'];
            $data['work']='I';

        }

        else if($_POST['type']=='pay')
        {

            $cwhere = array('payment_id' => $_POST['type_id']);
            $payment_details = $this->mod_common->select_single_records('project_temp_payments', $cwhere);


            $data['description']= $description = $payment_details["description"];
            $data['type']=$_POST['type'];
            $data['invoice_amount']= $invoiceAmount = $payment_details["invoice_amount"];
            $data['type_id']=$_POST['type_id'];
            $data['work']='I';

            $costing_id=$payment_details["costing_id"];
            $project_id=$this->mod_project->get_project_id_from_costing_id($costing_id);
            $data['project_id']=$project_id=$project_id['project_id'];

            $data['ids'] =$this->mod_saleinvoice->get_sale_invoice_ids_by_project_id($project_id);


            $fields=array('project_title');
            $cwhere = array('project_id' => $project_id);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            $data['project_title']=$project_title["project_title"];

        }
        
        $type = $_POST['type'];
        
        $projectID = $project_id;
        
        $dataa['pc_detail'] = $this->mod_project->get_project_costing_info($projectID);
        $tax =$dataa['pc_detail']->tax_percent;
        
        $where= array(
             "user_id" => $this->session->userdata("company_id")
            );
        $company_info = $this->mod_common->select_single_records('project_users', $where);

            $Saleinvoice = array(
                'project_id' => $projectID,
                'invoice_amount' => $invoiceAmount,
                'created_by' => $this->session->userdata('user_id'),
                'company_id' => $this->session->userdata('company_id'),
                'company_name' => $company_info["com_name"],
                'company_logo' => $company_info["com_logo"],
                'company_website' => $company_info["com_website"],
                'company_phone_number' => $company_info["com_phone_no"],
                'company_street_address' =>$company_info["com_street_address"],
                'company_postal_address' => $company_info["com_postal_address"],
                'company_gst_number' => $company_info["com_gst_number"],
                'company_email' => $company_info["com_email"],
                'notes' => ''
            );

        $sale_invoice_id = $this->mod_common->insert_into_table('project_sales_invoices', $Saleinvoice);
        $invoice_number = $sale_invoice_id + 2000000;
        $this->mod_common->update_table('project_sales_invoices', array("id" => $sale_invoice_id), array("invoice_number" => $invoice_number));

        $Saleinvoice_item = array(
            'sale_invoice_id' => $sale_invoice_id,
            'type_id' => $this->input->post('type_id'),
            'description' => $description,

            'part_invoice_amount' =>(float) str_replace(',', '',   $invoiceAmount),
            'type' => $this->input->post('type')
        );
        if($this->input->post('type')=='apd')
            $Saleinvoice_item['part_name']=$this->input->post('partname');
        $sale_invoiceitem_id = $this->mod_common->insert_into_table('sales_invoices_items', $Saleinvoice_item);




        if($sale_invoiceitem_id){
            $this->session->set_flashdata('ok_message', 'Sale Invoice item added succesfully');
            if($invoiceAmount<0){
                
            if($this->input->post('type')=="apd"){
            // Automatically Variation Script Starts
            
             $costing_id=$this->mod_project->get_costing_id_from_project_id($projectID);
             $invoice_amount = (float) str_replace(',', '',   $invoiceAmount);
             $var_number_q = $this->db->query("SELECT MAX(id) as var_number FROM project_variations");
             $var_number = $var_number_q->row_array();
       
        if ($type == 'apd'){
            
            $partname = $this->input->post('partname');
            $variation_description = 'Allowance Part difference for (Part name: ' . $partname . ' ) against  (Component: ' . $description . ')';
        }
        else if ($type=='var' ||  $type=='pay' ){
           $variation_description = $description;
        }
        
        $vdata = array(
            'created_by' => $this->session->userdata('user_id'),
            'variation_name' => "Allowance invoice number ".($sale_invoice_id+2000000),
            'variation_description' => $variation_description,
            'project_id' => $projectID,
            'var_number' => $var_number['var_number']+1+10000000,
            'costing_id' => $costing_id['costing_id'],
            'project_subtotal1' => $invoice_amount,
            'overhead_margin' => 0.00,
            'profit_margin' => 0.00,
            'project_subtotal2' => $invoice_amount,
            'tax' => 15,
            'project_subtotal3' => ((15/100)*$invoice_amount)+$invoice_amount,
            'project_price_rounding' => 0.00,
            'project_contract_price' => ((15/100)*$invoice_amount)+$invoice_amount,
            'status' => "APPROVED",
            'hide_from_sales_summary' => 0,
            'is_variation_locked' => 0,
            'company_id' => $this->session->userdata('company_id'),
            'var_type' => 'salecredit'
        );

        $tablename = 'project_variations';
        $insert_variations = $this->mod_common->insert_into_table($tablename, $vdata);
        $vId = $this->db->insert_id();
        $costing_partid = $this->input->post("type_id");
        $partDetail = $this->mod_project->get_part_detail_by_cost_part_id($costing_partid);
        
        if($vId>0){
            
             $recent_quantity = get_recent_quantity($costing_partid);
            $supplier_ordered_quantity = get_supplier_ordered_quantity($partDetail->costing_part_id, "pc");
            $invoicedquantity = $supplier_ordered_quantity;
            $purchase_ordered_quantity = get_purchase_ordered_items_quantity($costing_partid);
            if(count($recent_quantity)>0){
              if($partDetail->costing_type=="normal"){
               $uninvoicedquantity = (($partDetail->costing_quantity+$recent_quantity['total']) - $invoicedquantity)-$purchase_ordered_quantity;
               
              }
              else{
                  $uninvoicedquantity = ($recent_quantity['updated_quantity'] - $invoicedquantity)-$purchase_ordered_quantity;
              }
            }
            else{
               $uninvoicedquantity = ($partDetail->costing_quantity - $invoicedquantity)-$purchase_ordered_quantity;
            }
             $part = array(                    
                    'project_id' => $projectID,
                    'costing_id' => $costing_id['costing_id'],
                    'is_including_pc' => 1,
                    'variation_id' => $vId,
                    'stage_id' => $partDetail->stage_id,
                    'costing_part_id' => $costing_partid,
                    'component_id' => $partDetail->component_id,
                    'part_name' => $this->input->post("partname"),
                    'component_uom' => $partDetail->costing_uom,
                    'allowance_check' => 1,
                    'margin' => $partDetail->margin,
                    'linetotal' => $partDetail->line_cost,
                    'quantity_type' => "manual",
                    'formulaqty' => "",
                    'formulatext' => "",
                    'margin_line' => $partDetail->line_margin,
                    'type_status' => $partDetail->type_status,
                    'is_line_locked' => 0,
                    'include_in_specification' => $partDetail->include_in_specification,
                    'component_uc' => $partDetail->costing_uc,
                    'supplier_id' => $partDetail->costing_supplier,
                    'quantity' => $partDetail->costing_quantity,
                    'status_part' => 1,
                    'available_quantity' => $uninvoicedquantity,
                    'change_quantity' => $uninvoicedquantity*(-1),
                    'updated_quantity' => 0,
                    'useradditionalcost' => 0,
                    'marginaddcost_line' => 0
                );

                $parts = $this->mod_common->insert_into_table('project_variation_parts', $part);
        }

        $partispp=array('var_number' => $insert_variations+10000000 );
        $wherepp = array('id' => $insert_variations);
        $this->mod_common->update_table('project_variations', $wherepp, $partispp);
            
        }
            // Automatically Variation Script Ends
                
            $cwhere = array('project_id' => $projectID);
            $project_info = $this->mod_common->select_single_records('project_projects', $cwhere);
            
            $where 	= array('client_id' => $project_info["client_id"]);
		           $k = 0; 
		           $p_amount = (float) str_replace(',', '',  $invoiceAmount)*(-1);
		           $part_amount_without_gst = ($p_amount)/(1+($tax/100));
		           $totalTaxAmount =  $part_amount_without_gst + ($part_amount_without_gst *($tax/100));
		           
		           //$part_amount = $p_amount;
                
                    $line_items[$k]["Description"]= $variation_description;
        		    $line_items[$k]["Quantity"]= 1;
        		    $line_items[$k]["UnitAmount"]= $totalTaxAmount;
        		    $line_items[$k]["LineAmount"]= $totalTaxAmount;
        		    $line_items[$k]["TaxType"]= "OUTPUT2";
        		    $line_items[$k]["TaxAmount"]= ($totalTaxAmount*3)/23;
        		    $line_items[$k]["AccountCode"]= "200";
        		    $line_items[$k]["Tracking"][0]["Name"]= "Homes";
            
            $cwhere = array('id' => $sale_invoice_id);
            $invoice_detail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
            
            $invoice_number = $invoice_detail["id"] + 2000000;
            
            $invoice_date = date("Y-m-d", strtotime($invoice_detail["date_created"]));
            
            $cwhere = array('project_id' => $projectID);
		           
		    
            
		    $client_info = $this->mod_common->select_single_records('project_clients', $where);
		            
                       $new_credit_note = array("CreditNotes" => array(
                                			array(
                                				"Type"=>"ACCRECCREDIT",
                                			"Contact" => array(
                                					"Name" => $client_info["client_fname1"].' '.$client_info["client_surname1"].' '.$client_info["client_fname2"].' '.$client_info["client_surname2"]
                                				),
                                				"Date" => $invoice_date,
                                				"Status" => "AUTHORISED",
                                				"CreditNoteNumber" => "CN-".$invoice_number, 
                                				"Reference" => "CN-".$invoice_number,
                                				"LineAmountTypes" => "Inclusive",
                                				"LineItems"=> $line_items 
                                			)
                                		  )
                                		);
                                		
                         $new_contact = array(
                			array(
                				"Name" => $client_info["client_fname1"]." ".$client_info["client_surname1"]." ".$client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"FirstName" => $client_info["client_fname1"]." ".$client_info["client_surname1"],
                				"LastName" => $client_info["client_fname2"]." ".$client_info["client_surname2"],
                				"Addresses" => array(
                					"Address" => array(
                						array(
                							"AddressType" => "POBOX",
                							"AddressLine1" => $client_info["post_street_pobox"],
                							"City" => $client_info["client_postal_city"],
                							"PostalCode" => $client_info["client_postal_zip"]
                						),
                						array(
                							"AddressType" => "STREET",
                							"AddressLine1" => $client_info["street_pobox"],
                							"City" => $client_info["client_city"],
                							"PostalCode" => $client_info["client_zip"]
                						)
                					)
                				)
                			)
                		);
                		$xero_credentials = get_xero_credentials();
                		if(count($xero_credentials)>0){
                		// create the contact
                		$contact_result = $this->xero->Contacts($new_contact);
                    	$credit_result = $this->xero->CreditNotes($new_credit_note);
                    	$xero_creditnote_id = $credit_result['CreditNotes']['CreditNote']['CreditNoteID'];
                    	
                     $new_credit_note_arr = array(
            'project_id' => $projectID,
            'date' => $invoice_date,
            'reference' => "CN-".$invoice_number,
            'subtotal' => $part_amount_without_gst,
            'tax' => ($totalTaxAmount*3)/23,
            'tax_type' => "Inclusive",
            'total' => $totalTaxAmount,
            'totalamountentered' => $totalTaxAmount,
            'status' => 'Approved',
            'company_id' => $this->session->userdata('company_id'),
            'created_date' => date('Y-m-d G:i:s'),
            'xero_creditnote_id' => $xero_creditnote_id,
            'created_by_invoice_id' => $sale_invoice_id
        );
        $credit_note = $this->mod_common->insert_into_table('sales_credit_notes', $new_credit_note_arr);
        
        $item_array = array(
                        'credit_note_id' => $credit_note,
                        'quantity' => 1,
                        'unit_cost' => $part_amount_without_gst,
                        'amount' => $part_amount_without_gst,
                        'part' => $this->input->post("partname"),
                        'costing_part_id' => 0
                    );

                    $credit_note_item = $this->mod_common->insert_into_table('sales_credit_note_items', $item_array);
                    //echo "<pre>"; print_r($credit_result);exit;
                		}
            }
                 
    }   
        else {
            $this->session->set_flashdata('err_message', 'Sale invoice could not be updated');
        }
        
        redirect(base_url().'sales_invoices/viewsalesinvoice/'.$sale_invoice_id);
    }

    //Update Sales Invoice
    public function updateinvoice() {

        if($_POST['type']=='apd')
        {
            $fields=array('costing_id');
            $cwhere = array('costing_part_id' => $_POST['type_id']);
            $costing_id = $this->mod_common->select_single_records('project_costing_parts', $cwhere);



            $costing_id=$costing_id["costing_id"];
            $project_id=$this->mod_project->get_project_id_from_costing_id($costing_id);
            $data['project_id']=$project_id=$project_id['project_id'];

            $fields=array('project_title');
            $cwhere = array('project_id' => $project_id);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            $data['project_title']=$project_title["project_title"];


            $data['id']=$_POST['sale_invoice_id'];
            $data['sale_invoice_item_id']=$_POST['sale_invoice_item_id'];
            $data['ids']=array();
            $data['partname']=$_POST['partname'];
            $data['description']=$_POST['description'];
            $data['type']=$_POST['type'];
            $data['invoice_amount']=$_POST['invoice_amount'];
            $data['payment']=$_POST['payment'];
            $data['type_id']=$_POST['type_id'];
            $data['work']='U';

        }

        else if($_POST['type']=='var')
        {
            $fields=array('costing_id');
            $cwhere = array('id' => $_POST['type_id']);
            $costing_id = $this->mod_common->select_single_records('project_variations', $cwhere);



            $costing_id=$costing_id["costing_id"];
            $project_id=$this->mod_project->get_project_id_from_costing_id($costing_id);
            $data['project_id']=$project_id=$project_id['project_id'];

            $data['ids'] =array();


            $fields=array('project_title');
            $cwhere = array('project_id' => $project_id);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            $data['project_title']=$project_title["project_title"];


            $data['id']=$_POST['sale_invoice_id'];
            $data['sale_invoice_item_id']=$_POST['sale_invoice_item_id'];
            $data['description']=$_POST['description'];
            $data['type']=$_POST['type'];
            $data['invoice_amount']=$_POST['invoice_amount'];
            $data['payment']=$_POST['payment'];
            $data['type_id']=$_POST['type_id'];
            $data['work']='U';

        }

        else if($_POST['type']=='pay')
        {

            $cwhere = array('payment_id' => $_POST['type_id']);
            $payment_details = $this->mod_common->select_single_records('project_temp_payments', $cwhere);


            $data['id']=$_POST['sale_invoice_id'];
            $data['sale_invoice_item_id']=$_POST['sale_invoice_item_id'];
            $data['description']=$payment_details["description"];
            $data['type']=$_POST['type'];
            $data['invoice_amount']=$_POST['invoice_amount'];
            $data['type_id']=$_POST['type_id'];
            $data['payment']=$_POST['payment'];
            $data['work']='U';

            $costing_id=$payment_details["costing_id"];
            $project_id=$this->mod_project->get_project_id_from_costing_id($costing_id);
            $data['project_id']=$project_id=$project_id['project_id'];

            $data['ids'] =$this->mod_saleinvoice->get_sale_invoice_ids_by_project_id($project_id);


            $fields=array('project_title');
            $cwhere = array('project_id' => $project_id);
            $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
            $data['project_title']=$project_title["project_title"];

        }

        $this->stencil->title('Update Sales Invoice');
	    $this->stencil->paint('sales_invoices/update_sales_invoice', $data);
    }

    //Save Temporary Payments
    public function savetemppayments() {
        $projectID = $this->input->post('payment_project_id');

        $costing_id=$this->mod_project->get_costing_id_from_project_id($projectID);
        
        $costing_id=$costing_id['costing_id'];
        $payment_numbers=$this->input->post('payment_number');
        $description=$this
            ->input->post('description');
        $invoice_amount=$this->input->post('invoice_amount');



        $existingpostedpayment=array();
        $existingpaymentarr=array();


        $fields=array('payment_id');
        $cwhere = array('costing_id' => $costing_id);
        $existingpayment = $this->mod_common->select_single_records('project_temp_payments', $cwhere);



        foreach ($existingpayment as $key => $value) {
            array_push($existingpaymentarr, $value["payment_id"]);
        }

        foreach ($payment_numbers as $key => $payment_number) {
            if($payment_number!=0)
                array_push($existingpostedpayment, $payment_number);
        }

        $deletearrs=array_diff($existingpaymentarr, $existingpostedpayment);

        if(isset($description)){
            foreach ($description as $key => $value) {

                $Payment = array(
                    'costing_id' => $costing_id,
                    'description' => $description[$key],
                    'invoice_amount' => $invoice_amount[$key]
                );


                $Payment_id = $this->mod_common->insert_into_table('project_temp_payments', $Payment);
            }
        }

        $this->session->set_flashdata('ok_message', 'Payment added succesfully');
        redirect(base_url().'sales_invoices/project_sales_summary/'. $projectID);
    }
    
    //Delete Payment
    public function delete_payment(){
        $deleteitem = $this->input->post('id');
        $where = array('payment_id' => $deleteitem);
        $this->mod_common->delete_record('project_temp_payments', $where);
    }

    public function receiptsaleinvoiceitem(){
        $data=$_POST;
        $fields=array('project_id');
        $cwhere = array('id' => $_POST['sale_invoice_id']);
        $project_id = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        $data['project_id']=$project_id=$project_id["project_id"];

        $fields=array('project_title');
        $cwhere = array('project_id' => $project_id);
        $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
        $dataa['pc_detail'] = $this->mod_project->get_project_costing_info($project_id);
        $data['tax']=$dataa['pc_detail']->tax_percent;
        $data['project_title']=$project_title=$project_title["project_title"];

        $data['receipt_ids'] =$this->mod_saleinvoice->get_receipt_ids_by_saleinvoice_id($_POST['sale_invoice_id'],'PENDING');

        $this->stencil->title('Sales Invoice Receipt');
	    $this->stencil->paint('sales_invoices/invoice_receipt', $data);
    }

    public  function receiptinvoice(){

        if(isset($_POST['addtoexisting']) &&  $_POST['addtoexisting']==0 ){

            $receipt = array(
                'sale_invoice_id' =>$_POST['sale_invoice_id'],
                'payment' => $_POST['receipt_payment'],

            );

            $receipt_id = $this->mod_common->insert_into_table('project_sales_receipts', $receipt);


            $receiptsaleinvoiceitem = array(
                'receipt_id' => $receipt_id,
                'sale_invoice_item_id' => $_POST['sale_invoice_item_id'],
                'payment' => $_POST['receipt_payment'],

            );

            $receiptsaleinvoiceitem_id = $this->mod_common->insert_into_table('project_sales_receipts_items', $receiptsaleinvoiceitem);
            
            $receipt_history = array(
                'sales_receipt_id' =>$receipt_id,
                'amount' => $_POST['receipt_payment'],

            );

            $this->mod_common->insert_into_table('project_payment_history', $receipt_history);

        }


        else if (isset($_POST['addtoexisting']) &&  $_POST['addtoexisting']==1 ){

            $fields=array('id', 'payment');
            $cwhere = array('receipt_id' => $_POST['receipt_id'],'sale_invoice_item_id' => $_POST['sale_invoice_item_id'] );
            $receiptitems = $this->mod_common->select_single_records('project_sales_receipts_items', $cwhere);
            $receiptitem=0;

            $update_receipt =  $this->mod_saleinvoice->updatereceipt($_POST['receipt_id'],$_POST['receipt_payment']);

            if(count($receiptitems)){
                $receiptitem=$receiptitems["id"];
                $update_receiptitem=  $this->mod_saleinvoice->updatereceiptitem($receiptitem, $_POST['receipt_payment']);
                
                $receipt_history = array(
                'sales_receipt_id' =>$_POST['receipt_id'],
                'amount' => $_POST['receipt_payment'],

                );
    
                $this->mod_common->insert_into_table('project_payment_history', $receipt_history);
            }
            else{


                $receiptsaleinvoiceitem = array(
                    'receipt_id' => $_POST['receipt_id'],
                    'sale_invoice_item_id' => $_POST['sale_invoice_item_id'],
                    'payment' => $_POST['receipt_payment'],

                );

            $receiptsaleinvoiceitem_id = $this->mod_common->insert_into_table('project_sales_receipts_items', $receiptsaleinvoiceitem);
                $receipt_history = array(
                    'sales_receipt_id' =>$_POST['receipt_id'],
                    'amount' => $_POST['receipt_payment'],
    
                );
    
                $this->mod_common->insert_into_table('project_payment_history', $receipt_history);
            
            
            }



        }


        if($receiptsaleinvoiceitem_id)
            $this->session->set_flashdata('ok_message', 'Sale Receipt item added succesfully');
        else {
            $this->session->set_flashdata('err_message', 'Sale Receipt could not be updated');
        }

        $fields=array('project_id');
        $cwhere = array('id' => $_POST['sale_invoice_id']);
        $project_id = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        $project_id=$project_id["project_id"];
        $outstanding_amount = $_POST['outstanding']-$_POST['receipt_payment'];
        if($outstanding_amount==0){
            $salesinvoices_array = array(
                    'status' => 'PAID'
                );
    
            $this->mod_common->update_table('project_sales_invoices', $cwhere, $salesinvoices_array);
        }

        redirect(SURL.'sales_invoices/viewsalesinvoice/'. $_POST['sale_invoice_id']);


    }

    //View Sales Receipt
    function viewsalesreceipt($receipt_id=0){


        if($receipt_id==0){
            $receipt_id=$_POST['receipt_id'];

        }


        $fields=array('sale_invoice_id');
        $cwhere = array('id' =>  $receipt_id );
        $sale_invoice_id = $this->mod_common->select_single_records('project_sales_receipts', $cwhere);
        $sale_invoice_id = $sale_invoice_id["sale_invoice_id"];

        $fields=array('project_id');
        $cwhere = array('id' => $sale_invoice_id);
        $project_id = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
        $project_id = $project_id["project_id"];

        $fields=array('project_title');
        $cwhere = array('project_id' => $project_id);
        $project_title = $this->mod_common->select_single_records('project_projects', $cwhere);
        $dataa['pc_detail'] = $this->mod_project->get_project_costing_info($project_id);
        $data['tax']=$dataa['pc_detail']['tax_percent'];
        $data['project_title']=$project_title["project_title"];


        $cwhere = array('receipt_id' => $receipt_id);
        $data['sales_receipts_items'] = $this->mod_common->get_all_records('project_sales_receipts_items', "*", 0, 0, $cwhere);



        foreach ($data['sales_receipts_items'] as $key => $sales_receipts_item) {

            $cwhere = array('id' => $sales_receipts_item["sale_invoice_item_id"]);
            $sales_inv_items = $this->mod_common->select_single_records('project_sales_invoices_items', $cwhere);

            
                $result_arr =$this->mod_saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($sales_inv_items["id"]);

                $sales_inv_items["outstanding"] = $result_arr[0]['outstanding'] ;
                $sales_inv_items["payment"] = $result_arr[0]['payment'] ;

            $data['sales_receipts_items']["sales_invoices_item"] = $sales_inv_items;


        }

        $cwhere = array('id' => $receipt_id);
        $data['sales_receipt_detail'] = $this->mod_common->select_single_records('project_sales_receipts', $cwhere);

        $this->stencil->title('Sales Invoice Receipt');
	    $this->stencil->paint('sales_invoices/sales_invoice_receipt', $data);

    }
    
    //Manage Sales Receipts
    public function manage_receipts() {


        $data['sales_receipts'] = $this->mod_saleinvoice->get_all_sales_receipts();

        $this->stencil->title('Manage Sales Receipts');
	    $this->stencil->paint('sales_invoices/manage_receipts', $data);
    }

    public function receiptcomsinvoice($receipt_id){

        $fields='`status`,`payment`';
        $cwhere = array('id' => $receipt_id);
        $exstingreceiptstatus = $this->mod_common->select_single_records('project_sales_receipts', $cwhere);
        $exstingreceiptamount=$exstingreceiptstatus["payment"];
        $exstingreceiptstatus=$exstingreceiptstatus["status"];



        $fields='`id`';
        $cwhere = array('receipt_id' => $receipt_id);
        $exstingsir_items = $this->mod_common->get_all_records('project_sales_receipts_items', "*", 0, 0, $cwhere); 
        $esir_itemsarr= array();

        foreach ($exstingsir_items as $key => $exstingsir_item) {
            array_push($esir_itemsarr, $exstingsir_item->id);
        }

        $deletearrs=array_diff($esi_itemsarr, $_POST['receipt_item_number']);

        foreach ($deletearrs as $key => $deleteitem) {
            $where = array('id' => $deleteitem);
            $this->mod_common->delete_record('project_sales_receipts_items', $where);
        }

        if($exstinginvoiceamount!=$_POST['receipt_total_amount']){

            $part = $this->mod_common->update_table('project_sales_receipts', array('id'=> $receipt_id), array('payment'=> (float) str_replace(',', '', $this->input->post('receipt_total_amount'))));
        }

        if($exstingreceiptstatus!=$_POST['status']){

            $part = $this->mod_common->update_table('project_sales_receipts', array('id'=> $receipt_id), array('status'=> $_POST['status']));


        }


        

        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('err_message', 'Some thing went wrong, Receipt could not be updated');

        }else{

            $this->session->set_flashdata('ok_message',  'Receipt updated succesfully');
        }


        redirect(SURL.'sales_invoices/viewsalesreceipt/'. $receipt_id);


    }

    public function receiptcomsinvoicestatus($receipt_id){

        $cwhere = array('id' => $receipt_id);
        $exstingreceiptstatus = $this->mod_common->select_single_records('project_sales_receipts', $cwhere);
        $exstingreceiptamount=$exstingreceiptstatus["payment"];
        $exstingreceiptstatus=$exstingreceiptstatus["status"];

        if($exstingreceiptstatus!=$_POST['status']){

            $part = $this->mod_common->update_table('project_sales_invoices', array('id'=> $receipt_id), array('status'=> $_POST['status']));
        }


        

        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('err_message', 'Some thing went wrong, Receipt could not be updated');

        }else{

            $this->session->set_flashdata('ok_message',  'Receipt updated succesfully');
        }

        redirect(SURL.'sales_invoices/viewsalesreceipt/'. $receipt_id);

    }
    
    //Print Sales Invoice
    public function viewprintsaleinvoice(){
        $this->stencil->title('View Sales Invoice');
	    $this->stencil->paint('sales_invoices/view_sales_invoice', $data);
    }

    

    
}