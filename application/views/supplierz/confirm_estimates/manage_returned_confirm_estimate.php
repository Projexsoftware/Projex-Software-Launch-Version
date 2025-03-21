<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">keyborad_return</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Returned Confirm Estimates</h4> 
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
									 <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                    <div class="material-datatables">
                                        
                        		
                                               <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    							<thead>
                    								<tr>
                    									<th>S.No</th>
                    									<th>Confirm Estimate Id</th>
                    									<th>Project Name</th>
                                                        <th>Supplier</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th class="disabled-sorting text-right">Actions</th>
                    								</tr>
                    							</thead>
                    							<tbody>
                                                <?php  $count =1; foreach($confirm_estimates as $val) { ?>
                    								<tr class="row_<?php echo $val->id;?>">
                    									<td><?php echo $count;?></td>
                    									<td><a style="color:#428bca;" href="<?php echo SURL;?>confirm_estimate/view_confirm_estimate/<?php echo $val->id;?>"><?php echo "#".$val->id;?></a></td>
                    									<td><?php echo $val->project_title;?></td>
                                                        <td><?php echo $val->supplier_name;?></td>
                    									<td><?php echo date("d/m/Y", strtotime($val->created_at));?></td>
                    									<td><?php if($val->status==1){?><span class="label label-success">Sent</span><?php } else if($val->status==0){?><span class="label label-warning">Pending</span><?php } else {?><span class="label label-danger">Returned</span><?php } ?>
                    									</td>
                    									<td class="text-right">
                                                        <?php if($val->status==2){?>
                                                        <a href="<?php echo SURL;?>supplierz/view_confirm_estimate/<?php echo $val->id;?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">pageview</i></a>
                                                        <?php } else {?>
                                                        <a href="<?php echo SURL;?>supplierz/update_confirm_estimate/<?php echo $val->id;?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } ?>
                                                        </td>
                    								</tr>
                                                <?php $count++;} ?>
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