<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">draw</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Designz</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(161, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>supplierz/add_designz" class="btn btn-info"><i class="material-icons">add</i> Add Designz</a>
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
                									<th>Designz Name</th>
                									<th>Floor Area</th>
                									<th>Bedrooms</th>
                									<th>Bathrooms</th>
                									<th>Living Areas</th>
                									<th>Garage</th>
                									<th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $i=1;
                                                foreach($designz As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['designz_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td>
                                                        <?php 
                                                            echo $val['project_name'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo $val['floor_area'];?>m²</td>
                                                    <td><?php echo $val['bedrooms'];?></td>
                                                    <td><?php echo $val['bathrooms'];?></td>
                                                    <td><?php echo $val['living_areas'];?></td>
                                                    <td><?php echo $val['garage'];?></td>
                                                    <td><?php if($val['status']==1){?><span class="label label-success">Current</span><?php } else {?>
                    									<span class="label label-danger">Inactive</span>
                    									<?php } ?>
                    								</td>
                                                    <td class="text-right">
                                                        <?php if(in_array(161, $this->session->userdata("permissions")) || in_array(71, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>supplierz/edit_designz/<?php echo $val['designz_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(161, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'supplierz/delete_designz', <?php echo $val['designz_id'];?>, <?php echo $val['available_for_builderz']==1?true:false;?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                        <?php } ?>
                                                        <div class="checkbox" style="width:auto!important;">
                                                            <label>
                                                            <input type="checkbox" class="available_for_builderz" name="available_for_builderz[]" id="available_for_builderz<?php echo $val['designz_id'];?>" <?php if($val['available_for_builderz']==1){?> checked <?php } ?> value="<?php echo $val['designz_id'];?>">
                                                            </label>
                                                        </div>
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