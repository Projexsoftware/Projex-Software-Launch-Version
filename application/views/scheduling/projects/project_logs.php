<?php 
if(count($project_logs)>0){
foreach($project_logs as $val){ ?>
<tr>
    <td><?php echo date("d/m/Y", strtotime($val['date']));?></td>
    <td><?php echo get_user_name($val["user_id"]);?></td>
    <td><?php echo $val['entity_type'];?></td>
    <td><?php echo $val['notes'];?></td>
    <td align="center">
        <?php if($val['image']!=""){ ?>
            <img style="width:200px;height:200px;" src="<?php echo SURL.'assets/scheduling/project_logs/'.$val['image'];?>"> 
        <?php } ?>   
    </td>
</tr>
<?php } } else{ ?>
<tr><td colspan="5">No Project Logs Found!</td></tr>
<?php } ?>