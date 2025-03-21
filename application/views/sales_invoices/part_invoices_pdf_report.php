<?php
$totaldiff=0;
$total_invoice_amount=0;
$total_invoice_payment = 0;
$total_owing_amount = 0;
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
?>
    <tr>

        <td><?php echo $val->costing_part_name; ?></td>
        <td>
            <?php 
            
            foreach ($component as $ket => $vat) {
                
                if($vat["component_id"] == $val->component_id )
                {echo $vat["component_name"]; }
            } 
            ?>
        </td>
        <td class="text-right" style="text-align:right;">$<?php 
		
		$allowance_cost = ($val->line_margin)+($val->line_margin*($tax/100));
		echo number_format($allowance_cost,2, '.', ','); ?></td>
        <td class="text-right" style="text-align:right;">$<?php 
            if (isset($val->invoiced_amount ))
                echo number_format(($val->invoiced_amount)+($val->invoiced_amount*($tax/100)), 2, '.', ','); 
            else {
               echo '0.00'; 
            }
        ?></td>
         <td class="text-right"
            <?php

            $diff=(($val->invoiced_amount)+($val->invoiced_amount*($tax/100))) - $allowance_cost;
            $totaldiff+=$diff;
            /* if( ($val->invoiced_amount - $val->line_margin < 0 ) || !isset($val->invoiced_amount) )
            {

                echo 'style="color: red"';
            } */ if($diff < 0)
            {

                echo 'style="color: red;text-align:right"';
            }
            else{
                echo 'style="text-align:right"';
            }

            ?>
        ><?php
            ;/*
            if (isset($val->invoiced_amount)) {
                    if ($val->invoiced_amount - $val->line_margin < 0)
                        echo "-" . " $";
                    else {
                        echo "$";
                    }
                    $totaldiff+= $val->invoiced_amount - $val->line_margin;
                    echo number_format(abs($val->invoiced_amount - $val->line_margin),2, '.', '');
					$diff = $val->invoiced_amount - $val->line_margin;
            } else {
                    echo "-" . " $" . number_format($val->line_margin, 2, '.', '');
					$diff = $val->line_margin;
                    $totaldiff+=-$val->line_margin;
            } */
           if($diff < 0)
            {
            echo "-"." $".number_format(abs($diff), 2, ".", ",");
            }
            else{
             echo "$".number_format($diff, 2, ".", ",");
            }
            ?></td>
        <!--<td <?php
        if($val->completely_invoiced )
        {echo 'style="color: green"';}
        else {
            echo 'style="color: red"';
        }
        ?>    
        ><?php  
           if($val->completely_invoiced ){
               echo "<strong>Yes</strong>";
           }  
           else { echo "No";}
        ?></td>-->
        
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
        <td class="text-right" style="text-align:right;"><?php 
           if(!count($val->sales_invoice_item)){
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
            /*if (count($val->sales_invoice_item)==0) {
                echo "0.00";
                $invoice_amount = 0;
            }
            else{
                echo number_format($diff, 2, ".", "");
                $invoice_amount = $diff;
                
            }*/
            $total_invoice_amount +=$invoice_amount;
            ?>

        </td>
       <td class="text-right" style="text-align:right;">$<?php
       
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
                    echo number_format($sales_invoice_payment, 2, '.', ',');
                    $invoice_payment = number_format($sales_invoice_payment, 2, '.', '');
                }
            }
            $total_invoice_payment +=$invoice_payment;
            ?>

        </td>
       <td class="text-right" style="text-align:right;">
        <?php $owing_amount = $invoice_amount - $invoice_payment;?>
        $<?php echo number_format($owing_amount, 2, '.', ',') ?>
        </td>
        <?php
        $balance+=$invoice_amount;
        $total_owing_amount +=$owing_amount;
        ?>
        <td class="text-right" style="text-align:right;">$<?= number_format($balance, 2, '.', ',') ?></td>
        

    </tr>
<?php endforeach; ?>

    <tr class="imth">
       <!--  <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">TOTAL ALLOWANCE ADJUSTMENTS</th> -->
        <th style="background-color:#C0B9B9!important;padding:5px!important; color:#000000!important;" colspan="6" >TOTAL ALLOWANCE ADJUSTMENTS</th>
        <th style="text-align:right;background-color:#C0B9B9!important;padding:5px!important; color:#000000!important;" class="text-right"><?php
        /*if($totaldiff<0)
            echo "-"." $";
        else*/
            echo "$";
        ?><?=  number_format(abs($total_invoice_amount),2, '.', ',')?></th>
    <th style="text-align:right;background-color:#C0B9B9!important;padding:5px!important; color:#000000!important;" class="text-right" colspan="1" ><?php
        echo "$".number_format(abs($total_invoice_payment),2, '.', ',');
        ?></th>
    <th style="text-align:right;background-color:#C0B9B9!important;padding:5px!important; color:#000000!important;" class="text-right" colspan="1" ><?php
        echo "$".number_format(abs($total_owing_amount),2, '.', ',');
        ?></th>
        
        <th class="text-right" style="text-align:right;background-color:#C0B9B9!important;padding:5px!important; color:#000000!important;">$<span id="allowancebalance" ><?= number_format($balance, 2, '.', ',') ?>  <?php $this->load->library('session'); $this->session->set_userdata('balanceaapd', $balance); ?> </span>  </th>
       
        <input  type='hidden' id='tallowance' value='<?=  $totaldiff ?>'  />
    </tr>