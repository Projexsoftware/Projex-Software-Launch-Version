<div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="red">
                                        <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                                    <h4 class="card-title">WAR CHEST REPORT</h4>
                                                    <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                        <i class="fa fa-user"></i> YOUR DETAILS
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                    <table class="table">
                                                      <tbody>
                                                          <tr>
                                                            <td >Business Name</td>
                                                            <td>&nbsp;</td>
                                                            <td width="160"><?php echo $report["business_name"];?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Your Name</td>
                                                            <td>&nbsp;</td>
                                                            <td width="160"><?php echo $report["your_name"];?></td>
                                                          </tr>
                                                          <tr>
                                                            <td >Email</td>
                                                            <td>&nbsp;</td>
                                                            <td width="160"><?php echo $report["email"];?></td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                                    <?php foreach($projects as $val){?>
                                                    <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                        <i class="fa fa-info"></i> PROJECT DETAILS
                                                        <div class="ripple-container"></div>
                                                    </button>
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
                                        <button class="btn btn-simple btn-github" style="font-size:16px;padding-left:0px;">
                                                <i class="fa fa-dollar"></i> Cash Details
                                            <div class="ripple-container"></div></button>
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
                                                    <br/>
                                                    <div class="form-footer text-right">
                                                     <a target="_Blank" href="<?php echo SURL;?>cashflow/export/<?php echo $id;?>" class="btn btn-success btn-fill">Export as PDF</a>
                                </div>
                            </div>
                        </div>
                    </div>
                