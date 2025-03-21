<?php $count = $last_row + 1; ?>

<tr id="nitrnumber<?php echo $count; ?>" tr_val="<?php echo $count; ?>">
    <input type="hidden" name="nicosting_part_id[]" value="0"/>
    <input type="hidden" name="<?= 'nisi_item_id[]' ?>" value="0">
    <input type="hidden" name="<?= 'nisrno[]' ?>" value="<?php echo $count; ?>">


    <td>
        <select name="nistage[<?php echo $count-1; ?>]" id="nistagefield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control selectStage" required="true">
        </select>
    </td>

    <td><input type="text" name="nipart[<?php echo $count-1; ?>]" id="nipartfield<?php echo $count; ?>" value="" rno ='<?php echo $count; ?>' class="form-control" required="true"/></td>
    <td>
        <select name="nicomponent[<?php echo $count-1; ?>]" id="nicomponentfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control selectComponent" onchange="return componentval(<?php echo $count; ?>);" data-container="body" required="true">
        </select>

    </td>
    <td>
        <input type="text" class="form-control" name="nisupplier_name[<?php echo $count-1; ?>]" id="nisupplierfieldname<?php echo $count ?>" rno ='<?php echo $count ?>' value="" readonly required="true">
        <input type="hidden" class="form-control" name="nisupplier_id[]" id="nisupplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="" readonly>
    </td>

 

     <td><input readonly type="text" name="niuom[]" id="niuomfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' value="each" class="form-control readonlyme" width="5" /></td>
    <td><input type="text" name="niucost[]" id="niucostfield<?php echo $count; ?>" rno ='<?php echo $count; ?>' class="form-control" value="0.00"/></td>
    <td><input  name="nimanualqty[]" min="0" step="0.1" rno ="<?php echo $count; ?>" id="nimanualqty<?php echo $count; ?>" type="number"  required="true" class="qty form-control" value="0.00" onchange="calculateInvoiceAmount(<?php echo $count; ?>);"/></td>
    <td><input type="text" name="nilinttotal[]"  rno ="<?php echo $count; ?>" id="nilinetotalfield<?php echo $count; ?>" class="form-control invoicebudget res_count" value="0.00" /></td>

    <td>
       <a rno="<?php echo $count?>" class="btn btn-simple btn-danger btn-icon deleterow"><i class="material-icons">delete</i></a>
    </td>

</tr>


<?php $count ++ ?>
