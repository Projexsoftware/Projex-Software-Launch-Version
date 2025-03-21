<div id="notes_container<?php echo $item['id'];?>">
<?php $notes = get_buildz_template_task_notes($item['template_id'], $item['id']);?>
<a class="add_note_btn<?php echo $item['id'];?> btn btn-success btn-round" data-toggle="modal" data-target="#addNoteModal<?php echo $item['id'];?>">Notes <span class="badge count<?php echo $item['id'];?>"><?php echo count($notes);?></span>
<b class="caret"></b></a>
                                        <!-- Notes modal -->
                                            <div class="modal fade" id="addNoteModal<?php echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myNoteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myNoteModalLabel"><?php echo get_buildz_task_name($item['task_id']);?> Notes</h5>                                                        </div>
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
                                        <a rowno="<?php echo $item['id'];?>" id="<?php echo $note['id'];?>" class="remove_note btn btn-simple btn-danger btn-icon pull-right"><i class="material-icons">close</i></a>
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
                                                                						 


                                                            <?php } ?>
</ul>
<?php } ?>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="green">
                                    <i class="material-icons">description</i>
                                </div>
                                <div class="card-content">
                                    <h5 class="card-title">Add New Note</h5> 
                                    <div class="toolbar">
<form id="NotesForm<?php echo $item['id'];?>" method="post">
																<input type="hidden" id="note_item_id" name="note_item_id" value="<?php echo $item['id'];?>">
																<input type="hidden" id="note_template_id" name="note_template_id" value="<?php echo $item['template_id'];?>">
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
</div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
<!-- end Notes modal -->
                                            </div>
                                            