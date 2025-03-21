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
   tr.pro_title td{
	   background-color:#f56700!important;
	   color:#fff!important;
	   text-align:center!important;
	   /*font-weight:bold;*/
	   font-size:18px;
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
.col-md-6{
    float:left;
    width:45%;
}
</style>
<div id="row">
<div class="col-sm-12"><div style="text-align:right;"><img style="width:16px;" src="<?php echo SURL .'/assets/icons/calendar.png';?>"> <?php echo date('d M Y');?></div></div>
   <div class="col-sm-12">
     <h3 class="table_pro_name">Project Report</h3>
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
    <div class="col-md-12">
                                       <div class="row" style="background-color:#f56700;color:#fff!important;">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                
                                                            <center><h4 class="table_pro_name"><b>Project Name : <?php echo $project_name['project_title'];?></b></h4></center>
                                                   
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    <div id="report" >
                                                        <table  class="table table-bordered table-striped table-hover" >
                   
                    <tr>
                        <td >Project Costing subtotal</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['total_cost'], 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Overhead margin</td>
                        <td colspan="2" class="text-right"><?php echo $result['overhead_margin'];?>%</td>
                    </tr>
                    <tr>
                        <td >Profit margin</td>
                        <td colspan="2" class="text-right"><?php echo $result['profit_margin'];?>%</td>
                    </tr>
                    <tr>
                        <td >Project subtotal</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['total_cost2'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Tax</td>
                        <td colspan="2" class="text-right"><?php echo $result['costing_tax'];?>%</td>
                    </tr>
                    <tr>
                        <td >Project subtotal</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['total_cost3'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Project price rounding</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['price_rounding'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Project contract price</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['contract_price'], 2, '.', ',');?> </td>
                    </tr>
                     <tr>
                        <td >Projected profit</td>
                       <td colspan="2" class="text-right">$ 
						   <?php 
						   $total_profit = number_format($result['contract_price'],2,'.','')-number_format(($result['total_cost']*(100+$result['costing_tax'])/100),2,'.','');
						   echo number_format($total_profit, 2, '.', ',');?> 
					   </td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Extra costs from variations excluding GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostvare'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra costs from variations including GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostvare']*((100+$result['costing_tax'])/100), 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra sales from variations</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extrasalevar'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Profit from variations including GST</td>
                        <td colspan="2" class="text-right">$<?php $sale_profit = number_format($result['extrasalevar']-($result['extracostvare']*((100+$result['costing_tax'])/100)), 2, '.', '');
                        echo number_format($sale_profit, 2, '.', ',');
?> </td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Extra costs from purchase orders variations excluding GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostpovare'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra costs from purchase orders variations including GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostpovare']*((100+$result['costing_tax'])/100), 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra sales from purchase orders variations</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extrasalepovar'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Profit from purchase orders variations including GST</td>
                        <td colspan="2" class="text-right">$<?php $po_profit = number_format($result['extrasalepovar']-($result['extracostpovare']*((100+$result['costing_tax'])/100)), 2, '.', '');
                        echo number_format($po_profit, 2, '.', ',');
                   ?> </td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Extra costs from supplier invoices variations excluding GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostsivare'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra costs from supplier invoices variations including GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostsivare']*((100+$result['costing_tax'])/100), 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra sales from supplier invoices variations</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extrasalesivar'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Profit from supplier invoices variations</td>
                        <td colspan="2" class="text-right">$<?php $supplier_profit = number_format($result['extrasalesivar']-($result['extracostsivare']*((100+$result['costing_tax'])/100)), 2, '.', '');
                        echo number_format($supplier_profit, 2, '.', ',');
                    ?> </td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Extra costs from supplier credits variations excluding GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostscvare'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra costs from supplier credits variations including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $extracostsuppliercreditsvar = number_format($result['extracostscvare']*((100+$result['costing_tax'])/100), 2, '.', '');
                        echo number_format($result['extracostscvare']*((100+$result['costing_tax'])/100), 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra sales from supplier credits variations</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extrasalescvar'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Profit from supplier credits variations</td>
                        <td colspan="2" class="text-right">$<?php $supplier_profit = number_format($result['extrasalescvar']-($result['extracostscvare']*((100+$result['costing_tax'])/100)), 2, '.', '');
                        echo number_format($supplier_profit, 2, '.', ',');
                    ?> </td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <!--Allowances-->
                     <tr>
                        <td >Extra costs from allowances excluding GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostallowe'], 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Extra costs from allowances including GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['extracostallowe']*((100+$result['costing_tax'])/100), 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Current and Pending Sales from Allowances</td>
                        <td colspan="2" class="text-right">$<?php echo number_format(($result['extracostallowe']*((100+$result['costing_tax'])/100)), 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Profit from allowances</td>
                        <td colspan="2" class="text-right">$<?php $allowance_profit = number_format(($result['extracostallowe']*((100+$result['costing_tax'])/100))-($result['extracostallowe']*((100+$result['costing_tax'])/100)), 2, '.', '');
                        echo number_format($allowance_profit, 2, '.', ',');
                    ?> </td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td style="color:#0000ff;">Updated Project Cost including GST</td>
                        <td colspan="2" style="color:#0000ff;" class="text-right">$<?php
                        $updated_project_cost = (number_format(($result['total_cost']*((100+$result['costing_tax'])/100)), 2, '.', '')+number_format(($result['extracostvare']*((100+$result['costing_tax'])/100)), 2, '.', '')+number_format($result['extracostpovare']*((100+$result['costing_tax'])/100), 2, '.', '')+number_format(($result['extracostsivare']*((100+$result['costing_tax'])/100)), 2, '.', '')+number_format($result['extracostallowe']*((100+$result['costing_tax'])/100), 2, '.', ''))-$extracostsuppliercreditsvar;
                         echo number_format($updated_project_cost, 2, '.', ',');
                        ?> </td>
                    </tr>
                    <tr>
                        <td style="color:#0000ff;">Updated Project Contract Price including GST</td>
                        <td colspan="2" style="color:#0000ff;" class="text-right">$<?php 
                        $updated_project_contract_price = (number_format($result['contract_price'], 2, '.', '')+number_format($result['extrasalevar'], 2, '.', '')+number_format($result['extrasalepovar'], 2, '.', '')+number_format($result['extrasalesivar'], 2, '.', '')+number_format(($result['extracostallowe']*((100+$result['costing_tax'])/100)), 2, '.', ''))-number_format($result['extrasalescvar'], 2, '.', '');
                        echo number_format($updated_project_contract_price, 2, '.', ',');
                        ?> </td>
                    </tr>
                    <tr>
                        <td style="color:#0000ff;">Updated Profit including GST</td>
                        <td colspan="2" style="color:#0000ff;" class="text-right">$<?php 
//$total_updated_profit = number_format($total_profit, 2, '.', '')+number_format($sale_profit, 2, '.', '') +number_format($po_profit, 2, '.', '')+number_format($supplier_profit, 2, '.', '')+number_format($allowance_profit, 2, '.', '');
                        $total_updated_profit = number_format($updated_project_contract_price, 2, '.', '')-number_format($updated_project_cost, 2, '.', '');
                        echo number_format($total_updated_profit, 2, '.', ',');
                        ?> </td>
                    </tr>
                    <tr>
                        <td style="color:#0000ff;">PROFIT DIFFERENCE including GST</td>
                        <td colspan="2" style="color:#0000ff;" class="text-right">$<?php $profit_difference = number_format($total_updated_profit, 2, '.', '')-number_format($total_profit, 2, '.', '');
                        echo number_format($profit_difference, 2, '.', ',');
?> 
             
                      

</td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <!--<tr>
                        <td >Total Supplier Invoices Created including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $supplier_invoices_created = ($result['totalsupplierinvoicecreated']*((100+$result['costing_tax'])/100));
                        echo number_format($supplier_invoices_created, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Total Supplier credits created including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $total_supplier_credits = ($result['total_credit_notes']*($result['costing_tax']/100))+$result['total_credit_notes'];
                        echo number_format($total_supplier_credits, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Supplier Invoices paid from bank including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $supplier_invoices_paid = ($result['totalsupplierinvoicepaid']*((100+$result['costing_tax'])/100));
                        echo number_format($supplier_invoices_paid, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Supplier Invoices paid by Supplier Credit including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $supplier_invoices_paid_by_supplier_credit = $result['extracostscvare']*((100+$result['costing_tax'])/100);
                        echo number_format($supplier_invoices_paid_by_supplier_credit, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Supplier Invoices unpaid including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $supplier_invoices_unpaid = number_format($supplier_invoices_created,2,'.','')-number_format($supplier_invoices_paid,2,'.','')-number_format($supplier_invoices_paid_by_supplier_credit,2,'.',''); 
                        echo number_format($supplier_invoices_unpaid, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Future Supplier Invoices including GST</td>
                        <td colspan="2" class="text-right">$<?php
                        $futuresupplierinvoices = number_format($updated_project_cost,2,'.','')-number_format($supplier_invoices_created,2,'.','')-number_format($total_supplier_credits,2,'.','');
                        echo number_format($futuresupplierinvoices, 2, '.', ',');?></td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Total Sales Invoices Created including GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['totalsalesinvoicecreated'], 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Total Sales Credits Created including GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['totalsalescredits'], 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Sales Invoices Paid including GST</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['totalsalesinvoicepaid'], 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Sales Invoices Unpaid including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $salesinunpaid = number_format($result['totalsalesinvoicecreated'], 2, '.', '')-number_format($result['totalsalescredits'], 2, '.', '')-number_format($result['totalsalesinvoicepaid'], 2, '.', '');
                        echo number_format($salesinunpaid, 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td >Future Sales Invoices including GST</td>
                        <td colspan="2" class="text-right">$<?php 
                        $futuresalesinvoices = number_format($updated_project_contract_price, 2, '.', '')-number_format($result['totalsalesinvoicepaid'], 2, '.', ''); 
                        echo number_format($futuresalesinvoices, 2, '.', ',');?></td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Total Cash Transfers</td>
                        <td colspan="2" class="text-right">$<?php echo number_format($result['totalcashtransferspaid'], 2, '.', ',');?></td>
                    </tr>
                    <tr><td colspan="3" style="background-color: #000"></td></tr>
                    <tr>
                        <td >Bank Interest</td>
                    
                        <td colspan="2" class="text-right">$<?php echo number_format($bankinterest, 2, '.', ',');?> </td>
                    </tr>
                    <tr>
                        <td >Bank Balance</td>
                        <td colspan="2" class="text-right">$<?php 
                        $bank_balance = $total_supplier_credits+($result['totalsalesinvoicepaid'])-($supplier_invoices_paid)-($result['totalcashtransferspaid'])+$bankinterest;
                        echo number_format($bank_balance, 2, '.', ',');?> </td>
                    </tr>
                     <tr>
                        <td >FUTURE CASH REQUIRED</td>
                        <td colspan="2" class="text-right">$<?php 
                        $future_cash_required = number_format($supplier_invoices_unpaid, 2, '.', '') + number_format($futuresupplierinvoices, 2, '.', '');
                        echo number_format($future_cash_required, 2, '.', ',');?> </td>
                    </tr>
                     <tr>
                        <td >FUTURE CASH AVAILABLE</td>
                        <td colspan="2" class="text-right">$<?php 
                        $future_cash_available = number_format($salesinunpaid, 2, '.', '') + number_format($futuresalesinvoices, 2, '.', '') + number_format($bank_balance, 2, '.', '');
                        echo number_format($future_cash_available, 2, '.', ',');?> </td>
                    </tr>
                     <tr>
                        <td >PROJECTED FINAL CASH</td>
                        <td colspan="2" class="text-right">$<?php 
                        $projected_final_cash = number_format($future_cash_available, 2, '.', '') - number_format($future_cash_required, 2, '.', '');
                        echo number_format($projected_final_cash, 2, '.', ',');?> </td>
                    </tr>-->
                    
     
                </table>
                                                    </div>
                                                    
                                                </div>
                                        </div>
								
    </div>
</div>
