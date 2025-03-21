<?php $counter = 1; 
?>
    <div class="table-responsive" >
        <table id="tablepc" class="table table-no-bordered templates_table">
                                        <thead>

                                        <tr style="height : auto" >
                                            <th colspan="9" style="height : auto"></th>
                                        </tr>
                                        <tr class="headers">
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
                                        <?php 
                                        $amount_total_entered =0;
                                        foreach($sinvoice_items_pc as $sinvoice_item_pc){ ?>
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
                                            <input type="hidden" name="<?= 'pcinvoiceitemid[]' ?>" value="<?php echo $pts['id'];?>">
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


                                                <input type="hidden" value="<?php echo $pts['component_id']; ?>" name="<?php echo 'pccomponent[]' ?>" id="componentfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' class="readonlyme" onchange="return componentval(this);" >
                                                <?php
                                                echo $pts['component_name'];
                                                ?>
                                                <input type="hidden" value="<?php echo $pts['supplier_id'] ?>" disabled class="" name="<?php echo 'pcsupplier_id[]' ?>" id="supplierfield<?php echo $counter ?>" rno ='<?php echo $counter ?>' >
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
                                            <td><?php echo number_format($pts['invoice_amount'], 2, '.', '') ?><input type="hidden" name="<?php echo 'pcinvoicebudget[]' ?>" id="pcinvoicebudget<?php echo $counter ?>" value="<?php echo number_format($pts['invoice_amount'], 2, '.', '') ?>" rno ='<?php echo $counter ?>' ty='pc'/></td><?php $amount_total_entered+=$pts['invoice_amount']; ?>
                                            <input  type="hidden" name="<?php echo 'pcinvoicecostdiff[]' ?>" id="pcinvoicecostdiff<?php echo $counter ?>" value="<?php echo number_format(($pts['invoice_amount']-($pts['quantity']*($pts['unit_cost']=="" ? $pts['costing_uc'] : $pts['unit_cost']))), 2, '.', '')?>" rno ='<?php echo $counter ?>' <?php if($pts['client_allowance']==0){ ?> class="res_count  readonlyme" <?php } else{ ?>class="readonlyme" <?php } ?> readonly/></td>
                                    
                                            <td><input type="number" name="pcsuppliercreditquantity[]" id="pcsuppliercreditquantity<?php echo $counter ?>" value="0" rno ='<?php echo $counter ?>' ty='pc' class="form-control quantitychange" /></td>
                                            <td><input type="text" name="pcsuppliercreditamount[]" id="pcsuppliercreditamount<?php echo $counter ?>" value="0.00" rno ='<?php echo $counter ?>' ty='pc' class="form-control invoicebudget" /></td>
                                           
                                        </tr>
                                        <?php  $counter++; } ?>
                                        </tbody>

                                    </table>
                                </div>
