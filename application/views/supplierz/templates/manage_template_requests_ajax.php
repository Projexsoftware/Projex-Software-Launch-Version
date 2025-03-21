<table id="templateRequestDatatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Template</th>
                									<th>Date Request Made</th>
                                                    <th>Company Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Status</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            	<tbody>
                            <?php  $count =1; foreach($template_requests as $template) {
                                
                                 $user_info = get_price_book_supplier_info($template["from_user_id"]);
                            		
                            	?>
								<tr>
									<td><?php echo $count;?></td>
									<td><?php echo get_template_name($template["template_id"]);?></td>
									<td><?php echo date("d-M-Y", strtotime($template["created_date"]));?></td>
										<td><?php echo $user_info['com_name'];?></td>
								<td><?php echo $user_info['user_fname']." ".$user_info['user_lname'];?></td>
								
									<td><?php echo $user_info['com_phone_no'];?></td>
										<td>
									  <?php if($template["status"] == 0){
									   echo '<span class="label label-warning">Pending</span>';   
									  } else if($template["status"] == 1){
									   echo '<span class="label label-success">Accepted</span>'; 
									  }
									  else if($template["status"] == 2){
									   echo '<span class="label label-success">Price book has been uploaded into components</span>'; 
									  }
									  else{
									      echo '<span class="label label-danger">Declined</span>'; 
									  }
									  
									  ?>
									    
									</td>
                                    <td class="text-right">
                                    <?php if($template["status"] == 0){ ?>
                                    <a id="<?php echo $template['id'];?>" class="btn btn-sm btn-success btn-accept-template-request" href="javascript:void(0);"><i class="material-icons">done</i> Accept</a>
                                    <a  id="<?php echo $template['id'];?>" class="btn btn-sm btn-danger btn-decline-template-request"><i class="material-icons">close</i> Decline</a>
                                    <?php } ?>
                                    <a  class="btn btn-sm btn-warning" target="_blank" href="<?php echo SURL;?>supplierz/edit_template/<?php echo $template['template_id'];?>"><i class="material-icons">edit</i> View Template</a>
                                    </td>
								</tr>
                            <?php $count++;} ?>
							</tbody>
                                        </table>