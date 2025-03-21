<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xero_settings extends CI_Controller {

	public function __construct() {
             parent::__construct();

            $this->stencil->layout('default_layout');

             $this->stencil->slice('header_script');
             $this->stencil->slice('header');
             $this->stencil->slice('sidebar');
             $this->stencil->slice('footer_script');
             $this->stencil->slice('footer');

             $this->load->model("mod_common");

             $this->mod_common->verify_is_user_login();

    }
    
    //Xero Configuration Page
    
    function index(){
        
        $this->mod_common->is_company_page_accessible(124);
        
		$this->stencil->title('Xero Settings');
		
		$where 	= array("company_id" => $this->session->userdata('company_id'));
		$data['xero_settings'] 	= $this->mod_common->select_single_records('xero_settings',$where);
		
		if(isset($data['xero_settings']) && count($data['xero_settings'])==0){
		    $this->stencil->paint('xero_settings/set_xero_settings',$data);
		}
		else{
	        $this->stencil->paint('xero_settings/xero_settings',$data);
		}
    }
	
    //Update Xero Credentials
	public function update_credentials()
	{
	    
		$this->mod_common->is_company_page_accessible(124);
		
		$client_id = $this->input->post('client_id');
		$client_secret = $this->input->post('client_secret');
		$xero_tenant_id = $this->input->post('xero_tenant_id');
		$access_token = $this->input->post('access_token');
		$refresh_token = $this->input->post('refresh_token');
		
	             	$xero_array = array(
					'client_id'	=> rtrim($client_id, " "),
				    'client_secret'	=> rtrim($client_secret, " "),
					'xero_tenant_id'=> rtrim($xero_tenant_id, " "),
					'access_token'	=> rtrim($access_token, " "),
					'refresh_token'	=> rtrim($refresh_token, " "),
					'company_id'	=>$this->session->userdata('company_id')
					);
					
		$where 	= 'company_id ="'. $this->session->userdata('company_id').'"';
		
		$data['xero_settings'] 	= $this->mod_common->select_single_records('xero_settings',$where);
			
		if(count($data['xero_settings'])==0){			
		$id = $this->mod_common->insert_into_table('xero_settings', $xero_array);
		}
		else{
		    $where 	= array('company_id' => $this->session->userdata('company_id'));
			$this->mod_common->update_table('xero_settings',$where,$xero_array);
		}
		$this->session->set_flashdata("ok_message", "Xero Settings Updated Successfully!");
								
		redirect(SURL."xero_settings");
						
	}
	
	//Get Token, Refresh Token and Xero Tenant ID from Xero
	public function getToken(){
	    
	    require './vendor/autoload.php'; 
	    if($this->input->post("client_id")){
	        $this->session->set_userdata("clientID", $this->input->post("client_id"));
	    }
	     if($this->input->post("client_secret")){
	        $this->session->set_userdata("clientSecret", $this->input->post("client_secret"));
	    }

        $clientId = $this->session->userdata("clientID");
        $clientSecret = $this->session->userdata("clientSecret");
        
        $redirectUri = SURL.'xero_settings/getToken';
        
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $clientId,   
            'clientSecret'            => $clientSecret,
            'redirectUri'             => $redirectUri,
            'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
            'urlAccessToken'          => 'https://identity.xero.com/connect/token',
            'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Invoices'
        ]);



    // If we don't have an authorization code then get one
    // If we don't have an authorization code then get one
    if (!isset($_GET['code'])) {
    
        $options = [
        	'scope' => ['openid email profile offline_access accounting.transactions accounting.settings']
        ];
    
        // Fetch the authorization URL from the provider; this returns the
        // urlAuthorize option and generates and applies any necessary parameters (e.g. state).
        $authorizationUrl = $provider->getAuthorizationUrl($options);
    
        // Get the state generated for you and store it to the session.
        $_SESSION['oauth2state'] = $provider->getState();
    
        // Redirect the user to the authorization URL.
        header('Location: ' . $authorizationUrl);
        exit();
    
    // Check given state against previously stored one to mitigate CSRF attack
    } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        exit('Invalid state');
    
    // Redirect back from Xero with code in query string param
    } else {
        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            
            // We have an access token, which we may use in authenticated requests 
            // Retrieve the array of connected orgs and their tenant ids.      
            $options['headers']['Accept'] = 'application/json';
            $connectionsResponse = $provider->getAuthenticatedRequest(
                'GET',
                'https://api.xero.com/Connections',
                $accessToken->getToken(),
                $options
            );
    
            $xeroTenantIdArray = $provider->getParsedResponse($connectionsResponse);
                            
    	    $xero_array = array(
    					'client_id'	=> rtrim($clientId, " "),
    				    'client_secret'	=> rtrim($clientSecret, " "),
    					'xero_tenant_id'=> rtrim($xeroTenantIdArray[0]['tenantId'], " "),
    					'access_token'	=> rtrim($accessToken->getToken(), " "),
    					'refresh_token'	=> rtrim($accessToken->getRefreshToken(), " "),
    					'tracking_category_id'	=>"",
    					'company_id'	=>$this->session->userdata('company_id')
    					);
    					
    		$where 	= 'company_id ="'. $this->session->userdata('company_id').'"';
    		
    		$data['xero_settings'] 	= $this->mod_common->select_single_records('xero_settings',$where);
    			
    		if(count($data['xero_settings'])==0){			
    		$id = $this->mod_common->insert_into_table('xero_settings', $xero_array);
    		}
    		else{
    		    $where 	= array('company_id' => $this->session->userdata('company_id'));
    			$this->mod_common->update_table('xero_settings',$where,$xero_array);
    		}
    		
    		// Create Tracking Category
    		
    		$this->load->library('xero');
    		
    		$company_info = get_company_info();
    		
    		$tracking_name =  array("Name" => $company_info['com_name']);
                            
            $tracking_category = $this->xero->AddTrackingCategory($tracking_name); 
            
            $where 	= array('company_id' => $this->session->userdata('company_id'));
    		$this->mod_common->update_table('xero_settings', $where, array("tracking_category_id"=>$tracking_category['TrackingCategories']['TrackingCategory']['TrackingCategoryID'], "tracking_category_name" => $tracking_category['TrackingCategories']['TrackingCategory']['Name']));
                            
                            
    		$this->session->set_flashdata("ok_message", "Xero has been configured Successfully!");
    								
    		redirect(SURL."xero_settings");
    	}
        catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token or user details.
                $this->session->set_flashdata("err_message", $e->getMessage());
                redirect(SURL."xero_settings");
        }
    	
    }
}

   //Delete Xero Account
    public function delete_account() {
  
        $this->mod_common->is_company_page_accessible(124);
		
		$id = $this->input->post('id');
		
        if($id==""){
            redirect("nopage");
        }
		
	    $table = "project_xero_settings";
        $where = "`id` ='" . $id . "'";
		
        $this->mod_common->delete_record($table, $where);

    }

}

