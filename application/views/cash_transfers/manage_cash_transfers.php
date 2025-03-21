<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">money</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Cash Transfers</h4> 
                                    <div class="toolbar">
                                     <?php if(in_array(44, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>cash_transfers/add_cash_transfer" class="btn btn-info"><i class="material-icons">add</i> Add Cash Transfer</a>
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
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li class="active"><a  href="#activeProjectCashTransfers" data-toggle="tab">Active</a>
                                            </li>
                                            <li><a href="#completedeProjectCashTransfers" id="completedTab" data-toggle="tab" onclick="get_completed_job_cash_transfers();">Completed</a>
                                            </li>
                                        </ul>
                        			<div class="tab-content ">
                        		   	    <div class="tab-pane active" id="activeProjectCashTransfers">
                                               <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    							<thead>
                    								<tr>
                    									<th>S.No</th>
                                                        <th>Cash Transfer #</th>
                                                        <th>Project Name</th>
                                                        <th>Supplier Name</th>
                                                        <th>Transfer Amount</th>
                                                        <th>Comment</th>
                                                        <th>Created Date</th>
                                                        <th class="disabled-sorting text-right">Actions</th>
                    								</tr>
                    							</thead>
                    							<tbody>
                                                <?php  $count =1; foreach($cash_transfers as $val) { ?>
                    								<tr>
                    									<td><?php echo $count;?></td>
                    									<td><a style="color:#428bca;" href="<?php echo SURL;?>cash_transfers/view_cash_transfer/<?php echo $val['id'];?>"><?php echo "#".$val['id'];?></a></td>
                    									<td><?php echo $val['project_title'];?></td>
                                                        <td><?php echo $val['supplier_name'];?></td>
                    									<td><?php echo number_format($val['transfer_amount'],2,'.',''); ?></td>
                                                        <td><?php echo $val['comment']; ?></td>
                                                        <td><?php echo date("d-M-Y", strtotime($val['created_date'])); ?></td>
                    									<td class="text-right">
                                                        <a class="btn btn-warning btn-icon btn-simple" href="<?php echo SURL;?>cash_transfers/view_cash_transfer/<?php echo $val['id'];?>"><i class="material-icons">edit</i></a>
                                                        </td>
                    								</tr>
                                                <?php $count++;} ?>
                    							</tbody>
					                	</table>
                                        </div>
			   
                                        <div class="tab-pane" id="completedeProjectCashTransfers">
                                        <div class="completed_cash_transfers">
                                                            <table id="ProjectCashTransfers" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        							<thead>
                                        								<tr>
                                        									<th>S.No</th>
                                                                            <th>Cash Transfer #</th>
                                                                            <th>Project Name</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Transfer Amount</th>
                                                                            <th>Comment</th>
                                                                            <th>Created Date</th>
                                                                            <th>Actions</th>
                                        								</tr>
                                        							</thead>
                                        							<tbody>
                                                                    
                                        							</tbody>
                    					                	</table>
                    					       </div>
                                       	</div>
			</div>
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