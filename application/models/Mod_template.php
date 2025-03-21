<?php
Class Mod_template extends CI_Model {
	
	public function get_all_templates(){
		$company_id = $this->session->userdata('company_id');
		$q = $this->db->query("SELECT * FROM `project_templates` bt WHERE company_id  =".$company_id );
		
		return $q->result();
	}
	public function get_template($template_id){
		$q = $this->db->query("SELECT * FROM `project_templates`  WHERE template_id = ".$template_id." AND company_id = ".$this->session->userdata("company_id"));
		return $q->result();
	}
	
	public function get_supplierz_template($template_id){
		$q = $this->db->query("SELECT * FROM `project_supplierz_templates`  WHERE template_id = ".$template_id." AND company_id = ".$this->session->userdata("company_id"));
		return $q->result();
	}
	
	public function get_supplierz_template_for_builder($template_id){
		$q = $this->db->query("SELECT * FROM `project_supplierz_templates`  WHERE template_id = ".$template_id);
		return $q->result();
	}
	public function get_supplierz_costing_parts_by_template_id($temp_id) {
        $query = "SELECT parts.*, stage.stage_name, component.component_name, supplier.supplier_name"
            . " FROM  project_supplierz_tpl_component_part parts "
            . " INNER JOIN project_price_book_components component ON (component.id = parts.component_id)"
            . " LEFT JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_suppliers supplier ON (supplier.supplier_id = parts.tpl_part_supplier_id)"
            . " INNER JOIN project_supplierz_templates templates ON (templates.template_id = parts.temp_id)"
            . " WHERE templates.template_id = '" . $temp_id . "'";
        $q = $this->db->query($query);
        return $q->result();
    }
}
?>