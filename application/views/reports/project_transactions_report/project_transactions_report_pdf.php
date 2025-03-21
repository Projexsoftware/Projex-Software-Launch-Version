<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.sr_no_common {
    background-color: #d52418!important;
    color: #fff;
}

.yellow_cals {
    background-color: #fdea11!important;
    color: #000;
}

.pro_title{
    background-color: green!important;
    color: #fff;
    text-align: center;
}
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

   background-color: #415160!important;
   color:#fff!important;

   padding:10px!important;

}
.col-md-6{
    float:left;
    width:45%;
}
.tab_info tr td{
  background: none !important;
  color:#000!important;
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
     <h3 class="table_pro_name">Project Transactions Report</h3>
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
        <div class="project_report_container material-datatables">
  <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
   <thead>
            <tr>
                            <th class="sr_no_common" style="background-color: #d52418;color: #fff;">Sr No</th>
                            <th class="sr_no_common" style="background-color: #d52418;color: #fff;">Supplier</th>
                            <th class="sr_no_common" style="background-color: #d52418;color: #fff;">Supplier reference</th>
                            <th class="sr_no_common" style="background-color: #d52418;color: #fff;">Supplier invoice</th>
                            <th class="sr_no_common" style="background-color: #d52418;color: #fff;">Supplier Credits</th>
                            <th class="sr_no_common" style="background-color: #d52418;color: #fff;">Status</th>
                            <th class="yellow_cals" style="background-color: #fdea11;">Sales Invoice</th>
                            <th class="yellow_cals" style="background-color: #fdea11;">Sales invoice paid</th>
                            <th class="yellow_cals" style="background-color: #fdea11;">Sales Credits</th>
                            <th class="yellow_cals" style="background-color: #fdea11;">Status</th>
                            <th class="yellow_cals" style="background-color: #fdea11;">Balance</th>
                        </tr>

        </thead>
        <tbody>
                <?php if(isset($project_all) && count($project_all)>0){?>
                <?php $count = 1;
                foreach ($project_all as $p => $project) { ?>
                <?php if(array_key_exists($project['project_id'], $supplier_rec_project ) || array_key_exists( $project['project_id'],$sales_rec_project )){?>
                <tr class="pro_title" style="background: green!important;color: #fff;text-align: center;">
                    <td colspan="11" style="background: green!important;color: #fff;text-align: center;"><?php echo $project['project_title'];?></td>
                </tr>
                <?php }
                $balance=0;
                ?>
                <?php if(array_key_exists($project['project_id'],$supplier_rec_project)){

                    ?>
                    <?php 

                    foreach($supplier_rec_project[$project['project_id']] as $s_record){
                        $supplier_amount = number_format(($s_record['invoice_amount']*($s_record['va_tax']/100))+$s_record['invoice_amount'], 2, '.', '');
										$supplier_credits = number_format(get_total_supplier_credits($s_record['id']),2,".","");
										$balance -=($supplier_amount-$supplier_credits);
                        if(($transaction_type=="paid" && ($s_record['status']=="Paid" || $s_record['status']=="PAID")) || $transaction_type=="all"){    
                            ?>
                            <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $s_record['supplier_name'];?></td>
                                <td><?php echo $s_record['supplierrefrence'];?></td>
                                <td><?php echo "$".number_format(($s_record['invoice_amount']*($s_record['va_tax']/100))+$s_record['invoice_amount'], 2, '.', ',');?></td>
                                <td><?php echo "$".number_format(get_total_supplier_credits($s_record['id']),2,".",",");?></td>
                                <td><?php echo $s_record['status'];?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                 <td></td>
                                <td>
                                    <?php 
                                    echo "$".number_format($balance, 2, '.', ',');?>
                                </td>
                            </tr>
                            <?php $count++;?>
                            <?php }
                        }?>
                        <?php }?>
                        <?php if(array_key_exists($project['project_id'],$sales_rec_project)){?>
                        <?php foreach($sales_rec_project[$project['project_id']] as $sales_record){
                            $balance +=(number_format(($sales_record['invoice_amount']*($sales_record['va_tax']/100))+$sales_record['invoice_amount'], 2, '.', '')-number_format(get_total_sales_credits($sales_record['id']),2,".",""));
								
                            if(($transaction_type=="paid" && ($sales_record['status']=="Paid" || $sales_record['status']=="PAID")) || $transaction_type=="all"){    
                                ?>
                                <tr>
                                    <td><?php echo $count;?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                    <td><?php echo $sales_record['notes'];?></td>
                                    <td><?php echo "$".number_format(($sales_record['invoice_amount']*($sales_record['va_tax']/100))+$sales_record['invoice_amount'], 2, '.', '');?></td>
                                    <td><?php echo "$".number_format(get_total_sales_credits($sales_record['id']),2,".",",");?></td>
                                    <td><?php echo $sales_record['status'];?></td>
                                    <td><?php 
                                    echo "$".number_format($balance, 2, '.', ',');?></td>
                                </tr>
                                <?php $count++;?>
                                <?php }
                            }?>
                            <?php }?>
                            <?php } ?>
                            <?php }else{?>
                            <tr>
                                <td colspan="4">No record found</td>
                            </tr>
                            <?php }?>
                        </tbody>
    </table>
  </div>
    </div>
</div>
