	<style>
	    .bwinPopupd { overflow: visible!important; }
	</style>
	<h2><?php echo get_task_name($task_id);?></h2>
	<div class="row">
	    <div class="col-md-12">
	         <form id="assignUserForm" method="post" action="">
            	<div class="form-group label-floating">
            	    <input type="hidden" name="currentTaskId" id="currentTaskId" value="<?php echo $item_id;?>">
                	<select class="selectpicker" data-style="select-with-transition" title="Choose User *" name="currentUserId" id="currentUserId" required="true">
                                                            <option disabled> Choose User</option>
                											<?php foreach($users as $val){ 
                											    $fullName = $val['user_fname']." ".$val['user_lname'];
                											?>
                                                            <option <?php if($selectedUser == $fullName){ ?> selected <?php } ?> value="<?php echo $val['user_id'];?>"><?php echo $fullName;?></option>
                											<?php } ?>
                    </select>
                </div>
                <div class="form-group label-floating">
                <input type="button" id="assignTaskBtn" class="btn btn-success btn-sm pull-right" value="Save" onclick="assignTaskToUser();">
                </div>
            </form>
        </div>
    </div>