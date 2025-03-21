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
     <h3 class="table_pro_name">Project Uninvoiced Components Report</h3>
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
                <td><?php echo number_format($subtotal, 2, ".", ",");?></td>
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
        ?>
        
        <?php } else{ ?>
        <tr>
          <td colspan="11">No Records Found</td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
    </div>
</div>
