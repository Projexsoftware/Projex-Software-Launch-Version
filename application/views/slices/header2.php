<nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?php
                          $page_title = $this->uri->segment(1);
                          if($page_title!=""){
                          if($page_title=="whats_new"){
                        ?>
<a class="navbar-brand" href="<?php echo SURL;?>whats_new">What's New</a>
                        
                        <?php } else{ ?>
<a class="navbar-brand" href="<?php echo SURL.$page_title;?>"><?php echo ucfirst($page_title);?></a>
                        <?php } }?>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?php echo SURL;?>dashboard" title="Dashboard">
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Dashboard</p>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SURL;?>profile" title="Profile">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li>
                            <li class="dropdown project_notifications">
                                <?php
                            $notifications = get_notifications($this->session->userdata("admin_id"), $this->session->userdata("admin_role_id"), 5);
                            $notifications_count = get_notifications($this->session->userdata("admin_id"), $this->session->userdata("admin_role_id"));
                            $unread_notifications = 0;
                            if(count($notifications_count)>0){
                              foreach($notifications_count as $val){
                                 if($this->session->userdata("admin_role_id")==1){
                                    if($val['is_admin_read']==0){
                                      $unread_notifications++;
                                    }
                                 }
                                 else{
                                    if($val['is_read']==""){
                                      $unread_notifications++;
                                    }
                                 }
                              }
                            }
                            ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification"><?php echo $unread_notifications;?></span>
                                    <p class="hidden-lg hidden-md">
                                        Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if(count($notifications)>0){ 
                                    foreach($notifications as $val){ 
if($this->session->userdata("admin_id")==$val['user_id']){
 $name ="You have";
}
else{
$name = $val['first_name']." ".$val['last_name']." has";
}
                                    ?>
                                    <li>
<?php $is_read = explode(",", $val['is_read']);
      $read_string = $this->session->userdata("admin_id").":1";
?>
                                        <a <?php if((in_array($read_string, $is_read) && $this->session->userdata("admin_role_id")>1) || ($val['is_admin_read']==1 && $this->session->userdata("admin_role_id")==1)){ ?> class="read_notification" <?php } ?> target="_Blank" href="<?php echo SURL;?>notifications/view/<?php echo $val['id'];?>"><?php echo $name.$val['notification_text'].$val['project_name'];?>.</a>
                                    </li>
                                    <?php } ?>
<hr>
<li><center><a href="<?php echo SURL;?>notifications" class="btn btn-primary btn-round btn-sm" style="width:100px;margin-bottom:15px;">View All<div class="ripple-container"></div></a></center></li>

<?php } else{ ?>
                                    <li>
                                        <a href="#">No Notifications Found</a>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                            </li>
                            

                            <li class="separator hidden-lg hidden-md"></li>
                            <li><a href="#" title="Last Login">
                                    <i class="material-icons">lock</i>
Last Login at <?php echo date("d/m/Y h:i a", strtotime($this->session->userdata("last_signin")));?> ( <?php echo $this->session->userdata("signing_ip");?> )</a></li>
                        </ul>
                        
                    </div>
                </div>
            </nav>