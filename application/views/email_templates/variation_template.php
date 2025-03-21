<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <style>
     .material-icons img{
       width:24px;
       height:20px;
     }
     .card-title{
       font-weight: bold!important;
       padding-left: 45px!important;
     }
     a{
       text-decoration:none;
       color:#000!important;
     }
     body{
      font-family: "Roboto", "Helvetica", "Arial", sans-serif;
     }
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
          height:100px;
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
           color:#000;
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
             border-radius: 30px;
             background-color: #e91e63;
    color: #FFFFFF;
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

     table{
       width:100%;
     }

     td{
       padding: 12px 8px;
       vertical-align: middle;
       border-top: 1px solid #ddd;
     }

     .card-header{
       background: linear-gradient(60deg, #ec407a, #d81b60);
       margin: -20px 15px 0;
       border-radius: 3px;
    padding: 15px;
    background-color: #999999;
    position: relative;
    color: #fff;
    width:25px;
    float:left;
    z-index:3;
     }
    .card-title{
       margin-top: 0;
       margin-bottom: 30px;
           font-family: "Roboto", "Helvetica", "Arial", sans-serif;
    font-weight: 300;
    line-height: 1.5em;
     }
    .card{
      display: inline-block;
    position: relative;
    width: 100%;
    margin: 25px 0;
    box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
    border-radius: 6px!important;
    color: rgba(0, 0, 0, 0.87);
    background: #fff!important;
    border:1px solid #ddd;
     }
    .card .card-content {
    padding: 15px 20px;
    position: relative;
    }
    .material-icons {
    font-family: 'Material Icons';
    font-weight: normal;
    font-style: normal;
    font-size: 24px;
    line-height: 1;
    letter-spacing: normal;
    text-transform: none;
    display: inline-block;
    white-space: nowrap;
    word-wrap: normal;
    direction: ltr;
    -webkit-font-feature-settings: 'liga';
    -webkit-font-smoothing: antialiased;
}
    </style> 
</head>

<body class="off-canvas-sidebar">
              <div class="email-container"><div class="email-header"><h2>Project Software</h2></div><div class="email-body"><h3>Contract</h3><p>You have a new contract.</p></div><div class="email-content"><h3>Hi <?php echo $email;?>,</h3>
                        <div class="col-md-12">
                                    <p>Dear Customer there is some Variations in your contract Listing Showing in Attachment.</p></div></div>
                                <div class="email-footer"><div class="social-line">
                                            <a class="btn btn-just-icon btn-simple">
                                                <img src="<?php echo SURL;?>assets/img/social_icons/facebook.png">
                                            </a>
                                            <a class="btn btn-just-icon btn-simple">
                                                <img src="<?php echo SURL;?>assets/img/social_icons/twitter.png">
                                            </a>
                                            <a class="btn btn-just-icon btn-simple">
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