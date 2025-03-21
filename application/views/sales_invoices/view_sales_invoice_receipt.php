                <form id="SalesReceiptForm" method="post" action="<?= SURL.'sales_invoices/viewsalesreceipt/' ?>">   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">receipt</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">View All Sales Receipts</h4>
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
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Project <small>*</small></label>
                                                    <div class="col-md-8"><?php echo $project_title;?></div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Sale Invoice Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <?php if($invoice_detail["invoice_number"]==0){ echo $invoice_detail["id"]+1000000; } else{ echo $invoice_detail["id"]+2000000; }?>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Invoice Status <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <?php 
                                                        echo '<span class="';
                        
                                                        if ($invoice_detail["status"] == "PENDING") 
                                                            echo 'label label-danger';
                                                        else if ($invoice_detail["status"] == "APPROVED")
                                                            echo 'label label-info';
                                                        else if ($invoice_detail["status"] == "INVOICED")  
                                                            echo 'label label-primary';
                                                        else if ($invoice_detail["status"] == "PAID")
                                                            echo 'label label-success';
                                                        
                        
                                                        echo '">';
                                                        echo $invoice_detail["status"];
                                                        echo '</span>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Receipt Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <?php if(count($receipt_ids)){ ?>
                            <select name="receipt_id" id="receipt_id" class="selectpicker" data-style="select-with-transition" required="true" title="Select Receipt Number">
                                <?php foreach ( $receipt_ids as $key => $id) :?> 
                                <option value="<?=$receipt_ids[$key]['id']?>" > <?= $receipt_ids[$key]['id']?></option>
                                <?php endforeach;?>
                            </select>
                            <?php }  else{ ?>

                            No Receipts for this sales Invoice
                             <?php }  ?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                         
			
                                    </div>
                            </div>
                        </div>
        
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <input type="submit" value="View Selected Receipt" class="btn btn-warning">
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                

                