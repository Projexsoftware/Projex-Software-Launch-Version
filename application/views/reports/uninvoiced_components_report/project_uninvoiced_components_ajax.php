 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
    <thead>
        <tr>
            <th style="background-color:#495B6C; color:#fff;">Sr No</th>
            <th style="background-color:#495B6C; color:#fff;">Stage name</th>
            <th style="background-color:#495B6C; color:#fff;">Part</th>
            <th style="background-color:#495B6C; color:#fff;">Component</th>                            
            <th style="background-color:#495B6C; color:#fff;">Supplier</th>
            <th style="background-color:#495B6C; color:#fff;">Costing QTY</th>
            <th style="background-color:#495B6C; color:#fff;">Variations</th>
            <th style="background-color:#495B6C; color:#fff;">Subtotal</th>
            <th style="background-color:#495B6C; color:#fff;">Invoiced QTY</th>
            <th style="background-color:#495B6C; color:#fff;">Uninvoiced QTY</th>
            <th style="background-color:#495B6C; color:#fff;">Uninvoiced Budget</th>
        </tr>
    </thead>
	 <tbody>

      <?php 
      if($prjprts){
				
         $count = 1; 
        
         foreach ($prjprts As $key => $prjprt) { 
             
             $variations = 0;
             
             $variation_amount = get_variation_amount($prjprt->costing_part_id);
            
			 $invoiced_quantity = get_supplier_ordered_quantity($prjprt->costing_part_id);
			 
			
			 $invoiced_amount = get_supplier_invoice_amount($prjprt->costing_part_id);
                
				
		
			$variation_info = get_variation_info_by_costing_id($prjprt->costing_part_id);
			 $recent_quantity = get_recent_variation_quantity($prjprt->costing_part_id, $prjprt->costing_supplier);
                $recent_total = 0;
                foreach($recent_quantity as $val){
                    $recent_total += $val['total'];
                }
                $updated_total = 0;
                foreach($recent_quantity as $val){
                    $updated_total = $val['updated_quantity'];
                }
                if(count($recent_quantity)>0){
                if($prjprt->part_costing_type=="normal" || $prjprt->part_costing_type=="autoquote"){
            					$variations = $prjprt->costing_quantity+$recent_total;
            				}
            				else{
            					$variations =$updated_total;
            				}
            	$subtotal = $variations;
                }
                else{
                    $variations = 0;
                    $subtotal = $prjprt->costing_quantity;
                }
            
                       $uninvoiced_quantity = $subtotal - $invoiced_quantity;
            if($uninvoiced_quantity>0){	
                ?>
             <tr>
                <td><?php echo $count;?></td>
                <td><?php echo $prjprt->stage_name; ?></td>
                <td><?php echo $prjprt->costing_part_name; ?></td>
                <td><?php echo $prjprt->component_name;?></td>
                <td><?php echo $prjprt->supplier_name;?></td>
                <td><?php echo ($prjprt->is_variated==0) ? $prjprt->costing_quantity : 0;?></td>
                <td><?php echo ($prjprt->is_variated==0) ? $variations : $prjprt->costing_quantity;?></td>
                <td><?php echo  number_format($subtotal, 2, ".", ",");?></td>
                <td><?php echo $invoiced_quantity;?></td>  
                <td><?php echo number_format($uninvoiced_quantity, 2, ".", "");?></td>
                <td><?php
                  if($prjprt->part_costing_type!="normal"){
                      $prjprt->project_costing_cost = 0;
                  }
                echo number_format(($prjprt->project_costing_cost + $variation_amount)-$invoiced_amount, 2, ".", "");
                ?></td>
            </tr>
            <?php 
            $count++;
        }	
    }						
} else{ ?>
    <tr>
       <td colspan="11">No Records Found</td>
   </tr>
   <?php }?>
</tbody>
</table>
<?php if($prjprts){ ?>
<div class="row">
    <div class="col-md-12">
     <div class="form-footer">
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_project_uninvoiced_components" method="post" class="print">
            <a href="javascript:window.print()" class="btn btn-success no_print">Print</a>
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_project_id" name="report_project_id" value="">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To Excel" onclick="changeReportType('excel', 'uninvoiced_components');">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To PDF" onclick="changeReportType('pdf', 'uninvoiced_components');">
        </form>
    </div>
</div>
</div>
<?php } ?>