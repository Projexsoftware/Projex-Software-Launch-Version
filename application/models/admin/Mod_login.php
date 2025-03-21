<?php

class Mod_login extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    public function check_logged_in(){
    
        if($this->session->userdata('logged_in')){
            redirect(base_url() . 'dashboard/dashboard');
        }
        
    }

    //Validation of Login

    public function validate_credentials($username, $password) {
        
        $this->db->dbprefix('project_admin_users');
        
        $this->db->select('project_admin_users.*, project_admin_roles.role_title, project_admin_roles.permissions');
        $this->db->where('email', strip_quotes($username));
        $this->db->where('password', strip_quotes(md5($password)));
        $this->db->where('project_admin_users.status', 1);
        $this->db->join("project_admin_roles", 'project_admin_roles.id = project_admin_users.role_id');
        $get = $this->db->get('project_admin_users');
        
        if($get->num_rows() > 0){
            
            $this->db->where('email', strip_quotes($username));
            $this->db->where('password', strip_quotes(md5($password)));
            $data = array(
                'signing_ip' => $this->input->ip_address(),
                'last_signin' => date('Y-m-d H:i:s'),
            );
            $this->db->update('project_admin_users', $data); 
        }
        
            return $get->row_array();
    }

}

?>