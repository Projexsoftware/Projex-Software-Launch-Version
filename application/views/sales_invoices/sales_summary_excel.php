<style>
    
	.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
    #contractprice{
        text-align:right;
    }

</style>
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.table_pro_name{ text-align:center; width:80%; background-color: #f56700; color:#000000; padding:30px 0}
.pro_address{ width:100%;}

thead tr td{background-color:#cccccc;font-weight:bold;text-align:center;font-size:16px;}
tbody tr td{padding:5px;text-align:center;}
td{
  padding:5px!important;
  color:#000!important;
}
th{
  border: 1px solid #ffffff!important;
  padding:5px!important;
  color:red!important;
}
tr:nth-child(odd) td{
 background-color: #f9f9f9!important;
 padding:10px!important;
}
.tab_info{
  border: none !important;
}
.tab_info tr td{
  background: none !important;
  font-size: 14px;
  line-height: 3px !important;
  border: none !important;
}
.tab_info tr td h5{
  background: none !important;
  font-size: 17px !important;
}
.desktop_logo {
  float: left;
  width: 100% !important;
  text-align:center;
  line-height:10px!important;
}
.desktop_logo1 {
  float: left;
  width: 100% !important;
  line-height:10px!important;
}
.desktop_logo1 h5, .desktop_logo1 h4{
  float:left!importnt; 
  text-align:left;
  width: 100% !important;
  margin-bottom:0px!important;
}
.desktop_logo h3, .desktop_logo h4{
    margin-bottom:0px!important;
}
.logo_table, .logo_table tr, .logo_table td{
    border:none!important;
}
.logo_table img{
    width:20px!important;
}
</style>
  <div id="main-container" style="width:100%;float:left;"> 
<div class="padding-md" style="width:100%;float:left;">   
    <div class="col-sm-12" style="margin-top:25px;float:left;width:100%;">
     <div class="col-md-3 desktop_logo1">
         <table class="logo_table" style="border:0!important;"><tr><td style="border:0;"><img style="width:50px!important;height:50px!important;" src="<?php echo base_url() .'/assets/company/thumbnail/'.$company_info["com_logo"];?>"></td></tr><tr><td style="border:0;">&nbsp;</td></tr><tr><td style="border:0;">&nbsp;</td></tr><tr><td style="border:0;">&nbsp;</td></tr><tr><td style="border:0;">&nbsp;</td></tr></table>
        <br/>
        <br>
        <br>
        <h4><?php echo $company_info["com_name"];?></h4>
        <h5><img style="width:auto;" src="<?php echo base_url() .'/assets/icons/grid-world.png'?>">&nbsp;&nbsp;<?php echo $company_info["com_website"];?></h5>
        <h5><img style="width:auto;" src="<?php echo base_url() .'/assets/icons/envelope.png'?>">&nbsp;&nbsp;<?php echo $company_info["com_email"];?></h5>
        <h5><img style="width:auto;" src="<?php echo base_url() .'/assets/icons/telephone-handle-silhouette.png'?>">&nbsp;&nbsp;<?php echo $company_info["com_phone_no"];?></h5>
        
    </div>
    <br/><br/> 
    <div class="col-md-3 desktop_logo">
         <h3 class="text-center">Contract Summary</h3>
         <br/>
         <h4 class="text-center">
      Project Name:
      <?php echo $project_name['project_title']; ?>
  </h4>
       <br/><br/>
    </div>
</div>
<br/><br/> 
    <div class="material-datatables">
        <table id="contracttable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-md-10" style="background-color:#C0B9B9!important;padding:35px!important;color:#000000!important;">Contract price</th>
                        <th class="col-md-2" id="contractprice" style="background-color:#C0B9B9!important;padding:35px!important;color:#000000!important;"><?php echo '$'.$contract_price;?></th>
                    </tr>
                </thead>
        </table>
        <hr>

    <table id="allowancetable" class="table table-bordered table-striped table-hover ">
        <thead>
            <tr>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Part</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Component</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Allowance</th>
                <th  style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Actual</th>
                <th  style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Difference</th>
                <th  style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Number</th>
                <th  style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount Paid</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount Owing</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;"></th>
            </tr>
        </thead>
        <tbody >
            <?php echo $allowance;?>
        </tbody>
    </table>
        <hr>
        <table id="variationtable" class="table table-bordered table-striped table-hover" width="100%">
            <thead>
                <tr>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Variation Number</th>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Variation Description</th>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Total Cost</th>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Number</th>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount</th>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount Paid</th>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount Owing</th>
                    <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;"></th>
                </tr>
            </thead>
            <tbody >
              <?php echo $variation;?>
          </tbody>
      </table>
      <hr>
    <table id="paymenttable" class="table table-bordered table-striped table-hover">
         <thead>
            <tr>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Payment Description</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Payment Amount</th>

                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Number</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount Paid</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;">Invoice Amount Owing</th>
                <th style="background-color:#C0B9B9!important;padding:35px!important; color:#000000!important;"></th>
            </tr>
        </thead>

        <tbody >
            <?php echo $payment;?>
        </tbody>

    </table>

</div>

</div><!-- /.padding-md -->
</div>
