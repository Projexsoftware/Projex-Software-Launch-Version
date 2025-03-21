<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="ClientForm" method="POST" action="<?php echo SURL ?>manage/add_new_client_process" autocomplete="off">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">person</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Client</h4>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    First Name 1
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_fname1" id="client_fname1" required="true" value="<?php echo set_value('client_fname1')?>"/>
                                                    <?php echo form_error('client_fname1', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    First Name 2
                                                    </label>
                                                    <input class="form-control" type="text" name="client_fname2" id="client_fname2" value="<?php echo set_value('client_fname2')?>"/>
                                                    <?php echo form_error('client_fname2', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Surname 1
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_surname1" id="client_surname1" required="true" value="<?php echo set_value('client_surname1')?>"/>
                                                    <?php echo form_error('client_surname1', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Surname 2
                                                    </label>
                                                    <input class="form-control" type="text" name="client_surname2" id="client_surname2" value="<?php echo set_value('client_surname2')?>"/>
                                                    <?php echo form_error('client_surname2', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Home Phone Primary
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_homephone_primary" id="client_homephone_primary" value="<?php echo set_value('client_homephone_primary')?>"/>
                                                    <?php echo form_error('client_homephone_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Home Phone Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_homephone_secondary" id="client_homephone_secondary" value="<?php echo set_value('client_homephone_secondary')?>"/>
                                                    <?php echo form_error('client_homephone_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Work Phone Primary
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_workphone_primary" id="client_workphone_primary" value="<?php echo set_value('client_workphone_primary')?>"/>
                                                    <?php echo form_error('client_workphone_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Work Phone Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_workphone_secondary" id="client_workphone_secondary" value="<?php echo set_value('client_workphone_secondary')?>"/>
                                                    <?php echo form_error('client_workphone_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Mobile Phone Primary
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_mobilephone_primary" id="client_mobilephone_primary" required="true" value="<?php echo set_value('client_mobilephone_primary')?>"/>
                                                    <?php echo form_error('client_mobilephone_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Mobile Phone Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_mobilephone_secondary" id="client_mobilephone_secondary" value="<?php echo set_value('client_mobilephone_secondary')?>"/>
                                                    <?php echo form_error('client_mobilephone_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Email Primary
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_email_primary" id="client_email_primary" required="true" email="true" uniqueEmail="true" value="<?php echo set_value('client_email_primary')?>"/>
                                                    <?php echo form_error('client_email_primary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Email Secondary
                                                    </label>
                                                    <input class="form-control" type="text" name="client_email_secondary" id="client_email_secondary" email="true" value="<?php echo set_value('client_email_secondary')?>"/>
                                                    <?php echo form_error('client_email_secondary', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="street_pobox" id="street_pobox" required="true" value="<?php echo set_value('street_pobox')?>"/>
                                                    <?php echo form_error('street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="suburb" id="suburb" required="true" value="<?php echo set_value('suburb')?>"/>
                                                    <?php echo form_error('suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_city" id="client_city" required="true" value="<?php echo set_value('client_city')?>"/>
                                                    <?php echo form_error('client_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="state" id="state" value="<?php echo set_value('state')?>"/>
                                                    <?php echo form_error('state', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="country" id="country" value="<?php echo set_value('country')?>"/>
                                                    <?php echo form_error('country', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="client_zip" id="client_zip" required="true" value="<?php echo set_value('client_zip')?>"/>
                                                    <?php echo form_error('client_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Postal Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    </label>
                                                    <input class="form-control" type="text" name="post_street_pobox" id="post_street_pobox" value="<?php echo set_value('post_street_pobox')?>"/>
                                                    <?php echo form_error('post_street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    </label>
                                                    <input class="form-control" type="text" name="post_suburb" id="post_suburb" value="<?php echo set_value('post_suburb')?>"/>
                                                    <?php echo form_error('post_suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    </label>
                                                    <input class="form-control" type="text" name="client_postal_city" id="client_postal_city" value="<?php echo set_value('client_postal_city')?>"/>
                                                    <?php echo form_error('client_postal_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    </label>
                                                    <input class="form-control" type="text" name="pstate" id="pstate" value="<?php echo set_value('pstate')?>"/>
                                                    <?php echo form_error('pstate', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    </label>
                                                    <input class="form-control" type="text" name="pcountry" id="pcountry" value="<?php echo set_value('pcountry')?>"/>
                                                    <?php echo form_error('pcountry', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    </label>
                                                    <input class="form-control" type="text" name="client_postal_zip" id="client_postal_zip" value="<?php echo set_value('client_postal_zip')?>"/>
                                                    <?php echo form_error('client_postal_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                            Notes
                                                    </label>
                                                    <textarea class="form-control" name="client_note" id="client_note"><?php echo set_value('client_note')?></textarea>
                                                    <?php echo form_error('client_note', '<div class="custom_error">', '</div>'); ?>
            					               </div>
            					           </div>
            					       </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
            										<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="client_status" id="client_status" required="true">
                                                        <option disabled> Choose Status</option>
            											<option value="1" selected>Current</option>
            											<option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <button type="submit" class="btn btn-warning btn-fill">Add</button>
                                                        <a href="<?php echo SURL;?>manage/clients" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                