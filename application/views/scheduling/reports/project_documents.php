<style>
.project_summary_container h5.label{
  font-size:13px;
  padding:5px 15px;
}
</style>
<div class="toolbar">
<?php 
$is_document = 0;
  
$current_role = 1;
  
$project_documents = get_project_documents($project_id, $current_role);
if(count($project_documents)>0){ 
$is_document = 1;
echo "<ul class='list_container'>"; foreach($project_documents as $val){ ?>
                                                       <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $val['document'];?><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo SURL.'assets/project_plans_and_specifications/'.$val['document'];?>" target="_Blank"><i class="material-icons">file_download</i></a>
                                        </li>
                                                        <?php } echo "</ul>";} ?>
</div>
<?php
if($is_document==1){ ?>
<form action="<?php echo SCURL.'reports/export';?>" method="post">
<input type="hidden" name="project_id" value="<?php echo $project_id;?>">
<input type="hidden" name="summary_type" value="documents">
<input type="submit" class="btn btn-rose" value="Export As PDF">
</form>
<?php }
if($is_document==0){ ?>
<h5 class="label label-danger">No Documents Uploaded Yet</h5>
<?php }
?>
</div>
</div>
</div>
</div>                                                      </div>
                                                        
                                                   