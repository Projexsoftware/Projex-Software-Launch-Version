          <script>
              var invoiceamountist =<?php echo $sinvoice_detail ->invoice_amount ?>;
          </script>
           
               <div id='estimatewarning' class='alert alert-danger' style='display:none'>Warning: This project costing contains estimated costs.</div>
               <form id="SupplierInvoiceForm" method="POST" action="<?php echo ($sinvoice_detail->status=='Pending')? SURL.'supplier_invoices/updateinvoice/'.$sinvoice_detail->id :   SURL.'supplier_invoices/changedsuplierinvoicestatus/'.$sinvoice_detail->id  ?>" onsubmit="return validateForm()" autocomplete="off">
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
                                        ?><i class="material-icons view-timesheet-icon">schedule</i> <?php } ?>View & Update Supplier Invoice <?php if($sinvoice_detail->invoice_type=="timesheet"){?>
                                        <b>VIA</b> Timesheet<?php } ?></h4>
                                        <?php if($sinvoice_detail->status!='Pending') {?>
                                        <!--<div class="toolbar">
                                            <a href="<?php echo SURL.'supplier_invoices/exportascsv/'.$sinvoice_detail->id ?> " class="btn btn-success" target="_blank">Export As CSV</a>
                                        </div>-->
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
                                                        <label>Supplier Invoice Name <small>*</small></label>
                                                        <?php echo get_supplier_invoice_name($sinvoice_detail->id); ?>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row filter_section">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Filter Suppliers for current Project <p class="text-danger">Note: Selecting suppliers will reset this page. Any entered data will be lost.</p></label>
                                                    <select class="selectpicker" data-live-search="true" data-style="select-with-transition" name="supplier_id" id="supplier_id" onchange="change_supplier(this.value)"  multiple="multiple" title="Select Suppliers">
                                                        <?php foreach($suppliers as $supplier){ ?>
                                                        <option  value="<?php echo $supplier['supplier_id'];?>" ><?php echo $supplier['supplier_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        <label>Filter Stages for current Project <p class="text-danger">Note: Selecting stages will reset this page. Any entered data will be lost.</p></label>
                                                           <select class="selectpicker" data-live-search="true" data-style="select-with-transition" name="stage_id" id="stage_id" onchange="change_stage(this.value)"  title="Select Stages" multiple="multiple">
                                                                <?php foreach($stages as $stage){ ?>
                                                                <option  value="<?php echo $stage['stage_id'];?>" ><?php echo $stage['stage_name'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Enter Supplier Reference <small>*</small></label>
                                                    <input class="form-control" name="supplierrefrence" id="supplierrefrence" type="text"  value="<?php echo $sinvoice_detail->supplierrefrence?>" required>
                                                    <?php echo form_error('supplierrefrence', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        <label><?php if($sinvoice_detail->invoice_type=="timesheet"){?> Cost Subtotal <?php } else{ ?> Enter Invoice Amount Excluding GST <?php } ?> <small>*</small></label>
                                                           <input class="form-control" name="invoiceamountist" id="invoiceamountist" type="text" value="<?php echo $sinvoice_detail->invoice_amount?>" required number="true" >
                                                           <?php echo form_error('invoiceamountist', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-6">
                                                    <label>Enter Invoice Date <small>*</small></label>
                                                    <input class="form-control datepicker" name="invoicedate" id="invoicedate" type="text" value="<?php if($sinvoice_detail->invoice_date!="0000-00-00"){echo  $sinvoice_detail->invoice_date; }?>" required autocomplete="off">
                                                    <?php echo form_error('invoicedate', '<div class="custom_error">', '</div>'); ?>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                        <label>Enter Invoice Due Date <small>*</small></label>
                                                           <input class="form-control datepicker" name="invoiceduedate" id="invoiceduedate" type="text" required autocomplete="off" value="<?php if($sinvoice_detail->invoice_due_date!="0000-00-00"){ echo $sinvoice_detail->invoice_due_date; }?>">
                                                           <?php echo form_error('invoiceduedate', '<div class="custom_error">', '</div>'); ?>
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
                                         <?php if( $sinvoice_detail->status=="Pending" && in_array(21, $this->session->userdata("permissions"))){ ?>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-warning btn-fill" value="0" onclick="addMore(this.value);"><i class="material-icons">add</i> Add New Items</button>
                                            <button type="button" class="btn btn-danger btn-fill removeallbtn"><i class="material-icons">delete</i> Remove All</button>
                                            <a id="repopulateButton" class="btn btn-primary btn-fill" role="button"  href="javascript:void(0)" onclick="repopulate_all_available_components();"><i class="material-icons">refresh</i> Repopulate All Available Components</a>
                                        
                                            
                                            <?php if(in_array(69, $this->session->userdata("permissions")) && $sinvoice_detail->status=="Pending") {?>
                                            <button id="addcomponentbtn" class="btn btn-info btn-fill" type="button" data-toggle="modal" href="#addNewComponentModal"><i class="material-icons">add</i> Add Component</button>
                                            <?php } ?>
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
                                                           <td colspan="6">Supplier Invoices</td>
                                                       </tr>
                                                       <tr>
    
                                                        <th>Stage</th>
                            
                                                        <th>Part</th>
                            
                                                        <th>Component</th>
                            
                                                        <th>Supplier</th>
                                                        
                                                        <th>Include in specifications</th>
                            
                                                        <th>Client Allowance</th>
                                                        
                                                        <th>Unit Of Measure</th>
                            
                                                        <th>Unit Cost</th>
                                                        
                                                        <th>Quantity</th>
                            
                                                        <th>Invoice Amount</th>
                            
                                                        <th>Allocate to Allowance</th>
                                                        
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

                                            <td><input name="nipart[]" id="nipartfield<?php echo $count; ?>" value="<?php echo $pts['part_field']; ?>" rno ='<?php echo $count; ?>' class="form-control" required="true"></td>
                                            <td>
                                                <select rno="<?php echo $count;?>" data-container="body" class="selectComponent" data-style="btn btn-warning btn-round" title="Choose Component" data-live-search="true" data-size="7" name="nicomponent[]" id="nicomponentfield<?php echo $count; ?>" required="true" onchange="return componentval(<?php echo $count; ?>);">
                                                    <option value="<?php echo $pts["component_id"];?>" selected><?php echo $pts["component_name"];?></option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="nisupplier_name[]" id="nisupplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo get_supplier_name($pts['supplier_id']);?>" readonly required="true">
                                                <input type="hidden" class="form-control" name="nisupplier_id[]" id="nisupplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $pts['supplier_id'];?>" readonly>
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="specification_check[]" rno ='<?php echo $count; ?>' id="specificationcheck<?php echo $count; ?>"  <?php if($pts['include_in_specification']==1){ ?> checked <?php } ?> onClick="changeSpecificationValue(this.id, this.getAttribute('rno'))"/>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="include_in_specification[]" value="<?php echo $pts['include_in_specification'];?>" id="include_in_specification<?php echo $count; ?>">
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                      <input type="checkbox" name="allowance_check[]" rno ='<?php echo $count; ?>' id="allowance_check<?php echo $count; ?>"  <?php if($pts['client_allowance']==1){ ?> checked <?php } ?> onClick="changeAllowanceValue(this.id, this.getAttribute('rno'))"/>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="client_allowance[]" value="<?php echo $pts['client_allowance'];?>" id="client_allowance<?php echo $count; ?>">
                                            </td>
                                            <td><input readonly type="text" name="niuom[]" id="niuomfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="<?php echo $pts['ni_uom'] ?>" class="form-control readonlyme" width="5" /></td>
                                            <td><input readonly type="text" name="niucost[]" id="niucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control readonlyme" value="<?php echo number_format($pts['ni_unit_cost'], 2, '.', ''); ?>" onchange="calculateTotal(this.getAttribute('rno'))"/></td>
                                            <td><input  name="nimanualqty[]" rno ="<?php echo $count; ?>" id="nimanualqty<?php echo $count; ?>" type="number" step="any" required="true" class="qty form-control" value="<?php echo $pts['quantity'] ?>" onchange="calculateInvoiceAmount(<?php echo $count; ?>);"/></td>
                                            <td><input type="text" name="nilinttotal[]"  rno ="<?php echo $count; ?>" id="nilinetotalfield<?php echo $count; ?>" <?php if($pts['allocated_allowance_id']==0){ ?> class="form-control invoicebudget invoicebudget1 include_in_variation" <?php } else{ ?> class="form-control invoicebudget invoicebudget1" <?php } ?> value="<?php echo number_format($pts['invoice_amount'], 2, '.', ''); ?>" /></td>
                                            <?php  $amount_total_entered+= number_format($pts['invoice_amount'], 2, '.', '');  ?>
                                             <td>
                                                <?php $allocated_allowances_list = get_allocated_allowances($pts['id']);?>
                                                <?php if($sinvoice_detail->status=="Pending"){ ?>
                                                <select name="niallowance[]" id="niallowancefield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" data-live-search="true" onchange="excludefromvariation(<?php echo $count; ?>);">
                                                    <option value="0">None</option>
                                                    <?php foreach ($allowances as $allowance) { ?>
                                                        <option <?php if($pts['allocated_allowance_id']==$allowance["costing_part_id"]) { ?> selected <?php } ?> value="<?php echo $allowance["costing_part_id"]."|".$allowance["line_margin"]; ?>"><?php echo $allowance["costing_part_name"]; ?></option>
                                                    <?php } ?>
                                        
                                                </select>
                                                <?php } else{ ?>
                                                <input type="hidden" class="form-control" name="niallowance[]" id="niallowancefield<?php echo $count ?>" rno ='<?php echo $count ?>' value="$pts['allocated_allowance_id']">
                                          
                                                <?php } ?>
                                                <?php 
                                                
                                                if(count($allocated_allowances_list)>0){
                                                ?>
                                                <ol style="padding-left: 16px;">
                                                <?php 
                                                foreach($allocated_allowances_list as $val){
                                                ?> 
                                                 <li><?php echo get_part_name($val["allocated_allowance_id"]);?></li>
                                                <?php   
                                                }
                                                ?>
                                                </ol>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
                                            </td>
                                           

                                        </tr>
                                        </tr>
                                    <?php $count ++?>
                                    <?php } ?>
                                                   </tbody>
                                                   </table>
                                           </div>
                                        </div>
                                        </div>
                                        <div id="podiv" >
                                        <?php 
                                        if(isset($sinvoiceorders)){ ?>
                                            <?php $counter = 1; ?>
                                            <?php foreach($sinvoiceorders as $counterkey => $sinvoiceorder) :?>
                                            <?php $count = $counterkey+1; ?>
                
                                                <div class="table-responsive" >
                
                                                        <input type="hidden" class="order_id_po" name="<?php echo 'order_id_po[]' ?>" value="<?php echo $sinvoiceorder['id'] ?>">
                
                
                
                                                        <table id="tablepc<?php echo $count; ?>" class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                            <tr style="height : auto" >
                                                                <th colspan="12" style="height : auto"><?php echo $projectinfo['project_title'] ?></th>
                                                                <th colspan="2" style="height : auto;"  >Uninvoiced</th>
                                                                <th colspan="5" style="height : auto">Supplier Invoices</th>
                                                                <th style="height : auto"></th>
                
                                                            </tr>
                                                            <tr class="headers">
                                                                <th>Origin</th>
                                                                <th>Stage</th>
                                                                <th>Part</th>
                                                                <th>Component</th>
                                                                <th>Supplier</th>
                                                                <th>QTY</th>
                                                                <th width="40px">Included project costing or variation</th>
                                                                <th>Unit Of Measure</th>
                                                                <th>Unit Cost</th>
                                                                <th>Line Total</th>
                                                                <th>Margin %</th>
                                                                <th>Line Total with Margin</th>
                                                                <th>Un- invoiced Quantity</th>
                                                                <th>Un- invoiced Budget</th>
                                                                <th>Quantity</th>
                                                                <th>Subtotal</th>
                                                                <th>Subtotal with margin</th>
                                                                <th>Invoice Amount</th>
                                                                <th>Invoice cost difference</th>
                
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php 
                                                            
                                                            foreach ($sinvoiceorder['sinvoice_items_po'] as $pts) {
                                                            $supplier_ordered_quantity = get_supplier_ordered_quantity($pts['costing_part_id']);
                                                            $ordered_quantity = get_ordered_quantity($pts['costing_part_id']);
                                                            ?>
                
                
                
                                                                <tr id="tablepo<?php echo $counter; ?>trnumber<?php echo $counter ?>" class="locked puror<?php echo $count; ?>" tr_val="<?php echo $counter ?>" ta_val="<?php echo $count; ?>">
                 <input  type="hidden"  name="<?= 'pcorderqty[]' ?>" rno ='<?php echo $counter ?>' id="pcorderqty<?php echo $counter ?>" class="qty form-control" value="<?php echo $ordered_quantity ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                 <input type="hidden" name="<?= 'pcinvoicetype[]' ?>" value="<?php echo $pts['transaction_type'];?>">
                                    <input  type="hidden"  name="<?= 'supplierorderqty[]' ?>" rno ='<?php echo $counter ?>' id="supplierorderqty<?php echo $counter ?>" class="qty form-control" value="<?php echo $supplier_ordered_quantity; ?>"/>
                                                                    <input type="hidden" name="<?php echo 'pocosting_part_id' . $sinvoiceorder['id'] . '[]' ?>" value="<?php echo $pts['costing_part_id'] ?>">
                                                                    <input type="hidden" name="<?php echo 'posi_item_id' . $sinvoiceorder['id'] . '[]' ?>" value="<?php echo $pts['id'] ?>">
                                                                    <input type="hidden" name="<?php echo 'posrno' . $sinvoiceorder['id']. '[]' ?>" value="<?php echo $pts['srno']; ?>">
                                                                    <td>Purchase Order number <?php echo $sinvoiceorder['id'] ?></td>
                                                                    <td>
                                                                        <input type="hidden" name="<?php echo 'postage' . $sinvoiceorder['id'] . '[]' ?>" id="stagefield<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts['stage_id'] ?>" class="form-control readonlyme" >
                                                                        <?php
                
                                                                        echo $pts['stage_name'];
                
                                                                        ?>
                                                                    </td>
                
                                                                    <td><input  type="hidden" name="<?php echo 'popart' . $sinvoiceorder['id'] . '[]' ?>" id="partfield<?php echo $counter ?>" value="<?php echo $pts['part_field']; ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" /><?php echo $pts['part_field']; ?></td>
                                                                    <td>
                
                                                                        <input type="hidden" name="<?php echo 'pocomponent' . $sinvoiceorder['id'] . '[]' ?>" value="<?php echo $pts['component_id'] ?>" id="componentfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" >
                                                                        <?php
                
                
                                                                        echo $pts['component_name'];
                
                                                                        ?>
                
                                                                    </td>
                                                                    <td>
                
                                                                        <input type="hidden" disabled class="form-control" name="<?php echo 'supplier_id' . $sinvoiceorder['id'] . '[]' ?>" value="<?php echo $sinvoice_detail->supplier_id; ?>" id="supplierfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' >
                                                                        <?php
                                                                        echo $sinvoice_detail->supplier_name;
                
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="manualfield" id="manualfield<?php echo $counter ?>">
                                                                            <input type="hidden" disabled  name="<?php echo 'orderqty' . $sinvoiceorder['id'] . '[]' ?>" rno ='<?php echo $counter ?>' id="poorderqty<?php echo $counter ?>" type="text" ty="po" class="qty form-control" value="<?php echo $pts['order_quantity'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                                                        </div>
                                                                        <?php echo number_format($pts['order_quantity'],2); ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="iipc" id="iipc<?php echo $counter ?>">
                                                                            <input disabled type="checkbox" <?php if ($pts['costing_part_id']) echo "checked" ?> style="pointer-events: none; position: relative" readonly   class="readonlyme" >
                                                                        </div>
                
                                                                    </td>
                                                                    <td><input disabled type="hidden" name="<?php echo 'uom' . $sinvoiceorder['id'] . '[]' ?>" id="uomfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts['costing_uom'] ?>" class="form-control" width="5" /><?php echo $pts['costing_uom'] ?></td>
                                                                    <td><input disabled type="hidden" name="<?php echo 'ucost' . $sinvoiceorder['id'] . '[]' ?>" id="poinuccost<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control" value="<?php echo ($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']) ?>" onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo ($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']) ?></td>
                                                                    <td><input disabled type="hidden" name="<?php echo 'linttotal' . $sinvoiceorder['id'] . '[]' ?>"  rno ='<?php echo $counter ?>' id="linetotalfield<?php echo $counter ?>" class="form-control" value="<?php echo $pts['line_cost'] ?>" /><?php echo number_format($pts['line_cost'], 2, '.', ''); ?></td>
                                                                    <td><input disabled type="hidden" name="<?php echo 'margin' . $sinvoiceorder['id'] . '[]' ?>" id="pomargin<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control" value="<?php echo $pts['margin'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo $pts['margin'] ?></td>
                                                                    <td><input disabled type="hidden" name="<?php echo 'margintotal' . $sinvoiceorder['id'] . '[]' ?>"  rno ='<?php echo $counter ?>' id="pomargintotal<?php echo $counter ?>" class="form-control" value="<?php echo $pts['line_margin'] ?>" /><?php echo number_format($pts['line_margin'], 2, '.', ''); ?></td>
                                                                    <td><input  type="hidden" name="<?php echo 'uninvoicequantity' . $sinvoiceorder['id'] . '[]' ?>" id="pouninvoicequantity<?php echo $counter ?>" value="<?php echo $pts['uninvoicedquantity']; ?>" rno ='<?php echo $counter ?>' class="form-control" /><?php echo number_format($pts['uninvoicedquantity'],2); ?></td>
                                                                    <td><input disabled type="hidden" name="<?php echo 'uninvoicebudget' . $sinvoiceorder['id'] . '[]' ?>" id="pouninvoicebudget<?php echo $counter ?>" value="<?php echo $pts['uninvoicebudget']; ?>" rno ='<?php echo $counter ?>' class="form-control" /><?php echo number_format($pts['uninvoicebudget'], 2, '.', ''); ?></td>
                                                                    <?php if($pts['uninvoicedquantity']==0){ ?>
                                                                    <td><input type="hidden" name="<?php echo 'poinvoicequantity' . $sinvoiceorder['id'] . '[]' ?>" id="poinvoicequantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="po" rno ='<?php echo $counter ?>' class="form-control quantitychange qty" /><?php echo $pts['quantity'] ?></td>
                                                                    <?php } else{ ?>
                                                                    <td><input type="number" step="any" name="<?php echo 'poinvoicequantity' . $sinvoiceorder['id'] . '[]' ?>" id="poinvoicequantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="po" rno ='<?php echo $counter ?>' class="form-control quantitychange qty" /></td>
                                                                    <?php } ?>
                                                                    <td><input disabled type="text" name="<?php echo 'poinsubtotal' . $sinvoiceorder['id'] . '[]' ?>" id="poinsubtotal<?php echo $counter ?>" value="<?php echo number_format($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']), 2, '.', ''); ?>" rno ='<?php echo $counter ?>' class="form-control subtotalchange" readonly/></td>
                                                                    <td><input disabled type="text" name="<?php echo 'poinsubtotalmargin' . $sinvoiceorder['id'] . '[]' ?>" id="poinsubtotalmargin<?php echo $counter ?>" value="<?php echo number_format(($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']))*(100+$pts['margin'])/100, 2, '.', ''); ?>" rno ='<?php echo $counter ?>' class="form-control subtotalchange" readonly/></td>
                                                                    <td><input type="text" name="<?php echo 'poinvoicebudget' . $sinvoiceorder['id'] . '[]' ?>" id="poinvoicebudget<?php echo $counter ?>" value="<?php echo number_format($pts['invoice_amount'], 2, '.', ''); ?>" onblur="calculateaddcost();" rno ='<?php echo $counter ?>' ty='po' class="form-control invoicebudget" /></td><?php $amount_total_entered+=$pts['invoice_amount']; ?>
                                                                    <td><input  type="text" name="<?php echo 'poinvoicecostdiff' . $sinvoiceorder['id'] . '[]' ?>" id="poinvoicecostdiff<?php echo $counter ?>" value="<?php echo number_format($pts['cost_diff'], 2, '.', ''); ?>" rno ='<?php echo $counter ?>' ty='po' class="form-control  invoicedifference readonlyme" readonly/></td>
                                                                   
                                                                </tr>
                
                                                                <?php $counter++ ?>
                
                                                            <?php }  ?>
                                                            </tbody>
                
                                                        </table>
                                                    </div>
                
                                            <?php endforeach;?>
                                        <?php } ?>
                                    </div>
                                        <div id="pcdiv" >
                                        <?php $t_count= 0; $res_invoicecostd = array();?>
                                        <?php $i=1;?>
                                        <?php foreach($sinvoice_items_pc as $counterkey => $sinvoice_item_pc) :?>
                                        
                                            <?php $counter = $counterkey+1; $t_count ++;?>
                                            
                                            <?php if($i==1){ ?>
                                                <div class="table-responsive" >
                                                    <table id="tablepc<?php echo $counter; ?>" class="table table-no-bordered templates_table">
                                                        <thead>
                
                                                        <tr style="height : auto" >
                                                            <th colspan="10" style="height : auto"><?php echo $projectinfo['project_title'] ?></th>
                                                            <th colspan="2" style="height : auto;"  >Uninvoiced</th>
                                                            <th colspan="4" style="height : auto">Supplier Invoices</th>
                                                            <th style="height : auto">Purchase Orders</th>
                                                        </tr>
                                                        <tr class="headers">
                                                            <th>Origin</th>
                                                            <th>Stage</th>
                                                            <th>Part</th>
                                                            <th>Component</th>
                                                            <th>Supplier</th>
                                                            <th>Unit Of Measure</th>
                                                            <th>Unit Cost</th>
                                                            <th>Line Total</th>
                                                            <th>Margin %</th>
                                                            <th>Line Total with Margin</th>
                                                            <th>Un- invoiced Quantity</th>
                                                            <th>Un- invoiced Budget</th>
                                                            <th>Quantity</th>
                                                            <th>Subtotal</th>
                                                            <th>Invoice Amount</th>
                                                            <th>Invoice cost difference</th>
                                                            <th>Purchase Order Number</th>
                
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
                                                        
                                                      
                                                         
                                                        $recent_quantity = get_recent_quantity($sinvoice_item_pc['costing_part_id'], $sinvoice_item_pc['supplier_id']);
                                                        
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
                                                            <td><?php if ($sinvoice_item_pc['is_variated'] == 0){ echo "Project costing part # ".$sinvoice_item_pc['costing_part_id'];}
                                                             else {
                                                             if($sinvoice_item_pc['var_number']==""){
                                                                 $var_no = 10000000+$sinvoice_item_pc['is_variated'];
                                                
                                                             }
                                                             else{
                                                               $var_no = $sinvoice_item_pc['var_number'];
                                                             }
                                                             echo "Variation # " . ($var_no);} ?>
                                                             </td>
                                                            <td>
                
                                                                <input type="hidden" name="<?php echo 'pcstage[]' ?>" value="<?php echo $pts['stage_id'] ?>" id="stagefield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" readonly >
                                                                <?php
                
                                                                echo $pts['stage_name'];
                
                
                                                                ?>
                
                                                            </td>
                
                                                            <td><input  type="hidden" name="<?php echo 'pcpart[]' ?>" id="partfield<?php echo $counter ?>" value="<?php echo $pts['part_field'] ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" /><?php echo $pts['part_field'] ?></td>
                                                            <td>
                
                
                                                                <input type="hidden" value="<?php echo $pts['component_id']; ?>" name="<?php echo 'pccomponent[]' ?>" id="componentfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" onchange="return componentval(this);" >
                                                                <?php
                                                                echo $pts['component_name'];
                                                                ?>
                                                            </td>
                                                            <td>
                
                                                                <input type="hidden" value="<?php echo $pts['supplier_id'] ?>" class="form-control" name="<?php echo 'pcsupplier_id[]' ?>" id="supplierfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' >
                                                                <?php
                                                                 echo $pts['supplier_name'];
                                                                ?>
                                                            </td>
                                                            <td><input  type="hidden" name="<?php echo 'pcuom[]' ?>" id="uomfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts['costing_uom'] ?>" class="form-control" width="5" /><?php echo $pts['costing_uom'] ?></td>
                                                            <td><input  type="hidden" name="<?php echo 'pcucost[]' ?>" id="pcinuccost<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control" value="<?php echo ($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost'])?>"  onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo  ($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']); ?></td>
                                                            <td><input  type="hidden" name="<?php echo 'pclinttotal[]' ?>"  rno ='<?php echo $counter ?>' id="linetotalfield<?php echo $counter ?>" class="form-control" value="<?php echo number_format($costing_quantity*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']), 2, '.', ''); ?>" /><?php echo number_format($costing_quantity*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']), 2, '.', ''); ?></td>
                                                            <td><input  type="hidden" name="<?php echo 'pcmargin[]' ?>" id="pcmargin<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control" value="<?php echo $pts['margin'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo $pts['margin'] ?></td>
                                                            <td><input  type="hidden" name="<?php echo 'pcmargintotal[]' ?>"  rno ='<?php echo $counter ?>' id="pcmargintotal<?php echo $counter ?>" class="form-control" value="<?php echo $pts['line_margin'];?> "/><?php echo number_format($pts['line_margin'], 2, '.', '')  ?></td>
                                                             <td><input type="hidden" name="<?php echo 'uninvoicequantity[]' ?>" id="pcuninvoicequantity<?php echo $counter ?>" value="<?php echo $uninvoicedquantity; ?>" rno ='<?php echo $counter ?>' class="form-control" /><?php echo number_format($uninvoicedquantity,2); ?></td>
                                                            <td><input disabled type="hidden" name="<?php echo 'uninvoicebudget[]' ?>" id="pcuninvoicebudget<?php echo $counter ?>" value="<?php echo $uninvoicedbudget; ?>" rno ='<?php echo $counter ?>' class="form-control" /><?php echo number_format($uninvoicedbudget, 2, '.', ''); ?></td>
                                                            <td>
                                                            <?php if($uninvoicedquantity==0){ ?>
                                                                <input type="hidden" name="<?php echo 'pcinvoicequantity[]' ?>" id="pcinvoicequantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="pc" rno ='<?php echo $counter ?>' class="form-control qty quantitychange" /><?php echo $pts['quantity']; ?>
                                                                <input type="hidden" name="<?php echo 'pcinvoiceoriginalquantity[]' ?>" id="pcinvoiceoriginalquantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="pc" rno ='<?php echo $counter ?>'/>
                                                            <?php } 
                                                            else{
                                                            ?>
                                                             <input type="number" step="any" name="<?php echo 'pcinvoicequantity[]' ?>" id="pcinvoicequantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="pc" rno ='<?php echo $counter ?>' class="form-control qty quantitychange" />
                                                             <input type="hidden" step="any" name="<?php echo 'pcinvoiceoriginalquantity[]' ?>" id="pcinvoiceoriginalquantity<?php echo $counter ?>" value="<?php echo $pts['quantity'] ?>" ty="pc" rno ='<?php echo $counter ?>'/>
                                                            <?php } ?>
                                                            </td>
                                                            <td><input disabled type="text" name="<?php echo 'pcinsubtotal[]' ?>" id="pcinsubtotal<?php echo $counter ?>" value="<?php echo number_format($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']), 2, '.', ''); ?>" rno ='<?php echo $counter ?>' class="form-control subtotalchange" readonly/></td>
                                                             <input disabled type="hidden" name="<?php echo 'pcinsubtotalmargin[]' ?>" id="pcinsubtotalmargin<?php echo $counter ?>" value="<?php  echo number_format(($pts['quantity']*$pts['costing_uc'])*(100+$pts['margin'])/100, 2, '.', ''); ?>" rno ='<?php echo $counter ?>' class="subtotalchange" readonly/>
                                                            <td><input type="text" name="<?php echo 'pcinvoicebudget[]' ?>" id="pcinvoicebudget<?php echo $counter ?>" value="<?php echo number_format($pts['invoice_amount'], 2, '.', '') ?>" rno ='<?php echo $counter ?>' ty='pc' class="form-control invoicebudget" onblur="calculateaddcost();" /></td><?php $amount_total_entered+=$pts['invoice_amount']; ?>
                                                            <td><input  type="text" name="<?php echo 'pcinvoicecostdiff[]' ?>" id="pcinvoicecostdiff<?php echo $counter ?>" value="<?php echo number_format(($pts['invoice_amount']-($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']))), 2, '.', '')?>" ty='pc' rno ='<?php echo $counter ?>' <?php if($pts['client_allowance']==0){ ?> class="form-control invoicedifference res_count  readonlyme" <?php } else{ ?>class="form-control readonlyme" <?php } ?> readonly/></td>
                                                            <?php $res_invoicecostd[$t_count] = ($pts['invoice_amount']-($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost'])));?>
                                                            <td><?php  echo get_purchare_order_no($pts['costing_part_id']);?></td>
                                                        </tr>
                                                        <?php  if($i==count($sinvoice_items_pc)){ ?>
                                                        </tbody>
                
                                                    </table>
                                                </div>
                                               <?php } ?>
                                        <?php  $i++; endforeach; ?>
                                    </div>
                                        <div id="pcrepopultediv" ></div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                   
                                    <table class="table calstable">
                                      <tbody>
                                          <tr>
                                            <td>Invoice Amount Entered <small>*</small></td>
                                            <td>$</td>
                                            <td width="160">
                                                <input class="form-control notrequired" name="invoiceamountent" id="invoiceamountent" required number="true" value="<?php echo number_format($amount_total_entered, 2, '.', '');?>">
                                            </td>
                                          </tr>
                                           <tr>
                                                <td >Amount Not Entered <small>*</small></td>
                                                <td>$</td>
                                                <td width="160"><input class="form-control notrequired" name="invoiceamountnotent" id="invoiceamountnotent" required number="true" value="<?php echo number_format($sinvoice_detail->invoice_amount-$amount_total_entered, 2, '.', ''); ?>"></td>
                                            </tr>
                                          
                                          <tr>
                                        <td colspan="2">Invoice Status <small>*</small></td>
                                        <td width="160">
                                        <select class='selectpicker notrequired <?php if ( $sinvoice_detail->status!="Pending" &&  $sinvoice_detail->status!="Approved" ) echo "readonlyme" ?>' data-style="select-with-transition" name="supplierinvoicestatus" id="supplierinvoicestatus"  title="Select Status" required>
                                            <option
                                            <?php echo ($sinvoice_detail->status!='Pending')?  ' disabled ' :  '' ?>

                                            <?php if($sinvoice_detail->status=='Pending')  echo ' selected '?> value="Pending">Pending</option>
                                        <?php
                                      if(in_array(22, $this->session->userdata("permissions"))) {
                                    ?>
                                        <option class="disableme" <?php if(trim($sinvoice_detail->invoice_amount)!=trim($amount_total_entered)){ echo ' disabled'; } ?>  <?php if($sinvoice_detail->status=='Approved')  echo 'selected'?> value="Approved">Approved</option>
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
                                            <td><label><h4><b>Total</b></h4></label></td>
                                            <td style="text-align:right;"><h4><b><span class="total"><?php echo "$".number_format(($amount_total_entered+(15/100)*$amount_total_entered), 2, '.', '');?></span></b></h4></td>
                                        </tr>
                                        <?php 
                                        
                                        $amount_due = ($amount_total_entered+(15/100)*$amount_total_entered);
                                        $total_amount = 0;
                                        
                                        $credit_notes = get_supplier_credit_notes($sinvoice_detail->id);
                                        if(count($credit_notes)>0){
                                
                                        foreach($credit_notes as $credit_note_detail){ ?>
                                        <tr>
                                            <td><h4 style="color:#ccc;"><b>Less <span style="color:#3af;">Supplier Credit</span><br/><span style="color:#777777;"><?php echo date("d F Y", strtotime(str_replace("/", "-", $credit_note_detail['date'])));?></span></b></h4></td>
                                       
                                            <td style="text-align:right;"><h4 class="total_heading"><span class="total"><?php echo "$".$credit_note_detail['amount']; ?></span></h4></td>
                                        </tr> 
                                        
                                        <?php 
                                        $amount_due = $amount_due-$credit_note_detail['amount'];
                                        }  } ?>
                                        <?php 
                                        if($sinvoice_detail->id>0){
                                        $invoice_payments = get_supplier_invoice_payments($sinvoice_detail->id);
                
                                        if(count($invoice_payments)>0){
                                            if($amount_due==""){
                                        $amount_due = $subtotal_amount;
                                        }
                                        foreach($invoice_payments as $invoice_payment){ ?>
                                    
                                        <tr>
                                            <td><h4 style="color:#ccc;"><b>Less <span style="color:#3af;">Payment</span><br/><span style="color:#777777;"><?php echo date("d F Y", strtotime(str_replace("/", "-", $invoice_payment['date'])));?></span></b></h4></td>
                                            <td style="text-align: right"><h4>$<?php echo $invoice_payment['payment']; ?></h4></td>
                                        </tr>
                                        <?php 
                                         $total_amount +=$invoice_payment['payment'];
                                         $amount_due = $amount_due-$invoice_payment['payment'];
                                         
                                        }
                                        }
                                        } ?>
                                        <tr style="border-top: 3px solid black;line-height: 30px;">
                                            <td><label><h4><b>Amount Due</b></h4></label></td>
                                            <td style="text-align:right;"><h4 class="total_heading"><b><span class="total">$<?php echo number_format($amount_due, 2, ".", ","); ?></span></b></h4></td>
                                        </tr>
                                       
                                    </table>
                            </div>
                        </div>
                            </div>
                    </div>
                        <div class="col-md-12" id="suppintot" style="<?php echo (count($sinvoice_items_ni) || $sinvoice_detail->create_variation == 1)?  "display:block":  "display:none";?>">
                            <div class="card">
                                <div class="card-content">
                                    <div class="alert alert-info" style=" display: none" id="createvariationwarn">
                                        <strong>Info!</strong> You should get prior approval from client before creating this variation, the Supplier invoice can only be created for approved variations. 
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
                                                    <textarea class="form-control notrequired" rows="5"  id="varidescriptioin" name="varidescriptioin" <?php if($sinvoice_detail->create_variation=='1'){ ?> onblur="update_variation('varidescriptioin');" <?php } ?> <?php if($sinvoice_detail->create_variation=='1')  echo 'required'?>><?php echo $sinvoice_detail->va_description?></textarea>
                                            </td>              
                                        </tr>
                                          <tr>
                                            <td>Supplier Invoice Variation Subtotal <small>*</small></td>
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
                                            <td>Supplier Invoice Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control" name="total_cost2" id="total_cost2" value="<?php $subtotal = $sinvoice_detail->va_addsi_cost*(100+$sinvoice_detail->va_ohm+$sinvoice_detail->va_pm)/100; echo number_format($subtotal,2);?>"  readonly required></td>
                                          </tr>
                                          <tr>
                                            <td>Tax <small>*</small></td>
                                            <td>%</td>
                                            <td width="160"><input class="form-control cal-on-change" name="costing_tax" id="costing_tax" value="<?php echo $sinvoice_detail->va_tax?>" required></td>
                                          </tr>
                                          <tr>
                                            <td>Supplier Invoice Variation Subtotal <small>*</small></td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="total_cost3" id="total_cost3" value="<?php echo number_format($subtotal*(100+ $sinvoice_detail->va_tax)/100,2)?>"  readonly required></td>
                                          </tr>
                                          <tr>
                                            <td >Supplier Invoice Variation Price Rounding / Profit Adjustment <small>*</small></td>
                                            <td>$</td>
                                            <td width="160"><input class="form-control  roundme" name="price_rounding" id="price_rounding" value="<?php echo $sinvoice_detail->va_round?>" required></td>
                                          </tr>
                                          <tr>
                                            <td >Supplier Invoice Variation Total <small>*</small></td>
                                            <td>$</td>
                                            <td  width="160"><input class="form-control" name="contract_price" id="contract_price" value="<?php echo $sinvoice_detail->va_total?>" required></td>
                                          </tr>
                                          <tr>
                                        <td colspan="2">Variation Status <small>*</small></td>
                                        <td width="160">

                                        <select class="selectpicker notrequired" data-style="select-with-transition" name="supplierinvoicevarstatus" id="supplierinvoicevarstatus" title="Select Status" <?php if($sinvoice_detail->create_variation=='1')  echo 'required'?>>

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
                                            <button type="submit" class="btn btn-warning btn-fill">Update Supplier Invoice</button>
                                            <?php }
                                            if( $sinvoice_detail->status=="Approved" ){ ?>
                                            <button type="submit" class="btn btn-warning btn-fill">Update Supplier Invoice Status</button>
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
                