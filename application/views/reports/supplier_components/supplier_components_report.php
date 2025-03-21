<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Supplier Components Report</h4> 
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
                                                            <label class="col-md-3 label_with_selectpicker">Select Supplier <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="supplier" id="supplier" title="Select Supplier" data-live-search="true" required onchange="get_project_suppliers();">
                                                                    <?php foreach ($suppliers as $supplier) { ?>
                                                                        <option value="<?php if($supplier["parent_supplier_id"] == 0){ echo $supplier["supplier_id"]; } else{ echo $supplier["parent_supplier_id"]; }  ?>"><?php echo $supplier["supplier_name"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    	<div class="supplier_components_container material-datatables table-responsive">
                                                        </div>
                                                </div>
                                        </div>
                                        
                                </div>
		</div>
    </div>
</div>
