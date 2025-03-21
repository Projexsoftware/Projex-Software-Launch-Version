
<?php
$total_invoice_amount =0;
$totalvars = 0;
$total_invoice_amount_paid = 0;
$total_invoice_amount_owing = 0;
foreach ($variationarr AS $key => $val): 
 $credit_notes_total = 0;
    if(count($val['sales_invoices_items'])>0){
       $invoiceType = check_invoice_type($val['sales_invoices_items'][0]->sale_invoice_id);
       $credit_notes = get_sales_credit_notes($val['sales_invoices_items'][0]->sale_invoice_id, $invoiceType);
                                    
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
    <tr>

        <td><?php echo $val['var_number']; ?></td>
        <td><?php echo $val['variation_description']; ?></td>
        <td class="text-right"><?php if (isset($val['invoiced_amount'] ))
            {
               if(($val['variation_description']=="Variation From Supplier Credit"))
                {
                    echo "-$".number_format ($val['invoiced_amount'],2, '.', ',');
                    $totalvars-=$val['invoiced_amount'];
                    $total_cost = (-1)*$val['invoiced_amount'];
                }
                else{
                echo "$".number_format ($val['invoiced_amount'],2, '.', ',');
                $totalvars+=$val['invoiced_amount'];
                $total_cost = $val['invoiced_amount'];
                }

            }
            else {
                echo '$0.00';
                $totalvars+=0;
                $total_cost = 0;
            } ?>
        </td>

        <td><?php 
                if(count($val['sales_invoices_items'])){
                    if($val['sales_invoices_items'][0]->invoice_number == 0){
                        echo 1000000+$val['sales_invoices_items'][0]->sale_invoice_id;
                    }
                    else{
                        echo 2000000+$val['sales_invoices_items'][0]->sale_invoice_id;
                    }
                }
                else{
                   echo 'Not created';
                }
            ?>

        </td>
        <td class="text-right"><?php
            
            if(!count($val['sales_invoices_items'])){
                $invoice_amount = 0;
                if($val['invoice_amount_checkbox']==1){
                     $invoice_amount = $val['amount_before_creating_invoice'];
                } 
                    echo '$'.number_format($invoice_amount, 2, ".", ",");
            }
            else{
                echo number_format($val['sales_invoices_items'][0]->part_invoice_amount, 2, '.', ',');
                $invoice_amount = $val['sales_invoices_items'][0]->part_invoice_amount;
            }
            $total_invoice_amount +=$invoice_amount;
            ?>

        </td>
        <td class="text-right">$<?php
            if(!count($val['sales_invoices_items'])){
                echo '0.00';
                $invoice_payment = 0+(-1)*$credit_notes_total;
            }
            else{
                if($val['sales_invoices_items'][0]->part_invoice_amount<0){
                 /*echo number_format(($val['sales_invoices_items'][0]->part_invoice_amount-$val['sales_invoices_items'][0]->outstanding)+(-1)*$credit_notes_total, 2, '.', '');
                $invoice_payment = ($val['sales_invoices_items'][0]->part_invoice_amount-$val['sales_invoices_items'][0]->outstanding)+(-1)*$credit_notes_total;  */ 
                echo number_format(($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total)), 2, '.', ',');
                $invoice_payment = ($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total));
                    
                    
                }
                else{
                echo number_format(($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total)), 2, '.', ',');
                $invoice_payment = ($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total));
                }
            }
             $total_invoice_amount_paid +=$invoice_payment;
            ?>

        </td>
        <td class="text-right">
        <?php $prev_balance = $invoice_amount - $invoice_payment;?>
        $<?php echo number_format($prev_balance, 2, '.', ',') ;?>
        </td>
        <?php
        
        $balance+= $total_cost;
       $total_invoice_amount_owing +=$prev_balance;

        ?>
        <td class="text-right">
            $<?= number_format($balance, 2, '.', ',') ?></td>



    </tr>
<?php endforeach; ?>

<tr class="imth">
        <th style="background-color:#C0B9B9!important;padding:8px!important; color:black!important;" colspan="2" >TOTAL VARIATIONS</th>
        <th style="background-color:#C0B9B9!important;padding:8px!important; color:black!important;text-align:right;" ><?php echo "$";?><?php echo number_format(abs($totalvars),2,'.', ',')?></th>
        <th style="background-color:#C0B9B9!important;padding:8px!important; color:black!important;"></th>
        <th style="background-color:#C0B9B9!important;padding:8px!important; color:black!important;text-align:right;">$<?= number_format($total_invoice_amount, 2, '.', ',') ?></th>
        <th style="background-color:#C0B9B9!important;padding:8px!important; color:black!important;text-align:right;">$<?= number_format($total_invoice_amount_paid, 2, '.', ',') ?></th>
        <th style="background-color:#C0B9B9!important;padding:8px!important; color:black!important;text-align:right;">$<?= number_format($total_invoice_amount_owing, 2, '.', ',') ?></th>
       
        <?php $this->load->library('session'); $this->session->set_userdata('balanceavar', $balance); ?>
        <th style="background-color:#C0B9B9!important;padding:8px!important; color:black!important;text-align:right;">$<?= number_format($balance, 2, '.', ',') ?></th>
        <input  type='hidden' id='tvarhid' value='<?= $totalvars ?>'  />
    </tr>