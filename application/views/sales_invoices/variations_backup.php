
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
            <input type="hidden" id="variationAmount<?php echo $val['id'];?>" value="<?php echo $total_cost;?>">
        </td>

        <!--<td <?php
        if($val['completely_invoiced'] )
        {echo 'style="color: green"';}
        else {
            echo 'style="color: red"';
        }
        ?>    
        ><?php
        if($val['completely_invoiced']){
            echo "<strong>Yes</strong>";
        }
        else { echo "No";}
        ?></td>-->
        
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
            ?>
            <div class="checkbox" style="width:auto">
                <label>
                    <input type="checkbox" class="variation_amount_checkbox" id="<?php echo $val['id'];?>" <?php if($val['invoice_amount_checkbox']==1){?> checked <?php } ?>>
                </label>
             </div>
             <?php
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
        <td>

            <?php
            if (isset($val['invoiced_amount'])) {
                //echo $val['invoiced_amount'];
                /*if ($val['invoiced_amount'] <= 0){ ?>
                    <button class="btn btn-warning">No payment needed</button>
                <?php }
                else{*/

                    if(!count($val['sales_invoices_items'])) {
                        
                       if(in_array(32, $this->session->userdata("permissions"))) {
                    
                        $formname='creatinvoice';
                        $submitvalue='Create';
                        $btnclass='success';
                        } 
                    }
                    else{
                        
                        if(in_array(33, $this->session->userdata("permissions"))) {
                        $formname='viewsalesinvoice/'.$val['sales_invoices_items'][0]->sale_invoice_id;
                        $submitvalue='Update';
                        $btnclass='info';
                    }

                    }
                    ?>

                    <form id="formvar<?=$key.$formname?>" action="<?php echo SURL;?>sales_invoices/<?= $formname?>" method="post">

                        <?php if($formname!='creatinvoice'){ ?>
                            <input type="hidden" name="payment" value="<?= $val['sales_invoices_items'][0]->payment; ?>" form="formvar<?=$key.$formname?>"/>
                            <input type="hidden" name="sale_invoice_id" value="<?= $val['sales_invoices_items'][0]->sale_invoice_id; ?>" form="formvar<?=$key.$formname?>"/>
                            <input type="hidden" name="sale_invoice_item_id" value="<?= $val['sales_invoices_items'][0]->id; ?>" form="formvar<?=$key.$formname?>"/>
                        <?php } ?>
                        <?php if($formname=='receiptsaleinvoiceitem'){ ?>
                            <input type="hidden" name="work" value="C" form="formvar<?=$key.$formname?>"/>
                        <?php  } ?>
                        <input type="hidden" name="description" value="<?= $val['variation_description']; ?>" form="formvar<?=$key.$formname?>"/>
                        <input type="hidden" name="type" value="var" form="formvar<?=$key.$formname?>"/>

                        <?php if($formname=='receiptsaleinvoiceitem'){ ?>


                            <input type="hidden" name="invoice_amount" value="<?= $val['sales_invoices_items'][0]->part_invoice_amount  ?>" form="formvar<?=$key.$formname?>"/>
                        <?php } else { ?>

                            <input type="hidden" name="invoice_amount" value="<?= $val['invoiced_amount'] ?>" form="formvar<?=$key.$formname?>"/>
                        <?php   } ?>
                        <input type="hidden" name="type_id" value="<?=$val['id']?>" form="formvar<?=$key.$formname?>"/>
                        <?php
                            if(in_array(32, $this->session->userdata("permissions")) && $submitvalue=="Create") {
                        ?>
                        <input type="submit" value="<?=$submitvalue?> Invoice" class="btn btn-<?=$btnclass?>" form="formvar<?=$key.$formname?>"/>
                        <?php }
                        
                        if(in_array(33, $this->session->userdata("permissions")) && $submitvalue=="Update") {
                                    ?>
                        <input type="submit" value="<?=$submitvalue?> Invoice" class="btn btn-<?=$btnclass?>" form="formvar<?=$key.$formname?>"/>   
                        <?php } ?>
                    </form>

                    <?php
                }
            //}
            ?>
        </td>
         <td class="text-right">$<?php
            if(!count($val['sales_invoices_items'])){
              
                echo '0.00';
                $invoice_payment = 0+(-1)*$credit_notes_total;
            }
            else{
                if($val['sales_invoices_items'][0]->part_invoice_amount<0){
                 /*echo "<b>Credit Notes Total </b>=".$credit_notes_total;
                  echo "<br/>";
                  echo "<b>Part Invoice Amount </b>= ".$val['sales_invoices_items'][0]->part_invoice_amount;
                  echo "<br/>";
                  echo "<b>Outstanding </b>=".$val['sales_invoices_items'][0]->outstanding;
                  echo "<br/>";
                  echo "<b>Outstanding Amount</b> = ".($val['sales_invoices_items'][0]->outstanding-$credit_notes_total);
                  echo "<br/>";
                  echo "<b>Formula</b> = Outstanding Amount - Credit Notes Total";
                  echo "<br/>";
                  echo "<b>Formula</b> = Part Invoice Amount - Outstanding";
                  echo "<br/>";*/
                 /*echo number_format(($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total))+(-1)*$credit_notes_total, 2, '.', '');
                $invoice_payment = ($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total))+(-1)*$credit_notes_total; */
                
                echo number_format(($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total)), 2, '.', ',');
                $invoice_payment = ($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total));
                    
                }
                else{
                   
                /*echo number_format(($val['sales_invoices_items'][0]->part_invoice_amount-$val['sales_invoices_items'][0]->outstanding)+$credit_notes_total, 2, '.', '');
                $invoice_payment = ($val['sales_invoices_items'][0]->part_invoice_amount-$val['sales_invoices_items'][0]->outstanding)+$credit_notes_total;*/
                 echo number_format(($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total)), 2, '.', ',');
                $invoice_payment = ($val['sales_invoices_items'][0]->part_invoice_amount-($val['sales_invoices_items'][0]->outstanding-$credit_notes_total));
                }
            }
            $total_invoice_amount_paid +=$invoice_payment;
            ?>

        </td>
        <td class="text-right">
         <?php  
         $prev_balance = $invoice_amount - $invoice_payment;
              $total_invoice_amount_owing +=$prev_balance;
        ?>
        $<?php echo number_format($prev_balance, 2, '.', ',') ?>
        </td>
        <?php
          $balance2+= $total_cost;  
        
        ?>
        <td class="text-right">
        $<?= number_format($balance2, 2, '.', ',') ?></td>



    </tr>
<?php endforeach; ?>

<tr class="imth">
    <th colspan="2">TOTAL VARIATIONS</th>
    <th style="text-align:right;"><?php


        echo "$";
        ?><?=number_format(abs($totalvars),2,'.',',')?></th>
        <th></th>
        <th style="text-align:right;">$<?php echo number_format($total_invoice_amount,2,".",",");?></th>
    <th></th>
    <th style="text-align:right;">$<?php echo number_format($total_invoice_amount_paid,2,".",",");?></th>
    <th style="text-align:right;">$<?php echo number_format($total_invoice_amount_owing,2,".",",");?></th>
    <?php $this->load->library('session'); $this->session->set_userdata('balanceavar', $balance2); ?>
    <th style="text-align:right;">$<?= number_format($balance2, 2, '.', ',') ?></th>
    <input  type='hidden' id='tvarhid' value='<?= $totalvars ?>'  />
</tr>