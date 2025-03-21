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
<?php
$order_info = get_order_info($order_no);
$total = '';
    $quantity = 0;
    $val = '';
    $sub_total = 0;
?>
<body class="off-canvas-sidebar">
              <div class="email-container">
                    <div class="email-header"><h2>Projex Software</h2></div>
                  <div class="email-body"><h3>New Order Request</h3><p>Congrats! You have received a new order request.</p><a href="<?php echo AURL;?>login" class="btn_account">ACCESS ACCOUNT</a></div>
                  <div class="email-content"><h3>Hi Admin,</h3><p>Below is the details of new order request:</p><p><h4><b><?php echo "#".$order_no." <small>".date('F, d Y', strtotime($created_date))." at ".date('h:ia', strtotime($created_date));?></small></b></h4></p><p><b>Customer : </b><?php echo $firstname." ".$lastname;?></p><p><b>Order Contact Email : </b><?php echo $email;?></p><p><b>Order Contact Number : </b><?php echo $mobile_no;?></p><p><b>Billing Address : </b><?php echo $address;?></p><p><p><h4 style="font-weight:bold;">Order Summary</h4></p>
                  <table class="table table-bordered" >
                            <tr> 
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Unit Price</th>
                                <th>QTY</th>
                                <th>Total price</th>

                            </tr>
                            <?php foreach($this->cart->contents() as $items): 
                            
                            ?>
                            <tr> 
                                <td>
                                 <img src="<?php echo ONLINE_STORE_IMAGES.$items['image']; ?>" style="width:50px!important;height:50px!important;" width="50px" height="50px">
                                </td>
                                <td><?php echo $items['name']; ?>
                                 <p><span class="pr_supplier bg-warning"><i class="linearicons-pointer-right"></i> <?php echo $items['category'];?></span></p>
                                 <p><span class="pr_supplier bg-warning"><i class="linearicons-truck"></i> <?php echo $items['supplier'];?></span></p>
                                </td>
                                <td>
                                    <span class="price"><?php echo CURRENCY.$this->cart->format_number($items["price"]);?></span>
                                       
                                </td>
                                <td><?php echo $items['qty']; ?> </td>
                                <td><?php echo CURRENCY.$this->cart->format_number($items["price"]*$items['qty']); ?> </td>

                            </tr>
                        <?php endforeach; ?>
                        <tfoot>
                            <tr> 
                                <td class="empty-cell"> </td>
                                <td colspan="3" align="right"><b>SubTotal:</b></td>
                                <td><?php echo CURRENCY.$this->cart->format_number($this->cart->total()); ?></td>
                            </tr>
                            <tr>
                                <td class="empty-cell"> </td>
                                <td colspan="3" align="right"><b>Shipping:</b></td>
                                <td>Free Shipping</td>
                            </tr>
                            <tr> 
                                <td class="empty-cell"> </td>
                                <td colspan="3" align="right"><b>Total:</b></td>
                                <td><?php 
                                $total = $this->cart->total();
                                echo CURRENCY.$this->cart->format_number($total);
                                 ?>
                                 </td>


                            </tr>
                        </tfoot>
                        </table></p>
                    <h3>Customer Information</h3>
                    <p>
                        <table border="0" style="width:50%;">
                            <tr>
                                <td><h4>Shipping Information</h4></td>
                                <td><h4>Billing Information</h4></td>
                            </tr>
                            <tr>
                                <td>
                                <?php echo $order_info["shipping_first_name"]. " ".$order_info["shipping_last_name"];?>
                                </td>
                                <td>
                                <?php echo $order_info["first_name"]. " ".$order_info["last_name"];?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                <?php echo $order_info["shipping_address"];?>
                                </td>
                                 <td>
                                <?php echo $order_info["address"];?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                <?php echo $order_info["shipping_city"]. " ".$order_info["shipping_zipcode"];?>
                                </td>
                                <td>
                                <?php echo $order_info["city"]. " ".$order_info["zipcode"];?>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                <?php echo $order_info["shipping_state"];?>
                                </td>
                                <td>
                                <?php echo $order_info["state"];?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4>Shipping Method</h4></td>
                                <td><h4>Payment Method</h4></td>
                            </tr>
                            <tr>
                                
                                <td><p>Free Shipping</td>
                                 <td> 
                                 
                                    <p><?php echo "Cash On Delivery (COD)";?> <?php echo CURRENCY.$this->cart->format_number($order_info['total']);?></p>
                                    
                                 </td>
                            </tr>
                        </table>
                        
                    </p>
                    
                    </div>
                        <div class="email-footer"><div class="social-line">
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
                        Projex Software. All rights reserved.
                    </p></div></div>
</body>
</html>