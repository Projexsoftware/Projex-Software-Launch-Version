<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">phonelink_setup</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Templates</h4> 
                                    <div class="toolbar">
                                     <?php if(in_array(85, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>setup/add_template" class="btn btn-info"><i class="material-icons">add</i> Add Template</a>
                                     <?php } ?>
                                     <?php /*if(in_array(114, $this->session->userdata("permissions"))) {?>
                                         <a href="<?php echo SURL;?>setup/import_template" class="btn btn-warning"><i class="material-icons">add</i> Import Template</a>
                                     <?php }*/ ?>
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
                                                    <th>Template Name</th>
                                                    <th>Template Description</th>
                                                    <th>Created Date</th>
                                                    <th>Status</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
						<?php 
						$i=1;
                                                foreach($templates As $key=>$val) { 
                                                $is_component_missing = check_costingz_missing_component($val['template_id']);
                                                ?>
                                                <tr class="row_<?php echo $val['template_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['template_name'];?></td>
                                                    <td><?php echo $val['template_desc'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['created_date'])); ?></td>
                                                    <td><?php if($is_component_missing){?> <span class="label label-danger">Needs Fixing</span> <?php } else{ if($val['template_status']==1){?><span class="label label-success">Current</span><?php } else {?>
                    									<span class="label label-danger">Inactive</span>
                    									<?php } }?>
                    								</td>
                                                    <td class="text-right" >
                                                        <?php if(in_array(84, $this->session->userdata("permissions")) || in_array(86, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>setup/edit_template/<?php echo $val['template_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(85, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'setup/delete_template', <?php echo $val['template_id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
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