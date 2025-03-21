<form id="InvoiceReceiptForm" method="post" action="<?php echo base_url() . 'sales_invoices/receiptinvoice' ; ?>" onsubmit="return validateform();">
    <input class="form-control" type="hidden"  name="work" value="<?= $work; ?>" readonly >
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">file_present</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?= ($work=="C")? 'Create ': 'Update' ;?> Sales Receipt</h4> 
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
									    <?php if($work!='U'){ ?>
                                            <div class="form-group">
                                                <div  class="col-md-2">
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                        <label>
                                                          <input type="checkbox"  class="form-control" style="position: relative" id="creatnewreceipt" name="creatnewreceipt" value="<?=(count($receipt_ids))?0:1?>" <?=(count($receipt_ids))?'':'checked'?> onchange="checkcreatnewreceipt(this.id)" >Creat New Sales Receipt
                                                        </label>
                                                    </div>
                        
                                                    <?php if(count($receipt_ids)): ?>
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"  class="form-control" id="addtoexisting" name="addtoexisting" onchange="addtoexistingf(this.id)"  value="<?=(count($receipt_ids))?1:0?>" <?=(count($receipt_ids))?'checked':''?> />Add to existing Sales Receipt
                                                        </label>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                            <?php } ?>
                                            <?php if(count($receipt_ids)): ?>
                        
                                                <div class="form-group row">    
                                                    <label class="col-lg-2 control-label">Receipt Number: </label>
                                                    <div class="col-lg-10">
                                                        <select name="receipt_id" id="receipt_id" class="selectpicket" data-style="select-with-transition">
                                                            <option value="0">Creat New Receipt</option>
                                                            <?php foreach ( $receipt_ids as $key => $id) :?> 
                                                            <option value="<?=$receipt_ids[$key]['id']?>" <?=($key==0)?'selected':''?>> <?= $receipt_ids[$key]['id']?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                        
                                            <?php endif; ?>

									</div>
									<div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Sales Invoice Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                       <input class="form-control" type="text"  name="invoice_number" value="<?= (isset($sale_invoice_id)) ? $sale_invoice_id + 1000000 : '0000000'; ?>" readonly>
                                                       <input class="form-control" type="hidden"  name="sale_invoice_id" value="<?= (isset($sale_invoice_id)) ? $sale_invoice_id : '0'; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Sale Invoice Item Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                       <input class="form-control" type="text"  name="sale_invoice_item_id" value="<?= (isset($sale_invoice_item_id)) ? $sale_invoice_item_id  : '0'; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Item Part Invoice Amount <small>*</small></label>
                                                    <div class="col-md-8">
                                                         <input class="form-control" type="text"  name="part_invoice_amount" value="<?= (isset($invoice_amount)) ? number_format($invoice_amount+($invoice_amount*($tax/100)),2,'.','')  : '0'; ?>" readonly>
                                                         <?php $invoice_amount_tax = number_format($invoice_amount+($invoice_amount*($tax/100)),2, '.','');?>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Paid <small>*</small></label>
                                                    <div class="col-md-8">
                                                         <input class="form-control" type="text"  name="already_paid" id="already_paid" value="<?= (isset($payment)) ? $payment  : '0'; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Outstanding <small>*</small></label>
                                                    <div class="col-md-8">
                                                         <input class="form-control" type="text"  name="outstanding" id="outstanding" value="<?= (isset($payment) &&  isset($invoice_amount) ) ? number_format($invoice_amount_tax-$payment,2,'.','' ) : '0.00'; ?>" readonly>
                    
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Current Receipt item Amount <small>*</small></label>
                                                    <div class="col-md-8">
                                                         <input class="form-control" type="text" name="receipt_payment" id="receipt_payment" value="0.00" required="true">
                                                    </div>
                                                </div>
                                        </div>
                                              <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-content">
                                                     <div class="form-footer">
                                                         <div class="pull-left">
                                                            <button type="submit" class="btn btn-success btn-fill"><?php        
                        if($work=='C'){
                            echo   'Receipt Sales Invoice';  
                        }
                        else if($work=='U'){
                           echo   'Update Sales Receipt';  
                        }      
                        
                               
                        ?></button>
                                                         </div>
                                                         <div class="pull-right">
                                                            <a href="javascript:void(0)" class="btn btn-warning btn-fill closeBtn">Close</a>
                                                      </div>
                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                            </div>
                                    	</div>
                                    </div>
                                </div>
</form>
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