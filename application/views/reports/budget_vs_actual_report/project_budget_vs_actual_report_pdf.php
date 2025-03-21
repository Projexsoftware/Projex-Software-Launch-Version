<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.col-md-6{
    float:left;
    width:45%;
}
.title{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
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
     <h3 class="table_pro_name">Budget VS Actual Report</h3>
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
          //echo '<pre>';print_r($prjprts);
        $count = 1; 
        foreach ($prjprts As $key => $prjprt) { 
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
       
            //if($uninvoiced_quantity>0){	
                ?>
             <tr>
                <td><?php echo $prjprt->stage_name; ?></td>
                <td><?php echo $prjprt->costing_part_name; ?></td>
                <td><?php echo $prjprt->component_name;?></td>
                <td><?php echo $prjprt->supplier_name;?></td>
                <td>$<?php echo number_format($prjprt->project_costing_cost, 2, ".", ",");?></td>
                <td>$<?php echo number_format($variation_amount, 2, ".", ",");?></td>
                <td>$<?php echo number_format($prjprt->project_costing_cost+$variation_amount, 2, ".", ",");?></td>
                <td>$<?php echo number_format($invoiced_amount, 2, ".", ",");?></td>
                <td><?php
                /*echo "Variation id:".$prjprt->is_variated."<br/>";
                echo "Variation id:".$parts->variation_id."<br/>";
                echo "Costing Part Id:".$prjprt->costing_part_id."<br/>";
                echo "Project Costing :".$prjprt->project_costing_cost."<br/>";
                 echo "Variation Amount :".$variation_amount."<br/>";
                  echo "Invoiced Amount :".$invoiced_amount."<br/>";*/
                  
                echo "$".number_format(($prjprt->project_costing_cost + $variation_amount)-$invoiced_amount, 2, ".", ",");
                ?></td>
            </tr>
            <?php 
            $count++;
          //} 
        }           
        ?>
        
        <?php } else{ ?>
        <tr>
          <td colspan="9">No record found</td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
    </div>
</div>
