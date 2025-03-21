<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price_book_requests extends CI_Controller {

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
             
             $this->mod_common->is_company_page_accessible(63);

             $this->mod_common->verify_is_user_login();
        }
        
        //Manage Price Book Requests
        public function index(){
            $this->mod_common->is_company_page_accessible(121);
            $where = array('company_id' => $this->session->userdata('company_id'));
            $data['requests'] = $this->mod_common->get_all_records('price_book_requests', "*", 0, 0, $where);
            $this->stencil->title('Price Book Requests');
	        $this->stencil->paint('price_book/manage_requests', $data);
        }
        
        //Send Price Book Request to Supplierz Screen
        public function send_request() {
        $this->mod_common->is_company_page_accessible(121);
        $data['supplier_users'] = $this->mod_price_book->get_supplier_users();
        $this->stencil->title('Send Price Book Request');
	    $this->stencil->paint('price_book/send_request', $data);
    }
        
        //Send Price Book Request to Supplierz
        public function send_request_process(){
            $this->mod_common->is_company_page_accessible(121);
           	$this->form_validation->set_rules('supplier_user_id', 'Supplier User', 'required');
            if ($this->form_validation->run() == FALSE)
			{
			    $data['supplier_users'] = $this->mod_price_book->get_supplier_users();
                $this->stencil->title('Send Price Book Request');
	            $this->stencil->paint('price_book/send_request', $data);
			}
		   else{
                $request_array = array(
                    'from_user_id' => $this->session->userdata('user_id'),
                    'to_user_id' => $this->input->post('supplier_user_id'),
                    'company_id' => $this->session->userdata('company_id')
                );
                
                $send_request = $this->mod_common->insert_into_table('project_price_book_requests', $request_array);
                
                if ($send_request) {
                    $this->session->set_flashdata("ok_message", 'Price Book Request has been sent successfully!');
                    redirect(SURL."price_book_requests");
                }
		   }
    }
        
        //Delete Request
        public function delete_request(){
            $this->mod_common->is_company_page_accessible(121);
            $id = $this->input->post("id");
            $this->mod_common->delete_record('project_price_book_requests', array('id'=>$id));
        }

    }