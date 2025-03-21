<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="SendScheduleReportForm" method="POST" action="<?php echo SCURL ?>reports/send_project_schedule_report_process" enctype="multipart/form-data">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">mail</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Send Schedule Report</h4>
                                        <?php if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}?>
                                        <div class="form-group label-floating">
                                            
                                            <select id="to" name="to[]" class="selectpicker" data-style="select-with-transition" data-live-search="true" multiple title="Choose Receipints *" required="true" data-live-search="true">
                                                        <?php if(count($users)>0){
                                                        foreach($users as $val){
                                                        ?>
                                                        <option value="<?php echo $val['user_email'];?>"><?php echo $val['user_fname']." ".$val['user_lname'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('to', '<div class="custom_error">', '</div>'); ?>
					                    </div>
					                    <br/>
                                         <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
                                                        <span class="fileinput-new">Uplaod File</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="attachment" name="attachment" required="true" accept="pdf"/>
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>

                                                </div>
                                                <div class="attachment-error"></div>
                                                <?php echo form_error('attachment', '<div class="custom_error">', '</div>'); ?>
                                            </div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Email Subject
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="subject" id="subject" required="true" uniqueProject="true" value="<?php echo set_value('subject')?>"/>
                                            <?php echo form_error('subject', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Email Note
                                                <small></small>
                                            </label>
                                            <textarea class="form-control" type="text" name="description" id="description"><?php echo set_value('description')?></textarea>
                                            <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                