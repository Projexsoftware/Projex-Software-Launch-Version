<?php 
  /*$project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
  $current_role = $project_role['team_role'];
  if($current_role==""){*/
    $current_role = 1;
  //}
  
?>
<div class="panel-group col-md-12" id="accordionStages" role="tablist" aria-multiselectable="true">
<input type="hidden" id="sortable_stages" class="form-control"/>
<?php
                                  if(count($project_stages)>0){
                                  foreach($project_stages as $val){
                                ?>
                                        <div id="<?php echo $val['stage_id'];?>" class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTaskItem<?php echo $val['stage_id'];?>">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionStages" href="#taskItem<?php echo $val['stage_id'];?>" aria-expanded="true" aria-controls="taskItem<?php echo $val['stage_id'];?>">
                                                    <h4 class="panel-title">
                                                        <?php echo $val['stage_name'];?><div style="display:inline" class="stage_<?php echo $val['stage_id'];?>" item_count="<?php echo count(get_project_item_by_stage($val['stage_id'], $project_id));?>">&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
$stage_status = get_stage_status($project_id, $val['stage_id'], count(get_project_item_by_stage($val['stage_id'], $project_id)));
if($stage_status == 0){ ?>                        
<span class="label label-danger">Not Done</span>
<?php } else if($stage_status == 1){ ?>
<span class="label label-warning">Partially Done</span>
<?php } else { ?>
<span class="label label-success">Complete</span>
<?php } ?>
</div>
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="taskItem<?php echo $val['stage_id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTaskItem<?php echo $val['stage_id'];?>">
                                             <div class="panel-body">
                                               <div class="table-responsive">
                                                 <table id="table_<?php echo $val['stage_id'];?>" class="table sortable_table">
                                                   <tbody>
                                                      <?php 
                                                      $project_items = get_project_item_by_stage($val['stage_id'], $project_id);
                                                      $i=1;
                                                      foreach($project_items as $item){
                                                      $hasLinks = checkTasksDependands($project_id, $item['dependent_id'], $item['id']);
                                                      ?>
                                                         <tr rowno="<?php echo $item['id'];?>" hasLinks="<?php if($hasLinks){ echo "true";} else{ echo "false"; }?>">
<input class="form-control" type="hidden" name="task_id<?php echo $item['id'];?>" id="task_id<?php echo $item['id'];?>" value="<?php echo $item['task_id'];?>"/>
<input class="form-control" type="hidden" name="stage_id<?php echo $item['id'];?>" id="stage_id<?php echo $item['id'];?>" value="<?php echo $item['stage_id'];?>"/>
<td class="priority"><?php echo $i;?></td>
                                                           <td><?php 
                                                           if($item['parent_item_id']>0){
                                                           $part_name = get_part_name($item['parent_item_id']);
                                                           echo $part_name." - ".$item['task_name'];
                                                           }
                                                           else{
                                                               echo $item['task_name']; 
                                                           }
                                                           ?>
                                                           </td>
                                                           <td>
                                            <?php include("application/views/scheduling/projects/task_items/checklist.php");?>
                                                           </td>
                                                           <td>
                                                <?php include("application/views/scheduling/projects/task_items/notes.php");?>
                                                           </td>
                                                           <td>
                                                <?php include("application/views/scheduling/projects/task_items/files.php");?>
                                                           </td>
                                                           <td>
                                                <?php include("application/views/scheduling/projects/task_items/images.php");?>
                                                           </td>
                                                           <td><div id="status<?php echo $item['id'];?>"><?php if($item['status']==0){?> <span class="label label-danger">Not Done</span> <?php } else if($item['status']==1     ){ ?> <span class="label label-warning">Partially Done</span><?php } else{ ?><span class="label label-success">Complete</span> <?php } ?></div></td>
                                                           <td>
                                                           <a rowno="<?php echo $item['id'];?>" class="task_actions remove_task btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                           </td>
                                                         </tr>
                                                      <?php $i++; } ?>
                                                    </tbody>
                                                   </table>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                     
                                <?php } 
                                   }
                                ?>
</div>
