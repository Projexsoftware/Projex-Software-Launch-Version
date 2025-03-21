<?php
$project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
  $current_role = $project_role['team_role'];  
  if($current_role==""){
    $current_role = 1;
  }
?>
<?php if(($current_role==1 || $current_role==2) && $this->session->userdata('admin_role_id')!=3){ ?><a class="btn btn-info" data-toggle="modal" data-target="#addProjectTeamModal"><i class="material-icons">supervisor_account</i> Edit Project Team</a><?php } ?>
	
 <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
<?php $team = get_project_team($project_id); ?>
                                                <?php 
                                                 $project_team = array();
                                                 foreach($team as $val){ 
                                                 $project_team[] = $val['team_id'];
                                                 if($val['team_role']==1){
                                                    $team_role = "Project Manager";
                                                 }
                                                 else if($val['team_role']==2){
                                                    $team_role = "Project Leader";
                                                 }
                                                 else if($val['team_role']==3){
                                                    $team_role = "Project Member";
                                                 }
                                                 else{
                                                    $team_role = "Project Guest";
                                                 }
                                                  
                                                 
                                                 if($val['is_invitation_send']==1){
                                                   $invitation_status = "<span class='label label-warning'>Sent</span>"; }
                                                 else if($val['is_invitation_send']==2){
                                                   $invitation_status = "<span class='label label-success'>Joined</span>"; }
                                                 else{
                                                   $invitation_status = "<span class='label label-danger'>Not Sent Yet</span>";
                                                 }
                                                ?>
                                                <tr>
                                                    <td><b><?php echo $team_role;?></b></td>
                                                    <td><?php echo $val['first_name']." ".$val['last_name'];?></td>
                                                    <?php if(($current_role==1 || $current_role==2) && $this->session->userdata('admin_role_id')!=3){ ?><td><?php if($val['team_role']!=1){ ?><center><?php echo $invitation_status;?></center><?php } ?></td>
                                                    <?php if($val['team_role']!=1){ ?><td width="30px"><?php if($val['is_invitation_send']==0){ ?><button id="<?php echo $val['id'];?>" class="btn btn-xs btn-success invite_project_team">
                                        <span class="btn-label">
                                            <i class="material-icons">email</i>
                                        </span>
                                        Invite
                                    </button><?php } ?><button id="<?php echo $val['id'];?>" class="btn btn-xs btn-danger remove_project_team">
                                        <span class="btn-label">
                                            <i class="material-icons">delete</i>
                                        </span>
                                        Delete
                                    </button></td><?php } else { ?><td style="padding:30px;">&nbsp;</td><?php } } ?>
                                                </tr>
                                                <?php } ?>
</tbody>
</table>
</div>
<!-- New Project Team modal -->
                                            <div class="modal fade" id="addProjectTeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myModalLabel">Edit Project Team</h5>                                                        </div>
                                                        <div class="modal-body">
                                        <div class="task_response"></div>             
					<form id="ProjectTeamForm" method="post">
                                        <input type="hidden" id="project_team_project_id" name="project_team_project_id" value="<?php echo $project_id;?>">
                                        <div class="project_team_error error"></div>
                                        <div class="form-group label-floating">
                                            <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                <i class="fa fa-users"></i> Project Team
                                            <div class="ripple-container"></div></button>
                                            <select id="leaders" name="leaders[]" class="selectpicker select_leaders_team" data-style="select-with-transition" multiple title="Choose Leaders">
                                                        <?php if(count($scheduling_users)>0){
                                                        foreach($scheduling_users as $val){
                                                        if(!(in_array($val['user_id'], $project_team))){
                                                        ?>
                                                        <option value="<?php echo $val['user_id'];?>"><?php echo $val['user_fname']." ".$val['user_lname'];?></option>
                                                        <?php } } }?>
                                                    </select>
                                            <?php echo form_error('leaders', '<div class="custom_error">', '</div>'); ?>
					</div>
                                        <div class="form-group label-floating">
                                            
                                            <select id="members" name="members[]" class="selectpicker select_members_team" data-style="select-with-transition" multiple title="Choose Members">
                                                        <?php if(count($scheduling_members)>0){
                                                        foreach($scheduling_members as $val){
                                                        if(!(in_array($val['user_id'], $project_team))){
                                                        ?>
                                                        <option value="<?php echo $val['user_id'];?>"><?php echo $val['user_fname']." ".$val['user_lname']." (".$val['com_name'].")";?></option>
                                                        <?php } } }?>
                                                    </select>
                                            <?php echo form_error('members', '<div class="custom_error">', '</div>'); ?>
					</div>	
                                        <div class="form-group label-floating">
                                            
                                            <select id="guest" name="guest[]" class="selectpicker select_guest_team" data-style="select-with-transition" multiple title="Choose Guest">
                                                        <?php if(count($scheduling_members)>0){
                                                        foreach($scheduling_members as $val){
                                                        if(!(in_array($val['user_id'], $project_team))){
                                                        ?>
                                                        <option value="<?php echo $val['user_id'];?>"><?php echo $val['user_fname']." ".$val['user_lname']." (".$val['com_name'].")";?></option>
                                                        <?php } } }?>
                                                    </select>
                                            <?php echo form_error('guest', '<div class="custom_error">', '</div>'); ?>
					</div>		
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-warning btn-fill add_project_team">Update</button>
                                        </div>
                                    
                                        </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end new project team modal -->