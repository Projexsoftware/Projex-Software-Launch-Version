<style>
    .form-group label.control-label{
        font-size:13px;
    }
</style>
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">help</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Add New Ticket</h4>
                                    <?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    
                                                    </label>
                                                    <form id="myAwesomeDropzone" class="form-horizontal no-margin form-border dropzone" action="<?php echo SURL;?>tickets/upload_ticket_file" method="post" enctype="multipart/form-data">
                                                    <div class="dropzone-previews"></div>
                							
                						       </form>
    				                        	</div>
                                        </div>
                                        <form id="TicketForm" method="POST" action="<?php echo SURL;?>tickets/create_new_ticket_process" autocomplete="off">
                                        <input type="hidden" name="ticket_files[]" id="ticket_files" value="">
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Ticket Title <small>*</small>
                                                    </label>
                                                    <input type="text" class="form-control"  id="ticket_title" name="ticket_title" value="<?php echo set_value('ticket_title')?>" required="true">
                                                    <?php echo form_error('ticket_title', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                    Ticket Priority <small>*</small>
                                                    </label>
                                                    <select name="ticket_priority" class="form-control">
                                                        <option value="Low" selected>Low</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="High">High</option>
                                                         <option value="Urgent">Urgent</option>
                                                    </select>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                    Ticket Category <small>*</small>
                                                    </label>
                                                    <select name="ticket_category" class="form-control">
                                                        <option value="Default" selected>Default</option>
                                                        <option value="Technical Support">Technical Support</option>
                                                        <option value="User Support">User Support</option>
                                                     </select>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                    Ticket Body 
                                                    </label>
                                                    <br><br>
                                                    <textarea class="ckeditor" rows="5" name="ticket_body"></textarea>
    				                        	</div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <input type="submit" class="btn btn-warning btn-fill" value="Create Ticket"/>
                                                        <a href="<?php echo SURL;?>tickets" class="btn btn-default btn-fill">Cancel</a>
                     
                                                    </div>
                                            </div>
                                        </div>
                                     </form>
                              
                            </div>
                        </div>
                    </div>