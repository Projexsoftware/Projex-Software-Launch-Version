<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">summarize</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Manage Sales Credits Notes</h4> 
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
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li class="active"><a href="#activeSalesCreditsNotes" data-toggle="tab">Active</a></li>
                                            <li><a id="completedTab" href="#completedSalesCreditsNotes" data-toggle="tab" onclick="get_completed_job_sales_credits_notes();">Completed</a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="activeSalesCreditsNotes">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Sales Credit #</th>
                                                                        <th>Project Name</th>
                                                                        <th>Reference</th>
                                                                        <th>Subtotal</th>
                                                                        <th>Tax Type</th>
                                                                        <th>Tax</th>
                                                                        <th>Total</th>
                                                                        <th>Date</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                            						foreach ($credit_notes as $credit_note) { 
                                            						?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo $credit_note['id']; ?></td>
                                                                        <td><?php echo $credit_note['project_title']; ?></td>
                                                                        <td><?php echo $credit_note['reference']; ?></td>
                                                                        <td><?php echo number_format($credit_note['subtotal'],2,'.',''); ?></td>
                                                                        <td><?php echo $credit_note['tax_type']; ?></td>
                                                                        <td><?php echo number_format($credit_note['tax'],2,'.',''); ?></td>
                                                                        <td><?php echo number_format($credit_note['total'],2,'.',''); ?></td>
                                                                        <td><?php echo date("d/M/Y", strtotime(str_replace("/", "-", $credit_note['date']))); ?></td>
                                                                         
                                                                        <td><?php echo date("d/M/Y", strtotime($credit_note['created_date'])); ?></td>
                                                                        <td>
                                                                            <?php if ($credit_note['status'] == "Pending") { 
                                                                            ?><span id="<?php echo $credit_note["id"];?>" class="label label-danger"><?php echo $credit_note['status'];?></span>
                                                                            <?php } if ($credit_note['status'] == "Approved") { 
                                                                            ?><span id="<?php echo $credit_note["id"];?>" class="label label-info"><?php echo $credit_note['status'];?></span>
                                                                            <?php } if ($credit_note['status'] == "Allocated") { 
                                                                            ?><span id="<?php echo $credit_note["id"];?>" class="label label-success"><?php echo $credit_note['status'];?></span>
                                                                            <?php } ?>
                                                                       
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php if(in_array(37, $this->session->userdata("permissions")) || in_array(39, $this->session->userdata("permissions"))) {?>
                                                                                    <a href="<?php echo SURL;?>sales_credits_notes/viewsalescreditnote/<?php echo $credit_note["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                            </div>
                                            <div class="tab-pane" id="completedSalesCreditsNotes">
                                                 <div class="loader">
                                                    <center>
                                                        <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                                    </center>
                                                </div>
                                                <div class="completed_sales_credits_notes">
                                            	 <table id="completedJobsSalesCreditsNotes" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Sales Credit #</th>
                                                                        <th>Project Name</th>
                                                                        <th>Reference</th>
                                                                        <th>Subtotal</th>
                                                                        <th>Tax Type</th>
                                                                        <th>Tax</th>
                                                                        <th>Total</th>
                                                                        <th>Date</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
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
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->