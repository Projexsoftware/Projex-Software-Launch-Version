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
        
        $this->db->dbprefix('users');
        
        $this->db->select('users.*, roles.role_title, roles.permissions');
        $this->db->where('user_email', strip_quotes($username));
        $this->db->where('user_password', strip_quotes(md5($password)));
        $this->db->where('roles.status', 1);
        $this->db->join("roles", 'roles.id = users.role_id');
        $get = $this->db->get('users');
        
        if($get->num_rows() > 0){
            
            $this->db->where('user_email', strip_quotes($username));
            $this->db->where('user_password', strip_quotes(md5($password)));
            $data = array(
                'signing_ip' => $this->input->ip_address(),
                'last_signin' => date('Y-m-d H:i:s'),
            );
            $this->db->update('project_users', $data); 
        }
        
            return $get->row_array();
    }

}

?>