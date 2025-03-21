<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">help</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Help Section</h4> 
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
                                                    <th>Help Category</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $j=1;
                    						    $categories = array("Introduction", "Setup", "Designz", "Costingz", "Accountz", "Buildz");
                                                for($i=0;$i<count($categories);$i++){ ?>
                                                <tr>
                                                    <td><?php echo $j;?></td>
                                                    <td><a target="_Blank" href="<?php echo SURL;?>help/view_help_section/<?php echo str_replace(" ", "-", $categories[$i]);?>"><i class="material-icons">chevron_right</i> <?php echo $categories[$i];?></a></td>
                                                     <td class="text-right">
                                                        <a href="<?php echo SURL;?>help/view_help_section/<?php echo $categories[$i];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                    </td>
                                                </tr>
                                                <?php 
												$j++;
												}  ?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
    
                                             </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->