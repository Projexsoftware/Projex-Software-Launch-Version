<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">house</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Project Costing</h4> 
                                    <div class="toolbar">
                                     <?php if(in_array(3, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>supplierz/add_project_costing" class="btn btn-info"><i class="material-icons">add</i> Add Project Costing</a>
                                     <?php } ?>
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
                                        <div class="material-datatables">
                                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Costing Name</th>
                                                                        <th>Description</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($project_costing as $project) {?>
                                                                    
                                                                    <tr class="row_<?php echo $project->costing_id;?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><a href="<?php echo SURL;?>supplierz/edit_project_costing/<?php echo $project->costing_id;?>"><?php echo $project->costing_name;?></a></td>
                                                                        <td><?php echo substr($project->costing_description,0,100);?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($project->created_date)); ?></td>
                                                                        <td>
                                                                        <?php if($project->status==1){?><span class="label label-success">Current</span><?php } else if($project->status==2){?><span class="label label-warning">Pending</span><?php } else if($project->status==3){?><span class="label label-inverse">Completed</span><?php } else {?>
                                    									<span class="label label-danger">Inactive</span><?php } ?>
                                        								</td>
                                                                        <td class="text-right" >
                                                                           <a href="<?php echo SURL;?>supplierz/edit_project_costing/<?php echo $project->costing_id;?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                           <a onclick="demo.showSwal('warning-message-and-confirmation', 'supplierz/delete_project_costing', <?php echo $project->costing_id;?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                    	</div>
                                    </div>
                                </div>
                            </div>
    
                                             </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->