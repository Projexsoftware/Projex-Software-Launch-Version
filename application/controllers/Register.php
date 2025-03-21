<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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

            $this->stencil->layout('login_layout');
            $this->stencil->slice('header_script');
            $this->stencil->slice('login_footer_script');

            $this->load->model("mod_common");
        }
        
        //Register Screen
    	public function index()
    	{
             $this->stencil->title('Signup');
    	     $this->stencil->paint('register/register');
    	}
        
        //Register New User
        public function userSignupProcess(){
            
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[project_users.user_email]');
    		$this->form_validation->set_rules('firstName', 'First Name', 'required');
            $this->form_validation->set_rules('lastName', 'Last Name', 'required');
            $this->form_validation->set_rules('companyName', 'Company Name', 'required|is_unique[project_users.com_name]');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');
            
            if ($this->form_validation->run() == FALSE)
    				{
    				   $this->stencil->title('Signup');
    	               $this->stencil->paint('register/register');
    				}
    		else{
            
                $firstName = $this->input->post('firstName');
                $lastName = $this->input->post('lastName');
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $companyName = $this->input->post('companyName');
                
                $user = array(
        						'user_fname'	=> $firstName,
        						'user_lname'	=> $lastName,
        						'user_email'	=> $email,
        						'user_password'	=> md5($password),
        						'com_name'		=> $companyName,
        						'user_img'    => "project_avatar.png",
        						'role_id'	    => 1,
        						'user_status'	=> 0
        						);
        					
        		$id = $this->mod_common->insert_into_table('project_users',$user);
        		
        		if($id){
        		            
        		
        		                        $this->mod_common->insert_into_table('project_terms_and_conditions', array("company_id" => $id));
        		                        $this->mod_common->insert_into_table('project_email_templates', array("company_id" => $id));
        		                        //Default Templates
                                            
                                           /* $default_templates = $this->mod_common->get_all_records('project_default_templates', "*", 0, 0, array(), "template_id");
                                            if(count($default_templates)>0){
                                                foreach($default_templates as $template){
                                                    $ins_array = array(
                                                        "user_id" => $id,
                                                        "company_id" => $id,
                                                        'template_name'	=>	$template["template_name"],
                                            			'template_desc'	=>	$template["template_desc"],
                                            			'quantity'		=>	0,
                                            			'template_status' =>	1
                                                        
                                                        );
                                                    $template_id = $this->mod_common->insert_into_table('project_templates', $ins_array);
                                                    if($template_id){
                                                         $default_template_parts = $this->mod_common->get_all_records('project_default_tpl_component_part', "*", 0, 0, array("temp_id" => $template['template_id']), "tpl_part_id", "ASC");
                                                         if(count($default_template_parts)>0){
                                                             foreach($default_template_parts as $default_part){
                                                                    $part = array(
                                                						'temp_id'							=>	$template_id,
                                                						'stage_id'							=>	$default_part["stage_id"],
                                                						'user_id'							=>	$id,
                                                						'company_id'						=>	$id,
                                                						'component_id'						=>	$default_part["component_id"],
                                                						'tpl_part_name'						=>	$default_part["tpl_part_name"],
                                                						'tpl_part_component_uom'			=>	$default_part["tpl_part_component_uom"],
                                                						'tpl_part_component_uc'				=>	$default_part["tpl_part_component_uc"],
                                                						'tpl_part_supplier_id'				=>	$default_part["tpl_part_supplier_id"],
                                                						'tpl_quantity'						=>	$default_part["tpl_quantity"],
                                                						'tpl_quantity_type'					=>	$default_part["tpl_quantity_type"],
                                                						'tpl_quantity_formula'				=>	$default_part["tpl_quantity_formula"],
                                                						'is_rounded'			        	=>	$default_part["is_rounded"],
                                                						'quantity_formula_text'				=>	$default_part["quantity_formula_text"],
                                                						'tpl_part_status'					=>	1
                                                					);	
                                                
                                                					$this->mod_common->insert_into_table('project_tpl_component_part',$part);
                                                             }
                                                         }
                                                    }
                                                }
                                            }
                                            
                                        //Default Suppliers
                                            
                                            $default_suppliers =	$this->mod_common->get_all_records('project_default_suppliers', "*", 0, 0, array(), "supplier_id");
                                            if(count($default_suppliers)>0){
                                                foreach($default_suppliers as $supplier){
                                                    
                                                    $ins_array = array(
                                                        'parent_supplier_id' => 0,
                                                        'user_id' => $id,
                                                        'company_id' => $id,
                                                        'supplier_name' => $supplier["supplier_name"],
                                                        'supplier_status' => 1,
                                                        'supplier_city' => $supplier["supplier_city"],
                                                        'supplier_postal_city' => $supplier["supplier_postal_city"],
                                                        'supplier_zip' => $supplier["supplier_zip"],
                                                        'supplier_postal_zip' => $supplier["supplier_postal_zip"],
                                                        'post_street_pobox' => $supplier["post_street_pobox"],
                                                        'post_suburb' => $supplier["post_suburb"],
                                                        'street_pobox' => $supplier["street_pobox"],
                                                        'supplier_country' => $supplier["supplier_country"],
                                                        'supplier_postal_country' => $supplier["supplier_postal_country"],
                                                        'suburb' => $supplier["suburb"],
                                                        'supplier_email' => $supplier["supplier_email"],
                                                        'supplier_phone' => $supplier["supplier_phone"],
                                                        'supplier_web' => $supplier["supplier_web"],
                                                        'supplier_state' => $supplier["supplier_state"],
                                                        'supplier_postal_state' =>$supplier["supplier_postal_state"],
                                                        'supplier_contact_person' => $supplier["supplier_contact_person"],
                                                        'supplier_contact_person_mobile' => $supplier["supplier_contact_person_mobile"]
                                                    );
                                                    
                                                    $updated_supplier_id = $this->mod_common->insert_into_table('project_suppliers', $ins_array);
                                                    
                                                    $where = array("tpl_part_supplier_id" => $supplier["supplier_id"], "user_id" => $id);
                                                    $upd_array = array("tpl_part_supplier_id" => $updated_supplier_id);
                                                    $this->mod_common->update_table('project_tpl_component_part', $where, $upd_array);
                                                    
                                                }
                                            }*/
                                            
                                        //Default Stages
                                            
                                            $default_stages =	$this->mod_common->get_all_records('project_default_stages', "*", 0, 0, array(), "stage_id");
                                            if(count($default_stages)>0){
                                                foreach($default_stages as $stage){
                                                    $ins_array = array(
                                                        "user_id" => $id,
                                                        "company_id" => $id,
                                                        "stage_name" =>	$stage["stage_name"],
                                                		"stage_description"	=>	$stage["stage_description"],
                                                		"stage_status"		=>	1
                                                        
                                                        );
                                                    
                                                    $updated_stage_id = $this->mod_common->insert_into_table('project_stages', $ins_array);
                                                    
                                                    /*$where = array("stage_id" => $stage['stage_id'], "user_id" => $id);
                                                    $upd_array = array("stage_id" => $updated_stage_id);
                                                    $this->mod_common->update_table('project_tpl_component_part', $where, $upd_array);*/
                                                    
                                                }
                                            }
                                            
                                            //Default Takeoffdata
                                            
                                            $default_takeoffdata =	$this->mod_common->get_all_records('project_default_takeoffdata', "*", 0, 0, array(), "takeof_id");
                                            if(count($default_takeoffdata)>0){
                                                foreach($default_takeoffdata as $takeoff){
                                                    $ins_array = array(
                                                        'user_id' 				=>	$id,
                                                		'company_id' 			=>	$id,
                                                		'takeof_name'			=>	$takeoff["takeof_name"],
                                                		'takeof_des'			=>	$takeoff["takeof_des"],
                                                		'project_id'            =>  0,
                                                		'takeof_status'			=>	1,
                                                        );
                                                    $this->mod_common->insert_into_table('project_takeoffdata', $ins_array);
                                                }
                                            }
                                            
                                            //Default Components
                                            
                                            /*$default_components =	$this->mod_common->get_all_records('project_default_components', "*", 0, 0, array(), "component_id");
                                            if(count($default_components)>0){
                                                foreach($default_components as $component){
                                                    if($component["image"]!=""){  
                                                        copy('assets/components/'.$component["image"], 'assets/components/'.$component["image"].strtotime(date("Y-m-d h:i:s")));
                                                        copy('assets/components/'.$component["image"], 'assets/components/thumbnail/'.$component["image"].strtotime(date("Y-m-d h:i:s")));
                                                    }
                                                    $ins_array = array(
                                                        'user_id' => $id,
                                                        'company_id' => $id,
                                                        'parent_component_id' => 0,
                                                        'component_name' => $component["component_name"],
                                                        'component_des' => $component["component_des"],
                                                        'component_uom' => $component["component_uom"],
                                                        'component_uc' => $component["component_uc"],
                                                        'supplier_id' => $updated_supplier_id,
                                                        'component_status' => $component["component_status"],
                                                        'image' => "",
                                                        'component_category' => $component["component_category"],
                                                        'specification' => "",
                                                        'warranty' => "",
                                                        'maintenance' => "",
                                                        'installation' => "",
                                                        'price_book_id' => 0
                                                        );
                                                    $updated_component_id = $this->mod_common->insert_into_table('project_components', $ins_array);
                                                    $where = array("component_id" => $component['component_id'], "user_id" => $id);
                                                    $upd_array = array("component_id" => $updated_component_id);
                                                    $this->mod_common->update_table('project_tpl_component_part', $where, $upd_array);
                                                }
                                            }*/
                                            
                                            //Default Scheduling Checklists
                                            
                                            $default_checklists =	$this->mod_common->get_all_records('project_scheduling_default_checklists');
                                            if(count($default_checklists)>0){
                                                foreach($default_checklists as $checklist){
                                                    $ins_array = array(
                                                        "created_by" => $id,
                                                        "company_id" => $id,
                                                        "task_id" => $checklist["task_id"],
                                                        "name" =>	$checklist["name"],
                                                		"status"		=>	1
                                                        );
                                                    
                                                    $this->mod_common->insert_into_table('project_scheduling_checklists', $ins_array);
                                                }
                                            }
                                            
                                            //Default Scheduling Tasks
                                            
                                            $default_tasks =	$this->mod_common->get_all_records('project_scheduling_default_tasks');
                                            if(count($default_tasks)>0){
                                                foreach($default_tasks as $task){
                                                    $ins_array = array(
                                                        "created_by" => $id,
                                                        "company_id" => $id,
                                                        "name" =>	$task["name"],
                                                		"status"		=>	1
                                                        );
                                                    
                                                    $updated_task_id = $this->mod_common->insert_into_table('project_scheduling_tasks', $ins_array);
                                                    
                                                    $where = array("task_id" => $task["id"], "company_id" => $id);
                                                    $upd_array = array("task_id" => $updated_task_id);
                                                    $this->mod_common->update_table('project_scheduling_checklists', $where, $upd_array);
                                                    
                                                }
                                            }
                                            
                                            
                                            //Email Process
                                            
                                            $subject = "Confirm Registration";
                                            $passwordCount = strlen($password);
                                            $password = "";
                                            for($i=0;$i<$passwordCount;$i++){
                                                $password .="*";
                                            }
                                            $data['password'] = $password;
                                            $data['email'] = $email;
                                            $data['firstname'] = $firstName;
                                            $data['id'] = $id;
    
    		                                $message = $this->load->view("email_templates/register_template", $data, TRUE);
    		                                
    		                               // $site_preferences = get_site_preferences();
                                                    
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
    						                        $this->session->set_flashdata('ok_message', 'Thank you, a verification link will be sent to your email account shortly. Please click the link to complete the registration process.');
    						                        $this->session->set_userdata("is_register", true);
    						                        $this->session->set_userdata("register_email", $email);
    						                        redirect(SURL . 'register/thankyou');
        		}
        		else {
    				$this->session->set_flashdata('err_message', 'Error in creating account please try again!');
    				redirect(SURL . "register");
    			}
    		
    		}
            
        }
        
        //Thankyou Page
        public function thankyou(){
                if($this->session->userdata("is_register")!=""){
                   $this->session->unset_userdata("is_register");
                   $this->stencil->title('Thankyou');
    	           $this->stencil->paint('register/thankyou');
                }
                else{
                    redirect(SURL);
                }
            }
    
        //Verify User Email
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
        
        //Verify User Company
        public function verify_company() {
    
            $company = $this->input->post("company");
            
            $table = "project_users";
    
            if($this->input->post("id")!=""){
               $id = $this->input->post("id");
               $where = array(
                'user_id !=' => $id,
                'com_name' => $company,
              );
            }
            else{
              $where = array(
                'com_name' => $company,
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
