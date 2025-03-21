<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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

            $this->load->model(array(
                  "mod_login",
                  "mod_common",
                  "mod_project"
            ));
            $this->load->model('mod_saleinvoice', 'saleinvoice');
            $this->load->model('mod_supplierinvoice', 'supplierinvoice');
            $this->load->library('xero');

        }
        
    //Login Screen
	public function index()
	{
         $this->stencil->title('Login');
	     $this->stencil->paint('login/login');
	}
    
    //Validate Login User
    public function validate_user() {

        if (!$this->input->post()){
        redirect(SURL . "login");
        }
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        if ($email == "" || $password == "") {

            $this->session->set_flashdata('err_message', '- Email or Password is empty. Please try again!');
            redirect(SURL . "login");

        } else {

            $chk_isvalid_user = $this->mod_login->validate_credentials($email, $password);
           
            if ($chk_isvalid_user) {
                if($chk_isvalid_user["user_status"]==0){
                   $this->session->set_flashdata('err_message', 'Please activate your account!');
                   redirect(SURL . 'login');
                }
                
                if($this->input->post('remember')=="1") {
				
				setcookie('user_remember_me', $this->input->post('email'), time() + 3600 * 24 * 365, "/");
				setcookie('user_remember_me_pass', $this->input->post('password'), time() + 3600 * 24 * 365, "/");
			
				}
				else {
					if(isset($_COOKIE['user_remember_me'])) {
						$past = time() - 3600;
						setcookie('user_remember_me','', $past, "/");
						setcookie('user_remember_me_pass','', $past, "/");
					}
				}
                
                if($chk_isvalid_user['company_id']=="0"){
					    
					$this->session->set_userdata('company_id', $chk_isvalid_user['user_id']);
					$this->session->set_userdata('is_company', 'true');
				}
				else{
					    
					 $this->session->set_userdata('company_id', $chk_isvalid_user['company_id']);
					 $this->session->set_userdata('is_company', 'false');
					  
				}
				
                $login_sess_array = array(
                    'logged_in' => true,
                    'user_id' => $chk_isvalid_user['user_id'],
                    'user_role_id' => $chk_isvalid_user['role_id'],
                    'firstname' => $chk_isvalid_user['user_fname'],
                    'lastname' => $chk_isvalid_user['user_lname'],
                    'company_name' => $chk_isvalid_user['com_name'],
                    'email' => $chk_isvalid_user['user_email'],
                    'last_signin' => $chk_isvalid_user['last_signin'],
                    'signing_ip' => $chk_isvalid_user['signing_ip'],
                    'avatar' => $chk_isvalid_user['user_img'],
                    'parent_id' => $chk_isvalid_user['company_id']
                );
                
                $this->session->set_userdata($login_sess_array);
                
                $id = $this->session->userdata("user_id");
                $table = "project_users";
                $where = "`user_id` ='" . $id."'";
                $profileInfo = $this->mod_common->select_single_records($table, $where);
                
                if($profileInfo["com_email"]=="" && $profileInfo["company_id"]==0){
                      $this->session->set_userdata("permissions", array());
                }
                else{
                     $this->session->set_userdata("permissions", explode(";",$chk_isvalid_user['permissions']));
                }

                $ref_url = isset($_GET['url_ref'])?$_GET['url_ref']:""; 
                
                if($ref_url==""){
                if($profileInfo["com_email"]=="" && $profileInfo["company_id"]==0){
                     redirect(SURL."profile");
                }
                else{
                    redirect(SURL . 'welcome');
                }
                }else{
                    redirect($ref_url);
                }
            } else {

                $this->session->set_flashdata('err_message', 'Invalid Email or Password. Please try again!');
                redirect(SURL . 'login');
            }//end if($chk_isvalid_user) 
        }
    }

    //Activate User Account
    public function activate() {
         $url =  explode("-",$this->uri->segment(3));
         if(count($url)==0){
            redirect("nopage");
         }
         $id = $url[0];
         $password = $url[1];
         $is_already_activated = $this->mod_common->select_single_records("project_users", array("user_id" => $id));
         if($is_already_activated['status']==0){
            $table = "project_users";
	    $where = "`user_id` ='" . $id. "'";
            $upd_array = array("user_status" => 1);
	    $update_status = $this->mod_common->update_table($table, $where, $upd_array);
            $this->session->set_flashdata('ok_message', 'Account activated successfully!');
	        redirect(SURL . 'login');
         }
         else{
            
            $this->session->set_flashdata('err_message', 'You cannot activate your account again!');
            redirect(SURL . 'login');
         }

    }
    
    //Update Paid Supplier Invoices from Xero to Project Software
    public function supplier_invoice_payments(){
	    $xero_credentials = get_xero_credentials();
        if(count($xero_credentials)>0){
             
	    $invoice_result = $this->xero->Invoices();
	    
	   /* echo "<pre>";
	    print_r($invoice_result);exit;*/
		
		if(count($invoice_result['Invoices']['Invoice'])>0){
    		foreach($invoice_result['Invoices']['Invoice'] as $invoice){
    		    
                 if($invoice['Type']=="ACCPAY"){
                     
                    $xero_invoice_id = $invoice['InvoiceID'];
                    
                    $cwhere = array('xero_invoice_id' => $xero_invoice_id, 'status !=' => 'Paid');
                    $invoice_detail = $this->mod_common->select_single_records('project_supplier_invoices', $cwhere);
                    
                    /*if(count($invoice_detail)==0){
                       
                         $Invoice_Number = explode("INV-", $invoice['InvoiceNumber']);
                         $InvoiceNumber = $Invoice_Number[1] - 1000000;
                         $cwhere = array('id' => $InvoiceNumber, 'status !=' => 'Paid');
                         $invoice_detail = $this->mod_common->select_single_records('project_supplier_invoices', $cwhere);
                        
                    }*/
                    
                    
                    $total_receipt_payment = 0;
                    
                    if(count($invoice_detail)>0){
                        $invoice_id = $invoice_detail['id'];
                        if(isset($invoice['Payments']) && count($invoice['Payments'])>0){
        		    
        		        if(isset($invoice['Payments']['Payment'][0])){
            		    // For multiple payments
            		    foreach($invoice['Payments']['Payment'] as $xero_invoice_payment){
            		       if(isset($xero_invoice_payment['PaymentID'])){
                		    
                	     	
                            if(isset($xero_invoice_payment['PaymentID'])){
                            $payment_id = $xero_invoice_payment['PaymentID'];
                            }
                            else{
                                $payment_id = 0;
                            }
                           
                            $cwhere = array('supplier_invoice_id' => $invoice_id);
                            $receipt_info = $this->mod_common->select_single_records('project_suppliers_receipts', $cwhere);
                            
                            if(count($receipt_info)>0){
                                $cwhere = array('supplier_receipt_id' => $receipt_info['id'], 'xero_payment_id' => $payment_id);
                                $is_already_paid = $this->mod_common->select_single_records('project_suppliers_payment_history', $cwhere);
                            }
                            else{
                                $is_already_paid = array();
                            }
                                
                                            if(count($is_already_paid)==0){
                                           
                                            
                                    	    $receipt_payment = $xero_invoice_payment['Amount'];
                                    		$cwhere = array('supplier_invoice_id' => $invoice_id);
                                            $is_existing = $this->mod_common->select_single_records('project_suppliers_receipts', $cwhere);
                                    		if(count($is_existing)==0 ){
                                    
                                                $receipt = array(
                                                    'supplier_invoice_id' =>$invoice_id,
                                                    'payment' => $receipt_payment,
                                    
                                                );
                                    
                                                $receipt_id = $this->mod_common->insert_into_table('project_suppliers_receipts', $receipt);
                                                
                                                 $receiptsaleinvoiceitem = array(
                                                    'receipt_id' => $receipt_id,
                                                    'supplier_invoice_item_id' => $sale_invoice_item_id,
                                                    'payment' => $receipt_payment,
                                    
                                                );
                                    
                                                $receiptsaleinvoiceitem_id = $this->mod_common->insert_into_table('project_suppliers_receipts_items', $receiptsaleinvoiceitem);
                                                
                                                
                                                $receipt_history = array(
                                                    'supplier_receipt_id' =>$receipt_id,
                                                    'amount' => $receipt_payment,
                                                    'xero_payment_id' => $payment_id,
                                    
                                                );
                                    
                                                $this->mod_common->insert_into_table('project_suppliers_payment_history', $receipt_history);
                                                
                                                
                                                $total_receipt_payment +=$receipt_payment;
                                                
                                    		}
                                    		else{
                                    		     $total_receipt_payment2 = $receipt_payment;
                                    		     $update_receipt =  $this->supplierinvoice->updatereceipt($is_existing['id'],$total_receipt_payment2);
                                    		     
                                    		     $cwhere = array('receipt_id' => $is_existing['id'],'supplier_invoice_item_id' => $sale_invoice_item_id );
                                                 $receiptitems = $this->mod_common->select_single_records('project_suppliers_receipts_items', $cwhere);
                                            
                                                $receiptitem=0;
                                    
                                                if(count($receiptitems)){
                                                    $receiptitem=$receiptitems['id'];
                                                    $update_receiptitem=  $this->supplierinvoice->updatereceiptitem($receiptitem, $receipt_payment);
                                                    
                                                    $receipt_history = array(
                                                    'supplier_receipt_id' =>$is_existing['id'],
                                                    'amount' => $receipt_payment,
                                                    'xero_payment_id' => $payment_id,
                                    
                                                    );
                                                    $this->mod_common->insert_into_table('project_suppliers_payment_history', $receipt_history);
                                                    $total_receipt_payment +=$receipt_payment;
                                                }
                                    		}
                                    		
                                      }
                                      
                                
                                
            		        }
    				
            		}
        		    }
        		    else{
                        if(isset($invoice['Payments']['Payment']['PaymentID'])){
                        $payment_id = $invoice['Payments']['Payment']['PaymentID'];
                       
                        $cwhere = array('supplier_invoice_id' => $invoice_id);
                        $receipt_info = $this->mod_common->select_single_records('project_suppliers_receipts', $cwhere);
                        if(count($receipt_info)>0){
                        $cwhere = array('supplier_receipt_id' => $receipt_info['id'], 'xero_payment_id' => $payment_id);
                        $is_already_paid = $this->mod_common->select_single_records('project_suppliers_payment_history', $cwhere);
                        }
                        else{
                           $is_already_paid = array(); 
                        }
                        if(count($is_already_paid)==0){
                                    
                            		$receipt_payment = $invoice['Payments']['Payment']['Amount'];
                            		$cwhere = array('supplier_invoice_id' => $invoice_id);
                                    $is_existing = $this->mod_common->select_single_records('suppliers_receipts', $cwhere);
                            			if(count($is_existing)==0 ){
                                    
                                                $receipt = array(
                                                    'supplier_invoice_id' =>$invoice_id,
                                                    'payment' => $receipt_payment,
                                    
                                                );
                                    
                                                $receipt_id = $this->mod_common->insert_into_table('project_suppliers_receipts', $receipt);
                                                
                                                 $receiptsaleinvoiceitem = array(
                                                    'receipt_id' => $receipt_id,
                                                    'supplier_invoice_item_id' => $invoice_id,
                                                    'payment' => $receipt_payment,
                                    
                                                );
                                    
                                                $receiptsaleinvoiceitem_id = $this->mod_common->insert_into_table('project_suppliers_receipts_items', $receiptsaleinvoiceitem);
                                                
                                                
                                                $receipt_history = array(
                                                    'supplier_receipt_id' =>$receipt_id,
                                                    'amount' => $receipt_payment,
                                                    'xero_payment_id' => $payment_id,
                                    
                                                );
                                    
                                                $this->mod_common->insert_into_table('project_suppliers_payment_history', $receipt_history);
                                                
                                                
                                                $total_receipt_payment +=$receipt_payment;
                                                
                                    		}
                                    		else{
                                    		     $total_receipt_payment2 = $receipt_payment+$is_existing['payment'];
                                    		     $update_receipt =  $this->supplierinvoice->updatereceipt($is_existing['id'],$total_receipt_payment2);
                                    		     
                                    		     $cwhere = array('receipt_id' => $is_existing['id'],'supplier_invoice_item_id' => $invoice_id );
                                                 $receiptitems = $this->mod_common->select_single_records('project_suppliers_receipts_items', $cwhere);
                                            
                                                $receiptitem=0;
                                    
                                                if(count($receiptitems)){
                                                    $receiptitem=$receiptitems['id'];
                                                    $update_receiptitem=  $this->supplierinvoice->updatereceiptitem($receiptitem, $receipt_payment);
                                                    
                                                    $receipt_history = array(
                                                    'supplier_receipt_id' =>$is_existing['id'],
                                                    'amount' => $receipt_payment,
                                                    'xero_payment_id' => $payment_id,
                                    
                                                    );
                                                    $this->mod_common->insert_into_table('project_suppliers_payment_history', $receipt_history);
                                                    $total_receipt_payment +=$receipt_payment;
                                                }
                                    		}
                                    }
                            }
        		    }
        		     
        		}
            		    // Allocation Process
            		
                		if(isset($invoice['CreditNotes']) && count($invoice['CreditNotes'])>0){
                		 
                		    if(isset($invoice['CreditNotes']['CreditNote'][0])){
                		      foreach($invoice['CreditNotes']['CreditNote'] as $xero_credit_note){
                        		if(isset($xero_credit_note['CreditNoteID'])){
                        		       $creditNoteDetails = $this->mod_common->select_single_records("project_supplier_credits", array("xero_creditnote_id" => $xero_credit_note['CreditNoteID']));
                        		        if(count($creditNoteDetails)>0){
                            		       $creditNoteAllocationDetails = $this->mod_common->select_single_records("project_credit_notes_allocated_invoices", array("credit_note_id" => $creditNoteDetails['id']));
                                		     if(count($creditNoteAllocationDetails)>0){
                                		         $upd_array = array("allocated_invoice_id" => $invoice_detail['id'], "amount" => $xero_credit_note['AppliedAmount']);
                                		         $this->mod_common->update_table("project_credit_notes_allocated_invoices",  array("credit_note_id" =>  $creditNoteDetails['id']) , $upd_array);
                                		     }
                                		     else{
                                		         $ins_array = array("allocated_invoice_id" => $invoice_detail['id'], "credit_note_id" => $creditNoteDetails['id'], "xero_creditnote_id" => $xero_credit_note['CreditNoteID'], "amount" => $xero_credit_note['Total']);
                                		         $this->mod_common->insert_into_table("project_credit_notes_allocated_invoices",  $ins_array);
                                		     }
                        		        }
                        		      }
                        		 }
                		    }
                		    else{
                              $credit_note_id = $invoice['CreditNotes']['CreditNote']['CreditNoteID'];
                		      $credit_note_total = $invoice['CreditNotes']['CreditNote']['AppliedAmount'];
                		      $creditNoteDetails = $this->mod_common->select_single_records("project_supplier_credits", array("xero_creditnote_id" => $credit_note_id));
                		      if(count($creditNoteDetails)>0){
                		      $creditNoteAllocationDetails = $this->mod_common->select_single_records("project_credit_notes_allocated_invoices", array("credit_note_id" => $creditNoteDetails['id']));
                		      
                		     if(count($creditNoteAllocationDetails)>0){
                            		         $upd_array = array("allocated_invoice_id" => $invoice_detail['id'], "amount" => $credit_note_total);
                            		         $this->mod_common->update_table("project_credit_notes_allocated_invoices",  array("credit_note_id" =>  $creditNoteDetails['id']) , $upd_array);
                            		     }
                            		     else{
                            		         $ins_array = array("allocated_invoice_id" => $invoice_detail['id'], "credit_note_id" => $creditNoteDetails['id'], "xero_credit_note_id" => $credit_note_id, "amount" => $credit_note_total);
                            		         $this->mod_common->insert_into_table("project_credit_notes_allocated_invoices",  $ins_array);
                            		     }
                		      }
                		    }
                		}
                		else{
                		    $upd_array = array("allocated_invoice_id" => 0);
                            $this->mod_common->update_table("project_credit_notes_allocated_invoices",  array("allocated_invoice_id" =>  $invoice_detail['id']) , $upd_array);
                            $update_array = array(
                                "status" => "Approved",
                                "va_status" => "APPROVED",
                            );
                            
                            $where = array(
                                "xero_invoice_id" => $xero_invoice_id,
                                "status !=" => "Paid"
                            );
                
                            $table = "project_supplier_invoices";
                            $this->mod_common->update_table($table, $where, $update_array);
                            
                            //Variation Status
                            
                            $supplier_invoice_info = $this->mod_common->select_single_records('project_supplier_invoices', $where);
                            if(count($supplier_invoice_info)>0){
                            
                                 $update_array = array(
                                    "status" => "APPROVED",
                                );
                                
                                $where = array(
                                    "var_number" => $supplier_invoice_info['var_number'],
                                );
                    
                                $table = "project_variations";
                                $this->mod_common->update_table($table, $where, $update_array);
                            }
                		}
                		
                		if($invoice['Status']=="PAID"){
                        
                            $update_array = array(
                                "status" => "Paid",
                                "va_status" => "PAID",
                            );
                            
                            $where = array(
                                "xero_invoice_id" => $xero_invoice_id,
                            );
                
                            $table = "project_supplier_invoices";
                            $this->mod_common->update_table($table, $where, $update_array);
                            
                            //Variation Status
                            
                            $supplier_invoice_info = $this->mod_common->select_single_records('project_supplier_invoices', $where);
                            if(count($supplier_invoice_info)>0){
                            
                                 $update_array = array(
                                    "status" => "PAID",
                                );
                                
                                $where = array(
                                    "var_number" => $supplier_invoice_info['var_number'],
                                );
                    
                                $table = "project_variations";
                                $this->mod_common->update_table($table, $where, $update_array);
                            }
                		}
                    }
                 }
    		}
		}
		
        }
	    
	}
	
	//Update Paid Sales Invoices from Xero to Project Software
	public function sales_invoices_payment() {
        $xero_credentials = get_xero_credentials();
        if(count($xero_credentials)>0){
        
		$invoice_result = $this->xero->Invoices();
		
		foreach($invoice_result['Invoices']['Invoice'] as $invoice){
		  if($invoice['Type']=="ACCREC"){
    		    $cwhere = array('xero_invoice_id' => $invoice['InvoiceID'], 'status !=' => 'PAID');
                $invoice_detail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
              
    		     if(count($invoice_detail)==0){
                         $Invoice_Number = explode("INV-", $invoice['InvoiceNumber']);
                         $invoice_id = $Invoice_Number[1] - 1000000;
                         $cwhere = array('id' => $invoice_id, 'status !=' => 'PAID');
                         $invoice_detail = $this->mod_common->select_single_records('project_sales_invoices', $cwhere);
                    }
    		    
                if(count($invoice_detail)>0){
                 $invoice_id = $invoice_detail['id'];
		         if($invoice_detail['status'] == "APPROVED"){
            
                                        $data['pc_detail'] = $this->mod_project->get_project_costing_info($invoice_detail['project_id']);
                                        $tax = $data['pc_detail']->tax_percent;
                                        
                                        $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'apd');
                                        $data['apdsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
                                        foreach ($data['apdsiis']  as $key => $apdsii) {
                                            
                                            $result_arr =$this->saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($apdsii['id']);
                                            $apdsii[$key]['payment']=$result_arr[0]['payment'];
                                        
                                            $sale_invoice_item_id=$apdsii['id'];
                                            $invoice_amount= $apdsii['part_invoice_amount'];
                                            $payment= $apdsii[$key]['payment'];
                                            $outstanding = number_format($invoice_amount-$payment,2,'.','' );
                                            
                                        }
                            
                                        $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'var');
                                        $data['varsiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
                                        
                                        foreach ($data['varsiis']  as $key => $varsii) {
                                             $result_arr =$this->saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($varsii['id']);
                                             $varsii[$key]['payment']=$result_arr[0]['payment'];
                                             $sale_invoice_item_id=$varsii['id'];
                                             $invoice_amount= $varsii['part_invoice_amount'];
                                             $payment= $varsii[$key]['payment'];
                                             $outstanding = number_format($invoice_amount-$payment,2,'.','' );
                                           
                                        }
                                
                                        $cwhere = array('sale_invoice_id' => $invoice_id, 'type' => 'pay');
                                        $data['paysiis'] = $this->mod_common->get_all_records('project_sales_invoices_items', "*", 0, 0, $cwhere);
                                        foreach ($data['paysiis']  as $key => $paysii) {
                                            $result_arr =$this->saleinvoice->get_outstandingp_amount_by_sale_invoice_items_id($paysii['id']);
                                            $paysii[$key]['payment']=$result_arr[0]['payment'];
                                            $sale_invoice_item_id = $paysii['id'];
                                            $invoice_amount = $paysii['part_invoice_amount'];
                                            $payment = $paysii[$key]['payment'];
                                            $outstanding = number_format($invoice_amount-$payment,2,'.','' );
                                        }
                                        
                                        $part_invoice_amount = number_format($invoice_amount+($invoice_amount*($tax/100)),2,'.','');
                                        
                                        
    		      $total_receipt_payment = 0;
    		    if(isset($invoice['Payments']) && count($invoice['Payments'])>0){
    		    
    		    if(isset($invoice['Payments']['Payment'][0])){
        		    // For multiple payments
        		    foreach($invoice['Payments']['Payment'] as $xero_invoice_payment){
        		       if(isset($xero_invoice_payment['PaymentID'])){
            		    
            	     	
                        if(isset($xero_invoice_payment['PaymentID'])){
                        $payment_id = $xero_invoice_payment['PaymentID'];
                        }
                        else{
                            $payment_id = 0;
                        }
                       
                        $cwhere = array('sale_invoice_id' => $invoice_id);
                        $receipt_info = $this->mod_common->select_single_records('project_sales_receipts', $cwhere);
                        
                        if(count($receipt_info)>0){
                            $cwhere = array('sales_receipt_id' => $receipt_info['id'], 'xero_payment_id' => $payment_id);
                            $is_already_paid = $this->mod_common->select_single_records('project_payment_history', $cwhere);
                        }
                        else{
                            $is_already_paid = array();
                        }
                            
                                        if(count($is_already_paid)==0){
                                       
                                        
                                	    $receipt_payment = $xero_invoice_payment['Amount'];
                                		$cwhere = array('sale_invoice_id' => $invoice_id);
                                        $is_existing = $this->mod_common->select_single_records('project_sales_receipts', $cwhere);
                                		if(count($is_existing)==0 ){
                                
                                            $receipt = array(
                                                'sale_invoice_id' =>$invoice_id,
                                                'payment' => $receipt_payment,
                                
                                            );
                                
                                            $receipt_id = $this->mod_common->insert_into_table('project_sales_receipts', $receipt);
                                            
                                             $receiptsaleinvoiceitem = array(
                                                'receipt_id' => $receipt_id,
                                                'sale_invoice_item_id' => $sale_invoice_item_id,
                                                'payment' => $receipt_payment,
                                
                                            );
                                
                                            $receiptsaleinvoiceitem_id = $this->mod_common->insert_into_table('project_sales_receipts_items', $receiptsaleinvoiceitem);
                                            
                                            
                                            $receipt_history = array(
                                                'sales_receipt_id' =>$receipt_id,
                                                'amount' => $receipt_payment,
                                                'xero_payment_id' => $payment_id,
                                
                                            );
                                
                                            $this->mod_common->insert_into_table('project_payment_history', $receipt_history);
                                            
                                            
                                            $total_receipt_payment +=$receipt_payment;
                                            
                                		}
                                		else{
                                		     $total_receipt_payment2 = $receipt_payment;
                                		     $update_receipt =  $this->saleinvoice->updatereceipt($is_existing['id'],$total_receipt_payment2);
                                		     
                                		     $cwhere = array('receipt_id' => $is_existing['id'],'sale_invoice_item_id' => $sale_invoice_item_id );
                                             $receiptitems = $this->mod_common->select_single_records('project_sales_receipts_items', $cwhere);
                                        
                                            $receiptitem=0;
                                
                                            if(count($receiptitems)){
                                                $receiptitem=$receiptitems['id'];
                                                $update_receiptitem=  $this->saleinvoice->updatereceiptitem($receiptitem, $receipt_payment);
                                                
                                                $receipt_history = array(
                                                'sales_receipt_id' =>$is_existing['id'],
                                                'amount' => $receipt_payment,
                                                'xero_payment_id' => $payment_id,
                                
                                                );
                                                $this->mod_common->insert_into_table('project_payment_history', $receipt_history);
                                                $total_receipt_payment +=$receipt_payment;
                                            }
                                		}
                                		
                                  }
                                  
                            
                            
        		        }
				
        		}
    		    }
    		    else{
                    if(isset($invoice['Payments']['Payment']['PaymentID'])){
                    $payment_id = $invoice['Payments']['Payment']['PaymentID'];
                   
                    $cwhere = array('sale_invoice_id' => $invoice_id);
                    $receipt_info = $this->mod_common->select_single_records('project_sales_receipts', $cwhere);
                    if(count($receipt_info)>0){
                    $cwhere = array('sales_receipt_id' => $receipt_info['id'], 'xero_payment_id' => $payment_id);
                    $is_already_paid = $this->mod_common->select_single_records('project_payment_history', $cwhere);
                    }
                    else{
                       $is_already_paid = array(); 
                    }
                    if(count($is_already_paid)==0){
                                
                        		$receipt_payment = $invoice['Payments']['Payment']['Amount'];
                        		$cwhere = array('sale_invoice_id' => $invoice_id);
                                $is_existing = $this->mod_common->select_single_records('sales_receipts', $cwhere);
                        			if(count($is_existing)==0 ){
                                
                                            $receipt = array(
                                                'sale_invoice_id' =>$invoice_id,
                                                'payment' => $receipt_payment,
                                
                                            );
                                
                                            $receipt_id = $this->mod_common->insert_into_table('project_sales_receipts', $receipt);
                                            
                                             $receiptsaleinvoiceitem = array(
                                                'receipt_id' => $receipt_id,
                                                'sale_invoice_item_id' => $sale_invoice_item_id,
                                                'payment' => $receipt_payment,
                                
                                            );
                                
                                            $receiptsaleinvoiceitem_id = $this->mod_common->insert_into_table('project_sales_receipts_items', $receiptsaleinvoiceitem);
                                            
                                            
                                            $receipt_history = array(
                                                'sales_receipt_id' =>$receipt_id,
                                                'amount' => $receipt_payment,
                                                'xero_payment_id' => $payment_id,
                                
                                            );
                                
                                            $this->mod_common->insert_into_table('project_payment_history', $receipt_history);
                                            
                                            
                                            $total_receipt_payment +=$receipt_payment;
                                            
                                		}
                                		else{
                                		     $total_receipt_payment2 = $receipt_payment;
                                		     $update_receipt =  $this->saleinvoice->updatereceipt($is_existing['id'],$total_receipt_payment2);
                                		     
                                		     $cwhere = array('receipt_id' => $is_existing['id'],'sale_invoice_item_id' => $sale_invoice_item_id );
                                             $receiptitems = $this->mod_common->select_single_records('project_sales_receipts_items', $cwhere);
                                        
                                            $receiptitem=0;
                                
                                            if(count($receiptitems)){
                                                $receiptitem=$receiptitems['id'];
                                                $update_receiptitem=  $this->saleinvoice->updatereceiptitem($receiptitem, $receipt_payment);
                                                
                                                $receipt_history = array(
                                                'sales_receipt_id' =>$is_existing['id'],
                                                'amount' => $receipt_payment,
                                                'xero_payment_id' => $payment_id,
                                
                                                );
                                                $this->mod_common->insert_into_table('project_payment_history', $receipt_history);
                                                $total_receipt_payment +=$receipt_payment;
                                            }
                                		}
                                }
                    else{
                        $total_receipt_payment = $is_already_paid["amount"];
                    }
                        }
    		    }
    		     
    		}
    		    // Allocation Process
    		
        		if(isset($invoice['CreditNotes']) && count($invoice['CreditNotes'])>0){
        		 
        		    if(isset($invoice['CreditNotes']['CreditNote'][0])){
        		      foreach($invoice['CreditNotes']['CreditNote'] as $xero_credit_note){
                		if(isset($xero_credit_note['CreditNoteID'])){
                		       $creditNoteDetails = $this->mod_common->select_single_records("project_sales_credit_notes", array("xero_creditnote_id" => $xero_credit_note['CreditNoteID']));
                    		     if(count($creditNoteDetails)>0){
                    		         $upd_array = array("allocated_invoice_id" => $invoice_detail['id']);
                    		         $this->mod_common->update_table("project_sales_credit_notes",  array("xero_creditnote_id" => $xero_credit_note['CreditNoteID']) , $upd_array);
                    		     }
                		      }
                		 }
        		    }
        		    else{
    
        		      $credit_note_id = $invoice['CreditNotes']['CreditNote']['CreditNoteID'];
        		      $creditNoteDetails = $this->mod_common->select_single_records("project_sales_credit_notes", array("xero_creditnote_id" => $credit_note_id));
        		     if(count($creditNoteDetails)>0){
        		         $upd_array = array("allocated_invoice_id" => $invoice_detail['id']);
        		         $this->mod_common->update_table("project_sales_credit_notes",  array("xero_creditnote_id" => $credit_note_id) , $upd_array);
        		         
        		        
        		     }
        		    }
        		}
        		else{
                		    $upd_array = array("allocated_invoice_id" => 0);
                            $this->mod_common->update_table("project_sales_credit_notes",  array("allocated_invoice_id" =>  $invoice_detail['id']) , $upd_array);
                		}
        		
                            		$cwhere = array('id' => $invoice_id);
                            	    $invoiceType = check_invoice_type($invoice_id);
                                    $credit_notes = get_sales_credit_notes($invoice_id, $invoiceType);
                                    $credit_notes_total = 0;
                                    foreach($credit_notes as $credit_note_detail){ 
                                        if($invoiceType == "CN-"){
                                            $credit_notes_total +=$credit_note_detail['total'];
                                        }
                                        else{
                                            $credit_notes_total = (-1)*$credit_note_detail['total'];
                                        }
                                        
                                    }
                                        	    
                            $result_arr2 =$this->saleinvoice->get_outstandingp_amount_by_sale_invoice_id($invoice_id);
                            $outstanding = 0;
                                        
                                    $outstanding =  number_format($result_arr2[0]['outstanding'] - $credit_notes_total, 2, ".", ""); 
                                    
                                    if($invoice['Status']=="PAID" && $invoice['AmountDue']==0.00){
                                        $salesinvoices_array = array(
                                                'status' => 'PAID',
                                                'payed_ammount' => $total_receipt_payment
                                            );
                                        
                                        $this->mod_common->update_table('project_sales_invoices', $cwhere, $salesinvoices_array);
                                    }
                                    else{
                                        $cwhere1 = array('id' => $invoice_id, 'status !=' => 'PAID');
                                        $salesinvoices_array = array(
                                                'status' => 'APPROVED',
                                                'payed_ammount' => $total_receipt_payment
                                            );
                                        
                                        $this->mod_common->update_table('project_sales_invoices', $cwhere1, $salesinvoices_array);
                                    }
    		}
            }
		}
		
        }
    }

   }
   
    public function delete_db_backup_files(){
        $month = date('m');
        $month = $month-1;
        $folder_path = "database_backup";
       
        // List of name of files inside
        // specified folder
        $files = glob($folder_path.'/*'); 
           
        // Deleting all the files in the list
        foreach($files as $file) {
           
            if(is_file($file)) 
            $file_name = explode("_", $file);
            
            $desired_file_name = explode("-", $file_name[2]);
            if($desired_file_name[1] < $month){
                //Delete the given file
                unlink($file);
            }
                
        }
   }
}
