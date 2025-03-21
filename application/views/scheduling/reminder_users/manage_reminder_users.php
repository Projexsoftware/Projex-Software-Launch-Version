<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">notifications</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Reminder Users</h4> 
                                    <div class="toolbar">
                                     <?php if ($this->session->userdata('admin_role_id')!=3) { ?>
                                        <a href="<?php echo SURL;?>reminder_users/add_user" class="btn btn-info"><i class="material-icons">add</i> Add Reminder User</a>
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
                                                    <th>Task</th>
                                                    <th>Reminder User</th>
                                                    <th>Reminder Message</th>
                                                    <th>Created Date</th>
                                                    <th <?php if ($this->session->userdata('admin_role_id')!=3) { ?> class="disabled-sorting text-right" <?php } else{ ?> class="disabled-sorting text-center" <?php } ?>>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
						<?php 
						$i=1;
                                                foreach($reminder_users As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo get_task_name($val['task_id']);?></td>
                                                    <td><?php echo $val['email'];?></td>
                                                     <td><?php echo $val['message'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['created_date'])); ?></td>
                                                    <td <?php if ($this->session->userdata('admin_role_id')!=3) { ?> class="text-right" <?php } else{ ?> class="text-center" <?php } ?> >
                                                    <?php if ($this->session->userdata('admin_role_id')!=3) { ?>
                                                        <a href="<?php echo SURL;?>reminder_users/edit_user/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'reminder_users/delete_user', <?php echo $val['id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                    <?php } else { ?>
                                                       <a href="<?php echo SURL;?>reminder_users/edit_user/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon"><i class="material-icons">pageview</i></a>
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