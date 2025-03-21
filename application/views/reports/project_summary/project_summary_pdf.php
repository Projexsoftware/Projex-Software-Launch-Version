<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
.pro_address{ width:100%;}
thead tr td{background-color:#ccc;font-weight:bold;text-align:center;font-size:16px;}
tbody tr td{padding:5px;text-align:center;}
td{

  padding:10px!important;

}
th {
  border: 1px solid #eee!important;
  padding:10px;
}

tr:nth-child(odd) td{

   background-color: #f9f9f9!important;

   padding:10px!important;

}
.col-md-6{
    float:left;
    width:45%;
}
.tab_info tr td{
  background: none !important;
  font-size: 14px;
  line-height: 5px !important;
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
   <div class="col-sm-12">
     <h3 class="table_pro_name">Project Summary Report</h3>
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
       <h4 class="table_pro_name">
           Project Name:
           <?php echo $project_name['project_title']; ?>
       </h4>
   </div>
    <div class="col-md-12">
        <div class="project_report_container">
    <table class="table table-striped table_1" >
        <thead>
                        <tr>
                            <th style="background-color:#495B6C; color:#fff;width:150px;"></th>
                            <th style="background-color:#495B6C; color:#fff;">Date</th>
                            <th style="background-color:#495B6C; color:#fff;">Supplier</th>
                            <th style="background-color:#495B6C; color:#fff;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php if(count($sales_invoices)>0){ 
                            $i=0;
                            $total_sales_invoices = 0;
                            foreach($sales_invoices as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Sales Invoices</b> <?php } ?></td>
                            	<td><?php echo date("d-M-Y", strtotime($val['date_created'])); ?></td>
                            	<td></td>
                            	<td class="text-right">$<?php echo number_format($val['invoice_amount'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++;
                        	$total_sales_invoices += $val['invoice_amount'];
                            } 
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td style="background-color:#495B6C; color:#fff;" class="text-right"><b>$<?php echo number_format($total_sales_invoices,2,'.',',');?></b></td>
                            </tr>
                        	<?php
                        	} else { ?>
                            <tr>
                        	    <td><b>Sales Invoices</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                            <?php if(count($sales_credit_notes)>0){ 
                            $i=0;
                            $total_sales_credit_notes = 0;
                            foreach($sales_credit_notes as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Sales Credit Notes</b> <?php } ?></td>
                            	<td><?php echo date("d-M-Y", strtotime($val['date'])); ?></td>
                            	<td><?php echo $val['supplier_name'];?></td>
                            	<td class="text-right">$<?php echo number_format($val['subtotal'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++;
                        	$total_sales_credit_notes += $val['subtotal'];
                        	}
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$<?php echo number_format($total_sales_credit_notes,2,'.',',');?></b></td>
                            </tr>
                            <?php
                        	} else { ?>
                            <tr>
                        	    <td><b>Sales Credit Notes</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                            <?php if(count($supplier_invoices)>0){ 
                            $i=0;
                            $total_supplier_invoices = 0;
                            foreach($supplier_invoices as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Supplier Invoices</b> <?php } ?></td>
                            	<td><?php 
                            	$invoice_date = str_replace("/", "-", $val['invoice_date']);
                                $invoice_date = date("Y-m-d", strtotime($invoice_date));
                            	echo date("d-M-Y", strtotime($invoice_date)); ?></td>
                            	<td><?php echo $val['supplier_name'];?></td>
                            	<td class="text-right">$<?php echo number_format($val['invoice_amount'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++;
                        	$total_supplier_invoices += $val['invoice_amount'];
                        	} 
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$<?php echo number_format($total_supplier_invoices,2,'.',',');?></b></td>
                            </tr>
                        	<?php } else { ?>
                            <tr>
                        	    <td><b>Supplier Invoices</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                            <?php if(count($supplier_credit_notes)>0){ 
                            $i=0;
                            $total_supplier_credit_notes = 0;
                            foreach($supplier_credit_notes as $val){
                            ?>
                            <tr>
                        	    <td><?php if($i==0){ ?> <b>Supplier Credit Notes</b> <?php } ?></td>
                            	<td><?php echo date("d-M-Y", strtotime($val['date'])); ?></td>
                            	<td><?php echo $val['supplier_name'];?></td>
                            	<td class="text-right">$<?php echo number_format($val['subtotal'],2,'.',',');?></td>
                            </tr>
                        	<?php $i++; 
                        	$total_supplier_credit_notes += $val['subtotal'];
                        	} 
                        	?>
                        	<tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$<?php echo number_format($total_supplier_credit_notes,2,'.',',');?></b></td>
                            </tr>
                        	<?php }
                        	else { ?>
                            <tr>
                        	    <td><b>Supplier Credit Notes</b></td>
                            	<td colspan="3"><center></center></td>
                            </tr>
                            <tr>
                        	    <td colspan="3" style="background-color:#495B6C; color:#fff;text-align:left;"><b>Total</b></td>
                            	<td class="text-right" style="background-color:#495B6C; color:#fff;"><b>$0.00</b></td>
                            </tr>
                            <?php } ?>
                        
                    </tbody>
                </table>

</div>
    </div>
</div>
