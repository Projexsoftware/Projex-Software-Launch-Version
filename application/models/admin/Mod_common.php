<?php

class Mod_common extends CI_Model {

    public $permissions = array();
    
    function __construct() {

        parent::__construct();
        $this->permission = $this->session->userdata("permissions");
    }
    public function random_number_generator($digit) {

        $randnumber = '';
        $totalChar = $digit;  //length of random number
        $salt = "0123456789";  // salt to select chars
        srand((double) microtime() * 1000000); // start the random generator
        $password = ""; // set the inital variable

        for ($i = 0; $i < $totalChar; $i++)  // loop and create number
            $randnumber = $randnumber . substr($salt, rand() % strlen($salt), 1);

        return $randnumber;
    }

    public function is_page_accessible($page_id=0) {
        if (!in_array($page_id, $this->permission)) {
            redirect(SURL . "dashboard");
        }
    }

    public function is_project_accessible($project_id) {
    
        $query = $this->db->query("SELECT * FROM wiz_project_team WHERE project_id='".$project_id."' AND team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2))");
        
        if ($query->num_rows()==0) {
            redirect(SURL . "nopage");
        }
    }
    
    public function is_viewer() {
        if ($this->session->userdata('admin_role_id')==3) {
            redirect(SURL . "dashboard");
        }
    }

    public function check_logged_in() {
        if ($this->session->userdata('admin_id')) {
            redirect(SURL . 'dashboard/dashboard');
        }
    }
     public function get_total_company_margin($oid) {

       $qry="select sum(p.company_margin) as company_margin from biz_products p join biz_items i on p.id=i.product_id where i.order_id=$oid";
       $get=$this->db->query($qry);
  
       return $get->row_array();

    }
    public function get_total_agent_margin($oid) {

       $qry="select sum(p.agent_margin) as agent_margin from biz_products p join biz_items i on p.id=i.product_id where i.order_id=$oid";
       $get=$this->db->query($qry);
       return $get->row_array();

    }

    //Verify If User is Login on the authorized Pages.
    public function verify_is_admin_login() {

        if (!$this->session->userdata('admin_id')) {
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $this->session->set_flashdata('err_message', '- You have to login to access this page.');
            redirect(AURL . '?url_ref=' . $actual_link);
        }
    }

    public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    function insert_into_table($table, $data) {
        $insert = $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            return $insert_id;
        } else {
            return false;
        }
    }

    function update_table($table = "", $where = "", $data = "") {
        $this->db->where($where);
        $update = $this->db->update($table, $data);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
    function get_all_records_nums($table = "", $fields = "*", $where = array()) {

        $this->db->select($fields);
        if(count($where)>0){
            $this->db->where($where);
        }
        $get = $this->db->get($table);
		//echo $this->db->last_query(); 
        return $get->num_rows();
    }

    function get_all_records($table = "", $fields = "*",$llimit=0,$ulimit=0,$where = array(), $column = "") {
        
        $this->db->select($fields);
        if($column!=""){
            $this->db->order_by($column, 'DESC');
        }
        else{
            if($table=="cashflow_project_details"){
                $this->db->order_by('id', 'ACS');
            }
            else{
                $this->db->order_by('id', 'DESC');
            }
        }
        if ($ulimit > 0) {
            $this->db->limit($ulimit, $llimit);
        }
         if(count($where)>0){
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        //echo $this->db->last_query(); 
		return $get->result_array();
    }

    function select_single_records($table = "", $where = "", $fields = "*") {

        $this->db->select($fields);
        if ($where != "") {
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        return $get->row_array();
    }

    function select_array_records($table = "", $where = "", $fields = "*") {

        $this->db->select($fields);
        if ($where != "") {
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        //echo $this->db->last_query(); 
        return $get->result_array();
    }

    function delete_record($table = "", $where = "") {

        $this->db->where($where);
        $delete = $this->db->delete($table);
        if ($delete)
            return true;
        else
            return false;
    }

    public function get_tree() {
        $query = "SELECT id, category_name as name,category_name as text, parent_category as parent_id FROM biz_categories where is_active ='1'";
        $get = $this->db->query($query);
        $data = $get->result_array();

        foreach ($data as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
            // Children array:
            $itemsByReference[$item['id']]['children'] = array();
            // Empty data class (so that json_encode adds "data: {}" ) 
            $itemsByReference[$item['id']]['data'] = new StdClass();
        }

// Set items as children of the relevant parent item.
        foreach ($data as $key => &$item)
            if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                $itemsByReference [$item['parent_id']]['children'][] = &$item;

// Remove items that were added to parents elsewhere:
        foreach ($data as $key => &$item) {
            if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($data[$key]);
        }
        return $data;
    }

    public function get_all_states($country_id) {

        $this->db->dbprefix('states');
        $this->db->where('country', $country_id);
        $this->db->order_by('state_name ASC');
        $get_states_list = $this->db->get('states');
        //echo $this->db->last_query(); exit;

        $row_states_list['states_result'] = $get_states_list->result_array();
        $row_states_list['states_count'] = $get_states_list->num_rows;


        $this->db->dbprefix('cities');
        $this->db->where('country', $country_id);
        $this->db->order_by('name ASC');
        $get_cities_list = $this->db->get('cities');
        //echo $this->db->last_query(); exit;

        $row_states_list['cities_result'] = $get_cities_list->result_array();
        $row_states_list['cities_count'] = $get_cities_list->num_rows;


        return $row_states_list;
    }

    public function get_preferences_setting($setting_name = '') {
        $table_name = 'biz_site_preferences';
        $this->db->dbprefix($table_name);
        $this->db->where('setting_name', $setting_name);
        $get_setting = $this->db->get($table_name);
        return $get_setting->row_array();
    }

//end get_all_states
    //Get All Cities  Name
    public function get_all_cities($state_id) {

        $this->db->dbprefix('cities');
        $this->db->where('state_name', $state_id);
        $this->db->order_by('name ASC');
        $get_cities_list = $this->db->get('cities');

        $row_cities_list['cities_result'] = $get_cities_list->result_array();
        $row_cities_list['cities_count'] = $get_cities_list->num_rows;

        return $row_cities_list;
    }

    public function getrate($currency) {
        $amount = urlencode(1);
        $from_Currency = urlencode("USD");
        $to_Currency = urlencode($currency);
//       
//          $get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
//
//
//          $get = explode("<span class=bld>",$get);
//          $get = explode("</span>",$get[1]);
//          return $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]); 

        $this->db->select("*");
        $this->db->where("currency_sign", $currency);
        $get = $this->db->get("currency_rate");

        $result = $get->row_array();
//        echo $this->db->last_query();exit;
        return $result['currency_rate'];
    }

//end get_all_countries
    
    function get_CoA_Tree(){
        $this->db->select("id, title, parent_id");
        $get =$this->db->get("biz_chart_of_accounts");
         $result = $get->result_array();
    
          $tree = $this->buildCoATree($result);
         return $tree;
//          return $this->doOutputList($tree);
    }
    
    public function buildCoATree(array $elements, $parentId = 0) {
        $branch = array();

        
        foreach ($elements as $as =>$element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildCoATree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function get_project_stages($project_id){
      $query = $this->db->query("SELECT ps.stage_id, s.name as stage_name FROM wiz_project_items ps LEFT JOIN wiz_stages s ON ps.stage_id = s.id WHERE ps.project_id = '".$project_id."' GROUP BY stage_id ORDER BY ps.stages_priority ASC, ps.id DESC");
      return $query->result_array($query);
    }

    public function get_template_stages($template_id){
      $query = $this->db->query("SELECT ps.stage_id, s.name as stage_name FROM wiz_template_items ps LEFT JOIN wiz_stages s ON ps.stage_id = s.id WHERE ps.template_id = '".$template_id."' GROUP BY stage_id ORDER BY ps.stages_priority ASC, ps.id DESC");
      return $query->result_array($query);
    }
    
    public function get_project_tasks($project_id){
      $query = $this->db->query("SELECT pi.id, pi.project_id, pi.task_id, t.name as task_name FROM wiz_project_items pi LEFT JOIN wiz_tasks t ON pi.task_id = t.id WHERE pi.project_id = '".$project_id."' GROUP BY pi.task_id ORDER BY pi.id DESC");
      return $query->result_array($query);
    }

    public function get_all_projects(){
      //$query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      $query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR team_role=2))");
     
      return $query->result_array($query);
    }
    
    public function get_all_projects_list(){
      $query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      return $query->result_array($query);
    }

    public function get_all_dashboard_projects(){
      $query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2))) ORDER BY id DESC LIMIT 6");
      return $query->result_array($query);
    }

    public function get_dashboard_projects_count(){
      $query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2)))");
      return $query->result_array($query);
    }

    public function get_all_activities($is_admin=0){
      if($is_admin==0){
      $query = $this->db->query("SELECT u.first_name, u.last_name, t.name as task_name, s.name as stage_name, p.name as project_name, a.* FROM wiz_project_activities a INNER JOIN wiz_projects p ON p.id = a.project_id LEFT JOIN wiz_project_items i ON i.id = a.item_id LEFT JOIN wiz_stages s ON s.id = i.stage_id LEFT JOIN wiz_tasks t ON t.id = i.task_id INNER JOIN wiz_users u ON u.id = a.user_id WHERE a.project_id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR team_role=2)) ORDER BY a.id DESC LIMIT 0, 20");
      }
      else{
           $query = $this->db->query("SELECT u.first_name, u.last_name, t.name as task_name, s.name as stage_name, p.name as project_name, a.* FROM wiz_project_activities a INNER JOIN wiz_projects p ON p.id = a.project_id LEFT JOIN wiz_project_items i ON i.id = a.item_id LEFT JOIN wiz_stages s ON s.id = i.stage_id LEFT JOIN wiz_tasks t ON t.id = i.task_id INNER JOIN wiz_users u ON u.id = a.user_id ORDER BY a.id DESC LIMIT 0, 20");
      }
      return $query->result_array($query);
    }

    public function see_all_activities($is_admin=0){
      if($is_admin==0){
      $query = $this->db->query("SELECT u.first_name, u.last_name, t.name as task_name, s.name as stage_name, p.name as project_name, a.* FROM wiz_project_activities a INNER JOIN wiz_projects p ON p.id = a.project_id LEFT JOIN wiz_project_items i ON i.id = a.item_id LEFT JOIN wiz_stages s ON s.id = i.stage_id LEFT JOIN wiz_tasks t ON t.id = i.task_id INNER JOIN wiz_users u ON u.id = a.user_id WHERE a.project_id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR team_role=2)) ORDER BY a.id DESC");
      }
      else{
           $query = $this->db->query("SELECT u.first_name, u.last_name, t.name as task_name, s.name as stage_name, p.name as project_name, a.* FROM wiz_project_activities a INNER JOIN wiz_projects p ON p.id = a.project_id LEFT JOIN wiz_project_items i ON i.id = a.item_id LEFT JOIN wiz_stages s ON s.id = i.stage_id LEFT JOIN wiz_tasks t ON t.id = i.task_id INNER JOIN wiz_users u ON u.id = a.user_id ORDER BY a.id DESC");
      }
      return $query->result_array($query);
    }
    
    public function get_all_daily_summary_projects($admin_role, $from, $to){
      $from = date("Y-m-d", strtotime(str_replace("/", "-", $from)));
      $to = date("Y-m-d", strtotime(str_replace("/", "-", $to)));
      
      if($admin_role==1){
        $query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM `wiz_project_activities` WHERE DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '".$from."' AND '".$to."' ORDER BY created_at DESC)");
     
      }else{
      //$query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR (team_role!=1 AND is_invitation_send=2))) AND id IN (SELECT project_id FROM `wiz_project_activities` WHERE DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '".$from."' AND '".$to."' ORDER BY created_at DESC)");
      
    $query = $this->db->query("SELECT * FROM wiz_projects WHERE id IN (SELECT project_id FROM wiz_project_team WHERE team_id = '".$this->session->userdata("admin_id")."' AND (team_role=1 OR team_role=2)) AND id IN (SELECT project_id FROM `wiz_project_activities` WHERE DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '".$from."' AND '".$to."' ORDER BY created_at DESC)");
      
      }
      //echo $this->db->last_query();exit;
      return $query->result_array($query);
    }
}

?>