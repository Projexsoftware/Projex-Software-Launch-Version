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
                          $url = $page_title=="scheduling"?SCURL:SURL;
                          if($page_title=="scheduling" || $page_title == "manage" || $page_title == "setup"){
                            $page_title = $this->uri->segment(2);
                            $main_url = $url.$this->uri->segment(1)."/";
                          }
                          else{
                              $main_url = $url;
                          }
                          
                            
                          if($page_title!=""){
                          if($page_title=="whats_new"){
                        ?>
<a class="navbar-brand" href="<?php echo SCURL;?>whats_new">What's New</a>
                        
                        <?php } else if($page_title=="change_password"){
                        ?>
<a class="navbar-brand" href="<?php echo SURL;?>change_password">Change Password</a>
                        
                        <?php } else if($page_title=="xero_settings"){
                        ?>
<a class="navbar-brand" href="<?php echo SURL;?>xero_settings">Xero Settings</a>
                        
                        <?php } else if($page_title=="payment_settings"){
                        ?>
<a class="navbar-brand" href="<?php echo SURL;?>payment_settings">Payment Settings</a>
                        
                        <?php } else if($page_title=="projects" && $url==SCURL){
                        ?>
<a class="navbar-brand" href="<?php echo SCURL;?>projects">Construction Management</a>
                        
                        <?php } else if($page_title=="dashboard" && $url==SCURL){
                        ?>
<a class="navbar-brand" href="<?php echo SCURL;?>dashboard">Dashboard and Whats New</a>
                        
                        <?php } else if($page_title=="welcome"){
                        
                         } 
                        
                        else{ ?>
<a class="navbar-brand" href="<?php echo $main_url.$page_title;?>"><?php echo ucwords(str_replace("_", " ", $page_title));?></a>
                        <?php } }?>
                    </div>
                    <?php 
            			$controller1 = $this->uri->segment(1);
            			$controller2 = $this->uri->segment(2);
            			$controller3 = $this->uri->segment(3);
            			if($controller2==""){
            				$main_controller = $this->uri->segment(1);
            			}
            			else{
            				$main_controller = $controller1."/".$controller2;
            			}
            		?>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-left">
                        <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" title="Settings">
                                    <i class="material-icons">settings</i>
                                    <p class="hidden-lg hidden-md">Settings</p>
                                </a>
                                <ul class="dropdown-menu">
                                <li <?php if($controller1=="profile"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>profile">
                                        <span class="sidebar-normal">My Profile</span>
                                    </a>
                                </li>
                                <?php if($this->session->userdata("company_id") == $this->session->userdata('user_id')){ ?>
                                <!--<li <?php if($controller1=="subscription"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>subscription">
                                        <span class="sidebar-normal">Upgrade Subscription Plan</span>
                                    </a>
                                </li>-->
                                <?php } ?>
                                <li <?php if($controller1=="change_password"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>change_password">
                                        <span class="sidebar-normal">Change Password</span>
                                    </a>
                                </li>
                                <?php
                                   if(in_array(124, $this->session->userdata("permissions"))) {
                                ?>
                                <li <?php if($controller1=="xero_settings"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>xero_settings">
                                        <span class="sidebar-normal">Xero Settings</span>
                                    </a>
                                </li>
                                <?php } ?>
                                <li <?php if($controller1=="terms_and_conditions"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>terms_and_conditions">
                                        <span class="sidebar-normal">Terms and Conditions</span>
                                    </a>
                                </li>
                                <?php
                                   if(in_array(164, $this->session->userdata("permissions"))) {
                                ?>
                                <!--<li <?php if($controller1=="payment_settings"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>payment_settings">
                                        <span class="sidebar-normal">Payment Settings</span>
                                    </a>
                                </li>-->
                                <?php } ?>
								 <li>
                                    <a href="<?php echo SURL;?>logout">
                                        <span class="sidebar-normal">Logout</span>
                                    </a>
                                </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo SURL;?>help" title="Help Section">
                                    <img src="<?php echo ASSETS;?>images/help-icon.png" class="help-icon">
                                    <p class="hidden-lg hidden-md">Help Section</p>
                                </a>
                            </li>
                            <?php
                               if(in_array(97, $this->session->userdata("permissions")) && in_array(98, $this->session->userdata("permissions"))) {
                            ?>
                            <li>
                                <a href="<?php echo SURL;?>tickets" title="Your Tickets">
                                    <img src="<?php echo ASSETS;?>images/ticket-icon.png" class="ticket-icon">
                                    <p class="hidden-lg hidden-md">Your Tickets</p>
                                </a>
                            </li>
                            <?php } ?>
                            </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?php echo SURL;?>dashboard" title="Dashboard">
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Dashboard</p>
                                </a>
                            </li>
                            
                            <li class="separator hidden-lg hidden-md"></li>
                            <?php if(in_array(154, $this->session->userdata("permissions"))) { ?>
                            <li class="dropdown project_notifications">
                                <?php
                            $notifications = get_notifications($this->session->userdata("user_id"),  5);
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
                                                                                <a <?php if((in_array($read_string, $is_read))) { ?> class="read_notification" <?php } ?> target="_Blank" href="<?php echo SCURL;?>notifications/view/<?php echo $val['id'];?>"><?php echo $name.$val['notification_text'].$val['project_name'];?>.</a>
                                                                            </li>
                                                                            <?php } ?>
                                        <hr>
                                        <li><center><a href="<?php echo SCURL;?>notifications" class="btn btn-warning btn-sm" style="width:100px;margin-bottom:15px;">View All<div class="ripple-container"></div></a></center></li>
                                        
                                        <?php } else{ ?>
                                                                            <li>
                                                                                <a href="javascript:void(0)">No Notifications Found</a>
                                                                            </li>
                                                                            <?php } ?>
                                    
                                </ul>
                                </div>
                            </li>
                            <?php } ?>
                            <li class="separator hidden-lg hidden-md"></li>
                            <li><a href="#" title="Last Login">
                                    <i class="material-icons">lock</i>
Last Login at <?php echo date("d/m/Y h:i a", strtotime($this->session->userdata("last_signin")));?> ( <?php echo $this->session->userdata("signing_ip");?> )</a></li>
                        </ul>
                        
                    </div>
                </div>
            </nav>