<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ReminderUserForm" method="POST" action="<?php echo SURL ?>reminder_users/add_new_reminder_user_process">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">notifications</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Reminder User</h4>
                                        <div class="form-group label-floating task_dropdown">
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task *">
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Email
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="email" id="email" required="true" uniqueEmail="true" email="true" value="<?php echo set_value('email')?>"/>
                                            <?php echo form_error('email', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                        										<textarea class="form-control" name="message" id="message" placeholder="Message"/></textarea>
																</div>
										
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-rose btn-fill">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                