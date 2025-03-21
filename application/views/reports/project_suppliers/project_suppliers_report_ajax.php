 <div class="row">
	<div class="col-sm-12">
		<h4 class="table_pro_name">
			<p><?php echo $project_name['project_title']; ?></p>
			<p><?php echo $project_name['street_pobox'].", ".$project_name['suburb'].", ".$project_name['project_address_city'].", ".$project_name['project_address_state'].", ".$project_name['project_address_country'].", ".$project_name['project_zip'];?></p>
		</h4>

	</div>
</div>
 <table class="table table-striped table-no-bordered table-hover datatables print_table" cellspacing="0" width="100%" style="width:100%" >
    <thead>
        <tr>
            <th style="background-color:#495B6C; color:#fff;">Sr No</th>
			<th style="background-color:#495B6C; color:#fff;">Supplier</th>
			<th style="background-color:#495B6C; color:#fff;">Stages Required</th>
        </tr>
    </thead>
	 	<tbody>
			<?php 
			if(count($prjprts)>0){
			$count = 1;
			foreach ($prjprts As $key => $prjprt) { ?>
								<tr>
									<td><?php echo $count;?></td>
									<td><p><?php echo $prjprt->supplier_name; ?></p>
									<p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/user.png';?>"> <?php echo $prjprt->supplier_contact_person;?></p>
									<p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/link.png';?>"> <?php echo $prjprt->supplier_web;?></p>
									<p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/telephone-handle-silhouette.png';?>"> <?php echo $prjprt->supplier_contact_person_mobile;?></p>
									<p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/mobile-phone.png';?>"> <?php echo $prjprt->supplier_phone;?></p>
									<p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/envelope.png';?>"> <?php echo $prjprt->supplier_email;?>></p>
									</td>
									<td><?php
									if(count($stages[$prjprt->costing_supplier])>0){
									foreach($stages[$prjprt->costing_supplier] as $stage){
									?>
									    <p><?php echo $stage->stage_name;?></p>
									<?php
									}
									}
									?></td>
								</tr>

								<?php 
								$count++;
            }
			?>
			<?php } else{ ?>
			<tr>
				<td colspan="3">No record found</td>
			</tr>
		<?php }?>
	</tbody>
</table>
<?php if($prjprts){ ?>
<div class="row">
    <div class="col-md-12">
     <div class="form-footer">
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_project_suppliers_report" method="post" class="print">
            <a href="javascript:window.print()" class="btn btn-success no_print">Print</a>
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_project_id" name="report_project_id" value="">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To Excel" onclick="changeReportType('excel', 'project_suppliers');">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To PDF" onclick="changeReportType('pdf', 'project_suppliers');">
        </form>
    </div>
</div>
</div>
<?php } ?>