<?php 
  /*$project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
  $current_role = $project_role['team_role'];
  if($current_role==""){*/
    $current_role = 1;
  //}
$project_documents = get_project_documents($parent_project_id, $current_role);
if(count($project_documents)>0){ echo "<ul class='list_container'>"; foreach($project_documents as $val){ ?>
                                                       <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $val['document'];?><?php if($current_role==1 || $current_role==2){ ?><span id="<?php echo $val['id'];?>" class="remove_document pull-right btn btn-simple btn-danger btn-icon"><i class="material-icons">close</i></span><span class="pull-right btn btn-simple btn-icon">|</span><?php } ?><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo SURL.'assets/project_plans_and_specifications/'.$val['document'];?>" target="_Blank"><i class="material-icons">file_download</i></a><?php if($current_role==1 || $current_role==2){ ?>
                                        <div class="togglebutton pull-right privacy_toggle">
                                                <label class="text-default">
                                                  <input id="privacy_settings<?php echo $val['id'];?>" name="privacy_settings" type="checkbox" <?php if($val['privacy']==0){ ?> checked <?php } ?> onclick="set_privacy(<?php echo $val['id'];?>, 0, 'Document');" >Private
                                                </label>
                                        </div>
                                        <?php } ?></li>
                                                        <?php } echo "</ul>";} ?>