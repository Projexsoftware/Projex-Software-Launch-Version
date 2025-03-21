<?php

class Mod_price_book extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    function get_price_book_details($keyword = ""){
            $company_id = $this->session->userdata('company_id');
            if($keyword ==  ""){
                $query = "SELECT * "
                    . "FROM project_price_book_components "
                    . "WHERE company_id ='$company_id'"; 
            }
            else{
                $query = "SELECT * "
                    . "FROM project_price_book_components "
                    . "WHERE company_id =".$company_id." AND component_name LIKE '%".$keyword."%'";
            }
            $get = $this->db->query($query);
            if($get->num_rows()>0){
                $result = $get->result_array(); 
            }
            else{
                $result = array();
            } 
            return $result;
            }
            
    function get_price_book_lists($user_id, $from_company_id){
            $company_id = $this->session->userdata('company_id');
            $query = $this->db->query("SELECT * FROM project_price_books WHERE id NOT IN (SELECT price_book_id FROM project_allocate_price_books WHERE company_id='".$from_company_id."') AND status = 1 AND company_id='".$company_id."'");
            if($query->num_rows()>0){
                $result = $query->result_array(); 
            }
            else{
                $result = array();
            }
            return $result;
            
    }
    
    function get_supplier_users(){
        $company_id = $this->session->userdata('company_id');
        
        $query = $this->db->query("SELECT u.* FROM project_users u INNER JOIN project_price_books p on p.company_id = u.user_id WHERE  u.user_id!=".$company_id." AND u.company_id = 0 AND u.user_status=1 AND p.status=1 GROUP BY p.company_id");
            if($query->num_rows()>0){
                $result = $query->result_array(); 
            }
            else{
                $result = array();
            }
            return $result;
    }
}

?>