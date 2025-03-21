<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">person</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Users</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(90, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>setup/add_user" class="btn btn-info"><i class="material-icons">add</i> Add User</a>
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
													<th>Image</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
													<th>Email</th>
													<th>Role</th>
													<th>Status</th>
                                                    <th>Created Date</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											    <?php 
												$i=1;
                                                foreach($users As $key=>$val) { 
												if($this->session->userdata("user_id")!=$val['user_id']){
												?>
                                                <tr class="row_<?php echo $val['user_id'];?>">
                                                    <td><?php echo $i;?></td>
													<td>
													   <div class="fileinput-new thumbnail img-circle" style="width:50px;">
													     <?php if($val['user_img']==""){
													         $val['user_img'] = "project_avatar.png";
													     }?>
                                                          <img src="<?php echo PROFILE_IMG.$val['user_img'];?>" alt="...">
                                                       </div>
												    </td>
                                                    <td><?php echo $val['user_fname'];?></td>
                                                    <td><?php echo $val['user_lname'];?></td>
													<td><?php echo $val['user_email'];?></td>
													<td><?php echo get_role_title($val['role_id']);?></td>
													<td><?php if($val['user_status']==0){ echo '<span class="label label-danger">Inactive</span>'; } else{ echo '<span class="label label-success">Active</span>'; }?></td>
													<td><?php echo date('d/m/Y',strtotime($val['date_created'])); ?></td>
													<td class="text-right">
													     <?php if(in_array(89, $this->session->userdata("permissions")) || in_array(91, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>setup/edit_user/<?php echo $val['user_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(92, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'setup/delete_user', <?php echo $val['user_id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                       <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php 
												$i++;
												}
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