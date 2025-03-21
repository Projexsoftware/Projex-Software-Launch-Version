<html>
    <head>
        <!-- Bootstrap core CSS     -->
    <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo SURL;?>assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo SURL;?>public_html/assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
.timeline {
    list-style: none;
    padding: 20px 0 20px;
    position: relative;
    margin-top: 30px;
}

.timeline:before {
    top: 50px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 3px;
    background-color: #E5E5E5;
    left: 50%;
    margin-left: -1px;
}

.timeline h6 {
    color: #333333;
    font-weight: 400;
    margin: 10px 0px 0px;
}

.timeline.timeline-simple {
    margin-top: 30px;
    padding: 0 0 20px;
}

.timeline.timeline-simple:before {
    left: 5%;
    background-color: #E5E5E5;
}

.timeline.timeline-simple>li>.timeline-panel {
    width: 86%;
}

.timeline.timeline-simple>li>.timeline-badge {
    left: 5%;
}

.timeline>li {
    margin-bottom: 20px;
    position: relative;
}

.timeline>li:before,
.timeline>li:after {
    content: " ";
    display: table;
}

.timeline>li:after {
    clear: both;
}

.timeline>li>.timeline-panel {
    width: 45%;
    float: left;
    padding: 20px;
    margin-bottom: 20px;
    position: relative;
    box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
    border-radius: 6px;
    color: rgba(0, 0, 0, 0.87);
    background: #fff;
}

.timeline>li>.timeline-panel:before {
    position: absolute;
    top: 26px;
    right: -15px;
    display: inline-block;
    border-top: 15px solid transparent;
    border-left: 15px solid #e4e4e4;
    border-right: 0 solid #e4e4e4;
    border-bottom: 15px solid transparent;
    content: " ";
}

.timeline>li>.timeline-panel:after {
    position: absolute;
    top: 27px;
    right: -14px;
    display: inline-block;
    border-top: 14px solid transparent;
    border-left: 14px solid #FFFFFF;
    border-right: 0 solid #FFFFFF;
    border-bottom: 14px solid transparent;
    content: " ";
}

.timeline>li>.timeline-badge {
    color: #FFFFFF;
    width: 50px;
    height: 50px;
    line-height: 51px;
    font-size: 1.4em;
    text-align: center;
    position: absolute;
    top: 16px;
    left: 50%;
    margin-left: -24px;
    z-index: 100;
    border-top-right-radius: 50%;
    border-top-left-radius: 50%;
    border-bottom-right-radius: 50%;
    border-bottom-left-radius: 50%;
}

.timeline>li>.timeline-badge.primary {
    background-color: #9c27b0;
    box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(156, 39, 176, 0.4);
}

.timeline>li>.timeline-badge.success {
    background-color: #4caf50;
    box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(76, 175, 80, 0.4);
}

.timeline>li>.timeline-badge.rose {
    background-color: #e91e63;
    box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(76, 175, 80, 0.4);
}

.timeline>li>.timeline-badge.warning {
    background-color: #ff9800;
    box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(255, 152, 0, 0.4);
}

.timeline>li>.timeline-badge.info {
    background-color: #00bcd4;
    box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(0, 188, 212, 0.4);
}

.timeline>li>.timeline-badge.danger {
    background-color: #f44336;
    box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(244, 67, 54, 0.4);
}

.timeline>li>.timeline-badge [class^="ti-"],
.timeline>li>.timeline-badge [class*=" ti-"],
.timeline>li>.timeline-badge [class="material-icons"] {
    line-height: inherit;
}

.timeline>li.timeline-inverted>.timeline-panel {
    float: right;
    background-color: #FFFFFF;
}

.timeline>li.timeline-inverted>.timeline-panel:before {
    border-left-width: 0;
    border-right-width: 15px;
    left: -15px;
    right: auto;
}

.timeline>li.timeline-inverted>.timeline-panel:after {
    border-left-width: 0;
    border-right-width: 14px;
    left: -14px;
    right: auto;
}

.timeline-heading {
    margin-bottom: 15px;
}

.timeline-title {
    margin-top: 0;
    color: inherit;
}

.timeline-body hr {
    margin-top: 10px;
    margin-bottom: 5px;
}

.timeline-body .btn {
    margin-bottom: 0;
}

.timeline-body>p,
.timeline-body>ul {
    margin-bottom: 0;
}

.timeline-body>p+p {
    margin-top: 5px;
}
.label {
    border-radius: 12px!important;
    padding: 5px 12px!important;
    text-transform: uppercase;
    font-size: 10px;
}
.label.label-inverse {
    background-color: #212121;
}

.label.label-primary {
    background-color: #9c27b0;
}

.label.label-success {
    background-color: #4caf50;
    border:1 px solid #4caf50;
    border-radius:12px;
    padding:5px 12px;
}

.label.label-info {
    background-color: #00bcd4;
}

.label.label-warning {
    background-color: #ff9800;
}

.label.label-danger {
    background-color: #f44336;
}

.label.label-rose {
    background-color: #e91e63!important;
    color:#000!important;
}
</style>
    </head>
    <body>
<div class="toolbar">
<h4>From : <?php echo $from;?> &nbsp;&nbsp;&nbsp;&nbsp;To : <?php echo $to;?></h4>
    <?php
$is_daily_summary = 0;
if(count($projects)>0){
foreach($projects as $project){
$activities = get_daily_summary_by_project($project['id'], $from, $to);
?>
<h5 class="label label-warning" style="background-color: #ff9800;    border-radius: 12px;
    padding: 5px 12px;
    text-transform: uppercase;
    font-size: 12px;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;"><?php echo $project['name'];?></h5>
<div class="row">
                    <div class="col-md-8 col-md-offset-2">
                            
                                <ul class="timeline timeline-simple" style="margin-left:6px;margin-top:0px;padding-top:0px;">
                                <?php if(count($activities)>0){
                                 $is_daily_summary = 1;
                                 $counter = 0;
                                 $link="";
                                 foreach($activities as $val){ 
                                 $activity_type = explode("_", $val['activity_type']);
                                 
                                 $project_role = get_user_project_role($val['project_id'], $this->session->userdata("user_id"));
                                  $current_role = $project_role['team_role'];
                                  if($current_role==""){
                                    $current_role = 1;
                                  }
                                 $is_activity_public = is_activity_public($val['activity_id'], $activity_type[1]);
                               
                                 if((($current_role==1 || $current_role==2) || ($current_role>2 && $is_activity_public==1 && $activity_type[1]!="reminder"))){
                                 
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
                                 if($val['activity_type']=="add_note"){
                                  $activity =$posted_by."added a new note under (<b>Stage : </b>".$val['stage_name']." ) with (<b>Task : </b>".$val['task_name']." )";
                                  if(count(get_note_details($val['activity_id']))>0){
                                  $link = '<a class="btn btn-round btn-sm btn-rose" data-toggle="modal" data-target="#ViewNoteModal'.$val['id'].'"><i class="material-icons">art_track</i> View</a>';
                                  }
                                      
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
                                <li class="timeline-inverted activity_item">
                                    <div class="timeline-badge <?php echo $class_name;?>">
                                        
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <!--<span class="label label-<?php echo $class_name;?>"><?php echo $val['project_name'];?></span>-->
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $activity;?></p>
                                        </div>
                                        <h6>
                                            <br><?php echo get_time_diff($val['created_at']);?> on <?php echo date("d/m/Y", strtotime($val['created_at']));?> at <?php echo date("h:i a", strtotime($val['created_at']));?>
                                        </h6>
                                        
                                    </div>
                                </li><br><br>
                                <?php } } }?>
                               </ul>
                                    
                                </div>
</div>
<?php } } ?>
  </body>
</html>
                                                        
                                                   