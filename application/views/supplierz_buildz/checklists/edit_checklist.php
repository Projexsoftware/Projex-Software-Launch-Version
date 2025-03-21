<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ChecklistForm" method="POST" action="<?php echo SURL ?>supplierz_buildz/checklists/edit_checklist_process">
								<input type="hidden" id="checklist_id" name="checklist_id" value="<?php echo $checklist_edit['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">done_all</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Buildz Checklist</h4>
                                         <div class="form-group label-floating task_dropdown">
                                            <select id="task_id" name="task_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Task" disabled>
                                                        
                                                        <?php if(count($tasks)>0){
                                                        foreach($tasks as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>" <?php if($checklist_edit['task_id']==$val['id']){ ?> selected <?php } ?>><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('task_id', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Checklist
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" id="name" name="name" type="text" required="true" uniqueEditChecklist="true" value="<?php echo $checklist_edit['name'];?>"/>
                                            <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
					</div>  
				<div class="form-group label-floating">
                                        
                                        <div class="form-footer text-right">
                                            <button type="submit" id="update_checklist" name="update_checklist" class="btn btn-warning btn-fill">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                