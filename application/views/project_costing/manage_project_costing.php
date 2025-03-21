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
                                        <a href="<?php echo SURL;?>project_costing/add_project_costing" class="btn btn-info"><i class="material-icons">add</i> Add Project Costing</a>
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
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li class="active"><a href="#activeProjectCosting" data-toggle="tab">Active</a></li>
                                            <li><a href="#pendingProjectCosting" data-toggle="tab">Pending</a></li>
                                            <li><a href="#completedProjectCosting" data-toggle="tab">Completed</a></li>
                                            <li><a href="#inactiveProjectCosting" data-toggle="tab">Inactive</a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="activeProjectCosting">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name</th>
                                                                        <th>Client</th>
                                                                        <th>Description</th>
                                                                        <th>Location</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($active_projects as $project) {?>
                                                                    
                                                                    <tr class="row_<?php echo $project->project_id;?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>"><?php echo $project->project_title;?></a></td>
                                                                        <td><?php echo $project->client_fname1." ".$project->client_surname1." ".$project->client_fname2." ".$project->client_surname2;?></td>
                                                                        <td><?php echo substr($project->project_des,0,100);?></td>
                                                                        <td><?php echo $project->city_name.", ".$project->state_name.", ".$project->country_name;?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($project->created_date)); ?></td>
                                                                        <td>
                                                                        <?php if($project->project_status==1){?><span class="label label-success">Current</span><?php } else if($project->project_status==2){?><span class="label label-warning">Pending</span><?php } else if($project->project_status==3){?><span class="label label-inverse">Completed</span><?php } else {?>
                                    									<span class="label label-danger">Inactive</span><?php } ?>
                                        								</td>
                                                                        <td class="text-right" >
                                                                           <a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                            </div>
                                            <div class="tab-pane" id="pendingProjectCosting">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name</th>
                                                                        <th>Client</th>
                                                                        <th>Description</th>
                                                                        <th>Location</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($pending_projects as $project) {?>
                                                                    
                                                                    <tr class="row_<?php echo $project->project_id;?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>"><?php echo $project->project_title;?></a></td>
                                                                        <td><?php echo $project->client_fname1." ".$project->client_surname1." ".$project->client_fname2." ".$project->client_surname2;?></td>
                                                                        <td><?php echo substr($project->project_des,0,100);?></td>
                                                                        <td><?php echo $project->city_name.", ".$project->state_name.", ".$project->country_name;?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($project->created_date)); ?></td>
                                                                        <td>
                                                                        <?php if($project->project_status==1){?><span class="label label-success">Current</span><?php } else if($project->project_status==2){?><span class="label label-warning">Pending</span><?php } else if($project->project_status==3){?><span class="label label-inverse">Completed</span><?php } else {?>
                                    									<span class="label label-danger">Inactive</span><?php } ?>
                                        								</td>
                                                                        <td class="text-right" >
                                                                           <a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                            </div>
                                            <div class="tab-pane" id="completedProjectCosting">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name</th>
                                                                        <th>Client</th>
                                                                        <th>Description</th>
                                                                        <th>Location</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($completed_projects as $project) {?>
                                                                    
                                                                    <tr class="row_<?php echo $project->project_id;?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>"><?php echo $project->project_title;?></a></td>
                                                                        <td><?php echo $project->client_fname1." ".$project->client_surname1." ".$project->client_fname2." ".$project->client_surname2;?></td>
                                                                        <td><?php echo substr($project->project_des,0,100);?></td>
                                                                        <td><?php echo $project->city_name.", ".$project->state_name.", ".$project->country_name;?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($project->created_date)); ?></td>
                                                                        <td>
                                                                        <?php if($project->project_status==1){?><span class="label label-success">Current</span><?php } else if($project->project_status==2){?><span class="label label-warning">Pending</span><?php } else if($project->project_status==3){?><span class="label label-inverse">Completed</span><?php } else {?>
                                    									<span class="label label-danger">Inactive</span><?php } ?>
                                        								</td>
                                                                        <td class="text-right" >
                                                                           <a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                            </div>
                                            <div class="tab-pane" id="inactiveProjectCosting">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name</th>
                                                                        <th>Client</th>
                                                                        <th>Description</th>
                                                                        <th>Location</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($inactive_projects as $project) {?>
                                                                    
                                                                    <tr class="row_<?php echo $project->project_id;?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>"><?php echo $project->project_title;?></a></td>
                                                                        <td><?php echo $project->client_fname1." ".$project->client_surname1." ".$project->client_fname2." ".$project->client_surname2;?></td>
                                                                        <td><?php echo substr($project->project_des,0,100);?></td>
                                                                        <td><?php echo $project->city_name.", ".$project->state_name.", ".$project->country_name;?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($project->created_date)); ?></td>
                                                                        <td>
                                                                        <?php if($project->project_status==1){?><span class="label label-success">Current</span><?php } else if($project->project_status==2){?><span class="label label-warning">Pending</span><?php } else if($project->project_status==3){?><span class="label label-inverse">Completed</span><?php } else {?>
                                    									<span class="label label-danger">Inactive</span><?php } ?>
                                        								</td>
                                                                        <td class="text-right" >
                                                                           <?php if(in_array(2, $this->session->userdata("permissions")) || in_array(4, $this->session->userdata("permissions"))) {?>
                                                                           <a href="<?php echo SURL;?>project_costing/edit_project_costing/<?php echo $project->project_id;?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                           <?php } ?>
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
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->