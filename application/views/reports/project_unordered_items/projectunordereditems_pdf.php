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
</style>

<div id="row">
   <div class="col-sm-12">
     <h3 class="table_pro_name">Project Unordered Items Report</h3>
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
           Project Name:
           <?php echo $project_name['project_title']; ?>
       </h4>
   </div>
    <div class="col-md-12">
        <div class="project_report_container material-datatables">
  <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
   <thead>
            <tr>
                <th style="background-color:#495B6C!important; color:#fff;">Sr No</th>
                <th style="background-color:#495B6C!important; color:#fff;">Stage name</th>
                <th style="background-color:#495B6C!important; color:#fff;">Part</th>
                <th style="background-color:#495B6C!important; color:#fff;">Component</th>
                <th style="background-color:#495B6C!important; color:#fff;">Supplier</th>
                <th style="background-color:#495B6C!important; color:#fff;">QTY</th>
                <th style="background-color:#495B6C!important; color:#fff;">Unit Of Measure</th>
                <th style="background-color:#495B6C!important; color:#fff;">Variations</th>
                <th style="background-color:#495B6C!important; color:#fff;">Subtotal</th>
                <th style="background-color:#495B6C!important; color:#fff;">Purchase Orders</th>
                <th style="background-color:#495B6C!important; color:#fff;">Unordered Quantity</th>
            </tr>

        </thead>
        <tbody>

            <?php if(isset($stages) && count($stages)>0){
               $count = 1;
               foreach ($stages as $key => $stage){ ?>
               <?php foreach ($prjprts As $key => $prjprt) { ?>
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
    					$variations =0; 
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
                   ?>

                   <tr>
                    <td><?php echo $count;?></td>
                    <td><?php echo $stage["stage_name"]; ?></td>
                    <td><?php echo $prjprt->costing_part_name; ?></td>
                    <td><?php echo $prjprt->component_name;?></td>
                    <td><?php echo $prjprt->supplier_name;?></td>
                   <!--  <td><?php echo $prjprt->costing_quantity;?></td> -->
                   <td><?php echo ($prjprt->is_variated==0) ? $prjprt->costing_quantity : 0;?></td> 
                    <td><?php echo $prjprt->costing_uom;?></td>
                   <!--  <td><?php echo $subtotal-$prjprt->costing_quantity;?></td> -->
                  <td><?php echo ($prjprt->is_variated==0) ? $variations : $prjprt->costing_quantity;?></td>
                    <td><?php echo $subtotal;?></td>
                    <td><?php echo $ordered_quantity;?></td>
                    <td><?php echo $unordered_quantity;?></td>
                </tr>
                <?php $count++;?>

                <?php }
            }
        }   

        ?>
        <?php } else{ ?>
        <tr>
         <td colspan="11">No record found</td>
     </tr>
     <?php }?>
 </tbody>
    </table>
  </div>
    </div>
</div>
