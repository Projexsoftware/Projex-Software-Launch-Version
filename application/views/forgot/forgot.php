<div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="<?php echo IMG;?>login.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
			<div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form id="ForgotForm" method="post" action="<?php echo SURL."forgot/reset_password";?>">
                                <div class="card card-profile card-hidden card-forgot">
                                    <div class="card-avatar">
                                    <a href="<?php echo SURL;?>">
                                      <img class="avatar" src="<?php echo SURL;?>assets/img/forgot-icon.png" alt="...">
                                    </a>
                               </div>
									
                                    <div class="card-content">
                                        <h4 class="card-title">Forgot Password</h4>
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
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email address</label>
                                                <input type="text" id="email" name="email" class="form-control" email="true" required="true" checkEmail="true">
                                            </div>
                                        </div>
                                        
                                    <div class="footer text-center">
                                        <button type="submit" class="btn btn-warning btn-round">Reset Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>