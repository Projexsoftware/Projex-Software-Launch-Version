<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_invoices extends CI_Controller {

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
    
    //Get All Supplier Invoices
    
    public function index()
	{
	    $this->mod_common->is_company_page_accessible(19);
	    
	    $data['supplier_invoices'] = $this->mod_project->get_all_supplier_invoices();
        
        $this->stencil->title('Supplier Invoices');
	    $this->stencil->paint('supplier_invoices/manage_supplier_invoices', $data);
	}
	
	//Add Supplier Invoice Page
	
	public function add_invoice() {
        $this->mod_common->is_company_page_accessible(20);

        $data['projects'] = $this->mod_project->get_active_project(); 
        $data['var_number'] = $this->mod_variation->lastinsertedvariationid();
        
        $where = array('stage_status' => 1, 'company_id' => $this->session->userdata('company_id'));
        $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $where, "stage_id");
        
        $where = array('supplier_status' => 1, 'company_id' => $this->session->userdata('company_id'));
        $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $where, "supplier_id");
        
        $this->stencil->title('Add Supplier Invoice');
	    $this->stencil->paint('supplier_invoices/add_supplier_invoice', $data);
    }
    
    //Get Suppliers list
    public function getsupplier() {
        $prj_costing_id = $this->input->post('costing_id');
        $suppliers = $this->mod_project->get_costing_suppliers_by_costing_id($prj_costing_id);
        $html = '<select class="selectpicker" data-style="select-with-transition" data-live-search="true" name="supplier_id" id="supplier_id" onchange="change_supplier(this.value)" required>';
        foreach ($suppliers AS $k => $v) {
            $html.= '<option value="' . $v['costing_supplier'] . '" >' . $v['supplier_name'] . '</option>';
        }
        $html.='</select>';
        print_r($html);
    }
    
    //Populate project Costing Parts
    public function populate_project_part_costing() {

        $returnhtml='';
        
        $data['selected_costing_id'] = $this->input->post('value');
        $data['selected_stage_id'] = "";
        $data['selected_supplier_id'] = "";
        
        $cwhere = "costing_id = ".$data['selected_costing_id']." AND costing_type!='sivar' AND client_allowance = 0";
         
        if($this->input->post('supplier_id')!=""){
            $data['selected_supplier_id'] = join(', ', $this->input->post('supplier_id'));
            $cwhere .= " AND costing_supplier IN (".$data['selected_supplier_id'].")";
         }
        if($this->input->post('stage_id')!=""){
            $data['selected_stage_id'] = join(', ', $this->input->post('stage_id'));
            $cwhere .= " AND stage_id IN (".$data['selected_stage_id'].")";
        }
       
        $fields = '`costing_part_id`, `stage_id`, `costing_quantity`,`costing_tpe_id`,`client_allowance`,`costing_supplier`';
        $costing_parts = $this->mod_common->get_all_records('project_costing_parts', $fields, 0, 0, $cwhere, "costing_part_id");
        
        $pc_ids= array();
        
        
        foreach ($costing_parts as $k => $cp) {

            $ordered_quantity=$this->mod_project->get_order_quantity_by_costingpartid($cp["costing_part_id"]);
            $ordered_quantity = $ordered_quantity[0]['total_ordered'];
            
            $supplier_invoiceqi = $this->mod_project->get_siuiq_by_pccpid($cp["costing_part_id"]);
            if(count($supplier_invoiceqi)>0){
                $supplier_invoiceq = $supplier_invoiceqi[0]['invoicedquantity'];
                $updated_quantity = get_recent_quantity($cp["costing_part_id"], $cp["costing_supplier"]);
                
                $uninvoicedquantity =  $cp["costing_quantity"] - $supplier_invoiceq;
               
                if(($uninvoicedquantity>0 &&  $cp["client_allowance"] == 0) || ( $cp["client_allowance"] == 1)){
                    array_push($pc_ids,  $cp["costing_part_id"]);
                }
            }
            else{
                $updated_quantity = get_recent_quantity($cp["costing_part_id"], $cp["costing_supplier"]);
                
                $uninvoicedquantity =  $cp["costing_quantity"];
               
                if(($uninvoicedquantity>0 &&  $cp["client_allowance"] == 0) || ( $cp["client_allowance"] == 1)){
                    array_push($pc_ids,  $cp["costing_part_id"]);
                }
            }
        }
        if(count($pc_ids) > 0){
            $prject_id=$this->mod_project->get_project_id_from_costing_id($this->input->post('value'));
            $data['projectname'] = $this->mod_project->get_project_by_name($prject_id['project_id']);
            $i=1;
            foreach ($pc_ids as $kepc => $pc_id) {
                $data['no_of_rows']=count($pc_ids);
                if ($pc_id == 0) {
                    echo "Some thing is not right. Please refresh";
                }
                else {

                    $data['costing_part_details'] = $this->mod_project->get_costing_part_info_by_id($pc_id);
                    
                    if(isset($_POST['pccc'])){
                        if(in_array($data['costing_part_details']->costing_part_id, $_POST['pccc']) ) {unset($pc_ids[$kepc]); continue; }
                    }
                    $data['last_row'] = $kepc;

                    $ordered_quantity = $this->mod_project->get_order_quantity_by_costingpartid($data['costing_part_details']->costing_part_id);
                    $data['ordered_quantity'] = $ordered_quantity = $ordered_quantity[0]['total_ordered'];

                    $variation = $this->mod_project->getupdatedquantitybycostingpartid($data['costing_part_details']->costing_part_id);
                    
                    $supplier_invoiceqi = $this->mod_project->get_siuiq_by_pccpid($data['costing_part_details']->costing_part_id);
                    if(count($supplier_invoiceqi)>0){
                    $supplier_invoiceq = number_format($supplier_invoiceqi[0]['invoicedquantity'], 2, '.', '');
                    }
                    else{
                        $supplier_invoiceq = 0;
                    }
                    if(count($variation)>0){
                    $data['costing_part_details']->var_number = $variation[0]['var_number'];
                    }
                    $data['costing_part_details']->invoicedquantity = $supplier_invoiceq;
                    $data['costing_part_details']->uninvoicedquantity = $data['costing_part_details']->costing_quantity-$supplier_invoiceq;
                    $data['costing_part_details']->uninvoicebudget= ($data['costing_part_details']->costing_quantity)*($data['costing_part_details']->costing_uc)*(100+$data['costing_part_details']->margin)/100 - $supplier_invoiceq;
                    if($data['costing_part_details']->uninvoicedquantity<0)
                        $data['costing_part_details']->uninvoicedquantity = 0;
                    if($data['costing_part_details']->uninvoicebudget<0)
                    $data['costing_part_details']->uninvoicebudget = 0;
                    $data['i']=$i;
                    
                    $html = $this->load->view('supplier_invoices/populate_project_costing', $data, true);
                    
                    $returnhtml.=$html;
                }
                $i++;
            }
            $populatestage = count($pc_ids);
        }
        else{
            $populatestage=0;
        }
        $returnarr = array( 'returnhtml' => $returnhtml,
            'populatestage' => $populatestage);

        echo json_encode($returnarr);
    }

    //Add New Item
    public function importnew() {
        $data['last_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
        $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : 0;
        $costing_id = isset($_POST['project_id']) ? $_POST['project_id'] : 0;

        $allowance_query = $this->db->query("SELECT costing_part_name, costing_part_id, line_margin FROM project_costing_parts WHERE costing_id='".$costing_id."' AND client_allowance=1 AND costing_part_id NOT IN (SELECT type_id FROM project_sales_invoices_items)");
        
        $data['allowances'] = $allowance_query->result_array();

        $html = $this->load->view('supplier_invoices/importnew', $data, true);

        $return_arr["html1"] = $html;

        echo json_encode($return_arr);
    }
    
    //Create new Supplier Invoice
    public function insertinvoice() {
        
         $this->mod_common->is_company_page_accessible(20);
        
        $this->form_validation->set_rules('project_id', 'Project', 'required');
        $this->form_validation->set_rules('first_selected_supplier', 'Supplier Invoice Name', 'required');
        $this->form_validation->set_rules('supplierrefrence', 'Supplier Reference', 'required');
        $this->form_validation->set_rules('invoiceamountist', ' Invoice Amount Excluding GST', 'required');
        $this->form_validation->set_rules('invoicedate', 'Invoice Date', 'required');
        $this->form_validation->set_rules('invoiceduedate', 'Invoice Due Date', 'required');
        $this->form_validation->set_rules('supplierinvoicestatus', 'Invoice Status', 'required');
        $this->form_validation->set_rules('invoiceamountent', 'Invoice Amount Entered', 'required');
        $this->form_validation->set_rules('invoiceamountnotent', 'Amount Not Entered', 'required');
       
        if ($this->form_validation->run() == FALSE)
    	{
    	    $data['projects'] = $this->mod_project->get_active_project(); 
            $data['var_number'] = $this->mod_variation->lastinsertedvariationid();
            
            $where = array('stage_status' => 1, 'company_id' => $this->session->userdata('company_id'));
            $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $where, "stage_id");
            
            $where = array('supplier_status' => 1, 'company_id' => $this->session->userdata('company_id'));
            $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $where, "supplier_id");
            
            $this->stencil->title('Add Supplier Invoice');
    	    $this->stencil->paint('supplier_invoices/add_supplier_invoice', $data);
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
                'supplier_id' => $_POST['first_selected_supplier'],
                'worked_hours' => $worked_hours,
                'invoice_date' => $this->input->post('invoicedate'),
                'invoice_record_by' => $this->session->userdata('user_id'),
                'company_id' => $this->session->userdata('company_id'),
                'created_date' => date('Y-m-d G:i:s'),
                'supplierrefrence' => $_POST['supplierrefrence'],
                'status' => $this->input->post('supplierinvoicestatus'),
                'invoice_amount' => $this->input->post('invoiceamountist'),
                'create_variation' => (($this->input->post('createvariation'))?$this->input->post('createvariation'):0),
                'va_addsi_cost' => $this->input->post('totaladd_cost') ,
                'va_addclient_cost' => $this->input->post('totaladdclient_cost'),
                'va_description' => $this->input->post('varidescriptioin'),
                'va_ohm' => $this->input->post('overhead_margin') ,
                'va_pm' => $this->input->post('profit_margin'),
                'va_status' => $this->input->post('supplierinvoicevarstatus'),
                'va_total' => $this->input->post('contract_price'),
                'va_tax' => $this->input->post('costing_tax'),
                'va_round' => $this->input->post('price_rounding'),
                'invoice_due_date' => $this->input->post('invoiceduedate'),
                'invoice_type' => $invoice_type
            );
            $invoice_new = $this->mod_common->insert_into_table('project_supplier_invoices', $invoice_new_arr);
            if($invoice_type=="timesheet"){
            
            $data = array(
                     "project_id" => $this->input->post("project_id"),
                     "timesheet_id" => $this->input->post("timesheet_id"),
                     "supplier_invoice_id" =>  $invoice_new,
                    );
                $this->mod_common->insert_into_table('project_timesheet_supplier_invoices', $data);
                $timesheet_id = $this->input->post("timesheet_id");
    
                $invoice_timesheet_q = $this->db->query("SELECT distinct(project_id) as project_id FROM project_timesheet_items where timesheet_id ='".$timesheet_id."'");
                $invoice_timesheet_result = $invoice_timesheet_q->result_array();
                $is_invoiced = 0;
                foreach($invoice_timesheet_result as $val){
                    $timesheet_query = $this->db->query("SELECT * FROM project_timesheet_supplier_invoices WHERE timesheet_id='".$timesheet_id."' AND project_id='".$val['project_id']."'");
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
            $ppid=$this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
    
            if($this->input->post('createvariation')== 1){
                $vdata = array(
                    'created_by' => $this->session->userdata('user_id'),
                    'company_id' => $this->session->userdata('company_id'),
                    'variation_name' => 'Variation form supplier Invoice # '.$invoice_new ,
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
                    'status' => $_POST['supplierinvoicevarstatus'],
                    'var_type' => 'suppinvo',
                    'var_type_id' => $invoice_new
                );
                $insert_variations = $this->mod_common->insert_into_table('project_variations', $vdata);
                $vId = $insert_variations;
    
                $partispp=array('var_number' => $insert_variations+10000000 );
                $wherepp = array('id' => $insert_variations);
                $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                $this->mod_common->update_table('project_supplier_invoices', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000));
    
            }
            if ($invoice_new) {
                
                 $cid=$this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
                 
                 $where 	= array('project_id' => $cid['project_id']);
    		     $project_tax = $this->mod_common->select_single_records('project_costing', $where);
    		       
    		       $where 			= array('project_id' => $cid['project_id']);
    		       $project_info = $this->mod_common->select_single_records('project_projects', $where);
    		       
    		        
    		       if($this->input->post('supplierinvoicestatus')=='Approved'){
                        
                        $tracking_options =  array("Name" => $project_info["project_title"]);
                        if(count($xero_credentials)>0){
                           $tracking_name = $xero_credentials["tracking_category_name"];
                           $tracking_options_result = $this->xero->TrackingCategories($tracking_options); 
                        }
    		       }            
                 
                    
                $line_items1 =array();
                $contact_suppliers1 = array();
                $selected_suppliers_name1 = "";
                $k=0;
                $l=0;
    
                if (isset($_POST['order_id_po'])) {
                    $order_id_po = $_POST['order_id_po'];
    
    
                    foreach ($order_id_po as $key => $value) {
    
                        $pocosting_part_id = $_POST['pocosting_part_id' . $value];
                        $poinvoicequantity = $_POST['poinvoicequantity' . $value];
                        $poinvoicebudget = $_POST['poinvoicebudget' . $value];
                        $poinvoicecostdiff = $_POST['poinvoicecostdiff' . $value];
                        $pocomponent = $_POST['pocomponent' . $value];
                        $postage= $_POST['postage'.$value];
                        $popart = $_POST['popart'.$value];
                        $srno = $_POST['posrno'.$value];
                        
                        foreach ($pocosting_part_id as $ke => $va) {
    
                            $invoice = array(
                                'supplier_invoice_id' => $invoice_new,
                                'order_pc_id' => $value,
                                'supplier_id' => $_POST['supplier_id'],
                                'supplier_invoice_item_type' => 'po',
                                'costing_part_id' => $va,
                                'component_id' => $pocomponent[$ke],
                                'quantity' => $poinvoicequantity[$ke],
                                'invoice_amount' => $poinvoicebudget[$ke],
                                'cost_diff' => $poinvoicecostdiff[$ke],
                                'stage_id' => $postage[$ke],
                                'part_field' => $popart[$ke],
                                'srno' => $srno[$ke]
                            );
    
                            $invoicedone = $this->mod_common->insert_into_table('project_supplier_invoices_items', $invoice);
                        }
                    }
                }
    
                if (isset($_POST['project_cost_partpc'])) {
    
    
                    $project_cost_partpc = array_values($_POST['project_cost_partpc']);
                    $original_quantity = array_values($_POST['original_quantity']);
                    $pcuninvoicequantity = array_values($_POST['uninvoicequantity']);
                    $pcinvoicequantity = array_values($_POST['pcinvoicequantity']);
                    $pcinvoicebudget = array_values($_POST['pcinvoicebudget']);
                    $pcinvoicecostdiff = array_values($_POST['pcinvoicecostdiff']);
                    $pccomponent = array_values($_POST['pccomponent']);
                    $pcstage= array_values($_POST['pcstage']);
                    $pcpart = array_values($_POST['pcpart']);
                    $pcuom = array_values($_POST['pcuom']);
                    $supplierorderquantity = array_values($_POST['supplierorderqty']);
                    $pcorderquantity = array_values($_POST['pcorderqty']);
                    $pcucost = array_values($_POST['pcucost']);
                    $pclinttotal = array_values($_POST['pclinttotal']);
                    $pcmargin = array_values($_POST['pcmargin']);
                    $pcmargintotal = array_values($_POST['pcmargintotal']);
                    $pcinsubtotal = array_values($_POST['pcinsubtotal']);
                    $pcinvoicetype = array_values($_POST['pcinvoicetype']);
                    $pcsupplier_id = array_values($_POST['pcsupplier_id']);
                    
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
    		            
    		            $where 			= array('supplier_id' => $pcsupplier_id[$key]);
    		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
    		            
                        if($pcinvoicequantity[$key]>0){
    		            $line_items1[$k]["Description"] = $component_info["component_name"];
    		            $line_items1[$k]["Quantity"]= $pcinvoicequantity[$key];
    		            $line_items1[$k]["UnitAmount"]= $pcinvoicebudget[$key]/$pcinvoicequantity[$key];
    		            $line_items1[$k]["LineAmount"]= $pcinvoicebudget[$key];
    		            $line_items1[$k]["TaxType"]= "INPUT2";
    		            $line_items1[$k]["TaxAmount"]= $pcinvoicebudget[$key]*($project_tax["tax_percent"]/100);
    		            $line_items1[$k]["AccountCode"]= "310";
    		            $line_items1[$k]["Tracking"][0]["Name"]= $tracking_name;
                        $line_items1[$k]["Tracking"][0]["Option"]= $project_info["project_title"];
                        $k++;
                        
                        $selected_suppliers_name1 .=$supplier_info["supplier_name"].", ";
                        
                        $contact_suppliers1[$l]["Name"] = $supplier_info["supplier_name"];
                    	$contact_suppliers1[$l]["ContactNumber"] = $supplier_info["supplier_phone"];
                    	$contact_suppliers[$l]["ContactPersons"] = $supplier_info["supplier_contact_person"];
                    	$contact_suppliers[$l]["EmailAddress"] = $supplier_info["supplier_email"];
                    	
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["AddressType"] = "POBOX";
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["AddressLine1"] = $supplier_info["post_street_pobox"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["City"] = $supplier_info["supplier_postal_city"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["PostalCode"] = $supplier_info["supplier_postal_zip"];
                    	
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["AddressType"] = "STREET";
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["AddressLine1"] = $supplier_info["street_pobox"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["City"] = $supplier_info["supplier_city"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["PostalCode"] = $supplier_info["supplier_zip"];
                    	
                    	$l++;
                        }
                        
    
                        $allowance_cost = number_format($pcinvoicebudget[$key] - ($pcucost[$key]*$pcinvoicequantity[$key]), 2, '.', '');
                        $invoice = array(
                            'supplier_invoice_id' => $invoice_new,
                            'order_pc_id' => $value,
                            'supplier_id' => $pcsupplier_id[$key],
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
                        );
                        if($this->input->post('supplierinvoicestatus')=='Approved' OR $this->input->post('supplierinvoicestatus')=='Pending'){
                            $order_purchase = array(
                                'project_id' =>  $ppid['project_id'],
                                'supplier_id' =>  $this->input->post('first_selected_supplier'),
                                'stage_id' => $pcstage[$key],
                                'costing_id' => $_POST['project_id'],
                                'order_date' => date('Y-m-d G:i:s'),
                                'order_by' => $this->session->userdata('user_id'),
                                'company_id' => $this->session->userdata('company_id'),
                                'created_date' => date('Y-m-d G:i:s'),
                                'supplier_invoice_id' =>     $invoice_new,
                                'order_status' => 'Issued'
                            );
                        }
                        if($pcinvoicequantity[$key]>0){
                            
                           $invoicedone = $this->mod_common->insert_into_table('project_supplier_invoices_items', $invoice);
                        
                        }
    
    
                        if(($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending') && $pcinvoicetype[$key]=="pc" && $pcinvoicequantity[$key]>0){
    
                            $where = array('supplier_invoice_id' => $invoice_new);
    	                    $is_purchase_order = $this->mod_common->select_single_records('project_purchase_orders', $where);
                            if(count($is_purchase_order)==0){
                            $porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);
                            }
                            else{
                                $porders = $is_purchase_order["id"];
                            }
                            #------------- get the purchase order qty for the component-----------#
                            
                            $where1 = array('costing_id' => $this->input->post('project_id'),'stage_id'=>$pcstage[$key]);
                            $purchase_order_id = $this->mod_common->select_single_records('project_purchase_orders', $where1);
    
                            $where2 = array('purchase_order_id' => $purchase_order_id["id"],'stage_id'=>$pcstage[$key],'part_name'=>$pcpart[$key]);
                            $purchase_order_qty = $this->mod_common->select_single_records('project_purchase_order_items', $where2);
    
                           if(count($purchase_order_qty)>0){
                              $order_quantity = $purchase_order_qty["order_quantity"];
                            }else{
                                 $order_quantity = 0;
                            }
                        
                            $invoiced_quantity = $pcinvoicequantity[$key] - $order_quantity;
                            $i++;
                            if($pcinvoicecostdiff[$key]==0){
                                $new_costing_uc = $pcinvoicebudget[$key];
                                $new_line_cost = $pcinvoicebudget[$key]*$pcinvoicequantity[$key];
                            }
                            else{
                                $new_costing_uc = $pcinvoicebudget[$key]/$pcuninvoicequantity[$key];
                                $new_line_cost = ($pcinvoicebudget[$key]/$pcuninvoicequantity[$key])*$pcinvoicequantity[$key];
                            }
                            $part = array(
                                'purchase_order_id' => $porders,
                                'part_name' => $pcpart[$key],
                                'component_id' => $pccomponent[$key],
                                'supplier_id' => $pcsupplier_id[$key],
                                'costing_part_id' =>   $value,
                                'order_quantity' => $pcinvoicequantity[$key],
                                'stage_id' => $pcstage[$key],
                                'costing_uom' => $pcuom[$key],
                                'costing_uc' => $pcucost[$key],
                                'line_cost' => $pcinvoicebudget[$key],
                                'margin' => $pcmargin[$key],
                                'line_margin' => $pcinvoicebudget[$key]
                            );
                            if($pcinvoicequantity[$key]>0){
                            $parts = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                            }
    
                        }
                        if($this->input->post('createvariation')== 1 && $pcinvoicecostdiff[$key]!="allowance" && $pcinvoicequantity[$key]>0){
                        $part = array(
                            'variation_id' => $vId,
                            'stage_id' => $pcstage[$key],
                            'costing_part_id' => $value,
                            'project_id' => $ppid['project_id'],
                            'component_id' => $pccomponent[$key],
                            'part_name' => $pcpart[$key],
                            'component_uom' => $pcuom[$key],
                            'linetotal' => $pclinttotal[$key],
                            'margin' => $pcmargin[$key],
                            'margin_line' => $pcmargintotal[$key],
                            'component_uc' => $pcucost[$key],
                            'supplier_id' => $pcsupplier_id[$key],
                            'quantity' => $pcinvoicequantity[$key],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'costing_id' => $_POST['project_id'],
                            'change_quantity' => $pcinvoicequantity[$key],
                            'updated_quantity' => $pcinvoicequantity[$key],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin' => 0,
                            'component_variation_amount' => $pcinvoicecostdiff[$key]
                        );
                        if($pcinvoicequantity[$key]>0 && $vId>0){
                            $this->mod_common->insert_into_table('project_variation_parts', $part);
                        }
    
                    }
                    }
                    
                }
    
                if (isset($_POST['nicomponent'])) {
                    #-------------- insert_into_table variation-----------------#
                    if(($this->input->post('createvariation'))== 1 && ($this->input->post('supplierinvoicestatus')=='Approved' OR $this->input->post('supplierinvoicestatus')=='Pending') && $vId==0){
    
                        $vdata = array(
                            'created_by' => $this->session->userdata('user_id'),
                            'company_id' => $this->session->userdata('company_id'),
                            'variation_name' => 'Variation form supplier Invoice # '.$invoice_new ,
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
                            'status' => $_POST['supplierinvoicevarstatus'],
                            'var_type' => 'suppinvo',
                            'var_type_id' => $invoice_new
                        );
                        $insert_variations = $this->mod_common->insert_into_table('project_variations', $vdata);
                        $vId = $insert_variations;
    
                        $partispp=array('var_number' => $insert_variations+10000000 );
                        $wherepp = array('id' => $insert_variations);
                        $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                         $this->mod_common->update_table('project_supplier_invoices', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000, 'create_variation'=>1));
                    }
    
                    $nicosting_part_id=array_values($_POST['nicosting_part_id']);
                    $nistage = array_values($_POST['nistage']);
                    $nipart = array_values($_POST['nipart']);
                    $nicomponent = array_values($_POST['nicomponent']);
                    $niuom = array_values($_POST['niuom']);
                    $niucost = array_values($_POST['niucost']);
                    $nimanualqty = array_values($_POST['nimanualqty']);
                    $niallowance = array_values($_POST['niallowance']);
                    $nilinttotal = array_values($_POST['nilinttotal']);
                    $nisrno = array_values($_POST['nisrno']);
                    $nisupplier_id = array_values($_POST['nisupplier_id']);
                    $nisupplier_id = array_values($_POST['nisupplier_id']);
                    $include_in_specification = array_values($this->input->post('include_in_specification'));
                    $client_allowance = array_values($this->input->post('client_allowance'));
                    
    
                    foreach ($nicomponent as $key => $value) {
                        
                        $where = array('component_id' => $nicomponent[$key]);
    		            $component_info = $this->mod_common->select_single_records('project_components', $where);
    		            
    		            $where 			= array('supplier_id' => $nisupplier_id[$key]);
    		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
    					
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
                        
                        $selected_suppliers_name1 .=$supplier_info["supplier_name"].", ";
                        
                        $contact_suppliers1[$l]["Name"] = $supplier_info["supplier_name"];
                    	$contact_suppliers1[$l]["ContactNumber"] = $supplier_info["supplier_phone"];
                    	$contact_suppliers[$l]["ContactPersons"] = $supplier_info["supplier_contact_person"];
                    	$contact_suppliers[$l]["EmailAddress"] = $supplier_info["supplier_email"];
                    	
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["AddressType"] = "POBOX";
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["AddressLine1"] = $supplier_info["post_street_pobox"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["City"] = $supplier_info["supplier_postal_city"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][0]["PostalCode"] = $supplier_info["supplier_postal_zip"];
                    	
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["AddressType"] = "STREET";
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["AddressLine1"] = $supplier_info["street_pobox"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["City"] = $supplier_info["supplier_city"];
                    	$contact_suppliers1[$l]["Addresses"]["Address"][1]["PostalCode"] = $supplier_info["supplier_zip"];
                    	
                    	$l++;
    					}
    		            
    		           if($niallowance[$key]==0){
    		               $allocated_allowance_amount = 0;
    		               $allocated_allowance_id = 0;
    		           }
    		           else{
    		              $niallowance_array = explode("|", $niallowance[$key]); 
    		              $allocated_allowance_id = $niallowance_array[0];
    		              $allocated_allowance_amount = $niallowance_array[1];
    		           }
    
                        $invoice = array(
                            'supplier_invoice_id' => $invoice_new,
                            'supplier_id' => $nisupplier_id[$key],
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
                            'srno' =>  $nisrno[$key],
                            'allocated_allowance_id' => $allocated_allowance_id,
                            'allocated_allowance_amount' => $allocated_allowance_amount,
                            'include_in_specification' =>  $include_in_specification[$key],
                            'client_allowance' =>  $client_allowance[$key]
                        );
    
                        if(($this->input->post('createvariation'))== 1 &&  ($this->input->post('supplierinvoicestatus')=='Approved' OR $this->input->post('supplierinvoicestatus')=='Pending')){
    
                            $invoice['part_field']= $nipart[$key];
    
                            $order_purchase = array(
                                'project_id' => $cid['project_id'],
                                'supplier_id' =>  $this->input->post('first_selected_supplier'),
                                'stage_id' => $nistage[$key],
                                'costing_id' => $_POST['project_id'],
                                'order_date' => date('Y-m-d G:i:s'),
                                'order_by' => $this->session->userdata('user_id'),
                                'company_id' => $this->session->userdata('company_id'),
                                'created_date' => date('Y-m-d G:i:s'),
                                'order_status' => 'Issued',
                                'supplier_invoice_id' =>     $invoice_new,
                            );
    
                            if ($vId > 0 && $niallowance[$key]==0) {
    
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
                                    'supplier_id' => $nisupplier_id[$key],
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
                                    'component_variation_amount' => $nilinttotal[$key],
                                    'include_in_specification' =>  $include_in_specification[$key],
                                    'client_allowance' =>  $client_allowance[$key]
                                );
    
                                $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);
    
                            }
                            $this->mod_common->update_table('project_supplier_invoices', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000));
                            
                        }
    
                        $invoiceidone = $this->mod_common->insert_into_table('project_supplier_invoices_items', $invoice);
                        
                        if($allocated_allowance_id>0){
                            $allocated_array = array(
                                "supplier_invoice_item_id" => $invoiceidone,
                                "allocated_allowance_id" => $allocated_allowance_id,
                                "allocated_amount" => $nilinttotal[$key]
                            );
                            $this->mod_common->insert_into_table('allocated_allowance_items', $allocated_array);
                        }
    
                        if(($this->input->post('createvariation'))== 1 &&  ($this->input->post('supplierinvoicestatus')=='Approved' OR $this->input->post('supplierinvoicestatus')=='Pending') && ($nimanualqty[$key]!="0")){
                            
                            $where = array('supplier_invoice_id' => $invoice_new);
    	                    $is_purchase_order = $this->mod_common->select_single_records('project_purchase_orders', $where);
    	                    
                            if(count($is_purchase_order)==0){
                               $porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);
                            }
                            else{
                                $porders = $is_purchase_order["id"];
                            }
                            $j++;
                            $part = array(
                                'purchase_order_id' => $porders,
                                'part_name' => $nipart[$key],
                                'component_id' => $nicomponent[$key],
                                'supplier_id' => $nisupplier_id[$key],
                                'costing_part_id' =>   0,
                                'order_quantity' => $nimanualqty[$key],
                                'stage_id' => $nistage[$key],
                                'costing_uom' => $niuom[$key],
                                'costing_uc' => $niucost[$key],
                                'line_cost' => $nilinttotal[$key],
                                'include_in_specification' =>  $include_in_specification[$key],
                                'client_allowance' =>  $client_allowance[$key]
    
                            );
                            if(($this->input->post('createvariation'))== 1 ){
                                $part['part_name']= $nipart[$key];
                            }
                            $poitem = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
    
                        }
                        if(($this->input->post('createvariation'))== 1 && ($this->input->post('supplierinvoicestatus')=='Approved' OR $this->input->post('supplierinvoicestatus')=='Pending')){
                            if($niallowance[$key]==0){
                                $part = array(
                                    'costing_id' => $_POST['project_id'],
                                    'stage_id' => $nistage[$key],
                                    'component_id' => $nicomponent[$key],
                                    'costing_part_name' => $nipart[$key],
                                    'costing_uom' => $niuom[$key],
                                    'margin' => 0,
                                    'line_cost' => $nilinttotal[$key],
                                    'quantity_type' => 'manual',
                                    'quantity_formula' => '',
                                    'formula_text' => '',
                                    'line_margin' => $nilinttotal[$key],
                                    'type_status' => 1,
                                    'is_locked' => 0,
                                    'include_in_specification' =>  $include_in_specification[$key],
                                    'client_allowance' =>  $client_allowance[$key],
                                    'costing_uc' => $niucost[$key],
                                    'costing_supplier' => $nisupplier_id[$key],
                                    'costing_quantity' => $nimanualqty[$key],
                                    'costing_part_status' => 1,
                                    'is_variated' => $vId,
                                    'isp_variated' => $vparts,
                                    'costing_type' => 'sivar' ,
                                    'costing_tpe_id' => $invoice_new
                                );
        
                                $cpid = $this->mod_common->insert_into_table('project_costing_parts', $part);
        
                                $partispp=array('costingpartid_var' => $cpid );
                                $wherepp = array('id' => $vpid);
                                $this->mod_common->update_table('project_variation_parts', $wherepp, $partispp);
        
                                $partispp=array('costing_part_id' => $cpid );
                                $wherepp = array('id' => $poitem);
                                $this->mod_common->update_table('project_purchase_order_items', $wherepp, $partispp);
                                $this->mod_common->update_table('project_supplier_invoices', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000));
        
                                $partispp=array('costing_part_id' => $cpid,'order_pc_id' => $cpid );
                                $wherepp = array('id' => $invoiceidone);
                                $this->mod_common->update_table('project_supplier_invoices_items', $wherepp, $partispp);
                            }
    
                        }
                    }
                }
                
                
                //Xero Implementation 
                        
                if($this->input->post('supplierinvoicestatus')=='Approved'){
                           
                        $invoice_date = explode("/", $this->input->post('invoicedate'));
                        $invoice_date = $invoice_date[2]."-".$invoice_date[1]."-".$invoice_date[0];
                        $invoice_due_date = explode("/", $this->input->post('invoiceduedate'));
                        $invoice_due_date = $invoice_due_date[2]."-".$invoice_due_date[1]."-".$invoice_due_date[0];  
                        
                        $where 			= array('supplier_id' => $_POST['first_selected_supplier']);
    		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
     
    		            
                           $new_invoice = array( "Invoices" => array(
                                    			array(
                                    				"Type"=>"ACCPAY",
                                    				"Contact" => array(
                                    					"Name" => $supplier_info["supplier_name"]
                                    				),
                                    				"Date" => $invoice_date,
                                    				"DueDate" => $invoice_due_date,
                                    				"Status" => "AUTHORISED",
                                    				"InvoiceNumber" => $_POST['supplierrefrence']."-".$invoice_new, 
                                    				"Reference" => $_POST['supplierrefrence']."-".$invoice_new,
                                    				"LineAmountTypes" => "Exclusive",
                                    				"LineItems"=>  $line_items1                               					
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
                    		$contact_result = $this->xero->Contacts($new_contact);
                    		
                        	$invoice_result = $this->xero->Invoices($new_invoice);
                        	
                         	$xero_invoice_id = $invoice_result['Invoices']['Invoice']['InvoiceID'];
                        	
                        	$partispp=array('xero_invoice_id' => $xero_invoice_id);
                            $wherepp = array('id' => $invoice_new);
                            $this->mod_common->update_table('project_supplier_invoices', $wherepp, $partispp);
                            
                    		}
                        }
                        
                $this->session->set_flashdata('ok_message', 'Supplier Invoice added succesfully');
                redirect(SURL.'supplier_invoices/viewinvoice/'.$invoice_new);
            }
        
    	}
    }
    
     //Get All Completed Job Supplier Invoices
    public function get_completed_job_supplier_invoices() {
        $this->mod_common->is_company_page_accessible(19);
        $data['supplier_invoices'] = $this->mod_project->get_all_supplier_invoices(3);
        $this->load->view('supplier_invoices/manage_supplier_invoices_ajax', $data);
    }
    
     //View Supplier Invoice
    public function viewinvoice($invoice_id) {
        
        $data['error'] = array();
        
        $data['var_number'] = $this->mod_variation->lastinsertedvariationid();
        
        $where = array('stage_status' => 1, 'company_id' => $this->session->userdata('company_id'));
        $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $where, "stage_id");
        
        $where = array('supplier_status' => 1, 'company_id' => $this->session->userdata('company_id'));
        $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $where, "supplier_id");

        $data['sinvoice_detail'] = $this->mod_project->get_sinvoice_detail_by_id($invoice_id);
        
        if(!($data['sinvoice_detail'])){
            $this->session->set_flashdata('err_message', 'Sorry! Supplier Invoice does not exist.');
            redirect(SURL."supplier_invoices");
        }
        
        $ordersinsuin= $this->mod_project->getorderinsuin($invoice_id);

        $supplier_id=$data['sinvoice_detail']->supplier_id;
        
        $costing_id=$data['sinvoice_detail']->project_id;
        
        $allowance_query = $this->db->query("SELECT costing_part_name, costing_part_id, line_margin FROM project_costing_parts WHERE costing_id='".$costing_id."' AND client_allowance=1 AND costing_part_id NOT IN (SELECT type_id FROM project_sales_invoices_items)");
        
        $data['allowances'] = $allowance_query->result_array();
        
        foreach ($ordersinsuin as $key => $val){
            $data['sinvoiceorders'][$key]['id']= $val['order_pc_id'];
            $data['sinvoiceorders'][$key]['sinvoice_items_po']= $this->mod_project->get_sinvoice_items_by_sinvoice_id($invoice_id,'po',$val['order_pc_id']);

            $vr=$this->mod_project->get_sinvoicenipo_items_by_sinvoice_id($invoice_id,'po',$val['order_pc_id']);

            if(count($vr)){
                $counterkey=count($data['sinvoiceorders'][$key]['sinvoice_items_po']);
                foreach ($vr as $kett => $vatt) {
                    $data['sinvoiceorders'][$key]['sinvoice_items_po'][$counterkey]=$vatt;
                    $counterkey++;
                }
            }

            foreach ($data['sinvoiceorders'][$key]['sinvoice_items_po'] as $kett => $vatt) {


                if ($vatt['costing_part_id'] != 0)
                    $supplier_invoiceqi = $this->mod_project->get_siuiq_by_pocpid($val['order_pc_id'], $vatt['costing_part_id']);
                else
                    $supplier_invoiceqi = $this->mod_project->get_siuiq_by_poid($val['order_pc_id'], $vatt['srno']);

                $supplier_invoiceq = $supplier_invoiceqi[0]['uninvoicedquantity'];
                if ($supplier_invoiceq == NULL)
                    $supplier_invoiceq = $vatt['order_quantity'];

                $supplier_invoiceq = ($supplier_invoiceq>0)? $supplier_invoiceq: 0 ;
                $data['sinvoiceorders'][$key]['sinvoice_items_po'][$kett]['uninvoicedquantity'] = $supplier_invoiceq;
                $tib=$vatt['line_margin'] - $supplier_invoiceqi[0]['invoice_amount'];
                $data['sinvoiceorders'][$key]['sinvoice_items_po'][$kett]['uninvoicebudget'] = ($tib>0)? $tib: 0 ;


                if ($data['sinvoice_detail']->status == 'Pending') {
                    
                    if (($supplier_invoiceq+$vatt['quantity']) < $vatt['quantity'] && $supplier_invoiceq!=0) {
                        array_push($data['error'] , 'You should not approve this Supplier Invoice, Supplier invoice quantity is greater than project part uninvoiced costing quantity for an item (part name: '.$vatt['part_field'].' ) in Supplier invoice ');

                    }
                }
            }

        }

        $data['sinvoice_items_pc'] = $this->mod_project->get_sinvoice_items_by_sinvoice_id($invoice_id,'pc');
        
        $selected_suppliers = "";
        
        
        foreach ($data['sinvoice_items_pc'] as $key => $value) {
            $selected_suppliers .=$value["supplier_id"].",";
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
            if(count($variation)>0){
            $data['sinvoice_items_pc'][$key]['var_number'] = $variation[0]['var_number'];
            }
            $data['sinvoice_items_pc'][$key]['invoicedquantity'] = $supplier_invoiceq;
            $data['sinvoice_items_pc'][$key]['uninvoicedquantity'] = $data['sinvoice_items_pc'][$key]['costing_quantity'] - $supplier_invoiceq;
            $data['sinvoice_items_pc'][$key]['uninvoicebudget']= ($data['sinvoice_items_pc'][$key]['costing_quantity'] )*($data['sinvoice_items_pc'][$key]['costing_uc'])*(100+$data['sinvoice_items_pc'][$key]['margin'])/100 - $supplier_invoiceq;
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


        $data['sinvoice_items_ni'] = $this->mod_project->get_sinvoice_items_by_sinvoice_id($invoice_id,'ni');
        
        foreach($data['sinvoice_items_ni'] as $ni_item){
            $selected_suppliers .=$ni_item["supplier_id"].",";
        }
        
        $selected_suppliers = rtrim($selected_suppliers, ",");
        if($selected_suppliers!=""){
            $cwhere = "company_id =".$this->session->userdata('company_id')." AND component_status = 1 AND supplier_id IN (".$selected_suppliers.")";
        }
        else{
           $cwhere = "company_id =".$this->session->userdata('company_id')." AND component_status = 1";  
        }
        $data['components'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");


        $project_id = $this->mod_project->get_project_id_from_costing_id($data['sinvoice_detail']->project_id);

        $data['projectinfo'] = $this->mod_project->get_project_info($project_id['project_id']);

        $cwhere = array('supplier_id' => $data['sinvoice_detail']->supplier_id);
        $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $cwhere);
 
        $this->stencil->title('Supplier Invoice Details');
	    $this->stencil->paint('supplier_invoices/view_supplier_invoice', $data);
        

    }
    
    //Update Supplier Invoice Status
    public function changedsuplierinvoicestatus($si_id) {
        $status = isset($_POST['supplierinvoicestatus']) ? $_POST['supplierinvoicestatus'] : 'Pending';

        $invoice_date = $this->input->post('invoicedate');
        $invoice_due_date = $this->input->post('invoiceduedate');
        
        $si_status = $this->mod_project->updatesistatus($si_id,$status,$invoice_date,$invoice_due_date);

        if ($si_status){
            $this->session->set_flashdata('ok_message', 'Supplier invoice status updated succefully.');
        } else {
            $this->session->set_flashdata('err_message', 'Supplier invoice status not updated.');
        }
        redirect(base_url() . 'supplierinvoice/viewinvoice/' . $si_id);
    }

    //Export as CSV
    public function exportascsv($sinvoice_id=0){

        $cwhere = array('supplier_invoice_id' => $sinvoice_id );

        $supplier_invoice_item = $this->mod_project->get_allsinvoice_items_by_sinvoice_id($sinvoice_id);
        
        if(count($supplier_invoice_item)>0){

        if($sinvoice_id!=0)
            $v=$dsinvoice_detail = $this->mod_project->get_sinvoice_detail_by_id($sinvoice_id);

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

        foreach ($supplier_invoice_item AS $k => $p) {
            if($sinvoice_id==0)
                $v=$dsinvoice_detail = $this->mod_project->get_sinvoice_detail_by_id($p['supplier_invoice_id']);
            $inv_arr[$i]['customer_name'] =  $p['supplier_name'];
            $inv_arr[$i]['EmailAddress'] =   $p['supplier_email'];
            $inv_arr[$i]['POAddressLine1'] = $p['street_pobox'];
            $inv_arr[$i]['POAddressLine2'] = $p['street_pobox'];
            $inv_arr[$i]['POAddressLine3'] = $p['street_pobox'];
            $inv_arr[$i]['POAddressLine4'] = $p['street_pobox'];
            $inv_arr[$i]['POCity'] = $p['supplier_city'];
            $inv_arr[$i]['PORegion'] = "";
            $inv_arr[$i]['POPostalCode'] = $p['supplier_postal_zip'];
            $inv_arr[$i]['POCountry'] = $p['supplier_country'];
            $inv_arr[$i]['InvoiceNumber'] = $p['supplier_invoice_id'];
            $inv_arr[$i]['Reference'] = $v->supplierrefrence;
            $inv_arr[$i]['InvoiceDate'] = $v->created_date;
            $inv_arr[$i]['DueDate'] = $v->created_date;
            $inv_arr[$i]['Total'] = '';
            $inv_arr[$i]['InventoryItemCode'] = $p['id'];
            $inv_arr[$i]['Description'] = $p['part_field'];
            $inv_arr[$i]['Quantity'] = $p['quantity'];
            $inv_arr[$i]['UnitAmount'] = $p['invoice_amount']/ $p['quantity'];
            $inv_arr[$i]['Discount'] = 0;
            $inv_arr[$i]['AccountCode'] = "";
            $inv_arr[$i]['TaxType'] = "";
            $inv_arr[$i]['TaxAmount'] = 0;
            $inv_arr[$i]['TrackingName1'] = "Stage";
            $inv_arr[$i]['TrackingOption1'] = $p['stage_name'];
            $inv_arr[$i]['TrackingName2'] = "Component";
            $inv_arr[$i]['TrackingOption2'] = $p['component_name'];
            $inv_arr[$i]['Currency'] = "USD";
            $inv_arr[$i]['BrandingTheme'] = "";

            $i++;
        }

        $output = fopen("php://output", 'w') or die("Can't open php://output");
        header("Content-Type:application/csv");
        header("Content-Disposition:attachment;filename=SupplierInvoices.csv");
        foreach ($inv_arr as $product) {
            fputcsv($output, $product);
        }
        fclose($output) or die("Can't close php://output");

        exit;
        }
        else{
            $this->session->set_flashdata('err_message', 'No Supplier Invoices Found');
            redirect(SURL.'supplier_invoices');
        }

    }
    
    //Update Supplier Invoice Status
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
                'status' => $status,
                'va_status' => $status
            );
        $this->mod_common->update_table('project_supplier_invoices', $where, $order_purchase);
        if($status=="Approved"){
            
            $where 	= array('id' => $id);
		    $invoice_info = $this->mod_common->select_single_records('project_supplier_invoices', $where);
		   
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
		    
            $tracking_options =  array("Name" => $project_info["project_title"]);
            
            if(count($xero_credentials)>0){  
               $tracking_name = $xero_credentials["tracking_category_name"];
               $tracking_options_result = $this->xero->TrackingCategories($tracking_options);
             }
            
            $new_line_items =array();
            $iteration=0;
            
            
            $where = array('supplier_invoice_id' => $id);
		    $invoice_items = $this->mod_common->get_all_records('project_supplier_invoices_items', "*", 0, 0, $where);
		    foreach($invoice_items as $invoice_item){
            $where = array('component_id' => $invoice_item->component_id);
		    $component_info = $this->mod_common->select_single_records('project_components', $where);
            if($invoice_item->quantity>0){
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
                    $invoice_due_date = explode("/", $invoice_info["nvoice_due_date"]);
                    $invoice_due_date = $invoice_due_date[2]."-".$invoice_due_date[1]."-".$invoice_due_date[0];      
		               
		            $where 			= array('supplier_id' => $invoice_info["supplier_id"]);
		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
		            
                       $new_invoice = array( "Invoices" => array(
                                			array(
                                				"Type"=>"ACCPAY",
                                				"Contact" => array(
                                					"Name" => $supplier_info["supplier_name"]
                                				),
                                				"Date" => $invoice_date,
                                				"DueDate" => $invoice_due_date,
                                				"Status" => "AUTHORISED",
                                				"InvoiceNumber" => 	$invoice_info["supplierrefrence"]."-".$id, 
                                				"Reference" => 	$invoice_info["supplierrefrence"]."-".$id,
                                				"LineAmountTypes" => "Exclusive",
                                				"LineItems"=> $new_line_items
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
                		
                    	$invoice_result = $this->xero->Invoices($new_invoice);
                    	
                    	$xero_invoice_id = $invoice_result['Invoices']['Invoice']['InvoiceID'];
                    	
                    	$partispp=array('xero_invoice_id' => $xero_invoice_id);
                        $wherepp = array('id' => $id);
                        $this->mod_common->update_table('project_supplier_invoices', $wherepp, $partispp);
                		}
		    
		    
        }
        
        $data['sinvoice_detail_status'] = $status;
        $data['order_id'] = $id;
        $html = $this->load->view('supplier_invoices/status_ajax.php', $data, true);
        echo $html;
    }
    
    //Update Component Unit Cost
    function update_component_unit_cost(){
        $id=$this->input->post('component_id');
        $unit_cost=$this->input->post('unit_cost');
        $where= array(

                'component_id' => $id

            );
       $update_array = array(

                'component_uc' => $unit_cost

            );
        $this->mod_common->update_table('project_components', $where, $update_array);
        
        $template_update_array = array(
            'tpl_part_component_uc' => $unit_cost
        );
        
        $this->mod_common->update_table('project_tpl_component_part', $where, $template_update_array);
        
        echo "s";
    }
    
    //Update Variation Details
    function variation_update_ajax(){
        
        $id = $this->input->post('id');
        
        $type = $this->input->post('type');
        
        $va_total = $this->input->post('var_total');
        $va_round = $this->input->post('var_round');
        
        $var_number = $this->input->post('var_number');
        $column_name = $this->input->post('column_name');
        $column_value = $this->input->post('column_value');
        $where = array('var_number'=>$var_number);
        $cwhere = array('var_number'=>$var_number, $column_name=>$column_value);
        $is_updated = $this->mod_common->select_single_records('project_variations', $cwhere);
        if(count($is_updated)==0){
            $vdata = array(
                $column_name => $column_value
            );
            $update_variations = $this->mod_common->update_table('project_variations', $where, $vdata);
            
            if($type=="invoice"){
            
            $where = array('id'=>$id);
            
            if($column_name=="variation_description"){
                 $vdata = array(
                  "va_description" => $column_value
                );
                $this->mod_common->update_table('project_supplier_invoices', $where, $vdata);
            }
            
           $sidata = array(
                "va_total" => $va_total,
                "va_round" => $va_round,
            );
            
            
            $this->mod_common->update_table('project_supplier_invoices', $where, $sidata);
            }
            else{
                 $where = array('id'=>$id);
        
            
              $sidata = array(
                "project_contract_price" => $va_total,
                "project_price_rounding" => $va_round,
            );
            
            
            $this->mod_common->update_table('project_variations', $where, $sidata);
                
            }
            
            if($update_variations){
                echo "s";
            }
        }
        else{
             if($type=="invoice"){
            
            $where = array('id'=>$id);
            
            if($column_name=="variation_description"){
                 $vdata = array(
                  "va_description" => $column_value
                );
                $this->mod_common->update_table('project_supplier_invoices', $where, $vdata);
            }
            
           $sidata = array(
                "va_total" => $va_total,
                "va_round" => $va_round,
            );
            
            
            $this->mod_common->update_table('project_supplier_invoices', $where, $sidata);
            }
            else{
                 $where = array('id'=>$id);
        
            
              $sidata = array(
                "project_contract_price" => $va_total,
                "project_price_rounding" => $va_round,
            );
            
            
            $this->mod_common->update_table('project_variations', $where, $sidata);
                
            }
            
            echo "s";
            
        }
    }
    
    //Repopulate All Available Components
    public function repopulate_all_available_components() {
        
        $returnhtml='';
        
        $data['selected_costing_id'] = $this->input->post('costingId');
        
        $supplier_invoice_id = $this->input->post('supplier_invoice_id');
        
        $data['last_row'] = $this->input->post('last_row');
        
        if($this->input->post('supplier_id')!="" && $this->input->post('stage_id')==""){
        $data['selected_supplier_id'] = join(', ', $this->input->post('supplier_id'));
        $cwhere = "costing_id = ".$data['selected_costing_id']." AND costing_supplier IN (".$data['selected_supplier_id'].") AND costing_type!='sivar' AND client_allowance = 0 AND costing_part_id NOT IN (SELECT costing_part_id FROM supplier_invoices_items WHERE supplier_invoice_id = $supplier_invoice_id)";
        }
        else if($this->input->post('stage_id')!="" && $this->input->post('supplier_id')==""){
        $data['selected_stage_id'] = join(', ', $this->input->post('stage_id'));
        $cwhere = "costing_id = ".$data['selected_costing_id']." AND stage_id IN (".$data['selected_stage_id'].") AND costing_type!='sivar' AND client_allowance = 0 AND costing_part_id NOT IN (SELECT costing_part_id FROM supplier_invoices_items WHERE supplier_invoice_id = $supplier_invoice_id)";
        }
        else if($this->input->post('supplier_id')!="" && $this->input->post('stage_id')!=""){
        $data['selected_stage_id'] = join(', ', $this->input->post('stage_id'));
        $data['selected_supplier_id'] = join(', ', $this->input->post('supplier_id'));
        $cwhere = "costing_id = ".$data['selected_costing_id']." AND stage_id IN (".$data['selected_stage_id'].") AND costing_supplier IN (".$data['selected_supplier_id'].") AND costing_type!='sivar' AND client_allowance = 0 AND costing_part_id NOT IN (SELECT costing_part_id FROM supplier_invoices_items WHERE supplier_invoice_id = $supplier_invoice_id)";
        }
        else{
            $data['selected_supplier_id'] = "";
            $cwhere = "costing_id = ".$data['selected_costing_id']." AND costing_type!='sivar' AND client_allowance = 0 AND costing_part_id NOT IN (SELECT costing_part_id FROM supplier_invoices_items WHERE supplier_invoice_id = $supplier_invoice_id)"; 
        }
        
        $fields = '`costing_part_id`, `stage_id`, `costing_quantity`,`costing_tpe_id`,`client_allowance`,`costing_supplier`';
        $costing_parts = $this->mod_common->get_all_records('project_costing_parts', $fields, 0, 0, $cwhere, "costing_id");
        $pc_ids= array();
        
        
        foreach ($costing_parts as $k => $v) {

            $ordered_quantity=$this->mod_project->get_order_quantity_by_costingpartid($v["costing_part_id"]);
            $ordered_quantity = $ordered_quantity[0]['total_ordered'];
            
            $supplier_invoiceqi = $this->mod_project->get_siuiq_by_pccpid($v["costing_part_id"]);
          
            $supplier_invoiceq = $supplier_invoiceqi[0]['invoicedquantity'];
            $updated_quantity = get_recent_quantity($v["costing_part_id"], $v["costing_supplier"]);
            
            $uninvoicedquantity = $v["costing_quantity"]-$supplier_invoiceq;
           
            if(($uninvoicedquantity>0 && $v["client_allowance"]==0) || ($v["client_allowance"]==1)){
                array_push($pc_ids, $v["costing_part_id"]);
            }
        }
        
        if(count($pc_ids) > 0){
         
            $where = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
            $data['component'] = $this->mod_common->select_single_records('project_components', "*", 0, 0, $where, "component_id");
            
            $where = array('stage_status' => 1, 'company_id' => $this->session->userdata('company_id'));
            $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $where, "stage_id");
        
            $where = array('supplier_status' => 1, 'company_id' => $this->session->userdata('company_id'));
            $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $where, "supplier_id");
            
            $prject_id=$this->mod_project->get_project_id_from_costing_id($this->input->post('value'));
            $data['projectname'] = $this->mod_project->get_project_by_name($prject_id['project_id']);
           
            $i=1;
            $j=$data["last_row"];
            foreach ($pc_ids as $kepc => $pc_id) {
                $data['no_of_rows']=count($pc_ids);
                if ($pc_id == 0) {
                    echo "Some thing is not right. Please refresh";
                }
                else {

                    $data['costing_part_details'] = $this->mod_project->get_costing_part_info_by_id($pc_id);
                    
                    if(isset($_POST['pccc'])){
                        if(in_array($data['costing_part_details']->costing_part_id, $_POST['pccc']) ) {unset($pc_ids[$kepc]); continue; }
                    }
                    

                    $ordered_quantity = $this->mod_project->get_order_quantity_by_costingpartid($data['costing_part_details']->costing_part_id);
                    $data['ordered_quantity'] = $ordered_quantity = $ordered_quantity[0]['total_ordered'];
                    

                    $variation = $this->mod_project->getupdatedquantitybycostingpartid($data['costing_part_details']->costing_part_id);
                    
                    $supplier_invoiceqi = $this->mod_project->get_siuiq_by_pccpid($data['costing_part_details']->costing_part_id);
                    
                    $supplier_invoiceq = number_format($supplier_invoiceqi[0]['invoicedquantity'], 2, '.', '');
                    $data['costing_part_details']->var_number = $variation[0]['var_number'];
                    $data['costing_part_details']->invoicedquantity = $supplier_invoiceq;
                    $data['costing_part_details']->uninvoicedquantity = $data['costing_part_details']->costing_quantity-$supplier_invoiceq;
                    $data['costing_part_details']->uninvoicebudget= ($data['costing_part_details']->costing_quantity)*($data['costing_part_details']->costing_uc)*(100+$data['costing_part_details']->margin)/100 - $supplier_invoiceqi[0]['invoiced_amount'];
                    if($data['costing_part_details']->uninvoicedquantity<0)
                        $data['costing_part_details']->uninvoicedquantity = 0;
                    if($data['costing_part_details']->uninvoicebudget<0)
                    $data['costing_part_details']->uninvoicebudget = 0;
                    $data['i']=$i;
                    $j++;
                    $data['j'] = $j;
                    $html = $this->load->view('supplier_invoices/repopulate_project_costing', $data, true);
                        $returnhtml.=$html;
                }
                $i++;
            }
            $populatestage = count($pc_ids);
        }
        else{
            $populatestage=0;
        }
        $returnarr = array( 'returnhtml' => $returnhtml,
            'populatestage' => $populatestage);

        echo json_encode($returnarr);
    }
    
    //Update Supplier Invoice
    public function updateinvoice($invoice_id) {
        
        $xero_credentials = get_xero_credentials();
        
        $where = array('supplier_invoice_id' => $invoice_id);
		$check_purchase_order = $this->mod_common->select_single_records('project_purchase_orders', $where);
        $porders = $check_purchase_order["id"];

        $vId=0;
        $existingsipart = $this->mod_project->get_siparts_ids_by_si_id($invoice_id);

        $existingsipartarr = array();
        foreach ($existingsipart as $key => $value) {
            array_push($existingsipartarr,$value['id'] );
        }
        $invoice_new_arr = array(
            'project_id' => $_POST['project_id'],
            'supplier_id' => $_POST['first_selected_supplier'],
            'invoice_date' => $this->input->post('invoicedate'),
            'invoice_due_date' => $this->input->post('invoiceduedate'),
            'supplierrefrence' => $_POST['supplierrefrence'],
            'status' => $this->input->post('supplierinvoicestatus'),
            'invoice_amount' => $this->input->post('invoiceamountist'),
            'create_variation' => (($this->input->post('createvariation'))?$this->input->post('createvariation'):0),
            'va_addsi_cost' => !is_numeric($this->input->post('totaladd_cost'))?0:$this->input->post('totaladd_cost') ,
            'va_addclient_cost' => !is_numeric($this->input->post('totaladdclient_cost'))?0:$this->input->post('totaladdclient_cost') ,
            'va_description' => $this->input->post('varidescriptioin'),
            'va_ohm' => $this->input->post('overhead_margin') ,
            'va_pm' => $this->input->post('profit_margin'),
            'va_status' => $this->input->post('supplierinvoicevarstatus'),
            'va_total' => $this->input->post('contract_price'),
            'va_tax' => $this->input->post('costing_tax'),
            'va_round' => $this->input->post('price_rounding'),
        );
        $where = array('id' =>$invoice_id );
        $this->mod_common->update_table('supplier_invoices', $where, $invoice_new_arr);
        $invoice_new = $invoice_id;
        $ppid=$this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
        
        if ($invoice_new) {
           
               $cid=$this->mod_project->get_project_id_from_costing_id($_POST['project_id']);
               
               $where 	= array('project_id' => $cid['project_id']);
		       $project_tax = $this->mod_common->select_single_records('project_costing', $where);
		       
		       $where 			= array('project_id' => $cid['project_id']);
		       $project_info = $this->mod_common->select_single_records('project_projects', $where);
		        
		       if($this->input->post('supplierinvoicestatus')=='Approved'){
		       
                    
                    $tracking_options =  array( 
                    			                 "Name" => $project_info["project_title"]
                    			              );
                    if(count($xero_credentials)>0){
                        $tracking_name = $xero_credentials["tracking_category_name"];
                        $tracking_options_result = $this->xero->TrackingCategories($tracking_options);
                    }
                
		       }
		        $variation_name_info = 'Variation form supplier Invoice # '.$invoice_new;
                $where 			= array('var_number' => $this->input->post('var_number'), 'variation_name' => $variation_name_info);
		        $check_variation = $this->mod_common->select_single_records('project_variations', $where);
		        
                if(($this->input->post('createvariation'))== 1 && ($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending')){
                    if(count($check_variation)==0){
                         $var_number = $this->mod_variation->lastinsertedvariationid();
                         $var_number = $var_number + 10000000;
                        $vdata = array(
                            'created_by' => $this->session->userdata('user_id'),
                            'company_id' => $this->session->userdata('company_id'),
                            'variation_name' => 'Variation form supplier Invoice # '.$invoice_new,
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
                            'status' => $_POST['supplierinvoicevarstatus'],
                            'var_type' => 'suppinvo',
                            'var_type_id' => $invoice_new
                        );
                        $insert_variations = $this->mod_common->insert_into_table('project_variations', $vdata);
                        $vId = $insert_variations;
    
                        $partispp=array('var_number' => $insert_variations+10000000 );
                        $wherepp = array('id' => $insert_variations);
                        $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                        
                         $this->mod_common->update_table('supplier_invoices', array('id'=>$invoice_new ), array('var_number'=> $insert_variations+10000000, 'create_variation'=>1));
                    }
                    else{
                        $where 			= array('var_number' => $this->input->post('var_number'));
                        $vdata = array(
                            'variation_name' => 'Variation form supplier Invoice # '.$invoice_new,
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
                            'status' => $_POST['supplierinvoicevarstatus']
                        );
                        $this->mod_common->update_table('project_variations', $where, $vdata);
                    }
                }

            if (isset($_POST['order_id_po'])) {
                $order_id_po = $_POST['order_id_po'];

                foreach ($order_id_po as $key => $value) {
                    $posi_item_id= $_POST['posi_item_id' . $value];
                    $pocosting_part_id = $_POST['pocosting_part_id' . $value];
                    $poinvoicequantity = $_POST['poinvoicequantity' . $value];
                    $poinvoicebudget = $_POST['poinvoicebudget' . $value];
                    $poinvoicecostdiff = $_POST['poinvoicecostdiff' . $value];
                    $pocomponent = $_POST['pocomponent' . $value];
                    $postage= $_POST['postage'.$value];
                    $popart = $_POST['popart'.$value];
                    $srno = $_POST['posrno'.$value];
                    foreach ($pocosting_part_id as $ke => $va) {
                        if($poinvoicequantity[$ke]>0){
                        $invoice = array(
                            'supplier_invoice_id' => $invoice_new,
                            'order_pc_id' => $value,
                            'supplier_id' => $_POST['supplier_id'],
                            'supplier_invoice_item_type' => 'po',
                            'costing_part_id' => $va,
                            'component_id' => $pocomponent[$ke],
                            'quantity' => $poinvoicequantity[$ke],
                            'invoice_amount' => $poinvoicebudget[$ke],
                            'cost_diff' => $poinvoicecostdiff[$ke],
                            'stage_id' => $postage[$ke],
                            'part_field' => $popart[$ke],
                            'srno' => $srno[$ke]
                        );

                        if($posi_item_id[$ke]){
                            $this->mod_common->update_table('project_supplier_invoices_items', array('id'=>$posi_item_id[$ke]), $invoice);
                            $invoicedone=$posi_item_id[$ke];
                            $existingsipartarr = array_diff($existingsipartarr, array($invoicedone));

                        }
                        else{
                            $invoicedone = $this->mod_common->insert_into_table('project_supplier_invoices_items', $invoice);

                        }

                    }
                    }
                }
            }
            $line_items =array();
            $contact_suppliers = array();
            $selected_suppliers_name = "";
            $i=0;
            $j=0;
             
            if (isset($_POST['project_cost_partpc'])) {
                
                $project_cost_partpc = array_values($_POST['project_cost_partpc']);
                $original_quantity = array_values($_POST['original_quantity']);
                $pcuninvoicequantity = array_values($_POST['uninvoicequantity']);
                $pcinvoicequantity = array_values($_POST['pcinvoicequantity']);
                $pcinvoicebudget = array_values($_POST['pcinvoicebudget']);
                $pcinvoicecostdiff = array_values($_POST['pcinvoicecostdiff']);
                $pccomponent = array_values($_POST['pccomponent']);
                $pcstage= array_values($_POST['pcstage']);
                $pcpart = array_values($_POST['pcpart']);
                $pcuom = array_values($_POST['pcuom']);
                $pcucost = array_values($_POST['pcucost']);
                $pclinttotal = array_values($_POST['pclinttotal']);
                $pcmargin = array_values($_POST['pcmargin']);
                $pcmargintotal = array_values($_POST['pcmargintotal']);
                $pcsi_item_id = array_values($_POST['pcsi_item_id']);
                $pcsi_item_id = array_values($_POST['pcsi_item_id']); 
                $supplierorderquantity = array_values($_POST['supplierorderqty']);
                $pcorderquantity = array_values($_POST['pcorderqty']);
                $pcinvoicetype = array_values($_POST['pcinvoicetype']);
                $pcsupplier_id = array_values($_POST['pcsupplier_id']);
                
                foreach ($project_cost_partpc as $key => $value) {
                    
                   
                   $ordered_quantity2 = $this->mod_project->get_order_quantity_by_costingpartid($value);
                    $supplier_ordered_quantity = get_supplier_ordered_quantity($value);
                   if($pcinvoicequantity[$key]>0){
                    if(($supplier_ordered_quantity+$pcinvoicequantity[$key])>$ordered_quantity2[0]['total_ordered']){
                   
                    $pctotalunorderquantity  = ($supplier_ordered_quantity+$pcinvoicequantity[$key])-$ordered_quantity2[0]['total_ordered'];
                    }
                    else{
                        $pctotalunorderquantity  = 0;
                    }
                    
                    $allowance_cost = number_format($pcinvoicebudget[$key] - ($pcucost[$key]*$pcinvoicequantity[$key]), 2, '.', '');
                   
                    $invoice = array(
                        'supplier_invoice_id' => $invoice_new,
                        'order_pc_id' => $value,
                        'supplier_id' => $pcsupplier_id[$key],
                        'supplier_invoice_item_type' => 'pc',
                        'costing_part_id' => $value,
                        'quantity' => $pcinvoicequantity[$key],
                        'component_id' => $pccomponent[$key],
                        'invoice_amount' => $pcinvoicebudget[$key],
                        'cost_diff' => ($pcinvoicecostdiff[$key]=="allowance")?$allowance_cost:$pcinvoicecostdiff[$key],
                        'stage_id' => $pcstage[$key],
                        'part_field' => $pcpart[$key],
                    );                    
                    
                    if($this->input->post('supplierinvoicestatus')=='Approved'){
                        $order_purchase = array(
                            'project_id' =>  $ppid['project_id'],
                            'supplier_id' =>  $this->input->post('first_selected_supplier'),
                            'stage_id' => $pcstage[$key],
                            'costing_id' => $_POST['project_id'],
                            'order_date' => date('Y-m-d G:i:s'),
                            'order_by' => $this->session->userdata('user_id'),
                            'company_id' => $this->session->userdata('company_id'),
                            'created_date' => date('Y-m-d G:i:s'),
                            'supplier_invoice_id' =>     $invoice_new,
                            'order_status' => 'Issued'
                        );
                    }
                    else{
                         $order_purchase = array(
                            'project_id' =>  $ppid['project_id'],
                            'supplier_id' =>  $this->input->post('first_selected_supplier'),
                            'stage_id' => $pcstage[$key],
                            'costing_id' => $_POST['project_id'],
                            'order_date' => date('Y-m-d G:i:s'),
                            'order_by' => $this->session->userdata('user_id'),
                            'company_id' => $this->session->userdata('company_id'),
                            'created_date' => date('Y-m-d G:i:s'),
                            'supplier_invoice_id' =>     $invoice_new,
                            'order_status' => 'Issued'
                        );
                    }

                    if($pcsi_item_id[$key]){
                        $this->mod_common->update_table('project_supplier_invoices_items', array('id'=>$pcsi_item_id[$key]), $invoice);
                        $invoicedone=$pcsi_item_id[$key];
                        $existingsipartarr = array_diff($existingsipartarr, array($invoicedone));
                    }
                    else{
                        $invoicedone = $this->mod_common->insert_into_table('project_supplier_invoices_items', $invoice);
                    }

                    if(($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending') && $pcinvoicetype[$key]=="pc"){
                       
                        // new check added by akhtar only when purchase order exist.
                        $where 			= array('part_name' => $pcpart[$key], 'component_id' => $pccomponent[$key], 'costing_part_id' =>   $value, 'purchase_order_id' => $porders);
		                $check_purchase_items = $this->mod_common->select_single_records('project_purchase_order_items', $where);
                        //$porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);

                        if(count($check_purchase_items)>0){
                            $order_quantity = $check_purchase_items["order_quantity"];
                            $this->mod_common->update_table('project_purchase_orders', array("id"=>$porders), $order_purchase);
                        }else{
                             $order_quantity = 0;
                             $porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);
                        }
                    
                        $invoiced_quantity = $pcinvoicequantity[$key] - $order_quantity;
                      if($pcuninvoicequantity[$key]>0){
                         if($pcinvoicecostdiff[$key]==0){
                            $new_costing_uc = $pcinvoicebudget[$key];
                            $new_line_cost = $pcinvoicebudget[$key]*$pcinvoicequantity[$key];
                        }
                        else{
                            $new_costing_uc = $pcinvoicebudget[$key]/$pcuninvoicequantity[$key];
                            $new_line_cost = ($pcinvoicebudget[$key]/$pcuninvoicequantity[$key])*$pcinvoicequantity[$key];
                        }
                        if(count($check_purchase_items)==0){
                            $part = array(
                                'purchase_order_id' => $porders,
                                'part_name' => $pcpart[$key],
                                'component_id' => $pccomponent[$key],
                                'supplier_id' => $pcsupplier_id[$key],
                                'costing_part_id' =>   $value,
                                'order_quantity' => $pcinvoicequantity[$key],//$pcinvoicequantity[$key],
                                'stage_id' => $pcstage[$key],
                                'costing_uom' => $pcuom[$key],
                                'costing_uc' => $pcucost[$key],
                                'line_cost' => $pcinvoicebudget[$key],
                                'margin' => $pcmargin[$key],
                                'line_margin' => $pcinvoicebudget[$key]
                            );
    
                            $parts = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                        }
                        else{
                            $where 			= array('id' => $check_purchase_items["id"]);
                            $part = array(
                                'part_name' => $pcpart[$key],
                                'component_id' => $pccomponent[$key],
                                'supplier_id' => $pcsupplier_id[$key],
                                'costing_part_id' =>   $value,
                                'order_quantity' => $pcinvoicequantity[$key],
                                'stage_id' => $pcstage[$key],
                                'costing_uom' => $pcuom[$key],
                                'costing_uc' => $pcucost[$key],
                                'line_cost' => $pcinvoicebudget[$key],
                                'margin' => $pcmargin[$key],
                                'line_margin' => $pcinvoicebudget[$key]
                            );
    
                            $parts = $this->mod_common->update_table('project_purchase_order_items', $where, $part);
                        }
                    }
                   

                    }

                   if(($this->input->post('createvariation'))== 1 &&  ($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending')){
                        
                         $where = array('variation_id' => $check_variation["id"], 'stage_id' =>$pcstage[$key], 'project_id' => $cid['project_id'], 'component_id' => $pccomponent[$key]);
		                 $check_variation_parts = $this->mod_common->select_single_records('project_variation_parts', $where);
                        
                        if ($vId > 0 && $pcinvoicecostdiff[$key]!="allowance") {

                            $part = array(
                                'variation_id' => $insert_variations,
                                'stage_id' => $pcstage[$key],
                                'costing_part_id' => $value,
                                'project_id' => $cid['project_id'],
                                'component_id' => $pccomponent[$key],
                                'part_name' => $pcpart[$key],
                                'component_uom' => $pcuom[$key],
                                'linetotal' => $pclinttotal[$key],
                                'component_uc' => $pcucost[$key],
                                'supplier_id' => $pcsupplier_id[$key],
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

                            $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);

                        }
                        
                        else if (count($check_variation_parts)==0 && $pcinvoicecostdiff[$key]!="allowance") {

                            $part = array(
                                'variation_id' => $check_variation["id"],
                                'stage_id' => $pcstage[$key],
                                'costing_part_id' => $value,
                                'project_id' => $cid['project_id'],
                                'component_id' => $pccomponent[$key],
                                'part_name' => $pcpart[$key],
                                'component_uom' => $pcuom[$key],
                                'linetotal' => $pclinttotal[$key],
                                'component_uc' => $pcucost[$key],
                                'supplier_id' => $pcsupplier_id[$key],
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

                            $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);

                        }
                        
                        else{
                            if($pcinvoicecostdiff[$key]!="allowance"){
                            $where 	= array('id' => $check_variation_parts["id"]);
                            $part = array(
                                'stage_id' => $pcstage[$key],
                                'costing_part_id' => $value,
                                'project_id' => $cid['project_id'],
                                'component_id' => $pccomponent[$key],
                                'part_name' => $pcpart[$key],
                                'component_uom' => $pcuom[$key],
                                'linetotal' => $pclinttotal[$key],
                                'component_uc' => $pcucost[$key],
                                'supplier_id' => $pcsupplier_id[$key],
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
                            
                            $vpid=$vparts = $check_variation_parts["id"];
                        }

                        }
                    }
                    
                    $where = array('component_id' => $pccomponent[$key]);
		            $component_info = $this->mod_common->select_single_records('project_components' ,$where);
		            
		            $where 			= array('supplier_id' => $pcsupplier_id[$key]);
		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
                	
                	
                    if($pcinvoicequantity[$key]>0){
		            $line_items[$i]["Description"] = $component_info["component_name"];
		            $line_items[$i]["Quantity"]= $pcinvoicequantity[$key];
		            $line_items[$i]["UnitAmount"]= $pcinvoicebudget[$key]/$pcinvoicequantity[$key];
		            $line_items[$i]["LineAmount"]= $pcinvoicebudget[$key];
		            $line_items[$i]["TaxType"]= "INPUT2";
		            $line_items[$i]["TaxAmount"]= $pcinvoicebudget[$key]*($project_tax["tax_percent"]/100);
		            $line_items[$i]["AccountCode"]= "310";
		            $line_items[$i]["Tracking"][0]["Name"]= $tracking_name;
                    $line_items[$i]["Tracking"][0]["Option"]= $project_info["project_title"];
                    $i++; 
                    
                    $selected_suppliers_name .=$supplier_info["supplier_name"].", ";
                    
                    $contact_suppliers[$j]["Name"] = $supplier_info["supplier_name"];
                	$contact_suppliers[$j]["ContactNumber"] = $supplier_info["supplier_phone"];
                	$contact_suppliers[$j]["ContactPersons"] = $supplier_info["supplier_contact_person"];
                	$contact_suppliers[$j]["EmailAddress"] = $supplier_info["supplier_email"];
                	
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["AddressType"] = "POBOX";
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["AddressLine1"] = $supplier_info["post_street_pobox"];
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["City"] = $supplier_info["supplier_postal_city"];
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["PostalCode"] = $supplier_info["supplier_postal_zip"];
                	
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["AddressType"] = "STREET";
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["AddressLine1"] = $supplier_info["street_pobox"];
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["City"] = $supplier_info["supplier_city"];
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["PostalCode"] = $supplier_info["supplier_zip"];
                	
                	$j++;
                    }
                   }                 
                }              
            }

            if (isset($_POST['nicomponent'])) {

                $nicosting_part_id= array_values($_POST['nicosting_part_id']);
                $nistage = array_values($_POST['nistage']);
                $nipart = array_values($_POST['nipart']);
                $nicomponent = array_values($_POST['nicomponent']);
                $niuom = array_values($_POST['niuom']);
                $niucost = array_values($_POST['niucost']);
                $nimanualqty = array_values($_POST['nimanualqty']);
                $nilinttotal = array_values($_POST['nilinttotal']);
                $nisrno = array_values($_POST['nisrno']);
                $nisi_item_id= array_values($_POST['nisi_item_id']); 
                $niallowance = array_values($_POST['niallowance']);
                $nisupplier_id = array_values($_POST['nisupplier_id']);
                $include_in_specification = array_values($_POST['include_in_specification']);
                $client_allowance = array_values($this->input->post('client_allowance'));
                
                
                foreach ($nicomponent as $key => $value) {
                    if($nimanualqty[$key]>0){
                    if($niallowance[$key]==0){
    		               $allocated_allowance_amount = 0;
    		               $allocated_allowance_id = 0;
    		           }
    		           else{
    		              $niallowance_array = explode("|", $niallowance[$key]); 
    		              $allocated_allowance_id = $niallowance_array[0];
    		              $allocated_allowance_amount = $niallowance_array[1];
    		           }

                    $where = array('component_id' => $nicomponent[$key]);
		            $component_info = $this->mod_common->select_single_records('project_components', $where);
		            
		            $where 			= array('supplier_id' => $nisupplier_id[$key]);
		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);

                    $invoice = array(
                        'supplier_invoice_id' => $invoice_new,
                        'supplier_id' => $nisupplier_id[$key],
                        'supplier_invoice_item_type' => 'ni',
                        'quantity' => $nimanualqty[$key],
                        'invoice_amount' => $nilinttotal[$key],
                        'component_id' => $nicomponent[$key],
                        'part_field' => $nipart[$key],
                        'stage_id' => $nistage[$key],
                        'costing_part_id' => 0,
                        'ni_unit_cost' =>$niucost[$key] ,
                        'ni_uom' => $niuom[$key],
                        'srno' =>  $nisrno[$key],
                        'allocated_allowance_id' => $allocated_allowance_id,
                        'allocated_allowance_amount' => $allocated_allowance_amount,
                        'include_in_specification' =>  $include_in_specification[$key],
                        'client_allowance' =>  $client_allowance[$key]
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
                    
                    $selected_suppliers_name .=$supplier_info["supplier_name"].", ";
                    
                    $contact_suppliers[$j]["Name"] = $supplier_info["supplier_name"];
                	$contact_suppliers[$j]["ContactNumber"] = $supplier_info["supplier_phone"];
                	$contact_suppliers[$j]["ContactPersons"] = $supplier_info["supplier_contact_person"];
                	$contact_suppliers[$j]["EmailAddress"] = $supplier_info["supplier_email"];
                	
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["AddressType"] = "POBOX";
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["AddressLine1"] = $supplier_info["post_street_pobox"];
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["City"] = $supplier_info["supplier_postal_city"];
                	$contact_suppliers[$j]["Addresses"]["Address"][0]["PostalCode"] = $supplier_info["supplier_postal_zip"];
                	
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["AddressType"] = "STREET";
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["AddressLine1"] = $supplier_info["street_pobox"];
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["City"] = $supplier_info["supplier_city"];
                	$contact_suppliers[$j]["Addresses"]["Address"][1]["PostalCode"] = $supplier_info["supplier_zip"];
                	
                	$j++;
                    }
		            
		            
		            
                    if(($this->input->post('createvariation'))== 1 && ($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending')){
                        $invoice['part_field']= $nipart[$key];

                        $order_purchase = array(
                            'project_id' => $cid['project_id'],
                            'supplier_id' =>  $this->input->post('first_selected_supplier'),
                            'stage_id' => $nistage[$key],
                            'costing_id' => $_POST['project_id'],
                            'order_date' => date('Y-m-d G:i:s'),
                            'order_by' => $this->session->userdata('user_id'),
                             'company_id' => $this->session->userdata('company_id'),
                            'created_date' => date('Y-m-d G:i:s'),
                            'order_status' => 'Issued',
                            'supplier_invoice_id' =>     $invoice_new,
                        );
                    }

                    if(($this->input->post('createvariation'))== 1 &&  ($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending')){
                         $where = array('variation_id' => $check_variation["id"], 'stage_id' =>$nistage[$key], 'project_id' => $cid['project_id'], 'component_id' => $nicomponent[$key]);
		                 $check_variation_parts = $this->mod_common->select_single_records('project_variation_parts', $where);
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
                                'supplier_id' => $nisupplier_id[$key],
                                'quantity' => $nimanualqty[$key],
                                'status_part' => 1,
                                'available_quantity' => 0,
                                'costing_id' => $_POST['project_id'],
                                'change_quantity' => $nimanualqty[$key],
                                'updated_quantity' => $nimanualqty[$key],
                                'quantity_type' => 'manual',
                                'formulaqty' => '',
                                'formulatext' => '',
                                'component_variation_amount' => $nilinttotal[$key],
                                'include_in_specification' =>  $include_in_specification[$key],
                                'client_allowance' =>  $client_allowance[$key]
                            );

                            $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);

                        }
                        else if(count($check_variation_parts)==0){
                            $part = array(
                                'variation_id' => $check_variation["id"],
                                'stage_id' => $nistage[$key],
                                'costing_part_id' => $nicosting_part_id[$key],
                                'project_id' => $cid['project_id'],
                                'component_id' => $nicomponent[$key],
                                'part_name' => $nipart[$key],
                                'component_uom' => $niuom[$key],
                                'linetotal' => $nilinttotal[$key],
                                'component_uc' => $niucost[$key],
                                'supplier_id' => $nisupplier_id[$key],
                                'quantity' => $nimanualqty[$key],
                                'status_part' => 1,
                                'available_quantity' => 0,
                                'costing_id' => $_POST['project_id'],
                                'change_quantity' => $nimanualqty[$key],
                                'updated_quantity' => $nimanualqty[$key],
                                'quantity_type' => 'manual',
                                'formulaqty' => '',
                                'formulatext' => '',
                                'component_variation_amount' => $nilinttotal[$key],
                                'include_in_specification' =>  $include_in_specification[$key],
                                'client_allowance' =>  $client_allowance[$key]
                            );

                            $vpid=$vparts = $this->mod_common->insert_into_table('project_variation_parts', $part);
                        }
                        else{
                            $where = array('id' => $check_variation_parts["id"]);
                            $part = array(
                                'stage_id' => $nistage[$key],
                                'costing_part_id' => $nicosting_part_id[$key],
                                'project_id' => $cid['project_id'],
                                'component_id' => $nicomponent[$key],
                                'part_name' => $nipart[$key],
                                'component_uom' => $niuom[$key],
                                'linetotal' => $nilinttotal[$key],
                                'component_uc' => $niucost[$key],
                                'supplier_id' => $nisupplier_id[$key],
                                'quantity' => $nimanualqty[$key],
                                'status_part' => 1,
                                'available_quantity' => 0,
                                'costing_id' => $_POST['project_id'],
                                'change_quantity' => $nimanualqty[$key],
                                'updated_quantity' => $nimanualqty[$key],
                                'quantity_type' => 'manual',
                                'formulaqty' => '',
                                'formulatext' => '',
                                'component_variation_amount' => $nilinttotal[$key],
                                'include_in_specification' =>  $include_in_specification[$key],
                                'client_allowance' =>  $client_allowance[$key]
                            );
                            $vpid=$vparts = $this->mod_common->update_table('project_variation_parts', $where, $part);
                            $vpid=$vparts = $check_variation_parts["id"];
                        }
                    }
                    if($nisi_item_id[$key]){
                        
                        $this->mod_common->update_table('project_supplier_invoices_items', array('id'=>$nisi_item_id[$key]), $invoice);
                        
                        if($allocated_allowance_id>0){
                            
                            $check_allowance_items = $this->mod_common->select_single_records('allocated_allowance_items', array("allocated_allowance_id" => $allocated_allowance_id, "supplier_invoice_item_id" => $nisi_item_id[$key]));
                            if(count($check_allowance_items)==0){
                            $allocated_array = array(
                                "supplier_invoice_item_id" =>  $nisi_item_id[$key],
                                "allocated_allowance_id" => $allocated_allowance_id,
                                "allocated_amount" => $nilinttotal[$key]
                            );
                            $this->mod_common->insert_into_table('allocated_allowance_items', $allocated_array);
                            }
                       }
                        
                        
                        
                        $invoicedone=$nisi_item_id[$key];
                        $existingsipartarr = array_diff($existingsipartarr, array($invoicedone));

                    }
                    else{
                        $invoicedone = $this->mod_common->insert_into_table('project_supplier_invoices_items', $invoice);
                        
                        if($allocated_allowance_id>0){
                            $allocated_array = array(
                                "supplier_invoice_item_id" => $invoicedone,
                                "allocated_allowance_id" => $allocated_allowance_id,
                                "allocated_amount" => $nilinttotal[$key]
                            );
                            $this->mod_common->insert_into_table('allocated_allowance_items', $allocated_array);
                       }
                    }

                    if(($this->input->post('createvariation'))== 1 && ($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending')){
                        $where 			= array('part_name' => $nipart[$key], 'component_id' => $nicomponent[$key], 'costing_part_id' =>   0, 'purchase_order_id' => $porders, 'stage_id' => $nistage[$key]);
		                $check_purchase_items = $this->mod_common->select_single_records('project_purchase_order_items', $where);
		               
                        //$porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);
                        
                        if(count($check_purchase_items)>0){
                            $order_quantity = $check_purchase_items["order_quantity"];
                            $this->mod_common->update_table('project_purchase_orders', array("id"=>$porders), $order_purchase);
                        }else{
                             $order_quantity = 0;
                             $porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);
                        }
                        
                        if(count($check_purchase_items)==0){
                            $part = array(
                                'purchase_order_id' => $porders,
                                'part_name' => $nipart[$key],
                                'component_id' => $nicomponent[$key],
                                'supplier_id' => $nisupplier_id[$key],
                                'costing_part_id' =>   0,
                                'order_quantity' => $nimanualqty[$key],
                                'stage_id' => $nistage[$key],
                                'costing_uom' => $niuom[$key],
                                'costing_uc' => $niucost[$key],
                                'line_cost' => $nilinttotal[$key],
                                'include_in_specification' =>  $include_in_specification[$key],
                                'client_allowance' =>  $client_allowance[$key]
                            );
    
                            $parts = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                        }
                        else{
                            $where 			= array('id' => $check_purchase_items["id"]);
                            $part = array(
                                'part_name' => $nipart[$key],
                                'component_id' => $nicomponent[$key],
                                'supplier_id' => $nisupplier_id[$key],
                                'costing_part_id' =>   0,
                                'order_quantity' => $nimanualqty[$key],
                                'stage_id' => $nistage[$key],
                                'costing_uom' => $niuom[$key],
                                'costing_uc' => $niucost[$key],
                                'line_cost' => $nilinttotal[$key],
                                'include_in_specification' =>  $include_in_specification[$key],
                                'client_allowance' =>  $client_allowance[$key]
                            );
    
                            $parts = $this->mod_common->update_table('project_purchase_order_items', $where, $part);
                        }

                    }
                    if(($this->input->post('createvariation'))== 1 && ($this->input->post('supplierinvoicestatus')=='Approved' || $this->input->post('supplierinvoicestatus')=='Pending')){
                        $where = array('costing_tpe_id' => $invoice_new, 'costing_id' => $_POST['project_id'], 'stage_id' => $nistage[$key], 'component_id' => $nicomponent[$key], 'costing_part_name' => $nipart[$key], 'costing_supplier' => $nisupplier_id[$key]);
		                $check_costing_parts = $this->mod_common->select_single_records('project_costing_parts', $where);
                        if(count($check_costing_parts)==0){
                        $part = array(
                            'costing_id' => $_POST['project_id'],
                            'stage_id' => $nistage[$key],
                            'component_id' => $nicomponent[$key],
                            'costing_part_name' => $nipart[$key],
                            'costing_uom' => $niuom[$key],
                            'margin' => 0,
                            'line_cost' => $nilinttotal[$key],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $nilinttotal[$key],
                            'type_status' => 1,
                            'is_locked' => 0,
                            'include_in_specification' =>  $include_in_specification[$key],
                            'client_allowance' =>  $client_allowance[$key],
                            'costing_uc' => $niucost[$key],
                            'costing_supplier' => $nisupplier_id[$key],
                            'costing_quantity' => $nimanualqty[$key],
                            'costing_part_status' => 1,
                            'is_variated' => $vId,
                            'isp_variated' => $vparts,
                            'costing_type' => 'sivar' ,
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
                           'client_allowance' =>  $client_allowance[$key],
                            'margin' => 0,
                            'line_cost' => $nilinttotal[$key],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $nilinttotal[$key],
                            'type_status' => 1,
                            'is_locked' => 0,
                            'include_in_specification' =>  $include_in_specification[$key],
                            'costing_uc' => $niucost[$key],
                            'costing_supplier' => $nisupplier_id[$key],
                            'costing_quantity' => $nimanualqty[$key],
                            'costing_part_status' => 1,
                            'is_variated' => $vId,
                            'isp_variated' => $vparts
                        );

                        $this->mod_common->update_table('project_costing_parts', array('costing_part_id' => $check_costing_parts["costing_part_id"]), $part); 
                        $cpid = $check_costing_parts["costing_part_id"];
                        }

                        $partispp=array('costingpartid_var' => $cpid );
                        $wherepp = array('id' => $vpid);
                        $this->mod_common->update_table('project_variation_parts', $wherepp, $partispp);
                        $partispp=array('costing_part_id' => $cpid );
                        $wherepp = array('id' => $poitem);
                        $this->mod_common->update_table('project_purchase_order_items', $wherepp, $partispp);
                        $partispp=array('costing_part_id' => $cpid,'order_pc_id' => $cpid );
                        $wherepp = array('id' => $invoicedone);
                        $this->mod_common->update_table('project_supplier_invoices_items', $wherepp, $partispp);

                    }

                    }
                }
            }


            foreach ($existingsipartarr as $key => $value) {
                $where 			= array('id' => $value);
		        $costing_part_info = $this->mod_common->select_single_records('project_supplier_invoices_items', $where);
                $this->mod_common->delete('project_supplier_invoices_items', array('id'=>$value));
                   }            
            //Xero Implementation                     
                    if($this->input->post('supplierinvoicestatus')=='Approved'){

                    $invoice_date = explode("/", $this->input->post('invoicedate'));
                    $invoice_date = $invoice_date[2]."-".$invoice_date[1]."-".$invoice_date[0];
                    $invoice_due_date = explode("/", $this->input->post('invoiceduedate'));
                    $invoice_due_date = $invoice_due_date[2]."-".$invoice_due_date[1]."-".$invoice_due_date[0];     

		            $where 			= array('supplier_id' => $_POST['first_selected_supplier']);
		            $supplier_info = $this->mod_common->select_single_records('project_suppliers', $where);
                       
                       $new_invoice = array( "Invoices" => array(
                                			array(
                                				"Type"=>"ACCPAY",
                                				"Contact" => array(
                                					"Name" => $supplier_info["supplier_name"]
                                				),
                                				"Date" => $invoice_date,
                                				"DueDate" => $invoice_due_date,
                                				"Status" => "AUTHORISED",
                                				"InvoiceNumber" => $_POST['supplierrefrence']."-".$invoice_id, 
                                				"Reference" => $_POST['supplierrefrence']."-".$invoice_id,
                                				"LineAmountTypes" => "Exclusive",
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
                		
                    	$invoice_result = $this->xero->Invoices($new_invoice);
                    	
                    	$xero_invoice_id = $invoice_result['Invoices']['Invoice']['InvoiceID'];
                    	
                    	$partispp=array('xero_invoice_id' => $xero_invoice_id);
                        $wherepp = array('id' => $invoice_id);
                        $this->mod_common->update_table('supplier_invoices', $wherepp, $partispp);
                		}
                    	
                    	
                	
                    }
            }

            $this->session->set_flashdata('ok_message', 'Supplier Invoice updated succesfully');
            redirect(SURL. 'supplier_invoices/viewinvoice/'.$invoice_id);
    }
    
}
    