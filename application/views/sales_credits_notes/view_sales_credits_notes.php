          <script>
              var invoiceamountist =<?php echo $sinvoice_detail ->invoice_amount ?>;
          </script>
               <form id="SalesCreditsNotesForm" method="POST" action="<?php echo SURL.'sales_invoices/updatecreditnote/'.$credit_note_detail->id;?>" onsubmit="return validateForm()" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">receipt</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">View and Update Sales Credits Note</h4>
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
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Project Title <small>*</small></label>
                                                    <?php echo $projectinfo['project_title']; ?>
                                                    <input class="form-control" name="project_id" id="project_id" type="hidden" value='<?php echo $credit_note_detail->project_id ?>' required>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        &nbsp;
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                 <div class="form-group label-floating col-md-4">
                                                    <label>Date <small>*</small></label>
                                                    <?php if($credit_note_detail->status=="Pending"){?>
                                                    <input class="form-control datepicker" name="date" id="date" placeholder="" type="text" required autocomplete="off" value="<?php echo date("d-m-Y", strtotime(str_replace("/", "-", $credit_note_detail->date)));?>">
                                                    <?php } else{ ?>
                                                    <?php echo $credit_note_detail->date; ?>
                                                    <input class="form-control datepicker" name="date" id="date" placeholder="" type="hidden" autocomplete="off" value="<?php echo date("d-m-Y", strtotime(str_replace("/", "-", $credit_note_detail->date)));?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group label-floating col-md-4">
                                                    <label>Reference <small>*</small></label>
                                                    <?php if($credit_note_detail->status=="Pending"){?>
                                                     <input class="form-control" name="reference" id="reference" placeholder="" type="text" value="<?php echo $credit_note_detail->reference;?>" required>
                                                    <?php } else{ ?>
                                                    <?php echo $credit_note_detail->reference; ?>
                                                    <input class="form-control" name="reference" id="reference" placeholder="" type="hidden" value="<?php echo $credit_note_detail->reference;?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group label-floating col-md-4">
                                                        <label>Total <small>*</small></label>
                                                        <?php if($credit_note_detail->status=="Pending"){?>
                                                        <input class="form-control" name="total_credit" id="total_credit" value=" <?php echo $credit_note_detail->totalamountentered; ?>" type="text" required>
                                                        <?php } else{ ?>
                                                        <input class="form-control" name="total_credit" id="total_credit" value=" <?php echo $credit_note_detail->totalamountentered; ?>" type="hidden">
                                                        <?php echo $credit_note_detail->totalamountentered; ?>
                                                        <?php } ?>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                 <div class="form-group label-floating col-md-4">
                                                    <h6>Currency <b>New Zealand Dollar</b></h6>
                                                </div>
                                                <div class="form-group label-floating col-md-4">
                                                    &nbsp;
                                                </div>
                                                <div class="form-group label-floating col-md-4">
                                                         <?php if($credit_note_detail->status=="Pending"){?>
                                                         <label class="control-label col-lg-4 col-md-4 col-sm-12">Amounts are</label>
                                                         <select id="tax_type" name="tax_type" class="selectpicker" data-style="select-with-transition" onchange="calculate();">
                                                            <option <?php if($credit_note_detail->tax_type=="Exclusive"){ ?> selected <?php } ?> value="Exclusive">Tax Exclusive</option>
                                                            <option <?php if($credit_note_detail->tax_type=="Inclusive"){ ?> selected <?php } ?> value="Inclusive">Tax Inclusive</option>
                                                            <option <?php if($credit_note_detail->tax_type=="No Tax"){ ?> selected <?php } ?> value="No Tax">No Tax</option>
                                                        </select>
                                                        <?php } else{ 
                                                        if($credit_note_detail->tax_type=="Exclusive" || $credit_note_detail->tax_type=="Inclusive"){
                                                        ?>
                                                        <h5><?php echo "Amounts are Tax ".$credit_note_detail->tax_type; ?></h5>
                                                        <?php }
                                                        
                                                        else{
                                                        ?>
                                                        <h5><?php echo "Amounts are ".$credit_note_detail->tax_type; ?></h5>
                                                       
                                                        <?php } 
                                                        ?>
                                                         <input type="hidden" name="tax_type" id="tax_type" value="<?php echo $credit_note_detail->tax_type;?>">
                                                        <?php
                                                        } ?>
                                                </div>
                                        </div>
                                    </div>
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                         
                                        <?php  $amount_total_entered=0; ?>
                                        <div id="newcdiv">
                                             <div class="form-group label-floating">
                                           <div class="table-responsive">
                                                 <table id="impcos1" class="table sortable_table templates_table">
                                                   <thead>
                                                       <tr>
                                                        <th>Part</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Cost</th>
                                                        <th>Tax Rate</th>
                                                        <th>Amount</th>
                                                        <?php if($credit_note_detail->status=="Pending"){ ?> <th>Action</th> <?php } ?>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                   <?php 
                                                   $count = 1;
                                                   if(count($credit_note_items)){
                                                   foreach($credit_note_items as $credit_note_item ){ ?>
                                                        <tr id="nitrnumber<?php echo $count; ?>" tr_val="<?php echo $count; ?>">
                                                            <input type="hidden" name="nicosting_part_id[]" value="<?php echo $credit_note_item['costing_part_id'] ?>"/>
                                                            <input type="hidden" name="<?php echo 'nicn_item_id[]' ?>" value="<?php echo $credit_note_item['id'] ?>">
                
                                                            <td><input type="hidden" name="nipart[]" id="nipartfield<?php echo $count; ?>" value="<?php echo $credit_note_item['part']; ?>" rno ='<?php echo $count; ?>' class="form-control" /><?php echo $credit_note_item['part']; ?></td>
                                                           
                                                           
                                                         
                                                             <td><input  name="nimanualqty[]" rno ="<?php echo $count; ?>" id="nimanualqty<?php echo $count; ?>" type="hidden"  class="qty form-control" value="<?php echo $credit_note_item['quantity'] ?>" onchange="calculateInvoiceAmount(<?php echo $count; ?>);"/><?php echo $credit_note_item['quantity'] ?></td>
                                                             
                                                            <td><input type="hidden" name="niucost[]" id="niucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="<?php echo number_format($credit_note_item['unit_cost'], 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo number_format($credit_note_item['unit_cost'], 2, '.', ''); ?></td>
                                                           <td><span class="tax_type"><?php if($credit_note_detail->tax_type=="Exclusive" || $credit_note_detail->tax_type=="Inclusive"){ ?> Tax on Purchases (15%)<?php } else{ ?>No Tax<?php } ?></span></td>
                                                            <td><input type="hidden" name="nilinttotal[]"  rno ="<?php echo $count; ?>" id="nilinetotalfield<?php echo $count; ?>" class="form-control invoicebudget invoicebudget1 res_count" value="<?php echo number_format($credit_note_item['amount'], 2, '.', ''); ?>" /><?php echo number_format($credit_note_item['amount'], 2, '.', ''); ?></td>
                                                           
                                                           <?php if($credit_note_detail->status=="Pending"){ ?> <td>
                                                                <a href="javascript:void(0)" rno="<?php echo $count; ?>" class="deleterow"><i class="fa fa-times-circle-o fa-lg"></i></a>
                                                            </td><?php } ?>
                
                                                        </tr>
                                                    <?php $count++; } } ?>
                                                   </tbody>
                                                   </table>
                                           </div>
                                        </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                   <?php if($credit_note_detail->status=="Pending"){?><div class="col-lg-8 col-md-8 col-sm-8"><a class="btn btn-primary" style="cursor:pointer;" onclick="addMore();">Add a new line</a></div><?php } ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 pull-right">
                                <table style="width:100%;">
                                    <tr style="line-height: 30px;">
                                        <td style="text-align:right;"><label>Subtotal</label></td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:right;"><span class="subtotal"> <?php echo $credit_note_detail->subtotal; ?></span>
                                        <input type="hidden" name="subtotal" id="subtotal" value=" <?php echo $credit_note_detail->subtotal; ?>">
                                        </td>
                                    </tr>
                                    <tr <?php if($credit_note_detail->tax_type=="No Tax"){ ?> style="display:none;line-height:30px;" <?php } else{ ?> style="line-height: 30px;" <?php } ?> class="tax_container">
                                        <td style="text-align:right;"><label class="tax_rate"><?php if($credit_note_detail->tax_type=="Exclusive"){ ?>Total Tax 15.00%<?php } else if($credit_note_detail->tax_type=="Inclusive"){ ?>Inclusive Tax 15.00%<?php } else{ ?>No Tax<?php } ?></label></td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:right;"><span class="total_tax"> <?php echo $credit_note_detail->tax; ?></span>
                                        <input type="hidden" name="total_tax" id="total_tax" value="<?php echo $credit_note_detail->tax; ?>">
                                        </td>
                                    </tr>
                                    <tr style="border-top: 1px solid;border-bottom: 1px solid #ccc;line-height: 30px;">
                                        <td style="text-align:right;"><label><h4><b>Total Credit</b></h4></label></td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:right;"><h4 style="margin-top:0px;"><b><span class="total"><?php echo $credit_note_detail->total; ?></span></b></h4><input type="hidden" name="total" id="total" value="<?php echo $credit_note_detail->total; ?>"></td>
                                    </tr>
                                    <?php
                                    if($credit_note_detail->status=="Allocated"){
                                        
                                       $sales_info = get_sales_info($credit_note_detail->allocated_invoice_id);
                                       
                                    ?>
                                    <tr style="border-bottom: 1px solid;line-height: 30px;">
                                        <td style="text-align:right;"><label><h4 style="color:#ccc;"><b>Credit Allocated to Invoice <a target="_Blank" href="<?php echo SURL."sales_invoices/viewsalesinvoice/".$credit_note_detail->allocated_invoice_id;?>" style="color:#3af;"><?php echo $sales_info['id']+1000000;?></a><br/><span style="color:#777777;"><?php echo date("d F Y", strtotime(str_replace("/", "-", $credit_note_detail->date)));?></span></b></h4></label></td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:right;vertical-align:top"><h4 class="total_heading"><b><span class="total"><?php echo $credit_note_detail->total; ?></span></b></h4></td>
                                    </tr>  
                                    <tr style="border-bottom: 1px solid;line-height: 30px;">
                                        <td style="text-align:right;"><label><h3><b>Remaining Credit</b></h3></label></td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:right;"><h3 class="total_heading"><b><span class="total"><?php echo "0.00"; ?></span></b></h3></td>
                                    </tr>
                                   <?php }
                                    ?>
                                </table>
                            </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <input type="hidden" id="outstanding_amount" name="outstanding_amount" value="">
                                    <select class="selectpicker pull-right allocate_container" data-style="select-with-transition" id="sales_invoice_id" name="sales_invoice_id" style="width:250px;display:none;" onchange="checkOutstandingAmount(this.value);">
                                        <option value="">Select Sales Invoice</option>
                                        <?php 
                                        foreach($sales_invoices as $val){
                                            $amount_due = $val->invoice_amount;
                                            $credit_notes = get_sales_credit_notes($val->id);
                                            
                                            foreach($credit_notes as $credit_note){
                                            $amount_due = $amount_due-$credit_note['total'];
                                            }
                                         if($amount_due>0){   
                                            ?>
                                            <option value="<?php echo $val->id;?>"><?php echo $val->id+(1000000)." (".$amount_due.")";?></option>
                                            <?php } }?>
                                    </select>
                                    <label class="control-label allocate_container pull-right" style="margin-left:25px;margin-right:25px;display:none;">Allocate to Sales Invoice</label>
                                    <select class="selectpicker pull-right" data-style="select-with-transition" id="status" name="status" required style="width:150px;margin-left:25px;" onchange="checkStatus(this.value);">
                                        <option value="">Select Status</option>
                                        <option value="Pending" <?php if($credit_note_detail->status=="Pending"){ ?> selected <?php } if($credit_note_detail->status=="Approved" || $credit_note_detail->status=="Allocated"){ ?> disabled <?php } ?> >Pending</option>
                                        <?php if(in_array(40, $this->session->userdata("permissions"))) { ?> 
                                        <option value="Approved" <?php if($credit_note_detail->status=="Approved"){ ?> selected <?php } if($credit_note_detail->status=="Allocated"){ ?> disabled <?php } ?>>Approved</option>
                                        <?php } ?>
                                        <option <?php if($credit_note_detail->status=="Allocated"){ ?> selected <?php } ?> value="Allocated" <?php if($credit_note_detail->status=="Approved"){ } else{ ?> disabled <?php } ?> >Allocated</option>
                                    </select>
                                    
                                     <div class="form-footer">
                                    <div class="pull-left"><?php if($credit_note_detail->status=="Pending" || $credit_note_detail->status=="Approved"){ ?><input id="update_btn" type="submit" class="btn btn-primary" value="Update"/><?php } ?></div>
                                    <div class="pull-right">
                                    <a class="btn btn-danger pull-right" style="margin-left:25px;" href="<?php echo SURL;?>sales_credits_notes"> Cancel</a>
                                    
                                    </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                