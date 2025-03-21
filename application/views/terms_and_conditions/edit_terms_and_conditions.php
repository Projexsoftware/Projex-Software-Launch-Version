<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form id="TermsForm" method="POST" action="<?php echo SURL ?>terms_and_conditions/update" autocomplete="off">
								<input type="hidden" id="term_id" name="term_id" value="<?php echo $terms->id;?>">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">gavel</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Terms & Conditions</h4>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="">
                                                    Detail
                                                    <small>*</small>
                                                    </label>
                                                    <textarea class="form-control ckeditor" type="text" name="detail" id="detail" ckrequired="true"><?php echo stripcslashes($terms->detail);?></textarea>
                                                    <?php echo form_error('detail', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            
                                       <div class="col-md-12">
                                            <div class="col-md-12">
            				                    <div class="form-group label-floating">
                                                    <div class="form-footer text-right">
                                                        <?php if(in_array(66, $this->session->userdata("permissions"))) {?>
                                                        <button type="submit" id="update_terms_and_conditions" name="update_supplier" class="btn btn-warning btn-fill">Update</button>
                                                        <?php } ?>
                                                        <a href="<?php echo SURL;?>terms_and_conditions" class="btn btn-default btn-fill">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                