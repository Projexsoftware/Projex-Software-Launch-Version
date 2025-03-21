<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">android</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Projects</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(59, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>manage/add_project" class="btn btn-info"><i class="material-icons">add</i> Add Project</a>
                                        <?php }
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
                									<th>Project Name</th>
                									<th>Client</th>
                									<th>Description</th>
                									<th>Location</th>
                									<th>Created Date</th>
                									<th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $i=1;
                                                foreach($projects As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['project_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['project_title'];?></td>
                                                    <td>
                                                        <?php 
                                                            $client_info = get_client_info($val['client_id']);
                                                            echo $client_info['client_fname1']." ".$client_info['client_surname1']." ".$client_info['client_fname2']." ".$client_info['client_surname2'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo $val['project_des'];?></td>
                                                    <td><?php echo $val['street_pobox'].", ".$val['suburb'].", ".$val['project_address_city'].", ".$val['project_address_state'].", ".$val['project_address_country'].", ".$val['project_zip'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['date_created'])); ?></td>
                                                    <td><?php if($val['project_status']==1){?><span class="label label-success">Current</span><?php } else if($val['project_status']==2){?><span class="label label-warning">Pending</span><?php } else if($val['project_status']==3){?><span class="label label-success">Complete</span><?php } else {?>
									<span class="label label-danger">Inactive</span>
									<?php } ?></td>
                                                    <td class="text-right">
                                                        <?php if(in_array(58, $this->session->userdata("permissions")) || in_array(60, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>manage/edit_project/<?php echo $val['project_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(62, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'manage/delete_project', <?php echo $val['project_id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                        <?php } 
                                                        if(in_array(62, $this->session->userdata("permissions"))) {
                                                        ?>
                    									<p><a class="btn btn-warning btn-sm" href="<?php echo SURL.'project_costing/edit_project_costing/'.$val['project_id'] ?>"><i class="material-icons">android</i> Project Costing</a></p>
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
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->