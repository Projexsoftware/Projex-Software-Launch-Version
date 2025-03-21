 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
    <thead>
        <tr>
                <th style="background-color:#495B6C; color:#fff;">Stage</th>
                <th style="background-color:#495B6C; color:#fff;">Part</th>
                <th style="background-color:#495B6C; color:#fff;">Component</th>                            
                <th style="background-color:#495B6C; color:#fff;">Supplier</th>
                <th style="background-color:#495B6C; color:#fff;">Project Costing Amount</th>
                <th style="background-color:#495B6C; color:#fff;">Variations (+/-)</th>
                <th style="background-color:#495B6C; color:#fff;">Budget Amount</th>
                <th style="background-color:#495B6C; color:#fff;">Invoices Amount</th>
                <th style="background-color:#495B6C; color:#fff;">Variance</th>
            </tr>
    </thead>
    <tbody>

      <?php 
      if($prjprts){
				
         $count = 1; 
        
         foreach ($prjprts As $key => $prjprt) { 
             
             $variations = 0;
             
            if($prjprt->part_costing_type!="normal"){
                $prjprt->project_costing_cost = 0;
            }
             $parts = get_uninvoiced_components($prjprt->costing_part_id);
             
             $variation_amount = get_variation_amount_excluding_sale_summary($prjprt->costing_part_id);
            
			 $invoiced_quantity = get_supplier_ordered_quantity($prjprt->costing_part_id);
			 
			 $invoiced_amount = get_supplier_invoice_amount($prjprt->costing_part_id);
			 if($parts){
                $variation_type = get_variation_type($parts->variation_id);
				if($parts->change_quantity!="" && $parts->variation_id!=0 && $variation_type['var_type']=="normal"){
					$variations = $parts->change_quantity;
				}
				else{
					$variations =0; 
				}
			 }
			 else{
					$variations =0; 
				}
		
			$variation_info = get_variation_info_by_costing_id($prjprt->costing_part_id);
				if(count($variation_info)>0){
				foreach($variation_info as $vinfo){
				    
				    $variations += $vinfo['change_quantity'];
				}
				}
				
			
        if($prjprt->is_variated==0){
            $subtotal = $prjprt->costing_quantity + $variations;
        }else{
             $subtotal = $prjprt->costing_quantity;
        }

       
        
           $uninvoiced_quantity = $subtotal - $invoiced_quantity;
           
                ?>
             <tr>
                <td><?php echo $prjprt->stage_name; ?></td>
                <td><?php echo $prjprt->costing_part_name; ?></td>
                <td><?php echo $prjprt->component_name;?></td>
                <td><?php echo $prjprt->supplier_name;?></td>
                <td>$<?php echo number_format($prjprt->project_costing_cost, 2, ".", ",");?></td>
                <td><a target="_Blank" href="<?php echo base_url();?>reports/variations/<?php echo $prjprt->costing_part_id;?>">$<?php echo number_format($variation_amount, 2, ".", ",");?></a></td>
                <td>$<?php echo number_format($prjprt->project_costing_cost+$variation_amount, 2, ".", ",");?></td>
                <td><a target="_Blank" href="<?php echo base_url();?>reports/supplierinvoices/<?php echo $prjprt->costing_part_id;?>">$<?php echo number_format($invoiced_amount, 2, ".", ",");?></a></td>
                <td><?php
                
                echo "$".number_format(($prjprt->project_costing_cost + $variation_amount)-$invoiced_amount, 2, ".", ",");
                ?></td>
            </tr>
            <?php 
            $count++;

    }						
} else{ ?>
    <tr>
       <td colspan="9">No record found</td>
   </tr>
   <?php }?>
</tbody>
</table>
<?php if($prjprts){ ?>
<div class="row">
    <div class="col-md-12">
     <div class="form-footer">
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_budget_vs_actual_report" method="post" class="print">
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_project_id" name="report_project_id" value="">
            <input class="btn btn-success" type="submit" id="" name="" value="Export To Excel" onclick="changeReportType('excel', 'budget_vs_actual');">
            <input class="btn btn-success" type="submit" id="" name="" value="Export To PDF" onclick="changeReportType('pdf', 'budget_vs_actual');">
        </form>
    </div>
</div>
</div>
<?php } ?>