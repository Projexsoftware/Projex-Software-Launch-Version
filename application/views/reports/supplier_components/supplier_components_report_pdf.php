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

td > img{
    width:50px!important;
    height:50px!important;
}
th {
  border: 1px solid #eee!important;
  padding:10px;
}

tr:nth-child(odd) td{

   background-color: #f9f9f9!important;

   padding:10px!important;

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
.col-md-6{
    float:left;
    width:45%;
}
</style>

<div id="row">
   <div class="col-md-12">
     <h3 class="table_pro_name">Supplier Components Report</h3>
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
           <?php echo $suppliers['supplier_name']; ?>
		</h4>
   </div>
    <div class="col-md-12">
        <div class="project_report_container material-datatables">
  <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Component Image</th>
                <th>Component Name</th>
                <th>Description</th>
                <th>Unit of Measure</th>
                <th>Unit Cost</th>
                <th>Date</th>
            </tr>
            </thead>
                                                                   
            <tbody>
                                                                
                <?php 
                    if (count($supplier_components) > 0) {
                ?>
                <?php  
                $count =1; 
                foreach($supplier_components as $supplier_component) { ?>
                    <tr>
                        <td><?php echo $count;?></td>
                        <td><img width="50" src="<?php if($supplier_component['image']!="") { echo COMPONENT_IMG.'thumbnail/'.$supplier_component['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>"/></td>
                        <td><?php echo $supplier_component['component_name'];?></td>
                        <td><?php echo $supplier_component['component_des'];?></td>
                        <td><?php echo $supplier_component['component_uom'];?></td>
                        <td><?php echo $supplier_component['component_uc'];?></td>
                        <td><?php echo date("d/m/Y", strtotime($supplier_component['date_created']));?></td>
                    </tr>
                    <?php $count++;
                    } 
                } else { ?>
                    <tr>
                        <td colspan="7"><?php echo 'No Components found for this supplier';?></td>
                    </tr>
                <?php } ?>
                                                                    
        </tbody>
</table>
  </div>
    </div>
</div>
