<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends CI_Controller {

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
             
             $this->mod_common->is_company_page_accessible(83);

        }
    
    //Manage Templates
	public function index()
	{
	    $this->mod_common->is_company_page_accessible(83);
        $data['templates'] = $this->mod_common->get_all_records("templates","*",0,0,array(),"template_id");
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
    					$count	= 0;
    					$q =1;
    					$stagecount	    = $this->input->post('stagecount');
    					$part_name	    = $this->input->post('part_name');
    					$component_uom	= $this->input->post('component_uom');
    					$component_uc	= $this->input->post('component_uc');
    					$component_id	= $this->input->post('component_id');
    					$supplier_id	= $this->input->post('supplier_id');
    					$quantity		= $this->input->post('manualqty');
    					$formula		= $this->input->post('formula');
    					$quantity_type  = $this->input->post('quantity_type');
    					$formulaqty		= $this->input->post('formulaqty');
    					$formulatext	= $this->input->post('formulatext');
    					$stage_id	    = count($this->input->post('stage_id'));
    					$gstage_id	    = $this->input->post('stage_id');
    					$count1	= 0;
    					
    					for($i=0;$i<$stage_id;$i++){
    						$s = $i+1;
    						
    						if(trim($quantity[$count1])=='')
    							$quantity[$count1]=0;														
    
    						$part = array(
    							'temp_id'							=>	$addtemplate,
    							'stage_id'							=>	$gstage_id[$i],
    							'user_id'							=>	$this->session->userdata('user_id'),
    							'company_id'						=>	$this->session->userdata('company_id'),
    							'component_id'						=>	$component_id[$count1],
    							'tpl_part_name'						=>	$part_name[$count1],
    							'tpl_part_component_uom'			=>	$component_uom[$count1],
    							'tpl_part_component_uc'				=>	$component_uc[$count1],
    							'tpl_part_supplier_id'				=>	$supplier_id[$count1],
    							'tpl_quantity'						=>	$quantity[$count1],
    							'tpl_quantity_type'					=>	$quantity_type[$count1],
    							'tpl_quantity_formula'				=>	$formula[$count1],
    							'quantity_formula_text'				=>	$formulatext[$count1],
    							'tpl_part_status'					=>	1
    						);			
    
    						$part = $this->mod_common->insert_into_table('tpl_component_part',$part);	
    						
    						$count1++;
    						
    						$count++;
    					}
    					
    			$this->session->set_flashdata('ok_message', 'New Template added successfully.');
    			redirect(SURL . 'templates');
		}
	}
	
	//Get Supplier Information
	function getcompnent() {
        
        $supplier_id = $this->input->post('supplier_id');
        $costing_part_id = $this->input->post('costing_part_id');
        
        $cwhere = array('component_id' => $this->input->post('value'));
        $data['components'] = $this->mod_common->select_single_records('components', $cwhere);
        
        /*if($supplier_id!="" && $costing_part_id!=""){
             $pwhere = "supplier_id = '".$supplier_id."' AND order_status !='Cancelled' AND id IN (SELECT purchase_order_id FROM purchare_order_items WHERE costing_part_id='".$costing_part_id."')";
             $purchase_orders = $this->common->get_data_by_where('purchare_order', $fields = false, $pwhere);
             if(count($purchase_orders)>0){
                 echo "error";exit;
             }
        }*/

        
        $swhere = array('supplier_id' => $data['components']["supplier_id"]);

        $data['suppliers'] = $this->mod_common->select_single_records('suppliers', $swhere);
        
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
    
    //Import Template Data by Existimg Template
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
	
	//Edit Template Screen
	public function edit_template($id) {
	    
		if ($id > 0) {
		    
			$data['template_edit'] = $this->mod_template->get_template($id);
			$data['template_id'] =$id;
			$data['tpl_stages'] = $this->mod_project->get_stages_by_tempid($id);
			$data['tparts'] = $this->mod_project->get_costing_parts_by_template_id($id);

			$this->stencil->title('Edit Template');
            $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
            $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
            $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
            $data["exttemplates"] = $this->mod_common->get_all_records("templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
            $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
            $this->stencil->paint('templates/edit_template', $data);   
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
	    $this->form_validation->set_rules('template_name', 'Template Name', 'required|is_unique[templates.template_name]');
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
    					$stagecount	    = $this->input->post('stagecount');
    					$part_name	    = $this->input->post('part_name');
    					$component_uom	= $this->input->post('component_uom');
    					$component_uc	= $this->input->post('component_uc');
    					$component_id	= $this->input->post('component_id');
    					$supplier_id	= $this->input->post('supplier_id');
    					$quantity		= $this->input->post('manualqty');
    					$formula		= $this->input->post('formula');
    					$quantity_type  = $this->input->post('quantity_type');
    					$formulaqty		= $this->input->post('formulaqty');
    					$formulatext	= $this->input->post('formulatext');
    					$stage_id	    = count($this->input->post('stage_id'));
    					$gstage_id	    = $this->input->post('stage_id');
    					$count1	= 0;
    					
    					for($i=0;$i<$stage_id;$i++){
    						$s = $i+1;
    						
    						if(trim($quantity[$count1])=='')
    							$quantity[$count1]=0;														
    
    						$part = array(
    							'temp_id'							=>	$id,
    							'stage_id'							=>	$gstage_id[$i],
    							'user_id'							=>	$this->session->userdata('user_id'),
    							'company_id'						=>	$this->session->userdata('company_id'),
    							'component_id'						=>	$component_id[$count1],
    							'tpl_part_name'						=>	$part_name[$count1],
    							'tpl_part_component_uom'			=>	$component_uom[$count1],
    							'tpl_part_component_uc'				=>	$component_uc[$count1],
    							'tpl_part_supplier_id'				=>	$supplier_id[$count1],
    							'tpl_quantity'						=>	$quantity[$count1],
    							'tpl_quantity_type'					=>	$quantity_type[$count1],
    							'tpl_quantity_formula'				=>	$formula[$count1],
    							'quantity_formula_text'				=>	$formulatext[$count1],
    							'tpl_part_status'					=>	1
    						);			
    
    						$part = $this->mod_common->insert_into_table('tpl_component_part',$part);	
    						
    						$count1++;
    						
    						$count++;
    					}
    		    }
    					
    			$this->session->set_flashdata('ok_message', 'Template updated successfully.');
    			redirect(SURL . 'setup/templates');
		}
	}

}
