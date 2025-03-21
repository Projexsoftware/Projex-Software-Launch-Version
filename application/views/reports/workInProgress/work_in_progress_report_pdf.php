<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
/*.pro_address{ width:100%;}

 .print_table th{   background-color: rgba(194, 196, 197, 0.5) !important;
    color: #000 !important;}
	tr td{background-color:#ccc;font-size:16px;}
	tr td{padding:10px;}
   td {
    border: 1px solid #eee!important;
	
   }*/
   .pro_title{
       padding:10px 0px;
	   background-color:#f56700!important;
	   color:#fff!important;
	   text-align:center!important;
	   font-size:18px;
	   margin-bottom:2px;
   }
   .pro_subtitle{
       padding:10px 0px;
	   background-color:#f56700!important;
	   color:#fff!important;
	   text-align:center!important;
	   font-size:16px;
	   margin-bottom:2px;
   }
   .text-right{
       text-align:right;
   }
   th{
	   text-align:center!important;
   }
   td {
    border: 1px solid #eee!important;
	padding:10px;
   }
   tr:nth-child(odd) td{
	   background-color: #f9f9f9!important;
   }
.col-md-6{
    float:left;
    width:45%;
}
.tab_info tr td{
  background: none !important;
  font-size: 14px;
  line-height: 5px !important;
  border: none !important;
}
.tab_info tr td h5{
  background: none !important;
  font-size: 17px !important;
}
.desktop_logo {
  float: left;
  width: 30% !important;
}
</style>

<div id="row">
   <div class="col-sm-12"><div style="text-align:right;"><img style="width:16px;" src="<?php echo SURL .'/assets/icons/calendar.png';?>"> <?php echo date('d M Y');?></div></div>
    
   <div class="col-sm-12">
     <h3 class="table_pro_name">Work in Progress Report</h3>
   </div>
 </div>
<div id="row">
    <div class="col-md-12">
   <div class="col-md-6">
    <img style="width:100%;height:100px;" src="<?php echo trim(SURL).'/assets/company/'.trim($company_info["com_logo"]);?>">
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
     <div class="col-sm-12">
       <div class="pro_title">
           Project Name:
           <?php echo $project_name['project_title']; ?>
       </div>
       <div class="pro_subtitle">
           Start Date:
           <?php echo $start_date; ?>
       </div>
       <div class="pro_subtitle">
           End Date:
           <?php echo $end_date; ?>
       </div>
   </div>
   <?php
//Updated Project Budget Including GST
$total_cost = number_format($result["total_cost"], 2, '.', '')*((100+$result["costing_tax"])/100);
$extra_cost_var = number_format($result["extracostvare"], 2, '.', '')*((100+$result["costing_tax"])/100);
$extra_cost_po = number_format($result["extracostpovare"], 2, '.', '')*((100+$result["costing_tax"])/100);
$extra_cost_si = number_format($result["extracostsivare"], 2, '.', '')*((100+$result["costing_tax"])/100);
$extra_cost_allowance= number_format($result["extracostallowe"], 2, '.', '')*((100+$result["costing_tax"])/100);
$extracostscvari = number_format($result["extracostscvare"], 2, '.', '')*((100+$result["costing_tax"])/100);
$updated_project_cost = (number_format($total_cost, 2, '.', '')+number_format($extra_cost_var, 2, '.', '')+number_format($extra_cost_po, 2, '.', '')+number_format($extra_cost_si, 2, '.', '')+number_format($extra_cost_allowance, 2, '.', ''))-number_format($extracostscvari, 2, '.', '');

//Updated Project Contract 
$contract_price = $result["contract_price"];
$extra_sale_var = number_format($result["extrasalevar"], 2, '.', '');
$extra_sale_po = number_format($result["extrasalepovar"], 2, '.', '');
$extra_sale_si = number_format($result["extrasalesivar"], 2, '.', '');
$extra_sale_allowance = number_format($result["extrasaleallow"], 2, '.', '');
$extrasalescvar = number_format($result["extrasalescvar"], 2, '.', '');
$updated_project_contract_price = (number_format($contract_price, 2, '.', '')+number_format($extra_sale_var, 2, '.', '')+number_format($extra_sale_po, 2, '.', '')+number_format($extra_sale_si, 2, '.', '')+number_format($extra_cost_allowance, 2, '.', ''))-number_format($extrasalescvar, 2, '.', '');
              
$total_profit = number_format($updated_project_contract_price, 2, '.', '') - number_format($updated_project_cost, 2, '.', '');

$contigency_of_contract_budget = $contigency_of_contract_budget;
            if($contigency_of_contract_budget==""){
                $contigency_of_contract_budget = 0;
            }
            $contigency_value_including_gst = number_format($updated_project_cost, 2, '.', '')*($contigency_of_contract_budget/100);
            
            $projected_profit_after_contigency = number_format($total_profit, 2, '.', '') - number_format($contigency_value_including_gst, 2, '.', '');
            
            $supplierinvoicecreated = number_format($result["totalsupplierinvoicecreated"], 2, '.', '')*((100+$result["costing_tax"])/100);
            $salesinvoicecreated = number_format($result["totalsalesinvoicecreated"], 2, '.', '');
            
            $job_completion_progress = (number_format($salesinvoicecreated, 2, '.', '')/number_format($updated_project_contract_price, 2, '.', ''))*100;
            
            
            $upd_cont_bud_inc_con_gst = number_format($updated_project_cost, 2, '.', '')+number_format($contigency_value_including_gst, 2, '.', '');
            
            $supplier_invoices_based_on_per_completed = (number_format($job_completion_progress, 2, '.', '')/100)*(number_format($upd_cont_bud_inc_con_gst, 2, '.', ''));
            
            $work_in_progress_value = number_format($supplier_invoices_based_on_per_completed, 2, '.', '')-number_format($supplierinvoicecreated, 2, '.', '');
            


?>
    <div class="col-md-12">
        	<div class="project_report_container">
                <table class="table table-striped table_1" >
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Updated Contract Price Including GST</td>
                        <td class="text-right">$<?php echo number_format($updated_project_contract_price, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Updated Contract Budget including GST</td>
                        <td class="text-right">$<?php echo number_format($updated_project_cost, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td>Projected Profit</td>
                        <td class="text-right">$<?php 
                        echo number_format($total_profit, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Contingency % of Contract Budget</td>
                        <td class="text-right"><?php echo $contigency_of_contract_budget;?>%</td>
                    </tr>
                    <tr>
                        <td >Contingency Value Including GST</td>
                        <td class="text-right">$<?php echo number_format($contigency_value_including_gst, 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Projected Profit after Contingency</td>
                        <td class="text-right">$<?php echo number_format($projected_profit_after_contigency, 2, '.', ',');?> </td>
                    </tr>
                     <tr>
                       <td colspan="3" style="background-color: #000;"></td>
                    </tr>
                    <tr>
                        <td>Sales Invoices Created in Date Range Including GST</td>
                        <td class="text-right">$<?php echo number_format($salesinvoicecreated, 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >JOB Completion Progress %</td>
                        <td class="text-right"><?php echo number_format($job_completion_progress, 2, '.', '');?>%</td>
                    </tr>
                    <tr>
                       <td colspan="3" style="background-color: #000;"></td>
                    </tr>
                    <tr>
                        <td >Updated Contract Budget including Contingency & GST</td>
                        <td class="text-right">$<?php echo number_format($upd_cont_bud_inc_con_gst, 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Supplier Invoices Created In Date Range Including GST</td>
                        <td class="text-right">$<?php echo number_format($supplierinvoicecreated, 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Supplier Invoices Based on % Complete</td>
                        <td class="text-right">$<?php echo number_format($supplier_invoices_based_on_per_completed, 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                       <td colspan="3" style="background-color: #000;"></td>
                    </tr>
                    <tr>
                        <td >WORK IN PROGRESS VALUE</td>
                        <td class="text-right">$<?php echo number_format($work_in_progress_value, 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                       <td colspan="3" style="background-color: #000;"></td>
                    </tr>
                 
                </table>
            </div>
    </div>
</div>
