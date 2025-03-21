<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

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
             $this->load->model("mod_project");
             $this->load->model("mod_template");
             $this->load->model("mod_roles");
             $this->load->model("mod_price_book");

             $this->mod_common->verify_is_user_login();

        }
        
    /*************Stages Section Starts Here****************/
        
    //Get All Stages 
	public function stages()
	{
	    $this->mod_common->is_company_page_accessible(73);
        $data['stages'] = $this->mod_common->get_all_records("stages","*",0,0,array("company_id" => $this->session->userdata("company_id")),"stage_id");
        $this->stencil->title('Stages');
	    $this->stencil->paint('stages/manage_stages', $data);
	}
    
    //Add New Stage Screen
	public function add_stage() {

        $this->mod_common->is_company_page_accessible(75);
        $this->stencil->title('Add Stage');
        $this->stencil->paint('stages/add_new_stage');
    }
    
    //Add New Stage 
	public function add_new_stage_process() {
		 
        $this->mod_common->is_company_page_accessible(75);
		$this->form_validation->set_rules('name', 'Stage Name', 'required');
		$this->form_validation->set_rules('description', 'Stage Description', 'required');
	    if ($this->form_validation->run() == FALSE)
			{
			    $this->stencil->title('Add Stage');
                $this->stencil->paint('stages/add_new_stage');
			}
		else{
			$table = "stages";
					
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$stage_status = $this->input->post('stage_status');
            $created_by = $this->session->userdata("user_id");
            $user_id = $this->session->userdata("user_id");
            $company_id = $this->session->userdata("company_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
            				"stage_name" => $name,
            				"stage_description" => $description,
            				"created_by" => $created_by,
            				"user_id" => $user_id,
            				"company_id" => $company_id,
                            "ip_address" => $ip_address,
            				"stage_status" => $stage_status
            			);
					
		        $add_new_stage = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_stage) {
				$this->session->set_flashdata('ok_message', 'New Stage added successfully.');
				redirect(SURL . 'setup/stages');
			} else {

				$this->session->set_flashdata('err_message', 'New Stage is not added. Something went wrong, please try again.');

				redirect(SURL . 'setup/stages');
			}
		}
    }
    
    //Edit Stage Screen
	public function edit_stage($stage_id) {

    $this->mod_common->is_company_page_accessible(74);
		
	if($stage_id=="" || !(is_numeric($stage_id))){
            redirect("nopage");
        }
		
        $table = "project_stages";
        $where = "`stage_id` ='" . $stage_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['stage_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['stage_edit']) == 0) {
            $this->session->set_flashdata('err_message', 'Stage does not exist.');
            redirect(SURL . 'setup/stages');
        } else {
            $this->stencil->title("Edit Stage");

            $this->stencil->paint('stages/edit_stage', $data);
        }
    }
    
    //Update Stage 
    public function edit_stage_process() {
		
        
        $this->mod_common->is_company_page_accessible(76);
        
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_stage'))
        redirect(SURL."setup/stages");
        
	    $this->form_validation->set_rules('description', 'Stage Description', 'required');
	    $stage_id = $this->input->post('stage_id');
		
        $table = "project_stages";
	    $where = "`stage_id` ='" . $stage_id."'";

	    $data['stage_edit'] = $this->mod_common->select_single_records($table, $where);
		
        $original_value = $data['stage_edit']['stage_name'];
		
        if($this->input->post('name') != $original_value) {
            $is_unique =  '|is_unique[stages.stage_name]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('name', 'Stage Name', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Stage");
           $this->stencil->paint('stages/edit_stage', $data);
		    
		}
		
		else{	
			$table = "stages";
					
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$stage_status = $this->input->post('stage_status');
			$created_by = $this->session->userdata("user_id");
			$company_id = $this->session->userdata("company_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
					        "stage_name" => $name,
			                "stage_description" => $description,
			                "stage_status" => $stage_status,
                            "ip_address" => $ip_address
			);
                                                        
							
			$table = "stages";
			$where = "`stage_id` ='" . $stage_id . "'";
			$update_stage = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_stage) {
				$this->session->set_flashdata('ok_message', 'Stage updated successfully.');
				redirect(SURL . 'setup/stages');
			} else {
				$this->session->set_flashdata('err_message', 'Stage is not updated. Something went wrong, please try again.');
				redirect(SURL . 'setup/edit_stage/' . $stage_id);
			}
		}
    }
	
	//Delete Stage
	public function delete_stage() {
  
        
		$this->mod_common->is_company_page_accessible(77);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "stages";
        $where = "`stage_id` ='" . $id . "'";
		
        $delete_stage = $this->mod_common->delete_record($table, $where);

    }
	
	//Verify Stage
    public function verify_stage() {

        $name = $this->input->post("name");
        
        $table = "project_stages";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'stage_id !=' => $id,
            'stage_name' => $name,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'stage_name' => $name,
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
    
    /*************Stages Section Ends Here****************/
    
    /*************Takeoffdata Section Starts Here****************/
    
    
    //Get All Takeoffdata
    public function takeoffdata()
	{
	    $this->mod_common->is_company_page_accessible(78);
        $data['takeoffdata'] = $this->mod_common->get_all_records("takeoffdata","*",0,0,array("company_id" => $this->session->userdata("company_id")),"takeof_id");
        $this->stencil->title('Take off Data');
	    $this->stencil->paint('takeoffdata/manage_takeoffdata', $data);
	}
    
    //Add Takeoffdata Screen
	public function add_takeoffdata() {
        $this->mod_common->is_company_page_accessible(80);
        $this->stencil->title('Add Take off Data');
        $this->stencil->paint('takeoffdata/add_new_takeoffdata');
    }
    
    //Add New Takeoffdata
	public function add_new_takeoffdata_process() {
        $this->mod_common->is_company_page_accessible(80);
		$this->form_validation->set_rules('name', 'Take off Data Name', 'required');
	    if ($this->form_validation->run() == FALSE)
			{
			    $this->stencil->title('Add Take off Data');
                $this->stencil->paint('takeoffdata/add_new_takeoffdata');
			}
		else{
			$table = "takeoffdata";
					
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$takeoff_status = $this->input->post('takeof_status');
            $created_by = $this->session->userdata("user_id");
            $user_id = $this->session->userdata("user_id");
            $company_id = $this->session->userdata("company_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
            				"takeof_name" => $name,
            				"takeof_des" => $description,
            				"created_by" => $created_by,
            				"user_id" => $user_id,
            				"company_id" => $company_id,
                            "ip_address" => $ip_address,
            				"takeof_status" => $takeoff_status
            			);
					
		        $add_new_takeoffdata = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_takeoffdata) {
				$this->session->set_flashdata('ok_message', 'New Take off Data added successfully.');
				redirect(SURL . 'setup/takeoffdata');
			} else {

				$this->session->set_flashdata('err_message', 'New Take off Data is not added. Something went wrong, please try again.');

				redirect(SURL . 'setup/takeoffdata');
			}
		}
    }
	
	//Edit Takeoffdata Screen
	public function edit_takeoffdata($takeof_id) {

    $this->mod_common->is_company_page_accessible(79);
		
	if($takeof_id=="" || !(is_numeric($takeof_id))){
            redirect("nopage");
        }
		
        $table = "project_takeoffdata";
        $where = "`takeof_id` ='" . $takeof_id."' AND company_id = ".$this->session->userdata("company_id");


        $data['takeoffdata_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['takeoffdata_edit']) == 0) {
            $this->session->set_flashdata('err_message', 'Takeoffdata does not exist.');
            redirect(SURL . 'setup/takeoffdata');
        } else {
            $this->stencil->title("Edit Take off Data");

            $this->stencil->paint('takeoffdata/edit_takeoffdata', $data);
        }
    }

    //Update Takeoffdata
    public function edit_takeoffdata_process() {
        
        $this->mod_common->is_company_page_accessible(81);
        
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_takeoffdata'))
        redirect(SURL."setup/takeoffdata");
        
	    $takeof_id = $this->input->post('takeof_id');
		
        $table = "project_takeoffdata";
	    $where = "`takeof_id` ='" . $takeof_id."'";

	    $data['takeoffdata_edit'] = $this->mod_common->select_single_records($table, $where);
		
            $original_value = $data['takeoffdata_edit']['takeof_name'];
		
        if($this->input->post('name') != $original_value) {
            $is_unique =  '|is_unique[takeoffdata.takeof_name]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('name', 'Take off Data Name', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Take off Data");
           $this->stencil->paint('takeoffdata/edit_takeoffdata', $data);
		    
		}
		
		else{	
			$table = "takeoffdata";
					
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$takeoff_status = $this->input->post('takeof_status');
			$created_by = $this->session->userdata("user_id");
			$company_id = $this->session->userdata("company_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];

                        $upd_array = array(
					        "takeof_name" => $name,
			                "takeof_des" => $description,
			                "takeof_status" => $takeoff_status,
                            "ip_address" => $ip_address
			);
                                                        
							
			$table = "takeoffdata";
			$where = "`takeof_id` ='" . $takeof_id . "'";
			$update_takeoffdata = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_takeoffdata) {
				$this->session->set_flashdata('ok_message', 'Take off Data updated successfully.');
				redirect(SURL . 'setup/takeoffdata');
			} else {
				$this->session->set_flashdata('err_message', 'Take off Data is not updated. Something went wrong, please try again.');
				redirect(SURL . 'setup/edit_takeoffdata/' . $stage_id);
			}
		}
    }
	
	//Delete Takeoffdata
	public function delete_takeoffdata() {
  
		$this->mod_common->is_company_page_accessible(82);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "takeoffdata";
        $where = "`takeof_id` ='" . $id . "'";
		
        $delete_stage = $this->mod_common->delete_record($table, $where);

    }
	
	//Verify Takeoffdata
    public function verify_takeoffdata() {

        $name = $this->input->post("name");
        
        $table = "project_takeoffdata";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'takeof_id !=' => $id,
            'takeof_name' => $name,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'takeof_name' => $name,
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
    
    /********************Takeoffdata Section Starts Here**************************/
    
    /********************Templates Section Starts Here**************************/
    
    //Get All Templates
    public function templates()
	{
	    $this->mod_common->is_company_page_accessible(83);
        $data['templates'] = $this->mod_common->get_all_records("templates","*",0,0,array("company_id" => $this->session->userdata("company_id")),"template_id");
        $this->stencil->title('Templates');
	    $this->stencil->paint('templates/manage_templates', $data);
	}
    
    //Add Template Screen
    public function add_template() {
        
        $this->mod_common->is_company_page_accessible(85);
        $this->stencil->title('Add Template');
        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
        $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
        $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
        $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
        $data["extprojects"] = $this->mod_project->get_existing_project();
        
        //Get Supplierz Templates
        $data['supplier_users'] = get_supplier_users();
		$suppliers_user_list = "";
		foreach($data['supplier_users'] as $val){
		    $suppliers_user_list .= $val['user_id'].",";
		}
		$suppliers_user_list = rtrim($suppliers_user_list, ",");

		if($suppliers_user_list!=""){
		$query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id WHERE st.supplier_id IN (".$suppliers_user_list.
		") AND st.template_status=1 GROUP BY template_id");

		$data['supplierzTemplates'] = $query->result();
		}
		else{
		   	$data['supplierzTemplates'] = array(); 
		}
		
        $this->stencil->paint('templates/add_template', $data);
    }
    
    //Add New Item
    public function populate_new_template_row() {
    
		$data['next_row'] = isset($_POST['next_row']) ? $_POST['next_row'] : 0;
		
		$cwhere 			= array('company_id' => $this->session->userdata('company_id'),'component_status' => 1);
		$data['components'] = $this->mod_common->get_all_records('components', "*", 0, 0, $cwhere, 'component_id');
		
		$cwhere 			= array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1);
		$fields 		= '`stage_id`, `user_id`, `stage_name`';
		$data['stages'] = $this->mod_common->get_all_records('stages', $fields, 0, 0, $cwhere, 'stage_id');
		
		$fields = '`supplier_id`, `user_id`, `supplier_name`';
		$cwhere 			= array('supplier_status' => 1);
		$data['suppliers'] = $this->mod_common->get_all_records('suppliers', $fields, 0, 0, $cwhere, 'supplier_id');
		
		$cwhere = array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1);
		$fields = '`takeof_id`, `user_id`, `takeof_name`';
		$data['takeoffdatas'] = $this->mod_common->get_all_records('takeoffdata', $fields, 0, 0, $cwhere, 'takeof_id');

		$html = $this->load->view('templates/add_part', $data, true);
		
		echo $html;
	}
	
	//Add New Template 
	public function add_new_template_process(){
	    
	    $this->mod_common->is_company_page_accessible(85);
	    $this->form_validation->set_rules('template_name', 'Template Name', 'required');
		$this->form_validation->set_rules('template_desc', 'Template Description', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $this->stencil->title('Add Template');
                $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
                $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
                $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
                $data["templates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
                $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
                
                //Get Supplierz Templates
                $data['supplier_users'] = get_supplier_users();
        		$suppliers_user_list = "";
        		foreach($data['supplier_users'] as $val){
        		    $suppliers_user_list .= $val['user_id'].",";
        		}
        		$suppliers_user_list = rtrim($suppliers_user_list, ",");
        		if($suppliers_user_list!=""){
        		$query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id WHERE st.supplier_id IN (".$suppliers_user_list.
        		") AND st.template_status=1 GROUP BY template_id");
        		$data['supplierzTemplates'] = $query->result();
        		}
        		else{
        		   	$data['supplierzTemplates'] = array(); 
        		}
        		
                $this->stencil->paint('templates/add_template', $data);
			}
		else{
		    
    	    $ins_array = array(
    			'user_id'	=>	$this->session->userdata('user_id'),
    			'company_id' =>	$this->session->userdata('company_id'),
    			'template_name'	=>	$this->input->post('template_name'),
    			'template_desc'	=>	$this->input->post('template_desc'),
    			'quantity'		=>	0,
    			'template_status' =>	$this->input->post('template_status')
    		);
    		
    		$addtemplate = $this->mod_common->insert_into_table('templates',$ins_array);
    		
    		            $part	= '';
    					$q =1;
    					$stagecount	    = $this->input->post('stagecount');
    					$part_name	    = array_values($this->input->post('part_name'));
    					$component_uom	= array_values($this->input->post('component_uom'));
    					$component_uc	= array_values($this->input->post('component_uc'));
    					$component_id	= array_values($this->input->post('component_id'));
    					$supplier_id	= array_values($this->input->post('supplier_id'));
    					$quantity		= array_values($this->input->post('manualqty'));
    					$formula		= array_values($this->input->post('formula'));
    					$quantity_type  = array_values($this->input->post('quantity_type'));
    					$formulaqty		= array_values($this->input->post('formulaqty'));
    					$formulatext	= array_values($this->input->post('formulatext'));
    					$is_rounded	    = array_values($this->input->post('is_rounded'));
    					$component_type = array_values($this->input->post('component_type'));
    					$stage_id	    = count($this->input->post('stage_id'));
    					$gstage_id	    = array_values($this->input->post('stage_id'));
    					$ip_address = $_SERVER['REMOTE_ADDR'];
    					
    					for($i=0;$i<$stage_id;$i++){
    						$s = $i+1;
    						if(isset($gstage_id[$i])){
    						if(isset($quantity[$i]) && trim($quantity[$i])==''){
    							$quantity[$i]=0;
    						}
    						$part_stage_id = $gstage_id[$i];
    						$part_supplier_id = $supplier_id[$i];
    						$part_component_id = $component_id[$i];
    						$imported_formula = $formula[$i];
    							
    						if($component_type[$i]==-1){
                                //Adding New Stage if not exists
                                $stage = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'stage_name' => $gstage_id[$i],
                                    'stage_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_stage = $this->mod_common->select_single_records('project_stages', array('company_id' => $this->session->userdata('company_id'), 'stage_name' => $gstage_id[$i]));
                                
                                if (count($existing_stage) == 0) {
                                     $part_stage_id = $this->mod_common->insert_into_table('project_stages', $stage);
                                }
                                else{
                                    $part_stage_id = $existing_stage["stage_id"];
                                }
                                
                                //Adding New Supplier if not exists
                                $supplier = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'supplier_name' => $supplier_id[$i],
                                    'supplier_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_supplier = $this->mod_common->select_single_records('project_suppliers', array('company_id' => $this->session->userdata('company_id'), 'supplier_name' => $supplier_id[$i]));
                                
                                if (count($existing_supplier) == 0) {
                                     $part_supplier_id = $this->mod_common->insert_into_table('project_suppliers', $supplier);
                                }
                                else{
                                    $part_supplier_id = $existing_supplier["supplier_id"];
                                }
                                
                                
                                //Adding New Component if not exists
                                $component = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'component_name' => $component_id[$i],
                                    'component_des' => "",
                                    'component_uom' => $component_uom[$i],
                                    'component_uc' => $component_uc[$i],
                                    'supplier_id' => $part_supplier_id,
                                    'component_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_component = $this->mod_common->select_single_records('project_components', array('company_id' => $this->session->userdata('company_id'), 'component_name' => $component_id[$i]));
                                
                                if (count($existing_component) == 0) {
                                     $part_component_id = $this->mod_common->insert_into_table('project_components', $component);
                                }
                                else{
                                    $part_component_id = $existing_component["component_id"];
                                }
                            }
                            
                            else if($component_type[$i]==2){
                                    //Adding New Supplier If Not Exists
                                    
                                    $supplier_user_id = $supplier_id[$i];
               
                                    $where = "parent_supplier_id = '".$supplier_user_id."' AND company_id = ".$this->session->userdata('company_id');
               
                                    $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);
                                   
                                    if(count($data['supplier_info'])==0){
                            
                                        $where = "user_id = '".$supplier_user_id."'";
                                   
                                        $supplier_user_info = $this->mod_common->select_single_records('project_users', $where);
                               
                                        $supplier_detail = array(
                                                'user_id' => $this->session->userdata('user_id'),
                                                'company_id' => $this->session->userdata('company_id'),
                                                'parent_supplier_id' => $supplier_user_id,
                                                'supplier_name' => $supplier_user_info['com_name'],
                                                'supplier_status' => 1,
                                                'supplier_city' => "",
                                                'supplier_postal_city' => "",
                                                'supplier_zip' => "",
                                                'supplier_postal_zip' => "",
                                                'post_street_pobox' => "",
                                                'post_suburb' => "",
                                                'street_pobox' => "",
                                                'supplier_country' => "",
                                                'supplier_postal_country' => "",
                                                'suburb' => "",
                                                'supplier_email' => $supplier_user_info['user_email'],
                                                'supplier_phone' => "",
                                                'supplier_web' => "",
                                                'supplier_state' => "",
                                                'supplier_postal_state' =>"",
                                                'supplier_contact_person' => "",
                                                'supplier_contact_person_mobile' => ""
                                            );
                                       
                                        $this->mod_common->insert_into_table('project_suppliers', $supplier_detail);
                                        $part_supplier_id = $this->db->insert_id();
                                    }
                                    else{
                                        $part_supplier_id = $data['supplier_info']['supplier_id'];
                                    }
                                    
                                    //Substitution of Takeoffdata
    				    
                				    if($quantity_type[$i] == "formula"){
                				        preg_match_all('/\|\d+/', $formula[$i], $takeoffdata_id);
                				        if(isset($takeoffdata_id[1])){
                        				    $take_of_data_list = $takeoffdata_id[1];
                        				    if(count($take_of_data_list)>0){
                            				    for($j=0;$j<count($take_of_data_list);$j++){
                            				        $takeoffdata_info = $this->mod_common->select_single_records('project_takeoffdata',$fields = false,array("takeof_id" => $take_of_data_list[$j]));
                            				        $takeoffdata_name = $takeoffdata_info["takeof_name"];
                            				        $is_takeoffdata_exist = $this->mod_common->select_single_records('project_takeoffdata',$fields = false,array("takeof_name" => $takeoffdata_name, "company_id"=> $this->session->userdata('company_id')));
                            				        if(count($is_takeoffdata_exist)>0){
                            				            $imported_formula = str_replace("|".$take_of_data_list[$j], "|".$is_takeoffdata_exist["takeof_id"], $imported_formula);
                            				        }
                            				        else{
                            				            $takeoffdata_ins = array(
                            				                    "takeof_name" => $takeoffdata_info["takeof_name"],
                            				                    "takeof_des" => $takeoffdata_info["takeof_des"],
                            				                    "takeof_uom" => $takeoffdata_info["takeof_uom"],
                            				                    "takeof_m" => $takeoffdata_info["takeof_m"],
                            				                    "project_id" => 0,
                            				                    "takeof_status" => 1,
                            				                    "user_id"	  =>	$this->session->userdata('user_id'),
                        						                "company_id"  =>	$this->session->userdata('company_id')
                            				                    
                            				                );
                            				                
                            				            $new_takeoffdata = $this->mod_common->insert_into_table('project_takeoffdata',$takeoffdata_ins);
                            				            
                            				            $imported_formula = str_replace("|".$take_of_data_list[$j], "|".$new_takeoffdata, $imported_formula);
                            				        }
                            				        
                            				    }
                        				    }
                				        }
                				    }   
                				    
                				    // Substitution of components
    				                $component_info = $this->mod_common->select_single_records('project_price_book_components', array("id" => $component_id[$i]));
            				           
            				        $is_component_exist = $this->mod_common->select_single_records('project_components', array("parent_component_id" => $component_info["component_id"], "company_id"=> $this->session->userdata('company_id')));
            				       
            				        if(count($is_component_exist)>0){
            				            $part_component_id = $is_component_exist["component_id"];
            				        }
            				        else{
            				            $component_ins = array(
            				                    'parent_component_id' => $component_info["component_id"],
                                                'component_name' => $component_info["component_name"],
                                                'component_des' => $component_info["component_des"],
                                                'component_uom' => $component_info["component_uom"],
                                                'component_uc' => $component_info["component_sale_price"],
                                                'supplier_id' => $part_supplier_id,
                                                'component_status' => 1,
                                                'image' => $component_info["image"],
            				                    "user_id"	  =>	$this->session->userdata('user_id'),
        						                "company_id"  =>	$this->session->userdata('company_id')
            				                    
            				                );
            				                
            				            $new_component_id = $this->mod_common->insert_into_table('project_components',$component_ins);
            				            
            				            if($component_info["image"]!=""){
                                            copy('assets/price_books/'.$component_info["image"], 'assets/components/'.$component_info["image"]);
                                            copy('assets/price_books/'.$component_info["image"], 'assets/components/thumbnail/'.$component_info["image"]);
            				            }
                                        
            				            
            				            $part_component_id = $new_component_id;
            				        }
        				        
            				       // Substitution of stage
        				            
            				        $is_stage_exist = $this->mod_common->select_single_records('project_stages', array("stage_name" => $gstage_id[$i], "company_id"=> $this->session->userdata('company_id')));
            				        if(count($is_stage_exist)>0){
            				            $part_stage_id = $is_stage_exist["stage_id"];
            				        }
            				        else{
            				            $created_by = $this->session->userdata("user_id");
                                        $ip_address = $_SERVER['REMOTE_ADDR'];
                                        
            				            $stage_ins = array(
                                                'stage_name' => $gstage_id[$i],
                                                'stage_description' => '',
                                                'stage_status' => 1,
            				                    "user_id"	  =>	$this->session->userdata('user_id'),
        						                "company_id"  =>	$this->session->userdata('company_id'),
        						                "ip_address" => $ip_address,
        						                "created_by" => $created_by
            				                );
            				                
            				            $new_stage_id = $this->mod_common->insert_into_table('project_stages', $stage_ins);
            				            
            				            
            				            $part_stage_id = $new_stage_id;
            				        }
                                }
    
    						$part = array(
    							'temp_id'							=>	$addtemplate,
    							'stage_id'							=>	$part_stage_id,
    							'user_id'							=>	$this->session->userdata('user_id'),
    							'company_id'						=>	$this->session->userdata('company_id'),
    							'component_id'						=>	$part_component_id,
    							'tpl_part_name'						=>	$part_name[$i],
    							'tpl_part_component_uom'			=>	$component_uom[$i],
    							'tpl_part_component_uc'				=>	$component_uc[$i],
    							'tpl_part_supplier_id'				=>	$part_supplier_id,
    							'tpl_quantity'						=>	$quantity[$i],
    							'tpl_quantity_type'					=>	$quantity_type[$i],
    							'tpl_quantity_formula'				=>	$imported_formula,
    							'is_rounded'			        	=>	$is_rounded[$i],
    							'quantity_formula_text'				=>	$formulatext[$i],
    							'tpl_part_status'					=>	1
    						);			
    
    						$part = $this->mod_common->insert_into_table('tpl_component_part',$part);	

    						}
    					}
    					
    			$this->session->set_flashdata('ok_message', 'New Template added successfully.');
    			redirect(SURL . 'setup/templates');
		}
	}
	
	//Get Supplier Information By Component
	function getcompnent() {
        
        $cwhere = array('component_id' => $this->input->post('value'));
        $data['components'] = $this->mod_common->select_single_records('project_components', $cwhere);
        
        
        $swhere = array('supplier_id' => $data['components']["supplier_id"]);

        $data['suppliers'] = $this->mod_common->select_single_records('project_suppliers', $swhere);
        
        $data['components']["supplier_name"] = $data['suppliers']["supplier_name"];
        
        echo json_encode($data['components']);
    }
    
    function getSupplierzCompnent() {
        
        $cwhere = array('id' => $this->input->post('value'));
        $data['components'] = $this->mod_common->select_single_records('project_price_book_components', $cwhere);
        
        
        $swhere = array('supplier_id' => $data['components']["supplier_id"]);

        $data['suppliers'] = $this->mod_common->select_single_records('project_suppliers', $swhere);
        
        $data['components']["supplier_name"] = $data['suppliers']["supplier_name"];
        
        echo json_encode($data['components']);
    }
    
    //Verify Template
    public function verify_template() {

        $name = $this->input->post("name");
        
        $table = "project_templates";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'template_id !=' => $id,
            'template_name' => $name,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'template_name' => $name,
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
    
    //Verify Part
    public function verify_part() {

        $name = $this->input->post("name");
        
        $table = "project_tpl_component_part";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'tpl_part_id !=' => $id,
            'tpl_part_name' => $name,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'tpl_part_name' => $name,
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
    
    //Delete Template
    public function delete_template() {
  
        $this->mod_common->is_company_page_accessible(87);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "templates";
        $where = "`template_id` ='" . $id . "'";
		
        $delete_template = $this->mod_common->delete_record($table, $where);
        
        $table = "tpl_component_part";
        $where = "`temp_id` ='" . $id . "'";
		
        $delete_template_parts = $this->mod_common->delete_record($table, $where);

    }
    
    //Get Template by Template
    public function get_templating_by_template($id) {
        
		$data['next_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
		$todid = isset($_POST['todid']) ? $_POST['todid'] : "";

		if ($id > 0) {
		    
			$data['templates'] = $this->mod_template->get_template($id);			
			$data['template_id'] =$id;
			$data['tpl_stages'] = $this->mod_project->get_stages_by_tempid($id);
			$data['tparts'] = $this->mod_project->get_costing_parts_by_template_id($id);
			$data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
            $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
            $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
            $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
                


			$html = $this->load->view('templates/populate_templating_by_template', $data, true);

			$rArray = array("rData" => $html);
			echo json_encode($rArray);
		} else {

		}
	}
	
	//Get Template By Supplierz Template

	public function get_templating_by_supplierz_template($id) {
        
		$data['next_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
		$todid = isset($_POST['todid']) ? $_POST['todid'] : "";

		if ($id > 0) {
			$data['templates'] =  $this->mod_common->select_single_records('project_supplierz_templates', array("template_id" => $id));
			$data['template_id'] =$id;
			$data['tparts'] = $this->mod_project->get_costing_parts_by_supplierz_template_id($id);
			$data['is_supplierz_template'] = 1;

			$html = $this->load->view('templates/populate_templating_by_template', $data, true);

			$rArray = array("rData" => $html, "templateName" => $data['templates']['template_name'], "templateDesc" => $data['templates']['template_desc']);
			header('Content-Type: application/json');
			echo json_encode($rArray);
		} else {

		}
	}
	
	 //Get Previous Project costing
    public function get_previous_project_costing($id = 0) {
 
      $data['next_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
      $id = $this->input->post("id");
      if ($id > 0) {
        $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id);
        
        if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1);
        }   

        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, $cwhere, "stage_id");
        
        if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'component_status' => 1);
        }
        
        $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, $cwhere, "component_id");
        
        if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'supplier_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'supplier_status' => 1);
        }
        
        $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, $cwhere, "supplier_id");
        
        if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'takeof_status' => 1);
        }
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, $cwhere, "takeof_id");
    
        $html = $this->load->view('templates/populate_stages_by_project', $data, true);
        $rArray = array(
          "rData" => $html
        );
        echo json_encode($rArray);
        } else {
        
        }
}

    //Import components by CSV

	public function import_component_by_csv(){
	                    $file = $_FILES['importcsv']['tmp_name'];
                        $handle = fopen($file, "r");
                        
                        $allowed = array('csv');
                        $filename = $_FILES['importcsv']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            echo "Only CSV files are allowed.";exit;
                        }
                        
                                   
                        $data = array();
                        $k = 0;
                        $html = "";
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        $count = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
                        while ($data = fgetcsv($handle, 1000, ",", "'")) {
                            if ($k > 0) {
                                if(!isset($data[6])){
                                    echo "File format is wrong. Please upload correct file.";exit;
                                }
                                else{
                                    $html .= '<tr id="trnumber'.$count.'" tr_val="'.$count.'">
                                                           <input  name="component_type['.$count.']" rno ="'.$count.'" id="component_type'.$count.'" type="hidden"  class="form-control" value="-1" />
                                                           <td><input type="hidden" id="stagefield'.$count.'" name="stage_id['.$count.']" value="'.$data[0].'">'.$data[0].'</td>
                                                           <td><input type="hidden" name="part_name['.$count.']" value="'.$data[1].'">'.$data[1].'</td>
                                                           <td><input type="hidden" name="component_id['.$count.']" value="'.$data[2].'">'.$data[2].'</td>
                                                           <td><input type="hidden" name="component_uom['.$count.']" value="'.$data[3].'">'.$data[3].'</td>
                                                           <td><input type="hidden" name="component_uc['.$count.']" id="ucostfield'.$count.'" value="'.$data[4].'">'.$data[4].'</td>
                                                           <td><input type="hidden" name="supplier_id['.$count.']" value="'.$data[5].'">'.$data[5].'</td>
                                                           <td>
                                                                <select rno="'.$count.'" data-container="body" class="selectpicker costestimation" data-style="btn btn-warning btn-round" title="Choose Quantity Type" data-size="7" name="quantity_type['.$count.']" id="quantity_type'.$count.'" qtype_number="'.$count.'" required="true" onChange="changeQTYType(this);">
                                                                     <option value="manual" selected>Manual</option>
                                                                    <option value="formula">Formula</option>
                                                                </select>
                                                            </td>
                                                           <td><input rno="'.$count.'" type="hidden" class="qty" id="manualqty'.$count.'" name="manualqty['.$count.']" value="'.$data[6].'">'.$data[6].'</td>';
                                                            $html .='<td class="text-right">
                                                                <a id="model'.$count.'" data-toggle="modal" role="button" rno="'.$count.'" title="_stage_'.$count.'" href="" onclick="return modelid(this.title, '.$count.');" class="btn btn-simple btn-warning btn-icon formula_btn'.$count.' disabled"><i class="material-icons calculatedFormula'.$count.'">functions</i></a>
                                                                <input class="form-control formula" rno ="'.$count.'" type="hidden" value="" name="formula['.$count.']" id="formula_stage_'.$count.'" title="'.$count.'" alt="'.$count.'">
                                                                <input class="form-control formulaqty"  rno ="'.$count.'" type="hidden" value="" name="formulaqty['.$count.']" id="formulaqty_stage_'.$count.'" title="'.$count.'" alt="'.$count.'">
                                                                <input class="form-control formulatext"  rno ="'.$count.'" type="hidden" value="" name="formulatext['.$count.']" id="formulatext_stage_'.$count.'" title="'.$count.'" alt="'.$count.'">
                                                                <input type="hidden" name="is_rounded['.$count.']" value="0" id="is_rounded'.$count.'">
                                                                <a rno="'.$count.'" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                                                </td></tr>';
                                  $count++;  
                                }
                                
                            }//end of if
                            $k++;
                        }//end of while
                        echo $html;
	}
	
	//Edit Template Screen
	public function edit_template($id) {
	    
	    $this->mod_common->is_company_page_accessible(84);
		if ($id > 0) {
		    
			$data['template_edit'] = $this->mod_template->get_template($id);
			if($data['template_edit']){
    			$data['template_id'] =$id;
    			$data['tpl_stages'] = $this->mod_project->get_stages_by_tempid($id);
    			$data['tparts'] = $this->mod_project->get_costing_parts_by_template_id($id);
    			$this->stencil->title('Edit Template');
                $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
                $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
                $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
                $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
                $data["extprojects"] = $this->mod_project->get_existing_project();
                $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
                //Get Supplierz Templates
                $data['supplier_users'] = get_supplier_users();
        		$suppliers_user_list = "";
        		foreach($data['supplier_users'] as $val){
        		    $suppliers_user_list .= $val['user_id'].",";
        		}
        		$suppliers_user_list = rtrim($suppliers_user_list, ",");
        		if($suppliers_user_list!=""){
        		$query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id WHERE st.supplier_id IN (".$suppliers_user_list.
        		") AND st.template_status=1 GROUP BY template_id");
        		$data['supplierzTemplates'] = $query->result();
        		}
        		else{
        		   	$data['supplierzTemplates'] = array(); 
        		}
        		
                $this->stencil->paint('templates/edit_template', $data);  
			}
			else{
			    $this->session->set_flashdata('err_message', 'Template does not exist.');
                redirect(SURL . 'setup/templates');
			}
		} else {
          redirect(SURL."nopage");
		}
	}
	
	//Update Template
	public function update_template_process(){
	    
	    $this->mod_common->is_company_page_accessible(86);
	    
	    $id = $this->input->post("template_id");
	    
	    $data['template_edit'] = $this->mod_template->get_template($id);
	    
	    if($data['template_edit'][0]->template_name!=$this->input->post('template_name')){
	    $this->form_validation->set_rules('template_name', 'Template Name', 'required');
	    }
	    else{
	       $this->form_validation->set_rules('template_name', 'Template Name', 'required'); 
	    }
		$this->form_validation->set_rules('template_desc', 'Template Description', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			$data['template_id'] =$id;
			$data['tpl_stages'] = $this->mod_project->get_stages_by_tempid($id);
			$data['tparts'] = $this->mod_project->get_costing_parts_by_template_id($id);

			$this->stencil->title('Edit Template');
            $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
            $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
            $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
            $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
            $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
            
            //Get Supplierz Templates
            $data['supplier_users'] = get_supplier_users();
    		$suppliers_user_list = "";
    		foreach($data['supplier_users'] as $val){
    		    $suppliers_user_list .= $val['user_id'].",";
    		}
    		$suppliers_user_list = rtrim($suppliers_user_list, ",");
    		if($suppliers_user_list!=""){
    		$query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id WHERE st.supplier_id IN (".$suppliers_user_list.
    		") AND st.template_status=1 GROUP BY template_id");
    		$data['supplierzTemplates'] = $query->result();
    		}
    		else{
    		   	$data['supplierzTemplates'] = array(); 
    		}
            $this->stencil->paint('templates/edit_template', $data);
			}
		else{
		    
    	    $upd_array = array(
    			'template_name'	=>	$this->input->post('template_name'),
    			'template_desc'	=>	$this->input->post('template_desc'),
    			'template_status' =>	$this->input->post('template_status')
    		);
    		
    		$where = array("template_id" => $id);
    		
    		$updatetemplate = $this->mod_common->update_table('templates',$where, $upd_array);
    		
    		if($updatetemplate){
    		    
    		      $table = "tpl_component_part";
                  $where = "`temp_id` ='" . $id . "'";
		
                 $delete_template_parts = $this->mod_common->delete_record($table, $where);
    		
    		            $part	= '';
    					$count	= 0;
    					$q =1;
    					$stagecount	    = array_values($this->input->post('stagecount'));
    					$part_name	    = array_values($this->input->post('part_name'));
    					$component_uom	= array_values($this->input->post('component_uom'));
    					$component_uc	= array_values($this->input->post('component_uc'));
    					$component_id	= array_values($this->input->post('component_id'));
    					$supplier_id	= array_values($this->input->post('supplier_id'));
    					$quantity		= array_values($this->input->post('manualqty'));
    					$formula		= array_values($this->input->post('formula'));
    					$quantity_type  = array_values($this->input->post('quantity_type'));
    					$formulaqty		= array_values($this->input->post('formulaqty'));
    					$formulatext	= array_values($this->input->post('formulatext'));
    					$is_rounded	    = array_values($this->input->post('is_rounded'));
    					$component_type	= array_values($this->input->post('component_type'));
    					$stage_id	    = count($this->input->post('stage_id'));
    					$gstage_id	    = array_values($this->input->post('stage_id'));
    					$ip_address = $_SERVER['REMOTE_ADDR'];
    					
    					for($i=0;$i<$stage_id;$i++){
    						$s = $i+1;
    						if(isset($gstage_id[$i])){
        						if(trim($quantity[$i])==''){
        							$quantity[$i]=0;
        						}
        						$part_stage_id = $gstage_id[$i];
    						$part_supplier_id = $supplier_id[$i];
    						$part_component_id = $component_id[$i];
    						$imported_formula = $formula[$i];
    							
    						if($component_type[$i]==-1){
                                //Adding New Stage if not exists
                                $stage = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'stage_name' => $gstage_id[$i],
                                    'stage_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_stage = $this->mod_common->select_single_records('project_stages', array('company_id' => $this->session->userdata('company_id'), 'stage_name' => $gstage_id[$i]));
                                
                                if (count($existing_stage) == 0) {
                                     $part_stage_id = $this->mod_common->insert_into_table('project_stages', $stage);
                                }
                                else{
                                    $part_stage_id = $existing_stage["stage_id"];
                                }
                                
                                //Adding New Supplier if not exists
                                $supplier = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'supplier_name' => $supplier_id[$i],
                                    'supplier_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_supplier = $this->mod_common->select_single_records('project_suppliers', array('company_id' => $this->session->userdata('company_id'), 'supplier_name' => $supplier_id[$i]));
                                
                                if (count($existing_supplier) == 0) {
                                     $part_supplier_id = $this->mod_common->insert_into_table('project_suppliers', $supplier);
                                }
                                else{
                                    $part_supplier_id = $existing_supplier["supplier_id"];
                                }
                                
                                
                                //Adding New Component if not exists
                                $component = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'component_name' => $component_id[$i],
                                    'component_des' => "",
                                    'component_uom' => $component_uom[$i],
                                    'component_uc' => $component_uc[$i],
                                    'supplier_id' => $part_supplier_id,
                                    'component_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_component = $this->mod_common->select_single_records('project_components', array('company_id' => $this->session->userdata('company_id'), 'component_name' => $component_id[$i]));
                                
                                if (count($existing_component) == 0) {
                                     $part_component_id = $this->mod_common->insert_into_table('project_components', $component);
                                }
                                else{
                                    $part_component_id = $existing_component["component_id"];
                                }
                            }
                            else if($component_type[$i]==2){
                                    //Adding New Supplier If Not Exists
                                    
                                    $supplier_user_id = $supplier_id[$i];
               
                                    $where = "parent_supplier_id = '".$supplier_user_id."' AND company_id = ".$this->session->userdata('company_id');
               
                                    $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);
                                   
                                    if(count($data['supplier_info'])==0){
                            
                                        $where = "user_id = '".$supplier_user_id."'";
                                   
                                        $supplier_user_info = $this->mod_common->select_single_records('project_users', $where);
                               
                                        $supplier_detail = array(
                                                'user_id' => $this->session->userdata('user_id'),
                                                'company_id' => $this->session->userdata('company_id'),
                                                'parent_supplier_id' => $supplier_user_id,
                                                'supplier_name' => $supplier_user_info['com_name'],
                                                'supplier_status' => 1,
                                                'supplier_city' => "",
                                                'supplier_postal_city' => "",
                                                'supplier_zip' => "",
                                                'supplier_postal_zip' => "",
                                                'post_street_pobox' => "",
                                                'post_suburb' => "",
                                                'street_pobox' => "",
                                                'supplier_country' => "",
                                                'supplier_postal_country' => "",
                                                'suburb' => "",
                                                'supplier_email' => $supplier_user_info['user_email'],
                                                'supplier_phone' => "",
                                                'supplier_web' => "",
                                                'supplier_state' => "",
                                                'supplier_postal_state' =>"",
                                                'supplier_contact_person' => "",
                                                'supplier_contact_person_mobile' => ""
                                            );
                                       
                                        $this->mod_common->insert_into_table('project_suppliers', $supplier_detail);
                                        $part_supplier_id = $this->db->insert_id();
                                    }
                                    else{
                                        $part_supplier_id = $data['supplier_info']['supplier_id'];
                                    }
                                    
                                    //Substitution of Takeoffdata
    				    
                				    if($quantity_type[$i] == "formula"){
                				        preg_match_all('/\|\d+/', $formula[$i], $takeoffdata_id);
                				        if(isset($takeoffdata_id[1])){
                        				    $take_of_data_list = $takeoffdata_id[1];
                        				    if(count($take_of_data_list)>0){
                            				    for($j=0;$j<count($take_of_data_list);$j++){
                            				        $takeoffdata_info = $this->mod_common->select_single_records('project_takeoffdata',$fields = false,array("takeof_id" => $take_of_data_list[$j]));
                            				        $takeoffdata_name = $takeoffdata_info["takeof_name"];
                            				        $is_takeoffdata_exist = $this->mod_common->select_single_records('project_takeoffdata',$fields = false,array("takeof_name" => $takeoffdata_name, "company_id"=> $this->session->userdata('company_id')));
                            				        if(count($is_takeoffdata_exist)>0){
                            				            $imported_formula = str_replace("|".$take_of_data_list[$j], "|".$is_takeoffdata_exist["takeof_id"], $imported_formula);
                            				        }
                            				        else{
                            				            $takeoffdata_ins = array(
                            				                    "takeof_name" => $takeoffdata_info["takeof_name"],
                            				                    "takeof_des" => $takeoffdata_info["takeof_des"],
                            				                    "takeof_uom" => $takeoffdata_info["takeof_uom"],
                            				                    "takeof_m" => $takeoffdata_info["takeof_m"],
                            				                    "project_id" => 0,
                            				                    "takeof_status" => 1,
                            				                    "user_id"	  =>	$this->session->userdata('user_id'),
                        						                "company_id"  =>	$this->session->userdata('company_id')
                            				                    
                            				                );
                            				                
                            				            $new_takeoffdata = $this->mod_common->insert_into_table('project_takeoffdata',$takeoffdata_ins);
                            				            
                            				            $imported_formula = str_replace("|".$take_of_data_list[$j], "|".$new_takeoffdata, $imported_formula);
                            				        }
                            				        
                            				    }
                        				    }
                				        }
                				    }   
                				    
                				    // Substitution of components
    				                $component_info = $this->mod_common->select_single_records('project_price_book_components', array("id" => $component_id[$i]));
    				                
            				        $is_component_exist = $this->mod_common->select_single_records('project_components', array("parent_component_id" => $component_info["component_id"], "company_id"=> $this->session->userdata('company_id')));
            				       
            				        if(count($is_component_exist)>0){
            				            $part_component_id = $is_component_exist["component_id"];
            				        }
            				        else{
            				            $component_ins = array(
            				                    'parent_component_id' => $component_info["component_id"],
                                                'component_name' => $component_info["component_name"],
                                                'component_des' => $component_info["component_des"],
                                                'component_uom' => $component_info["component_uom"],
                                                'component_uc' => $component_info["component_sale_price"],
                                                'supplier_id' => $part_supplier_id,
                                                'component_status' => 1,
                                                'image' => $component_info["image"],
            				                    "user_id"	  =>	$this->session->userdata('user_id'),
        						                "company_id"  =>	$this->session->userdata('company_id')
            				                    
            				                );
            				                
            				            $new_component_id = $this->mod_common->insert_into_table('project_components',$component_ins);
            				            
            				            if($component_info["image"]!=""){
                                            copy('assets/price_books/'.$component_info["image"], 'assets/components/'.$component_info["image"]);
                                            copy('assets/price_books/'.$component_info["image"], 'assets/components/thumbnail/'.$component_info["image"]);
            				            }
                                        
            				            
            				            $part_component_id = $new_component_id;
            				        }
        				        
            				       // Substitution of stage
        				            
            				        $is_stage_exist = $this->mod_common->select_single_records('project_stages', array("stage_id" => $gstage_id[$i], "company_id"=> $this->session->userdata('company_id')));
            				        if(count($is_stage_exist)>0){
            				            $part_stage_id = $is_stage_exist["stage_id"];
            				        }
            				        else{
            				           
            				            $stage_info = $this->mod_common->select_single_records('project_stages', array("stage_id" =>  $gstage_id[$i]));
            				           
            				            $created_by = $this->session->userdata("user_id");
                                        $ip_address = $_SERVER['REMOTE_ADDR'];
                                        
            				            $stage_ins = array(
                                                'stage_name' => $stage_info["stage_name"],
                                                'stage_description' => $stage_info["stage_description"],
                                                'stage_status' => 1,
            				                    "user_id"	  =>	$this->session->userdata('user_id'),
        						                "company_id"  =>	$this->session->userdata('company_id'),
        						                "ip_address" => $ip_address,
        						                "created_by" => $created_by
            				                );
            				                
            				            $new_stage_id = $this->mod_common->insert_into_table('project_stages', $stage_ins);
            				            
            				            
            				            $part_stage_id = $new_stage_id;
            				        }
                                }
        
        						$part = array(
        							'temp_id'							=>	$id,
        							'stage_id'							=>	$part_stage_id,
        							'user_id'							=>	$this->session->userdata('user_id'),
        							'company_id'						=>	$this->session->userdata('company_id'),
        							'component_id'						=>	$part_component_id,
        							'tpl_part_name'						=>	$part_name[$i],
        							'tpl_part_component_uom'			=>	$component_uom[$i],
        							'tpl_part_component_uc'				=>	$component_uc[$i],
        							'tpl_part_supplier_id'				=>	$part_supplier_id,
        							'tpl_quantity'						=>	$quantity[$i],
        							'tpl_quantity_type'					=>	$quantity_type[$i],
        							'tpl_quantity_formula'				=>	$imported_formula,
        							'is_rounded'			        	=>	$is_rounded[$i],
        							'quantity_formula_text'				=>	$formulatext[$i],
        							'tpl_part_status'					=>	1
        						);			
        
        						$part = $this->mod_common->insert_into_table('tpl_component_part',$part);	
        						
    						}
    					}
    		    }
    					
    			$this->session->set_flashdata('ok_message', 'Template updated successfully.');
    			redirect(SURL . 'setup/templates');
		}
	}
	
	//Import Template
	public function import_template($id=0)
	{		
        $this->mod_common->is_company_page_accessible(114);
        if($this->session->userdata("selected_supplier")){
           $this->session->unset_userdata("selected_supplier");
        }
		/*$query = $this->db->query("SELECT u.user_id, u.com_name, u.user_fname, u.user_lname FROM project_price_books pb INNER JOIN project_users u ON pb.company_id = u.user_id WHERE (pb.status = 1 OR pbr.status=2) AND pbr.company_id='".$this->session->userdata('company_id')."' GROUP BY pbr.to_user_id");
		$data['supplier_users'] = $query->result();*/
		
		$data['supplier_users'] = get_supplier_users();
		$suppliers_user_list = "";
		foreach($data['supplier_users'] as $val){
		    $suppliers_user_list .= $val['user_id'].",";
		}
		$suppliers_user_list = rtrim($suppliers_user_list, ",");
		if($suppliers_user_list!=""){
		$query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id WHERE st.supplier_id IN (".$suppliers_user_list.
		") AND st.template_status=1 GROUP BY template_id");
		$data['templates'] = $query->result();
		}
		else{
		   	$data['templates'] = array(); 
		}
		
		$this->stencil->title('Import Template');
		$this->stencil->paint('templates/import_template', $data);
	}
	
	//Check Selected Templates
	public function checkSelectedTemplates(){
	    $templates_array = $this->input->post("selectedTemplates");
	    if(count($this->input->post("selectedTemplates"))>0){
	       $selectedTemplates = implode(",", $this->input->post("selectedTemplates"));
	    }
	    else{
	        $selectedTemplates = $templates_array[0];
	    }

	    $query = $this->db->query("Select * FROM project_templates WHERE downloaded_template_id IN (".$selectedTemplates.")");
	    
	    if($query->num_rows()>0){
	        $result = $query->result_array();
	        $templatesList = array();
	        foreach($result as $res){
	            $templatesList[] = $res["template_name"];
	        }
	        $existingTemplates = implode(",", $templatesList);
	        echo $existingTemplates;
	    }
	    else{
	        echo "success";
	    }
	}
	
	//Get Supplierz Template
	public function getsupplierztemplates() {
	    
        $supplier_id = $this->input->post("supplier_id");
        if($supplier_id>0){
        $query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id INNER JOIN project_template_requests r ON r.to_user_id = st.supplier_id WHERE st.supplier_id=".$supplier_id." AND st.template_status=1 AND r.status=2 GROUP BY template_id");
		$data['templates'] = $query->result();   
        }
        else{
            
        $data['supplier_users'] = get_supplier_users();
		$suppliers_user_list = "";
		foreach($data['supplier_users'] as $val){
		    $suppliers_user_list .= $val['user_id'].",";
		}
		$suppliers_user_list = rtrim($suppliers_user_list, ",");
		if($suppliers_user_list!=""){
			$query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id INNER JOIN project_template_requests r ON r.to_user_id = st.supplier_id WHERE st.supplier_id IN (".$suppliers_user_list.
		") AND st.template_status=1 AND r.status=2 GROUP BY template_id");
		$data['templates'] = $query->result();
		}
		else{
		   	$data['templates'] = array(); 
		}
        
        }

		echo $this->load->view('templates/populate_template_by_supplierz', $data, true);

	}
	
	//Send Template Request
	public function send_request(){
	       $created_by = $this->session->userdata("user_id");
           $ip_address = $_SERVER['REMOTE_ADDR'];
	       $request_array = array(
                'from_user_id' => $this->session->userdata('user_id'),
                'to_user_id' => $this->input->post('to_supplier_id'),
                'template_id' => $this->input->post('template_id'),
                'company_id' => $this->session->userdata('company_id'),
                'created_by' => $created_by,
                'ip_address' => $ip_address
            );
        
            $send_request = $this->mod_common->insert_into_table('project_template_requests', $request_array);
            
            if ($send_request) {
                $this->session->set_userdata("selected_supplier", $this->input->post('supplier_user_id'));
                redirect(SURL."setup/request_a_template_list");
            }
	}
	
	//Get All Requested Template List
	public function request_a_template_list()
	{		
        $this->mod_common->is_company_page_accessible(114);
        if($this->session->userdata("selected_supplier")){
            $supplier_id = $this->session->userdata("selected_supplier");
    		$this->session->set_flashdata("ok_message", 'Template Request has been sent successfully!');
    		$query = $this->db->query("SELECT u.user_fname, u.com_name, u.user_lname, st.* FROM project_supplierz_templates st INNER JOIN project_users u ON u.user_id = st.supplier_id INNER JOIN project_template_requests r ON r.to_user_id = st.supplier_id WHERE st.supplier_id=".$supplier_id." AND st.template_status=1 AND r.status=2 GROUP BY template_id");
			$data['templates'] = $query->result();
    		$data['supplier_user_id'] = $supplier_id;
    		
    		$data['supplier_users'] = get_supplier_users();
    		
    		$this->stencil->title('Request A Template');
		    $this->stencil->paint('templates/request_a_template', $data);
        }
        else{
            $this->session->set_flashdata("ok_message", 'Template Request has been sent successfully!');
            redirect(SURL."setup/request_a_template");
        }
	}
	
	//Import Supplierz Template Screen
	public function import_supplierz_template($id) {
	    
        $data['template_info'] = $this->mod_template->get_supplierz_template_for_builder($id);
        
        $request_info = $data["request_info"] = $this->mod_common->select_single_records('project_template_requests', array("template_id"=>$id, "company_id" => $this->session->userdata('company_id')));
        
        if($request_info["status"]!=1){
            redirect("setup/request_a_template");
        }
		$data['template_id'] = $id;
		
		$data['tparts'] = $this->mod_template->get_supplierz_costing_parts_by_template_id($id);
		
		$this->stencil->title('Import Supplierz Template');
		$this->stencil->paint('templates/import_supplierz_template', $data);
    }
    
    //Import Supplierz Template into Builderz Account Screen
    public function download_selected_templates(){	
	    $this->mod_common->is_company_page_accessible(114);
		$templates = $this->input->post("selectTemplate");
		for($i=0;$i<count($templates);$i++){
		    $templateInfo = $this->mod_common->select_single_records('project_supplierz_templates', array("template_id", $templates[$i]));
		    if(count($templateInfo)>0){
		        $this->mod_common->delete_record("project_templates", array("downloaded_template_id" => $templates[$i], "company_id" => $this->session->userdata('company_id')));
		    }
		    
    		$userdetail = array(
    			'user_id'							=>	$this->session->userdata('user_id'),
    			'company_id'						=>	$this->session->userdata('company_id'),
    			'template_name'						=>	$templateInfo['template_name'],
    			'template_desc'						=>	$templateInfo['template_desc'],
    			'downloaded_template_id'            =>  $templateInfo['template_id'],
    			'quantity'							=>	0,
    			'template_status'					=>	1
    		);		

			$addtemplate = $this->mod_common->insert_into_table('project_templates',$userdetail);	
			
			if($addtemplate){
			    
        		$supplier_user_id = 1;
               
                $where = "parent_supplier_id = '".$supplier_user_id."' AND company_id = ".$this->session->userdata('company_id');
               
                $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);
               
                if(count($data['supplier_info'])==0){
        
                    $where = "user_id = '".$supplier_user_id."'";
               
                    $supplier_user_info = $this->mod_common->select_single_records('project_users', $where);
           
                    $supplier_detail = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'company_id' => $this->session->userdata('company_id'),
                            'parent_supplier_id' => $supplier_user_id,
                            'supplier_name' => $supplier_user_info['com_name'],
                            'supplier_status' => 1,
                            'supplier_city' => "",
                            'supplier_postal_city' => "",
                            'supplier_zip' => "",
                            'supplier_postal_zip' => "",
                            'post_street_pobox' => "",
                            'post_suburb' => "",
                            'street_pobox' => "",
                            'supplier_country' => "",
                            'supplier_postal_country' => "",
                            'suburb' => "",
                            'supplier_email' => $supplier_user_info['user_email'],
                            'supplier_phone' => "",
                            'supplier_web' => "",
                            'supplier_state' => "",
                            'supplier_postal_state' =>"",
                            'supplier_contact_person' => "",
                            'supplier_contact_person_mobile' => ""
                        );
                   
                    $this->mod_common->insert_into_table('project_suppliers', $supplier_detail);
                    $supplier_id = $this->db->insert_id();
                }
                else{
                    $supplier_id = $data['supplier_info']['supplier_id'];
                }
                
                $templateParts = $this->mod_common->get_all_records('project_supplierz_tpl_component_part', "*", 0, 0, array("temp_id", $templates[$i]), "tpl_part_id");
    			foreach($templateParts as $val){
    				    $imported_formula = $val['tpl_quantity_formula'];
    				    
    				    //Substitution of Takeoffdata
    				    
    				    if($val['tpl_quantity_type'] == "formula"){
    				        preg_match_all('/\|\d+/', $val['tpl_quantity_formula'], $takeoffdata_id);
        				    $take_of_data_list = $takeoffdata_id[1];
        				    if(count($take_of_data_list)>0){
            				    for($j=0;$j<count($take_of_data_list);$j++){
            				        $takeoffdata_info = $this->mod_common->select_single_records('project_takeoffdata',$fields = false,array("takeof_id" => $take_of_data_list[$j]));
            				        $takeoffdata_name = $takeoffdata_info["takeof_name"];
            				        $is_takeoffdata_exist = $this->mod_common->select_single_records('project_takeoffdata',$fields = false,array("takeof_name" => $takeoffdata_name, "company_id"=> $this->session->userdata('company_id')));
            				        if(count($is_takeoffdata_exist)>0){
            				            $imported_formula = str_replace("|".$take_of_data_list[$j], "|".$is_takeoffdata_exist["takeof_id"], $imported_formula);
            				        }
            				        else{
            				            $takeoffdata_ins = array(
            				                    "takeof_name" => $takeoffdata_info["takeof_name"],
            				                    "takeof_des" => $takeoffdata_info["takeof_des"],
            				                    "takeof_uom" => $takeoffdata_info["takeof_uom"],
            				                    "takeof_m" => $takeoffdata_info["takeof_m"],
            				                    "project_id" => 0,
            				                    "takeof_status" => 1,
            				                    "user_id"	  =>	$this->session->userdata('user_id'),
        						                "company_id"  =>	$this->session->userdata('company_id')
            				                    
            				                );
            				                
            				            $new_takeoffdata = $this->mod_common->insert_into_table('project_takeoffdata',$takeoffdata_ins);
            				            
            				            $imported_formula = str_replace("|".$take_of_data_list[$j], "|".$new_takeoffdata, $imported_formula);
            				        }
            				        
            				    }
        				    }
    				    }   
    				    // Substitution of components
    				            
        				        $component_info = $this->mod_common->select_single_records('project_price_book_components', array("id" => $val['component_id']));
        				        
        				        $is_component_exist = $this->mod_common->select_single_records('project_components', array("parent_component_id" => $component_info["component_id"], "company_id"=> $this->session->userdata('company_id')));
        				       
        				        if(count($is_component_exist)>0){
        				            $imported_component_id = $is_component_exist["component_id"];
        				        }
        				        else{
        				           
        				            $component_ins = array(
        				                    'parent_component_id' => $component_info["component_id"],
                                            'component_name' => $component_info["component_name"],
                                            'component_des' => $component_info["component_des"],
                                            'component_uom' => $component_info["component_uom"],
                                            'component_uc' => $component_info["component_sale_price"],
                                            'supplier_id' => $supplier_id,
                                            'component_status' => 1,
                                            'image' => $component_info["image"],
        				                    "user_id"	  =>	$this->session->userdata('user_id'),
    						                "company_id"  =>	$this->session->userdata('company_id')
        				                    
        				                );
        				                
        				            $new_component_id = $this->mod_common->insert_into_table('project_components',$component_ins);
        				            
        				            if($component_info["image"]!=""){
                                        copy('assets/price_books/'.$component_info["image"], 'assets/components/'.$component_info["image"]);
                                        copy('assets/price_books/'.$component_info["image"], 'assets/components/thumbnail/'.$component_info["image"]);
        				            }
                                    
        				            
        				            $imported_component_id = $new_component_id;
        				        }
        				        
        				// Substitution of stage
    				            
        				        $is_stage_exist = $this->mod_common->select_single_records('project_stages', array("stage_id" => $val['stage_id'], "company_id"=> $this->session->userdata('company_id')));
        				        if(count($is_stage_exist)>0){
        				            $imported_stage_id = $is_stage_exist["stage_id"];
        				        }
        				        else{
        				           
        				            $stage_info = $this->mod_common->select_single_records('project_stages', array("stage_id" => $val['stage_id']));
        				           
        				            $created_by = $this->session->userdata("user_id");
                                    $ip_address = $_SERVER['REMOTE_ADDR'];
                                    
        				            $stage_ins = array(
                                            'stage_name' => $stage_info["stage_name"],
                                            'stage_description' => $stage_info["stage_description"],
                                            'stage_status' => 1,
        				                    "user_id"	  =>	$this->session->userdata('user_id'),
    						                "company_id"  =>	$this->session->userdata('company_id'),
    						                "ip_address" => $ip_address,
    						                "created_by" => $created_by
        				                );
        				                
        				            $new_stage_id = $this->mod_common->insert_into_table('project_stages', $stage_ins);
        				            
        				            
        				            $imported_stage_id = $new_stage_id;
        				        }
        				        
    					$part = array(
    						'temp_id'							=>	$addtemplate,
    						'stage_id'							=>	$imported_stage_id,
    						'user_id'							=>	$this->session->userdata('user_id'),
    						'company_id'						=>	$this->session->userdata('company_id'),
    						'component_id'						=>	$imported_component_id,
    						'tpl_part_name'						=>	$val['tpl_part_name'],
    						'tpl_part_component_uom'			=>	$val['tpl_part_component_uom'],
    						'tpl_part_component_uc'				=>	$val['tpl_part_component_uc'],
    						'tpl_part_supplier_id'				=>	$supplier_id,
    						'tpl_quantity'						=>	$val['tpl_quantity'],
    						'tpl_quantity_type'					=>	$val['tpl_quantity_type'],
    						'tpl_quantity_formula'				=>	$imported_formula,
    						'quantity_formula_text'				=>	$val['quantity_formula_text'],
    						'is_rounded'			        	=>	$val['is_rounded'],
    						'tpl_part_status'					=>	1
    					);	
    
    					$part = $this->mod_common->insert_into_table('project_tpl_component_part',$part);						
    			}
			}
		}
			
			$this->session->set_flashdata("ok_message", 'Template imported successfully!');	
			redirect(SURL.'setup/templates');				
	}
	
	//Get All Created Templates By Admin
	public function template_store(){
        
        $this->mod_common->is_company_page_accessible(113);
        
        $data['templates'] = $this->mod_project->get_admin_templates();	
        
		$this->stencil->title('Template Store');
		$this->stencil->paint('templates/template_store', $data);
    }
    
    //Import Template
	public function import_template_old($id=0)
	{		
        $this->mod_common->is_company_page_accessible(113);
		if($id>0){

			$cwhere 			= array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1);
			$data['takeoffdatas'] = $this->mod_common->get_all_records('project_takeoffdata', "*", 0, 0, $cwhere);

			$data['templates'] = $this->mod_project->get_admin_templates($id);
			$data['template_parts'] = $this->mod_project->get_admin_template_parts($id);		

			$this->stencil->title('Template Store');
	    	$this->stencil->paint('templates/import_admin_template', $data);

		}else{
			$data['templates'] = $this->mod_project->get_admin_templates();		
			$this->stencil->title('Template Store');
		    $this->stencil->paint('templates/template_store', $data);
		}

	}
	
	/********************Templates Section Ends Here**************************/
	
	/********************Users Section Starts Here**************************/
	
	//Get All Users
	public function users()
	{
	    $this->mod_common->is_company_page_accessible(88);
        $table="users";
        $data['users'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id')), "user_id");
        $this->stencil->title('Users');
	    $this->stencil->paint('users/manage_users', $data);
	}
    
    //Add New User
    public function add_user()
	{   
            $this->mod_common->is_company_page_accessible(90);
            
		    $table="roles";
            $data['roles'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id'), "status" => 1));
	       $this->stencil->title('Add User');	
             if ($this->input->post("add_new_user")) {
			    
		        $this->form_validation->set_rules('first_name', 'First Name', 'required');
		        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
				$this->form_validation->set_rules('role_id', 'Role', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.user_email]');

				
			    if ($this->form_validation->run() == FALSE)
				{
				   $this->stencil->title("Add User");
                   $this->stencil->paint('users/add_user', $data);
				}
				else{

					$table = "users";
					
					$first_name = $this->input->post('first_name');
					$last_name = $this->input->post('last_name');
					$email = $this->input->post('email');
					$role_id = $this->input->post('role_id');
					$created_by = $this->session->userdata("user_id");
                    $ip_address = $_SERVER['REMOTE_ADDR'];
					$password = random_password_generator();

					$filename= "project_avatar.png";

					if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
						
						$projects_folder_path = './assets/profile_images/';
						$projects_folder_path_main = './assets/profile_images/';

						$thumb = $projects_folder_path_main . 'thumb';

						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|JPG|JPEG|GIF|TIFF|TIF|PNG';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('profile_image')) {
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
					
					$company_info = $this->mod_common->select_single_records("project_users", array("user_id" => $this->session->userdata("company_id")));

					$ins_array = array(
						"user_fname" => $first_name,
						"user_lname" => $last_name,
                        "user_email" => $email,
						"user_password" => md5($password),
						"user_img" => $filename,
						"com_logo" => $company_info['com_logo'],
                        "com_name" => $company_info['com_name'],
                        "com_street_address" => $company_info['com_street_address'],
                        "com_postal_address" => $company_info['com_postal_address'],
                        "com_website" => $company_info['com_website'],
						"com_email" => $company_info['com_email'],
						"com_gst_number" => $company_info['com_gst_number'],
						"com_phone_no" => $company_info['com_phone_no'],
						"com_tax" => $company_info['com_tax'],
						"role_id" => $role_id,
						"company_id" => $this->session->userdata("company_id"),
						"created_by" => $created_by,
                        "ip_address" => $ip_address
					);
					
		            $add_user = $this->mod_common->insert_into_table($table, $ins_array);
					
					if ($add_user) {

                                                $subject = "Confirm Registration";
                                                $data['password'] = $password;
                                                $data['email'] = $email;
                                                $data['firstname'] = $first_name;
                                                $data['id'] = $this->db->insert_id();

		                                        $message = $this->load->view("email_templates/register_template", $data, TRUE); 
		   
                                                $config = Array(
                                                    'protocol' => 'smtp',
                                                    'smtp_host' => 'mail.wizard.net.nz',
                                                    'smtp_port' => 587,
                                                    'smtp_user' => 'info@wizard.net.nz', // change it to yours
                                                    'smtp_pass' => '{SGwI8a~GDMJ', // change it to yours
                                                    'mailtype' => 'html',
                                                    'charset' => 'utf-8',
                                                    'wordwrap' => TRUE
                                                  );
                                                
                                                       
                                                $this->load->library('email', $config);
                                                $this->email->set_newline("\r\n"); 
                                                $this->email->set_mailtype("html");
                                                
                                                $this->email->to($email);
                                                $this->email->from('info@wizard.net.nz');
                                                $this->email->subject($subject);
                                                $this->email->message($message);
		                                        $this->email->send();
						$this->session->set_flashdata('ok_message', 'User added successfully!');
						redirect(SURL . 'setup/users');
					} else {
						
						$this->session->set_flashdata('err_message', 'Error in adding User please try again!');
						redirect(SURL . "setup/add_user");
					}
				}
        }

        else{
	        $this->stencil->title("Add User");
            $this->stencil->paint('users/add_user', $data);
	    }
	     
	}
   
    //Edit User Screen
    public function edit_user($id="") {
		
		$this->mod_common->is_company_page_accessible(89);

        if($id=="" || !(is_numeric($id))){
          redirect("nopage");
        }

		$table="roles";
        $data['roles'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id'), "status" => 1));
			
        $table = "project_users";
        $where = "`user_id` ='" . $id."' AND company_id = ".$this->session->userdata("company_id");

        $data['user_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['user_edit']) == 0) {
            $this->session->set_flashdata('err_message', 'User does not exist.');
            redirect(SURL . 'setup/users');
        } else {
            $this->stencil->title("Edit User");

            $this->stencil->paint('users/edit_user', $data);
        }
    }
    
    //Update User
    public function update_user() {
      
		$this->mod_common->is_company_page_accessible(91);

		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('role_id', 'Role', 'required');
                
        $id = $this->input->post('user_id');
                if($id!=""){
                $table = "project_users";
		$where = "`user_id` ='" . $id."'";

		$data['user_edit'] = $this->mod_common->select_single_records($table, $where);
		
		$table="roles";
        $data['roles'] = $this->mod_common->get_all_records($table, "*", 0, 0, array("company_id"=>$this->session->userdata('company_id'), "status" => 1));

                $original_value = $data['user_edit']['user_email'];
                if($this->input->post('email') != $original_value) {
                   $is_unique =  '|is_unique[users.user_email]';
                } else {
                   $is_unique =  '';
                }

                
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email'.$is_unique);

			if ($this->form_validation->run() == FALSE)
				{
				   $this->stencil->title("Edit User");
                   $this->stencil->paint('users/edit_user', $data);
				}
				else{

					$table = "users";
					
					$first_name = $this->input->post('first_name');
					$last_name = $this->input->post('last_name');
					$email = $this->input->post('email');
					$role_id = $this->input->post('role_id');
					$user_status = $this->input->post("user_status");
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                                        
					$filename= "";

					if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
						
						if($data['user_edit']['user_img']!="project_avatar.png"){
    						$ext_file_name="./assets/profile_images/".$data['user_edit']['user_img'];
    						if(file_exists($ext_file_name)){
    							unlink($ext_file_name);
    						}
    						$thumb_file_name="./assets/profile_images/thumb/".$data['user_edit']['user_img'];
    						if(file_exists($thumb_file_name)){
    							unlink($thumb_file_name);
    						}
						}
						$projects_folder_path = './assets/profile_images/';
						$projects_folder_path_main = './assets/profile_images/';

						$thumb = $projects_folder_path_main . 'thumb';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|JPG|JPEG|GIF|TIFF|TIF|PNG';
						$config['overwrite'] = false;
						$config['encrypt_name'] = TRUE;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('profile_image')) {
							
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
						$filename = $this->input->post('old_image');
					}
                         	$company_info = $this->mod_common->select_single_records("project_users", array("user_id" => $this->session->userdata("company_id")));
                            $upd_array = array(
								"user_fname" => $first_name,
						        "user_lname" => $last_name,
                                "user_email" => $email,
						        "user_img" => $filename,
						        "com_logo" => $company_info['com_logo'],
                                "com_name" => $company_info['com_name'],
                                "com_street_address" => $company_info['com_street_address'],
                                "com_postal_address" => $company_info['com_postal_address'],
                                "com_website" => $company_info['com_website'],
        						"com_email" => $company_info['com_email'],
        						"com_gst_number" => $company_info['com_gst_number'],
        						"com_phone_no" => $company_info['com_phone_no'],
        						"com_tax" => $company_info['com_tax'],
						        "role_id" => $role_id,
						        "user_status" => $user_status,
                                "ip_address" => $ip_address
							     );
							
							$table = "users";
							$where = "`user_id` ='" . $id . "'";
							$update_user = $this->mod_common->update_table($table, $where, $upd_array);
							
							if ($update_user) {
								$this->session->set_flashdata('ok_message', 'User updated successfully!');
								redirect(SURL . 'setup/users');
							} else {
								$this->session->set_flashdata('err_message', 'Error in updating User please try again!');
								redirect(SURL . 'setup/edit_user/' . $id);
							}
					
			}
      }
      else{
           redirect("nopage");
      }
    }

    //Delete User
    public function delete_user() {
		
    $this->mod_common->is_company_page_accessible(92);

        $id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
		$table = "users";
		$where = "`user_id` ='" . $id ."'";
			
		$data['user_edit'] = $this->mod_common->select_single_records($table, $where);

		if($data['user_edit']['user_img']!="project_avatar.png"){
    		$file_name="./assets/profile_images/".$data['user_edit']['user_img'];
    		if(file_exists($file_name)){
    			unlink($file_name);
    		}
    		$thumb_file_name="./assets/profile_images/thumb/".$data['user_edit']['user_img'];
    		if(file_exists($thumb_file_name)){
    			unlink($thumb_file_name);
    		}
		}
       
        $delete_user = $this->mod_common->delete_record($table, $where);

    }
    
    //Verify User
    public function verify_email() {

        $email = $this->input->post("email");
        
        $table = "project_users";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'user_id !=' => $id,
            'user_email' => $email,
          );
        }
        else{
          $where = array(
            'user_email' => $email,
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    /********************Users Section Ends Here**************************/
    
    /********************Roles Section Starts Here**************************/
    
    //Get All Roles
    public function roles()
	{
	    $this->mod_common->is_company_page_accessible(93);
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
				redirect(SURL . 'setup/roles');
			} else {

				$this->session->set_flashdata('err_message', 'New Role is not added. Something went wrong, please try again.');

				redirect(SURL . 'setup/roles');
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
        if ($get_admin_role['admin_role_count'] == 0){
            $this->session->set_flashdata('err_message', 'Role does not exist.');
            redirect(SURL . 'setup/roles');
        }
        else{
            $this->stencil->title('Edit Role');
            $this->stencil->paint('roles/edit_role', $data);
        }
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
				redirect(SURL . 'setup/roles');
			} else {
				$this->session->set_flashdata('err_message', 'Role is not updated. Something went wrong, please try again.');
				redirect(SURL . 'setup/edit_role/' . $role_id);
			}
		}
    }
	
	//Delete Role
	public function delete_role() {
	    
	    $this->mod_common->is_company_page_accessible(113);
		
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
    
    /********************Roles Section Ends Here**************************/
    
    //Add New Takeoffdata
	public function add_new_takeoffdata_shortcut_process() {
		
	    if ($this->input->post("name") == "")
			{
			    $response = array('status' => 'error', 'message' => 'Take off Data Name is required');
			}
		else{
			$table = "takeoffdata";
					
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$takeoff_status = $this->input->post('takeof_status');
            $created_by = $this->session->userdata("user_id");
            $user_id = $this->session->userdata("user_id");
            $company_id = $this->session->userdata("company_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
 
                        $ins_array = array(
            				"takeof_name" => $name,
            				"takeof_des" => $description,
            				"created_by" => $created_by,
            				"user_id" => $user_id,
            				"company_id" => $company_id,
                            "ip_address" => $ip_address,
            				"takeof_status" => $takeoff_status
            			);
					
		        $add_new_takeoffdata = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_takeoffdata) {
			    $takeoffdatas = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
	            $data = "";
	            foreach ($takeoffdatas as $takeoffdata) {
	               $data .="<option tod_id='".$takeoffdata["takeof_id"]."' value='".$takeoffdata["takeof_id"]."' title='".$takeoffdata['takeof_name']."'>".$takeoffdata['takeof_name']."</option>";
                }                       
				$response = array('status' => 'success', 'message' => 'New Take off Data added successfully.', 'data' => $data);
			} else {
				$response = array('status' => 'error', 'message' => 'New Take off Data is not added. Something went wrong, please try again.');
			}
			
			header('Content-Type: application/json');
			echo json_encode($response);
		}
    }
}
