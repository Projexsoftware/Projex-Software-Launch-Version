
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
              .comments, .status, .include, .boom_mobile{
                display:none;
              }
              .table_project_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0;font-weight:bold;}
              .homeworx_logo{
                  /*margin-top:25px;*/
                  text-align:center;
              }
              
              @media print {
                @page { size: landscape; }
            	.notprint{
                    display: none !important;
                }
              }
          </style> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon notprint" data-background-color="orange">
                                        <i class="material-icons">house</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Report</h4>
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
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <ul class="nav nav-pills nav-pills-warning notprint">
                                            <li <?php if($type == "project_costing"){ ?> class="active" <?php } ?>><a href="<?php echo SURL.'project_costing/edit_project_costing/'.$project_id;?>">Project Costing</a></li>
                                            <li <?php if($type == "specifications"){ ?> class="active" <?php } ?>><a href="<?php echo SURL.'project_costing/specifications/'.$project_id;?>">Specifications</a></li>
                                            <li <?php if($type == "allowances"){ ?> class="active" <?php } ?>><a href="<?php echo SURL.'project_costing/allowances/'.$project_id;?>">Allowances</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/plans_and_specifications/'.$project_id;?>">Plans and Specifications</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/create_documents/'.$project_id;?>">Create Documents</a></li>
                                              <!--<li><a href="<?php echo SURL.'project_costing/estimate_request/'.$project_id;?>">Estimate Request <font color="red">"fees apply"</font></a></li>-->
                                    
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="projectCosting">
                                    	         <!--<div class="row notprint">
                                                            <div class="col-md-12"><legend>Show/Hide Columns</legend></div>
                                                            <div class="col-md-12">
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_status" id="column_status"  onchange="showcolumn('status')"> Show Status
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_subcategory" id="column_subcategory"  onchange="showcolumn('subcategory')"> Show Sub-Category
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_include" id="column_include"  onchange="showcolumn('include')"> Show Include in specification & client allowance
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_comments" id="column_comments"  onchange="showcolumn('comments')"> Show Comments
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_boom_mobile" id="column_boom_mobile"  onchange="showcolumn('boom_mobile')"> Show Boom Mobile Settings
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="col-md-2">
                                                                    <div class="checkbox">
                                                                        <label>
                                            								<input type="checkbox" name="column_component_description" id="column_component_description"  onchange="showcolumn('component_description')"> Show Component Description
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    if(in_array(134, $this->session->userdata("permissions"))) {
                                                                ?>
                                                                    <div class="col-md-2">
                                                                        <div class="checkbox">
                                                                            <label>
                                                								<input type="checkbox" name="column_add_task_to_schedule" id="column_add_task_to_schedule"  onchange="showcolumn('add_task_to_schedule')"> Show Add Task to Schedule
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                    </div>-->
                                                <?php if($company_info["com_logo"]!=""){ ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-3 homeworx_logo">
                                                        <img style="width:100%;height:100px;" src="<?php echo trim(SURL).'/assets/company/'.trim($company_info["com_logo"]);?>">
                                                    </div>
                                                </div>
                                                <?php } else{ ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-3 homeworx_logo">
                                                        <img src="<?php echo SURL; ?>assets/img/homeworx_logo.png">
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                 <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="table_project_name">
                                	    				Project Name:
                                	    				<?php echo $project_name['project_title']; ?>
                                	    				<br/>
                                	    				Project Address:
                                	    				<?php 
                                	    					echo $project_info['street_pobox'] . ' ' .
                                	    					$project_info['suburb'] . ', ' .
                                	    					$project_info['project_address_city'] . ', ' .
                                							$project_info['project_address_state'] . ', ' .
                                							$project_info['project_address_country'] . ', ' .
                                							$project_info['project_zip'];
                                	    				?>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <!--<div class="row">
                                                    <div class="col-sm-12">
                                	    				<h4 class="pro_address">
                                	    				Project Address:
                                	    				<?php 
                                	    					echo $project_info['street_pobox'] . ' ' .
                                	    					$project_info['suburb'] . ', ' .
                                	    					$project_info['project_address_city'] . ', ' .
                                							$project_info['project_address_state'] . ', ' .
                                							$project_info['project_address_country'] . ', ' .
                                							$project_info['project_zip'];
                                	    				?>
                                	    				</h4>
                                    				</div>
                                                </div>-->
                                                <div class="form-group label-floating">
                                                    <div class="table-responsive">
                                                                 <table id="partstable" class="table sortable_table templates_table partstable">
                                                                   	<thead>
                                                            		    <th>Stage</th>
                                                            		    <th>Sub-Category</th>
                                                                        <th>Part</th>
                                                                        <th>Component</th>
                                                                        <th>Component Description</th>
                                                                        <th>Supplier</th>
                                                                        <th>QTY</th>
                                                                        <th>Unit Of Measure</th>
                                                                        <th>Unit Cost</th>
                                                                        <th>Line Total</th>
                                                                        <th>Margin %</th>
                                                                        <th>Line Total with Margin</th>
                                                                        <th>Status</th>
                                                                                    <th>Include in specifications</th>
                                                                                    <th>Client Allowance</th>
                                                                                    <th>Comment</th>
                                                                                    <th>Hide From Boom Mobile</th>
                                                                                    <?php
                                                                                        if(in_array(134, $this->session->userdata("permissions"))) {
                                                                                    ?>
                                                                                    <th>Add Task to Schedule</th>
                                                                                    <?php } ?>
                                                            		</thead>
                                                                   <tbody>
                                                                        
                                                                        <?php 
                                                                        foreach ($prjprts As $key => $prjprt) {?>
                                                                        <tr>
                                                                            <td>
                                                                                    <?php echo $prjprt->stage_name;?>
                                                                           </td>
                                                                           <td>
                                                                                   <?php echo $prjprt->sub_category; ?>
                                                                            </td>
                                                                           <td>
                                                                               <?php echo $prjprt->costing_part_name; ?>
                                                                           </td>
                                                                           <td>
                                                                                 <?php echo $prjprt->component_name;?>
                                                                           </td>
                                                                           <td>
                                                                               <?php echo $prjprt->component_des; ?>
                                                                            </td>
                                                                           <td>
                                                                               <?php echo $prjprt->supplier_name;?>
                                                                           </td>
                                                                           <td>
                                                                               <?php echo number_format($prjprt->costing_quantity, 2, '.', ''); ?>
                                                                           </td>
                                                                           <td>
                                                                               <?php echo $prjprt->costing_uom; ?>
                                                                           </td>
                                                                           <td>
                                                                               <?php echo number_format($prjprt->costing_uc, 2, '.', ''); ?>
                                                                           </td>
                                                                           <td>
                                                                               <?php echo number_format($prjprt->line_cost, 2, '.', ''); ?>
                                                                           </td>
                                                                            <td>
                                                                               <?php echo $prjprt->margin ?>
                                                                           </td>
                                                                           <td>
                                                                               <?php echo number_format($prjprt->line_margin, 2, '.', ''); ?>
                                                                           </td>
                                                                           <td>
                                                                               <?php if ($prjprt->type_status == "estimated") { echo "Estimated"; } ?>
                                                                               <?php if ($prjprt->type_status == "price_finalized") { echo "Price Finalized"; } ?>
                                                                               <?php if ($prjprt->type_status == "allowance") { echo "Allowance"; } ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                        							if ($prjprt->include_in_specification == 1) {
                                                        								echo "Yes";
                                                        							}
                                                        							else {
                                                        								echo "No";
                                                        							}	
                                                        						?>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                    							if ($prjprt->client_allowance == 1) {
                                                    								echo "Yes";
                                                    							}
                                                    							else {
                                                    								echo "No";
                                                    							}	
                                                    							?>
                                                                            </td>
                                                                            <td>
                                                                               <?php echo $prjprt->comment;?>
                                                                            </td>
                                                                            <td> 
                                                                               <?php 
                                                    							if ($prjprt->hide_from_boom_mobile == 1) {
                                                    								echo "Yes";
                                                    							}
                                                    							else {
                                                    								echo "No";
                                                    							}	
                                                    							?>
                                                                            </td>
                                                                            <?php
                                                                                if(in_array(134, $this->session->userdata("permissions"))) {
                                                                            ?>
                                            										<td> 
                                                                                        <?php 
                                                                							if ($prjprt->add_task_to_schedule == 1) {
                                                                								echo "Yes";
                                                                							}
                                                                							else {
                                                                								echo "No";
                                                                							}	
                                                            							?>
                                                									</td>
                                                							<?php } ?>
                                                                        </tr>
                                                                        <?php } ?> 
                                                                    </tbody>
                                                                   </table>
                                                           </div>             
                                        		 </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-3">
                            <div class="card">
                                <div class="card-content">
                                    <div class="panel-group" id="accordionSummary" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOneSummary">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionSummary" href="#collapseOneSummary" aria-controls="collapseOneSummary">
                                                    <h4 class="panel-title">
                                                        <center>Summary</center>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="collapseOneSummary" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOneSummary" aria-expanded="true">
                                                <div class="panel-body">
                                                    <table class="table">
                                                      <tbody>
                                                          <tr>
                                                            <td >Project Subtotal</td>
                                                            <td></td>
                                                            <td width="160">$<?php echo number_format($pc_detail->project_subtotal_1, 2, '.', ''); ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Overhead margin</td>
                                                            <td></td>
                                                            <td width="160"><?php echo number_format($pc_detail->over_head_margin, 2, '.', ''); ?>%</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Profit margin</td>
                                                            <td></td>
                                                            <td width="160"><?php echo number_format($pc_detail->porfit_margin, 2, '.', ''); ?>%</td>
                                                          </tr>
                                                          <tr>
                                                            <td>Project subtotal</td>
                                                            <td></td>
                                                            <td width="160">$<?php echo number_format($pc_detail->project_subtotal_2, 2, '.', ''); ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Tax</td>
                                                            <td></td>
                                                            <td width="160"><?php echo $pc_detail->tax_percent; ?>%</td>
                                                          </tr>
                                                          <tr>
                                                            <td >Project subtotal</td>
                                                            <td></td>
                                                            <td  width="160">$<?php $total1 = $pc_detail->project_subtotal_3; echo number_format($total1, 2, '.', ''); ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Project price rounding</td>
                                                            <td></td>
                                                            <td width="160">$<?php $total2 = $pc_detail->price_rounding; echo number_format($total2, 2, '.', ''); ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Project contract price</td>
                                                            <td></td>
                                                            <td  width="160">$<?php $gtotal = $total1 + $total2; echo number_format($gtotal, 2, '.', '');?></td>
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
                        <div class="col-md-12 notprint">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                            <a href="javascript:window.print()" class="btn btn-warning btn-fill">Print</a>
                                            <a href="<?php echo SURL;?>project_costing/export_excel/<?php echo $type;?>/<?php echo $project_id;?>" class="btn btn-warning btn-fill">Export To Excel</a>
                                            <a href="<?php echo SURL;?>project_costing/export_pdf/<?php echo $type;?>/<?php echo $project_id;?>" class="btn btn-warning btn-fill">Export To PDF</a>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                