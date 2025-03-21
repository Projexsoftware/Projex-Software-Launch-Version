<style>
.text-right{
    text-align:right!important;
}
.imth,th{background-color:#000; padding:5px!important;color:#ffffff!important;}
td{padding:5px; color:#ffffff}
.table{padding:5px;  margin:8px 0}
table, th, td { border: 5px solid #ffffff;}
.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#ffffff; padding:10px 0}

 #contractprice{
        text-align:right;
    }

</style>
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.table_pro_name{ text-align:center; width:80%; background-color: #f56700; color:#ffffff; padding:30px 0}
.pro_address{ width:100%;}

thead tr td{background-color:#ccc;font-weight:bold;text-align:center;font-size:16px;}
tbody tr td{padding:5px;text-align:center;}
td{
  padding:5px!important;
  color:#000!important;
}
th{
  border: 1px solid #ffffff!important;
  padding:5px!important;
  color:#ffffff!important;
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
  width: 40% !important;
  line-height:10px!important;
}
/*.desktop_logo1 img{
  float:left!importnt; 
  text-align:left;
  width: 100% !important;
  margin-bottom:0px!important;
}*/
.desktop_logo1 h5, .desktop_logo1 h4{
  float:left!importnt; 
  text-align:left;
  width: 100% !important;
  margin-bottom:0px!important;
}
.desktop_logo h3, .desktop_logo h4{
    margin-bottom:0px!important;
}
</style>
   <div class="row">
                        <div class="col-md-12">
                            
                            
                                        <div class="row">
                            		    <div class="col-md-12">
                                            	<div class="desktop_logo1">
                                                <img style="width:auto;" src="<?php echo base_url() .'/assets/company/'.$company_info["com_logo"];?>">
                                                <h4><?php echo $company_info["com_name"];?></h4>
                                                <h5><img style="width:auto;margin-top:3px;" src="<?php echo base_url() .'/assets/icons/grid-world.png'?>">&nbsp;<?php echo $company_info["com_website"];?></h5>
                                                <h5><img style="width:auto;margin-top:3px;" src="<?php echo base_url() .'/assets/icons/envelope.png'?>">&nbsp;<?php echo $company_info["com_email"];?></h5>
                                                <h5><img style="width:auto;margin-top:3px;" src="<?php echo base_url() .'/assets/icons/telephone-handle-silhouette.png'?>">&nbsp;<?php echo $company_info["com_phone_no"];?></h5>
                                                
                                        </div>
                                        </div>
                                         <div class="col-md-12">
                            			        <h3 class="card-title text-center">Contract Summary</h3>
                            					<h4 class="text-center">
                            						Project Name:
                            					<?php echo $project_name['project_title']; ?>
                            					</h4>
                            			    
                            		    </div>
                                    </div>
                                    <div class="material-datatables">
                            
                                                <table id="contracttable" class="table table-striped table-bordered table-hover">
                                                    
                                                    <thead>
                                                        <tr>
                                                            <td colspan="2" style="text-align:left;">SECTION 1: CONTRACT PRICE</td>
                                                        </tr>
                                                        <tr>
                                                       
                                                            <th class="col-md-10" style="background-color:#C0B9B9!important; color:black!important;">Contract price</th>
                                                            <th class="col-md-2" id="contractprice" style="background-color:#C0B9B9!important;color:black!important;"><?php echo '$'.$contract_price;?></th>
                            
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <hr>
                                                <table id="allowancetable" class="table table-bordered table-striped table-hover ">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="10" style="text-align:left;">SECTION 2: ALLOWANCES</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Part</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Component</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Allowance</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Actual</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Difference</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Paid</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Owing</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                        <?php echo $allowance;?>
                            	                    </tbody>
                                                </table>
                            	                <hr>
                                                <table id="variationtable" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="8" style="text-align:left;">SECTION 3: VARIATIONS</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Variation Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Variation Description</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Total Cost</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Paid</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Owing</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                      <?php echo $variation;?>
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <table id="paymenttable" class="table table-bordered table-striped table-hover">
                                                    <a id="addbtn" title="Add new payment item" class="btn btn-sm btn-primary clone pull-right" type="button" value="1" onclick="addMore(this.value);"><i class="fa fa-plus-circle"></i>Add New Payment Item</a>
                                                    <thead>
                                                        <tr>
                                                            <td colspan="10" style="text-align:left;">SECTION 4: PAYMENTS</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Payment Description</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Payment Amount</th>
                                                            
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Paid</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Owing</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;"></th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody >
                                                        <?php echo $payment;?>
                                                    </tbody>
                                                    
                                                </table>
                                    </div>
                                    
                                    
                                                   
                                                
     
</div>
</div>