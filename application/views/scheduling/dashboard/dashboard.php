                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">person</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Total Users</p>
                                    <h3 class="card-title"><?php echo $total_users;?></h3>
                                </div>
                            </div>
                         </div>
                         <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">android</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Total Projects</p>
                                    <h3 class="card-title"><?php echo $total_projects;?></h3>
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="rose">
                                    <i class="material-icons">timeline</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Total Stages</p>
                                    <h3 class="card-title"><?php echo $total_stages;?></h3>
                                </div>
                            </div>
                          </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3>What's New &nbsp;&nbsp;<a href="<?php echo SCURL;?>whats_new" class="btn btn-rose btn-round btn-sm">See All</a></h3>
                            
                                <marquee behavior="scroll" direction="up" 
        onmouseover="this.stop();" 
        onmouseout="this.start();">
           
    <ul class="timeline timeline-simple" style="margin-left:10px;">
                                <?php if(count($activities)>0){
                                 $counter = 0;
                                 foreach($activities as $val){ 
                                  $activity_type = explode("_", $val['activity_type']);
                                  $project_role = get_user_project_role($val['project_id'], $this->session->userdata("user_id"));
                                  $current_role = $project_role['team_role'];
                                  if($current_role==""){
                                    $current_role = 1;
                                  }
                                 $is_activity_public = is_activity_public($val['activity_id'], $activity_type[1]);
                               
                                 if((($current_role==1 || $current_role==2) || ($current_role>2 && $is_activity_public==1 && $activity_type[1]!="reminder")) && $counter<5){
                                 $counter++;
                                 $class_name = "success";
                                 if($activity_type[0]=="remove"){
                                   $class_name = "danger";
                                 }
                                 if($this->session->userdata("user_id")==$val['user_id']){
                                   $posted_by="<b>You</b> ";
                                 }
                                 else{
                                  $posted_by= "<b>".$val['first_name']." ".$val['last_name']."</b> ";
                                 }
                                 $link ="";
                                 if($val['activity_type']=="add_note"){
                                  $activity =$posted_by."added a new note under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                  if(count(get_note_details($val['activity_id']))>0){
                                  $link = '<a class="btn btn-round btn-sm btn-rose" data-toggle="modal" data-target="#ViewNoteModal'.$val['id'].'"><i class="material-icons">art_track</i> View</a>';
                                  }
 ?>
<?php 
                                 }
                                 else if($val['activity_type']=="remove_note"){
                                  $activity =$posted_by."removed note under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                 }
                                 
                                 else if($val['activity_type']=="add_task"){
                                  $activity =$posted_by."added (<b>Task : </b>".$val['task_name']." ) under (<b>Stage : </b>".$val['stage_name']." )";
                                 }

                                 else if($val['activity_type']=="remove_task"){
                                  //$activity =$posted_by."removed (<b>Task : </b>".$val['task_name']." ) under (<b>Stage : </b>".$val['stage_name']." )";
                                  $activity =$posted_by."removed task";
                                 }

                                 else if($val['activity_type']=="add_document"){
                                  $activity =$posted_by."uploaded new document";
                                  if(count(get_document_details($val['activity_id']))>0){
                                  $link = '<a class="btn btn-round btn-sm btn-rose" data-toggle="modal" data-target="#ViewDocumentModal'.$val['id'].'"><i class="material-icons">art_track</i> View</a>';
                                  }
                                  }
                                 else if($val['activity_type']=="remove_document"){
                                 $activity =$posted_by."deleted document";
                                 }                                 

                                 else if($val['activity_type']=="add_file"){
                                  $activity =$posted_by."uploaded new file under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                  if(count(get_files_details($val['activity_id'], 0))>0){
                                  $link = '<a class="btn btn-round btn-sm btn-rose" data-toggle="modal" data-target="#ViewFileModal'.$val['id'].'"><i class="material-icons">art_track</i> View</a>';
                                  }
                                      
                                  }
                                 else if($val['activity_type']=="remove_file"){
                                  $activity =$posted_by."removed file under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                 }

                                 else if($val['activity_type']=="add_image"){
                                  $activity =$posted_by."uploaded new image under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                  if(count(get_files_details($val['activity_id'], 1))>0){
                                  $link = '<a class="btn btn-round btn-sm btn-rose" data-toggle="modal" data-target="#ViewImageModal'.$val['id'].'"><i class="material-icons">art_track</i> View</a>';
                                  }
                                  }
                                 else if($val['activity_type']=="remove_image"){
                                  $activity =$posted_by."removed image under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                 }

                                 else if($val['activity_type']=="add_reminder"){
                                  $activity =$posted_by."added reminder under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                  if(count(get_reminder_details($val['activity_id']))>0){
                                  $link = '<a class="btn btn-round btn-sm btn-rose" data-toggle="modal" data-target="#ViewReminderModal'.$val['id'].'"><i class="material-icons">art_track</i> View</a>';
                                  }
                                  }
                                 else if($val['activity_type']=="remove_reminder"){
                                  $activity =$posted_by."removed reminder under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                 }

                                ?>
                                <li class="timeline-inverted">
                                    <div class="timeline-badge <?php echo $class_name;?>">
                                        <i class="material-icons">local_activity</i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <span class="label label-<?php echo $class_name;?>"><?php echo $val['project_name'];?></span>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $activity;?></p>
                                        </div>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo get_time_diff($val['created_at']);?>
                                        </h6>
                                        <center><?php if($class_name=="success"){ echo $link;} ?></center>
                                    </div>
                                </li>
                                <?php } } }?>
                               </ul>
                               </marquee>
                        </div>
                    </div>
                    <h3>Latest Projects&nbsp;&nbsp;<a href="<?php echo SCURL;?>projects" class="btn btn-rose btn-round btn-sm">View All</a></h3>
                    <br>
                    <div class="row">
                        <?php if(count($projects)>0){
                        $counter = 1;
                        foreach($projects as $val){ 
                        if($counter == 1){
                        ?>
                        <div class="col-md-12">
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="card card-product">
                                <div class="card-image" data-header-animation="true">
                                    <a href="#pablo">
                                        <?php if($val['image']==""){ ?><img class="img" src="<?php echo IMG;?>image_placeholder.jpg"><?php } else { ?> <img class="img" src="<?php echo PROJECT_IMG.$val['image'];?>"> <?php } ?>
                                    </a>
                                </div>
                                <div class="card-content">
                                    <div class="card-actions">
                                        <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                            <i class="material-icons">build</i> Fix Header!
                                        </button>
                                        <a href="<?php echo SCURL;?>projects/edit_project/<?php echo $val['id'];?>"><button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="View">
                                            <i class="material-icons">art_track</i>
                                        </button></a>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="<?php echo SCURL;?>projects/edit_project/<?php echo $val['id'];?>"><?php echo $val['name'];?></a>
                                    </h4>
                                    <div class="card-description">
                                        <?php echo $val['description'];?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="stats pull-right">
                                        <p class="category"><i class="material-icons">event</i> <?php echo date("d/m/Y", strtotime($val['start_date']));?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $counter++;
                        if($counter == 4){
                            $counter = 1;
                        ?>
                        </div>
                        <?php } ?>
                        <?php } } ?>
                    </div>
<?php if(count($activities)>0){
                                 foreach($activities as $val){
                                 $activity_type = explode("_", $val['activity_type']);
if($val['activity_type']=="add_note"){ ?>

<!-- Notes modal -->
                                            <div class="modal fade" id="ViewNoteModal<?php echo $val['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myNoteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice" style="width:420px;">
                                                    
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myNoteModalLabel">View Note</h5>                                                        </div>
                                                        <div class="modal-body">
<p><b>Project :</b> <?php echo $val['project_name'];?></p>
<p><b>Stage :</b> <?php echo $val['stage_name'];?></p>
<p><b>Task :</b> <?php echo $val['task_name'];?></p>
                                                         <ul class="timeline timeline-simple">
                                                            <?php 
                                 $note = get_note_details($val['activity_id']);?>
                                                          
                                <li class="timeline-inverted">
                                    <div class="timeline-badge success">
                                        <i class="material-icons">description</i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <span class="label label-success"><?php echo $note['author'];?></span>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $note['note'];?></p>
                                        </div>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo date("M d, Y", strtotime($note['date']));?>
                                        </h6>
                                    </div>
                                </li>
                                                               
</ul>
</div>                                                      </div>
                                                        
                                                    </div>
                                                </div>
<!-- end Notes modal --> 
<?php } 
else if($val['activity_type']=="add_image"){ ?>

<!-- Image modal -->
                                            <div class="modal fade" id="ViewImageModal<?php echo $val['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myImageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice" style="width:420px;">
                                                    
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myImageModalLabel">View Image</h5>                                                        </div>
                                                        <div class="modal-body">
<p><b>Project :</b> <?php echo $val['project_name'];?></p>
<p><b>Stage :</b> <?php echo $val['stage_name'];?></p>
<p><b>Task :</b> <?php echo $val['task_name'];?></p>
                                                         <ul class="list_container">
                                <?php 
                                 $image = get_files_details($val['activity_id'], 1);?>
                                                          
                               <li> <img src="<?php echo TASK_PATH.'images/'.$image['file'];?>" style="width:50px;height:50px;"><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo TASK_PATH.'images/'.$image['file'];?>" target="_Blank"><i class="material-icons">file_download</i></a></li>
                                </ul>
</div>                                                      
</div>
                                                        
                                                    </div>
                                                </div>
<!-- end Image modal -->
<?php
}
else if($val['activity_type']=="add_file"){ ?>

<!-- File modal -->
                                            <div class="modal fade" id="ViewFileModal<?php echo $val['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myFileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice" style="width:420px;">
                                                    
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myFileModalLabel">View File</h5>                                                        </div>
                                                        <div class="modal-body">
<p><b>Project :</b> <?php echo $val['project_name'];?></p>
<p><b>Stage :</b> <?php echo $val['stage_name'];?></p>
<p><b>Task :</b> <?php echo $val['task_name'];?></p>
                                                         <ul class="list_container">
                                <?php 
                                 $file = get_files_details($val['activity_id'], 0);?>
                                                          
                               <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $file['file_original_name'];?><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo TASK_PATH.'files/'.$file['file'];?>" target="_Blank"><i class="material-icons">file_download</i></a>
                                </ul>
                                </div>                                                      </div>
                                                        
                                                    </div>
                                                </div>
<!-- end File modal -->
<?php
}
else if($val['activity_type']=="add_document"){ ?>

<!-- File modal -->
                                            <div class="modal fade" id="ViewDocumentModal<?php echo $val['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myDocumentModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice" style="width:420px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myDocumentModalLabel">View Document</h5>                                                        </div>
                                                        <div class="modal-body">
<p><b>Project :</b> <?php echo $val['project_name'];?></p>
                                                         <ul class="list_container">
                                <?php 
                                 $document = get_document_details($val['activity_id']);?>
                                                          
                               <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $document['document_original_name'];?><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo TASK_PATH.'documents/'.$document['document'];?>" target="_Blank"><i class="material-icons">file_download</i></a>
                                </ul>
                                </div>                                                      </div>
                                                        
                                                    </div>
                                                </div>
<!-- end File modal -->
<?php
}
else if($val['activity_type']=="add_reminder"){ ?>

<!-- Reminder modal -->
                                            <div class="modal fade" id="ViewReminderModal<?php echo $val['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myReminderModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice" style="width:420px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myReminderModalLabel">View Reminder</h5>                                                        </div>
                                                        <div class="modal-body">
<p><b>Project :</b> <?php echo $val['project_name'];?></p>
<p><b>Stage :</b> <?php echo $val['stage_name'];?></p>
<p><b>Task :</b> <?php echo $val['task_name'];?></p>

                                <ul class="timeline timeline-simple">
                                <?php 
                                 $reminder = get_reminder_details($val['activity_id']);
                                ?>
                                <li class="timeline-inverted">
                                    <div class="timeline-badge rose">
                                        <i class="material-icons">description</i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <span class="label label-rose"><?php echo $reminder['email'];?></span>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $reminder['message'];?></p>
                                        </div>
                                        <?php 
                                        if($reminder['reminder_type']==0){
                                          $reminder_statement = "Same Day";
                                        } 
                                        else if($reminder['reminder_type']==1){
                                          if($reminder['no_of_days']>1){
                                           $reminder_statement = "After ".$reminder['no_of_days']." days";
                                          }
                                          else{
                                            $reminder_statement = "After ".$reminder['no_of_days']." day";
                                          }
                                        }
                                        else if($reminder['reminder_type']==2){
                                          if($reminder['no_of_days']>1){
                                           $reminder_statement = "Before ".$reminder['no_of_days']." days";
                                          }
                                          else{
                                            $reminder_statement = "Before ".$reminder['no_of_days']." day";
                                          }
                                        }
                                        ?>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo $reminder_statement;?>
                                        </h6>
                                        <h6>
                                            <i class="ti-time"></i> <?php echo date("M d, Y", strtotime($reminder['date']));?>
                                        </h6>
                                        <h5>
                                            <?php if($reminder['status']==0){?>
                                              <span class="label label-danger">Not Sent Yet</span>
                                            <?php } else{ ?>
                                              <span class="label label-success">Sent</span>
                                            <?php } ?>
                                        </h5>
                                    </div>
                                </li>
                                </ul>
                                </div>                                                      </div>
                                                        
                                                    </div>
                                                </div>
<!-- end Reminder modal -->
<?php
}
 }
}
?>