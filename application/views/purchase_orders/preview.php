    <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo IMG;?>apple-icon.png" />
    <link rel="icon" type="image/png" href="<?php echo IMG;?>favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo DEFAULT_TITLE;?> - <?php echo $title;?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo CSS;?>bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo CSS;?>material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo CSS;?>demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='<?php echo CSS;?>scheduler.min.css' rel='stylesheet' />
    <!-- Dropzone -->
	<link href='<?php echo ASSETS; ?>dropzone/dist/dropzone.css' rel="stylesheet"/>
	
    <script src="<?php echo JS;?>jquery-3.2.1.min.js" type="text/javascript"></script>
	<script>
      var base_url = "<?php echo SURL ?>";
    </script> 
</head>

<body>
    <div class="wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="padding-md">      
        <div class="panel panel-default">           
           
            <div class="table-responsive1">

             
                <div class="col-md-12" id="printvariation" style="">
                    <style>
                        .row2{
                            margin: 0px 0px 15px 0px;
                        }
                        .boom-custom-img-container {
                            padding-bottom: 15px;
                            padding-top: 15px;
                        }

                        .boom-custom-img-container .cusotm-banner {
                            height:100px;
                            width:100%;
                            background:#FC7B00;
                        }

                        .boom-custom-img-container img {

                        }

                        .boom-custom-section-1 {
                            margin-top: 10px
                        }

                        .boom-custom-section-1 h2 {
                            font-size: 20px;
                        }

                        .boom-custom-section-2 {
                            margin-top: 20px
                        }

                        .boom-custom-section-2 p {
                            color: #777777;
                            font-size: 15px;
                            text-align: right;
                            padding: 6px 0;
                        }

                        .boom-custom-section-2 .custom-underline {
                            display:inline-block;
                            width:30%;
                            height:auto;
                            background: transparent;
                            color: #6BAFBD;
                            border-bottom: 2px solid #777777;
                            text-align: center;
                        }

                        .boom-custom-section-3 {
                            margin-top: 10px
                        }

                        .boom-custom-section-3 p {
                            color: #777777;
                            font-size: 16px;
                            padding: 6px 0;
                            margin-bottom: 10px;
                        }

                        .boom-custom-section-3 .custom-underline {
                            display:inline-block;
                            background: transparent;
                            color: #6BAFBD;
                            border-bottom: 2px solid #777777;
                        }

                        .boom-custom-section-4 {
                            padding-bottom: 10px;
                        }

                        .boom-custom-section-4 .boom-custom-section-4-inner-1 {

                        }

                        .boom-custom-section-4 .boom-custom-section-4-inner-1 p {
                            color: #777777;
                            font-size: 15px;
                            text-align: left;
                            padding: 6px 0;
                        }

                        .boom-custom-section-4 .boom-custom-section-4-inner-2 {

                        }

                        .boom-custom-section-4 .boom-custom-section-4-inner-2 p {
                            color: #777777;
                            font-size: 15px;
                            text-align: right;
                            padding: 6px 0;
                        }

                        .boom-custom-section-5 {

                        }

                        .boom-custom-section-5 .boom-custom-section-5-inner-1 {

                        }

                        .boom-custom-section-5 .boom-custom-section-5-inner-1 p {
                            color: #777777;
                            font-size: 15px;
                            text-align: left;
                            padding: 6px 0;
                        }

                        .boom-custom-section-5 .boom-custom-section-5-inner-2 {

                        }

                        .boom-custom-section-5 .boom-custom-section-5-inner-2 p {
                            color: #777777;
                            font-size: 15px;
                            text-align: right;
                            padding: 6px 0;
                        }


                        .boom-custom-section-6 {

                        }

                        .boom-custom-section-6 p {
                            color: #777777;
                            font-size: 16px;
                            padding: 6px 0;
                        }

                        .boom-custom-section-6 .custom-underline {
                            background: transparent none repeat scroll 0 0;
                            color: #6bafbd;
                            display: inline-block;
                            height: auto;
                            text-align: center;
                            text-decoration:underline;
                        }

                        .boom-custom-section-6 .custom-underline-1 {
                            display:inline-block;
                            width:25%;
                            height:auto;
                            background: transparent;
                            color: #6BAFBD;
                            border-bottom: 2px solid #777777;
                            text-align: center;
                            margin-left: 10px;
                        }
                        
                        .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}
.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
    border-top: 0;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    padding: 12px 8px;
    vertical-align: middle;
}
.table>thead>tr>th {
    border-bottom-width: 1px;
    font-size: 1.25em;
    font-weight: 300;
}
.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}

                        @media print {
                            .form_not{
                                display: none !important;
                            }
                        }

                    </style>
                    <div class="row col-md-12 boom-custom-img-container">

                        <div class="col-md-6" style="float:left">
                            <div class="logo img-responsive"><img style="width: 400px;" src="<?php echo base_url(); ?>/assets/img/homeworx_logo.png"></div>
                        </div>
                        <div class="col-md-4" style="float:right">
                            <div class="logo img-responsive"><img style="width: 150px;" src="<?php echo base_url(); ?>/assets/img/boom_logo.png"></div>
                        </div>
                    </div>
                    <div class="col-md-12 boom-custom-section-1">
                        <h2 class="text-center">AUTHORISATION OF VARIATION OF THE WORK</h2>
                    </div>
                    
                    <div class="col-md-12 boom-custom-section-2">
                        <p>
                            Varation No :
                            <span class="custom-underline" style="display: inline-block;width: 25%;height: auto;background: transparent;color: #6BAFBD;border-bottom: 2px solid #777777;text-align: center;margin-left: 10px;"><?= $variation_detail['var_number'] ?></span>
                        </p>
                        <p>
                            Date :
                            <span class="custom-underline" style="display: inline-block;width: 25%;height: auto;background: transparent;color: #6BAFBD;border-bottom: 2px solid #777777;text-align: center;margin-left: 10px;"><?=  (date('jS F Y',strtotime($variation_detail['created_date']) ))?></span>
                        </p>
                    </div>
                    <div class="col-md-12 boom-custom-section-3">
                        <p>
                            I, <span class="custom-underline" style="display: inline-block;width: 25%;height: auto;background: transparent;color: #6BAFBD;border-bottom: 2px solid #777777;text-align: center;margin-left: 10px;"><?= $clientnameinfo['client_fname1'].' '.$clientnameinfo['client_surname1'].' '.$clientnameinfo['client_fname2'].' '.$clientnameinfo['client_surname2']?></span> authorise Chango Limited Trading as Homeworx to carry out the following variation and we agree
                            to pay any cost difference for the variation
                        </p>
                    </div>

                    <div class="col-md-12 row boom-custom-section-4" >

                        <table class="table" style="background-color:transparent!important;width: 100%;max-width: 100%;margin-bottom: 20px;">
                            <thead>
                            <tr>
                                <th style="background-color:transparent;padding: 12px 8px;vertical-align: middle;border-bottom-width: 1px;font-size: 1.25em;font-weight: 300;vertical-align: bottom;border-bottom: 2px solid #ddd;">Description</th>
                                <th style="background-color:transparent!important;text-align: right; width: 150px;padding: 12px 8px;vertical-align: middle;border-bottom-width: 1px;font-size: 1.25em;font-weight: 300;vertical-align: bottom;border-bottom: 2px solid #ddd;">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td style="background-color:transparent;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"><?php echo $variation_detail['variation_description']; ?></td>
                                <td align="right" style="background-color:transparent;text-align: right; width: 150px;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">$ <?php echo number_format($variation_detail['project_contract_price'],2,'.','') ?></td>
                            </tr>
                            <tr>
                            
                            <td  style="background-color:transparent;text-align: right;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Subtotal (NZD)</td>
                            <td style="background-color:transparent;text-align: right;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">$ <?php echo number_format($variation_detail['project_contract_price'],2,'.','');
                            $subtotal_amount = $variation_detail['project_contract_price'];
                            ?></td>
                        </tr> 
                       <tr>
                           
                            <td style="background-color:transparent;text-align: right; border-bottom: 3px solid black;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Includes GST at 15%</td>
                            <td style="background-color:transparent;text-align: right; border-bottom: 3px solid black;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">
                            <?php
                            $tax = ($subtotal_amount*3)/23;
                            ?>
                            $ <?=number_format($tax,2,'.','')?>
                            </td>
                        </tr>
                        <tr>
                            
                            <td  style="background-color:transparent;text-align: right;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">Total Payable (NZD)</td>
                            <td style="background-color:transparent;text-align: right;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">$ <?=number_format($subtotal_amount,2,'.','')?></td>
                        </tr> 
                            </tbody>
                        </table>

                    </div>

                    <div class="col-md-12 boom-custom-section-6" >
                        <p>Builder's Signature (or duty authorised representatives if applicable)<span class="custom-underline-1" style="display: inline-block;width: 25%;height: auto;background: transparent;color: #6BAFBD;border-bottom: 2px solid #777777;text-align: center;margin-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </p>
                        <p>Date :
                            <span class="custom-underline-1" style="display: inline-block;width: 30%;height: auto;background: transparent;color: #6BAFBD;border-bottom: 2px solid #777777;text-align: center;margin-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p>
                        <p>
                            I/We <span class="custom-underline"><?= $clientnameinfo['client_fname1'].' '.$clientnameinfo['client_surname1'].' '.$clientnameinfo['client_fname2'].' '.$clientnameinfo['client_surname2']?></span> hereby accept the above cost of the Variation.
                        </p>
                        <p>
                            Owner's Signature (or duty authorised representatives if applicable)  <span class="custom-underline-1" style="display: inline-block;width: 20%;height: auto;background: transparent;color: #6BAFBD;border-bottom: 2px solid #777777;text-align: center;margin-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </p>
                        <p>
                            Date : <span class="custom-underline-1" style="display: inline-block;width: 25%;height: auto;background: transparent;color: #6BAFBD;border-bottom: 2px solid #777777;text-align: center;margin-left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </p>

                    </div>
                </div>


            </div>
            <div class="clearfix"></div>
            <div class="clear"></div>
            <!-- /.padding-md -->
        </div><!-- /panel -->
    </div>
                </div>
            </div>
    </div>
</body>
</html>
    
