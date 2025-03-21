<table id="credit_invoices_table" class="table table-bordered table-striped table-hover" style="text-align:left;">
		        		<thead>
                        <tr>
                            <th>Part</th>
                            <th>Component</th>
                            <th>Alowance</th>
                            <th>Actual</th>
                            <th>Difference</th>
                            <th>Supplier Invoice #</th>
                            <th>Supplier Name</th>
                            <th>Supplier Refrence</th>
                            <th>Supplier Invoice Amount</th>
                        </tr>
                       </thead>
		        		<tbody>
		        		    <?php if(count($allowance_costing_parts)>0){ ?>
		        		    <?php 
		        		    $total_allowance_amount = 0;
		        		    $total_actual_amount = 0;
		        		    $total_diff = 0;
		        		    $total_supplier_amount = 0;
                            foreach ($allowance_costing_parts as $key => $costing_part) { 
                            ?>
                            <tr>
                                <td><?php echo $costing_part["costing_part_name"]; ?></td>
                                <td><?php 
                                $component_info = get_component_info($costing_part["component_id"]);
                                echo $component_info["component_name"]; ?></td>
                                <td align="right"><?php 
                                $allowance_cost = ($costing_part["line_margin"])+($costing_part["line_margin"]*($tax/100));
                                echo number_format($allowance_cost,2, '.', ',');
                                $total_allowance_amount +=number_format($allowance_cost, 2, '.', '');
                                ?>
                                </td>
                                <td align="right">
                                <?php 
                                   $actualAmount = 0;
                                   if(isset($costing_part[$costing_part["costing_part_id"]]) && count($costing_part[$costing_part["costing_part_id"]])>0){
                                       foreach($costing_part[$costing_part["costing_part_id"]] as $val){
                                           $actualAmount += $val["subtotal"]+($val["subtotal"]*($tax/100));
                                       }
                                   }
                                   $total_actual_amount +=number_format($actualAmount, 2, '.', '');
                                   echo number_format($actualAmount, 2, '.', ',');
                                ?>
                                </td>
                                <td align="right">
                                    <?php $diff = $actualAmount - $allowance_cost; ?>
                                    <span <?php if($diff<0){ ?>style="color:red"<?php } ?>>
                                        <?php if($diff < 0)
                                        {
                                        echo "-"." $".number_format(abs($diff), 2, ".", ",");
                                        $total_diff +=(number_format(abs($diff), 2, '.', '')*(-1));
                                        }
                                        else{
                                         echo "$".number_format($diff,2, ".", ",");
                                         $total_diff +=number_format($diff,2, ".", "");
                                        }?>
                                    </span>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                </tr>
                                <?php if(isset($costing_part[$costing_part["costing_part_id"]]) && count($costing_part[$costing_part["costing_part_id"]])>0){ 
                                     foreach($costing_part[$costing_part["costing_part_id"]] as $val){
                                ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td align="right"><?php echo $val['supplier_invoice_id']; ?></td>
                                        <td><?php echo $val['supplier_name']; ?></td>
                                        <td><?php echo $val['supplierrefrence']; ?></td>
                                        <td align="right"><?php 
                                        $total_supplier_amount +=number_format($val['subtotal']+($val["subtotal"]*($tax/100)), 2,'.',''); 
                                        echo number_format($val['subtotal']+($val["subtotal"]*($tax/100)), 2,'.',''); 
                                        ?></td>
                                    </tr>
                                <?php } } ?>
    <?php 
} 
}
?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="right"><b><?php echo "$".number_format($total_allowance_amount,2, ".", ",");?></b></td>
                                    <td align="right"><b><?php echo "$".number_format($total_actual_amount,2, ".", ",");?></b></td>
                                    <td align="right"><span <?php if($total_diff<0){ ?>style="color:red;"<?php } ?>><b><?php echo "-$".number_format(abs($total_diff),2, ".", ",");?></b></span></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right"><b><?php echo "$".number_format($total_supplier_amount,2, ".", ",");?></b></td>
                                </tr>
		        		   
		        		</tbody>
		        		</table>