<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">android</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Projects</h4> 
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
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Last Updated</th>
                                                    <th <?php if ($this->session->userdata('admin_role_id')!=3) { ?> class="disabled-sorting text-right" <?php } else{ ?> class="disabled-sorting text-center" <?php } ?>>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
						<?php 
						$i=1;
                                                foreach($projects As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td>
                                                        <a href="<?php echo SCURL;?>projects/edit_project/<?php echo $val['id'];?>"><img style="width:50px!important;height:50px!important;" src="<?php if($val['image']!="") { echo PROJECT_IMG."thumb/".$val['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" class="img" /></a>
                                                    </td>
                                                    <td><a href="<?php echo SCURL;?>projects/edit_project/<?php echo $val['id'];?>" class="text-default"><?php echo $val['name'];?></a></td>
                                                    <td><?php if($val['start_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['start_date'])); } ?>
</td>
                                                    <td><?php if($val['end_date']!="0000-00-00"){ echo date('d/m/Y',strtotime($val['end_date']));} ?>
</td>
                                                    <td><?php if($val['last_updated']!=""){ echo "<i class='fa fa-clock-o'></i> ".date('d/m/Y h:i A',strtotime($val['last_updated'])); }?>
</td>
                                                    <td <?php if ($this->session->userdata('admin_role_id')!=3) { ?> class="text-right" <?php } else{ ?> class="text-center" <?php } ?> >
                                                    <?php if ($this->session->userdata('admin_role_id')!=3) { ?>
                                                        <a href="<?php echo SCURL;?>projects/edit_project/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'scheduling/projects/delete_project', <?php echo $val['id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                    <?php } else { ?>
                                                       <a href="<?php echo SCURL;?>projects/edit_project/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon"><i class="material-icons">pageview</i></a>
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