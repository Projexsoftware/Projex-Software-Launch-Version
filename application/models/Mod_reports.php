<?php

class Mod_reports extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    // get supplier invoice invoice amount by costing part id
    function getsiiabycpi($costing_part_id) {

        $query = "SELECT sii.quantity, sii.invoice_amount"
            . " FROM  project_supplier_invoices_items sii "
            . " INNER JOIN project_supplier_invoices si ON (sii.supplier_invoice_id = si.id)"
            . " WHERE si.status != 'Pending' AND sii.costing_part_id='".$costing_part_id."'";
        $q = $this->db->query($query);
        return $q->result();

    }
    
    function gettotalactualamount($costing_part_id) {

        $query = "SELECT SUM(invoice_amount) as total FROM project_supplier_invoices_items WHERE costing_part_id='".$costing_part_id."'";
        $q = $this->db->query($query);
        return $q->row_array();
    }
    
    function gettotalallowanceamount($costing_part_id){
        $query = "SELECT SUM(a.allocated_amount) as total FROM project_allocated_allowance_items a INNER JOIN  project_supplier_invoices_items si ON si.id = a.supplier_invoice_item_id WHERE a.allocated_allowance_id='".$costing_part_id."'";
        $q = $this->db->query($query);
        //echo $this->db->last_query();exit;
        return $q->row_array();
    }
    
    function getactualamount($costing_part_id) {

        $query = "SELECT invoice_amount as total FROM project_supplier_invoices_items WHERE costing_part_id='".$costing_part_id."'";
        $q = $this->db->query($query);
        return $q->row_array();
    }

    //getinoviceamount by cpart id and costing quantity
    function getiabycpidandcq($costing_part_id,$costingquantity, $type='reports'){

        $remainingquantity=$costingquantity;
        $siia=0;
        // get supplier invoice invoice amount by costing part id
        $siiap=$this->getsiiabycpi($costing_part_id);
        if(count($siiap)){

            foreach($siiap as $ket=> $vat){
                if($remainingquantity<$vat->quantity){

                    $siia+=$vat->invoice_amount/$vat->quantity*$remainingquantity;
                    $remainingquantity=0;

                }
                else{
                    $siia+=$vat->invoice_amount;
                    $remainingquantity-=$vat->quantity;

                }
            }
            if($type!='sales')
                return $siia;
            else{
                if($remainingquantity>0)
                    $completely_invoiced=0;
                else{
                    $completely_invoiced=1;
                }

                return $re_arr = array('total' => $siia, 'completely_invoiced' => $completely_invoiced);
            }
        }
        else{
            if($type=='sales'){
            return array();
            }
            else{
                return 0;
            }
        }
    }

    function getsoavbycid($costing_id, $type){

        $query = "SELECT SUM(project_contract_price) as sum_var_contract_price"
            . " FROM  project_variations "
            . " WHERE status != 'PENDING' AND var_type='".$type."' AND costing_id='".$costing_id."'";
        $q = $this->db->query($query);
        return $q->result();
    }

    function getextracostvarebyvarid($var_id, $costing_id=0, $type='report'){
        
        $iav=0;
        $this->load->model('mod_common', 'common');


        static $tinvoicedquantity = array(); static $counter=0;  static $curr_type;
        $tremainingquantity=array();

        if(!$counter || ($curr_type!= $type)   ){
            $curr_type=$type;
            $existingcostingpartarr = $this->getexistingcostingpartbycostingid($costing_id,'id');
            foreach($existingcostingpartarr as $key => $value){

                $fields = 'costing_quantity';
                $cwhere = array('costing_part_id' => $value);
                $costing_quantity = $this->common->select_single_records('project_costing_parts', $cwhere);

                $tinvoicedquantity[$value]=  $costing_quantity["costing_quantity"];

            }
        }

        $query = "SELECT vp.id, cp.costing_part_id, vp.costingpartid_var, vp.change_quantity, cp.costing_quantity,vp.is_including_pc "
            . " FROM  project_variation_parts vp "
            . " JOIN project_costing_parts cp ON (cp.costing_part_id = vp.costingpartid_var )"
            . " WHERE  vp.variation_id='".$var_id."' UNION"
            . " SELECT vp.id, cp.costing_part_id, vp.costingpartid_var, vp.change_quantity, cp.costing_quantity,vp.is_including_pc "
            . " FROM  project_variation_parts vp "
            . " JOIN project_costing_parts cp ON ( cp.costing_part_id = vp.costing_part_id )"
            . " WHERE  vp.variation_id='".$var_id."' ";


        $q = $this->db->query($query);
        $vars= $q->result_array();
        $completely_invoiced=1;


        foreach($vars as $key => $varparts){

            if($varparts['is_including_pc'] && $varparts['change_quantity']>0){
                if(isset($tinvoicedquantity[$varparts['is_including_pc']])){
                $tremainingquantity[$varparts['is_including_pc']]=$tinvoicedquantity[$varparts['is_including_pc']];
				}
				else{
					$tremainingquantity[$varparts['is_including_pc']]=0;
				}


                $remainingquantity=$varparts['change_quantity'];


                $siia=0;
                // get supplier invoice invoice amount by costing part id
                $siiap=$this->getsiiabycpi($varparts['is_including_pc']);
                if(count($siiap)){

                    foreach($siiap as $ket=> $vat){

                        if($tremainingquantity[$varparts['is_including_pc']]==0 ){


                            if($remainingquantity<$vat->quantity){

                                $siia+=$vat->invoice_amount/$vat->quantity*$remainingquantity;
                                $remainingquantity=0;
                            }
                            else{
                                $siia+=$vat->invoice_amount;
                                $remainingquantity-=$vat->quantity;
                            }

                        }
                        else if($tremainingquantity[$varparts['is_including_pc']]<$vat->quantity  ){

                            if( $remainingquantity<($vat->quantity-$tremainingquantity[$varparts['is_including_pc']]) ){

                                $siia+=$vat->invoice_amount/$vat->quantity*$remainingquantity;
                                $remainingquantity=0;
                            }
                            else if($remainingquantity>=($vat->quantity-$tremainingquantity[$varparts['is_including_pc']]) ){

                                $siia+=($vat->invoice_amount/$vat->quantity)*($vat->quantity-$tremainingquantity[$varparts['is_including_pc']]);
                                $remainingquantity-=$vat->quantity-$tremainingquantity[$varparts['is_including_pc']];
                            }

                            $tremainingquantity[$varparts['is_including_pc']]=0;


                        }

                        else{
                            $tremainingquantity[$varparts['is_including_pc']]-=$vat->quantity;
                        }
                    }
                    $iav+= $siia;
                }

                if($remainingquantity>0){
                    $completely_invoiced=0;
                }
                if(isset($tinvoicedquantity[$varparts['is_including_pc']])){
                $tinvoicedquantity[$varparts['is_including_pc']]+=$varparts['change_quantity']-$remainingquantity;
				}
            }
            else{

                $pp=$this->getiabycpidandcq($varparts['costing_part_id'],$varparts['change_quantity'],$type);
                if($type!='sales')
                    $iav+=$pp;
                else{
                    if(count($pp)>0){
                    $iav=$pp['total'];
                    $completely_invoiced = $pp['completely_invoiced'];
                    }
                }

            }

        }

        $counter++;


        if($type!='sales')
            return $iav;
        else{

            $cwhere = array('id' => $var_id);
            $variation_detail = $this->common->select_single_records('project_variations', $cwhere);
            $opercent= ($variation_detail["overhead_margin"])*$iav/100;
            $ppercent= $variation_detail["profit_margin"]*$iav/100;
            $iav+=$opercent+$ppercent;
            $iav+= $variation_detail["tax"]*$iav/100;
            $variation_cost= $variation_detail["project_subtotal3"];

            return $resultarr= array('total' => $variation_cost ,'completely_invoiced' => $completely_invoiced);
        }

    }

    function getexistingcostingpartbycostingid($costing_id) {
        $this-> db  ->select('costing_part_id')
            ->where('costing_id', $costing_id)
            ->where('is_variated', '0')
            ->where('costing_type', 'normal');
        $get = $this->db->get('project_costing_parts');

        $vars= $get->result_array();
        $resultarr=array();
        foreach ($vars as $key => $val){

            array_push($resultarr, $val['costing_part_id']);
        }
        return $resultarr;
    }

    function gettotalsupplierinvoicepaidbycosting_id($costing_id){


        $query =  " SELECT COALESCE(SUM(invoice_amount),0)  as total_invoice_amount_paid FROM project_supplier_invoices Where status='PAID' AND project_id='".$costing_id."'";

        $get =$this->db->query($query);
        $result=$get->result_array();


        return $result[0]['total_invoice_amount_paid'];

    }

    function gettotalsaleinvoicepaidbyproject_id($project_id){


        $query =  " SELECT COALESCE(SUM(invoice_amount),0)  as total_invoice_amount_paid FROM project_sales_invoices Where status='PAID' AND project_id='".$project_id."'";

        $get =$this->db->query($query);
        $result=$get->result_array();


        return $result[0]['total_invoice_amount_paid'];

    }
    
    function gettotalsalecreditsbyproject_id($project_id){
         $query =  " SELECT COALESCE(SUM(subtotal),0)  as total_sales_credits FROM project_sales_credit_notes Where project_id='".$project_id."'";

        $get =$this->db->query($query);
        $result=$get->result_array();


        return $result[0]['total_sales_credits'];
    }
    
    function gettotalsupplierinvoicebycosting_id($costing_id, $start_date="", $end_date=""){
  
        if($start_date=="" && $end_date==""){
        $query =  " SELECT COALESCE(SUM(invoice_amount),0)  as total_invoice_amount_paid FROM project_supplier_invoices Where project_id='".$costing_id."'" ;
        }
        else{
          $start_date = date("Y-m-d", strtotime(str_replace("/", "-", $start_date)));
          $end_date = date("Y-m-d", strtotime(str_replace("/", "-", $end_date)));
          $query =  " SELECT COALESCE(SUM(invoice_amount),0)  as total_invoice_amount_paid FROM project_supplier_invoices Where project_id='".$costing_id."' AND (STR_TO_DATE(invoice_date, '%d/%m/%Y') BETWEEN '".$start_date."' AND '".$end_date."')" ;  
        }

        $get =$this->db->query($query);
        //echo $this->db->last_query();
        $result=$get->result_array();


        return $result[0]['total_invoice_amount_paid'];

    }

    function gettotalsaleinvoicebyproject_id($project_id, $start_date="", $end_date=""){

        if($start_date=="" && $end_date==""){
        $query =  " SELECT COALESCE(SUM(invoice_amount),0)  as total_invoice_amount_paid FROM project_sales_invoices Where project_id='".$project_id."'" ;
        }
        else{
           $start_date = date("Y-m-d", strtotime(str_replace("/", "-", $start_date)));
          $end_date = date("Y-m-d", strtotime(str_replace("/", "-", $end_date)));
           $query =  " SELECT COALESCE(SUM(invoice_amount),0)  as total_invoice_amount_paid FROM project_sales_invoices Where project_id='".$project_id."' AND (DATE_FORMAT(date_created, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."')"; 
        }

        $get =$this->db->query($query);
        $result=$get->result_array();


        return $result[0]['total_invoice_amount_paid'];

    }
    
     function gettotalcashtransfersbyproject_id($project_id){


        $query =  " SELECT COALESCE(SUM(transfer_amount),0)  as total_transfer_amount_paid FROM"
            . " project_cash_transfers  "

            . " Where project_id='".$project_id."'" ;

        $get =$this->db->query($query);
        $result=$get->result_array();


        return $result[0]['total_transfer_amount_paid'];

    }
    
    function get_extra_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_subtotal1) as total_extra_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='normal'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_variation_cost;
        }
    }

    function get_extra_sales_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_contract_price) as total_extra_sales_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='normal'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_sales_variation_cost;
        }
    }

    function get_extra_po_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_subtotal1) as total_extra_po_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='purord'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_po_variation_cost;
        }
    }

    function get_extra_po_sales_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_contract_price) as total_extra_po_sales_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='purord'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_po_sales_variation_cost;
        }
    }
    function get_extra_sup_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_subtotal1) as total_extra_sup_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='suppinvo'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_sup_variation_cost;
        }
    }
    
    function get_extra_sup_credit_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_subtotal1) as total_extra_sup_credit_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='supcredit'");
        //$query = $this->db->query("SELECT SUM(`component_uc`*`change_quantity`) as total_extra_sup_credit_variation_cost FROM project_variation_parts WHERE variation_id IN (SELECT id From project_variations WHERE project_id='".$project_id."' AND var_type='supcredit')");
        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_sup_credit_variation_cost;
        }
    }
    
    function gettotalbankinterestbyproject_id($project_id){
        $query = $this->db->query("SELECT bank_interest FROM project_projects WHERE project_id='".$project_id."'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->bank_interest;
        }
        
    }
    /*function get_extra_sup_variation_cost($project_id){
        $total_extra_sup_variation_cost = 0;
        $query = $this->db->query("SELECT vp.* FROM project_variation_parts vp INNER JOIN project_variations v ON v.id = vp.variation_id WHERE vp.project_id='".$project_id."' AND v.var_type='suppinvo'");
        if($query->num_rows()>0){
            $result=$query->result();
            foreach($result as $val){
               $total_extra_sup_variation_cost +=get_invoice_amount($val->supplier_id)-$val->component_uc;
            }
            return $total_extra_sup_variation_cost;
        }
    }*/

    function get_extra_sup_sales_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_contract_price) as total_extra_sup_sales_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='suppinvo'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_sup_sales_variation_cost;
        }
    }
    
    function get_extra_sup_credit_sales_variation_cost($project_id){

        $query = $this->db->query("SELECT SUM(project_contract_price) as total_extra_sup_credit_sales_variation_cost FROM project_variations WHERE project_id='".$project_id."' AND var_type='supcredit'");

        $result=$query->row();
        if($query->num_rows()>0){
            return $result->total_extra_sup_credit_sales_variation_cost;
        }
    }
    
    //  AND hide_from_sales_summary=0
    
    
    function get_extra_allowance_cost($costing_id){
        $query = $this->db->query("SELECT SUM(invoice_amount) as total_extra_allowance_cost FROM project_supplier_invoices_items WHERE costing_part_id IN (SELECT costing_part_id FROM  project_costing_parts WHERE client_allowance=1 AND costing_id ='".$costing_id."')");
        $result=$query->row();
        $q = $this->db->query("SELECT sum(line_margin) as project_cost FROM project_costing_parts WHERE client_allowance=1 AND costing_id ='".$costing_id."' AND costing_part_id IN (SELECT costing_part_id FROM project_supplier_invoices_items)");
        $result2 = $q->row();
        if($query->num_rows()>0){
            return $result->total_extra_allowance_cost-$result2->project_cost;
        }
    }

    function get_extra_allowance_sales_cost($project_id){
        $query = $this->db->query("SELECT parts.line_margin, parts.costing_part_id, parts.costing_quantity, costing.tax_percent as tax FROM project_costing_parts parts INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id) INNER JOIN project_sales_invoices_items sii ON (parts.costing_part_id = sii.type_id) WHERE parts.client_allowance=1 AND costing.project_id='".$project_id."' AND sii.type='apd'");
        
        if($query->num_rows()>0){
            $result=$query->result_array();
            $allowance = 0;
            foreach ($result as $val){
            $allowance_cost = ($val['line_margin'])+($val['line_margin']*($val['tax']/100));
            //$invoiced=$this->getiabycpidandcq($val['costing_part_id'],$val['costing_quantity'],'sales');
            $invoiced = $this->gettotalactualamount($val['costing_part_id']);
            $allocated_allowance_amount = $this->gettotalallowanceamount($val['costing_part_id']);
            $invoiced_amount=$invoiced['total']+$allocated_allowance_amount['total'];
            
            $allowance+=(($invoiced_amount)+($invoiced_amount*($val['tax']/100))) - $allowance_cost;
          
            }
            return $allowance;
            
        }
        
    }
    
    function get_total_credit_invoices($costing_id){
        $query = $this->db->query("SELECT SUM(invoice_amount) as total_credit_invoices FROM project_supplier_invoices WHERE project_id ='".$costing_id."' AND invoice_amount<0");
        $result=$query->row();
        if($query->num_rows()>0){
            if($result->total_credit_invoices<0){
               return $result->total_credit_invoices*(-1);
            }
            else{
            return $result->total_credit_invoices;
            }
        }
    }
    
    function get_total_credit_notes($costing_id){
        $query = $this->db->query("SELECT SUM(invoice_amount) as total_credit_notes FROM project_supplier_credits WHERE project_id ='".$costing_id."'");
        $result=$query->row();
        if($query->num_rows()>0){
            if($result->total_credit_notes<0){
               return $result->total_credit_notes*(-1);
            }
            else{
            return $result->total_credit_notes;
            }
        }
        else{
            return array();
        }
    }
    
    function get_variations($project_id, $type){
        //$query = $this->db->query("SELECT * FROM project_variations v INNER JOIN project_variation_parts vp ON vp.variation_id = v.id WHERE v.project_id='".$project_id."' AND v.var_type='".$type."'");
        $query = $this->db->query("SELECT * FROM project_variations WHERE project_id='".$project_id."' AND var_type='".$type."'");
        if($query->num_rows()>0){
            $result=$query->result();
            return $result;
        }
        else{
            return array();
        }
    }
    
     function get_cash_transfers($project_id){
        $query ="SELECT tran.*,pr.project_title, s.supplier_name FROM"
            . " project_cash_transfers tran "
            . " JOIN project_projects pr ON (pr.project_id= tran.project_id)"
            . " JOIN project_suppliers s ON (s.supplier_id =tran.supplier_id) WHERE tran.project_id='".$project_id."'";
        $get = $this->db->query($query);
        if($get->num_rows()>0){
            $result=$get->result_array();
            return $result;
        }
        else{
            return array();
        }
    }
    
    public function get_outstandingp_amount_by_sale_invoice_id($sales_invoices_id){
        $query =  " SELECT si.invoice_amount-COALESCE(SUM(sr.payment),0) as outstanding, COALESCE(SUM(sr.payment),0) as payment  FROM"
                . " project_sales_receipts  sr"
                . " INNER JOIN project_sales_invoices si ON(si.id= sr.sale_invoice_id)"      
                . " Where sr.sale_invoice_id=$sales_invoices_id" ; 

        $get =$this->db->query($query);
        if($get->num_rows()>0){
            $result=$get->result_array();

            return $result;
        }
        else{
            return array();
        }
         
    }
    
    function get_sales_invoices($project_id){ 
        $query ="SELECT sa.*,pr.project_title FROM"
        . " project_sales_invoices sa "      
        . " JOIN project_projects pr ON (pr.project_id= sa.project_id) WHERE sa.project_id ='".$project_id."'"; 

        $get =$this->db->query($query);
        $Sales=$get->result_array();

        foreach ($Sales as $key => $sale) {
            
            $result_arr=$this->get_outstandingp_amount_by_sale_invoice_id($sale['id']);
            $Sales[$key]['outstanding']=$result_arr[0]['outstanding'] ;
            $Sales[$key]['payment']=$result_arr[0]['payment'] ;
        }
        
        return $Sales;
    }
    
    function get_sales_credits($costing_id){ 
        
         $query ="SELECT cr.*,pr.project_title FROM"
            . " project_sales_credit_notes cr "
            . " JOIN project_projects pr ON (pr.project_id= cr.project_id) WHERE cr.project_id = '".$costing_id."'";
            
        $get =$this->db->query($query);
        if($get->num_rows()>0){
            $result=$get->result_array();

            return $result;
        }
        else{
            return array();
        }
            
    }
    
    function get_credit_invoices($costing_id,$type=""){
        if($type==""){
           $query = "SELECT si.*, s.supplier_name FROM project_supplier_invoices si INNER JOIN project_suppliers s ON s.supplier_id = si.supplier_id WHERE si.project_id ='".$costing_id."'";
        }
        else{
           $query = "SELECT si.*, s.supplier_name FROM project_supplier_invoices si INNER JOIN project_suppliers s ON s.supplier_id = si.supplier_id WHERE si.project_id ='".$costing_id."' AND si.id IN (SELECT supplier_invoice_id FROM project_supplier_invoices_items WHERE allocated_allowance_id > 0)";
        }
        $get = $this->db->query($query);
        if($get->num_rows()>0){
            $result=$get->result_array();

            return $result;
        }
        else{
            return array();
        }
    }
    
    function get_allowance_invoices($costing_id, $costing_part_id){
        
        $query = "SELECT sitems.subtotal, sitems.supplier_invoice_id, si.supplierrefrence, s.supplier_name FROM project_supplier_invoices_items sitems INNER JOIN project_supplier_invoices si ON si.id = sitems.supplier_invoice_id LEFT JOIN project_suppliers s ON s.supplier_id = si.supplier_id WHERE si.project_id =".$costing_id." AND (sitems.allocated_allowance_id = ".$costing_part_id." OR sitems.costing_part_id = ".$costing_part_id.")";
        $get = $this->db->query($query);
        if($get->num_rows()>0){
            $result=$get->result_array();
            return $result;
        }
        else{
            return array();
        }
    }
    
    function get_credit_notes($costing_id){
        $query = "SELECT cn.*, s.supplier_name FROM project_supplier_credits cn INNER JOIN project_suppliers s ON s.supplier_id = cn.supplier_id WHERE cn.project_id ='".$costing_id."'";
        $get = $this->db->query($query);
        if($get->num_rows()>0){
            $result=$get->result_array();

            return $result;
        }
        else{
            return array();
        }
    }
    
    function save_tracking_report(){
        $is_selected = $this->input->post('is_selected');
        $title = $this->input->post('title');
        $project_id = $this->input->post('project_id');
        $total_amount = $this->input->post('total_amount');
        $costing_part_id = $this->input->post('selected_costing_parts');
        $data = array(
            "title" =>  $title,
            "project_id" => $project_id,
            "costing_part_ids" => $costing_part_id,
            "total_amount" => $total_amount,
            "company_id" => $this->session->userdata('company_id'),
            "user_id" => $this->session->userdata('user_id'),
            "created_date" => date("Y-m-d H:i:s")
        );

        //print_r($data);exit;
       $insert = $this->db->insert("tracking_report", $data);
      // echo $this->db->last_query();exit;
       // $insert = $this->db->insert("tracking_report",$data);
       if($insert){
        return true;
       }else{
        return false;
       }
    }
    
    function update_tracking_report($id){
       //echo '<pre>';print_r($this->input->post());exit;
        $is_selected = $this->input->post('is_selected');
        $title = $this->input->post('title');
       
        $total_amount = $this->input->post('total_amount');
        $costing_part_id = $this->input->post('selected_costing_parts');
        //echo $costing_part_id;exit;
        $data = array(
            "title" =>  $title,
            "costing_part_ids" => $costing_part_id,
            "total_amount" => $total_amount
        );
       $this->db->where("id", $id);
       $update = $this->db->update("tracking_report", $data);
      
       if($update){
        return true;
       }else{
        return false;
       }
    }

    function get_tracking_groups(){       
        
        $this->db->select(array("tr.*","bp.project_title"));
        $this->db->from("project_tracking_report tr");        
         $this->db->join("project_projects bp","bp.project_id=tr.project_id");
         $this->db->where("tr.company_id",$this->session->userdata('company_id'));
         $this->db->order_by("tr.id","desc");
        $query = $this->db->get();
        return $query->result();

    }

    function delete_tracking($id){       
        $this->db->where("id",$id);
        $this->db->delete("tracking_report");
    }

function get_tracking_reports($id=0){       
        
        $this->db->select(array("tr.*","bp.project_title"));
        $this->db->from("project_tracking_report tr");        
         $this->db->join("project_projects bp","bp.project_id=tr.project_id");
         $this->db->where("tr.company_id",$this->session->userdata('company_id'));
         $this->db->where("tr.id",$id);
        $query = $this->db->get();
        return $query->row();

    }

    function get_group_parts($costing_part_ids){       
       
        $costing_ids = implode(',', $costing_part_ids);
        $this->db->select(array("bcp.costing_part_id", "bcp.costing_part_name", "bcp.costing_uc", "bcp.is_variated", "bcp.costing_quantity", "bs.stage_name","bc.component_name","bcp.line_cost as budget","IFNULL(SUM(sii.invoice_amount),0) - IFNULL(SUM(cn.amount),0) as actual"));
        $this->db->from("project_costing_parts bcp");        
        $this->db->join("project_supplier_invoices_items sii","bcp.costing_part_id = sii.costing_part_id","left");
        $this->db->join("project_sales_credit_note_items cn","bcp.costing_part_id = cn.costing_part_id","left");
        $this->db->join("project_stages bs","bcp.stage_id = bs.stage_id");
         $this->db->join("project_components bc","bcp.component_id = bc.component_id");
        $this->db->where_in("bcp.costing_part_id",$costing_part_ids);
        $this->db->group_by("bcp.costing_part_id");
      
        $query = $this->db->get();  
        $result = $query->result(); 
        //echo $this->db->last_query();exit;
        //print_r($result);exit;
        return $result;

    }
    
    function get_group_parts_stages($costing_part_ids){       
       
        $costing_ids = implode(',', $costing_part_ids);
        $this->db->select(array("bc.component_name","bs.stage_name", "SUM(sii.invoice_amount) as actual", "bcp.component_id", "MAX(bcp.line_cost) as budget", "MAX(bs.stage_id) as stage_id"));
        $this->db->from("project_costing_parts bcp");        
        $this->db->join("project_supplier_invoices_items sii","bcp.costing_part_id = sii.costing_part_id","left");
        $this->db->join("project_stages bs","bcp.stage_id = bs.stage_id");
        $this->db->join("project_components bc","bcp.component_id = bc.component_id");
        $this->db->where_in("bcp.costing_part_id",$costing_part_ids);
        $this->db->group_by("bs.stage_id, bcp.component_id");
      
        $query = $this->db->get();  
        $result = $query->result(); 
        //echo $this->db->last_query();exit;
        //print_r($result);exit;
        return $result;

    }
    
    function get_project_summary($project_id, $start_date, $end_date, $type){
        
        $costing_query = $this->db->query("SELECT costing_id FROM project_costing WHERE project_id='".$project_id."'");
        $costing_info = $costing_query->row_array();
             
        if($type=="supplier_invoices"){
             $start_date = str_replace("/", "-", $start_date);
             $start_date = date("Y-m-d", strtotime($start_date));
             
             $end_date = str_replace("/", "-", $end_date);
             $end_date = date("Y-m-d", strtotime($end_date));
            $query = $this->db->query("SELECT si.supplier_id, si.invoice_amount, si.invoice_date, s.supplier_name FROM project_supplier_invoices si INNER JOIN project_suppliers s ON s.supplier_id = si.supplier_id WHERE si.project_id = '".$costing_info['costing_id']."' AND (STR_TO_DATE(si.invoice_date, '%d/%m/%Y') BETWEEN '".$start_date."' AND '".$end_date."')");
            if($query->num_rows()>0){
               return $query->result_array();
            }
            else{
                return array();
            }
        }
        else if($type=="sales_invoices"){
            
             $start_date = str_replace("/", "-", $start_date);
             $start_date = date("Y-m-d", strtotime($start_date));
             
             $end_date = str_replace("/", "-", $end_date);
             $end_date = date("Y-m-d", strtotime($end_date));
             
             $query = $this->db->query("SELECT si.invoice_amount, si.date_created FROM project_sales_invoices si WHERE si.project_id = '".$project_id."' AND (si.date_created BETWEEN '".$start_date."' AND '".$end_date."')");
                
             if($query->num_rows()>0){
               return $query->result_array();
            }
            else{
                return array();
            }
            
        }
        else if($type=="sales_credit_notes"){
            
             $start_date = str_replace("/", "-", $start_date);
             $start_date = date("Y-m-d", strtotime($start_date));
             
             $end_date = str_replace("/", "-", $end_date);
             $end_date = date("Y-m-d", strtotime($end_date));
             
             $query = $this->db->query("SELECT scn.subtotal, scn.date, s.supplier_name FROM project_sales_credit_notes scn LEFT JOIN project_suppliers s ON s.supplier_id = scn.supplier_id WHERE scn.project_id = '".$costing_info['costing_id']."' AND (STR_TO_DATE(scn.date, '%d-%m-%Y') BETWEEN '".$start_date."' AND '".$end_date."')");
                
             if($query->num_rows()>0){
               return $query->result_array();
            }
            else{
                return array();
            }
            
        }
         else if($type=="supplier_credit_notes"){
             
             $start_date = str_replace("/", "-", $start_date);
             $start_date = date("Y-m-d", strtotime($start_date));
             
             $end_date = str_replace("/", "-", $end_date);
             $end_date = date("Y-m-d", strtotime($end_date));
             $query = $this->db->query("SELECT scn.invoice_amount, scn.invoice_date, s.supplier_name FROM project_supplier_credits scn LEFT JOIN project_suppliers s ON s.supplier_id = scn.supplier_id WHERE scn.project_id = '".$costing_info['costing_id']."' AND (STR_TO_DATE(scn.invoice_date, '%d-%m-%Y') BETWEEN '".$start_date."' AND '".$end_date."')");
             if($query->num_rows()>0){
               return $query->result_array();
            }
            else{
                return array();
            }
         }
     
        
    }
    
    function getAllowanceInvoicesParts($costing_id){
        $query = $this->db->query("SELECT * FROM `project_costing_parts` WHERE `costing_id` = ".$costing_id." AND client_allowance = 1");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        else{
            return array();
        }
    }


}

?>