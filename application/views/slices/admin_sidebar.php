<div class="sidebar" data-active-color="orange" data-background-color="black" data-image="<?php echo IMG;?>sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
            <div class="logo">
                <a href="<?php echo AURL;?>dashboard" class="simple-text logo-mini">
                    PS
                </a>
                <a href="<?php echo AURL;?>dashboard" class="simple-text logo-small">
                    Project Software
                </a>
            </div>
			<?php 
			$controller1 = $this->uri->segment(2);
			$controller2 = $this->uri->segment(3);
			$controller3 = $this->uri->segment(4);
			if($controller2==""){
				$main_controller = $this->uri->segment(2);
			}
			else{
				$main_controller = $controller1."/".$controller2;
			}
			?>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="<?php echo ADMIN_PROFILE_IMG.$this->session->userdata("admin_avatar");?>" />
                    </div>
                    <div class="info">
                        <a class="parentMenu" data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                <?php echo $this->session->userdata("admin_firstname")." ".$this->session->userdata("admin_lastname");?>
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <div <?php if($controller1=="profile" || $controller1=="change_password"){ ?> class="collapse in" <?php } else { ?> class="collapse" <?php } ?>id="collapseExample">
                            <ul class="nav">
                                <li <?php if($controller1=="profile"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo AURL;?>profile">
                                        <span class="sidebar-mini">MP</span>
                                        <span class="sidebar-normal">My Profile</span>
                                    </a>
                                </li>
                                <li <?php if($controller1=="change_password"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo AURL;?>change_password">
                                        <span class="sidebar-mini">CP</span>
                                        <span class="sidebar-normal">Change Password</span>
                                    </a>
                                </li>
								 <li>
                                    <a href="<?php echo AURL;?>logout">
                                        <span class="sidebar-mini">L</span>
                                        <span class="sidebar-normal">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                       
                    </div>
                </div>
                <ul class="nav">
                    <li <?php if($main_controller=="dashboard"){ ?> class="active" <?php } ?>>
                        <a href="<?php echo AURL;?>dashboard">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li <?php if($main_controller=="help" || $main_controller=="help/add_help" || $main_controller=="help/edit_help"){ ?> class="active" <?php } ?>>
                        <a href="<?php echo AURL;?>help">
                            <i class="material-icons">help</i>
                            <p>Help</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>