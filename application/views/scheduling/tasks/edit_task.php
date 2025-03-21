<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="TaskForm" method="POST" action="<?php echo SCURL ?>tasks/edit_task_process">
								<input type="hidden" id="task_id" name="task_id" value="<?php echo $task_edit['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">timeline</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Task</h4>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Task
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" id="name" name="name" type="text" required="true" uniqueEditTask="true" value="<?php echo $task_edit['name'];?>"/>
                                            <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
					</div>
				                    <div class="form-group label-floating">
                                        <div class="form-footer text-right">
                                            <button type="submit" id="update_task" name="update_task" class="btn btn-warning btn-fill">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                