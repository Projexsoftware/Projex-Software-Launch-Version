<?php

class Mod_scheduling extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    

    public function get_project_stages($project_id){
       $query = $this->db->query("SELECT ps.stage_id, s.stage_name FROM project_scheduling_items ps LEFT JOIN project_stages s ON ps.stage_id = s.stage_id WHERE ps.project_id = '".$project_id."' GROUP BY ps.stage_id
       ORDER BY
        CASE 
            WHEN ps.stages_priority > 0 THEN ps.stages_priority
            ELSE ps.stage_id 
        END ASC
       ");
      return $query->result_array($query);
    }

    public function get_template_stages($template_id){
      $query = $this->db->query("SELECT ps.stage_id, s.stage_name FROM project_scheduling_template_items ps LEFT JOIN project_stages s ON ps.stage_id = s.stage_id WHERE ps.template_id = '".$template_id."' GROUP BY stage_id ORDER BY ps.stages_priority ASC, ps.stage_id DESC");
      return $query->result_array($query);
    }
    
    public function get_project_tasks($project_id){
      $query = $this->db->query("SELECT pi.id, pi.project_id, pi.task_id, pi.stage_id, t.name as task_name FROM project_scheduling_items pi LEFT JOIN project_scheduling_tasks t ON pi.task_id = t.id WHERE pi.project_id = '".$project_id."' GROUP BY pi.task_id ORDER BY pi.stages_priority ASC");
      return $query->result_array($query);
    }
    
    public function get_project_logs($project_id, $start_date, $end_date){
      $query = $this->db->query("SELECT * FROM project_logs WHERE project_id = '".$project_id."' AND (date BETWEEN '".$start_date."' AND '".$end_date."') ORDER BY id DESC");
      return $query->result_array($query);
    }
    
    public function get_scheduling_users(){
    $query = $this->db->query("SELECT u.*, r.permissions FROM project_users u INNER JOIN project_roles r on r.id = u.role_id WHERE u.user_id != '".$this->session->userdata("user_id")."' AND (u.company_id = ".$this->session->userdata("company_id")." OR u.user_id = ".$this->session->userdata("company_id")." AND u.company_id = 0)");
     
    return $query->result_array($query);
    }
    
    public function get_scheduling_members(){
    $query = $this->db->query("SELECT u.*, r.permissions FROM project_users u INNER JOIN project_roles r on r.id = u.role_id WHERE u.user_id != ".$this->session->userdata("user_id"));
     
    return $query->result_array($query);
    }

    public function get_all_projects(){
      //$query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND parent_project_id > 0 AND (team_role=1 OR team_role=2)) AND company_id = ".$this->session->userdata("company_id"));
     
      return $query->result_array($query);
    }
    
    public function get_all_projects_list($status=""){
      if($status=="pending"){
        $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND parent_project_id > 0 AND status = 2 AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      }
      else if($status=="active"){
        $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND parent_project_id > 0 AND status = 1 AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      }
      else if($status=="completed"){
        $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND parent_project_id > 0 AND status = 3 AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      }
      else if($status=="inactive"){
        $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND parent_project_id > 0 AND status = 0 AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      }
      else{
        $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND parent_project_id > 0 AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      }
      
      return $query->result_array($query);
    }

    public function get_all_dashboard_projects(){
      $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2))) ORDER BY id DESC LIMIT 6");
      return $query->result_array($query);
    }

    public function get_dashboard_projects_count(){
      $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      return $query->result_array($query);
    }

    public function get_all_activities($is_admin=0){
      
      $query = $this->db->query("SELECT u.user_fname as first_name, u.user_lname as last_name, t.name as task_name, s.stage_name, p.name as project_name, a.* FROM project_scheduling_activities a INNER JOIN project_scheduling_projects p ON p.id = a.project_id LEFT JOIN project_scheduling_items i ON i.id = a.item_id LEFT JOIN project_stages s ON s.stage_id = i.stage_id LEFT JOIN project_scheduling_tasks t ON t.id = i.task_id INNER JOIN project_users u ON u.user_id = a.user_id WHERE a.project_id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND (team_role=1 OR team_role=2)) ORDER BY a.id DESC LIMIT 0, 20");
      return $query->result_array($query);
    }

    public function see_all_activities($is_admin=0){
      if($is_admin==0){
      $query = $this->db->query("SELECT u.user_fname as first_name, u.user_lname as last_name, t.name as task_name, s.stage_name, p.name as project_name, a.* FROM project_scheduling_activities a INNER JOIN project_scheduling_projects p ON p.id = a.project_id LEFT JOIN project_scheduling_items i ON i.id = a.item_id LEFT JOIN project_stages s ON s.stage_id = i.stage_id LEFT JOIN project_scheduling_tasks t ON t.id = i.task_id INNER JOIN project_users u ON u.user_id = a.user_id WHERE a.project_id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND (team_role=1 OR team_role=2)) ORDER BY a.id DESC");
      }
      else{
           $query = $this->db->query("SELECT u.user_fname as first_name, u.user_lname as last_name, t.name as task_name, s.stage_name, p.name as project_name, a.* FROM project_scheduling_activities a INNER JOIN project_scheduling_projects p ON p.id = a.project_id LEFT JOIN project_scheduling_items i ON i.id = a.item_id LEFT JOIN project_stages s ON s.stage_id = i.stage_id LEFT JOIN project_scheduling_tasks t ON t.id = i.task_id INNER JOIN project_users u ON u.user_id = a.user_id ORDER BY a.id DESC");
      }
      return $query->result_array($query);
    }
    
    public function get_all_daily_summary_projects($admin_role, $from, $to){
      $from = date("Y-m-d", strtotime(str_replace("/", "-", $from)));
      $to = date("Y-m-d", strtotime(str_replace("/", "-", $to)));
      
      if($admin_role==1){
        $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM `project_scheduling_activities` WHERE DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '".$from."' AND '".$to."' ORDER BY created_at DESC) AND company_id =".$this->session->userdata('company_id'));
     
      }else{
         
    $query = $this->db->query("SELECT * FROM project_scheduling_projects WHERE id IN (SELECT project_id FROM project_scheduling_team WHERE team_id = '".$this->session->userdata("user_id")."' AND (team_role=1 OR team_role=2)) AND id IN (SELECT project_id FROM `project_scheduling_activities` WHERE DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '".$from."' AND '".$to."' ORDER BY created_at DESC) AND company_id =".$this->session->userdata('company_id'));
      
      }
      return $query->result_array($query);
    }
    
    public function is_project_accessible($project_id) {
    
        $query = $this->db->query("SELECT * FROM project_scheduling_team WHERE project_id='".$project_id."' AND team_id = '".$this->session->userdata("user_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2))");
        
        if ($query->num_rows()==0) {
            redirect(SURL . "nopage");
        }
    }
    
    public function is_viewer() {
        /*if ($this->session->userdata('admin_role_id')==3) {
            redirect(SCURL . "dashboard");
        }*/
    }
    
    public function get_existing_projects_for_buildz(){
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT cp.*,p.project_title,p.project_id FROM project_costing cp,project_projects p WHERE cp.project_id=p.project_id AND cp.company_id='" . $company_id . "' AND p.project_id IN  (SELECT project_id FROM project_scheduling_items)");
        return $q->result_array();
    }
    
    public function get_existing_templates(){
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT t.* FROM project_scheduling_templates t INNER JOIN project_scheduling_template_items ti ON t.id = ti.template_id WHERE t.company_id=".$company_id." AND t.status = 1 GROUP BY ti.template_id");
        return $q->result_array();
    }
    
    public function get_existing_supplierz_buildz_templates(){
        $q = $this->db->query("SELECT t.* FROM project_buildz_templates t INNER JOIN project_buildz_template_items ti ON t.id = ti.template_id WHERE t.available_for_import_by_user= 1 AND t.status = 1 GROUP BY ti.template_id");
        return $q->result_array();
    }

}

?>