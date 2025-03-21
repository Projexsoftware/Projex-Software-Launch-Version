<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xero_cron_job extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('mod_common');
		$this->load->library('xero');
		
    }
    
    function index(){
        redirect(SURL."nopage");
    }
    
    //Refresh Xero Token Automatically
    function refreshXeroToken(){
        	$accounts = $this->mod_common->get_all_records("xero_settings");
        	 if(count($accounts)){
            	 foreach($accounts as $val){
            	     require './vendor/autoload.php';
    
                     $clientId = $val["client_id"];
                     $clientSecret = $val["client_secret"];
                     
            	     $provider = new \League\OAuth2\Client\Provider\GenericProvider([
                        'clientId'                => $clientId,   
                        'clientSecret'            => $clientSecret,
                        'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
                        'urlAccessToken'          => 'https://identity.xero.com/connect/token',
                        'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Invoices'
                    ]);
                          
                    $newAccessToken = $provider->getAccessToken('refresh_token', [
                        'refresh_token' => $val["refresh_token"]
                    ]);
                    $updatedToken = $newAccessToken->getToken();
                    $updatedRefreshToken = $newAccessToken->getRefreshToken();
                    $upd_array = array(
                        "access_token" => $updatedToken,
                        "refresh_token" => $updatedRefreshToken,
                    );
                    $this->db->where('id', $val["id"]);
                    $this->db->update("xero_settings", $upd_array);
                    
                    $this->db1 = $this->load->database('boom', true); 
                    $upd_array = array(
                        "access_token" => $updatedToken,
                        "refresh_token" => $updatedRefreshToken,
                    );
                    $this->db1->where('id', 3);
                    $this->db1->update("xero_settings", $upd_array);
                    
            	 }
        	 }
        }
}