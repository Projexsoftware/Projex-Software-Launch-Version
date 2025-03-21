<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_store extends CI_Controller {

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
             $this->load->model("mod_onlinestore");

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(150);

    }
    
    //Online Store
    public function index($pagenumber="")
	{
	    $this->mod_common->is_company_page_accessible(150);
        
        $this->stencil->title('Online Store');
        $data['suppliers'] = $this->mod_common->get_all_records("suppliers", "*" ,0 , 0, array("supplier_status" => 1, "parent_supplier_id" => 0),"supplier_id");
        $data['categories'] = $this->mod_common->get_all_records("categories", "*" ,0 ,0, array("status" => 1),"name");
        $data['total_products'] =  $this->mod_common->get_all_records("project_components", "*" ,0 ,0, array("component_status" => 1, "list_this_component_in_online_store" =>1), "component_id");
        $config["base_url"] = SURL . "online_store/";
        $config['total_rows'] = $data['total_rows'] = count($data['total_products']);
        $ppage = $config["per_page"] = 12;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 2;


        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '< Previous';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next >';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#" data-ci-pagination-page="1">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $data['numcounter'] = 1;
        if ($pagenumber > 0) {
            $pagenumber = $pagenumber - 1;
            $data['numcounter'] = ($pagenumber * 2) + 1;
            $llimit = ($ppage * $pagenumber);
            $ulimit = ($ppage * $pagenumber) + $ppage;
        }
        if ($pagenumber == 0 || $pagenumber=="") {
            $llimit = 0;
            $ulimit = $ppage;
        }

  
        $data["links"] = $this->pagination->create_links();
            
        $data['products'] = $this->mod_common->get_all_records("project_components", "*" ,$llimit ,$ppage, array("component_status" => 1, "list_this_component_in_online_store" =>1), "component_id");
        
	    $this->stencil->paint('online_store/home', $data);
	}
	
	public function search($pagenumber="")
	{
	    $this->mod_common->is_company_page_accessible(150);
	    $column = "";
	    $order = "";
	    $type = $this->input->post("type");
	    if($type!=""){
	        if($type == "price"){
	            $column = "project_components.sale_price";
	            $order = "ASC";
	        }
	        else if($type == "price-desc"){
	            $column = "project_components.sale_price";
	            $order = "DESC";
	        }
	        else if($type == "category"){
	            $column = "project_components.component_category";
	            $order = "ASC";
	        }
	        else if($type == "supplier"){
	            $column = "project_suppliers.supplier_name";
	            $order = "ASC";
	        }
	        else{
	            $column = "project_components.component_id";
	            $order = "DESC";
	        }
	    }
	    $categories = $this->input->post("categories")!=""?$this->input->post("categories"):array();
	    $suppliers = $this->input->post("suppliers")!=""?$this->input->post("suppliers"):array();
        
        $data['total_products'] =  $this->mod_onlinestore->filter_products($categories, $suppliers, 0, 0, $column, $order);
        $config["base_url"] = SURL . "online_store/search/";
        $config['total_rows'] = $data['total_rows'] = count($data['total_products']);
        $ppage = $config["per_page"] = 12;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 2;


        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '< Previous';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next >';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#" data-ci-pagination-page="1">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $data['numcounter'] = 1;
        if ($pagenumber > 0) {
            $pagenumber = $pagenumber - 1;
            $data['numcounter'] = ($pagenumber * 2) + 1;
            $llimit = ($ppage * $pagenumber);
            $ulimit = ($ppage * $pagenumber) + $ppage;
        }
        if ($pagenumber == 0 || $pagenumber=="") {
            $llimit = 0;
            $ulimit = $ppage;
        }

  
        $data["links"] = $this->pagination->create_links();
            
        $data['products'] = $this->mod_onlinestore->filter_products($categories, $suppliers, $ppage, $llimit, $column, $order);
        
	    $this->load->view('online_store/products_ajax', $data);
	}
	public function filter_supplierz_users(){
	    $keyword = $this->input->post("keyword");
	    $data['supplierz_users'] = get_supplierz_users($keyword);
	    $this->load->view("online_store/supplierz_users_ajax", $data);
	    
	}
	public function filter_categories(){
	    $keyword = $this->input->post("keyword");
	    $data['categories'] = get_categories($keyword);
	    $this->load->view("online_store/categories_ajax", $data);
	    
	}
	public function details($id) {
        $table = "project_components";
        $where = "`component_id` ='" . $id . "' AND list_this_component_in_online_store = 1";

        $data['product'] = $this->mod_common->select_single_records($table, $where);
        $data['options'] = $this->mod_common->get_all_records("project_component_options", "*", 0, 0, array("component_id" => $id));
        

        $this->stencil->title("Product Details");
        $this->stencil->paint('online_store/product_details', $data);
    }
    public function cart() {
        $this->stencil->title("Cart");
        $data['user_info'] = $this->mod_common->select_single_records("users",array("user_id" => $this->session->userdata('user_id')));
        $this->stencil->title("My Cart");
        $this->stencil->paint('online_store/view_cart', $data);
    }
    public function wishlist(){
        $this->stencil->title("My Wishlist");
        $this->stencil->paint('online_store/wishlist');
    }
    
    public function add_to_wishlist() {
            $id = $this->input->post("id");
            $product_details = $this->mod_common->select_single_records("project_components", array("component_id" => $id));
            $data = array(
                'id' =>     $id,
                'supplier' => $product_details["supplier_id"],
                'qty' => 1,
                'price' => $product_details["sale_price"],
                'name' => $product_details["component_name"],
                'image' => $product_details["image"],
                'category' => $product_details["component_category"],
                'supplierz' => $product_details["company_id"],
            );
        $rowid = $this->wishlist->insert($data);
        if ($rowid) {
            $response = array("wishlist_items" => $this->wishlist->total_items(), "wishlist_rowid" => $rowid);
            echo json_encode($response);
        } else {
            echo "fail";
        }
    }
    
    public function remove_wishlist_ajax() {
        $id = $this->input->post("id");
        $item = $this->wishlist->get_item($id);
        $this->wishlist->remove($id);
        $response = array("wishlist_items" => $this->wishlist->total_items() , "wishlist_rowid" => $item["id"]);
        echo json_encode($response);
    }
    function remove_wishlist($id) {
        $this->wishlist->remove($id);
        $this->session->set_flashdata('ok_message', 'Product has been removed from wishlist successfully!');
        redirect(SURL . 'online_store/wishlist');
    }
    
    function add_to_cart() {
        
            $id = $this->input->post("id");
            
            $data = array(
                'id' =>     $this->input->post('id'),
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'qty' => ($this->input->post('quantity')==""?"1":$this->input->post('quantity')),
                'category' => $this->input->post('category'),
                'supplier' => $this->input->post('supplier'),
                'supplierz' => $this->input->post('supplierz'),
                'image' => $this->input->post('image')
            );
        $this->cart->product_name_rules = '[:print:]';
        if ($this->cart->insert($data)) {
            $cart_items = '<ul class="cart_list">';
            
            foreach ($this->cart->contents() as $items):
                $cart_items .='<li><a href="'.SURL.'online_store/remove_cart/'.$items['rowid'].'" class="item_remove"><i class="ion-close"></i></a><a href="'.SURL.'online_store/details/'.$items['id'].'"><img src="'.COMPONENT_IMG.$items['image'].'" alt="'.$items['name'].'">'.$items['name'].'</a><span class="cart_quantity"> '.$items["qty"].' x ';
                
                                        
                        $cart_items .= '<span class="cart_amount"><span class="price_symbole">'.CURRENCY.'</span>'.$this->cart->format_number($items['price']).'</span>';
                
                 
                $cart_items .= '</li>';
            endforeach;
            $cart_items .='</ul><div class="cart_footer">
                                <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">'.CURRENCY.'</span></span>'.$this->cart->format_number($this->cart->total()).'</p>
                                
                                <p class="cart_buttons"><a href="'.SURL.'online_store/cart" class="btn btn-sm btn-success view-cart">VIEW CART</a>
                                <a href="'.SURL.'online_store/checkout" class="btn btn-sm btn-warning checkout">CHECKOUT</a>
                                </p>
                            </div>';
            $response = array("cart_items_count" => $this->cart->total_items(), "cart_total" => $this->cart->format_number($this->cart->total()), "cart_items" => $cart_items);
            echo json_encode($response);
        } else {
            echo "fail";
        }
    }
	
	function remove_cart($id) {
        $this->cart->remove($id);
        $this->session->set_flashdata('ok_message', 'Product has been removed from cart successfully!');
        redirect(SURL . 'online_store/cart');
    }
    
     function update_cart() {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('quantity');
        $product = $this->input->post('product');
        for ($i = 0; $i < count($rowid); $i++) {
                $data = array(
                'rowid' => $rowid[$i],
                'qty' => $qty[$i],
            );
        
            $this->cart->update($data);
        }
            $this->session->set_flashdata('ok_message', 'Cart updated successfully!');
        
        redirect(SURL . 'online_store/cart');
    }
    
    function empty_cart() {
        $this->cart->destroy();
        redirect(SURL . 'online_store/cart');
    }
    
    public function checkout(){

        if(!empty($this->cart->contents())){
        $data['user_info'] = $this->mod_common->select_single_records("project_users",array("user_id" => $this->session->userdata('company_id')));
        $this->stencil->title("Checkout");
        $this->stencil->paint('online_store/checkout', $data);
         }
         else{
             redirect(SURL.'online_store');
         }
    }
    
    function thankyou(){
        if($this->session->userdata('order_no_')!=""){
        $this->stencil->title('Thankyou');
        $this->stencil->paint('online_store/thankyou');
        }
        else{
            return redirect(SURL.'online_store');
        }
        
    }
    
    function your_order() {
        
        $post = $this->input->post();
        
        if(count($post)>0){
            
            $customer_id = $this->session->userdata("company_id");
            
            if($customer_id == ""){
                redirect(SURL."online_store/checkout");
            }
              
            
                   $checkout = random_code_generator(10,1);
                   $no_of_orders = $this->mod_common->get_all_records("project_online_store_orders", "MAX(order_no) as order_no");
                   $order_no = $no_of_orders[0]['order_no'] + 1;
            
                $total = $this->cart->total();
            
            $ins_array = array(
                'user_id' => $customer_id,
                'first_name' => $this->input->post('fname'),
                'last_name' => $this->input->post('lname'),
                'address' => $this->input->post('address'),
                'company_name' => $this->input->post('cname'),
                'mobile_no' => $this->input->post('phone'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zipcode' => $this->input->post('zipcode'),
                'email' => $this->input->post('email'),
                'ship_to_a_different_address' => ($this->input->post('differentaddress'))?$this->input->post('differentaddress'):0,
                'shipping_address' => ($this->input->post('shipping_address'))?$this->input->post('shipping_address'):$this->input->post('address'),
                'shipping_first_name' => ($this->input->post('shipping_fname'))?$this->input->post('shipping_fname'):$this->input->post('fname'),
                'shipping_last_name' => ($this->input->post('shipping_lname'))?$this->input->post('shipping_lname'):$this->input->post('lname'),
                'shipping_company_name' => ($this->input->post('shipping_cname'))?$this->input->post('shipping_cname'):$this->input->post('cname'),
                'shipping_state' => ($this->input->post('shipping_state'))?$this->input->post('shipping_state'):$this->input->post('state'),
                'shipping_city' => ($this->input->post('shipping_city'))?$this->input->post('shipping_city'):$this->input->post('city'),
                'shipping_zipcode' => ($this->input->post('shipping_zipcode'))?$this->input->post('shipping_zipcode'):$this->input->post('zipcode'),
                'comments' => $this->input->post('order_notes'),
                'order_no' => $order_no,
                'total' => $total,
                'checkout' => $checkout[0],
                'status' => 1
            );
            
            
            if ($this->db->insert('project_online_store_orders', $ins_array)) {
                
                $insert_id = $this->db->insert_id();
                $supplierz_id = array();
                foreach($this->cart->contents() as $items){
                    if(!in_array($items['supplierz'], $supplierz_id)){
                      $supplierz_id[] = $items['supplierz'];
                    }
                    $ins_array = array(
                     'item_id' => $items['id'],
                     'item_category' => $items['category'],
                     'item_image' => $items['image'],
                     'item_name' => $items['name'],
                     'item_quantity' => $items['qty'],
                     'item_price' => $items['price'],
                     'item_supplier' => $items['supplier'],
                     'item_subtotal' => $items['subtotal'],
                     'order_no' => $order_no,
                     'supplierz_id' => $items['supplierz']
                    );
                 $this->db->insert('project_online_store_order_items', $ins_array);
                 if(file_exists('assets/components/'.$items['image'])){
                    copy('assets/components/'.$items['image'], 'assets/online_store_orders/'.$items['image']);
                 }
                }
                 $this->session->set_userdata('insert_id', $insert_id);
                 
                    $ins_array_['user_id']        = $customer_id;
                    $ins_array_['payment_type'] = $this->input->post('payment_option');
                    $ins_array_['order_no'] =  $order_no;
                    $ins_array_['txn_id']            = 'NA';
                    $ins_array_['payment_gross']    = $total;
                    $ins_array_['currency_code']    = CURRENCY;
                    $ins_array_['payer_email']    = $this->input->post('email');
                    $ins_array_['payment_status'] = 'Pending';
                    $this->db->insert("project_online_store_order_payments", $ins_array_);
                
                $notification_array = array(
                         "notification_text" => "You have a new order request (checkout #".$checkout[0].")",
                         "notification_type" => 1,
                         "order_no" => $order_no,
                         "user_id" => 0
                );
                 
                $this->db->insert('project_scheduling_notifications', $notification_array);
                
                if(count($supplierz_id)>0){
                for($i=0;$i<count($supplierz_id);$i++){
                     $notification_array = array(
                     "notification_text" => "You have a new order request (checkout #".$checkout[0].")",
                     "notification_type" => 1,
                     "order_no" => $order_no,
                     "user_id" => $supplierz_id[$i]
                    );
                    $this->db->insert('project_scheduling_notifications', $notification_array);
                }
            }
                
                $notification_array = array(
                         "notification" => "placed this order on Online Store (checkout #".$checkout[0].").",
                         "notification_type" => 0,
                         "order_no" => $order_no,
                         "user_id" => $this->session->userdata("company_id")
                );
                $this->db->insert('project_notifications', $notification_array);
            
            $order = $this->mod_common->select_single_records("project_online_store_orders", array("id"=>$this->session->userdata('insert_id')));
            
            if($customer_id!="" && $this->input->post('email')){
            $data['order_no'] = $order['order_no'];
            $data['firstname'] = $order['first_name'];
            $data['created_date'] = $order['order_received_date'];
            $subject = "Order Confirmation";
                                                   
    
    		                                $message = $this->load->view("email_templates/confirm_order_template", $data, TRUE); 
    
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
                                                $this->email->to($order['email']);
                                                $this->email->from("info@wizard.net.nz");
                                                $this->email->subject($subject);
                                                $this->email->message($message);
    		                                    $this->email->send();
                                                if(count($supplierz_id)>0){
                for($i=0;$i<count($supplierz_id);$i++){
                    $supplierz_info = $this->mod_common->select_single_records("project_users", array("user_id" => $supplierz_id[$i]));
                                                    //Send To Admin
                                                    $subject = "New Order Request";
                                                   
                                                    $data['order_no'] = $order['order_no'];
                                                    $data['firstname'] = $order['first_name'];
                                                    $data['lastname'] = $order['last_name'];
                                                    $data['created_date'] = $order['order_received_date'];
                                                    $data['address'] = $order['address'];
                                                    $data['city'] = $order['city'];
                                                    $data['state'] = $order['state'];
                                                    $data['company_name'] = $order['company_name'];
                                                    $data['mobile_no'] = $order['mobile_no'];
                                                    $data['email'] = $order['email'];
    
    		                                        $message = $this->load->view("email_templates/supplierz_order_template", $data, TRUE); 
                                                    $this->email->to($supplierz_info["user_email"]);
                                                    $this->email->from($order['email']);
                                                    $this->email->subject($subject);
                                                    $this->email->message($message);
    		                                $this->email->send();
                                            $notification_array = array(
                                                     "notification" => "Order confirmation email was sent to",
                                                     "notification_type" => 1,
                                                     "order_no" => $order_no,
                                                     "user_id" => $this->session->userdata("company_id")
                                            );
                                            $this->db->insert('project_notifications', $notification_array);
            }
                }
            }
            
            $data['thankyou_content'] = $order['order_no'];
            $this->cart->destroy();
            
            $this->session->set_userdata('order_no_', $data['thankyou_content']);
            echo SURL."online_store/thankyou";
            }
         }
        else{
          redirect(SURL."online_store");
        }
       
    }
	
}
