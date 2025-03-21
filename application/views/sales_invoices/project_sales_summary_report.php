<style>
    
	.table_pro_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0}
    #contractprice{
        text-align:right;
    }

</style>
<style rel="stylesheet" type="text/css" media="print">
    @media print {
    @page { size: landscape; }
	.print, .card-header, .footer, .navbar{
        display: none !important;
    }
	.printable{
	   display: block!important;
    }
    .breadcrumb, .slimScrollDiv{
        display: none !important;
    }
    #top-nav {
    	display: none !important;
    }
	
	
	.desktop_logo{ display:block !important;padding:15px 0px 20px 15px !important;background-color:#000!important;}
	.desktop_logo img{ }
	
	.table_pro_name{ text-align:center; width:100%; background-color: #f56700!important; color:#fff!important; padding:10px 0}

}
</style>
   <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">summarize</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="col-md-12 desktop_logo" style="display:none;text-align:center;">
    	<img class="dashboard_logo" src="<?php echo base_url() .'/assets/img/boom-white.png' ?>">
    </div>
                                        <h4 class="card-title">Project Sales Summary Report</h4>
				                    
                                        <div class="row">
                            		    <div class="col-sm-12">
                            			    
                            					<h4 class="table_pro_name">
                            						Project Name:
                            					<?php echo $project_name['project_title']; ?>
                            					</h4>
                            			    
                            		    </div>
                                    </div>
                                    <div class="material-datatables">
                            
                                                <table id="contracttable" class="table table-striped table-bordered table-hover">
                                                    <div class="row">
                                                    
                                                    <thead>
                                                        <tr>
                            
                                                            <th class="col-md-10" style="background-color:#C0B9B9!important; color:black!important;">Contract price</th>
                                                            <th class="col-md-2" id="contractprice" style="background-color:#C0B9B9!important;color:black!important;"><?php echo '$'.$contract_price;?></th>
                            
                                                        </tr>
                                                    </thead>
                                                    </div>
                                                </table>
                                                <hr>
                                                <table id="allowancetable" class="table table-bordered table-striped table-hover ">
                                                    <thead>
                                                        <tr>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Part</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Component</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Allowance</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Actual</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Difference</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Paid</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Owing</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;"></th>
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
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Variation Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Variation Description</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Total Cost</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Paid</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Owing</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                      <?php echo $variation;?>
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <table id="paymenttable" class="table table-bordered table-striped table-hover">
                                                    <a id="addbtn" title="Add new payment item" class="btn btn-sm btn-primary clone pull-right" type="button" value="1" onclick="addMore(this.value);"><i class="fa fa-plus-circle"></i>Add New Payment Item</a>
                                                    <thead>
                                                        <tr>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Payment Description</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Payment Amount</th>
                                                            
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Number</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Paid</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;">Invoice Amount Owing</th>
                                                            <th style="background-color:#C0B9B9!important;color:black!important;"></th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody >
                                                        <?php echo $payment;?>
                                                    </tbody>
                                                    
                                                </table>
                                    </div>
                                    
                                    
                                                    <div class="form-footer">
                            					<a href="javascript:window.print()" class="btn btn-success print">Print</a>
                            					<a href="<?php echo base_url(); ?>sales_invoices/pdf_report/<?php echo $project_id; ?>" class="btn btn-success print">Export To PDF</a>
                            					<a href="<?php echo base_url(); ?>sales_invoices/excel_report/<?php echo $project_id; ?>" class="btn btn-success print">Export To Excel</a>
                            				
                                                </div>
                                                
                                            
</div>
</div>
</div>
</div>