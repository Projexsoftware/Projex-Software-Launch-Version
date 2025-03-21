<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">report</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Project Sales Summary Report</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="table_pro_name">
                            Project Name:
                            <?php echo $project_name['project_title']; ?>
                        </h4>
                    </div>
                </div>
                <div class="table-responsive">
                                                <div class='clearfix'></div>
                                 
                                                <div id="populatetables">
                                
                                                    <table id="contracttable" class="table table-bordered table-striped table-hover">
                                                        <div class="row">
                                                        
                                                        <thead>
                                                            <tr>
                                
                                                                <th class="col-md-10" style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;"><center>Contract Price</center></th>
                                                                <th class="col-md-2" id="contractprice" style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;"><?php echo '$'.$contract_price;?></th>
                                
                                                            </tr>
                                                        </thead>
                                                        </div>
                                                    </table>
                                                    <hr>
                                
                                                    <table id="allowancetable" class="table table-bordered table-striped table-hover ">
                                                        <thead>
                                                            <tr>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Part</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Component</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Allowance</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Actual</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Difference</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Number</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount Paid</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount Owing</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody >
                                                            <?php echo $allowance;?>
                                	                    </tbody>
                                                    </table>
                                	                <hr>
                                                    <table id="variationtable" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Variation Number</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Variation Description</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Total Cost</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Number</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount Paid</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount Owing</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody >
                                                          <?php echo $variation;?>
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                    <table id="paymenttable" class="table table-bordered table-striped table-hover">
                                                        <a id="addbtn" title="Add new payment item" class="btn btn-primary clone pull-right" type="button" value="1" onclick="addMore(this.value);"><i class="fa fa-plus-circle"></i>Add New Payment Item</a>
                                                        <thead>
                                                            <tr>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Payment Description</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Payment Amount</th>
                                                                
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Number</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount Paid</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;">Invoice Amount Owing</th>
                                                                <th style="background-color:#C0B9B9!important;padding:3px!important; color:black!important;"></th>
                                                            </tr>
                                                        </thead>
                                                        
                                                        <tbody >
                                                            <?php echo $payment;?>
                                                        </tbody>
                                                        
                                                    </table>
                                					<p>
                                					<a href="javascript:window.print()" class="btn btn-success print">Print</a>
                                					<a href="<?php echo base_url(); ?>sales_invoices/pdf_report/<?php echo $project_id; ?>" class="btn btn-success print">Export To PDF</a>
                                					<a href="<?php echo base_url(); ?>sales_invoices/excel_report/<?php echo $project_id; ?>" class="btn btn-success print">Export To Excel</a>
                                					</p>
                                					</div>
                                        </div>
            </div>
        </div>
    </div>
</div>
                