<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="PublicHolidayForm" method="POST" action="<?php echo SCURL ?>public_holidays/edit_public_holiday_process" autocomplete="off">
								<input type="hidden" id="public_holiday_id" name="public_holiday_id" value="<?php echo $public_holiday_edit['id']  ?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">lightbulb</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Public Holiday</h4>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Title
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" id="title" name="title" type="text" required="true" uniqueEditTitle="true" value="<?php echo $public_holiday_edit['title'];?>"/>
                                            <?php echo form_error('title', '<div class="custom_error">', '</div>'); ?>
					</div>
                                         <div class="form-group label-floating">
                                            <label class="control-label">
                                                
                                            </label>
                                            <input class="form-control datepicker" id="date" name="date" type="text" required="true" value="<?php echo $public_holiday_edit['date'];?>" placeholder="Date"/>
                                            <?php echo form_error('date', '<div class="custom_error">', '</div>'); ?>
					</div>
				<div class="form-group label-floating">
                                        
                                        <div class="form-footer text-right">
                                            <button type="submit" id="update_public_holiday" name="update_public_holiday" class="btn btn-warning btn-fill">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                