<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_variations extends CI_Controller {

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
             $this->load->model("mod_variation");

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(5);

    }
    
    //Manage Project Variations
    public function index()
	{
	    $this->mod_common->is_company_page_accessible(6);
	    
	    $table = 'project_variations';        
        $company_id = $this->session->userdata("company_id"); 
        $where = "company_id =".$company_id." AND project_id IN (SELECT project_id FROM project_projects WHERE project_status=1)";
        $data['variations'] = $this->mod_common->get_all_records($table, '*', 0, 0, $where, "id");
        
        $this->stencil->title('Project Variations');
	    $this->stencil->paint('project_variations/manage_variations', $data);
	}
	
	//Get Completed Job Variations
	function get_completed_job_variations() {
        $this->mod_common->is_company_page_accessible(6);
        $table = 'project_variations';        
        $company_id = $this->session->userdata("company_id"); 
        $where = "company_id =".$company_id." AND project_id IN (SELECT project_id FROM project_projects WHERE project_status=3)";
        $data['variations'] = $this->mod_common->get_all_records($table, '*', 0, 0, $where, "id");
        $this->load->view('project_variations/manage_variations_ajax', $data);
    }
    
    //Get Costing Stages
    public function getCostingStages() {

        $stages = $this->mod_project->get_costing_stages_by_projectid($this->input->post('value'));
        $option = '';
        foreach ($stages as $stage) {
            $option .='<option value="' . $stage->stage_id . '">' . $stage->stage_name . '</option>';
        }
        $costing_id = $this->mod_project->get_costing_detail_by_projectid($this->input->post('value'));
        $return_arr = array(
            "costing_id" => $costing_id->costing_id,
            "option" => $option
        );
        
        echo json_encode($return_arr);
    }
    
    //Get Costing Suppliers
    public function get_costing_suppliers(){
        $stage_id = $this->input->post("stage_id");
        $costing_id = $this->input->post("costing_id");
        if($stage_id!=""){
           $query =$this->db->query("SELECT distinct(c.costing_supplier), s.supplier_name FROM `project_costing_parts` c LEFT JOIN project_suppliers s ON s.supplier_id = c.costing_supplier WHERE c.costing_id = '".$costing_id."' AND c.stage_id ='".$stage_id."'");
        }
        else{
           $query =$this->db->query("SELECT distinct(c.costing_supplier), s.supplier_name FROM `project_costing_parts` c LEFT JOIN project_suppliers s ON s.supplier_id = c.costing_supplier WHERE c.costing_id = '".$costing_id."'");
         
        }
        $suppliers = $query->result_array();
        
        $option = '';
        foreach ($suppliers as $supplier) {
            $option .='<option value="' . $supplier['costing_supplier'] . '">' . $supplier['supplier_name'] . '</option>';
        }
        
        $return_arr = array(
            "option" => $option
        );
        
        echo json_encode($return_arr);
        
    }
    
    //Add Variation Screen
    public function add_variation() {
        
        $this->mod_common->is_company_page_accessible(7);
        $this->stencil->title('Add Variation');
        $data["projects"] = $this->mod_project->get_active_project();
        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
        $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
        $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
        $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        $data["extprojects"] = $this->mod_project->get_existing_project();
        $var_number=$this->mod_variation->lastinsertedvariationid();
        $data['var_number'] = $var_number;
        $this->stencil->paint('project_variations/add_variation', $data);
    }
    
    //View Variation Details
    public function view_variation($id) {
        
        $this->mod_common->is_company_page_accessible(6);
        
        $this->stencil->title('View Variation');

        $tablename = 'project_variations';
        $where = array('id' => $id);
        $data['variation_detail'] = $this->mod_common->select_single_records($tablename, $where);

        $data['clientid'] = $this->mod_project->getclient_id_by_prj_id($data['variation_detail']['project_id']);
        $data['clientnameinfo'] = $this->mod_common->getclientnameinfoby_client_id($data['clientid']);

        $tablename = 'project_variation_parts';
        $where = array('variation_id' => $id);
        $data['variation_parts'] = $this->mod_common->get_all_records($tablename, "*", 0, 0, $where, "id");

        if ($this->uri->segment(3) != "") {
            $where = array('stage_id' => $this->uri->segment(3));
            $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $where, "stage_id");
        }

        $where = array('company_id' => $this->session->userdata('company_id'), 'project_status' => 1);
        $fields = '`project_id`,`project_title`';
        $data['projects'] = $this->mod_common->get_all_records('project_projects', "*", 0, 0, $where, "project_id");

        $swhere = array('supplier_status' => 1);
        $data['suppliers'] = $this->mod_common->get_all_records('project_suppliers', "*", 0, 0, $swhere, "supplier_id");

        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
        $data['component'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, "component_id");
        $data['allcomponents'] = $data['component'];

        $data['eproject'] = $this->mod_project->get_existing_project();
        $data["stages"] = $this->mod_project->get_costing_stages_by_projectid($data['variation_detail']['project_id']);
        $data["components"] = $this->mod_project->get_costing_components_by_projectid($data['variation_detail']['project_id']);

        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        $fields = '`takeof_id`, `user_id`, `takeof_name`';
        $data['takeoffdatas'] = $this->mod_common->get_all_records('project_takeoffdata', "*", 0, 0, $cwhere, "takeof_id");
        
        $this->stencil->paint('project_variations/edit_variation', $data);

    }
    
    //Preview Variation Details
    public function preview($id="") {
       if($id!="" && $id>0){
        $data["title"] = "Variation";
        $tablename = 'project_variations';
        $where = array('id' => $id, 'company_id' => $this->session->userdata('company_id'));
        $data['variation_detail'] = $this->mod_common->select_single_records($tablename, $where);
        if(count($data['variation_detail'])>0){
        $data['clientid'] = $this->mod_project->getclient_id_by_prj_id($data['variation_detail']['project_id']);
        $data['clientnameinfo'] = $this->mod_common->getclientnameinfoby_client_id($data['clientid']);
        $this->load->view('project_variations/preview', $data);
        }
        else{
            echo redirect(SURL."nopage");
        }
       }
       else{
            echo redirect(SURL."nopage");
        }

    }
    
    //Get Costing Parts
    public function getCostingParts() {
        $lastRow = 1;
        $html="";
        $parts = $this->mod_project->get_costing_parts_by_project_stage($this->input->post('stage_id'), $this->input->post('supplier_id'), $this->input->post('costingId'));
        foreach ($parts as $key => $part) {
        $costingpartid = $part->costing_part_id;
        $data['costing_id_data'] = $this->mod_project->get_costing_id($costingpartid);
        
       
        $cwhere = array('costing_part_id' => $costingpartid);

        $data['partDetail'] = $partDetail = $this->mod_project->get_part_detail_by_cost_part_id($costingpartid);
        
        $supplier_ordered_quantity = get_supplier_ordered_quantity($data['partDetail']->costing_part_id);
        
        $data['recent_quantity'] = get_recent_variation_quantity($partDetail->costing_part_id, $partDetail->costing_supplier);
        $recent_total = 0;
        foreach($data['recent_quantity'] as $val){
            $recent_total += $val['total'];
        }
        $updated_total = 0;
        foreach($data['recent_quantity'] as $val){
            $updated_total = $val['updated_quantity'];
        }
        if(count($data['recent_quantity'])>0){
              if($partDetail->costing_type=="normal" || $partDetail->costing_type=="autoquote"){
               $uninvoicedquantity = ($partDetail->costing_quantity+$recent_total) - $supplier_ordered_quantity;
               $costing_quantity = ($partDetail->costing_quantity+$recent_total);
              }
              else{
                  $uninvoicedquantity = $updated_total - $supplier_ordered_quantity;
                   $costing_quantity = $updated_total;
              }
            }
            else{
               $uninvoicedquantity = $partDetail->costing_quantity - $supplier_ordered_quantity;
                $costing_quantity = $partDetail->costing_quantity;
            }
    
    if(($uninvoicedquantity)>0){
        $data['last_row'] = $lastRow;
       
        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        $fields = '`takeof_id`, `user_id`, `takeof_name`';
        $data['takeoffdatas'] = $this->mod_common->get_all_records('project_takeoffdata', "*", 0, 0, $cwhere, 'takeof_id');

        $html .= $this->load->view('project_variations/add_part_by_costingpart_id', $data, true);
        $lastRow++;

        }
        }
        echo $html;
       
    }
    
    //Add New Item
    public function populate_new_costing_row_for_variation() {
        
        $data['last_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;

        if($this->session->userdata('company_id')>0){
          $where = "company_id = ".$this->session->userdata('company_id')." AND";
        }else{
         $where = "user_id = ".$this->session->userdata('user_id')." AND";
        }   
       
        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
        $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, 'stage_id');
        
        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'component_status' => 1);
        $data['components'] = $this->mod_common->get_all_records('project_components', "*", 0, 0, $cwhere, 'component_id');
        
        $html = $this->load->view('project_variations/add_part', $data, true);
        echo $html;
    }
	
	//Get Supplier Info By Component
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
    
    //Verify Variation
    public function verify_variation() {

        $name = $this->input->post("name");
        
        $table = "project_variations";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'variation_name' => $name,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'variation_name' => $name,
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
    
    //Add New Variation
    public function saveprojectvariation() {
        
        $this->mod_common->is_company_page_accessible(7);
        
        $this->form_validation->set_rules('project_id', 'Project', 'required');
        $this->form_validation->set_rules('variname', 'Initiated Variation', 'required');
        $this->form_validation->set_rules('varidescription', 'Variation Description', 'required');
    		
        if ($this->form_validation->run() == FALSE)
    	{
    	    $this->mod_common->is_company_page_accessible(7);
            $this->stencil->title('Add Variation');
            $data["projects"] = $this->mod_project->get_active_project();
            $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
            $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
            $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
            $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
            $data["extprojects"] = $this->mod_project->get_existing_project();
            $var_number=$this->mod_variation->lastinsertedvariationid();
            $data['var_number'] = $var_number;
            $this->stencil->paint('project_variations/add_variation', $data);
    	}
    	else{

            $projectID = $this->input->post('project_id');
            $costing_id=$this->mod_project->get_costing_id_from_project_id($this->input->post('project_id'));
            
            $var_number = $this->mod_variation->lastinsertedvariationid();
            
            $var_number = $var_number + 10000000;
            
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
            $vdata = array(
                'created_by' => $this->session->userdata('user_id'),
                'variation_name' => $this->input->post('variname'),
                'variation_description' => $this->input->post('varidescription'),
                'project_id' => $this->input->post('project_id'),
                'var_number' => $var_number,
                'costing_id' => $costing_id['costing_id'],
                'project_subtotal1' => $this->input->post('total_cost'),
                'overhead_margin' => $this->input->post('overhead_margin'),
                'profit_margin' => $this->input->post('profit_margin'),
                'project_subtotal2' => $this->input->post('total_cost2'),
                'tax' => $this->input->post('costing_tax'),
                'project_subtotal3' => $this->input->post('total_cost3'),
                'project_price_rounding' => $this->input->post('price_rounding'),
                'project_contract_price' => $this->input->post('contract_price'),
                'status' => $this->input->post('variationstatus'),
                'hide_from_sales_summary' => (isset($_POST['hide_from_summary']) AND $_POST['hide_from_summary']=='1')?1:0,
                'is_variation_locked' => $this->input->post('lockproject'),
                'company_id' => $this->session->userdata('company_id'),
                 'ip_address' =>  $ip_address
            );
    
            $tablename = 'project_variations';
            $insert_variations = $this->mod_common->insert_into_table($tablename, $vdata);
            $vId = $this->db->insert_id();
    
            $partispp=array('var_number' => $insert_variations+10000000 );
            $wherepp = array('id' => $insert_variations);
            $this->mod_common->update_table('project_variations', $wherepp, $partispp);
    
            if ($vId > 0) {
                $count = 0;
                $stages = count($this->input->post('stage'));
                $costing_part_id = array_values($this->input->post('costing_part_id'));
                $gstage_id = array_values($this->input->post('stage'));
                $part_name = array_values($this->input->post('part'));
                $component_id = array_values($this->input->post('component'));
                $supplier_id = array_values($this->input->post('supplier_id'));
                $quantity_type = array_values($this->input->post('quantity_type'));
                $quantity = array_values($this->input->post('manualqty'));
                $formula_text = array_values($this->input->post('formulatext'));
                $quantity_formula = array_values($this->input->post('formulaqty'));
                $component_uom = array_values($this->input->post('uom'));
                $component_uc = array_values($this->input->post('ucost'));
                $line_cost = array_values($this->input->post('linetotal'));
                $margin = array_values($this->input->post('margin'));
                $line_margin = array_values($this->input->post('margin_line'));
                $typestatus = array_values($this->input->post('status'));
                $include_in_specification = array_values($this->input->post('include_in_specification'));
                $allowances = array_values($this->input->post('allowance'));
                $is_locked = array_values($this->input->post('is_line_locked'));
                $useradditionalcost = array_values($this->input->post('useradditionalcost'));
                $marginaddcost_line = array_values($this->input->post('marginaddcost_line'));
                $available_quantity = array_values($this->input->post('manualqty'));
                $change_quantity = array_values($this->input->post('changeQty'));
                $updated_quantity = array_values($this->input->post('updatedQty'));
                $is_including_pc = array_values($this->input->post('is_including_pc'));            
                $var_type = array_values($this->input->post('var_type'));
    
                for ($i = 0; $i < $stages; $i++) {
                     
                if($change_quantity[$i]!=0){
                if($var_type[$i]==1){
                    $costing_part = array(
                        'costing_id' => $costing_id['costing_id'],
                        'stage_id' => $gstage_id[$i],
                        'component_id' => $component_id[$i],
                        'costing_part_name' => $part_name[$i],                    
                        'costing_uom' => $component_uom[$i],
                        'costing_uc' => $component_uc[$i],                    
                        'costing_supplier' => $supplier_id[$i],
                        'margin' => $margin[$i],
                        'line_cost' => $line_cost[$i],
                        'quantity_type' => "manual",
                        'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                        'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                        'line_margin' => $line_margin[$i],
                        'type_status' => $typestatus[$i],
                        'is_locked' => $is_locked[$i],
                        'include_in_specification' => (isset($include_in_specification[$i])?$include_in_specification[$i]:0),                    
                        'client_allowance' => !is_numeric($allowances[$i])?0:$allowances[$i],
                        'costing_quantity' => $change_quantity[$i],                    
                        'costing_type' => 'norvar',
                        'costing_part_status' => 1,
                        'is_variated' => 1
                    );
    
                    $tablename = 'project_costing_parts';
                    $this->mod_common->insert_into_table($tablename, $costing_part);
                    $costing_partid = $this->db->insert_id(); 
    
                }
                else{
                    $costing_partid = $costing_part_id[$i];
                }
                    $part = array(                    
                        'project_id' => $this->input->post('project_id'),
                        'costing_id' => $costing_id['costing_id'],
                        'is_including_pc' => $is_including_pc[$i],
                        'variation_id' => $vId,
                        'stage_id' => $gstage_id[$i],
                        'costing_part_id' => $costing_partid,
                        'component_id' => $component_id[$i],
                        'part_name' => $part_name[$i],
                        'component_uom' => $component_uom[$i],
                        'allowance_check' => !is_numeric($allowances[$i])?0:$allowances[$i],
                        'margin' => $margin[$i],
                        'linetotal' => $line_cost[$i],
                        'quantity_type' => "manual",
                        'formulaqty' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                        'formulatext' => (isset($formula_text[$i])?$formula_text[$i]:""),
                        'margin_line' => $line_margin[$i],
                        'type_status' => $typestatus[$i],
                        'is_line_locked' => $is_locked[$i],
                        'include_in_specification' => (isset($include_in_specification[$i])?$include_in_specification[$i]:0),
                        'component_uc' => $component_uc[$i],
                        'supplier_id' => $supplier_id[$i],
                        'quantity' => $quantity[$i],
                        'status_part' => 1,
                        'available_quantity' => $available_quantity[$i],
                        'change_quantity' => $change_quantity[$i],
                        'updated_quantity' => $updated_quantity[$i],
                        'useradditionalcost' => $useradditionalcost[$i],
                        'marginaddcost_line' => $marginaddcost_line[$i]
                    );
    
                    if($is_including_pc[$i])
                        $part['part_name']=$part_name[$i];
                    $parts = $this->mod_common->insert_into_table('project_variation_parts', $part);
                }
                }
    
                if ($vId > 0) {
                    $this->session->set_flashdata('ok_message', 'Project Variation Added Successfully.');
                    redirect(base_url() . 'project_variations/view_variation/' . $vId);
                }
    
            }
    	}
    }
    
    //Update Project Variation
    public function updateprojectvariation() {
        
        $this->mod_common->is_company_page_accessible(8);
        
        if (empty($_POST['variation_id'])) {
            redirect(base_url() . 'dashboard');
        }
        $var_id = $this->input->post('variation_id');
        $vstatus = $this->input->post('status');
        $bvstatus = $this->mod_variation->getvariationstatusbyvarid($var_id);
        $existingvarpart = $this->mod_variation->get_varparts_ids_by_var_id($var_id);
        $existingvarpartarr = array();        
        $existingcostingparts = array();
        foreach ($existingvarpart as $key => $value) {

            array_push($existingvarpartarr,$value['id'] );
            array_push($existingcostingparts,$value['costing_part_id'] );
        }

        $vdata = array(
            'variation_name' => $this->input->post('variname'),
            'variation_description' => $this->input->post('varidescription'),
            'project_id' => $this->input->post('project_id'),
            'costing_id' => $this->input->post('costing_id'),
            'project_subtotal1' => $this->input->post('total_cost'),
            'overhead_margin' => $this->input->post('overhead_margin'),
            'profit_margin' => $this->input->post('profit_margin'),
            'project_subtotal2' => $this->input->post('total_cost2'),
            'tax' => $this->input->post('costing_tax'),
            'project_subtotal3' => $this->input->post('total_cost3'),
            'project_price_rounding' => $this->input->post('price_rounding'),
            'project_contract_price' => $this->input->post('contract_price'),            
            'costing_id' => $this->input->post('costing_id'),
            'hide_from_sales_summary' => (isset($_POST['hide_from_summary']) AND $_POST['hide_from_summary']=='1')?1:0,
            'status' => $this->input->post('variationstatus'),
            'is_variation_locked' => $this->input->post('lockproject')
        );

        $where = "id ='" . $var_id . "'";
        $part = $this->mod_common->update_table('project_variations', $where, $vdata);
      
        $is_including_pc = array_values($this->input->post('is_including_pc'));
        $stages = count($this->input->post('stage'));
        $costing_part_id = array_values($this->input->post('costing_part_id'));
        $variation_part_id = array_values($this->input->post('variation_part_id'));
        $gstage_id = array_values($this->input->post('stage'));
        $part_name = array_values($this->input->post('part'));
        $component_id = array_values($this->input->post('component'));
        $supplier_id = array_values($this->input->post('supplier_id'));
        $quantity_type = array_values($this->input->post('quantity_type'));
        $quantity = array_values($this->input->post('manualqty'));
        $formula_text = array_values($this->input->post('formulatext'));
        $quantity_formula = array_values($this->input->post('formulaqty'));
        $component_uom = array_values($this->input->post('uom'));
        $component_uc = array_values($this->input->post('ucost'));
        $line_cost = array_values($this->input->post('linetotal'));
        $margin = array_values($this->input->post('margin'));
        $line_margin = array_values($this->input->post('margin_line'));
        $typestatus = array_values($this->input->post('status'));
        $include_in_specification = array_values($this->input->post('include_in_specification'));
        $allowances = array_values($this->input->post('allowance'));
        $is_locked = array_values($this->input->post('is_line_locked'));
        $useradditionalcost = array_values($this->input->post('useradditionalcost'));
        $marginaddcost_line = array_values($this->input->post('marginaddcost_line'));
        $available_quantity = array_values($this->input->post('manualqty'));
        $change_quantity = array_values($this->input->post('changeQty'));
        $updated_quantity = array_values($this->input->post('updatedQty')); 
        $updatedarr = array();

        for ($i = 0; $i < $stages; $i++) {
            if($change_quantity[$i]>0){
                if($costing_part_id[$i]==0){
                    $costing_part = array(
                        'costing_id' => $this->input->post('costing_id'),
                        'stage_id' => $gstage_id[$i],
                        'component_id' => $component_id[$i],
                        'costing_part_name' => $part_name[$i],                    
                        'costing_uom' => $component_uom[$i],
                        'costing_uc' => $component_uc[$i],                    
                        'costing_supplier' => $supplier_id[$i],
                        'margin' => $margin[$i],
                        'line_cost' => $line_cost[$i],
                        'quantity_type' => "manual",
                        'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                        'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                        'line_margin' => $line_margin[$i],
                        'type_status' => $typestatus[$i],
                        'is_locked' => $is_locked[$i],
                        'include_in_specification' => (isset($include_in_specification[$i])?$include_in_specification[$i]:0),                    
                        'client_allowance' => !is_numeric($allowances[$i])?0:$allowances[$i],
                        'costing_quantity' => $change_quantity[$i],                    
                        'costing_type' => 'norvar',
                        'costing_part_status' => 1,
                        'is_variated' => 1
                    );
    
                    $tablename = 'project_costing_parts';
                    $this->mod_common->insert_into_table($tablename, $costing_part);
                    $new_costing_part_id = $this->db->insert_id();
                    
                }
                else{
                    if(in_array($costing_part_id[$i], $existingcostingparts)){ 
                    $costing_part = array(
                        'costing_id' => $this->input->post('costing_id'),
                        'stage_id' => $gstage_id[$i],
                        'component_id' => $component_id[$i],
                        'costing_part_name' => $part_name[$i],                    
                        'costing_uom' => $component_uom[$i],
                        'costing_uc' => $component_uc[$i],                    
                        'costing_supplier' => $supplier_id[$i],
                        'margin' => $margin[$i],
                        'line_cost' => $line_cost[$i],
                        'quantity_type' => "manual",
                        'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                        'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                        'line_margin' => $line_margin[$i],
                        'type_status' => $typestatus[$i],
                        'is_locked' => $is_locked[$i],
                        'include_in_specification' => (isset($include_in_specification[$i])?$include_in_specification[$i]:0),                    
                        'client_allowance' => !is_numeric($allowances[$i])?0:$allowances[$i],
                        'costing_quantity' => $change_quantity[$i]
                    );
    
                    $tablename = 'project_costing_parts';
                    $where = "costing_part_id ='" . $costing_part_id[$i]. "'";
                    $new_costing_part_id = $costing_part_id[$i];
                    }
                    else{
                        $costing_part = array(
                           'is_variated' => 0
                        );
    
                     $tablename = 'project_costing_parts';
                     $where = "costing_part_id ='" . $costing_part_id[$i]. "'";
                     $this->mod_common->update_table($tablename, $where, $costing_part);
                     $new_costing_part_id = $costing_part_id[$i];
                    }
                }
    
                $svariation_part_id = $variation_part_id[$i];
    
                $part = array(
                    'is_including_pc' => $is_including_pc[$i],
                    'variation_id' => $var_id,
                    'stage_id' => $gstage_id[$i],
                    'costing_part_id' => $new_costing_part_id,
                    'component_id' => $component_id[$i],
                    'part_name' => $part_name[$i],
                    'component_uom' => $component_uom[$i],
                    'allowance_check' => !is_numeric($allowances[$i])?0:$allowances[$i],
                    'margin' => $margin[$i],
                    'linetotal' => $line_cost[$i],
                    'quantity_type' => "manual",
                    'formulaqty' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                    'formulatext' => (isset($formula_text[$i])?$formula_text[$i]:""),
                    'margin_line' => $line_margin[$i],
                    'type_status' => $typestatus[$i],
                    'is_line_locked' => $is_locked[$i],
                    'include_in_specification' => (isset($include_in_specification[$i])?$include_in_specification[$i]:0),
                    'component_uc' => $component_uc[$i],
                    'supplier_id' => $supplier_id[$i],
                    'quantity' => $quantity[$i],
                    'status_part' => 1,
                    'available_quantity' => $available_quantity[$i],
                    'change_quantity' => $change_quantity[$i],
                    'updated_quantity' => $updated_quantity[$i],
                    'useradditionalcost' => $useradditionalcost[$i],
                    'marginaddcost_line' => $marginaddcost_line[$i]
                );
    
                $where = "id ='" . $variation_part_id[$i] . "'";
                //print_r($existingvarpartarr);exit;
                if (in_array($variation_part_id[$i], $existingvarpartarr)) {
                    $part = $this->mod_common->update_table('project_variation_parts', $where, $part);
                    array_push($updatedarr, $variation_part_id[$i]);
                } else {
    
                    $part['part_name']=$part_name[$i];
                    if($is_including_pc[$i])
                        $part['part_name']=$part_name[$i];
                    $part = $this->mod_common->insert_into_table('project_variation_parts', $part);
                }
            }
        }

        $diffarr = array_diff($existingvarpartarr, $updatedarr);

        foreach ($diffarr as $kem => $vam) {
            $where = array('id' => $vam);
		    $costing_part_info = $this->mod_common->get_all_records("project_variation_parts", "*", 0, 0, $where);
            $this->mod_common->delete_record('project_variation_parts', $where);
            
        }

        if ($vstatus == "APPROVED" && $bvstatus != 'APPROVED') {
            $variation_parts = $this->mod_variation->getnivariationpartsbyid($var_id);
            if((count($variation_parts))> 0){
                $costing= $this->input->post('costing_id');

                $stages = count($variation_parts['stage_id']);
                $variation_costing_part_id = $variation_parts['costing_part_id'];
                $part_name = $variation_parts['costing_part_name'];
                $component_uom = $variation_parts['costing_uom'];
                $component_uc = $variation_parts['costing_uc'];
                $is_locked = $variation_parts['is_locked'];
                $line_cost = $variation_parts['line_cost'];
                $quantity_type = $variation_parts['quantity_type'];
                $quantity_formula = $variation_parts['quantity_formula'];
                $formula_text = $variation_parts['formula_text'];
                $line_margin = $variation_parts['line_margin'];
                $component_id = $variation_parts['component_id'];                
                $supplier_id = $variation_parts['costing_supplier'];
                $quantity = $variation_parts['costing_quantity'];
                $allowances = $variation_parts['client_allowance'];
                $margin = $variation_parts['margin'];
                $line_margin = $variation_parts['line_margin'];
                $typestatus = $variation_parts['type_status'];
                $include_in_specification = $variation_parts['include_in_specification'];
                $gstage_id = $variation_parts['stage_id'];
                $is_variated = $variation_parts['variation_id'];
                $isp_variated = $variation_parts['variationp_id'];

                for ($i = 0; $i < $stages; $i++) {
                    $part = array(
                        'costing_id' => $costing,
                        'stage_id' => $gstage_id[$i],
                        'component_id' => $component_id[$i],
                        'costing_part_name' => $part_name[$i],
                        'costing_uom' => $component_uom[$i],
                        'client_allowance' => !is_numeric($allowances[$i])?0:$allowances[$i],
                        'margin' => $margin[$i],
                        'line_cost' => $line_cost[$i],
                        'quantity_type' => "manual",
                        'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                        'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                        'line_margin' => $line_margin[$i],
                        'type_status' => $typestatus[$i],
                        'is_locked' => $is_locked[$i],
                        'include_in_specification' => (isset($include_in_specification[$i])?$include_in_specification[$i]:0),
                        'costing_uc' => $component_uc[$i],
                        'costing_supplier' => $supplier_id[$i],
                        'costing_quantity' => $quantity[$i],
                        'costing_part_status' => 1,
                        'is_variated' => $is_variated[$i] ,
                        'isp_variated' => $isp_variated[$i],
                        'costing_type' => 'norvar' ,
                        'costing_tpe_id' => $is_variated[$i]
                    );
                    
                    $variation_costing_part_info = $this->mod_common->get_all_records('project_costing_parts', "*", 0, 0, array("costing_part_id"=>$variation_costing_part_id[$i], "costing_type"=>'norvar'), "costing_part_id");
                    
                    if(count($variation_costing_part_info)>0){
                       $parts = $this->mod_common->update_table('project_costing_parts', array("costing_part_id"=>$variation_costing_part_id[$i], "costing_type"=>'norvar'), $part);
                       $insert_id = $variation_costing_part_id[$i]; 
                    }
                    else{
                       $parts = $this->mod_common->insert_into_table('project_costing_parts', $part);
                       $insert_id = $this->db->insert_id();
                    }

                    $partispp=array('costingpartid_var' => $insert_id );
                    $wherepp = array('id' => $isp_variated[$i]);
                    $this->mod_common->update_table('project_variation_parts', $wherepp, $partispp);
                }
            }
        }

        if ($this->db->trans_status() === FALSE)
            $this->session->set_flashdata('err_message', 'An error occured while updating variation');
        else
            $this->session->set_flashdata('ok_message', 'Project Variation Updated Succesfully');
            redirect(SURL.'project_variations/view_variation/'. $var_id);
    }
    
    //Update Variation Details VIA Ajax Request
    function variation_update_ajax(){
        
        $id = $this->input->post('id');
        
        $type = $this->input->post('type');
        
        $va_total = $this->input->post('var_total');
        $va_round = $this->input->post('var_round');
        
        $var_number = $this->input->post('var_number');
        $column_name = $this->input->post('column_name');
        $column_value = $this->input->post('column_value');
        $where = array('var_number'=>$var_number);
        $cwhere = array('var_number'=>$var_number, $column_name=>$column_value);
        $is_updated = $this->mod_common->get_all_records('project_variations', "*", 0, 0, $cwhere,"id");
        if(count($is_updated)==0){
            $vdata = array(
                $column_name => $column_value
            );
            $update_variations = $this->mod_common->update_table('project_variations', $where, $vdata);
            
            /*if($type=="invoice"){
            
            $where = array('id'=>$id);
            
            if($column_name=="variation_description"){
                 $vdata = array(
                  "va_description" => $column_value
                );
                $this->mod_common->update_table('supplier_invoices', $vdata, $where);
            }
            
           $sidata = array(
                "va_total" => $va_total,
                "va_round" => $va_round,
            );
            
            
            $this->common->update('supplier_invoices', $sidata, $where);
            }
            else{*/
                 $where = array('id'=>$id);
        
            
              $sidata = array(
                "project_contract_price" => $va_total,
                "project_price_rounding" => $va_round,
            );
            
            
            $this->mod_common->update_table('project_variations', $where, $sidata);
                
            //}
            
            if($update_variations){
                echo "s";
            }
        }
        else{
             /*if($type=="invoice"){
            
            $where = array('id'=>$id);
            
            if($column_name=="variation_description"){
                 $vdata = array(
                  "va_description" => $column_value
                );
                $this->mod_common->update_table('supplier_invoices', $vdata, $where);
            }
            
           $sidata = array(
                "va_total" => $va_total,
                "va_round" => $va_round,
            );
            
            
            $this->mod_common->update_table('supplier_invoices', $sidata, $where);
            }
            else{*/
                 $where = array('id'=>$id);
        
            
              $sidata = array(
                "project_contract_price" => $va_total,
                "project_price_rounding" => $va_round,
            );
            
            
            $this->mod_common->update_table('project_variations', $where, $sidata);
                
            //}
            
            echo "s";
            
        }
    }
    
    //Get Project Costing Parts
    public function getCostingPartsbyProject() {
        
       $parts = $this->mod_project->get_costing_parts_by_project_stage($this->input->post('value'), 0, $this->input->post('costingId'));

        $option = '';

        $option .='<option value=""> Select Part </option>';

        foreach ($parts as $part) {

            $option .='<option value="' . $part->costing_part_id . '">' . $part->costing_part_name . '(' . $part->component_name . ')' . '</option>';

        }

        echo $option;

   }
   
    //Populate Project Costing Parts
    function populate_new_costing_row_by_cost_id() {

        $data['last_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
        $costingpartid = isset($_POST['costing_part']) ? $_POST['costing_part'] : 0;
        $data['costing_id_data'] = $this->mod_project->get_costing_id($costingpartid);
        $data['recent_quantity'] = $this->mod_project->get_recent_quantity($costingpartid)? : 0;
       
        $cwhere = array('costing_part_id' => $costingpartid);
        $data['partDetail'] = $this->mod_project->get_part_detail_by_cost_part_id($costingpartid);

        $html = $this->load->view('project_variations/add_part_by_costingpart_id', $data, true);
        
        echo $html;

    }
    
    //Get Component ID
    public function get_component_id() {

        $data['last_row'] = isset($_GET['last_row']) ? $_GET['last_row'] : 0;

        $data['costingpart'] = isset($_GET['costingpart']) ? $_GET['costingpart'] : 0;

        $data['stageid'] = isset($_GET['stageid']) ? $_GET['stageid'] : 0;
        $data['components'] = $this->mod_project->get_component_id($data['last_row'], $data['costingpart'], $data['stageid']);



        print_r($data['components']);

    }
    
    //Send Variation Details to Client
    public function variationsform($variation_id) {

        $data["title"] = "Variation";
        $data = array();

        $variation_data = $this->mod_common->get_variations($variation_id);

        $data['variation_data'] = $variation_data['result'];

        $tablename = 'project_variations';

        $where = array('id' => $variation_id, 'company_id' => $this->session->userdata('company_id'), 'status !=' => 'APPROVED', 'status !=' => 'SALES INVOICED', 'status !=' => 'PAID');

        $data['variation_detail'] = $this->mod_common->select_single_records($tablename, $where);
        
        if(count($data['variation_detail'])>0){

        $data['clientid'] = $this->mod_project->getclient_id_by_prj_id($data['variation_detail']['project_id']);

        $data['clientnameinfo'] = $this->mod_common->getclientnameinfoby_client_id($data['clientid']);


        if ($data['variation_data'] != '') {


            $data["email"] = $email = $data['variation_data'][0]['client_email_primary'];
            
            if (!is_dir('assets/contracts/'.$data['variation_detail']['company_id'])) {
                          mkdir('./assets/contracts/'.$data['variation_detail']['company_id'], 0777, TRUE);
            }
            if (!is_dir('assets/contracts/'.$data['variation_detail']['company_id'].'/'.$data['variation_detail']['id'])) {
                          mkdir('./assets/contracts/'.$data['variation_detail']['company_id'].'/'.$data['variation_detail']['id'], 0777, TRUE);
            }
            
            $html  = $this->load->view('project_variations/preview',$data, true);
                    
            $filename = "Contract".date("Y")."_".$data['variation_detail']['id'];
            $this->load->library('m_pdf');
 
           //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);
             
            //download it.
            $this->m_pdf->pdf->Output('./assets/contracts/'.$data['variation_detail']['company_id'].'/'.$data['variation_detail']['id'].'/'.$filename.'.pdf', "F");
                    
                    
            $emailtext = 'These are the following variations regarding your project'; 

            $emailtext .= 'Dear Customer there is some Variations in your contract Listing Showing in Attachment'; 
            
            $message = $this->load->view("email_templates/variation_template", $data, TRUE); 
		   
                   $subject = "Project Software Edit Variation";
                   
                   
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
                    $this->email->attach( SURL.'/assets/contracts/'.$data['variation_detail']['company_id'].'/'.$data['variation_detail']['id'].'/'.$filename.'.pdf');

            if ($this->email->send()) {

                $variation_status = "ISSUED";

                $partispp=array('status' => $variation_status );

                $wherepp = array('id' => $variation_id);

                $this->mod_common->update_table('project_variations', $wherepp, $partispp);

                $this->session->set_flashdata('ok_message', 'Variation Detail Send successfully to the client.');

                redirect(SURL.'project_variations/view_variation/'.$variation_id);


            } else {


                $this->session->set_flashdata('err_message', 'Error Occur while sending email to client.');

                redirect(SURL.'project_variations/view_variation/'.$variation_id);

            }

        }

        }
        else{
            redirect(SURL."nopage");
        }

    
}

    public function check_component_in_purchase_order(){
        $costing_part_id = $this->input->post("costing_part_id");
        $project_id = $this->input->post("project_id");
        $where = "costing_part_id =".$costing_part_id." AND purchase_order_id IN (SELECT id FROM project_purchase_orders WHERE project_id=".$project_id." AND order_status != 'Cancelled')";
        $is_component_used = $this->mod_common->select_single_records("project_purchase_order_items", $where);
        if(count($is_component_used)>0){
            $response = array("message" => "fail", "purchase_order_id" => $is_component_used["purchase_order_id"]);
            echo json_encode($response);
        }
        else{
             $response = array("message" => "success");
            echo json_encode($response);
        }
        
    }
    
    //Repopulate All Available Components
    public function repopulate_all_available_components() {
        $lastRow = $this->input->post('last_row');
        $html="";
        $parts = $this->mod_project->repopulate_costing_parts_by_project_stage($this->input->post('costingId'), $this->input->post('variation_id'));
        foreach ($parts as $key => $part) {
        $costingpartid = $part->costing_part_id;
        $data['costing_id_data'] = $this->mod_project->get_costing_id($costingpartid);
        
       
        $cwhere = array('costing_part_id' => $costingpartid);

        $data['partDetail'] = $partDetail = $this->mod_project->get_part_detail_by_cost_part_id($costingpartid);
        
        $supplier_ordered_quantity = get_supplier_ordered_quantity($data['partDetail']->costing_part_id);
        
        $data['recent_quantity'] = get_recent_variation_quantity($partDetail->costing_part_id, $partDetail->costing_supplier);
        $recent_total = 0;
        foreach($data['recent_quantity'] as $val){
            $recent_total += $val['total'];
        }
        $updated_total = 0;
        foreach($data['recent_quantity'] as $val){
            $updated_total = $val['updated_quantity'];
        }
        if(count($data['recent_quantity'])>0){
              if($partDetail->costing_type=="normal" || $partDetail->costing_type=="autoquote"){
               $uninvoicedquantity = ($partDetail->costing_quantity+$recent_total) - $supplier_ordered_quantity;
               $costing_quantity = ($partDetail->costing_quantity+$recent_total);
              }
              else{
                  $uninvoicedquantity = $updated_total - $supplier_ordered_quantity;
                   $costing_quantity = $updated_total;
              }
            }
            else{
               $uninvoicedquantity = $partDetail->costing_quantity - $supplier_ordered_quantity;
                $costing_quantity = $partDetail->costing_quantity;
            }
    
    if(($uninvoicedquantity)>0){
        $data['last_row'] = $lastRow;
       
        $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        $fields = '`takeof_id`, `user_id`, `takeof_name`';
        $data['takeoffdatas'] = $this->mod_common->get_all_records('project_takeoffdata', "*", 0, 0, $cwhere, 'takeof_id');

        $html .= $this->load->view('project_variations/add_part_by_costingpart_id', $data, true);
        $lastRow++;

        }
        }
        echo $html;
        
    }
    
}