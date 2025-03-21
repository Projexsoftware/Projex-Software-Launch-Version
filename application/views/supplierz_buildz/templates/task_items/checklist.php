<div class="checklist_container<?php echo $item['id'];?>">
<?php $checklists = get_buildz_template_task_checklist($item['template_id'], $item['id']);?>
<?php if($item['checklist']!=""){$task_checklist = explode(",", $item['checklist']);}else{ $task_checklist = array();} ?>
<a class="btn btn-primary btn-round add_checklist_btn<?php echo $item['id'];?>" data-toggle="modal" data-target="#addChecklistModal<?php echo $item['id'];?>">Checklist <span class="badge count<?php echo $item['id'];?> checklist_count<?php echo $item['id'];?>"><?php echo count($task_checklist);?></span>
<b class="caret"></b></a>
                                        <!-- Checklist modal -->
                                            <div class="modal fade" id="addChecklistModal<?php echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myChecklistModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myChecklistModalLabel"><?php echo get_buildz_task_name($item['task_id']);?> Checklist</h5>                                                        </div>
                                                        <div class="modal-body">
														<ul class="list_container">
                                                        
                                                            <?php 
                                                            
                                                            foreach($checklists as $checklist){ ?>

                                                            <li>
                                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="checklist<?php echo $item['id'];?>" rowno="<?php echo $item['id'];?>" value="<?php echo $checklist['id'];?>" onclick="update_checklist(<?php echo $item['id'];?>);" <?php if(in_array($checklist['id'], $task_checklist)){ echo "checked"; } ?>> <?php echo $checklist['name'];?>
                                                    </label>
<span rowno="<?php echo $item['id'];?>" id="<?php echo $checklist['id'];?>" class="remove_checklist pull-right btn btn-simple btn-danger btn-icon"><i class="material-icons">close</i></span>
                                                </div> 
                                                
                                                          </li>

                                                            <?php } ?>
                                                         
                                                        </ul>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">check</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add New Checklist</h4> 
                                    <div class="toolbar">
<form id="checklistForm<?php echo $item['id'];?>" method="post"><div class="form-group label-floating">
<input type="hidden" id="checklist_item_id" name="checklist_item_id" value="<?php echo $item['id'];?>">
<input type="hidden" id="checklist_template_id" name="checklist_template_id" value="<?php echo $item['template_id'];?>">
<input class="form-control" type="text" name="new_checklist<?php echo $item['id'];?>" id="new_checklist<?php echo $item['id'];?>" uniqueChecklist="true" required="true" value="" placeholder="Checklist"/>
                                            
					</div>
                                        <div class="form-footer text-right">
                                            <button rowno="<?php echo $item['id'];?>" type="button" class="btn btn-primary btn-fill add_new_checklist">Add</button>
                                        </div>
</form>
</div>
</div>
</div>
</div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end Checklist modal -->
</div>