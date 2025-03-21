<div id="reminders_container<?php echo $item['id'];?>">
<?php $reminders = get_template_task_reminders($item['template_id'], $item['id']);?>
<a class="add_reminder_btn<?php echo $item['id'];?> btn btn-rose btn-round" data-toggle="modal" data-target="#addReminderModal<?php echo $item['id'];?>">Notifications <span class="badge count<?php echo $item['id'];?>"><?php echo count($reminders);?></span>
<b class="caret"></b></a>
                                        <!-- Reminders modal -->
                                            <div class="modal fade" id="addReminderModal<?php echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myReminderModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myReminderModalLabel"><?php echo get_task_name($item['task_id']);?> Notifications</h5>                                                        </div>
                                                        <div class="modal-body">													
                                                        <?php if(count($reminders)>0){ ?>
                                                         <ul class="timeline timeline-simple">
                                                            <?php 
                                                            
                                                            foreach($reminders as $reminder){ ?>

                                                          
                                <li class="timeline-inverted">
                                    <div class="timeline-badge rose">
                                        <i class="material-icons">notifications</i>
                                    </div>
                                    <div class="timeline-panel">
                                        <a rowno="<?php echo $item['id'];?>" id="<?php echo $reminder['id'];?>" class="remove_reminder btn btn-simple btn-danger btn-icon pull-right"><i class="material-icons">close</i></a>
                                        <div class="timeline-heading">
                                            <span class="label label-rose"><?php echo $reminder['email'];?></span>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $reminder['message'];?></p>
                                        </div>
                                        <?php 
                                        if($reminder['reminder_type']==0){
                                          $reminder_statement = "Same Day";
                                        } 
                                        else if($reminder['reminder_type']==1){
                                          if($reminder['no_of_days']>1){
                                           $reminder_statement = "After ".$reminder['no_of_days']." days";
                                          }
                                          else{
                                            $reminder_statement = "After ".$reminder['no_of_days']." day";
                                          }
                                        }
                                        else if($reminder['reminder_type']==2){
                                          if($reminder['no_of_days']>1){
                                           $reminder_statement = "Before ".$reminder['no_of_days']." days";
                                          }
                                          else{
                                            $reminder_statement = "Before ".$reminder['no_of_days']." day";
                                          }
                                        }
                                        ?>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo $reminder_statement;?>
                                        </h6>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo date("M d, Y", strtotime($reminder['date']));?>
                                        </h6>
                                        <h5>
                                            <?php if($reminder['status']==0){?>
                                              <span class="label label-danger">Not Sent Yet</span>
                                            <?php } else{ ?>
                                              <span class="label label-success">Sent</span>
                                            <?php } ?>
                                        </h5>
                                    </div>
                                </li>
                                                                						 


                                                            <?php } ?>
</ul>
<?php } ?>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">notifications</i>
                                </div>
                                <div class="card-content">
                                    <h5 class="card-title">Add New Notification</h5> 
                                    <div class="toolbar">
<form id="RemindersForm<?php echo $item['id'];?>" method="post">

<input type="hidden" id="reminder_type" name="reminder_type" value="0">

<input type="hidden" id="reminder_task_id" name="reminder_task_id" value="0">
																<input type="hidden" id="reminder_item_id" name="reminder_item_id" value="<?php echo $item['id'];?>">
																<input type="hidden" id="reminder_template_id" name="reminder_template_id" value="<?php echo $item['template_id'];?>">
																															<div class="form-group label-floating reminder_dropdown">																	<select id="to_id" name="to_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose To">
                                                        
                                                        <?php 
if(count($reminder_users)>0){
                                                        foreach($reminder_users as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['email'];?></option>
                                                        <?php } } ?>
                                                    </select>
<button reminder_type="1" type="button" class="btn btn-danger btn-xs pull-right reminder_list_type">Hide List</button>															</div>
<div class="form-group label-floating reminder_textfield" style="display:none;">
                                            <input class="form-control" type="text" name="to_email" id="to_email" required="true" email="true" uniqueEmail="true" value="" placeholder="Email"/>
                                                    <button reminder_type="0" type="button" class="btn btn-danger btn-xs pull-right reminder_list_type">Show List</button>
                                           
					</div>
<div class="form-group label-floating">
                        <select id="remindertype" name="remindertype" class="selectpicker" data-style="select-with-transition" title="Choose Reminder Type">
                             <option value="0" selected>Same Day</option>
                             <option value="1">After</option>
                             <option value="2">Before</option>
                        </select>
</div>
<div class="form-group label-floating no_of_days_container">
																	<input class="form-control" type="number" name="no_of_days" id="no_of_days" required="true" min="1" value="" placeholder="Number Of Days"/>
																</div>
<div class="form-group label-floating"><label>Date Task Scheduled</label>
																	<input class="form-control datepicker" type="text" name="date" id="date" required="true" value="" placeholder="Date"/>
																</div>			
<?php $reminders = get_task_reminder_message($item['task_id']);?>
<div class="form-group label-floating">																	<select rowno="<?php echo $item['id'];?>" id="message_id" name="message_id" required="true" class="selectpicker" data-style="select-with-transition" title="Reminder Type">
<option value="0" selected>New</option>
                                                        
                                                        <?php 
if(count($reminders)>0){
                                                        foreach($reminders as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo substr($val['message'], 0, 10);?><?php if(strlen($val['message'])>10){ ?>......<?php }?></option>
                                                        <?php } } ?>
                                                    </select>																</div>															<div class="form-group label-floating">
																	<textarea class="form-control message_<?php echo $item['id'];?>" name="message" id="message" required="true" placeholder="Message"/></textarea>
																</div>
																<div class="form-footer text-right">
																	<button rowno="<?php echo $item['id'];?>" type="button" class="btn btn-rose btn-fill add_new_reminder">Add</button>
																</div>
														
															   </form>
</div>
</div>
</div>
</div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
<!-- end Reminders modal -->
                                            </div>
                                            