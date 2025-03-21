<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="TaskForm" method="POST" action="<?php echo SURL ?>supplierz_buildz/tasks/add_new_task_process">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Buildz Task</h4>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Task
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="name" id="name" required="true" uniqueTask="true" value="<?php echo set_value('name')?>"/>
                                            <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
					                    </div>
					                    <div class="input_fields_wrap">
                                            <div class="form-footer text-right">
                                                <button type="button" class="btn btn-sm btn-success btn-fill add_field_button">Add More Checklist</button>
                                            </div>
                                            <div class="form-group label-floating">
                                                <label class="control-label">
                                                    Checklist
                                                    <small>*</small>
                                                </label>
                                                <input class="form-control more_checklist" type="text" name="checklists[]" id="checklist1" required="true" uniqueChecklist="true" value=""/>
                                                <?php echo form_error('checklists[]', '<div class="custom_error">', '</div>'); ?>
    					                    </div>
                                        </div>		
                                        				
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                            <a href="<?php echo SURL;?>supplierz_buildz/tasks" class="btn btn-default btn-fill">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                