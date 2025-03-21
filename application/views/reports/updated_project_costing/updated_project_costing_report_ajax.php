 <div class="row">
   <div class="col-sm-12">
     <h4 class="table_pro_name">
         Project Name:
         <?php echo $project_name['project_title']; ?>
     </h4>						
 </div>
</div>
 <table class="table table-striped table-no-bordered table-hover datatables print_table" cellspacing="0" width="100%" style="width:100%" >
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
            
            if($prjprt->costing_type != "normal"){
                $className = "variation_column";
            }
            else{
                $className = "";
            }
                ?>
             <tr>
                <td class="<?php echo $className;?>"><?php echo $prjprt->stage_name; ?></td>
                <td class="<?php echo $className;?>"><?php echo $prjprt->costing_part_name; ?></td>
                <td class="<?php echo $className;?>"><?php 
                if($prjprt->costing_type=="autoquote"){
					$summary_info = get_summary_info_by_autoquote($prjprt->costing_tpe_id);
					echo $summary_info["component_name"];
                }
                else{
                echo $prjprt->component_name;
                }
                ?></td>
                <td class="<?php echo $className;?>"><?php echo $prjprt->supplier_name;?></td>
                <td class="<?php echo $className;?>"><?php if($prjprt->costing_type=="autoquote"){
                    echo "1";
                }else{
                    echo number_format($prjprt->costing_quantity, 2, '.', '');
                }
                
                ?></td>
                <td class="<?php echo $className;?>"><?php echo $prjprt->costing_uom; ?></td>
                <td class="<?php echo $className;?>">
                <?php 
                if($prjprt->costing_type=="autoquote"){
                    echo "Auto Quote";
                }else{
                    echo number_format($prjprt->costing_uc, 2, '.', '');
                }
                ?></td>
                <td class="<?php echo $className;?>"><?php echo number_format($prjprt->line_cost, 2, '.', ''); ?></td>  
                <td class="<?php echo $className;?>">
                <?php 
                if($prjprt->costing_type=="autoquote"){
                    echo "0.00";
                }
                else{
                    echo number_format($prjprt->margin, 2, '.', '');
                }
                ?></td>
                <td class="<?php echo $className;?>"><?php
                  if($prjprt->costing_type=="autoquote"){
                      echo number_format(($prjprt->line_margin-$prjprt->margin), 2, '.', '');
                      
                  }
                  else{
                      echo number_format($prjprt->line_margin, 2, '.', '');
                       
                  }
                ?></td>
                <td class="<?php echo $className;?>">
                    <?php if ($prjprt->type_status == "estimated") {echo "Estimated";}
                    else if ($prjprt->type_status == "prince_finalized") { echo "Price finalized<"; }
                    else{
                       echo "Allowance"; 
                    }
                ?>
                </td>
                <td class="<?php echo $className;?>">
                    <?php if ($prjprt->include_in_specification == 1) {
                        echo "Yes";
                    }
                    else{
                        echo "No";
                    }
                   ?>
                </td>
                 <td class="<?php echo $className;?>">
                    <?php if ($prjprt->client_allowance == 1) {
                        echo "Yes";
                    }
                    else{
                        echo "No";
                    }
                   ?>
                </td>
                <td class="<?php echo $className;?>">
                    <?php echo $prjprt->comment;?>
                </td>
            </tr>
            <?php 
            $count++;
        }	
} else{ ?>
    <tr>
       <td colspan="15">No Records Found</td>
   </tr>
   <?php }?>
</tbody>
</table>
<?php 
$total = get_project_subtotal($pc_detail->costing_id);?>
 <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <table class="table">
                                      <tbody>
                                          <tr>
                                            <td >Project Subtotal</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost" id="total_cost" value="<?php echo number_format($total, 2, '.', ''); ?>"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td>Overhead Margin</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control" name="overhead_margin" id="overhead_margin" readonly value="<?php echo number_format(@$pc_detail->over_head_margin, 2, '.', ''); ?>"  ></td>
                                          </tr>
                                          <tr>
                                            <td>Profit Margin</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control" name="profit_margin" id="profit_margin" readonly value="<?php echo number_format(@$pc_detail->porfit_margin, 2, '.', ''); ?>" ></td>
                                          </tr>
                                          <?php $subtotal_2 = (($pc_detail->over_head_margin / 100) * $total) + (($pc_detail->porfit_margin / 100) * $total) + $total;?>
                                          <tr>
                                            <td>Project Subtotal</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost2" id="total_cost2" value="<?php echo number_format($subtotal_2, 2, '.', ''); ?>"  readonly ></td>
                                          </tr>
                                          <tr>
                                            <td>Tax</td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control" name="costing_tax" id="costing_tax" value="<?php echo @$pc_detail->tax_percent; ?>" readonly></td>
                                          </tr>
                                          <?php $subtotal_3 = (($pc_detail->tax_percent / 100) * $total) +  $subtotal_2;?>
                                          <tr>
                                            <td >Project Subtotal</td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="total_cost3" id="total_cost3" readonly value="<?php @$total1 = $subtotal_3; echo number_format(@$total1, 2, '.', ''); ?>"  readonly></td>
                                          </tr>
                                          <tr>
                                            <td >Project Price Rounding</td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" readonly name="price_rounding" id="price_rounding" value="<?php @$total2 = @$pc_detail->price_rounding; echo number_format(@$total2, 2, '.', ''); ?>" required ></td>
                                          </tr>
                                          <tr>
                                            <td >Project Contract Price</td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" readonly name="contract_price" id="contract_price" value="<?php @$gtotal = @$total1 + @$total2; echo number_format(@$gtotal, 2, '.', '');?>" required ></td>
                                          </tr>
                                          
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
<?php if($prjprts){ ?>
<div class="row">
    <div class="col-md-12">
     <div class="form-footer">
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_updated_project_costing" method="post" class="print">
            <a href="javascript:window.print()" class="btn btn-success no_print">Print</a>
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_project_id" name="report_project_id" value="<?php echo $costing_id;?>">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export as PDF">
        </form>
    </div>
</div>
</div>
<?php } ?>