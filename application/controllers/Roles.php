<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct() {
             parent::__construct();

             $this->stencil->layout('default_layout');

             $this->stencil->slice('header_script');
             $this->stencil->slice('header');
             $this->stencil->slice('sidebar');
             $this->stencil->slice('footer_script');
             $this->stencil->slice('footer');

            $this->load->model("mod_common");
	        $this->load->model("mod_roles");

            $this->mod_common->verify_is_user_login();
            
            $this->mod_common->is_company_page_accessible(93);

        }
        
    //Manage Roles
	public function index()
	{
	    $this->mod_common->is_company_page_accessible(94);
	    $where = array('company_id' => $this->session->userdata('company_id'));
        $data['roles'] = $this->mod_common->get_all_records("roles","*",0,0,$where);
        $this->stencil->title('Roles');
	    $this->stencil->paint('roles/manage_roles', $data);
	}
    
    //Add Role Screen
	public function add_role() {
        $this->mod_common->is_company_page_accessible(95);
        $data['menus'] = $this->mod_roles->get_all_menu();
        $this->stencil->title('Add Role');
        $this->stencil->paint('roles/add_new_role', $data);
    }
	
	//Add New Role
	public function add_new_role_process() {
        $this->mod_common->is_company_page_accessible(95);
		$this->form_validation->set_rules('role_title', 'Role Title', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
				$data['menus'] = $this->mod_roles->get_all_menu();
                                $this->stencil->title('Add Role');
                                $this->stencil->paint('roles/add_new_role', $data);
			}
		else{
			$data_arr['add-new-role-data'] = $this->input->post();
			$add_new_role = $this->mod_roles->add_new_role($this->input->post());

			if ($add_new_role) {
				//Unset POST values from session
				$this->session->unset_userdata('add-new-role-data');
				$this->session->set_flashdata('ok_message', 'New Role added successfully.');
				redirect(SURL . 'roles');
			} else {

				$this->session->set_flashdata('err_message', 'New Role is not added. Something went wrong, please try again.');

				redirect(SURL . 'roles');
			}
		}
    }
	
	//Edit Role Screen
	public function edit_role($role_id) {

        $this->mod_common->is_company_page_accessible(94);
		
		if($role_id=="" || !(is_numeric($role_id))){
            redirect("nopage");
        }
		
        //All Restricted Menues of Admin Panel            
        $permission_arr = $this->mod_roles->get_all_menu();
        $data['permission_arr'] = $permission_arr;

        //Fetching Admin Role Data
        $get_admin_role = $this->mod_roles->get_admin_role($role_id);
        $get_admin_role['admin_role_arr']['user_permissions_arr'] = explode(';', $get_admin_role['admin_role_arr']['permissions']);

        $data['admin_role_arr'] = $get_admin_role['admin_role_arr'];
        $data['admin_role_count'] = $get_admin_role['admin_role_count'];
        if ($get_admin_role['admin_role_count'] == 0)
            redirect(SURL);
        $this->stencil->title('Edit Role');
        $this->stencil->paint('roles/edit_role', $data);
    }
    
    //Update Role
    public function edit_role_process() {
        $this->mod_common->is_company_page_accessible(96);
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_role'))
            redirect(SURL);
		
		$role_id = $this->input->post('role_id');
		
		$get_admin_role = $this->mod_roles->get_admin_role($role_id);
        
		$original_value = $get_admin_role['admin_role_arr']['role_title'];
		
        if($this->input->post('role_title') != $original_value) {
            $is_unique =  '|is_unique[roles.role_title]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('role_title', 'Role Title', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   //All Restricted Menues of Admin Panel            
           $permission_arr = $this->mod_roles->get_all_menu();
           $data['permission_arr'] = $permission_arr;
		
		   $get_admin_role['admin_role_arr']['user_permissions_arr'] = explode(';', $get_admin_role['admin_role_arr']['permissions']);

           $data['admin_role_arr'] = $get_admin_role['admin_role_arr'];
           $data['admin_role_count'] = $get_admin_role['admin_role_count'];
           if ($get_admin_role['admin_role_count'] == 0)
            redirect(SURL);
           $this->stencil->title('Edit Role');
           $this->stencil->paint('roles/edit_role', $data);
		    
		}
		
		else{	
			$upd_admin_role = $this->mod_roles->edit_role($this->input->post());

			if ($upd_admin_role) {
				$this->session->set_flashdata('ok_message', 'Role updated successfully.');
				redirect(SURL . 'roles');
			} else {
				$this->session->set_flashdata('err_message', 'Role is not updated. Something went wrong, please try again.');
				redirect(SURL . 'roles/edit_role/' . $role_id);
			}
		}
    }
	
	//Delete Role
	public function delete_role() {
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "roles";
        $where = "`id` ='" . $id . "'";
		
        $delete_role = $this->mod_common->delete_record($table, $where);

    }
	
	//Verify Role
	public function verify_role() {

        $role_title = $this->input->post("role_title");
        
        $table = "roles";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'role_title' => $role_title,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'role_title' => $role_title,
            'company_id' => $this->session->userdata('company_id')
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
 
}
