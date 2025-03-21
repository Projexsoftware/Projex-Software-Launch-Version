<style>
.project_summary_container h5.label{
  font-size:13px;
  padding:5px 15px;
}
.list_container .btn, .list_container{
   padding-left: 0px!important;
   padding-right: 10px!important;
   padding-top: 0px!important;
   padding-bottom: 0px!important;
   list-style: none;
}
.list_container{
   margin-bottom:0px;
}
</style>
<div class="toolbar">
<?php 
$is_files = 0;
if(count($tasks)>0){
foreach($tasks as $val){

$current_role = 1;
$files = get_project_summary_files($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($files)>0){ 
$is_files = 1;
?>
<h5 class="label label-rose"><?php echo $val['task_name'];?></h5>
<br/>
<div class="row">                                                       
                                                            

                       <div class="col-md-6">
                            <div class="card card-product">
                            <div class="card-content">
                                    <ul class='list_container'><?php 
                                                            
                                                            foreach($files as $file){ ?><li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $file['file_original_name'];?>
                                                            <?php if($current_role==1 || $current_role==2){ ?>
                                                            <a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo SCURL;?>projects/download_file/<?php echo $file['file'];?>"><i class="material-icons">file_download</i></a>
                                                            <?php if($file['uploaded_at']!=""){ ?>
                                                             <br/><p class="text-right"><i class="fa fa-user" title="Uploaded By"></i> <?php echo get_user_info($file['uploaded_by']);?>&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o" title="Uploaded At"></i> <?php echo date("d/m/Y h:i A", strtotime($file['uploaded_at']));?></p>
                                                            <?php } 
                                                             } ?>
                                                            </li><?php }
?></ul>
                                    </div>
                                    <div class="card-footer">
                                    <?php if($file['uploaded_at']!=""){ ?>
                                    <div class="stats pull-left">
                                        <p class="category"><i title="Uploaded By" class="fa fa-user"></i> <?php echo get_user_info($file['uploaded_by']);?></p>
                                    </div>
                                    <div class="stats pull-right">
                                        <p class="category"><i title="Uploaded At" class="fa fa-clock-o"></i> <?php echo date("d/m/Y h:i A", strtotime($file['uploaded_at']));?></p>
                                    </div>
                                    <?php } ?>
                                </div>
                                   </div>
                            </div>  
                       
                            </div> 
                                                                						 

                                                            
</div>
<?php 
}  
}
}
if($is_files==1){ ?>
<form action="<?php echo SCURL.'reports/export';?>" method="post">
<input type="hidden" name="project_id" value="<?php echo $tasks[0]['project_id'];?>">
<input type="hidden" name="summary_type" value="files">
<input type="submit" class="btn btn-rose" value="Export As PDF">
</form>
<?php }
if($is_files==0){ ?>
<h5 class="label label-danger">No Files Added Yet</h5>
<?php }
?>
</div>
</div>
</div>
</div>                                                      </div>
                                                        
                                                   