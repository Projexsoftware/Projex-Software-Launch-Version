<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.title{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
.pro_address{ width:100%;}
thead tr td{background-color:#ccc;font-weight:bold;text-align:left;font-size:16px;}
tbody tr td{padding:5px;text-align:left;}
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
.variation_column{
    background:lightgoldenrodyellow;
}
.pro_address{ width:100%; text-align:left;}
</style>

<div id="row">
   <div class="col-sm-12">
     <h3 class="table_pro_name">Updated Specifications Report</h3>
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
           <?php echo $project_name['project_title']; ?>
	   </h4>
   </div>
<div class="col-sm-12 width_half2">
    				<div class="col-sm-12">
	    				<h4 class="pro_address">
	    				<b>Project Address:
	    				<?php 
	    					echo $project_info['street_pobox'] . ' ' .
	    					$project_info['suburb'] . ', ' .
	    					$project_info['project_address_city'] . ', ' .
							$project_info['project_address_state'] . ', ' .
							$project_info['project_address_country'] . ', ' .
							$project_info['project_zip'];
	    				?></b>
	    				</h4>
    				</div>
    			</div>
    <div class="col-md-12">
        <div class="project_report_container material-datatables">
              <?php foreach ($stages as $key => $stage): ?>
<?php if (in_array($stage["stage_id"], $saved_stages)) : ?>
<div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"> <?php echo $stage["stage_name"]; ?></h3>
        </div>
<div class="panel-body">
   <table class="table table-striped table-no-bordered table-hover datatables print_table" cellspacing="0" width="100%" style="width:100%" >
    <thead>
      <tr>
                <th style="background-color:#495B6C; color:#fff;">Part</th>
                <th style="background-color:#495B6C; color:#fff;">Comment</th>
                <th style="background-color:#495B6C; color:#fff;">Component</th>
                <th style="background-color:#495B6C; color:#fff;">Image</th>
            </tr>
    </thead>
    <tbody>

      <?php 
      if($prjprts){
         $count = 1; 
        foreach ($prjprts As $key => $prjprt) { 
            if ($prjprt->stage_id == $stage["stage_id"]) { 
             ?>
             <tr>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php echo $prjprt->costing_part_name; ?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php echo $prjprt->comment;?></td>
                <td <?php if($prjprt->costing_type != "normal"){ ?> style="background:lightgoldenrodyellow;" <?php } ?>><?php 
                if($prjprt->costing_type=="autoquote"){
					$summary_info = get_summary_info_by_autoquote($prjprt->costing_tpe_id);
					echo $summary_info["component_name"];
                }
                else{
                echo $prjprt->component_name;
                }
                ?></td>
                <td id=component_img>
                               <?php 
                                    if($prjprt->costing_type=="autoquote"){ ?>
                                      <img src="<?php echo base_url('assets/autoquote/'.get_autoquote_image($prjprt->costing_tpe_id));?>" style="width: 80px; height: 50px;">
                                     
                                    <?php }else{
                                    if($prjprt->component_image){?>
                                        <img src="<?php echo base_url('assets/components/thumbnail/'.$prjprt->component_image);?>" style="width: 80px; height: 50px;">
                                        <?php } }?>
                            </td> 
            </tr>
            <?php 
            $count++;
            }
        }	          
        ?>
        
        <?php } else{ ?>
        <tr>
          <td colspan="15">No record found</td>
        </tr>
        <?php }?>
      </tbody>
    </table>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
        </div>
    </div>
    
</div>
