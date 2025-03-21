<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ReminderForm" method="POST" action="<?php echo SCURL ?>reminders/add_new_reminder_process">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">notifications</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Reminder</h4>
                                        <div class="form-group label-floating task_dropdown">
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task *" DATA-LIVE-SEARCH="TRUE">
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                        										<textarea class="form-control" name="message" id="message" placeholder="Message" required="true"/></textarea>
					 <?php echo form_error('message', '<div class="custom_error">', '</div>'); ?>											</div>
										
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                