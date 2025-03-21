<?php
                            $notifications = get_notifications($this->session->userdata("user_id"), 5);
                            $notifications_count = get_notifications($this->session->userdata("user_id"));
                            $unread_notifications = 0;
                            if(count($notifications_count)>0){
                              foreach($notifications_count as $val){
                                 
                                    if($val['is_read']==""){
                                      $unread_notifications++;
                                    }
                                 
                              }
                            }
                            ?>
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification"><?php echo $unread_notifications;?></span>
                                    <p class="hidden-lg hidden-md">
                                        Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div>
                                <ul class="dropdown-menu">
                                    <?php if(count($notifications)>0){ 
                                    foreach($notifications as $val){ 
if($this->session->userdata("user_id")==$val['user_id']){
 $name ="You have";
}
else{
$name = $val['first_name']." ".$val['last_name']." has";
}
                                    ?>
                                    <li>
                                        <?php $is_read = explode(",", $val['is_read']);
      $read_string = $this->session->userdata("user_id").":1";
?>
                                        <a <?php if((in_array($read_string, $is_read) && $this->session->userdata("admin_role_id")>1) || ($val['is_admin_read']==1 && $this->session->userdata("admin_role_id")==1)){ ?> class="read_notification" <?php } ?> target="_Blank" href="<?php echo SURL;?>notifications/view/<?php echo $val['id'];?>"><?php echo $name.$val['notification_text'].$val['project_name'];?>.</a>
                                    </li>
                                    <?php } ?>
<hr>
<li><center><a href="<?php echo SURL;?>notifications" class="btn btn-primary btn-round btn-sm" style="width:100px;margin-bottom:15px;">View All<div class="ripple-container"></div></a></center></li>

<?php } else{ ?>
                                    <li>
                                        <a href="javascript:void(0)">No Notifications Found</a>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                                </div>