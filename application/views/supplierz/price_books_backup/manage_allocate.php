<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">assignment_turned_in</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Allocate Price Book Requests</h4>
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
                                    <div class="material-datatables priceBookRequests">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                									<th>Date Request Made</th>
                									<th>Company Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Allocate Price Book</th>
                                                    <th>Notes</th>
                                                    <th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    if(count($price_book_requests)>0){
                    						    $i=1;
                                                foreach($price_book_requests As $key=>$request) { 
                                                 $user_info = get_price_book_supplier_info($request['from_user_id']);
                                                ?>
                                                <tr class="row_<?php echo $request['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td>
                                                        <?php echo date("d/M/Y", strtotime($request['created_date']));?>
                                                    </td>
                                                     <td><?php echo $user_info['com_name'];?></td>
                                                     <td><?php echo $user_info['user_fname']." ".$user_info['user_lname'];?></td>
								                     <td><?php echo $user_info['com_phone_no'];?></td>
								                     <?php  
                                                    if($request['allocate_price_book_id']>0){
                                                    $price_book_info = get_price_book_name($request['allocate_price_book_id']);
                                                		
                                                	?>
                    									<td><i style="color:#6bafbd;" class="fa fa-book"></i> <?php echo $price_book_info['name'];?>
                    									
                    									</td>
                    									<?php } else{ ?>
                    									<td><span class="label label-success">Not Allocated Yet</span></td>
                    									<?php } ?>
                    								    
                    									<td>
                    									 <?php if($request['notes']!=""){ ?>
                    									<i style="cursor:pointer;color:crimson;font-size:14px;" class="fa fa-file" data-toggle="tooltip" data-html="true" title="<p></p><p><?php echo $request['notes'];?></p>" data-placement="bottom"></i>
                    									<?php } ?>
                    									</td>
                                                    <td>
                                                        <?php if($request['status'] == 0){
                    									   echo '<span class="label label-warning">Pending</span>';   
                    									  } else if($request['status'] == 1){
                    									   echo '<span class="label label-success">Accepted</span>'; 
                    									   echo '<br/><br/><span class="label label-warning">Price book pending</span>';
                    									   
                    									  }
                    									  else if($request['status'] == 2){
                    									   echo '<span class="label label-success">Price book has been uploaded into components</span>'; 
                    									  }
                    									  else{
                    									      echo '<span class="label label-danger">Declined</span>'; 
                    									  }
                    									  ?>
                    								</td>
                                                    <td class="text-right">
                                                        <?php if($request['status'] == 2){ ?>
                                                        <a  class="btn btn-sm btn-warning" href="<?php echo SURL;?>supplierz/view/<?php echo $request['id'];?>"><i class="material-icons">view_comfy</i> View</a>
                                                        <?php } else if($request['status'] == 1){ ?>
                                                        <a  class="btn btn-sm btn-success" href="<?php echo SURL;?>supplierz/allocate_price_book/<?php echo $request['id'];?>"><i class="material-icons">done</i> Allocate</a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php 
												$i++;
												} }?>
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