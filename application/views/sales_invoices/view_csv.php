<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">file_present</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">View CSV file</h4> 
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
									<div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">File Number <small>*</small></label>
                                                    <div class="col-md-8"><?= $file_detail["id"] ?></div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">File Type <small>*</small></label>
                                                    <div class="col-md-8">
                                                        From Sale Invoices
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">File Status <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <?php 
                                                        echo '<span class="';
                        
                                                        if ($file_detail["status"] == "PENDING") 
                                                            echo 'label label-danger';
                                                       
                                                        else if ($file_detail["status"]== "EXPORTED")
                                                            echo 'label label-success';
                                                        
                        
                                                        echo '">';
                                                        echo $file_detail["status"];
                                                        echo '</span>';
                        
                                                    ?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                                 <div class="loader">
                                                    <center>
                                                        <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                                    </center>
                                                </div>
                                            	 <table class="table table-striped table-no-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>File Item ID</th>
                                                                        <th>Invoice Number</th>
                                                                        <th>Reference Number</th>
                                                                        <th>Inventory Item Code / Sale Invoice Item Number</th>
                                                                        <th>Due Date (m/d/Y)</th>
                                                                        <th>Invoice Date (m/d/Y)</th>
                                                                        <th>Description</th>
                                                                        <th>Unit Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						 <?php 
                                                                        foreach ($file_items as $file_item) {  ?>        
                                                                            <tr id="fli<?= $file_item['id']; ?>" >
                                                                                    <td><?= $file_item['id']; ?>
                                                                                        <input type="hidden" name="item_number[]" value="<?= $file_item['id']; ?>" />
                                                                                    </td>
                                                                                    <td><?= $file_item['InvoiceNumber']+10000000; ?></td>
                                                                                    <td><?= $file_item['InvoiceNumber']+10000000; ?></td>
                                                                                    <td><?= $file_item['InventoryItemCode']; ?></td>
                                                                                    <td><?php if($file_item['DueDate']!="0000-00-00"){ echo date('m/d/Y',strtotime($file_item['DueDate']));} ?></td>
                                                                                    <td><?= date('m/d/Y',strtotime($file_item['InvoiceDate'])); ?></td>
                                                                                    <td><?= $file_item['Description']; ?></td>
                                                                                    <td class="text-right">$ <?= $file_item['UnitAmount']; ?></td>
                                                                                    
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