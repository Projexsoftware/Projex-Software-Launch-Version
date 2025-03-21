 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
    <thead>
		<tr>
			<th style="background-color:#495B6C; color:#fff;">Sr No</th>
			<th style="background-color:#495B6C; color:#fff;">Stage name</th>
			<th style="background-color:#495B6C; color:#fff;">Part</th>
			<th style="background-color:#495B6C; color:#fff;">Component</th>
			<th style="background-color:#495B6C; color:#fff;">Supplier</th>
			<th style="background-color:#495B6C; color:#fff;">QTY</th>
			<th style="background-color:#495B6C; color:#fff;">Unit Of Measure</th>
			<th style="background-color:#495B6C; color:#fff;">Variations</th>
			<th style="background-color:#495B6C; color:#fff;">Subtotal</th>
			<th style="background-color:#495B6C; color:#fff;">Purchase Orders</th>
			<th style="background-color:#495B6C; color:#fff;">Unordered Quantity</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($stages) && count($stages)>0){
			$count = 1; 
			foreach ($stages as $key => $stage){ ?>                     

			<?php 
			foreach ($prjprts As $key => $prjprt) { ?>

			<?php if ($prjprt->stage_id == $stage["stage_id"]) { 
			    
			    $parts = get_uninvoiced_components($prjprt->costing_part_id);
			    
			    
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
				    $variations = 0;
				}
				
				$variation_info = get_variation_info_by_costing_id($prjprt->costing_part_id);
				if(count($variation_info)>0){
				foreach($variation_info as $vinfo){
				    $variations += $vinfo['change_quantity'];
				}
				}
				
				$ordered_quantity = get_ordered_quantity($prjprt->costing_part_id);
				
						
							if($prjprt->is_variated==0){
								$subtotal = $prjprt->costing_quantity + $variations;
							}else{
								$subtotal = $prjprt->costing_quantity;
							}
						
								$unordered_quantity = $subtotal-$ordered_quantity;

if($unordered_quantity>0){
								?>
								<tr>
									<td><?php echo $count;?></td>
									<td><?php echo $stage["stage_name"]; ?></td>
									<td><?php echo $prjprt->costing_part_name; ?></td>
									<td><?php echo $prjprt->component_name;?></td>
									<td><?php echo $prjprt->supplier_name;?></td>
									<!--  <td><?php echo $prjprt->costing_quantity;?></td> -->
									<td><?php echo ($prjprt->is_variated==0) ? $prjprt->costing_quantity : 0;?></td> <!-- if the reocrd is a variation -->
									<td><?php echo $prjprt->costing_uom;?></td>
									<!--  <td><?php echo $variations;?></td> -->
									<td><?php echo ($prjprt->is_variated==0) ? $variations : $prjprt->costing_quantity;?></td> <!-- if the reocrd is a variation -->
									<td><?php echo $subtotal;?></td>
									<td><?php echo $ordered_quantity;?></td>
									<td><?php echo $unordered_quantity;?></td>
								</tr>

								<?php 
								$count++;
}
							}
							
						}

					}	
					?>

					<?php } else{ ?>
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
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_component_unordered_items" method="post" class="print">
            <a href="javascript:window.print()" class="btn btn-success no_print">Print</a>
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_project_id" name="report_project_id" value="">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To Excel" onclick="changeReportType('excel', 'component_unordered_items');">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To PDF" onclick="changeReportType('pdf', 'component_unordered_items');">
        </form>
    </div>
</div>
</div>
<?php } ?>