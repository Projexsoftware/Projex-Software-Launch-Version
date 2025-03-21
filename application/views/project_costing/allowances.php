    <form id="ProjectCostingForm" method="POST" action="<?php echo SURL ?>project_costing/updatecost_without_price/<?php echo $pc_detail->costing_id;?>" onsubmit="return validateForm()">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">house</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Update Project Costing</h4>
				                    	<div class="form-group label-floating">
                								<?php echo $project_name; ?>
                                        </div>
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
                                       <ul class="nav nav-pills nav-pills-warning">
                                            <li><a href="<?php echo SURL.'project_costing/edit_project_costing/'.$project_id;?>">Project Costing</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/specifications/'.$project_id;?>">Specifications</a></li>
                                            <li class="active"><a href="#allowanceOptions"  data-toggle="tab">Allowances</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/plans_and_specifications/'.$project_id;?>">Plans and Specifications</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/create_documents/'.$project_id;?>">Create Documents</a></li>
                                              <!--<li><a href="<?php echo SURL.'project_costing/estimate_request/'.$project_id;?>">Estimate Request <font color="red">"fees apply"</font></a></li>-->
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="allowanceOptions">
                                                <div class="form-group label-floating">
                                                    <?php $count = 0;
                                                    foreach ($stages as $key => $stage): ?>
                    <?php if (in_array($stage['stage_id'], $saved_stages)) : 
                    $stage_total = 0;
                    $no_of_items = 0;
                    $no_of_checkboxes = 0;
                    foreach ($prjprts As $key => $prjprt) {
				        			
				        	if ($prjprt->stage_id == $stage['stage_id']) { 
							  $stage_total +=number_format($prjprt->line_margin, 2, '.', '');
							  $no_of_items++;
							  if($prjprt->hide_from_boom_mobile){
							     $no_of_checkboxes++; 
							  }
							}
							}?>
                                                      <div class="panel-group" id="accordion<?php echo $stage['stage_id']; ?>" role="tablist" aria-multiselectable="true">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="headingOne<?php echo $stage['stage_id']; ?>">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $stage['stage_id']; ?>" href="#collapseOne<?php echo $stage['stage_id']; ?>" aria-controls="collapseOne<?php echo $stage['stage_id']; ?>">
                                                                        <h4 class="panel-title">
                                                                            <?php echo $stage['stage_name']; ?>
                                                                            <i class="material-icons">keyboard_arrow_down</i>
                                                                            <!--<span class="pull-right">Stage Sub-total : <?php echo "$".number_format($stage_total, 2, '.', '');?></span>-->
                                                                        </h4>
                                                                    </a>
                                                                </div>
                                                                <div id="collapseOne<?php echo $stage['stage_id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne<?php echo $stage['stage_id']; ?>">
                                                                    <div class="panel-body">
                                                                       <div class="table-responsive">
                                                                 <table id="partstable" class="table sortable_table templates_table partstable">
                                                                   <thead>
                                                                       <th>Stage</th>
                                                                       <th>Part</th>
                                                                       <th>Comment</th>
                                                                       <th>Component</th>
                                                                       <th>Image</th>
                                                                    </thead>
                                                                   <tbody>
                                                                        
                                                                        <?php foreach ($prjprts As $key => $prjprt) {
				        	                                            if ($prjprt->stage_id == $stage['stage_id']) { ?>
                                                                        <tr id="trnumber<?php echo $count;?>" rno="<?php echo $count;?>" tr_val="<?php echo $count;?>">
                                                                            <input  name="costing_tpe_id[]" rno ='<?php echo $count ?>' id="costing_tpe_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $prjprt->costing_tpe_id ?>" />
					        	                                          <input  name="costing_part_id[]" rno ='<?php echo $count ?>' id="costing_part_id<?php echo $count ?>" type="hidden"  class="form-control" value="<?php echo $prjprt->costing_part_id ?>" />
								
                                                                           <td>
                                                                                <select data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="stage_id[<?php echo $count;?>]" id="stagefield<?php echo $count;?>" required="true">
                                                                                        <option value="<?php echo $prjprt->stage_id;?>" selected><?php echo $prjprt->stage_name;?></option>
                                                                                </select>
                                                                           </td>
                                                                           <td>
                                                                               <input class="form-control part-form-control" type="text" name="part_name[]" id="partfield<?php echo $count;?>" required="true" uniques="true" value="<?php echo $prjprt->costing_part_name; ?>"/>
                                                                           </td>
                                                                           <td>
                                                                               <textarea name="comments[]" id="comments<?php echo $count;?>" class="form-control" style="width:200px;"><?php echo $prjprt->comment;?></textarea>
                                                                           </td>
                                                                           
                                                                           <td>
                                                                               <input type="hidden" name="component_id[<?php echo $count;?>]" id="componentfield<?php echo $count;?>" value="<?php echo $prjprt->component_id;?>">
                                                                                <?php echo $prjprt->component_name;?>
                                                                           </td>
                                                                           <td id="component_img<?php echo $count;?>">
                                                                               <?php if($prjprt->component_image!=""){?>
                                                                               <img src="<?php echo base_url('assets/components/thumbnail/'.$prjprt->component_image);?>" style="width: 80px; height: 50px;">
                                                                               <?php } else{ ?>
                                                                               <img src="<?php echo base_url('assets/img/image_placeholder.jpg');?>" style="width: 80px; height: 50px;">
                                                                               <?php } ?>
                                    
                                                                           </td>
                                                                        </tr>
                                                                        <?php $count++; } ?> 
                                                                        <?php 
                                                                        } ?>
                                                                    </tbody>
                                                                   </table>
                                                           </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php endif; ?>
                                        		<?php endforeach; ?>
                                        		<input type="hidden" id="last_row" name="last_row" value="<?php echo $count-1;?>">
                                        		<input type="hidden" id="current_project_id" name="current_project_id" value="<?php echo $project_id;?>">
                                        		<input type="hidden" id="selected_tab" name="selected_tab" value="allowances">
                        
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <?php if(count($prjprts)>0){ ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                             <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
                                            <button type="submit" class="btn btn-warning btn-fill">Update Cost</button>
                                            <?php } ?>
                                         </div>
                                         <div class="pull-right">
                                            <?php if(in_array(2, $this->session->userdata("permissions"))) {?>
                                            <a href="<?php echo SURL;?>project_costing/report/allowances/<?php echo $project_id;?>" class="btn btn-warning btn-fill">Report</a>
                                            <?php } ?>
                                            <a href="<?php echo SURL;?>project_costing" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </form>
                