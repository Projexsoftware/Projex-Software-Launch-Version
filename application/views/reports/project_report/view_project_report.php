<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Project Report</h4> 
                                    <div class="toolbar">
                                        <?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
									</div>
									<div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                    <form method="post" id="reportForm" action="<?php echo SURL; ?>reports/view_project_report_details" autocomplete="off">
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Project to View Report <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="project_id" id="project_id" title="Select Project" data-live-search="true" required>
                                                                    <?php foreach ($projects as $project) { ?>
                                                                        <option value="<?php echo $project["costing_id"]; ?>"><?php echo $project["project_title"]; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    <div id="report" >
                                                        <table  class="table table-bordered table-striped table-hover" >
                                                            <tr>
                                                                <td >Project Costing subtotal</td>
                                                                <td colspan="2" class="text-right">$<span id="total_cost"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Overhead margin <small>*</small></td>
                                                                <td>%</td>
                                                                <td ><input class="form-control cal-on-change" name="overhead_margin" id="overhead_margin" value="0.00" required></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Profit margin <small>*</small></td>
                                                                <td>%</td>
                                                                <td ><input class="form-control cal-on-change" name="profit_margin" id="profit_margin" value="0.00" required></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Project subtotal</td>
                                                                <td colspan="2" class="text-right">$<span id="total_cost2"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Tax</td>
                                                                <td>%</td>
                                                                <td ><input class="form-control cal-on-change" name="costing_tax" id="costing_tax" value="0.00" required></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Project subtotal</td>
                                                                <td colspan="2" class="text-right">$<span id="total_cost3"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Project price rounding <small>*</small></td>
                                                                <td>$</td>
                                                                <td ><input class="form-control cal-on-change roundme" name="price_rounding" id="price_rounding" value="0.00" required></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Project contract price</td>
                                                                <td colspan="2" class="text-right">$<span id="contract_price"></span></td>
                                                            </tr>
                                                             <tr>
                                                                <td >Projected profit</td>
                                                                <td colspan="2" class="text-right">$<span id="projectedprofit"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr class="variation_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#normal_variations" class="btn btn-info" onclick="get_variations('normal');">View Variations</button>
                                                                    </div>
                                                                    <div id="normal_variations" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from variations excluding GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostvare"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from variations including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostvari"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra sales from variations</td>
                                                                <td colspan="2" class="text-right">$<span id="extrasalevar"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Profit from variations including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="proextrasalevar"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr class="variation_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#purord_variations" class="btn btn-info" onclick="get_variations('purord');">View Purchase Order Variations</button>
                                                                    </div>
                                                                    <div id="purord_variations" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from purchase orders variations excluding GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostpovare"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from purchase orders variations including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostpovari"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra sales from purchase orders variations</td>
                                                                <td colspan="2" class="text-right">$<span id="extrasalepovar"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Profit from purchase orders variations including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="proextrasalepovar"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr class="variation_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#suppinvo_variations" class="btn btn-info" onclick="get_variations('suppinvo');">View Supplier Invoice Variations</button>
                                                                    </div>
                                                                    <div id="suppinvo_variations" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from supplier invoices variations excluding GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostsivare"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from supplier invoices variations including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostsivari"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra sales from supplier invoices variations</td>
                                                                <td colspan="2" class="text-right">$<span id="extrasalesivar"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Profit from supplier invoices variations</td>
                                                                <td colspan="2" class="text-right">$<span id="proextrasalesivar"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr class="variation_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#supcredit_variations" class="btn btn-info" onclick="get_variations('supcredit');">View Supplier Credit Variations</button>
                                                                    </div>
                                                                    <div id="supcredit_variations" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from supplier credits variations excluding GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostscvare"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from supplier credits variations including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostscvari"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra sales from supplier credits variations</td>
                                                                <td colspan="2" class="text-right">$<span id="extrasalescvar"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Profit from supplier credits variations</td>
                                                                <td colspan="2" class="text-right">$<span id="proextrasalescvar"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr class="variation_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#allowance_invoices_list" class="btn btn-info" onclick="get_supplier_invoices('allowance');">View Allowance Invoices</button>
                                                                    </div>
                                                                    <div id="allowance_invoices_list" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from allowances excluding GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostallowe"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Extra costs from allowances including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="extracostallowi"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Current and Pending Sales from Allowances</td>
                                                                <td colspan="2" class="text-right">$<span id="extrasalesallow"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Profit from allowances</td>
                                                                <td colspan="2" class="text-right">$<span id="proextrasaleallow"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr>
                                                                <td style="color:#0000ff;">Updated Project Cost including GST</td>
                                                                <td colspan="2" style="color:#0000ff;" class="text-right">$<span id="updatepcostigst"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color:#0000ff;">Updated Project Contract Price including GST</td>
                                                                <td colspan="2" style="color:#0000ff;" class="text-right">$<span id="updatepcpigst"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color:#0000ff;">Updated Profit including GST</td>
                                                                <td colspan="2" style="color:#0000ff;" class="text-right">$<span id="updateproigst"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color:#0000ff;">PROFIT DIFFERENCE including GST</td>
                                                                <td colspan="2" style="color:#0000ff;" class="text-right">$<span id="prodiff"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <!--<tr class="supplier_invoices_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#supplier_invoices_list" class="btn btn-info" onclick="get_supplier_invoices();">View Suplier Invoices</button>
                                                                    </div>
                                                                    <div id="supplier_invoices_list" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Total Supplier Invoices Created including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="supplierinvoicecreated"></span></td>
                                                            </tr>
                                                            <tr class="supplier_credits_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#supplier_credits_list" class="btn btn-info" onclick="get_supplier_credits();">View Supplier Credits</button>
                                                                    </div>
                                                                    <div id="supplier_credits_list" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Total Supplier credits created including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="suppliercreditscreated"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Supplier Invoices paid from bank including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="sipaid"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Supplier Invoices paid by Supplier Credit including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="sipaidbysc"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Supplier Invoices unpaid including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="supplierinvoiceunpaid"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Future Supplier Invoices including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="futuresupplierinvoices"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr class="sales_invoices_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#sales_invoices_list" class="btn btn-info" onclick="get_sales_invoices();">View Sales Invoices</button>
                                                                    </div>
                                                                    <div id="sales_invoices_list" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Total Sales Invoices Created including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="salesinvoicecreated"></span></td>
                                                            </tr>
                                                            <tr class="sales_credits_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#sales_credits_list" class="btn btn-info" onclick="get_sales_credits();">View Sales Credits</button>
                                                                    </div>
                                                                    <div id="sales_credits_list" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Total Sales Credits Created including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="salescreditcreated"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Sales Invoices Paid including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="salesinpaid"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Sales Invoices Unpaid including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="salesinunpaid"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Future Sales Invoices including GST</td>
                                                                <td colspan="2" class="text-right">$<span id="futuresalesin"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            <tr class="cash_transfers_btn_container" style="display:none;">
                                                                <td colspan="3">
                                                                    <div class="text-right">
                                                                    <button type="button" data-toggle="collapse" data-target="#cash_transfers_list" class="btn btn-info" onclick="get_cash_transfers();">View Cash Transfers</button>
                                                                    </div>
                                                                    <div id="cash_transfers_list" class="collapse">
                                                                     
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >Total Cash Transfers</td>
                                                                <td colspan="2" class="text-right">$<span id="cash_transfers"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>
                                                            
                                                            <tr>
                                                                <td >Bank Interest <small>*</small></td>
                                                                <td>$</td>
                                                                <td ><input class="form-control cal-on-changebi" name="bankinterest" id="bankinterest" value="0.00" required><br/>
                                                                <input style="display:none;" class="btn btn-success update_bank_interest pull-right" type="button" name="update_bank_interest" id="update_bank_interest" value="Update"></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Bank Balance</td>
                                                                <td colspan="2" class="text-right">$<span id="bankbalance"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >FUTURE CASH REQUIRED</td>
                                                                <td colspan="2" class="text-right">$<span id="future_cash_required"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >FUTURE CASH AVAILABLE</td>
                                                                <td colspan="2" class="text-right">$<span id="future_cash_available"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >PROJECTED FINAL CASH</td>
                                                                <td colspan="2" class="text-right">$<span id="projected_final_cash"></span></td>
                                                            </tr>
                                                            <tr><td colspan="3" style="background-color: #000"></td></tr>-->
                                                            
                                             
                                                        </table>
                                                    </div>
                                                    <div class="form-footer">
                                                        <button type="submit" class="btn btn-success btn-fill print report_btn" style="display:none;">Report</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </form>
        
								</div>
		</div>
    </div>
</div>
