<div id="files_container<?php echo $item_id;?>">
<?php 
  /*$project_role = get_user_project_role($project_id, $this->session->userdata("user_id"));
  $current_role = $project_role['team_role'];
  if($current_role==""){*/
    $current_role = 1;
  //}
?>
<?php $task_files = get_task_files($project_id, $item_id, $current_role);?>
<a class="btn btn-warning btn-round" data-toggle="modal" data-target="#addFileModal<?php echo $item_id;?>">Files <span class="badge count<?php echo $item_id;?>"><?php echo count($task_files);?></span>
                                       <b class="caret"></b></a>
                                        <!-- Files modal -->
                                            <div class="modal fade" id="addFileModal<?php echo $item_id;?>" tabindex="-1" role="dialog" aria-labelledby="myFileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myFileModalLabel"><?php echo get_task_name($task_id);?> Files</h5>                                                        </div>
                                                        <div class="modal-body">
                                                        <?php if(count($task_files)>0){ echo "<ul class='list_container'>"; foreach($task_files as $val){ ?>
                                                       <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $val['file'];?><?php if($current_role==1 || $current_role==2 || $val['user_id']==$this->session->userdata("admin_id")){ ?><span rowno="<?php echo $item_id;?>" id="<?php echo $val['id'];?>" class="remove_file pull-right btn btn-simple btn-danger btn-icon"><i class="material-icons">close</i></span><?php }
 ?><span class="pull-right btn btn-simple btn-icon">|</span><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo SCURL;?>projects/download_file/<?php echo $val['file'];?>"><i class="material-icons">file_download</i></a><?php if($current_role==1 || $current_role==2){ ?>
                                        <div class="togglebutton pull-right privacy_toggle">
                                                <label class="text-default">
                                                  <input id="privacy_settings<?php echo $val['id'];?>" name="privacy_settings" type="checkbox" <?php if($val['privacy_settings']==0){ ?> checked <?php } ?> onclick="set_privacy(<?php echo $val['id'];?>, <?php echo $item_id;?>, 'File');" >Private
                                                </label>
                                        </div>
                                        <?php if($val['uploaded_at']!=""){ ?>
                                        <br/><p class="text-right"><i class="fa fa-user" title="Uploaded By"></i> <?php echo get_user_info($val['uploaded_by']);?>&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o" title="Uploaded At"></i> <?php echo date("d/m/Y h:i A", strtotime($val['uploaded_at']));?></p>
                                        <?php } ?>
                                       <?php } ?>
                                       
                                        </li>
                                                        <?php } echo "</ul>";} ?>
<?php if($current_role==1 || $current_role==2 || $current_role==3 || $current_role==4){ ?>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">attach_file</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Upload New File</h4> 
                                    <div class="toolbar">
<form rowno="<?php echo $item_id;?>" class="upload_task_file" name="FilesForm<?php echo $item_id;?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="file_item_id" value="<?php echo $item_id;?>">
<input type="hidden" name="file_project_id" value="<?php echo $project_id;?>">
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
                                                        <span class="fileinput-new">Select file</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="task_file<?php echo $item_id;?>" name="task_file" />
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    <p class="file_error<?php echo $item_id;?> text-danger"></p>
                                                </div>
                                            </div>
<div class="form-footer text-right">
                                             <div class='progress progress-line-success' id="progressFileDivId<?php echo $item_id;?>">
            <div class='progress-bar progress-bar-success' id='progressFileBar<?php echo $item_id;?>'>0%</div>
        </div>
                                            <button id="btn-upload<?php echo $item_id;?>" type="submit" class="btn btn-warning btn-fill">Upload</button>
                                        </div>
</form>
</div>
</div>
</div>
<?php } ?>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end Files modal -->
</div>
                                            