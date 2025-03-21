<!doctype html>
<html lang="en">
<head>
<title>Purchase Order For <?php echo $order_detail->supplier_name?></title>
<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">   
    <!-- Endless -->
<style>
body{
    font-family:"century-gothic", sans-serif!important;
}
   tr:nth-child(odd) td{
       background-color: #f9f9f9!important;
   }
.table_pro_name{ text-align:center; width:100%;padding:10px 0}
.tab_info{
  float: right;
}
.tab_info tr td{
  background: none !important;
  font-size: 14px;
  border: none !important;
  padding-top:0px!important;
}
.tab_info tr td h5{
  background: none !important;
  font-size: 17px !important;
  padding-bottom:0px!important;
  padding-top:0px!important;
}
.desktop_logo {
  float: left;
  width: 30% !important;
}

.po_project_container{
        border:2px solid gray; 
        padding:10px 20px!important;
    } 
    .po_details_container{
        text-align:center; 
        border:2px solid gray; 
        margin-bottom:20px;
    }
    
    #termandcond{font-size: 12px}
    #termandcond h3{
        font-weight:bold;
    }
    .po_details_container h3{
        font-size:24px!important;
        margin-top: 20px!important;
        margin-bottom: 10px!important;
    }
    #termandcond {
    padding: 8px 20px;
    border: 1px solid gray;
    color: #000000;
    margin: 8px 0;
    }
    .table{
        width:100%;
        margin-top:25px;
        border-spacing: 0px;
    }
    table th, table td{
    padding: 12px 8px!important;
    vertical-align: middle;
    line-height: 1.42857143;
    border: 1px solid #000000!important;
    text-align:left!important;
    
    }
    table th{
         background-color: #f0f0f0!important;
    }
    .porder
{
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif!important;
    font-size: 14px!important;
    color: #333!important;
}
#porderpanel, #termandcond {
    padding: 5px;
    border: 1px solid gray;
    color: #000000;
    margin: 8px 0;
}
#porderpanel h3{
    font-size:24px;
    margin-top: 20px;
    margin-bottom: 10px;
}
.col-md-6{
                    float:left;
                    width:48%;
                }
table{
    width:100%!important;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif!important;
                        	    }
								table tr th, table tr td {
									border: 1px solid #000000!important;
									padding: 12px 8px!important;
								}
								table tr th {
								    font-weight: normal;
                                    color: #555;
                                    border: none;
                                    background-color: #f0f0f0;
								}

</style>
</head>
<body>
<div id="main-container" class="porder">    
  <div class="padding-md">   
    <?php if($company_info["com_logo"]!=""){ ?>
                                                <div class="row">
                                                    <div class="col-md-6">
    <img style="width:100%;" src="<?php echo trim(SURL).'/assets/company/thumbnail/'.trim($company_info["com_logo"]);?>">
  </div>
  <div class="col-md-6">
   <table class="table tab_info" align="right">
     <tr>
        <td><h4><?php echo $company_info["com_name"];?></h4></td>
     </tr>
     <tr>
       <td><p><img style="width:16px;" src="<?php echo SURL.'/assets/icons/grid-world.png';?>"> <?php echo $company_info["com_website"];?></p></td>
     </tr>
      <tr>
       <td><p><img style="width:16px;" src="<?php echo SURL.'/assets/icons/envelope.png';?>"> <?php echo $company_info["com_email"];?></p></td>
     </tr>
      <tr>
       <td><p><img style="width:16px;" src="<?php echo SURL.'/assets/icons/telephone-handle-silhouette.png';?>"> <?php echo $company_info["com_phone_no"];?></p></td>
     </tr>
   </table>
  </div>
                                                </div>
                                                <?php } else{ ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-3 homeworx_logo">
                                                        <img src="<?php echo SURL; ?>assets/img/homeworx_logo.png">
                                                    </div>
                                                </div>
                                                <?php } ?>
<div id="porderpanel">
    <div class="grey po_details_container">
                                
                                <h3>Purchase Order For <?php echo $order_detail->supplier_name?></h3>
                                <p>
                                    Chango Limited Trading as Homeworx, 336 Meeanee Road, Napier
                                    P: 06 843 8834 E: Info@homeworx.co.nz
                                </p>
                            </div>
                        
                        <div class="col-md-12 po_project_container">
                        <div class="col-md-12"><b>Project Name:</b> &nbsp;  <?= $projectinfo['project_title']?> </div>
                         <div class="col-md-12"><b>Project Adddress:</b> &nbsp;  <?= $projectinfo['street_pobox'].",".$projectinfo['suburb'].", ".$projectinfo['project_address_city'].", ".$projectinfo['project_address_state'].", ".$projectinfo['project_address_country'].", ".$projectinfo['project_zip'] ?> </div>
    </div>
    <div class="project_report_container">
                <table class="table table-bordered" >
                    <tr>
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">PO Number</th>  
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">Stage</th>  
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">Part</th>  
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">Component</th>  
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">Supplier</th> 
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">QTY</th>
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">Including in project costing or variation</th>
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">UOM</th>
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">Comments</th>
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">COST</th>  
                      <th style="background-color: #f0f0f0!important;border:1px solid #000000!important;">TOTAL</th> 

                  </tr>
                   <?php foreach ($order_items AS $pt => $pts): ?>
                    <tr>
  
                        <td ><?php echo $pts['purchase_order_id']?></td>    
                        <td ><?php echo $order_detail->supplier_name?></td>  
                        <td ><?php echo $pts['stage_name']?></td>  
                        <td ><?php echo $pts['part_name']?></td>  
                        <td ><?php echo $pts['component_name']?></td>  
                        <td ><?php echo number_format($pts['order_quantity'],2)?></td>  
                        <td><?php if($pts['costing_part_id']) { echo "Yes"; } else { "No"; } ?></td>
                        <td ><?php echo $pts['costing_uom']?></td>
                        <td><?php echo $pts['comment'];?></td>
                        <td><?php echo $pts['costing_uc']?></td>  
                        <td><?php echo number_format($pts['costing_uc']*$pts['order_quantity'],2)?></td>  
                    </tr>

                <?php endforeach; ?>              
                    
                </table>
                <div id="termandcond">
                            <h3>TERMS AND CONDITIONS</h3>
                            <?php 
                            $get_terms_and_conditions_for_company =  get_terms_and_conditions_for_company();
                            if($get_terms_and_conditions_for_company){
                                echo $get_terms_and_conditions_for_company;
                            }else{
                            ?>
                            <p><strong>Licensed Building Practitioner: </strong>Please ensure you are aware of all obligations including providing relevant LBP License classes for restricted building work.</p>
                            <p><strong>Health and Safety: </strong>You must comply with all relevant Health and Safety Regulations and ALL site specific site safety requirements including site induction. If you are unsure of your obligations contact the Homeworx office or your Health and Safety advisor. NO DOGS ARE PERMITTED ON SITE.</p>
                            <p><strong>Waste Management: </strong>You are responsible for maintaining a clean and safe working environment. This includes cleaning up regularly after your work (including sweeping up any mud tracked inside) and removal of all waste from materials that you supplied to site.</p>
                            <p><strong>Project Schedule: </strong>Refer to the attached project schedule for the anticipated date you are required. This is a fluid document and updates will be available during construction. Please advise the Homeworx office if you are unavailable at the scheduled time.</p>
                            <p><strong>Substitutions: </strong>Absolutely no substitutions allowed without prior written approval of the designer and Homeworx Office. </p>
                            <p><strong>Invoicing and Payment: </strong>
                            Please note the following requirements to avoid processing delays:<br/>
                            <ol>
                                <li>All invoices require a Purchase Order. PO’s will be issued at the time of acceptance of your quote.</li>
                                <li>Additional works and variations will require a PO Number. This should be obtained from the Homeworx Office by emailing info@homeworx or by phone.</li>
                                <li>Our payment terms are payment on the 20th month following, for invoices received by end of previous month (with valid purchase order). Invoices can be delivered by post to PO Box 3394, HB Mail Centre 4142 or emailed to invoice@homeworx.co.nz. </li>
                                <li>Invoices are subject to approval based on the amount claimed, work completed/goods supplied, acceptable quality and supply of warranty documentation/LBP memorandum.</li>
                                <li>We need to clearly demonstrate any additional costs to our clients, hence any additional works must be clearly itemised on a separate invoice.</li>
                            </ol>  
                            </p>
                            <p><strong>Compliance and Warranty Documents: </strong>Please supply all relevant documentation eg. Warranty, LBP memorandum, as-builts, producer statements, etc. with your final invoice.</p>
                            <?php }?>
                        </div>
            </div>
</div>
        
    </div>
</div>
</body>
</html>
