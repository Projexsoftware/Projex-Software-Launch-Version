<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_credits extends CI_Controller {

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
             $this->load->model("mod_template");
             $this->load->model("mod_variation");
             $this->load->model("mod_component");
             
             $this->load->library('xero');

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(18);

    }
    
    //Get All Supplier Credits
    public function index()
	{
	    $this->mod_common->is_company_page_accessible(25);
        $data['supplier_credits'] = $this->mod_project->get_all_supplier_credits();
        
        $this->stencil->title('Supplier Credits');
	    $this->stencil->paint('supplier_credits/manage_supplier_credits', $data);
	}
	
	//Create Supplier Credit Page
	public function create_supplier_credit() {
        $this->mod_common->is_company_page_accessible(26);

        $data['projects'] = $this->mod_project->get_active_project(); 
        $data['var_number'] = $this->mod_variation->lastinsertedvariationid();

       $this->stencil->title('Create Supplier Credit');
	   $this->stencil->paint('supplier_credits/create_supplier_credits', $data);
    }
    
    //Get Completed Job Supplier Credits
    public function get_completed_job_supplier_credits() {
        $this->mod_common->is_company_page_accessible(25);
        $data['supplier_credits'] = $this->mod_project->get_all_supplier_credits(3);
        $this->load->view('supplier_credits/manage_supplier_credits_ajax', $data);
    }

    //Get Suppliers List
    public function getsupplier() {
        $prj_costing_id = $this->input->post('costing_id');
        $suppliers = $this->mod_project->get_costing_suppliers_by_costing_id($prj_costing_id);
        $html = '';
        foreach ($suppliers AS $k => $v) {
            $html.= '<option value="' . $v['costing_supplier'] . '" >' . $v['supplier_name'] . '</option>';
        }
        print_r($html);
    }
    
    //Populate Project Costing Parts
    public function populate_project_part_costing() {

        $returnhtml='';
        
        $data['selected_costing_id'] = $this->input->post('value');
        $data['selected_supplier_id'] = $this->input->post('supplier_id');
        
        $data["sinvoice_items_pc"] = $this->mod_project->get_sinvoice_items( $this->input->post('value'), $this->input->post('supplier_id'));
        
        $html = $this->load->view('supplier_credits/populate_project_costing', $data, true);
        
        $returnhtml.=$html;
        
        $populatestage = count($data["sinvoice_items_pc"]);
        $returnarr = array( 'returnhtml' => $returnhtml,
        'populatestage' => $populatestage);

        echo json_encode($returnarr);
    }
    
    //Add New Item
    public function importnew() {
        $data['last_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
        $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : 0;
        
        $html = $this->load->view('supplier_credits/importnew', $data, true);
    
        $return_arr["html1"] = $html;

        echo json_encode($return_arr);
    }

    //Create Supplier Credit
    public function insertcredit() {
        
        $this->mod_common->is_company_page_accessible(26);
        
        $this->form_validation->set_rules('project_id', 'Project', 'required');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('creditreference', 'Credit Reference', 'required');
        $this->form_validation->set_rules('creditamountist', ' Credit Amount Excluding GST', 'required');
        $this->form_validation->set_rules('creditdate', 'Credit Date', 'required');
        $this->form_validation->set_rules('suppliercreditstatus', 'Credit Status', 'required');
        $this->form_validation->set_rules('creditamountent', 'Credit Amount Entered', 'required');
        $this->form_validation->set_rules('creditamountnotent', 'Amount Not Entered', 'required');
       
        if ($this->form_validation->run() == FALSE)
    	{

            $data['projects'] = $this->mod_project->get_active_project(); 
            $data['var_number'] = $this->mod_variation->lastinsertedvariationid();
    
            $this->stencil->title('Create Supplier Credit');
    	    $this->stencil->paint('supplier_credits/create_supplier_credits', $data);
    	}
    	else{
            $xero_credentials = get_xero_credentials();
    
            $vId=0;
            $i=0;
            $j=0;     
            
            $var_number = $this->mod_variation->lastinsertedvariationid();
            $var_number = $var_number + 10000000;
            
            if(isset($_POST['worked_hours'])){
                $worked_hours = $_POST['worked_hours'];
            }
            else{
                $worked_hours = "0.00";
            }
            
            if(isset($_POST['invoice_type'])){
                $invoice_type = "timesheet";
            }
            else{
                $invoice_type = "normal";
            }
            
            $invoice_new_arr = array(
                'project_id' => $_POST['project_id'],
                'supplier_id' => $_POST['supplier_id'],
                'worked_hours' => $worked_hours,
                'invoice_date' => $this->input->post('creditdate'),
                'invoice_record_by' => $this->session->userdata('user_id'),
                'company_id' => $this->session->userdata('company_id'),
                'created_date' => date('Y-m-d G:i:s'),
                'supplierrefrence' => $_POST['creditreference'],
                'status' => $this->input->post('suppliercreditstatus'),
                'invoice_amount' => $this->input->post('creditamountist'),
                'create_variation' => (($this->input->post('createvariation'))?$this->input->post('createvariation'):0),
                'va_addsi_cost' => $this->input->post('total_cost') ,
                'va_addclient_cost' => $this->input->post('total_cost'),
                'va_description' => $this->input->post('varidescriptioin'),
                'va_ohm' => $this->input->post('overhead_margin') ,
                'va_pm' => $this->input->post('profit_margin'),
                'va_status' => $this->input->post('suppliercreditvarstatus'),
                'va_total' => $this->input->post('contract_price'),
                'va_tax' => $this->input->post('costing_tax'),
                'va_round' => $this->input->post('price_rounding'),
                'invoice_type' => $invoice_type
            );
            $invoice_new = $this->mod_common->insert_into_table('project_supplier_credits', $invoice_new_arr);
            
            if($invoice_type=="timesheet"){
            
            $data = array(
                     "project_id" => $this->input->post("project_id"),
                     "timesheet_id" => $this->input->post("timesheet_id"),
                     "supplier_credit_id" =>  $invoice_new,
                    );
                $this->mod_common->insert_into_table('project_timesheet_supplier_credits', $data);
                $timesheet_id = $this->input->post("timesheet_id");
    
                $invoice_timesheet_q = $this->db->query("SELECT distinct(project_id) as project_id FROM timesheet_items where timesheet_id ='".$timesheet_id."'");
                $invoice_timesheet_result = $invoice_timesheet_q->result_array();
                $is_invoiced = 0;
                foreach($invoice_timesheet_result as $val){
                    $timesheet_query = $this->db->query("SELECT * FROM timesheet_supplier_credits WHERE timesheet_id='".$timesheet_id."' AND project_id='".$val['project_id']."'");
                    if($timesheet_query->num_rows()>0){
                        $is_invoiced = 1;
                    }
                    else{
                        $is_invoiced=0;
                        break;
                    }
                    
                }
                if($is_invoiced==1){
                    $upd_data = array(
                        "status" =>'Invoiced'
                        );
                    $this->mod_common->update_table('project_timesheets', array("id"=>$timesheet_id), $upd_data);
                }
        }
            $ppid = $this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
    
            if($this->input->post('createvariation')== 1){
                $vdata = array(
                    'created_by' => $this->session->userdata('user_id'),
                    'company_id' => $this->session->userdata('company_id'),
                    'variation_name' => 'Variation from Supplier Credit # '.$invoice_new ,
                    'variation_description' => $this->input->post('varidescriptioin'),
                    'project_id' => $ppid['project_id'],
                    'var_number' => $var_number,
                    'project_subtotal1' => $_POST['total_cost'],
                    'hide_from_sales_summary' => isset($_POST['hide_from_summary'])?1:0,
                    'overhead_margin' => $_POST['overhead_margin'],
                    'profit_margin' => $_POST['profit_margin'],
                    'project_subtotal2' => str_replace(',', '', $_POST['total_cost2']),
                    'tax' => $_POST['costing_tax'],
                    'project_subtotal3' => str_replace(',', '', $_POST['total_cost3']),
                    'project_price_rounding' => str_replace(',', '', $_POST['price_rounding']),
                    'project_contract_price' => str_replace(',', '', $_POST['contract_price']),
                    'costing_id' => $_POST['project_id'],
                    'status' => $_POST['suppliercreditvarstatus'],
                    'var_type' => 'supcredit'
                );
                $insert_variations = $this->mod_common->insert_into_table('project_variations', $vdata);
                $vId = $insert_variations;
    
                $partispp=array('var_number' => $insert_variations+10000000 );
                $wherepp = array('id' => $insert_variations);
                $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                $this->mod_common->update_table('project_supplier_credits', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000));
    
            }
            if ($invoice_new) {
                
                $cid = $this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
                 
                $where	= array('project_id' => $cid['project_id']);
    		    $project_tax = $this->mod_common->select_single_records('project_costing', $where);
    		       
    		     $where = array('project_id' => $cid['project_id']);
    		     $project_info = $this->mod_common->select_single_records('project_projects', $where);
    		     
    		        
    		       if($this->input->post('suppliercreditstatus')=='Approved'){
    		       
                        
                        $tracking_options =  array(  "Name" => $project_info["project_title"]);
                        
                        if(count($xero_credentials)>0){
                           $tracking_name = $xero_credentials["tracking_category_name"];
                           $tracking_options_result = $this->xero->TrackingCategories($tracking_options); 
                        }
    		       }            
                 
                    
                $line_items1 =array();
                $k=0;
    
                if (isset($_POST['project_cost_partpc'])) {
    
    
                    $project_cost_partpc = $_POST['project_cost_partpc'];
                    $pcinvoiceitemid = $_POST['pcinvoiceitemid'];
                    $original_quantity = $_POST['original_quantity'];
                    $pcuninvoicequantity = $_POST['uninvoicequantity'];
                    $pcinvoicequantity = $_POST['pcinvoicequantity'];
                    $pcinvoicebudget = $_POST['pcinvoicebudget'];
                    $pcinvoicecostdiff = $_POST['pcinvoicecostdiff'];
                    $pccomponent = $_POST['pccomponent'];
                    $pcstage= $_POST['pcstage'];
                    $pcpart = $_POST['pcpart'];
                    $pcuom = $_POST['pcuom'];
                    $supplierorderquantity = $_POST['supplierorderqty'];
                    $pcorderquantity = $_POST['pcorderqty'];
                    $pcucost = $_POST['pcucost'];
                    $pclinttotal = $_POST['pclinttotal'];
                    $pcmargin = $_POST['pcmargin'];
                    $pcmargintotal = $_POST['pcmargintotal'];
                    $pcinsubtotal = $_POST['pcinsubtotal'];
                    $pcinvoicetype = $_POST['pcinvoicetype'];
                    $pcsuppliercreditquantity = $_POST['pcsuppliercreditquantity'];
                    $pcsuppliercreditamount = $_POST['pcsuppliercreditamount'];
                    
                    foreach ($project_cost_partpc as $key => $value) {
                        
                        $ordered_quantity2 = $this->mod_project->get_order_quantity_by_costingpartid($value);
                        $supplier_ordered_quantity = get_supplier_ordered_quantity($value);
                       
                        if(($supplier_ordered_quantity+$pcinvoicequantity[$key])>$ordered_quantity2[0]['total_ordered']){
                      
                        $pcunorderquantity = ($supplier_ordered_quantity+$pcinvoicequantity[$key])-$ordered_quantity2[0]['total_ordered'];
                        }
                        else{
                            $pcunorderquantity = 0;
                        }
                        $where = array('component_id' => $pccomponent[$key]);
    		            $component_info = $this->mod_common->select_single_records('project_components', $where);
                        if($pcinvoicequantity[$key]>0 && $pcsuppliercreditquantity[$key]>0){
    		            $line_items1[$k]["Description"] = $component_info["component_name"];
    		            $line_items1[$k]["Quantity"]= $pcsuppliercreditquantity[$key];
    		            $line_items1[$k]["UnitAmount"]= $pcsuppliercreditamount[$key]/$pcsuppliercreditquantity[$key];
    		            $line_items1[$k]["LineAmount"]= $pcsuppliercreditamount[$key];
    		            $line_items1[$k]["TaxType"]= "INPUT2";
    		            $line_items1[$k]["TaxAmount"]= $pcsuppliercreditamount[$key]*($project_tax["tax_percent"]/100);
    		            $line_items1[$k]["AccountCode"]= "310";
    		            $line_items1[$k]["Tracking"][0]["Name"]= $tracking_name;
                        $line_items1[$k]["Tracking"][0]["Option"]= $project_info["project_title"];
                        $k++;
                        }
                        
    
                        $allowance_cost = number_format($pcinvoicebudget[$key] - ($pcucost[$key]*$pcinvoicequantity[$key]), 2, '.', '');
                        
                        if($pcsuppliercreditquantity[$key]>0){
                            
                        if ($vId > 0) {
    
                                $v_part = array(
                                    'variation_id' => $vId,
                                    'stage_id' => $pcstage[$key],
                                    'costing_part_id' => $value,
                                    'project_id' => $cid['project_id'],
                                    'component_id' => $pccomponent[$key],
                                    'part_name' => $pcpart[$key],
                                    'component_uom' => $pcuom[$key],
                                    'linetotal' => $pcsuppliercreditamount[$key],
                                    'component_uc' => $pcucost[$key],
                                    'supplier_id' => $_POST['supplier_id'],
                                    'quantity' => $pcsuppliercreditquantity[$key],
                                    'status_part' => 1,
                                    'available_quantity' => 0,
                                    'costing_id' => $_POST['project_id'],
                                    'change_quantity' => $pcsuppliercreditquantity[$key],
                                    'updated_quantity' => $pcsuppliercreditquantity[$key],
                                    'quantity_type' => 'manual',
                                    'formulaqty' => '',
                                    'formulatext' => '',
                                    'margin' => 0,
                                    'component_variation_amount' => $pcsuppliercreditamount[$key]
                                );
    
                                $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $v_part);
    
                            }
                        
                            $part = array(
                                'costing_id' => $_POST['project_id'],
                                'stage_id' => $pcstage[$key],
                                'component_id' => $pccomponent[$key],
                                'costing_part_name' => $pcpart[$key],
                                'costing_uom' => $pcuom[$key],
                                'client_allowance' => 0,
                                'margin' => 0,
                                'line_cost' => $pcsuppliercreditamount[$key],
                                'quantity_type' => 'manual',
                                'quantity_formula' => '',
                                'formula_text' => '',
                                'line_margin' => $pcsuppliercreditamount[$key],
                                'type_status' => 1,
                                'is_locked' => 0,
                                'include_in_specification' => 0,
                                'costing_uc' => $pcucost[$key],
                                'costing_supplier' => $_POST['supplier_id'],
                                'costing_quantity' => $pcsuppliercreditquantity[$key],
                                'costing_part_status' => 1,
                                'is_variated' => $vId,
                                'isp_variated' => $vparts,
                                'costing_type' => 'supcredit' ,
                                'costing_tpe_id' => $invoice_new
                            );
    
                        }
                        
                        $invoice = array(
                            'supplier_credit_id' => $invoice_new,
                            'order_pc_id' => $value,
                            'supplier_invoice_item_id' => $pcinvoiceitemid[$key],
                            'supplier_id' => $_POST['supplier_id'],
                            'supplier_invoice_item_type' => 'pc',
                            'transaction_type' => $pcinvoicetype[$key],
                            'costing_part_id' => $value,
                            'quantity' => $pcinvoicequantity[$key],
                            'original_quantity' => $original_quantity[$key],
                            'unit_cost' => $pcucost[$key],
                            'subtotal' => $pcinvoicequantity[$key]*$pcucost[$key],
                            'component_id' => $pccomponent[$key],
                            'invoice_amount' => $pcinvoicebudget[$key],
                            'cost_diff' => ($pcinvoicecostdiff[$key]=="allowance")?$allowance_cost:$pcinvoicecostdiff[$key],
                            'stage_id' => $pcstage[$key],
                            'part_field' => $pcpart[$key],
                            'supplier_credit_quantity' => $pcsuppliercreditquantity[$key],
                            'supplier_credit_amount' => $pcsuppliercreditamount[$key]
                        );
                        
                        
                        if($pcsuppliercreditquantity[$key]>0){
                            $invoicedone = $this->mod_common->insert_into_table('project_supplier_credits_items', $invoice);
                            $partispp=array('costingpartid_var' => $value );
                            $wherepp = array('id' => $vpid);
                            $this->mod_common->update_table('project_variation_parts', $wherepp, $partispp);
        
                            $this->mod_common->update_table('project_supplier_credits', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000));
        
                            $partispp=array('costing_part_id' => $value,'order_pc_id' => $value );
                            $wherepp = array('id' => $invoiceidone);
                            $this->mod_common->update_table('project_supplier_credits_items', $wherepp, $partispp);
                        }
                    }
                    
                }
    
                if (isset($_POST['nicomponent'])) {
    
                    #-------------- insert variation-----------------#
                    if(($this->input->post('createvariation'))== 1 && ($this->input->post('suppliercreditstatus')=='Approved' OR $this->input->post('suppliercreditstatus')=='Pending') && $vId==0){
    
                        $vdata = array(
                            'created_by' => $this->session->userdata('user_id'),
                            'company_id' => $this->session->userdata('company_id'),
                            'variation_name' => 'Variation from Supplier Credit # '.$invoice_new ,
                            'variation_description' => $this->input->post('varidescriptioin'),
                            'project_id' => $cid['project_id'],
                            'var_number' => $var_number,
                            'project_subtotal1' => $_POST['total_cost'],
                            'hide_from_sales_summary' => isset($_POST['hide_from_summary'])?1:0,
                            'overhead_margin' => $_POST['overhead_margin'],
                            'profit_margin' => $_POST['profit_margin'],
                            'project_subtotal2' => str_replace(',', '', $_POST['total_cost2']),
                            'tax' => $_POST['costing_tax'],
                            'project_subtotal3' => str_replace(',', '', $_POST['total_cost3']),
                            'project_price_rounding' => str_replace(',', '', $_POST['price_rounding']),
                            'project_contract_price' => str_replace(',', '', $_POST['contract_price']),
                            'costing_id' => $_POST['project_id'],
                            'status' => $_POST['suppliercreditvarstatus'],
                            'var_type' => 'supcredit'
                        );
                        $insert_variations = $this->mod_common->insert_into_table('project_variations', $vdata);
                        $vId = $insert_variations;
    
                        $partispp=array('var_number' => $insert_variations+10000000 );
                        $wherepp = array('id' => $insert_variations);
                        $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                         $this->mod_common->update_table('project_supplier_credits', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000, 'create_variation'=>1));
                    }
    
                    $nicosting_part_id=$_POST['nicosting_part_id'];
                    $nistage = $_POST['nistage'];
                    $nipart = $_POST['nipart'];
                    $nicomponent = $_POST['nicomponent'];
                    $niuom = $_POST['niuom'];
                    $niucost = $_POST['niucost'];
                    $nimanualqty = $_POST['nimanualqty'];
                    $nilinttotal = $_POST['nilinttotal'];
                    $nisrno = $_POST['nisrno'];
                    
    
                    foreach ($nicomponent as $key => $value) {
                        
                        $where = array('component_id' => $nicomponent[$key]);
    		            $component_info = $this->mod_common->select_single_records('project_components', $where);
    					
    					if($nimanualqty[$key]>0){
    					$line_items1[$k]["Description"]= $component_info["component_name"];
    		            $line_items1[$k]["Quantity"]= $nimanualqty[$key];
    		            $line_items1[$k]["UnitAmount"]= $nilinttotal[$key]/$nimanualqty[$key];
    		            $line_items1[$k]["LineAmount"]= $nilinttotal[$key];
    		            $line_items1[$k]["TaxType"]= "INPUT2";
    		            $line_items1[$k]["TaxAmount"]= $nilinttotal[$key]*($project_tax["tax_percent"]/100);
    		            $line_items1[$k]["AccountCode"]= "310";
    		            $line_items1[$k]["Tracking"][0]["Name"]= $tracking_name;
                        $line_items1[$k]["Tracking"][0]["Option"]= $project_info["project_title"];
                         $k++;
    					}
    		            
                        $invoice = array(
                            'supplier_credit_id' => $invoice_new,
                            'supplier_id' => $_POST['supplier_id'],
                            'order_pc_id' => 0,
                            'supplier_invoice_item_id' => 0,
                            'supplier_invoice_item_type' => 'ni',
                            'transaction_type' => 'ni',
                            'original_quantity' => $nimanualqty[$key],
                            'unit_cost' => $niucost[$key],
                            'subtotal' => $nimanualqty[$key]*$niucost[$key],
                            'quantity' => $nimanualqty[$key],
                            'invoice_amount' => $nilinttotal[$key],
                            'component_id' => $nicomponent[$key],
                            'part_field' => $nipart[$key],
                            'stage_id' => $nistage[$key],
                            'costing_part_id' => 0,
                            'ni_unit_cost' =>$niucost[$key] ,
                            'ni_uom' => $niuom[$key],
                            'srno' =>  $nisrno[$key]
                        );
    
    
                        if(($this->input->post('createvariation'))== 1 &&  ($this->input->post('suppliercreditstatus')=='Approved' OR $this->input->post('suppliercreditstatus')=='Pending')){
    
                            $invoice['part_field']= $nipart[$key];
    
                            if ($vId > 0) {
    
                                $part = array(
                                    'variation_id' => $vId,
                                    'stage_id' => $nistage[$key],
                                    'costing_part_id' => $nicosting_part_id[$key],
                                    'project_id' => $cid['project_id'],
                                    'component_id' => $nicomponent[$key],
                                    'part_name' => $nipart[$key],
                                    'component_uom' => $niuom[$key],
                                    'linetotal' => $nilinttotal[$key],
                                    'component_uc' => $niucost[$key],
                                    'supplier_id' => $_POST['supplier_id'],
                                    'quantity' => $nimanualqty[$key],
                                    'status_part' => 1,
                                    'available_quantity' => 0,
                                    'costing_id' => $_POST['project_id'],
                                    'change_quantity' => $nimanualqty[$key],
                                    'updated_quantity' => $nimanualqty[$key],
                                    'quantity_type' => 'manual',
                                    'formulaqty' => '',
                                    'formulatext' => '',
                                    'margin' => 0,
                                    'component_variation_amount' => $nilinttotal[$key]
                                );
    
                                $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);
    
                            }
                            $this->mod_common->update_table('project_supplier_credits', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000));
                            
                        }
    
                        $invoiceidone = $this->mod_common->insert_into_table('project_supplier_credits_items', $invoice);
    
                        if(($this->input->post('createvariation'))== 1 && ($this->input->post('suppliercreditstatus')=='Approved' OR $this->input->post('suppliercreditstatus')=='Pending')){
    
                            $part = array(
                                'costing_id' => $_POST['project_id'],
                                'stage_id' => $nistage[$key],
                                'component_id' => $nicomponent[$key],
                                'costing_part_name' => $nipart[$key],
                                'costing_uom' => $niuom[$key],
                                'client_allowance' => 0,
                                'margin' => 0,
                                'line_cost' => $nilinttotal[$key],
                                'quantity_type' => 'manual',
                                'quantity_formula' => '',
                                'formula_text' => '',
                                'line_margin' => $nilinttotal[$key],
                                'type_status' => 1,
                                'is_locked' => 0,
                                'include_in_specification' => 0,
                                'costing_uc' => $niucost[$key],
                                'costing_supplier' => $_POST['supplier_id'],
                                'costing_quantity' => $nimanualqty[$key],
                                'costing_part_status' => 1,
                                'is_variated' => $vId,
                                'isp_variated' => $vparts,
                                'costing_type' => 'supcredit' ,
                                'costing_tpe_id' => $invoice_new
                            );
    
                            $cpid = $this->mod_common->insert_into_table('project_costing_parts', $part);
    
                            $partispp=array('costingpartid_var' => $cpid );
                            $wherepp = array('id' => $vpid);
                            $this->mod_common->update_table('project_variation_parts', $wherepp, $partispp);
    
                            $this->mod_common->update_table('project_supplier_credits', array('var_number'=> $insert_variations+10000000), array('id'=>$invoice_new ));
    
                            $partispp=array('costing_part_id' => $cpid,'order_pc_id' => $cpid );
                            $wherepp = array('id' => $invoiceidone);
                            $this->mod_common->update_table('project_supplier_credits_items', $wherepp, $partispp);
    
                        }
                    }
                }
                        
                        //Xero Implementation 
                        
                        if($this->input->post('suppliercreditstatus')=='Approved'){
                           
                        $date = explode("/", $this->input->post('creditdate'));
                        $date = $date[2]."-".$date[1]."-".$date[0];
                       
    		            $where 			= array('supplier_id' => $_POST['supplier_id']);
    		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
    		            
                           $new_credit_note = array("CreditNotes" => array(
                                    			array(
                                    				"Type"=>"ACCPAYCREDIT",
                                    				"Contact" => array(
                                    					"Name" =>$supplier_info["supplier_name"]
                                    				),
                                    				"Date" => $date,
                                    				"Status" => "AUTHORISED",
                                    				"CreditNoteNumber" => $_POST['creditreference'], 
                                    				"Reference" => $_POST['creditreference'],
                                    				"LineAmountTypes" => 'Exclusive',
                                    				"LineItems"=> $line_items1                              					
                                    				)
                                    			)
                                    		);
                          
                         
                           $new_contact = array(
                    			array(
                    				"Name" => $supplier_info["supplier_name"],
                    				"ContactNumber" => $supplier_info["supplier_phone"],
                    				"ContactPersons" => $supplier_info["supplier_contact_person"],
                    				"EmailAddress" => $supplier_info["supplier_email"],
                    				"Addresses" => array(
                    					"Address" => array(
                    						array(
                    							"AddressType" => "POBOX",
                    							"AddressLine1" => $supplier_info["post_street_pobox"],
                    							"City" => $supplier_info["supplier_postal_city"],
                    							"PostalCode" => $supplier_info["supplier_postal_zip"]
                    						),
                    						array(
                    							"AddressType" => "STREET",
                    							"AddressLine1" => $supplier_info["street_pobox"],
                    							"City" => $supplier_info["supplier_city"],
                    							"PostalCode" => $supplier_info["supplier_zip"]
                    						)
                    					)
                    				)
                    			)
                    		);
                    		
                    		// create the contact
                    		$contact_result = $this->xero->Contacts($new_contact);
                    		
                        	$credit_result = $this->xero->CreditNotes($new_credit_note);
                        	
                        	$xero_creditnote_id = $credit_result['CreditNotes']['CreditNote']['CreditNoteID'];
                        	
                        	$partispp=array('xero_creditnote_id' => $xero_creditnote_id);
                            $wherepp = array('id' => $invoice_new);
                            $this->mod_common->update_table('project_supplier_credits', $wherepp, $partispp);
                            
                        }
                $this->session->set_flashdata('ok_message', 'Supplier Credit added succesfully');
                redirect(SURL.'supplier_credits/viewcredit/'.$invoice_new);
            }
    	}
    }

    //Update Supplier Credit
    public function updatecredit($invoice_id) {
        
        $xero_credentials = get_xero_credentials();

        $vId=0;

        $existingsipartarr = array();
        
        $existingsipart = $this->mod_project->get_sicnparts_ids_by_si_id($invoice_id);

        $existingsipartarr = array();
        foreach ($existingsipart as $key => $value) {
            array_push($existingsipartarr,$value['id'] );
        }
      
        $invoice_new_arr = array(
            'project_id' => $_POST['project_id'],
            'supplier_id' => $_POST['supplier_id'],
            'invoice_date' => $this->input->post('creditdate'),
            'supplierrefrence' => $_POST['creditreference'],
            'status' => $this->input->post('suppliercreditstatus'),
            'invoice_amount' => $this->input->post('creditamountist'),
            'create_variation' => (($this->input->post('createvariation'))?$this->input->post('createvariation'):0),
            'va_addsi_cost' => $this->input->post('total_cost') ,
            'va_addclient_cost' => $this->input->post('total_cost'),
            'va_description' => $this->input->post('varidescriptioin'),
            'va_ohm' => $this->input->post('overhead_margin') ,
            'va_pm' => $this->input->post('profit_margin'),
            'va_status' => $this->input->post('suppliercreditvarstatus'),
            'va_total' => $this->input->post('contract_price'),
            'va_tax' => $this->input->post('costing_tax'),
            'va_round' => $this->input->post('price_rounding'),
        );
        $where = array('id' =>$invoice_id );
        $this->mod_common->update_table('project_supplier_credits', $where, $invoice_new_arr);
        $invoice_new = $invoice_id;
        $ppid=$this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
        
        if ($invoice_new) {
           
               $cid=$this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
               
               $where 	= array('project_id' => $cid['project_id']);
		       $project_tax = $this->mod_common->select_single_records('project_costing', $where);
		       
		       $where 			= array('project_id' => $cid['project_id']);
		       $project_info = $this->mod_common->select_single_records('project_projects', $where);
		       
		       if($this->input->post('suppliercreditstatus')=='Approved'){
		       
                    $tracking_options =  array( "Name" => $project_info["project_title"]);
                    if(count($xero_credentials)>0){
                        $tracking_name = $xero_credentials["tracking_category_name"];
                        $tracking_options_result = $this->xero->TrackingCategories($tracking_options);
                    }
                
		       }
		        $variation_name_info = 'Variation from Supplier Credit # '.$invoice_new;
                $where 			= array('var_number' => $this->input->post('var_number'), 'variation_name' => $variation_name_info);
		        $check_variation = $this->mod_common->select_single_records('project_variations', $where);
		        
                if(($this->input->post('createvariation'))== 1 && ($this->input->post('suppliercreditstatus')=='Approved' || $this->input->post('suppliercreditstatus')=='Pending')){
                    if(count($check_variation)==0){
                         $var_number = $this->mod_variation->lastinsertedvariationid();
                         $var_number = $var_number + 10000000;
                        $vdata = array(
                            'created_by' => $this->session->userdata('user_id'),
                            'company_id' => $this->session->userdata('company_id'),
                            'variation_name' => 'Variation from Supplier Credit # '.$invoice_new,
                            'variation_description' => $this->input->post('varidescriptioin'),
                            'project_id' => $cid['project_id'],
                            'var_number' => $var_number,
                            'project_subtotal1' => $_POST['total_cost'],
                            'hide_from_sales_summary' => isset($_POST['hide_from_summary'])?1:0,
                            'overhead_margin' => $_POST['overhead_margin'],
                            'profit_margin' => $_POST['profit_margin'],
                            'project_subtotal2' => str_replace(',', '', $_POST['total_cost2']),
                            'tax' => $_POST['costing_tax'],
                            'project_subtotal3' => str_replace(',', '', $_POST['total_cost3']),
                            'project_price_rounding' => str_replace(',', '', $_POST['price_rounding']),
                            'project_contract_price' => str_replace(',', '', $_POST['contract_price']),
                            'costing_id' => $_POST['project_id'],
                            'status' => $_POST['suppliercreditvarstatus'],
                            'var_type' => 'supcredit'
                        );
                        $insert_variations = $this->mod_common->insert_into_table('project_variations', $vdata);
                        $vId = $insert_variations;
    
                        $partispp=array('var_number' => $insert_variations+10000000 );
                        $wherepp = array('id' => $insert_variations);
                        $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                        
                         $this->mod_common->update_table('project_supplier_credits', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000, 'create_variation'=>1));
                    }
                    else{
                        $where 			= array('var_number' => $this->input->post('var_number'));
                        $vdata = array(
                            'variation_name' => 'Variation from Supplier Credit # '.$invoice_new,
                            'variation_description' => $this->input->post('varidescriptioin'),
                            'project_id' => $cid['project_id'],
                            'project_subtotal1' => $_POST['total_cost'],
                            'hide_from_sales_summary' => isset($_POST['hide_from_summary'])?1:0,
                            'overhead_margin' => $_POST['overhead_margin'],
                            'profit_margin' => $_POST['profit_margin'],
                            'project_subtotal2' => str_replace(',', '', $_POST['total_cost2']),
                            'tax' => $_POST['costing_tax'],
                            'project_subtotal3' => str_replace(',', '', $_POST['total_cost3']),
                            'project_price_rounding' => str_replace(',', '', $_POST['price_rounding']),
                            'project_contract_price' => str_replace(',', '', $_POST['contract_price']),
                            'costing_id' => $_POST['project_id'],
                            'status' => $_POST['suppliercreditvarstatus']
                        );
                        $this->mod_common->update_table('project_variations', $where, $vdata);
                        $vId = $check_variation["id"];
                    }
                }

            $line_items =array();
            $i=0;
             
            if (isset($_POST['project_cost_partpc'])) {
                
                $project_cost_partpc = $_POST['project_cost_partpc'];
                $pccostingpartid = $_POST['project_cost_partpc'];
                $original_quantity = $_POST['original_quantity'];
                $pcuninvoicequantity = $_POST['uninvoicequantity'];
                $pcinvoicequantity = $_POST['pcinvoicequantity'];
                $pcinvoicebudget = $_POST['pcinvoicebudget'];
                $pcinvoicecostdiff = $_POST['pcinvoicecostdiff'];
                $pccomponent = $_POST['pccomponent'];
                $pcstage= $_POST['pcstage'];
                $pcpart = $_POST['pcpart'];
                $pcuom = $_POST['pcuom'];
                $pcucost = $_POST['pcucost'];
                $pclinttotal = $_POST['pclinttotal'];
                $pcmargin = $_POST['pcmargin'];
                $pcmargintotal = $_POST['pcmargintotal'];
                $pcsi_item_id = $_POST['pcsi_item_id'];
                $pcsi_item_id = $_POST['pcsi_item_id']; 
                $supplierorderquantity = $_POST['supplierorderqty'];
                $pcorderquantity = $_POST['pcorderqty'];
                $pcinvoicetype = $_POST['pcinvoicetype'];
                $pcsuppliercreditquantity = $_POST['pcsuppliercreditquantity'];
                $pcsuppliercreditamount = $_POST['pcsuppliercreditamount'];
                
                foreach ($project_cost_partpc as $key => $value) {
                    
                   
                   $ordered_quantity2 = $this->mod_project->get_order_quantity_by_costingpartid($value);
                    $supplier_ordered_quantity = get_supplier_ordered_quantity($value);
                   
                    if(($supplier_ordered_quantity+$pcinvoicequantity[$key])>$ordered_quantity2[0]['total_ordered']){
                   
                    $pctotalunorderquantity  = ($supplier_ordered_quantity+$pcinvoicequantity[$key])-$ordered_quantity2[0]['total_ordered'];
                    }
                    else{
                        $pctotalunorderquantity  = 0;
                    }
                    
                    $allowance_cost = number_format($pcinvoicebudget[$key] - ($pcucost[$key]*$pcinvoicequantity[$key]), 2, '.', '');
                   
                    $invoice = array(
                        'supplier_credit_id' => $invoice_new,
                        'order_pc_id' => $value,
                        'supplier_id' => $_POST['supplier_id'],
                        'supplier_invoice_item_type' => 'pc',
                        'costing_part_id' => $value,
                        'quantity' => $pcinvoicequantity[$key],
                        'component_id' => $pccomponent[$key],
                        'invoice_amount' => $pcinvoicebudget[$key],
                        'cost_diff' => ($pcinvoicecostdiff[$key]=="allowance")?$allowance_cost:$pcinvoicecostdiff[$key],
                        'stage_id' => $pcstage[$key],
                        'part_field' => $pcpart[$key],
                        'supplier_credit_quantity' => $pcsuppliercreditquantity[$key],
                        'supplier_credit_amount' => $pcsuppliercreditamount[$key]
                    );                    
                    
                    if($pcsi_item_id[$key]){
                        $this->mod_common->update_table('project_supplier_credits_items', array('id'=>$pcsi_item_id[$key]), $invoice);
                        $invoicedone=$pcsi_item_id[$key];
                        $existingsipartarr = array_diff($existingsipartarr, array($invoicedone));
                    }
                    else{
                        $invoicedone = $this->mod_common->insert_into_table('supplier_credits_items', $invoice);
                    }

                   if(($this->input->post('createvariation'))== 1 &&  ($this->input->post('suppliercreditstatus')=='Approved' || $this->input->post('suppliercreditstatus')=='Pending')){
                        
                         $where = array('variation_id' => $check_variation["id"], 'stage_id' =>$pcstage[$key], 'project_id' => $cid['project_id'], 'component_id' => $pccomponent[$key]);
		                 $check_variation_parts = $this->mod_common->get_all_records('project_variation_parts', "*", 0, 0, $where);
                        
                        if (count($check_variation_parts)==0 && $pcinvoicecostdiff[$key]!="allowance") {

                            $part = array(
                                'variation_id' => $vId,
                                'stage_id' => $pcstage[$key],
                                'costing_part_id' => $value,
                                'project_id' => $cid['project_id'],
                                'component_id' => $pccomponent[$key],
                                'part_name' => $pcpart[$key],
                                'component_uom' => $pcuom[$key],
                                'linetotal' => $pclinttotal[$key],
                                'component_uc' => $pcucost[$key],
                                'supplier_id' => $_POST['supplier_id'],
                                'quantity' => $pcinvoicequantity[$key],
                                'status_part' => 1,
                                'available_quantity' => 0,
                                'costing_id' => $_POST['project_id'],
                                'change_quantity' => $pcinvoicequantity[$key],
                                'updated_quantity' => $pcinvoicequantity[$key],
                                'quantity_type' => 'manual',
                                'formulaqty' => '',
                                'formulatext' => '',
                                'component_variation_amount' => $pcinvoicecostdiff[$key],
                                'costingpartid_var' => $value,
                            );

                            $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);

                        }
                        
                        else{
                            if($pcinvoicecostdiff[$key]!="allowance"){
                            $where 	= array('id' => $check_variation_parts[0]["id"]);
                            $part = array(
                                'stage_id' => $pcstage[$key],
                                'costing_part_id' => $value,
                                'project_id' => $cid['project_id'],
                                'component_id' => $pccomponent[$key],
                                'part_name' => $pcpart[$key],
                                'component_uom' => $pcuom[$key],
                                'linetotal' => $pclinttotal[$key],
                                'component_uc' => $pcucost[$key],
                                'supplier_id' => $_POST['supplier_id'],
                                'quantity' => $pcinvoicequantity[$key],
                                'status_part' => 1,
                                'available_quantity' => 0,
                                'costing_id' => $_POST['project_id'],
                                'change_quantity' => $pcinvoicequantity[$key],
                                'updated_quantity' => $pcinvoicequantity[$key],
                                'quantity_type' => 'manual',
                                'formulaqty' => '',
                                'formulatext' => '',
                                'component_variation_amount' => $pcinvoicecostdiff[$key]
                            );
                            
                            $this->mod_common->update_table('project_variation_parts', $where, $part);
                            
                            $vpid=$vparts = $check_variation_parts[0]["id"];
                        }

                        }
                        
                       $costing_parts = array(
                            'is_variated' => $vId,
                            'isp_variated' => $vpid);
                        $this->mod_common->update_table("project_costing_parts", array("costing_part_id" => $pccostingpartid[$key]), $costing_parts);
                    }
                    
                    $where = array('component_id' => $pccomponent[$key]);
		            $component_info = $this->mod_common->select_single_records('project_components', $where);
                    if($pcinvoicequantity[$key]>0){
		            $line_items[$i]["Description"] = $component_info["component_name"];
		            $line_items[$i]["Quantity"] = $pcsuppliercreditquantity[$key];
		            $line_items[$i]["UnitAmount"] = $pcsuppliercreditamount[$key]/$pcsuppliercreditquantity[$key];
		            $line_items[$i]["LineAmount"] = $pcsuppliercreditamount[$key];
		            $line_items[$i]["TaxType"] = "INPUT2";
		            $line_items[$i]["TaxAmount"] = $pcsuppliercreditquantity[$key]*($project_tax["tax_percent"]/100);
		            $line_items[$i]["AccountCode"] = "310";
		            $line_items[$i]["Tracking"][0]["Name"] = $tracking_name;
                    $line_items[$i]["Tracking"][0]["Option"] = $project_info["project_title"];
                    $i++; 
                    }
                                     
                }              
            }

            if (isset($_POST['nicomponent'])) {

                $nicosting_part_id=$_POST['nicosting_part_id'];
                $nistage = $_POST['nistage'];
                $nipart = $_POST['nipart'];
                $nicomponent = $_POST['nicomponent'];
                $niuom = $_POST['niuom'];
                $niucost = $_POST['niucost'];
                $nimanualqty = $_POST['nimanualqty'];
                $nilinttotal = $_POST['nilinttotal'];
                $nisrno = $_POST['nisrno'];
                $nisi_item_id= $_POST['nisi_item_id'];
                
                foreach ($nicomponent as $key => $value) {

                    $where = array('component_id' => $nicomponent[$key]);
		            $component_info = $this->mod_common->select_single_records('project_components', $where);

                    $invoice = array(
                        'supplier_credit_id' => $invoice_new,
                        'supplier_id' => $_POST['supplier_id'],
                        'supplier_invoice_item_type' => 'ni',
                        'quantity' => $nimanualqty[$key],
                        'invoice_amount' => $nilinttotal[$key],
                        'component_id' => $nicomponent[$key],
                        'part_field' => $nipart[$key],
                        'stage_id' => $nistage[$key],
                        'costing_part_id' => 0,
                        'ni_unit_cost' =>$niucost[$key] ,
                        'ni_uom' => $niuom[$key],
                        'srno' =>  $nisrno[$key]
                    );
                    if($nimanualqty[$key]>0){
		            $line_items[$i]["Description"]= $component_info["component_name"];
		            $line_items[$i]["Quantity"]= $nimanualqty[$key];
		            $line_items[$i]["UnitAmount"]= $nilinttotal[$key]/$nimanualqty[$key];
		            $line_items[$i]["LineAmount"]= $nilinttotal[$key];
		            $line_items[$i]["TaxType"]= "INPUT2";
		            $line_items[$i]["TaxAmount"]= $nilinttotal[$key]*($project_tax["tax_percent"]/100);
		            $line_items[$i]["AccountCode"]= "310";
		            $line_items[$i]["Tracking"][0]["Name"]= $tracking_name;
                    $line_items[$i]["Tracking"][0]["Option"]= $project_info["project_title"];
                    $i++;
                    }
		            
                    if(($this->input->post('createvariation'))== 1 &&  ($this->input->post('suppliercreditstatus')=='Approved' || $this->input->post('suppliercreditstatus')=='Pending')){
                         $where = array('variation_id' => $check_variation["id"], 'stage_id' =>$nistage[$key], 'project_id' => $cid['project_id'], 'component_id' => $nicomponent[$key]);
		                 $check_variation_parts = $this->mod_common->get_all_records('project_variation_parts', "*", 0, 0, $where);
                         if(count($check_variation_parts)==0){
                            $part = array(
                                'variation_id' => $vId,
                                'stage_id' => $nistage[$key],
                                'costing_part_id' => $nicosting_part_id[$key],
                                'project_id' => $cid['project_id'],
                                'component_id' => $nicomponent[$key],
                                'part_name' => $nipart[$key],
                                'component_uom' => $niuom[$key],
                                'linetotal' => $nilinttotal[$key],
                                'component_uc' => $niucost[$key],
                                'supplier_id' => $_POST['supplier_id'],
                                'quantity' => $nimanualqty[$key],
                                'status_part' => 1,
                                'available_quantity' => 0,
                                'costing_id' => $_POST['project_id'],
                                'change_quantity' => $nimanualqty[$key],
                                'updated_quantity' => $nimanualqty[$key],
                                'quantity_type' => 'manual',
                                'formulaqty' => '',
                                'formulatext' => '',
                                'component_variation_amount' => $nilinttotal[$key]
                            );

                            $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);
                        }
                        else{
                            $where = array('id' => $check_variation_parts[0]["id"]);
                            $part = array(
                                'stage_id' => $nistage[$key],
                                'costing_part_id' => $nicosting_part_id[$key],
                                'project_id' => $cid['project_id'],
                                'component_id' => $nicomponent[$key],
                                'part_name' => $nipart[$key],
                                'component_uom' => $niuom[$key],
                                'linetotal' => $nilinttotal[$key],
                                'component_uc' => $niucost[$key],
                                'supplier_id' => $_POST['supplier_id'],
                                'quantity' => $nimanualqty[$key],
                                'status_part' => 1,
                                'available_quantity' => 0,
                                'costing_id' => $_POST['project_id'],
                                'change_quantity' => $nimanualqty[$key],
                                'updated_quantity' => $nimanualqty[$key],
                                'quantity_type' => 'manual',
                                'formulaqty' => '',
                                'formulatext' => '',
                                'component_variation_amount' => $nilinttotal[$key]
                            );
                            $vpid=$vparts = $this->mod_common->update_table('project_variation_parts', $where, $part);
                            $vpid=$vparts = $check_variation_parts[0]["id"];
                        }
                    }
                    if($nisi_item_id[$key]){
                        
                        $this->mod_common->update_table('project_supplier_credits_items', array('id'=>$nisi_item_id[$key]), $invoice);
                        
                        $invoicedone=$nisi_item_id[$key];
                        $existingsipartarr = array_diff($existingsipartarr, array($invoicedone));

                    }
                    else{
                        $invoicedone = $this->mod_common->insert_into_table('project_supplier_credits_items', $invoice);
                    }

                      if(($this->input->post('createvariation'))== 1 && ($this->input->post('suppliercreditstatus')=='Approved' || $this->input->post('suppliercreditstatus')=='Pending')){
                        $where = array('costing_tpe_id' => $invoice_new, 'costing_id' => $_POST['project_id'], 'stage_id' => $nistage[$key], 'component_id' => $nicomponent[$key], 'costing_part_name' => $nipart[$key], 'costing_supplier' => $_POST['supplier_id']);
		                $check_costing_parts = $this->mod_common->get_all_records('project_costing_parts', "*", 0, 0 ,$where, "costing_part_id");
                        if(count($check_costing_parts)==0){
                        $part = array(
                            'costing_id' => $_POST['project_id'],
                            'stage_id' => $nistage[$key],
                            'component_id' => $nicomponent[$key],
                            'costing_part_name' => $nipart[$key],
                            'costing_uom' => $niuom[$key],
                            'client_allowance' => 0,
                            'margin' => 0,
                            'line_cost' => $nilinttotal[$key],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $nilinttotal[$key],
                            'type_status' => 1,
                            'is_locked' => 0,
                            'include_in_specification' => 0,
                            'costing_uc' => $niucost[$key],
                            'costing_supplier' => $_POST['supplier_id'],
                            'costing_quantity' => $nimanualqty[$key],
                            'costing_part_status' => 1,
                            'is_variated' => $vId,
                            'isp_variated' => $vparts,
                            'costing_type' => 'supcredit' ,
                            'costing_tpe_id' => $invoice_new
                        );

                        $cpid = $this->mod_common->insert_into_table('project_costing_parts', $part);
                        }
                        else{
                           $part = array(
                            'costing_id' => $_POST['project_id'],
                            'stage_id' => $nistage[$key],
                            'component_id' => $nicomponent[$key],
                            'costing_part_name' => $nipart[$key],
                            'costing_uom' => $niuom[$key],
                            'client_allowance' => 0,
                            'margin' => 0,
                            'line_cost' => $nilinttotal[$key],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $nilinttotal[$key],
                            'type_status' => 1,
                            'is_locked' => 0,
                            'include_in_specification' => 0,
                            'costing_uc' => $niucost[$key],
                            'costing_supplier' => $_POST['supplier_id'],
                            'costing_quantity' => $nimanualqty[$key],
                            'costing_part_status' => 1,
                            'is_variated' => $vId,
                            'isp_variated' => $vparts
                        );

                        $this->mod_common->update_table('project_costing_parts', array('costing_part_id' => $check_costing_parts[0]["costing_part_id"]), $part); 
                        $cpid = $check_costing_parts[0]["costing_part_id"];
                        }

                        $partispp=array('costingpartid_var' => $cpid );
                        $wherepp = array('id' => $vpid);
                        $this->mod_common->update_table('project_variation_parts', $wherepp, $partispp);
                        $partispp=array('costing_part_id' => $cpid );
                        $partispp=array('costing_part_id' => $cpid,'order_pc_id' => $cpid );
                        $wherepp = array('id' => $invoicedone);
                        $this->mod_common->update_table('supplier_credits_items', $wherepp, $partispp);

                    }
                }
            }

            foreach ($existingsipartarr as $key => $value) {
                $where 			= array('id' => $value);
		        $costing_part_info = $this->mod_common->select_single_records('project_supplier_credits_items', $where);
                $this->mod_common->delete_record('project_supplier_credits_items', array('id'=>$value));
                      }            
            //Xero Implementation                     
                    if($this->input->post('suppliercreditstatus')=='Approved'){

                    $invoice_date = explode("/", $this->input->post('creditdate'));
                    $invoice_date = $invoice_date[2]."-".$invoice_date[1]."-".$invoice_date[0];     

		            $where 			= array('supplier_id' => $_POST['supplier_id']);
		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
		            
                      $new_credit_note = array("CreditNotes" => array(
                                			array(
                                				"Type"=>"ACCPAYCREDIT",
                                				"Contact" => array(
                                					"Name" => $supplier_info["supplier_name"]
                                				),
                                				"Date" => $invoice_date,
                                				"Status" => "AUTHORISED",
                                				"CreditNoteNumber" => $_POST['creditreference'], 
                                				"Reference" => $_POST['creditreference'],
                                				"LineAmountTypes" => 'Exclusive',
                                				"LineItems"=>  $line_items                            					
                                				)
                  

              			)
                                		);
                                		
                      
                     
                       $new_contact = array(
                			array(
                				"Name" => $supplier_info["supplier_name"],
                				"ContactNumber" => $supplier_info["supplier_phone"],
                				"ContactPersons" => $supplier_info["supplier_contact_person"],
                				"EmailAddress" => $supplier_info["supplier_email"],
                				"Addresses" => array(
                					"Address" => array(
                						array(
                							"AddressType" => "POBOX",
                							"AddressLine1" => $supplier_info["post_street_pobox"],
                							"City" => $supplier_info["supplier_postal_city"],
                							"PostalCode" => $supplier_info["supplier_postal_zip"]
                						),
                						array(
                							"AddressType" => "STREET",
                							"AddressLine1" => $supplier_info["street_pobox"],
                							"City" => $supplier_info["supplier_city"],
                							"PostalCode" => $supplier_info["supplier_zip"]
                						)
                					)
                				)
                			)
                		);
                		if(count($xero_credentials)>0){
                		// create the contact
                		$contact_result = $this->xero->Contacts($new_contact);
                		
                    	$credit_result = $this->xero->CreditNotes($new_credit_note);
                    	
                    	$xero_creditnote_id = $credit_result['CreditNotes']['CreditNote']['CreditNoteID'];
                    	
                    	
                    	$partispp=array('xero_creditnote_id' => $xero_creditnote_id);
                        $wherepp = array('id' => $invoice_id);
                        $this->mod_common->update_table('project_supplier_credits', $wherepp, $partispp);
                        
                		}
                	
                    }
            }

            $this->session->set_flashdata('ok_message', 'Supplier Credit updated succesfully');
            redirect(SURL.'supplier_credits/viewcredit/'.$invoice_id);
    }

    //View Supplier Credit
    public function viewcredit($invoice_id) {
        
        $data['error'] = array();
        
        $var_number = $this->mod_variation->lastinsertedvariationid();
        $data['var_number'] = $var_number;

        $data['sinvoice_detail'] = $this->mod_project->get_scredit_detail_by_id($invoice_id);
        if(isset($data['sinvoice_detail']) && $data['sinvoice_detail']!=""){
            $ordersinsuin= $this->mod_project->getorderinsuin($invoice_id);
    
            $supplier_id=$data['sinvoice_detail']->supplier_id;
            
            $data['sinvoice_items_pc'] = $this->mod_project->get_scredit_items_by_sinvoice_id($invoice_id,'pc');
            
            foreach ($data['sinvoice_items_pc'] as $key => $value) {
                $totalquantity = $this->mod_project->gettotalquantity($value['costing_part_id']);
    
                $totalprojectcosting = $this->mod_project->getprojectcosting($value['costing_part_id']);
    
                if($totalprojectcosting['costing_id']!=""){
                    $totalprojectsum = $this->mod_project->getprojectcostingsum($totalprojectcosting['costing_id'], $value['stage_id']);
                    if($totalprojectsum['total_sum']==""){
                        $totalprojectsum = 0;
                    }
                    else{
                        $totalprojectsum = $totalprojectsum['total_sum'];
                    }
                }
    
                if($totalquantity['variation_quantity']==""){
                    $totalquantity = 0;
                }
                else{
                    $totalquantity = $totalquantity['variation_quantity'];
                }
                $ordered_quantity=$this->mod_project->get_order_quantity_by_costingpartid($value['costing_part_id']);
                $data['sinvoice_items_pc'][$key]['total_ordered'] = $ordered_quantity[0]['total_ordered'];
                $variation = $this->mod_project->getupdatedquantitybycostingpartid($value['costing_part_id']);
    
                $supplier_invoiceqi = $this->mod_project->get_siuiq_by_pccpid($value['costing_part_id']);
                $supplier_invoiceq = $supplier_invoiceqi[0]['invoicedquantity'];
                
                if ($supplier_invoiceq == NULL)
                    $supplier_invoiceq = 0;
    
                $costing_part_details = $this->mod_project->get_costing_part_info_by_id($value['costing_part_id']);
               
                $data['sinvoice_items_pc'][$key]['client_allowance'] = $costing_part_details->client_allowance;
                $data['sinvoice_items_pc'][$key]['var_number'] = $variation[0]['var_number'];
                $data['sinvoice_items_pc'][$key]['invoicedquantity'] = $supplier_invoiceq;
                $data['sinvoice_items_pc'][$key]['uninvoicedquantity'] = $data['sinvoice_items_pc'][$key]['costing_quantity'] - $supplier_invoiceq;
                $data['sinvoice_items_pc'][$key]['uninvoicebudget']= ($data['sinvoice_items_pc'][$key]['costing_quantity'] )*($data['sinvoice_items_pc'][$key]['costing_uc'])*(100+$data['sinvoice_items_pc'][$key]['margin'])/100 - $supplier_invoiceqi[0]['invoiced_amount'];
                
                if( $data['sinvoice_items_pc'][$key]['uninvoicedquantity']<0)
                    $data['sinvoice_items_pc'][$key]['uninvoicedquantity'] = 0;
                if($data['sinvoice_items_pc'][$key]['uninvoicebudget']<0)
                    $data['sinvoice_items_pc'][$key]['uninvoicebudget'] = 0;
    
                if ($data['sinvoice_detail']->status == 'Pending') {
    
                    if (($data['sinvoice_items_pc'][$key]['uninvoicedquantity']+$value['quantity']) < $value['quantity'] && $data['sinvoice_items_pc'][$key]['uninvoicedquantity']!=0) {
    
                        array_push($data['error'], 'you should  not approve this Supplier Invoice, Supplier invoice quantity is greater than project part uninvoiced costing quantity with ((part name: '.$value['part_field'].' ) for an item in Supplier invoice ');
                    }
                }
    
    
            }
    
    
            $data['sinvoice_items_ni'] = $this->mod_project->get_scredit_items_by_sinvoice_id($invoice_id,'ni');
            
            $project_id = $this->mod_project->get_project_id_from_costing_id($data['sinvoice_detail']->project_id);
    
            $data['projectinfo'] = $this->mod_project->get_project_info($project_id['project_id']);
    
            $cwhere = array('supplier_id' => $data['sinvoice_detail']->supplier_id);
            $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $cwhere);
    
            $this->stencil->title('View Supplier Credit Details');
    	    $this->stencil->paint('supplier_credits/view_credit', $data);

        }
        else{
             $this->session->set_flashdata('err_message', 'No Record Found.');
            redirect(SURL."supplier_credits");
        }
   }
   
   //Update Supplier Credit Status
   function update_status(){
        $xero_credentials = get_xero_credentials();
        $id=$this->input->post('id');
        $status=$this->input->post('status');
        $data['invoice_amount']=$this->input->post('invoice_amount');
        $data['amount_total_entered']=$this->input->post('amount_total_entered');
        $where= array(
                'id' => $id
            );
       $order_purchase = array(
                'status' => $status
            );
        $this->mod_common->update_table('project_supplier_credits', $where, $order_purchase);
        if($status=="Approved"){
            
            $where 	= array('id' => $id);
		    $invoice_info = $this->mod_common->select_single_records('project_supplier_credits', $where);
		   
		    //Costing Id
		    $costing_id = $invoice_info["project_id"];
		    
		    $where 	= array('costing_id' => $costing_id);
		    $costing_info = $this->mod_common->select_single_records('project_costing', $where);
		    
		    //Project Id
		    $project_id = $costing_info["project_id"];
		    
		    //Project Tax
		    $project_tax =  $costing_info["tax_percent"];		    
		    
		    $where 			= array('project_id' => $project_id);
		    $project_info = $this->mod_common->select_single_records('project_projects', $where);
		    
            $tracking_options =  array( 
                    	 "Option" => array(
                    	 "Name" => $project_info["project_title"]
                    	 )
                 );
             if(count($xero_credentials)>0){ 
                $tracking_name = $xero_credentials["tracking_category_name"];
                $tracking_options_result = $this->xero->TrackingCategories($tracking_options);
             }
            
            $new_line_items =array();
            $iteration=0;
            
            
            $where = array('supplier_credit_id' => $id);
		    $invoice_items = $this->mod_common->get_all_records('project_supplier_credits_items', '*', 0, 0, $where);
		    foreach($invoice_items as $invoice_item){
            $where = array('component_id' => $invoice_item["component_id"]);
		    $component_info = $this->mod_common->select_single_records('project_components', $where);
            if($invoice_item["quantity"]>0){
    		   $new_line_items[$iteration]["Description"] = $component_info["component_name"];
    		   $new_line_items[$iteration]["Quantity"]= $invoice_item["quantity"];
    		   $new_line_items[$iteration]["UnitAmount"]= $invoice_item["invoice_amount"]/$invoice_item["quantity"];
    		   $new_line_items[$iteration]["LineAmount"]= $invoice_item["invoice_amount"];
    		   $new_line_items[$iteration]["TaxType"]= "INPUT2";
    		   $new_line_items[$iteration]["TaxAmount"]= $invoice_item["invoice_amount"]*($project_tax/100);
    		   $new_line_items[$iteration]["AccountCode"]= "310";
    		   $new_line_items[$iteration]["Tracking"][0]["Name"]= $tracking_name;
               $new_line_items[$iteration]["Tracking"][0]["Option"]= $project_info["project_title"];
               $iteration++;
            }
              
           
		    }
		    
		    //Xero Implementation 
		    
		            $invoice_date = explode("/", $invoice_info["invoice_date"]);
                    $invoice_date = $invoice_date[2]."-".$invoice_date[1]."-".$invoice_date[0];      
		               
		            $where 			= array('supplier_id' => $invoice_info["supplier_id"]);
		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
                       $new_credit_note = array("CreditNotes" => array(
                                			array(
                                				"Type"=>"ACCPAYCREDIT",
                                				"Contact" => array(
                                					"Name" => $supplier_info["supplier_name"]
                                				),
                                				"Date" => $invoice_date,
                                				"Status" => "AUTHORISED",
                                				"CreditNoteNumber" => $invoice_info['supplierrefrence'], 
                                				"Reference" => $invoice_info['supplierrefrence'],
                                				"LineAmountTypes" => 'Exclusive',
                                				"LineItems"=> $line_items                            					
                                				)
              			)
                                		);
                      
                     
                       $new_contact = array(
                			array(
                				"Name" => $supplier_info["supplier_name"],
                				"ContactNumber" => $supplier_info["supplier_phone"],
                				"ContactPersons" => $supplier_info["supplier_contact_person"],
                				"EmailAddress" => $supplier_info["supplier_email"],
                				"Addresses" => array(
                					"Address" => array(
                						array(
                							"AddressType" => "POBOX",
                							"AddressLine1" => $supplier_info["post_street_pobox"],
                							"City" => $supplier_info["supplier_postal_city"],
                							"PostalCode" => $supplier_info["supplier_postal_zip"]
                						),
                						array(
                							"AddressType" => "STREET",
                							"AddressLine1" => $supplier_info["street_pobox"],
                							"City" => $supplier_info["supplier_city"],
                							"PostalCode" => $supplier_info["supplier_zip"]
                						)
                					)
                				)
                			)
                		);
                		if(count($xero_credentials)>0){
                		// create the contact
                		$contact_result = $this->xero->Contacts($new_contact);
                		
                    	$credit_result = $this->xero->CreditNotes($new_credit_note);
                    	
                    	$xero_creditnote_id = $credit_result['CreditNotes']['CreditNote']['CreditNoteID'];
                    	
                    	$partispp=array('xero_creditnote_id' => $xero_creditnote_id);
                        $wherepp = array('id' => $id);
                        $this->mod_common->update_table('project_supplier_credits', $wherepp, $partispp);
                		}
		    
		    
        }
        
        $data['sinvoice_detail_status'] = $status;
        $data['order_id'] = $id;
        $html = $this->load->view('supplier_credits/status_ajax.php', $data, true);
        echo $html;
    }
    
}