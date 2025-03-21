<?php
$totaldiff=0;
$total_invoice_amount=0;
$total_invoice_payment = 0;
$total_owing_amount = 0;
$total_allowance = 0;
$total_actual = 0;
$total_difference = 0;
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

        <td><?php echo $val->costing_part_name; ?></td>
        <td>
            <?php

            foreach ($component as $ket => $vat) {

                if($vat["component_id"] == $val->component_id )
                {echo $vat["component_name"]; }
            }
            ?>
        </td>
        <td class="text-right">$<?php
            $allowance_cost = ($val->line_margin)+($val->line_margin*($tax/100));
            $total_allowance +=$allowance_cost;

            echo number_format($allowance_cost,2, '.', ','); ?></td>
        <td class="text-right"><div style="cursor:pointer;" data-container="body" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="<?php echo $allocated_allowances_table;?>">$<?php
            if (isset($val->invoiced_amount )){
                echo number_format(($val->invoiced_amount)+($val->invoiced_amount*($tax/100)), 2, '.', ',');
                $total_actual +=number_format(($val->invoiced_amount)+($val->invoiced_amount*($tax/100)), 2, '.', ',');
            }
            else {
                echo '0.00';
                $total_actual +=0;
            }
            ?></div></td>
        <td class="text-right"
            <?php

            $diff=(($val->invoiced_amount)+($val->invoiced_amount*($tax/100))) - $allowance_cost;
            $totaldiff+=$diff;
            if($diff < 0)
            {

                echo 'style="color: red"';
            }

            ?>
        ><?php
            if($diff < 0)
            {
            echo "-"." $".number_format(abs($diff), 2, ".", ",");
            $diff_invoice_amount = abs($diff)*(-1);
            }
            else{
             echo "$".number_format($diff,2, ".", ",");
             $diff_invoice_amount = $diff;
            }
            
             $total_difference +=$diff_invoice_amount;
            ?>
            <input type="hidden" id="amount<?php echo $val->costing_part_id;?>" value="<?php echo $diff_invoice_amount;?>">
        </td>
        <?php
            if(count($val->sales_invoice_item)==0){
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
            
            $balance1+=$diff_invoice_amount<0?($invoice_amount + $diff_invoice_amount):($invoice_amount - $diff_invoice_amount);
        ?>
        <td class="text-right">$<?= number_format($balance1, 2, '.', ',') ?></td>
    </tr>
<?php endforeach; ?>

<tr class="imth">
    <th colspan="2"  >TOTAL ALLOWANCE ADJUSTMENTS</th>
    <th class="text-right" colspan="1" ><?php
        echo "$".number_format(abs($total_allowance),2, '.', ',');
        ?></th>
    <th class="text-right" colspan="1" ><?php
        echo "$".number_format(abs($total_actual),2, '.', ',');
        ?></th>
    <th class="text-right" colspan="1" <?php if($total_difference < 0){ ?> style="color:red;" <?php } ?>>
    <?php echo ($total_difference < 0)?"-$".number_format(abs($total_difference),2, '.', ','):"$".number_format(abs($total_difference),2, '.', ',');
        ?></th>
    <th class="text-right" >$<span id="allowancebalance" ><?= number_format($balance1, 2, '.', ',') ?>  <?php $this->load->library('session'); $this->session->set_userdata('balanceaapd', $balance1); ?> </span>  </th>

    <input  type='hidden' id='tallowance' value='<?=  $totaldiff ?>'  />
</tr>