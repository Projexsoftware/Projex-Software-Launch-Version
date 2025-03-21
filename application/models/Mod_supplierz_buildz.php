<?php

class Mod_supplierz_buildz extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    
    public function get_template_stages($template_id){
      $query = $this->db->query("SELECT ps.stage_id, s.stage_name FROM project_buildz_template_items ps INNER JOIN project_stages s ON ps.stage_id = s.stage_id WHERE ps.template_id = '".$template_id."' GROUP BY stage_id ORDER BY ps.stages_priority ASC, ps.stage_id DESC");
      return $query->result_array($query);
    }
    
    public function get_existing_supplierz_buildz_templates(){
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT t.* FROM project_buildz_templates t INNER JOIN project_buildz_template_items ti ON t.id = ti.template_id WHERE t.status = 1 AND company_id = ".$company_id." GROUP BY ti.template_id");
        return $q->result_array();
    }
    
}

?>