<style>
.project_summary_container h5.label{
  font-size:13px;
  padding:5px 15px;
}
.card-product .card-image img {
    height: auto;
}
</style>
<div class="toolbar">
<?php 
$is_images = 0;
if(count($tasks)>0){
foreach($tasks as $val){

$current_role = 1;

$images = get_project_summary_images($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($images)>0){ 
$is_images = 1;
?>
<h5 class="label label-rose"><?php echo $val['task_name'];?></h5>
<br/><br/>
<div class="row">                                                       
                                                            <?php 
                                                            
                                                            foreach($images as $image){ ?>

                       <div class="col-md-4">
                            <div class="card card-product">
                                <div class="card-image" data-header-animation="true">
                                       <a href="#pablo">
                                            <img class="img" src="<?php echo TASK_PATH.'images/'.$image['file'];?>">
                                       </a>
                                </div>
                                <div class="card-content">
                                    <div class="card-actions">
                                       <a rel="tooltip" data-placement="bottom" title="Download" class="btn btn-success btn-simple btn-icon" href="<?php echo SCURL;?>projects/download_image/<?php echo $image['file'];?>"><i class="material-icons">file_download</i></a>
                                    </div>
                                    <h4 class="card-title"><?php echo $image["description"];?></h4>
                                </div>
                                <div class="card-footer">
                                    <?php 
                                    if($current_role==1 || $current_role==2){
                                    if($image['uploaded_at']!=""){ ?>
                                    <div class="stats pull-left">
                                        <p class="category"><i title="Uploaded By" class="fa fa-user"></i> <?php echo get_user_info($image['uploaded_by']);?></p>
                                    </div>
                                    <div class="stats pull-right">
                                        <p class="category"><i title="Uploaded At" class="fa fa-clock-o"></i> <?php echo date("d/m/Y h:i A", strtotime($image['uploaded_at']));?></p>
                                    </div>
                                    <?php } } ?>
                                </div>
                            </div>  
                       
                            </div> 
                                                                						 

                                                            <?php }
?>
</div>
<?php 
}  
}
}
if($is_images==1){ ?>
<form action="<?php echo SCURL.'reports/export';?>" method="post">
<input type="hidden" name="project_id" value="<?php echo $tasks[0]['project_id'];?>">
<input type="hidden" name="summary_type" value="images">
<input type="submit" class="btn btn-rose" value="Export As PDF">
</form>
<?php }
if($is_images==0){ ?>
<h5 class="label label-danger">No Images Added Yet</h5>
<?php }
?>
</div>
</div>
</div>
</div>                                                      </div>
                                                        
                                                   