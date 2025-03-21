
<?php
$total_invoice_amount = 0;
$totalvars = 0;
$total_cost_value = '$0.00';
$i = 0;
$this->load->library('session');

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
    
            if (isset($val['invoiced_amount'] )){
                if(($val['variation_description']=="Variation From Supplier Credit"))
                {
                    $total_cost_value = "-$".number_format ($val['invoiced_amount'],2, '.', ',');
                    $totalvars-=$val['invoiced_amount'];
                    $total_cost = (-1)*$val['invoiced_amount'];
                }
                else{
                $total_cost_value = "$".number_format ($val['invoiced_amount'],2, '.', ',');
                $totalvars+=$val['invoiced_amount'];
                $total_cost = $val['invoiced_amount'];
                }

            }
            else {
                $total_cost_value = '$0.00';
                $totalvars+=0;
                $total_cost = 0;
            } 
            
            $balance2+= $total_cost; 
?>
    <tr>

        <td><?php echo $val['var_number']; ?></td>
        <td><?php echo $val['variation_description']; ?></td>
        <td class="text-right" <?php if($total_cost_value < 0){ echo 'style="color: red"';}?>>
            <?php echo  $total_cost_value;?>
            <input type="hidden" id="variationAmount<?php echo $val['id'];?>" value="<?php echo $total_cost;?>">
        </td>
        <td class="text-right">
        $<?= number_format($balance2, 2, '.', ',') ?></td>



    </tr>
<?php $i++; endforeach; ?>

<tr class="imth">
    <th colspan="2">TOTAL VARIATIONS</th>
    <th style="text-align:right;"><?php echo "$".number_format(abs($totalvars),2,'.',',')?></th>
    <?php $this->session->set_userdata('balanceavar', $balance2); ?>
    <th style="text-align:right;">$<?= number_format($balance2, 2, '.', ',') ?></th>
    <input  type='hidden' id='tvarhid' value='<?= $totalvars ?>'  />
</tr>