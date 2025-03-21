<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">menu_book</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Price Books</h4> 
                                    <div class="toolbar">
                                     <?php if(in_array(116, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>supplierz/add_price_book" class="btn btn-info"><i class="material-icons">add</i> Add Price Book</a>
                                     <?php } ?>
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
                    									<th>Price Book Name</th>
                                                        <th>Created Date</th>
                                                        <th class="disabled-sorting text-right">Actions</th>
                    								</tr>
                    							</thead>
                    							<tbody>
                                                <?php  $count =1; foreach($price_books as $val) { ?>
                    								<tr class="row_<?php echo $val['id'];?>">
                    									<td><?php echo $count;?></td>
                    									<td><?php echo $val['name'];?></td>
                                                        <td><?php echo date("d/M/Y", strtotime($val['date_created'])); ?></td>
                    									<td class="text-right">
                                                        <?php if(in_array(115, $this->session->userdata("permissions")) || in_array(117, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>supplierz/edit_price_book/<?php echo $val['id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(118, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'supplierz/delete_price_book', <?php echo $val['id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
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