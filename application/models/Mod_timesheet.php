<?php
Class Mod_timesheet extends CI_Model {
    
    public function get_draft_timesheets() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT ts.*, u.user_fname, u.user_lname FROM project_timesheets ts INNER JOIN project_users u ON u.user_id = ts.user_id WHERE ts.company_id =" . $company_id." AND status='Draft' ORDER BY id DESC");
        return $q->result_array();
    }

    public function get_pending_timesheets() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT ts.*, u.user_fname, u.user_lname FROM project_timesheets ts INNER JOIN project_users u ON u.user_id = ts.user_id WHERE ts.company_id =" . $company_id." AND status='Pending' ORDER BY id DESC");
        return $q->result_array();
    }
    
    public function get_approved_timesheets() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT ts.*, u.user_fname, u.user_lname FROM project_timesheets ts INNER JOIN project_users u ON u.user_id = ts.user_id WHERE ts.company_id =" . $company_id." AND status='Approved' ORDER BY id DESC");
        return $q->result_array();
    }
    
    public function get_invoiced_timesheets() {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT ts.*, u.user_fname, u.user_lname FROM project_timesheets ts INNER JOIN project_users u ON u.user_id = ts.user_id WHERE ts.company_id =" . $company_id." AND status='Invoiced' ORDER BY id DESC");
        return $q->result_array();
    }
    
    public function get_timesheet_items($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT tsi.*, ts.status as timesheet_status, ts.user_id, u.user_fname, u.user_lname, p.project_title, s.stage_name FROM project_timesheets ts INNER JOIN project_timesheet_items tsi ON tsi.timesheet_id = ts.id INNER JOIN project_users u ON u.user_id = ts.user_id LEFT JOIN project_stages s ON s.stage_id = tsi.stage_id INNER JOIN project_costing pc ON pc.costing_id = tsi.project_id INNER JOIN project_projects p ON pc.project_id = p.project_id WHERE ts.company_id =" . $company_id." AND tsi.timesheet_id = '".$id."' ORDER BY tsi.date ASC");
        //echo $this->db->last_query();
        return $q->result_array();
    }
    
    public function get_timesheet_projects($id) {
        $company_id = $this->session->userdata('company_id');
        $q = $this->db->query("SELECT COUNT(tsi.id) AS theCount, tsi.project_id, sum(tsi.approved_hours) as worked_hours, sum(tsi.subtotal) as cost_subtotal, p.project_title FROM project_timesheet_items tsi INNER JOIN project_timesheets ts ON ts.id = tsi.timesheet_id INNER JOIN project_costing pc ON pc.costing_id = tsi.project_id INNER JOIN project_projects p ON pc.project_id = p.project_id WHERE tsi.timesheet_id='".$id."' AND ts.status!='Pending' GROUP BY tsi.project_id ORDER BY theCount DESC");
        return $q->result_array();
    }
    
}
