<?php 
$team = get_project_team($project_edit['id']); 
$project_team = array();
foreach($team as $val){ 
$project_team[] = $val['team_id'];
}
if($type=="leaders"){
 $users = get_scheduling_users();
}
else{
  $users = get_scheduling_members();  
}
?>
<select id="<?php echo $type;?>" name="<?php echo $type;?>[]" class="selectpicker select_<?php echo $type;?>_team" data-style="select-with-transition" multiple title="Choose <?php echo ucfirst($type);?>">
                                                     
<?php
if(count($users)>0){
    foreach($users as $val){
    if(!(in_array($val['user_id'], $project_team))){
?>
    <option value="<?php echo $val['user_id'];?>"><?php echo $val['user_fname']." ".$val['user_lname'];?></option>
<?php } } } ?>
</select>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
