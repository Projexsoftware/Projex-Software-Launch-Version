<?php foreach($parts as $val){?>
                  <tr>
                    <td><input type="checkbox" name="costing_part_id[]" value="<?php echo $val->costing_part_id;?>" class="selected_items"></td>
                    <td><?php echo $val->stage_name;?></td>
                    <td><?php echo $val->costing_part_name;?></td>
                    <td><?php echo $val->component_name;?></td>
                    <td><?php echo $val->costing_quantity;?></td>
                    <td><?php echo $val->costing_uom;?></td>
                    <td><?php echo $val->costing_uc;?></td>
                    <td><?php echo $val->line_cost;?></td>
                    <td><textarea class="form-control" name="user_notes_<?php echo $val->costing_part_id;?>"></textarea></td>
                    <td></td>
                    </tr>
<?php } ?>