<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Tracking Report</h4> 
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
                                    <form id="trackingForm" method="post" action="<?php echo base_url('reports/save_tracking_report/');?>" onsubmit="return validateForm()">
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Tracking Report Name <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('title');?>" required uniqueTrackingReport="true">
                                                                <?php echo form_error('title', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Project Costing for Tracking <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="project_id" id="tracking_project_id" title="Select Project" data-live-search="true" required onChange="getCostingbyProject(this.value)">
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
                                                    	<div id='newcdiv' style="display:none;">
                <div class="panel panel-default table-responsive">
                    <div class="table-responsive" >

                         <table id="partstable" class="table table-bordered table-striped table-hover">
                            <thead>
                              <tr>
                                <th><div class="checkbox"><label><input type="checkbox" class="select_all"></label></div></th>
                                <th>Stage</th>
                                <th>Part</th>
                                <th>Component</th>
                                <th>Supplier</th>
                                <th>QTY</th>
                                <th>Unit Of Measure</th>
                                <th>Unit Cost</th>
                                <th>Line Total</th>
                                <th>Margin %</th>
                                <th>Line Total with Margin</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">Total</td>
                                     <td colspan="4" id="total_count">0.00</td>
                                </tr>
                            </tfoot>
                          </table>                           
                    </div>

                </div>

            </div>
            <div class="row" style="margin-bottom:15px;">
            <div class="form-group col-lg-12">             
             
              <div class="col-lg-4 ">
                <input type="hidden" name="total_amount" id="total_amount" value="0" />
                 <input type="hidden" name="selected_costing_parts" id="selected_costing_parts" value="0" />
                <button type="submit" class="btn btn-success">Save Tracking Report</button>
              </div>
            </div>
        </div>
                                                </div>
                                        </div>
                                    </form>
                                        
                                </div>
		</div>
    </div>
</div>
