<?php

Class Mod_component extends CI_Model {
	
	function getpart($group_id){
		$q = $this->db->query("SELECT * FROM `project_parts` bp, `project_components` bc WHERE bp.component_id=bc.component_id AND bp.group_id='".$group_id."' AND bc.component_status=1");
		return $q->result();
	}
        
        
        function getAllUserComponents(){
            $company_id = $this->session->userdata('company_id');
            $query = "SELECT c.*, s.supplier_name, s.supplier_email "
                    . "FROM project_components c "
                    . "LEFT JOIN project_suppliers s ON (c.supplier_id = s.supplier_id)"
                    . "WHERE c.company_id ='$company_id'"; 
            $get = $this->db->query($query);
            $result = $get->result(); 
            return $result;
            }
            
        function getcomponentbysupplierid(){
            
            $supplier_id=$POST['supplier_id'] ;
            
            $company_id= $this->session->userdata('company_id');
            $query = "SELECT c.* "
                    . "FROM project_components c "
                    . "WHERE c.supplier_id ='$supplier_id'"; 
            $get = $this->db->query($query);
            $result = $get->result(); 
            return $result;
        }
}

// End Class Mod_seller