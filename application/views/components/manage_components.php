<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">star</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Components</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(70, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>manage/add_component" class="btn btn-info"><i class="material-icons">add</i> Add Component</a>
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
                									<th>Supplier</th>
                									<th>Category</th>
                									<th>Image</th>
                									<th>Name</th>
                									<th>Description</th>
                									<th>Unit of Measure</th>
                									<th>Unit Cost</th>
                									<th>Created Date</th>
                									<th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $i=1;
                                                foreach($components As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['component_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td>
                                                        <?php 
                                                            $supplier_info = get_supplier_info($val['supplier_id']);
                                                            echo $supplier_info['supplier_name'];
                                                        ?>
                                                    </td>
                                                    <td><?php if($val['component_category']!="0"){ echo $val['component_category']; }?></td>
                                                    <td><img style="width:50px!important;height:50px!important;" src="<?php if($val['image']!="") { echo COMPONENT_IMG."thumbnail/".$val['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" class="img" /></td>
                                                    <td><?php if($val['price_book_id'] == 0){ echo $val['component_name']; } else{ echo '<i style="color:#6bafbd;" class="fa fa-book"></i> '.$val['component_name']; } ?></td>
                                                    <td><?php echo $val['component_des'];?></td>
                                                    <td><?php echo $val['component_uom'];?></td>
                                                    <td><?php echo $val['component_uc'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['date_created'])); ?></td>
                                                    <td><?php if($val['component_status']==1){?><span class="label label-success">Current</span><?php } else {?>
                    									<span class="label label-danger">Inactive</span>
                    									<?php } ?>
                    								</td>
                                                    <td class="text-right">
                                                        <?php if(in_array(69, $this->session->userdata("permissions")) || in_array(71, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>manage/edit_component/<?php echo $val['component_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(72, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'manage/delete_component', <?php echo $val['component_id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
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