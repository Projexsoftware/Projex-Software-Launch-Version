<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">book</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Price Book Requests</h4>
                                    <span class="text-success"><i style="vertical-align:middle;" class="material-icons">note_alt</i> <b>The following requests you have been sent to companies to open a price book for your use:</b></span>
                                    <div class="toolbar">
                                        <?php if(in_array(121, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>price_book_requests/send_request" class="btn btn-info"><i class="material-icons">add</i> Send Price Book Request</a>
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
                									<th>Date Request Made</th>
                									<th>Company Name</th>
                									<th>User Name</th>
                                                    <th>Supplier Name</th>
                                                    <th>Supplier Email</th>
                                                    <th>Allocate Price Book</th>
                                                    <th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $i=1;
                                                foreach($requests As $key=>$request) { 
                                                 $company_info = get_price_book_supplier_info($request['to_user_id']);
                                                ?>
                                                <tr class="row_<?php echo $request['id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td>
                                                        <?php echo date("d/M/Y", strtotime($request['created_date']));?>
                                                    </td>
                                                     <td>
                                                        <?php 
                    									$company_name = get_company_info();
                    									echo $company_name['com_name'];
                    									?>
                    								</td>
                                                    <td><?php echo get_user_name($request['from_user_id']);?></td>
                                                    <td><?php echo $company_info['com_name'];?> <i style="vertical-align:bottom;" class="material-icons">person</i></td>
                                                    <td><?php echo $company_info['user_email'];?></td>
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
                                                        <?php if($request['status'] == 0){ ?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'price_book_requests/delete_request', <?php echo $request['id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
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