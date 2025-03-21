<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplierz extends CI_Controller {

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
             $this->load->model("mod_price_book");
             $this->load->model("mod_project");
             $this->load->model("mod_template");

             $this->mod_common->verify_is_user_login();
             $this->mod_common->is_company_page_accessible(126);

    }
    
    public function index()
	{
	    redirect("nopage");
	}
	
	/******************Price Book Section Starts Here*********************/
	
	//Manage Price Books
	function price_books() {
	    $this->mod_common->is_company_page_accessible(114);
        $data['price_book_components'] = $this->mod_price_book->get_price_book_details();
        $assigned_users_list = $this->mod_common->get_all_records('project_allocate_price_books', "user_id", 0, 0, array());
        $assigned_users = array();
        foreach($assigned_users_list as $user){
             $assigned_users[] = $user["user_id"];
        }
        $data['assigned_users'] = $assigned_users;
        $data['builderz'] = $this->mod_common->get_all_records('project_users', "*", 0, 0, array("user_status" => 1, "company_id" => 0, "role_id !=" => 10), "user_id");
        $this->stencil->title('Manage Price Book');
	    $this->stencil->paint('supplierz/price_books/edit_price_book', $data);
    }
    
    function filter_price_book_components() {
	    $keyword = $this->input->post("keyword");
        $data['price_book_components'] = $this->mod_price_book->get_price_book_details($keyword);
	    $this->load->view('supplierz/price_books/price_book_components_ajax', $data);
    }
    
    //Verify Price Book
    public function verify_price_book() {

        $name = $this->input->post("name");
        
        $table = "project_price_books";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id!=' => $id,
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
    
    //Add Price Book Screen
    public function add_price_book(){
        $this->mod_common->is_company_page_accessible(114);
        $data['categories'] = $this->mod_common->get_all_records('project_categories',  "*", 0, 0,  array("status" => 1));
        $data['existing_price_books'] = $this->mod_common->get_all_records('project_price_books', "*", 0, 0,  array("company_id" => $this->session->userdata("company_id"), "status" => 1));
        $this->stencil->title('Add Price Books');
	    $this->stencil->paint('supplierz/price_books/add_price_book', $data);
    }
    
    //Add Component
    public function add_new_component(){
        $data['categories'] = $this->mod_common->get_all_records('project_categories',  "*", 0, 0,  array("status" => 1));
        $data["count"] = $this->input->post("last_row");
        $this->load->view("supplierz/price_books/add_component", $data);
        
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
        $this->mod_common->update_table('project_components', $where, $update_array);
        
        $template_update_array = array(
            'tpl_part_component_uc' => $unit_cost
        );
        
        $this->mod_common->update_table('project_tpl_component_part', $where, $template_update_array);
        
        echo "s";
    }
    
    //Add New Price Book
    public function add_price_book_process() {
        $this->mod_common->is_company_page_accessible(114);
        $this->form_validation->set_rules('name', 'Price Book', 'required');
        if ($this->form_validation->run() == FALSE){
            $data['categories'] = $this->mod_common->get_all_records('project_categories',  "*", 0, 0,  array("status" => 1));
            $data['existing_price_books'] = $this->mod_common->get_all_records('project_price_books', "*", 0, 0,  array("company_id" => $this->session->userdata("company_id"), "status" => 1));
            $this->stencil->title('Add Price Books');
    	    $this->stencil->paint('supplierz/price_books/add_price_book', $data);
        }
        else{
            
            $price_book_array = array(
                'user_id' => $this->session->userdata('user_id'),
                'company_id' => $this->session->userdata('company_id'),
                'name' => $this->input->post('name'),
                'status' => 1,
            );
            
            $price_book_id = $this->mod_common->insert_into_table('project_price_books', $price_book_array);
            
            $component_id =  array_values($this->input->post('component_id'));
            $component_category =  array_values($this->input->post('component_category'));
            $component_des =  array_values($this->input->post('component_des'));
            $component_uom =  array_values($this->input->post('component_uom'));
            $component_uc =  array_values($this->input->post('component_uc'));
            $component_status =  array_values($this->input->post('component_status'));
            $specification =  array_values($this->input->post('specification'));
            $warranty =  array_values($this->input->post('warranty'));
            $installation =  array_values($this->input->post('installation'));
            $maintenance =  array_values($this->input->post('maintenance'));
            $checklist = array_values($this->input->post('checklist'));
            $component_type = array_values($this->input->post('component_type'));
            $component_img = array_values($this->input->post('component_img'));
            $component_name =  array_values($this->input->post('component_name'));
            $supplier_id = array_values($this->input->post('supplier_id'));
            $component_margin =  array_values($this->input->post('component_margin_percentage'));
            $component_marginline =  array_values($this->input->post('component_margin'));
            $component_sale_price =  array_values($this->input->post('component_sale_price'));
        
            if(count($component_id)>0){
              for($i=0;$i<count($component_id);$i++){
            if($component_uc[$i]!=""){
           
           $specification_document = $specification[$i];
           $warranty_document = $warranty[$i];
           $maintenance_document = $maintenance[$i];
           $installation_document = $installation[$i];
           $component_supplier_id = $supplier_id[$i];
           
              $filename2 = $component_img[$i];
               
                if($component_type[$i] == 0){
               
                if(file_exists('./assets/components/'.$component_img[$i]) && $component_img[$i]!=""){
                   $filename2 = time().$component_img[$i];
                   copy('assets/components/'.$component_img[$i], 'assets/price_books/'.$filename2);
                   copy('assets/components/'.$component_img[$i], 'assets/price_books/thumbnail/'.$filename2);
                }
                if(file_exists('./assets/component_documents/specification/'.$specification[$i]) && $specification[$i]!=""){
                  $specification_document = time().$specification[$i];
                  copy('assets/component_documents/specification/'.$specification[$i], 'assets/price_books/component_documents/specification/'.$specification_document);
                }
                if(file_exists('./assets/component_documents/warranty/'.$warranty[$i]) && $warranty[$i]!=""){
                   $warranty_document = time().$warranty[$i];
                  copy('assets/component_documents/warranty/'.$warranty[$i], 'assets/price_books/component_documents/warranty/'.$warranty_document);
                }
                if(file_exists('./assets/component_documents/maintenance/'.$maintenance[$i]) && $maintenance[$i]!=""){
                  $maintenance_document = time().$maintenance[$i];
                  copy('assets/component_documents/maintenance/'.$maintenance[$i], 'assets/price_books/component_documents/maintenance/'.$maintenance_document);
                }
                if(file_exists('./assets/component_documents/installation/'.$installation[$i]) && $installation[$i]!=""){
                  $installation_document = time().$installation[$i];
                  copy('assets/component_documents/installation/'.$installation[$i], 'assets/price_books/component_documents/installation/'.$installation_document);
                }
           }
           else if($component_type[$i] == 1){
             
             if(file_exists('./assets/price_books/'.$component_img[$i]) && $component_img[$i]!=""){
                  $filename2 = time().$component_img[$i];
                  copy('assets/price_books/'.$component_img[$i], 'assets/price_books/'.$filename2);
                  copy('assets/price_books/'.$component_img[$i], 'assets/price_books/thumbnail/'.$filename2);
                }
                if(file_exists('./assets/price_books/component_documents/specification/'.$specification[$i]) && $specification[$i]!=""){
                  $specification_document = time().$specification[$i];
                  copy('assets/price_books/component_documents/specification/'.$specification[$i], 'assets/price_books/component_documents/specification/'.$specification_document);
                }
                if(file_exists('./assets/price_books/component_documents/warranty/'.$warranty[$i]) && $warranty[$i]!=""){
                  $warranty_document = time().$warranty[$i];
                  copy('assets/price_books/component_documents/warranty/'.$warranty[$i], 'assets/price_books/component_documents/warranty/'.$warranty_document);
                }
                if(file_exists('./assets/price_books/component_documents/maintenance/'.$maintenance[$i]) && $maintenance[$i]!=""){
                  $maintenance_document = time().$maintenance[$i];
                  copy('assets/price_books/component_documents/maintenance/'.$maintenance[$i], 'assets/price_books/component_documents/maintenance/'.$maintenance_document);
                }
               
                if(file_exists('./assets/price_books/component_documents/installation/'.$installation[$i]) && $installation[$i]!=""){
                  $installation_document = time().$installation[$i];
                  copy('assets/price_books/component_documents/installation/'.$installation[$i], 'assets/price_books/component_documents/installation/'.$installation_document);
                }
           }
           else if($component_type[$i] == 2){
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
                             $component_supplier_id = $this->mod_common->insert_into_table('project_suppliers', $supplier);
                        }
                        else{
                            $component_supplier_id = $existing_supplier["supplier_id"];
                        }
                        
               //Adding New Component if not exists
                        $component = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'component_name' => $component_name[$i],
                            'component_des' => $component_des[$i],
                            'component_uom' => $component_uom[$i],
                            'component_uc' => $component_uc[$i],
                            'supplier_id' => $component_supplier_id,
                            'component_status' => $component_status[$i],
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

            $component = array(
                'price_book_id' => $price_book_id,
                'component_category' => $component_category[$i],
                'component_id' => $component_id[$i],
                'component_name' => $component_name[$i],
                'component_des' => $component_des[$i],
                'component_uom' => $component_uom[$i],
                'component_uc' => $component_uc[$i],
                'component_margin' => $component_margin[$i],
                'component_marginline' => $component_marginline[$i],
                'component_sale_price' => $component_sale_price[$i],
                'component_status' => $component_status[$i],
                'supplier_id' => $component_supplier_id,
                'image' =>  $filename2,
            );
            
            $this->mod_common->insert_into_table('project_price_book_components', $component);
            $price_book_component_inserted_id = $this->db->insert_id();
            
                $document_array = array(
                   "component_id" => $price_book_component_inserted_id,
                   "specification" => $specification_document,
                   "warranty" => $warranty_document,
                   "maintenance" => $maintenance_document,
                   "installation" => $installation_document
                );
                
                $this->mod_common->insert_into_table('project_price_book_component_documents', $document_array);
                if($checklist[$i]){
                    $checklist_items = explode(",", rtrim($checklist[$i], ","));
                    for($j=0;$j<count($checklist_items);$j++){
                        $checklist_array = array(
                           "component_id" => $price_book_component_inserted_id,
                           "checklist" => $checklist_items[$j],
                        );
                        
                        $this->mod_common->insert_into_table('project_price_book_component_checklists', $checklist_array);
                    }
                }
            }
            
            }
            
            }
            else{
                $this->session->set_flashdata('err_message', 'Please select atleast one part to save this price book.');
                redirect(SURL.'supplierz/add_price_book');  
            }
        
            $this->session->set_flashdata("ok_message", "Price Book Saved Successfully!");
            $data['price_books'] = $this->mod_common->get_all_records('project_price_books', "*", 0, 0, array("company_id" => $this->session->userdata("company_id")));

            redirect(SURL."supplierz/edit_price_book/".$price_book_id);
    }
    }
    
    public function import_component_by_csv(){
    	    $categories = $this->mod_common->get_all_records('project_categories', "*", 0, 0, array("status" => 1));
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
                                if(!isset($data[8])){
                                    echo "File format is wrong. Please upload correct file.";exit;
                                }
                                else{
                                    $html .= '<tr class="pb'.$count.'" id="trnumber'.$count.'" tr_val="'.$count.'">
    <input  name="component_type[]" rno ="'.$count.'" id="component_type'.$count.'" type="hidden" value="2" />
    <td>
                                        <select data-container="body" class="selectpicker"  name="component_category['.$count.']" data-style="select-with-transition" data-live-search="true">
                                            <option value="0">Select Category</option>';
                                            foreach($categories as $category){
                                            $html .='<option value="'.$category["name"].'">'.$category["name"].'</option>';
                                            } 
                                        $html .='</select>
                                      </td>
                                      <td>
                                            <div class="form-group">'.
                                                $data[0].'
                                                 <input type="hidden" name="component_id['.$count.']" id="componentidfield'.$count.'" value="'.$data[0].'">
                                                <input type="hidden" name="component_name['.$count.']" id="componentnamefield'.$count.'" value="'.$data[0].'">
                                                 <input type="hidden" name="supplier_id['.$count.']" id="supplierfield'.$count.'" value="'.$data[1].'">
                                            </div>
                                      </td>
                                       <td>'.$data[3].'<input type="hidden" name="component_uom['.$count.']" id="uomfield'.$count.'" value="'.$data[3].'" placeholder="Enter Unit of Measure" required="true"></td>
                                      <td> 
                                      '.$data[4].'<input type="hidden" name="component_uc['.$count.']" id="ucostfield'.$count.'" value="'.$data[4].'" onchange="return calculateTotal('.$count.');" placeholder="Enter Unit Cost" required="true">
                                      <input type="hidden" name="order_unit_cost['.$count.']" id="order_unit_cost'.$count.'" value="'.$data[4].'">
                                      </td>
                                      <td>'.$data[5].'<input type="hidden" name="component_margin_percentage['.$count.']" id="marginfield'.$count.'" value="'.$data[5].'" placeholder="Enter Margin %" required="true" onchange="return calculateTotal('.$count.');"></td>
                                      <td>'.$data[6].' <input type="hidden" name="component_margin['.$count.']" id="marginlinefield'.$count.'" value="'.$data[6].'" placeholder="Enter Margin $" required="true" onchange="return calculateTotal('.$count.');"></td>
                                      <td>'.$data[7].' <input type="hidden" name="component_sale_price['.$count.']" id="linetotalfield'.$count.'" value="'.$data[7].'" placeholder="Enter Sale Price $" required="true"></td>
                                                              
                                      <td class="optional_column">
                                                                
                                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                        <div class="fileinput-new thumbnail preview_component_image'.$count.'">
                                                                            <img src="'.IMG.'image_placeholder.jpg" alt="..." style="width:100px;height:100px;">
                                                                        </div>
                                                                    <input type="hidden" id="component_img'.$count.'" name="component_img['.$count.']" value=""/>
                                                                </div>
                                      </td>
                                      <td class="optional_column">'.$data[2].'<input type="hidden" name="component_des['.$count.']" placeholder="Enter Component Description" required="true" value="'.$data[2].'"></td>
                                      <td class="optional_column">
                                           <input type="hidden" id="specification'.$count.'" name="specification['.$count.']" value="" rowno="'.$count.'">
                                          <div class="specification_container'.$count.'"></div>
                                      </td>
                                      <td class="optional_column">
                                          <input type="hidden" id="warranty'.$count.'" name="warranty['.$count.']" value="" rowno="'.$count.'">
                                          <div class="warranty_container'.$count.'"></div>
                                      </td>
                                      <td class="optional_column">
                                          <input type="hidden" id="maintenance'.$count.'" name="maintenance['.$count.']" value="" rowno="'.$count.'">
                                          <div class="maintenance_container'.$count.'"></div>
                                      </td>
                                      <td class="optional_column">
                                           <input type="hidden" id="installation'.$count.'" name="installation['.$count.']" value="" rowno="'.$count.'">
                                          <div class="installation_container'.$count.'"></div>
                                      </td>
                                       <td class="optional_column">
                                          <input type="hidden" id="checklist'.$count.'" name="checklist['.$count.']" value="" rowno="'.$count.'">
                                          <div class="checklist_container'.$count.'"></div>
                                      </td>
                                      <td>
                                       <input type="hidden" name="component_status['.$count.']" value="'.$data[8].'">';
                                       
                                            if($data[8]==1){
                                             $html .='CURRENT';
                                             }
                                            else{
                                             $html .='INACTIVE';
                                             }
                                            
                                      $html .='</td>
                                      <td>
                                          <a  class="btn btn-danger btn-icon btn-simple remove remove_component" rowno="'.$count.'" tabletype="pocos" type="button"><i class="material-icons">delete</i></a>
                                      </td>
		</tr>';
                                  $count++;  
                                }
                                
                            }//end of if
                            $k++;
                        }//end of while
                        echo $html;
	}
    
    //Edit Price Book Screen
    public function edit_price_book($price_book_id){
        $this->mod_common->is_company_page_accessible(114);
        $data['categories'] = $this->mod_common->get_all_records('project_categories', "*", 0, 0, array("status" => 1));
        $data['existing_price_books'] = $this->mod_common->get_all_records('price_books', "*", 0, 0, array("company_id" => $this->session->userdata("company_id")));
        $data['price_book_components'] = $this->mod_price_book->get_price_book_details($price_book_id);
        $data['assigned_users'] = $this->mod_common->get_all_records('project_allocate_price_books', "*", 0, 0, array("price_book_id" => $price_book_id));
        if(count($data['price_book_components'])>0){
        $this->stencil->title('Edit Price Book');
	    $this->stencil->paint('supplierz/price_books/edit_price_book', $data);
        }
        else{
             $this->session->set_flashdata('err_message', "You don't have permission to access this page or may be page does not exists.");
             redirect(SURL."supplierz/price_books");
        }
    }
    
    //Update Price Book
    public function update_price_book_process(){
        $this->mod_common->is_company_page_accessible(114);
        
        $existing_components= $this->mod_price_book->get_price_book_details();
        
        $existing_components_arr=array();
        
        foreach ($existing_components as $key => $value) {
          array_push($existing_components_arr,$value['id'] );

        }
        
        $component_id = array_values($this->input->post('component_id'));
        $component_margin =  array_values($this->input->post('component_margin_percentage'));
        $component_marginline =  array_values($this->input->post('component_margin'));
        $component_sale_price =  array_values($this->input->post('component_sale_price'));
        $include_in_price_book = array_values($this->input->post('include_in_price_book'));
        $parent_component_id = array_values($this->input->post('parent_component_id'));
       
            $updatedarr = array();
            
            if(count($component_id)>0){
                for($i=0;$i<count($component_id);$i++){
                        $component = array(
                            'component_margin' => $component_margin[$i],
                            'component_marginline' => $component_marginline[$i],
                            'component_sale_price' => $component_sale_price[$i]
                        );
                       $this->mod_common->update_table('project_price_book_components', array("id"=>$component_id[$i]), $component);
                       array_push($updatedarr, $component_id[$i]);
                    
                    //Update Price Book to Builderz User who has price book shared checked
                    
                    $builderz_users = $this->mod_common->get_all_records("project_allocate_price_books", "*", 0, 0);
                    foreach($builderz_users as $val){
                        $is_component_exists = $this->mod_common->select_single_records("project_components", array("parent_component_id" => $parent_component_id[$i], "company_id" => $val['user_id']));
                        if(count($is_component_exists) == 0){
                            $component_info = $this->mod_common->select_single_records('project_price_book_components', array("id" => $component_id[$i]));
                			
                			$supplier_user_id = $component_info["supplier_id"];
               
                            $where = "parent_supplier_id = '".$supplier_user_id."' AND company_id = ".$val['user_id'];
               
                            $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);
                                   
                            if(count($data['supplier_info'])==0){
                            
                                        $where = "user_id = '".$supplier_user_id."'";
                                   
                                        $supplier_user_info = $this->mod_common->select_single_records('project_users', $where);
                               
                                        $supplier_detail = array(
                                                'user_id' => $val['user_id'],
                                                'company_id' => $val['user_id'],
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
                            
                            $component_ins = array(
                				'parent_component_id' => $component_info["component_id"],
                                'component_name' => $component_info["component_name"],
                                'component_des' => $component_info["component_des"],
                                'component_uom' => $component_info["component_uom"],
                                'component_uc' => $component_info["component_sale_price"],
                                'supplier_id' => $part_supplier_id,
                                'component_status' => 1,
                                'image' => $component_info["image"],
                				"user_id"	  =>	$val['user_id'],
            					"company_id"  =>	$val['user_id']
                				                    
                			);
                				                
                			$this->mod_common->insert_into_table('project_components',$component_ins);
                				            
                			if($component_info["image"]!=""){
                                copy('assets/price_books/'.$component_info["image"], 'assets/components/'.$component_info["image"]);
                                copy('assets/price_books/'.$component_info["image"], 'assets/components/thumbnail/'.$component_info["image"]);
                			}
                        }
                        else{
                            $this->mod_common->update_table("project_components", array("parent_component_id" => $parent_component_id[$i], "company_id" => $val['user_id']), array("component_uc" =>  $component_sale_price[$i]));
                            //$this->mod_common->update_table("project_tpl_component_part", array("component_id" => $is_component_exists["component_id"], "company_id" => $val['user_id']), array("tpl_part_component_uc" =>  $component_sale_price[$i]));
                        }
                    }
                }
            }
            
            if(count($updatedarr)>0){
                $diffarr=array_diff($existing_components_arr,$updatedarr);
                foreach ($diffarr as $kem => $val) {
                   $where = array('id' => $val);
                    $price_books_components = $this->mod_common->select_single_records('project_price_book_components', $where);
                    
                        if(count($price_books_components)>0 && $price_books_components['image']!="" && file_exists('./assets/price_books/'.$price_books_components['image'])){
                                        unlink('./assets/price_books/'.$price_books_components['image']);
                        }
                   $this->mod_common->delete_record('project_price_book_components', $where);
                   
                   $component_documents = $this->mod_common->select_single_records('project_price_book_component_documents', array("component_id" => $val));
                    if(count($component_documents)>0 && $component_documents['specification']!=""){
                        if(file_exists('./assets/price_books/component_documents/specification/'.$component_documents['specification'])){
                                unlink('./assets/price_books/component_documents/specification/'.$component_documents['specification']);
                        }
                    }
                    
                    if(count($component_documents)>0 && $component_documents['warranty']!=""){
                        if(file_exists('./assets/price_books/component_documents/warranty/'.$component_documents['warranty'])){
                                unlink('./assets/price_books/component_documents/warranty/'.$component_documents['warranty']);
                        }
                    }
                    
                    if(count($component_documents)>0 && $component_documents['maintenance']!=""){
                        if(file_exists('./assets/price_books/component_documents/maintenance/'.$component_documents['maintenance'])){
                                unlink('./assets/price_books/component_documents/maintenance/'.$component_documents['maintenance']);
                        }
                    }
                    
                    if(count($component_documents)>0 && $component_documents['installation']!=""){
                        if(file_exists('./assets/price_books/component_documents/installation/'.$component_documents['installation'])){
                                unlink('./assets/price_books/component_documents/installation/'.$component_documents['installation']);
                        }
                    }
                        
                   $this->mod_common->delete_record('project_price_book_component_documents', array("component_id" => $val));
                   $this->mod_common->delete_record('project_price_book_component_checklists', array("component_id" => $val));
                   $this->mod_common->update_table("project_components", array("component_id" => $price_books_components['component_id']), array("include_in_price_book" => 0));
                   $this->mod_common->update_table("project_supplierz_tpl_component_part", array("component_id" => $price_books_components['component_id']), array("tpl_part_component_uom" => "", "tpl_part_component_uc" => ""));
               
                }
            }
            
            $this->session->set_flashdata("ok_message", "Price Book Updated Successfully!");
    
            redirect(SURL."supplierz/price_books");
    }
    
    //Delete Price Book
    public function delete_price_book(){
            $this->mod_common->is_company_page_accessible(114);
            $price_book_id = $this->input->post("id"); 
            $where = array('id' => $price_book_id, "company_id" => $this->session->userdata("company_id"));
            if ($this->mod_common->delete_record('project_price_books', $where)) {
                $where = array('price_book_id' => $price_book_id);
                $price_books_components = $this->mod_common->get_all_records('project_price_book_components', "*", 0, 0, $where);
                foreach($price_books_components as $val){
                    if(file_exists('./assets/price_books/'.$val['image'])){
                                    unlink('./assets/price_books/'.$val['image']);
                    }
                    $where = array('id' => $val['id']);
                    $this->mod_common->delete_record('project_price_book_components', $where);
                    $component_documents = $this->mod_common->get_all_records('project_price_book_component_documents', "*", 0, 0, array("component_id" => $val->id));
                if($component_documents['specification']!=""){
                    if(file_exists('./assets/price_books/component_documents/specification/'.$component_documents['specification'])){
                            unlink('./assets/price_books/component_documents/specification/'.$component_documents['specification']);
                    }
                }
                
                if($component_documents['warranty']!=""){
                    if(file_exists('./assets/price_books/component_documents/warranty/'.$component_documents['warranty'])){
                            unlink('./assets/price_books/component_documents/warranty/'.$component_documents['warranty']);
                    }
                }
                
                if($component_documents['maintenance']!=""){
                    if(file_exists('./assets/price_books/component_documents/maintenance/'.$component_documents['maintenance'])){
                            unlink('./assets/price_books/component_documents/maintenance/'.$component_documents['maintenance']);
                    }
                }
                
                if($component_documents['installation']!=""){
                    if(file_exists('./assets/price_books/component_documents/installation/'.$component_documents['installation'])){
                            unlink('./assets/price_books/component_documents/installation/'.$component_documents['installation']);
                    }
                }
                    
               $this->mod_common->delete_record('project_price_book_component_documents', array("component_id" => $val->id));
               $this->mod_common->delete_record('project_price_book_component_checklists', array("component_id" => $val->id));
                }
                
                $this->session->set_flashdata("ok_message", "Price Book Deleted Successfully!");
                
                redirect(SURL."supplierz/price_books");
            }
            else{
             $this->session->set_flashdata('err_message', 'Record does not exists');
             redirect(SURL."supplierz/price_books");
        }

    }
    
    //Update Users
    public function update_users(){
        
        $price_book_id = $this->input->post('allocate_price_book');
         
        $existing_components= $this->mod_price_book->get_price_book_details($price_book_id);
         
        $supplier_info = $this->mod_common->select_single_records('project_suppliers', array("parent_supplier_id" => $this->session->userdata("user_id")));
        
        $existing_components_arr=array();
        
        $existing_user_components = $this->mod_common->get_all_records('project_components', "*", 0, 0,  array("price_book_id" => $price_book_id), "component_id");
        
        foreach ($existing_user_components as $key => $value) {
          array_push($existing_components_arr,$value["parent_component_id"] );
        }
        
        $updatedarr = array();
        
        foreach ($existing_components as $key => $value) {
        if(count($existing_components)>0){
              $assigned_users = $this->mod_common->get_all_records('project_allocate_price_books', "*", 0, 0, array("price_book_id" => $price_book_id));
            
              if(count($assigned_users)>0){
                 foreach($assigned_users as $user){
                    $is_component_exist = $this->mod_common->select_single_records('project_components', array("price_book_id" => $price_book_id, "parent_component_id" =>$value['component_id'], "company_id" => $user['company_id'] ));
                    
                    $component_name =  $value['component_name'];
                    $component_des =  $value['component_des'];
                    $component_uom =  $value['component_uom'];
                    $component_uc =  $value['component_uc'];
                    $component_status =  $value['component_status'];
                    $component_image =  $value['image'];
                    $component_category =  $value['component_category'];
                    
                    $document_info = get_document_info($value['component_id']);
                    
                    if(count($document_info)>0){
                        $specification =  $document_info['specification'];
                        $warranty =  $document_info['warranty'];
                        $maintenance =  $document_info['maintenance'];
                        $installation =  $document_info['installation'];
                    } else{
                        $specification =  "";
                        $warranty =  "";
                        $maintenance =  "";
                        $installation =  "";
                    }
                    
                    $component = array(
                        'user_id' => $user['user_id'],
                        'company_id' => $user['company_id'],
                        'parent_component_id' => $value['component_id'],
                        'component_name' => $component_name,
                        'component_des' => $component_des,
                        'component_uom' => $component_uom,
                        'component_uc' => $component_uc,
                        'supplier_id' => $supplier_info['supplier_id'],
                        'component_status' => $component_status,
                        'component_category' => $component_category,
                        'image' => $component_image,
                        'specification' => $specification,
                        'warranty' => $warranty,
                        'maintenance' => $maintenance,
                        'installation' => $installation,
                        'price_book_id' => $price_book_id
                    );
                    
                    if(count($is_component_exist)==0){
                        
                         $this->mod_common->insert_into_table('project_components', $component);
                         $component_id = $this->db->insert_id();
                         if($component_image!=""){
                            copy('assets/price_books/'.$component_image, 'assets/components/'.$component_image);
                            copy('assets/price_books/'.$component_image, 'assets/components/thumbnail/'.$component_image);
                         }
                         if($specification!=""){
                           copy('assets/price_books/component_documents/specification/'.$specification, 'assets/component_documents/specification/'.$specification);
                         }
                         
                         if($warranty!=""){
                            copy('assets/price_books/component_documents/warranty/'.$warranty, 'assets/component_documents/warranty/'.$warranty);
                        }
                        if($maintenance!=""){
                            copy('assets/price_books/component_documents/maintenance/'.$maintenance, 'assets/component_documents/maintenance/'.$maintenance);
                        }
                        
                        if($installation!=""){
                             copy('assets/price_books/component_documents/installation/'.$installation, 'assets/component_documents/installation/'.$installation);
                        }
                        
                         $checklist_items = $this->mod_common->get_all_records('project_price_book_component_checklists', "*", 0, 0, array("component_id" => $value['component_id']));
                        
                            if(count($checklist_items)>0){
                                foreach($checklist_items as $ck){
                                    $checklist_array = array(
                                       "component_id" => $component_id,
                                       "checklist" => $ck['checklist'],
                                    );
                                   
                                $this->mod_common->insert_into_table('project_component_checklists', $checklist_array);
                                 
                                }
                            }
                         array_push($updatedarr,$component_id);
                    }
                    else{
                        $this->mod_common->update_table('project_components', array("parent_component_id"=>$value['component_id']), $component); 
                        
                         if($component_image!=""){
                            if(file_exists('./assets/components/'.$component_image)){
                                if($is_component_exist['image']!=$component_image){
                                  unlink('./assets/components/'.$component_image);
                                  unlink('./assets/components/thumbnail/'.$component_image);
                                  copy('assets/price_books/'.$component_image, 'assets/components/'.$component_image);
                                  copy('assets/price_books/'.$component_image, 'assets/components/thumbnail/'.$component_image);
                                }
                            }
                            else{
                              copy('assets/price_books/'.$component_image, 'assets/components/'.$component_image);
                              copy('assets/price_books/'.$component_image, 'assets/components/thumbnail/'.$component_image);
                            }
                        }
                        if($specification!=""){
                            if(file_exists('./assets/component_documents/specification/'.$specification)){
                                if($is_component_exist['specification']!=$specification){
                                  unlink('./assets/component_documents/specification/'.$specification);
                                  copy('assets/price_books/component_documents/specification/'.$specification, 'assets/component_documents/specification/'.$specification);
                                }
                            }
                                else{
                                  copy('assets/price_books/component_documents/specification/'.$specification, 'assets/component_documents/specification/'.$specification);
                            }
                        }
                        if($warranty!=""){
                            if(file_exists('./assets/component_documents/warranty/'.$warranty)){
                                if($is_component_exist['warranty']!=$warranty){
                                  unlink('./assets/component_documents/warranty/'.$warranty);
                                  copy('assets/price_books/component_documents/warranty/'.$warranty, 'assets/component_documents/warranty/'.$warranty);
                                }
                            }
                            else{
                              copy('assets/price_books/component_documents/warranty/'.$warranty, 'assets/component_documents/warranty/'.$warranty);
                            }
                        }
                        if($maintenance!=""){
                    
                            if(file_exists('./assets/component_documents/maintenance/'.$maintenance)){
                                if($is_component_exist['maintenance']!=$maintenance){
                                  unlink('./assets/component_documents/maintenance/'.$maintenance);
                                  copy('assets/price_books/component_documents/maintenance/'.$maintenance, 'assets/component_documents/maintenance/'.$maintenance);
                                }
                            }
                            else{
                              copy('assets/price_books/component_documents/maintenance/'.$maintenance, 'assets/component_documents/maintenance/'.$maintenance);
                            }
                        }
                        
                        if($installation!=""){
                    
                            if(file_exists('./assets/component_documents/installation/'.$installation)){
                                if($is_component_exist['installation']!=$installation){
                                  unlink('./assets/component_documents/installation/'.$installation);
                                  copy('assets/price_books/component_documents/installation/'.$installation, 'assets/component_documents/installation/'.$installation);
                                }
                            }
                            else{
                              copy('assets/price_books/component_documents/installation/'.$installation, 'assets/component_documents/installation/'.$installation);
                            }
                        }
                        
                        $this->mod_common->delete_record('project_component_checklists', array("component_id"=>$is_component_exist["component_id"]));
                        
                        $checklist_items = $this->mod_common->get_all_records('price_book_component_checklists', "*", 0, 0, array("component_id" => $value['component_id']));
                        
                            if(count($checklist_items)>0){
                                foreach($checklist_items as $ck){
                                    $checklist_array = array(
                                       "component_id" => $is_component_exist["component_id"],
                                       "checklist" => $ck['checklist'],
                                    );
                                $this->mod_common->insert_into_table('project_component_checklists', $checklist_array);
                                }
                            }
                         array_push($updatedarr, $is_component_exist["component_id"]);
                    }
               }
              }
           
        }
           
        }
        
            $diffarr=array_diff($existing_components_arr,$updatedarr);
           
            
            foreach ($diffarr as $kem => $val) {
               $where = array('parent_component_id' => $val);
                $price_books_components = $this->mod_common->get_all_records('project_components', "*", 0, 0, $where, "component_id");
                    if(count($price_books_components)>0){
                        if(isset($price_books_components['image']) && $price_books_components['image']!=""){
                            if(file_exists('./assets/components/'.$price_books_components['image'])){
                                    unlink('./assets/components/'.$price_books_components['image']);
                                    unlink('./assets/components/thumbnail/'.$price_books_components['image']);
                            }
                        }
                        if(isset($price_books_components['specification']) && $price_books_components['specification']!=""){    
                            if(file_exists('./assets/component_documents/specification/'.$price_books_components['specification'])){
                                    unlink('./assets/component_documents/specification/'.$price_books_components['specification']);
                            }
                        }
                        if(isset($price_books_components['warranty']) && $price_books_components['warranty']!=""){
                            
                            if(file_exists('./assets/component_documents/warranty/'.$price_books_components['warranty'])){
                                    unlink('./assets/component_documents/warranty/'.$price_books_components['warranty']);
                            }
                        }
                        if(isset($price_books_components['maintenance']) && $price_books_components['maintenance']!=""){
                            
                            if(file_exists('./assets/component_documents/maintenance/'.$price_books_components['maintenance'])){
                                    unlink('./assets/component_documents/maintenance/'.$price_books_components['maintenance']);
                            }
                        }
                        if(isset($price_books_components['installation']) && $price_books_components['installation']!=""){
                            
                            if(file_exists('./assets/component_documents/installation/'.$price_books_components['installation'])){
                                    unlink('./assets/component_documents/installation/'.$price_books_components['installation']);
                            }
                        }
                            
                       $this->mod_common->delete_record('project_components', $where);
                       $this->mod_common->delete_record('project_component_checklists', array("component_id"=>$val));
                    }
            }
        
            $this->session->set_flashdata("ok_message", "Users Updated Successfully!");

            redirect(SURL."supplierz/edit_price_book/".$price_book_id);
    }
    
    //Upload New Document
    public function upload_document(){
       $type = $this->input->post("document_type");
       $filename= "";

       if (isset($_FILES[$type.'_file']['name']) && $_FILES[$type.'_file']['name'] != "") {
						
						$projects_folder_path = './assets/price_books/component_documents/'.$type;
						$projects_folder_path_main = './assets/price_books/component_documents/'.$type;

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
        $where = array('id' => $file);
        $file_info = $this->mod_common->get_all_records('project_price_book_component_documents', "*", 0, 0, $where);
        $this->mod_common->update_table('project_price_book_component_documents', $where, array($type => ""));
        $file_name="./assets/price_books/component_documents/".$type."/".$file_info[$type];
     }
     else{
         $file_name="./assets/price_books/component_documents/".$type."/".$file;
     }
     
        if(file_exists($file_name)){
    	   unlink($file_name);
        }
    
    }
    
    //Remove Checklist
    public function remove_checklist(){
        $id = $this->input->post("id");
        $this->mod_common->delete_record('project_price_book_component_checklists', array("id" => $id));
    }
    
    //Populate Components By Existing Price Book
    public function populate_components_by_price_book() {
		$data['last_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
		$id = $this->input->post("price_book_id");

		if ($id > 0) {
			$data['components'] = $this->mod_common->get_all_records('project_price_book_components', "*", 0, 0, array("price_book_id" => $id));
			$data['categories'] = $this->mod_common->get_all_records('project_categories', "*", 0, 0, array("status" => 1));
			$data['price_book_id'] =$id;
	
			$html = $this->load->view('supplierz/price_books/populate_components_by_price_book', $data, true);

			$rArray = array("rData" => $html);
			header('Content-Type: application/json');
			echo json_encode($rArray);
		} else {

		}
	}
	
	
	//Manage Price Book Requests
	public function price_book_requests(){
	    $this->mod_common->is_company_page_accessible(119);
	    $where = "to_user_id = '".$this->session->userdata('user_id')."' AND (status = 0 OR status = 1 OR status = -1)";
        $data['price_book_requests'] = $this->mod_common->get_all_records('price_book_requests', "*", 0, 0, $where);
        $this->stencil->title('Manage Price Book Requests');
	    $this->stencil->paint('supplierz/price_books/manage_requests', $data);
	}
	
	//Accept Price Book Request
	public function accept_request(){
        $request_id = $this->input->post("id");
        if($request_id>0){
            $this->mod_common->update_table('project_price_book_requests', array("id"=>$request_id) , array("status" => 1));
            $where = "to_user_id = '".$this->session->userdata('user_id')."' AND (status = 0 OR status = 1 OR status = -1)";
            $data['price_book_requests'] = $this->mod_common->get_all_records('price_book_requests', "*", 0, 0, $where);
            $this->load->view("supplierz/price_books/manage_requests_ajax", $data);
        }
        else{
            redirect(SURL."nopage");
        }
    }
    
    //Decline Price Book Request
    public function decline_request(){
        $request_id = $this->input->post("id");
        if($request_id>0){
             $this->mod_common->update_table('project_price_book_requests', array("id"=>$request_id) , array("status" => -1));
            $where = "to_user_id = '".$this->session->userdata('user_id')."' AND (status = 0 OR status = 1 OR status = -1)";
            $data['price_book_requests'] = $this->mod_common->get_all_records('price_book_requests', "*", 0, 0, $where);
            $this->load->view("supplierz/price_books/manage_requests_ajax", $data);
        }
        else{
            redirect(SURL."nopage");
        }
    }
    
    
    //Manage Price Book Allocation
    function manage_allocate() {
        $this->mod_common->is_company_page_accessible(127);
        $where = "to_user_id = '".$this->session->userdata('user_id')."' AND (status = 1 OR status = 2)";
        $data['price_book_requests'] = $this->mod_common->get_all_records('price_book_requests', "*", 0, 0, $where);

        $this->stencil->title('Manage Allocate Price');
	    $this->stencil->paint('supplierz/price_books/manage_allocate', $data);
    }
    
    //Allocate Price Book
    function allocate_price_book($id) {
        $this->mod_common->is_company_page_accessible(127);
        $where = "to_user_id = '".$this->session->userdata('user_id')."' AND (status = 1 OR status = 2) AND id='".$id."'";
        
        $data['price_book_request'] = $this->mod_common->select_single_records('project_price_book_requests', $where);
        
        $user_info = get_price_book_supplier_info($data['price_book_request']["from_user_id"]);
        if($user_info['company_id']==0){
            $company_id = $user_info['user_id'];
        }
        else{
            $company_id = $user_info['company_id'];
        }
         $data['price_book_list'] = $this->mod_price_book->get_price_book_lists($data['price_book_request']["from_user_id"], $company_id);
         
         $supplier_user_id = $this->session->userdata('company_id');
        
        $where = "user_id = '".$supplier_user_id."'";
        
        $data['supplier_user_info'] = $this->mod_common->select_single_records('project_users', $where);
        
        $supplier_user_id = $this->session->userdata('company_id');
        
        $where = "parent_supplier_id = '".$supplier_user_id."'";
        
        $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);

        $this->stencil->title('Allocate Price Book');
	    $this->stencil->paint('supplierz/price_books/allocate_price_book', $data);
    }
    
    //View Price Book Details
    function view($id) {
        $this->mod_common->is_company_page_accessible(127);
        $where = "to_user_id = '".$this->session->userdata('user_id')."' AND status=2 AND id='".$id."'";
        
        $data['price_book_request'] = $this->mod_common->select_single_records('project_price_book_requests', $where);
        
        $user_info = get_price_book_supplier_info($data['price_book_request']["from_user_id"]);
        if($user_info['company_id']==0){
            $company_id = $user_info['user_id'];
        }
        else{
            $company_id = $user_info['company_id'];
        }
         $data['price_book_list'] = $this->mod_price_book->get_price_book_lists($data['price_book_request']["from_user_id"], $company_id);
         
        $supplier_user_id = $this->session->userdata('company_id');
        
        $where = "parent_supplier_id = '".$supplier_user_id."'";
        
        $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);

        $this->stencil->title('Allocate Price Book');
	    $this->stencil->paint('supplierz/price_books/allocate_price_book', $data);
    }
    
    //Allocate Price Book to User
    function allocate_price_book_process(){
        $this->mod_common->is_company_page_accessible(127);
        $supplier_user_id = $this->session->userdata('company_id');
        
        $where = "parent_supplier_id = '".$supplier_user_id."'";
        
        $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);
        
        if(count($data['supplier_info'])==0){
    		$this->form_validation->set_rules('supplier_phone', 'Supplier Phone', 'required');
    		$this->form_validation->set_rules('supplier_web', 'Supplier Website', 'required');
    		$this->form_validation->set_rules('supplier_contact_person', 'Supplier Contact Person', 'required');
    		$this->form_validation->set_rules('supplier_contact_person_mobile', 'Supplier Contact Person Mobile', 'required');
    		$this->form_validation->set_rules('street_pobox', 'Street', 'required');
    		$this->form_validation->set_rules('suburb', 'Suburb', 'required');
    		$this->form_validation->set_rules('supplier_state', 'Region', 'required');
    		$this->form_validation->set_rules('supplier_city', 'City', 'required');
    		$this->form_validation->set_rules('supplier_country', 'Country', 'required');
    		$this->form_validation->set_rules('supplier_zip', 'ZIP Code', 'required');
        }
		$this->form_validation->set_rules('allocate_price_book_id', 'Allocate Price Book', 'required');
		$this->form_validation->set_rules('notes', 'Notes', 'required');
		
		if ($this->form_validation->run() == FALSE)
			{
    		$id = $this->input->post("request_id");
    			    
    		$where = "to_user_id = '".$this->session->userdata('user_id')."' AND (status = 1 OR status = 2) AND id='".$id."'";
            
            $data['price_book_request'] = $this->mod_common->select_single_records('project_price_book_requests', $where);
            
            $user_info = get_price_book_supplier_info($data['price_book_request']["from_user_id"]);
            if($user_info['company_id']==0){
                $company_id = $user_info['user_id'];
            }
            else{
                $company_id = $user_info['company_id'];
            }
             $data['price_book_list'] = $this->mod_price_book->get_price_book_lists($data['price_book_request']["from_user_id"], $company_id);
             
             $supplier_user_id = $this->session->userdata('company_id');
            
            $where = "user_id = '".$supplier_user_id."'";
            
            $data['supplier_user_info'] = $this->mod_common->select_single_records('project_users', $where);
    
            $this->stencil->title('Allocate Price Book');
    	    $this->stencil->paint('supplierz/price_books/allocate_price_book', $data);
			}
		else{
		
        $user_id = $this->input->post("from_user_id");
        $company_id = $this->input->post("company_id");
        $price_book_id = $this->input->post("allocate_price_book_id");
        $notes = $this->input->post("notes");
        $request_id = $this->input->post("request_id");
        
        $ins_array = array(
            "user_id" => $user_id,
            "price_book_id" => $price_book_id,
            "company_id" => $company_id
            );
        
        $this->mod_common->insert_into_table('project_allocate_price_books', $ins_array);
        $this->mod_common->update_table('project_price_book_requests', array("id"=>$request_id), array("status" => 2, "allocate_price_book_id" => $price_book_id, "notes" => $notes));
         
        $supplier_user_id = $this->session->userdata('company_id');
        
        $is_supplier_exist = $this->mod_common->select_single_records('project_suppliers', array("parent_supplier_id"=>$supplier_user_id, 'company_id' => $company_id));
        if(count($is_supplier_exist)==0){
        
        $where = "user_id = '".$supplier_user_id."'";
        
        $supplier_user_info = $this->mod_common->select_single_records('project_users', $where);
        
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
        
        $supplier_detail = array(
                'user_id' => $user_id,
                'company_id' => $company_id,
                'parent_supplier_id' => $this->session->userdata('company_id'),
                'supplier_name' => $supplier_user_info['com_name'],
                'supplier_status' => 1,
                'supplier_city' => $supplier_city,
                'supplier_postal_city' => $supplier_postal_city,
                'supplier_zip' => $supplier_zip,
                'supplier_postal_zip' => $supplier_postal_zip,
                'post_street_pobox' => $post_street_pobox,
                'post_suburb' => $post_suburb,
                'street_pobox' => $street_pobox,
                'supplier_country' => $supplier_country,
                'supplier_postal_country' => $supplier_postal_country,
                'suburb' => $suburb,
                'supplier_email' => $supplier_user_info['user_email'],
                'supplier_phone' => $supplier_phone,
                'supplier_web' => $supplier_web,
                'supplier_state' => $supplier_state,
                'supplier_postal_state' =>$supplier_postal_state,
                'supplier_contact_person' => $supplier_contact_person,
                'supplier_contact_person_mobile' => $supplier_contact_person_mobile
            );
            
        $this->mod_common->insert_into_table('project_suppliers', $supplier_detail);
        
        $supplier_id = $this->db->insert_id();
         
        }
        else{
           $supplier_id = $is_supplier_exist["supplier_id"];
        }
        
        $where = "price_book_id = '".$price_book_id."'";
        
        $components = $this->mod_common->get_all_records('project_price_book_components', "*", 0, 0, $where);
        
        if(count($components)>0){
            foreach($components as $component){
                     $is_component_exist = $this->mod_common->select_single_records('project_components', array("price_book_id" => $price_book_id, "parent_component_id" =>$component['id'], "company_id" => $company_id));
                   if(count($is_component_exist)==0){
                         if($component['image']!="" && file_exists('./assets/price_books/'.$component['image'])){   
                                copy('assets/price_books/'.$component['image'], 'assets/components/'.$component['image']);
                            }
                        $document_info = get_document_info($component['id']);
                        $specification =  "";
                        $warranty =  "";
                        $maintenance =  "";
                        $installation =  "";
                        if(count($document_info)>0){
                                $specification =  $document_info['specification'];
                                $warranty =  $document_info['warranty'];
                                $maintenance =  $document_info['maintenance'];
                                $installation =  $document_info['installation'];
                                if($specification!=""){
                                    if(file_exists('./assets/component_documents/specification/'.$specification)){
                                        if($is_component_exist['specification']!=$specification){
                                          unlink('./assets/component_documents/specification/'.$specification);
                                          copy('assets/price_books/component_documents/specification/'.$specification, 'assets/component_documents/specification/'.$specification);
                                        }
                                    }
                                    else{
                                      copy('assets/price_books/component_documents/specification/'.$specification, 'assets/component_documents/specification/'.$specification);
                                    }
                                }
                                if($warranty!=""){
                                    
                                    if(file_exists('./assets/component_documents/warranty/'.$warranty)){
                                        if($is_component_exist['warranty']!=$warranty){
                                          unlink('./assets/component_documents/warranty/'.$warranty);
                                          copy('assets/price_books/component_documents/warranty/'.$warranty, 'assets/component_documents/warranty/'.$warranty);
                                        }
                                    }
                                    else{
                                      copy('assets/price_books/component_documents/warranty/'.$warranty, 'assets/component_documents/warranty/'.$warranty);
                                    }
                                }
                                if($maintenance!=""){
                                    
                                    if(file_exists('./assets/component_documents/maintenance/'.$maintenance)){
                                        if($is_component_exist['maintenance']!=$maintenance){
                                          unlink('./assets/component_documents/maintenance/'.$maintenance);
                                          copy('assets/price_books/component_documents/maintenance/'.$maintenance, 'assets/component_documents/maintenance/'.$maintenance);
                                        }
                                    }
                                    else{
                                      copy('assets/price_books/component_documents/maintenance/'.$maintenance, 'assets/component_documents/maintenance/'.$maintenance);
                                    }
                                }
                                if($installation!=""){
                                    
                                    if(file_exists('./assets/component_documents/installation/'.$installation)){
                                        if($is_component_exist['installation']!=$installation){
                                          unlink('./assets/component_documents/installation/'.$installation);
                                          copy('assets/price_books/component_documents/installation/'.$installation, 'assets/component_documents/installation/'.$installation);
                                        }
                                    }
                                    else{
                                      copy('assets/price_books/component_documents/installation/'.$installation, 'assets/component_documents/installation/'.$installation);
                                    }
                                }
                        }
                               
                                $component_array = array(
                                    'user_id' => $user_id,
                                    'company_id' => $company_id,
                                    'parent_component_id' => $component['id'],
                                    'component_name' => $component['component_name'],
                                    'component_des' => $component['component_des'],
                                    'component_uom' => $component['component_uom'],
                                    'component_uc' => $component['component_uc'],
                                    'supplier_id' => $supplier_id,
                                    'component_status' => $component['component_status'],
                                    'image' => $component['image'],
                                    'component_category' => $component['component_category'],
                                    'specification' => $specification,
                                    'warranty' => $warranty,
                                    'maintenance' => $maintenance,
                                    'installation' => $installation,
                                    'price_book_id' => $price_book_id
                                );
                                $component_inserted_id = $this->mod_common->insert_into_table('project_components', $component_array);
                                $checklist_items = $this->mod_common->get_all_records('project_price_book_component_checklists', "*", 0, 0,  array("component_id" => $component['id']));
                                if(count($checklist_items)>0){
                                                foreach($checklist_items as $ck){
                                                    $checklist_array = array(
                                                       "component_id" => $component_inserted_id,
                                                       "checklist" => $ck['checklist'],
                                                    );
                                                $this->mod_common->insert_into_table('project_component_checklists', $checklist_array);
                                                }
                                            }
                        }
                }
            }
        
        $this->session->set_flashdata("ok_message", "Price book request has been allocated");
        redirect(SURL."supplierz/allocate_price_book/".$request_id);
		}
    }
    
    /******************Price Book Section Ends Here*********************/
    
    /******************Confirm Estimate Requests Section Starts Here*********************/
    
    //Manage Confirm Estimate Requests
    function manage_confirm_estimate_requests(){
        $this->mod_common->is_company_page_accessible(122);
        $data['confirm_estimates'] = $this->mod_project->get_all_confirm_estimates(1);
        $this->stencil->title('Confirm Estimate Requests');
	    $this->stencil->paint('supplierz/confirm_estimates/manage_confirm_estimate_requests', $data);
    }
    
    //View Confirm Estimate Request Details
    function view_confirm_estimate($id) {
          $this->mod_common->is_company_page_accessible(122);
        $data['confirm_estimate_details'] = $this->mod_project->get_confirm_estimate_details($id, 2);
        $confirm_estimate_info = $this->mod_common->select_single_records('project_confirm_estimates', array("id"=>$id, "supplier_id" => $this->session->userdata('company_id')));
        if(count($confirm_estimate_info)==0 || $id=="" || $id<=0){
            $this->session->set_flashdata('err_message', 'No Record Found.');
            redirect(SURL."supplierz/manage_confirm_estimate_requests");
        }
        $data['plans_and_specifications'] = $this->mod_common->get_all_records('project_plans_and_specifications', "*", 0, 0, array("project_id"=>$confirm_estimate_info['project_id'], "privacy"=>1));
        $this->stencil->title('View Confirm Estimate Request');
	    $this->stencil->paint('supplierz/confirm_estimates/view_confirm_estimate_request', $data);
  }
    
    //Update Confirm Estimate Request
    public function update_confirm_estimate($id) {
            $this->mod_common->is_company_page_accessible(122);
            $data['confirm_estimate_details'] = $this->mod_project->get_confirm_estimate_details($id, 2);
            $confirm_estimate_info = $this->mod_common->select_single_records('project_confirm_estimates', array("id"=>$id, "supplier_id" => $this->session->userdata('company_id')));
            if(count($confirm_estimate_info)==0 || $id=="" || $id<=0){
                $this->session->set_flashdata('err_message', 'No Record Found.');
                redirect(SURL."supplierz/manage_confirm_estimate_requests");
            }
            $data['plans_and_specifications'] = $this->mod_common->get_all_records('project_plans_and_specifications', "*", 0, 0, array("project_id"=>$confirm_estimate_info['project_id'], "privacy"=>1));
            $this->stencil->title('Edit Confirm Estimate Request');
    	    $this->stencil->paint('supplierz/confirm_estimates/update_confirm_estimate_request', $data);
      }
  
    //Download File Attach with Confirm Estimate
    public function download($id){
            $this->mod_common->is_company_page_accessible(122);
            $where = "id =".$id." AND privacy = 1 AND project_id IN(SELECT project_id FROM project_confirm_estimates WHERE supplier_id =". $this->session->userdata('company_id').")";
            $plans_and_specifications = $this->mod_common->select_single_records('project_plans_and_specifications', $where);
            if(count($plans_and_specifications)==0 || $id=="" || $id<=0){
                $this->session->set_flashdata('err_message', 'No Record Found.');
                redirect(SURL."supplierz/manage_confirm_estimate_requests");
            }
            $this->load->helper('download');
            if(count($plans_and_specifications)>0){
            $path = 'assets/project_plans_and_specifications/'.$plans_and_specifications['document'];
            $data = file_get_contents($path);
            $name = $plans_and_specifications['document'];
            force_download($name, $data);
        }
        else{
            $this->session->set_userdata("err_message", "You don't have permission to download this document");
            redirect(SURL."supplierz/returned_confirm_estimate");
        }
    }

    //Return & Confirm Request
    public function return_and_confirm(){
          $this->mod_common->is_company_page_accessible(128);
          $confirm_estimate_id = $this->input->post("confirm_estimate_id");
          $company_name = $this->input->post("company_name");
          $confirm_estimate_data = array(
                "status" => 2
              );
          $this->mod_common->update_table("project_confirm_estimates", array("id" => $confirm_estimate_id), $confirm_estimate_data);
          $confirm_estimate_part_id = $this->input->post("confirm_estimate_part_id");
              for($i=0;$i<count($confirm_estimate_part_id);$i++){
                  $supplier_notes = $this->input->post("supplier_notes_".$confirm_estimate_part_id[$i]);
                  $parts_data = array(
                      "supplier_notes" => $supplier_notes,
                      );
              $this->mod_common->update_table("project_confirm_estimate_parts", array("id" => $confirm_estimate_part_id[$i]), $parts_data);
                  
              }
              $this->session->set_userdata("ok_message", "Confirm Estimate #".$confirm_estimate_id." has been confirmed and returned to ".$company_name);
              redirect(SURL."supplierz/returned_confirm_estimate");
      }
  
    //Get All Returned Confirm Estimate List
    public function returned_confirm_estimate() {
          $this->mod_common->is_company_page_accessible(128);
          $data['confirm_estimates'] = $this->mod_project->get_all_confirm_estimates(2);
       
          $this->stencil->title('Returned Confirm Estimate');
    	  $this->stencil->paint('supplierz/confirm_estimates/manage_returned_confirm_estimate', $data);
    }
    
    //Manage Component Orders
    public function manage_component_orders() {

      $this->mod_common->is_company_page_accessible(123);
      $data['orders'] = $this->mod_common->get_all_records('project_component_purchase_orders', "*", 0, 0, array("supplier_id" => $this->session->userdata("company_id")));

      $this->stencil->title('Component Orders');
	  $this->stencil->paint('supplierz/component_orders/manage_component_orders', $data);
 
    }
    
    //Manage Online Store Orders
    public function manage_online_store_orders() {

      $this->mod_common->is_company_page_accessible(151);
      
      $where = "order_no IN (SELECT order_no FROM project_online_store_order_items WHERE supplierz_id =".$this->session->userdata('company_id').")";
      $data['orders'] = $this->mod_common->get_all_records("project_online_store_orders", "*", 0, 0, $where);

      $this->stencil->title('Online Store Orders');
	  $this->stencil->paint('supplierz/online_store/manage_online_store_orders', $data);
 
    }
    
    //Order Details
    public function order_details($order_no="")
	{
            
        if($order_no==""){
              redirect(SURL."nopage");
        }
            
	    $this->stencil->title('Order Details');
        $data['items'] = $this->mod_common->get_customer_order_detail($order_no);
        if(count($data['items'])>0){
        $data['notifications'] = $this->mod_common->get_user_notifications($order_no);
        $table = "project_online_store_order_payments";
        $where = "`order_no` ='" . $order_no . "'";

        $data['payment'] = $this->mod_common->select_single_records($table, $where);
        $data['price'] = $this->mod_common->select_single_records('project_online_store_orders', $where);
       
	    $this->stencil->paint('supplierz/online_store/details', $data);
        }
        else{
            redirect(SURL."nopage");
        }
	    
	}
	
	public function fetchOrders(){
        $query = '';
        $field = '';
        $table = '';
        $output = '';
        if($this->input->post('query') != '')
          {
           $query = $this->input->post('query');
          
           $field = $this->input->post('field');
           
           $table = 'project_online_store_orders';
           
           $data['orders'] = $this->mod_common->fetch_data($table, $query, $field);
        
          }
         else{
             echo redirect(SURL.'supplierz/manage_online_store_orders');
         }          
    
         $this->load->view('supplierz/online_store/manage_online_store_orders_result', $data);          
                        
                     
         
    }
    
    //Update Status
    function update_status(){
        $id=$this->input->post('id');
        $status=$this->input->post('status');
       
        $where= array(
                'id' => $id
            );
            
       $deliver_date = date('Y-m-d H:i:s');
       
       $order_purchase = array(
                'status' => $status,
                'order_delivered_date' => $deliver_date
            );
        $this->mod_common->update_table('component_purchase_orders', $where, $order_purchase);
        $data['order_status'] = $status;
        $deliver_date_format = date("d/m/Y", strtotime($deliver_date));
        $data['order_id'] = $id;
        $html = $this->load->view('supplierz/component_orders/status_ajax.php', $data, true);
        echo $html."|". $deliver_date_format;
    }
    
    //View Component Order Details
    public function component_order_details($porder) {
        $this->mod_common->is_company_page_accessible(123);
        $data['order_detail'] = $this->mod_project->get_porder_detail_by_id_for_suppliers($porder);

        $data['order_items'] = $this->mod_project->get_order_items_by_porder_id($porder);

        if($data['order_detail']->order_status=='Pending'){
            redirect(SURL."purchaseorder/update_porder/".$data['order_detail']->id);
            foreach ($data['order_items'] as $keyo => $valo) {
                $si=$this->project->get_siuiq_by_pocpid($valo['purchase_order_id'],$valo['costing_part_id'] );
                if(isset($si[0]['uninvoicedquantity']) && $si[0]['uninvoicedquantity'] < $valo['order_quantity']){
                    $data['errorpur']='You should not approve this purchase order, Order quantity is greater than project part uninvoiced costing quantity for an item in purchase order ';
                }
            }
        }


        $cwhere = array('id' => $porder);
        $data['postatus'] = $this->mod_common->select_single_records('project_purchase_orders', $cwhere);

        $data['projectinfo'] = $this->mod_project->get_project_info($data['order_detail']->project_id);
        #------------------ email message----------------#
         $data['email_message'] = $this->mod_common->select_single_records('project_email_templates', $fields = false, array('company_id'=>$this->session->userdata('company_id')));
        #------------------- load view-------------------#
        $this->stencil->title('Component Order Details');
	    $this->stencil->paint('supplierz/component_orders/porder', $data);
    }
    
    /******************Confirm Estimate Requests Section Ends Here*********************/
    
    /******************Templates Section Starts Here****************************/
    
    //Manage Templates
    public function manage_templates()
	{
	    $this->mod_common->is_company_page_accessible(129);
        $data['templates'] = $this->mod_common->get_all_records("project_supplierz_templates","*",0,0,array("company_id" => $this->session->userdata("company_id")),"template_id");
        $this->stencil->title('Supplierz Templates');
	    $this->stencil->paint('supplierz/templates/manage_templates', $data);
	}
    
    //Add Template Screen
    public function add_template() {
        
        $this->mod_common->is_company_page_accessible(129);
        $this->stencil->title('Add Supplierz Template');
        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
        $data["components"] = $this->mod_common->get_all_records("components","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'component_status' => 1), "component_id");
        $data["suppliers"] = $this->mod_common->get_all_records("suppliers","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'supplier_status' => 1), "supplier_id");
        $data["exttemplates"] = $this->mod_common->get_all_records("project_supplierz_templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        $data["extprojects"] = $this->mod_project->get_existing_supplierz_project_costing();
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
        $this->stencil->paint('supplierz/templates/add_template', $data);
    }
    
    //Add New Item
    public function populate_new_template_row() {
    
		$data['next_row'] = isset($_POST['next_row']) ? $_POST['next_row'] : 0;
		
		$cwhere = array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1);
		$fields = '`takeof_id`, `user_id`, `takeof_name`';
		$data['takeoffdatas'] = $this->mod_common->get_all_records('takeoffdata', $fields, 0, 0, $cwhere, 'takeof_id');

		echo $this->load->view('supplierz/templates/add_part', $data, true);
		
	}
	
	//Add New Template
	public function add_new_template_process(){
	    
	    $this->mod_common->is_company_page_accessible(129);
	    $this->form_validation->set_rules('template_name', 'Template Name', 'required');
		$this->form_validation->set_rules('template_desc', 'Template Description', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $this->stencil->title('Add Template');
                 $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
                $this->stencil->paint('supplierz/templates/add_template', $data);
			}
		else{
		    $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
		    
    	    $ins_array = array(
    			'supplier_id'	=>	$this->session->userdata('company_id'),
    			'company_id' =>	$this->session->userdata('company_id'),
    			'template_name'	=>	$this->input->post('template_name'),
    			'template_desc'	=>	$this->input->post('template_desc'),
    			'template_status' =>	$this->input->post('template_status'),
    			'created_by' => $created_by,
    			'ip_address' => $ip_address
    		);
    		
    		$addtemplate = $this->mod_common->insert_into_table('project_supplierz_templates',$ins_array);
    		
    		            $part	= '';
    					$q =1;
    					$stagecount	    = $this->input->post('stagecount');
    					$part_name	    = array_values($this->input->post('part_name'));
    					$component_uom	= array_values($this->input->post('component_uom'));
    					$component_uc	= array_values($this->input->post('component_uc'));
    					$component_id	= array_values($this->input->post('component_id'));
    					$quantity		= array_values($this->input->post('manualqty'));
    					$formula		= array_values($this->input->post('formula'));
    					$quantity_type  = array_values($this->input->post('quantity_type'));
    					$formulaqty		= array_values($this->input->post('formulaqty'));
    					$formulatext	= array_values($this->input->post('formulatext'));
    					$is_rounded	    = array_values($this->input->post('is_rounded'));
    					$stage_id	    = count($this->input->post('stage_id'));
    					$gstage_id	    = array_values($this->input->post('stage_id'));
    					$component_type = array_values($this->input->post('component_type'));
    				
    					$supplier_info_query = $this->db->query("Select * FROM project_suppliers WHERE parent_supplier_id='".$this->session->userdata('company_id')."'");
			            $supplier_info_result = $supplier_info_query->row_array();
			    
    					for($i=0;$i<count($part_name);$i++){
    						$s = $i+1;
    						if(isset($part_name[$i])){
    						if(isset($quantity[$i]) && trim($quantity[$i])==''){
    							$quantity[$i]=0;	
    						}
    						
    						$part_stage_id = $gstage_id[$i];
    						$part_supplier_id = $supplier_info_result["supplier_id"];
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
                                    'supplier_name' => $supplier_info_result["supplier_name"],
                                    'supplier_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_supplier = $this->mod_common->select_single_records('project_suppliers', array('company_id' => $this->session->userdata('company_id'), 'supplier_name' => $supplier_info_result["supplier_name"]));
                                
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
                                    'include_in_price_book' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_component = $this->mod_common->select_single_records('project_components', array('company_id' => $this->session->userdata('company_id'), 'component_name' => $component_id[$i]));
                                
                                if (count($existing_component) == 0) {
                                     $part_component_id = $this->mod_common->insert_into_table('project_components', $component);
                                     $this->save_components_in_price_book($part_component_id);
                                }
                                else{
                                    $part_component_id = $existing_component["component_id"];
                                }
                            }
    
    						$part = array(
    							'temp_id'							=>	$addtemplate,
    							'stage_id'							=>	$part_stage_id,
    							'supplier_id'						=>	$this->session->userdata('company_id'),
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
    
    						$part = $this->mod_common->insert_into_table('project_supplierz_tpl_component_part',$part);	

    						}
    					}
    					
    			$this->session->set_flashdata('ok_message', 'New Template added successfully.');
    			redirect(SURL . 'supplierz/manage_templates');
		}
	}
	
	//Get Component Details
	function getComponentDetails() {
        
        $cwhere = array('component_id' => $this->input->post('value'));
        $data['components'] = $this->mod_common->select_single_records('price_book_components', $cwhere);
        
        echo json_encode($data['components']);
    }
    
    function getSupplierzComponentDetails() {
        
        $cwhere = array('component_id' => $this->input->post('value'));
        $data['components'] = $this->mod_common->select_single_records('project_components', $cwhere);
        
        $checklists = $this->mod_common->get_all_records('project_component_checklists', "*", 0, 0, $cwhere);
       
        $checklist_data = "";
        foreach($checklists as $checklist){
            $checklist_data .=$checklist["checklist"].", ";
        }
        
        $data['components']['checklists'] = rtrim($checklist_data, ", ");
        
        echo json_encode($data['components']);
    }
    
    //Verify Template
    public function verify_template() {

        $name = $this->input->post("name");
        
        $table = "project_supplierz_templates";

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
        
        $table = "project_supplierz_tpl_component_part";

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
		
	    $table = "project_supplierz_templates";
        $where = "`template_id` ='" . $id . "'";
		
        $delete_template = $this->mod_common->delete_record($table, $where);
        
        $table = "project_supplierz_tpl_component_part";
        $where = "`temp_id` ='" . $id . "'";
		
        $delete_template_parts = $this->mod_common->delete_record($table, $where);

    }
    
    //Import Template Data By Existing Template
    public function get_templating_by_template($id) {
        
		$data['next_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
		$todid = isset($_POST['todid']) ? $_POST['todid'] : "";

		if ($id > 0) {
		    
			$data['templates'] = $this->mod_template->get_supplierz_template($id);			
			$data['template_id'] =$id;
			$data['tparts'] = $this->mod_project->get_supplierz_costing_parts_by_template_id($id);
            $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
                
			$html = $this->load->view('supplierz/templates/populate_templating_by_template', $data, true);

			$rArray = array("rData" => $html);
			header('Content-Type: application/json');
			echo json_encode($rArray);
		} else {

		}
	}
	
	//Importt Template Data By Existing Project Costing
    public function get_templating_by_project_costing($id = 0) {
 
      $data['next_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
      $id = $this->input->post("id");
      if ($id > 0) {
        $data['prjprts'] = $this->mod_project->get_supplierz_costing_parts_by_id($id);
        
       if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'takeof_status' => 1);
        }
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, $cwhere, "takeof_id");
    
        $html = $this->load->view('supplierz/templates/populate_stages_for_template', $data, true);
        
        $rArray = array(
          "rData" => $html
        );
        
        header('Content-Type: application/json');
        echo json_encode($rArray);
            
        } else {
        
        }
    }
	
	//Import components by CSV

	public function import_template_by_csv(){
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
	    
	    $this->mod_common->is_company_page_accessible(129);
		if ($id > 0) {
		    
			$data['template_edit'] = $this->mod_template->get_supplierz_template($id);
			if($data['template_edit']){
    			$data['template_id'] =$id;
    			$data['tparts'] = $this->mod_project->get_supplierz_costing_parts_by_template_id($id);
    		
    			$this->stencil->title('Edit Supplierz Template');
                 $data["exttemplates"] = $this->mod_common->get_all_records("project_supplierz_templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
                 $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
                $data["extprojects"] = $this->mod_project->get_existing_supplierz_project_costing();
                $this->stencil->paint('supplierz/templates/edit_template', $data);  
			}
			else{
			    $this->session->set_flashdata('err_message', 'Template does not exist.');
                redirect(SURL . 'supplierz/manage_templates');
			}
		} else {
          redirect(SURL."nopage");
		}
	}
	
	//Update Template 
	public function update_template_process(){
	    
	    $this->mod_common->is_company_page_accessible(86);
	    
	    $id = $this->input->post("template_id");
	    
	    $data['template_edit'] = $this->mod_template->get_supplierz_template($id);
	    
	    if($data['template_edit'][0]->template_name!=$this->input->post('template_name')){
	    $this->form_validation->set_rules('template_name', 'Template Name', 'required|is_unique[project_supplierz_templates.template_name]');
	    }
	    else{
	       $this->form_validation->set_rules('template_name', 'Template Name', 'required'); 
	    }
		$this->form_validation->set_rules('template_desc', 'Template Description', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			$data['template_id'] =$id;
			$data['tparts'] = $this->mod_project->get_supplierz_costing_parts_by_template_id($id);

			$this->stencil->title('Edit Supplierz Template');
			$data["extprojects"] = $this->mod_project->get_existing_supplierz_project_costing();
            $data["exttemplates"] = $this->mod_common->get_all_records("project_supplierz_templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
            $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
            $this->stencil->paint('supplierz/templates/edit_template', $data);
			}
		else{
		    $created_by = $this->session->userdata("user_id");
            $ip_address = $_SERVER['REMOTE_ADDR'];
    	    $upd_array = array(
    			'template_name'	=>	$this->input->post('template_name'),
    			'template_desc'	=>	$this->input->post('template_desc'),
    			'template_status' =>	$this->input->post('template_status'),
    			'created_by' => $created_by,
    			'ip_address' => $ip_address
    			
    		);
    		
    		$where = array("template_id" => $id);
    		
    		$updatetemplate = $this->mod_common->update_table('project_supplierz_templates',$where, $upd_array);
    		
    		if($updatetemplate){
    		    
    		      $table = "project_supplierz_tpl_component_part";
                  $where = "`temp_id` ='" . $id . "'";
		
                 $delete_template_parts = $this->mod_common->delete_record($table, $where);
    		
    		            $part	= '';
    					$count	= 0;
    					$q =1;
    					$part_name	    = array_values($this->input->post('part_name'));
    					$component_uom	= array_values($this->input->post('component_uom'));
    					$component_uc	= array_values($this->input->post('component_uc'));
    					$component_id	= array_values($this->input->post('component_id'));
    					$quantity		= array_values($this->input->post('manualqty'));
    					$formula		= array_values($this->input->post('formula'));
    					$quantity_type  = array_values($this->input->post('quantity_type'));
    					$formulaqty		= array_values($this->input->post('formulaqty'));
    					$formulatext	= array_values($this->input->post('formulatext'));
    					$is_rounded	    = array_values($this->input->post('is_rounded'));
    					$stage_id	    = count($this->input->post('stage_id'));
    					$gstage_id	    = array_values($this->input->post('stage_id'));
    					$component_type = array_values($this->input->post('component_type'));
    				
    					$supplier_info_query = $this->db->query("Select * FROM project_suppliers WHERE parent_supplier_id='".$this->session->userdata('company_id')."'");
			            $supplier_info_result = $supplier_info_query->row_array();
    				
    					for($i=0;$i<count($part_name);$i++){
    						$s = $i+1;
    						if(isset($part_name[$i])){
        						if(trim($quantity[$i])==''){
        						$quantity[$i]=0;	
        						}
        						
        					$part_stage_id = $gstage_id[$i];
    						$part_supplier_id = $supplier_info_result["supplier_id"];
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
                                    'supplier_name' => $supplier_info_result["supplier_name"],
                                    'supplier_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_supplier = $this->mod_common->select_single_records('project_suppliers', array('company_id' => $this->session->userdata('company_id'), 'supplier_name' => $supplier_info_result["supplier_name"]));
                                
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
                                    'include_in_price_book' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_component = $this->mod_common->select_single_records('project_components', array('company_id' => $this->session->userdata('company_id'), 'component_name' => $component_id[$i]));
                                
                                if (count($existing_component) == 0) {
                                     $part_component_id = $this->mod_common->insert_into_table('project_components', $component);
                                     $this->save_components_in_price_book($part_component_id);
                                }
                                else{
                                    $part_component_id = $existing_component["component_id"];
                                }
                            }
                                
        						$part = array(
        							'temp_id'							=>	$id,
        							'stage_id'							=>	$part_stage_id,
        							'supplier_id'						=>	$this->session->userdata('company_id'),
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
        
        						$part = $this->mod_common->insert_into_table('project_supplierz_tpl_component_part',$part);	
        						
    						}
    					}
    		    }
    					
    			$this->session->set_flashdata('ok_message', 'Template updated successfully.');
    			redirect(SURL."supplierz/edit_template/".$id);
		}
	}
	
	//Edit Formula
	public function edit_formula(){
       $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
		if($this->input->post("part_id")!=""){
           $formula_info = get_supplierz_part_formula($this->input->post("part_id"));
		}
		else{
			$formula_info["tpl_quantity_formula"] = "";
			$formula_info["quantity_formula_text"] = "";
			$formula_info["is_rounded"] = "";
		}
		$formula_qty = $this->input->post("formula_qty");
		$formula_text = $this->input->post("formula_text");
		$is_rounded = $this->input->post("is_rounded");
		if($formula_qty!="0"){
			$data['formula'] =  $formula_qty;
            $data['formula_text'] =  $formula_text;
			$data['is_rounded'] =  $is_rounded;
		}
		else{
			
            $data['formula'] =  $formula_info["tpl_quantity_formula"];
            $data['formula_text'] =  $formula_info["quantity_formula_text"];
			$data['is_rounded'] =  $formula_info["is_rounded"];
		}
        $this->load->view("supplierz/templates/edit_formula_ajax", $data);
	}
	
	//Manage Template Requests
    public function manage_template_requests()
	{
	    $this->mod_common->is_company_page_accessible(130);
        $data['template_requests'] = $this->mod_common->get_all_records("project_template_requests","*",0,0,array("to_user_id" => $this->session->userdata("company_id")));
        $this->stencil->title('Template Requests');
	    $this->stencil->paint('supplierz/templates/manage_template_requests', $data);
	}
	
	//Accept Template Request
	public function accept_template_request(){
        $request_id = $this->input->post("id");
        if($request_id>0){
            $this->mod_common->update_table('project_template_requests', array("id"=>$request_id), array("status" => 1));
            $data['template_requests'] = $this->mod_common->get_all_records("project_template_requests","*",0,0,array("to_user_id" => $this->session->userdata("company_id")));
            $this->load->view("supplierz/templates/manage_template_requests_ajax", $data);
        }
        else{
            redirect(SURL."nopage");
        }
    }
    
    //Decline Template Request
    public function decline_template_request(){
        $request_id = $this->input->post("id");
        if($request_id>0){
            $this->mod_common->update_table('project_template_requests', array("id"=>$request_id), array("status" => -1));
            $data['template_requests'] = $this->mod_common->get_all_records("project_template_requests","*",0,0,array("to_user_id" => $this->session->userdata("company_id")));
            $this->load->view("supplierz/templates/manage_template_requests_ajax", $data);
        }
        else{
            redirect(SURL."nopage");
        }
    }
    
    /***************Designz Section Starts Here*********************/
    
    //Get All Designz
    public function manage_designz() {
       
       $this->mod_common->is_company_page_accessible(161);
       $data['designz'] = $this->mod_common->get_all_records("project_supplierz_designz","*",0,0,array("company_id" => $this->session->userdata("company_id")),"designz_id");
       $this->stencil->title('Designz');
	   $this->stencil->paint('supplierz/designz/manage_designz', $data);
    
    }
    
    //Add Designz Screen
    public function add_designz() {
        
        $this->mod_common->is_company_page_accessible(161);
        $this->stencil->title('Add Designz');
        $this->stencil->paint('supplierz/designz/add_new_designz');
    }
    
    //Add New Designz
    public function add_new_designz_process() {
		 
        $this->mod_common->is_company_page_accessible(161);
		$this->form_validation->set_rules('project_name', 'Designz Name', 'required');
		$this->form_validation->set_rules('floor_area', 'Floor Area', 'required');
		$this->form_validation->set_rules('living_areas', 'Living Areas', 'required');
		$this->form_validation->set_rules('bathrooms', 'Bathrooms', 'required');
		$this->form_validation->set_rules('bedrooms', 'Bedrooms', 'required');
		$this->form_validation->set_rules('garage', 'Garage', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
                $this->stencil->title('Add Designz');
                $this->stencil->paint('supplierz/designz/add_new_designz');
			}
		else{
		    
			$table = "project_supplierz_designz";
					
			$project_name = $this->input->post('project_name');
			$floor_area = $this->input->post('floor_area');
			$living_areas = $this->input->post('living_areas');
			$bedrooms = $this->input->post('bedrooms');
			$bathrooms = $this->input->post('bathrooms');
			$garage = $this->input->post('garage');
			$movies = $this->input->post('movies');
			$ThreeD = $this->input->post('3D');
			$uploadedFiles = $this->input->post('uploadedFiles');
			$thumbnail = $this->input->post("set_as_thumbnail");
			$plan_thumbnail = $this->input->post("set_plan_as_thumbnail");
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
    			        $this->mod_common->insert_into_table("project_supplierz_designz_uploads", $ins_array);
    			    }
			    }
			   
				$this->session->set_flashdata('ok_message', 'New Designz added successfully.');
				redirect(SURL . 'supplierz/manage_designz');
			} else {
				$this->session->set_flashdata('err_message', 'New Designz is not added. Something went wrong, please try again.');
				redirect(SURL . 'supplierz/manage_designz');
			}
		}
    }
    
    //Edit Designz Screen
    public function edit_designz($designz_id) {

        $this->mod_common->is_company_page_accessible(161);
		
	    if($designz_id=="" || !(is_numeric($designz_id))){
            redirect("nopage");
        }
        $table = "project_supplierz_designz";
        
        $where = array("designz_id" => $designz_id,
	              "company_id" => $this->session->userdata("company_id"));

        $data['designz_edit'] = $this->mod_common->select_single_records($table, $where);
        
        $data['uploadedImages'] = $this->mod_common->get_all_records("project_supplierz_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "image"));
        
        $data['thumbnail'] = $this->mod_common->select_single_records("project_supplierz_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "image", "set_as_thumbnail" => 1));
        
        $data['uploadedPlans'] = $this->mod_common->get_all_records("project_supplierz_designz_uploads", "*", 0, 0, array("designz_id" => $designz_id, "designz_upload_type" => "plan"));
        
        $data['plan_thumbnail'] = $this->mod_common->select_single_records("project_supplierz_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "plan", "set_as_thumbnail" => 1));
        
        if (count($data['designz_edit']) == 0) {
           $this->session->set_flashdata('err_message', 'Designz does not exist.');
            redirect("supplierz/manage_designz");
        } else {
            $this->stencil->title("Edit Designz");

            $this->stencil->paint('supplierz/designz/edit_designz', $data);
        }
    }
    
    //Edit Component
    public function edit_designz_process() {
		 
        $this->mod_common->is_company_page_accessible(161);
        
        if (!$this->input->post() && !$this->input->post('update_designz'))
        
        redirect(SURL."supplierz/manage_designz");
        
		$this->form_validation->set_rules('floor_area', 'Floor Area', 'required');
		$this->form_validation->set_rules('living_areas', 'Living Areas', 'required');
		$this->form_validation->set_rules('bathrooms', 'Bathrooms', 'required');
		$this->form_validation->set_rules('bedrooms', 'Bedrooms', 'required');
		$this->form_validation->set_rules('garage', 'Garage', 'required');
		
		$designz_id = $this->input->post('designz_id');
		
        $table = "project_supplierz_designz";
	    $where = array("designz_id" => $designz_id,
	              "company_id" => $this->session->userdata("company_id"));

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
                $this->stencil->paint('supplierz/designz/edit_designz', $data);
			}
		else{
		    
		    $table = "project_supplierz_designz";
					
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
    			        $is_exist = $this->mod_common->select_single_records("project_supplierz_designz_uploads", array("file_name" => $file["name"]));
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
        			        $this->mod_common->insert_into_table("project_supplierz_designz_uploads", $ins_array);
    			        }
    			        else{
    			            $upd_array = array(
        			           "set_as_thumbnail" => $set_as_thumbnail
        			        );
    			            
    			            $this->mod_common->update_table("project_supplierz_designz_uploads", array("designz_id" => $designz_id, "file_name" => $file["name"]), $upd_array);
    			     
    			        }
    			    }
			    }
			    
				$this->session->set_flashdata('ok_message', 'Designz updated successfully.');
				redirect(SURL . 'supplierz/manage_designz');
			} else {
				$this->session->set_flashdata('err_message', 'Designz is not updated. Something went wrong, please try again.');
				redirect(SURL . 'supplierz/manage_designz');
			}
		}
    }
    
    //Include/Exclude Designz for Builderz Users
    public function available_for_builderz(){
        $id = $this->input->post("id");
        $available_for_builderz = $this->input->post("available_for_builderz");
        $this->mod_common->update_table("project_supplierz_designz", array("designz_id" => $id), array("available_for_builderz" => $available_for_builderz));
    }
    
    //Verify Designz Project
    public function verify_project() {

        $name = $this->input->post("name");
        
        $table = "project_supplierz_designz";

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
    
    //Delete Designz
    public function delete_designz() {
  
        $this->mod_common->is_company_page_accessible(161);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "project_supplierz_designz";
        $where = "`designz_id` ='" . $id . "'";
        
        $this->mod_common->delete_record($table, $where);
        
        //Delete Designz Upload data
        $files = $this->mod_common->get_all_records("project_supplierz_designz_uploads", "*", 0, 0, $where);
        if(count($files)>0){
            foreach($files as $file){
                if(file_exists("./assets/designz_uploads/".$file["file_name"])){
        	        unlink("./assets/designz_uploads/".$file["file_name"]);
        	        if(file_exists("./assets/designz_uploads/thumbnail/".$file["file_name"])){
        	          unlink("./assets/designz_uploads/thumbnail/".$file["file_name"]);
        	        }
        	    }
    	        $this->mod_common->delete_record("project_supplierz_designz_uploads", array("id" => $file["id"]));
            }
        }
    }
    
    //Upload Designz File
	public function upload_designz_files($file_type){
	                $projects_folder_path = './assets/designz_uploads/';
					$projects_folder_path_main = './assets/designz_uploads/';
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
	        $designz_uploads_info = $this->mod_common->select_single_records("project_supplierz_designz_uploads", array("id" => $id));
	        $this->mod_common->delete_record("project_supplierz_designz_uploads", array("id" => $id));
	    }
	    
	    if(file_exists("./assets/designz_uploads/".$file_name)){
	        unlink("./assets/designz_uploads/".$file_name);
	        if(file_exists("./assets/designz_uploads/thumbnail/".$file_name)){
	          unlink("./assets/designz_uploads/thumbnail/".$file_name);
	        }
	    }
	    $response = array("status" => "deleted", "file_name" => $file_name, "set_as_thumbnail" => $designz_uploads_info["set_as_thumbnail"], "designz_id" => $designz_uploads_info["designz_id"]);
	    echo json_encode($response);
	}
	
	public function refresh_designz_thumbnails($designz_id){
	    
	    $data['thumbnail'] = $this->mod_common->select_single_records("project_supplierz_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "image", "set_as_thumbnail" => 1));
        
        $data['plan_thumbnail'] = $this->mod_common->select_single_records("project_supplierz_designz_uploads", array("designz_id" => $designz_id, "designz_upload_type" => "plan", "set_as_thumbnail" => 1));
        
        $this->load->view("supplierz/designz/refresh_designz_thumbnails", $data);
	
	    
	}
    
    
    
    /***************Designz Section Ends Here*********************/
    
    
    /***************Components Section Starts Here*********************/
    
    //Get All Components
    public function components() {
       
       $this->mod_common->is_company_page_accessible(149);
       $data['components'] = $this->mod_common->get_all_records("project_components","*",0,0,array("company_id" => $this->session->userdata("company_id")),"component_id");
       $this->stencil->title('Components');
	   $this->stencil->paint('supplierz/components/manage_components', $data);
    
    }
    
    //Add Component Screen
    public function add_component() {
        
        $this->mod_common->is_company_page_accessible(149);
        $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
        $data['categories'] = $this->mod_common->get_all_records("categories","*",0,0,array("status" => 1),"name");
        $this->stencil->title('Add Component');
        $this->stencil->paint('supplierz/components/add_new_component', $data);
    }
    
    //Add New Component
    public function add_new_component_process() {
		 
        $this->mod_common->is_company_page_accessible(149);
		$this->form_validation->set_rules('component_name', 'Component Name', 'required');
		$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
		$this->form_validation->set_rules('component_uc', 'Unit Cost', 'required');
		$this->form_validation->set_rules('component_uom', 'Unit of Mesure', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
                $this->stencil->title('Add Component');
                $this->stencil->paint('supplierz/components/add_new_component', $data);
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
			$table = "project_components";
					
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
            $include_in_price_book = $this->input->post('include_in_price_book')!=""?$this->input->post('include_in_price_book'):0;
			$company_id = $this->session->userdata("company_id");
            $created_by = $this->session->userdata("user_id");
            $list_this_component_in_online_store = $this->input->post('list_this_component_in_online_store');
            
            if(isset($list_this_component_in_online_store) && $list_this_component_in_online_store == 1){
                $sale_price = $this->input->post('sale_price');
            }
            else{
                $sale_price = 0;
                $list_this_component_in_online_store = 0;
            }
            
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
                				"include_in_price_book" => $include_in_price_book,
                				"image" => $filename,
                				"sale_price" => $sale_price,
                				"list_this_component_in_online_store" => $list_this_component_in_online_store,
                				"component_status" => $component_status,
                				"user_id" => $created_by,
                				"company_id" => $company_id,
                				"created_by" => $created_by,
                                "ip_address" => $ip_address
		                	);
					
		    $add_new_component = $this->mod_common->insert_into_table($table, $ins_array);

			if ($add_new_component) {
			    // Include in Price Book
			    if($include_in_price_book == 1){
                    $this->save_components_in_price_book($add_new_component);
                }
                
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
			     
			    if(isset($list_this_component_in_online_store) && $list_this_component_in_online_store == 1){
			        $index = $this->input->post('index');
			        $option_name = $this->input->post('option_name');
			        for($i=0;$i<count($option_name);$i++){
			            $option_values = implode(",", $this->input->post('option_values'.$index[$i]));
			            $ins_array = array(
			                "option_name" => $option_name[$i],
			                "option_values" => $option_values,
			                "component_id" => $add_new_component
			                );
			            $this->mod_common->insert_into_table("project_component_options", $ins_array);
			        }
			    }
				$this->session->set_flashdata('ok_message', 'New Component added successfully.');
				redirect(SURL . 'supplierz/components');
			} else {
				$this->session->set_flashdata('err_message', 'New Component is not added. Something went wrong, please try again.');
				redirect(SURL . 'supplierz/components');
			}
		}
    }
    
    //Edit Component Screen
    public function edit_component($component_id) {
        $this->mod_common->is_company_page_accessible(149);
		
	    if($component_id=="" || !(is_numeric($component_id))){
            redirect("nopage");
        }
		
        $table = "project_components";
        $where = "`component_id` ='" . $component_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['component_edit'] = $this->mod_common->select_single_records($table, $where);
        //$data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1, "parent_supplier_id" => 0),"supplier_id");
        $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
        $data['categories'] = $this->mod_common->get_all_records("categories","*",0,0,array("status" => 1),"name");
        $data['component_options'] = $this->mod_common->get_all_records("project_component_options", "*", 0, 0, array("component_id" => $component_id), "id");

        if (count($data['component_edit']) == 0) {
           $this->session->set_flashdata('err_message', 'Component does not exist.');
            redirect("supplierz/components");
        } else {
            $this->stencil->title("Edit Component");

            $this->stencil->paint('supplierz/components/edit_component', $data);
        }
    }
    
    //Edit Component
    public function edit_component_process() {
		 
        $this->mod_common->is_company_page_accessible(149);
        
        if (!$this->input->post() && !$this->input->post('update_component'))
        
        redirect(SURL."supplierz/components");
        
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
      
        $this->form_validation->set_rules('component_name', 'Component Name', 'required'.$is_unique);
		
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array('company_id' => $this->session->userdata('company_id'), "supplier_status" => 1),"supplier_id");
                $this->stencil->title('Edit Component');
                $this->stencil->paint('supplierz/components/edit_component', $data);
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
			$table = "project_components";
					
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
            //$include_in_price_book = $this->input->post('include_in_price_book')!=""?$this->input->post('include_in_price_book'):0;
			$component_status = $this->input->post('component_status');
            $ip_address = $_SERVER['REMOTE_ADDR'];
            
            $list_this_component_in_online_store = $this->input->post('list_this_component_in_online_store');
           
            if(isset($list_this_component_in_online_store) && $list_this_component_in_online_store == 1){
                $sale_price = $this->input->post('sale_price');
            }
            else{
                $sale_price = 0;
                $list_this_component_in_online_store = 0;
            }
            
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
                				/*"include_in_price_book" => $include_in_price_book,*/
                				"image" => $filename,
                				"sale_price" => $sale_price,
                                "list_this_component_in_online_store" => $list_this_component_in_online_store,
                				"component_status" => $component_status,
                                "ip_address" => $ip_address
		                	);
					
		    $update_component = $this->mod_common->update_table($table, $where, $upd_array);

			if ($update_component) {
			    
			    $this->save_components_in_price_book($component_id);
			    
			     //$component_info = $this->mod_common->select_single_records("project_price_book_components", array("component_id" => $component_id));
			     
			    /*if($include_in_price_book == 1 && count($component_info) == 0){
                    $this->save_components_in_price_book($component_id);
                }
                else if($include_in_price_book == 0){
                    $this->mod_common->update_table("project_supplierz_tpl_component_part", array("component_id" => $component_info["id"]), array("tpl_part_component_uom" => "", "tpl_part_component_uc" => ""));
                    $this->mod_common->delete_record('project_price_book_components', array("component_id" => $component_id));
                }*/
                
			    if($checklist!=""){
			        $this->mod_common->delete_record('project_component_checklists', array("component_id" => $component_id));
			        $checklist_items = explode(",", rtrim($checklist, ","));
			    
                        for($j=0;$j<count($checklist_items);$j++){
                            $checklist_array = array(
                               "component_id" => $component_id,
                               "checklist" => $checklist_items[$j],
                            );
                            
                            $this->mod_common->insert_into_table('project_component_checklists', $checklist_array);
                        }
			    }
			    if(isset($list_this_component_in_online_store) && $list_this_component_in_online_store == 1){
                       $this->mod_common->delete_record('project_component_options', array("component_id" => $component_id));
                       $index = $this->input->post('index');
                       $option_name = $this->input->post('option_name');
                       for($i=0;$i<count($option_name);$i++){
                           $option_values = implode(",", $this->input->post('option_values'.$index[$i]));
                           $ins_array = array(
                               "option_name" => $option_name[$i],
                               "option_values" => $option_values,
                               "component_id" => $component_id
                               );
                           $this->mod_common->insert_into_table("project_component_options", $ins_array);
                       }
                }
                else{
                     $this->mod_common->delete_record('project_component_options', array("component_id" => $component_id));
                }
				$this->session->set_flashdata('ok_message', 'Component updated successfully.');
				redirect(SURL . 'supplierz/components');
			} else {
				$this->session->set_flashdata('err_message', 'Component is not updated. Something went wrong, please try again.');
				redirect(SURL . 'supplierz/components');
			}
		}
    }
    
    public function save_components_in_price_book($component_id){
            $component_info = $this->mod_common->select_single_records('project_components', array("component_id" => $component_id));
        
            if(count($component_info)>0){
               $component_id =  $component_info['component_id'];
               $component_category =  $component_info['component_category'];
               $component_des =  $component_info['component_des'];
               $component_uom =  $component_info['component_uom'];
               $component_uc =  $component_info['component_uc'];
               $component_status =  $component_info['component_status'];
               $specification =  $component_info['specification'];
               $warranty =  $component_info['warranty'];
               $installation =  $component_info['installation'];
               $maintenance =  $component_info['maintenance'];
               $component_img = $component_info['image'];
               $component_name =  $component_info['component_name'];
               $supplier_id = $component_info['supplier_id'];
               $specification_document = $specification;
               $warranty_document = $warranty;
               $maintenance_document = $maintenance;
               $installation_document = $installation;
               $component_supplier_id = $supplier_id;
           
               $filename2 = $component_img;
               
                if(file_exists('./assets/components/'.$component_img) && $component_img!="" && !(file_exists('./assets/price_books/'.$component_img))){
                   //$filename2 = time().$component_img;
                   copy('assets/components/'.$component_img, 'assets/price_books/'.$filename2);
                   copy('assets/components/'.$component_img, 'assets/price_books/thumbnail/'.$filename2);
                }
                if(file_exists('./assets/component_documents/specification/'.$specification) && $specification!="" && !(file_exists('./assets/price_books/component_documents/specification/'.$specification))){
                  //$specification_document = time().$specification;
                  copy('assets/component_documents/specification/'.$specification, 'assets/price_books/component_documents/specification/'.$specification);
                }
                if(file_exists('./assets/component_documents/warranty/'.$warranty) && $warranty!="" && !(file_exists('./assets/price_books/component_documents/warranty/'.$warranty))){
                   //$warranty_document = time().$warranty;
                  copy('assets/component_documents/warranty/'.$warranty, 'assets/price_books/component_documents/warranty/'.$warranty);
                }
                if(file_exists('./assets/component_documents/maintenance/'.$maintenance) && $maintenance!="" && !(file_exists('./assets/price_books/component_documents/maintenance/'.$maintenance))){
                  //$maintenance_document = time().$maintenance;
                  copy('assets/component_documents/maintenance/'.$maintenance, 'assets/price_books/component_documents/maintenance/'.$maintenance);
                }
                if(file_exists('./assets/component_documents/installation/'.$installation) && $installation!="" && !(file_exists('./assets/price_books/component_documents/installation/'.$installation))){
                  //$installation_document = time().$installation;
                  copy('assets/component_documents/installation/'.$installation, 'assets/price_books/component_documents/installation/'.$installation);
                }
           
            $component = array(
                'company_id' => $this->session->userdata('company_id'),
                'component_category' => $component_category,
                'component_id' => $component_id,
                'component_name' => $component_name,
                'component_des' => $component_des,
                'component_uom' => $component_uom,
                'component_uc' => $component_uc,
                'component_sale_price' => $component_uc,
                'component_status' => 1,
                'supplier_id' => $component_supplier_id,
                'image' =>  $filename2,
            );
            
            $pb_component_info = $this->mod_common->select_single_records('project_price_book_components', array("component_id" => $component_id));
        
            if(count($pb_component_info)==0){
                $this->mod_common->insert_into_table('project_price_book_components', $component);
                $price_book_component_inserted_id = $this->db->insert_id();
                
                $document_array = array(
                       "component_id" => $price_book_component_inserted_id,
                       "specification" => $specification_document,
                       "warranty" => $warranty_document,
                       "maintenance" => $maintenance_document,
                       "installation" => $installation_document
                );
                
                $this->mod_common->insert_into_table('project_price_book_component_documents', $document_array);
            }
            else{
                $this->mod_common->update_table('project_price_book_components', array("component_id" => $component_id), $component);
                
                $document_array = array(
                       "specification" => $specification_document,
                       "warranty" => $warranty_document,
                       "maintenance" => $maintenance_document,
                       "installation" => $installation_document
                );
                
                $this->mod_common->update_table('project_price_book_component_documents', array("component_id" => $pb_component_info['id']), $document_array);
            }
            
                /*if($checklist){
                    $checklist_items = explode(",", rtrim($checklist, ","));
                    for($j=0;$j<count($checklist_items);$j++){
                        $checklist_array = array(
                           "component_id" => $price_book_component_inserted_id,
                           "checklist" => $checklist_items[$j],
                        );
                        
                        $this->mod_common->insert_into_table('project_price_book_component_checklists', $checklist_array);
                    }
                }*/
            }
    }
    
    /*public function update_components_in_price_book(){
            $components = $this->mod_common->get_all_records('project_components', "*", 0, 0, array("company_id" => 1), "component_id");
        
            foreach($components as $component){
           
               $component_img = $filename2 = $component["image"];
               
                if(file_exists('./assets/components/'.$component_img) && $component_img!=""){
                   $filename2 = time().$component_img;
                   copy('assets/components/'.$component_img, 'assets/price_books/'.$filename2);
                   copy('assets/components/'.$component_img, 'assets/price_books/thumbnail/'.$filename2);
                }
                
           
            $component_array = array(
                'image' =>  $filename2,
            );
            
            $this->mod_common->update_table('project_price_book_components', array("component_id" => $component["component_id"], "company_id" => 1), $component_array);
            
            }
    }*/
    
    //Price Book Shared OR Allocate Price Book to Builderz
    public function allocate_price_book_to_builderz(){
        $user_id = $this->input->post("user_id");
        $price_book_shared = $this->input->post("price_book_shared");
        if($price_book_shared == 1){
            $builderz = array(
                'user_id' => $user_id,
            );
            
            $this->mod_common->insert_into_table('project_allocate_price_books', $builderz);
            
            $supplierz_components = $this->mod_common->get_all_records("project_price_book_components", "*", 0, 0);
            
                foreach($supplierz_components as $val){
                        
                        $component_info = $this->mod_common->select_single_records('project_price_book_components', array("id" => $val['id']));
                        
                        $is_component_exists = $this->mod_common->select_single_records("project_components", array("parent_component_id" => $val['component_id'], "company_id" => $user_id));
                        
                        if(count($is_component_exists) == 0){
                            $supplier_user_id = $component_info["supplier_id"];
               
                            $where = "parent_supplier_id = '".$supplier_user_id."' AND company_id = ".$user_id;
               
                            $data['supplier_info'] = $this->mod_common->select_single_records('project_suppliers', $where);
                                   
                            if(count($data['supplier_info'])==0){
                            
                                        $where = "user_id = '".$supplier_user_id."'";
                                   
                                        $supplier_user_info = $this->mod_common->select_single_records('project_users', $where);
                               
                                        $supplier_detail = array(
                                                'user_id' => $user_id,
                                                'company_id' => $user_id,
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
                            $component_ins = array(
                				'parent_component_id' => $component_info["component_id"],
                                'component_name' => $component_info["component_name"],
                                'component_des' => $component_info["component_des"],
                                'component_uom' => $component_info["component_uom"],
                                'component_uc' => $component_info["component_sale_price"],
                                'supplier_id' => $part_supplier_id,
                                'component_status' => 1,
                                'image' => $component_info["image"],
                				"user_id"	  =>	$user_id,
            					"company_id"  =>	$user_id
                				                    
                			);
                				                
                			$this->mod_common->insert_into_table('project_components',$component_ins);
                				            
                			if($component_info["image"]!=""){
                                copy('assets/price_books/'.$component_info["image"], 'assets/components/'.$component_info["image"]);
                                copy('assets/price_books/'.$component_info["image"], 'assets/components/thumbnail/'.$component_info["image"]);
                			}
                        }
                        else{
                            $this->mod_common->update_table("project_components", array("parent_component_id" => $val['component_id'], "company_id" => $user_id), array("component_uc" =>  $component_info["component_sale_price"]));
                        }
                }
        }
        else{
            $this->mod_common->delete_record('project_allocate_price_books', array("user_id" => $user_id));
        }
    }
    
    //Include/Exclude Component in Price Book
    public function include_component_in_price_book(){
        $id = $this->input->post("id");
        $component_info = $this->mod_common->select_single_records("project_price_book_components", array("component_id" => $id));
        $include_in_price_book = $this->input->post("include_in_price_book");
        if($include_in_price_book == 1){
            $this->save_components_in_price_book($id);
        }
        else{
            $this->mod_common->update_table("project_supplierz_tpl_component_part", array("component_id" => $id), array("tpl_part_component_uom" => "", "tpl_part_component_uc" => ""));
            $this->mod_common->delete_record('project_price_book_components', array("component_id" => $id));
        }
        $this->mod_common->update_table("project_components", array("component_id" => $id), array("include_in_price_book" => $include_in_price_book));
    }
    
    //Delete Component
    public function delete_component() {
  
        $this->mod_common->is_company_page_accessible(149);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
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
         
        $this->mod_common->update_table("project_supplierz_tpl_component_part", array("component_id" => $id), array("tpl_part_component_uom" => "", "tpl_part_component_uc" => ""));
        $this->mod_common->delete_record('project_price_book_components', array("component_id" => $id));
        $this->mod_common->update_table("project_tpl_component_part", array("component_id" => $id), array("tpl_part_component_uom" => "", "tpl_part_component_uc" => ""));

        $delete_component = $this->mod_common->delete_record($table, $where);
        $this->mod_common->delete_record('project_component_options', array("component_id" => $id));
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
        
        $this->mod_common->is_company_page_accessible(149);
        $file = $_FILES['importcsv']['tmp_name'];
        $handle = fopen($file, "r");
        
        $allowed = array('csv');
        $filename = $_FILES['importcsv']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $this->session->set_flashdata('err_message', 'Only CSV files are allowed.');
            redirect(SURL.'supplierz/add_component');  
        }
                
        $data = array();
        $k = 0;
        
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        while ($data = fgetcsv($handle, 1000, ",", "'")) {
            if ($k > 0) {
                if(count($data)>5 || count($data)<5){
                    $this->session->set_flashdata('err_message', 'File format is wrong. Please upload correct file.');
                    redirect(SURL.'supplierz/add_component');
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
         redirect(SURL . 'supplierz/components');
    }
    
    //Add Component VIA Shortcut
    public function addcomponentbyquicklink() {
            $this->mod_common->is_company_page_accessible(149);
            $where = array('component_name' => $this->input->post('component_name'), 'supplier_id' => $this->input->post('supplier_id'));
            $is_already_exists = $this->mod_common->select_single_records('project_supplierz_components', $where);
            if(count($is_already_exists)==0){
            $filename = "";

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
						
						$projects_folder_path = './assets/supplierz/components/';
						$projects_folder_path_main = './assets/supplierz/components/';

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
            
            $addnewcomponent = $this->mod_common->insert_into_table('project_supplierz_components', $component);
            
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
	
	//Upload Document
	public function upload_component_document(){
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
    public function remove_component_file(){

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
    public function remove_component_checklist(){
        $id = $this->input->post("id");
        $this->mod_common->delete_record('project_component_checklists', array("id" => $id));
    }
    
    /***************Components Section Ends Here*********************/
    
    
    /***************Suppliers Section Starts Here*********************/
    
    //Get All Suppliers
    public function suppliers()
	{   
	    $this->mod_common->is_company_page_accessible(160);
        $data['suppliers'] = $this->mod_common->get_all_records("suppliers","*",0,0,array("company_id" => $this->session->userdata("company_id")),"supplier_id");
        $this->stencil->title('Suppliers');
	    $this->stencil->paint('supplierz/suppliers/manage_suppliers', $data);
	}

    //Add Supplier Screen
	public function add_supplier() {

        $this->mod_common->is_company_page_accessible(160);
        $this->stencil->title('Add Supplier');
        $this->stencil->paint('supplierz/suppliers/add_new_supplier');
    }
	
	//Add New Supplier
	public function add_new_supplier_process() {
		 
        $this->mod_common->is_company_page_accessible(160);
		$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
			    $this->stencil->title('Add Supplier');
                $this->stencil->paint('supplierz/suppliers/add_new_supplier');
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
				redirect(SURL . 'supplierz/suppliers');
			} else {
				$this->session->set_flashdata('err_message', 'New Supplier is not added. Something went wrong, please try again.');
				redirect(SURL . 'supplierz/suppliers');
			}
		}
    }
	
	//Edit Supplier Screen
	public function edit_supplier($supplier_id) {

        $this->mod_common->is_company_page_accessible(160);
		
	    if($supplier_id=="" || !(is_numeric($supplier_id))){
            redirect("nopage");
        }
		
        $table = "project_suppliers";
        $where = "`supplier_id` ='" . $supplier_id."' AND company_id = ".$this->session->userdata("company_id");

        $data['supplier_edit'] = $this->mod_common->select_single_records($table, $where);

        if (count($data['supplier_edit']) == 0) {
            $this->session->set_flashdata('err_message', 'Supplier does not exist.');
            redirect("supplierz/suppliers");
        } else {
            $this->stencil->title("Edit Supplier");

            $this->stencil->paint('supplierz/suppliers/edit_supplier', $data);
        }
    }
    
    //Update Supplier
    public function edit_supplier_process() {
		
        $this->mod_common->is_company_page_accessible(160);
        //If Post is not SET
        if (!$this->input->post() && !$this->input->post('update_supplier'))
        
        redirect(SURL."supplierz/suppliers");
		
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
      
        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required'.$is_unique);
		
        $original_value = $data['supplier_edit']['supplier_email'];
		
        if($this->input->post('supplier_email') != $original_value) {
            $is_unique =  '|is_unique[suppliers.supplier_email]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('supplier_email', 'Supplier Email', 'required'.$is_unique);
		
		if ($this->form_validation->run() == FALSE)
		{
		
		   $this->stencil->title("Edit Supplier");
           $this->stencil->paint('supplierz/suppliers/edit_supplier', $data);
		    
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
				redirect(SURL . 'supplierz/suppliers');
			} else {
				$this->session->set_flashdata('err_message', 'Supplier is not updated. Something went wrong, please try again.');
				redirect(SURL . 'supplierz/edit_supplier/' . $supplier_id);
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
    
    //Manage Current Jobs Project Costing
    public function project_costing()
	{
	    $this->mod_common->is_company_page_accessible(162);
	    
        $data['project_costing'] = $this->mod_project->get_all_supplierz_project_costing();
        
        $this->stencil->title('Project Costing');
	    $this->stencil->paint('supplierz/project_costing/manage_project_costing', $data);
	}
    
    //Add Project Costing Screen
    public function add_project_costing() {
        
        $this->mod_common->is_company_page_accessible(162);
        $this->stencil->title('Add Project Costing');
        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'stage_status' => 1), "stage_id");
        $data["exttemplates"] = $this->mod_common->get_all_records("project_supplierz_templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        $data["extprojects"] = $this->mod_project->get_existing_supplierz_project_costing();
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
        $this->stencil->paint('supplierz/project_costing/add_project_costing', $data);
    }
    
    //Add New Item
    public function populate_new_costing_row() {
        
        $data['last_row'] = isset($_POST['next_row']) ? $_POST['next_row'] : 0;

        if($this->session->userdata('company_id')>0){
          $where = "company_id = ".$this->session->userdata('company_id')." AND";
        }else{
         $where = "user_id = ".$this->session->userdata('user_id')." AND";
        }   
       
        $data["stages"] = $this->mod_common->get_all_records("stages","*", 0, 0, $where." stage_status = 1", "stage_id");
        $html = $this->load->view('supplierz/project_costing/add_part', $data, true);
        echo $html;

    }
	
	//Save Project Costing
	function savecost() {
	    
	    $this->mod_common->is_company_page_accessible(162);

        $this->form_validation->set_rules('costing_name', 'Project Costing Name', 'required');
        $this->form_validation->set_rules('costing_description', 'Project Costing Description', 'required');
    		
        if ($this->form_validation->run() == FALSE)
        {
            	    $this->stencil->title('Add Project Costing');
                    $data["exttemplates"] = $this->mod_common->get_all_records("project_supplierz_templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
                    $data["extprojects"] = $this->mod_project->get_existing_supplierz_project_costing();
                    $this->stencil->paint('supplierz/project_costing/add_project_costing', $data);
            	}
        else{
                	  $created_by = $this->session->userdata("user_id");
                      $user_id = $this->session->userdata("user_id");
                      $company_id = $this->session->userdata("company_id");
                      $ip_address = $_SERVER['REMOTE_ADDR'];
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
                                'costing_name' => $this->input->post('costing_name'),
                                'costing_description' => $this->input->post('costing_description'),
                                'project_id' => 0,
                                'user_id' => $this->session->userdata('user_id'),
                                'company_id' => $this->session->userdata('company_id'),
                                'include_in_report' => 0,
                                'contract_allownce' => 0,
                                'total_quantity' => $this->input->post('total_cost'),
                                'takeoffdatas' => $jtods,
                                'project_subtotal_1' => $this->input->post('total_cost'),
                                'project_subtotal_2' => $this->input->post('total_cost2'),
                                'project_subtotal_3' => $this->input->post('total_cost3'),
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
                                $line_cost = $this->input->post('linetotal');
                                $quantity_type = $this->input->post('quantity_type');
                                $quantity_formula = $this->input->post('formulaqty');
                                $formula_text = $this->input->post('formulatext');
                                $is_rounded = $this->input->post('is_rounded');
                                $line_margin = $this->input->post('margin_line');
                                $component_id = $this->input->post('component_id');
                                $supplier_id = $this->session->userdata('company_id');
                                $quantity = $this->input->post('manualqty');
                                $margin = $this->input->post('margin');
                                $line_marginn = $this->input->post('margin_line');
                                $costing_tpe_id = $this->input->post('costing_tpe_id');
                                $component_description = $this->input->post('component_description');
                            
                                $gstage_id = $this->input->post('stage_id');
                            
                                    for ($i = 0; $i < $stages; $i++) {
                                        $costing_type = "supplierz";
                                        $part_stage_id = $gstage_id[$i];
                                        $part_supplier_id = $supplier_id;
                                        $part_component_id = $component_id[$i];
                                        if($costing_tpe_id[$i]==-1){
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
                                                'component_des' => '',
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
                                        
                                        // Insert Costing Part
                                        $part_array = array(
                                        'costing_id' => $costing,
                                        'stage_id' => $part_stage_id,
                                        'component_id' => $part_component_id,
                                        'costing_part_name' => $part_name[$i],
                                        'costing_uom' => $component_uom[$i],
                                        'client_allowance' => 0,
                                        'margin' => $margin[$i],
                                        'line_cost' => $line_cost[$i],
                                        'quantity_type' => $quantity_type[$i],
                                        'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                                        'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                                        'is_rounded' => (isset($is_rounded[$i])?$is_rounded[$i]:0),
                                        'line_margin' => $line_margin[$i],
                                        'type_status' => 'estimated',
                                        'is_locked' =>0,
                                        'include_in_specification' => 0,
                                        'add_task_to_schedule' => 0,
                                        'hide_from_boom_mobile' => 1,
                                        'costing_uc' => $component_uc[$i],
                                        'costing_supplier' => $part_supplier_id,
                                        'costing_quantity' => $quantity[$i],
                                        'costing_part_status' => 1,
                                        'comment' => '',
                                        'costing_type' => $costing_type,
                                        'costing_tpe_id' => 0
                                      ); 
                                        $new_costing_part_id = $this->mod_common->insert_into_table('project_costing_parts', $part_array);
                            	    }
                                }
                            
                                if ($costing) {
                                  $this->session->set_flashdata('ok_message', 'Project Costing has been saved successfully.');
                    	          redirect(SURL."supplierz/edit_project_costing/".$costing);
                                }
                      //end of if
                      
              	}//end of else
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
    public function verify_costing_part() {

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
    
    //Verify Costing Name
    public function verify_costing_name() {

        $name = $this->input->post("name");
        
        $table = "project_costing";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'costing_id !=' => $id,
            'costing_name' => $name,
          );
        }
        else{
          $where = array(
            'costing_name' => $name,
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
		
		$takeoffdata = "";
		
		if(isset($_POST["project_id"])){
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
		}
        $rArray = array("rData" => $html, "tData" => $takeoffdata);
		$json = json_encode($rArray);
		    if ($json === false) {
            echo 'JSON encoding error: ' . json_last_error_msg();
            } else {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(trim($json));
            }
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
      
    $this->mod_common->is_company_page_accessible(162);
    
    if ($id > 0) {
        
        $data["exttemplates"] = $this->mod_common->get_all_records("project_supplierz_templates","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'template_status' => 1), "template_id");
        
        $data["extprojects"] = $this->mod_project->get_existing_supplierz_project_costing();
                   
    
        $data['prjprts'] = $this->mod_project->get_supplierz_costing_parts_by_id($id);
        
        $data['stages'] = $this->mod_project->get_supplierz_project_costing_stages($id);
        
        foreach($data["stages"] as $key => $stage){
            $data["stages"][$key]["costing_parts"] = $this->mod_project->get_supplierz_costing_parts_by_stage($id, $stage["stage_id"]);
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
        $todata['projectCosting'] = $this->mod_project->get_project_costing_by_costing_id($id);
        $data['takeoffdata'] = $this->load->view('supplierz/project_costing/formula_calculation_table', $todata, true);
        $data['pc_detail'] = $this->mod_project->get_supplierz_project_costing_info($id);
        $data['project_costing_id'] = $id;
        $counter = count($data['prjprts']);
        
        if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'takeof_status' => 1);
        }
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, $cwhere, "takeof_id");

        $this->stencil->paint('supplierz/project_costing/edit_project_costing', $data); 
    }
    else {
          redirect(SURL."nopage");
		}
}
	
	//Update Project Costing
	public function update_project_costing_process($costing){
	    
	    $this->mod_common->is_company_page_accessible(162);

        $p_id = $this->input->post('current_costing_id');
        
        $selected_tab = $this->input->post('selected_tab');
      
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
              'costing_name' => $this->input->post('costing_name'),
              'costing_description' => $this->input->post('costing_description'),
              'total_quantity' => $this->input->post('total_cost'),
              'project_subtotal_1' => $this->input->post('total_cost'),
              'project_subtotal_2' => $this->input->post('total_cost2'),
              'project_subtotal_3' => $this->input->post('total_cost3'),
              'over_head_margin' => $this->input->post('overhead_margin'),
              'porfit_margin' => $this->input->post('profit_margin'),
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
             $line_margin = $this->input->post('margin_line');
             $quantity = $this->input->post('manualqty');
             $allowances = $this->input->post('allowance');
             $margin = $this->input->post('margin');
             $costing_tpe_id = $this->input->post('costing_tpe_id');
             $component_description = $this->input->post('component_description');
             $ip_address = $_SERVER['REMOTE_ADDR'];
            
             $gstage_id = $this->input->post('stage_id');
             
            $updatedarr=array();
            for ($i = 0; $i < $stages; $i++) {
                
             if(isset($component_uom[$i]) && isset($margin[$i]) && isset($component_uc[$i]) && isset($quantity[$i])){
                  if(!(isset($comments[$i])) || ($comments[$i]==" ") || (empty($comments[$i]))){
                    $comments[$i]="";
                  }
                  else{
                    $comments[$i] = $comments[$i];
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
                  $supplier_info_query = $this->db->query("Select * FROM project_suppliers WHERE parent_supplier_id='".$this->session->userdata('company_id')."'");
			      $supplier_info_result = $supplier_info_query->row_array();
    					
                  if($part_name_text!='' || $part_name_text==0){
                    $part_stage_id = $gstage_id[$i];
                    $part_supplier_id = $supplier_info_result["supplier_id"];
                    $part_component_id = $component_id[$i];
                    if($costing_tpe_id[$i]==-1){
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
                                    'supplier_name' => $supplier_info_result["supplier_name"],
                                    'supplier_status' => 1,
                                    'created_by' => $this->session->userdata('user_id'),
                                    'ip_address' => $ip_address,
                                    'company_id' => $this->session->userdata('company_id'),
                                );
                
                                $existing_supplier = $this->mod_common->select_single_records('project_suppliers', array('company_id' => $this->session->userdata('company_id'), 'supplier_name' => $supplier_info_result["supplier_name"]));
                                
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
                            'component_des' => $component_description[$i],
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
                    $part = array(
                      'costing_id' => $costing,
                      'stage_id' => $part_stage_id,
                      'component_id' => $part_component_id,
                      'costing_part_name' => $part_name[$i],
                      'costing_uom' => $component_uom[$i],
                      'client_allowance' => 0,
                      'margin' => $margin[$i],
                      'line_cost' => $line_cost[$i],
                      'line_margin' => $line_margin[$i],
                      'type_status' => "estimated",
                      'quantity_type' => $quantity_type[$i],
                      'quantity_formula' => (isset($quantity_formula[$i])?$quantity_formula[$i]:""),
                      'formula_text' => (isset($formula_text[$i])?$formula_text[$i]:""),
                      'is_rounded' => (isset($is_rounded[$i])?$is_rounded[$i]:0),
                      'is_locked' => 0,
                      'include_in_specification' => 0,
                      'add_task_to_schedule' => 0,
                      'hide_from_boom_mobile' => 1,
                      'costing_uc' => $component_uc[$i],
                      'costing_supplier' => $part_supplier_id,
                      'costing_quantity' => $quantity[$i],
                      'costing_type'   => "supplierz",
                      'costing_tpe_id'   => 0,
                      'costing_part_status' => 1
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
            redirect(SURL."supplierz/edit_project_costing/".$costing);
            }
          }
            else{
                redirect(SURL."nopage");
            }
	}
	
	//Delete Template
    public function delete_project_costing() {
  
        $this->mod_common->is_company_page_accessible(149);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "project_costing";
        $where = "`costing_id` ='" . $id . "'";
		
        $delete_project_costing = $this->mod_common->delete_record($table, $where);
        
        $table = "project_costing_parts";
        $where = "`costing_id` ='" . $id . "'";
		
        $delete_costing_parts = $this->mod_common->delete_record($table, $where);

    }
    
    //Import Project Costing Data By Existing Template
    public function get_project_costing_by_template($id) {
        
		$data['next_row'] = isset($_POST['last_row']) ? $_POST['last_row'] : 0;
		$todid = isset($_POST['todid']) ? $_POST['todid'] : "";

		if ($id > 0) {
		    
			$data['templates'] = $this->mod_template->get_supplierz_template($id);			
			$data['template_id'] =$id;
			$data['tparts'] = $this->mod_project->get_supplierz_costing_parts_by_template_id($id);
            $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, array('company_id' => $this->session->userdata('company_id'),'takeof_status' => 1), "takeof_id");
                
			$html = $this->load->view('supplierz/project_costing/populate_stages_for_template', $data, true);

			$rArray = array("rData" => $html);
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
        $data['prjprts'] = $this->mod_project->get_supplierz_costing_parts_by_id($id);
        
       if($this->session->userdata('company_id')>0){
          $cwhere = array('company_id' => $this->session->userdata('company_id'), 'takeof_status' => 1);
        }else{
         $cwhere = array('user_id' => $this->session->userdata('user_id'), 'takeof_status' => 1);
        }
        $data["takeoffdatas"] = $this->mod_common->get_all_records("takeoffdata","*", 0, 0, $cwhere, "takeof_id");
    
        $html = $this->load->view('supplierz/project_costing/populate_stages_for_project', $data, true);
        $rArray = array(
          "rData" => $html
        );
        header('Content-Type: application/json');
        echo json_encode($rArray);
            
        } else {
        
        }
    }
    
    public function import_component_in_project_costing_by_csv(){
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
                                if(!isset($data[7])){
                                    echo "File format is wrong. Please upload correct file.";exit;
                                }
                                else{
                                    $html .= '<tr id="trnumber'.$count.'" tr_val="'.$count.'">
    <input  name="costing_tpe_id[]" rno ="'.$count.'" id="costing_tpe_id'.$count.'" type="hidden"  class="form-control" value="-1" />
	<input  name="costing_part_id[]" rno ="'.$count.'" id="costing_part_id'.$count.'" type="hidden"  class="form-control" value="0" />
	<td><input type="hidden" name="stage_id[]" value="'.$data[0].'">'.$data[0].'</td>
                                                           <td><input type="hidden" name="part_name[]" value="'.$data[1].'">'.$data[1].'</td>
                                                           <td><input type="hidden" name="component_id[]" value="'.$data[2].'">'.$data[2].'</td>
                                                           <td><input type="hidden" name="supplier_id[]" value="'.$data[3].'">'.$data[3].'</td>
                                                           <td><input type="hidden" class="form-control" name="quantity_type[]" id="quantity_type'.$count.'" rno ="'.$count.'" value="manual">Manual</td>
                                                           <td><input rno="'.$count.'" type="hidden" class="qty" id="manualqty'.$count.'" name="manualqty[]" value="'.$data[4].'">'.$data[4].'</td>
                                                           <td><input type="hidden" name="component_uom[]" value="'.$data[5].'">'.$data[5].'</td>
                                                           <td><input type="hidden" name="component_uc[]" id="ucostfield'.$count.'" value="'.$data[6].'">'.$data[6].' <input type="hidden" id="order_unit_cost'.$count.'" rno ="'.$count.'" name="order_unit_cost[]" value="0.00"></td>
                                                           <td><input type="hidden" name="linetotal[]" id="linetotalfield'.$count.'"  value="'.$data[7].'">'.$data[7].'</td>
                                                           <td><input type="hidden" name="margin[]" id="marginfield'.$count.'" value="0.00">0.00</td>
                                                           <td><input type="hidden" name="margin_line[]" id="margin_linefield'.$count.'" value="'.$data[7].'">'.$data[7].'</td>
                                                            <td class="text-right">
                                                               <a rno="'.$count.'" class="btn btn-simple btn-danger btn-icon deleterow deleterow'.$count.'"><i class="material-icons">delete</i></a>
                                                               <input class="form-control formula" rno ="'.$count.'" type="hidden" value="" name="formula[]" id="formula_stage_'.$count.'" title="'.$count.'" alt="'.$count.'">
                                                               <input class="form-control formulaqty"  rno ="'.$count.'" type="hidden" value="" name="formulaqty[]" id="formulaqty_stage_'.$count.'" title="'.$count.'" alt="'.$count.'">
                                                               <input class="form-control formulatext"  rno ="'.$count.'" type="hidden" value="" name="formulatext[]" id="formulatext_stage_'.$count.'" title="'.$count.'" alt="'.$count.'">
                                                               <input class="form-control"  rno ="'.$count.'" type="hidden" value="0" name="is_rounded[]" id="is_rounded_stage_'.$count.'" title="'.$count.'" alt="'.$count.'">
                                                              
                                                            </td></tr>';
                                  $count++;  
                                }
                                
                            }//end of if
                            $k++;
                        }//end of while
                        echo $html;
	}
    
    /***************Project Costing Section Ends Here*********************/
    
    //Add New Takeoffdata
	public function add_new_takeoffdata_process() {
		
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
