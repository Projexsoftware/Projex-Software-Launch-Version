<table id="priceBookDatatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                									<th>Date Request Made</th>
                									<th>Company Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Number</th>
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
                                                        <a id="<?php echo $request['id'];?>" class="btn btn-sm btn-success btn-accept-request" href="javascript:void(0);"><i class="material-icons">done</i> Accept</a>
                                                        <a  id="<?php echo $request['id'];?>" class="btn btn-sm btn-danger btn-decline-request"><i class="material-icons">close</i> Decline</a>
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