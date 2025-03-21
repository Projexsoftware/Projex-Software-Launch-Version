<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ChecklistForm" method="POST" action="<?php echo SURL ?>supplierz_buildz/checklists/add_new_checklist_process">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">done_all</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Buildz Checklist</h4>
                                        <div class="form-group label-floating task_dropdown">
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task">
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="input_fields_wrap">
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-sm btn-success btn-fill add_field_button">Add More</button>
                                        </div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Checklist
                                                <small>*</small>
                                            </label>
                                            <input class="form-control more_checklist" type="text" name="name[]" id="name1" required="true" uniqueChecklist="true" value="<?php echo set_value('name[]')?>"/>
                                            <?php echo form_error('name[]', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        </div>					
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill add_new_checklist">Add</button>
                                            <a href="<?php echo SURL;?>supplierz_buildz/checklists" class="btn btn-default btn-fill">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                