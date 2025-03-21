<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">done_all</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Buildz Checklists</h4> 
                                    <div class="toolbar">
                                        <a href="<?php echo SURL;?>supplierz_buildz/checklists/add_checklist" class="btn btn-info"><i class="material-icons">add</i> Add Buildz Checklist</a>
                                        <a href="<?php echo SURL;?>supplierz_buildz/templates" class="btn btn-warning"><i class="material-icons">arrow_back</i> Buildz Templates</a>
                                        
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
                                                    <th>Checklist</th>
                                                    <th>Created Date</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
						<?php 
						$i=1;
                                                foreach($checklists As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo get_buildz_task_name($val['task_id']);?></td>
                                                    <td><?php echo $val['name'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['created_date'])); ?></td>
                                                    <td class="text-right">
                                                        <a href="<?php echo SURL;?>supplierz_buildz/checklists/edit_checklist/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'supplierz_buildz/checklists/delete_checklist', <?php echo $val['id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
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