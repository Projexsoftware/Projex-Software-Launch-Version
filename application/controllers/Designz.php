<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designz extends CI_Controller {

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
             $this->load->model("mod_dashboard");
             $this->load->model("mod_project");
             $this->load->model("mod_reports");
             $this->load->model("mod_designz");

             $this->mod_common->verify_is_user_login();
             $this->mod_common->is_company_page_accessible(159);

    }
    
	public function index()
	{
        $this->stencil->title('Designz');
             
	    $this->stencil->paint('designz/designz');
	}
	
	public function ajax_filter() {

        $r1min = isset($_POST['r1min']) ? $_POST['r1min'] : -1;
        $r1max = isset($_POST['r1max']) ? $_POST['r1max'] : -1;
        
        $r2min = isset($_POST['r2min']) ? $_POST['r2min'] : -1;
        $r2max = isset($_POST['r2max']) ? $_POST['r2max'] : -1;

        $r3min = isset($_POST['r3min']) ? $_POST['r3min'] : -1;
        $r3max = isset($_POST['r3max']) ? $_POST['r3max'] : -1;

        $r4min = isset($_POST['r4min']) ? $_POST['r4min'] : -1;
        $r4max = isset($_POST['r4max']) ? $_POST['r4max'] : -1;

        $storey1 = isset($_POST['storey1']) ? $_POST['storey1'] : -1;
        $storey2 = isset($_POST['storey2']) ? $_POST['storey2'] : -1;
        
        $search_design = isset ($_POST['search_design'])?$_POST['search_design']:""; 
        
        
        $sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';
        
        $search_filters = array (
            'r1min' => $r1min,
            'r1max' => $r1max,
            'r2min' => $r2min,
            'r2max' => $r2max,
            'r3min' => $r3min,
            'r3max' => $r3max,
            'r4min' => $r4min,
            'r4max' => $r4max,
            'storey1'   => $storey1,
            'storey2'   => $storey2,
            'search_design' =>  $search_design,
            'sort_order' => $sort_order

        );

        $this->session->set_userdata($search_filters);
            
        $data['get_data'] = $this->mod_designz->filter_my_project($search_design, $r1min, $r1max, $r2min, $r2max, $r3min, $r3max, $r4min, $r4max, $storey1, $storey2, $sort_order);
            
        $data['get_data_count'] = count($data['get_data']);


        $html = $this->load->view('designz/filter_records', $data, TRUE);
        echo $html;
    }
    
    public function details($type, $designz_id){
        $this->stencil->title('Designz Details');
        $data["designz_details"] = $this->mod_designz->getDesignzDetails($designz_id, $type);
        if(count($data["designz_details"]) == 0){
            $this->session->set_flashdata('err_message', 'No Designz Found.');
			redirect(SURL . 'designz');
        }
        if($type == 'supplierz'){
        $data['uploadedBuilderzImages'] = $this->mod_common->get_all_records("project_designz_builderz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "image", "company_id" => $this->session->userdata("company_id")));
    
        //$data['thumbnail'] = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "image", "set_as_thumbnail" => 1));
        
        $data['uploadedBuilderzPlans'] = $this->mod_common->get_all_records("project_designz_builderz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "plan", "company_id" => $this->session->userdata("company_id")));
        
        //$data['plan_thumbnail'] = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "plan", "set_as_thumbnail" => 1));
        }
        else{
        $data['uploadedBuilderzImages'] = $this->mod_common->get_all_records("project_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "image"));
    
        //$data['thumbnail'] = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "image", "set_as_thumbnail" => 1));
        
        $data['uploadedBuilderzPlans'] = $this->mod_common->get_all_records("project_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "plan"));
        
        //$data['plan_thumbnail'] = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "plan", "set_as_thumbnail" => 1));
      
        }
	    $this->stencil->paint('designz/designz_details', $data);
    }
	
	/***************Designz Section Starts Here*********************/
    
    //Get All Designz
    public function manage_designz() {
       
       $this->mod_common->is_company_page_accessible(159);
       $data['designz'] = $this->mod_common->get_designz();
       $this->stencil->title('Designz');
	   $this->stencil->paint('designz/manage_designz', $data);
    
    }
    
    //Add Designz Screen
    public function add_designz() {
        
        $this->mod_common->is_company_page_accessible(159);
        $this->stencil->title('Add Designz');
        $this->stencil->paint('designz/add_new_designz');
    }
    
    //Add New Designz
    public function add_new_designz_process() {
		 
        $this->mod_common->is_company_page_accessible(159);
		$this->form_validation->set_rules('project_name', 'Project Name', 'required');
		$this->form_validation->set_rules('floor_area', 'Floor Area', 'required');
		$this->form_validation->set_rules('living_areas', 'Living Areas', 'required');
		$this->form_validation->set_rules('bathrooms', 'Bathrooms', 'required');
		$this->form_validation->set_rules('bedrooms', 'Bedrooms', 'required');
		$this->form_validation->set_rules('garage', 'Garage', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
                $this->stencil->title('Add Designz');
                $this->stencil->paint('designz/add_new_designz');
			}
		else{
		    
			$table = "project_designz";
					
			$project_name = $this->input->post('project_name');
			$floor_area = $this->input->post('floor_area');
			$living_areas = $this->input->post('living_areas');
			$bedrooms = $this->input->post('bedrooms');
			$bathrooms = $this->input->post('bathrooms');
			$garage = $this->input->post('garage');
			$movies = $this->input->post('movies');
			$ThreeD = $this->input->post('3D');
			$uploadedFiles = $this->input->post('uploadedFiles');
			$thumbnail = $this->input->post('set_as_thumbnail');
			$plan_thumbnail = $this->input->post('set_plan_as_thumbnail');
			$status = $this->input->post('status');
			$company_id = $this->session->userdata("company_id");
            $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
            $ins_array = array(
                "supplier_id" => $company_id,
                "project_name" => $project_name,
                "floor_area" => $floor_area,
                "living_areas" => $living_areas,
                "bedrooms" => $bedrooms,
                "bathrooms" => $bathrooms,
                "garage" => $garage,
                "movies" => $movies,
                "3D" => $ThreeD,
                "status" => $status,
                "company_id" => $company_id,
                "created_by" => $created_by,
                "ip_address" => $ip_address
		    );
		    
		    $add_new_designz = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_designz) {
			    $uploadedFilesArray = json_decode($uploadedFiles, true);
			    if ($uploadedFilesArray != null) {
    			    foreach($uploadedFilesArray as $file){
    			        $set_as_thumbnail = 0;
    			        if((isset($thumbnail) && $thumbnail == $file["name"]) || (isset($plan_thumbnail) && $plan_thumbnail == $file["name"])){
    			          $set_as_thumbnail = 1;
    			        }
    			        $ins_array = array(
    			            "designz_id" => $add_new_designz,
    			            "file_name" => $file["name"],
    			            "designz_upload_type" => $file["designz_upload_type"],
    			            "file_type" => $file["type"],
    			            "set_as_thumbnail" => $set_as_thumbnail
    			        );
    			        $this->mod_common->insert_into_table("project_designz_uploads", $ins_array);
    			    }
			    }
			   
				$this->session->set_flashdata('ok_message', 'New Designz added successfully.');
				redirect(SURL . 'designz/manage_designz');
			} else {
				$this->session->set_flashdata('err_message', 'New Designz is not added. Something went wrong, please try again.');
				redirect(SURL . 'designz/manage_designz');
			}
		}
    }
    
    //Edit Designz Screen
    public function edit_designz($designz_id) {

        $this->mod_common->is_company_page_accessible(159);
		
	    if($designz_id=="" || !(is_numeric($designz_id))){
            redirect("nopage");
        }
		
        $table = "project_designz";
        $where = "`designz_id` ='" . $designz_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['designz_edit'] = $this->mod_common->select_single_records($table, $where);
        
        $data['uploadedImages'] = array();
        
        $data['uploadedPlans'] = array();
        
        $data['uploadedBuilderzImages'] = $this->mod_common->get_all_records("project_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "image"));
        
        $data['thumbnail'] = $this->mod_common->select_single_records("project_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "image", "set_as_thumbnail" => 1));
        
        $data['uploadedBuilderzPlans'] = $this->mod_common->get_all_records("project_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "plan"));
        
        $data['plan_thumbnail'] = $this->mod_common->select_single_records("project_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "plan", "set_as_thumbnail" => 1));
        
        if (count($data['designz_edit']) == 0) {
           $this->session->set_flashdata('err_message', 'Designz does not exist.');
            redirect("designz/manage_designz");
        } else {
            $data['designz_type'] = "builderz";
            $this->stencil->title("Edit Designz");

            $this->stencil->paint('designz/edit_designz', $data);
        }
    }
    
    //Edit Designz Screen
    public function view_designz_details($designz_id) {

        $this->mod_common->is_company_page_accessible(159);
		
	    if($designz_id=="" || !(is_numeric($designz_id))){
            redirect("nopage");
        }
		
        $table = "project_supplierz_designz";
        $where = "`designz_id` ='" . $designz_id."' AND available_for_builderz = 1";

        $data['designz_edit'] = $this->mod_common->select_single_records($table, $where);
        
        $data['uploadedBuilderzImages'] = $this->mod_common->get_all_records("project_designz_builderz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "image", "company_id" => $this->session->userdata("company_id")));
    
        //$data['uploadedImages'] = $this->mod_common->get_all_records("project_supplierz_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "image"));
        $data['uploadedImages'] = $this->mod_common->get_supplierz_designz_uploads($designz_id, "image");
           
        $data['thumbnail'] = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "image", "set_as_thumbnail" => 1, "company_id" => $this->session->userdata("company_id")));
        
        //$data['uploadedPlans'] = $this->mod_common->get_all_records("project_supplierz_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "plan"));
        $data['uploadedPlans'] = $this->mod_common->get_supplierz_designz_uploads($designz_id, "plan");
        
        $data['uploadedBuilderzPlans'] = $this->mod_common->get_all_records("project_designz_builderz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "plan", "company_id" => $this->session->userdata("company_id")));
        
        $data['plan_thumbnail'] = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "plan", "set_as_thumbnail" => 1, "company_id" => $this->session->userdata("company_id")));
        
        if (count($data['designz_edit']) == 0) {
           $this->session->set_flashdata('err_message', 'Designz does not exist.');
            redirect("designz/manage_designz");
        } else {
            $data['designz_type'] = "supplierz";
            $this->stencil->title("View Supplierz Designz");

            $this->stencil->paint('designz/edit_designz', $data);
        }
    }
    
    //Edit Component
    public function edit_designz_process() {
		 
        $this->mod_common->is_company_page_accessible(159);
        
        if (!$this->input->post() && !$this->input->post('update_designz'))
        
        redirect(SURL."designz/manage_designz");
        
        
    	$this->form_validation->set_rules('floor_area', 'Floor Area', 'required');
    	$this->form_validation->set_rules('living_areas', 'Living Areas', 'required');
    	$this->form_validation->set_rules('bathrooms', 'Bathrooms', 'required');
    	$this->form_validation->set_rules('bedrooms', 'Bedrooms', 'required');
    	$this->form_validation->set_rules('garage', 'Garage', 'required');
		
		$designz_id = $this->input->post('designz_id');
		
        $table = "project_designz";
	    $where = array(
	        "designz_id" => $designz_id,
	        "company_id" => $this->session->userdata("company_id")
	        );

	    $data['designz_edit'] = $this->mod_common->select_single_records($table, $where);
	    
	    
    	    $original_value = $data['designz_edit']['project_name'];
    		
            if($this->input->post('project_name') != $original_value) {
                $is_unique =  '|is_unique[project_designz.project_name]';
            } else {
                $is_unique =  '';
            }
          
        $this->form_validation->set_rules('project_name', 'Designz Name', 'required'.$is_unique);
	    
	    if ($this->form_validation->run() == FALSE)
			{
                $this->stencil->title('Edit Designz');
                $this->stencil->paint('designz/edit_designz', $data);
			}
		else{
		    
		    $table = "project_designz";
					
			$project_name = $this->input->post('project_name');
			$floor_area = $this->input->post('floor_area');
			$living_areas = $this->input->post('living_areas');
			$bedrooms = $this->input->post('bedrooms');
			$bathrooms = $this->input->post('bathrooms');
			$garage = $this->input->post('garage');
			$movies = $this->input->post('movies');
			$ThreeD = $this->input->post('3D');
			$uploadedFiles = $this->input->post('uploadedFiles');
			$thumbnail = $this->input->post('set_as_thumbnail');
			$plan_thumbnail = $this->input->post('set_plan_as_thumbnail');
			$status = $this->input->post('status');
			$company_id = $this->session->userdata("company_id");
            $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
    		$upd_array = array(
                    "supplier_id" => $company_id,
                    "project_name" => $project_name,
                    "floor_area" => $floor_area,
                    "living_areas" => $living_areas,
                    "bedrooms" => $bedrooms,
                    "bathrooms" => $bathrooms,
                    "garage" => $garage,
                    "movies" => $movies,
                    "3D" => $ThreeD,
                    "status" => $status,
                    "company_id" => $company_id,
                    "created_by" => $created_by,
                    "ip_address" => $ip_address
    		);
    		
					
		    $update_designz = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_designz) {
			    
			    $uploadedFilesArray = json_decode($uploadedFiles, true);
			    if ($uploadedFilesArray != null) {
    			    foreach($uploadedFilesArray as $file){
    			        $is_exist = $this->mod_common->select_single_records("project_designz_uploads", array("file_name" => $file["name"]));
    			        $set_as_thumbnail = 0;
    			            if((isset($thumbnail) && $thumbnail == $file["name"]) || (isset($plan_thumbnail) && $plan_thumbnail == $file["name"])){
    			                $set_as_thumbnail = 1;
    			            }
    			        if(count($is_exist)==0){
        			        $ins_array = array(
        			            "designz_id" => $designz_id,
        			            "file_name" => $file["name"],
        			            "designz_upload_type" => $file["designz_upload_type"],
        			            "file_type" => $file["type"],
        			            "set_as_thumbnail" => $set_as_thumbnail
        			        );
        			        $this->mod_common->insert_into_table("project_designz_uploads", $ins_array);
    			        }
    			        else{
    			            $upd_array = array(
        			           "set_as_thumbnail" => $set_as_thumbnail
        			        );
    			            
    			            $this->mod_common->update_table("project_designz_uploads", array("designz_id" => $designz_id, "file_name" => $file["name"]), $upd_array);
    			     
    			        }
    			    }
			    }
			    
				$this->session->set_flashdata('ok_message', 'Designz updated successfully.');
				redirect(SURL . 'designz/manage_designz');
			} else {
				$this->session->set_flashdata('err_message', 'Designz is not updated. Something went wrong, please try again.');
				redirect(SURL . 'designz/manage_designz');
			}
		}
    }
    
    //Edit Component
    public function edit_supplierz_designz_process() {
		 
        $this->mod_common->is_company_page_accessible(159);
        
        if (!$this->input->post() && !$this->input->post('update_designz'))
        
        redirect(SURL."designz/manage_designz");
        
		
		$designz_id = $this->input->post('designz_id');
		
		$table = "project_designz";
	    $where = array(
	        "designz_id" => $designz_id,
	        "company_id" => $this->session->userdata("company_id")
	        );

	    $data['designz_edit'] = $this->mod_common->select_single_records($table, $where);
		
        $table = "project_designz_builderz_settings";
	    $where = array(
	        "designz_id" => $designz_id,
	        "company_id" => $this->session->userdata("company_id")
	        );

	    $data['builderz_designz_edit'] = $this->mod_common->select_single_records($table, $where);
	    
	        if($data['builderz_designz_edit']['name']!=""){
    	       $original_value = $data['builderz_designz_edit']['name'];
	        }
	        else{
	            $table = "project_supplierz_designz";
        	    $where = array(
        	        "designz_id" => $designz_id
        	        );
                $data['supplierz_designz_edit'] = $this->mod_common->select_single_records($table, $where);
	            $original_value = $data['supplierz_designz_edit']['project_name'];
	        }
    		
            if($this->input->post('builderz_designz_name') != $original_value) {
                $is_unique =  '|is_unique[project_designz_builderz_settings.name]';
            } else {
                $is_unique =  '';
            }
          
        $this->form_validation->set_rules('builderz_designz_name', 'Builderz Designz Name', 'required'.$is_unique);
	    
	    if ($this->form_validation->run() == FALSE)
			{
                $this->stencil->title('Edit Designz');
                $this->stencil->paint('designz/edit_designz', $data);
			}
		else{
		    
		    $table = "project_designz_builderz_settings";
					
			$builderz_designz_name = $this->input->post('builderz_designz_name');
			$uploadedFiles = $this->input->post('uploadedFiles');
			$selectedFiles = $this->input->post('selectedFiles');
			$thumbnail = $this->input->post('set_as_thumbnail');
			$plan_thumbnail = $this->input->post('set_plan_as_thumbnail');
			
    		$is_exists = $this->mod_common->select_single_records("project_designz_builderz_settings", array("designz_id" => $designz_id, "company_id" => $this->session->userdata("company_id")));
            
            if(count($is_exists) == 0){
               $ins_array = array(
                   "name" => $builderz_designz_name,
                   "designz_id" => $designz_id,
                   "company_id" => $this->session->userdata("company_id")
               );
               $this->mod_common->insert_into_table("project_designz_builderz_settings", $ins_array);
               
            }
            else{
               $this->mod_common->update_table("project_designz_builderz_settings", array("designz_id" => $designz_id, "company_id" => $this->session->userdata("company_id")), array("name" => $builderz_designz_name));
            }

			    
			    $uploadedFilesArray = json_decode($uploadedFiles, true);
			    if ($uploadedFilesArray != null) {
    			    foreach($uploadedFilesArray as $file){
    			        $is_exist = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("file_name" => $file["name"], "company_id" => $this->session->userdata("company_id")));
    			        $set_as_thumbnail = 0;
    			        if((isset($thumbnail) && $thumbnail == $file["name"]) || (isset($plan_thumbnail) && $plan_thumbnail == $file["name"])){
    			               $set_as_thumbnail = 1;
    			        }
    			        if(count($is_exist)==0){
        			        $ins_array = array(
        			            "designz_id" => $designz_id,
        			            "file_name" => $file["name"],
        			            "designz_upload_type" => $file["designz_upload_type"],
        			            "file_type" => $file["type"],
        			            "set_as_thumbnail" => $set_as_thumbnail,
        			            "company_id" => $this->session->userdata("company_id")
        			        );
        			        $this->mod_common->insert_into_table("project_designz_builderz_uploads", $ins_array);
    			        }
    			        else{
        			           $upd_array = array(
        			               "set_as_thumbnail" => $set_as_thumbnail
        			           );
    			            
    			               $this->mod_common->update_table("project_designz_builderz_uploads", array("designz_id" => $designz_id, "file_name" => $file["name"], "company_id" => $this->session->userdata("company_id")), $upd_array);
    			        }
    			    }
			    }
			    
			    $selectedFilesArray = json_decode($selectedFiles, true);
			    if ($selectedFilesArray != null) {
    			    foreach($selectedFilesArray as $file){
    			        
    			        $filename = "builderz-".$file["name"];
    			        $is_exist = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("file_name" => $filename, "company_id" => $this->session->userdata("company_id")));
    			        if(count($is_exist)==0){
    			            $set_as_thumbnail = 0;
                            copy('assets/designz_uploads/'.$file["name"], 'assets/builderz_designz_uploads/'.$filename);
                            copy('assets/designz_uploads/thumbnail/'.$file["name"], 'assets/builderz_designz_uploads/thumbnail/'.$filename);
                            
        			        $ins_array = array(
        			            "designz_id" => $designz_id,
        			            "file_name" => $filename,
        			            "designz_upload_type" => $file["designz_upload_type"],
        			            "file_type" => $file["type"],
        			            "set_as_thumbnail" => $set_as_thumbnail,
        			            "company_id" => $this->session->userdata("company_id")
        			        );
        			        $this->mod_common->insert_into_table("project_designz_builderz_uploads", $ins_array);
    			        }
    			    }
			    }
		
				$this->session->set_flashdata('ok_message', 'Designz updated successfully.');
				redirect(SURL . 'designz/manage_designz');
		}
    }
    
    //Show/Hide designz at Client Interface
    public function show_at_client_interface(){
        $id = $this->input->post("id");
        $designz_type = $this->input->post("designz_type");
        $show_at_client_interface = $this->input->post("show_at_client_interface");
        if($designz_type == "builderz"){
            $this->mod_common->update_table("project_designz", array("designz_id" => $id), array("show_at_client_interface" => $show_at_client_interface));
        }
        else{
           $is_exists = $this->mod_common->select_single_records("project_designz_builderz_settings", array("designz_id" => $id, "company_id" => $this->session->userdata("company_id")));
           if(count($is_exists) == 0){
               $ins_array = array(
                   "show_at_client_interface" => $show_at_client_interface,
                   "designz_id" => $id,
                   "company_id" => $this->session->userdata("company_id")
               );
               $this->mod_common->insert_into_table("project_designz_builderz_settings", $ins_array);
               
           }
           else{
               $this->mod_common->update_table("project_designz_builderz_settings", array("designz_id" => $id, "company_id" => $this->session->userdata("company_id")), array("show_at_client_interface" => $show_at_client_interface));
           }
        }
    }
    
    //Update Builderz Designz Name
    
    public function update_designz_name(){
        $id = $this->input->post("id");
        $designz_type = $this->input->post("designz_type");
        $name = $this->input->post("name");
        
           $is_exists = $this->mod_common->select_single_records("project_designz_builderz_settings", array("designz_id" => $id, "company_id" => $this->session->userdata("company_id")));
           if(count($is_exists) == 0){
               $ins_array = array(
                   "name" => $name,
                   "designz_id" => $id,
                   "company_id" => $this->session->userdata("company_id")
               );
               $this->mod_common->insert_into_table("project_designz_builderz_settings", $ins_array);
               
           }
           else{
               $this->mod_common->update_table("project_designz_builderz_settings", array("designz_id" => $id, "company_id" => $this->session->userdata("company_id")), array("name" => $name));
           }
    }
    
    //Verify Designz Project
    public function verify_project() {

        $name = $this->input->post("name");
        
        $table = "project_designz";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'designz_id !=' => $id,
            'project_name' => $name,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'project_name' => $name,
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
    
    //Verify Builderz Designz Name
    
    public function verify_builderz_designz_name() {

        $name = $this->input->post("name");
        
        $table = "project_designz_builderz_settings";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'designz_id !=' => $id,
            'name' => $name,
            'company_id' => $this->session->userdata('company_id')
          );
        }
        else{
          $where = array(
            'name' => $name,
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
    
    //Delete Designz
    public function delete_designz() {
  
        $this->mod_common->is_company_page_accessible(159);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "project_designz";
        $where = array(
	        "designz_id" => $id,
	        "company_id" => $this->session->userdata("company_id")
	    );
        
        $this->mod_common->delete_record($table, $where);
        
        //Delete Designz Upload data
        $files = $this->mod_common->get_all_records("project_designz_uploads", "*", 0, 0, $where);
        if(count($files)>0){
            foreach($files as $file){
                if(file_exists("./assets/builderz_designz_uploads/".$file["file_name"])){
        	        unlink("./assets/builderz_designz_uploads/".$file["file_name"]);
        	        if(file_exists("./assets/builderz_designz_uploads/thumbnail/".$file["file_name"])){
        	          unlink("./assets/builderz_designz_uploads/thumbnail/".$file["file_name"]);
        	        }
        	    }
    	        $this->mod_common->delete_record("project_designz_uploads", array("id" => $file["id"]));
            }
        }
    }
    
    //Upload Designz File
	public function upload_designz_files($file_type){
	                $projects_folder_path = './assets/builderz_designz_uploads/';
					$projects_folder_path_main = './assets/builderz_designz_uploads/';
					$thumb = $projects_folder_path_main . 'thumbnail';


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
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
							create_optimize($filename, $full_path, $projects_folder_path_main);
                            create_fixed_thumbnail($filename, $full_path, $thumb);
						}
						
		$response = array("status" => "success", "file_name" => $filename);
	    echo json_encode($response);
	    
	}
	
	//Remove Designz File
	public function remove_designz_file(){
	    
	    $file_name = $this->input->post("filename");
	    $id = $this->input->post("id");
	    
	    if($id){
	        $designz_uploads_info = $this->mod_common->select_single_records("project_designz_uploads", array("id" => $id));
	        $this->mod_common->delete_record("project_designz_uploads", array("id" => $id));
	    }
	    
	    if(file_exists("./assets/builderz_designz_uploads/".$file_name)){
	        unlink("./assets/builderz_designz_uploads/".$file_name);
	        if(file_exists("./assets/builderz_designz_uploads/thumbnail/".$file_name)){
	          unlink("./assets/builderz_designz_uploads/thumbnail/".$file_name);
	        }
	    }
	    $response = array("status" => "deleted", "file_name" => $file_name, "set_as_thumbnail" => $designz_uploads_info["set_as_thumbnail"], "designz_id" => $designz_uploads_info["designz_id"]);
	    echo json_encode($response);
	}
	
	public function remove_builderz_designz_file(){
	    $file_name = $this->input->post("filename");
	    $id = $this->input->post("id");
	    
	    if($id){
	        $designz_uploads_info = $this->mod_common->select_single_records("project_designz_builderz_uploads", array("id" => $id));
	        $this->mod_common->delete_record("project_designz_builderz_uploads", array("id" => $id));
	    }
	    
	    if(file_exists("./assets/builderz_designz_uploads/".$file_name)){
	        unlink("./assets/builderz_designz_uploads/".$file_name);
	        if(file_exists("./assets/builderz_designz_uploads/thumbnail/".$file_name)){
	          unlink("./assets/builderz_designz_uploads/thumbnail/".$file_name);
	        }
	    }
	    $response = array("status" => "deleted", "file_name" => $file_name, "set_as_thumbnail" => $designz_uploads_info["set_as_thumbnail"], "designz_id" => $designz_uploads_info["designz_id"]);
	    echo json_encode($response);
	}
	
	public function refresh_designz_thumbnails($designz_id){
	    
	    $data['thumbnail'] = $this->mod_common->select_single_records("project_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "image", "set_as_thumbnail" => 1));
        
        $data['plan_thumbnail'] = $this->mod_common->select_single_records("project_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "plan", "set_as_thumbnail" => 1));
        
        $this->load->view("designz/refresh_designz_thumbnails", $data);
	
	    
	}
    
    
    
    /***************Designz Section Ends Here*********************/
}
