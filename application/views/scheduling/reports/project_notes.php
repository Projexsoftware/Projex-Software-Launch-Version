<style>
.project_summary_container h5.label{
  font-size:13px;
  padding:5px 15px;
}
</style>
<div class="toolbar">
<?php 
$is_notes = 0;
if(count($tasks)>0){
foreach($tasks as $val){
  
  $current_role = 1;
  $notes = get_project_summary_notes($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($notes)>0){ 
$is_notes = 1;
?>
<h5 class="label label-rose"><?php echo $val['task_name'];?></h5>
<div class="row">
<div class="col-md-6">
                                                         <ul class="timeline timeline-simple">
                                                            <?php 
                                                            
                                                            foreach($notes as $note){ ?>

                                                          
                                <li class="timeline-inverted">
                                    <div class="timeline-badge success">
                                        <i class="material-icons">description</i>
                                    </div>
                                    <div class="timeline-panel">
                                        
                                        <div class="timeline-heading">
                                            <span class="label label-success"><?php echo $note['author'];?></span>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $note['note'];?></p>
                                        </div>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo date("M d, Y", strtotime($note['date']));?>
                                        </h6>
                                    </div>
                                </li>
                                                                						 


                                                            <?php }
?>
</ul>
</div>
</div>
<?php 
}  
}
}
if($is_notes==1){ ?>
<form action="<?php echo SCURL.'reports/export';?>" method="post">
<input type="hidden" name="project_id" value="<?php echo $tasks[0]['project_id'];?>">
<input type="hidden" name="summary_type" value="notes">
<input type="submit" class="btn btn-rose" value="Export As PDF">
</form>
<?php }
if($is_notes==0){ ?>
<h5 class="label label-danger">No Notes Added Yet</h5>
<?php }
?>
</div>
</div>
</div>
</div>                                                      </div>
                                                        
                                                   