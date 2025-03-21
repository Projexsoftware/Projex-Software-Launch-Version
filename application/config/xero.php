<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$xero_credentials = get_xero_credentials();

if(count($xero_credentials)>0){
        $config = array(
            "client_id" => $xero_credentials['client_id'],
            "client_secret" => $xero_credentials['client_secret'],
            "access_token" => $xero_credentials['access_token'],
            "xero_tenant_id" => $xero_credentials['xero_tenant_id'],
            "tracking_category_id" => $xero_credentials['tracking_category_id'],
            "format"    => 'json'
          );
}
else{
   $config = array(
            "client_id" => "",
            "client_secret" => "",
            "access_token" => "",
            "xero_tenant_id" => "",
            "tracking_category_id" => "",
            "format"    => 'json'
          );
}