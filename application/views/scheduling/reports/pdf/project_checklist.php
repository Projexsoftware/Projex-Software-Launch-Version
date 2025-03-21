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
</head>
<body>
<div class="toolbar">
<span style="font-size:20px;"><b>Project Name : </b><?php echo $project_name;?></span>
<div class="toolbar">
<?php 
$is_checklist = 0;
if(count($tasks)>0){
foreach($tasks as $val){
  
  $current_role = 1;
  
  $checklists = get_project_summary_checklist($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($checklists)>0){ 
$is_checklist = 1;
?>
<h5 style="color:#ffffff;background-color: #e91e63;font-size: 13px;
    padding: 5px 15px;border-radius: 12px;text-transform: uppercase;border-color:#e91e63;width:50%;"><?php echo $val['task_name'];?></h5>
<div class="row">
<div class="col-md-12">
                                                         <ul class="list_container">
                                                        
                                                            <?php 
                                                            
                                                            foreach($checklists as $checklist){ 
                                                            $item_checklist = get_item_selected_checklists($checklist['item_id']);
                                                            
                                                            if($item_checklist!=""){$task_checklist = explode(",", $item_checklist);}else{ $task_checklist = array();}
                                                            
                                                            ?>

                                                            <li>
                                                                <div class="checkbox">
                                                    <label>
                                                        <?php if(in_array($checklist['id'], $task_checklist)){ ?>
                                                        <img src="<?php echo IMG;?>icons/done.png" style="width:12px;"> <?php } else{ ?> <input type="checkbox" class="form-control" disabled><?php }?>&nbsp;<?php echo $checklist['name'];?>
                                                        
                                                    </label>
                                                </div> 
                                                
                                                          </li><br>

                                                            <?php }  ?>
                                                         
                                                        </ul>
</div>
</div>
<?php 
}  
}
}
?>
</div>
</div>
</body>
</html>
                                                   