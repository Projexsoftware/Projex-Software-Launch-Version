                <form id="SalesInvoiceForm" method="POST" action="<?php echo SURL ?>sales_invoices/updatesalesinvoice" autocomplete="off">
                    <input  type="hidden" class="form-control readonlyme"  name="project_id" value="<?= $project_id; ?>" readonly >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">summarize</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Update Items in Sales Invoice</h4>
				                    	<div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Project <small>*</small></label>
                                                    <div class="col-md-8"><?php echo $project_title;?></div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Sale Invoice Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <input type="hidden" class="form-control readonlyme" type="text"  name="id" value="<?= (isset($id)) ? $id : 0; ?>" readonly>
                                                        <input class="form-control" type="text" name="invoice_number" value="<?= (isset($id)) ? $id + 1000000 : '0000000'; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Sale Invoice Item Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                       <input class="form-control" type="text"  name="invoice_item_number" value="<?= (isset($sale_invoice_item_id)) ? $sale_invoice_item_id  : '0000000'; ?>" readonly>
                                                    </div>
                                                </div>
                                                <?php if($type=='var'): ?>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Variation Number <small>*</small></label>
                                                    <div class="col-md-8"><input class="form-control" type="text"  name="var_num" value="<?= $type_id+1000000 ?>" readonly></div>
                                                </div>
                                                <?php endif; ?> 
                                                <?php if($type=='pay'): ?>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Payment Number <small>*</small></label>
                                                    <div class="col-md-8"><input class="form-control" type="text"  name="pay_num" value="<?php echo $type_id;?>" readonly></div>
                                                </div>
                                                <?php endif; ?>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Description <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  name="descriptiondes" value="<?php
                                                        if ($type == 'apd')
                                                            echo 'Allowance Part difference for (Part name: ' . $partname . ' ) against  (Component: ' . $description . ')';
                                                        else if ($type=='var' ||  $type=='pay' )
                                                            echo $description;
                                                        ?>" readonly >
                                                        <input  type="hidden" class="form-control" type="text"  name="description" value="<?= $description; ?>" readonly >
                                                        <?php  if ($type == 'apd'){ ?>
                                                        <input  type="hidden" class="form-control" type="text"  name="part_name" value="<?= $partname; ?>" readonly >
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Type <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text"  name="typedes" value="<?php
                                                        if ($type == 'apd')
                                                            echo 'Allowance Part difference';
                                                        else if ($type == 'var')
                                                            echo 'Variation Amount inclusive GST, PM, OHM';
                                                        else if ($type == 'pay')
                                                            echo 'Customized Payment';
                                                        ?>" readonly >
                                                        <input  type="hidden" class="form-control"  name="type" value="<?= $type; ?>" readonly>
                                                        <input  type="hidden" class="form-control"  name="type_id" value="<?= $type_id; ?>" readonly>
                                                        <input  type="hidden" class="form-control"  name="project_id" value="<?= $project_id; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Part Invoice Amount <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                          <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">$</span>
                                                          </div>
                                                          <input class="form-control" type="text"  name="invoice_amount1" value="<?= number_format($invoice_amount,2) ?>" readonly>
                                                        </div>
                                                       <input class="form-control" type="hidden"  name="invoice_amount" value="<?= $invoice_amount ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Invoice Payment <small>*</small></label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                          <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2">$</span>
                                                          </div>
                                                          <input class="form-control" type="text"  name="payment" value="<?= $payment; ?>" readonly >
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                            <button type="submit" class="btn btn-success btn-fill">Update Sales Invoice</button>
                                         </div>
                                         <div class="pull-right">
                                            <a href="javascript:void(0)" class="btn btn-warning btn-fill closeBtn">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                