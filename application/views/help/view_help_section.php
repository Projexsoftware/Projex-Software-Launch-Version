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
                                            
                                            <tbody>
                    						<?php 
                    						$i=1;
                    						  if(count($help_section)>0){
                                                foreach($help_section As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><a target="_Blank" href="<?php echo HELP_FILE_PATH.$val['help_uploads'];?>"><i class="material-icons pdf-icon">picture_as_pdf</i> <?php echo $val['help_uploads'];?></a></td>
                                                </tr>
                                                <?php 
												$i++;
												} } ?>
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