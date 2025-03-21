<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ReminderForm" method="POST" action="<?php echo SCURL ?>reminders/edit_reminder_process">
								<input type="hidden" id="reminder_id" name="reminder_id" value="<?php echo $reminder_edit['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">notifications</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Reminder</h4>
                                         <div class="form-group label-floating task_dropdown">
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task *" disabled>
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>" <?php if($reminder_edit['task_id']==$val['id']){ ?> selected <?php } ?>><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                <div class="form-group label-floating">
                                        										<textarea class="form-control" name="message" id="message" placeholder="Message" required="true"><?php echo $reminder_edit['message'];?></textarea>
					<?php echo form_error('message', '<div class="custom_error">', '</div>'); ?>  
				                    <div class="form-group label-floating">
                                        
                                        <div class="form-footer text-right">
                                            <button type="submit" id="update_reminder" name="update_reminder" class="btn btn-warning btn-fill">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                