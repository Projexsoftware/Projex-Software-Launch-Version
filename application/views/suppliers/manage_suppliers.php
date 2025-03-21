<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">local_shipping</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Suppliers</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(65, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>manage/add_supplier" class="btn btn-info"><i class="material-icons">add</i> Add Supplier</a>
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
                									<th>Supplier ID</th>
                									<th>Supplier Name</th>
                									<th>Supplier Email</th>
                									<th>Supplier Phone</th>
                									<th>Created Date</th>
                									<th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $i=1;
                                                foreach($suppliers As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['supplier_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['supplier_id'];?></td>
                                                    <td><?php echo $val['supplier_name'];?><?php if($val['parent_supplier_id']!="0"){?>
									       <i class="material-icons supplier-icon">person</i>
									   <?php }
									    ?></td>
                                                    <td><?php echo $val['supplier_email'];?></td>
                                                    <td><?php echo $val['supplier_phone'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['date_created'])); ?></td>
                                                    <td><?php if($val['supplier_status']==1){?><span class="label label-success">Current</span><?php } else {?>
									<span class="label label-danger">Inactive</span>
									<?php } ?></td>
                                                    <td class="text-right">
                                                        <?php if(in_array(64, $this->session->userdata("permissions")) || in_array(66, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>manage/edit_supplier/<?php echo $val['supplier_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
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