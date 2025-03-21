<html>
<head>
<!-- Bootstrap core CSS     -->
    <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo SURL;?>assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="toolbar">
        <h4>From : <?php echo $from;?> &nbsp;&nbsp;&nbsp;&nbsp;To : <?php echo $to;?></h4>
        <span style="font-size:20px;"><b>Project Name : </b><?php echo $project_name;?></span>
        <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td><b>Project Log</b></td>
                                                                <td colspan="4"><center><b><?php echo $project_name;?></b></center></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Date</b></td>
                                                                <td><b>User</b></td>
                                                                <td><b>Entity Type</b></td>
                                                                <td><b>Notes</b></td>
                                                                <td><b>Image</b></td>
                                                            </tr>
                                                        </thead>
                                                         <tbody class="project-logs-container">
                                                             <?php 
                                                                if(count($project_logs)>0){
                                                                foreach($project_logs as $val){ ?>
                                                                <tr>
                                                                    <td><?php echo date("d/m/Y", strtotime($val['date']));?></td>
                                                                    <td><?php echo get_user_name($val["user_id"]);?></td>
                                                                    <td><?php echo $val['entity_type'];?></td>
                                                                    <td><?php echo $val['notes'];?></td>
                                                                    <td align="center">
                                                                     <?php if($val['image']!=""){ ?>
                                                                      <img style="width:200px;height:150px;" src="<?php echo SURL.'assets/scheduling/project_logs/'.$val['image'];?>"> 
                                                                      <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php } } else{ ?>
                                                                <tr><td colspan="5">No Project Logs Found!</td></tr>
                                                                <?php } ?>
                                                         </tbody>
                                                     </table>                               													
    </div>                                                       
</body>
</html>                                           