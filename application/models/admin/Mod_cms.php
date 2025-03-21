<?php

class Mod_cms extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    public function check_logged_in(){
    
        if($this->session->userdata('logged_in')){
            redirect(base_url() . 'dashboard/dashboard');
        }
        
    }

    public function get_page_detail_by_page_slug($page_slug ="") {
        
        $this->db->select("*");
        $this->db->where("slug", $page_slug);
        $this->db->where("status", 1);
        $get = $this->db->get("cms");
        return $get->row_array();
    }

}

?>