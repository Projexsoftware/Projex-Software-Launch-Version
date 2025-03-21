<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">roofing</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Buildz</h4> 
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
                                    <div class="material-datatables">
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li class="active"><a href="#activeProjects" data-toggle="tab">Active</a></li>
                                            <li><a href="#pendingProjects" data-toggle="tab">Pending</a></li>
                                            <li><a href="#completedProjects" data-toggle="tab">Completed</a></li>
                                            <li><a href="#inactiveProjects" data-toggle="tab">Inactive</a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="activeProjects">
                                            	  <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <!--<th>Start Date</th>
                                                            <th>End Date</th>-->
                                                            <th>Created Date</th>
                                                            <th class="disabled-sorting text-right">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                						<?php 
                                						if(count($active_projects)>0){
                                						     $i=1;
                                                             foreach($active_projects As $key=>$val) { ?>
                                                        <tr class="row_<?php echo $val['project_id'];?>">
                                                            <td><?php echo $i;?></td>
                                                            <td><a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="text-default"><?php echo $val['project_title'];?></a></td>
                                                            <!--<td><?php if($val['start_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['start_date'])); } ?>
        </td>
                                                            <td><?php if($val['end_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['end_date']));} ?>
        </td>-->
                                                            <td><?php if($val['date_created']!=""){ echo "<i class='fa fa-clock-o'></i> ".date('d/m/Y h:i A',strtotime($val['date_created'])); }?>
        </td>
                                                            <td class="text-right">
                                                               <a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="btn btn-simple btn-warning btn-icon"><i class="material-icons">edit</i></a>
                                                            </td>
        
                                                        </tr>
                                                        <?php 
        												$i++;
        												} ?>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="pendingProjects">
                                                <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <!--<th>Start Date</th>
                                                            <th>End Date</th>-->
                                                            <th>Created Date</th>
                                                            <th class="disabled-sorting text-right">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                						<?php 
                                						if(count($pending_projects)>0){
                                						     $i=1;
                                                             foreach($pending_projects As $key=>$val) { ?>
                                                        <tr class="row_<?php echo $val['project_id'];?>">
                                                            <td><?php echo $i;?></td>
                                                            <td><a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="text-default"><?php echo $val['project_title'];?></a></td>
                                                            <!--<td><?php if($val['start_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['start_date'])); } ?>
        </td>
                                                            <td><?php if($val['end_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['end_date']));} ?>
        </td>-->
                                                            <td><?php if($val['date_created']!=""){ echo "<i class='fa fa-clock-o'></i> ".date('d/m/Y h:i A',strtotime($val['date_created'])); }?>
        </td>
                                                            <td class="text-right">
                                                               <a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="btn btn-simple btn-warning btn-icon"><i class="material-icons">edit</i></a>
                                                            </td>
        
                                                        </tr>
                                                        <?php 
        												$i++;
        												} ?>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="completedProjects">
                                                <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <!--<th>Start Date</th>
                                                            <th>End Date</th>-->
                                                            <th>Created Date</th>
                                                            <th class="disabled-sorting text-right">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                						<?php 
                                						if(count($completed_projects)>0){
                                						$i=1;
                                                             foreach($completed_projects As $key=>$val) { ?>
                                                        <tr class="row_<?php echo $val['project_id'];?>">
                                                            <td><?php echo $i;?></td>
                                                            <td><a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="text-default"><?php echo $val['project_title'];?></a></td>
                                                            <!--<td><?php if($val['start_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['start_date'])); } ?>
        </td>
                                                            <td><?php if($val['end_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['end_date']));} ?>
        </td>-->
                                                            <td><?php if($val['date_created']!=""){ echo "<i class='fa fa-clock-o'></i> ".date('d/m/Y h:i A',strtotime($val['date_created'])); }?>
        </td>
                                                            <td class="text-right">
                                                               <a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="btn btn-simple btn-warning btn-icon"><i class="material-icons">edit</i></a>
                                                            </td>
        
                                                        </tr>
                                                        <?php 
        												$i++;
        												} ?>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="inactiveProjects">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <!--<th>Start Date</th>
                                                            <th>End Date</th>-->
                                                            <th>Created Date</th>
                                                            <th class="disabled-sorting text-right">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                						<?php 
                                						if(count($inactivate_projects)>0){
                                						$i=1;
                                                             foreach($inactivate_projects As $key=>$val) { ?>
                                                        <tr class="row_<?php echo $val['project_id'];?>">
                                                            <td><?php echo $i;?></td>
                                                            <td><a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="text-default"><?php echo $val['project_title'];?></a></td>
                                                            
                                                            <td><?php if($val['date_created']!=""){ echo "<i class='fa fa-clock-o'></i> ".date('d/m/Y h:i A',strtotime($val['date_created'])); }?>
        </td>
                                                            <td class="text-right">
                                                               <a href="<?php echo SURL;?>buildz/edit_buildz/<?php echo $val['project_id'];?>" class="btn btn-simple btn-warning btn-icon"><i class="material-icons">edit</i></a>
                                                            </td>
        
                                                        </tr>
                                                        <?php 
        												$i++;
        												} ?>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
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