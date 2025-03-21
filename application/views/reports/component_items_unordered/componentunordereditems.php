<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Component Items Unordered Report</h4> 
                                    <div class="toolbar">
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
									</div>
									<div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                    
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Project <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="project_id" id="component_unordered_items_project_id" title="Select Project" data-live-search="true" required onchange="get_component_unordered_items();">
                                                                    <?php foreach ($projects as $project) { ?>
                                                                        <option value="<?php echo $project["project_id"]; ?>"><?php echo $project["project_title"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    	<div class="project_report_container material-datatables table-responsive">
                                                            <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color:#495B6C; color:#fff;">Sr No</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">Stage name</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">Part</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">Component</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">Supplier</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">QTY</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">Unit Of Measure</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">Variations</th>
                                            							<th style="background-color:#495B6C; color:#fff;">Subtotal</th>
                                                                        <th style="background-color:#495B6C; color:#fff;">Purchase Orders</th>
                                            							<th style="background-color:#495B6C; color:#fff;">Unordered Quantity</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                
                                                                    	<tr>
                                                                        	<td colspan="11">No Records Found</td>
                                                                        </tr>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                        </div>
                                        
                                </div>
		</div>
    </div>
</div>
