<html>
<head>
<!-- Bootstrap core CSS     -->
    <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo SURL;?>assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
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
<span style="font-size:20px;"><b>Project Name : </b><?php echo $project_name;?></span>
<?php 
$is_notes = 0;
if(count($tasks)>0){
foreach($tasks as $val){
  
$current_role = 1;
  
$notes = get_project_summary_notes($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($notes)>0){ 
$is_notes = 1;
?>
<h5 style="color:#ffffff;background-color: #e91e63;font-size: 13px;
    padding: 5px 15px;border-radius: 12px;text-transform: uppercase;border-color:#e91e63;width:50%;"><?php echo $val['task_name'];?></h5>
                                                         <ul style="margin:0px;" class="timeline timeline-simple">
                                                            <?php 
                                                            
                                                            foreach($notes as $note){ ?>

                                                          
                                <li style="border:1px solid #000000!important;">
                                    
                                    <div class="timeline-panel">
                                        
                                        <div class="timeline-heading">
                                            <br/><span class="label label-success" style="border-color:#4caf50;padding:5px 12px!important;border-radius:12px;"><?php echo $note['author'];?></span>
                                        </div>
                                        <div class="timeline-body">
                                            <br/><p><?php echo $note['note'];?></p>
                                        </div>
                                        <h6>
                                            <br/><i class="ti-time"></i><?php echo date("M d, Y", strtotime($note['date']));?>
                                        </h6>
                                    </div>
                                </li>
                                                                						 


                                                            <?php }
?>
</ul>
<?php 
}  
}
}
?>
</div>
</div>
</div>
</div>                                                      </div>
</body>
</html>
                                                        
                                                   