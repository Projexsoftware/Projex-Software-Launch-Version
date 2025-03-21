<div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="<?php echo IMG;?>login.jpeg">
            <div class="content">
                <div class="container">
                    <div class="row justify-content-center">
              	        <div class="col-md-12 text-center">
              	            <div class="card">
              	                <div class="card-content">
              	              	 <h1>Thankyou</h1>
              	              	 <h3>Congratulations! you are registered with us now :)</h3>
              	              	 <p style="font-size:18px;margin:25px 0px;"><?php echo str_replace("@", $this->session->userdata("register_email"), "A verification link has been sent to your email account <b>@</b>. Please click the link to complete the registration process.");?></p>
            					 <a href="<?php echo SURL;?>" role="button" class="btn btn-round btn-success">Back To Home</a>	
              	              </div>
              	           </div>
              	        </div>
            		</div>	 
            	</div>
            </div>
        </div>
</div>