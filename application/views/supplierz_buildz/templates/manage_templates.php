<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">phonelink_setup</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Buildz Templates</h4> 
                                    <div class="toolbar">
                                        <a href="<?php echo SURL;?>supplierz_buildz/templates/add_template" class="btn btn-info"><i class="material-icons">add</i> Add Buildz Template</a>
                                        <a href="<?php echo SURL;?>supplierz_buildz/tasks" class="btn btn-info"><i class="material-icons">add</i> Add/Manage Buildz Tasks</a>
                                        <a href="<?php echo SURL;?>supplierz_buildz/checklists" class="btn btn-info"><i class="material-icons">add</i> Add/Manage Buildz Checklists</a>
                                    
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
                                                    <th>Name</th>
                                                    <th>Created Date</th>
                                                    <th>Available For Import By User</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
						<?php 
						$i=1;
                                                foreach($templates As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['name'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['created_at'])); ?>
</td>
                                                    <td class="text-center">
                                                        <div class="checkbox" style="width:auto!important;">
                                                            <label>
                                                            <input type="checkbox" class="available_for_import_by_user" name="available_for_import_by_user[]" id="available_for_import_by_user<?php echo $val['id'];?>" <?php if(isset($val['available_for_import_by_user']) && $val['available_for_import_by_user']==1){?> checked <?php } ?> value="<?php echo $val['id'];?>">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="<?php echo SURL;?>supplierz_buildz/templates/edit_template/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'supplierz_buildz/templates/delete_template', <?php echo $val['id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                    
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