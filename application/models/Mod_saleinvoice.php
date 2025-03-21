<?php

Class Mod_saleinvoice extends CI_Model {
    
    public function getinvoicedamountbycpid($cp_id) {
        $query = "SELECT (SUM(si.quantity)) as invoicedquantity, SUM(invoice_amount) as invoiced_amount FROM"
                . " supplier_invoices_items si "
                . " WHERE ( (si.supplier_invoice_item_type='pc' AND si.order_pc_id ='" . $cp_id . "') OR si.supplier_invoice_item_type='po' ) AND si.costing_part_id ='" . $cp_id . "'";
        $get = $this->db->query($query);
        return $get->result_array();
    }

    function lastinsertedtemppaymentid() {
      
        $table_name = "temp_payments"; 
        $query ="SHOW TABLE STATUS WHERE name='$table_name'";
        $q = $this->db->query($query);
        $row = $q->result();        
        
        return $row[0]->Auto_increment;
        
        
        
    }
    

    public function gettemppaymentsbycosid($costing_id){

        $this->db->select('*')->where('costing_id', $costing_id);
        $q= $this->db->get('temp_payments');

        return $q->result();

    }
    
    public function get_all_sales_invoices($status=1){
        
        $company_id = $this->session->userdata('company_id');
        $query ="SELECT sa.*,pr.project_title FROM"
        . " project_sales_invoices sa "      
        . " JOIN project_projects pr ON (pr.project_id= sa.project_id) WHERE sa.company_id ='".$company_id."' AND pr.project_status=".$status." ORDER BY id DESC"; 

        $get =$this->db->query($query);
        $Sales=$get->result_array();

        foreach ($Sales as $key => $sale) {
            
            $result_arr=$this->get_outstandingp_amount_by_sale_invoice_id($sale['id']);
            $Sales[$key]['outstanding']=$result_arr[0]['outstanding'] ;
            $Sales[$key]['payment']=$result_arr[0]['payment'] ;
        }
        
        return $Sales;
            
    }

    public function updatesalesinvoice($invoice_id, $increment){


        $query="UPDATE `project_sales_invoices` SET `invoice_amount` = `invoice_amount`+$increment  WHERE `id` = '".$invoice_id."'";

       return $this->db->query($query);    

    }

    public function get_sale_invoice_items_by_type_and_type_id($type_id, $type  ){
        
        $query =  " SELECT sit.*, si.status, si.invoice_number FROM"
                . " project_sales_invoices_items  sit"    
                 . " INNER JOIN project_sales_invoices si ON(si.id= sit.sale_invoice_id)"        
                . " Where sit.type_id=$type_id AND sit.type='".$type."'"; 

        $get =$this->db->query($query);

        return $get->result();



    }

    public function get_outstandingp_amount_by_sale_invoice_items_id($sales_invoices_item_id){

        $query =  " SELECT sit.part_invoice_amount-COALESCE(SUM(sri.payment),0) as outstanding, COALESCE(SUM(sri.payment),0) as payment  FROM"
                . " project_sales_receipts_items  sri"
                . " INNER JOIN project_sales_invoices_items sit ON(sit.id= sri.sale_invoice_item_id)"      
                . " Where sri.sale_invoice_item_id=$sales_invoices_item_id" ; 

        $get =$this->db->query($query);
        //echo $this->db->last_query();exit;
        return $get->result_array();
         
    }

    public function get_outstandingp_amount_by_sale_invoice_id($sales_invoices_id){
        $query =  " SELECT si.invoice_amount-COALESCE(SUM(sr.payment),0) as outstanding, COALESCE(SUM(sr.payment),0) as payment  FROM"
                . " project_sales_receipts  sr"
                . " INNER JOIN project_sales_invoices si ON(si.id= sr.sale_invoice_id)"      
                . " Where sr.sale_invoice_id=$sales_invoices_id" ; 

        $get =$this->db->query($query);
        return $get->result_array();
         
    }

    public function get_sale_invoice_ids_by_project_id($project_id){
        $query =  " SELECT id FROM"
                . " project_sales_invoices"  
                . " Where  project_id=$project_id AND status='PENDING'" ; 


        $get =$this->db->query($query);
        return $resultarr= $get->result_array();
    }

    public  function get_receipt_ids_by_saleinvoice_id($saleinvoice_id, $status='ALL'){
        $query =  " SELECT id FROM"
                . " project_sales_receipts"  
                . " Where  sale_invoice_id=$saleinvoice_id";

        if($status!='ALL')        
            $query .=  " AND status='".$status."'" ; 


        $get =$this->db->query($query);
        return $resultarr= $get->result_array();
    }

     public function updatereceipt($receipt_id, $increment){


        $query="UPDATE `project_sales_receipts` SET `payment` = `payment`+$increment  WHERE `id` = '".$receipt_id."'";

       return $this->db->query($query);    

    }

    
    public function updatereceiptitem($receiptitem_id, $increment){


        $query="UPDATE `project_sales_receipts_items` SET `payment` = `payment`+$increment  WHERE `id` = '".$receiptitem_id."'";

       return $this->db->query($query);    

    }

    public function get_all_sales_receipts(){
           
        $query ="SELECT sr.*,pr.project_title FROM"
        . " project_sales_receipts sr " 
        . " JOIN project_sales_invoices sa ON (sa.id= sr.sale_invoice_id)"     
        . " JOIN project_projects pr ON (pr.project_id= sa.project_id)"; 

        $get =$this->db->query($query);
        return $get->result_array();   
            
    }

    public function get_file_ids($type='sale',$status='PENDING'){
        $query =  " SELECT id FROM"
                . " project_exported_files"  
                . " Where  type='".$type."' AND status='".$status."'";

        
        $get =$this->db->query($query);
        return $resultarr= $get->result_array();
    }

    public function get_all_csv_files(){
        
        $company_id = $this->session->userdata('company_id');
        
        $query ="SELECT ef.* FROM"
        . " project_exported_files ef WHERE ef.company_id = $company_id" ;
       

        $get =$this->db->query($query);
        return $get->result_array(); 
    }

     public function get_allfile_items_by_file_id($file_id){
        
        $query = "SELECT efi.*,cl.client_fname1, cl.client_fname2, cl.client_surname1, cl.client_surname2,cl.client_email_primary, cl.street_pobox, cl.pcountry, cl.client_postal_zip,cl.pstate,  cl.client_postal_city  ";
        $query.= " FROM project_exported_files_items efi "
                . "INNER JOIN project_sales_invoices sa ON(sa.id = efi.InvoiceNumber) "
                . "INNER JOIN project_projects pro ON (pro.project_id = sa.project_id) "
                . "INNER JOIN project_clients cl ON (cl.client_id = pro.client_id) ";
        if($file_id==0){
            $query  .= " JOIN project_exported_files ef ON (ef.id = efi.file_id) ";
            $query.= " WHERE ef.status='Pending'";
        }
        if($file_id!=0)
            $query.= " WHERE efi.file_id = '".$file_id."'";
        $get = $this->db->query($query);

        return $get->result_array();
    }
}

