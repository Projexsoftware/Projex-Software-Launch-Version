<style>
#addbtn{
	display:none;
}
</style>
<?php
$last_row = 0;
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
            <input  class="W<?=$key+$last_row?> form-control new" name="description[]" placeholder="Payment Description" value="<?= (isset($val->description))?  $val->description :  '' ; ?>" form="formtemppayment" required/>
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
        <td class="text-right" style="text-align:right;">$<?php 
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
        <td class="text-right" style="text-align:right;">

            $<?php 
                if(!count($val->sales_invoices_items)){
                    echo '0.00';
				    $invoice_payment = 0+$credit_notes_total;
				}
                else{
                echo number_format($val->sales_invoices_items[0]->payment+$credit_notes_total, 2, '.', ',');
                $invoice_payment = $val->sales_invoices_items[0]->payment+$credit_notes_total;
			   }
			   $total_invoice_paid +=$invoice_payment;	
				
            ?>

        </td>
		<td class="text-right" style="text-align:right;">
            <?php $part_invoice_amount= $invoice_amount - $invoice_payment;?>
            $<?php echo number_format($part_invoice_amount, 2, '.', ','); 
            $total_invoice_owing +=$part_invoice_amount; ?>
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
    <tr id="trnumber<?= $last_row+1?>" tr_val='<?= $last_row+1?>'>
        <td>
           Allowances (Allowances paid to date)
        </td>
        <td class="text-right" style="text-align:right;">
                <span >$<?php echo number_format($total_invoice_amount_allowances,2,".",","); ?></span>
        </td>
       
        <td>
       Various
        </td>
        <td class="text-right" style="text-align:right;">$<?php echo number_format($total_invoice_amount_allowances,2,".",","); ?>

        </td>
        <td class="text-right" style="text-align:right;">

            $<?php echo number_format($total_invoice_amount_paid_allowances,2,".",","); ?>

        </td>
        <td class="text-right" style="text-align:right;">
           $<?php echo number_format($total_invoice_amount_owing_allowances,2,".",",");?>
        </td>
        <td class="text-right" style="text-align:right;">
           <?php 
           $balance -=number_format($total_invoice_amount_paid_allowances,2,".","");
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
    
<?php if($type==2):?>
    <tr class="imth">
        <th colspan="3" style="background-color:#C0B9B9!important;padding:5px!important; color:black!important;">Future payments</th>
        <th style="text-align:right!important;background-color:#C0B9B9!important;padding:5px!important; color:black!important;" align="right">$<?= number_format($total_invoice_amount, 2, '.', ',') ?></th>
        <th class="text-right" style="text-align:right!important;background-color:#C0B9B9!important;padding:5px!important; color:black!important;text-align:right!important;" align="right">$<?= number_format($total_invoice_paid, 2, '.', ',') ?></th>
        <th class="text-right" style="text-align:right!important;background-color:#C0B9B9!important;padding:5px!important; color:black!important;text-align:right!important;" align="right">$<?= number_format($total_invoice_owing, 2, '.', ',') ?></th>
        <th class="text-right" style="text-align:right!important;background-color:#C0B9B9!important;padding:5px!important; color:black!important;text-align:right!important;" align="right">$<span id="lastbalance"><?= number_format($balance, 2, '.', ',') ?></span></th>
    </tr>
    <?php endif; ?>