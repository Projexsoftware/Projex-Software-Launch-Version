<?php if(count($saved_stages)>0){ ?>
 <div class="row">
    			<div class="col-sm-12">
    				<div class="col-sm-12 homeworx_logo_container">
	    			<img src="<?php echo base_url(); ?>assets/img/homeworx_logo.png">
    				</div>
    			</div>
</div>
<div class="row">
    				<div class="col-sm-12">
	    				<h4 class="table_pro_name">
	    				Project Name:
	    				<?php echo $project_name['project_title']; ?>
	    				</h4>
                        
    				</div>
</div>
<div class="row">
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
                
</div>
<?php } else{ ?>
<div class="row">
    <div class="col-md-12">
        <p class="text-danger">No Records Found</p>
    </div>
</div>
<?php } ?>

 <div class="row">
    <div class="col-md-12">
<?php foreach ($stages as $key => $stage): 
?>
<?php if (in_array($stage["stage_id"], $saved_stages)) : ?>
<div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"> <?php echo $stage["stage_name"]; ?></h3>
        </div>
<div class="panel-body">
<table class="table table-bordered table-striped table-hover print_table">
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
            
            if($prjprt->costing_type != "normal"){
                $className = "variation_column";
            }
            else{
                $className = "";
            }
                ?>
             <tr>
                <td class="<?php echo $className;?>"><?php echo $prjprt->costing_part_name; ?></td>
                <td class="<?php echo $className;?>">
                    <?php echo $prjprt->comment;?>
                </td>
                <td class="<?php echo $className;?>"><?php 
                if($prjprt->costing_type=="autoquote"){
					$summary_info = get_summary_info_by_autoquote($prjprt->costing_tpe_id);
					echo $summary_info["component_name"];
                }
                else{
                echo $prjprt->component_name;
                }
                ?></td>
                <td class="<?php echo $className;?>" id=component_img>
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
} else{ ?>
    <tr>
       <td colspan="15">No Records Found</td>
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
<?php if($prjprts){ ?>
<div class="row">
    <div class="col-md-12">
     <div class="form-footer">
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_updated_specifications" method="post" class="print">
            <a href="javascript:window.print()" class="btn btn-success no_print">Print</a>
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_project_id" name="report_project_id" value="<?php echo $costing_id;?>">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export as PDF">
        </form>
    </div>
</div>
</div>
<?php } ?>