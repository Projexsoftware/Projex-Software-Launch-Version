<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">timeline</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Stages</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(75, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>setup/add_stage" class="btn btn-info"><i class="material-icons">add</i> Add Stage</a>
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
                                                    <th>Stage Name</th>
                                                    <th>Stage Description</th>
                                                    <th>Created Date</th>
                                                    <th>Status</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
						<?php 
						$i=1;
                                                foreach($stages As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['stage_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['stage_name'];?></td>
                                                    <td><?php echo $val['stage_description'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['date_created'])); ?></td>
                                                    <td><?php if($val['stage_status']==1){?><span class="label label-success">Current</span><?php } else {?>
                    									<span class="label label-danger">Inactive</span>
                    									<?php } ?>
                    								</td>
                                                    <td class="text-right">
                                                        <?php if(in_array(74, $this->session->userdata("permissions")) || in_array(76, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>setup/edit_stage/<?php echo $val['stage_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(77, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'setup/delete_stage', <?php echo $val['stage_id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
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