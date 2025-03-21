<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">person</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Clients</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(54, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>manage/add_client" class="btn btn-info"><i class="material-icons">add</i> Add Client</a>
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
                									<th>First Name 1 Surname 1</th>
                									<th> First Name 2 Surname 2</th>
                									<th>Mobile Number</th>
                									<th>Email</th>
                									<th>Notes</th>
                									<th>Created Date</th>
                									<th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $i=1;
                                                foreach($clients As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['client_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['client_fname1']." ".$val['client_surname1'];?></td>
                                                    <td><?php echo $val['client_fname2']." ".$val['client_surname2'];?></td>
                                                    <td><?php echo $val['client_mobilephone_primary'];?></td>
                                                    <td><?php echo $val['client_email_primary'];?></td>
                                                    <td><?php echo $val['client_note'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['date_created'])); ?></td>
                                                    <td><?php if($val['client_status']==1){?><span class="label label-success">Current</span><?php } else {?>
									<span class="label label-danger">Inactive</span>
									<?php } ?></td>
                                                    <td class="text-right">
                                                        <?php if(in_array(55, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>manage/edit_client/<?php echo $val['client_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(56, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'manage/delete_client', <?php echo $val['client_id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                        <?php } if(in_array(53, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>manage/view_client/<?php echo $val['client_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">pageview</i></a>
                                                        <?php } ?>
                                                        <?php
                                                         if(in_array(58, $this->session->userdata("permissions"))) {
                                                        ?>
                                                        <p><a href="<?php echo base_url();?>manage/add_project/<?php echo $val['client_id'];?>"><span class="btn btn-success btn-sm"><i class="material-icons">add</i> Create New Project</span></a></p>
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