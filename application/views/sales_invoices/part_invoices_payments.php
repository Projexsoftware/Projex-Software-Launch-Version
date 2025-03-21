<?php
$totaldiff=0;
$total_invoice_amount=0;
$total_invoice_payment = 0;
$total_owing_amount = 0;
$balance1 = $allowance_balance;
foreach ($prjprts AS $key => $val):

  $credit_notes_total = 0;
  if(count($val->sales_invoice_item)>0){
 $invoiceType = check_invoice_type($val->sales_invoice_item[0]->sale_invoice_id);
       $credit_notes = get_sales_credit_notes($val->sales_invoice_item[0]->sale_invoice_id, $invoiceType);
                                    
                        foreach($credit_notes as $credit_note_detail){ 
                             if($invoiceType!="CN-"){
                                $credit_notes_total = (-1)*$credit_note_detail['total'];
                            }
                            else{
                            $credit_notes_total +=$credit_note_detail['total'];
                            }
                            
                        }
}
$allocated_invoices = get_allocated_allowance_invoices($val->costing_part_id);
$allocated_allowances_table = "";
if(count($allocated_invoices)>0){
$allocated_allowances_table = "<table class='table'><thead><tr><th><center>Stage</center></th><th><center>Part</center></th><th><center>Component</center></th><th><center>Supplier</center></th><th><center>Amount</center></th></tr></thead><tbody>";
 foreach($allocated_invoices as $allocated_invoice){
 $allocated_allowances_table .="<tr><td>".$allocated_invoice['stage_name']."</td><td>".$allocated_invoice['part_field']."</td><td>".$allocated_invoice['component_name']."</td><td>".$allocated_invoice['supplier_name']."</td><td>$".number_format($allocated_invoice['invoice_amount'], 2, ".", ",")."</td></tr>";
 }
 $allocated_allowances_table .= "</tbody></table>";
}
?>
    <tr>
        <td>
            <?php

            foreach ($component as $ket => $vat) {

                if($vat["component_id"] == $val->component_id )
                {echo $vat["component_name"]; }
            }
            ?>
        </td>
        <td><?php
            if(count($val->sales_invoice_item)){
                if($val->sales_invoice_item[0]->invoice_number == 0){
                    echo 1000000+$val->sales_invoice_item[0]->sale_invoice_id;
                }
                else{
                    echo 2000000+$val->sales_invoice_item[0]->sale_invoice_id;
                }
            }
            else{
                echo 'Not created yet';
            }
            ?>

        </td>
        <td class="text-right"><?php
            if(count($val->sales_invoice_item)==0){
            ?>
            <div class="checkbox" style="width:auto">
                <label>
                    <input type="checkbox" class="invoice_amount_checkbox" id="<?php echo $val->costing_part_id;?>" <?php if($val->invoice_amount_checkbox==1){?> checked <?php } ?>>
                </label>
             </div>
             <?php 
             $invoice_amount = 0;
             if($val->invoice_amount_checkbox==1){
                 $invoice_amount = $val->amount_before_creating_invoice;
            } 
                echo '$'.number_format($invoice_amount, 2, ".", ",");
            }
            else{
                echo number_format((($tax/100)*$val->sales_invoice_item[0]->part_invoice_amount)+$val->sales_invoice_item[0]->part_invoice_amount, 2, '.', ',');
                $invoice_amount = number_format((($tax/100)*$val->sales_invoice_item[0]->part_invoice_amount)+$val->sales_invoice_item[0]->part_invoice_amount, 2, '.', '');
            }
            $total_invoice_amount +=$invoice_amount;
            
            ?>

        </td>
        <td>


            <?php
            
            $allowance_cost = ($val->line_margin)+($val->line_margin*($tax/100));
            
            $diff=(($val->invoiced_amount)+($val->invoiced_amount*($tax/100))) - $allowance_cost;
            if ($diff!=0) {
                //if ($val->invoiced_amount - $val->line_margin < 0){ 
                ?>
                    <!--<button class="btn btn-warning">No payment needed</button>-->
                <?php
                //}
                
                //else{

                    if(count($val->sales_invoice_item)==0) {
                        if(in_array(32, $this->session->userdata("permissions"))) {
                        $formname='creatinvoice';
                        $submitvalue='Create ';
                        $btnclass='success';
                        }
                    }
                     else { 
                           if(in_array(33, $this->session->userdata("permissions"))) {
                            $formname='viewsalesinvoice/'.$val->sales_invoice_item[0]->sale_invoice_id;
                            $submitvalue='Update';
                            $btnclass='info';
                           }

                        } 
                        ?>

                    <form id="formapd<?=$key.$formname?>" action="<?php echo base_url()?>sales_invoices/<?= $formname?>" method="post">

                        <?php if($formname!='creatinvoice'){ ?>
                            <input type="hidden" name="payment" value="<?= $val->sales_invoice_item[0]->payment; ?>" form="formapd<?=$key.$formname?>"/>
                            <input type="hidden" name="sale_invoice_id" value="<?= $val->sales_invoice_item[0]->sale_invoice_id; ?>" form="formapd<?=$key.$formname?>"/>
                            <input type="hidden" name="sale_invoice_item_id" value="<?= $val->sales_invoice_item[0]->id; ?>" form="formapd<?=$key.$formname?>"/>
                        <?php } ?>
                        <input type="hidden" name="partname" value="<?= $val->costing_part_name; ?>" form="formapd<?=$key.$formname?>"/>

                        <?php if($formname=='receiptsaleinvoiceitem'){ ?>
                            <input type="hidden" name="work" value="C" form="formapd<?=$key.$formname?>"/>
                        <?php  } ?>
                        <input type="hidden" name="description" value="<?php

                        foreach ($component as $ket => $vat) {

                            if($vat["component_id"] == $val->component_id )
                            {echo $vat["component_name"]; }
                        }
                        ?>" form="formapd<?=$key.$formname?>"/>
                        <input type="hidden" name="type" value="apd" form="formapd<?=$key.$formname?>"/>

                        <?php if($formname=='receiptsaleinvoiceitem'){ ?>


                            <input type="hidden" name="invoice_amount" value="<?= $val->sales_invoice_item[0]->part_invoice_amount ?>" form="formapd<?=$key.$formname?>"/>
                        <?php } else { ?>

                            <input type="hidden" name="invoice_amount" value="<?= $val->invoiced_amount - $val->line_margin ?>" form="formapd<?=$key.$formname?>"/>
                        <?php   } ?>
                        <input type="hidden" name="type_id" value="<?=$val->costing_part_id?>" form="formapd<?=$key.$formname?>"/>
                        
                        <?php
                            if(in_array(32, $this->session->userdata("permissions")) && $submitvalue=="Create ") {
                        ?>
                        <input type="submit" value="<?=$submitvalue?> Invoice" class="btn btn-<?=$btnclass?>" form="formapd<?=$key.$formname?>"/>
                        <?php }
                        
                        if(in_array(33, $this->session->userdata("permissions")) && $submitvalue=="Update") {
                                    ?>
                        <input type="submit" value="<?=$submitvalue?> Invoice" class="btn btn-<?=$btnclass?>" form="formapd<?=$key.$formname?>"/>   
                        <?php } ?>
                    </form>

                    <?php
                }
            //}
            else {
               
                    ?>
                    <button class="btn btn-warning">No payment needed</button>
                    <?php
            }
            ?>
        </td>
        <td class="text-right">$<?php
       
            if(!count($val->sales_invoice_item)){
                
                echo '0.00';
                $invoice_payment = 0+(-1)*$credit_notes_total;
            }
            else{
                if($val->sales_invoice_item[0]->part_invoice_amount<0){
                $sales_invoice_payment = $val->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                echo number_format(($sales_invoice_payment+($sales_invoice_payment*($tax/100))), 2, '.', ',');
                $invoice_payment = ($val->sales_invoice_item[0]->payment+$credit_notes_total)+(($val->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));
                }
                else{
                    $sales_invoice_payment = $val->sales_invoice_item[0]->payment+(-1)*$credit_notes_total;
                   /*echo number_format(($sales_invoice_payment+($sales_invoice_payment*($tax/100))), 2, '.', '');
                    $invoice_payment = ($val->sales_invoice_item[0]->payment+$credit_notes_total)+(($val->sales_invoice_item[0]->payment+$credit_notes_total)*($tax/100));*/
                    
                    echo number_format($sales_invoice_payment, 2, '.', ',');
                    $invoice_payment = number_format($sales_invoice_payment, 2, '.', '');
                    
                }
            }
            $total_invoice_payment +=$invoice_payment;
            ?>

        </td>
        <td class="text-right">
        <?php 
        $owing_amount = $invoice_amount - $invoice_payment;?>
        $<?php echo number_format($owing_amount, 2, '.', ',') ?>
        </td>
        <?php
            $balance1+=$invoice_amount;
            $total_owing_amount +=$owing_amount;
        ?>
        <td class="text-right">$<?= number_format($balance1, 2, '.', ',') ?></td>
    </tr>
<?php endforeach; ?>

<tr class="imth">
    <th colspan="2"  >TOTAL ALLOWANCE ADJUSTMENTS</th>
    <th class="text-right" colspan="1" ><?php
        echo "$".number_format(abs($total_invoice_amount),2, '.', ',');
        ?></th>
    <th colspan="1" ></th>
    <th class="text-right" colspan="1" ><?php
        echo "$".number_format(abs($total_invoice_payment),2, '.', ',');
        ?></th>
    <th class="text-right" colspan="1" ><?php
        echo "$".number_format(abs($total_owing_amount),2, '.', ',');
        ?></th>
    <th class="text-right" >$<span id="allowancebalance" ><?= number_format($balance1, 2, '.', ',') ?>  <?php $this->load->library('session'); $this->session->set_userdata('balanceaapd', $balance1); ?> </span>  </th>

    <input  type='hidden' id='tallowance' value='<?=  $totaldiff ?>'  />
</tr>