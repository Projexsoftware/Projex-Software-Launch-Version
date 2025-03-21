<?php 
  $project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
  $current_role = $project_role['team_role'];
  if($current_role==""){
    $current_role = 1;
  }
?>
<h2><?php echo get_task_name($task_id);?></h2>
<table class="table">
<tbody>
<tr>
<td>
                                            <?php include("application/views/scheduling/projects/task_items/checklist.php");?>
                                                           </td>
                                            <?php if($current_role!=4){ ?>
                                                           <td>
                                            <?php include("application/views/scheduling/projects/task_items/notes.php");?>
                                                           </td>
                                            <?php } ?>
                                            <?php if($current_role!=4){ ?>
                                                           <td>
                                            <?php include("application/views/scheduling/projects/task_items/files.php");?>
                                                           </td>
                                            <?php } ?>
                                                            <td>
                                            <?php include("application/views/scheduling/projects/task_items/images.php");?>
                                                           </td>
                                            <?php if($current_role==1 || $current_role==2){ ?>
                                                           <td>
                                           <?php $reminder_users = get_task_reminder_users($item_id);?>
                                           <?php include("application/views/scheduling/projects/task_items/reminders.php");?>
                                                           </td>
                                            <?php }?>
</tr>
</tbody>
</table>