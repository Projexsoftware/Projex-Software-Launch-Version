<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_orders extends CI_Controller {

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
             $this->load->model('mod_email_message');
             

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(11);
             

    }
    
    //Manage Purchase Orders
    public function index()
	{
	    $this->mod_common->is_company_page_accessible(12);
	    
	    $data['purchase_orders'] = $this->mod_project->get_all_purchase_orders(1);
        
        $this->stencil->title('Purchase Orders');
	    $this->stencil->paint('purchase_orders/manage_purchase_orders', $data);
	}
	
	//Get Completed Job Purchase Orders
	public function get_completed_job_purchase_orders(){
        $this->mod_common->is_company_page_accessible(12);
        $data['purchase_orders'] = $this->mod_project->get_all_purchase_orders(3);
        $this->load->view('purchase_orders/manage_purchase_orders_ajax', $data);
    }
	
	//Add Purchase Order Screen
	public function add_purchase_order(){
	   // $this->mod_common->is_company_page_accessible(13);
	   // $this->stencil->title("Purchase Order Wizard");
    //     $this->session->unset_userdata('porderdata');
    //     $this->session->unset_userdata('porders_id');

    //     $data['eprojects'] = $this->mod_project->get_active_project();
        
    //     $this->stencil->paint('purchase_orders/purchase_order_wizard', $data);
    $this->porder();
        
	}
	
	//Show Screen on Selection of Purchase Order Type Manual/Auto
	public function porder() {
        $order_type = "manual";
        $this->stencil->title("Manual Purchase Order");
        // if($this->session->userdata('porderdata')){
        //     $porderdata = $this->session->userdata('porderdata');
        //     $order_type = $porderdata['template'];
        //     $costing_id = $porderdata['project_id'];
        // }else{
        //     $order_type = $this->input->post('template');
        //     $costing_id = $this->input->post('project_id');
        //     $porderdata = array(
        //         'template'  => $order_type,
        //         'project_id' => $costing_id
        //     );
        //     $this->session->set_userdata('porderdata', $porderdata);
        // }
        
        // if($order_type==""){
        //     $this->session->set_flashdata("err_message", "Please Select Project For Purchase Order");
        //     redirect(SURL."purchase_orders/add_purchase_order");
        // }

        $id = $this->mod_project->get_project_id_from_costing_id($costing_id);

        // $id = $id['project_id'];
        // $data['project_name'] = $this->mod_project->get_project_by_name($id);
        // $data['project_id'] = $id;
        
       // $data['prjprts'] = $this->mod_project->get_costing_parts_by_costing_id($costing_id);

        
        
        if ($order_type == "auto") {
            $id = $this->mod_project->get_project_id_from_costing_id($costing_id);
            $data['project_costing_id'] = $costing_id;
            $data['suppliersprj'] = $suppliers = $this->mod_project->get_costing_suppliers_by_costing_id($costing_id);

            foreach ($suppliers AS $k => $v) {
                $stages = $this->mod_project->get_costing_stages_by_suppliers($v['costing_supplier'], $costing_id);
                $suppliers[$k]['stages'] = $stages;

                foreach ($stages AS $st => $stg) {
                    $part = $this->mod_project->get_parts_by_stage_id($stg['stage_id'], $v['costing_supplier'], $costing_id);
                    $suppliers[$k]['stages'][$st]['parts'] = $part;
                }
            }

            $data['porder'] = $suppliers;
            
            $this->stencil->paint("purchase_orders/automatic_purchase_order", $data);

        } else {
            
           $data['eprojects'] = $this->mod_project->get_active_project();
            $this->session->unset_userdata('porders_id');
            //$data['pselected'] = $costing_id;
            //$data['suppliersprj'] = $suppliers = $this->mod_project->get_costing_suppliers_by_costing_id($costing_id);
            
            $selected_suppliers = array();
            
    // foreach($data['suppliersprj'] as $key => $supplier){
    // $q= $this->db->query("SELECT id FROM project_purchase_orders WHERE order_status='Cancelled'");
    // $purchase_orders = $q->result_array();
    // $purchase_orders_id = array();
    // foreach($purchase_orders as $val){
    //     $purchase_orders_id[]= $val['id'];
        
    // }
    // $purchase_orders_id = implode(",",$purchase_orders_id);
    // $ids = explode(",", $purchase_orders_id);
    
    // $stage_id = 0;
    // $supplier_id = $supplier['costing_supplier'];
    // $company_id = $this->session->userdata('company_id');

    // $this->db->select(array("cp.*","c.component_name", "s.stage_name"));
    // $this->db->from("project_costing pc");
    // $this->db->join("project_costing_parts cp","pc.costing_id=cp.costing_id");
    // $this->db->join("project_components c","cp.component_id=c.component_id");
    // $this->db->join("project_purchase_order_items po","po.costing_part_id=cp.costing_part_id","left");
    // $this->db->join("project_stages s","s.stage_id=cp.stage_id","left");
    // $this->db->where("cp.costing_part_status",1);
    // if($stage_id>0){
    //   $this->db->where("cp.stage_id",$stage_id);
    // }
    // $this->db->where("cp.costing_supplier",$supplier_id);
    // $this->db->where("cp.costing_id",$costing_id);
    // $this->db->where("pc.company_id",$company_id);
    // $this->db->group_by("cp.costing_part_id");


    // $query = $this->db->get();
    // $result = $query->result();
    // $remaining_quantity = -1;
    // /*foreach($result as $value){
    //  $ordered_quantity = get_ordered_quantity($value->costing_part_id);
    //     $updated_quantity = get_recent_quantity($value->costing_part_id);
    //     if(count($updated_quantity)>0){
    //     $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
       
    //     }
    //     else{
    //       $remaining_quantity = $value->costing_quantity - $ordered_quantity; 
         
           
    //     }
        
    //     if($remaining_quantity>0){
    //         break;
    //     }
    // } 
        
        
    // if(count($result)>0 && $remaining_quantity>0){
    //     $selected_suppliers[$key]['costing_supplier'] = $supplier['costing_supplier'];
    //     $selected_suppliers[$key]['supplier_name'] = $supplier['supplier_name'];
    // }
    //         }
            
    //         $data['selected_suppliers'] = $selected_suppliers;
            
    //         foreach ($suppliers AS $k => $v) {
    //             $stages = $this->mod_project->get_costing_stages_by_suppliers($v['costing_supplier'], $costing_id);
    //             $suppliers[$k]['stages'] = $stages;

    //             foreach ($stages AS $st => $stg) {
    //                 $part = $this->mod_project->get_parts_by_stage_id($stg['stage_id'], $v['costing_supplier'], $costing_id);
    //                 $suppliers[$k]['stages'][$st]['parts'] = $part;
    //             }
    //         }
    // */
    // }
    
            $swhere = array('supplier_status' => 1, 'company_id' => $this->session->userdata('company_id'));
            $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $swhere, "supplier_name");
            
            $swhere = array('stage_status' => 1, 'company_id' => $this->session->userdata('company_id'));
            $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $swhere, "stage_id");

            $var_number=$this->mod_variation->lastinsertedvariationid();
            $data['var_number'] = $var_number;

            $this->stencil->paint("purchase_orders/manual_purchase_order", $data);
            
        }
    }
   
    //Add New Item
    public function populate_new_costing_row() {

        $data['last_row'] = $this->input->post("last_row");

        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
        $data['components'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");

        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");

        $swhere = array('supplier_status' => 1);
        $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $swhere, "supplier_id");
        
        $html = $this->load->view('purchase_orders/add_part', $data, true);

        echo $html;

    }
    
    //Get Costing Suppliers
    public function getCostingSuppliers(){
        $costing_id = $this->input->post("costingId");
        $suppliersArray = array();
        $q= $this->db->query("SELECT id FROM project_purchase_orders WHERE order_status='Cancelled'");
        $purchase_orders = $q->result_array();
        $purchase_orders_id = array();
        foreach($purchase_orders as $val){
            $purchase_orders_id[]= $val['id'];
            
        }
        $purchase_orders_id = implode(",",$purchase_orders_id);
        $ids = explode(",", $purchase_orders_id);
       
        $company_id = $this->session->userdata('company_id');
    
        $this->db->select(array("cp.*", "sup.supplier_name", "c.component_name", "s.stage_name"));
        $this->db->from("project_costing pc");
        $this->db->join("project_costing_parts cp","pc.costing_id=cp.costing_id");
        $this->db->join("project_components c","cp.component_id=c.component_id");
        $this->db->join("project_suppliers sup","cp.costing_supplier=sup.supplier_id");
        $this->db->join("project_purchase_order_items po","po.costing_part_id=cp.costing_part_id","left");
        $this->db->join("project_stages s","s.stage_id=cp.stage_id","left");
        $this->db->where("cp.costing_part_status",1);
        $this->db->where("cp.costing_id",$costing_id);
        $this->db->where("cp.client_allowance",0);
        $this->db->where("pc.company_id",$company_id);
        $this->db->group_by("cp.costing_part_id");
    
    
        $query = $this->db->get();
        $partDetail = $query->result();
        foreach ($partDetail as $key => $value) {
        
            $ordered_quantity = get_ordered_quantity($value->costing_part_id);
            $updated_quantity = get_recent_quantity($value->costing_part_id);
            if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']>0){
           
                 $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
            
            }
            else  if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']==0){
                $remaining_quantity = $updated_quantity['updated_quantity'];
            }
            else{
               $remaining_quantity = $value->costing_quantity - $ordered_quantity; 
            }
        
            if($remaining_quantity>0){
                $suppliersArray[] = $value->costing_supplier;
            }
        }
        
        $costingSuppliers = $this->mod_project->get_costing_suppliers_by_costing_id($costing_id);
     
        if(count($suppliersArray)>0){
            echo '<select class="selectpicker" data-style="select-with-transition" data-live-search="true" multiple="multiple" title="Select Suppliers" data-size="7" name="supplier_idd[]" id="supplier_id" onChange="setPartsForStages();">';
            foreach($costingSuppliers as $supplier){
              if(in_array($supplier["costing_supplier"], $suppliersArray)){
                 echo '<option value='.$supplier["costing_supplier"].'>'.$supplier["supplier_name"].'</option>'; 
              }
            }
            echo '</select>';
        }
                
    }
    
    //Get Costing Stages
    public function getCostingStages(){
        $costing_id = $this->input->post("costingId");
        $stagesArray = array();
        $q= $this->db->query("SELECT id FROM project_purchase_orders WHERE order_status='Cancelled'");
        $purchase_orders = $q->result_array();
        $purchase_orders_id = array();
        foreach($purchase_orders as $val){
            $purchase_orders_id[]= $val['id'];
            
        }
        $purchase_orders_id = implode(",",$purchase_orders_id);
        $ids = explode(",", $purchase_orders_id);
       
        $company_id = $this->session->userdata('company_id');
    
        $this->db->select(array("cp.*", "sup.supplier_name", "c.component_name", "s.stage_name"));
        $this->db->from("project_costing pc");
        $this->db->join("project_costing_parts cp","pc.costing_id=cp.costing_id");
        $this->db->join("project_components c","cp.component_id=c.component_id");
        $this->db->join("project_suppliers sup","cp.costing_supplier=sup.supplier_id");
        $this->db->join("project_purchase_order_items po","po.costing_part_id=cp.costing_part_id","left");
        $this->db->join("project_stages s","s.stage_id=cp.stage_id","left");
        $this->db->where("cp.costing_part_status",1);
        $this->db->where("cp.costing_id",$costing_id);
        $this->db->where("cp.client_allowance",0);
        $this->db->where("pc.company_id",$company_id);
        $this->db->group_by("cp.costing_part_id");
    
    
        $query = $this->db->get();
        $partDetail = $query->result();
        foreach ($partDetail as $key => $value) {
        
            $ordered_quantity = get_ordered_quantity($value->costing_part_id);
            $updated_quantity = get_recent_quantity($value->costing_part_id);
            if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']>0){
           
                 $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
            
            }
            else  if(count($updated_quantity)>0 && $updated_quantity['updated_quantity']==0){
                $remaining_quantity = $updated_quantity['updated_quantity'];
            }
            else{
               $remaining_quantity = $value->costing_quantity - $ordered_quantity; 
            }
        
            if($remaining_quantity>0){
                if(!in_array($value->stage_id, $stagesArray)){
                  $stagesArray[] = $value->stage_id;
                }
            }
        }
        
        $costingStages = $this->mod_project->get_costing_stages_by_costing_id($costing_id);
     
        if(count($stagesArray)>0){
            echo '<select class="selectpicker" data-style="select-with-transition" data-live-search="true" multiple="multiple" title="Select Stages" data-size="7" name="stage_id[]" id="supplier_stage_id" onChange="setPartsForStages();">';
            foreach($costingStages as $stage){
              if(in_array($stage["stage_id"], $stagesArray)){
                 echo '<option value='.$stage["stage_id"].'>'.$stage["stage_name"].'</option>'; 
              }
            }
            echo '</select>';
        }
                
    }
    
    //Get Component By Supplier
    public function getcomponentbysupplier() {
        $supplier_id = $this->input->post('supplier_id');
        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1, 'supplier_id' => $supplier_id);
        $component = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");
        
        $html = '';
        foreach ($component as $c) {
            $component_info = get_component_info($c['component_id']);
            $html.= '<option value="' . $c['component_id'] . '">' . escapeString($c["component_name"]).' ('.escapeString($component_info["supplier_name"]).'|'.$c["component_uc"].')' . '</option>';
        }
        print_r($html);
        exit;
    }
    
    //Create New Manual Purchase Order
    public function manual_purchase_order_process() {
        
        $prj = $this->mod_project->get_project_id_from_costing_id($this->input->post('costing_id'));
    
        $order_purchase = array(
            'project_id' => $prj['project_id'],
            'costing_id' => $this->input->post('costing_id'),
            'supplier_id' => $this->input->post('first_selected_supplier'),
            'stage_id' => 0,
            'order_date' => date('Y-m-d G:i:s'),
            'order_by' => $this->session->userdata('user_id'),            
            'company_id' => $this->session->userdata('company_id'),
            'created_date' => date('Y-m-d G:i:s'),
            'order_status' => $this->input->post('purchaseorderstatus'),
        );
        
        $table = "project_purchase_orders";

        if($this->session->userdata('porders_id')){
            $where= array(
                'id' => $this->session->userdata('porders_id')
            );

            $this->mod_common->update_table($table, $where, $order_purchase);
            $porders = $this->session->userdata('porders_id');
        }
        else{
            $porders = $this->mod_common->insert_into_table($table, $order_purchase);
        }
        
        if(($this->input->post('creatvariation'))== 1){
            

                    $where = array('variation_name' => 'Variation from Purchase Order #'.$porders);
                    $is_variation = $this->mod_common->get_all_records('project_variations',"*", 0, 0, $where, "id");
                    
                    if(count($is_variation)>0){
                        $vdata = array(
                        'variation_description' => $this->input->post('varidescriptioin'),
                        'project_id' => $prj['project_id'],
                        'var_number' => $this->input->post('var_number'),
                        'costing_id' => $this->input->post('costing_id'),
                        'project_subtotal1' => $this->input->post('total_cost'),
                        'hide_from_sales_summary' => (isset($_POST['hide_from_summary']) AND $_POST['hide_from_summary']=='1')?1:0,
                        'overhead_margin' => $this->input->post('overhead_margin'),
                        'profit_margin' => $this->input->post('profit_margin'),
                        'project_subtotal2' => $this->input->post('total_cost2'),
                        'tax' => $this->input->post('costing_tax'),
                        'project_subtotal3' => $this->input->post('total_cost3'),
                        'project_price_rounding' => $this->input->post('price_rounding'),
                        'project_contract_price' => $this->input->post('contract_price'),
                        'status' => $this->input->post('purchaseordervarstatus'),
                        'is_variation_locked' => 0
                    );

                    $tablename = 'project_variations';

                    $this->mod_common->update_table($tablename, $where, $vdata);

                    $vId = $is_variation['id'];
                    }
                    else{
                        
                    $vdata = array(
                        'created_by' => $this->session->userdata('user_id'),                        
                        'company_id' => $this->session->userdata('company_id'),
                        'variation_name' => 'Variation from Purchase Order #'.$porders,
                        'variation_description' => $this->input->post('varidescriptioin'),
                        'project_id' => $prj['project_id'],
                        'var_number' => $this->input->post('var_number'),
                        'costing_id' => $this->input->post('costing_id'),
                        'project_subtotal1' => $this->input->post('total_cost'),
                        'hide_from_sales_summary' => (isset($_POST['hide_from_summary']) AND $_POST['hide_from_summary']=='1')?1:0,
                        'overhead_margin' => $this->input->post('overhead_margin'),
                        'profit_margin' => $this->input->post('profit_margin'),
                        'project_subtotal2' => $this->input->post('total_cost2'),
                        'tax' => $this->input->post('costing_tax'),
                        'project_subtotal3' => $this->input->post('total_cost3'),
                        'project_price_rounding' => $this->input->post('price_rounding'),
                        'project_contract_price' => $this->input->post('contract_price'),
                        'status' => $this->input->post('purchaseordervarstatus'),
                        'is_variation_locked' => 0,
                        'var_type' => 'purord'
                    );

                    $tablename = 'project_variations';
                    $insert_variations = $this->mod_common->insert_into_table($tablename, $vdata);
                    $vId = $this->db->insert_id();
                    }

                    $partispp=array('var_number' => $vId+10000000 );
                    $wherepp = array('id' => $vId);
                    $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                }
            if ($porders) {
            if (isset($_POST['pmcosting_part_id'])) { 
             
                $cpi = count($this->input->post('pmcosting_part_id'));
                $part_name = array_values($this->input->post('pmpart'));
                $component_id = array_values($this->input->post('pmcomponent'));
                $costing_uom = array_values($this->input->post('pmuom'));
                $costing_part_id = array_values($this->input->post('pmcosting_part_id'));
                $costing_uc = array_values($this->input->post('order_unit_cost'));
                $old_cost = array_values($this->input->post('pmucost'));
                $line_cost = array_values($this->input->post('total_order'));
                $order_quantity = array_values($this->input->post('pmmanualqty'));
                $margin = array_values($this->input->post('pmmargin'));
                $line_margin = array_values($this->input->post('pmmargin_line'));
                $marginaddcost_line = array_values($this->input->post('marginaddprojectcost_line'));
                $comment = array_values($this->input->post('pmcomments'));
                $supplier_id = array_values($this->input->post('pmsupplier'));
                $stage_id = array_values($this->input->post('pmstage'));
                $client_allowance = array_values($this->input->post('pmclient_allowance'));
                $include_in_specification = array_values($this->input->post('pminclude_in_specification'));
                $pmstatus = array_values($this->input->post('pmstatus'));
                $pmcomments = array_values($this->input->post('pmcomments'));
                

                for ($i = 0; $i < $cpi; $i++) {
                    
                    $where = array('purchase_order_id' => $porders, 'costing_part_id' => $costing_part_id[$i]);

                    $is_purchase_order_items = $this->mod_common->get_all_records('project_purchase_order_items',"*", 0, 0, $where, "id");

                   if(count($is_purchase_order_items)>0){
                       $part = array(
                        'part_name' => $part_name[$i],
                        'component_id' => $component_id[$i],
                        'costing_uom' => $costing_uom[$i],
                        'costing_uc' => $costing_uc[$i],
                        'line_cost' => $line_cost[$i],
                        'order_quantity' => $order_quantity[$i],
                        'stage_id' => $stage_id[$i],
                        'supplier_id' => $supplier_id[$i],
                        'margin' => $margin[$i],
                        'line_margin' => $line_margin[$i],
                        'comment' => $pmcomments[$i]
                    );

                    $parts = $this->mod_common->update_table('project_purchase_order_items', $where, $part);
                    
                   }
                   else{
                    if($order_quantity[$i]>0){
                            $part = array(
                                'purchase_order_id' => $porders,
                                'part_name' => $part_name[$i],
                                'supplier_id' => $supplier_id[$i],
                                'component_id' => $component_id[$i],
                                'costing_uom' => $costing_uom[$i],
                                'costing_part_id' => $costing_part_id[$i],
                                'costing_uc' => $costing_uc[$i],
                                'line_cost' => $line_cost[$i],
                                'order_quantity' => $order_quantity[$i],
                                'stage_id' => $stage_id[$i],
                                'margin' => $margin[$i],
                                'line_margin' => $line_margin[$i],
                                 'comment' => $pmcomments[$i]
                            );

                            $parts = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                        }
                    
                   }
                    if(($this->input->post('creatvariation'))== 1 && $order_quantity[$i]>0 && ($costing_uc[$i]!=$old_cost[$i])){

                       $where = array('variation_id' => $vId, 'costing_part_id' => $costing_part_id[$i]);

                       $is_variation_items = $this->mod_common->get_all_records('project_variation_parts', "*", 0, 0, $where, "id");
                       
                       
                       if(count($is_variation_items)>0){
                          
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'allowance_check' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $line_cost[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $pmstatus[$i],
                            'is_line_locked' => 0,
                            'include_in_specification' => $include_in_specification[$i],
                            'component_uc' => $costing_uc[$i],
                            'supplier_id' => $supplier_id[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'change_quantity' => 0,
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $marginaddcost_line[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );

                        $this->mod_common->update_table('project_variation_parts', $where, $part);                        
                        $vpid = $is_variation_items['id'];                       
                        
                       }
                       else{
                           
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],
                            'costingpartid_var' => $costing_part_id[$i],                            
                            'costing_part_id' => $costing_part_id[$i],
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'allowance_check' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $line_cost[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $pmstatus[$i],
                            'is_line_locked' => 0,
                            'include_in_specification' => $include_in_specification[$i],
                            'component_uc' => $costing_uc[$i],
                            'supplier_id' => $supplier_id[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'change_quantity' => 0,
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $marginaddcost_line[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );
                         
                        $this->mod_common->insert_into_table('project_variation_parts', $part);
                        $vpid = $this->db->insert_id();
                       }    
                       
                       $where = array("costing_part_id" => $costing_part_id[$i]);
                            $is_project_costing = $this->mod_common->select_single_records('project_costing_parts', $where);
                            if(count($is_project_costing)>0){
                                     $part = array(
                                    'stage_id' => $stage[$i],
                                    'component_id' => $component_id[$i],
                                    'costing_part_name' => $part_name[$i],
                                    'costing_uom' => $costing_uom[$i],
                                    'margin' => $margin[$i],
                                    'line_cost' => $linttotal[$i],
                                    'line_margin' => $line_margin[$i],
                                    'costing_uc' => $costing_uc[$i],
                                    'costing_supplier' => $supplier_id[$i],
                                    'costing_quantity' => $order_quantity[$i],
                                    'is_variated' => 0,
                                    'isp_variated' => 0
                                   );
                               
                                   //$this->mod_common->update_table('project_costing_parts', $where, $part);
                            }
                    }
                   
                }
            }
			
			
			 
            if (isset($_POST['component'])) {

                $count = 0;
                $cpi = count($this->input->post('component'));
                $part_name = array_values($this->input->post('part'));
                $component_id = array_values($this->input->post('component'));
                $costing_uom = array_values($this->input->post('uom'));
                $costing_part_id = array_values($this->input->post('costing_part_id'));
                $costing_uc = array_values($this->input->post('ucost'));
                $linttotal = array_values($this->input->post('linttotal'));
                $order_quantity = array_values($this->input->post('manualqty'));
                $margin = array_values($this->input->post('margin'));
                $line_margin = array_values($this->input->post('margin_line'));
                $useradditionalcost = array_values($this->input->post('useradditionalcost'));
                $marginaddcost_line = array_values($this->input->post('marginaddcost_line'));
                $srno = array_values($this->input->post('srno'));
                $supplier_id = array_values($this->input->post('supplier_id'));
                $stage_id = array_values($this->input->post('stage'));
                $include_in_specification = array_values($this->input->post('include_in_specification'));
                $client_allowance = array_values($this->input->post('allowance'));
                $status = array_values($this->input->post('status'));
                $comments = array_values($this->input->post('comments'));
               

                
				for ($i = 0; $i < $cpi; $i++) {
                    
                     $where = array('costing_tpe_id' => $porders, 'costing_part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i]);
                            $is_project_costing = $this->mod_common->select_single_records('project_costing_parts', $where);
                           
                            if(count($is_project_costing)>0){
                                
                             $part = array(
                            'costing_id' => $this->input->post('costing_id'),
                            'stage_id' => $stage_id[$i],
                            'component_id' => $component_id[$i],
                            'costing_part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i],
                            'costing_uom' => $costing_uom[$i],
                            'margin' => $margin[$i],
                            'line_cost' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_locked' => 0,
                            'client_allowance' => $client_allowance[$i],
                            'include_in_specification' => $include_in_specification[$i],
                            'costing_uc' => $costing_uc[$i],
                            'costing_supplier' => $supplier_id[$i],
                            'costing_quantity' => $order_quantity[$i],
                            'costing_part_status' => 1,
                            'is_variated' => ($vId) ? $vId : 0,
                            'isp_variated' => $vpid,
                            'comment' => $comments[$i]
                        );
                       
                         $this->mod_common->update('project_costing_parts', $part, $where);
                         $cpid = $is_project_costing['costing_part_id'];

                        }
                        else{
                             
                        $part = array(
                            'costing_id' => $this->input->post('costing_id'),
                            'stage_id' => $stage_id[$i],
                            'component_id' => $component_id[$i],
                            'costing_part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i],
                            'costing_uom' => $costing_uom[$i],
                            'margin' => $margin[$i],
                            'line_cost' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_locked' => 0,
                            'client_allowance' => $client_allowance[$i],
                            'include_in_specification' => $include_in_specification[$i],
                            'costing_uc' => $costing_uc[$i],
                            'costing_supplier' => $supplier_id[$i],
                            'costing_quantity' => $order_quantity[$i],
                            'costing_part_status' => 1,
                            'is_variated' => ($vId) ? $vId : 0,
                            'isp_variated' => $vpid,
                            'costing_type' => 'pvar' ,
                            'costing_tpe_id' => $porders,
                            'comment' => $comments[$i]
                        );                        
                        
                        $this->mod_common->insert_into_table('project_costing_parts', $part);
                        $cpid = $this->db->insert_id();
                        
                        }

                    $where = array('purchase_order_id' => $porders, 'costing_part_id' => $cpid);

                    $is_purchase_order_items = $this->mod_common->select_single_records('project_purchase_order_items', $where);
                    
                    if(count($is_purchase_order_items)>0){
                       
                        $part = array(

                        'part_name' => $part_name[$i],
                        'supplier_id' => $supplier_id[$i],
                        'component_id' => $component_id[$i],
                        'costing_uom' => $costing_uom[$i],
                        'costing_uc' => $costing_uc[$i],
                        'line_cost' => $linttotal[$i],
                        'order_quantity' => $order_quantity[$i],
                        'stage_id' => $stage_id[$i],
                        'margin' => $margin[$i],
                        'line_margin' => $line_margin[$i],
                        'srno' => $srno[$i],
                        'client_allowance' => $client_allowance[$i],
                        'include_in_specification' => $include_in_specification[$i],
                        'comment' => $comments[$i]
                    );

                    if(($this->input->post('creatvariation'))== 1){

                        $part['part_name']= 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i];

                    }

                    $this->mod_common->update_table('project_purchase_order_items', $where, $part);
                    $poiid = $is_purchase_order_items['id'];
                  
                        
                    }
                    else{
                      
                    $part = array(
                        'purchase_order_id' => $porders,
                        'part_name' => $part_name[$i],
                        'supplier_id' => $supplier_id[$i],
                        'component_id' => $component_id[$i],
                        'costing_uom' => $costing_uom[$i],
                        'costing_part_id' => $cpid,
                        'costing_uc' => $costing_uc[$i],
                        'line_cost' => $linttotal[$i],
                        'order_quantity' => $order_quantity[$i],
                        'stage_id' => $stage_id[$i],
                        'margin' => $margin[$i],
                        'line_margin' => $line_margin[$i],
                        'srno' => $srno[$i],
                        'client_allowance' => $client_allowance[$i],
                        'include_in_specification' => $include_in_specification[$i],
                        'comment' => $comments[$i]
                    );

                    if(($this->input->post('creatvariation'))== 1){

                        $part['part_name']= 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i];
                    }

                    $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                    $poiid = $this->db->insert_id();

                    }

                    if(($this->input->post('creatvariation'))== 1){

                       $where = array('variation_id' => $vId, 'costing_part_id' => $cpid);

                       $is_variation_items = $this->mod_common->select_single_records('project_variation_parts', $where);
                       
                       
                       if(count($is_variation_items)>0){
                          
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],//$this->input->post('stage_id'),
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_line_locked' => 0,
                            'component_uc' => $costing_uc[$i],
                            'supplier_id' => $supplier_id[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'allowance_check' => $client_allowance[$i],
                            'include_in_specification' => $include_in_specification[$i],
                            'change_quantity' => $order_quantity[$i],
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $useradditionalcost[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );

                        $this->mod_common->update_table('project_variation_parts', $where, $part);                        
                        $vpid = $is_variation_items['id'];                       
                        
                       }
                       else{
                           
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],
                            'costingpartid_var' => $cpid,                            
                            'costing_part_id' => $cpid,
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_line_locked' => 0,
                            'component_uc' => $costing_uc[$i],
                            'supplier_id' => $supplier_id[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'allowance_check' => $client_allowance[$i],
                            'include_in_specification' => $include_in_specification[$i],
                            'change_quantity' => $order_quantity[$i],
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $useradditionalcost[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );
                         
                        $this->mod_common->insert_into_table('project_variation_parts', $part); 
                        $vpid = $this->db->insert_id();
                       }                                            
                    }
					}
                }

                if(($this->input->post('creatvariation'))== 1){
                    $this->db->trans_complete();
                }
            }
            $this->session->set_userdata('porders_id', $porders);
            
            if($this->input->post('first_selected_supplier')!="" && $this->input->post('first_selected_supplier')>0){
                $where = array("purchase_order_id" => $porders);
                $upd_array = array("supplier_id" => $this->input->post('first_selected_supplier'));
                
                $this->mod_common->update_table("purchase_order_items", $where, $upd_array);
            }
            
            $this->session->set_flashdata('ok_message', "Manual Purchase Order created sucessfully");
            redirect(SURL."purchase_orders/update_porder/".$porders);
        }
        
    //Get Project Costing Parts
    public function get_projects_part_for_porder() {
      
    $q= $this->db->query("SELECT id FROM project_purchase_orders WHERE order_status='Cancelled'");
    $purchase_orders = $q->result_array();
    $purchase_orders_id = array();
    foreach($purchase_orders as $val){
        $purchase_orders_id[]= $val['id'];
        
    }
    $purchase_orders_id = implode(",",$purchase_orders_id);
    $ids = explode(",", $purchase_orders_id);
   
    
    $costing_id = $this->input->post('costingId');
    $company_id = $this->session->userdata('company_id');
    $is_auto_purchase_order = $this->input->post("is_auto_purchase_order");
    $data["is_auto_purchase_order"] = $is_auto_purchase_order;

    $this->db->select(array("cp.*", "sup.supplier_name", "c.component_name", "s.stage_name"));
    $this->db->from("project_costing pc");
    $this->db->join("project_costing_parts cp","pc.costing_id=cp.costing_id");
    $this->db->join("project_components c","cp.component_id=c.component_id");
    $this->db->join("project_suppliers sup","cp.costing_supplier=sup.supplier_id");
    $this->db->join("project_purchase_order_items po","po.costing_part_id=cp.costing_part_id","left");
    $this->db->join("project_stages s","s.stage_id=cp.stage_id","left");
    $this->db->where("cp.costing_part_status",1);
     if($this->input->post('stage_id')!=""){
        $stage_id = join(', ', $this->input->post('stage_id'));
        $this->db->where("cp.stage_id IN (".$stage_id.")",NULL, false);
    }
    if($this->input->post('supplier_id')!=""){
    $supplier_id = join(', ', $this->input->post('supplier_id'));
    $this->db->where("cp.costing_supplier IN (".$supplier_id.")",NULL, false);
    }
    $this->db->where("cp.costing_id",$costing_id);
    $this->db->where("cp.client_allowance",0);
    $this->db->where("pc.company_id",$company_id);
    $this->db->group_by("cp.costing_part_id");


    $query = $this->db->get();
    $result = $query->result();
    //echo $this->db->last_query();exit;
    
    $data['partDetail'] = $result;
    count($data['partDetail']);
    $data['last_row'] = 0;
    if($is_auto_purchase_order=="true"){
        $html = $this->load->view('purchase_orders/add_part_by_costing_part_id_for_automated_porder', $data, true);
    }
    else{
        $html = $this->load->view('purchase_orders/add_part_by_costingpart_id', $data, true);
    }

    echo $html;

  }
    
    //Update Purchase Order Status
    function update_status(){
        $id=$this->input->post('id');
        $status=$this->input->post('status');
        $data['supplier_invoice_id'] = $this->input->post('supplier_invoice_id');
        $where= array(
                'id' => $id
            );
       $order_purchase = array(
                'order_status' => $status
            );
        $this->mod_common->update_table('purchase_orders', $where, $order_purchase);
        $where = array("variation_name" => "Variation from Purchase Order #".$id);
        $this->mod_common->update_table('project_variations', $where, array("status" => "APPROVED"));
        $data['order_status'] = $status;
        $data['order_id'] = $id;
        $html = $this->load->view('purchase_orders/status_ajax', $data, true);
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
    
    //Populate Supplier
    public function populate_supplier() {

        $supplier = isset($_POST['supplier']) ? $_POST['supplier'] : 0;
        $stage = isset($_POST['stage']) ? $_POST['stage'] : 0;

        $prj_costing_id = isset($_POST['prj_costing_id']) ? $_POST['prj_costing_id'] : 0;
        $data['suppliersprj'] = $curr_suppliers = $this->mod_project->get_costing_suppliers_by_costing_id($prj_costing_id, $supplier);
        foreach ($curr_suppliers AS $k => $v) {

            $stagesall = $this->mod_project->get_costing_stages_by_suppliers($v['costing_supplier'], $prj_costing_id, $stage);
            if(count($stagesall)>0){
                
            $curr_suppliers[$k]['stages'] = $stagesall;
            
            foreach ($stagesall AS $st => $stg) {
                if($stg['stage_id']){
                $part = $this->mod_project->get_parts_by_stage_id($stg['stage_id'], $v['costing_supplier'], $prj_costing_id);
                foreach ($part as $km => $vm) {

                    $variation = $this->mod_project->getupdatedquantitybycostingpartid($vm['costing_part_id']);

                    if (isset($variation[0]['updated_quantity']))
                        $part[$km]['costing_quantity'] = $variation[0]['updated_quantity'];

                    $ordered_quantity=$this->mod_project->get_order_quantity_by_costingpartid($vm['costing_part_id']);
                    $ordered_quantity = $ordered_quantity[0]['total_ordered'];
                    $part[$km]['ordered_quantity'] = $ordered_quantity;
                }
                $curr_suppliers[$k]['stages'][$st]['parts'] = $part;
                /*echo "<pre>";
                print_r($curr_suppliers[$k]['stages'][$st]['parts']);*/
                }
            }
            }
            else{
                 $curr_suppliers[$k]['stages'] = $stagesall;
            }
        }

        $data['porder'] = $curr_suppliers;

        echo $this->load->view('purchase_orders/populate_suppliers', $data, true);
    }
    
    //Add New Automatic Purchase Order
   /* public function automatic_purchase_order_process() {
        $prj = $this->mod_project->get_project_id_from_costing_id($this->input->post('costing_id'));
        $suppliers = $this->input->post("supplier_idd");
        $parts_supplier_id = array_values($this->input->post('pmsupplier'));
        if(count($suppliers)==0){
            $suppliers = array();
            for($k=0;$k<count($parts_supplier_id);$k++){
                if(!in_array($parts_supplier_id[$k], $suppliers)){
                    $suppliers[]=$parts_supplier_id[$k];
                }
            }
        }
    
        for($j=0;$j<count($suppliers);$j++){
                if(in_array($suppliers[$j], $parts_supplier_id)){
                    $order_purchase = array(
                        'project_id' => $prj['project_id'],
                        'supplier_id' => $suppliers[$j],
                        'stage_id' => 0,
                        'costing_id' => $this->input->post('costing_id'),
                        'order_date' => date('Y-m-d G:i:s'),
                        'order_type' => "automatic",
                        'order_by' => $this->session->userdata('user_id'),                        
                        'company_id' => $this->session->userdata('company_id'),
                        'created_date' => date('Y-m-d G:i:s')
                    );
                    
                    $porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);
                    if ($porders) {
                        $cpi = count($this->input->post('pmcosting_part_id'));
                        $part_name = array_values($this->input->post('pmpart'));
                        $component_id = array_values($this->input->post('pmcomponent'));
                        $costing_uom = array_values($this->input->post('pmuom'));
                        $costing_part_id = array_values($this->input->post('pmcosting_part_id'));
                        $costing_uc = array_values($this->input->post('order_unit_cost'));
                        $old_cost = array_values($this->input->post('pmucost'));
                        $line_cost = array_values($this->input->post('total_order'));
                        $order_quantity = array_values($this->input->post('pmmanualqty'));
                        $margin = array_values($this->input->post('pmmargin'));
                        $line_margin = array_values($this->input->post('pmmargin_line'));
                        $marginaddcost_line = array_values($this->input->post('marginaddprojectcost_line'));
                        $comment = array_values($this->input->post('pmcomments'));
                        $supplier_id = array_values($this->input->post('pmsupplier'));
                        $stage_id = array_values($this->input->post('pmstage'));
                        $client_allowance = array_values($this->input->post('pmclient_allowance'));
                        $include_in_specification = array_values($this->input->post('pminclude_in_specification'));
                        $pmstatus = array_values($this->input->post('pmstatus'));
                        $pmcomments = array_values($this->input->post('pmcomments'));
                        for ($i = 0; $i < $cpi; $i++) {

                            if($order_quantity[$i]>0 && $suppliers[$j]==$supplier_id[$i]){
                                $part = array(
                                    'purchase_order_id' => $porders,
                                    'part_name' => $part_name[$i],
                                    'supplier_id' => $supplier_id[$i],
                                    'component_id' => $component_id[$i],
                                    'costing_uom' => $costing_uom[$i],
                                    'costing_part_id' => $costing_part_id[$i],
                                    'costing_uc' => $costing_uc[$i],
                                    'line_cost' => $line_cost[$i],
                                    'order_quantity' => $order_quantity[$i],
                                    'stage_id' => $stage_id[$i],
                                    'margin' => $margin[$i],
                                    'line_margin' => $line_margin[$i],
                                    'comment' => $pmcomments[$i]
                                );
    
                                $parts = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                            }
                        }
                    }
                }
        }
        
        $this->session->set_flashdata('ok_message', "Automatic Purchase Order created sucessfully");
        redirect(SURL . 'purchase_orders');
    }*/
    
    public function automatic_purchase_order_process() {
        $prj = $this->mod_project->get_project_id_from_costing_id($this->input->post('costing_id'));
        $suppliert = array_values($this->input->post('suppliers'));
        $testing = array();
        for ($i = 0; $i < count($suppliert); $i++) {
            $m = $suppliert[$i];
            $mstage = array_values($this->input->post('mstage' . $m));
            for ($j = 0; $j < count($mstage); $j++) {
                $n = $mstage[$j];
                $ss = array_values($this->input->post('stage'.$m.$n));
                $s_id=$ss[0]."-".$m;
                if(!(in_array($s_id, $testing))){
                    $testing[]=$ss[0]."-".$m;

                    $order_purchase = array(
                        'project_id' => $prj['project_id'],
                        'supplier_id' => $m,
                        'stage_id' => $ss['0'],
                        'costing_id' => $this->input->post('costing_id'),
                        'order_date' => date('Y-m-d G:i:s'),
                        'order_type' => "automatic",
                        'order_by' => $this->session->userdata('user_id'),                        
                        'company_id' => $this->session->userdata('company_id'),
                        'created_date' => date('Y-m-d G:i:s'),
                        'order_status' => $this->input->post('purchaseorderstatus')
                    );
                    
                    $porders = $this->mod_common->insert_into_table('project_purchase_orders', $order_purchase);
                    if ($porders) {
                        $cpi = count($this->input->post('costing_part_id' . $m . $n));
                        $part_name = array_values($this->input->post('part' . $m . $n));
                        $component_id = array_values($this->input->post('component' . $m . $n));
                        $costing_uom = array_values($this->input->post('uom' . $m . $n));
                        $costing_part_id = array_values($this->input->post('costing_part_id' . $m . $n));
                        $costing_uc = array_values($this->input->post('ucost' . $m . $n));
                        $linttotal = array_values($this->input->post('linttotal' . $m . $n));
                        $order_quantity = array_values($this->input->post('manualqty' . $m . $n));
                        $stage_id = array_values($this->input->post('stage' . $m . $n));
                        $margin = array_values($this->input->post('margin' . $m . $n));
                        $line_margin = array_values($this->input->post('margintotal' . $m . $n));
                        for ($k = 0; $k < $cpi; $k++) {

                            $part = array(
                                'purchase_order_id' => $porders,
                                'part_name' => $part_name[$k],
                                'supplier_id' => $m,
                                'component_id' => $component_id[$k],
                                'costing_uom' => $costing_uom[$k],
                                'costing_part_id' => $costing_part_id[$k],
                                'costing_uc' => $costing_uc[$k],
                                'line_cost' => $linttotal[$k],
                                'order_quantity' => $order_quantity[$k],
                                'stage_id' => $stage_id[$k],
                                'margin' => $margin[$k],
                                'line_margin' => $line_margin[$k],
                            );

                            $parts = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                        }
                    }
                }
            }
        }
        $this->session->set_flashdata('ok_message', "Automatic Purchase Order created sucessfully");
        redirect(SURL . 'purchase_orders');
    }
    
    
    //View Purchase Order Details
    public function pporder($porder) {
        $this->mod_common->is_company_page_accessible(12);
        $data['istemplate'] = '';
        $data['order_detail'] = $this->mod_project->get_porder_detail_by_id($porder);
        if($data['order_detail']){
            $data['order_items'] = $this->mod_project->get_order_items_by_porder_id($porder);
    
            if($data['order_detail']->order_status=='Pending' && $data['order_detail']->order_type == "manual" ){
                redirect(SURL."purchase_orders/update_porder/".$data['order_detail']->id);
            }
                foreach ($data['order_items'] as $keyo => $valo) {
                    $si=$this->mod_project->get_siuiq_by_pocpid($valo['purchase_order_id'],$valo['costing_part_id'] );
                    if(isset($si[0]['uninvoicedquantity']) && $si[0]['uninvoicedquantity'] < $valo['order_quantity']){
                        $data['errorpur']='You should not approve this purchase order, Order quantity is greater than project part uninvoiced costing quantity for an item in purchase order ';
                    }
                }
    
            $cwhere = array('id' => $porder);
            $data['postatus'] = $this->mod_common->select_single_records('project_purchase_orders', $cwhere);
             
            $data['projectinfo'] = $this->mod_project->get_project_info($data['order_detail']->project_id);
            
            $data['email_message'] = $this->mod_common->select_single_records('email_templates', array('company_id'=>$this->session->userdata('company_id')));
            
            $this->stencil->title('Purchase Order');
    	    $this->stencil->paint('purchase_orders/porder', $data);
        }
        else{
            $this->session->set_flashdata('err_message', "Sorry! You don't have permission to access this page");
            redirect(SURL."purchase_orders");
        }
    }
    
    //Change Purchase Order Status
    public function changedpurchaseorderstatus($po_id) {
        $where = array('id' => $po_id, 'company_id' => $this->session->userdata('company_id'));
		$data['porder_details'] = $this->mod_common->select_single_records('project_purchase_orders', $where );
		
		if(count($data['porder_details'])>0){
            $status = isset($_POST['status']) ? $_POST['status'] : 'Pending';
            $order_status = $this->mod_project->updateorderstatus($po_id,$status);
    
            if ($order_status){
                if($status=="Cancelled"){
                    $this->mod_project->updatepurchaseorderitems($po_id);
                }
                $this->session->set_flashdata('ok_message', 'Purchase Order status has been updated.');
            } else {
                $this->session->set_flashdata('err_message', 'Purchase order status not updated.');
            }
            redirect(SURL . 'purchase_orders/pporder/' . $po_id);
        }
        else{
            $this->session->set_flashdata('err_message', "Sorry! You don't have permission to access this page");
            redirect(SURL."purchase_orders");
        }
    }
    
    //Issue Purchase Order
    public function issue_order($porder) {
         $this->load->library('M_pdf');
        $data['order_detail'] = $this->mod_project->get_porder_detail_by_id($porder);
        if(count($data['order_detail'])>0){
        $button_type = $this->input->post('button_type');
        if($button_type==1){
        $email_message = $this->input->post('email_message');
        $data['order_items'] = $this->mod_project->get_order_items_by_porder_id($porder);

        if($data['order_detail']->order_status=='Pending'){
            foreach ($data['order_items'] as $keyo => $valo) {
                $si=$this->mod_project->get_siuiq_by_pocpid($valo['purchase_order_id'],$valo['costing_part_id'] );
                if(isset($si[0]['uninvoicedquantity']) && $si[0]['uninvoicedquantity'] < $valo['order_quantity']){
                    $data['errorpur']='You should not approve this purchase order, Order quantity is greater than project part uninvoiced costing quantity for an item in Purchase Order ';
                }
            }
        }


        $data['projectinfo'] = $this->mod_project->get_project_info($data['order_detail']->project_id);

        $cwhere = array('user_id' => $this->session->userdata('company_id'));
    
        $data['company_info'] = $this->mod_common->select_single_records('project_users', $cwhere);

        $html = $this->load->view('purchase_orders/purchase_order_pdf', $data, true);
        $pdfFilePath = $_SERVER["DOCUMENT_ROOT"]."/projex_software/assets/porder_pdf/supplier_purchase_order_".$porder."_".date('Y-m-d').".pdf";
        $this->m_pdf->pdf->WriteHTML($html); 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "F"); 
       
        $to_email = $data['order_detail']->supplier_email;
        $from_email = $data['company_info']["com_email"];
        $from_txt = "Purchase Order";
        $this->email->from($from_email,$from_txt);
        $this->email->to($to_email);
        
        $this->email->subject("Purchase order by ".$data['company_info']["com_name"]);
        

        $this->email->message($email_message);
        $this->email->attach($pdfFilePath);
        $this->email->set_mailtype("html");
        if($this->email->send()){
        $this->session->set_flashdata("ok_message", "Purchase order has been sent via email to supplier.");
        }
        
        }
        else{
            $ins_array = array(
                'supplier_id' => $this->input->post('supplier_id'),
                'user_id' => $this->session->userdata('user_id'),           
                'purchase_order_id' => $porder,
                'status' => 1
            );

            $this->mod_common->insert_into_table('project_component_purchase_orders', $ins_array);
            
             $where= array(
                'id' => $porder
            );
            
            $order_purchase = array(
                "is_order_send" => 1,
                "order_status" => "Send Order Direct to Supplier"
                );

            $this->mod_common->update_table('project_purchase_orders', $where, $order_purchase);
            
            $this->session->set_flashdata("ok_message", "Purchase order has been sent directly to supplier.");
        }

        redirect(SURL . 'purchase_orders/pporder/' . $porder);
        }
        else{
            $this->session->set_flashdata('err_message', "Sorry! You don't have permission to access this page");
            redirect(SURL."purchase_orders");
        }
    }
    
    //Update Manual Purchase Order
    public function update_porder($porder_id) {
        
        $this->stencil->title("Update Manual Purchase Order");
        
        $data['istemplate'] = '';
		
		$where = array('id' => $porder_id, 'company_id' => $this->session->userdata('company_id'), 'order_type' => 'manual');
		$data['porder_details'] = $this->mod_common->select_single_records('project_purchase_orders', $where );
		
		if(count($data['porder_details'])>0){
		
    		$variation_name = "Variation from Purchase Order #".$porder_id;
    		$where = array('variation_name' => $variation_name);
            $fields = '*';
            
    		$data['variation_details'] =  $this->mod_common->select_single_records('project_variations', $where );
    		
    	    if($data['porder_details']["order_status"]=="Pending"){
        		$data['porder_items'] = $this->mod_project->get_order_items_by_porder_id($porder_id);
        		//echo "<pre>";
        		//print_r($data['porder_items']);exit;
        
                $costing_id = $data['porder_details']["costing_id"];
        
                $id = $this->mod_project->get_project_id_from_costing_id($costing_id);
        
                $id = $id['project_id'];
                $data['project_name'] = $this->mod_project->get_project_by_name($id);
                $data['project_id'] = $id;
                
                    $data['pselected'] = $costing_id;
                    $data['suppliersprj'] = $suppliers = $this->mod_project->get_costing_suppliers_by_costing_id($costing_id);
                    $selected_suppliers = array();
                    
                    $var_number=$this->mod_variation->lastinsertedvariationid();
                    $data['var_number'] = $var_number;
        
                    $swhere = array('company_id' => $this->session->userdata('company_id'), 'supplier_status' => 1);
                    $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $swhere, "supplier_name");
        
                    $data['prjprts'] = $this->mod_project->get_costing_parts_by_costing_id($costing_id);
        
        
                    $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
                    $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
        
                    $data['eproject'] = $this->mod_project->get_active_project();
        
                    
                    $this->stencil->paint('purchase_orders/update_purchase_manual', $data);
    		}
    		else{
    		    redirect(SURL."purchase_orders/pporder/".$data['porder_details']["id"]);
    		}
		}
		else{
            $this->session->set_flashdata('err_message', "Sorry! You don't have permission to access this page");
            redirect(SURL."purchase_orders");
        }
    }
    
    //Update Automatic Purchase Order
    public function update_purchase_order() {
        
       $porders = $this->input->post("porder_id");
       $first_selected_supplier = $this->input->post("first_selected_supplier");
	   $purchase_order_status = $this->input->post('purchaseorderstatus');
	   
	    $order_purchase = array(
            'order_status' => $purchase_order_status,
        );
		
		$where= array(
                'id' => $porders
            );

        $this->mod_common->update_table('project_purchase_orders', $where, $order_purchase);
        
        if(($this->input->post('creatvariation'))== 1){
            
                    $where = array('variation_name' => 'Variation from Purchase Order #'.$porders);
                    
                    $is_variation = $this->mod_common->select_single_records('project_variations', $where);
                    
                    if(count($is_variation)>0){
                        $vdata = array(
                            
                        'variation_description' => $this->input->post('varidescriptioin'),
                        'var_number' => $this->input->post('var_number'),
                        'costing_id' => $this->input->post('costing_id'),
                        'project_subtotal1' => $this->input->post('total_cost'),
                        'hide_from_sales_summary' => (isset($_POST['hide_from_summary']) AND $_POST['hide_from_summary']=='1')?1:0,
                        'overhead_margin' => $this->input->post('overhead_margin'),
                        'profit_margin' => $this->input->post('profit_margin'),
                        'project_subtotal2' => $this->input->post('total_cost2'),
                        'tax' => $this->input->post('costing_tax'),
                        'project_subtotal3' => $this->input->post('total_cost3'),
                        'project_price_rounding' => $this->input->post('price_rounding'),
                        'project_contract_price' => $this->input->post('contract_price'),
                        'status' => $this->input->post('purchaseordervarstatus'),
                        'is_variation_locked' => 0
                    );

                  

                    $tablename = 'project_variations';
                    $this->db->where($where);
                    $this->db->update($tablename, $vdata);
                   
                    $vId = $is_variation["id"];
                    }
                    else{
                        
                    $vdata = array(
                        'created_by' => $this->session->userdata('user_id'),                        
                        'company_id' => $this->session->userdata('company_id'),
                        'variation_name' => 'Variation from Purchase Order #'.$porders,
                        'variation_description' => $this->input->post('varidescriptioin'),
                        'var_number' => $this->input->post('var_number'),
                        'costing_id' => $this->input->post('costing_id'),
                        'project_subtotal1' => $this->input->post('total_cost'),
                        'hide_from_sales_summary' => (isset($_POST['hide_from_summary']) AND $_POST['hide_from_summary']=='1')?1:0,
                        'overhead_margin' => $this->input->post('overhead_margin'),
                        'profit_margin' => $this->input->post('profit_margin'),
                        'project_subtotal2' => $this->input->post('total_cost2'),
                        'tax' => $this->input->post('costing_tax'),
                        'project_subtotal3' => $this->input->post('total_cost3'),
                        'project_price_rounding' => $this->input->post('price_rounding'),
                        'project_contract_price' => $this->input->post('contract_price'),
                        'status' => $this->input->post('purchaseordervarstatus'),
                        'is_variation_locked' => 0,
                        'var_type' => 'purord'
                    );

                    $tablename = 'project_variations';
                    $insert_variations = $this->mod_common->insert_into_table($tablename, $vdata);
                    $vId = $this->db->insert_id();
                    }

                    $partispp=array('var_number' => $vId+10000000 );
                    $wherepp = array('id' => $vId);
                    $this->mod_common->update_table('project_variations', $wherepp, $partispp);
                }



        if ($porders) {
            if (isset($_POST['pmcosting_part_id'])) {               
             
                $cpi = count($this->input->post('pmcosting_part_id'));
                $part_name = array_values($this->input->post('pmpart'));
                $component_id = array_values($this->input->post('pmcomponent'));
                $costing_uom = array_values($this->input->post('pmuom'));
                $costing_part_id = array_values($this->input->post('pmcosting_part_id'));
                $costing_uc = array_values($this->input->post('order_unit_cost'));
                $old_cost = array_values($this->input->post('pmucost'));
                $line_cost = array_values($this->input->post('total_order'));
                $order_quantity = array_values($this->input->post('pmmanualqty'));
                $margin = array_values($this->input->post('pmmargin'));
                $line_margin = array_values($this->input->post('pmmargin_line'));
                $stage_id = array_values($this->input->post('pmstage'));
                $supplier_id = array_values($this->input->post('pmsupplier'));
                $client_allowance = array_values($this->input->post('pmclient_allowance'));
                $include_in_specification = array_values($this->input->post('pminclude_in_specification'));
                $marginaddcost_line = array_values($this->input->post('marginaddprojectcost_line'));
                $pmstatus = array_values($this->input->post('pmstatus'));
                $pmcomments = array_values($this->input->post('pmcomments'));
                
               

                for ($i = 0; $i < $cpi; $i++) {
                    
                    $where = array('purchase_order_id' => $porders, 'costing_part_id' => $costing_part_id[$i]);

                    $is_purchase_order_items = $this->mod_common->select_single_records('project_purchase_order_items', $where);

                   if(count($is_purchase_order_items)>0){
                       $part = array(
                        'part_name' => $part_name[$i],
                        'component_id' => $component_id[$i],
                        'costing_uom' => $costing_uom[$i],
                        'costing_uc' => $costing_uc[$i],
                        'line_cost' => $line_cost[$i],
                        'order_quantity' => $order_quantity[$i],
                        'stage_id' => $stage_id[$i],
                        'supplier_id' => $supplier_id[$i],
                        'margin' => $margin[$i],
                        'line_margin' => $line_margin[$i],
                        'comment' => $pmcomments[$i]
                    );

                    $parts = $this->mod_common->update_table('project_purchase_order_items', $where, $part);
                    
                   }
                   else{
                    if($order_quantity[$i]>0){
                            $part = array(
                                'purchase_order_id' => $porders,
                                'part_name' => $part_name[$i],
                                'component_id' => $component_id[$i],
                                'costing_uom' => $costing_uom[$i],
                                'costing_part_id' => $costing_part_id[$i],
                                'costing_uc' => $costing_uc[$i],
                                'line_cost' => $line_cost[$i],
                                'order_quantity' => $order_quantity[$i],
                                'stage_id' => $stage_id[$i],
                                'supplier_id' => $supplier_id[$i],
                                'margin' => $margin[$i],
                                'line_margin' => $line_margin[$i],
                                'comment' => $pmcomments[$i]
                            );

                            $parts = $this->mod_common->insert_into_table('project_purchase_order_items', $part);
                        }
                    
                   }
                   if(($this->input->post('creatvariation'))== 1 && $order_quantity[$i]>0 && ($costing_uc[$i]!=$old_cost[$i])){

                       $where = array('variation_id' => $vId, 'costing_part_id' => $costing_part_id[$i]);

                       $is_variation_items = $this->mod_common->select_single_records('project_variation_parts', $where);
                       
                       
                       if(count($is_variation_items)>0){
                          
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],
                            'supplier_id' => $supplier_id[$i],
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'allowance_check' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $line_cost[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $pmstatus[$i],
                            'is_line_locked' => 0,
                            'include_in_specification' => $include_in_specification[$i],
                            'component_uc' => $costing_uc[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' =>1,
                            'available_quantity' => 0,
                            'change_quantity' => 0,
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $marginaddcost_line[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );

                        $this->mod_common->update_table('project_variation_parts', $where, $part);                        
                        $vpid = $is_variation_items["id"];                       
                        
                       }
                       else{
                           
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],
                            'supplier_id' => $supplier_id[$i],
                            'costingpartid_var' => $costing_part_id[$i],                            
                            'costing_part_id' => $costing_part_id[$i],
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'allowance_check' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $line_cost[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $pmstatus[$i],
                            'is_line_locked' => 0,
                             'include_in_specification' => $include_in_specification[$i],
                            'component_uc' => $costing_uc[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'change_quantity' => 0,
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $marginaddcost_line[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );
                         
                        $vpid = $this->mod_common->insert_into_table('project_variation_parts', $part);                   
                       }
                       $where = array("costing_part_id" => $costing_part_id[$i]);
                            $is_project_costing = $this->mod_common->select_single_records('project_costing_parts', $where);
                            if(count($is_project_costing)>0){
                                     $part = array(
                                    'stage_id' => $stage[$i],
                                    'component_id' => $component_id[$i],
                                    'costing_part_name' => $part_name[$i],
                                    'costing_uom' => $costing_uom[$i],
                                    'margin' => $margin[$i],
                                    'line_cost' => $linttotal[$i],
                                    'line_margin' => $line_margin[$i],
                                    'costing_uc' => $costing_uc[$i],
                                    'costing_supplier' => $supplier_id[$i],
                                    'costing_quantity' => $order_quantity[$i],
                                    'is_variated' => 0,
                                    'isp_variated' => 0
                                   );
                               
                                  // $this->mod_common->update_table('project_costing_parts', $where, $part);
                            }
                    }
                }
            }
			
			
			 
            if (isset($_POST['component'])) {

                $count = 0;
                $cpi = count($this->input->post('component'));
                $part_name = array_values($this->input->post('part'));
                $component_id = array_values($this->input->post('component'));
                $stage_id = array_values($this->input->post('stage'));
                $supplier_id = array_values($this->input->post('supplier_id'));
                $costing_uom = array_values($this->input->post('uom'));
                $costing_part_id = array_values($this->input->post('costing_part_id'));
                $costing_uc = array_values($this->input->post('ucost'));
                $linttotal = array_values($this->input->post('linttotal'));
                $order_quantity = array_values($this->input->post('manualqty'));
                $include_in_specification = array_values($this->input->post('include_in_specification'));
                $client_allowance = array_values($this->input->post('allowance'));
                $margin = array_values($this->input->post('margin'));
                $status = array_values($this->input->post('status'));
                $line_margin = array_values($this->input->post('margin_line'));
                $useradditionalcost = array_values($this->input->post('useradditionalcost'));
                $marginaddcost_line = array_values($this->input->post('marginaddcost_line'));
                $srno = array_values($this->input->post('srno'));
                $comments = array_values($this->input->post('comments'));

                
				for ($i = 0; $i < $cpi; $i++) {
                    
                     $where = array('costing_tpe_id' => $porders, 'costing_part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i]);
                            $is_project_costing = $this->mod_common->select_single_records('project_costing_parts', $where);
                           
                            if(count($is_project_costing)>0){
                                
                             $part = array(
                            'costing_id' => $this->input->post('costing_id'),
                            'stage_id' => $stage_id[$i],
                            'component_id' => $component_id[$i],
                            'costing_part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i],
                            'costing_uom' => $costing_uom[$i],
                            'client_allowance' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'line_cost' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_locked' => 0,
                            'include_in_specification' => $include_in_specification[$i],
                            'costing_uc' => $costing_uc[$i],
                            'costing_quantity' => $order_quantity[$i],
                            'costing_part_status' => 1,
                            'is_variated' => ($vId) ? $vId : 0,
                            'isp_variated' => $vpid,
                            'comment' => $comments[$i]
                        );
                       
                         $this->mod_common->update_table('project_costing_parts', $where, $part);
                         $cpid = $is_project_costing["costing_part_id"];

                        }
                        else{
                             
                        $part = array(
                            'costing_id' => $this->input->post('costing_id'),
                            'stage_id' => $stage_id[$i],
                            'component_id' => $component_id[$i],
                            'costing_part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i],
                            'costing_uom' => $costing_uom[$i],
                            'client_allowance' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'line_cost' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'quantity_formula' => '',
                            'formula_text' => '',
                            'line_margin' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_locked' => 0,
                            'include_in_specification' => $include_in_specification[$i],
                            'costing_uc' => $costing_uc[$i],
                            'costing_supplier' => $supplier_id[$i],
                            'costing_quantity' => $order_quantity[$i],
                            'costing_part_status' => 1,
                            'is_variated' => ($vId) ? $vId : 0,
                            'isp_variated' => $vpid,
                            'costing_type' => 'pvar' ,
                            'costing_tpe_id' => $porders,
                             'comment' => $comments[$i]
                        );                        
                        
                        $cpid = $this->mod_common->insert_into_table('project_costing_parts', $part);
                        }

                    $where = array('purchase_order_id' => $porders, 'costing_part_id' => $cpid);

                    $is_purchase_order_items = $this->mod_common->select_single_records('project_purchase_order_items', $where);
                    
                    if(count($is_purchase_order_items)>0){
                       
                    $part = array(
                        'part_name' => $part_name[$i],
                        'component_id' => $component_id[$i],
                        'costing_uom' => $costing_uom[$i],
                        'costing_uc' => $costing_uc[$i],
                        'line_cost' => $linttotal[$i],
                        'order_quantity' => $order_quantity[$i],
                        'stage_id' => $stage_id[$i],
                        'margin' => $margin[$i],
                        'line_margin' => $line_margin[$i],
                        'srno' => $srno[$i],
                        'comment' => $comments[$i]
                    );

                    if(($this->input->post('creatvariation'))== 1){

                        $part['part_name']= 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i];

                    }

                    $this->mod_common->update_table('project_purchase_order_items', $where, $part);
                    $poiid = $is_purchase_order_items["id"];
                  
                        
                    }
                    else{
                      
                    $part = array(
                        'purchase_order_id' => $porders,
                        'part_name' => $part_name[$i],
                        'component_id' => $component_id[$i],
                        'supplier_id' => $supplier_id[$i],
                        'costing_uom' => $costing_uom[$i],
                        'costing_part_id' => $cpid,
                        'costing_uc' => $costing_uc[$i],
                        'line_cost' => $linttotal[$i],
                        'order_quantity' => $order_quantity[$i],
                        'stage_id' => $stage_id[$i],
                        'margin' => $margin[$i],
                        'line_margin' => $line_margin[$i],
                        'srno' => $srno[$i],
                        'comment' => $comments[$i]
                    );

                    if(($this->input->post('creatvariation'))== 1){

                        $part['part_name']= 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i];
                    }

                    $poiid = $this->mod_common->insert_into_table('project_purchase_order_items', $part);

                    }

                    if(($this->input->post('creatvariation'))== 1){

                       $where = array('variation_id' => $vId, 'costing_part_id' => $cpid);

                       $is_variation_items = $this->mod_common->select_single_records('project_variation_parts', $where);
                       
                       
                       if(count($is_variation_items)>0){
                          
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'allowance_check' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_line_locked' => 0,
                            'include_in_specification' => $include_in_specification[$i],
                            'component_uc' => $costing_uc[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'change_quantity' => $order_quantity[$i],
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $useradditionalcost[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );

                        $this->mod_common->update_table('project_variation_parts', $where, $part);                        
                        $vpid = $is_variation_items["id"];                       
                        
                       }
                       else{
                           
                           $part = array(
                            'is_including_pc' => 0,
                            'variation_id' => $vId,
                            'stage_id' => $stage_id[$i],
                            'costingpartid_var' => $cpid,                            
                            'costing_part_id' => $cpid,
                            'component_id' => $component_id[$i],
                            'part_name' => 'Variation Number: '.$this->input->post('var_number').' (PO Number '.$porders.' ) , '.$part_name[$i],
                            'component_uom' => $costing_uom[$i],
                            'allowance_check' => $client_allowance[$i],
                            'margin' => $margin[$i],
                            'linetotal' => $linttotal[$i],
                            'quantity_type' => 'manual',
                            'formulaqty' => '',
                            'formulatext' => '',
                            'margin_line' => $line_margin[$i],
                            'type_status' => $status[$i],
                            'is_line_locked' => 0,
                            'include_in_specification' => $include_in_specification[$i],
                            'component_uc' => $costing_uc[$i],
                            'supplier_id' => $supplier_id[$i],
                            'quantity' => $order_quantity[$i],
                            'status_part' => 1,
                            'available_quantity' => 0,
                            'change_quantity' => $order_quantity[$i],
                            'updated_quantity' => $order_quantity[$i],
                            'useradditionalcost' => $useradditionalcost[$i],
                            'marginaddcost_line' => $marginaddcost_line[$i]
                        );
                         
                        $vpid = $this->mod_common->insert_into_table('project_variation_parts', $part);                   
                       }                                            
                    }
                	}
                }

                if(($this->input->post('creatvariation'))== 1){
                    $this->db->trans_complete();
                }
            }
            
            if($purchase_order_status=="Pending"){
                if($first_selected_supplier > 0){
                $where = array("purchase_order_id" => $porders);
                $upd_array = array("supplier_id" => $first_selected_supplier);
                
                $this->mod_common->update_table("project_purchase_order_items", $where, $upd_array);

			    }
				$this->session->set_flashdata('ok_message', 'Purchase Order updated successfully!');
				redirect(SURL."purchase_orders/update_porder/".$porders);
			}
			else{
			    if($first_selected_supplier > 0){
                $where = array("purchase_order_id" => $porders);
                $upd_array = array("supplier_id" => $first_selected_supplier);
                
                $this->mod_common->update_table("project_purchase_order_items", $where, $upd_array);

			    }
			    $this->session->set_flashdata('ok_message', 'Purchase Order updated successfully!');
				redirect(SURL."purchase_orders/pporder/".$porders);
			}
        }
        
    //Get Costing Stages by Supplier
    function getCostingStagesByCostingandSupplier() {
    
        $costing_id = $this->input->post('costing_id');
        $supplier_id = $this->input->post('supplier_id');
        $option ='';
        if ($costing_id > 0 && $supplier_id) {
    
        $q= $this->db->query("SELECT id FROM project_purchase_orders WHERE order_status='Cancelled'");
        $purchase_orders = $q->result_array();
        $purchase_orders_id = array();
        foreach($purchase_orders as $val){
            $purchase_orders_id[]= $val['id'];
            
        }
        $purchase_orders_id = implode(",",$purchase_orders_id);
        $ids = explode(",", $purchase_orders_id);
        
        $company_id = $this->session->userdata('company_id');
    
        $this->db->select(array("cp.*","c.component_name", "s.stage_name"));
        $this->db->from("project_costing pc");
        $this->db->join("project_costing_parts cp","pc.costing_id=cp.costing_id");
        $this->db->join("project_components c","cp.component_id=c.component_id");
        $this->db->join("project_purchase_order_items po","po.costing_part_id=cp.costing_part_id","left");
        $this->db->join("project_stages s","s.stage_id=cp.stage_id","left");
        $this->db->where("cp.costing_part_status",1);
        $this->db->where("cp.costing_supplier",$supplier_id);
        $this->db->where("cp.costing_id",$costing_id);
        $this->db->where("pc.company_id",$company_id);
        $this->db->group_by("cp.costing_part_id");
    
    
        $query = $this->db->get();
       // echo $this->db->last_query();exit;
        $result = $query->result();
        $data['partDetail'] = $result;
        $is_stage_display = 0;
        $stagesList = array();
            if(count($data['partDetail'])>0){
        foreach ($data['partDetail'] as $key => $value) {
            
            $ordered_quantity = get_ordered_quantity($value->costing_part_id);
            $updated_quantity = get_recent_quantity($value->costing_part_id);
            if(count($updated_quantity)>0){
           
                 $remaining_quantity = $updated_quantity['updated_quantity'] - $ordered_quantity;
            
            }
            else{
               $remaining_quantity = $value->costing_quantity - $ordered_quantity; 
            }
            if($remaining_quantity>0){
                $is_stage_display++;
            }
            if($is_stage_display>0 && !in_array($value->stage_id, $stagesList)){
            $stagesList[] = $value->stage_id;
            $option .='<option value="' . $value->stage_id . '">' . $value->stage_name . '</option>';
            }
        }
            }
          $return_arr = array(
            "costing_id" => $costing_id,
            "option" => $option
          );
          echo json_encode($return_arr);
        }
      }
      
    //Repopulate All Available Components
    function repopulate_all_available_components(){
        
        $costing_id = $this->input->post('costingId');
        $porder_id = $this->input->post('porder_id');
        $company_id = $this->session->userdata('company_id');
        
        $q= $this->db->query("SELECT costing_part_id FROM project_purchase_order_items WHERE purchase_order_id = $porder_id");
        $purchase_orders = $q->result_array();
        $costing_part_id_list = array();
        foreach($purchase_orders as $val){
            $costing_part_id_list[]= $val['costing_part_id'];
            
        }
        $costing_part_id = implode(",", $costing_part_id_list);
        $ids = explode(",", $costing_part_id);
        
        $supplier_id_list = 0;
        $stage_id_list = 0;
        
        if($this->input->post('supplier_id')!=""){
            $supplier_id = implode(",", $this->input->post('supplier_id'));
            $supplier_id_list = explode(",", $supplier_id);
        }
        
        if($this->input->post('stage_id')!=""){
            $stage_id = implode(",", $this->input->post('stage_id'));
            $stage_id_list = explode(",", $stage_id);
        }
            
    
        $this->db->select(array("cp.*","c.component_name", "sup.supplier_name", "s.stage_name"));
        $this->db->from("project_costing pc");
        $this->db->join("project_costing_parts cp","pc.costing_id=cp.costing_id");
        $this->db->join("project_components c","cp.component_id=c.component_id");
        $this->db->join("project_suppliers sup","cp.costing_supplier=sup.supplier_id");
        $this->db->join("project_stages s","s.stage_id=cp.stage_id");
        $this->db->where("cp.costing_part_status",1);
        $this->db->where("cp.costing_id",$costing_id);
        $this->db->where("cp.client_allowance",0);
        $this->db->where("pc.company_id",$company_id);
        if($supplier_id_list!=0){
            $this->db->where_in("cp.costing_supplier",$supplier_id_list);
        }
        if($stage_id_list!=0){
            $this->db->where_in("cp.stage_id",$stage_id_list);
        }
        $this->db->where_not_in("cp.costing_part_id",$ids);
        $this->db->group_by("cp.costing_part_id");
    
    
        $query = $this->db->get();
        $result = $query->result();
        
      
        $data['partDetail'] = $result;
        
    	
    	$data['porder_id'] = $porder_id;
    	
        $data['last_row'] = $this->input->post("last_row");
        $html = $this->load->view('purchase_orders/add_all_part_by_costpart_id', $data, true);
    
        echo $html;
        }
    
    /* Email Message */
    
    //Get Email Template
    function email_message()
	{		
	    $this->mod_common->is_company_page_accessible(98);
		$data['email_message'] = $this->mod_email_message->get_email_template();
		$this->stencil->title('Email Message');
	    $this->stencil->paint('email_message/manage_email_message', $data);
	}
    
    //Edit Email Message Screen
	public function edit_email_message(){
		$this->mod_common->is_company_page_accessible(98);
		$data['email_message'] = $this->mod_email_message->get_email_template();
		#--------------- load view--------------#
		$this->stencil->title('Edit Email Message');
	    $this->stencil->paint('email_message/edit_email_message', $data);
		
	}
	
	//Update Email Message Screen
	public function update_email_message()
	{
		if($this->input->post('email_message_id')){
			$this->mod_email_message->update_email_template();
		}else{
		     $this->session->set_flashdata('err_message', 'Email Message ID is missing.');
		     redirect(SURL . 'purchase_orders/email_message');
		}
		
		 redirect(SURL . 'purchase_orders/email_message');
	
	}
}