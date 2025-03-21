<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">file_present</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Manage CSV files</h4> 
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
                                                                        <th>File Number</th>
                                                                        <th>File Item Types</th>
                                                                        <th>CSV File Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						 <?php
                                                                        foreach ($csv_files as $csv_file) {  ?>
                                                                            <tr>
                                                                                <td><?= $csv_file['id'] ?></td>
                                                                                <td><?= ($csv_file['type']=='sale')? 'From Sale Invoices': 'From Sale Receipts' ?></td>
                                                                                
                                                                                <td>
                                                                                    <?php 
                                                                                    echo '<span class="label label-';
                                                
                                                                                    if ($csv_file['status'] == "PENDING") 
                                                                                        echo 'danger';
                                                                                   
                                                                                    else if ($csv_file['status'] == "EXPORTED")  
                                                                                        echo 'success';
                                                                                   
                                                                                    echo '">';
                                                                                    echo $csv_file['status'];
                                                                                    echo '</span>';
                                                                                    
                                                                                    ?>
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <a href="<?php echo SURL.'sales_invoices/viewcsv/'.$csv_file['id']?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                                    <a href="<?php echo SURL.'sales_invoices/exportascsv/'.$csv_file['id']?>" target="_blank" class="btn btn-simple btn-success btn-icon"><i class="material-icons">download</i></a>
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