<div id="notes_container<?php echo $item['id'];?>">
<?php $notes = get_task_notes($item['project_id'], $item['id'], $current_role);
?>
<a class="add_note_btn<?php echo $item['id'];?> btn btn-success btn-round" data-toggle="modal" data-target="#addNoteModal<?php echo $item['id'];?>">Notes <span class="badge count<?php echo $item['id'];?>"><?php echo count($notes);?></span>
<b class="caret"></b></a>
                                        <!-- Notes modal -->
                                            <div class="modal fade" id="addNoteModal<?php echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myNoteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myNoteModalLabel"><?php echo get_task_name($item['task_id']);?> Notes</h5>                                                        </div>
                                                        <div class="modal-body">													
                                                        <?php if(count($notes)>0){ ?>
                                                         <ul class="timeline timeline-simple">
                                                            <?php 
                                                            
                                                            foreach($notes as $note){ ?>

                                                          
                                <li class="timeline-inverted">
                                    <div class="timeline-badge success">
                                        <i class="material-icons">description</i>
                                    </div>
                                    <div class="timeline-panel">
                                        <?php if($current_role==1 || $current_role==2 || $note['user_id']==$this->session->userdata("admin_id")){ ?><a rowno="<?php echo $item['id'];?>" id="<?php echo $note['id'];?>" class="remove_note btn btn-simple btn-danger btn-icon pull-right"><i class="material-icons">close</i></a><?php } ?>
                                        <div class="timeline-heading">
                                            <span class="label label-success"><?php echo $note['author'];?></span>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $note['note'];?></p>
                                        </div>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo date("M d, Y", strtotime($note['date']));?>
                                        </h6>
                                        <?php if($current_role==1 || $current_role==2){ ?>
                                        <div class="togglebutton pull-right">
                                                <label class="text-default">
                                                  <input id="privacy_settings<?php echo $note['id'];?>" name="privacy_settings" type="checkbox" <?php if($note['privacy_settings']==0){ ?> checked <?php } ?> onclick="set_privacy(<?php echo $note['id'];?>, <?php echo $item['id'];?>, 'Note');" >Private
                                                </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </li>
                                                                						 


                                                            <?php } ?>
</ul>
<?php } ?>
<?php if($current_role==1 || $current_role==2 || $current_role==3 || $current_role==4){ ?>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="green">
                                    <i class="material-icons">description</i>
                                </div>
                                <div class="card-content">
                                    <h5 class="card-title">Add New Note</h5> 
                                    <div class="toolbar">
<form id="NotesForm<?php echo $item['id'];?>" method="post">
																<input type="hidden" id="note_item_id" name="note_item_id" value="<?php echo $item['id'];?>">
																<input type="hidden" id="note_project_id" name="note_project_id" value="<?php echo $item['project_id'];?>">
																															<div class="form-group label-floating">
																	<input class="form-control" type="text" name="author" id="author" required="true" value="<?php echo $this->session->userdata('firstname').' '.$this->session->userdata('lastname');?>" placeholder="Author"/>
																</div>
<div class="form-group label-floating">
																	<input class="form-control datepicker" type="text" name="date" id="date" required="true" value="" placeholder="Date"/>
																</div>																<div class="form-group label-floating">
																	<textarea class="form-control" name="note" id="note" required="true" placeholder="Note"/></textarea>
																</div>
																<div class="form-footer text-right">
																	<button rowno="<?php echo $item['id'];?>" type="button" class="btn btn-success btn-fill add_new_note">Add</button>
																</div>
														
															   </form>
</div>
</div>
</div>
<?php } ?>
</div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
<!-- end Notes modal -->
                                            </div>
                                            