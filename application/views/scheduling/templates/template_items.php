<div class="panel-group col-md-12" id="accordionStages" role="tablist" aria-multiselectable="true">
<input type="hidden" id="sortable_stages" class="form-control"/>
<?php
                                  if(count($template_stages)>0){
                                  foreach($template_stages as $val){
                                ?>
                                        <div id="<?php echo $val['stage_id'];?>" class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTaskItem<?php echo $val['stage_id'];?>">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionStages" href="#taskItem<?php echo $val['stage_id'];?>" aria-expanded="true" aria-controls="taskItem<?php echo $val['stage_id'];?>">
                                                    <h4 class="panel-title">
                                                        <?php echo $val['stage_name'];?><div style="display:inline" class="stage_<?php echo $val['stage_id'];?>" item_count="<?php echo count(get_template_item_by_stage($val['stage_id'], $template_edit['id']));?>">&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
$stage_status = get_template_stage_status($template_edit['id'], $val['stage_id'], count(get_template_item_by_stage($val['stage_id'], $template_edit['id'])));
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
                                            <div id="taskItem<?php echo $val['stage_id'];?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTaskItem<?php echo $val['stage_id'];?>">
                                             <div class="panel-body">
                                               <div class="table-responsive table-<?php echo $val['stage_id'];?>">
                                                 <table id="table_<?php echo $val['stage_id'];?>" class="table sortable_table">
                                                   <tbody>
                                                      <?php 
                                                      $template_items = get_template_item_by_stage($val['stage_id'], $template_id);
                                                      $i=1;
                                                      foreach($template_items as $item){
                                                      ?>
                                                         <tr rowno="<?php echo $item['id'];?>">
<input class="form-control" type="hidden" name="task_id<?php echo $item['id'];?>" id="task_id<?php echo $item['id'];?>" value="<?php echo $item['task_id'];?>"/>
<input class="form-control" type="hidden" name="stage_id<?php echo $item['id'];?>" id="stage_id<?php echo $item['id'];?>" value="<?php echo $item['stage_id'];?>"/>
<td class="priority"><?php echo $i;?></td>
                                                           <td><?php echo $item['task_name'];?></td>
                                                           <td>
                                            <?php include("application/views/scheduling/templates/task_items/checklist.php");?>
                                                           </td>
                                                           <td>
                                                <?php include("application/views/scheduling/templates/task_items/notes.php");?>
                                                           </td>
                                                           <td>
                                                <?php include("application/views/scheduling/templates/task_items/files.php");?>
                                                           </td>
                                                           <td>
                                                <?php include("application/views/scheduling/templates/task_items/images.php");?>
                                                           </td>
                                                           
                                                           <td><div id="status<?php echo $item['id'];?>"><?php if($item['status']==0){?> <span class="label label-danger">Not Done</span> <?php } else if($item['status']==1     ){ ?> <span class="label label-warning">Partially Done</span><?php } else{ ?><span class="label label-success">Complete</span> <?php } ?></div></td>
                                                           <td><a rowno="<?php echo $item['id'];?>" class="remove_task btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a></td>
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
