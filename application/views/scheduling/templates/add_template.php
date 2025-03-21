<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="TemplateForm" method="POST" action="<?php echo SCURL ?>templates/add_new_template_process">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">phonelink_setup</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Template</h4>
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
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Name
                                                <small>*</small>
                                            </label>
                                            <input class="form-control" type="text" name="name" id="name" required="true" uniqueTemplate="true" value="<?php echo set_value('name')?>"/>
                                            <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            <label class="control-label">
                                                Description
                                                <small>*</small>
                                            </label>
                                            <textarea class="form-control" type="text" name="description" id="description" required="true"><?php echo set_value('description')?></textarea>
                                            <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
					</div>
				        			
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                