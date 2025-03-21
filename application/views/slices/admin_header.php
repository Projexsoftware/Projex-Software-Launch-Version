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
                          $page_title = $this->uri->segment(2);
                          
                            $url = AURL;  
                         
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
                        
                        <?php } else if($page_title=="projects" && $url==SCURL){
                        ?>
<a class="navbar-brand" href="<?php echo SCURL;?>projects">Construction Management</a>
                        
                        <?php } else if($page_title=="dashboard" && $url==SCURL){
                        ?>
<a class="navbar-brand" href="<?php echo SCURL;?>dashboard">Dashboard and Whats New</a>
                        
                        <?php } else{ ?>
<a class="navbar-brand" href="<?php echo $url.$page_title;?>"><?php echo ucwords(str_replace("_", " ", $page_title));?></a>
                        <?php } }?>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?php echo AURL;?>dashboard" title="Dashboard">
                                    <i class="material-icons">dashboard</i>
                                    <p class="hidden-lg hidden-md">Dashboard</p>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo AURL;?>profile" title="Profile">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li>
                            
                            <li class="separator hidden-lg hidden-md"></li>
                            <li><a href="#" title="Last Login">
                                    <i class="material-icons">lock</i>
Last Login at <?php echo date("d/m/Y h:i a", strtotime($this->session->userdata("admin_last_signin")));?> ( <?php echo $this->session->userdata("admin_signing_ip");?> )</a></li>
                        </ul>
                        
                    </div>
                </div>
            </nav>