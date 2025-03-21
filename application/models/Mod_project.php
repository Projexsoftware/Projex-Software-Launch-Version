<?php
/**
 * Created by PhpStorm.
 * User: salman jutt
 * Date: 4/29/2017
 * Time: 3:28 PM
 */


Class Mod_project extends CI_Model {

    public function get_all_projects() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT bp.*,bc.client_fname1,bc.client_surname1,bc.client_fname2,bc.client_surname2,
          (SELECT name FROM project_cities WHERE id = bp.project_address_city) as city_name, 
          (SELECT country_name FROM project_cities WHERE id = bp.project_address_city) as country_name, 
          (SELECT state_name FROM project_cities WHERE id = bp.project_address_city) as state_name
          FROM `project_projects` bp, project_client bc WHERE bp.client_id=bc.client_id AND bp.company_id =" . $company_id);
        return $q->result();
    }

    public function get_project_by_name($id) {

        $this->db->select('*');
        $this->db->where('project_id', $id);
        $get = $this->db->get('project_projects');
        if($get->num_rows()>0){
        return $get->row_array();
        }
        else{
            return array();
        }
    }
    
    function get_costing_id($costint_part_id){
			
		$querry="select cp.costing_id from  project_costing_parts cp where cp.costing_part_id='$costint_part_id'";
		$get=$this->db->query($querry);
		return $get->row_array();
		
	}
	
	public function get_project_costing_stages($costing_id){
	    $query = "SELECT s.stage_id, s.stage_name, SUM(cp.line_cost) as stage_total FROM `project_costing_parts` cp INNER JOIN project_stages s ON s.stage_id = cp.stage_id WHERE cp.costing_id = ".$costing_id." AND cp.costing_type='normal' GROUP BY cp.stage_id";
	    $q = $this->db->query($query);
	    if($q->num_rows()>0){
	        return $q->result_array();
	    }
	    else{
	        return array();
	    }
	}
	
	public function get_supplierz_project_costing_stages($costing_id){
	    $query = "SELECT s.stage_id, s.stage_name, SUM(cp.line_cost) as stage_total FROM `project_costing_parts` cp INNER JOIN project_stages s ON s.stage_id = cp.stage_id WHERE cp.costing_id = ".$costing_id." AND cp.costing_type='supplierz' GROUP BY cp.stage_id";
	    $q = $this->db->query($query);
	    if($q->num_rows()>0){
	        return $q->result_array();
	    }
	    else{
	        return array();
	    }
	}
	
	public function get_updated_project_costing($costing_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, sup.supplier_name, com.component_name,com.image as component_image, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.costing_id = '" . $costing_id . "' AND  (parts.costing_part_id  IN (SELECT costing_part_id FROM project_variation_parts WHERE updated_quantity > 0) OR parts.costing_part_id  NOT IN (SELECT costing_part_id FROM project_variation_parts)) AND parts.costing_part_status=1";
        $query .= " ORDER BY parts.costing_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }
    
    public function get_updated_specifications($costing_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, sup.supplier_name, com.component_name,com.image as component_image, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.costing_id = '" . $costing_id . "' AND (parts.costing_part_id  IN (SELECT costing_part_id FROM project_variation_parts WHERE updated_quantity > 0) OR parts.costing_part_id  NOT IN (SELECT costing_part_id FROM project_variation_parts)) AND parts.include_in_specification=1 AND parts.costing_part_status=1";
        $query .= " ORDER BY parts.costing_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }

    public function get_supplier_invoices(){
        $this->db->select('SI.*,S.supplier_name,CI.project_id as prj_id');
        $this->db->from('project_supplier_invoices SI');
        $this->db->where('SI.company_id', $this->session->userdata('company_id'));
        $this->db->join('project_suppliers S','S.supplier_id = SI.supplier_id','left');
        $this->db->join('project_costing CI','CI.costing_id = SI.project_id','left');
        $this->db->order_by('SI.project_id','asc');
        $query = $this->db->get();
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }
    
    public function get_all_supplier_credits($status=1){
        $company_id = $this->session->userdata('company_id');
        $query ="SELECT si.*,pr.project_title, s.supplier_name FROM"
            . " project_supplier_credits si "
            . " JOIN project_costing t ON ( t.costing_id = si.project_id)"
            . " JOIN project_projects pr ON (pr.project_id= t.project_id)"
            . " JOIN project_suppliers s ON (s.supplier_id =si.supplier_id) WHERE si.company_id = '".$company_id."' AND pr.project_status=".$status;

        $get =$this->db->query($query);
        return $get->result_array();


    }

    public function get_salesinvoices(){
        $this->db->select('*');
        $this->db->from('project_sales_invoices');
        $this->db->where('company_id', $this->session->userdata('company_id'));
        $this->db->order_by('project_id','asc');
        $query = $this->db->get();
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }
    public function get_project(){
        $this->db->select('*');
        $this->db->from('project_projects');
        $this->db->where('company_id', $this->session->userdata('company_id'));
        $this->db->order_by('project_id','asc');
        $query = $this->db->get();
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function get_filter_projects($project_id){
        $this->db->select('*');
        $this->db->from('project_projects');
        $this->db->where('company_id', $this->session->userdata('company_id'));
        $this->db->where('project_id',$project_id);
        $query = $this->db->get();
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function get_project_info($id) {
        $this->db->select('*');
        $this->db->where('project_id', $id);
        $get = $this->db->get('project_projects');
        return $get->row_array();
    }

    public function get_client_info($id) {
        $this->db->select('*');
        $this->db->where('client_id', $id);
        $get = $this->db->get('project_clients');
        return $get->row_array();
    }

    public function get_project_id_from_costing_id($id) {

        $this->db->select('project_id');
        $this->db->where('costing_id', $id);
        $get = $this->db->get('project_costing');

        return $get->row_array();
    }
    
    public function get_dashboard_project_costing() {
        
        $query = $this->db->query("SELECT * FROM project_costing WHERE project_id IN (SELECT project_id FROM project_projects WHERE project_status=1 AND company_id='".$this->session->userdata('company_id')."')");

        return $query->result_array();
    }


    public function get_costing_id_from_project_id($id) {

        $this->db->select('costing_id');
        $this->db->where('project_id', $id);
        $get = $this->db->get('project_costing');

        return $get->row_array();
    }
    
    public function get_all_projects_list($status=""){
      $company_id = $this->session->userdata('company_id');
        
      if($status=="pending"){
        $this->db->select('*');
        $this->db->where('project_status', 2);
        $this->db->where('company_id', $company_id);
        $get = $this->db->get('project_projects');
      }
      else if($status=="active"){
        $this->db->select('*');
        $this->db->where('project_status', 1);
        $this->db->where('company_id', $company_id);
        $get = $this->db->get('project_projects');
      }
      else if($status=="completed"){
          $this->db->select('*');
        $this->db->where('project_status', 3);
        $this->db->where('company_id', $company_id);
        $get = $this->db->get('project_projects');
      }
      else {
        $this->db->select('*');
        $this->db->where('project_status', 0);
        $this->db->where('company_id', $company_id);
        $get = $this->db->get('project_projects');
      }
      
      $result = $get->result_array();
      return $result;
    }

    public function get_active_projects() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
        $this->db->where('project_status', '1');
        $this->db->where('company_id', $company_id);
        $get = $this->db->get('project_projects');

        $result = $get->result_array();
        return $result;
    }
    
     public function get_active_pending_project() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT cp.*,p.project_title,p.project_id FROM project_costing cp, project_projects p WHERE cp.project_id=p.project_id AND cp.company_id='" . $company_id . "' AND (project_status=1 OR project_status=2)");
        return $q->result();
    }
    
    public function get_project_supplier_users($project_id) {
        $query = "SELECT parts.costing_supplier, sup.*
             FROM  project_costing_parts parts 
             INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)
             INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)
             WHERE costing.project_id = '" . $project_id . "' AND parts.costing_part_status=1 AND sup.parent_supplier_id>0";
       
        $query .= " GROUP BY parts.costing_supplier"; 
        $q = $this->db->query($query);
        return $q->result();
    }

    public function get_costing_parts($id, $costing_id = false) {
        $company_id = $this->session->userdata('company_id');
        if ($costing_id == false) {
            $q = $this->db->query("SELECT cp.*,sp.supplier_name,s.stage_name,c.* FROM `project_costing` pc, project_costing_parts cp, project_stages s, project_suppliers sp,project_components c WHERE pc.costing_id=cp.costing_id AND cp.stage_id=s.stage_id AND cp.costing_supplier=sp.supplier_id AND cp.component_id=c.component_id AND cp.stage_id='" . $id . "' AND pc.company_id=" . $company_id);
        } else {
            $q = $this->db->query("SELECT cp.*,sp.supplier_name,s.stage_name,c.* FROM `project_costing` pc, project_costing_parts cp, project_stages s, project_suppliers sp,project_components c WHERE pc.costing_id=cp.costing_id AND cp.stage_id=s.stage_id AND cp.costing_supplier=sp.supplier_id AND cp.component_id=c.component_id AND cp.stage_id='" . $id . "' AND pc.costing_id='" . $costing_id . "' AND pc.company_id=" . $company_id);
        }

        return $q->result();
    }

    public function get_costing_stages($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT s.stage_name,s.stage_id FROM `project_costing` pc, project_costing_parts cp, project_stages s WHERE pc.costing_id=cp.costing_id AND cp.stage_id=s.stage_id AND pc.costing_id='" . $id . "' AND pc.company_id=" . $company_id . " GROUP BY s.stage_id ORDER BY s.stage_id DESC");
        return $q->result();
    }

    public function get_project_costing($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT pc.*,p.project_title FROM project_costing pc, project_projects p WHERE pc.project_id=p.project_id AND pc.costing_id='" . $id . "'");
        return $q->result();
    }

    public function get_project_costing_by_project_id($id) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("*");
        $this->db->where('project_id', $id);
        $result = $this->db->get('project_costing');
        return $result->row_array();
    }
    
    public function get_project_costing_by_costing_id($id) {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("*");
        $this->db->where('costing_id', $id);
        $result = $this->db->get('project_costing');
        return $result->row_array();
    }

    public function get_project_costing_info($id) {
        $q = $this->db->query("SELECT pc.*,p.project_title FROM project_costing pc, project_projects p WHERE pc.project_id=p.project_id AND pc.project_id='" . $id . "'");
        return $q->row();
    }
    
    public function get_supplierz_project_costing_info($id) {
        $q = $this->db->query("SELECT * FROM project_costing WHERE costing_id='" . $id . "'");
        return $q->row();
    }

    public function get_costing_stages_by_projectid($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT s.stage_name,s.stage_id FROM `project_costing` pc, project_costing_parts cp, project_stages s WHERE pc.costing_id=cp.costing_id AND cp.is_variated=0 AND cp.costing_part_status=1 AND cp.stage_id=s.stage_id AND pc.project_id='" . $id . "'  GROUP BY s.stage_id ");

        return $q->result();
    }
    
    public function get_costing_components_by_projectid($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT c.component_name, c.component_id FROM `project_costing` pc, project_costing_parts cp, project_components c WHERE pc.costing_id=cp.costing_id AND cp.is_variated=0 AND cp.costing_part_status=1 AND cp.component_id=c.component_id AND pc.project_id='" . $id . "'  GROUP BY c.component_id ");

        return $q->result_array();
    }

    public function get_costing_stages_by_costing_suppler_id($supplier_id, $costing_id) {
        $company_id = $this->session->userdata('company_id');
        //$q = $this->db->query("SELECT s.stage_name,s.stage_id FROM  project_costing_parts cp, project_stages s WHERE  cp.stage_id=s.stage_id AND cp.costing_id='" . $costing_id . "'  AND cp.costing_supplier = '" . $supplier_id . "' GROUP BY s.stage_id ");
        $q = $this->db->query("SELECT stage_name, stage_id FROM  project_stages  WHERE company_id = '".$company_id."'");
        return $q->result();
    }

    public function get_costing_detail_by_projectid($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT * FROM `project_costing` pc WHERE pc.project_id = '" . $id . "'  GROUP BY pc.costing_id ");

        return $q->row();
    }

    public function get_costing_id_by_project($project_id) {
        $query = "SELECT pc.costing_id  "
            . " FROM project_costing pc "
            . " WHERE project_id = '" . $project_id . "' AND status = 1";
        $q = $this->db->query($query);
        return $q->row_array();
    }
    
    public function get_project_unordered_items($project_id, $type='') {
        $company_id = $this->session->userdata('company_id');
        /*$query = "SELECT parts.*, SUM(v.change_quantity) as change_quantity,SUM(v.updated_quantity) as updated_quantity, v.variation_id, sup.supplier_name, com.component_name, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " LEFT JOIN projectcost_variation_parts v ON (v.costing_part_id = parts.costing_part_id)"
            . " WHERE costing.project_id = '" . $project_id . "' AND parts.costing_part_status=1  AND costing.company_id='".$company_id."'";*/
        /*$query = "SELECT parts.*, v.change_quantity, v.variation_id, sup.supplier_name, com.component_name, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  projectcost_variation_parts v "
            . " INNER JOIN project_stages stage ON (stage.stage_id = v.stage_id)"
            . " INNER JOIN project_components com ON (com.component_id = v.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = v.supplier_id)"
            . " INNER JOIN projectcost_variations var ON (var.id = v.variation_id)"
            . " LEFT JOIN project_costing costing ON (costing.costing_id = var.costing_id)"
            . " LEFT JOIN project_costing_parts parts ON (parts.costing_part_id = v.costing_part_id)"
            . " WHERE costing.project_id = '" . $project_id . "' AND parts.costing_part_status=1  ";*/
        $query = "SELECT parts.costing_uom, parts.costing_part_id,stage.stage_name, stage.stage_id,parts.is_variated, parts.costing_part_name, com.component_name,com.component_uc as unit_price, sup.supplier_name, parts.costing_quantity, parts.costing_uc, parts.line_cost as project_costing_cost, costing.costing_id AS CostingID
             FROM  project_costing_parts parts 
             INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)
             INNER JOIN project_components com ON (com.component_id = parts.component_id)
             INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)
             INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)
             WHERE costing.project_id = '" . $project_id . "' AND parts.costing_part_status=1";
       
        
        if($type=='allowance'){
            $query .= "AND parts.client_allowance=1 ";
        }
        $query .= " GROUP BY parts.costing_part_id"; // addng this group by items becuase of sql_mode=only_full_group_by active in client server
        $query .= " ORDER BY costing_part_id ASC";
       // echo $query;
        $q = $this->db->query($query);
       //echo $this->db->last_query();
        return $q->result();
    }

    public function get_project_uninvoiced_items($project_id, $type='') {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.costing_type as part_costing_type, parts.costing_supplier, parts.costing_part_id,stage.stage_name, stage.stage_id,parts.is_variated, parts.costing_part_name, com.component_name,com.component_uc as unit_price, sup.supplier_name, parts.costing_quantity, parts.costing_uc, parts.line_cost as project_costing_cost, costing.costing_id AS CostingID
             FROM  project_costing_parts parts
             INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)
             INNER JOIN project_components com ON (com.component_id = parts.component_id)
             INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)
             INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)
             WHERE costing.project_id = '" . $project_id . "' AND parts.costing_part_status=1";
       
        $query .= " GROUP BY parts.costing_part_id"; // addng this group by items becuase of sql_mode=only_full_group_by active in client server
        $query .= " ORDER BY parts.costing_part_id ASC";
      // echo $query;
        $q = $this->db->query($query);
        //echo $this->db->last_query();
        return $q->result();
    }

    public function get_costing_parts_by_project_id($project_id, $type='', $stage_id = 0) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, sup.supplier_name, com.component_name,com.component_des, com.image as component_image, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.project_id = '" . $project_id . "' AND parts.is_variated=0 AND parts.costing_part_status=1  AND parts.costing_type = 'normal' ";
        if($type=='allowance'){
            $query .= "AND parts.client_allowance=1 ";
        }
        else if($type=='specification'){
            $query .= "AND parts.include_in_specification=1 ";
        }
        if($stage_id>0){
            $query .= "AND parts.stage_id=".$stage_id." ";
        }
        $query .= "ORDER BY costing_part_id ASC";
        $q = $this->db->query($query);
        //echo $this->db->last_query();exit;
        return $q->result();
    }
    
    public function get_supplierz_costing_parts_by_id($costing_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, sup.supplier_name, com.component_name,com.component_des, com.image as component_image, stage.stage_name, stage.stage_id"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " WHERE costing_id = " . $costing_id;
        $query .= " ORDER BY costing_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }
    
    public function get_costing_parts_by_stage($project_id, $stage_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, sup.supplier_name, com.component_name,com.component_des, com.image as component_image, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.project_id = '" . $project_id . "' AND parts.stage_id = '" . $stage_id . "' AND parts.is_variated=0 AND parts.costing_part_status=1 AND parts.costing_type='normal' ";
        $query .= "ORDER BY costing_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }
    
    public function get_supplierz_costing_parts_by_stage($costing_id, $stage_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, sup.supplier_name, com.component_name,com.component_des, com.image as component_image, stage.stage_name, stage.stage_id"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " WHERE parts.costing_id = '" . $costing_id . "' AND parts.stage_id = " . $stage_id;
        $query .= " ORDER BY costing_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }
    
    public function get_tracking_costing_parts_by_project_id($project_id, $type='') {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, sup.supplier_name, com.component_name,com.image as component_image, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_components com ON (com.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.project_id = '" . $project_id . "'";
        if($type=='allowance')
            $query .= "AND parts.client_allowance=1 ";
        $query .= "ORDER BY costing_part_id ASC";
        $q = $this->db->query($query);
       // echo $this->db->last_query();exit;
        return $q->result();
    }

    public function get_specification_parts_by_project_id($project_id, $type='') {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.project_id = '" . $project_id . "' AND parts.is_variated=0 AND parts.costing_part_status=1  ";
        if($type=='allowance')
            $query .= "AND parts.client_allowance=1 ";
        $query .= "ORDER BY stage.stage_id ASC";
        $q = $this->db->query($query);
        //echo $this->db->last_query();exit;
        return $q->result();
    }

    public function get_costing_parts_by_costing_id($costing_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE costing.costing_id = '" . $costing_id . "' ORDER BY costing_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }

    public function supplier_order_parts_by_costing_id($costing_id) {
        $query = " SELECT * FROM project_costing_parts parts WHERE parts.stage_id IN ( SELECT stage_id from project_costing_parts ps WHERE ps.costing_supplier IN (SELECT costing_supplier from project_costing_parts psp GROUP BY costing_supplier))";
        $q = $this->db->query($query);
        return $q->result();
    }

    public function get_costing_suppliers_by_costing_id2($costing_id) {
        $query = "SELECT costing_supplier FROM project_costing_parts WHERE costing_id= '" . $costing_id . "' GROUP BY costing_supplier";
        $q = $this->db->query($query);
        return $q->result_array();
    }

    public function get_costing_suppliers_by_costing_id($costing_id, $supplier_id = 0) {

        /*$query = "SELECT cp.costing_supplier, s.supplier_name
        FROM project_costing_parts cp 
        JoIN project_suppliers s ON (s.supplier_id=cp.costing_supplier)
        WHERE cp.costing_id= '" . $costing_id . "' GROUP BY cp.costing_supplier UNION SELECT vp.supplier_id, s.supplier_name
        FROM projectcost_variations v
        JoIN projectcost_variation_parts vp ON (v.id=vp.variation_id)
        JoIN project_suppliers s ON (s.supplier_id=vp.supplier_id)
        WHERE v.costing_id= '" . $costing_id . "' GROUP BY vp.supplier_id";*/
        if($supplier_id==0){
             $query = "SELECT supplier_id as costing_supplier, supplier_name FROM project_suppliers WHERE company_id= '" . $this->session->userdata('company_id') . "' ORDER BY supplier_name ASC";
        }
        else{
            $query = "SELECT supplier_id as costing_supplier, supplier_name FROM project_suppliers WHERE company_id= '" . $this->session->userdata('company_id') . "' AND supplier_id = ".$supplier_id." ORDER BY supplier_name ASC";
   
        }
        $q = $this->db->query($query);
        return $q->result_array();
    }
    
    public function get_costing_stages_by_costing_id($costing_id) {

        $query = "SELECT distinct(cp.stage_id), s.stage_name FROM project_costing_parts cp INNER JOIN project_stages s ON s.stage_id = cp.stage_id WHERE cp.costing_id = ".$costing_id." ORDER BY s.stage_name ASC";
        $q = $this->db->query($query);
        return $q->result_array();
    }

    public function get_costing_stages_by_suppliers($supplier_id, $costing_id, $stage_id = 0) {
        if($stage_id == 0){
           $query = "SELECT b.stage_id,s.stage_name FROM project_costing_parts b JOIN project_stages s ON (b.stage_id=s.stage_id) WHERE b.costing_id= '" . $costing_id . "' AND b.costing_supplier = '" . $supplier_id . "' GROUP BY stage_id ";
        }
        else{
            $query = "SELECT b.stage_id,s.stage_name FROM project_costing_parts b JOIN project_stages s ON (b.stage_id=s.stage_id) WHERE b.costing_id= '" . $costing_id . "' AND b.costing_supplier = '" . $supplier_id . "' AND b.stage_id = '" . $stage_id . "' GROUP BY stage_id ";
        }
        $q = $this->db->query($query);
        return $q->result_array();
    }

    public function get_parts_by_stage_id($stage_id, $supplier_id, $costing_id) {
        $query = " SELECT project_costing_parts.*,project_components.component_name as component_name,project_stages.stage_name as stage_name,project_suppliers.supplier_name as supplier_name  "
            . " FROM project_costing_parts"
            . " JOIN project_components ON (project_costing_parts.component_id=project_components.component_id)"
            . " JOIN project_stages ON (project_costing_parts.stage_id=project_stages.stage_id)"
            . " JOIN project_suppliers ON (project_costing_parts.costing_supplier=project_suppliers.supplier_id)"
            . " WHERE costing_id= '" . $costing_id . "' AND project_costing_parts.costing_supplier = '" . $supplier_id . "'  AND project_costing_parts.stage_id= '" . $stage_id . "'  ";
        $q = $this->db->query($query);
        return $q->result_array();
    }

    public function get_allowanced_parts_by_project_id($project_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, stage.stage_name, stage.stage_id, costing.costing_id AS CostingID, component.component_name AS ComponentName"
            . " FROM  project_costing_parts parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_components component ON (component.component_id = parts.component_id)"
            . " INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)"
            . " WHERE parts.client_allowance =1 AND costing.project_id = '" . $project_id . "' ORDER BY costing_part_id ASC";
        $q = $this->db->query($query);

        return $q->result();
    }

    public function get_costing_parts_by_template_id($temp_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, stage.stage_name, stage.stage_id, component.component_id as pricebook_component_id, component.component_des, component.component_name, suppliers.supplier_name"
            . " FROM  project_tpl_component_part parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_components component ON (component.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers suppliers ON (suppliers.supplier_id = parts.tpl_part_supplier_id)"
            . " INNER JOIN project_templates templates ON (templates.template_id = parts.temp_id)"
            . " WHERE templates.template_id = '" . $temp_id . "' ORDER BY parts.tpl_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }
    
    public function get_costing_parts_by_supplierz_template_id($temp_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.*, stage.stage_name, stage.stage_id, component.company_id, component.component_id as pricebook_component_id, component.id as parent_component_id, component.component_des, component.component_name, suppliers.supplier_name"
            . " FROM  project_supplierz_tpl_component_part parts "
            . " INNER JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_price_book_components component ON (component.component_id = parts.component_id)"
            . " INNER JOIN project_suppliers suppliers ON (suppliers.supplier_id = parts.supplier_id)"
            . " INNER JOIN project_supplierz_templates templates ON (templates.template_id = parts.temp_id)"
            . " WHERE templates.template_id = '" . $temp_id . "' ORDER BY parts.tpl_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }
    
    public function get_supplierz_costing_parts_by_template_id($temp_id) {
        $query = "SELECT parts.*, component.component_name, component.component_id as pricebook_component_id, stage.stage_name, stage.stage_id as pricebook_stage_id, component.component_uc"
            . " FROM  project_supplierz_tpl_component_part parts "
            . " LEFT JOIN project_stages stage ON (stage.stage_id = parts.stage_id)"
            . " LEFT JOIN project_price_book_components component ON (component.component_id = parts.component_id)"
            . " INNER JOIN project_supplierz_templates templates ON (templates.template_id = parts.temp_id)"
            . " WHERE templates.template_id = '" . $temp_id . "' ORDER BY parts.tpl_part_id ASC";
        $q = $this->db->query($query);
        return $q->result();
    }


    public function get_takeoff_data_by_ids($ids = "") {

        $query = "SELECT * from project_takeoffdata WHERE takeof_id IN (" . $ids . ")";
        $q = $this->db->query($query);
        return $q->result();
    }

    public function get_costing_parts_by_stage_id($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name FROM `project_costing` pc, project_costing_parts cp WHERE pc.costing_id=cp.costing_id  AND cp.stage_id='" . $id . "' AND pc.company_id='" . $company_id . "'");
        return $q->result();
    }

    public function get_costing_parts_by_project_stages($stageId = 0, $supplier_id=0, $costingId = 0) {
        $company_id = $this->session->userdata('company_id');
        if(($supplier_id==0 || $supplier_id=="") && $stageId>0){
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc, project_costing_parts

         cp,project_components c

         WHERE cp.component_id=c.component_id AND pc.costing_id=cp.costing_id  AND cp.stage_id='" . $stageId . "' AND cp.costing_part_status=1 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'");
        }
        else if(($stageId==0 || $stageId=="") && $supplier_id>0){
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc, project_costing_parts

         cp,project_components c

         WHERE cp.component_id=c.component_id AND pc.costing_id=cp.costing_id AND cp.costing_supplier='" . $supplier_id . "' AND cp.costing_part_status=1 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'");
        }
        else if(($stageId==0 || $stageId=="") && ($supplier_id==0 || $supplier_id=="")){
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc, project_costing_parts

         cp,project_components c

         WHERE cp.component_id=c.component_id AND pc.costing_id=cp.costing_id AND cp.costing_part_status=1 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'");
        }
        else{
            $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc, project_costing_parts

         cp,project_components c

         WHERE cp.component_id=c.component_id AND pc.costing_id=cp.costing_id  AND cp.stage_id='" . $stageId . "' AND cp.costing_supplier='" . $supplier_id . "' AND cp.costing_part_status=1 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'"); 
        }

       //echo $this->db->last_query();exit;
        return $q->result();
    }
    
    
    

    public function get_costing_parts_by_project_supplier_stage_id($stageId = 0, $costingId = 0,$supplier_id = 0,$type="") {
        $company_id = $this->session->userdata('company_id');
        if($type=="new"){
            $q = $this->db->query("SELECT v.*, c.component_name FROM project_variation_parts v INNER JOIN project_components c ON v.component_id = c.component_id WHERE v.stage_id='".$stageId."' AND v.supplier_id='" . $supplier_id . "'");
            
        }
        else{
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name,cp.is_variated, c.component_name 
            FROM project_costing pc, project_costing_parts cp,project_components c

         WHERE cp.component_id=c.component_id AND pc.costing_id=cp.costing_id AND cp.costing_part_status=1  AND cp.stage_id='" . $stageId . "' AND cp.costing_supplier='" . $supplier_id . "' AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'");
        }
        //echo $this->db->last_query();
        return $q->result();
    }



    public function get_costing_component_by_partid($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT * FROM `project_costing_parts` cp, project_components c WHERE cp.`component_id`=c.`component_id` AND cp.costing_part_id='" . $id . "'");
        return $q->result();
    }

    public function get_stages_by_tempid($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT s.stage_id,s.stage_name FROM `project_tpl_component_part` cp, project_stages s WHERE cp.stage_id=s.stage_id AND cp.temp_id='" . $id . "' GROUP BY cp.stage_id ORDER BY s.stage_id DESC");



        return $q->result();
    }
    
    public function get_supplierz_stages_by_tempid($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT s.stage_id,s.stage_name FROM `project_supplierz_tpl_component_part` cp, project_stages s WHERE cp.stage_id=s.stage_id AND cp.temp_id='" . $id . "' GROUP BY cp.stage_id ORDER BY s.stage_id DESC");

        return $q->result();
    }

    public function get_temp_component_by_stageid($id, $temp_id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT c.*, cp.* FROM `project_tpl_component_part` cp, project_components c WHERE cp.component_id=c.component_id AND cp.temp_id='" . $temp_id . "'  AND cp.stage_id='" . $id . "'");
        return $q->result();
    }

    public function get_existing_project() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT cp.*,p.project_title,p.project_id FROM project_costing cp,project_projects p WHERE cp.project_id=p.project_id AND cp.company_id='" . $company_id . "'");
        return $q->result_array();
    }
    
    public function get_existing_supplierz_project_costing(){
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT * FROM project_costing WHERE project_id=0 AND status = 1 AND company_id='" . $company_id . "'");
        return $q->result_array();
    }
    
    public function get_active_project_for_sales_summary() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT cp.*,p.project_title,p.project_id FROM project_costing cp,project_projects p WHERE cp.project_id=p.project_id AND cp.company_id='" . $company_id . "' AND project_status=1");
        return $q->result_array();
    }
    
    public function get_active_project() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT cp.*,p.project_title,p.project_id FROM project_costing cp,project_projects p WHERE cp.project_id=p.project_id AND cp.company_id='" . $company_id . "' AND project_status=1");
        return $q->result();
    }

    public function get_not_existing_project() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT * FROM project_projects WHERE project_id NOT IN (SELECT project_id FROM project_costing) AND company_id='" . $company_id . "'");
        return $q->result();
    }

    public function get_all_costed_projects($status=-1) {
        $company_id = $this->session->userdata('company_id');
        if($status==-1){
          $q = $this->db->query("SELECT bp.*,bp.project_address_city as city_name,bp.project_address_country as country_name, bp.project_address_state as state_name, bc.*,
          (SELECT created_date FROM project_costing WHERE project_id = bp.project_id) as created_date, 
          (SELECT costing_id FROM project_costing WHERE project_id = bp.project_id) as costing_id
          FROM `project_projects` bp, project_clients bc WHERE 
          bp.project_id  IN (SELECT project_id FROM project_costing) AND
          bp.client_id=bc.client_id AND bp.company_id =" . $company_id." ORDER BY costing_id DESC");
        }
        else{
          $q = $this->db->query("SELECT bp.*, bp.project_address_city as city_name, bp.project_address_country as country_name, bp.project_address_state as state_name, bc.*,
          (SELECT created_date FROM project_costing WHERE project_id = bp.project_id) as created_date, 
          (SELECT costing_id FROM project_costing WHERE project_id = bp.project_id) as costing_id
          FROM `project_projects` bp, project_clients bc WHERE 
          bp.project_id  IN (SELECT project_id FROM project_costing) AND
          bp.client_id=bc.client_id AND bp.project_status = ".$status." AND bp.company_id =" . $company_id." ORDER BY costing_id DESC"); 
        }
        return $q->result();
    }
    
    public function get_all_supplierz_project_costing() {
        $company_id = $this->session->userdata('company_id');
        
        $q = $this->db->query("SELECT * FROM project_costing WHERE project_id = 0 AND company_id =" . $company_id." ORDER BY costing_id DESC");
       
        return $q->result();
    }
    
    public function get_all_confirm_estimates($status=0){
        $company_id = $this->session->userdata('company_id');
        if($status==0){
        $q = $this->db->query("SELECT ce.*, p.project_title, s.supplier_name FROM project_confirm_estimates ce INNER JOIN project_projects p ON p.project_id = ce.project_id INNER JOIN project_suppliers s ON s.parent_supplier_id = ce.supplier_id WHERE ce.company_id =" . $company_id);
        }
        else{
          $supplier_id = $this->session->userdata('company_id');
          $q = $this->db->query("SELECT ce.*, p.project_title, s.supplier_name FROM project_confirm_estimates ce INNER JOIN project_projects p ON p.project_id = ce.project_id INNER JOIN project_suppliers s ON s.parent_supplier_id = ce.supplier_id WHERE ce.supplier_id ='" . $supplier_id."' AND ce.status='".$status."'");
        }
        return $q->result();
    }
    
    public function get_parts_by_search($project_id, $supplier_id){
        $costing_id = $this->get_costing_id_by_project($project_id);
        $q = $this->db->query("SELECT cp.*, s.stage_name, c.component_name FROM project_costing_parts cp INNER JOIN project_stages s ON s.stage_id = cp.stage_id INNER JOIN project_components c ON c.component_id = cp.component_id WHERE cp.costing_id ='".$costing_id['costing_id']."' AND cp.costing_supplier='".$supplier_id."'");
        return $q->result();
    }
    
    public function get_existing_templates() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT * FROM project_templates WHERE template_status=1 AND company_id='" . $company_id . "'");
        return $q->result();
    }

    public function get_confirm_estimate_details($id, $user_type=0){
        $company_id = $this->session->userdata('company_id');
        if($user_type==0){
        $q = $this->db->query("SELECT ce.*, p.project_title, sup.supplier_name, s.stage_name, c.component_name, cp.stage_id, cp.component_id, cp.costing_quantity, cp.costing_part_name, cp.line_cost, cp.costing_uc, cp.costing_uom, cep.user_notes, cep.supplier_notes FROM project_confirm_estimates ce INNER JOIN project_confirm_estimate_parts cep ON cep.confirm_estimate_id = ce.id INNER JOIN project_projects p ON p.project_id = ce.project_id INNER JOIN project_suppliers sup ON sup.parent_supplier_id = ce.supplier_id INNER JOIN project_costing_parts cp ON cp.costing_part_id = cep.costing_part_id INNER JOIN project_stages s ON s.stage_id = cp.stage_id INNER JOIN project_components c ON c.component_id = cp.component_id WHERE ce.company_id ='" . $company_id."' AND cep.confirm_estimate_id='".$id."'");
        }
        else{
         $supplier_id = $this->session->userdata('company_id');
         $q = $this->db->query("SELECT ce.*, p.project_title, sup.supplier_name, s.stage_name, c.component_name, cp.stage_id, cp.costing_part_id, cp.component_id, cp.costing_quantity, cp.costing_part_name, cp.line_cost, cp.costing_uc, cp.costing_uom, cep.id as confirm_estimate_part_id, cep.user_notes, cep.supplier_notes FROM project_confirm_estimates ce INNER JOIN project_confirm_estimate_parts cep ON cep.confirm_estimate_id = ce.id INNER JOIN project_projects p ON p.project_id = ce.project_id INNER JOIN project_suppliers sup ON sup.parent_supplier_id = ce.supplier_id INNER JOIN project_costing_parts cp ON cp.costing_part_id = cep.costing_part_id INNER JOIN project_stages s ON s.stage_id = cp.stage_id INNER JOIN project_components c ON c.component_id = cp.component_id WHERE ce.supplier_id ='" . $supplier_id."' AND cep.confirm_estimate_id='".$id."'");
          
        }
        return $q->result();
    }
     public function get_admin_templates($id=0) {
        $this->db->select("*");
        $this->db->from("admin_templates");
        if($id>0){
            $this->db->where('template_id',$id);
        }
        $q = $this->db->get();
        return $q->result();
    }

    public function get_admin_template_parts($id=0) {
        $this->db->select("*");
        $this->db->from("admin_tmpl_part");
        $this->db->where('temp_id',$id);
        $q = $this->db->get();
        return $q->result();
    }

    public function get_costing_part_info_by_id($costing_part_id) {

        $q = $this->db->query("SELECT cp.*, sup.supplier_name, s.stage_name, c.component_name FROM project_costing_parts cp INNER JOIN project_stages s ON s.stage_id = cp.stage_id INNER JOIN project_suppliers sup ON sup.supplier_id = cp.costing_supplier INNER JOIN project_components c ON c.component_id = cp.component_id WHERE  cp.costing_part_id='" . $costing_part_id . "'");
        return $q->row();
    }
    
    public function get_variation_part_info_by_id($part_id) {

        $q = $this->db->query("SELECT v.*, c.component_name FROM  project_variation_parts v INNER JOIN project_components c ON c.component_id= v.component_id WHERE v.id='" . $part_id . "'");
        return $q->row();
    }

    public function get_part_detail_by_cost_part_id($costing_id) {

        $query = "SELECT cp.*, st.stage_name, s.supplier_name, c.component_name"
            . " FROM project_costing_parts cp"
            . " INNER JOIN project_stages st ON (st.stage_id= cp.stage_id) "
            . " INNER JOIN project_suppliers s ON (s.supplier_id = cp.costing_supplier)"
            . " INNER JOIN project_components c ON (c.component_id= cp.component_id)"
            . " WHERE cp.costing_part_id = '" . $costing_id . "'";

        $get = $this->db->query($query);
        return $get->row();
    }

    public function get_porder_detail_by_id($id) {

        $this->db->select('project_purchase_orders.*, project_suppliers.supplier_name , project_suppliers.supplier_email, project_suppliers.parent_supplier_id');
        $this->db->join('project_suppliers',"project_suppliers.supplier_id = project_purchase_orders.supplier_id" );
        $this->db->where('project_purchase_orders.id', $id);
        $this->db->where('project_purchase_orders.company_id', $this->session->userdata('company_id'));

        $get = $this->db->get('project_purchase_orders');
        return $get->row();
    }
    
    public function get_porder_detail_by_id_for_suppliers($id) {
        $this->db->select('project_purchase_orders.*, project_suppliers.supplier_name , project_suppliers.supplier_email, project_suppliers.parent_supplier_id');
        $this->db->join('project_suppliers',"project_suppliers.supplier_id = project_purchase_orders.supplier_id" );
        $this->db->where('project_purchase_orders.id', $id);
        $this->db->where('project_suppliers.parent_supplier_id', $this->session->userdata('company_id'));

        $get = $this->db->get('project_purchase_orders');
        return $get->row();
    }

    public function get_order_items_by_porder_id($porder_id){
        $query = "SELECT i.*, pc.type_status, pc.costing_quantity, i.comment, pc.is_variated, s.stage_name, c.component_name, c.component_des, sup.supplier_name "
            . " FROM project_purchase_order_items i "
            . "JOIN project_suppliers sup ON(sup.supplier_id = i.supplier_id) "
            . "JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . "JOIN project_components c ON (c.component_id = i.component_id) "
            . "JOIN project_costing_parts pc ON (pc.costing_part_id = i.costing_part_id) "
            . " WHERE i.purchase_order_id = '".$porder_id."'";

        $get = $this->db->query($query);

        return $get->result_array();


    }

    public function get_all_purchase_orders($status){
        $company_id = $this->session->userdata('company_id');
        $query ="SELECT po.*,pr.project_title, s.supplier_name, stage.stage_name FROM"
            . " project_purchase_orders po "
            . " JOIN project_projects pr ON (pr.project_id= po.project_id)"
            . " JOIN project_suppliers s ON (s.supplier_id =po.supplier_id)"
            . " LEFT JOIN project_stages stage ON (stage.stage_id =po.stage_id) WHERE po.company_id='".$company_id."' AND pr.project_status=".$status." ORDER BY po.id DESC";

        $get =$this->db->query($query);
        return $get->result_array();
    }


    public function get_po_suppliers_by_costing_id($costing_id){
        $query = "SELECT i.supplier_id,s.supplier_name"
            . " FROM project_purchase_orders i "
            . "JOIN project_suppliers s ON(s.supplier_id = i.supplier_id) "
            . " WHERE i.costing_id = '".$costing_id."'"
            . "GROUP BY i.supplier_id"
        ;

        $get = $this->db->query($query);

        return $get->result_array();


    }

    public function get_po_stages_by_costing_suppler_id($supplier_id,$costing_id){

        $query = "SELECT i.stage_id, s.stage_name"
            . " FROM project_purchase_orders i "
            . " JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . " WHERE i.costing_id = '".$costing_id."' AND i.supplier_id= '".$supplier_id."' AND i.supplier_invoice_id=0 "
            . " GROUP BY i.stage_id";

        //print_r($query);
        $get = $this->db->query($query);

        return $get->result_array();

    }


    public function get_component_id($project_id, $costingp_id, $stage_id ){

        $query = "SELECT component_id,costing_supplier,costing_id"
            . " FROM project_costing_parts  "
            . " WHERE costing_part_id = '" . $costingp_id . "'";

//print_r($query); echo "<br>";


        $get = $this->db->query($query);
        $component_id_from_db = $get->result_array();


        $query_for_check = "SELECT i.*, p.* "
            . " FROM project_purchase_orders p INNER JOIN project_purchase_order_items i ON p.id=i.purchase_order_id"
            . " WHERE p.costing_id = '" . $component_id_from_db[0]['costing_id'] . "' AND p.supplier_id='" . $component_id_from_db[0]['costing_supplier'] . "' AND p.stage_id='" . $stage_id . "' AND i.costing_part_id='" . $costingp_id. "'" ;

//print_r($query_for_check);echo "<br>";
        $get_result = $this->db->query($query_for_check);
        $output = $get_result->result_array();

        print_r($output);


        $data_array = $output[0]['id'];



        if (count($output) > 0) {

            $arr = array
            (
                'is_exist' => 1,
                'purchaser_id' => $data_array
            );
            echo json_encode($arr);
        } else {
            $arr = array
            (
                'is_exist' => 0,
                'component_id' => $data_array
            );
            echo json_encode($arr);
        }
        exit;
    }

    public function get_po__by_costing_suppler_stage_id($project_id, $supplier_id,$stage_id) {

        $query = "SELECT id"
            . " FROM project_purchase_orders  "
            . " WHERE costing_id = '".$project_id."' AND supplier_id= '".$supplier_id. "' AND stage_id= '".$stage_id."' AND supplier_invoice_id=0";

        print_r($query);
        $get = $this->db->query($query);

        return $get->result_array();



    }


    public function get_pc__by_costing_suppler_stage_id($project_id, $supplier_id,$stage_id ){
        $query = "SELECT s.costing_part_id, s.costing_part_name, s.costing_quantity, i.component_name"
            . " FROM project_costing_parts  s"
            . " JOIN project_components i ON (i.component_id=s.component_id)"
            . " WHERE s.costing_id = '".$project_id."' AND s.costing_supplier= '".$supplier_id. "' AND s.stage_id= '".$stage_id."'";

        //print_r($query);
        $get = $this->db->query($query);

        return $get->result_array();


    }

    public function get_order_quantity_by_costingpartid($costing_part_id){
        $query = "SELECT SUM( i.`order_quantity` ) as total_ordered "
            . " FROM project_purchase_order_items i "
            . " JOIN project_purchase_orders s ON (s.id=purchase_order_id)"
            . " WHERE i.costing_part_id = '".$costing_part_id."' AND (s.order_status!='Cancelled')";
        $get = $this->db->query($query);

        return $get->result_array();



    }

    public function getupdatedquantitybycostingpartid($costing_part_id){

        /*$query = "SELECT  `updated_quantity`"
            . " FROM  `projectcost_variation_parts`"
            . " WHERE  `costing_part_id` = '".$costing_part_id."'"
            . " AND  `id` = ( "
            . " SELECT MAX( i.`id` )"
            . " FROM  `projectcost_variation_parts` i"
            . " JOIN  `projectcost_variations` s ON ( i.`variation_id` = s.`id` )"
            . " WHERE i.`costing_part_id` = '".$costing_part_id."' AND (s.status!='PENDING' OR s.status!='ISSUED') "
            . "  )"; */
        $query = "SELECT  p.updated_quantity, v.var_number"
            . " FROM  project_variation_parts p INNER JOIN project_variations v ON v.id = p.variation_id"
            . " WHERE  p.costing_part_id = '".$costing_part_id."'";

//echo $query;exit;
        $get = $this->db->query($query);

        return $get->result_array();

    }
    
     public function get_scredit_items_by_sinvoice_id($invoice_id, $type, $orderno=0){

        $query = "SELECT i.*,s.stage_name, c.component_name  ";

        if($type=='pc'){
            $query.= ", k.is_variated, k.costing_uom, k.costing_supplier, k.costing_type, k.costing_uc, k.margin,k.costing_quantity , k.line_cost, k.line_margin, k.margin ";
        }
        if($type=='po'){
            $query.=  ", m.order_quantity, m.costing_uom, m.costing_uc, m.line_cost, m.line_margin, m.margin ";
        }

        $query.= " FROM project_supplier_credits_items i "
            . "LEFT JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . "LEFT JOIN project_components c ON (c.component_id = i.component_id) ";

        if($type=='pc'){
            $query.=  "LEFT JOIN project_costing_parts k ON (k.costing_part_id = i.costing_part_id) ";
        }
        if($type=='po'){
            $query .= " JOIN project_purchase_order_items m ON (m.costing_part_id = i.costing_part_id AND m.purchase_order_id=i.order_pc_id )";
        }

        $query.= " WHERE i.supplier_credit_id = '".$invoice_id."' AND i.supplier_invoice_item_type='".$type."'";

        if($type=='po')
            $query.= " AND i.order_pc_id='".$orderno."' AND i.costing_part_id!=0";

        $get = $this->db->query($query);


        return $get->result_array();


    }
    
    public function get_scredit_detail_by_id($invoice_id) {
        $this->db->select('supplier_credits.*, project_suppliers.supplier_name, project_variations.hide_from_sales_summary');
        $this->db->join('project_suppliers',"project_suppliers.supplier_id = supplier_credits.supplier_id" );
        $this->db->join('project_variations',"project_variations.var_number = supplier_credits.var_number", "left" );

        $this->db->where('supplier_credits.id', $invoice_id);

        $get = $this->db->get('supplier_credits');
        if($get->num_rows()>0){
        return $get->row();
        }
        else{
            return array();
        }
    }

    public function get_all_supplier_invoices($status=1){
        $company_id = $this->session->userdata('company_id');
        $query ="SELECT * FROM"
            . " project_supplier_invoices WHERE project_id IN (SELECT costing_id FROM project_costing WHERE project_id IN (SELECT project_id FROM project_projects WHERE project_status = ".$status.")) AND company_id = ".$company_id." UNION ALL Select * FROM project_supplier_credits WHERE project_id IN (SELECT costing_id FROM project_costing WHERE project_id IN (SELECT project_id FROM project_projects WHERE project_status = ".$status.")) AND company_id = ".$company_id." ORDER BY created_date DESC";

        $get =$this->db->query($query);
        return $get->result_array();


    }
    
    public function get_all_credit_notes($type=""){
        $company_id = $this->session->userdata('company_id');
        if($type==""){
        $query ="SELECT cr.*,pr.project_title, s.supplier_name FROM"
            . " credit_notes cr "
            . " JOIN project_costing t ON ( t.costing_id = cr.project_id)"
            . " JOIN project_projects pr ON (pr.project_id= t.project_id)"
            . " JOIN project_suppliers s ON (s.supplier_id =cr.supplier_id) WHERE cr.company_id = '".$company_id."'";
        }
        else{
             $query ="SELECT cr.*,pr.project_title FROM"
            . " project_sales_credit_notes cr "
            . " JOIN project_projects pr ON (pr.project_id= cr.project_id) WHERE cr.company_id = '".$company_id."'";
        }

        $get =$this->db->query($query);
        return $get->result_array();


    }
    
    public function get_all_cash_transfers($status = 1){
        $company_id = $this->session->userdata('company_id');
        $query ="SELECT tran.*,pr.project_title, s.supplier_name FROM"
            . " project_cash_transfers tran "
            . " JOIN project_projects pr ON (pr.project_id= tran.project_id)"
            . " JOIN project_suppliers s ON (s.supplier_id =tran.supplier_id) WHERE tran.company_id='".$company_id."' AND pr.project_status=".$status;

        $get =$this->db->query($query);
        return $get->result_array();
    }

    public function get_siuiq_by_pocpid($po_id,$cp_id) {
        $query ="SELECT  (t.order_quantity-SUM(si.quantity)) as uninvoicedquantity, SUM(si.invoice_amount) as invoice_amount FROM"
            . " project_supplier_invoices_items si "
            . " JOIN project_purchase_order_items t ON ( t.purchase_order_id ='".$po_id."' AND t.costing_part_id = '".$cp_id."'  )"

            . " JOIN project_supplier_invoices sis ON ( si.supplier_invoice_id = sis.id)"
            . " WHERE (si.order_pc_id ='".$po_id."'  ) AND si.costing_part_id ='".$cp_id."' AND sis.status!='Pending' group by t.order_quantity";
       
        $get =$this->db->query($query);
        return $get->result_array();


    }

    //get supplier invoice invoicedquantity quantity and invoiced_amount by costing part id
    public function get_siuiq_by_pccpid($cp_id) {
        $query ="SELECT (SUM(si.quantity)) as invoicedquantity, SUM(si.invoice_amount) as invoiced_amount,po.purchase_order_id FROM
             project_supplier_invoices_items si 
             JOIN project_supplier_invoices sis ON ( si.supplier_invoice_id = sis.id)
             LEFT JOIN project_purchase_order_items po ON ( po.costing_part_id = si.costing_part_id)
             WHERE ( (si.supplier_invoice_item_type='pc' AND si.order_pc_id ='".$cp_id."') OR si.supplier_invoice_item_type='po' ) AND si.costing_part_id ='".$cp_id."' GROUP BY po.purchase_order_id" ; // this group by added later b/c query is not running on live server with mysql update
        
        $get =$this->db->query($query);
        
//print_r($query);echo "\n";exit;
        return $get->result_array();


    }

    public function get_siuiq_by_poid($po_id,$com_id) {
        $query ="SELECT (t.order_quantity-SUM(si.quantity)) as uninvoicedquantity, SUM(si.invoice_amount) as invoice_amount FROM"
            . " supplier_invoices_items si "
            . " JOIN supplier_invoices sis ON ( si.supplier_invoice_id = sis.id)"
            . " JOIN project_purchase_order_items t ON ( t.purchase_order_id ='".$po_id."' AND t.costing_part_id = '0'  )"
            . " WHERE si.supplier_invoice_item_type='po' AND si.order_pc_id ='".$po_id."' AND si.costing_part_id ='0' AND si.srno ='".$com_id."' AND sis.status!='Pending' GROUP BY t.purchase_order_id" ;
        //print_r($query);
        $get =$this->db->query($query);
        //echo $this->db->last_query();exit;
        return $get->result_array();


    }
    
    public function get_credit_note_detail_by_id($credit_note_id, $type="") {
        
        if($type==""){
        $this->db->select('credit_notes.*, project_suppliers.supplier_name');
        $this->db->join('project_suppliers',"project_suppliers.supplier_id = credit_notes.supplier_id" );

        $this->db->where('credit_notes.id', $credit_note_id);

        $get = $this->db->get('credit_notes');
        }
        else{
           $this->db->select('sales_credit_notes.*');

        $this->db->where('sales_credit_notes.id', $credit_note_id);

        $get = $this->db->get('project_sales_credit_notes'); 
        }
        
        return $get->row();
    }

    public function get_sinvoice_detail_by_id($invoice_id) {
        $this->db->select('supplier_invoices.*, project_suppliers.supplier_name, project_variations.hide_from_sales_summary');
        $this->db->join('project_suppliers',"project_suppliers.supplier_id = supplier_invoices.supplier_id" );
        $this->db->join('project_variations',"project_variations.var_number = supplier_invoices.var_number", "left" );

        $this->db->where('supplier_invoices.id', $invoice_id);

        $get = $this->db->get('supplier_invoices');
        if($get->num_rows()>0){
        return $get->row();
        }
        else{
            return array();
        }
    }


   public function getcredit_note_items_by_credit_note_id($credit_note_id, $type=""){
       if($type==""){
        $query = "SELECT i.*,s.stage_name, c.component_name  ";

        $query.= " FROM project_sales_credit_note_items i "
            . "LEFT JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . "LEFT JOIN project_components c ON (c.component_id = i.component_id) ";

        $query.= " WHERE i.credit_note_id = '".$credit_note_id."'";
        
       }
       else{
          $query = "SELECT i.*";
        $query.= " FROM project_sales_credit_note_items i";

        $query.= " WHERE i.credit_note_id = '".$credit_note_id."'"; 
       }

        $get = $this->db->query($query);


        return $get->result_array();
       
   }
    public function get_sinvoice_items_by_sinvoice_id($invoice_id, $type, $orderno=0){

        $query = "SELECT i.*, s.stage_name, c.component_name, c.component_id, sup.supplier_name  ";

        if($type=='pc'){
            $query.= ", k.is_variated, k.costing_uom, k.costing_type, k.costing_uc, k.margin,k.costing_quantity , k.line_cost, k.line_margin, k.margin ";
        }
        if($type=='po'){
            $query.=  ", m.order_quantity, m.costing_uom, m.costing_uc, m.line_cost, m.line_margin, m.margin ";
        }

        $query.= " FROM project_supplier_invoices_items i "
            . "LEFT JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . "LEFT JOIN project_suppliers sup ON(sup.supplier_id = i.supplier_id) "
            . "LEFT JOIN project_components c ON (c.component_id = i.component_id) ";

        if($type=='pc'){
            $query.=  "LEFT JOIN project_costing_parts k ON (k.costing_part_id = i.costing_part_id) ";
        }
        if($type=='po'){
            $query .= " JOIN project_purchase_order_items m ON (m.costing_part_id = i.costing_part_id AND m.purchase_order_id=i.order_pc_id )";
        }

        $query.= " WHERE i.supplier_invoice_id = '".$invoice_id."' AND i.supplier_invoice_item_type='".$type."'";

        if($type=='po')
            $query.= " AND i.order_pc_id='".$orderno."' AND i.costing_part_id!=0";
//


        $get = $this->db->query($query);
        //echo $this->db->last_query();


        return $get->result_array();


    }
    
     public function get_sinvoice_items($project_id, $supplier_id){

        $query = "SELECT i.*,s.stage_name, c.component_name  ";

        
        $query.= ", k.is_variated, k.costing_uom, k.costing_uc, k.margin,k.costing_quantity , k.line_cost, k.line_margin, k.margin, k.client_allowance, k.costing_type ";

        $query.= " FROM project_supplier_invoices_items i "
            . "LEFT JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . "LEFT JOIN project_components c ON (c.component_id = i.component_id) ";

        $query.=  "LEFT JOIN project_costing_parts k ON (k.costing_part_id = i.costing_part_id) ";
        
        $query.=  "LEFT JOIN project_supplier_invoices si ON (si.id = i.supplier_invoice_id) ";

        $query.= " WHERE i.costing_part_id!=0 AND si.supplier_id='".$supplier_id."' AND si.project_id='".$project_id."'";

        $get = $this->db->query($query);

        return $get->result_array();
    }
    
    function get_sinvoicenipo_items_by_sinvoice_id($invoice_id, $type, $orderno=0) {
        $query = "SELECT i.*, s.stage_name, c.component_name ";
        $query.=  ", m.order_quantity, m.costing_uom, m.costing_uc, m.line_cost, m.line_margin, m.margin ";
        $query.= " FROM project_supplier_invoices_items i "
            . "JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . "JOIN project_components c ON (c.component_id = i.component_id) ";
        $query .= " JOIN project_purchase_order_items m ON (m.srno = i.srno AND m.purchase_order_id=i.order_pc_id )";
        $query.= " WHERE i.supplier_invoice_id = '".$invoice_id."' AND i.supplier_invoice_item_type='".$type."'";
        $query.= "AND i.costing_part_id=0 AND i.order_pc_id='".$orderno."'";
//


        $get = $this->db->query($query);

        return $get->result_array();
    }
    
    function updateorderstatus($po_id, $status) {
        $querry = "update project_purchase_orders SET order_status='$status' where id='$po_id'";
        $get = $this->db->query($querry);
        if ($get) {
            return true;
        } else {
            return false;
        }
    }
    
    function updatepurchaseorderitems($po_id) {
        $querry = "SELECT * FROM project_purchase_order_items where purchase_order_id='$po_id'";
        $get = $this->db->query($querry);
        $result = $get->result_array();
        
        foreach($result as $val){
            $querry = $this->db->query("SELECT * FROM project_costing_parts where costing_part_id='".$val['costing_part_id']."'");
            $records = $querry->row_array();
            if($records['costing_type']=="pvar"){
            $po_number = " (PO number ".$po_id." )";
            $costing_part_name = str_replace($po_number,"", $records['costing_part_name']);
            $this->db->query("UPDATE project_costing_parts SET costing_part_name='$costing_part_name' where costing_part_id='".$val['costing_part_id']."'");
            }
        }
    }

    function updatesistatus($si_id, $status, $invoice_date, $invoice_due_date) {
        $querry = "update supplier_invoices SET 
        status='$status', 
        invoice_date = '$invoice_date',
        invoice_due_date = '$invoice_due_date'
        where id='$si_id'";
        $get = $this->db->query($querry);
        if ($get) {
            return true;
        } else {
            return false;
        }
    }

    public function get_costingpart_ids_by_project($costing_id) {
        $query = "SELECT pc.costing_part_id  "
            . " FROM project_costing_parts pc "
            . " WHERE costing_id = '" . $costing_id . "' AND costing_part_status = 1 AND is_variated=0";
        $q = $this->db->query($query);
        return $q->result_array();
    }

    public function getclient_id_by_prj_id($project_id){
        $this->db->select('client_id');
        $this->db->where('project_id', $project_id);
        $get = $this->db->get('project_projects');
        $row = $get->row_array();
        return $row['client_id'];
    }

    public function get_pos__by_costing_suppler_id($supplier_id, $prject_id){
        $this->db->select('id');
        $this->db->where('costing_id', $prject_id);
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('order_status !=', 'Pending');
        $this->db->where('order_status !=', 'Cancelled');
        $get = $this->db->get('project_purchase_orders');
        return  $get->result_array();

    }

    public function getorderinsuin($invoice_id) {
        $query = "SELECT si.order_pc_id  "
            . " FROM project_supplier_invoices_items si "
            . " WHERE si.supplier_invoice_id = '" . $invoice_id . "' AND si.supplier_invoice_item_type='po' "
            . " Group by si.order_pc_id";
        $q = $this->db->query($query);
        return $q->result_array();
    }

    public function get_siparts_ids_by_si_id($si_id) {
        $query = "SELECT id  "
            . " FROM project_supplier_invoices_items  "
            . " WHERE supplier_invoice_id = '" . $si_id . "'";

        $q = $this->db->query($query);
        return $q->result_array();
    }
    
     public function get_sicnparts_ids_by_si_id($si_id) {
        $query = "SELECT id  "
            . " FROM project_supplier_credits_items  "
            . " WHERE supplier_credit_id = '" . $si_id . "'";

        $q = $this->db->query($query);
        return $q->result_array();
    }
    
     public function get_cnparts_ids_by_cn_id($cn_id) {
        $query = "SELECT id  "
            . " FROM credit_note_items  "
            . " WHERE credit_note_id = '" . $cn_id . "'";

        $q = $this->db->query($query);
        return $q->result_array();
    }

    public function get_allsinvoice_items_by_sinvoice_id($invoice_id){

        $query = "SELECT i.*,s.stage_name, c.component_name, su.supplier_name, su.street_pobox, su.supplier_postal_zip, su.supplier_email, su.supplier_country, su.supplier_city ";
        $query.= " FROM project_supplier_invoices_items i "
            . "LEFT JOIN project_stages s ON(s.stage_id = i.stage_id) "
            . "LEFT JOIN project_components c ON (c.component_id = i.component_id) "
            . "LEFT JOIN project_suppliers su ON (su.supplier_id = i.supplier_id) ";
        if($invoice_id==0){
            $query  .= " JOIN project_supplier_invoices si ON (si.id = i.supplier_invoice_id) ";
            $query.= " WHERE si.status!='Pending'";
        }
        if($invoice_id!=0)
            $query.= " WHERE i.supplier_invoice_id = '".$invoice_id."'";
        $get = $this->db->query($query);

        return $get->result_array();
    }
    public function gettotalquantity($costing_part_id){

        $query = "SELECT (SUM(quantity)) as variation_quantity"
            . " FROM project_variation_parts pvp"
            . " WHERE pvp.costing_part_id = '" . $costing_part_id . "'";
        $q = $this->db->query($query);
        $result = $q->row_array();
        return $result;
    }

    public function getprojectcosting($costing_part_id){

        $query = "SELECT costing_id as costing_id"
            . " FROM project_costing_parts bcp"
            . " WHERE bcp.costing_part_id = '" . $costing_part_id . "'";
        $q = $this->db->query($query);
        $result = $q->row_array();
        return $result;
    }

    public function getprojectcostingsum($costing_id, $stage_id){

        $query = "SELECT (SUM(costing_quantity)) as total_sum"
            . " FROM project_costing_parts bcp"
            . " WHERE bcp.costing_id = '" . $costing_id . "' AND stage_id = '" . $stage_id . "'" ;
        $q = $this->db->query($query);
        $result = $q->row_array();
        return $result;
    }
    
    public function get_project_supplier($project_id) {
        $company_id = $this->session->userdata('company_id');
        $query = "SELECT parts.costing_supplier, sup.*
             FROM  project_costing_parts parts 
             INNER JOIN project_suppliers sup ON (sup.supplier_id = parts.costing_supplier)
             INNER JOIN project_costing costing ON (costing.costing_id = parts.costing_id)
             WHERE costing.project_id = '" . $project_id . "' AND parts.costing_part_status=1";
       
        $query .= " GROUP BY parts.costing_supplier"; 
        $q = $this->db->query($query);
        return $q->result();
    }
    
    public function get_project_id_by_costing($costing_id) {
        $query = "SELECT pc.project_id  "
            . " FROM project_costing pc "
            . " WHERE costing_id = '" . $costing_id . "' AND status = 1";
        $q = $this->db->query($query);
        return $q->row_array();
    }
    
    public function get_costing_parts_by_project_stage($stageId = 0, $supplier_id=0, $costingId = 0) {
        $company_id = $this->session->userdata('company_id');
        if($supplier_id=="" && $stageId!="" && count($stageId)>0){
        $stage_id = implode(",",$stageId);
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc INNER JOIN project_costing_parts

         cp ON pc.costing_id=cp.costing_id LEFT JOIN project_components c

         On cp.component_id=c.component_id  WHERE cp.stage_id IN (".$stage_id.") AND cp.costing_part_status=1 AND cp.client_allowance=0 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'");
        }
        else if($stageId=="" && $supplier_id!="" && count($supplier_id)>0){
        $supplier_id = implode(",",$supplier_id);
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc INNER JOIN project_costing_parts

         cp ON pc.costing_id=cp.costing_id LEFT JOIN project_components c

         On cp.component_id=c.component_id  WHERE cp.costing_supplier IN (".$supplier_id.") AND cp.costing_part_status=1 AND cp.client_allowance=0 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'");
        }
        else if($stageId == "" && $supplier_id == ""){
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc INNER JOIN project_costing_parts

         cp ON pc.costing_id=cp.costing_id LEFT JOIN project_components c

         On cp.component_id=c.component_id  WHERE cp.costing_part_status=1 AND cp.client_allowance=0 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'");
                }
        else{
            $stage_id = implode(",",$stageId);
            $supplier_id = implode(",",$supplier_id);
            $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc INNER JOIN project_costing_parts

         cp ON pc.costing_id=cp.costing_id LEFT JOIN project_components c

         On cp.component_id=c.component_id  WHERE cp.stage_id IN (".$stage_id.") AND cp.costing_supplier IN (".$supplier_id.") AND cp.costing_part_status=1 AND cp.client_allowance=0 AND cp.costing_id = '" . $costingId . "' AND pc.company_id='" . $company_id . "'"); 
        }
        
        echo $this->db->last_query();

        return $q->result();
    }
    
    public function repopulate_costing_parts_by_project_stage($costingId, $variation_id) {
        $company_id = $this->session->userdata('company_id');
        
        $q = $this->db->query("SELECT cp.costing_part_id,cp.costing_part_name, c.component_name FROM `project_costing` pc, project_costing_parts

        cp,project_components c

        WHERE cp.component_id=c.component_id AND pc.costing_id=cp.costing_id AND cp.costing_part_status=1 AND cp.costing_id = '" . $costingId . "' AND pc.company_id=" . $company_id . " AND cp.costing_part_id NOT IN (SELECT costing_part_id FROM project_variation_parts WHERE variation_id = ".$variation_id.")");
        
        return $q->result();
    }

    
    function get_recent_quantity($costint_part_id){
		$approve='APPROVED';
		$querry="select pvp.*,pv.*, sum(pvp.change_quantity) as total  from  project_variation_parts pvp
		INNER JOIN project_variations pv ON pvp.variation_id = pv.id
		where pvp.costing_part_id='$costint_part_id' GROUP BY pvp.id";
		$get=$this->db->query($querry);
		return $get->row_array();
	}



}
