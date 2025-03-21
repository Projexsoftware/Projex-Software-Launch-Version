<?php

class Mod_appapi extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    public function check_logged_in(){
    
        if($this->session->userdata('logged_in')){
            redirect(base_url() . 'dashboard/dashboard');
        }
        
    }

    //Validation of Login

    public function validate_credentials($table, $email, $password) {
        
        $this->db->dbprefix($table);
        
        $this->db->select('*');
        $this->db->where('email', strip_quotes($email));
        $this->db->where('password', strip_quotes(md5($password)));
        $this->db->where('status', 1);
        $get = $this->db->get($table);
        
        if($get->num_rows() > 0){
            
            $this->db->where('email', strip_quotes($email));
            $this->db->where('password', strip_quotes(md5($password)));
            $data = array(
                'signing_ip' => $this->input->ip_address(),
                'last_signin' => date('Y-m-d H:i:s'),
            );

            $this->db->update('sixtaxi_'.$table, $data); 
            
        }
        
            return $get->row_array();
    }
    
    public function get_nearest_drivers($lat, $lng){
 
      $distance = 500;

      $query = $this->db->query("SELECT *, (3956 * 2 * asin(sqrt(power(sin(($lat-lat) * pi()/180 / 2), 2) + cos($lat * pi()/180) * cos(lat * pi()/180) * pow(sin(($lng - lng) * pi()/180 / 2), 2) ))) as distance FROM sixtaxi_drivers where lat != 0 AND lng != 0 AND status=1 having distance < $distance ORDER BY distance ASC");
      return $query->result_array();
    }

}

?>