<?php $counter = $last_row + 1; 
?>
<?php if($i==1){ ?> 
<?php $ordered_items = get_uninvoiced_purchase_orders($selected_costing_id, $selected_supplier_id, $selected_stage_id);

?>
<div class="table-responsive">
<table id="tablepo<?php echo $counter; ?>" class="table table-bordered table-striped table-hover">

          <thead>

            <tr style="height : auto" >
                <th colspan="14" style="height : auto">Ordered Items</th>
                
            </tr>
            <tr style="height : auto" >
                <th colspan="7" style="height : auto"><?= $projectname['project_title'] ?></th>
                <th colspan="2" style="height : auto;"  ><center>Uninvoiced</center></th>
                <th colspan="5" style="height : auto;"  ><center>Supplier Invoices</center></th>
                
            </tr>
            
            <tr class="headers">
                <th>PO Number</th>
                <th style="width:120px;">Stage</th>
                <th style="width:120px;">Part</th>
                <th style="width:120px;">Component</th>
                <th style="width:120px;">Supplier</th>
                <th>Unit Of Measure</th>
                <th>Unit Cost</th>
                 <th>Un- invoiced Quantity</th>
                <th>Un- invoiced Budget</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Invoice Amount</th>
                <th>Invoice cost difference</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php if(count($ordered_items)>0){ 
                
            foreach($ordered_items as $oi){
                
           
            $supplier_ordered_quantity = get_supplier_ordered_quantity($oi['costing_part_id'], "po");
           
            
            $uninvoicedquantity = $oi['order_quantity']-$supplier_ordered_quantity;
            /*echo $oi['costing_part_id'];
            echo "<br>";
            echo $uninvoicedquantity;
            echo "<br>";
            echo $supplier_ordered_quantity;
            echo "<br>";
            echo $oi['order_quantity'];*/
            
             if($uninvoicedquantity>0){  
            ?>
            <tr class="locked pocos<?php echo $counter; ?>" to_val="<?php echo $counter; ?>">
                <input type="hidden" class="si_id_pc" name="<?= 'project_cost_partpc[]' ?>" value="<?php echo  $oi['costing_part_id']; ?> ">
                <input type="hidden" name="original_quantity[]" value="<?php echo $oi['order_quantity'];?>">
                <input type="hidden" name="<?= 'pcsi_item_id[]' ?>" value="0">
                <input type="hidden" name="<?= 'pcinvoicetype[]' ?>" value="po">
                
                <td><?php echo $oi['purchase_order_id'];?></td>
                
                <td>
                 <input type="hidden" name="<?= 'pcstage[]' ?>" value="<?php echo $oi['stage_id'] ?>" id="stagefield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" >    
                <?php echo $oi['stage_name'];?></td>
                <td>
                    <input  type="hidden" name="<?= 'pcpart[]' ?>" id="partfield<?php echo $counter ?>" value="<?php echo $oi['part_name'];?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" />
                <?php echo $oi['part_name'];?></td>
                <td>
                 <input type="hidden" value=" <?php echo $oi['component_id'];?>" name="<?= 'pccomponent[]' ?>" id="componentfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control readonlyme" onchange="return componentval(this);" >   
                <?php echo $oi['component_name'];?></td>
                <td>
                     <input type="hidden" value="<?php if($oi['supplier_id']==0){ echo $oi['po_supplier_id']; } else{ echo $oi['supplier_id']; }?>" class="form-control" name="<?= 'pcsupplier_id[]' ?>" id="supplierfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' >
                <?php if($oi['supplier_name']==""){ echo $oi['po_supplier_name']; } else{ echo $oi['supplier_name']; }?></td>
                <td><input  type="hidden" name="<?= 'pcuom[]' ?>" id="pouomfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $oi['costing_uom'] ?>" class="form-control" width="5" /><?php echo $oi['costing_uom'];?></td>
                 <td>
                     <input  type="hidden" name="<?= 'pclinttotal[]' ?>"  rno ='<?php echo $counter ?>' id="polinetotalfield<?php echo $counter ?>" class="form-control" value="<?php echo $oi['line_margin'];  ?>" />
                     
                   
                     <input  type="hidden" name="<?= 'pcucost[]' ?>" id="poinuccost<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="form-control" value="<?php echo $oi['costing_uc'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                     <?php echo $oi['costing_uc'];?></td>
                <td>
                 <input type="hidden" name="<?= 'uninvoicequantity[]' ?>" id="pouninvoicequantity<?php echo $counter ?>" value="<?php echo $oi['order_quantity']-$supplier_ordered_quantity;?>" rno ='<?php echo $counter ?>' class="form-control" />   
                <?php echo $oi['order_quantity']-$supplier_ordered_quantity;?></td>
               
                <td><?php if(($oi['order_quantity']-$supplier_ordered_quantity)==0){ echo "0.00"; } else{ echo number_format((($oi['order_quantity']-$supplier_ordered_quantity)*$oi['costing_uc']), 2, ".", ""); }?></td>
                 <td><input <?php if(($oi['order_quantity']-$supplier_ordered_quantity)==0){?> readonly <?php } ?> type="number" step="any" name="<?= 'pcinvoicequantity[]' ?>" id="poinvoicequantity<?php echo $counter ?>" value="<?php echo '0' ?>" ty="po" rno ='<?php echo $counter ?>' <?php if($oi['client_allowance']==0){ ?> class="form-control qty quantitychange" <?php } else{ ?>class="form-control" <?php } ?>/></td>
                <td><input disabled type="text" name="<?= 'pcinsubtotal[]' ?>" id="poinsubtotal<?php echo $counter ?>" value="<?php echo "0.00"; ?>" rno ='<?php echo $counter ?>'  class="form-control subtotalchange" readonly/></td>
                    
                    <input type="hidden" name="<?= 'pcinsubtotalmargin[]' ?>" id="poinsubtotalmargin<?php echo $counter ?>" value="<?php echo "0.00"; ?>" rno ='<?php echo $counter ?>' class="subtotalchange" readonly/>
                    <input  type="hidden" name="<?= 'pcmargin[]' ?>" id="pomargin<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $oi['costing_margin'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                    <input  type="hidden" name="<?= 'pcmargintotal[]' ?>"  rno ='<?php echo $counter ?>' id="pomargintotal<?php echo $counter ?>" value="<?php echo ($oi['order_quantity']*$oi['costing_uc'])*((100+$oi['costing_margin'])/100)  ?>" />
                    <td><input <?php if(($oi['order_quantity']-$supplier_ordered_quantity)==0){?> readonly <?php } ?> type="text" name="<?= 'pcinvoicebudget[]' ?>" id="poinvoicebudget<?php echo $counter ?>" value="<?php echo "0.00"; ?>" rno ='<?php echo $counter ?>' ty='po'  <?php if($oi['client_allowance']==0){ ?> onblur="calculateaddcost();" class="form-control invoicebudget poinvoicebudget" <?php } else{ ?>class="form-control invoicebudget" <?php } ?>/></td>
                    
                    <td><input  <?php if(($oi['order_quantity']-$supplier_ordered_quantity)==0){?> readonly <?php } ?> type="text" name="<?= 'pcinvoicecostdiff[]' ?>" id="poinvoicecostdiff<?php echo $counter ?>" rno ='<?php echo $counter ?>' readonly <?php if($oi['client_allowance']==1){ ?> value="allowance" class="form-control readonlyme" <?php } else{ ?>value="<?php echo "0.00"; ?>" class="form-control invoicedifference readonlyme" <?php } ?>/></td>
                    
                    
                    
                    <td> <a  class="btn btn-sm btn-danger remove" tabletype="pocos" type="button" onclick="$('.pocos<?php echo $counter; ?>').remove();calculate()"><i class="fa fa-times-circle-o"></i> Remove this </a></td>
            </tr>
            <?php 
            $counter++;
             }
            } 
            }
            else{
            ?>
            <tr><td colspan="14" style="height : auto">No Items Found</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
    <?php $counter = $last_row + 1; ?>
<div class="panel panel-default table-respcnsive">

    <div class="table-responsive" >





        <table id="tablepc<?php echo $counter; ?>" class="table table-bordered table-striped table-hover">

          <thead>
           <tr style="height : auto" >
                <th colspan="15" style="height : auto">Unordered Items</th>
                
            </tr>
            <tr style="height : auto" >
                <th colspan="6" style="height : auto"><?= $projectname['project_title'] ?></th>
                <th colspan="2" style="height : auto;"  ><center>Uninvoiced</center></th>
                <th colspan="4" style="height : auto"><center>Supplier Invoices</center></th>  
                <!--<th style="height : auto">Purchase Orders</th>-->  
                <th style="height : auto"></th> 
            </tr>
            <tr class="headers">
                <!--<th>Origin</th>-->
                <th style="width:120px;">Stage</th>
                <th style="width:120px;">Part</th>
                <th style="width:120px;">Component</th>
                <th style="width:120px;">Supplier</th>
                <!--<th>QTY</th>-->
                <th>Unit Of Measure</th>
                <th>Unit Cost</th>
                <!--<th>Line Total</th>
                <th>Margin %</th>
                <th>Line Total with Margin</th>-->
                <th>Un- invoiced Quantity</th>
                <th>Un- invoiced Budget</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <!--<th>Subtotal with margin</th>-->
                <th>Invoice Amount</th>
                <th>Invoice cost difference</th>
                <!--<th>Purchase Order Number</th>-->
                <th>Action</th>

            </tr>
        </thead>
        
        <tbody>
            <?php }?>
            <?php 
//echo "<pre>";print_r($costing_part_details);exit;
            $pts = $costing_part_details;
            $counter = $j;
            $invoicedquantity = $pts->invoicedquantity;
            $recent_quantity = get_recent_quantity($costing_part_details->costing_part_id, $costing_part_details->costing_supplier);
            $supplier_ordered_quantity = get_supplier_ordered_quantity($costing_part_details->costing_part_id, "pc");
            $invoicedquantity = $supplier_ordered_quantity;
            $purchase_ordered_quantity = get_purchase_ordered_items_quantity($costing_part_details->costing_part_id);
            if(count($recent_quantity)>0){
              if($pts->costing_type=="normal"){
               $uninvoicedquantity = (($pts->costing_quantity+$recent_quantity['total']) - $invoicedquantity)-$purchase_ordered_quantity;
               $costing_quantity = ($pts->costing_quantity+$recent_quantity['total']);
              }
              else{
                  if($recent_quantity['updated_quantity']==0){
                  $uninvoicedquantity = ($recent_quantity['total'] - $invoicedquantity)-$purchase_ordered_quantity;
                  $costing_quantity = $recent_quantity['total'];
                  }
                  else{
                    $uninvoicedquantity = ($recent_quantity['updated_quantity'] - $invoicedquantity)-$purchase_ordered_quantity;
                    $costing_quantity = $recent_quantity['updated_quantity'];
                  }
              }
            }
            else{
               $uninvoicedquantity = ($pts->costing_quantity - $invoicedquantity)-$purchase_ordered_quantity;
                $costing_quantity = $pts->costing_quantity;
            }
            
            if((($uninvoicedquantity)>0 && $pts->client_allowance==0) || ($pts->client_allowance==1)){
                
            //if(($uninvoicedquantity)>0){
            ?>

            <tr id="tablepc<?php echo $counter; ?>trnumber<?php echo $counter ?>" class="locked prcos<?php echo $counter; ?>" ta_val="<?php echo $counter; ?>" tr_val="<?php echo $counter ?>">
                <input type="hidden" class="si_id_pc" name="<?= 'project_cost_partpc[]' ?>" value="<?= $costing_part_details->costing_part_id ?> ">
                <input type="hidden" name="original_quantity[]" value="<?php echo $costing_quantity;?>">
                <input type="hidden" name="<?= 'pcsi_item_id[]' ?>" value="0">
                <input type="hidden" name="<?= 'pcinvoicetype[]' ?>" value="pc">
                <!--<td>
                <?php /*if($costing_part_details->is_variated ==0){ echo "Project costing part # $costing_part_details->costing_part_id ";} else{ 
                    if($costing_part_details->var_number==""){

                        $var_no = 10000000+$costing_part_details->is_variated;
                        
                    }
                    else{
                        $var_no = $costing_part_details->var_number;
                    }
                    echo "Variation # ".($var_no);}*/?></td>-->
                    <td>
                        <input type="hidden" name="<?= 'pcstage[]' ?>" value="<?php echo $pts->stage_id ?>" id="stagefield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="readonlyme" readonly >
                        <?php
                        foreach ($stages as $stage) {
                            if ($pts->stage_id == $stage["stage_id"]) {
                                echo $stage["stage_name"];
                            }
                        }
                        ?>

                    </td>

                    <td><input  type="hidden" name="<?= 'pcpart[]' ?>" id="partfield<?php echo $counter ?>" value="<?php echo $pts->costing_part_name ?>" rno ='<?php echo $counter ?>' class="readonlyme" /><?php echo $pts->costing_part_name ?></td>
                    <td>


                        <input type="hidden" value="<?php echo $pts->component_id; ?>" name="<?= 'pccomponent[]' ?>" id="componentfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="readonlyme" onchange="return componentval(this);" >
                        <?php
                        foreach ($component as $c) {
                            if ($pts->component_id == $c["component_id"]) {
                                echo $c["component_name"];
                            }
                        }
                        ?>
                    </td>
                    <td>

                        <input type="hidden" value="<?php echo $pts->costing_supplier ?>" name="<?= 'pcsupplier_id[]' ?>" id="supplierfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' >
                        <?php
                        foreach ($suppliers as $supplier) {
                            if ($pts->costing_supplier == $supplier["supplier_id"]) {
                                echo $supplier["supplier_name"];
                            }
                        }
                        ?>
                    </td>
                    <input  type="hidden"  name="<?= 'pcorderqty[]' ?>" rno ='<?php echo $counter ?>' id="pcorderqty<?php echo $counter ?>" class="qty" value="<?php echo $ordered_quantity ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                    <input  type="hidden"  name="<?= 'supplierorderqty[]' ?>" rno ='<?php echo $counter ?>' id="supplierorderqty<?php echo $counter ?>" class="qty" value="<?php echo $supplier_ordered_quantity; ?>"/>
                   <!-- <td>
                        <div class="manualfield" id="manualfield<?php echo $counter ?>">
                            
                        </div>
                        <?php //echo ($pts->costing_quantity+$updated_quantity['total']) - $ordered_quantity; ?>
                        
                    </td>-->

                    <td><input  type="hidden" name="<?= 'pcuom[]' ?>" id="uomfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts->costing_uom ?>" width="5" /><?php echo $pts->costing_uom ?></td>
                    
                    <td><input  type="hidden" name="<?= 'pcucost[]' ?>" id="pcinuccost<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts->costing_uc ?>" onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo number_format($pts->costing_uc, 2, '.', ''); ?></td>
                    <input  type="hidden" name="<?= 'pclinttotal[]' ?>"  rno ='<?php echo $counter ?>' id="linetotalfield<?php echo $counter ?>" value="<?php echo ($costing_quantity - $ordered_quantity)*$pts->costing_uc  ?>" />
                    <!--<td><?php //echo number_format((($pts->costing_quantity+$updated_quantity['total']) - $ordered_quantity)*$pts->costing_uc, 2, '.', ''); ?></td>-->
                    <input  type="hidden" name="<?= 'pcmargin[]' ?>" id="pcmargin<?php echo $counter ?>" rno ='<?php echo $counter ?>' value="<?php echo $pts->margin ?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                    <!--<td><?php echo $pts->margin ?></td>-->
                    <input  type="hidden" name="<?= 'pcmargintotal[]' ?>"  rno ='<?php echo $counter ?>' id="pcmargintotal<?php echo $counter ?>" value="<?php echo (($costing_quantity - $ordered_quantity)*$pts->costing_uc)*((100+$pts->margin)/100)  ?>" />
                    <!--<td><?php //echo number_format(((($pts->costing_quantity+$updated_quantity['total']) - $ordered_quantity)*$pts->costing_uc)*((100+$pts->margin)/100), 2, '.', ''); ?></td>-->
                    
                    <td><input type="hidden" name="<?= 'uninvoicequantity[]' ?>" id="pcuninvoicequantity<?php echo $counter ?>" value="<?php echo $uninvoicedquantity; ?>" rno ='<?php echo $counter ?>'/><?php echo $uninvoicedquantity; ?></td>
                    
                    <td><input disabled type="hidden" name="<?= 'uninvoicebudget[]' ?>" id="pcuninvoicebudget<?php echo $counter ?>" value="<?php echo $pts->uninvoicebudget; ?>" rno ='<?php echo $counter ?>'/><?php echo number_format($pts->costing_uc*($uninvoicedquantity), 2, '.', ''); ?></td>
                   
                    <td><input type="number" step="any" name="<?= 'pcinvoicequantity[]' ?>" id="pcinvoicequantity<?php echo $counter ?>" value="<?php echo '0' ?>" ty="pc" rno ='<?php echo $counter ?>' <?php if($pts->client_allowance==0){ ?> class="form-control qty quantitychange" <?php } else{ ?>class="form-control" <?php } ?>/></td>
                    
                    <td><input disabled type="text" name="<?= 'pcinsubtotal[]' ?>" id="pcinsubtotal<?php echo $counter ?>" value="<?php echo "0.00"; ?>" rno ='<?php echo $counter ?>'  class="form-control subtotalchange" readonly/></td>
                    <!--<td><input disabled type="text" name="<?= 'pcinsubtotalmargin[]' ?>" id="pcinsubtotalmargin<?php echo $counter ?>" value="<?php echo "0.00"; ?>" rno ='<?php echo $counter ?>' class="form-control subtotalchange" readonly/></td>-->
                    <input disabled type="hidden" name="<?= 'pcinsubtotalmargin[]' ?>" id="pcinsubtotalmargin<?php echo $counter ?>" value="<?php echo "0.00"; ?>" rno ='<?php echo $counter ?>' class="subtotalchange" readonly/>
                    
                    <td><input type="text" name="<?= 'pcinvoicebudget[]' ?>" id="pcinvoicebudget<?php echo $counter ?>" value="<?php echo "0.00"; ?>" rno ='<?php echo $counter ?>' ty='pc'  <?php if($pts->client_allowance==0){ ?> onblur="calculateaddcost();" class="form-control invoicebudget pcinvoicebudget" <?php } else{ ?>class="form-control allowancebudget" <?php } ?>/></td>
                    
                    <td><input  type="text" name="<?= 'pcinvoicecostdiff[]' ?>" id="pcinvoicecostdiff<?php echo $counter ?>" rno ='<?php echo $counter ?>' readonly <?php if($pts->client_allowance==1){ ?> value="allowance" class="form-control readonlyme" <?php } else{ ?>value="<?php echo "0.00"; ?>" class="form-control  invoicedifference readonlyme" <?php } ?>/></td>
                    
                    <!--<td><?php //echo get_purchare_order_no($pts->costing_part_id);?></td>-->
                    
                    <td> <a  class="btn btn-sm btn-danger remove" tabletype="prcos" type="button" onclick="$('.prcos<?php echo $counter; ?>').remove();calculate()"><i class="fa fa-times-circle-o"></i> Remove this </a></td>
                </tr>
                <?php  $counter++;} ?>
                <?php if($i==$no_of_rows){ ?>
            </tbody>
        </table>
    </div>

</div>
<?php } ?>

