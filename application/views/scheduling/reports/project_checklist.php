<style>
.project_summary_container h5.label{
  font-size:13px;
  padding:5px 15px;
}
</style>
<div class="toolbar">
<?php 
$is_checklist = 0;
if(count($tasks)>0){
foreach($tasks as $val){
  
  $current_role = 1;
  $checklists = get_project_summary_checklist($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($checklists)>0){ 
$is_checklist = 1;
?>
<h5 class="label label-rose"><?php echo get_stage_name($val['stage_id'])." - ".$val['task_name'];?></h5>
<div class="row">
<div class="col-md-12">
                                                         <ul class="list_container">
                                                        
                                                            <?php 
                                                            
                                                            foreach($checklists as $checklist){ 
                                                            $item_checklist = get_item_selected_checklists($checklist['item_id']);
                                                            
                                                            if($item_checklist!=""){$task_checklist = explode(",", $item_checklist);}else{ $task_checklist = array();}
                                                            
                                                            ?>

                                                            <li>
                                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="checklist;?>" rowno="<?php echo $checklist['id'];?>" value="<?php echo $checklist['id'];?>" <?php if(in_array($checklist['id'], $task_checklist)){ ?> checked <?php } ?>  disabled> <?php echo $checklist['name'];?>
                                                    </label>
                                                </div> 
                                                
                                                          </li>

                                                            <?php }  ?>
                                                         
                                                        </ul>
</div>
</div>
<?php 
}  
}
}
if($is_checklist==1){ ?>
<form action="<?php echo SCURL.'reports/export';?>" method="post">
<input type="hidden" name="project_id" value="<?php echo $tasks[0]['project_id'];?>">
<input type="hidden" name="summary_type" value="checklist">
<input type="submit" class="btn btn-rose" value="Export As PDF">
</form>
<?php }
if($is_checklist==0){ ?>
<h5 class="label label-danger">No Checklist Added Yet</h5>
<?php }
?>
</div>
</div>
</div>
</div>                                                      </div>
                                                        
                                                   