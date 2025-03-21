<html>
    <head>
        <title>
            WAR CHEST REPORT FOR <?php echo $report["your_name"];?> of <?php echo $report["business_name"];?>
        </title>
        <style>
            p{
                font-size:12px;
                width:100%;
            }
            body{
                        font-family:"century-gothic", sans-serif!important;
            }
            .col-md-offset-2 {
                margin-left: 16.66666667%;
               }
               .col-md-8 {
                 width: 66.66666667%;
               }
               .panel-title, .card-title{
                   text-align:center;
               }
               th{
                   font-weight:bold;
               }
               td, th {
            		padding: 8px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border-top: 1px solid #ddd;
            	}
        </style>
    </head>
    <body>
        <div class="row">
                        <div class="col-md-12">
                            <h4>WAR CHEST REPORT FOR <?php echo $report["your_name"];?> of <?php echo $report["business_name"];?> </h4>
                            <h4><b>Date Created:</b> <?php echo date("d/m/Y");?> </h4>
                            <h5>YOUR CASH TODAY (Including available Overdraft): $<?php echo number_format($available_funds_today, "2", ".", ",");?></h5>
 
<p><b>Q: Why does this differ to my bank balance? </b></p>
<p><b>A:</b> If there is a difference between the invoices you have paid compared to what should be paid at this stage of construction an adjustment needs to be made for funds you may have, but are holding on behalf of the client for future project payments. This value is the cash YOU own today.</p>
 
<p><b>Q: What does YOUR CASH TODAY mean?</b></p>
<?php if($available_funds_today>$current_overdraft_limit){ ?>
<p><b>A:</b> You have cash available today.</p> 
<?php } else{ ?>
<p><b>A:</b> You don’t have any available cash today. You should seek to introduce some working capital into your business.</p> 
<?php } ?>
 
<h5>THIS IS YOUR WAR CHEST NOW (Including available Overdraft): $<?php echo number_format($war_chest_now, "2", ".", ",");?> </h5>
 
<p>This is the amount of cash you have available for overhead and operating expenses during the lockdown.<?php if($war_chest_now>$current_overdraft_limit){ ?> After you collect money from outstanding sales invoices and paying current bills, you have cash available in your War Chest.<?php } else{ ?> After you collect money from outstanding sales invoices and paying current bills, you have NO cash available in your War Chest. You need to raise some more working capital.<?php } ?></p> 
 
 
 
 
<h5>THIS IS WHAT IS EXPECTED IN YOUR WAR CHEST AT THE END OF THE SHUTDOWN (Including available overdraft): $<?php echo number_format($your_expected_war_chest_at_the_end_of_shut_down, "2", ".", ",");?></h5>  
 <?php if($your_expected_war_chest_at_the_end_of_shut_down>$current_overdraft_limit){ ?>
<p>Congratulations, when your predicted period of the shutdown ends you still have cash available in your War Chest.</p>
<?php } else{ ?>
<p>When your predicted period of the shutdown ends, you have NO cash available in your War Chest. You need to raise some more working capital. </p>
<?php } ?>
 
 
 
 
<p style="font-size:11px;"><b>Disclaimer:</b> This report has been prepared based on the information you inputted along with some generalised assumptions. This report is intended to forecast your cash position, however, gives no assurance that this will be your true cash position at a given time. For detailed financial advice you should contact your accountant, banker and/or your financial advisor.</p>
                        </div>
                    </div>
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;font-weight:bold;padding:20px 0px">
                                                        <i class="fa fa-user"></i> <b>YOUR DETAILS</b>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    <br/>
                                                    <table class="table">
                                                      <tbody>
                                                          <tr>
                                                            <td >Business Name</td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td width="160"><?php echo $report["business_name"];?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Your Name</td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td width="160"><?php echo $report["your_name"];?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Email</td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td width="160"><?php echo $report["email"];?></td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                                    <?php foreach($projects as $val){?>
                                                    <br/>
                                                    <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;font-weight:bold;padding:20px 0px">
                                                        <i class="fa fa-info"></i> <b>PROJECT DETAILS</b>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    <br/>
                                                    <table class="table">
                                                      <tbody>
                                                          <tr>
                                                            <td>Project Name</td>
                                                            <td>&nbsp;</td>
                                                            <td width="160"><?php echo $val["project_name"];?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Project Contract Price</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($val["project_contract_price"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Value of Contract Variations</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($val["value_of_contract_variations"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Total Value of Sales Invoices Issued</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($val["total_value_of_sales_invoices_issued"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Total value of outstanding Sales Invoices</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($val["total_value_of_outstanding_sales_invoices"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Project Contract Budget</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($val["project_contract_budget"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Value of extra costs due to variations (or other factors)</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($val["value_of_extra_cost_due_to_variations"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Total Bills received from Suppliers & Subbies</td>
                                                            <td>$</td>
                                                            <td  width="160"><?php echo number_format($val["total_bills_received_from_suppliers_and_subbies"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Total Value of unpaid bills for this job</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($val["total_value_of_unpaid_bill"], 2, ".", ",");?></td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                        <?php } ?>
                                        <br/>
                                        <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;font-weight:bold;padding:20px 0px">
                                                <i class="fa fa-dollar"></i> <b>Cash Details</b>
                                            <div class="ripple-container"></div></button>
                                            <br/>
                                        <table class="table">
                                                      <tbody>
                                                          <tr>
                                                            <td>Total Cash in your bank account</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($report["total_cash_in_your_bank_account"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Current Overdraft Limit</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($report["current_overdraft_limit"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Value of employee subsidy (If not included in cash above)</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($report["value_of_employee_subsidy"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Wages and drawings to be paid during the shut down period</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($report["wages_and_drawings_to_be_paid"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Other Costs to be paid during the shut down</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($report["other_costs_to_be_paid"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Tax and GST to be paid during the shut down</td>
                                                            <td>$</td>
                                                            <td width="160"><?php echo number_format($report["tax_and_gst_to_be_paid"], 2, ".", ",");?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>Any revenue expected during the shut down</td>
                                                            <td>$</td>
                                                            <td  width="160"><?php echo number_format($report["any_revenue_expected"], 2, ".", ",");?></td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
    </body>
</html>


                