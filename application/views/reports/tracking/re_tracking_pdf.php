<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
   tr.pro_title td{
       background-color:#f56700!important;
       color:#fff!important;
       text-align:center!important;
      
       font-size:18px;
   }
    tr.gro_title td{
       background-color:#6d3309!important;
       color:#fff!important;
       text-align:center!important;
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
.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
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
   <div class="col-sm-12">
     <h3 class="table_pro_name">Tracking Report</h3>
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
        <div class="project_report_container">
                <table class="table table-striped table_1" >
                    <tr class="pro_title">
                                <td colspan="5">Tracking Report for <?php echo $tracking_report->project_title;?></td>
                    </tr>
                    <tr class="gro_title">
                        <td colspan="5">Family Group : <?php echo $tracking_report->title;?></td>        
                    </tr>
                    <tr>
                        <td >Stage</td>
                        <td >Part</td>
                        <td >Component</td>
                        <td >Budget</td>
                        <td >Actual</td>
                    </tr>
                    <?php if($group_parts){
                         $total_budget=0;
                         $total_actual=0;
                        foreach($group_parts as $part){
                             $total_budget +=$part->budget;
                            $total_actual +=$part->actual;
                            ?>                    
                     <tr>
                        <td ><?php echo $part->stage_name?></td>
                        <td ><?php echo $part->costing_part_name?></td>
                        <td ><?php echo $part->component_name?></td>
                        <td ><?php echo number_format($part->budget,2);?></td>
                        <td ><?php echo number_format($part->actual,2);?></td>
                    </tr>
                    <?php }
                }
                ?>
                  <tr>
                        <td style="font-weight: bold;"><strong>Total</strong></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold;"><strong><?php echo number_format($total_budget,2);?></strong></td>
                         <td style="font-weight: bold;"><strong><?php echo number_format($total_actual,2)  ;?></strong></td>
                    </tr>      
                </table>
            </div>
        <div class="row">
                   <div class="col-lg-12">
                    <!-- <div id="sales_invoice_container" style="min-width: 310px; height: 400px; margin: 30px auto"></div> -->
                    <img src="<?php echo $line_chart;?>" />
                   </div>
                </div>
    </div>
</div>
