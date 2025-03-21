<div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="<?php echo IMG;?>login.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            
            <?php 
            $ref_url = isset($_GET['url_ref'])?$_GET['url_ref']:""; 
            ?>
			<div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form id="LoginForm" method="post" action="<?php echo SURL."login/validate_user/?url_ref=".$ref_url?>">
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="orange">
                                        <h4 class="card-title">Login</h4>
                                        <!--<div class="social-line">
                                            <a href="#btn" class="btn btn-just-icon btn-simple">
                                                <i class="fa fa-facebook-square"></i>
                                            </a>
                                            <a href="#pablo" class="btn btn-just-icon btn-simple">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                            <a href="#eugen" class="btn btn-just-icon btn-simple">
                                                <i class="fa fa-google-plus"></i>
                                            </a>
                                        </div>-->
                                    </div>
									<?php 
               if($this->session->flashdata("err_message")) {
            ?> 
            <p class="category text-center text-danger"><?php echo $this->session->flashdata("err_message"); ?></p>
            <?php 
            }
			?>
            <?php 
               if($this->session->flashdata("ok_message")) {
            ?> 
            <p class="category text-center text-success"><?php echo $this->session->flashdata("ok_message"); ?></p>
            <?php 
            }
			?>
			<br>
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email address</label>
                                                <input type="text" id="email" name="email" class="form-control" email="true" required="true" value="<?php if(isset($_COOKIE['user_remember_me'])) { echo $_COOKIE['user_remember_me']; }?>">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" required="true" value="<?php if(isset($_COOKIE['user_remember_me_pass'])) { echo $_COOKIE['user_remember_me_pass']; }?>">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-group">
                                                <div class="form-check">
                                                <label class="form-check-label">
                                                  <input class="form-check-input" type="checkbox" name="remember" value="1" <?php if(isset($_COOKIE['user_remember_me'])) { ?> checked <?php } ?>>
                                                  <span class="form-check-sign">
                                                    <span class="check"></span>
                                                  </span>
                                                  Remember Me</label>
                                              </div>
                                            </div>
                                      </div>
                                        <div class="input-group">
                                            <div class="form-group">
                                                <div class="form-check">
                                                  <label style="margin-left:20px;">
                                                    <a class="btn btn-warning btn-simple acceptBtn" target="_Blank" href="<?php echo SURL;?>TermsOfService">Terms and Conditions</a>
                                                  </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <div class="text-center">
                                           <button type="submit" class="btn btn-warning btn-round">Login</button>
                                         </div>
                                         <div class="card-footer">
                                             <div class="pull-left">
                                             <a href="<?php echo SURL;?>forgot" class="text-warning">Forgot Password?</a>
                                             </div>
                                             <div class="pull-right">
                                             <a href="<?php echo SURL;?>register" class="text-warning">Not Registered Yet?</a>
                                             </div>
                                         </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>