<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_holidays extends CI_Controller {

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
             
             $this->load->model("mod_scheduling");
             
             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(134);
             $this->mod_common->is_company_page_accessible(154);

        }
	public function index()
	{
	    $this->mod_common->is_company_page_accessible(135);
        $data['public_holidays'] = $this->mod_common->get_all_records("scheduling_public_holidays", "*", 0, 0, array("company_id" => $this->session->userdata("company_id")));
        $this->stencil->title('Public Holidays');
	    $this->stencil->paint('scheduling/public_holidays/manage_public_holidays', $data);
	}

	public function add_public_holiday() {
	    $this->mod_common->is_company_page_accessible(135);
        $this->mod_scheduling->is_viewer();
        $this->stencil->title('Add Public Holiday');
        $this->stencil->paint('scheduling/public_holidays/add_new_public_holiday');
    }
	
	 public function add_new_public_holiday_process() {
	     $this->mod_common->is_company_page_accessible(135);
		 $this->mod_scheduling->is_viewer();
		$this->form_validation->set_rules('title', 'Public Holiday', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		
	    if ($this->form_validation->run() == FALSE)
			{
                $this->stencil->title('Add Public Holiday');
                $this->stencil->paint('scheduling/public_holidays/add_new_public_holiday');
			}
		else{
			$ins_array = array("title" => $this->input->post("title"),
			                   "date" => $this->input->post("date"),
			                   "company_id" => $this->session->userdata("company_id"));
			                   
			$add_new_public_holiday = $this->mod_common->insert_into_table("scheduling_public_holidays", $ins_array);

			if ($add_new_public_holiday) {
				$this->session->set_flashdata('ok_message', 'New Public Holiday added successfully.');
				redirect(SCURL . 'public_holidays');
			} else {

				$this->session->set_flashdata('err_message', 'New Public Holiday is not added. Something went wrong, please try again.');
				redirect(SCURL . 'public_holidays');
			}
		}
    }
	
	public function edit_public_holiday($public_holiday_id) {
		$this->mod_common->is_company_page_accessible(135);
		if($public_holiday_id=="" || !(is_numeric($public_holiday_id))){
            redirect("nopage");
        }
        
        $data["public_holiday_edit"] = $this->mod_common->select_single_records("scheduling_public_holidays", array("id" => $public_holiday_id, "company_id" =>  $this->session->userdata("company_id")));
        
        if (count($data["public_holiday_edit"]) == 0){
            $this->session->set_flashdata('err_message', 'Record does not exists.');
            redirect(SCURL . 'public_holidays');
     	}
        $this->stencil->title('Edit Public Holiday');
        $this->stencil->paint('scheduling/public_holidays/edit_public_holiday', $data);
    }

    public function edit_public_holiday_process() {
        $this->mod_common->is_company_page_accessible(135);
        $this->mod_scheduling->is_viewer();
        
        $public_holiday_id = $this->input->post('public_holiday_id');
        $data["public_holiday_edit"] = $this->mod_common->select_single_records("scheduling_public_holidays", array("id" => $public_holiday_id, "company_id" =>  $this->session->userdata("company_id")));
		
		
		
	   if (count($data["public_holiday_edit"]) == 0){
            $this->session->set_flashdata('err_message', 'Record does not exists.');
            redirect(SCURL . 'public_holidays');
     	}
        
		$original_value = $data["public_holiday_edit"]['title'];
		
        if($this->input->post('title') != $original_value) {
            $is_unique =  '|is_unique[public_holidays.title]';
        } else {
            $is_unique =  '';
        }
      
        $this->form_validation->set_rules('title', 'Public Holiday', 'required'.$is_unique);
        $this->form_validation->set_rules('date', 'Date', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
		
           $this->stencil->title('Edit Public Holiday');
           $this->stencil->paint('scheduling/public_holidays/edit_public_holiday', $data);
		    
		}
		
		else{
		    $upd_array = array("title" => $this->input->post("title"),
			                   "date" => $this->input->post("date"));
			$upd_admin_public_holiday = $this->mod_common->update_table("scheduling_public_holidays", array("id" => $public_holiday_id), $upd_array);

			if ($upd_admin_public_holiday) {
				$this->session->set_flashdata('ok_message', 'Public Holiday updated successfully.');
				redirect(SCURL . 'public_holidays');
			} else {
				$this->session->set_flashdata('err_message', 'Public Holiday is not updated. Something went wrong, please try again.');
				redirect(SCURL . 'public_holidays/edit_public_holiday/' . $public_holiday_id);
			}
		}
    }
	
	public function delete_public_holiday() {
	    $this->mod_common->is_company_page_accessible(135);
		$this->mod_scheduling->is_viewer();
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "scheduling_public_holidays";
        $where = "`id` ='" . $id . "'";
		
        $delete_public_holiday = $this->mod_common->delete_record($table, $where);

    }
	
	 public function verify_public_holiday() {
        $this->mod_common->is_company_page_accessible(135);
        $title = $this->input->post("title");
        
        $table = "scheduling_public_holidays";

        if($this->input->post("id")!=""){
           $id = $this->input->post("id");
           $where = array(
            'id !=' => $id,
            'title' => $title,
            'company_id' =>  $this->session->userdata("company_id")
          );
        }
        else{
          $where = array(
            'title' => $title,
            'company_id' =>  $this->session->userdata("company_id")
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
