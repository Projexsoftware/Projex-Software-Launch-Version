<?php

class Mod_common extends CI_Model {

    public $permissions = array();
    
    function __construct() {

        parent::__construct();
        $this->company_permission = $this->session->userdata("permissions");
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
    
    public function is_company_page_accessible($page_id=0) {
        if (!in_array($page_id, $this->company_permission)) {
            $this->session->set_flashdata('err_message',"- You don't have access to this operation.");
            $this->session->keep_flashdata('err_message');
           // echo $this->session->flashdata('err_message');exit;
             $this->session->set_userdata('err_message',"- You don't have access to this operation.");
           //echo $this->session->flashdata('err_message');die();
            redirect(SURL . "nopage","refresh");
        }
    }
    
    
    public function check_logged_in() {
        if ($this->session->userdata('admin_id')) {
            redirect(SURL . 'dashboard/dashboard');
        }
    }
     
    //Verify If User is Login on the authorized Pages.
    public function verify_is_admin_login() {

        if (!$this->session->userdata('admin_id')) {
            $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $this->session->set_flashdata('err_message', '- You have to login to access this page.');
            redirect(SURL . '?url_ref=' . $actual_link);
        }
    }
    
    public function verify_is_user_login() {

        if (!$this->session->userdata('user_id')) {
            $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $this->session->set_flashdata('err_message', '- You have to login to access this page.');
            redirect(SURL . '/login?url_ref=' . $actual_link);
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

    function get_all_records($table = "", $fields = "*",$llimit=0,$ulimit=0,$where = array(),$column="") {
        
        $this->db->select($fields);
        if($column==""){
          $this->db->order_by('id', 'DESC');
        }
        else if($table == "categories"){
            $this->db->order_by($column, 'ASC');  
        }
        else if($table == "stages"){
            $this->db->order_by($column, 'ASC');  
        }
        else if($table == "project_component_options" || $table == "takeoffdata"){
            $this->db->order_by($column, 'ASC');  
        }
        else{
          $this->db->order_by($column, 'DESC');  
        }
        if ($ulimit > 0) {
            $this->db->limit($ulimit, $llimit);
        }
         if($where!=""){
            $this->db->where($where);
        }
        $get = $this->db->get($table);
       // echo $this->db->last_query(); exit;
		return $get->result_array();
    }

    function select_single_records($table = "", $where = "", $fields = "*") {

        $this->db->select($fields);
        if ($where != "") {
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        if($get->num_rows()>0){
        return $get->row_array();
        }
        else{
            return array();
        }
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
    
    function get_latest_clients(){
		$this->db->select('*');
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->order_by('date_created', 'DESC');
		$this->db->limit(6);
		$get = $this->db->get('project_clients');
		if($get->num_rows()>0){ 
		   return $get->result_array();
		}
		else{
		    return array();
		}
	}
	
	function getclientnameinfoby_client_id($client_id) {
            $this->db->select('client_fname1');
            $this->db->select('client_fname2');
            $this->db->select('client_surname1');
            $this->db->select('client_surname2');
            $this->db->where('client_id', $client_id);
            $get = $this->db->get('project_clients');
            $row = $get->row_array();
            return $row;
        }
    
    function get_variations($variation_id){
		$querry="select pv.*,pvp.*,p.client_id,c.client_fname1,c.client_fname2,c.client_email_primary from  project_variations pv 
		INNER JOIN project_variation_parts pvp ON pv.id=pvp.variation_id 
		INNER JOIN project_projects p ON pv.project_id=p.project_id
		INNER JOIN project_clients c ON p.client_id=c.client_id
		where pv.id='$variation_id'";
		$get=$this->db->query($querry);
		$data['result']=$get->result_array();
		return $data;
	}
	
	public function get_filter_components($term){
        if($this->session->userdata('company_id')>0){
          $query = $this->db->query("SELECT * FROM project_components where company_id = ".$this->session->userdata('company_id')." AND supplier_id IN (SELECT supplier_id FROM project_suppliers) AND component_status = 1 AND ((component_name LIKE '%".$term."%') OR (supplier_id IN (SELECT supplier_id FROM project_suppliers WHERE supplier_name LIKE '%".$term."%')))");
        }
        else{
           $query = $this->db->query("SELECT * FROM project_components where user_id = ".$this->session->userdata('user_id')." AND supplier_id IN (SELECT supplier_id FROM project_suppliers) AND component_status = 1 AND ((component_name LIKE '%".$term."%') OR (supplier_id IN (SELECT supplier_id FROM project_suppliers WHERE supplier_name LIKE '%".$term."%')))"); 
        }
        return $query->result();
    }
    
    public function get_supplierz_filter_components($term){
        //$query = $this->db->query("SELECT pc.id as component_id, pc.component_name, pc.component_sale_price, p.* FROM project_price_books p INNER JOIN project_price_book_components pc ON pc.price_book_id = p.id WHERE p.user_id='".$this->session->userdata('company_id')."' AND pc.component_status = 1 AND pc.component_name LIKE '%".$term."%'");
        $query = $this->db->query("SELECT pc.id as component_id, pc.component_id as pricebook_component_id, pc.component_name, pc.component_sale_price FROM project_price_book_components pc WHERE pc.company_id='".$this->session->userdata('company_id')."' AND pc.component_status = 1 AND pc.component_name LIKE '%".$term."%'");
        return $query->result();
    }
    
    public function filter_supplierz_components($term){
        if($this->session->userdata('company_id')>0){
          $query = $this->db->query("SELECT * FROM project_supplierz_components where company_id = ".$this->session->userdata('company_id')." AND component_status = 1 AND ((component_name LIKE '%".$term."%') OR (supplier_id IN (SELECT supplier_id FROM project_suppliers WHERE supplier_name LIKE '%".$term."%')))");
        }
        else{
           $query = $this->db->query("SELECT * FROM project_supplierz_components where user_id = ".$this->session->userdata('user_id')." AND component_status = 1 AND ((component_name LIKE '%".$term."%') OR (supplier_id IN (SELECT supplier_id FROM project_suppliers WHERE supplier_name LIKE '%".$term."%')))"); 
        }
        return $query->result();
    }
    
    public function get_designz(){
        $query = $this->db->query('(SELECT 
    pd.designz_id AS designz_id, 
    pd.project_name, 
    pd.project_name AS builderz_designz_name,
    pd.floor_area, 
    pd.bedrooms, 
    pd.bathrooms, 
    pd.living_areas, 
    pd.garage, 
    pd.show_at_client_interface,
    pd.status, 
    pd.created_at, 
    "builderz" AS designz_type 
 FROM 
    project_designz pd
 WHERE 
    pd.company_id = '.$this->session->userdata("company_id").')

UNION ALL

(SELECT 
    psd.designz_id AS designz_id, 
    psd.project_name, 
    IFNULL((SELECT pdbs.name 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), psd.project_name) AS builderz_designz_name,
    psd.floor_area, 
    psd.bedrooms, 
    psd.bathrooms, 
    psd.living_areas, 
    psd.garage, 
    IFNULL((SELECT pdbs.show_at_client_interface 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), 0) AS show_at_client_interface,
    psd.status, 
    psd.created_at, 
    "supplierz" AS designz_type 
 FROM 
    project_supplierz_designz psd 
 WHERE 
    psd.available_for_builderz = 1)

ORDER BY created_at DESC');
        
    $result = $query->result_array();
    return $result;
    
    }
    
    public function get_designz_uploads($designz_id, $designz_type){
        
        $query = $this->db->query('(SELECT 
            psdu.* 
            FROM 
            project_supplierz_designz_uploads psdu
            WHERE 
            psdu.designz_id = '.$designz_id.' AND psdu.designz_upload_type = "'.$designz_type.'")
        
        UNION ALL
        
        (SELECT 
            pdbu.* 
            FROM 
            project_designz_builderz_uploads pdbu
            WHERE 
            pdbu.designz_id = '.$designz_id.' AND pdbu.designz_upload_type = "'.$designz_type.'") 
        
        ORDER BY id DESC');
        
        // Execute the combined query
        $result = $query->result_array();
        
        return $result;
    
    }
    
    public function get_supplierz_designz_uploads($designz_id, $designz_type){
        
        $query = $this->db->query('SELECT * FROM project_supplierz_designz_uploads WHERE designz_id = '.$designz_id.' AND CONCAT("builderz-", file_name) NOT IN (SELECT file_name FROM project_designz_builderz_uploads WHERE designz_id ='.$designz_id.' AND company_id ='.$this->session->userdata("company_id").') AND designz_upload_type ="'.$designz_type.'"');
        
        $result = $query->result_array();
        
        return $result;
    
    }
}

?>