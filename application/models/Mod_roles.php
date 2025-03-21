<?php

class Mod_roles extends CI_Model {

    function __construct() {

        parent::__construct();
    }
           
    public function get_all_menu(){
        $this->db->select("*"); 
        $this->db->where("status", 1);
        $this->db->where("show_in_nav", 1);
        $this->db->order_by("display_order", "ASC");
        $get = $this->db->get("menu");
        $get_arr = $get->result_array();
        foreach($get_arr as $get_arr => $g){
            if($g['parent_id'] == 0){
                
                $nav_panel_arr[$g['id']]['id'] = $g['id'];
                $nav_panel_arr[$g['id']]['menu_title'] = $g['menu_title'];
                $nav_panel_arr[$g['id']]['status'] = $g['status'];
                $nav_panel_arr[$g['id']]['set_as_default'] = $g['set_as_default'];
            }else{
                $query = $this->db->query("Select * FROM project_menu WHERE id = ".$g['parent_id']." AND parent_id > 0");
                if($query->num_rows()==0){
                   $nav_panel_arr[$g['parent_id']]['sub_menu'][] = $g;
                   $last_parent_id = $g['parent_id'];
                   $last_index = count($nav_panel_arr[$g['parent_id']]['sub_menu'])-1;
                }
                else{
                    $row = $query->row_array();
                    $nav_panel_arr[$last_parent_id]['sub_menu'][$last_index]['child_menu'][] = $g;
                }
            }            
        }
        return $nav_panel_arr;             

    }
    
    public function add_new_role($data){
        extract($data);                            
        
        $created_date = date('Y-m-d G:i:s');

		$created_by_ip = $this->input->ip_address();

		$created_by = $this->session->userdata('user_id');
		
		$company_id = $this->session->userdata("company_id");

		

		$permission_str = implode(';',$role_arr);


		$ins_data = array(
		   'role_title' => $this->db->escape_str(trim($role_title)),
		   'permissions' => $this->db->escape_str(trim($permission_str)),
		   'status' => 1,
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		   'company_id' => $this->db->escape_str(trim($company_id)),
		);		

		$this->db->dbprefix('roles');
		$ins_into_db = $this->db->insert('roles', $ins_data);
		if($ins_into_db)
			return true;
        }
   
    
        public function get_admin_role($role_id){	
		$this->db->dbprefix('roles');
		$this->db->where('id',$role_id);
		$this->db->where('company_id', $this->session->userdata("company_id"));
		$get_admin_role = $this->db->get('roles');
		$row_admin['admin_role_arr'] = $get_admin_role->row_array();
		$row_admin['admin_role_count'] = $get_admin_role->num_rows();
		return $row_admin;	
	}//end get_admin_role
        
        //Update admin Role

	public function edit_role($data){
	
		extract($data);
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');		
		$permission_str = implode(';',$role_arr);
		$ins_data = array(
		   'role_title' => $this->db->escape_str(trim($role_title)),
		   'permissions' => $this->db->escape_str(trim($permission_str)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);
		//Inserting the record into the database.
		$this->db->dbprefix('admin_roles');
		$this->db->where('id',$role_id);
		$ins_into_db = $this->db->update('roles', $ins_data);
		if($ins_into_db)
                    return true;
	}//end edit_role

}

?>