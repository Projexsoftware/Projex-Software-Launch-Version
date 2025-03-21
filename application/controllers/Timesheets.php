<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheets extends CI_Controller {

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
              $this->load->model('mod_timesheet');
              $this->load->model("mod_variation");

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(105);

    }
    
    //Manage Timesheets
    public function index()
	{
	    $this->mod_common->is_company_page_accessible(106);
	   
	   $data['draft_timesheets'] = $this->mod_timesheet->get_draft_timesheets();
	   
	   $data['pending_timesheets'] = $this->mod_timesheet->get_pending_timesheets(); 
	 
	   $data['approved_timesheets'] = $this->mod_timesheet->get_approved_timesheets();
	   
	   $data['invoiced_timesheets'] = $this->mod_timesheet->get_invoiced_timesheets();
        
        $this->stencil->title('Manage Timesheets');
	    $this->stencil->paint('timesheets/manage_timesheets', $data);
	}
	
	//Add Timesheet Screen
	function add_timesheet()
	{
	   $this->mod_common->is_company_page_accessible(107);
	   
	   $data['projects'] = $this->mod_project->get_active_project();
	   
	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
	   $fields = '`stage_id`, `user_id`, `stage_name`';
       $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
	 
	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'user_status' => 1);
	   $fields = '`user_fname`, `user_id`, `user_lname`';
       $data['staff'] = $this->mod_common->get_all_records('project_users', "*", 0, 0, $cwhere, "user_id");
	   
       $this->stencil->title('Add Timesheet');
	   $this->stencil->paint('timesheets/add_timesheet', $data);
	}
	
	//Add New Item in Timesheet
	function importnew(){
	   $projects = $this->mod_project->get_active_project();
	   $last_row = $this->input->post("last_row");
	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
	   $fields = '`stage_id`, `user_id`, `stage_name`';
       $stages = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
       $last_row = $last_row++;
	    echo '<tr id="nitrnumber'.$last_row.'" row_no="'.$last_row.'">
                                      <td><input type="text" class="datepicker form-control" required name="date[]" id="date'.$last_row.'">'.form_error("date", '<div class="custom_error">', '</div>').'</td>
                                      <td>
                                        <select name="project_id[]" id="project_id'.$last_row.'" required class="selectpicker" title="Choose Project *" data-live-search="true" data-style="select-with-transition">
                                            <option value="">Select Project</option>
                                            ';
                                            foreach($projects as $project){ 
                                               echo '<option value="'.$project->costing_id.'">'.$project->project_title.'</option>';
                                         } 
                                        echo '</select>
                                      </td>
                                      <td>
                                          <select name="stage_id[]" id="stage_id'.$last_row.'" required class="selectpicker" title="Choose Stage *" data-live-search="true" data-style="select-with-transition">
                                            <option value="0">Select Stage</option>';
                                         foreach($stages as $stage){ 
                                              echo '<option value="'.$stage["stage_id"].'">'.$stage["stage_name"].'</option>';
                                            } 
                                        echo '</select>
                                      </td>
                                      <td><input type="text" class="form-control" name="details[]" id="details'.$last_row.'"></td>
                                      <td><input type="number" class="form-control" name="submitted_hours[]" id="submitted_hours'.$last_row.'"" required></td> 
                                      <td>
                                             <a href="javascript:void(0)" rno="'.$last_row.'" class="btn btn-danger btn-simple btn-icon deleterow" title="Delete Item"><i class="fa fa-trash delete fa-lg"></i></a>
                                      </td>
                                  </tr>';
	}
	
	//Create New Timesheet
	function inserttimesheetprocess(){
	    $this->form_validation->set_rules('user_id', 'Staff', 'required');
	    $this->form_validation->set_rules('project_id[]', 'Project', 'required');
	    $this->form_validation->set_rules('stage_id[]', 'Stage', 'required');
	    $this->form_validation->set_rules('submitted_hours[]', 'Submitted Hours', 'required');
	    $this->form_validation->set_rules('date[]', 'Date', 'required');
	    
	     if ($this->form_validation->run() == FALSE)
    	{
            $data['projects'] = $this->mod_project->get_active_project();
    	   
    	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
    	   $fields = '`stage_id`, `user_id`, `stage_name`';
           $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
    	 
    	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'user_status' => 1);
    	   $fields = '`user_fname`, `user_id`, `user_lname`';
           $data['staff'] = $this->mod_common->get_all_records('project_users', "*", 0, 0, $cwhere, "user_id");
    	   
           $this->stencil->title('Add Timesheet');
    	   $this->stencil->paint('timesheets/add_timesheet', $data);
    	}
    	else{
        	    $user_id = $this->input->post("user_id");
        	    $status = $this->input->post("status");
        	    $company_id = $this->session->userdata("company_id");
        	    
        	    //Timesheet Items
        	    $date = $this->input->post("date");
        	    $project_id = $this->input->post("project_id");
        	    $stage_id = $this->input->post("stage_id");
        	    $details = $this->input->post("details");
        	    $submitted_hours = $this->input->post("submitted_hours");
        	    $ip_address = $_SERVER['REMOTE_ADDR'];
        	    
        	    $q =  $this->db->query("SELECT * FROM project_timesheets WHERE user_id='".$user_id."' AND company_id='".$company_id."' ORDER BY id DESC LIMIT 1"); 
                
                $is_already_exists = $q->row_array();
                
                //if((count($is_already_exists)==0) || (count($is_already_exists)>0 && ($is_already_exists['status']=="Approved" || $is_already_exists['status']=="Invoiced") )){
                $start_date = date("Y-m-d");
                $end_date = date('Y-m-d', strtotime($start_date . " + 15 days"));
                $timesheet_array = array(
                                    'user_id' => $user_id,
                                    'company_id' => $company_id,
                                    'start_date' => $start_date,
                                    'end_date' => $end_date,
                                    'status' => $status,
                                    'ip_address' => $ip_address
                                );                        
                                
                $this->mod_common->insert_into_table('timesheets', $timesheet_array);
                $timesheet_id = $this->db->insert_id();
               /* }
                else{
                    $timesheet_id = $is_already_exists['id'];
                }*/
                if(count($date)>0){
                    for($i=0;$i<count($date);$i++){
                        
                        $date_format = explode("/", $date[$i]);
                        
                        $date_format = $date_format[2]."-".$date_format[1]."-".$date_format[0]; 
                        
                        $timesheet_items_array = array(
                                            'timesheet_id' => $timesheet_id,
                                            'stage_id' => $stage_id[$i],
                                            'project_id' => $project_id[$i],
                                            'details' => $details[$i],
                                            'submitted_hours' => $submitted_hours[$i],
                                            'date' => $date_format
                                        );
                        $this->mod_common->insert_into_table('timesheet_items', $timesheet_items_array);
                    }
               }
              $this->session->set_flashdata("ok_message", "Timesheet has been saved as ".$status."."); 
              if($status=="Draft"){
                 redirect(SURL."timesheets/update_timesheet/".$timesheet_id);
              }
              else{
                 redirect(SURL."timesheets/view/".$timesheet_id);
              }
    	}
	}
	
	//Edit Timesheet Screen
	function update_timesheet($id)
	{
	   $this->mod_common->is_company_page_accessible(108);
	   
	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'id' => $id, 'status' => 'Draft');
	   $fields = '*';
       $data['timesheet_info'] = $timesheet_info = $this->mod_common->select_single_records('project_timesheets', $cwhere);
	   
	   if(count($timesheet_info)>0){
	   $data['timesheet_items'] = $this->mod_timesheet->get_timesheet_items($id); 
	   
	   /*if(count($data['timesheet_items'])==0){
	       $this->session->set_flashdata('err_message', 'No Record(s) Found');
	       redirect(SURL."timesheets");
	   }*/
	   
	   $data['projects'] = $this->mod_project->get_active_project();
	   
	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
	   $fields = '`stage_id`, `user_id`, `stage_name`';
       $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
	 
	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'user_status' => 1);
	   $fields = '`user_fname`, `user_id`, `user_lname`';
       $data['staff'] = $this->mod_common->get_all_records('project_users', "*", 0, 0, $cwhere, "user_id");
	   
        $this->stencil->title('Edit Timesheet');
	    $this->stencil->paint('timesheets/update_timesheet', $data);
	   }
	   else{
	       $this->session->set_flashdata('err_message', 'No Record(s) Found');
	       redirect(SURL."timesheets");
	   }
	}
	
	//Update Timesheet
	function updatetimesheetprocess(){
	    
	    $this->form_validation->set_rules('project_id[]', 'Project', 'required');
	    $this->form_validation->set_rules('stage_id[]', 'Stage', 'required');
	    $this->form_validation->set_rules('submitted_hours[]', 'Submitted Hours', 'required');
	    $this->form_validation->set_rules('date[]', 'Date', 'required');
	    
	    $timesheet_id = $id = $this->input->post("timesheet_id");
	    
	     if ($this->form_validation->run() == FALSE)
    	{
    	    
           $cwhere = array('company_id' => $this->session->userdata('company_id'), 'id' => $id, 'status' => 'Draft');
    	   $fields = '*';
           $timesheet_info = $this->mod_common->select_single_records('project_timesheets', $cwhere);
    	   
    	   if(count($timesheet_info)>0){
    	   $data['timesheet_items'] = $this->mod_timesheet->get_timesheet_items($id); 
    	   
    	   $data['projects'] = $this->mod_project->get_active_project();
    	   
    	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'stage_status' => 1);
    	   $fields = '`stage_id`, `user_id`, `stage_name`';
           $data['stages'] = $this->mod_common->get_all_records('project_stages', "*", 0, 0, $cwhere, "stage_id");
    	 
    	   $cwhere = array('company_id' => $this->session->userdata('company_id'), 'user_status' => 1);
    	   $fields = '`user_fname`, `user_id`, `user_lname`';
           $data['staff'] = $this->mod_common->get_all_records('project_users', "*", 0, 0, $cwhere, "user_id");
    	   
            $this->stencil->title('Edit Timesheet');
    	    $this->stencil->paint('timesheets/update_timesheet', $data);
    	   }
    	    
	   }
	   else{
    	    
    	    $status = $this->input->post("status");
    	    
    	    $this->mod_common->update_table('timesheets', array("id"=>$timesheet_id), array("status"=>$status));
    	    
    	    $existingtimesheetitems = $this->mod_timesheet->get_timesheet_items($timesheet_id); 
    
            $existingtimesheetitemsarr = array();
            
            foreach ($existingtimesheetitems as $key => $value) {
                array_push($existingtimesheetitemsarr,$value['id'] );
            }
    	    
    	    //Timesheet Items
    	    $date = $this->input->post("date");
    	    $item_id = $this->input->post("item_id");
    	    $project_id = $this->input->post("project_id");
    	    $stage_id = $this->input->post("stage_id");
    	    $details = $this->input->post("details");
    	    $submitted_hours = $this->input->post("submitted_hours");
    	  
            if(count($date)>0){
                for($i=0;$i<count($date);$i++){
                    
                    $date_format = explode("/", $date[$i]);
                    
                    $date_format = $date_format[2]."-".$date_format[1]."-".$date_format[0]; 
                    
                    $timesheet_items_array = array(
                                        'timesheet_id' => $timesheet_id,
                                        'stage_id' => $stage_id[$i],
                                        'project_id' => $project_id[$i],
                                        'details' => $details[$i],
                                        'submitted_hours' => $submitted_hours[$i],
                                        'date' => $date_format
                                    );
                    if($item_id[$i]>0){
                        $this->mod_common->update_table('timesheet_items', array("id"=>$item_id[$i]),  $timesheet_items_array);
                        $timesheetdone = $item_id[$i];
                        $existingtimesheetitemsarr = array_diff($existingtimesheetitemsarr, array($timesheetdone));
                    }
                    else{
                    $this->mod_common->insert_into_table('timesheet_items', $timesheet_items_array);
                    }
                    
                }
                
                //remove deleted items
                
                foreach ($existingtimesheetitemsarr as $key => $value) {
                    $where 			= array('id' => $value);
    		        $costing_part_info = $this->mod_common->get_data_by_where('timesheet_items',$fields = false,$where);
                    $this->mod_common->delete('timesheet_items', array('id'=>$value));
                } 
           }
              $this->session->set_flashdata("ok_message", "Timesheet has been saved as ".$status."."); 
              if($status=="Draft"){
                 redirect(SURL."timesheets/update_timesheet/".$timesheet_id);
              }
              else{
                 redirect(SURL."timesheets/view/".$timesheet_id);
              }
	   }
	}
	
	//View Timesheet
	function view($id)
	{
	   $this->mod_common->is_company_page_accessible(106);
	   
	   $data['timesheet_items'] = $this->mod_timesheet->get_timesheet_items($id); 
	   
	   if(count($data['timesheet_items'])>0 && $data['timesheet_items'][0]['timesheet_status']!="Draft"){
	   
       $data['projects'] = $this->mod_timesheet->get_timesheet_projects($id);
       
       $this->stencil->title('View Timesheet');
	    $this->stencil->paint('timesheets/view_timesheet_items', $data);
       
	   }
	   else{
	       redirect(SURL."timesheets");
	   }
	}
	
	//Update Status from Pending to Approved of a Timesheet
	function approved_timesheet_process(){
	    $this->mod_common->is_company_page_accessible(108);
	    $timesheet_id = $this->input->post("timesheet_id");
	    $timesheet_item_id = $this->input->post("timesheet_item_id");
	    $approved_hours = $this->input->post("approved_hours");
	    $cost = $this->input->post("cost");
	    $subtotal = $this->input->post("subtotal");
	    
	    $update_array = array(
	       "status" => "Approved"
	   );
	   $where = array(
	           "id" => $timesheet_id
	   );
	   $this->mod_common->update_table('timesheets', $where, $update_array);
	       
	    for($i=0;$i<count($timesheet_item_id);$i++){
	        if($approved_hours[$i]>0){
	        $update_array = array(
	               "approved_hours" => $approved_hours[$i],
	               "cost" => $cost[$i],
	               "subtotal" => $subtotal[$i]
	            );
	       $where = array(
	           "id" => $timesheet_item_id[$i]
	           );
	       $this->mod_common->update_table('timesheet_items', $where,  $update_array);
	        }
	    }
	    $this->session->set_flashdata("ok_message", "Timesheet has been approved");
	    redirect(base_url().'timesheets/view/'.$timesheet_id);
	}
	
	//Add Supplier Invoice
	function add_invoice()
	{
	    $this->mod_common->is_company_page_accessible(108);
	 
	    if($this->input->post("timesheet_id")!=""){
             $data['timesheet_id'] = $this->input->post("timesheet_id");
             $this->session->set_userdata("timesheet_id", $this->input->post("timesheet_id"));
	    }
	    else{
	        $data['timesheet_id'] = $this->session->userdata("timesheet_id");
	    }
	    if($this->input->post("project_id")!=""){
             $data['project_id'] = $project_id = $this->input->post("project_id");
              $this->session->set_userdata("project_id", $this->input->post("project_id"));
	    }
	    else{
	        $data['project_id'] = $project_id = $this->session->userdata("project_id");
	    }
	    if($this->input->post("project_title")!=""){
             $data['project_title'] = $this->input->post("project_title");
             $this->session->set_userdata("project_title", $this->input->post("project_title"));
	    }
	    else{
	        $data['project_title'] = $this->session->userdata("project_title");
	    }
	    if($this->input->post("worked_hours")!=""){
             $data['worked_hours'] = $this->input->post("worked_hours");
             $this->session->set_userdata("worked_hours", $this->input->post("worked_hours"));
	    }
	    else{
	        $data['worked_hours'] = $this->session->userdata("worked_hours");
	    }
	    
	    if($this->input->post("cost_subtotal")!=""){
             $data['cost_subtotal'] = $this->input->post("cost_subtotal");
             $this->session->set_userdata("cost_subtotal", $this->input->post("cost_subtotal"));
	    }
	    else{
	        $data['cost_subtotal'] = $this->session->userdata("cost_subtotal");
	    }
       
       
        $data['suppliers'] = $this->mod_project->get_costing_suppliers_by_costing_id($project_id);
            
        $var_number=$this->mod_variation->lastinsertedvariationid();
        $data['var_number'] = $var_number;
           
        $this->stencil->title('Timesheet Supplier Invoice');
	    $this->stencil->paint('timesheets/add_supplier_invoice', $data);
	}
}
