<div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="<?php echo IMG;?>login.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            
            <?php 
            $ref_url = isset($_GET['url_ref'])?$_GET['url_ref']:""; 
            ?>
			<div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">
                            <form id="RegisterForm" method="post" action="<?php echo SURL.'register/userSignupProcess';?>" autocomplete="off">
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="orange">
                                        <h4 class="card-title">Signup</h4>
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
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">title</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Company Name</label>
                                                <input type="text" id="companyName" name="companyName" class="form-control" uniqueCompany="true" required="true">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">First Name</label>
                                                <input type="text" id="firstName" name="firstName" class="form-control" required="true" lettersonly="true">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Last Name</label>
                                                <input type="text" id="lastName" name="lastName" class="form-control" required="true" lettersonly="true">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email address</label>
                                                <input type="text" id="email" name="email" class="form-control" email="true" uniqueEmail="true" required="true">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" id="password" name="password" class="form-control" required="true" autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Confirm Password</label>
                                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required="true" autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-group">
                                                <div class="form-check">
                                                <label class="form-check-label">
                                                  <input class="form-check-input" type="checkbox" name="accept" value="1" required="true">
                                                  <span class="form-check-sign">
                                                    <span class="check"></span>
                                                  </span>
                                                  <a class="btn btn-default btn-simple acceptBtn" target="_Blank" href="<?php echo SURL;?>TermsOfService">I accept the agreement</a></label>
                                              </div>
                                            </div>
                                      </div>
                                    </div>
                                    <div class="footer">
                                        <div class="text-center">
                                           <button type="submit" class="btn btn-warning btn-round">Signup</button>
                                         </div>
                                             <div class="pull-left">
                                             <a class="btn btn-warning btn-simple" href="<?php echo SURL;?>login">Already have an account? Sign In</a>
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