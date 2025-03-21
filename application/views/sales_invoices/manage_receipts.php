<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">file_present</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Manage Sales Receipts</h4> 
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
                                                 <div class="loader">
                                                    <center>
                                                        <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                                    </center>
                                                </div>
                                            	 <table id="completedJobsSalesInvoices" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Project</th>
                                                                        <th>Receipt Number</th>
                                                                        <th>Receipt Total Amount</th>
                                                                        <th>Sales Invoice Number</th>
                                                                        <th>Receipt Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                        foreach ($sales_receipts as $p => $po) {  ?>
                            <tr>
                                <td><?= $po['project_title'] ?></td>
                                <td><?= $po['id'] ?></td>
                                <td class="text-right">$ <?= $po['payment'] ?></td>
                                <td ><?= $po['sale_invoice_id']+1000000 ?></td>
                                <td>
                                    <?php 
                                    echo '<span class="label label-';

                                    if ($po['status'] == "PENDING") 
                                        echo 'danger';
                                    else if ($po['status'] == "APPROVED")
                                        echo 'info';
                                    else if ($po['status'] == "EXPORTED")  
                                        echo 'success';
                                   
                                    echo '">';
                                    echo $po['status'];
                                    echo '</span>';
                                    
                                    ?>
                                </td>
                                <td class="text-right">
                                    <a href="<?php echo SURL.'sales_invoices/viewsalesreceipt/'.$po['id'] ?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material_icons">edit</i></a>
                                  
                                </td>
                            </tr>
                        
                        <?php } ?>
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