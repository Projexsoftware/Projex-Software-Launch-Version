          <script>
              var invoiceamountist =<?php echo $sinvoice_detail ->invoice_amount ?>;
          </script>
          <style>
              .templates_table .form-control{
                  background-image: none;
                  border:1px solid #ccc!important;
                  padding:5px;
                  margin-top:12px;
              }
             .form-group.is-focused .templates_table .form-control{
                  background-image: none!important;
              }
              .part-form-control{
                  width:200px;
              }
              .uom-form-control, .uc-form-control{
                width:100px;
              }
              .no-padding{
                  padding:0px!important;
              }
              .btn-success{
                  margin-top: 0px;
              }
              p.text-danger{
                  margin-bottom:0px;
              }
          </style> 
               <div id='estimatewarning' class='alert alert-danger' style='display:none'>Warning: This project costing contains estimated costs.</div>
               <form id="SupplierCreditForm" method="POST" action="<?php echo ($sinvoice_detail->status=='Pending')?  base_url() . 'supplier_credits/updatecredit/'.$sinvoice_detail->id :   ''  ?>" onsubmit="return validateForm()" autocomplete="off">
                    <input type="hidden" name="first_selected_supplier" id="first_selected_supplier" value="<?php echo $sinvoice_detail->supplier_id;?>">
                    <input type="hidden" name="supplier_invoice_id" id="supplier_invoice_id" value="<?php echo $sinvoice_detail->id ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">receipt</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php if($sinvoice_detail->invoice_type=="timesheet"){
                                        ?><i class="material-icons">schedule</i> <?php } ?>View & Update Supplier Credit <?php if($sinvoice_detail->invoice_type=="timesheet"){?>
                                        <b>VIA</b> Timesheet<?php } ?></h4>
                                        <?php if($sinvoice_detail->status!='Pending') {?>
                                        <div class="toolbar">
                                           
                                        </div>
                                        <?php } ?>
                                        <?php if (count($error)) {
                                        foreach($error as $key => $errorval){?>
                                            <div class="alert alert-danger"> <strong>Error!</strong> <?php echo $errorval; ?> </div>
                                            <?php
                                        } }?>
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
                                        <div id='estimatewarning' class='alert alert-danger' style='display:none'>Warning: This project costing contains estimated costs.</div>
				                    	<div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Project Title <small>*</small></label>
                                                    <?php echo $projectinfo['project_title']; ?>
                                                    <input class="form-control" name="project_id" id="project_id" type="hidden" value='<?php echo $sinvoice_detail->project_id ?>' required>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        <label>Supplier <small>*</small></label>
                                                        <?php echo $sinvoice_detail->supplier_name; ?>
                                                         <input class="form-control" name="supplier_id" id="supplier_id" type="hidden" value='<?php echo $sinvoice_detail->supplier_id ?>' required  />
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Enter Credit Reference <small>*</small></label>
                                                    <input class="form-control" name="creditreference" id="creditreference" type="text"  value="<?php echo $sinvoice_detail->supplierrefrence?>" required>
                                                    <?php echo form_error('supplierrefrence', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        <label><?php if($sinvoice_detail->invoice_type=="timesheet"){?> Cost Subtotal <?php } else{ ?> Enter Credit Amount Excluding GST <?php } ?> <small>*</small></label>
                                                           <input class="form-control" name="creditamountist" id="creditamountist" type="text" value="<?php echo $sinvoice_detail->invoice_amount?>" required number="true" >
                                                           <?php echo form_error('creditamountist', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Enter Credit Date <small>*</small></label>
                                                    <input class="form-control datepicker" name="creditdate" id="creditdate" type="text" value="<?php if($sinvoice_detail->invoice_date!="0000-00-00"){echo  $sinvoice_detail->invoice_date; }?>" required autocomplete="off">
                                                    <?php echo form_error('creditdate', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        &nbsp;
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <?php if($sinvoice_detail->invoice_type=="timesheet"){ ?>
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Hours Worked <small>*</small></label>
                                                    <input class="form-control" name="worked_hours" id="worked_hours" readonly type="text" required value="<?php echo $sinvoice_detail->worked_hours;?>">
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        &nbsp;
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <?php } ?>
                                        
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                         <?php if( $sinvoice_detail->status=="Pending" && in_array(27, $this->session->userdata("permissions"))){ ?>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add New Items</button>
                                        </div>
                                        <?php } ?>
                                        <?php  $amount_total_entered=0; ?>
                                        <div id="newcdiv" style="<?php echo (count($sinvoice_items_ni))?  "":  "display:none";  ?>">
                                             <div class="form-group label-floating">
                                           <div class="table-responsive">
                                                 <table id="impcos1" class="table sortable_table templates_table">
                                                   <thead>
                                                       <tr><td colspan="12">Import new items not included project costing</td></tr>
                                                       <tr>
                                                           <td colspan="6"><span id="projecttitleimp"><?php echo $projectinfo['project_title']; ?></span></td>
                                                           <td colspan="6">Supplier Credits</td>
                                                       </tr>
                                                       <tr>
                                                         <th>Stage</th>
                                                        <th>Part</th>
                                                        <th>Component</th>
                                                        <th>Supplier</th>
                                                        <th>Unit Of Measure</th>
                                                        <th>Unit Cost</th>
                                                        <th>Quantity</th>
                                                        <th>Invoice Amount</th>
                                                        <th>Action</th>
                            
                                                    </tr>
                                                   </thead>
                                                   <tbody>
                                    <?php $count =  1; ?>
                                    <?php foreach($sinvoice_items_ni as $pts ){ ?>
                                        <tr id="nitrnumber<?php echo $count; ?>" tr_val="<?php echo $count; ?>">
                                            <input type="hidden" name="nicosting_part_id[]" value="<?php echo $pts['costing_part_id'];?>"/>
                                            <input type="hidden" name="<?php echo 'nisi_item_id[]' ?>" value="<?php echo $pts['id'] ?>">
                                            <input type="hidden" name="<?php echo 'nisrno[]' ?>" value="<?php echo $pts['srno'] ?>">


                                            <td>
                                                <select data-container="body" class="selectStage" data-style="btn btn-warning btn-round" title="Choose Stage" data-size="7" name="nistage[]" id="nistagefield<?php echo $count;?>" required="true">
                                                    <option value="<?php echo $pts["stage_id"];?>" selected><?php echo $pts["stage_name"];?></option>
                                                </select> 
                                            </td>

                                            <td><input type="text" name="nipart[]" id="nipartfield<?php echo $count; ?>" value="<?php echo $pts['part_field']; ?>" rno ='<?php echo $count; ?>' class="form-control" required="true"></td>
                                            <td>
                                                <select rno="<?php echo $count;?>" data-container="body" class="selectComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="nicomponent[]" id="nicomponentfield<?php echo $count; ?>" required="true" onchange="return componentval(<?php echo $count; ?>);">
                                                    <option value="<?php echo $pts["component_id"];?>" selected><?php echo $pts["component_name"];?></option>
                                                </select>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="nisupplier_name[]" id="nisupplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo get_supplier_name($pts['supplier_id']);?>" readonly>
                                                <input type="hidden" class="form-control" name="nisupplier_id[]" id="nisupplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $pts['supplier_id'];?>" readonly>
                                            </td>
                                            <td><input readonly type="text" name="niuom[]" id="niuomfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $pts['ni_uom'] ?>" class="form-control readonlyme" width="5" /></td>
                                            <td><input readonly type="text" name="niucost[]" id="niucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control readonlyme" value="<?php echo number_format($pts['ni_unit_cost'], 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/></td>
                                            <td><input  name="nimanualqty[]" rno ="<?php echo $count; ?>" id="nimanualqty<?php echo $count; ?>" type="number"  required="true" class="qty form-control" value="<?php echo $pts['quantity'] ?>" onchange="calculateInvoiceAmount(<?php echo $count; ?>);"/></td>
                                            <td><input type="text" name="nilinttotal[]"  rno ="<?php echo $count; ?>" id="nilinetotalfield<?php echo $count; ?>" class="form-control invoicebudget res_count" value="<?php echo number_format($pts['invoice_amount'], 2, '.', ''); ?>" /></td>
                                            <?php $amount_total_entered+= number_format($pts['invoice_amount'], 2, '.', ''); ?>
                                            <td>
                                                <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                            </td>

                                        </tr>
                                    <?php $count ++?>
                                    <?php } ?>
                                    </tbody>
                                                   </table>
                                           </div>
                                        </div>
                                        </div>
        
                                        <div id="pcdiv" >
                                        <?php $t_count= 0; $res_invoicecostd = array();?>
                                        <?php $i=1;?>
                                        <?php foreach($sinvoice_items_pc as $counterkey => $sinvoice_item_pc) :?>
                                        
                                            <?php $counter = $counterkey+1; $t_count ++;?>
                                            
                                            <?php if($i==1){ ?>
                                                <div class="table-responsive" >
                                                    <table id="tablepc" class="table table-no-bordered templates_table">
                                                        <thead>
                                                            <tr style="height : auto" >
                                                                <th colspan="9" style="height : auto"><?php echo $projectinfo['project_title'] ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Stage</th>
                                                                <th>Part</th>
                                                                <th>Component</th>
                                                                <th>Unit Of Measure</th>
                                                                <th>Unit Cost</th>
                                                                <th>Quantity</th>
                                                                <th>Invoice Amount</th>
                                                                <th>Supplier Credit Quantity</th>
                                                                <th>Supplier Credit Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php } ?>
                                        <?php $pts = $sinvoice_item_pc; 
                                        
                                         $supplier_ordered_quantity = get_supplier_ordered_quantity($sinvoice_item_pc['costing_part_id']);
                                         $purchase_ordered_quantity = get_purchase_ordered_items_quantity($sinvoice_item_pc['costing_part_id']);
                                            $ordered_quantity = get_ordered_quantity($sinvoice_item_pc['costing_part_id']);
                                        if($pts['transaction_type']=="po"){
                                                $invoicedquantity = get_supplier_ordered_quantity($sinvoice_item_pc['costing_part_id'], "po");
                                                $purchase_ordered_quantity = 0;
                                            }
                                        else{
                                         $invoicedquantity = get_supplier_ordered_quantity($sinvoice_item_pc['costing_part_id'], "pc");
                                        }
                                        
                                      
                                         
                                        $recent_quantity = get_recent_quantity($sinvoice_item_pc['costing_part_id'], $sinvoice_item_pc['costing_supplier']);
                                        
                                         if(count($recent_quantity)>0 && $pts['transaction_type']=="pc"){
                                             if($sinvoice_item_pc['costing_type']=="normal"){
                                            
                                      $uninvoicedquantity = ((($sinvoice_item_pc['original_quantity']=="" ? $sinvoice_item_pc['costing_quantity'] : $sinvoice_item_pc['original_quantity'])+$recent_quantity['total']) - $invoicedquantity)-$purchase_ordered_quantity;
                                     $costing_quantity = (($sinvoice_item_pc['original_quantity']=="" ? $sinvoice_item_pc['costing_quantity'] : $sinvoice_item_pc['original_quantity'])+$recent_quantity['total']);
              }
              else{
                  if($recent_quantity['updated_quantity']>0){
                   $uninvoicedquantity = ($recent_quantity['updated_quantity'] - $invoicedquantity)-$purchase_ordered_quantity;
                   $costing_quantity = $recent_quantity['updated_quantity'];
                  }
                   else{
                       $uninvoicedquantity = (($sinvoice_item_pc['original_quantity']=="" ? $sinvoice_item_pc['costing_quantity'] : $sinvoice_item_pc['original_quantity']) - $invoicedquantity)-$purchase_ordered_quantity;
                       $costing_quantity = ($sinvoice_item_pc['original_quantity']=="" ? $sinvoice_item_pc['costing_quantity'] : $sinvoice_item_pc['original_quantity']);
                   }
              }
            }
            else{
                 $uninvoicedquantity = (($sinvoice_item_pc['original_quantity']=="" ? $sinvoice_item_pc['costing_quantity'] : $sinvoice_item_pc['original_quantity']) - $invoicedquantity)-$purchase_ordered_quantity;
                $costing_quantity = ($sinvoice_item_pc['original_quantity']=="" ? $sinvoice_item_pc['costing_quantity'] : $sinvoice_item_pc['original_quantity']);
            }
            if($uninvoicedquantity<0){
            $uninvoicedquantity = 0;
            }
            $uninvoicedbudget = ($sinvoice_item_pc['unit_cost']=="" || $sinvoice_item_pc['unit_cost']==0.00 ? $sinvoice_item_pc['costing_uc'] : $sinvoice_item_pc['unit_cost']) * $uninvoicedquantity;
                                        ?>


                                        <tr id="tablepc<?php echo $counter; ?>trnumber<?php echo $counter ?>" tr_val="<?php echo $counter ?>" class="locked prcos<?php echo $counter; ?>" ta_val="<?php echo $counter; ?>">
                                            <input type="hidden" name="original_quantity[]" value="<?php echo $costing_quantity;?>">
                                        <input type="hidden" name="<?= 'pcinvoicetype[]' ?>" value="<?php echo $pts['transaction_type'];?>">
                                        <input  type="hidden"  name="<?= 'pcorderqty[]' ?>" rno ='<?php echo $counter ?>' id="pcorderqty<?php echo $counter ?>" class="qty" value="<?php echo $ordered_quantity ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                        <input  type="hidden"  name="<?= 'supplierorderqty[]' ?>" rno ='<?php echo $counter ?>' id="supplierorderqty<?php echo $counter ?>" class="qty" value="<?php echo $supplier_ordered_quantity; ?>"/>
                                        <input type="hidden" class="si_id_pc" name="<?php echo 'project_cost_partpc[]' ?>" value="<?php echo $sinvoice_item_pc['costing_part_id'] ?> ">
                                        <input type="hidden" name="<?php echo 'pcsi_item_id[]' ?>" value="<?php echo $pts['id'] ?>">
                                            <td>

                                                <input type="hidden" name="<?php echo 'pcstage[]' ?>" value="<?php echo $pts['stage_id'] ?>" id="stagefield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="readonlyme" readonly >
                                                <?php

                                                echo $pts['stage_name'];


                                                ?>

                                            </td>

                                            <td><input  type="hidden" name="<?php echo 'pcpart[]' ?>" id="partfield<?php echo $counter ?>" value="<?php echo $pts['part_field'] ?>" rno ='<?php echo $counter ?>' class="readonlyme" /><?php echo $pts['part_field'] ?></td>
                                            <td>


                                                <input type="hidden" value="<?php echo $pts['component_id']; ?>" name="<?php echo 'pccomponent[]' ?>" id="componentfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" onchange="return componentval(this);" >
                                                <?php
                                                echo $pts['component_name'];
                                                ?>
                                                <input type="hidden" value="<?php echo $pts['supplier_id'] ?>" name="<?php echo 'pcsupplier_id[]' ?>" id="supplierfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' >
                                            </td>  
                                            

                                            <td><input  type="hidden" name="<?php echo 'pcuom[]' ?>" id="uomfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts['costing_uom'] ?>" width="5" /><?php echo $pts['costing_uom'] ?></td>
                                            <td><?php echo ($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost'])?><input  type="hidden" name="<?php echo 'pcucost[]' ?>" id="pcinuccost<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo ($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost'])?>"  onchange="calculateTotal(this.getAttribute('rno'))"/>
                                            <input  type="hidden" name="<?php echo 'pclinttotal[]' ?>"  rno ='<?php echo $counter ?>' id="linetotalfield<?php echo $counter ?>" value="<?php echo number_format($costing_quantity*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']), 2, '.', ''); ?>"/>
                                            <input  type="hidden" name="<?php echo 'pcmargin[]' ?>" id="pcmargin<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts['margin'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                             <input  type="hidden" name="<?php echo 'pcmargintotal[]' ?>"  rno ='<?php echo $counter ?>' id="pcmargintotal<?php echo $counter ?>" value="<?php echo $pts['line_margin'];?>"/>
                                            <input type="hidden" name="<?php echo 'uninvoicequantity[]' ?>" id="pcuninvoicequantity<?php echo $counter ?>" value="<?php echo $uninvoicedquantity; ?>" rno ='<?php echo $counter ?>'/>
                                            <input disabled type="hidden" name="<?php echo 'uninvoicebudget[]' ?>" id="pcuninvoicebudget<?php echo $counter ?>" value="<?php echo $uninvoicedbudget; ?>" rno ='<?php echo $counter ?>'/>
                                            </td>
                                            <td>
                                                <input type="hidden" name="<?php echo 'pcinvoicequantity[]' ?>" id="pcinvoicequantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="pc" rno ='<?php echo $counter ?>' class="qty quantitychange" /><?php echo number_format($pts['quantity'],2); ?>
                                                <input type="hidden" name="<?php echo 'pcinvoiceoriginalquantity[]' ?>" id="pcinvoiceoriginalquantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="pc" rno ='<?php echo $counter ?>'/>
        
                                            <input disabled type="hidden" name="<?php echo 'pcinsubtotal[]' ?>" id="pcinsubtotal<?php echo $counter ?>" value="<?php echo number_format($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']), 2, '.', ''); ?>" rno ='<?php echo $counter ?>' class="subtotalchange" readonly/>
                                            <input disabled type="hidden" name="<?php echo 'pcinsubtotalmargin[]' ?>" id="pcinsubtotalmargin<?php echo $counter ?>" value="<?php  echo number_format(($pts['quantity']*$pts['costing_uc'])*(100+$pts['margin'])/100, 2, '.', ''); ?>" rno ='<?php echo $counter ?>' class="subtotalchange" readonly/>
                                            </td>
                                            <td><?php echo number_format($pts['invoice_amount'], 2, '.', '') ?><input type="hidden" name="<?php echo 'pcinvoicebudget[]' ?>" id="pcinvoicebudget<?php echo $counter ?>" value="<?php echo number_format($pts['invoice_amount'], 2, '.', '') ?>" rno ='<?php echo $counter ?>' ty='pc' /></td><?php $amount_total_entered+=$pts['supplier_credit_amount']; ?>
                                            <input  type="hidden" name="<?php echo 'pcinvoicecostdiff[]' ?>" id="pcinvoicecostdiff<?php echo $counter ?>" value="<?php echo number_format(($pts['invoice_amount']-($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']))), 2, '.', '')?>" rno ='<?php echo $counter ?>' <?php if($pts['client_allowance']==0){ ?> class="res_count  readonlyme" <?php } else{ ?>class="readonlyme" <?php } ?> readonly/></td>
                                            <?php $res_invoicecostd[$t_count] = ($pts['invoice_amount']-($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost'])));?>
                                            <td><input type="number" name="pcsuppliercreditquantity[]" id="pcsuppliercreditquantity<?php echo $counter ?>" value="<?php echo $pts['supplier_credit_quantity'];?>" rno ='<?php echo $counter ?>' ty='pc' class="form-control quantitychange" /></td>
                                            <td><input type="text" name="pcsuppliercreditamount[]" id="pcsuppliercreditamount<?php echo $counter ?>" value="<?php echo number_format($pts['supplier_credit_amount'], 2, '.', '') ?>" rno ='<?php echo $counter ?>' ty='pc' class="form-control invoicebudget" /></td>
                                           
                                            <!--<td> 
                                            <?php if( $sinvoice_detail->status=="Pending" ){ ?>
                                                <a  class="btn btn-sm btn-danger remove pull-right" tabletype="prcos" type="button" style="padding-bottom: 9px;padding-top: 9px;" onclick="$('.prcos<?php echo $counter; ?>').remove();calculate();"><i class="fa fa-times-circle-o"></i>Remove this </a>
                                            <?php } ?>
                                            </td>-->
                                        </tr>
                                     
                                          <?php  if($i==count($sinvoice_items_pc)){ ?>
                                        </tbody>
                
                                                    </table>
                                                </div>
                                               <?php } ?>
                                        <?php  $i++; endforeach; ?>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                   
                                    <table class="table calstable">
                                      <tbody>
                                          <tr>
                                            <td>Credit Amount Entered <small>*</small></td>
                                            <td>$</td>
                                            <td width="160">
                                                <input class="form-control notrequired" name="creditamountent" id="creditamountent" required number="true" value="<?php echo number_format($amount_total_entered, 2, '.', '');?>">
                                            </td>
                                          </tr>
                                           <tr>
                                                <td >Amount Not Entered <small>*</small></td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control notrequired" name="creditamountnotent" id="creditamountnotent" required number="true" value="<?php echo number_format($sinvoice_detail->invoice_amount-$amount_total_entered, 2, '.', ''); ?>"></td>
                                            </tr>
                                          
                                          <tr>
                                        <td colspan="2">Credit Status <small>*</small></td>
                                        <td width="160">

                                        <select class='selectpicker notrequired <?php if ( $sinvoice_detail->status!="Pending" &&  $sinvoice_detail->status!="Approved" ) echo "readonlyme" ?>' data-style="select-with-transition" name="suppliercreditstatus" id="suppliercreditstatus"  title="Select Status" required>
                                            <option
                                            <?php echo ($sinvoice_detail->status!='Pending')?  ' disabled ' :  '' ?>

                                            <?php if($sinvoice_detail->status=='Pending')  echo ' selected '?> value="Pending">Pending</option>
                                        <?php
                                      if(in_array(22, $this->session->userdata("permissions"))) {
                                    ?>
                                        <option <?php if(trim($sinvoice_detail->invoice_amount)!=trim($amount_total_entered)){ echo ' disabled'; } ?>  <?php if($sinvoice_detail->status=='Approved')  echo 'selected'?> value="Approved">Approved</option>
                                    <?php } ?>
                                        <option

                                            <?php echo ($sinvoice_detail->status=='Pending')?  'disabled' :  '' ?>

                                            <?php if($sinvoice_detail->status=='Paid')  echo 'selected'?> value="Paid" disabled>Paid</option>
                                        <option disabled <?php if($sinvoice_detail->status=='Sales Invoiced')  echo 'selected'?> value="Sales Invoiced">Sales Invoiced</option>

                                        </select>

                                    </td>

                                </tr>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                         <div class="col-md-6 col-md-offset-6" id="suppintotal1">
                        
                                 <table class="calstable table" style="width:500px; margin:0 auto">
                                     
                                        <tr>
                                            <td><label><h4><b>Subtotal</b></h4></label></td>
                                            <td style="text-align:right;"><h4><span class="total"><?php echo "$".number_format($amount_total_entered, 2, '.', '');?></span></h4></td>
                                        </tr>
                                        <tr style="border-bottom: 3px solid black;line-height: 30px;">
                                            <td><label><h4><b>Total GST  15%</b></h4></label></td>
                                            <td style="text-align:right;"><h4><span class="total"><?php echo "$".number_format((15/100)*$amount_total_entered, 2, '.', '');?></span></h4></td>
                                        </tr>
                                        <tr>
                                            <td><label><h4><b>Total Credit</b></h4></label></td>
                                            <td style="text-align:right;"><h4><b><span class="total"><?php echo "$".number_format(($amount_total_entered+(15/100)*$amount_total_entered), 2, '.', '');?></span></b></h4></td>
                                        </tr>
                                        <?php 
                                        
                                        $amount_due = ($amount_total_entered+(15/100)*$amount_total_entered);
                                        $total_amount = 0;
                                        
                                        $credit_notes = get_allocate_supplier_credit_notes($sinvoice_detail->id);
                                        if(count($credit_notes)>0){
                                
                                        foreach($credit_notes as $credit_note_detail){ ?>
                                        <tr>
                                            <td><h4 style="color:#ccc;"><b>Less Credit to <a href="<?php echo SURL;?>supplier_invoices/viewinvoice/<?php echo $credit_note_detail['allocated_invoice_id'];?>" target="_Blank"><span style="color:#3af;">Bill <?php echo get_allocated_supplier_invoice($credit_note_detail['allocated_invoice_id']);?></span></a><br/><span style="color:#777777;"><?php echo date("d F Y", strtotime(str_replace("/", "-", $credit_note_detail['date'])));?></span></b></h4></td>
                                       
                                            <td style="text-align:right;"><h4 class="total_heading"><span class="total"><?php echo "$".$credit_note_detail['amount']; ?></span></h4></td>
                                        </tr> 
                                        
                                        <?php 
                                        $amount_due = $amount_due-$credit_note_detail['amount'];
                                        }  } ?>
                                    
                                        <tr style="border-top: 3px solid black;line-height: 30px;">
                                            <td><label><h4><b>Allocate Remaining Credit</b></h4></label></td>
                                            <td style="text-align:right;"><h4 class="total_heading"><b><span class="total">$<?php echo number_format($amount_due, 2, ".", ","); ?></span></b></h4></td>
                                        </tr>
                                       
                                    </table>
                            </div>
                        </div>
                             </div>
                        </div>
                     
                        <div class="col-md-12" id="suppintot" style="<?php echo (count($sinvoice_items_ni))?  "display:block":  "display:none";?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="alert alert-info" style=" display: none" id="createvariationwarn">
                                        <strong>Info!</strong> You should get prior approval from client before creating this variation, the Supplier Credit can only be created for approved variations. 
                                    </div>
                                    <table class="table">
                                      <tbody>
                                          <tr>
                                            <td>Hide from Project Sales Summary</td>
                                            <td></td>
                                            <td width="160">
                                                <div class="checkbox">
                                                   <label><input type="checkbox" id="hide_from_summary" name="hide_from_summary" <?php if(isset($sinvoice_detail->hide_from_sales_summary) && $sinvoice_detail->hide_from_sales_summary == 1) echo 'checked'; ?> value="1" onchange="update_variation('hide_from_summary');"></label>
                                                </div>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Create Variation </td>
                                            <td></td>
                                            <td width="160">
                                                <div class="checkbox">
                                                   <label><input type="checkbox" id="createvariation" name="createvariation" value="<?php echo ($sinvoice_detail->create_variation)?  "1":  "0";  ?>" <?php echo ($sinvoice_detail->create_variation)?  "checked":  "";  ?> onchange="checkcreatvar(this.id)"></label>
                                                </div>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>Variation Number <small>*</small></td>
                                            <td colspan="2"><input class="form-control readonlyme" type="text" id="var_number" name="var_number" value="<?php echo ($sinvoice_detail->var_number!=0)? $sinvoice_detail->var_number : 10000000 + $var_number ?>" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>Variation Description <small>*</small></td>
                                            <td colspan="2">
                                                    <textarea class="form-control" rows="5"  id="varidescriptioin" name="varidescriptioin" <?php if($sinvoice_detail->create_variation=='1'){ ?> onblur="update_variation('varidescriptioin');" <?php } ?> <?php if($sinvoice_detail->create_variation=='1')  echo 'required'?>><?php echo $sinvoice_detail->va_description?></textarea>
                                            </td>              
                                        </tr>
                                          <tr>
                                            <td>Supplier Credit Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost" id="total_cost" value="<?php echo $sinvoice_detail->va_addclient_cost?>"  readonly required></td>
                                          </tr>
                                          <tr>
                                            <td>Overhead Margin <small>*</small></td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="<?php echo $sinvoice_detail->va_ohm?>" required></td>
                                          </tr>
                                          <tr>
                                            <td>Profit Margin <small>*</small></td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="<?php echo $sinvoice_detail->va_pm?>" required></td>
                                          </tr>
                                          <tr>
                                            <td>Supplier Credit Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost2" id="total_cost2" value="<?php $subtotal = $sinvoice_detail->va_addsi_cost*(100+$sinvoice_detail->va_ohm+$sinvoice_detail->va_pm)/100; echo number_format($subtotal,2);?>"  readonly required></td>
                                          </tr>
                                          <tr>
                                            <td>Tax <small>*</small></td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="costing_tax" id="costing_tax" value="<?php echo $sinvoice_detail->va_tax?>" required></td>
                                          </tr>
                                          <tr>
                                            <td>Supplier Credit Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="total_cost3" id="total_cost3" value="<?php echo number_format($subtotal*(100+ $sinvoice_detail->va_tax)/100,2)?>"  readonly required></td>
                                          </tr>
                                          <tr>
                                            <td >Supplier Credit Adjustment <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control  roundme" name="price_rounding" id="price_rounding" value="<?php echo $sinvoice_detail->va_round?>" required></td>
                                          </tr>
                                          <tr>
                                            <td >Supplier Credit Variation Total <small>*</small></td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="contract_price" id="contract_price" value="<?php echo $sinvoice_detail->va_total?>" required></td>
                                          </tr>
                                          <tr>
                                        <td colspan="2">Variation Status <small>*</small></td>
                                        <td width="160">

                                        <select class="selectpicker" data-style="select-with-transition" name="suppliercreditvarstatus" id="suppliercreditvarstatus" title="Select Status" <?php if($sinvoice_detail->create_variation=='1')  echo 'required'?>>

                                            <option <?php if($sinvoice_detail ->va_status=='PENDING')  echo 'selected'?> value="PENDING">Pending</option>
                                    <?php
                                      if(in_array(10, $this->session->userdata("permissions"))) {
                                    ?>
                                    <option <?php if($sinvoice_detail ->va_status=='ISSUED')  echo 'selected'?> value="ISSUED">Issued</option>
                                    <?php } ?>
                                    <?php
                                      if(in_array(9, $this->session->userdata("permissions"))) {
                                    ?>
                                    <option <?php if($sinvoice_detail ->va_status=='APPROVED')  echo 'selected'?> value="APPROVED">Approved</option>
                                    <?php } ?>
                                    <option <?php if($sinvoice_detail ->va_status=='SALES INVOICED')  echo 'selected'?> value="SALES INVOICED">Sales Invoiced</option>
                                    <option <?php if($sinvoice_detail ->va_status=='PAID')  echo 'selected'?> value="PAID" disabled>Paid</option>

                                        </select>

                                    </td>

                                </tr>
                                          <tr>
                                            <td colspan="2">Lock/Unlock</td>
                                            <td  width="160"><a class="btn btn-simple btn-success btn-icon" id="iconlockproject" onclick="LockProject()"><i class="material-icons lock_project_icon_type">lock_open</i></a>
                                              <input type="hidden" name="lockproject" id="lockproject" value="0"></td>
                                          </tr>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                            <?php
                                               if(in_array(21, $this->session->userdata("permissions"))) {
                                                 if( $sinvoice_detail->status=="Pending" ){ 
                                            ?>
                                            <button type="submit" class="btn btn-warning btn-fill">Update Supplier Credit</button>
                                            <?php } } ?>
                                         </div>
                                         <div class="pull-right">
                                            <a href="<?php echo SURL;?>supplier_invoices" class="btn btn-default btn-fill">Close</a>
                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                    
    <div class="modal fade" id="change_project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change project, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changeproject()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangeproject()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="change_supplierm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change supplier, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changesupplier()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangesupplier()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="change_stage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Do you really want to change stage, all imported data will be removed</h4>
            </div>

            <div class="modal-footer">
                <input class="btn btn-sm btn-danger" data-dismiss="modal" value="Yes" onclick="changestage()">
                <input class="btn btn-sm btn-success" data-dismiss="modal" value="No" onclick="donotchangestage()">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_po_for_this_supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> No approved purchase order with uninvoiced quantity set for this supplier</div>
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="error_no_pc_for_this_supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-info"><strong>Info!</strong> No project part costing without purchase order for this supplier</div>
            </div>

            <div class="modal-footer">
                 <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Upodate component cost-->

<div id="componentCostModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h4>The Invoice Unit Cost appears to be different to the current component Unit Cost. Do you want to update the component Unit Cost?</h4>
       <form>
           <input type="hidden" id="update_component_id" value="">
           <input type="hidden" id="update_invoice_unit_cost" value="">
           <input type="hidden" id="update_rno" value="">
            <div class="form-group">
                <label for="current_unit_cost">Current Unit Cost:</label>
                <input type="text" class="form-control" id="current_unit_cost" name="current_unit_cost" value="" readonly>
            </div>
            <div class="form-group">
                <label for="current_unit_cost">Invoice Unit Cost:</label>
                <input type="text" class="form-control" id="invoice_unit_cost" name="invoice_unit_cost" value="" readonly>
            </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="update_component_unit_cost();">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Don't Update</button>
      </div>
    </div>

  </div>
</div>
                