<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.title{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
.pro_address{ width:100%;}
thead tr td{background-color:#ccc;font-weight:bold;text-align:center;font-size:16px;}
tbody tr td{padding:5px;text-align:center;}
.col-md-offset-3 {
    margin-left: 25%;
}
.col-md-6 {
    width: 50%;
}
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
.variation_column{
    background:lightgoldenrodyellow;
}
</style>

<div id="row">
   <div class="col-sm-12">
     <h3 class="table_pro_name">Updated Project Costing Report</h3>
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
           <?php echo $project_name['project_title']; ?>
	   </h4>
   </div>
    <div class="col-md-12">
        <div class="project_report_container material-datatables">
  <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
   <thead>
            <tr>
                <th style="background-color:#495B6C; color:#fff;">Stage</th>
                <th style="background-color:#495B6C; color:#fff;">Part</th>
                <th style="background-color:#495B6C; color:#fff;">Component</th>
                <th style="background-color:#495B6C; color:#fff;">Supplier</th>                            
                <th style="background-color:#495B6C; color:#fff;">QTY</th>
                <th style="background-color:#495B6C; color:#fff;">Unit Of Measure</th>
                <th style="background-color:#495B6C; color:#fff;">Unit Cost</th>
                <th style="background-color:#495B6C; color:#fff;">Line Total</th>
                <th style="background-color:#495B6C; color:#fff;">Margin %</th>
                <th style="background-color:#495B6C; color:#fff;">Line Total with Margin</th>
                <th style="background-color:#495B6C; color:#fff;">Status</th>
                <th style="background-color:#495B6C; color:#fff;">Include in specifications</th>
                <th style="background-color:#495B6C; color:#fff;">Client Allowance</th>
                <th style="background-color:#495B6C; color:#fff;">Comment</th>
            </tr>

        </thead>
        <tbody>

      <?php 
      if($prjprts){
         $count = 1; 
         $total = 0;
        foreach ($prjprts As $key => $prjprt) { 
             ?>
             <tr>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php echo $prjprt->stage_name; ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php echo $prjprt->costing_part_name; ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php 
                if($prjprt->costing_type=="autoquote"){
					$summary_info = get_summary_info_by_autoquote($prjprt->costing_tpe_id);
					echo $summary_info["component_name"];
                }
                else{
                echo $prjprt->component_name;
                }
                ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php echo $prjprt->supplier_name;?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php if($prjprt->costing_type=="autoquote"){
                    echo "1";
                }else{
                    echo number_format($prjprt->costing_quantity, 2, '.', '');
                }
                
                ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php echo $prjprt->costing_uom; ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>>
                <?php 
                if($prjprt->costing_type=="autoquote"){
                    echo "Auto Quote";
                }else{
                    echo number_format($prjprt->costing_uc, 2, '.', '');
                }
                ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php echo number_format($prjprt->line_cost, 2, '.', ''); ?></td>  
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>>
                <?php 
                if($prjprt->costing_type=="autoquote"){
                    echo "0.00";
                }
                else{
                    echo number_format($prjprt->margin, 2, '.', '');
                }
                ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php
                  if($prjprt->costing_type=="autoquote"){
                      echo number_format(($prjprt->line_margin-$prjprt->margin), 2, '.', '');
                      $total +=($prjprt->line_margin-$prjprt->margin);
                  }
                  else{
                      echo number_format($prjprt->line_margin, 2, '.', '');
                      $total +=$prjprt->line_margin;
                  }
                ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>>
                    <?php if ($prjprt->type_status == "estimated") {echo "Estimated";}
                    else if ($prjprt->type_status == "prince_finalized") { echo "Price finalized<"; }
                    else{
                       echo "Allowance"; 
                    }
                ?>
                </td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>>
                    <?php if ($prjprt->include_in_specification == 1) {
                        echo "Yes";
                    }
                    else{
                        echo "No";
                    }
                   ?>
                </td>
                 <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>>
                    <?php if ($prjprt->client_allowance == 1) {
                        echo "Yes";
                    }
                    else{
                        echo "No";
                    }
                   ?>
                </td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>>
                    <?php echo $prjprt->comment;?>
                </td>
            </tr>
            <?php 
            $count++;
        }	          
        ?>
        
        <?php } else{ ?>
        <tr>
          <td colspan="15">No record found</td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
    </div>
    
</div>
 <div class="row">
        <br>
            <div class="form-group col-md-12">

                        <table class="table table-bordered table-striped table-hover">
                            <tr>

                                <td>Project Subtotal</td>
                                <td width="160" class="text-right"><?php echo "$".number_format($total, 2, '.', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Overhead Margin</td>
                                <td width="160" class="text-right"> <?php echo number_format(@$pc_detail->over_head_margin, 2, '.', '')."%"; ?></td>
                            </tr>
                            <tr>
                                <td>Profit Margin</td>
                                <td width="160" class="text-right"> <?php echo number_format(@$pc_detail->porfit_margin, 2, '.', '')."%"; ?></td>
                            </tr>
                            <?php $subtotal_2 = (($pc_detail->over_head_margin / 100) * $total) + (($pc_detail->porfit_margin / 100) * $total) + $total;?>
                            <tr>
                                <td>Project Subtotal</td>
                                <td width="160" class="text-right"> <?php echo "$".number_format($subtotal_2, 2, '.', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td width="160" class="text-right"> <?php echo @$pc_detail->tax_percent."%"; ?></td>
                            </tr>
                            <?php $subtotal_3 = (($pc_detail->tax_percent / 100) * $total) +  $subtotal_2;?>
                            <tr>
                                <td>Project Subtotal</td>
                                <td  width="160" class="text-right"> <?php @$total1 = $subtotal_3; echo "$".number_format(@$total1, 2, '.', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Project Price Rounding</td>
                                <td width="160" class="text-right"> <?php @$total2 = @$pc_detail->price_rounding; echo "$".number_format(@$total2, 2, '.', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Project Contract Price</td>
                                <td  width="160" class="text-right"> <?php @$gtotal = @$total1 + @$total2; echo "$".number_format(@$gtotal, 2, '.', '');?></td>
                            </tr>                           
                            
                          </tbody>  
                        </table>
                    </div>
        </div>
