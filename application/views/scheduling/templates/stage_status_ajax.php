&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
$stage_status = get_template_stage_status($template_id, $stage_id, $item_count);
if($stage_status == 0){ ?>                        
<span class="label label-danger">Not Done</span>
<?php } else if($stage_status == 1){ ?>
<span class="label label-warning">Partially Done</span>
<?php } else { ?>
<span class="label label-success">Complete</span>
<?php } ?>