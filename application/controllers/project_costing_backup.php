<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_costing extends CI_Controller {

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

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(1);

    }
    
    //Manage Current Jobs Project Costing
    public function index()
	{
	    $this->mod_common->is_company_page_accessible(1);
	    
        $data['active_projects'] = $this->mod_project->get_all_costed_projects(1);
        $data['pending_projects'] = $this->mod_project->get_all_costed_projects(2);
        $data['inactive_projects'] = $this->mod_project->get_all_costed_projects(0);
        $data['completed_projects'] = $this->mod_project->get_all_costed_projects(3);
        
        $this->stencil->title('Project Costing');
	    $this->stencil->paint('project_costing/manage_project_costing', $data);
	}
    
    //Add Project Costing Screen
    public function add_project_costing() {
        
        $this->mod_common->is_company_page_accessible(3);
        $this->stencil->title('Add Project Costing');
        $data['projects'] = $this->mod_project->get_not_existing_project();
        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
        $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
        $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
        $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        $data["extprojects"] = $this->mod_project->get_existing_project();
        $data["clients"] = $this->mod_common->get_all_records("clients","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'client_status' => 1), "client_id");
        $this->stencil->paint('project_costing/add_project_costing', $data);
    }
    
    //Add New Item
    public function populate_new_costing_row() {
        
        $data['last_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;

        if($this->session->userdata('company_id')>0){
          $where = "company_id = ".$this->session->userdata('company_id')." AND";
        }else{
         $where = "user_id = ".$this->session->userdata('user_id')." AND";
        }   
       
        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, $where." stage_status = 1", "stage_id");
        $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, $where." component_status = 1", "component_id");
        $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, $where." supplier_status = 1", "supplier_id");
        $html = $this->load->view('project_costing/add_part', $data, true);
        echo $html;

    }
	
	//Save Project Costing
	function savecost() {
	    
	    $this->mod_common->is_company_page_accessible(3);
	    $projectID = $this->input->post('project_id');
	    $is_already_exists = $this->mod_common->select_single_records("project_costing", array("project_id" => $projectID));
	    if(count($is_already_exists)==0){

                $this->form_validation->set_rules('project_id', 'Project', 'required');
    		
                if ($this->form_validation->run() == FALSE)
            	{
            	    $this->stencil->title('Add Project Costing');
                    $data['projects'] = $this->mod_project->get_not_existing_project();
                    $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
                    $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
                    $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
                    $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
                    $data["extprojects"] = $this->mod_common->get_all_records("projects","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'project_status' => 1), "project_id");
                    $this->stencil->paint('project_costing/add_project_costing', $data);
            	}
            	else{
                	  $created_by = $this->session->userdata("user_id");
                      $user_id = $this->session->userdata("user_id");
                      $company_id = $this->session->userdata("company_id");
                      $ip_address = $_SERVER['REMOTE_ADDR'];
                      
                      $project_costing_type = $this->input->post("project_costing_type");
                      if($project_costing_type=="Manual"){
                              $tods = $this->input->post('takeoffdatas');
                              $todsarr = array();
                              $jtods = "";
                              if ($tods != "") {
                                $xplodetods = explode(',', $tods);
                            
                                foreach ($xplodetods As $key => $val) {
                                  $st = "td" . $val;
                                  $p = 'todinput' . $val;
                                  $vv = $this->input->post($p);
                                  $todsarr[$st] = $vv;
                                }
                                $jtods = json_encode($todsarr);
                              }
                    
                              $costing = array(
                                'project_id' => $this->input->post('project_id'),
                                'user_id' => $this->session->userdata('user_id'),
                                'company_id' => $this->session->userdata('company_id'),
                                'include_in_report' => 0,
                                'contract_allownce' => 0,
                                'total_quantity' => $this->input->post('total_cost'),
                                'takeoffdatas' => $jtods,
                                'project_subtotal_1' => $this->input->post('total_cost'),
                                'project_subtotal_2' => $this->input->post('total_cost2'),
                                'project_subtotal_3' => $this->input->post('total_cost3'),
                                'is_costing_locked' => $this->input->post('lockproject'),
                                'over_head_margin' => $this->input->post('overhead_margin'),
                                'porfit_margin' => $this->input->post('profit_margin'),
                                'tax_percent' => $this->input->post('costing_tax'),
                                'price_rounding' => $this->input->post('price_rounding'),
                                'contract_price' => $this->input->post('contract_price'),
                                'sale_price' => 0,
                                'status' => 1,  
                                "created_by" => $created_by,
                                "user_id" => $user_id,
                                "company_id" => $company_id,
                                "ip_address" => $ip_address,
                              );
                              $costing = $this->mod_common->insert_into_table('project_costing', $costing);
                              if ($costing) {
                                $count = 0;
                                $stages = count($this->input->post('stage_id'));
                                $stagecount = $this->input->post('stage_id');
                                $part_name = $this->input->post('part_name');
                                $component_uom = $this->input->post('component_uom');
                                $component_uc = $this->input->post('component_uc');
                                $is_locked = $this->input->post('is_line_locked');
                                $line_cost = $this->input->post('linetotal');
                                $quantity_type = $this->input->post('quantity_type');
                                $quantity_formula = $this->input->post('formulaqty');
                                $formula_text = $this->input->post('formulatext');
                                $is_rounded = $this->input->post('is_rounded');
                                $line_margin = $this->input->post('margin_line');
                                $component_id = $this->input->post('component_id');
                                $supplier_id = $this->input->post('supplier_id');
                                $quantity = $this->input->post('manualqty');
                                $allowances = $this->input->post('allowance');
                                $margin = $this->input->post('margin');
                                $line_marginn = $this->input->post('margin_line');
                                $typestatus = $this->input->post('status');
                                $include_in_specification = $this->input->post('include_in_specification');
                                $hide_from_boom_mobile = $this->input->post('hide_from_boom_mobile');
                                $add_task_to_schedule = $this->input->post('add_task_to_schedule');
                                $comments = $this->input->post('comments');
                                $costing_tpe_id = $this->input->post('costing_tpe_id');
                                $sub_category = $this->input->post('sub_category');
                            
                                $gstage_id = $this->input->post('stage_id');
                            
                            
                                    for ($i = 0; $i < $stages; $i++) {
                                        $costing_type = "normal";
                                        $costing_type_id = 0;
                                        
                                        // Insert Costing Part
                                        $part_array = array(
                                        'costing_id' => $costing,
                                        'stage_id' => $gstage_id[$i],
                                        'component_id' => $component_id[$i],
                                        'sub_category' => $sub_category[$i],
                                        'costing_part_name' => $part_name[$i],
                                        'costing_uom' => $component_uom[$i],
                                        'client_allowance' => (isset($allowances[$i]) && $allowances[$i]!="")?$allowances[$i]:0,
                                        'margin' => $margin[$i],
                                        'line_cost' => $line_cost[$i],
                                        'quantity_type' => $quantity_type[$i],
                                        'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                                        'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                                        'is_rounded' => (isset($is_rounded[$i])?$is_rounded[$i]:0),
                                        'line_margin' => $line_margin[$i],
                                        'type_status' => $typestatus[$i],
                                        'is_locked' => $is_locked[$i],
                                        'include_in_specification' => (isset($include_in_specification[$i]) && $include_in_specification[$i]!="")?$include_in_specification[$i]:0,
                                        'add_task_to_schedule' => (isset($add_task_to_schedule[$i]) && $add_task_to_schedule[$i]!="")?$add_task_to_schedule[$i]:0,
                                        'hide_from_boom_mobile' => ($hide_from_boom_mobile[$i]==""?0:1),
                                        'costing_uc' => $component_uc[$i],
                                        'costing_supplier' => $supplier_id[$i],
                                        'costing_quantity' => $quantity[$i],
                                        'costing_part_status' => 1,
                                        'comment' => $comments[$i],
                                        'costing_type' => $costing_type,
                                        'costing_tpe_id' => $costing_type_id
                                      ); 
                                        $new_costing_part_id = $this->mod_common->insert_into_table('project_costing_parts', $part_array);
                                      
                                        /*Add Task to Schedule Starts Here*/
                                       $created_by = $this->session->userdata("user_id");
                                       $user_id = $this->session->userdata("user_id");
                                       $company_id = $this->session->userdata("company_id");
                                       $ip_address = $_SERVER['REMOTE_ADDR'];
                                      
                                        if(isset($add_task_to_schedule[$i]) && $add_task_to_schedule[$i]==1){
                                        $component_info = $this->mod_common->select_single_records("project_components", array("component_id" =>  $component_id[$i]));
                                        $schedule_project_info = $this->mod_common->select_single_records("project_scheduling_projects", array("parent_project_id" =>  $this->input->post('project_id')));
                                        
                                        $is_task_exists =  $this->mod_common->select_single_records("project_scheduling_tasks", array("parent_task_id" => $component_info["component_id"]));
                                        if(count($is_task_exists)==0){
                                            $task_array = array(
                                                "parent_task_id" => $component_info["component_id"],
                                                "name" => $component_info["component_name"],
                                                'created_by' => $created_by,
                                                'ip_address' => $ip_address,
                                                'company_id' => $company_id,
                                                "status"     => 1
                                                );
                                            $new_task_id = $this->mod_common->insert_into_table('project_scheduling_tasks', $task_array);
                                        }
                                        else{
                                          $new_task_id = $is_task_exists['id'];  
                                        }
                                        
                                        // Insert Item into Schedule
                                        
                                        $is_item_exists =  $this->mod_common->select_single_records("project_scheduling_items", array("task_id" => $new_task_id, "parent_item_id" => $new_costing_part_id));
                                        if(count($schedule_project_info)>0){
                                            if(count($is_item_exists)==0){
                                            
                                            $priority_info = $this->mod_common->select_single_records("project_scheduling_items", array("stage_id"=>$gstage_id[$i],"project_id"=>$schedule_project_info['id']), "MAX(priority) as priority");
                                            $item_array = array(
                                                "parent_item_id" => $new_costing_part_id,
                                                "project_id"=> $schedule_project_info['id'],
                            				    "stage_id" => $gstage_id[$i],
                                                "task_id" => $new_task_id,
                                                "start_date" => $schedule_project_info['start_date'],
                                                "end_date"   => $schedule_project_info['end_date'],
                                                "priority" => $priority_info["priority"]+1,
                                                "user_id" => $this->session->userdata("user_id")
                            		        );
                                                
                                            $item_id = $this->mod_common->insert_into_table('project_scheduling_items', $item_array);
                                            }
                                            else{
                                                $priority_info = $this->mod_common->select_single_records("project_scheduling_items", array("stage_id"=>$gstage_id[$i],"project_id"=>$schedule_project_info['id']), "MAX(priority) as priority");
                                                $item_array = array(
                                				    "stage_id" => $gstage_id[$i],
                                                    "user_id" => $this->session->userdata("user_id")
                                		        );
                                                    
                                                $this->mod_common->update_table('project_scheduling_items', array("task_id" => $new_task_id), $item_array); 
                                                $item_id = $is_item_exists['id'];
                                            }
                                         }
                                        //Get Checklists 
                                        $checklists = $this->mod_common->get_all_records("project_component_checklists", "*", 0, 0, array("component_id" =>  $component_id[$i]));
                                        if(count($checklists)>0){
                                            foreach($checklists as $checklist){
                                                $is_checklist_exists =  $this->mod_common->select_single_records("project_scheduling_item_checklists", array("parent_checklist_id" => $checklist["id"]));
                                                if(count($is_checklist_exists)==0){
                                                    $checklist_array = array(
                                                        "parent_checklist_id" => $checklist["id"],
                                                        "name" => $checklist["checklist"],
                                                        'project_id' => $schedule_project_info['id'],
                                                        'item_id' => $item_id,
                                                        'user_id' => $created_by
                                                    );
                                                    
                                                    $this->mod_common->insert_into_table('project_scheduling_item_checklists', $checklist_array);
                                                }
                                                else{
                                                    $checklist_array = array(
                                                        "parent_checklist_id" => $checklist["id"],
                                                        "name" => $checklist["checklist"],
                                                        'project_id' => $schedule_project_info['id'],
                                                        'item_id' => $item_id,
                                                        'user_id' => $created_by
                                                    );
                                                    
                                                    $this->mod_common->update_table('project_scheduling_item_checklists', array("parent_checklist_id" => $checklist["id"]), $checklist_array);
                                                }
                                            }
                                        }
                                        else{
                                                    $checklist_array = array(
                                                        "parent_checklist_id" => 0,
                                                        "name" => "In-Progress",
                                                        'project_id' => $schedule_project_info['id'],
                                                        'item_id' => $item_id,
                                                        'user_id' => $created_by
                                                    );
                                                    
                                                    $this->mod_common->insert_into_table('project_scheduling_item_checklists', $checklist_array);
                                                    
                                                    $checklist_array = array(
                                                        "parent_checklist_id" => 0,
                                                        "name" => "Complete",
                                                        'project_id' => $schedule_project_info['id'],
                                                        'item_id' => $item_id,
                                                        'user_id' => $created_by
                                                    );
                                                    
                                                    $this->mod_common->insert_into_table('project_scheduling_item_checklists', $checklist_array);
                                        }
                                        
                                      }
                                      
                                        /*Add Task to Schedule ends Here*/
                            	    }
                                }
                            
                                if ($costing) {
                                  $project_name = get_project_name($projectID);
                                  $this->session->set_flashdata('ok_message', 'Costing Parts have been saved against '.$project_name.' successfully.');
                    	          redirect(SURL."project_costing/edit_project_costing/".$this->input->post('project_id'));
                                }
                      }//end of if
                      else{
                        
                        $file = $_FILES['importcsv']['tmp_name'];
                        $handle = fopen($file, "r");
                        
                        $allowed = array('csv');
                        $filename = $_FILES['importcsv']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            $this->session->set_flashdata('err_message', 'Only CSV files are allowed.');
                            redirect(base_url() . 'project_costing/add_project_costing'); 
                        }
                        
                             $costing_array = array(
                                'project_id' => $this->input->post('project_id'),
                                'user_id' => $this->session->userdata('user_id'),
                                'company_id' => $this->session->userdata('company_id'),
                                'include_in_report' => 0,
                                'contract_allownce' => 0,
                                'total_quantity' => 0.00,
                                'takeoffdatas' => "",
                                'project_subtotal_1' => 0.00,
                                'project_subtotal_2' => 0.00,
                                'project_subtotal_3' => 0.00,
                                'is_costing_locked' => 0.00,
                                'over_head_margin' => 0.00,
                                'porfit_margin' => 0.00,
                                'tax_percent' => 15.00,
                                'price_rounding' => 0.00,
                                'contract_price' => 0.00,
                                'sale_price' => 0,
                                'status' => 1,  
                                "created_by" => $created_by,
                                "ip_address" => $ip_address,
                              );
                            
                             $costing = $this->mod_common->insert_into_table('project_costing', $costing_array);
                            
                        $data = array();
                        $k = 0;
                        
                        $ip_address = $_SERVER['REMOTE_ADDR'];
                        while ($data = fgetcsv($handle, 1000, ",", "'")) {
                            if ($k > 0) {
                                if(!isset($data[8])){
                                    $this->session->set_flashdata('err_message', 'File format is wrong. Please upload correct file.');
                                    redirect(base_url() . 'project_costing/add_project_costing'); 
                                }
                                if($data[0]!="" && $data[1]!="" && $data[2]!="" && $data[3]!="" && $data[4]!="" && $data[5]!="" && $data[6]!="" && $data[7]!="" && $data[8]!=""){
                                    //Adding New Stage if not exists
                                    $stage = array(
                                        'user_id' => $this->session->userdata('user_id'),
                                        'stage_name' => $data[0],
                                        'stage_status' => 1,
                                        'created_by' => $this->session->userdata('user_id'),
                                        'ip_address' => $ip_address,
                                        'company_id' => $this->session->userdata('company_id'),
                                    );
                    
                                    $existing_stage = $this->mod_common->select_single_records('project_stages', array('company_id' => $this->session->userdata('company_id'), 'stage_name' => $data[0]));
                                    
                                    if (count($existing_stage) == 0) {
                                         $stage_id = $this->mod_common->insert_into_table('project_stages', $stage);
                                    }
                                    else{
                                        $stage_id = $existing_stage["stage_id"];
                                    }
                                    
                                    //Adding New Supplier if not exists
                                    $supplier = array(
                                        'user_id' => $this->session->userdata('user_id'),
                                        'supplier_name' => $data[4],
                                        'supplier_status' => 1,
                                        'created_by' => $this->session->userdata('user_id'),
                                        'ip_address' => $ip_address,
                                        'company_id' => $this->session->userdata('company_id'),
                                    );
                    
                                    $existing_supplier = $this->mod_common->select_single_records('project_suppliers', array('company_id' => $this->session->userdata('company_id'), 'supplier_name' => $data[4]));
                                    
                                    if (count($existing_supplier) == 0) {
                                         $supplier_id = $this->mod_common->insert_into_table('project_suppliers', $supplier);
                                    }
                                    else{
                                        $supplier_id = $existing_supplier["supplier_id"];
                                    }
                                    
                                    //Adding New Component if not exists
                                    $component = array(
                                        'user_id' => $this->session->userdata('user_id'),
                                        'component_name' => $data[2],
                                        'component_des' => "",
                                        'component_uom' => $data[6],
                                        'component_uc' => $data[7],
                                        'supplier_id' => $supplier_id,
                                        'component_status' => 1,
                                        'created_by' => $this->session->userdata('user_id'),
                                        'ip_address' => $ip_address,
                                        'company_id' => $this->session->userdata('company_id'),
                                    );
                    
                                    $existing_component = $this->mod_common->select_single_records('project_components', array('company_id' => $this->session->userdata('company_id'), 'component_name' => $data[2]));
                                    
                                    if (count($existing_component) == 0) {
                                         $component_id = $this->mod_common->insert_into_table('project_components', $component);
                                    }
                                    else{
                                        $component_id = $existing_component["component_id"];
                                    }
                                    
                                    //Adding Costing Parts
                                    $is_projec_costing_part_exist = $this->mod_common->select_single_records("project_costing_parts", array("costing_id" => $costing, "costing_part_name" => $data[1], "stage_id" => $stage_id, "component_id" => $component_id,  "costing_supplier" => $supplier_id));
                                    if(count($is_projec_costing_part_exist)==0){
                                        $part = array(
                                          'costing_id' => $costing,
                                          'stage_id' => $stage_id,
                                          'component_id' => $component_id,
                                          'sub_category' => "",
                                          'costing_part_name' => $data[1],
                                          'costing_uom' => $data[6],
                                          'client_allowance' => 0,
                                          'margin' => 0,
                                          'line_cost' => $data[8],
                                          'line_margin' => $data[8],
                                          'type_status' => "estimated",
                                          'quantity_type' => "manual",
                                          'quantity_formula' => "",
                                          'formula_text' => "",
                                          'is_rounded' => 0,
                                          'is_locked' => 0,
                                          'include_in_specification' => 0,
                                          'hide_from_boom_mobile' => 0,
                                          'add_task_to_schedule' => 0,
                                          'costing_uc' => $data[7],
                                          'costing_supplier' => $supplier_id,
                                          'costing_quantity' => $data[5],
                                          'costing_type'   => "normal",
                                          'costing_tpe_id'   => 0,
                                          'costing_part_status' => 1,
                                          'comment' => ""
                                        );
                                    
                                        $this->mod_common->insert_into_table('project_costing_parts', $part);
                                    }
                                    else{
                                        $part = array(
                                          'costing_uom' => $data[6],
                                          'line_cost' => $data[8],
                                          'line_margin' => $data[8],
                                          'costing_uc' => $data[7],
                                          'costing_quantity' => $data[5]
                                        );
                                        
                                        $where = "costing_part_id ='" . $is_projec_costing_part_exist['costing_part_id'] . "'";
                                        $this->mod_common->update_table('project_costing_parts', $where, $part);
                                    }
                                }//end of if
                            }//end of if
                            $k++;
                        }//end of while
                        
                        //updating Project Costing Table
                        
                        $project_costing_info = $this->mod_common->select_single_records("project_costing", array("costing_id" => $costing));
                        
                        $project_costing_parts = $this->mod_common->get_all_records("project_costing_parts", "SUM('line_margin') as total_line_margin", 0, 0, array("costing_id" => $costing), "costing_part_id");
                        
                        $project_costing_parts = $project_costing_parts[0];
                        $psubtotal1 = $project_costing_parts["total_line_margin"];
                        $opercent = ($project_costing_info["over_head_margin"] / 100) * $psubtotal1;
                        $ppercent = ($project_costing_info["porfit_margin"] / 100) * $psubtotal1;
                        $total_cost2 = $opercent + $ppercent + $psubtotal1;
                        
                        $tax_percent = ($project_costing_info["tax_percent"] / 100) * $total_cost2;
                        $total_cost3 = $tax_percent + $total_cost2;
                        
                        $contract_price = $total_cost3+$project_costing_info["price_rounding"];
                    
                        $cUpdate = array(
                          'total_quantity' => $project_costing_parts["total_line_margin"],
                          'project_subtotal_1' => $project_costing_parts["total_line_margin"],
                          'project_subtotal_2' => number_format($total_cost2, 2, ".", ""),
                          'project_subtotal_3' => number_format($total_cost3, 2, ".", ""),
                          'is_costing_locked' => 0,
                          'over_head_margin' => $project_costing_info["over_head_margin"],
                          'porfit_margin' => $project_costing_info["porfit_margin"],
                          'tax_percent' => $project_costing_info["tax_percent"],
                          'takeoffdatas' => $project_costing_info["takeoffdatas"],
                          'price_rounding' => $project_costing_info["price_rounding"],
                          'contract_price' => number_format($contract_price, 2, ".", "")
                        );
                         $where = "costing_id ='" . $costing . "'";
                         $this->mod_common->update_table('project_costing', $where, $cUpdate);
                         $project_name = get_project_name($projectID);
                         $this->session->set_flashdata('ok_message', 'Costing Parts have been saved against '.$project_name.' successfully.');
                    	 redirect(SURL."project_costing/edit_project_costing/".$this->input->post('project_id'));
                    }//end of else
              	}//end of else
	    }//end of if
	    else{
	        $project_name = get_project_name($projectID);
            $this->session->set_flashdata('err_message', 'You have already saved costing against '.$project_name.'.');
	        redirect(SURL."project_costing");
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
    
        $html = $this->load->view('project_costing/populate_stages_for_project', $data, true);
        $rArray = array(
          "rData" => $html
        );
        echo json_encode($rArray);
        } else {
        
        }
}
	
	//Get Supplier Information By Selecting Component
	function getcompnent() {
        
        $supplier_id = $this->input->post('supplier_id');
        $costing_part_id = $this->input->post('costing_part_id');
        
        $cwhere = array('component_id' => $this->input->post('value'));
        $data['components'] = $this->mod_common->select_single_records('components', $cwhere);
        
        $swhere = array('supplier_id' => $data['components']["supplier_id"]);

        $data['suppliers'] = $this->mod_common->select_single_records('suppliers', $swhere);
        
        $data['components']["supplier_name"] = $data['suppliers']["supplier_name"];
        
        echo json_encode($data['components']);
    }

    //Verify Part
    public function verify_part() {

        $name = $this->input->post("name");
        
        $table = "project_costing_parts";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'costing_part_id !=' => $id,
            'costing_part_name' => $name,
          );
        }
        else{
          $where = array(
            'costing_part_name' => $name,
          );
        }

        $data['row'] = $this->mod_common->select_single_records($table, $where);

        if (empty($data['row'])) {
            echo "0";
        } else {
            echo "1";
        }
    }
    
    //Get Costing Parts By Template
    public function get_costing_by_template($id) {
        
		$data['next_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
		$todid = isset($_POST['todid']) ? $_POST['todid'] : "";

		if ($id > 0) {
		    
			$data['tpl_stages'] = $this->mod_project->get_stages_by_tempid($id);
			$data['tmpparts'] = $this->mod_project->get_costing_parts_by_template_id($id);
			$tdata['ctakeoffdata'] = $this->get_takeoff_data_used_in_template($data['tmpparts'], $todid);

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
        
		$html = $this->load->view('project_costing/populate_stages_for_template', $data, true);
		
		$data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($_POST["project_id"]);
        
        $prjParts = $data['prjprts'];
        $v = "0,";
        foreach ($prjParts AS $key => $val) {
    
          if ($val->quantity_type == "formula") {
            $vv = explode(',', $val->quantity_formula);
            for ($i = 0; $i < count($vv); $i++) {
    
              if (strpos($vv[$i], '|') !== false) {
                $take_of_data_formula = str_replace('|', '', $vv[$i]);
                $v .= "'" . $take_of_data_formula  . "',";
              }
            }
          }
        }
        $v = substr($v, 0, -1);
    
        $tdata['etakeoffdata'] = $this->mod_project->get_takeoff_data_by_ids($v);
        if($_POST["is_takeoffdata_exists"]==0){
           $takeoffdata = $this->load->view('project_costing/formula_calculation_table', $tdata, true); 
        }
        else{
           $takeoffdata = $this->load->view('project_costing/formula_calculation_table_ajax', $tdata, true);
        }
        $rArray = array("rData" => $html, "tData" => $takeoffdata);
		echo json_encode($rArray);
		} else {

		}
	}
	
	//Get Takeoffdata used in template
	function get_takeoff_data_used_in_template($tmpparts, $todid) {

        if ($todid != '0') {
            $v = $todid . ",";
        } else {
            $v = "0,";
        }

        foreach ($tmpparts AS $key => $val) {
            if ($val->tpl_quantity_type == "formula") {
              $vv = explode(',', $val->tpl_quantity_formula);
              for ($i = 0; $i < count($vv); $i++) {
               if (strpos($vv[$i], '|') !== false) {
                $take_of_data_formula = str_replace('|', '', $vv[$i]);
                $v .= "'" . $take_of_data_formula  . "',";
              }
            }
          }
        }
    
        $v = substr($v, 0, -1);
        $todata = $this->mod_project->get_takeoff_data_by_ids($v);
        return $todata;
}

    //Edit Project Costing Screen
    function edit_project_costing($id) {
        
    $this->stencil->title('Edit Project Costing');
      
    $this->mod_common->is_company_page_accessible(2);
    
    if ($id > 0) {

        $data['project_id'] = $id;
        
        $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        
        $data["extprojects"] = $this->mod_project->get_existing_project();
    
        $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id);
        
        $cid = $this->mod_project->get_costing_id_by_project($id);
        
        $data['stages'] = $this->mod_project->get_project_costing_stages($cid["costing_id"]);
        
        foreach($data["stages"] as $key => $stage){
            $data["stages"][$key]["costing_parts"] = $this->mod_project->get_costing_parts_by_stage($id, $stage["stage_id"]);
        }
    
        $prjParts = $data['prjprts'];
        
        $v = "0,";
        foreach ($prjParts AS $key => $val) {
    
          if ($val->quantity_type == "formula") {
            $vv = explode(',', $val->quantity_formula);
            for ($i = 0; $i < count($vv); $i++) {
    
              if (strpos($vv[$i], '|') !== false) {
                $take_of_data_formula = str_replace('|', '', $vv[$i]);
                $v .= "'" . $take_of_data_formula  . "',";
              }
            }
          }
        }
        $v = substr($v, 0, -1);
        $todata['ctakeoffdata'] = $data['ctakeoffdata'] = $this->mod_project->get_takeoff_data_by_ids($v);
        $todata['projectCosting'] = $this->mod_project->get_project_costing_by_project_id($id);
        $data['takeoffdata'] = $this->load->view('project_costing/formula_calculation_table', $todata, true);
        $data['pc_detail'] = $this->mod_project->get_project_costing_info($id);
        $data['project_name'] = get_project_name($id);
        $data['project_costing_id'] = $cid['costing_id'];
        $counter = count($data['prjprts']);
        
        if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'takeof_status' => 1);
        }
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, $cwhere, "takeof_id");

        $this->stencil->paint('project_costing/edit_project_costing', $data); 
    }
    else {
          redirect(SURL."nopage");
		}
}
	
	//Update Project Costing
	public function update_project_costing_process($costing){
	    
	    $this->mod_common->is_company_page_accessible(4);

        $p_id = $this->input->post('current_project_id');
        
        $selected_tab = $this->input->post('selected_tab');
        
        $project_costing_type = $this->input->post("project_costing_type");
        
        if($project_costing_type=="Manual"){

            $existingpartcosting= $this->mod_project->get_costingpart_ids_by_project($costing);
            
            $existingpartcostingarr=array();
            foreach ($existingpartcosting as $key => $value) {
              array_push($existingpartcostingarr,$value['costing_part_id'] );
            }
            
            if ($costing > 0) {
    
              $tods = $this->input->post('takeoffdatas');
              $todsarr = array();
              $jtods = "";
              if ($tods != "") {
                $xplodetods = explode(',', $tods);
               
                foreach ($xplodetods As $key => $val) {
                  $st = "td" . $val;
                  $p = 'todinput' . $val;
                  $vv = $this->input->post($p);
                  $todsarr[$st] = $vv;
                }
                $jtods = json_encode($todsarr);
              }
              
              if($this->input->post('contract_price')!=""){
               $contract_price = str_replace(",","",$this->input->post('contract_price'));
             }
             else{
               $contract_price = 0;   
             }
             
             $cUpdate = array(
              'total_quantity' => $this->input->post('total_cost'),
              'project_subtotal_1' => $this->input->post('total_cost'),
              'project_subtotal_2' => $this->input->post('total_cost2'),
              'project_subtotal_3' => $this->input->post('total_cost3'),
              'is_costing_locked' => $this->input->post('lockproject'),
              'over_head_margin' => $this->input->post('overhead_margin'),
              'porfit_margin' => $this->input->post('profit_margin'),
              'tax_percent' => $this->input->post('costing_tax'),
              'takeoffdatas' => $jtods,
              'price_rounding' => $this->input->post('price_rounding'),
              'contract_price' => $contract_price
            );
             $where = "costing_id ='" . $costing . "'";
             $part = $this->mod_common->update_table('project_costing', $where, $cUpdate);
    
             $stages = count($this->input->post('stage_id'));
             
             $part_name = $this->input->post('part_name');
             if($this->input->post('costing_part_id')){
             $costing_part_id = $this->input->post('costing_part_id');
             }
             else{
                 $costing_part_id = 0;
             }
             $component_uom = $this->input->post('component_uom');
             $component_uc = $this->input->post('component_uc');
             $is_locked = $this->input->post('is_line_locked');
             $component_id = $this->input->post('component_id');
             $quantity_type = $this->input->post('quantity_type');
             $quantity_formula = $this->input->post('formulaqty');
             $formula_text = $this->input->post('formulatext');
             if($this->input->post('is_rounded')){
                 $is_rounded = $this->input->post('is_rounded');
             }
             else{
                 $is_rounded = "";
             }
             $line_cost = $this->input->post('linetotal');
             $supplier_id = $this->input->post('supplier_id');
             $line_margin = $this->input->post('margin_line');
             $quantity = $this->input->post('manualqty');
             $allowances = $this->input->post('allowance');
             $margin = $this->input->post('margin');
             $typestatus = $this->input->post('status');
             $include_in_specification = $this->input->post('include_in_specification');
             $add_task_to_schedule = $this->input->post('add_task_to_schedule');
             $hide_from_boom_mobile = $this->input->post('hide_from_boom_mobile');
             $comments = $this->input->post('comments');
             $costing_tpe_id = $this->input->post('costing_tpe_id');
             $sub_category = $this->input->post('sub_category');
            
             $gstage_id = $this->input->post('stage_id');
             
            $updatedarr=array();
            for ($i = 0; $i < $stages; $i++) {
                 
                $costing_type = "normal";
                $costing_type_id = 0;
             if(isset($component_uom[$i]) && isset($margin[$i]) && isset($component_uc[$i]) && isset($quantity[$i])){
                  if(!(isset($comments[$i])) || ($comments[$i]==" ") || (empty($comments[$i]))){
                    $comments[$i]="";
                  }
                  else{
                    $comments[$i] = $comments[$i];
                  }
                  if(!(isset($is_locked[$i])) || ($is_locked[$i]==" ") || (empty($is_locked[$i]))){
                    $is_locked[$i]=0;
                  }
                  else{
                    $is_locked[$i] = $is_locked[$i];
                  }
                  if(!(isset($line_margin[$i])) || ($line_margin[$i]==".") || (empty($line_margin[$i]))){
                    $line_margin[$i]="0.00";
                  }
                  else{
                    $line_margin[$i]= $line_margin[$i];
                  }
        
                  if(!(isset($component_id[$i])) || ($component_id[$i]==" ") || (empty($component_id[$i]))){
                    $component_id[$i]=0;
                  }
                  else{
                    $component_id[$i] = $component_id[$i];
                  }
        
                  if(!(isset($part_name[$i])) || ($part_name[$i]==" ") || (empty($part_name[$i]))){
                    $part_name_text=0;
                  }
                  else{
                    $part_name_text = $part_name[$i];
                  }
        
                  if($part_name_text!='' || $part_name_text==0){
                       
                    $part = array(
                      'costing_id' => $costing,
                      'stage_id' => $gstage_id[$i],
                      'component_id' => $component_id[$i],
                      'sub_category' => $sub_category[$i],
                      'costing_part_name' => $part_name[$i],
                      'costing_uom' => $component_uom[$i],
                      'client_allowance' => (isset($allowances[$i]) && $allowances[$i]!="")?$allowances[$i]:0,
                      'margin' => $margin[$i],
                      'line_cost' => $line_cost[$i],
                      'line_margin' => $line_margin[$i],
                      'type_status' => $typestatus[$i],
                      'quantity_type' => $quantity_type[$i],
                      'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                      'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                      'is_rounded' => (isset($is_rounded[$i])?$is_rounded[$i]:0),
                      'is_locked' => $is_locked[$i],
                      'include_in_specification' => (isset($include_in_specification[$i]) && $include_in_specification[$i]!="")?$include_in_specification[$i]:0,
                      'hide_from_boom_mobile' => ($hide_from_boom_mobile[$i]=="")?0:$hide_from_boom_mobile[$i],
                      'add_task_to_schedule' => (isset($add_task_to_schedule[$i]) && $add_task_to_schedule[$i]!="")?$add_task_to_schedule[$i]:0,
                      'costing_uc' => $component_uc[$i],
                      'costing_supplier' => $supplier_id[$i],
                      'costing_quantity' => $quantity[$i],
                      'costing_type'   => $costing_type,
                      'costing_tpe_id'   => $costing_type_id,
                      'costing_part_status' => 1,
                      'comment' => $comments[$i]
                    );
                    
        
                    $where = "costing_part_id ='" . $costing_part_id[$i] . "'";
                    if(in_array($costing_part_id[$i],$existingpartcostingarr ))
                    { 
                      $this->mod_common->update_table('project_costing_parts', $where, $part);
                      $costing_part_idd =  $costing_part_id[$i];
        
                      array_push($updatedarr,$costing_part_id[$i] );
        
                    }else{
                      $costing_part_idd = $this->mod_common->insert_into_table('project_costing_parts', $part);
        
                    }
                    
                           /*Add Task to Schedule Starts Here*/
                           $created_by = $this->session->userdata("user_id");
                           $user_id = $this->session->userdata("user_id");
                           $company_id = $this->session->userdata("company_id");
                           $ip_address = $_SERVER['REMOTE_ADDR'];
                          
                            if(isset($add_task_to_schedule[$i]) && $add_task_to_schedule[$i]==1){
                            $component_info = $this->mod_common->select_single_records("project_components", array("component_id" =>  $component_id[$i]));
                            $schedule_project_info = $this->mod_common->select_single_records("project_scheduling_projects", array("parent_project_id" =>  $this->input->post('current_project_id')));
                            
                            $is_task_exists =  $this->mod_common->select_single_records("project_scheduling_tasks", array("parent_task_id" => $component_info["component_id"]));
                            if(count($is_task_exists)==0){
                            $task_array = array(
                                "parent_task_id" => $component_info["component_id"],
                                "name" => $component_info["component_name"],
                                'created_by' => $created_by,
                                'ip_address' => $ip_address,
                                'company_id' => $company_id,
                                "status"     => 1
                                );
                            $new_task_id = $this->mod_common->insert_into_table('project_scheduling_tasks', $task_array);
                            }
                            else{
                              $new_task_id = $is_task_exists['id'];  
                            }
                            
                            // Insert Item into Schedule
                            
                            $is_item_exists =  $this->mod_common->select_single_records("project_scheduling_items", array("task_id" => $new_task_id, "parent_item_id" => $costing_part_idd));
                            if(count($schedule_project_info)>0){
                                if(count($is_item_exists)==0){
                                
                                $priority_info = $this->mod_common->select_single_records("project_scheduling_items", array("stage_id"=>$gstage_id[$i],"project_id"=>$schedule_project_info['id']), "MAX(priority) as priority");
                                $item_array = array(
                                    "parent_item_id" => $costing_part_idd,
                                    "project_id"=> $schedule_project_info['id'],
                				    "stage_id" => $gstage_id[$i],
                                    "task_id" => $new_task_id,
                                    "start_date" => $schedule_project_info['start_date'],
                                    "end_date"   => $schedule_project_info['end_date'],
                                    "priority" => $priority_info["priority"]+1,
                                    "user_id" => $this->session->userdata("user_id")
                		        );
                                    
                                $item_id = $this->mod_common->insert_into_table('project_scheduling_items', $item_array);
                                }
                                else{
                                    $priority_info = $this->mod_common->select_single_records("project_scheduling_items", array("stage_id"=>$gstage_id[$i],"project_id"=>$schedule_project_info['id']), "MAX(priority) as priority");
                                    $item_array = array(
                    				    "stage_id" => $gstage_id[$i],
                                        "user_id" => $this->session->userdata("user_id")
                    		        );
                                        
                                    $this->mod_common->update_table('project_scheduling_items', array("task_id" => $new_task_id), $item_array); 
                                    $item_id = $is_item_exists['id'];
                                }
                            }
                            
                            //Get Checklists 
                            $checklists = $this->mod_common->get_all_records("project_component_checklists", "*", 0, 0, array("component_id" =>  $component_id[$i]));
                            if(count($checklists)>0){
                                foreach($checklists as $checklist){
                                    $is_checklist_exists =  $this->mod_common->select_single_records("project_scheduling_item_checklists", array("parent_checklist_id" => $checklist["id"]));
                                    if(count($is_checklist_exists)==0){
                                        $checklist_array = array(
                                            "parent_checklist_id" => $checklist["id"],
                                            "name" => $checklist["checklist"],
                                            'project_id' => $schedule_project_info['id'],
                                            'item_id' => $item_id,
                                            'user_id' => $created_by
                                        );
                                        
                                        $this->mod_common->insert_into_table('project_scheduling_item_checklists', $checklist_array);
                                    }
                                    else{
                                        $checklist_array = array(
                                            "parent_checklist_id" => $checklist["id"],
                                            "name" => $checklist["checklist"],
                                            'project_id' => $schedule_project_info['id'],
                                            'item_id' => $item_id,
                                            'user_id' => $created_by
                                        );
                                        
                                        $this->mod_common->update_table('project_scheduling_item_checklists', array("parent_checklist_id" => $checklist["id"]), $checklist_array);
                                    }
                                }
                            }
                            else{
                                $checklist_array = array(
                                                        "parent_checklist_id" => 0,
                                                        "name" => "In-Progress",
                                                        'project_id' => $schedule_project_info['id'],
                                                        'item_id' => $item_id,
                                                        'user_id' => $created_by
                                                    );
                                                    
                                                    $this->mod_common->insert_into_table('project_scheduling_item_checklists', $checklist_array);
                                                    
                                                    $checklist_array = array(
                                                        "parent_checklist_id" => 0,
                                                        "name" => "Complete",
                                                        'project_id' => $schedule_project_info['id'],
                                                        'item_id' => $item_id,
                                                        'user_id' => $created_by
                                                    );
                                                    
                                                    $this->mod_common->insert_into_table('project_scheduling_item_checklists', $checklist_array);
                            }
                            
                            
                          }
                            else{
                                $component_info = $this->mod_common->select_single_records("project_components", array("component_id" =>  $component_id[$i]));
                                $task_info =  $this->mod_common->select_single_records("project_scheduling_tasks", array("parent_task_id" => $component_info["component_id"]));
                                if(count($task_info)>0){
                                    $is_item_exists =  $this->mod_common->select_single_records("project_scheduling_items", array("task_id" => $task_info['id'], "parent_item_id" => $costing_part_idd));
                                    if(count($is_item_exists)>0){
                                        $this->mod_common->delete_record("project_scheduling_items", array("id" => $is_item_exists['id']));
                                        $this->mod_common->delete_record("project_scheduling_item_checklists", array("item_id" => $is_item_exists['id']));
                                    }
                                }
                            }
                          
                            /*Add Task to Schedule ends Here*/
                  }
             }
            }
            $diffarr=array_diff($existingpartcostingarr,$updatedarr);
    
       if($selected_tab=="edit_project_costing"){
            foreach ($diffarr as $kem => $vam) {
              $where = array('costing_part_id' => $vam);
              
              $costing_parts_info = $this->mod_common->select_single_records('project_costing_parts', $where);
              
              $pid = $this->mod_project->get_project_id_by_costing($costing_parts_info['costing_id']);
              
              $this->mod_common->delete_record('project_costing_parts', $where);
            }
       }
    
            if ($costing) {
            $this->session->set_flashdata('ok_message', 'Costing Parts Updated Successfully.');
            redirect(base_url() . 'project_costing/'.$selected_tab.'/' . $p_id);
            }
          }
            else{
                redirect(SURL."nopage");
            }
        }
        else{
            
            $file = $_FILES['importcsv']['tmp_name'];
            $handle = fopen($file, "r");
            
            $allowed = array('csv');
            $filename = $_FILES['importcsv']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                $this->session->set_flashdata('err_message', 'Only CSV files are allowed.');
                redirect(base_url() . 'project_costing/'.$selected_tab.'/' . $p_id); 
            }
                
            $data = array();
            $k = 0;
            
            $ip_address = $_SERVER['REMOTE_ADDR'];
            while ($data = fgetcsv($handle, 1000, ",", "'")) {
                if ($k > 0) {
                    if(!isset($data[8])){
                        $this->session->set_flashdata('err_message', 'File format is wrong. Please upload correct file.');
                        redirect(base_url() . 'project_costing/'.$selected_tab.'/' . $p_id); 
                    }
                    if($data[0]!="" && $data[1]!="" && $data[2]!="" && $data[3]!="" && $data[4]!="" && $data[5]!="" && $data[6]!="" && $data[7]!="" && $data[8]!=""){
                        //Adding New Stage if not exists
                        $stage = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'stage_name' => $data[0],
                            'stage_status' => 1,
                            'created_by' => $this->session->userdata('user_id'),
                            'ip_address' => $ip_address,
                            'company_id' => $this->session->userdata('company_id'),
                        );
        
                        $existing_stage = $this->mod_common->select_single_records('project_stages', array('company_id' => $this->session->userdata('company_id'), 'stage_name' => $data[0]));
                        
                        if (count($existing_stage) == 0) {
                             $stage_id = $this->mod_common->insert_into_table('project_stages', $stage);
                        }
                        else{
                            $stage_id = $existing_stage["stage_id"];
                        }
                        
                        //Adding New Supplier if not exists
                        $supplier = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'supplier_name' => $data[4],
                            'supplier_status' => 1,
                            'created_by' => $this->session->userdata('user_id'),
                            'ip_address' => $ip_address,
                            'company_id' => $this->session->userdata('company_id'),
                        );
        
                        $existing_supplier = $this->mod_common->select_single_records('project_suppliers', array('company_id' => $this->session->userdata('company_id'), 'supplier_name' => $data[4]));
                        
                        if (count($existing_supplier) == 0) {
                             $supplier_id = $this->mod_common->insert_into_table('project_suppliers', $supplier);
                        }
                        else{
                            $supplier_id = $existing_supplier["supplier_id"];
                        }
                        
                        //Adding New Component if not exists
                        $component = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'component_name' => $data[2],
                            'component_des' => $data[3],
                            'component_uom' => $data[6],
                            'component_uc' => $data[7],
                            'supplier_id' => $supplier_id,
                            'component_status' => 1,
                            'created_by' => $this->session->userdata('user_id'),
                            'ip_address' => $ip_address,
                            'company_id' => $this->session->userdata('company_id'),
                        );
        
                        $existing_component = $this->mod_common->select_single_records('project_components', array('company_id' => $this->session->userdata('company_id'), 'component_name' => $data[2]));
                        
                        if (count($existing_component) == 0) {
                             $component_id = $this->mod_common->insert_into_table('project_components', $component);
                        }
                        else{
                            $component_id = $existing_component["component_id"];
                        }
                        
                        //Adding Costing Parts
                        $is_projec_costing_part_exist = $this->mod_common->select_single_records("project_costing_parts", array("costing_id" => $costing, "costing_part_name" => $data[1], "stage_id" => $stage_id, "component_id" => $component_id,  "costing_supplier" => $supplier_id));
                        if(count($is_projec_costing_part_exist)==0){
                            $part = array(
                              'costing_id' => $costing,
                              'stage_id' => $stage_id,
                              'component_id' => $component_id,
                              'sub_category' => "",
                              'costing_part_name' => $data[1],
                              'costing_uom' => $data[6],
                              'client_allowance' => 0,
                              'margin' => 0,
                              'line_cost' => $data[8],
                              'line_margin' => $data[8],
                              'type_status' => "estimated",
                              'quantity_type' => "manual",
                              'quantity_formula' => "",
                              'formula_text' => "",
                              'is_rounded' => 0,
                              'is_locked' => 0,
                              'include_in_specification' => 0,
                              'hide_from_boom_mobile' => 0,
                              'add_task_to_schedule' => 0,
                              'costing_uc' => $data[7],
                              'costing_supplier' => $supplier_id,
                              'costing_quantity' => $data[5],
                              'costing_type'   => "normal",
                              'costing_tpe_id'   => 0,
                              'costing_part_status' => 1,
                              'comment' => ""
                            );
                            //print_r($part);exit;
                        
                            $this->mod_common->insert_into_table('project_costing_parts', $part);
                        }
                        else{
                            $part = array(
                              'costing_uom' => $data[6],
                              'line_cost' => $data[8],
                              'line_margin' => $data[8],
                              'costing_uc' => $data[7],
                              'costing_quantity' => $data[5]
                            );
                            
                            $where = "costing_part_id ='" . $is_projec_costing_part_exist['costing_part_id'] . "'";
                            $this->mod_common->update_table('project_costing_parts', $where, $part);
                        }
                    }//end of if
                }//end of if
                $k++;
            }//end of while
            
            //updating Project Costing Table
            
            $project_costing_info = $this->mod_common->select_single_records("project_costing", array("costing_id" => $costing));
            
            $project_costing_parts = $this->mod_common->get_all_records("project_costing_parts", "SUM('line_margin') as total_line_margin", 0, 0, array("costing_id" => $costing), "costing_part_id");
            
            $project_costing_parts = $project_costing_parts[0];
            $psubtotal1 = $project_costing_parts["total_line_margin"];
            $opercent = ($project_costing_info["over_head_margin"] / 100) * $psubtotal1;
            $ppercent = ($project_costing_info["porfit_margin"] / 100) * $psubtotal1;
            $total_cost2 = $opercent + $ppercent + $psubtotal1;
            
            $tax_percent = ($project_costing_info["tax_percent"] / 100) * $total_cost2;
            $total_cost3 = $tax_percent + $total_cost2;
            
            $contract_price = $total_cost3+$project_costing_info["price_rounding"];
        
            $cUpdate = array(
              'total_quantity' => $project_costing_parts["total_line_margin"],
              'project_subtotal_1' => $project_costing_parts["total_line_margin"],
              'project_subtotal_2' => number_format($total_cost2, 2, ".", ""),
              'project_subtotal_3' => number_format($total_cost3, 2, ".", ""),
              'is_costing_locked' => 0,
              'over_head_margin' => $project_costing_info["over_head_margin"],
              'porfit_margin' => $project_costing_info["porfit_margin"],
              'tax_percent' => $project_costing_info["tax_percent"],
              'takeoffdatas' => $project_costing_info["takeoffdatas"],
              'price_rounding' => $project_costing_info["price_rounding"],
              'contract_price' => number_format($contract_price, 2, ".", "")
            );
             $where = "costing_id ='" . $costing . "'";
             $this->mod_common->update_table('project_costing', $where, $cUpdate);
            $this->session->set_flashdata('ok_message', 'Costing Parts Updated Successfully.');
            redirect(base_url() . 'project_costing/'.$selected_tab.'/' . $p_id);
        }//end of else
	}
	
	//Get Costing Parts that includes in Specifications
    function specifications($id) {
    $this->stencil->title('Specifications');
      
    $this->mod_common->is_company_page_accessible(2);
    
    if ($id > 0) {

        $data['project_id'] = $id;
        
        //$data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        
        //$data["extprojects"] = $this->mod_project->get_existing_project();
    
        $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "specification");
        
        
        $prjParts = $data['prjprts'];
        
        $projctprts_with_stages = $data['prjprts'];
        $saved_stages = array();
        foreach ($projctprts_with_stages as $projctprt_with_stage) {
          $saved_stages[] = $projctprt_with_stage->stage_id;
        }
        $data['saved_stages'] = $saved_stages;
        $v = "0,";
        /*foreach ($prjParts AS $key => $val) {
    
          if ($val->quantity_type == "formula") {
            $vv = explode(',', $val->quantity_formula);
            for ($i = 0; $i < count($vv); $i++) {
    
              if (strpos($vv[$i], '|') !== false) {
                $take_of_data_formula = str_replace('|', '', $vv[$i]);
                $v .= "'" . $take_of_data_formula  . "',";
              }
            }
          }
        }
        $v = substr($v, 0, -1);
    
        $todata['ctakeoffdata'] = $this->mod_project->get_takeoff_data_by_ids($v);
        $todata['projectCosting'] = $this->mod_project->get_project_costing_by_project_id($id);
        $data['takeoffdata'] = $this->load->view('project_costing/formula_calculation_table', $todata, true);*/
    
    
        $data['pc_detail'] = $this->mod_project->get_project_costing_info($id);
        $data['project_name'] = get_project_name($id);
    
        $cid = $this->mod_project->get_costing_id_by_project($id);
        $data['project_costing_id'] = $cid['costing_id'];
        $counter = count($data['prjprts']);
    
    	if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1);
        }   

        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, $cwhere, "stage_id");
        
        /*if($this->session->userdata('company_id')>0){
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
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, $cwhere, "takeof_id");*/

        $this->stencil->paint('project_costing/specifications', $data); 
    }
    else {
          redirect(SURL."nopage");
		}
    }
    
    function updatecost_without_price($costing) {
        
      $this->mod_common->is_company_page_accessible(4);
      $project_id = $this->input->post('current_project_id');
      $costing_part_id = $this->input->post('costing_part_id');
      $stage_id = $this->input->post('stage_id');
      $part_name = $this->input->post('part_name');
      $comments = $this->input->post('comments');
      $component_id = $this->input->post('component_id');
      $is_line_locked = $this->input->post('is_line_locked');
      $selected_tab = $this->input->post('selected_tab');

      $counter = count($costing_part_id);

      for($i=0; $i<$counter; $i++){
          
        $part = array(
          'stage_id' => $stage_id[$i],
          'component_id' => $component_id[$i],
          'costing_part_name' => $part_name[$i],        
          'comment' => $comments[$i]
        );

        $where = array("costing_part_id"=>$costing_part_id[$i],"costing_id"=>$costing);

        $this->mod_common->update_table('project_costing_parts', $where, $part);
      }
      if ($costing) {
        $this->session->set_flashdata('ok_message', 'Costing Parts Updated Successfully.');
        redirect(SURL.'project_costing/'.$selected_tab.'/' . $project_id);
      }

    }

    //Get Costing Parts that includes in Allowances
    function allowances($id) {
        
    $this->stencil->title('Allowances');
      
    $this->mod_common->is_company_page_accessible(2);
    
    if ($id > 0) {

        $data['project_id'] = $id;
        
        /*$data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        
        $data["extprojects"] = $this->mod_project->get_existing_project();*/
    
        $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "allowance");
        
        $prjParts = $data['prjprts'];
        
        $projctprts_with_stages = $data['prjprts'];
        $saved_stages = array();
        foreach ($projctprts_with_stages as $projctprt_with_stage) {
          $saved_stages[] = $projctprt_with_stage->stage_id;
        }
        $data['saved_stages'] = $saved_stages;
        $v = "0,";
        /*foreach ($prjParts AS $key => $val) {
    
          if ($val->quantity_type == "formula") {
            $vv = explode(',', $val->quantity_formula);
            for ($i = 0; $i < count($vv); $i++) {
    
              if (strpos($vv[$i], '|') !== false) {
                $take_of_data_formula = str_replace('|', '', $vv[$i]);
                $v .= "'" . $take_of_data_formula  . "',";
              }
            }
          }
        }
        $v = substr($v, 0, -1);
    
        $todata['ctakeoffdata'] = $this->mod_project->get_takeoff_data_by_ids($v);
        $todata['projectCosting'] = $this->mod_project->get_project_costing_by_project_id($id);
        $data['takeoffdata'] = $this->load->view('project_costing/formula_calculation_table', $todata, true);*/
    
    
        $data['pc_detail'] = $this->mod_project->get_project_costing_info($id);
        $data['project_name'] = get_project_name($id);
    
        $cid = $this->mod_project->get_costing_id_by_project($id);
        $data['project_costing_id'] = $cid['costing_id'];
        $counter = count($data['prjprts']);
    
    	if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'stage_status' => 1);
        }   

        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, $cwhere, "stage_id");
        
        /*if($this->session->userdata('company_id')>0){
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
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, $cwhere, "takeof_id");*/

        $this->stencil->paint('project_costing/allowances', $data); 
    }
    else {
          redirect(SURL."nopage");
		}
    }
    
    //Report of Project Costing Parts
    public function report($type, $id){
        $this->stencil->title('Report');
        $this->mod_common->is_company_page_accessible(2);
        if ($id > 0 && $type!="") {
            $data['project_id'] = $id;
            $data['type'] = $type;
            $data['project_name'] = $this->mod_project->get_project_by_name($id);
            $data['project_info'] = $this->mod_project->get_project_info($id);
            $data['client_info'] = $this->mod_project->get_client_info($data['project_info']['client_id']);
            $data['pc_detail'] = $this->mod_project->get_project_costing_info($id);
            
            /*if($this->session->userdata('company_id')>0){
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
            
            $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, $cwhere, "supplier_id");*/
        
            if($type=="project_costing"){
               $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id); 
            }
            else if($type=="specification_costing" || $type=="specifications"){
            $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "specification");
            }
            else{
              $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "allowance");  
            }
            $cwhere = array('user_id' => $this->session->userdata('company_id'));
            $data['company_info'] = $this->mod_common->select_single_records('project_users', $cwhere);
            if($type=="specifications" || $type=="allowances"){
                $this->stencil->paint('project_costing/report_without_price', $data);
            }
            else{
               $this->stencil->paint('project_costing/report_with_price', $data);
            }
        }
        else{
            redirect(SURL."nopage");
        }
    }
    
    //Export in PDF Format
    public function export_pdf($type, $id){
        $this->mod_common->is_company_page_accessible(2);
        if ($id > 0 && $type!="") {
            $data['type'] = $type;
            $data['project_id'] = $id;
            $data['project_name'] = $this->mod_project->get_project_by_name($id);
            $data['project_info'] = $this->mod_project->get_project_info($id);
            $data['client_info'] = $this->mod_project->get_client_info($data['project_info']['client_id']);
            $data['pc_detail'] = $this->mod_project->get_project_costing_info($id);
            
            /*if($this->session->userdata('company_id')>0){
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
            
            $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, $cwhere, "supplier_id");*/
        
            if($type=="project_costing"){
               $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id); 
            }
            else if($type=="specifications"){
            $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "specification");
            }
            else{
              $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "allowance");  
            }
            
            $cwhere = array('user_id' => $this->session->userdata('company_id'));
            $data['company_info'] = $this->mod_common->select_single_records('project_users', $cwhere);
            
            if($type=="specifications" || $type=="allowances"){
                $html = $this->load->view('project_costing/pdf_without_price', $data, true); 
            }
            else{
                $html = $this->load->view('project_costing/pdf_with_price', $data, true);
            }
            
            $this->load->library('M_pdf');
            $pdfFilePath = $type."_".date('Y-m-d').".pdf";

            $this->m_pdf->pdf->WriteHTML($html);
            //$this->m_pdf->pdf->SetJS('app.alert("hello");');

            //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
        }
        else{
            redirect(SURL."nopage");
        }
    }
    
    //Export in Excel Format
    public function export_excel($type, $id){
        $this->mod_common->is_company_page_accessible(2);
        if ($id > 0 && $type!="") {
            $data['type'] = $type;
            $data['project_id'] = $id;
            $data['project_name'] = $this->mod_project->get_project_by_name($id);
            $data['project_info'] = $this->mod_project->get_project_info($id);
            $data['client_info'] = $this->mod_project->get_client_info($data['project_info']['client_id']);
            $data['pc_detail'] = $pc_detail = $this->mod_project->get_project_costing_info($id);
            
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
        
            if($type=="project_costing"){
               $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id); 
            }
            else if($type=="specifications"){
            $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "specification");
            }
            else{
              $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id, "allowance");  
            }
            
            $this->load->library('excel');
            
            if($type=="specifications" || $type=="allowances"){
                $my_data_titles = array(
 array(
  'stage_name'    => 'Project Name:',
  'costing_part_name'    => $data['project_name']['project_title'],
),

 array(
  'stage_name'    => 'Stage',
  'costing_part_name' => 'Part',
  'comment' => 'Comment',
  'component_name'    =>  'Component',
  'image'    =>  'Image',
)
);
$my_data = array();
foreach ($data['prjprts'] as $key => $prjprt) {

  foreach ($data['stages'] as $stage) {
    if ($prjprt->stage_id == $stage["stage_id"]) {
      $my_data[$key]['stage_name'] = $stage["stage_name"];
    } 
  }

  $my_data[$key]['costing_part_name'] = $prjprt->costing_part_name;
  $my_data[$key]['comment'] = $prjprt->comment;

  foreach ($data['components'] as $component) {
    if ($prjprt->component_id == $component["component_id"]) {
      $my_data[$key]['component_name'] = $component["component_name"];
    }
  }

}

$all_data = array_merge($my_data_titles, $my_data);

$res_count = count($data['prjprts']) + 2;
        //activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
        //name the worksheet
$this->excel->getActiveSheet()->setTitle('Costing Report');

$i=3;
    foreach ($data['prjprts'] as $key => $prjprt) {
        if($prjprt->component_image!=""){
        $gdImage = imagecreatefromjpeg(SURL.'assets/components/thumbnail/'.$prjprt->component_image);
        }
        else{
            $gdImage = imagecreatefromjpeg(SURL.'assets/img/image_placeholder.jpg');
        }
        if (!$gdImage)
        {
        $gdImage= imagecreatefromstring(file_get_contents(SURL.'assets/components/thumbnail/'.$prjprt->component_image));
        }
       
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(80);
        $objDrawing->setWidth(80);
        $objDrawing->setOffsetX(25);                    
        $objDrawing->setOffsetY(26);  
        $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(80);
        /*$this->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
        );*/
        $objDrawing->setCoordinates('E'.$i);
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        $i++;
    }
    $this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
            // read data to active sheet
    $this->excel->getActiveSheet()->fromArray($all_data);

        $filename=$type.'_report.xls'; //save our workbook as this file name
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
            }
            else{
                
    
        if(in_array(134, $this->session->userdata("permissions"))) {
        $my_data_titles = array(
           array(
            'stage_name'    => 'Project Name:',
            'costing_part_name'    => $data['project_name']['project_title'],
          ),
          array(

            'stage_name'                  => 'Stage',
            'sub_category'                  => 'Sub-Category',
            'costing_part_name'           => 'Part',
            'component_name'              =>  'Component',
            'component_description'       =>  'Component Description',
            'supplier_name'               =>  'Supplier',
            'qty'                         =>  'QTY',
            'unit_of_measure'             =>  'Unit Of Measure',
            'unit_cost'                   =>  'Unit Cost',
            'line_total'                  =>  'Line Total',
            'margin'                      =>  'Margin %',
            'line_total_with_margin'      =>  'Line Total with Margin',
            'status'                      =>  'Status',
            'include_in_specification'    =>  'Include in specifications',
            'client_allownce'             =>  'Client Allowance',
            'comment'             =>  'Comment',
            'hide_from_boom_mobile'    =>  'Hide From Boom Mobile',
            'add_task_to_schedule' => 'Add Task to Schedule'
          )
         );
        } 
        else{
            $my_data_titles = array(
              array(
            'stage_name'    => 'Project Name:',
            'costing_part_name'    => $data['project_name']['project_title'],
          ),
              array(

            'stage_name'                  => 'Stage',
            'sub_category'                  => 'Sub-Category',
            'costing_part_name'           => 'Part',
            'component_name'              =>  'Component',
            'component_description'       =>  'Component Description',
            'supplier_name'               =>  'Supplier',
            'qty'                         =>  'QTY',
            'unit_of_measure'             =>  'Unit Of Measure',
            'unit_cost'                   =>  'Unit Cost',
            'line_total'                  =>  'Line Total',
            'margin'                      =>  'Margin %',
            'line_total_with_margin'      =>  'Line Total with Margin',
            'status'                      =>  'Status',
            'include_in_specification'    =>  'Include in specifications',
            'client_allownce'             =>  'Client Allowance',
            'comment'             =>  'Comment',
            'hide_from_boom_mobile'    =>  'Hide From Boom Mobile'
          )
            );
        }
           
         $my_data = array();
         foreach ($data['prjprts'] as $key => $prjprt) {

          foreach ($data['stages'] as $stage) {
            if ($prjprt->stage_id == $stage["stage_id"]) {
              $my_data[$key]['stage_name'] = $stage["stage_name"];
            } 
          }
          $my_data[$key]['sub_category'] = $prjprt->sub_category;
          $my_data[$key]['costing_part_name'] = $prjprt->costing_part_name;

          foreach ($data['components'] as $component) {
            if ($prjprt->component_id == $component["component_id"]) {
              $component_info = get_component_info($component['component_id']);
              $my_data[$key]['component_name'] = escapeString($component["component_name"]).' ('.escapeString($component_info["supplier_name"]).'|'.$component_info["component_uc"].')';
              $my_data[$key]['component_des'] = $component_info["component_des"];
            }
          }
          foreach($data['suppliers'] as $supplier) {
           if ($prjprt->costing_supplier == $supplier["supplier_id"]) {
            $my_data[$key]['supplier_name'] = $supplier["supplier_name"];
          }
        } 
        $my_data[$key]['qty'] = number_format($prjprt->costing_quantity, 2, '.', '')." "; 
        $my_data[$key]['unit_of_measure'] = $prjprt->costing_uom;
        $my_data[$key]['unit_cost'] = number_format($prjprt->costing_uc, 2, '.', '')." "; 
        $my_data[$key]['line_total'] = number_format($prjprt->line_cost, 2, '.', '')." ";
        $my_data[$key]['margin'] = $prjprt->margin;
        $my_data[$key]['line_total_with_margin'] =number_format($prjprt->line_margin, 2, '.', '')." " ; 
        if ($prjprt->type_status == "estimated") {
         $my_data[$key]['status'] = "Estimated";
       }
       else if ($prjprt->type_status == "price_finalized") {
         $my_data[$key]['status'] = "Price finalized";
       }
       else if ($prjprt->type_status == "allowance") {
         $my_data[$key]['status'] = "Allowance";
       }	
       if ($prjprt->include_in_specification == 1) {
        $my_data[$key]['include_in_specification'] = "Yes";
      }
      else {
        $my_data[$key]['include_in_specification'] = "No";
      }
      if ($prjprt->client_allowance == 1) {
        $my_data[$key]['client_allowance'] = "Yes";
      }
      else {
        $my_data[$key]['client_allowance'] = "No";
      }

      $my_data[$key]['comment'] = $prjprt->comment;
      
      if ($prjprt->hide_from_boom_mobile == 1) {
        $my_data[$key]['hide_from_boom_mobile'] = "Yes";
      }
      else {
        $my_data[$key]['hide_from_boom_mobile'] = "No";
      }
      
      if(in_array(134, $this->session->userdata("permissions"))) {
         if ($prjprt->add_task_to_schedule == 1) {
        $my_data[$key]['add_task_to_schedule'] = "Yes";
      }
      else {
        $my_data[$key]['add_task_to_schedule'] = "No";
      } 
      }

    }
    $rowno = count($data['prjprts'])+1; 
    $my_data[$rowno]['project_subtotal'] = "";
    $my_data[$rowno]['project_subtotal1'] = "";
    
    $rowno++;
    $my_data[$rowno]['project_subtotal'] = "Project Subtotal";
    $my_data[$rowno]['project_subtotal1'] = "$".number_format($pc_detail->project_subtotal_1, 2, '.', '');
    
    $rowno++;
    
    $my_data[$rowno]['project_subtotal'] = "Overhead margin";
    $my_data[$rowno]['project_subtotal1'] = number_format($pc_detail->over_head_margin, 2, '.', '')."%";

    $rowno++;
    
    $my_data[$rowno]['project_subtotal'] = "Profit margin";
    $my_data[$rowno]['project_subtotal1'] = number_format($pc_detail->porfit_margin, 2, '.', '')."%";
    
    $rowno++;
    $my_data[$rowno]['project_subtotal'] = "Project Subtotal";
    $my_data[$rowno]['project_subtotal1'] = "$".number_format($pc_detail->project_subtotal_2, 2, '.', '');
    
    $rowno++;
    
    $my_data[$rowno]['project_subtotal'] = "Tax";
    $my_data[$rowno]['project_subtotal1'] = number_format($pc_detail->tax_percent, 2, '.', '')."%";
    
    $rowno++;
    $my_data[$rowno]['project_subtotal'] = "Project Subtotal";
    $my_data[$rowno]['project_subtotal1'] = "$".number_format($pc_detail->project_subtotal_3, 2, '.', '');
    
    $rowno++;
    $my_data[$rowno]['project_subtotal'] = "Project price rounding";
    $my_data[$rowno]['project_subtotal1'] = "$".number_format($pc_detail->price_rounding, 2, '.', '');
    $total1 = $data["pc_detail"]->project_subtotal_3;
    $total2 = $data["pc_detail"]->price_rounding;
    $gtotal = $total1 + $total2;
     $rowno++;
    $my_data[$rowno]['project_subtotal'] = "Project contract price";
    $my_data[$rowno]['project_subtotal1'] = "$".number_format($gtotal, 2, '.', '');
    
    $all_data = array_merge($my_data_titles, $my_data);
    $res_count = count($data['prjprts']) + 2;
        //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
        //name the worksheet
    $this->excel->getActiveSheet()->setTitle('Project Costing Report');

    $this->excel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle('A2:O2')->getFont()->setBold(true);
        // read data to active sheet
    $this->excel->getActiveSheet()->fromArray($all_data);
    
        $filename=$type.'_report.xls'; //save our workbook as this file name
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
            }
        }
        else{
            redirect(SURL."nopage");
        }
    }
    
    //Get Project Plans & Specifications
    public function plans_and_specifications($id){
    $this->session->unset_userdata("project_documents");
    $this->mod_common->is_company_page_accessible(2);
    $this->stencil->title('Plans & Specifications'); 
    $data['project_id'] = $id;
    $data['project_name'] = $this->mod_project->get_project_by_name($id);
    $data['plans_and_specifications'] = $this->mod_common->get_all_records('project_plans_and_specifications', "*", 0, 0, array("project_id"=>$id), "id");
    $this->stencil->paint('project_costing/project_plans_and_specifications', $data); 
    }
    
    //Upload Documents
    public function upload_documents(){
        
            $this->mod_common->is_company_page_accessible(4);
    	    $filename = "";
    	    
    	    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
						
						$projects_folder_path = './assets/project_plans_and_specifications/';
						$projects_folder_path_main = './assets/project_plans_and_specifications/';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = '*';
						$config['overwrite'] = false;
						$config['encrypt_name'] = false;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('file')) {
							
							$error_file_arr = array('error' => $this->upload->display_errors());
							
							print_r($error_file_arr);exit;
							
						} else {
                            
							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
						}
					}
    								  if($this->session->userdata("project_documents")==""){
    	                                   $this->session->set_userdata("project_documents", $_FILES['file']['name'].",");
    	                                   
    	                              }
    	                              else{
    	                                    $filename = $this->session->userdata("project_documents").$_FILES['file']['name'].",";
    	                                    $this->session->set_userdata("project_documents", $filename);
    	                               }
    	           
    	           copy('assets/project_plans_and_specifications/'.$filename, 'assets/scheduling/task_uploads/documents'.$filename);
    	           echo "Document Uploaded";

    	}
    
    //Remove Document	
    public function remove_file(){
    	    $file_name = $this->input->post("filename");
    	    if(file_exists("./assets/project_plans_and_specifications/".$file_name)){
    	        unlink("./assets/project_plans_and_specifications/".$file_name);
    	        if(file_exists("./assets/scheduling/task_uploads/documents/".$file_name)){
    	            unlink("./assets/scheduling/task_uploads/documents/".$file_name); 
    	        }
    	        $new_fle = str_replace($file_name.",", "", $this->session->userdata("project_documents"));
    	        $this->session->set_userdata("project_documents", $new_fle);
    	    }
    	}
    	
    //Save Document
    public function save_documents(){
        
        $this->mod_common->is_company_page_accessible(3);
        
        $project_id = $this->input->post("project_id");
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
    		    }
    		   $this->session->unset_userdata("project_documents");
    		   $this->session->set_flashdata('ok_message', "Project Plans & Specifications has been uploaded successfully");
    		   redirect(SURL."project_costing/plans_and_specifications/".$project_id);
    	}
    }
    
    //Download Uploaded Documents
    public function download($id){
        
        $this->mod_common->is_company_page_accessible(2);
        
        $plans_and_specifications = $this->mod_common->get_all_records('project_plans_and_specifications', "*", 0, 0, array("id"=>$id));
        $this->load->helper('download');
        $path = 'assets/project_plans_and_specifications/'.$plans_and_specifications[0]["document"];
        $data = file_get_contents($path); // Read the file's contents
        $name = $plans_and_specifications[0]["document"];
       force_download($name, $data);
    }
    
    //Delete all Documents
    public function delete_all_documents(){
        
        $this->mod_common->is_company_page_accessible(4);
        $selected_items = $this->input->post("selected_items");
        $project_id = $this->input->post("project_id");
        for($i=0;$i<count($selected_items);$i++){
            $file_info = $this->mod_common->select_single_records('project_plans_and_specifications', array("id"=>$selected_items[$i]));
            if(count($file_info)>0){
                $file_name = $file_info['document'];
                if($file_name!="" && file_exists("./assets/project_plans_and_specifications/".$file_name)){
        	        unlink("./assets/project_plans_and_specifications/".$file_name);
        	    }
                $this->mod_common->delete_record('project_plans_and_specifications', array("id" => $selected_items[$i]));
            }
        }
        $data["plans_and_specifications"] = $this->mod_common->get_all_records('project_plans_and_specifications', "*", 0, 0, array("project_id"=>$project_id), "id");
        $this->load->view('project_costing/documents_ajax', $data);
    }
    
    //Set Document Privacy
    public function set_as_private(){
        
        $this->mod_common->is_company_page_accessible(4);
        $selected_items = $this->input->post("selected_items");
        $project_id = $this->input->post("project_id");
        for($i=0;$i<count($selected_items);$i++){
            $this->mod_common->update_table('project_plans_and_specifications', array("id" => $selected_items[$i]), array("privacy" => 0));
        }
        $data["plans_and_specifications"] = $this->mod_common->get_all_records('project_plans_and_specifications', "*", 0, 0, array("project_id"=>$project_id), "id");
        $this->load->view('project_costing/documents_ajax', $data);
    }
    
    //Set Document Privacy
    public function set_as_share(){
        
        $this->mod_common->is_company_page_accessible(4);
        $selected_items = $this->input->post("selected_items");
        $project_id = $this->input->post("project_id");
        for($i=0;$i<count($selected_items);$i++){
            $this->mod_common->update_table('project_plans_and_specifications', array("id" => $selected_items[$i]), array("privacy" => 1));
        }
        $data["plans_and_specifications"] = $this->mod_common->get_all_records('project_plans_and_specifications', "*", 0, 0, array("project_id"=>$project_id), "id");
        $this->load->view('project_costing/documents_ajax', $data);
    }
    
    //Get Estimate Requests
    function estimate_request($id) {
      $this->session->set_flashdata("err_message", "You don't have permission to access this page");
      redirect(SURL."project_costing/edit_project_costing/".$id);
      $this->mod_common->is_company_page_accessible(2);
      $data['project_id'] = $id;
      $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, array("supplier_status" => 1), "supplier_id");
      $data['project_name'] = $this->mod_project->get_project_by_name($id);
      $this->stencil->title('Estimate Request \"fees apply\"');
      $this->stencil->paint('project_costing/estimate_request', $data);
    }
    
    //Send Estimate Request
    public function send_estimate_request()
	{
	    $project_id = $this->input->post("project_id");
	    $supplier_id = $this->input->post("supplier_id");
	    $description = $this->input->post("description");
	    
	    $ins_array = array("project_id" => $project_id,
		                    "supplier_id" => $supplier_id,
		                    "description" => $description,
		                    "company_id" => $this->session->userdata('company_id'),
		                    "user_id" => $this->session->userdata('user_id'));
		                  
		 $this->mod_common->insert_into_table("project_estimate_requests", $ins_array);
		 
		 $project_estimate_id = $this->db->insert_id();
		 
 
      // Looping all files
      $countfiles = count($_FILES['files']['name']);
      for($i=0;$i<$countfiles;$i++){
          
        if($_FILES['files']['name'][$i]!=""){
            
		$upload_folder_path = './assets/project_estimate_documents';
		$config['upload_path'] = $upload_folder_path;
		$config['allowed_types'] = '*';
		$config['max_size']	= '6000';
		$config['overwrite'] = false;
		$config['file_name'] = $_FILES['files']['name'][$i];
		$filename = $_FILES['files']['name'][$i];
		$_FILES['file']['name'] = $_FILES['files']['name'][$i];
        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
        $_FILES['file']['size'] = $_FILES['files']['size'][$i];
        
        $this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if($this->upload->do_upload('file')){
		 $ins_array = array("project_estimate_id" => $project_estimate_id,
		                    "document" => $filename);
		                  
		 $this->db->insert("project_estimate_documents", $ins_array);
		}
		else{
		    $error = array('error' => $this->upload->display_errors());
		    print_r($error);
		}
        }
		}
		
		$email = $this->session->userdata("email");
		$subject = 'Boom Estimate request for '.get_project_name($project_id);
		$message = '<table bgcolor="#ffffff" align="center" width="600" style="border-spacing: 0;padding:15px;">
											<tbody><tr><td>Your estimate request has been received and will be processed within 7 days. Please direct any queries to estimates@boom.net.nz.</td></tr></tbody></table>';
		
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
                    $this->email->from('estimates@boom.net.nz');
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->email->send();

		  
		
		$message = '<table bgcolor="#ffffff" align="center" width="600" style="border-spacing: 0;padding:15px;">
											<tbody><tr><td><b>Boom User Name:</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<td>'.$this->session->userdata("first_name").' '.$this->session->userdata("last_name").'</td></tr><tr><td><b>Boom User Email:</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<td>'.$this->session->userdata("email").'</td></tr><tr><td><b>Project Name :</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<td>'.get_project_name($project_id).'</td></tr><tr><td><b>Preferred Supplier :</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<td>'.get_supplier_name($supplier_id).'</td></tr><tr><td><b>Description :</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<td>'.$description.'</td></tr></tbody></table>';
			
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
                    $this->email->to("estimates@boom.net.nz");
                    $this->email->from($this->session->userdata("email"));
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->email->send();
		
		$notification = array(
		         "notify_from" => $this->session->userdata("user_id"),
		         "notify_from_role" => $this->session->userdata("user_role"),
		         "notify_to" => 0,
		         "notify_type" => 5,
		         "notify_ticket_id" => $project_estimate_id,
		         "notify_project_id" => $project_id
		        );
		//$this->mod_common->insert('tickets_notifications',$notification);
		
		
		echo "Estimate request sent successfully on ".date("d/m/Y").". We will contact you within 48 hours. Please direct any queries to estimates@boom.net.nz";exit;
	    
	}
	
	function update_component_unit_cost(){
        $id=$this->input->post('component_id');
        $unit_cost=$this->input->post('unit_cost');
        $where= array(

                'component_id' => $id

            );
       $update_array = array(

                'component_uc' => $unit_cost

            );
        $this->mod_common->update_table('project_components', $update_array, $where);
        
        $template_update_array = array(
            'tpl_part_component_uc' => $unit_cost
        );
        
        $this->mod_common->update_table('project_tpl_component_part', $template_update_array, $where);
        
        echo "s";
    }
	
	// Create Documents
	function create_documents($id) {
    
      $this->mod_common->is_company_page_accessible(2);
      
      $data['project_id'] = $id;
      
      $data['type'] = "specification";
      $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id);
      $prjParts = $data['prjprts'];
      $prjprt_with_documents = array();
      foreach ($prjParts as $key => $prjprt) {
        $is_component_have_documents = is_component_have_documents($prjprt->component_id, "specification");
        if (count($is_component_have_documents)>0) {
    
          $prjprt_with_documents[] = $prjprt;
    
        }
      }
    
    
      $data['prjprts'] = $prjprt_with_documents;
      
      $data['project_name'] = $this->mod_project->get_project_by_name($id);
      
      $this->stencil->title('Create Documents');
      $this->stencil->paint('project_costing/create_documents', $data);
   }
   
   //Get Component Documents
   function get_component_documents() {
    
      $this->mod_common->is_company_page_accessible(2);
      
      $id = $this->input->post("project_id");
      $type = $this->input->post("type");
      
      $data['project_id'] = $id;
      
      $data['type'] = $type;
    
      $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id);
      $prjParts = $data['prjprts'];
      $prjprt_with_documents = array();
      foreach ($prjParts as $key => $prjprt) {
        if($type=="checklist"){
            $checklists = get_checklist_items_for_builders($prjprt->component_id);
            if (count($checklists)>0) {
              $prjprt_with_documents[] = $prjprt;
        
            }
        }else{
            $is_component_have_documents = is_component_have_documents($prjprt->component_id, $type);
            if (count($is_component_have_documents)>0) {
              $prjprt_with_documents[] = $prjprt;
        
            }
        }
      }
    
      $data['prjprts'] = $prjprt_with_documents;
    
      $data['project_name'] = $this->mod_project->get_project_by_name($id);
      
      $this->load->view('project_costing/create_documents_ajax', $data);
}

   public function create_documents_pdf($id) {
    
 $this->load->library('M_pdf');
    
 $this->mod_common->is_company_page_accessible(4);
 
 $costing_parts_id = $this->input->post("selected_components");
 
 $data["type"] = $type = $this->input->post("type");
 
 if($costing_parts_id!=""){
     
   $filename = "";
     
  if($type=="specification"){
      $data["filename"] = $filename = "Technical_Specification_Document";
  }
  else{
      $data["filename"] = $filename = ucfirst($type)."_Document";
  }
  
  $data['project_id'] = $id;

  $data['prjprts'] = $this->mod_project->get_costing_parts_by_project_id($id);
  $prjParts = $data['prjprts'];
  $prjprt_with_documents = array();
  foreach ($prjParts as $key => $prjprt) {
    if($type=="checklist"){
        $checklists = get_checklist_items_for_builders($prjprt->component_id);
        if (count($checklists)>0) {
          $prjprt_with_documents[] = $prjprt;
    
        }
    }else{
        $is_component_have_documents = is_component_have_documents($prjprt->component_id, $type);
        if (count($is_component_have_documents)>0) {
          $prjprt_with_documents[] = $prjprt;
    
        }
    }
  }


      $data['prjprts'] = $prjprt_with_documents;
 
      $cwhere = array('user_id' => $this->session->userdata('company_id'));
      $data['company_info'] = $this->mod_common->select_single_records('project_users', $cwhere);
    
      $data['project_name'] = $this->mod_project->get_project_by_name($id);
    
      $data['project_info'] = $this->mod_project->get_project_info($id);
    
    
    $html = $this->load->view('project_costing/create_documents_pdf', $data, true);
    
    $pdfFilePath = $filename."_".date('Y-m-d').".pdf";
    
    $this->m_pdf->pdf->WriteHTML($html);
    
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
}
else{
    $this->session->set_flashdata("err_message", "Please select atleast one component to generate this report");
    redirect(base_url()."project_costing/create_documents/".$id);
}
}

   //Add new Project VIA Shortcut
   public function add_new_project(){
	    $ins_array = array(
    		'client_id' 						=>	$this->input->post('client_id'),
    		'user_id'							=>	$this->session->userdata('user_id'),
    		'company_id'						=>	$this->session->userdata('company_id'),
    		'project_title'						=>	$this->input->post('project_title'),
    		'project_des'						=>	$this->input->post('project_des'),
    		'project_legal_des'					=>	$this->input->post('project_legal_des'),
    		'project_status'					=>	$this->input->post('project_status'),
    		'project_address_city'				=>	$this->input->post('project_address_city'),
    		'project_address_state'				=>	$this->input->post('project_address_state'),
    		'project_address_country'			=>	$this->input->post('project_address_country'),
    		'project_zip'						=>	$this->input->post('project_zip'),
    		'street_pobox'						=>	$this->input->post('street_pobox'),
    		'suburb'							=>	$this->input->post('suburb'),
    		'bank_acount'						=>	$this->input->post('bank_acount')
		);
			
	    $addproject = $this->mod_common->insert_into_table('project_projects', $ins_array);
	    
	    // Add Project In Scheduling
					$start_date = DateTime::createFromFormat('d/m/Y', $this->input->post('proposed_start_date'));
                    $start_date = $start_date->format('Y-m-d');
        			$end_date = date('Y-m-d', strtotime($start_date. ' + 5 days'));
					$ins_array = array(
					            "parent_project_id" => $addproject,
				                "name" => $this->input->post('project_title'),
                                "description" => $this->input->post('project_des'),
                                "start_date" => $start_date,
                                "end_date" => $end_date,
				                "created_by" => $this->session->userdata("user_id"),
                                "ip_address" => $_SERVER['REMOTE_ADDR'],
                                "company_id" => $this->session->userdata("company_id"),
				                "status" => $this->input->post('project_status')
			       );
					
		           $project_scheduling_id = $this->mod_common->insert_into_table("project_scheduling_projects", $ins_array);
					
					 //Project Manager
                        $ins_array = array(
				            "project_id" => $project_scheduling_id,
				            "team_id" => $this->session->userdata("user_id"),
                            "team_role" => 1,
                            "token" => md5($this->session->userdata("user_id"))
			            );
					 
		                $this->mod_common->insert_into_table("project_scheduling_team", $ins_array);
	    
	    $projects = $this->mod_project->get_not_existing_project();
	    
	    $html ='<option value="" >Select Project</option>';
            foreach ($projects as $project) { 
                $html.='<option value="'.$project->project_id.'">'.$project->project_title.'</option>';
           } 
        echo $html;
	    
	}
	
	//Add new Client VIA Shortcut
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
}
