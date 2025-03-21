<?php

class Mod_onlinestore extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    public function check_logged_in(){
    
        if($this->session->userdata('logged_in')){
            redirect(base_url() . 'dashboard/dashboard');
        }
        
    }

    public function filter_products($categories=array(), $suppliers=array(), $ulimit = 0, $limit = 0, $column = "", $order = "") {
        $this->db->select("*", "project_suppliers.supplier_name");
        if($column!=""){ 
        if($column!="project_suppliers.supplier_name"){
          $this->db->order_by($column, $order);
        }
        else{
           $this->db->order_by("project_suppliers.supplier_name", "ASC"); 
        }
        }
        if ($ulimit > 0) {
            $this->db->limit($ulimit, $limit);
        }
        $this->db->where("component_status", 1);
         $this->db->where("list_this_component_in_online_store", 1);
        if(count($suppliers)>0 && $suppliers[0]!="0"){
            $this->db->where_in("company_id", $suppliers);
        }
        if(count($categories)>0 && $categories[0]!="0"){
            $this->db->where_in("component_category", $categories);
        }
        if($column=="project_suppliers.supplier_name"){
            $this->db->join("project_suppliers", "project_suppliers.supplier_id = project_components.supplier_id", "inner");
        }
        if($column == "project_components.component_category"){
            $this->db->join("project_categories", "project_categories.name = project_components.component_category", "inner");
        }
        $get = $this->db->get("project_components");
       // echo $this->db->last_query(); exit;
		return $get->result_array();
    }

}

?>