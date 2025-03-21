<?php
$totalvars=0;
$balance=0;
$total_invoice_amount = 0;
$total_invoice_paid = 0;
$total_invoice_owing = 0;
$i=0;
foreach ($prjprts AS $key => $val): $last_row++;
$credit_notes_total = 0;
    if(count($val->sales_invoices_items)>0){
       $invoiceType = check_invoice_type($val->sales_invoices_items[0]->sale_invoice_id);
       $credit_notes = get_sales_credit_notes($val->sales_invoices_items[0]->sale_invoice_id, $invoiceType);
                                    
                        foreach($credit_notes as $credit_note_detail){ 
                             if($invoiceType!="CN-"){
                                $credit_notes_total = (-1)*$credit_note_detail['total'];
                            }
                            else{
                            $credit_notes_total +=$credit_note_detail['total'];
                            }
                            
                        }
    }

    ?>
    <tr id="trnumber<?= $last_row?>" tr_val='<?= $last_row?>'>
        <?php

        if(!count($val->sales_invoices_items)) {
            if(in_array(32, $this->session->userdata("permissions"))) {
            $formname='creatinvoice';
            $submitvalue='Create';
            $btnclass='success';
            }
        }
        else{ 
            if(in_array(33, $this->session->userdata("permissions"))) {
            $formname='viewsalesinvoice/'.$val->sales_invoices_items[0]->sale_invoice_id;
            $submitvalue='Update';
            $btnclass='info';
            }

        } 
         ?>

        <td>
            <?php if($type==2):?>
                <span id="" class="R<?=$key+$last_row?>"><?= (isset($val->description))?  $val->description :  '' ; ?></span>
            <?php endif;?>
            <?php if($type==1):?>
                <input type="hidden" name="payment_project_id" form="formtemppayment" value="<?php echo $project_id;?>">
                <input  class="W<?=$key+$last_row?> form-control new" name="description[]" placeholder="Payment Description" value="<?= (isset($val->description))?  $val->description :  '' ; ?>" form="formtemppayment" required>
            <?php endif;?>
        </td>
        <td class="text-right">
            <?php if($type==2):?>
                <span >$<?= (isset($val->invoice_amount))?  number_format($val->invoice_amount, 2, '.', ',') :  '' ; ?></span>
            <?php endif;?>
            <?php if($type==1):?>
                <input  class="form-control"  placeholder="Invoice amount" name="invoice_amount[]" value="<?= (isset($val->invoice_amount))?  number_format($val->invoice_amount, 2, '.', '') :  '' ; ?>" form="formtemppayment" required />
            <?php endif;?>

        </td>
       
        <td><?php
            if(count($val->sales_invoices_items)){
                    if($val->sales_invoices_items[0]->invoice_number == 0){
                        echo 1000000+$val->sales_invoices_items[0]->sale_invoice_id;
                    }
                    else{
                        echo 2000000+$val->sales_invoices_items[0]->sale_invoice_id;
                    }
                }
                else{
                   echo 'Not created';
                }
            ?>

        </td>
        <td class="text-right">$<?php
            if(!count($val->sales_invoices_items)){
                echo '0.00';
                $invoice_amount = 0;
            }
            else{
                echo number_format($val->sales_invoices_items[0]->part_invoice_amount, 2, '.', ',');
                $invoice_amount = $val->sales_invoices_items[0]->part_invoice_amount;
            }
            $total_invoice_amount +=$invoice_amount;
            ?>

        </td>
        <td>

            <?php if($type==2):?>
            <form id="formpay<?=$key+$last_row.$formname?>" action="<?php echo SURL;?>sales_invoices/<?= $formname?>" method="post">
                <input type="hidden" name="type" value="pay" form="formpay<?=$key+$last_row.$formname?>"/>
                <?php if($formname!='creatinvoice'){
                    ?>
                    <input type="hidden" name="payment" value="<?= $val->sales_invoices_items[0]->payment; ?>" form="formpay<?=$key+$last_row.$formname?>"/>
                    <input type="hidden" name="sale_invoice_id" value="<?= $val->sales_invoices_items[0]->sale_invoice_id; ?>" form="formpay<?=$key+$last_row.$formname?>"/>
                    <input type="hidden" name="sale_invoice_item_id" value="<?= $val->sales_invoices_items[0]->id; ?>" form="formpay<?=$key+$last_row.$formname?>"/>
                <?php } ?>
                <?php if($formname=='receiptsaleinvoiceitem'){
                    ?>
                    <input type="hidden" name="work" value="C" form="formpay<?=$key+$last_row.$formname?>"/>
                <?php  } ?>
                <?php if($formname=='receiptsaleinvoiceitem'){
                    ?>


                    <input type="hidden" name="invoice_amount" value="<?= $val->sales_invoices_items[0]->part_invoice_amount  ?>" form="formpay<?=$key+$last_row.$formname?>"/>
                <?php } else { ?>

                    <input type="hidden" name="invoice_amount" value="<?= $val->invoice_amount ?>" form="formpay<?=$key+$last_row.$formname?>"/>
                <?php   } ?>
                <input type="hidden" name="type_id" value="<?=$val->payment_id?>" form="formpay<?=$key+$last_row.$formname?>"/>
                
                <?php
                    if(in_array(32, $this->session->userdata("permissions")) && $submitvalue=="Create") {
                ?>
                    <input type="submit" value="<?=$submitvalue?> Invoice" class="btn btn-<?=$btnclass?>" form="formpay<?=$key+$last_row.$formname?>"/>
                <?php }
                        
                if(in_array(33, $this->session->userdata("permissions")) && $submitvalue=="Update") {
                                    ?>
                   <input type="submit" value="<?=$submitvalue?> Invoice" class="btn btn-<?=$btnclass?>" form="formpay<?=$key+$last_row.$formname?>"/> 
                <?php } ?>
                
                <?php endif;?>
                <?php if($type==1) {
                    echo "<span class='label label-warning'>Save Payment First</span>";?>
                <?php } ?>
                <?php if($type==1 ||  ($type==2 && !count($val->sales_invoices_items) ) || ($val->sales_invoices_items[0]->status == "PENDING")  ) {
                    
                    if($type == 1){?>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-success btn-sm btn-save-payment"><i class="material-icons">done</i> Save</a>
                   <?php } ?>
                    
                    <a href="javascript:void(0)" tr_val="<?=$last_row ?>" class="btn btn-simple btn-danger btn-icon deletepaymentrow" id="<?php if(isset($val->payment_id)){ echo $val->payment_id;} else{ echo $last_row; }?>"><i class="material-icons">delete</i></a>
                <?php }  ?>
        </td>
        <td class="text-right">

            $<?php
            if(!count($val->sales_invoices_items)){
                $invoice_payment = 0+$credit_notes_total;
                echo number_format($invoice_payment,2,'.',',');
            }
            else{
                echo number_format($val->sales_invoices_items[0]->payment+$credit_notes_total, 2, '.', ',');
                $invoice_payment = $val->sales_invoices_items[0]->payment+$credit_notes_total;
            }
            $total_invoice_paid +=$invoice_payment;
            ?>

        </td>
        <td class="text-right">
            <?php $part_invoice_amount= $invoice_amount - $invoice_payment;?>
            $<?php echo number_format($part_invoice_amount, 2, '.', ','); 
            $total_invoice_owing +=$part_invoice_amount;
            ?>
        </td>
        <td class="text-right">
            <?php
                $balance = $balance - $invoice_payment;
            
            ?>
            $<?= number_format($balance, 2, '.', ',') ?>
        </td>
        </form>

    </tr>
<?php  endforeach; ?>
<?php if($type!=1):?>
    <tr class="allowancesRow" id="trnumber<?= $last_row+1?>" tr_val='<?= $last_row+1?>'>
        <td>
           Allowances (Allowances paid to date)
        </td>
        <td class="text-right">
                <span >$<?php if(isset($total_invoice_amount_allowances)){ echo number_format($total_invoice_amount_allowances,2,".",","); } else{ echo "0.00"; } ?></span>
        </td>
       
        <td>
       Various
        </td>
        <td class="text-right">$<?php if(isset($total_invoice_amount_allowances)){ echo number_format($total_invoice_amount_allowances,2,".",","); } else{ echo "0.00"; } ?>

        </td>
        <td>
        -
        </td>
        <td class="text-right">

            $<?php if(isset($total_invoice_amount_paid_allowances)){ echo number_format($total_invoice_amount_paid_allowances,2,".",","); } else{ echo "0.00"; } ?>

        </td>
        <td class="text-right">
           $<?php if(isset($total_invoice_amount_owing_allowances)){ echo number_format($total_invoice_amount_owing_allowances,2,".",","); } else{ echo "0.00"; } ?>
        </td>
        <td class="text-right">
           <?php 
           if(isset($total_invoice_amount_paid_allowances)){  $calculated_balance = number_format($total_invoice_amount_paid_allowances,2,".",""); } else{ $calculated_balance = "0.00"; }
           $balance -= $calculated_balance;
           ?>
           $<?= number_format($balance, 2, '.', ',') ?>
        </td>

    </tr>
    <tr id="trnumber<?= $last_row+2?>" tr_val='<?= $last_row+2?>'>
        <td>
           Variations (Variations paid to date)
        </td>
        <td class="text-right">
                <span >$<?php if(isset($variation_total_cost)){ echo number_format($variation_total_cost,2,".",","); } else{ echo "0.00"; } ?></span>
        </td>
       
        <td>
       Various
        </td>
        <td class="text-right">$<?php if(isset($variation_total_invoice_amount)){ echo number_format($variation_total_invoice_amount,2,".",","); } else{ echo "0.00"; } ?>

        </td>
        <td>
          -
        </td>
        <td class="text-right">

            $<?php if(isset($variation_total_invoice_amount_paid)){ echo number_format($variation_total_invoice_amount_paid,2,".",","); } else{ echo "0.00"; } ?>

        </td>
        <td class="text-right">
            $<?php if(isset($variation_total_invoice_amount_owing)){ echo number_format($variation_total_invoice_amount_owing,2,".",","); } else{ echo "0.00"; } ?>
        </td>
        <td class="text-right">
           <?php 
           if(isset($variation_total_invoice_amount_paid)){
               $calculated_balance = number_format($variation_total_invoice_amount_paid,2,".","");
           }
           else{
               $calculated_balance = 0.00;
           }
           $balance -= $calculated_balance;
           ?>
           $<?= number_format($balance, 2, '.', ',') ?>
        </td>

    </tr>
<?php endif;?>
<?php if($type==2):?>
    <tr class="imth">
        <th colspan="3">Future payments</th>
        <th style="text-align:right;">$<?= number_format($total_invoice_amount, 2, '.', ',') ?></th>
        <th></th>
        <th style="text-align:right;">$<?= number_format($total_invoice_paid, 2, '.', ',') ?></th>
        <th style="text-align:right;">$<?= number_format($total_invoice_owing, 2, '.', ',') ?></th>
        <th style="text-align:right;">$<span id="lastbalance"><?= number_format($balance, 2, '.', ',') ?></span></th>
    </tr>
<?php endif; ?>