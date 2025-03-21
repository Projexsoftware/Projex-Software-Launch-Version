<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
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

   background-color: #f9f9f9!important;

   padding:10px!important;

}
.tab_info{
  float: right;
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
</style>

<div id="row">
   <div class="col-sm-12">
     <h3 class="table_pro_name">Project Uninvoiced Components Report</h3>
   </div>
 </div>
<div id="row">
    <div class="col-sm-12">
   <div class="col-md-3 desktop_logo">
    <img style="width:100%;" src="<?php echo SURL.'/assets/company/thumbnail/'.$company_info["com_logo"];?>">
  </div>
  <div class="col-md-6 desktop_logo">&nbsp;</div>
  <div class="col-md-3 desktop_logo">
   <table class="tab_info">
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
           <p><?php echo $project_name['project_title']; ?></p>
			<p><?php echo $project_name['street_pobox'].", ".$project_name['suburb'].", ".$project_name['project_address_city'].", ".$project_name['project_address_state'].", ".$project_name['project_address_country'].", ".$project_name['project_zip'];?></p>
       </h4>
   </div>
    <div class="col-md-12">
        <div class="project_report_container material-datatables">
  <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
   <thead>
            <tr>
                <th style="background-color:#495B6C!important; color:#fff;">Sr No</th>
                <th style="background-color:#495B6C!important; color:#fff;">Supplier</th>
                <th style="background-color:#495B6C!important; color:#fff;">Stages Required</th>
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
									<br/><p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/user.png';?>"> <?php echo $prjprt->supplier_contact_person;?></p>
									<br/><p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/link.png';?>"> <?php echo $prjprt->supplier_web;?></p>
									<br/><p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/telephone-handle-silhouette.png';?>"> <?php echo $prjprt->supplier_contact_person_mobile;?></p>
									<br/><p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/mobile-phone.png';?>"> <?php echo $prjprt->supplier_phone;?></p>
									<br/><p><img style="width:16px;" src="<?php echo base_url() .'/assets/icons/envelope.png';?>"> <?php echo $prjprt->supplier_email;?>></p>
									</td>
									<td><?php
									if(count($stages[$prjprt->costing_supplier])>0){
									foreach($stages[$prjprt->costing_supplier] as $stage){
									?>
									    <p><?php echo $stage->stage_name;?></p><br/>
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
  </div>
    </div>
</div>
