<?php
/**
 * Created by PhpStorm.
 * User: salman jutt
 * Date: 4/29/2017
 * Time: 3:28 PM
 */


Class Mod_dashboard extends CI_Model {
    function get_total_sales_invoices(){
		$query = "SELECT sum(project_sales_invoices.invoice_amount) as total_sales_invoices FROM project_sales_invoices WHERE project_id IN (SELECT project_id FROM project_projects WHERE project_status=1 AND company_id='".$this->session->userdata('company_id')."' AND project_id IN (SELECT project_id FROM project_projects WHERE project_status=1))";
		$get=$this->db->query($query);
		$result = $get->row();
		return $result->total_sales_invoices;
	}
	
	function get_total_sales_credits(){
		$query = "SELECT sum(total) as total_sales_credits FROM  project_sales_credit_notes WHERE project_id IN (SELECT costing_id FROM project_costing
 WHERE status=1 AND company_id='".$this->session->userdata('company_id')."' AND project_id IN (SELECT project_id FROM project_projects WHERE project_status=1)) AND status='Approved'";
		$get=$this->db->query($query);
		$result = $get->row();
		return $result->total_sales_credits;
	}
	
	function get_total_supplier_invoices(){
		$query = "SELECT sum(((project_supplier_invoices.invoice_amount)*(project_supplier_invoices.va_tax/100))+project_supplier_invoices.invoice_amount) as total_supplier_invoices FROM project_supplier_invoices WHERE project_id IN (SELECT costing_id FROM project_costing
 WHERE status=1 AND company_id='".$this->session->userdata('company_id')."' AND project_id IN (SELECT project_id FROM project_projects WHERE project_status=1))";
		$get=$this->db->query($query);
		$result = $get->row();
		return $result->total_supplier_invoices;
	}
	
	function get_total_supplier_credits(){
		$query = "SELECT sum(invoice_amount) as total_supplier_credits FROM project_supplier_credits WHERE project_id IN (SELECT costing_id FROM project_costing
 WHERE status=1 AND company_id='".$this->session->userdata('company_id')."' AND project_id IN (SELECT project_id FROM project_projects WHERE project_status=1)) AND status='Approved'";
		$get=$this->db->query($query);
		$result = $get->row();
		return $result->total_supplier_credits;
	}
	
	function get_project_variations(){
		$query = "SELECT count(project_variations.var_number) as variation_count, project_variations.project_id, project_projects.project_title FROM project_variations INNER JOIN project_projects ON project_projects.project_id = project_variations.project_id WHERE project_variations.project_id IN (SELECT project_id FROM project_projects WHERE project_status=1 AND company_id='".$this->session->userdata('company_id')."') GROUP BY project_variations.project_id";
		$get=$this->db->query($query);
		$result = $get->result_array();
		return $result;
	}
	
	function get_project_sales_invoice(){
		$query = "SELECT sum(project_sales_invoices.invoice_amount) as invoice_amount, project_sales_invoices.project_id, project_projects.project_title FROM project_sales_invoices INNER JOIN project_projects ON project_projects.project_id = project_sales_invoices.project_id WHERE project_sales_invoices.project_id IN (SELECT project_id FROM project_projects WHERE project_status=1 AND company_id='".$this->session->userdata('company_id')."') GROUP BY project_sales_invoices.project_id";
		$get=$this->db->query($query);
		$result = $get->result_array();
		return $result;
	}
	
	function get_project_supplier_invoice(){
		$query = "SELECT sum(project_supplier_invoices.invoice_amount) as invoice_amount, project_supplier_invoices.project_id, project_projects.project_title FROM project_supplier_invoices INNER JOIN project_costing ON project_costing.costing_id = project_supplier_invoices.project_id INNER JOIN project_projects ON project_projects.project_id = project_costing.project_id WHERE project_supplier_invoices.project_id IN (SELECT costing_id FROM project_costing WHERE status=1 AND company_id='".$this->session->userdata('company_id')."') GROUP BY project_supplier_invoices.project_id";
		$get=$this->db->query($query);
		$result = $get->result_array();
		return $result;
	}
	
	function get_all_projects($table,$user_id){
		$this->db->select('*');
		$this->db->where($user_id);
		$get = $this->db->get($table);
		return $get->result_array();
	}
    
}