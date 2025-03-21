<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="PublicHolidayForm" method="POST" action="<?php echo SCURL ?>public_holidays/add_new_public_holiday_process" autocomplete="off">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">lightbulb</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Public Holiday</h4>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Title
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="title" id="title" required="true" uniqueTitle="true" value="<?php echo set_value('title')?>"/>
                                            <?php echo form_error('title', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                
                                            </label>
                                            <input class="form-control datepicker" type="text" name="date" id="date" required="true" placeholder="Date" value="<?php echo set_value('date')?>"/>
                                            <?php echo form_error('date', '<div class="custom_error">', '</div>'); ?>
					</div>
										
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                