          <style>
              .templates_table .form-control{
                  background-image: none;
                  border:1px solid #ccc!important;
                  padding:5px;
                  margin-top:12px;
              }
             .form-group.is-focused .templates_table .form-control{
                  background-image: none!important;
              }
              .part-form-control{
                  width:200px;
              }
              .uom-form-control, .uc-form-control{
                width:100px;
              }
              .no-padding{
                  padding:0px!important;
              }
              .btn-success{
                  margin-top: 0px;
              }
          </style> 
               <form id="PurchaseOrderForm" method="POST" action="<?php echo SURL ?>purchase_orders/porder">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Purchase Order Wizard</h4>
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
                								<select class="selectpicker" data-style="select-with-transition" title="Select Project For Purchase Order *" data-size="7" name="project_id" id="project_id" onchange="get_stages(this.value)" required="true">
                                                    <?php foreach($eprojects as $project){ ?>
                                                       <option value="<?php echo $project->costing_id; ?>"><?php echo $project->project_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                        </div>
                                        <div class="form-group label-floating">
                                            <div class="radio">
                                                <label><input type="radio" name="template" value="manual" checked>Create Manual Purchase Order</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="template" value="auto">Automatic Purchase Order</label>
                                            </div>
                                        </div>
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <br/>
                                        <div class="form-footer">
                                            <div class="text-left col-md-6">
                                                <a href="<?php echo SURL;?>purchase_orders" class="btn btn-success btn-fill" >Previous</a>
                                            </div>
                                            <div class="text-right col-md-6">
                                                <input type="submit" class="btn btn-success btn-fill" value="Next">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </form>