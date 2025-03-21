<?php

function get_site_preferences() {
     $ci = & get_instance();
    $query = "SELECT * FROM biz_site_preferences where setting_name  in ('site_name','footer_copyright_text','company_phone_number','company_contact_email','facebook','twitter','linkedin','googleplus','youtube','tumblr','stumbleupon','site_footer_about_us_block','company_address','company_fax','contactus_statment')";
    $get = $ci->db->query($query);
	//    echo $ci->db->last_query();exit;
	$data = $get->result_array();
	foreach($data as $key => $val){
		$site_preference[$val['setting_name']]=$val['setting_value'];
	}
	return $site_preference;
}


// handy function to output server side stuff in console
function console_print($data) {

    echo '<script type="text/javascript">';
    echo "console.log('$data')";

    echo '</script>';
}

function get_purchare_order_no($id){
		$ci =& get_instance();
        $ci->load->database();
        $where = array('costing_part_id' => $id );
        
        $ci->db->select(array('GROUP_CONCAT(purchase_order_id SEPARATOR  "," ) as purchase_order_id'));
        $ci->db->from("project_purchase_order_items");
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
        return $result->purchase_order_id;
	}
	
function get_designz_builderz_settings($designz_id){
    $ci =& get_instance();
    $ci->load->database();
        
    $company_id = $ci->session->userdata('company_id');
        
    $query = $ci->db->query("SELECT * FROM project_designz_builderz_settings WHERE company_id='".$company_id."' AND designz_id = ".$designz_id);
    
    return $query->row_array();
}
	
function get_order_items($order_no){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('order_no' => $order_no );
        $ci->db->select("*");
        $ci->db->from("project_online_store_order_items");
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->result_array();
        return $result;
}

function get_order_info($order_no){
       $ci =& get_instance();
        $ci->load->database();
        $where = array('order_no' => $order_no );
        $ci->db->select("*");
        $ci->db->from("project_online_store_orders");
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
}

// hanby funtion to print debug info
function getComponentSuppliers(){
    $ci =& get_instance();
    $ci->load->database();
        
    $company_id = $ci->session->userdata('company_id');
        
    $query = $ci->db->query("SELECT * FROM project_suppliers WHERE company_id='".$company_id."' AND supplier_status = 1 AND parent_supplier_id = 0");
    
    return $query->result_array();
		
}

function get_total_sales_credits($sales_invoice_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT SUM(total) as total_amount FROM project_sales_credit_notes WHERE allocated_invoice_id='".$sales_invoice_id."'");
		
        $row = $query->row_array();
        return $row['total_amount'];
}

function get_uninvoiced_purchase_orders($costing_id, $supplier_id="", $stage_id=""){
    $ci =& get_instance();
    $ci->load->database();
    if($supplier_id!="" && $stage_id == ""){
    $query = $ci->db->query("SELECT cos.line_margin as costing_line_margin, cos.margin as costing_margin, po.supplier_id, sp.supplier_id as po_supplier_id, cos.client_allowance, cos.costing_uc as costing_unit_cost, cos.costing_quantity, po.id, poi.*, c.component_name, s.stage_name, sp.supplier_name as po_supplier_name, sp2.supplier_name  FROM project_purchase_orders po LEFT JOIN project_purchase_order_items poi ON po.id = poi.purchase_order_id LEFT JOIN project_stages s ON s.stage_id = poi.stage_id LEFT JOIN project_components c ON c.component_id = poi.component_id LEFT JOIN project_suppliers sp2 ON sp2.supplier_id = poi.supplier_id LEFT JOIN project_suppliers sp ON sp.supplier_id = po.supplier_id LEFT JOIN project_costing_parts cos ON cos.costing_part_id = poi.costing_part_id WHERE po.costing_id='".$costing_id."' AND (poi.supplier_id IN (".$supplier_id.") OR po.supplier_id IN (".$supplier_id.")) AND po.supplier_invoice_id = 0 AND po.order_status!='Cancelled' AND cos.client_allowance=0");
    }
    else if($supplier_id=="" && $stage_id!= ""){
    $query = $ci->db->query("SELECT cos.line_margin as costing_line_margin, cos.margin as costing_margin, po.supplier_id, sp.supplier_id as po_supplier_id, cos.client_allowance, cos.costing_uc as costing_unit_cost, cos.costing_quantity, po.id, poi.*, c.component_name, s.stage_name, sp.supplier_name as po_supplier_name, sp2.supplier_name  FROM project_purchase_orders po LEFT JOIN project_purchase_order_items poi ON po.id = poi.purchase_order_id LEFT JOIN project_stages s ON s.stage_id = poi.stage_id LEFT JOIN project_components c ON c.component_id = poi.component_id LEFT JOIN project_suppliers sp2 ON sp2.supplier_id = poi.supplier_id LEFT JOIN project_suppliers sp ON sp.supplier_id = po.supplier_id LEFT JOIN project_costing_parts cos ON cos.costing_part_id = poi.costing_part_id WHERE po.costing_id='".$costing_id."' AND poi.stage_id IN (".$stage_id.") AND po.supplier_invoice_id = 0 AND po.order_status!='Cancelled' AND cos.client_allowance=0");
    }
    else if($supplier_id!="" && $stage_id != ""){
    $query = $ci->db->query("SELECT cos.line_margin as costing_line_margin, cos.margin as costing_margin, po.supplier_id, sp.supplier_id as po_supplier_id, cos.client_allowance, cos.costing_uc as costing_unit_cost, cos.costing_quantity, po.id, poi.*, c.component_name, s.stage_name, sp.supplier_name as po_supplier_name, sp2.supplier_name  FROM project_purchase_orders po LEFT JOIN project_purchase_order_items poi ON po.id = poi.purchase_order_id LEFT JOIN project_stages s ON s.stage_id = poi.stage_id LEFT JOIN project_components c ON c.component_id = poi.component_id LEFT JOIN project_suppliers sp2 ON sp2.supplier_id = poi.supplier_id LEFT JOIN project_suppliers sp ON sp.supplier_id = po.supplier_id LEFT JOIN project_costing_parts cos ON cos.costing_part_id = poi.costing_part_id WHERE po.costing_id='".$costing_id."' AND poi.stage_id IN (".$stage_id.") AND (poi.supplier_id IN (".$supplier_id.") OR po.supplier_id IN (".$supplier_id.")) AND po.supplier_invoice_id = 0 AND po.order_status!='Cancelled' AND cos.client_allowance=0");
    }
    else{
       $query = $ci->db->query("SELECT cos.line_margin as costing_line_margin, cos.margin as costing_margin, po.supplier_id, sp.supplier_id as po_supplier_id, cos.client_allowance, cos.costing_uc as costing_unit_cost, cos.costing_quantity, po.id, poi.*, c.component_name, s.stage_name, sp.supplier_name as po_supplier_name, sp2.supplier_name  FROM project_purchase_orders po LEFT JOIN project_purchase_order_items poi ON po.id = poi.purchase_order_id LEFT JOIN project_stages s ON s.stage_id = poi.stage_id LEFT JOIN project_components c ON c.component_id = poi.component_id LEFT JOIN project_suppliers sp2 ON sp2.supplier_id = poi.supplier_id LEFT JOIN project_suppliers sp ON sp.supplier_id = po.supplier_id LEFT JOIN project_costing_parts cos ON cos.costing_part_id = poi.costing_part_id WHERE po.costing_id='".$costing_id."' AND po.supplier_invoice_id = 0 AND po.order_status!='Cancelled' AND cos.client_allowance=0");
     
    }
    return $query->result_array();
    
}

function checkUserProfile(){
        $ci =& get_instance();
        $ci->load->database();
        
        $user_id = $ci->session->userdata('user_id');
        
        $query = $ci->db->query("SELECT * FROM project_users WHERE user_id='".$user_id."' AND com_email !=''");
		
        $no_of_rows = $query->num_rows();
        if($no_of_rows>0){
            return true;
        }
        else{
            return false;
        }
}

function get_template_name($id){
	    $ci =& get_instance();
        $ci->load->database();
        $where = array('template_id' => $id );
		$ci->db->select('template_name');
        $ci->db->from('project_supplierz_templates');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
        return $result->template_name;
	}

function is_request_sent($template_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $user_id = $ci->session->userdata('user_id');
        
        $query = $ci->db->query("SELECT * FROM project_template_requests WHERE from_user_id='".$user_id."' AND template_id='".$template_id."'");
		
        $no_of_rows = $query->num_rows();
        return $no_of_rows;
}

function get_supplierz_part_formula($tpl_part_id){
    $ci =& get_instance();
    $ci->load->database();
    
    $query = $ci->db->query("SELECT tpl_quantity_formula, quantity_formula_text FROM project_supplierz_tpl_component_part WHERE tpl_part_id = ".$tpl_part_id);
    
    $result = $query->row_array();
    return $result;
    
}

function get_document_info($component_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT * FROM project_price_book_component_documents WHERE component_id = '".$component_id."'");
		if($query->num_rows()>0){
            $result = $query->row_array();
		}
		else{
		    $result = array();
		}
		
        return $result;
}
function get_checklist_items($component_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT * FROM project_price_book_component_checklists WHERE component_id = '".$component_id."'");
		
        $result = $query->result_array();
        return $result;
}

function get_checklist_items_for_builders($component_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT * FROM project_component_checklists WHERE component_id = '".$component_id."'");
		
        $result = $query->result_array();
        return $result;
}

function get_part_name($costing_part_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT * FROM project_costing_parts WHERE costing_part_id='".$costing_part_id."'");
		
        $result = $query->row_array();
       
        return $result["costing_part_name"];
}


function get_price_book_user_info($user_id){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT * FROM project_users WHERE user_id='".$user_id."'");
        
        
		
        return $query->row_array();
       
	}
	
function get_price_book_name($price_book_id){
    
        $ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT name FROM project_price_books WHERE id='".$price_book_id."'");
        
        
		
        return $query->row_array();
    
}

function get_price_book_requests_count($supplier_user_id){
     $ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT count(*) as total_requests FROM project_price_book_requests WHERE to_user_id='".$supplier_user_id."' AND status=0");
        
        
		
        $row = $query->row_array();
        return $row['total_requests'];
}

function get_template_requests_count($supplier_user_id){
    $ci =& get_instance();
    $ci->load->database();
	    
    $query = $ci->db->query("SELECT count(*) as total_requests FROM project_template_requests WHERE to_user_id='".$supplier_user_id."' AND status=0");
        
    $row = $query->row_array();
    return $row['total_requests'];
}

function get_confirm_estimate_requests_count($supplier_user_id){
     $ci =& get_instance();
        $ci->load->database();
	    
        
        $query = $ci->db->query("SELECT count(*) as total_requests FROM project_confirm_estimates WHERE supplier_id='".$supplier_user_id."' AND status=1");
        $row = $query->row_array();
        return $row['total_requests'];
}

function get_component_orders_count($supplier_user_id){
     $ci =& get_instance();
        $ci->load->database();
            $query = $ci->db->query("SELECT count(*) as total_requests FROM project_component_purchase_order_items WHERE supplierz_id='".$supplier_user_id."' GROUP BY order_no");
		
        if($query->num_rows()>0){
        $row = $query->row_array();
        return $row['total_requests'];
        }
        else{
            return 0;
        }
}

function get_online_store_orders_count($supplier_user_id){
     $ci =& get_instance();
        $ci->load->database();
            $query = $ci->db->query("SELECT count(*) as total_requests FROM project_online_store_orders WHERE order_no IN (SELECT order_no FROM project_online_store_order_items WHERE supplierz_id='".$supplier_user_id."')");
		
        if($query->num_rows()>0){
        $row = $query->row_array();
        return $row['total_requests'];
        }
        else{
            return 0;
        }
}

function check_price_book_component_image($component_id){
    $ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT image FROM project_price_book_components WHERE id='".$component_id."'");
        
        
		if($query->num_rows()>0){
        $row = $query->row_array();
        return $row['image'];
		}
}

function get_total_supplier_credits($supplier_invoice_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT SUM(supplier_credit_amount) as total_amount FROM project_supplier_credits_items WHERE supplier_invoice_item_id IN (SELECT id FROM project_supplier_invoices_items WHERE supplier_invoice_id=".$supplier_invoice_id.")");
		
        $row = $query->row_array();
        return $row['total_amount'];
}

function get_project_subtotal($costing_id){
	    $ci =& get_instance();
        $ci->load->database();
		$query = $ci->db->query("SELECT SUM(line_margin) as project_subtotal"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.costing_id = '" . $costing_id . "' AND  ((costing_type !='normal' AND costing_part_id  IN (SELECT costing_part_id FROM project_variation_parts WHERE updated_quantity > 0)) OR costing_type ='normal') AND parts.costing_part_status=1");
        $result = $query->row_array();
        return $result["project_subtotal"];
	}

function get_uninvoiced_components($costing_part_id){
	    $ci =& get_instance();
        $ci->load->database();
       
	    $query = $ci->db->query("SELECT IF(sii.quantity,SUM(sii.quantity),0) as invoiced_quantity , ((parts.costing_quantity + IF(v.change_quantity,SUM(v.change_quantity),0)) - sii.quantity) as uninvoiced_quantity,IF(v.change_quantity,SUM(v.change_quantity),0) as change_quantity, IF(v.updated_quantity,SUM(v.updated_quantity),0) as updated_quantity,costing.costing_id AS CostingID,v.variation_id FROM project_costing_parts parts INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id) INNER JOIN project_components com ON (com.component_id = parts.component_id) INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier) INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id) LEFT JOIN project_supplier_invoices_items sii ON (sii.costing_part_id=parts.costing_part_id) LEFT JOIN project_variation_parts v ON (v.costing_part_id = parts.costing_part_id) WHERE sii.costing_part_id = '".$costing_part_id."' GROUP BY parts.costing_part_id,v.id,sii.id");
	     return $query->row();
}

function get_variations_used_in_budget($costingpartid){
	    $ci =& get_instance();
        $ci->load->database();
	    
        $query = $ci->db->query("SELECT * FROM project_variations WHERE id IN (SELECT variation_id FROM project_variation_parts WHERE costing_part_id='".$costingpartid."' OR costingpartid_var = '".$costingpartid."') AND (var_type='suppinvo' OR var_type='normal' OR var_type='supcredit' OR var_type='purord') AND (hide_from_sales_summary=0)");
      
        if($query->num_rows()>0){
           $result = $query->result_array();
        }
        else{
            $result = array();
        }
		
        return $result; 
}

function get_supplier_invoices_used_in_budget($costingpartid, $type=""){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        $query = $ci->db->query("SELECT * FROM project_supplier_invoices WHERE id IN (SELECT supplier_invoice_id FROM project_supplier_invoices_items WHERE costing_part_id='".$costingpartid."')");
       
        if($query->num_rows()>0){
           $result = $query->result_array();
        }
        else{
            $result = array();
        }

        return $result;
	}
	
	function get_variation_amount($costingpartid){
	    $ci =& get_instance();
        $ci->load->database();
	    
        $query = $ci->db->query("SELECT useradditionalcost, component_variation_amount FROM project_variation_parts WHERE (costing_part_id='".$costingpartid."' OR costingpartid_var = '".$costingpartid."') AND variation_id IN (SELECT id FROM project_variations WHERE var_type='suppinvo' OR var_type='normal' OR var_type='supcredit' OR var_type='purord')");
       
        $sumquantity = $query->result();
        
	    $useradditionalcost=0;
		foreach($sumquantity as $key=> $val){
		 
			$useradditionalcost+=$val->useradditionalcost+$val->component_variation_amount;
		 
		}
		
        return $useradditionalcost; 
	}
	
	
function get_variation_amount_excluding_sale_summary($costingpartid){
	    $ci =& get_instance();
        $ci->load->database();
	    
        $query = $ci->db->query("SELECT useradditionalcost, component_variation_amount FROM project_variation_parts WHERE (costing_part_id='".$costingpartid."' OR costingpartid_var = '".$costingpartid."') AND variation_id IN (SELECT id FROM project_variations WHERE (var_type='suppinvo' OR var_type='normal' OR var_type='supcredit' OR var_type='purord') AND hide_from_sales_summary=0)");
       
        $sumquantity = $query->result();
        
	    $useradditionalcost=0;
		foreach($sumquantity as $key=> $val){
		 
			$useradditionalcost+=$val->useradditionalcost+$val->component_variation_amount;
		 
		}
		
        return $useradditionalcost; 
}

function check_is_invoiced($project_id, $timesheet_id){
    $ci =& get_instance();
    $ci->load->database();
	   
    $query = $ci->db->query("SELECT * FROM project_timesheet_supplier_invoices WHERE project_id='".$project_id."' AND timesheet_id ='".$timesheet_id."'");
    if($query->num_rows()>0){
         return $result = $query->row_array();
        }
        else{
        return array();
        }
}

function printme($data, $exit_status = 0) {

    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($exit_status) {
        exit;
    }
}

function get_sales_credit_notes($sales_invoice_id, $invoice_type=""){
	   
		$ci =& get_instance();
        $ci->load->database();
        if($invoice_type=="CN-"){
            
         $query = $ci->db->query("SELECT * FROM project_sales_credit_notes WHERE allocated_invoice_id > 0 AND created_by_invoice_id =".$sales_invoice_id);
           
        }
        else{
           $query = $ci->db->query("SELECT * FROM project_sales_credit_notes WHERE allocated_invoice_id='".$sales_invoice_id."'");
        }
        //echo $ci->db->last_query();
		
        return $query->result_array();
       
	}
	function check_invoice_type($sales_invoice_id){
	    if($sales_invoice_id!=""){
	    $ci =& get_instance();
        $ci->load->database();
	     $query = $ci->db->query("SELECT * FROM project_sales_credit_notes WHERE created_by_invoice_id=".$sales_invoice_id." AND allocated_invoice_id > 0");
    	     if($query->num_rows()>0){
    	         return "CN-";
    	     }
    	     else{
    	         return "INV-";
    	     }
	    }
	    else{
	         return "INV-";
	     }
	}
	function get_invoice_payments($sales_invoice_id){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        
        //$query = $ci->db->query("SELECT * FROM project_sales_credit_notes WHERE allocated_invoice_id='".$sales_invoice_id."' OR created_by_invoice_id ='".$sales_invoice_id."'");
        $query = $ci->db->query("SELECT r.*, p.date FROM project_sales_receipts r INNER JOIN project_payment_history p ON p.sales_receipt_id = r.id WHERE r.sale_invoice_id='".$sales_invoice_id."'");
        
		
        return $query->result_array();
       
	}
	
	function get_supplier_invoice_payments($supplier_invoice_id){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        $query = $ci->db->query("SELECT r.*, p.date FROM project_suppliers_receipts r INNER JOIN project_suppliers_payment_history p ON p.supplier_receipt_id = r.id WHERE r.supplier_invoice_id='".$supplier_invoice_id."'");
        
		
        return $query->result_array();
       
	}
	
	function get_user_company_info($user_id){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('user_id' => $user_id );
        $ci->db->select('*');
        $ci->db->from('project_users');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result['com_name'];
    }
    
    function get_supplierz_company_info($user_id){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('user_id' => $user_id );
        $ci->db->select('*');
        $ci->db->from('project_users');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
    }
	

   function get_company_info(){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('user_id' => $ci->session->userdata('company_id') );
        $ci->db->select('*');
        $ci->db->from('project_users');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
    }

function get_purchase_ordered_items_quantity($costingpartid){
	   
		$ci =& get_instance();
        $ci->load->database();
	
        
        $query = $ci->db->query("SELECT order_quantity FROM project_purchase_order_items WHERE costing_part_id='".$costingpartid."' AND purchase_order_id IN (SELECT id FROM project_purchase_orders WHERE order_status!='Cancelled' AND supplier_invoice_id=0)");
        $sumquantity = $query->result();
		$ordered_quantity=0;
		foreach($sumquantity as $key=> $val){
		 
			$ordered_quantity+=$val->order_quantity;
		 
		}
        return $ordered_quantity;
       
	}
	
function get_allocated_allowance_invoices($costing_part_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT a.supplier_invoice_item_id, si.invoice_amount, s.stage_name, c.component_name, si.part_field, sup.supplier_name FROM project_allocated_allowance_items a LEFT JOIN project_supplier_invoices_items si ON si.id = a.supplier_invoice_item_id LEFT JOIN project_stages s ON s.stage_id = si.stage_id LEFT JOIN project_suppliers sup ON sup.supplier_id = si.supplier_id LEFT JOIN project_components c ON c.component_id = si.component_id WHERE a.allocated_allowance_id='".$costing_part_id."'");
		
        $result = $query->result_array();
       
        return $result;
    }
    
function get_supplier_users(){
        $ci =& get_instance();
        $ci->load->database();
        // Load the Projex database
        $projex_db = $ci->load->database('projex', TRUE);
        $company_id = $ci->session->userdata('company_id');
        //if($ci->session->userdata("user_id")!=1){
          $query = $ci->db->query("SELECT u.*  FROM project_users u INNER JOIN project_supplierz_templates t on t.supplier_id = u.user_id WHERE  u.user_id=1 AND u.company_id = 0 AND u.user_status=1 GROUP BY t.supplier_id");
          $result = $query->result_array();
        /*}
        else{
            $result = array();
        }*/
       
        return $result;
}

function get_template_request_info($template_id){
        $ci =& get_instance();
        $ci->load->database();
        $company_id = $ci->session->userdata('company_id');
        $query = $ci->db->query("SELECT *  FROM project_template_requests WHERE  template_id=".$template_id." AND company_id =".$ci->session->userdata("company_id"));
        if($query->num_rows()>0){
        $result = $query->row_array();
        }
        else{
            $result = array();
        }

        return $result;
}
    
function get_supplier_credit_notes($supplier_invoice_id){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT * FROM project_credit_notes_allocated_invoices WHERE allocated_invoice_id='".$supplier_invoice_id."'");
        
        
		
        return $query->result_array();
       
	}
	
	function get_allocate_supplier_credit_notes($credit_note_id){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT * FROM project_credit_notes_allocated_invoices WHERE credit_note_id='".$credit_note_id."' AND allocated_invoice_id>0");
        
        
		
        return $query->result_array();
       
	}
	
	function get_allocated_supplier_invoice($supplier_invoice_id){
	    	$ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT * FROM project_supplier_invoices WHERE id='".$supplier_invoice_id."'");
        
        
		
        $result = $query->row_array();
        
        return $result["supplierrefrence"]."-".$supplier_invoice_id;
	}
	
function get_allocated_allowances($id){
       $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT * FROM project_allocated_allowance_items WHERE supplier_invoice_item_id='".$id."'");
		
        $result = $query->result_array();
        return $result;
}

function get_supplier_invoice_name($invoice_id){
       $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT distinct(si.supplier_id), s.supplier_name FROM project_supplier_invoices si INNER JOIN project_suppliers s ON s.supplier_id = si.supplier_id WHERE si.id='".$invoice_id."'");
		
        $result = $query->row_array();
    
       return $result["supplier_name"];
        
}

function get_sender_details($id, $type){
        $ci =& get_instance();
        $ci->load->database();
        if($type=="user"){
        $where = array('user_id' => $id );
        $ci->db->select('user_fname as first_name, user_lname as last_name, user_img as image, user_email as email, role_id');
        $ci->db->from('project_users');
        }
        else{
          $where = array('id' => $id );
          $ci->db->select('first_name, last_name, image, email');
          $ci->db->from('admin');  
        }
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
}

function get_ticket_reply_files($id){
	    
	    	$ci =& get_instance();
            $ci->load->database();
        
            $query = $ci->db->query("SELECT * FROM project_ticket_files WHERE ticket_id='".$id."'");
		
            return $query->result_array();
	}

function get_last_reply($id){
        $ci =& get_instance();
        $ci->load->database();
        
          $where = array('ticket_parent' => $id );
          $ci->db->select('from_id_role');
          $ci->db->from('tickets');  
          
        $ci->db->where($where);
        $ci->db->order_by('id', 'DESC'); 
        $ci->db->limit('1');
        $query = $ci->db->get();
        if($query->num_rows()==0){
            $where = array('id' => $id );
          $ci->db->select('from_id_role');
          $ci->db->from('tickets');  
          
        $ci->db->where($where);
        $query = $ci->db->get();
        }
        $result = $query->row_array();
        return $result;
}

function get_xero_credentials(){
    
    $ci =& get_instance();
    $ci->load->database();
	if($ci->session->userdata('company_id')!=""){
    $query = $ci->db->query("SELECT * FROM project_xero_settings WHERE company_id='".$ci->session->userdata('company_id')."'");
        if($query->num_rows()>0){
           $result = $query->result_array();
           return $result[0];
        }
        else{
            return array();
        }
	}
	else{
	    return array();
	}
}

function is_component_have_documents($component_id, $type){
        $ci =& get_instance();
        $ci->load->database();
        if($type=="specification"){
        $query = $ci->db->query("SELECT * FROM project_components WHERE component_id = '".$component_id."' AND specification!=''");
        }
        else if($type=="warranty"){
            $query = $ci->db->query("SELECT * FROM project_components WHERE component_id = '".$component_id."' AND warranty!=''");
        }
        else if($type=="installation"){
            $query = $ci->db->query("SELECT * FROM project_components WHERE component_id = '".$component_id."' AND installation!=''");
        }
        else if($type=="maintenance"){
            $query = $ci->db->query("SELECT * FROM project_components WHERE component_id = '".$component_id."' AND maintenance!=''");
        }
        if($query->num_rows()>0){
            $result = $query->row_array();
            return $result;
        }
        else{
            return array();
        }
}

function display_date($date) {
    return date('d M Y', strtotime($date));
}

function country_dropdown_options($selected = '', $comare_by = 'country_name') {
    $ci = & get_instance();
    $ci->db->dbprefix('countries');
    $ci->db->order_by('country_name', 'asc');
    $get_data = $ci->db->get('countries');
    //echo $ci->db->last_query(); 
    $data = $get_data->result_array();
    $country_options = '<option value="">Select Country </option>';
    foreach ($data as $country) {
        $selected_tag = ($selected == $country[$comare_by]) ? 'selected="selected"' : '';
        $country_options.='<option ' . $selected_tag . ' value="' . $country[$comare_by] . '">' . $country['country_name'] . '</option>';
    }
    //printme($data,1);
    return $country_options;
}

function country_list() {
    $ci = & get_instance();
    $ci->db->dbprefix('countries');
    $ci->db->order_by('country_name', 'asc');
    $get_data = $ci->db->get('countries');
    //echo $ci->db->last_query(); 
    $data = $get_data->result_array();
    return $data;
}

function get_user_info($id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT user_fname as first_name, user_lname as last_name FROM project_users WHERE user_id='".$id."'");
    $row = $query->row_array();
    if($query->num_rows()>0){
    return $row["first_name"]." ".$row["last_name"];
    }
    else{
        return "";
    }
}

function get_users(){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_users WHERE user_status = 1");
    $result = $query->result_array();
    return $result;
}

function get_roles(){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_roles WHERE status = 1");
    $result = $query->result_array();
    return $result;
}

function get_supplierz_users($keyword=""){
    $ci = & get_instance();
    if($keyword == ""){
         $query = $ci->db->query("SELECT u.*, r.permissions FROM project_users u INNER JOIN project_roles r on r.id = u.role_id WHERE u.company_id = 0 AND user_status = 1 AND com_name!='' AND user_id IN (SELECT company_id FROM project_components WHERE list_this_component_in_online_store = 1 AND component_status = 1)");
    }
    else{
         $query = $ci->db->query("SELECT u.*, r.permissions FROM project_users u INNER JOIN project_roles r on r.id = u.role_id WHERE u.company_id = 0 AND user_status = 1 AND com_name LIKE '%".$keyword."%' AND com_name!='' AND user_id IN (SELECT company_id FROM project_components WHERE list_this_component_in_online_store = 1 AND component_status = 1)");   
    }
     
    return $query->result_array($query);
    }
    
    function get_categories($keyword=""){
    $ci = & get_instance();
    if($keyword == ""){
         $query = $ci->db->query("SELECT * FROM project_categories WHERE status = 1");
    }
    else{
         $query = $ci->db->query("SELECT * FROM project_categories WHERE status = 1 AND name LIKE '%".$keyword."%'");   
    }
     
    return $query->result_array($query);
    }

function get_scheduling_users(){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT u.*, r.permissions FROM project_users u INNER JOIN project_roles r on r.id = u.role_id WHERE u.user_id != '".$ci->session->userdata("user_id")."' AND u.company_id = ".$ci->session->userdata("company_id"));
     
    return $query->result_array($query);
    }
    
function get_scheduling_members(){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT u.*, r.permissions FROM project_users u INNER JOIN project_roles r on r.id = u.role_id WHERE u.user_id != ".$ci->session->userdata("user_id"));
     
    return $query->result_array($query);
    }


function create_gallery_thumbnail($filename, $src, $dest, $width = 150, $height = 150) {
    $ci = & get_instance();
//
//    //resize:
    // echo $src."<br>";
    $config_resize['image_library'] = 'gd2';
//    $config_resize['library_path'] = '/usr/bin/mogrify';
    $config_resize['source_image'] = $src;
    $config_resize['quality'] = 80;
    $config_resize['new_image'] = $dest;
//  $config_resize['file_name'] = $filename;
    $config_resize['maintain_ratio'] = FALSE;
    $config_resize['create_thumb'] = FALSE;
    $config_resize['width'] = $width;
    $config_resize['height'] = $height;
//
    // echo $src;
    $data = getimagesize($src);
    $width1 = $data[0];
    $height1 = $data[1];
    if ($width1 != $height1) {

        $config_resize['maintain_ratio'] = TRUE;
        $config_resize['master_dim'] = 'auto';
        $ci->load->library('image_lib');
        $ci->image_lib->initialize($config_resize);
        if ($ci->image_lib->resize()) {

            $dfile = $dest . "/" . $filename;

            $im = imagecreatetruecolor($width, $height);
//        $stamp = imagecreatefromjpeg('img.jpg');

            if (preg_match('/[.](jpg)$/', $filename)) {
                $stamp = imagecreatefromjpeg($dfile);
            } else if (preg_match('/[.](gif)$/', $filename)) {
                $stamp = imagecreatefromgif($dfile);
            } else if (preg_match('/[.](png)$/', $filename)) {
                $stamp = imagecreatefrompng($dfile);
            } else if (preg_match('/[.](jpeg)$/', $filename)) {

                $stamp = imagecreatefromjpeg($dfile);
            } else if (preg_match('/[.](JPG)$/', $filename)) {

                $stamp = imagecreatefromjpeg($dfile);
            }


            $red = imagecolorallocate($im, 15, 117, 187);
            imagefill($im, 0, 0, $red);



            $sx = imagesx($stamp);
            $sy = imagesy($stamp);


            $oy = imagesx($stamp);
            $ox = imagesy($stamp);


            $d = getimagesize($dfile);
            $wd = $d[0];
            $hg = $d[1];

            if ($wd < $width) {
                $mg = $width - $wd;
                $marge_right = $mg / 2;
            } else {
                $marge_right = 0;
            }
            if ($hg < $height) {

                $mgh = $height - $hg;
                $marge_bottom = $mgh / 2;
            } else {
                $marge_bottom = 0;
            }
            $imgg = imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, $sx, $sy);

// echo "resized ".$src;
            header('Content-type: image/png');
            imagejpeg($im, $dfile);
            imagepng($im, $dfile);
            imagedestroy($im);
        } else {

            // echo $ci->image_lib->display_errors();
        }
    } else {

// echo "resized ".$src;
        $ci->load->library('image_lib');
        $ci->image_lib->initialize($config_resize);
        $ci->image_lib->resize();
    }

//      $ci->image_lib->fit();
//
//
//
//    $ci->image_lib->clear();
}

function create_thumbnail($filename, $src, $dest, $width = 100, $height = 100) {
    $ci = & get_instance();
//
//    //resize:
    // echo $src."<br>";
    $config_resize['image_library'] = 'gd2';
//    $config_resize['library_path'] = '/usr/bin/mogrify';
    $config_resize['source_image'] = $src;
    $config_resize['quality'] = 80;
    $config_resize['new_image'] = $dest;
//  $config_resize['file_name'] = $filename;
    $config_resize['maintain_ratio'] = FALSE;
    $config_resize['create_thumb'] = FALSE;
    $config_resize['width'] = $width;
    $config_resize['height'] = $height;
//
    // echo $src;
    $data = getimagesize($src);
    $width1 = $data[0];
    $height1 = $data[1];
    if ($width1 != $height1) {

        $config_resize['maintain_ratio'] = TRUE;
        $config_resize['master_dim'] = 'auto';
        $ci->load->library('image_lib');
        $ci->image_lib->initialize($config_resize);
        if ($ci->image_lib->resize()) {

            $dfile = $dest . "/" . $filename;

            $im = imagecreatetruecolor($width, $height);
//        $stamp = imagecreatefromjpeg('img.jpg');

            if (preg_match('/[.](jpg)$/', $filename)) {
                $stamp = imagecreatefromjpeg($dfile);
            } else if (preg_match('/[.](gif)$/', $filename)) {
                $stamp = imagecreatefromgif($dfile);
            } else if (preg_match('/[.](png)$/', $filename)) {
                $stamp = imagecreatefrompng($dfile);
            } else if (preg_match('/[.](jpeg)$/', $filename)) {

                $stamp = imagecreatefromjpeg($dfile);
            } else if (preg_match('/[.](JPG)$/', $filename)) {

                $stamp = imagecreatefromjpeg($dfile);
            }


            $red = imagecolorallocate($im, 255, 255, 255);
            imagefill($im, 0, 0, $red);



            $sx = imagesx($stamp);
            $sy = imagesy($stamp);


            $oy = imagesx($stamp);
            $ox = imagesy($stamp);


            $d = getimagesize($dfile);
            $wd = $d[0];
            $hg = $d[1];

            if ($wd < $width) {
                $mg = $width - $wd;
                $marge_right = $mg / 2;
            } else {
                $marge_right = 0;
            }
            if ($hg < $height) {

                $mgh = $height - $hg;
                $marge_bottom = $mgh / 2;
            } else {
                $marge_bottom = 0;
            }
            $imgg = imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, $sx, $sy);

// echo "resized ".$src;
            header('Content-type: image/png');
            imagejpeg($im, $dfile);
            imagepng($im, $dfile);
            imagedestroy($im);
        } else {

            // echo $ci->image_lib->display_errors();
        }
    } else {

// echo "resized ".$src;
        $ci->load->library('image_lib');
        $ci->image_lib->initialize($config_resize);
        $ci->image_lib->resize();
    }

//      $ci->image_lib->fit();
//
//
//
//    $ci->image_lib->clear();
}

function create_fixed_thumbnail($filename, $src, $dest, $width = 100, $height = 100) {
    $ci = & get_instance();
//
//    //resize:
    $config_resize['image_library'] = 'gd2';
    $config_resize['library_path'] = '/usr/bin/mogrify';
    $config_resize['source_image'] = $src;
    $config_resize['quality'] = 80;
    $config_resize['new_image'] = $dest;
    $config_resize['maintain_ratio'] = FALSE;
    $config_resize['width'] = $width;
    $config_resize['height'] = $height;


    $ci->load->library('image_lib');
    $ci->image_lib->initialize($config_resize);
    $ci->image_lib->resize();
}

function create_optimize($filename, $src, $dest) {
    $ci = & get_instance();

    //resize:
    $config_resize['image_library'] = 'gd2';
//     $config_resize['library_path'] = '/usr/bin/composite';
    $config_resize['source_image'] = $src;
    $config_resize['quality'] = 80;
    $config_resize['new_image'] = $dest;
    $config_resize['maintain_ratio'] = TRUE;

    $ci->load->library('image_lib');
    $ci->image_lib->initialize($config_resize);
    $ci->image_lib->resize();

    $ci->image_lib->clear();
}

function get_brands() {
    $ci = & get_instance();
    $query = "SELECT * FROM biz_brand LIMIT 4 ";
    $get = $ci->db->query($query);
    return $data = $get->result_array();
}

function get_role_title($role_id) {
    $ci = & get_instance();
    $query = "SELECT role_title FROM project_roles WHERE id='".$role_id."'";
    $get = $ci->db->query($query);
    $data = $get->row_array();
	return $data['role_title'];
}


function get_banner_by_id($id) {
    $ci = & get_instance();
    $query = "SELECT * FROM biz_banner where banner_id='" . $id . "'";
    $get = $ci->db->query($query);
    return $data = $get->row_array();
}

function random_code_generator($len, $number_of_codes) {
    $result = array();
    $chars = "abGTyHqr$*#sTuvwxyz^%67891230";
    $charArray = str_split($chars);
    for ($j = 0; $j < $number_of_codes; $j++) {
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            if ($i == 0) {
                $result[$j] = "" . $charArray[$randItem];
                continue;
            }
            $result[$j] .= "" . $charArray[$randItem];
        }
    }
    return $result;
}


function slider_with_data() {
    $ci = & get_instance();
    $query = "SELECT * FROM biz_front_banner where status ='" . 1 . "' order by sorting_order asc";
    $get = $ci->db->query($query);
//    echo $ci->db->last_query();exit;
    return $data = $get->result_array();
}

function get_driver_zone($zone_id){
  $ci = & get_instance();
  $query = $ci->db->query("SELECT * FROM sixtaxi_zone WHERE id='".$zone_id."'");
  $row = $query->row_array();
  if($query->num_rows()>0){
   return $row['title'];
  }
  else{
   return false;
  }
}

function lastquery() {
    $ci = & get_instance();
    echo $ci->db->last_query();
}
function random_password_generator($len = 8, $number_of_codes = 1) {
    $result = array();
    $chars = "abGTyHqr$*#sTuvwxyz^%67891230";
    $charArray = str_split($chars);
    for ($j = 0; $j < $number_of_codes; $j++) {
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            if ($i == 0) {
                $result[$j] = "" . $charArray[$randItem];
                continue;
            }
            $result[$j] .= "" . $charArray[$randItem];
        }
    }
    return $result[0];
}

function get_time_diff($d){

                $date1 = $d;
                date_default_timezone_set("Pacific/Auckland");
                
                $date2 = date('Y-m-d G:i:s');

                $diff = abs(strtotime($date2) - strtotime($date1));

                $years   = floor($diff / (365*60*60*24)); 

                $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 

                $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

                $minutes  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

                $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
		
if($years!=0){
	if($years==1){
		echo $years." year ago";
	}
	else{
	echo $years." years ago";
	}
}
else if($years==0 && $months!=0){
	if($months==1){
		echo $months." month ago";
	}
	else{
	echo $months." months ago";
	}
}
else if($years==0 && $months==0 && $days!=0){
	if($days==1){
		echo $days." day ago";
	}
	else{
	echo $days." days ago";
	}
}
else if($years==0 && $months==0 && $days==0 && $hours!=0){
	
	if($hours==1){
		echo $hours." hour ago";
	}
	else{
	echo $hours." hours ago";
	}
}
else if($years==0 && $months==0 && $days==0 && $hours==0){
	
	if($minutes==1 || $minutes==0){
		echo $minutes." minute ago";
	}
	else{
	echo $minutes." minutes ago";
	}
}
else if($years==0 && $months==0 && $days==0 && $hours==0 && $minutes==0){
	
	if($seconds==1){
		echo $seconds." second ago";
	}
	else{
	echo $seconds." seconds ago";
	}
}

	}
function admin_menu_tree() {

    $ci = & get_instance();
    $ci->db->dbprefix('admin_menu');
    $ci->db->where('parent_id', '0');
    $ci->db->where('show_in_nav', '1');
    $ci->db->where('status', '1');
    $ci->db->order_by('display_order', 'asc');
    $get_data = $ci->db->get('menu');
    $data = $get_data->result_array();

    foreach ($data AS $key => $val) {
        $sub_items = get_sub_menu($val['id']);
        $data[$key]["sub_item"] = $sub_items;
    }
    return $data;
}

function get_sub_menu($parent_id) {
    $ci = & get_instance();
    $ci->db->dbprefix('menu');
    $ci->db->where('parent_id', $parent_id);
    $ci->db->where('show_in_nav', '1');
    $ci->db->order_by('display_order', 'asc');
    $get_data = $ci->db->get('menu');
    $data = $get_data->result_array();
    return $data;
}

function get_project_team($project_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT t.*, u.user_fname as first_name, u.user_lname as last_name FROM project_scheduling_team t INNER JOIN project_users u ON u.user_id = t.team_id WHERE t.project_id='".$project_id."' ORDER BY t.team_role ASC");
    return $query->result_array();
}

function get_project_item_by_stage($stage_id, $project_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.stage_id = '".$stage_id."' AND pi.project_id ='".$project_id."' ORDER BY pi.priority ASC");
    return $query->result_array();
}

function get_task_name($id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT name FROM project_scheduling_tasks WHERE id = '".$id."'");
    $result = $query->row_array();
    return $result['name'];
}

function get_buildz_task_name($id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT name FROM project_buildz_tasks WHERE id = '".$id."'");
    $result = $query->row_array();
    return $result['name'];
}

function get_project_name($id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT project_title FROM project_projects WHERE project_id = '".$id."'");
    $result = $query->row_array();
    return $result['project_title'];
}

function get_project_id_from_costing_id($id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT project_id FROM project_costing WHERE costing_id = '".$id."'");
    $result = $query->row_array();
    return $result['project_id'];
}

function get_scheduling_project_name($id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT name as project_title FROM project_scheduling_projects WHERE id = '".$id."'");
    $result = $query->row_array();
    return $result['project_title'];
}

function get_task_checklist($project_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_item_checklists WHERE item_id = '".$item_id."' AND project_id='".$project_id."' ORDER BY id DESC");
    return $query->result_array();
}

function get_task_notes($project_id, $item_id, $current_role){
    $ci = & get_instance();
    if($current_role==1 || $current_role==2){
         $query = $ci->db->query("SELECT * FROM project_scheduling_item_notes WHERE item_id = '".$item_id."' AND project_id='".$project_id."' ORDER BY id DESC");
    }
    else{
        $query = $ci->db->query("SELECT * FROM project_scheduling_item_notes WHERE item_id = '".$item_id."' AND project_id='".$project_id."' AND privacy_settings = 1 ORDER BY id DESC");
    }
    return $query->result_array();
}

function get_task_files($project_id, $item_id, $current_role){
    $ci = & get_instance();
    if($current_role==1 || $current_role==2){
    $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id = '".$item_id."' AND project_id='".$project_id."' AND file_type = 0 ORDER BY id DESC");
    }
    else{
        $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id = '".$item_id."' AND project_id='".$project_id."' AND file_type = 0 AND privacy_settings = 1 ORDER BY id DESC");
    }
    return $query->result_array();
}
function get_task_images($project_id, $item_id, $current_role){
    $ci = & get_instance();
    if($current_role==1 || $current_role==2){
    $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id = '".$item_id."' AND project_id='".$project_id."' AND file_type = 1 ORDER BY id DESC");
    }
    else{
     $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id = '".$item_id."' AND project_id='".$project_id."' AND file_type = 1 AND privacy_settings = 1 ORDER BY id DESC");
    }
    return $query->result_array();
}

function get_task_reminders($project_id, $item_id, $current_role){
    $ci = & get_instance();
    if($current_role==1 || $current_role==2){
    $query = $ci->db->query("SELECT r.*, u.email FROM project_scheduling_item_reminders r INNER JOIN project_scheduling_reminder_users u ON u.id = r.to_id WHERE r.item_id = '".$item_id."' AND r.project_id='".$project_id."' ORDER BY r.id DESC");
    }
    else{
        $query = $ci->db->query("SELECT r.*, u.email FROM project_scheduling_item_reminders r INNER JOIN project_scheduling_reminder_users u ON u.id = r.to_id WHERE r.item_id = '".$item_id."' AND r.project_id='".$project_id."' AND r.privacy_settings = 1 ORDER BY r.id DESC");
    }
    return $query->result_array();
}

function get_task_reminder_users($task_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_reminder_users WHERE task_id = '".$task_id."' ORDER BY id DESC");
    return $query->result_array();
}

function get_stage_status($project_id, $stage_id, $total_items){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_items WHERE stage_id = '".$stage_id."' AND project_id = '".$project_id."' AND status=0 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records==$total_items){
     return 0;exit;
    }

    $query = $ci->db->query("SELECT * FROM project_scheduling_items WHERE stage_id = '".$stage_id."' AND project_id = '".$project_id."' AND status=1 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records>0){
     return 1;exit;
    }

    $query = $ci->db->query("SELECT * FROM project_scheduling_items WHERE stage_id = '".$stage_id."' AND project_id = '".$project_id."' AND status=2 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records==$total_items){
     return 2;exit;
    }
    else{
      return 1;exit;
    } 

}

//Suuplierz Buildz Templates Functions

function get_buildz_template_item_by_stage($stage_id, $template_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT t.name as task_name, pi.* FROM project_buildz_template_items pi INNER JOIN project_buildz_tasks t ON t.id = pi.task_id WHERE pi.stage_id = '".$stage_id."' AND pi.template_id ='".$template_id."' ORDER BY pi.priority ASC");
    return $query->result_array();
}

function get_buildz_template_task_checklist($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_buildz_template_item_checklists WHERE item_id = '".$item_id."' AND template_id='".$template_id."' ORDER BY id DESC");
    return $query->result_array();
}

function get_buildz_template_task_notes($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_buildz_template_item_notes WHERE item_id = '".$item_id."' AND template_id='".$template_id."' ORDER BY id DESC");
    return $query->result_array();
}

function get_buildz_template_task_files($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_buildz_template_item_files WHERE item_id = '".$item_id."' AND template_id='".$template_id."' AND file_type = 0 ORDER BY id DESC");
    return $query->result_array();
}
function get_buildz_template_task_images($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_buildz_template_item_files WHERE item_id = '".$item_id."' AND template_id='".$template_id."' AND file_type = 1 ORDER BY id DESC");
    return $query->result_array();
}

function get_buildz_template_task_reminders($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT r.*, u.email FROM project_buildz_template_item_reminders r INNER JOIN project_buildz_reminder_users u ON u.id = r.to_id WHERE r.item_id = '".$item_id."' AND r.template_id='".$template_id."' ORDER BY r.id DESC");
    return $query->result_array();
}

function get_buildz_template_stage_status($template_id, $stage_id, $total_items){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_buildz_template_items WHERE stage_id = '".$stage_id."' AND template_id = '".$template_id."' AND status=0 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records==$total_items){
     return 0;exit;
    }

    $query = $ci->db->query("SELECT * FROM project_buildz_template_items WHERE stage_id = '".$stage_id."' AND template_id = '".$template_id."' AND status=1 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records>0){
     return 1;exit;
    }

    $query = $ci->db->query("SELECT * FROM project_buildz_template_items WHERE stage_id = '".$stage_id."' AND template_id = '".$template_id."' AND status=2 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records==$total_items){
     return 2;exit;
    }

}

//Templates Function

function get_template_item_by_stage($stage_id, $template_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_template_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.stage_id = '".$stage_id."' AND pi.template_id ='".$template_id."' ORDER BY pi.priority ASC");
    return $query->result_array();
}

function get_template_task_checklist($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_template_item_checklists WHERE item_id = '".$item_id."' AND template_id='".$template_id."' ORDER BY id DESC");
    return $query->result_array();
}

function get_template_task_notes($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_template_item_notes WHERE item_id = '".$item_id."' AND template_id='".$template_id."' ORDER BY id DESC");
    return $query->result_array();
}

function get_template_task_files($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_template_item_files WHERE item_id = '".$item_id."' AND template_id='".$template_id."' AND file_type = 0 ORDER BY id DESC");
    return $query->result_array();
}
function get_template_task_images($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_template_item_files WHERE item_id = '".$item_id."' AND template_id='".$template_id."' AND file_type = 1 ORDER BY id DESC");
    return $query->result_array();
}

function get_template_task_reminders($template_id, $item_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT r.*, u.email FROM project_scheduling_template_item_reminders r INNER JOIN project_scheduling_reminder_users u ON u.id = r.to_id WHERE r.item_id = '".$item_id."' AND r.template_id='".$template_id."' ORDER BY r.id DESC");
    return $query->result_array();
}

function get_template_stage_status($template_id, $stage_id, $total_items){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_template_items WHERE stage_id = '".$stage_id."' AND template_id = '".$template_id."' AND status=0 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records==$total_items){
     return 0;exit;
    }

    $query = $ci->db->query("SELECT * FROM project_scheduling_template_items WHERE stage_id = '".$stage_id."' AND template_id = '".$template_id."' AND status=1 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records>0){
     return 1;exit;
    }

    $query = $ci->db->query("SELECT * FROM project_scheduling_template_items WHERE stage_id = '".$stage_id."' AND template_id = '".$template_id."' AND status=2 ORDER BY id DESC");
    $records = $query->num_rows();
    if($records==$total_items){
     return 2;exit;
    }

}

function get_project_summary_checklist($project_id, $task_id, $current_role){
    
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_item_checklists WHERE item_id IN (SELECT id FROM project_scheduling_items WHERE task_id='".$task_id."') AND project_id='".$project_id."' ORDER BY id DESC");
    return $query->result_array();
}

function get_item_selected_checklists($item_id){
    
    $ci = & get_instance();
   
    $query = $ci->db->query("SELECT checklist FROM project_scheduling_items WHERE id='".$item_id."'");
    $result = $query->row_array();
    return $result["checklist"];
}

function get_project_summary_notes($project_id, $task_id, $current_role){
    $ci = & get_instance();
    if($current_role==1 || $current_role==2){
    $query = $ci->db->query("SELECT * FROM project_scheduling_item_notes WHERE item_id IN (SELECT id FROM project_scheduling_items WHERE task_id='".$task_id."') AND project_id='".$project_id."' ORDER BY id DESC");
    }
    else{
     $query = $ci->db->query("SELECT * FROM project_scheduling_item_notes WHERE item_id IN (SELECT id FROM project_scheduling_items WHERE task_id='".$task_id."') AND project_id='".$project_id."' AND privacy_settings = 1 ORDER BY id DESC");
    }
    return $query->result_array();
}

function get_project_summary_images($project_id, $task_id, $current_role){
    $ci = & get_instance();
    if($current_role==1 || $current_role==2){
      $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id IN (SELECT id FROM project_scheduling_items WHERE task_id='".$task_id."') AND project_id='".$project_id."' AND file_type=1 ORDER BY id DESC");
    }
    else{
       $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id IN (SELECT id FROM project_scheduling_items WHERE task_id='".$task_id."') AND project_id='".$project_id."' AND file_type=1 AND privacy_settings = 1 ORDER BY id DESC");
    }
    return $query->result_array();
}
function get_project_summary_files($project_id, $task_id, $current_role){
    $ci = & get_instance();
    if($current_role==1 || $current_role==2){
      $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id IN (SELECT id FROM project_scheduling_items WHERE task_id='".$task_id."') AND project_id='".$project_id."' AND file_type=0 ORDER BY id DESC");
    }
    else{
      $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE item_id IN (SELECT id FROM project_scheduling_items WHERE task_id='".$task_id."') AND project_id='".$project_id."' AND file_type=0 AND privacy_settings = 1 ORDER BY id DESC");
    }
    return $query->result_array();
}
function get_task_reminder_message($task_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_reminders WHERE task_id='".$task_id."' ");
    return $query->result_array();
}
function get_project_details($project_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT p.name, p.description, u.user_fname as first_name, u.user_lname as last_name, u.user_email FROM project_scheduling_projects p LEFT JOIN project_scheduling_team t ON t.project_id = p.id LEFT JOIN project_users u ON u.user_id = t.team_id WHERE p.id='".$project_id."' AND t.team_role=1 ");
    return $query->result_array();
}
function get_project_documents($project_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_plans_and_specifications WHERE project_id='".$project_id."' ORDER BY id DESC");
    
    return $query->result_array();
}

function get_user_project_role($project_id, $user_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT team_role FROM project_scheduling_team WHERE project_id='".$project_id."' AND team_id='".$user_id."'");
    return $query->row_array();
}
function get_note_details($note_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_item_notes WHERE id='".$note_id."'");
    if($query->num_rows()>0){
    return $query->row_array();
    }
    else{
        return array();
    }
}
function get_reminder_details($reminder_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT r.*, u.email FROM project_scheduling_item_reminders r INNER JOIN project_scheduling_reminder_users u ON u.id = r.to_id WHERE r.id='".$reminder_id."'");
   if($query->num_rows()>0){
    return $query->row_array();
    }
    else{
        return array();
    }
}
function get_files_details($file_id, $type){
   $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_scheduling_item_files WHERE id='".$file_id."' AND file_type='".$type."'");
    if($query->num_rows()>0){
    return $query->row_array();
    }
    else{
        return array();
    }
}
function get_document_details($document_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_plans_and_specifications WHERE id='".$document_id."'");
    if($query->num_rows()>0){
    return $query->row_array();
    }
    else{
        return array();
    }
}
function get_notifications($user_id, $limit=0){
   $ci = & get_instance();
   if($limit==0){
    $query = $ci->db->query("SELECT n.*, u.user_fname as first_name, u.user_lname as last_name, p.name as project_name FROM project_scheduling_notifications n LEFT JOIN project_users u ON u.user_id = n.user_id LEFT JOIN project_scheduling_projects p ON p.id = n.project_id WHERE n.project_id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$user_id."') ORDER BY n.id DESC");
   }
   else{
    $query = $ci->db->query("SELECT n.*, u.user_fname as first_name, u.user_lname as last_name, p.name as project_name FROM project_scheduling_notifications n LEFT JOIN project_users u ON u.user_id = n.user_id LEFT JOIN project_scheduling_projects p ON p.id = n.project_id WHERE n.project_id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$user_id."') ORDER BY n.id DESC LIMIT 5");
   }
    return $query->result_array();
}

function get_project_items($project_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT t.name as task_name, s.stage_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id INNER JOIN project_stages s ON s.stage_id = pi.stage_id WHERE pi.project_id ='".$project_id."'");
$calendar_events = $query->result_array();

$events = "";
foreach($calendar_events as $event){
if($event['status']==0){
$status = '<span class="label label-danger">Not Done</span>';
$event_class = "event-red";
}else if($event['status']==1){ 
$status ='<span class="label label-warning">Partially Done</span>';
$event_class = "event-orange";
}else{ 
$status = '<span class="label label-success">Complete</span>';
$event_class = "event-green";
} 
$events .= "{
                    title: '".$event['task_name']." under ".$event['stage_name']."',
                    start: '".$event['start_date']."',
                    end: '".$event['end_date']."T23:59:00',
                    end_date: '".$event['end_date']."',
                    className: '".$event_class."',
                    id: '".$event['id']."',
                    status: '".$status."',
                    stage: '".$event['stage_name']."',
                    task: '".$event['task_name']."',
                },";
}
$events =rtrim($events, ",");
	
return $events;
}
function is_activity_public($activity_id, $activity_type){
     $ci = & get_instance();
    if($activity_type=="note"){
        $query = $ci->db->query("SELECT privacy_settings FROM project_scheduling_item_notes WHERE id='".$activity_id."'");
        $row = $query->row_array();
        if($query->num_rows()>0){
          return $row['privacy_settings'];
        }
        else{
            $is_activity_public = 1;
            return $is_activity_public;
        }
    }
    else if($activity_type=="file" || $activity_type=="image"){
        $query = $ci->db->query("SELECT privacy_settings FROM project_scheduling_item_files WHERE id='".$activity_id."'");
        $row = $query->row_array();
        if($query->num_rows()>0){
        return $row['privacy_settings'];
        }
        else{
            $is_activity_public = 1;
            return $is_activity_public;
        }
    }
    else if($activity_type=="reminder"){
        $query = $ci->db->query("SELECT privacy_settings FROM project_scheduling_item_reminders WHERE id='".$activity_id."'");
        $row = $query->row_array();
        if($query->num_rows()>0){
           return $row['privacy_settings'];
        }
        else{
            $is_activity_public = 1;
            return $is_activity_public;
        }
    }
    else{
        $is_activity_public = 1;
        return $is_activity_public;
    }
    
}
function get_client_info($client_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_clients WHERE client_id = '".$client_id."'");
    return $query->row_array();
}
function get_supplier_info($supplier_id){
    $ci = & get_instance();
    $query = $ci->db->query("SELECT * FROM project_suppliers WHERE supplier_id = '".$supplier_id."'");
    return $query->row_array();
}
function get_component_info($component_id){
	   
		$ci =& get_instance();
        $ci->load->database();
		$ci->db->select('c.component_id, c.include_in_price_book, c.component_uc, c.supplier_id, c.component_des, s.supplier_name, c.component_name, c.image');
        $ci->db->from('project_components c');
        $ci->db->join('project_suppliers s', 's.supplier_id=c.supplier_id', 'inner');
        $ci->db->where('c.component_id', $component_id);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
       
	}
	
	function get_supplierz_component_details($component_id){
	   
		$ci =& get_instance();
        $ci->load->database();
		$ci->db->select('c.component_id, c.component_uc, c.supplier_id, c.component_des, s.supplier_name, c.component_name, c.image');
        $ci->db->from('project_supplierz_components c');
        $ci->db->join('project_suppliers s', 's.supplier_id=c.supplier_id', 'inner');
        $ci->db->where('c.component_id', $component_id);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
       
	}
	
	function get_supplierz_component($component_id){
	   
		$ci =& get_instance();
        $ci->load->database();
		$ci->db->select('c.component_id, c.component_uc, c.supplier_id, c.component_des, s.supplier_name, c.component_name, c.image');
        $ci->db->from('project_price_book_components c');
        $ci->db->join('project_suppliers s', 's.supplier_id=c.supplier_id', 'inner');
        $ci->db->where('c.id', $component_id);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
       
	}
	
	function get_supplierz_component_info($component_id){
	   
		$ci =& get_instance();
        $ci->load->database();
		$ci->db->select('c.component_uc, c.component_name, c.image');
        $ci->db->from('project_price_book_components c');
        $ci->db->where('c.id', $component_id);
        $query = $ci->db->get();
        $result = $query->row_array();
        return $result;
       
	}
	
	function escapeString($val) {
        $db = get_instance()->db->conn_id;
        $val = mysqli_real_escape_string($db, $val);
        return $val;
    }
    
    
   function get_company_tax(){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('user_id' => $ci->session->userdata('company_id') );
        $ci->db->select('com_tax');
        $ci->db->from('project_users');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
        return $result->com_tax;
    }
    
    function get_supplier_ordered_quantity($costingpartid, $type=""){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        if($type==""){
        $query = $ci->db->query("SELECT quantity FROM project_supplier_invoices_items WHERE costing_part_id='".$costingpartid."'");
        }
        else{
            $query = $ci->db->query("SELECT quantity FROM project_supplier_invoices_items WHERE costing_part_id='".$costingpartid."' AND transaction_type='".$type."'");
        }
        $sumquantity = $query->result();
        
		$ordered_quantity=0;
		foreach($sumquantity as $key=> $val){
		 
			$ordered_quantity+=$val->quantity;
		 
		}
        return $ordered_quantity;
       
	}
	
	function get_recent_variation_quantity($costint_part_id, $costing_supplier=0){
	    
        $ci =& get_instance();
        $ci->load->database();
		$approve='APPROVED';
		if($costing_supplier>0){
		$querry="select pvp.*,pv.*, sum(pvp.change_quantity) as total, sum(pvp.updated_quantity) as updated_quantity  from  project_variation_parts pvp
		INNER JOIN project_variations pv ON pvp.variation_id = pv.id
		where pvp.costing_part_id='$costint_part_id' AND pvp.supplier_id = '".$costing_supplier."' AND pv.var_type='normal' GROUP BY pvp.id";
		}
		else{
		    $querry="select pvp.*,pv.*, sum(pvp.change_quantity) as total, sum(pvp.updated_quantity) as updated_quantity  from  project_variation_parts pvp
		INNER JOIN project_variations pv ON pvp.variation_id = pv.id
		where pvp.costing_part_id='$costint_part_id' AND pv.var_type='normal' GROUP BY pvp.id";
		}
		$get=$ci->db->query($querry);
		return $get->result_array();
		
	}
	
	function get_supplier_invoice_amount($costingpartid, $type=""){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
        if($type==""){
        $query = $ci->db->query("SELECT quantity, invoice_amount FROM project_supplier_invoices_items WHERE costing_part_id='".$costingpartid."'");
        }
        else{
            $query = $ci->db->query("SELECT quantity, invoice_amount FROM project_supplier_invoices_items WHERE costing_part_id='".$costingpartid."' AND transaction_type='po'");
        }
        $sumquantity = $query->result();
        
		$ordered_quantity=0;
		$invoice_amount=0;
		foreach($sumquantity as $key=> $val){
		 
			$invoice_amount+=$val->invoice_amount;
		 
		}
		
        return $invoice_amount;
       
	}
	
	function get_variation_type($variation_id){
        $ci =& get_instance();
        $ci->load->database();
		
		$querry="select var_type from  project_variations where id='$variation_id'";
		$get=$ci->db->query($querry);
		return $get->row_array();
	}
	
	function get_variation_info_by_costing_id($costing_part_id){
	    $ci =& get_instance();
        $ci->load->database();
	    $query = $ci->db->query("SELECT vp.* FROM project_variation_parts vp INNER JOIN project_variations v ON v.id = vp.variation_id WHERE vp.costing_part_id = '".$costing_part_id."' AND v.var_type='normal'");
        return $query->result_array();
	}
	
	
	
	function get_user_name($user_id){
	   
		$ci =& get_instance();
        $ci->load->database();
	    
	    $query = $ci->db->query("SELECT * FROM project_users WHERE user_id='".$user_id."'");
        	
        $row = $query->row_array();
        return $row['user_fname']." ".$row['user_lname'];
       
	}
	
	
   function get_price_book_supplier_info($supplier_user_id){
	   
		$ci =& get_instance();
        $ci->load->database();
	   
        $query = $ci->db->query("SELECT * FROM project_users WHERE user_id='".$supplier_user_id."'");
        return $query->row_array();
       
	}
	
	function get_costing_quantity($costing_part_id){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('costing_part_id' => $costing_part_id);
        $ci->db->select('costing_quantity');
        $ci->db->from('project_costing_parts');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
        if($query->num_rows()>0){
        return $result->costing_quantity;
        }
    }
    
    function get_costing_type($costing_part_id){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('costing_part_id' => $costing_part_id);
        $ci->db->select('costing_type');
        $ci->db->from('project_costing_parts');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
         if($query->num_rows()>0){
        return $result->costing_type;
         }
    }
    
    function get_supplier_name($id){
		$ci =& get_instance();
        $ci->load->database();
        $where = array('supplier_id' => $id );
		$ci->db->select('supplier_name');
        $ci->db->from('project_suppliers');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
         if($query->num_rows()>0){
        return $result->supplier_name;
         }
	}

    function get_stage_name($id){
		$ci =& get_instance();
        $ci->load->database();
        $where = array('stage_id' => $id );
		$ci->db->select('stage_name');
        $ci->db->from('project_stages');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
         if($query->num_rows()>0){
        return $result->stage_name;
         }
	}
	
	function get_ordered_quantity($costingpartid){
	   
		$ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT order_quantity FROM project_purchase_order_items WHERE costing_part_id='".$costingpartid."' AND purchase_order_id IN (SELECT id FROM project_purchase_orders WHERE order_status!='Cancelled')");
        $sumquantity = $query->result();
        
		$ordered_quantity=0;
		foreach($sumquantity as $key=> $val){
		 
			$ordered_quantity+=$val->order_quantity;
		 
		}
        return $ordered_quantity;
       
	}
	
	function get_recent_quantity($costint_part_id, $costing_supplier=0){
	    
        $ci =& get_instance();
        $ci->load->database();
        
		$approve='APPROVED';
		
		if($costing_supplier>0){
		$querry="select pvp.*,pv.*, sum(pvp.change_quantity) as total, sum(pvp.updated_quantity) as updated_quantity  from  project_variation_parts pvp
		INNER JOIN project_variations pv ON pvp.variation_id = pv.id
		where pvp.costing_part_id='$costint_part_id' AND pvp.supplier_id = '".$costing_supplier."' AND pv.var_type='normal' GROUP BY pvp.id";
		}
		else{
		    $querry="select pvp.*,pv.*, sum(pvp.change_quantity) as total, sum(pvp.updated_quantity) as updated_quantity  from  project_variation_parts pvp
		INNER JOIN project_variations pv ON pvp.variation_id = pv.id
		where pvp.costing_part_id='$costint_part_id' AND pv.var_type='normal' GROUP BY pvp.id";
		}
		$get=$ci->db->query($querry);
		$result = $get->result_array();
		$total = 0;
		$updated_quantity = 0;
		$data = array();
		if($get->num_rows()>0){
		foreach($result as $val){
		    $updated_quantity +=$val["updated_quantity"];
		    $total +=$val["total"];
		}
		$data = array ("total" => $total,
		"updated_quantity" => $updated_quantity);
		}
		return $data;
	}
	
	function get_variation_number($costing_id, $costing_part_id){
	    
	    	$ci =& get_instance();
            $ci->load->database();
        
            $query = $ci->db->query("SELECT * FROM `project_variation_parts` WHERE `costing_id` = $costing_id AND (`costing_part_id` = $costing_part_id OR `costingpartid_var` = $costing_part_id)");
            
		     if($query->num_rows()>0){
                 $row = $query->row_array();
                 return $row["variation_id"];
		     }
		     else{
		         return 0;
		     }
	}
	
	function get_porder_detail($porder_id, $costing_part_id){
	    
    $ci =& get_instance();
    $ci->load->database();
    
    $query = $ci->db->query("SELECT order_quantity as porder_order_quantity, costing_uc as order_unit_cost, line_cost as order_total  FROM project_purchase_order_items WHERE purchase_order_id='".$porder_id."' AND costing_part_id ='".$costing_part_id."'");
    return $query->row_array();
    
    }
    
    function get_po_suppliers_name($po_id){
       $ci =& get_instance();
        $ci->load->database();
        
        $query = $ci->db->query("SELECT distinct(poi.supplier_id), s.supplier_name FROM project_purchase_order_items poi INNER JOIN project_suppliers s ON s.supplier_id = poi.supplier_id WHERE poi.purchase_order_id='".$po_id."'");
		$result = $query->result_array();
		
		$query2 = $ci->db->query("SELECT po.supplier_id, s.supplier_name FROM project_purchase_orders po INNER JOIN project_suppliers s ON s.supplier_id = po.supplier_id WHERE po.id='".$po_id."'");
	    $result2 = $query2->row_array();
		
		$suppliers_list = $result2['supplier_name'].", ";
		
        foreach($result as $val){
            if($result2['supplier_id']!=$val['supplier_id']){
                $suppliers_list.= $val["supplier_name"].", ";
            }
        }
        return rtrim($suppliers_list, ", ");
    }
    
    function is_supplier_user($supplier_id){
    
        $ci =& get_instance();
        $ci->load->database();
	    
        
            $query = $ci->db->query("SELECT * FROM project_suppliers WHERE supplier_id='".$supplier_id."' AND parent_supplier_id!=0");
        
        
		
        if($query->num_rows()>0){
        return true;
        }
        else{
            return false;
        }
    
   }
    
    function get_terms_and_conditions_for_company(){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('company_id' => $ci->session->userdata('company_id') );
        $ci->db->select('*');
        $ci->db->from('project_terms_and_conditions');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
        return $result->detail;
    }
    
    function get_terms_and_conditions_for_company_via_supplierz($company_id){
        $ci =& get_instance();
        $ci->load->database();
        $where = array('company_id' => $company_id );
        $ci->db->select('*');
        $ci->db->from('project_terms_and_conditions');
        $ci->db->where($where);
        $query = $ci->db->get();
        $result = $query->row();
        return $result->detail;
    }
    
    function get_daily_summary_by_project($project_id, $from, $to){
      $ci = & get_instance();
      $from = date("Y-m-d", strtotime(str_replace("/", "-", $from)));
      $to = date("Y-m-d", strtotime(str_replace("/", "-", $to)));
      $query = $ci->db->query("SELECT u.user_fname, u.user_lname, t.name as task_name, s.stage_name as stage_name, p.name as project_name, a.* FROM project_scheduling_activities a INNER JOIN project_scheduling_projects p ON p.id = a.project_id LEFT JOIN project_scheduling_items i ON i.id = a.item_id LEFT JOIN project_stages s ON s.stage_id = i.stage_id LEFT JOIN project_scheduling_tasks t ON t.id = i.task_id INNER JOIN project_users u ON u.user_id = a.user_id WHERE a.project_id = '".$project_id."' AND (DATE_FORMAT(a.created_at, '%Y-%m-%d') BETWEEN '".$from."' AND '".$to."') ORDER BY a.id DESC");
      //echo $ci->db->last_query();exit;
      return $query->result_array($query);
    }
    
    function get_public_holidays(){
       $ci = & get_instance();
        $query = $ci->db->query("SELECT date FROM project_scheduling_public_holidays");
        $dates = $query->result_array();
        $dates_array = "[";
        foreach($dates as $val){
           $dates_array .= "'".$val["date"]."', "; 
        }
        $dates_array = rtrim($dates_array, ", ");
        $dates_array .= "]";
        echo $dates_array;
    }
    
    function get_holidays(){
       $ci = & get_instance();
        $query = $ci->db->query("SELECT date FROM project_scheduling_public_holidays");
        $dates = $query->result_array();
        $dates_array = array();
        foreach($dates as $val){
           $dates_array[]= $val["date"]; 
        }
        return $dates_array;
    }
    function dateDifference($start_date, $end_date)
    {
        $datetime1 = new DateTime($start_date);
       
        $datetime2 = new DateTime($end_date);
        
        $interval = $datetime1->diff($datetime2);
        
        
        $holidays = get_holidays();
        
        $woweekends = 0;
        for($i=0; $i<=$interval->days; $i++){
            $datetime1->modify('+1 day');
            $weekday = $datetime1->format('w');
        
            if($weekday !== "0" && $weekday !== "6" && !(in_array($datetime1->format('Y-m-d'), $holidays))){ // 0 for Sunday and 6 for Saturday
                $woweekends++;  
            }
        
        }
        
        return $woweekends;
    }
    
    function get_supplierz_item_total($order_no){
    
        $ci = & get_instance();
        
        $query = $ci->db->query("SELECT SUM(item_subtotal) as total FROM project_online_store_order_items WHERE order_no = ".$order_no." AND supplierz_id=".$ci->session->userdata('company_id'));
    
        $result = $query->row_array();
        
        return $result["total"];
   }
   
    function get_notification_details($date, $order_no){
        $ci = & get_instance();
        $query = $ci->db->query("SELECT * FROM project_notifications WHERE created_date LIKE '".$date."%' AND order_no ='".$order_no."' ORDER BY id DESC");
        return $query->result_array();
    }
    
    function get_user_image($id){
        $ci = & get_instance();
        $query = $ci->db->query("SELECT user_img FROM project_users WHERE user_id = '".$id."'");
        $result = $query->row_array();
        return $result['user_img'];
    }
    
    function get_no_of_orders($customer_id){
        $ci = & get_instance();
        
        $ci->db->where('user_id', $customer_id);
        $ci->db->where('user_id', $customer_id);
        $get_data = $ci->db->query('Select * FROM project_online_store_orders WHERE order_no IN (Select order_no FROM project_online_store_order_items WHERE supplierz_id='.$ci->session->userdata("company_id").")");
        $data = $get_data->num_rows();
        if($data==1){
          return "1 order";
        }
        else{
          return $data." orders";
        }
    }
    
    function get_gantt_tasks($project_id, $daterange=""){
    $ci = & get_instance();
    if($ci->session->userdata("daterange") && $ci->session->userdata("daterange")!=""){
        $daterange = $ci->session->userdata("daterange");
    }
    if($daterange!=""){   
        $daterange = str_replace("%20"," ", $daterange);
        $daterange = explode(" - ", $daterange);
        $from_date = explode("-", $daterange[0]);
        $from_date = $from_date[2]."-".$from_date[1]."-".$from_date[0];
        $to_date = explode("-", $daterange[1]);
        $to_date = $to_date[2]."-".$to_date[1]."-".$to_date[0];
    }
    /*$query = $ci->db->query("SELECT pi.stage_id, pi.stages_priority, pi.id, s.stage_name as stage_name FROM project_scheduling_items pi LEFT JOIN project_stages s ON s.stage_id = pi.stage_id WHERE pi.project_id ='".$project_id."' GROUP BY pi.stage_id ORDER BY 
    CASE 
        WHEN pi.stages_priority > 0 THEN pi.stages_priority  
    END ASC, pi.id ASC");*/
    
    $query = $ci->db->query("SELECT pi.stage_id, pi.stages_priority, pi.id, s.stage_name as stage_name FROM project_scheduling_items pi LEFT JOIN project_stages s ON pi.stage_id = s.stage_id WHERE pi.project_id ='".$project_id."' GROUP BY pi.stage_id
   ORDER BY
        CASE 
            WHEN pi.stages_priority > 0 THEN pi.stages_priority
            ELSE pi.stage_id 
        END ASC");
    $stages = $query->result_array();
    echo "[";
    $str = "";
    $stage_index =1;
    $i = 0;
    
        foreach($stages as $stage){
            if($daterange==""){
               $query = $ci->db->query("SELECT t.name as task_name, t.id as task_id, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' ORDER BY pi.priority ASC");
               $items = $query->result_array();
            }
            else{
                $query = $ci->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' AND (pi.start_date >= '".$from_date."' AND pi.end_date <= '".$to_date."') ORDER BY pi.priority ASC");
                /*echo "<br>";
                echo $ci->db->last_query();
                echo "<br>";*/
                $items = $query->result_array();
            }
            
            if($daterange==""){
               $query = $ci->db->query("SELECT MIN(pi.start_date) as p_start_date, MAX(pi.end_date) as p_end_date FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' GROUP BY pi.stage_id ORDER BY pi.priority ASC");
               $task_data = $query->row_array();
            }
            else{
                $query = $ci->db->query("SELECT MIN(pi.start_date) as p_start_date, MAX(pi.end_date) as p_end_date, t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' AND (pi.start_date >= '".$from_date."' AND pi.end_date <= '".$to_date."') GROUP BY pi.stage_id ORDER BY pi.priority ASC");
                $task_data = $query->row_array();
            }
            
            if(count($items)>0){
                //$t_s_date = date('Y-m-d', strtotime("+1 day", strtotime($task_data["p_start_date"])));
                $t_s_date = $task_data["p_start_date"];
                $start_date = strtotime($t_s_date)*1000;
                //$t_e_date = date('Y-m-d', strtotime("+1 day", strtotime($task_data["p_end_date"])));
                $t_e_date = $task_data["p_end_date"];
                $end_date = strtotime($t_e_date)*1000;
    
                

                $duration = dateDifference($t_s_date, $t_e_date);
                
                echo '{"id": -'.$stage["stage_id"].', "name": "'.$stage["stage_name"].'", "progress": 0, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "", "level": 0, "status": "STATUS_UNDEFINED", "depends": "", "canWrite": true, "canSeePopEdit":false, "start": '.$start_date.', "duration": '.$duration.', "end": '.$end_date.', "startIsMilestone": false, "endIsMilestone": false, "collapsed": false, "assigs": [], "hasChild": true},';
                for($j=0;$j<count($items);$j++){
                    /*if($items[$task_data["p_start_date"];
                    echo "<br>";
                    echo $j]["task_id"]==49 && $items[$j]["id"] == 4392){
            echo "<pre>";
            print_r($items[$j]);
            $e_date = $items[$j]["end_date"];
            echo "<br>";
            echo $e_date;
            $mdate = date('Y-m-d', strtotime("+1 day", strtotime($items[$j]["end_date"])));
            $task_end_date = strtotime($mdate)*1000;
            echo $task_end_date;
            exit;
            }*/
                    if($items[$j]["status"]==0){
                    $status = "STATUS_FAILED";
                    }else if($items[$j]["status"]==1){ 
                    $status = "STATUS_SUSPENDED";
                    }else{ 
                    $status = "STATUS_ACTIVE";
                    } 
                    $depends = $items[$j]["depends"];
                    /*if($j==0){
                        $i = $i+2;
                        $depends = "";
                    }
                    
                    else{
                        $depends = $i;
                        if($j!=count($tems)-1){
                        $i++;
                        }
                    }*/
                    //$s_date = date('Y-m-d', strtotime("+1 day", strtotime($items[$j]["start_date"])));
                    $s_date = $items[$j]["start_date"];
                    $task_start_date = strtotime($s_date)*1000;
                    //$e_date = date('Y-m-d', strtotime("+1 month", strtotime($items[$j]["end_date"])));
                    $e_date = $items[$j]["end_date"];
                    $task_end_date = strtotime($e_date)*1000;
                    
                    $task_start_date1 = $items[$j]["startDateInMiliseconds"];
                    $task_end_date1 = $items[$j]["endDateInMiliseconds"];
               
                    $task_duration = $items[$j]["duration"];
                    if($task_duration==0){
                       $task_duration = dateDifference($s_date, $items[$j]["end_date"]);
                    }
                    $who = get_user_info($items[$j]['assign_to_user']);
                    
                    if($items[$j]['parent_item_id']>0){
                        $part_name = get_part_name($items[$j]['parent_item_id']);
                        $customTaskName = $part_name." - ".$items[$j]['task_name'];
                    }
                    else{
                        $customTaskName = $items[$j]['task_name']; 
                    }
                    
                    echo '{"id": '.$items[$j]["id"].', "name": "'.$customTaskName.'", "progress": 0, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "'.$items[$j]["end_date"].'", "description": "", "code": "", "level": 1, "status": "'.$status.'", "depends": "'.$depends.'", "canWrite": true, "canSeePopEdit":true, "canSeeDep": true, "start": '.$task_start_date.', "duration": '.$task_duration.', "end": '.$task_end_date.', "startIsMilestone": false, "endIsMilestone": false, "collapsed": false, "assigs": ["'.$who.'"], "hasChild": false},';
                    
                } 
                
                $stage_index++;
            }
            
        }
        
    echo "]";
}

    function getResources(){
        
        $ci = & get_instance();
        $resources = array();
        $query = $ci->db->query("SELECT * FROM project_users WHERE user_status = 1 AND company_id =".$ci->session->userdata("company_id"));
        $users = $query->result_array();
        foreach($users as $user){
            $resources[] = array("id" => $user["user_id"], "name" => $user["user_fname"]." ".$user["user_lname"]);
        }
        
        return json_encode($resources);
        
    }

    function checkTasksDependands($project_id, $dependent_id, $item_id){
        
            $ci = & get_instance();
            if($dependent_id > 0){
                $query = $ci->db->query("Select * from project_scheduling_items WHERE project_id = ".$project_id." AND (depends =".$dependent_id." OR id IN (SELECT id FROM project_scheduling_items WHERE id =".$item_id." AND depends > 0))");
            }
            else{
               $query = $ci->db->query("Select * from project_scheduling_items WHERE project_id = ".$project_id." AND id IN (SELECT id FROM project_scheduling_items WHERE id =".$item_id." AND depends > 0)");
          
            }
            if($query->num_rows()>0){
                return true;
            }
            else{
               return false; 
            }
    }
    
    function check_missing_component($template_id){
            $ci = & get_instance();
            $query = $ci->db->query("Select * from project_supplierz_tpl_component_part WHERE temp_id = ".$template_id." AND (component_id NOT IN (SELECT component_id FROM project_price_book_components) OR stage_id NOT IN (SELECT stage_id FROM project_stages) OR tpl_part_supplier_id NOT IN (SELECT supplier_id FROM project_suppliers))");
            if($query->num_rows()>0){
                return true;
            }
            else{
               return false; 
            }
    }
    
    function check_costingz_missing_component($template_id){
            $ci = & get_instance();
            $query = $ci->db->query("Select * from project_tpl_component_part WHERE temp_id = ".$template_id." AND (component_id NOT IN (SELECT component_id FROM project_components) OR stage_id NOT IN (SELECT stage_id FROM project_stages) OR tpl_part_supplier_id NOT IN (SELECT supplier_id FROM project_suppliers))");
            if($query->num_rows()>0){
                return true;
            }
            else{
               return false; 
            }
    }
    
    function get_thumbnail($designz_id, $designz_type, $thumbnail_type){
        $ci = & get_instance();
        $company_id = $ci->session->userdata('company_id');
        if($designz_type == 'supplierz'){
            $query = $ci->db->query("SELECT * FROM project_designz_builderz_uploads WHERE set_as_thumbnail = 1 AND designz_upload_type = '". $thumbnail_type."' AND designz_id =".$designz_id." AND company_id =".$company_id);
        }
        else{
            $query = $ci->db->query("SELECT * FROM project_designz_uploads WHERE set_as_thumbnail = 1 AND designz_upload_type = '". $thumbnail_type."' AND designz_id =".$designz_id." AND company_id =".$company_id);
        }
        if($query->num_rows()>0){
                return $query->row_array();
            }
            else{
               return array(); 
            }
    }
?>