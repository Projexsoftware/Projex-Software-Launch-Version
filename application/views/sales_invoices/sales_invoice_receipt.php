<form id="InvoiceReceiptForm" method="post" action="<?php echo ($sales_receipt_detail["status"]=='PENDING')?  SURL.'sales_invoices/receiptcomsinvoice/'.$sales_receipt_detail["id"] :   SURL . 'sales_invoices/receiptcomsinvoicestatus/'. $sales_receipt_detail["id"]  ?>">
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">file_present</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Receipt Sales Invoice</h4> 
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
                                                    <label class="col-md-4">Sale Receipt Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                       <?= $sales_receipt_detail["id"]?>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Sale Invoice Number <small>*</small></label>
                                                    <div class="col-md-8">
                                                       <?= $sales_receipt_detail["sale_invoice_id"] + 1000000 ?>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="col-md-4">Receipt Status <small>*</small></label>
                                                    <div class="col-md-8">
                                                         <?php 
                                                            echo '<span class="';
                                                            if ($sales_receipt_detail["status"] == "PENDING") 
                                                                echo 'label label-danger';
                                                            else if ($sales_receipt_detail["status"] == "APPROVED")
                                                                echo 'label label-info';
                                                            else if ($sales_receipt_detail["status"] == "EXPORTED")  
                                                                echo 'label label-success';
                                                            echo '">';
                                                            echo $sales_receipt_detail["status"];
                                                            echo '</span>';
                                                        ?>
                                                    </div>
                                                </div>
                                        </div>
                                        <?php $subtotal=0; ?>    
                <div id="populatetables" >

                        <span id="allowancetableheading">Allowance Part difference</span>
                    
                    <table id="allowancetable" class="table table-bordered table-striped table-hover nfnstable">

                        <thead>
                            <tr>
                                <th>Receipt Item Number</th>
                                <th>Invoice Item Number</th>
                                <th>Description</th>
                                <th>Part Invoice amount</th>
                                <th>Invoice Part Total Payment</th>
                                <th>Receipt Payment</th>
                                <th>Subtotal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                            foreach ($sales_receipts_items as $key => $sales_receipts_item) { 
                                if( $sales_receipts_item["sales_invoices_item"]["type"]!='apd')
                                    continue;
                                else
                                    $apdsii= $sales_receipts_item["sales_invoices_item"];

                              ?>        
                                <tr id="apd<?= $sales_receipts_item["id"]; ?>" >
                                        <td><?= $sales_receipts_item["id"]; ?>
                                            <input type="hidden" name="receipt_item_number" value="<?= $sales_receipts_item["id"]; ?>" />
                                        </td>
                                        <td><?= $apdsii["id"]; ?></td>
                                        <td><?= 'Allowance Part difference for (Part name: ' . $apdsii["part_name"] . ' ) against  (Component: ' . $apdsii["description"] . ')';?></td>
                                        <td class="text-right" >$ <?= number_format(($apdsii["part_invoice_amount"])+($apdsii["part_invoice_amount"]*($tax/100)),2);?> </td>
                                        <td class="text-right" >$ <?= number_format($apdsii["payment"],2) ?></td>
                                        <td class="text-right" >$ <span class="subtotal"><?= number_format($sales_receipts_item["payment"],2); $subtotal+=$sales_receipts_item["payment"]; ?></span></td>
                                        <td class="text-right" >$ <?= number_format($subtotal,2)?></td>
                                        <td>
                                            <?php if ($sales_receipt_detail["status"] == "PENDING"): ?>
                                            <a href="javascript:void(0)" rno="<?= $sales_receipts_item["id"]; ?>" itype="apd"  class="btn btn-simple btn-danger btn-icon deletereceiptrow"><i class="material-icons">delete</i></a>
                                            <?php endif; ?>
                                        </td>
                                </tr>
                                
                            <?php } ?> 
                        </tbody>
                    </table>
                    <br/><br/>
                    <div class="clearfix"></div>
                    <table id="variationtable" class="table table-bordered table-striped table-hover nfnstable">
                        <thead>
                            <tr >
                                <span id="variationtableheading"> Variations Amount inclusive GST, PM, OHM</span>
                            </tr>
                            <tr>
                                <th>Receipt Item Number</th>
                                <th>Invoice Item Number</th>
                                <th>Variation number</th>
                                <th>Description</th>
                                <th>Part Invoice amount</th>
                                <th>Invoice Part Total Payment</th>
                                <th>Receipt Payment</th>
                                <th>Subtotal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                            foreach ($sales_receipts_items as $key => $sales_receipts_item) { 
                                if( $sales_receipts_item["sales_invoices_item"]["type"]!='var')
                                    continue;
                                else
                                    $varsii=$sales_receipts_item["sales_invoices_item"];

                              ?>        
                                <tr id="var<?= $sales_receipts_item["id"]; ?>" >
                                        <td><?= $sales_receipts_item["id"]; ?>
                                            <input type="hidden" name="receipt_item_number" value="<?= $sales_receipts_item["id"]; ?>" />
                                        </td>
                                        <td><?= $varsii["id"]; ?></td>
                                        <td><?= $varsii["type_id"]+1000000; ?></td>
                                        <td><?=  $varsii["description"] ?></td>
                                        <td class="text-right" >$ <?= $varsii["part_invoice_amount"];?> </td>
                                        <td class="text-right" >$ <?= number_format($varsii["payment"],2) ?></td>
                                        <td class="text-right" >$ <?= number_format($sales_receipts_item["payment"],2); $subtotal+=$sales_receipts_item["payment"]; ?>
                                        <td class="text-right" >$ <?= number_format($subtotal,2)?></td>
                                        <td>
                                            <?php if ($sales_receipt_detail["status"] == "PENDING"): ?>
                                            <a href="javascript:void(0)" rno="<?= $sales_receipts_item["id"]; ?>" itype="var"  class="btn btn-simple btn-danger btn-icon deletereceiptrow"><i class="material-icons">delete</i></a>
                                            <?php endif; ?>
                                        </td>
                                </tr>
                                
                            <?php } ?> 
                        </tbody>
                    </table>
                    <hr>
                    <table id="paymenttable" class="table table-bordered table-striped table-hover nfnstable">
                       
                        <thead>
                            <tr >
                                <span id="paymenttableheading"> Customized Payments</span>
                            </tr>
                            <tr>
                                <th>Receipt Item Number</th>
                                <th>Invoice Item Number</th>
                                <th>Payments Number</th>
                                <th>Payment Description</th>
                                <th>Part Invoice amount</th>
                                <th>Invoice Part Total Payment</th>
                                <th>Receipt Payment</th>
                                <th>Subtotal</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        
                        <tbody >
                            <?php
                            foreach ($sales_receipts_items as $key => $sales_receipts_item) { 
                                if( $sales_receipts_item["sales_invoices_item"]["type"]!='pay')
                                    continue;
                                else
                                    $paysii=$sales_receipts_item["sales_invoices_item"];

                              ?>        
                                <tr id="pay<?= $sales_receipts_item["id"]; ?>" >
                                        <td><?= $sales_receipts_item["id"]; ?>
                                            <input type="hidden" name="receipt_item_number" value="<?= $sales_receipts_item["id"]; ?>" />
                                        </td>
                                        <td><?= $paysii["id"]; ?></td>
                                        <td><?= $paysii["type_id"] ?></td>
                                        <td><?=  $paysii["description"] ?></td>
                                        <td class="text-right" >$ <?= $paysii["part_invoice_amount"];?> </td>
                                        <td class="text-right" >$ <?= number_format($paysii["payment"], 2) ?></td>
                                        <td class="text-right" >$ <?= number_format($sales_receipts_item["payment"], 2); $subtotal+=$sales_receipts_item["payment"]; ?>
                                        <td class="text-right" >$ <?= number_format($subtotal,2)?></td>
                                        <td>
                                            <?php if ($sales_receipt_detail["status"] == "PENDING"): ?>
                                            <a href="javascript:void(0)" rno="<?= $sales_receipts_item["id"]; ?>" itype="pay"  class="btn btn-simple btn-danger btn-icon deletereceiptrow"><i class="material-icons">delete</i></a>
                                            <?php endif; ?>
                                        </td>
                                </tr>
                                
                            <?php } ?> 
                                
                            
                        </tbody>
                        
                    </table>
                    
                </div>
                 <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Invoice Status <small>*</small></label>
                                                    <div class="col-md-8">
                                                       <select class="selectpicker " data-style="select-with-transition" name="status" id="receiptstatus" required>
                                                        <option <?= ($sales_receipt_detail["status"]!='PENDING')? 'disabled':'' ?> <?= ($sales_receipt_detail["status"] =='PENDING')? 'selected':'' ?> value="PENDING">PENDING</option>
                                                        <option  <?= ($sales_receipt_detail["status"]=='APPROVED')? 'selected':'' ?> value="APPROVED">APPROVED</option>
                                                        <option <?= ($sales_receipt_detail["status"]=='EXPORTED')? 'selected':'' ?> value="EXPORTED">EXPORTED</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating col-md-12">
                                                    <label class="col-md-4">Receipt Total <small>*</small></label>
                                                    <div class="col-md-8">
                                                       <div class="input-group">
                                                          <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">$</span>
                                                          </div>
                                                          <input class="form-control" name="receipt_total_amount" id="receipt_total_amount" value="<?=number_format($subtotal,2)?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-content">
                                                     <div class="form-footer">
                                                         <div class="pull-left">
                                                            <button type="submit" class="btn btn-success btn-fill">
                                                                Update Receipt<?= ($sales_receipt_detail[0]->status!='PENDING')?' Status':'' ?>
                                                            </button>
                                                         </div>
                                                         <div class="pull-right">
                                                            
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