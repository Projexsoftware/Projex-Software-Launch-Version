<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {

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

    }
    
    /***************Clients Section Starts Here*********************/
    
    //Get All Clients
	public function clients()
	{
	    $this->mod_common->is_company_page_accessible(52);
        $data['clients'] = $this->mod_common->get_all_records("clients","*",0,0,array("company_id" => $this->session->userdata("company_id")),"client_id");
        $this->stencil->title('Clients');
	    $this->stencil->paint('clients/manage_clients', $data);
	}
    
    //Add Client Screen
	public function add_client() {

        $this->mod_common->is_company_page_accessible(54);
        $this->stencil->title('Add Client');
        $this->stencil->paint('clients/add_new_client');
    }
	
	//Add New Client
	public function add_new_client_process() {
		 
        $this->mod_common->is_company_page_accessible(54);
		$this->form_validation->set_rules('client_fname1', 'First Name 1', 'required');
		$this->form_validation->set_rules('client_surname1', 'Surname 1', 'required');
		$this->form_validation->set_rules('client_mobilephone_primary', 'Mobile Phone Primary', 'required');
		$this->form_validation->set_rules('client_email_primary', 'Email Primary', 'required');
		$this->form_validation->set_rules('street_pobox', 'Street', 'required');
		$this->form_validation->set_rules('suburb', 'Suburb', 'required');
		$this->form_validation->set_rules('client_city', 'City', 'required');
		$this->form_validation->set_rules('client_zip', 'ZIP Code', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $this->stencil->title('Add Client');
                $this->stencil->paint('clients/add_new_client');
			}
		else{
			$table = "clients";
					
			$client_fname1 = $this->input->post('client_fname1');
			$client_fname2 = $this->input->post('client_fname2');
			$client_surname1 = $this->input->post('client_surname1');
			$client_surname2 = $this->input->post('client_surname2');
			$client_homephone_secondary = $this->input->post('client_homephone_secondary');
			$client_homephone_primary = $this->input->post('client_homephone_primary');
			$client_workphone_secondary = $this->input->post('client_workphone_secondary');
			$client_workphone_primary = $this->input->post('client_workphone_primary');
			$client_mobilephone_secondary = $this->input->post('client_mobilephone_secondary');
			$client_mobilephone_primary = $this->input->post('client_mobilephone_primary');
			$client_email_secondary = $this->input->post('client_email_secondary');
			$client_email_primary = $this->input->post('client_email_primary');
			$street_pobox = $this->input->post('street_pobox');
			$post_street_pobox = $this->input->post('post_street_pobox');
			$suburb = $this->input->post('suburb');
			$post_suburb = $this->input->post('post_suburb');
			$client_city = $this->input->post('client_city');
			$client_postal_city = $this->input->post('client_postal_city');
			$country = $this->input->post('country');
			$pcountry = $this->input->post('pcountry');
			$state = $this->input->post('state');
			$pstate = $this->input->post('pstate');
			$client_zip = $this->input->post('client_zip');
			$client_postal_zip = $this->input->post('client_postal_zip');
			$client_status = $this->input->post('client_status');
			$client_note = $this->input->post('client_note');
			$company_id = $this->session->userdata("company_id");
            $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
 
                        $ins_array = array(
                				"client_fname1" => $client_fname1,
                				"client_fname2" => $client_fname2,
                				"client_surname1" => $client_surname1,
                				"client_surname2" => $client_surname2,
                				"client_homephone_secondary" => $client_homephone_secondary,
                				"client_homephone_primary" => $client_homephone_primary,
                				"client_workphone_secondary" => $client_workphone_secondary,
                				"client_workphone_primary" => $client_workphone_primary,
                				"client_mobilephone_secondary" => $client_mobilephone_secondary,
                				"client_mobilephone_primary" => $client_mobilephone_primary,
                				"client_email_secondary" => $client_email_secondary,
                				"client_email_primary" => $client_email_primary,
                				"street_pobox" => $street_pobox,
                				"post_street_pobox" => $post_street_pobox,
                				"suburb" => $suburb,
                				"post_suburb" => $post_suburb,
                				"client_city" => $client_city,
                				"client_postal_city" => $client_postal_city,
                				"country" => $country,
                				"pcountry" => $pcountry,
                				"state" => $state,
                				"pstate" => $pstate,
                				"client_zip" => $client_zip,
                				"client_postal_zip" => $client_postal_zip,
                				"client_status" => $client_status,
                				"client_note" => $client_note,
                				"company_id" => $company_id,
                				"user_id" => $created_by,
                				"created_by" => $created_by,
                                "ip_address" => $ip_address
		                	);
					
		    $add_new_client = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_client) {
				$this->session->set_flashdata('ok_message', 'New Client added successfully.');
				redirect(SURL . 'manage/clients');
			} else {
				$this->session->set_flashdata('err_message', 'New Client is not added. Something went wrong, please try again.');
				redirect(SURL . 'manage/clients');
			}
		}
    }
	
	//Edit Client Screen
	public function edit_client($client_id) {

        $this->mod_common->is_company_page_accessible(55);
		
	    if($client_id=="" || !(is_numeric($client_id))){
            redirect("nopage");
        }
		
        $table = "project_clients";
        $where = "`client_id` ='" . $client_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['client_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['client_edit']) == 0) {
            $this->session->set_flashdata('err_message', 'Client does not exist.');
			redirect(SURL . 'manage/clients');
        } else {
            $this->stencil->title("Edit Client");

            $this->stencil->paint('clients/edit_client', $data);
        }
    }

    //Update Client
    public function edit_client_process() {
		
        $this->mod_common->is_company_page_accessible(55);
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_client'))
        
        redirect(SURL."manage/clients");
	    
	    $this->form_validation->set_rules('client_fname1', 'First Name 1', 'required');
		$this->form_validation->set_rules('client_surname1', 'Surname 1', 'required');
		$this->form_validation->set_rules('client_mobilephone_primary', 'Mobile Phone Primary', 'required');
		$this->form_validation->set_rules('street_pobox', 'Street', 'required');
		$this->form_validation->set_rules('suburb', 'Suburb', 'required');
		$this->form_validation->set_rules('client_city', 'City', 'required');
		$this->form_validation->set_rules('client_zip', 'ZIP Code', 'required');
		
	    $client_id = $this->input->post('client_id');
		
        $table = "project_clients";
	    $where = "`client_id` ='" . $client_id."'";

	    $data['client_edit'] = $this->mod_common->select_single_records($table, $where);
		
        $original_value = $data['client_edit']['client_email_primary'];
		
        if($this->input->post('client_email_primary') != $original_value) {
            $is_unique =  '|is_unique[clients.client_email_primary]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('client_email_primary', 'Home Phone Primary', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Client");
           $this->stencil->paint('clients/edit_client', $data);
		    
		}
		
		else{	
			$table = "clients";
					
			$client_fname1 = $this->input->post('client_fname1');
			$client_fname2 = $this->input->post('client_fname2');
			$client_surname1 = $this->input->post('client_surname1');
			$client_surname2 = $this->input->post('client_surname2');
			$client_homephone_secondary = $this->input->post('client_homephone_secondary');
			$client_homephone_primary = $this->input->post('client_homephone_primary');
			$client_workphone_secondary = $this->input->post('client_workphone_secondary');
			$client_workphone_primary = $this->input->post('client_workphone_primary');
			$client_mobilephone_secondary = $this->input->post('client_mobilephone_secondary');
			$client_mobilephone_primary = $this->input->post('client_mobilephone_primary');
			$client_email_secondary = $this->input->post('client_email_secondary');
			$client_email_primary = $this->input->post('client_email_primary');
			$street_pobox = $this->input->post('street_pobox');
			$post_street_pobox = $this->input->post('post_street_pobox');
			$suburb = $this->input->post('suburb');
			$post_suburb = $this->input->post('post_suburb');
			$client_city = $this->input->post('client_city');
			$client_postal_city = $this->input->post('client_postal_city');
			$country = $this->input->post('country');
			$pcountry = $this->input->post('pcountry');
			$state = $this->input->post('state');
			$pstate = $this->input->post('pstate');
			$client_zip = $this->input->post('client_zip');
			$client_postal_zip = $this->input->post('client_postal_zip');
			$client_status = $this->input->post('client_status');
			$client_note = $this->input->post('client_note');
			$ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
					            "client_fname1" => $client_fname1,
                				"client_fname2" => $client_fname2,
                				"client_surname1" => $client_surname1,
                				"client_surname2" => $client_surname2,
                				"client_homephone_secondary" => $client_homephone_secondary,
                				"client_homephone_primary" => $client_homephone_primary,
                				"client_workphone_secondary" => $client_workphone_secondary,
                				"client_workphone_primary" => $client_workphone_primary,
                				"client_mobilephone_secondary" => $client_mobilephone_secondary,
                				"client_mobilephone_primary" => $client_mobilephone_primary,
                				"client_email_secondary" => $client_email_secondary,
                				"client_email_primary" => $client_email_primary,
                				"street_pobox" => $street_pobox,
                				"post_street_pobox" => $post_street_pobox,
                				"suburb" => $suburb,
                				"post_suburb" => $post_suburb,
                				"client_city" => $client_city,
                				"client_postal_city" => $client_postal_city,
                				"country" => $country,
                				"pcountry" => $pcountry,
                				"state" => $state,
                				"pstate" => $pstate,
                				"client_zip" => $client_zip,
                				"client_postal_zip" => $client_postal_zip,
                				"client_status" => $client_status,
                				"client_note" => $client_note,
                                "ip_address" => $ip_address
                            );                      
							
			$table = "clients";
			$where = "`client_id` ='" . $client_id . "'";
			$update_client = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_client) {
				$this->session->set_flashdata('ok_message', 'Client updated successfully.');
				redirect(SURL . 'manage/clients');
			} else {
				$this->session->set_flashdata('err_message', 'Client is not updated. Something went wrong, please try again.');
				redirect(SURL . 'manage/edit_client/' . $client_id);
			}
		}
    }
	
	//Delete Client
	public function delete_client() {
  
        $this->mod_common->is_company_page_accessible(56);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "clients";
        $where = "`client_id` ='" . $id . "'";
		
        $delete_client = $this->mod_common->delete_record($table, $where);

    }
	
	//Verify Client Email
    public function verify_client_email() {

        $client_email_primary = $this->input->post("email");
        
        $table = "project_clients";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'client_id !=' => $id,
            'client_email_primary' => $client_email_primary,
            "company_id" => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'client_email_primary' => $client_email_primary,
            "company_id" => $this->session->userdata('company_id')
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    //Verify Client
    public function view_client($client_id) {
        
        $this->mod_common->is_company_page_accessible(53);
		
	    if($client_id=="" || !(is_numeric($client_id))){
            redirect("nopage");
        }
		
        $table = "project_clients";
        $where = "`client_id` ='" . $client_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['client_details'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['client_details']) == 0) {
            $this->session->set_flashdata('err_message', 'Client does not exist.');
			redirect(SURL . 'manage/clients');
        } else {
            $this->stencil->title("View Client Details");

            $this->stencil->paint('clients/client_details', $data);
        }
    }
    
    /***************Clients Section Ends Here*********************/
    
    /***************Projects Section Starts Here*********************/
    
    //Get All Projects
    public function projects()
	{
	    $this->mod_common->is_company_page_accessible(57);
        $data['projects'] = $this->mod_common->get_all_records("projects","*",0,0,array("company_id" => $this->session->userdata("company_id")),"project_id");
        $this->stencil->title('Projects');
	    $this->stencil->paint('projects/manage_projects', $data);
	}
    
    //Add Project Screen
	public function add_project($client_id=0) {

        $this->mod_common->is_company_page_accessible(59);
        $this->session->unset_userdata("project_documents");
        $data["client_id"] = $client_id;
        if($client_id>0){
            $data['clients'] = $this->mod_common->get_all_records("clients","*",0,0,array('company_id' => $this->session->userdata('company_id'), "client_status" => 1, "client_id" => $client_id),"client_id");
        }
        else{
            $data['clients'] = $this->mod_common->get_all_records("clients","*",0,0,array('company_id' => $this->session->userdata('company_id'), "client_status" => 1),"client_id");
        }
        $this->stencil->title('Add Project');
        $this->stencil->paint('projects/add_new_project', $data);
    }
    
    //Add New Project
    public function add_new_project_process() {
		 
        $this->mod_common->is_company_page_accessible(59);
		$this->form_validation->set_rules('project_title', 'Project Name', 'required');
		$this->form_validation->set_rules('client_id', 'Client', 'required');
		$this->form_validation->set_rules('street_pobox', 'Street', 'required');
		$this->form_validation->set_rules('suburb', 'Suburb', 'required');
		$this->form_validation->set_rules('project_address_state', 'Region', 'required');
		$this->form_validation->set_rules('project_address_city', 'City', 'required');
		$this->form_validation->set_rules('project_address_country', 'Country', 'required');
		$this->form_validation->set_rules('project_zip', 'ZIP Code', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $data['clients'] = $this->mod_common->get_all_records("clients","*",0,0,array('company_id' => $this->session->userdata('company_id'), "client_status" => 1),"client_id");
                $this->stencil->title('Add Project');
                $this->stencil->paint('projects/add_new_project', $data);
			}
		else{
			$table = "projects";
					
			$project_title = $this->input->post('project_title');
			$project_des = $this->input->post('project_des');
			$client_id = $this->input->post('client_id');
			$street_pobox = $this->input->post('street_pobox');
			$suburb = $this->input->post('suburb');
			$project_address_state = $this->input->post('project_address_state');
			$project_address_city = $this->input->post('project_address_city');
			$project_address_country = $this->input->post('project_address_country');
			$project_zip = $this->input->post('project_zip');
			$bank_account = $this->input->post('bank_acount');
			$project_legal_des = $this->input->post('project_legal_des');
			$project_status = $this->input->post('project_status');
			//$start_date = DateTime::createFromFormat('d/m/Y', $this->input->post('proposed_start_date'));
            //$start_date = $start_date->format('Y-m-d');
			//$end_date = date('Y-m-d', strtotime($start_date. ' + 5 days'));
			$company_id = $this->session->userdata("company_id");
            $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
 
                        $ins_array = array(
                				"project_title" => $project_title,
                				"project_des" => $project_des,
                				"client_id" => $client_id,
                				"street_pobox" => $street_pobox,
                				"suburb" => $suburb,
                				"project_address_state" => $project_address_state,
                				"project_address_city" => $project_address_city,
                				"project_address_country" => $project_address_country,
                				"project_zip" => $project_zip,
                				"bank_acount" => $bank_account,
                				"project_legal_des" => $project_legal_des,
                				"project_status" => $project_status,
                				"user_id" => $created_by,
                				"company_id" => $company_id,
                				"created_by" => $created_by,
                                "ip_address" => $ip_address
		                	);
					
		    $add_new_project = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_project) {
			    
			        $projectID = $add_new_project;
                    $costing = array(
                        'project_id' => $projectID,
                        'user_id' => $this->session->userdata('user_id'),
                        'company_id' => $this->session->userdata('company_id'),
						'include_in_report' => 0,
                        'contract_allownce' => 0,
                        'total_quantity' => 0.00,
                        'takeoffdatas' => "",
                        'project_subtotal_1' => 0,
                        'project_subtotal_2' => 0,
                        'project_subtotal_3' => 0,
                        'is_costing_locked' => 0,
                        'over_head_margin' => 0,
                        'porfit_margin' => 0,
                        'tax_percent' => 15.00,
                        'price_rounding' => 0,
                        'contract_price' => 0,
                        'sale_price' => 0,
                        'status' => 1,        
                      );


                    $costing = $this->mod_common->insert_into_table('project_costing', $costing);
					$project_id = $projectID;
					
					// Add Project In Scheduling
					
					/*$ins_array = array(
					            "parent_project_id" => $project_id,
				                "name" => $project_title,
                                "description" => $project_des,
                                "start_date" => $start_date,
                                "end_date" => $end_date,
				                "created_by" => $created_by,
                                "ip_address" => $ip_address,
                                "company_id" => $company_id,
				                "status" => $project_status
			       );
					
		           $project_scheduling_id = $this->mod_common->insert_into_table("project_scheduling_projects", $ins_array);
					
					 //Project Manager
                        $ins_array = array(
				            "project_id" => $project_scheduling_id,
				            "team_id" => $this->session->userdata("user_id"),
                            "team_role" => 1,
                            "token" => md5($this->session->userdata("user_id"))
			            );
					 
		                $this->mod_common->insert_into_table("project_scheduling_team", $ins_array);*/
					
                    $privacy_options = $this->input->post("privacy_options");
    
					if($this->session->userdata("project_documents")!=""){
							$project_documents = explode(",", rtrim($this->session->userdata("project_documents"),","));
							for($i=0;$i<count($project_documents);$i++){
							$project_plans_and_specifications_array = array(
								 "document" => $project_documents[$i],
								 "project_id" => $project_id,
								 "privacy" => $privacy_options,
								);
							$this->mod_common->insert_into_table('project_plans_and_specifications',$project_plans_and_specifications_array);
							
							/*$project_scheduling_documents_array = array(
							     "parent_document_id" => $parent_document_id,
								 "document" => $project_documents[$i],
								 "document_original_name" => $project_documents[$i],
								 "project_id" => $project_scheduling_id,
								 "privacy_settings" => $privacy_options,
								);
							$this->mod_common->insert_into_table('project_scheduling_documents',$project_scheduling_documents_array);*/
							}
						   $this->session->unset_userdata("project_documents");
					}
				$this->session->set_flashdata('ok_message', 'New Project added successfully.');
				redirect(SURL . 'manage/projects');
			} else {
				$this->session->set_flashdata('err_message', 'New Project is not added. Something went wrong, please try again.');
				redirect(SURL . 'manage/projects');
			}
		}
    }
    
    //Edit Project
    public function edit_project($project_id) {

        $this->mod_common->is_company_page_accessible(58);
		
	    if($project_id=="" || !(is_numeric($project_id))){
            redirect("nopage");
        }
		
        $table = "project_projects";
        $where = "`project_id` ='" . $project_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['project_edit'] = $this->mod_common->select_single_records($table, $where);
        $data['clients'] = $this->mod_common->get_all_records("clients","*",0,0,array('company_id' => $this->session->userdata('company_id'), "client_status" => 1),"client_id");

        if (count($data['project_edit']) == 0) {
            $this->session->set_flashdata('err_message', 'Project does not exist.');
            redirect("manage/projects");
        } else {
            $this->stencil->title("Edit Project");
            $this->stencil->paint('projects/edit_project', $data);
        }
    }
    
    //Update Project
    public function edit_project_process() {
		
        $this->mod_common->is_company_page_accessible(60);
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_project'))
        
        redirect(SURL."manage/projects");
	    
		$this->form_validation->set_rules('client_id', 'Client', 'required');
		$this->form_validation->set_rules('street_pobox', 'Street', 'required');
		$this->form_validation->set_rules('suburb', 'Suburb', 'required');
		$this->form_validation->set_rules('project_address_state', 'Region', 'required');
		$this->form_validation->set_rules('project_address_city', 'City', 'required');
		$this->form_validation->set_rules('project_address_country', 'Country', 'required');
		$this->form_validation->set_rules('project_zip', 'ZIP Code', 'required');
		
	    $project_id = $this->input->post('project_id');
		
        $table = "project_projects";
	    $where = array("project_id" => $project_id);

	    $data['project_edit'] = $this->mod_common->select_single_records($table, $where);
	
        $this->form_validation->set_rules('project_title', 'Project Name', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Project");
		    $data['clients'] = $this->mod_common->get_all_records("clients","*",0,0,array('company_id' => $this->session->userdata('company_id'), "client_status" => 1),"client_id");
           $this->stencil->paint('clients/edit_client', $data);
		    
		}
		
		else{	
			$table = "projects";
					
		    $project_title = $this->input->post('project_title');
			$project_des = $this->input->post('project_des');
			$client_id = $this->input->post('client_id');
			$street_pobox = $this->input->post('street_pobox');
			$suburb = $this->input->post('suburb');
			$project_address_state = $this->input->post('project_address_state');
			$project_address_city = $this->input->post('project_address_city');
			$project_address_country = $this->input->post('project_address_country');
			$project_zip = $this->input->post('project_zip');
			$bank_account = $this->input->post('bank_acount');
			$project_legal_des = $this->input->post('project_legal_des');
			$project_status = $this->input->post('project_status');
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
 
            $upd_array = array(
            	"project_title" => $project_title,
                "project_des" => $project_des,
                "client_id" => $client_id,
                "street_pobox" => $street_pobox,
                "suburb" => $suburb,
                "project_address_state" => $project_address_state,
                "project_address_city" => $project_address_city,
                "project_address_country" => $project_address_country,
                "project_zip" => $project_zip,
                "bank_acount" => $bank_account,
                "project_legal_des" => $project_legal_des,
                "project_status" => $project_status,
                "ip_address" => $ip_address
		  );
					
			$where = "`project_id` ='" . $project_id . "'";
			$update_project = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_project) {
			    
			    //Update project status into scheduling projects
			    
			    /*$upd_array = array(
				    "status" => $project_status
			    );
					
		        $this->mod_common->update_table("project_scheduling_projects", array("parent_project_id" => $project_id), $upd_array);*/
		        
				$this->session->set_flashdata('ok_message', 'Project updated successfully.');
				redirect(SURL . 'manage/projects');
			} else {
				$this->session->set_flashdata('err_message', 'Project is not updated. Something went wrong, please try again.');
				redirect(SURL . 'manage/edit_project/' . $client_id);
			}
		}
    }
    
    //Delete Project
    public function delete_project() {
  
        $this->mod_common->is_company_page_accessible(62);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "project_projects";
        $where = "`project_id` ='" . $id . "'";
        
        //Delete project_costing
	    $project_costing = $this->mod_common->get_all_records('project_costing',"*",0,0,$where, "costing_id");
		foreach($project_costing as $val){
			 $this->mod_common->delete_record('project_costing_parts',array('costing_id'=>$val["costing_id"]));
			 //$this->mod_common->delete_record('temp_payments',array('costing_id'=>$val->costing_id));
		}
	    $this->mod_common->delete_record('project_costing',$where);
			    
			    
	    //Delete Variations
		$projectcost_variations = $this->mod_common->get_all_records('project_variations',"*",0,0,$where);
		foreach($projectcost_variations as $val){
			$this->mod_common->delete_record('project_variation_parts',array('variation_id'=>$val->id));
		}
		$this->mod_common->delete_record('project_variations',$where);
			    
			    
	    //Delete Purchase Orders
		$purchase_order = $this->mod_common->get_all_records('project_purchase_orders',"*",0,0,$where);
		foreach($purchase_order as $val){
			$this->mod_common->delete_record('project_purchase_order_items',array('purchase_order_id'=>$val->id));
	    }
	    $this->mod_common->delete_record('project_purchase_orders',$where);
			    
			    
		//Delete salesinvoices
		$salesinvoices = $this->mod_common->get_all_records('project_sales_invoices',"*",0,0,$where);
		foreach($salesinvoices as $val){
			 $this->mod_common->delete_record('project_sales_invoices_items',array('sale_invoice_id'=>$val->id));
			        
			 //Delete sales_receipts
        	 $sales_receipts = $this->mod_common->get_all_records('project_sales_receipts',"*",0,0,array('sale_invoice_id'=>$val->id));
        	foreach($salesinvoices as $val){
        		$this->mod_common->delete_record('project_sales_receipts_items',array('receipt_id'=>$val->id));
        	}
        	$this->mod_common->delete_record('project_sales_receipts',array('sale_invoice_id'=>$val->id));
		}
	    $this->mod_common->delete_record('project_sales_invoices',$where);
	    
	    //Delete Sales Credits Notes
	    $sales_credits = $this->mod_common->get_all_records('project_sales_credit_notes',"*",0,0,$where);
		foreach($sales_credits as $val){
			 $this->mod_common->delete_record('project_sales_credit_note_items',array('credit_note_id'=>$val->id));
		}
		$this->mod_common->delete_record('project_sales_credit_notes',$where);
			    
		//Delete supplier_invoices
		$supplier_invoices = $this->mod_common->get_all_records('project_supplier_invoices',"*",0,0,$where);
		foreach($supplier_invoices as $val){
			 $this->mod_common->delete_record('project_supplier_invoices_items',array('supplier_invoice_id'=>$val->id));
		}
		$this->mod_common->delete_record('project_supplier_invoices',$where);
		
		//Delete Supplier Credits
		$supplier_credits = $this->mod_common->get_all_records('project_supplier_credits',"*",0,0,$where);
		foreach($supplier_credits as $val){
			 $this->mod_common->delete_record('project_supplier_credits_items',array('supplier_credit_id'=>$val->id));
		}
		$this->mod_common->delete_record('project_supplier_credits',$where);
		
		$delete_project = $this->mod_common->delete_record($table, $where);
		
		
        // Delete from Scheduling
        		
		/*if($this->input->post("delete_from_schedule")==1){
        		
        		
        	$project_info = $this->mod_common->select_single_records("project_scheduling_projects", array("parent_project_id" => $id));
        	
        	if(count($project_info)>0){
        	
                	$file_name="./assets/scheduling/project_images/".$project_info['image'];   
        		         
                    if(file_exists($file_name) && $project_info['image']!=""){
                    	unlink($file_name);
                    	$thumb_file_name="./assets/scheduling/project_images/thumb/".$project_info['image']; 
                    	if(file_exists($thumb_file_name)){
                    	   unlink($thumb_file_name);
                    	}
                    }
                		
                	$table = "project_scheduling_projects";
                    $where = "`id` ='" . $project_info['id'] . "'";
                		
                    $this->mod_common->delete_record($table, $where);
                
                    $table = "project_scheduling_team";
                    $where = "`project_id` ='" . $project_info['id'] . "'";
                    $this->mod_common->delete_record($table, $where);
                
                    //Delete Items
                    $table = "project_scheduling_items";
                    $where = "`project_id` ='" . $project_info['id'] . "'";
                		
                    $this->mod_common->delete_record($table, $where);
                
                    //Delete Checklists
                
                     $table = "project_scheduling_item_checklists";
                     $where = "`project_id` ='" . $project_info['id'] . "'";
                
                     $this->mod_common->delete_record($table, $where);
                
                     //Delete Notes
                
                     $table = "project_scheduling_item_notes";
                     $where = "`project_id` ='" . $project_info['id'] . "'";
                
                     $this->mod_common->delete_record($table, $where);
                
                     //Delete Reminders
                
                     $table = "project_scheduling_item_reminders";
                     $where = "`project_id` ='" . $project_info['id'] . "'";
                
                     $this->mod_common->delete_record($table, $where);
                
                     //Delete Files
                     
                     $scheduling_files = $this->mod_common->get_all_records('project_scheduling_item_files',"*",0,0,array("project_id" => $project_info['id']));
        		     foreach($scheduling_files as $scheduling_file){
        		         if($scheduling_file['file_type']==0){
        		            $file_name="./assets/scheduling/task_uploads/files/".$scheduling_file['file'];
        		         }
        		         else{
        		           $file_name="./assets/scheduling/task_uploads/images/".$scheduling_file['file'];   
        		         }
                         if(file_exists($file_name) && $file_name!=""){
                    	   unlink($file_name);
                         }
        		     }
                
                     $table = "project_scheduling_item_files";
                     $where = "`project_id` ='" . $project_info['id'] . "'";
                
                     $this->mod_common->delete_record($table, $where);
        	}
		}*/

    }
    
    //Verify Project
    public function verify_project() {

        $project_title = $this->input->post("name");
        
        $table = "project_projects";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'project_id !=' => $id,
            'project_title' => $project_title,
            "company_id" => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'project_title' => $project_title,
            "company_id" => $this->session->userdata('company_id')
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    /***************Projects Section Ends Here*********************/
    
    /***************Suppliers Section Starts Here*********************/
    
    //Get All Suppliers
    public function suppliers()
	{   
	    $this->mod_common->is_company_page_accessible(63);
        $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array("company_id" => $this->session->userdata("company_id")),"supplier_id");
        $this->stencil->title('Suppliers');
	    $this->stencil->paint('suppliers/manage_suppliers', $data);
	}

    //Add Supplier Screen
	public function add_supplier() {

        $this->mod_common->is_company_page_accessible(65);
        $this->stencil->title('Add Supplier');
        $this->stencil->paint('suppliers/add_new_supplier');
    }
	
	//Add New Supplier
	public function add_new_supplier_process() {
		 
        $this->mod_common->is_company_page_accessible(65);
		$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $this->stencil->title('Add Supplier');
                $this->stencil->paint('suppliers/add_new_supplier');
			}
		else{
			$table = "suppliers";
					
			$supplier_name = $this->input->post('supplier_name');
			$supplier_email = $this->input->post('supplier_email');
			$supplier_phone = $this->input->post('supplier_phone');
			$supplier_web = $this->input->post('supplier_web');
			$supplier_contact_person = $this->input->post('supplier_contact_person');
			$supplier_contact_person_mobile = $this->input->post('supplier_contact_person_mobile');
			$street_pobox = $this->input->post('street_pobox');
			$post_street_pobox = $this->input->post('post_street_pobox');
			$suburb = $this->input->post('suburb');
			$post_suburb = $this->input->post('post_suburb');
			$supplier_city = $this->input->post('supplier_city');
			$supplier_postal_city = $this->input->post('supplier_postal_city');
			$supplier_country = $this->input->post('supplier_country');
			$supplier_postal_country = $this->input->post('supplier_postal_country');
			$supplier_state = $this->input->post('supplier_state');
			$supplier_postal_state = $this->input->post('supplier_postal_state');
			$supplier_zip = $this->input->post('supplier_zip');
			$supplier_postal_zip = $this->input->post('supplier_postal_zip');
			$supplier_status = $this->input->post('supplier_status');
			$company_id = $this->session->userdata("company_id");
            $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
 
                        $ins_array = array(
                				"supplier_name" => $supplier_name,
                				"supplier_email" => $supplier_email,
                				"supplier_phone" => $supplier_phone,
                				"supplier_web" => $supplier_web,
                				"supplier_contact_person" => $supplier_contact_person,
                				"supplier_contact_person_mobile" => $supplier_contact_person_mobile,
                				"street_pobox" => $street_pobox,
                				"post_street_pobox" => $post_street_pobox,
                				"suburb" => $suburb,
                				"post_suburb" => $post_suburb,
                				"supplier_city" => $supplier_city,
                				"supplier_postal_city" => $supplier_postal_city,
                				"supplier_country" => $supplier_country,
                				"supplier_postal_country" => $supplier_postal_country,
                				"supplier_state" => $supplier_state,
                				"supplier_postal_state" => $supplier_postal_state,
                				"supplier_zip" => $supplier_zip,
                				"supplier_postal_zip" => $supplier_postal_zip,
                				"supplier_status" => $supplier_status,
                				"company_id" => $company_id,
                				"user_id" => $created_by,
                				"created_by" => $created_by,
                                "ip_address" => $ip_address
		                	);
					
		    $add_new_supplier = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_supplier) {
				$this->session->set_flashdata('ok_message', 'New Supplier added successfully.');
				redirect(SURL . 'manage/suppliers');
			} else {
				$this->session->set_flashdata('err_message', 'New Supplier is not added. Something went wrong, please try again.');
				redirect(SURL . 'manage/suppliers');
			}
		}
    }
	
	//Edit Supplier Screen
	public function edit_supplier($supplier_id) {

        $this->mod_common->is_company_page_accessible(64);
		
	    if($supplier_id=="" || !(is_numeric($supplier_id))){
            redirect("nopage");
        }
		
        $table = "project_suppliers";
        $where = "`supplier_id` ='" . $supplier_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['supplier_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['supplier_edit']) == 0) {
            $this->session->set_flashdata('err_message', 'Supplier does not exist.');
            redirect("manage/suppliers");
        } else {
            $this->stencil->title("Edit Supplier");

            $this->stencil->paint('suppliers/edit_supplier', $data);
        }
    }
    
    //Update Supplier
    public function edit_supplier_process() {
		
        $this->mod_common->is_company_page_accessible(66);
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_supplier'))
        
        redirect(SURL."manage/suppliers");
		
	    $supplier_id = $this->input->post('supplier_id');
		
        $table = "project_suppliers";
	    $where = "`supplier_id` ='" . $supplier_id."'";

	    $data['supplier_edit'] = $this->mod_common->select_single_records($table, $where);
	    
	    $original_value = $data['supplier_edit']['supplier_name'];
		
        if($this->input->post('supplier_name') != $original_value) {
            $is_unique =  '|is_unique[suppliers.supplier_name]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
		
        $original_value = $data['supplier_edit']['supplier_email'];
		
        if($this->input->post('supplier_email') != $original_value) {
            $is_unique =  '|is_unique[suppliers.supplier_email]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('supplier_email', 'Supplier Email', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Supplier");
           $this->stencil->paint('suppliers/edit_supplier', $data);
		    
		}
		
		else{	
			$table = "suppliers";
					
			$supplier_name = $this->input->post('supplier_name');
			$supplier_email = $this->input->post('supplier_email');
			$supplier_phone = $this->input->post('supplier_phone');
			$supplier_web = $this->input->post('supplier_web');
			$supplier_contact_person = $this->input->post('supplier_contact_person');
			$supplier_contact_person_mobile = $this->input->post('supplier_contact_person_mobile');
			$street_pobox = $this->input->post('street_pobox');
			$post_street_pobox = $this->input->post('post_street_pobox');
			$suburb = $this->input->post('suburb');
			$post_suburb = $this->input->post('post_suburb');
			$supplier_city = $this->input->post('supplier_city');
			$supplier_postal_city = $this->input->post('supplier_postal_city');
			$supplier_country = $this->input->post('supplier_country');
			$supplier_postal_country = $this->input->post('supplier_postal_country');
			$supplier_state = $this->input->post('supplier_state');
			$supplier_postal_state = $this->input->post('supplier_postal_state');
			$supplier_zip = $this->input->post('supplier_zip');
			$supplier_postal_zip = $this->input->post('supplier_postal_zip');
			$supplier_status = $this->input->post('supplier_status');
            $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
					            "supplier_name" => $supplier_name,
                				"supplier_email" => $supplier_email,
                				"supplier_phone" => $supplier_phone,
                				"supplier_web" => $supplier_web,
                				"supplier_contact_person" => $supplier_contact_person,
                				"supplier_contact_person_mobile" => $supplier_contact_person_mobile,
                				"street_pobox" => $street_pobox,
                				"post_street_pobox" => $post_street_pobox,
                				"suburb" => $suburb,
                				"post_suburb" => $post_suburb,
                				"supplier_city" => $supplier_city,
                				"supplier_postal_city" => $supplier_postal_city,
                				"supplier_country" => $supplier_country,
                				"supplier_postal_country" => $supplier_postal_country,
                				"supplier_state" => $supplier_state,
                				"supplier_postal_state" => $supplier_postal_state,
                				"supplier_zip" => $supplier_zip,
                				"supplier_postal_zip" => $supplier_postal_zip,
                				"supplier_status" => $supplier_status,
                                "ip_address" => $ip_address
                            );                      
							
			$table = "suppliers";
			$where = "`supplier_id` ='" . $supplier_id . "'";
			$update_supplier = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_supplier) {
				$this->session->set_flashdata('ok_message', 'Supplier updated successfully.');
				redirect(SURL . 'manage/suppliers');
			} else {
				$this->session->set_flashdata('err_message', 'Supplier is not updated. Something went wrong, please try again.');
				redirect(SURL . 'manage/edit_supplier/' . $supplier_id);
			}
		}
    }
    
    //Verify Supplier
    public function verify_supplier() {

        $supplier_name = $this->input->post("name");
        
        $table = "project_suppliers";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'supplier_id !=' => $id,
            'supplier_name' => $supplier_name,
            "company_id" => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'supplier_name' => $supplier_name,
            "company_id" => $this->session->userdata('company_id')
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    //Verify Supplier Email
    public function verify_supplier_email() {

        $supplier_email = $this->input->post("email");
        
        $table = "project_suppliers";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'supplier_id !=' => $id,
            'supplier_email' => $supplier_email,
            "company_id" => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'supplier_email' => $supplier_email,
            "company_id" => $this->session->userdata('company_id')
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    /***************Suppliers Section Ends Here*********************/
    
    /***************Components Section Starts Here*********************/
    
    //Get All Components
    public function components() {
       
       $this->mod_common->is_company_page_accessible(68);
       $data['components'] = $this->mod_common->get_all_records("components","*",0,0,array("company_id" => $this->session->userdata("company_id")),"component_id");
       $this->stencil->title('Components');
	   $this->stencil->paint('components/manage_components', $data);
    
    }
    
    //Add Component Screen
    public function add_component() {
        
        $this->mod_common->is_company_page_accessible(70);
        $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
        $data['categories'] = $this->mod_common->get_all_records("categories","*",0,0,array("status" => 1),"name");
        $this->stencil->title('Add Component');
        $this->stencil->paint('components/add_new_component', $data);
    }
    
    //Add New Component
    public function add_new_component_process() {
		 
        $this->mod_common->is_company_page_accessible(70);
		$this->form_validation->set_rules('component_name', 'Component Name', 'required');
		$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
		$this->form_validation->set_rules('component_uc', 'Unit Cost', 'required');
		$this->form_validation->set_rules('component_uom', 'Unit of Mesure', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
                $this->stencil->title('Add Component');
                $this->stencil->paint('components/add_new_component', $data);
			}
		else{
		    
		    $filename= "";

			if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
						
						$projects_folder_path = './assets/components/';
						$projects_folder_path_main = './assets/components/';

						$thumb = $projects_folder_path_main . 'thumbnail';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('image')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							
							print_r($error_file_arr);exit;
							
						} else {
                            
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
					}
			$table = "components";
					
			$component_name = $this->input->post('component_name');
			$component_des = $this->input->post('component_des');
			$supplier_id = $this->input->post('supplier_id');
			$component_uc = $this->input->post('component_uc');
			$component_uom = $this->input->post('component_uom');
			$component_status = $this->input->post('component_status');
			$specification =  $this->input->post('specification');
            $warranty =  $this->input->post('warranty');
            $installation =  $this->input->post('installation');
            $maintenance =  $this->input->post('maintenance');
            $checklist = $this->input->post('checklist');
            $component_category = $this->input->post('component_category');
			$company_id = $this->session->userdata("company_id");
            $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
                        $ins_array = array(
                				"component_name" => $component_name,
                				"component_des" => $component_des,
                				"supplier_id" => $supplier_id,
                				"component_uc" => $component_uc,
                				"component_uom" => $component_uom,
                				"specification" => $specification,
                				"warranty" => $warranty,
                				"installation" => $installation,
                				"maintenance" => $maintenance,
                				"component_category" => $component_category,
                				"image" => $filename,
                				"component_status" => $component_status,
                				"user_id" => $created_by,
                				"company_id" => $company_id,
                				"created_by" => $created_by,
                                "ip_address" => $ip_address
		                	);
					
		    $add_new_component = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_component) {
			    if($checklist!=""){
			    $checklist_items = explode(",", rtrim($checklist, ","));
                        for($j=0;$j<count($checklist_items);$j++){
                            $checklist_array = array(
                               "component_id" => $add_new_component,
                               "checklist" => $checklist_items[$j],
                            );
                            
                            $this->mod_common->insert_into_table('project_component_checklists', $checklist_array);
                        }
			    }
				$this->session->set_flashdata('ok_message', 'New Component added successfully.');
				redirect(SURL . 'manage/components');
			} else {
				$this->session->set_flashdata('err_message', 'New Component is not added. Something went wrong, please try again.');
				redirect(SURL . 'manage/components');
			}
		}
    }
    
    //Edit Component Screen
    public function edit_component($component_id) {

        $this->mod_common->is_company_page_accessible(69);
		
	    if($component_id=="" || !(is_numeric($component_id))){
            redirect("nopage");
        }
		
        $table = "project_components";
        $where = "`component_id` ='" . $component_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['component_edit'] = $this->mod_common->select_single_records($table, $where);
        $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
        $data['categories'] = $this->mod_common->get_all_records("categories","*",0,0,array("status" => 1),"name");
    
        if (count($data['component_edit']) == 0) {
           $this->session->set_flashdata('err_message', 'Component does not exist.');
            redirect("manage/components");
        } else {
            $this->stencil->title("Edit Component");

            $this->stencil->paint('components/edit_component', $data);
        }
    }
    
    //Edit Component
    public function edit_component_process() {
		 
        $this->mod_common->is_company_page_accessible(71);
        
        if (!$this->input->post() && !$this->input->post('update_component'))
        
        redirect(SURL."manage/components");
        
		$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
		$this->form_validation->set_rules('component_uc', 'Unit Cost', 'required');
		$this->form_validation->set_rules('component_uom', 'Unit of Mesure', 'required');
		
		$component_id = $this->input->post('component_id');
		
        $table = "project_components";
	    $where = "`component_id` ='" . $component_id."'";

	    $data['component_edit'] = $this->mod_common->select_single_records($table, $where);
	    
	    $original_value = $data['component_edit']['component_name'];
		
        if($this->input->post('component_name') != $original_value) {
            $is_unique =  '|is_unique[components.component_name]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('component_name', 'Component Name', 'required');
		
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
                $this->stencil->title('Edit Component');
                $this->stencil->paint('components/edit_component', $data);
			}
		else{
		    
		    $filename= "";

			if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
						
						$ext_file_name="./assets/components/".$data['component_edit']['image'];
						if(file_exists($ext_file_name)){
							unlink($ext_file_name);
						}
						$thumb_file_name="./assets/components/thumbnail/".$data['component_edit']['image'];
						if(file_exists($thumb_file_name)){
							unlink($thumb_file_name);
						}
						
						$projects_folder_path = './assets/components/';
						$projects_folder_path_main = './assets/components/';

						$thumb = $projects_folder_path_main . 'thumbnail';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('image')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							
							print_r($error_file_arr);exit;
							
						} else {
                            
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
					}
					else{
					    $filename = $this->input->post("old_image");
					}
			$table = "components";
					
			$component_name = $this->input->post('component_name');
			$component_des = $this->input->post('component_des');
			$supplier_id = $this->input->post('supplier_id');
			$component_uc = $this->input->post('component_uc');
			$component_uom = $this->input->post('component_uom');
			$specification =  $this->input->post('specification');
            $warranty =  $this->input->post('warranty');
            $installation =  $this->input->post('installation');
            $maintenance =  $this->input->post('maintenance');
            $checklist = $this->input->post('checklist');
            $component_category = $this->input->post('component_category');
			$component_status = $this->input->post('component_status');
            $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
                				"component_name" => $component_name,
                				"component_des" => $component_des,
                				"supplier_id" => $supplier_id,
                				"component_uc" => $component_uc,
                				"component_uom" => $component_uom,
                				"specification" => $specification,
                				"warranty" => $warranty,
                				"installation" => $installation,
                				"maintenance" => $maintenance,
                				"component_category" => $component_category,
                				"image" => $filename,
                				"component_status" => $component_status,
                                "ip_address" => $ip_address
		                	);
					
		    $update_component = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_component) {
			    $this->mod_common->delete_record('project_component_checklists', array("component_id" => $component_id));
			    if($checklist!=""){
			    $checklist_items = explode(",", rtrim($checklist, ","));
			    
                        for($j=0;$j<count($checklist_items);$j++){
                            $checklist_array = array(
                               "component_id" => $component_id,
                               "checklist" => $checklist_items[$j],
                            );
                            
                            $this->mod_common->insert_into_table('project_component_checklists', $checklist_array);
                        }
			    }
				$this->session->set_flashdata('ok_message', 'Component updated successfully.');
				redirect(SURL . 'manage/components');
			} else {
				$this->session->set_flashdata('err_message', 'Component is not updated. Something went wrong, please try again.');
				redirect(SURL . 'manage/components');
			}
		}
    }
    
    //Delete Component
    public function delete_component() {
  
        $this->mod_common->is_company_page_accessible(72);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
        
        $this->mod_common->update_table("project_supplierz_tpl_component_part", array("component_id" => $id), array("tpl_part_component_uom" => "", "tpl_part_component_uc" => ""));
        $this->mod_common->delete_record('project_price_book_components', array("component_id" => $id));
        $this->mod_common->update_table("project_tpl_component_part", array("component_id" => $id), array("tpl_part_component_uom" => "", "tpl_part_component_uc" => ""));

		
	    $table = "components";
        $where = "`component_id` ='" . $id . "'";
        
        $component_info = $this->mod_common->delete_record($table, $where);
        
        $file_name="./assets/components/".$component_info['image'];
        $thumb_file_name="./assets/components/thumbnail/".$file_info['image'];

        if(file_exists($file_name)){
    	     unlink($file_name);
         }
         
         if(file_exists($thumb_file_name)){
    	     unlink($thumb_file_name);
         }
		
        $delete_project = $this->mod_common->delete_record($table, $where);

    }
    
    //Verify Component
    public function verify_component() {

        $component_name = $this->input->post("name");
        $supplier_id = $this->input->post("supplier_id");
        
        $table = "project_components";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'component_id !=' => $id,
            'component_name' => $component_name,
            'supplier_id' => $supplier_id,
            "company_id" => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'component_name' => $component_name,
            'supplier_id' => $supplier_id,
            "company_id" => $this->session->userdata('company_id')
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    //Add Component From CSV File
    public function add_component_from_csv() {        
        
        $this->mod_common->is_company_page_accessible(70);
        $file = $_FILES['importcsv']['tmp_name'];
        $handle = fopen($file, "r");
        
        $allowed = array('csv');
        $filename = $_FILES['importcsv']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $this->session->set_flashdata('err_message', 'Only CSV files are allowed.');
            redirect(SURL.'manage/add_component');  
        }
                
        $data = array();
        $k = 0;
        
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        while ($data = fgetcsv($handle, 1000, ",", "'")) {
            if ($k > 0) {
                if(count($data)>5 || count($data)<5){
                    $this->session->set_flashdata('err_message', 'File format is wrong. Please upload correct file.');
                    redirect(SURL.'manage/add_component');
                }
                $component = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'component_name' => $data[0],
                    'component_des' => $data[1],
                    'component_uom' => $data[2],
                    'component_uc' => $data[3],
                    'supplier_id' => $this->input->post("component_supplier_id"),
                    'component_status' => $data[4],
                    'created_by' => $this->session->userdata('user_id'),
                    'ip_address' => $ip_address,
                    'company_id' => $this->session->userdata('company_id'),
                );

                $existing_component = $this->mod_common->select_single_records('project_components', array('company_id' => $this->session->userdata('company_id'), 'component_name' => $data[0], 'supplier_id' => $this->input->post("component_supplier_id")));
                
                if (count($existing_component) > 0) {
                    $data = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'component_name' => $data[0],
                        'component_des' => $data[1],
                        'component_uom' => $data[2],
                        'component_uc' => $data[3],
                        'supplier_id' => $this->input->post("component_supplier_id"),
                        'component_status' => $data[4],
                        'company_id' => $this->session->userdata('company_id'),
                    );
                    $where = array('component_id' => $existing_component['component_id']);
                    $this->mod_common->update_table('project_components',$where,$data);
                }
                else {
                    $add_component = $this->mod_common->insert_into_table('project_components', $component);
                    if ($add_component) {
                      
                    }
                }
            }
            $k++;
        }
         $this->session->set_flashdata('ok_message', 'Components added successfully.');
         redirect(SURL . 'manage/components');
    }
    
    //Add Component VIA Shortcut
    public function addcomponentbyquicklink() {
            $this->mod_common->is_company_page_accessible(69);
            $where = array('component_name' => $this->input->post('component_name'), 'supplier_id' => $this->input->post('supplier_id'));
            $is_already_exists = $this->mod_common->select_single_records('project_components', $where);
            if(count($is_already_exists)==0){
            $filename = "";

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
						
						$projects_folder_path = './assets/components/';
						$projects_folder_path_main = './assets/components/';

						$thumb = $projects_folder_path_main . 'thumbnail';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('image')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							
							print_r($error_file_arr);exit;
							
						} else {
                            
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
					}
            
            $component = array(
                'user_id' => $this->session->userdata('user_id'),
                'company_id' => $this->session->userdata('company_id'),
                'component_name' => $this->input->post('component_name'),
                'component_des' => "",
                'component_uom' => $this->input->post('component_uom'),
                'component_uc' => $this->input->post('component_uc'),
                'supplier_id' => $this->input->post('supplier_id'),
                'component_status' => 1,
                'image' => $filename
            );
            
            $addnewcomponent = $this->mod_common->insert_into_table('project_components', $component);
            
            if ($addnewcomponent) {
                 
            }
            else{
                echo "error";
            }
        }
        else{
            echo "Component Already exists";
        }
            
    }
    
    //Add New Client VIA Shortcut
    public function add_new_client(){
    	    	$ins_array = array(
    		'user_id' 						=>	$this->session->userdata('user_id'),
    		'company_id' 					=>	$this->session->userdata('company_id'),
    		'client_fname1'					=>	$this->input->post('client_fname1'),
    		'client_fname2'					=>	$this->input->post('client_fname2'),
    		'client_surname1'				=>	$this->input->post('client_surname1'),
    		'client_surname2'				=>	$this->input->post('client_surname2'),
    		'client_homephone_primary'		=>	$this->input->post('client_homephone_primary'),
    		'client_homephone_secondary'	=>	$this->input->post('client_homephone_secondary'),
    		'client_workphone_primary'		=>	$this->input->post('client_workphone_primary'),
    		'client_workphone_secondary'	=>	$this->input->post('client_workphone_secondary'),
    		'client_mobilephone_primary'	=>	$this->input->post('client_mobilephone_primary'),
    		'client_mobilephone_secondary'	=>	$this->input->post('client_mobilephone_secondary'),
    		'client_email_primary'			=>	$this->input->post('client_email_primary'),
    		'client_email_secondary'		=>	$this->input->post('client_email_secondary'),
    		'client_city'					=>	$this->input->post('client_city'),
    		'state'							=>	$this->input->post('state'),
    		'country'						=>	$this->input->post('country'),
    		'client_postal_city'			=>	$this->input->post('client_postal_city'),
    		'pstate'						=>	$this->input->post('pstate'),
    		'pcountry'						=>	$this->input->post('pcountry'),
    		'client_zip'					=>	$this->input->post('client_zip'),
    		'client_postal_zip'				=>	$this->input->post('client_postal_zip'),
    		'client_note'					=>	$this->input->post('client_note'),
    		'client_status'					=>	$this->input->post('client_status'),
    		'post_street_pobox'				=> 	$this->input->post('post_street_pobox'),
    		'post_suburb'					=> 	$this->input->post('post_suburb'),
    		'street_pobox'					=>	$this->input->post('street_pobox'),
    		'suburb'						=>	$this->input->post('suburb')
		);
		
		$addclient = $this->mod_common->insert_into_table('project_clients', $ins_array);
			
	    $where 			= array('company_id' => $this->session->userdata('company_id'));
		$clients = $this->mod_common->get_all_records('project_clients', "*", 0, 0, $where, "client_id");
	    
	    $html ='<option value="" >Select Client</option>';
            foreach ($clients as $client) { 
                $html.='<option value="'.$client["client_id"].'">'.$client["client_fname1"].' '.$client["client_surname1"].' '.$client["client_fname2"].' '.$client["client_surname2"].'</option>';
           } 
        echo $html;
	    
	}
	
	//Upload Document
	public function upload_document(){
       $type = $this->input->post("document_type");
       $filename= "";

       if (isset($_FILES[$type.'_file']['name']) && $_FILES[$type.'_file']['name'] != "") {
						
						$projects_folder_path = './assets/component_documents/'.$type;
						$projects_folder_path_main = './assets/component_documents/'.$type;

						$thumb = $projects_folder_path_main . 'thumb';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = false;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload($type.'_file')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							print_r($error_file_arr);exit;
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
                            
							
						}
					}
	                    
       echo $filename;

    }
    
    //Remove Document
    public function remove_file(){

     $file = $this->input->post("filename");
     $type = $this->input->post("type");
     if(is_numeric($file)){
        $where = array('component_id' => $file);
        $file_info = $this->mod_common->get_all_records('project_components', "*", 0, 0, $where, "component_id");
        $this->mod_common->update_table('project_components', $where, array($type => ""));
        $file_name="./assets/component_documents/".$type."/".$file_info[$type];
     }
     else{
         $file_name="./assets/component_documents/".$type."/".$file;
     }
     
        if(file_exists($file_name)){
    	   unlink($file_name);
        }
    
    }
    
    //Remove Checklist
    public function remove_checklist(){
        $id = $this->input->post("id");
        $this->mod_common->delete_record('project_component_checklists', array("id" => $id));
    }
    
    /***************Components Section Ends Here*********************/
}
