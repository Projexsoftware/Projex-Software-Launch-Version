<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">phonelink_setup</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Template Store</h4> 
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
                                                foreach($templates As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['template_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['template_name'];?></td>
                                                    <td><?php echo $val['template_desc'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['created_date'])); ?></td>
                                                    <td><?php if($val['template_status']==1){?><span class="label label-success">Current</span><?php } else {?>
                    									<span class="label label-danger">Inactive</span>
                    									<?php } ?>
                    								</td>
                                                    <td class="text-right" >
                                                        <a href="<?php echo SURL;?>setup/import_template/<?php echo $val['template_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i> Import</a>
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