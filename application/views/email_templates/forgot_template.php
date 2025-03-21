<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<php echo IMG;?>apple-icon.png" />
    <link rel="icon" type="image/png" href="<php echo IMG;?>favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width" />
        <!-- Bootstrap core CSS     -->
    <link href="<php echo CSS;?>bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<php echo CSS;?>material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <link href="<php echo CSS;?>demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
     .email-container{
       width:500px;
       float:left;
      }
      h5{
       font-weight:500!important;
      }
      .email-header{
          float:left;
          width:98.4%;
          color:#fff;
          background-color:#ffa726;
          height:50px;
          text-align:center;
          padding:4px;
      }
      .email-body{
          float:left;
          width:100%;color:#fff;
          background-color:#191919;
          height:140px;
          text-align:center;
          background-image: url(<?php echo SURL;?>assets/img/login.jpeg);
          top: 0;
          left: 0;
          background-size: cover;
          background-position: center -132px;
          padding-top:10px;
       }
       .email-content{
           width:91.5%;
           border:1px solid #ccc;
           float:left;
           background-color: #fff;
           padding: 10px 20px;
       }
       .email-footer{
          float:left;
          width:100%;
          color:#fff;
          background-color:#191919;
          height:80px;
          text-align:center;
          padding-top:20px;
       }
       .btn_account{
             border-radius: 30px!important;
             background-color: #ffa726!important;
    color: #FFFFFF!important;
box-shadow: 0 2px 2px 0 rgba(233, 30, 99, 0.14), 0 3px 1px -2px rgba(233, 30, 99, 0.2), 0 1px 5px 0 rgba(233, 30, 99, 0.12);
border: none;
    position: relative;
    padding: 12px 30px!important;
    margin: 10px 1px!important;
    font-size: 12px!important;
    font-weight: 400!important;
    text-transform: uppercase!important;
    letter-spacing: 0;
    will-change: box-shadow, transform;
    transition: box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-block;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    text-decoration:none;
        }
    .btn-just-icon{
           padding: 11px 11px;
           line-height: 1em;
           color:transparent!important;
     }
     .text-center{
       text-align:center;
     }
    </style> 
</head>

<body class="off-canvas-sidebar">
              <div class="email-container"><div class="email-header"><h2>Project Software</h2></div><div class="email-body"><h3>YOUR Project Software PASSWORD</h3><p></p><a href="<?php echo SURL;?>" class="btn_account">ACCESS ACCOUNT</a></div><div class="email-content"><h3>Hi <?php echo $firstname;?>,</h3><p>As per your reset password request your password has been reset and below is your new password:</p><p><strong>Password: </strong><?php echo $password;?></p><p>Please change your password once you login to portal.</p></div><div class="email-footer"><div class="social-line">
                                            <a href="#btn" class="btn btn-just-icon btn-simple">
                                                <img src="<?php echo SURL;?>assets/img/social_icons/facebook.png">
                                            </a>
                                            <a href="#pablo" class="btn btn-just-icon btn-simple">
                                                <img src="<?php echo SURL;?>assets/img/social_icons/twitter.png">
                                            </a>
                                            <a href="#eugen" class="btn btn-just-icon btn-simple">
                                                <img src="<?php echo SURL;?>assets/img/social_icons/google-plus.png">
                                            </a>
                                        </div><p class="copyright text-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        Project Software. All rights reserved.
                    </p></div></div>
</body>
</html>