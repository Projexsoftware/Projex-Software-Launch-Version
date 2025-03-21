<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmed_estimate extends CI_Controller {

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
             $this->load->model("mod_component");
             $this->load->model("mod_price_book");
             
             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(109);

    }
    
    //Manage Confirmed Estimates
    public function index() {
      $this->mod_common->is_company_page_accessible(110);

      $data['confirmed_estimate'] = $this->mod_project->get_all_confirm_estimates();

      $this->stencil->title('Confirmed Estimate');
	  $this->stencil->paint('confirmed_estimate/manage_confirmed_estimate', $data);
    }
    
   //Add Confirmed Estimate
   function add_confirmed_estimate() {
    $this->mod_common->is_company_page_accessible(111);
    
    $data['projects'] = $this->mod_project->get_active_pending_project();

    $this->stencil->title('Add Confirmed Estimate');
	$this->stencil->paint('confirmed_estimate/add_confirmed_estimate', $data);
  }
   
   //Get All Costing Parts
   function get_parts(){
      $costing_id = $this->input->post("project_id");
      $supplier_id = $this->input->post("supplier_id");
      $data['parts'] = $this->mod_project->get_parts_by_search($costing_id, $supplier_id);
      if(count($data['parts'])>0){
           $this->load->view("confirmed_estimate/get_all_parts", $data);
      }
      else{
          echo "<tr><td colspan='10' style='color:red;font-size:14px;'>Sorry No Results Found</td></tr>";
      }
  }
  
   //Send Request for Confirmation
   function send_for_confirmation(){
      $project_id = $this->input->post("selected_project_id");
      $supplier_id = $this->input->post("selected_supplier_id");
      
      $supplier_info = $this->mod_common->select_single_records('project_suppliers', array('supplier_id' => $supplier_id));
      $ip_address = $_SERVER['REMOTE_ADDR'];
      
      $confirm_estimate_data = array(
            "project_id" => $project_id,
            "company_id" => $this->session->userdata('company_id'),
            "supplier_id" => $supplier_info['parent_supplier_id'],
            "status" => 1,
            'ip_address' => $ip_address
          );
      $confirm_estimate_id = $this->mod_common->insert_into_table("project_confirm_estimates", $confirm_estimate_data);
      if($confirm_estimate_id){
          $costing_part_id = $this->input->post("costing_part_id");
          for($i=0;$i<count($costing_part_id);$i++){
              $user_notes = $this->input->post("user_notes_".$costing_part_id[$i]);
              $parts_data = array(
                  "confirm_estimate_id" => $confirm_estimate_id,
                  "costing_part_id" => $costing_part_id[$i],
                  "user_notes" => $user_notes,
                  );
              $this->mod_common->insert_into_table("confirm_estimate_parts", $parts_data);
              
          }
          $this->session->set_flashdata("ok_message", "Confirm Estimate #".$confirm_estimate_id." has been sent to ".$supplier_info['supplier_name']." for confirmation");
      }
      else{
          $this->session->set_flashdata("error_message", "Issue in adding confirm estimate. Please try again!");
      }
      redirect(SURL."confirmed_estimate");
  }
   
   //View Confirmed Estimate Details
   function view_confirmed_estimate($id) {
    $this->mod_common->is_company_page_accessible(110);
    $data['confirm_estimate_details'] = $this->mod_project->get_confirm_estimate_details($id);
    $this->stencil->title('Confirmed Estimate Details');
	$this->stencil->paint('confirmed_estimate/view_confirmed_estimate', $data);
  }
   
   //Get Suppliers
   function get_suppliers(){
      $project_id = $this->input->post("project_id");
      //$where = "supplier_status = 1 AND parent_supplier_id >0 AND supplier_id IN (SELECT costing_supplier FROM project_costing_parts WHERE costing_id IN (SELECT costing_id FROM project_costing WHERE project_id =".$project_id."))";
      $supplier_users = $this->mod_project->get_project_supplier_users($project_id);
      $html = '<label class="control-label"></label><select class="selectpicker search_options" data-live-search="true" data-style="select-with-transition" title="Select Supplier *" data-size="7" name="supplier_id" id="supplier_id" required="true"><option disabled> Choose Supplier</option>';
      foreach($supplier_users as $supplier){
        $html .='<option value="'.$supplier->supplier_id.'">'.$supplier->supplier_name.'</option>';  
      }
      $html .='</select>';
      
      echo $html;
  }
    
}