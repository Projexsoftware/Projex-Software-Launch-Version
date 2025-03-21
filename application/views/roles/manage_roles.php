<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">accessibility</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Roles</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(95, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>setup/add_role" class="btn btn-info"><i class="material-icons">add</i> Add Role</a>
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
                                                    <th>Role Title</th>
                                                    <th>Status</th>
                                                    <th>Created Date</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											    <?php 
												$i=1;
                                                foreach($roles As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['role_title'];?></td>
                                                    <td><?php if($val['status']==0){ echo '<span class="label label-danger">Inactive</span>'; } else{ echo '<span class="label label-success">Active</span>'; }?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['created_date'])); ?></td>
                                                    <td class="text-right">
                                                        <?php if(in_array(91, $this->session->userdata("permissions")) || in_array(94, $this->session->userdata("permissions"))){ ?>
                                                        <a href="<?php echo SURL;?>setup/edit_role/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } ?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'setup/delete_role', <?php echo $val['id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
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