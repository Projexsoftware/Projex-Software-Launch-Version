<?php
if($myprofithtml!=""){
 $myprofithtml = explode("^", $myprofithtml);
 $profit_table = "<table class='table'><thead><tr><th><center>Project</center></th><th><center>Amount</center></th></tr></thead><tbody>";
 for($i=0;$i<count($myprofithtml);$i++){
 $project = explode("|", $myprofithtml[$i]);  
 $profit_table .="<tr><td>".$project[0]."</td><td>$".number_format($project[1], 2, ".", ",")."</td></tr>";
 }
 $profit_table .= "</tbody></table>";
 
 $myprofitdiffhtml = explode("^", $myprofitdiffhtml);
 $profit_diff_table = "<table class='table'><thead><tr><th><center>Project</center></th><th><center>Amount</center></th></tr></thead><tbody>";
 for($i=0;$i<count($myprofitdiffhtml);$i++){
 $project = explode("|", $myprofitdiffhtml[$i]);  
 $profit_diff_table .="<tr><td>".$project[0]."</td><td>$".number_format($project[1], 2, ".", ",")."</td></tr>";
 }
 $profit_diff_table .= "</tbody></table>";
 
  $myprofitpendinghtml = explode("^", $myprofitpendinghtml);
 $profit_pending_table = "<table class='table'><thead><tr><th><center>Project</center></th><th><center>Amount</center></th></tr></thead><tbody>";
 for($i=0;$i<count($myprofitpendinghtml);$i++){
 $project = explode("|", $myprofitpendinghtml[$i]); 
 if($project[0]){
 $profit_pending_table .="<tr><td>".$project[0]."</td><td>$".number_format($project[1], 2, ".", ",")."</td></tr>";
 }
 }
 $profit_pending_table .= "</tbody></table>";
}
?>                    
                    <h4>Welcome back <?php echo ucfirst($this->session->userdata('firstname'));?></h4>
                   
                    <h4>For Current</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="rose">
                                    <i class="material-icons">attach_money</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Total Sales</p>
                                    <h3 class="card-title"><?php echo '$'.number_format($total_sales_invoices-$total_sales_credits, 2, '.', ',');?></h3>
                                </div>
                            </div>
                         </div>
                         <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">receipt</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Total Supplier Invoices</p>
                                    <h3 class="card-title"><?php echo '$'.number_format($total_supplier_invoices-$total_supplier_credits, 2, '.', ',');?></h3>
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">android</i>
                                </div>
                                <div class="card-content tooltip-btn" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="<?php if(isset($profit_table)){ echo $profit_table; }?>">
                                    <p class="category">Total Project Profit Amount</p>
                                    <h3 class="card-title"><?php echo '$'.number_format($project_profit, 2, '.', ',');?></h3>
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="red">
                                    <i class="material-icons">attach_money</i>
                                </div>
                                <div class="card-content tooltip-btn" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="<?php if(isset($profit_diff_table)){ echo $profit_diff_table; } ?>">
                                    <p class="category">Total Profit Difference Amount</p>
                                    <h3 class="card-title"><?php echo '$'.number_format($profit_difference, 2, '.', ',');?></h3>
                                </div>
                            </div>
                          </div>
                    </div>
                    <h4>For Pending</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">android</i>
                                </div>
                                <div class="card-content tooltip-btn" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="<?php if(isset($profit_pending_table)){ echo $profit_pending_table; }?>">
                                    <p class="category">Total Project Profit Amount</p>
                                    <h3 class="card-title"><?php echo '$'.number_format($total_profit_for_pending, 2, '.', ',');?></h3>
                                </div>
                            </div>
                         </div>
                         <div class="col-lg-4 col-md-4 col-sm-4">
                            
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4">
                            
                          </div>
                    </div>
                    <div class="row">
				   <div class="col-md-12">
                    <div id="variation_container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				   </div>
				</div>
				<div class="row">
				   <div class="col-md-12">
                    <div id="sales_invoice_container" style="min-width: 310px; height: 400px; margin: 30px auto"></div>
				   </div>
				</div>
				<div class="row">
				   <div class="col-md-12">
                    <div id="supplier_invoice_container" style="min-width: 310px; height: 400px; margin: 30px auto"></div>
				   </div>
				</div>
				<div class="row">
				   <div class="col-md-12">
                    <div id="bank_account_container" style="min-width: 310px; height: 400px; margin: 30px auto"></div>
				   </div>
				</div>
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">person</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Latest Clients&nbsp;&nbsp;<a href="<?php echo SURL;?>manage/clients" class="btn btn-rose btn-round btn-sm" style="margin-top: 0px;
    margin-bottom: 0px;">View All</a></h4> 
                                    
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                									<th>Client Name</th>
                									<th>Mobile Number</th>
                									<th>Email</th>
                									<th>Notes</th>
                									<th>Created Date</th>
                									<th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						 if(count($clients)>0){
                    						    $i=1;
                                                foreach($clients As $key=>$val) { ?>
                                                <tr class="row_<?php echo $val['client_id'];?>">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $val['client_fname1']." ".$val['client_surname1'];?> <?php echo $val['client_fname2']." ".$val['client_surname2'];?></td>
                                                    <td><?php echo $val['client_mobilephone_primary'];?></td>
                                                    <td><?php echo $val['client_email_primary'];?></td>
                                                    <td><?php echo $val['client_note'];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['date_created'])); ?></td>
                                                    <td><?php if($val['client_status']==1){?><span class="label label-success">Current</span><?php } else {?>
									<span class="label label-danger">Inactive</span>
									<?php } ?></td>
                                                    <td class="text-right">
                                                        <?php if(in_array(55, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>manage/edit_client/<?php echo $val['client_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                        <?php } if(in_array(56, $this->session->userdata("permissions"))) {?>
                                                        <a onclick="demo.showSwal('warning-message-and-confirmation', 'manage/delete_client', <?php echo $val['client_id'];?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                        <?php } if(in_array(53, $this->session->userdata("permissions"))) {?>
                                                        <a href="<?php echo SURL;?>manage/view_client/<?php echo $val['client_id'];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">pageview</i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php 
												$i++;
												} } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                               
                        </div>
							<div class="col-md-4">
							<div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">bar_chart</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Stats</h4> 	
									<ul class="list-group collapse in" id="feedList">
										<li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>manage/clients" class=""><i class="material-icons">face</i> Clients</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_clients;?></span><br/>
												
											</div>
										</li>
										<li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>manage/projects" class=""><i class="material-icons">android</i> Projects</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_projects;?></span><br/>
												
											</div>
										</li>
										<li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>setup/users"><i class="material-icons" style="width:25px;">supervisor_accounts</i> Users</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_users;?></span><br/>
												
											</div>
										</li>
										<li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>manage/suppliers"><i class="material-icons">local_shipping</i> Suppliers</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_suppliers;?></span><br/>
												
											</div>
										</li>
                                        <li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>manage/components"><i class="material-icons">check_box</i> Components</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_components;?></span><br/>
												
											</div>
										</li>
										<li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>setup/stages"><i class="material-icons">trending_up</i> Stages</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_stages;?></span><br/>
												
											</div>
										</li>
										<li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>setup/takeoffdata"><i class="material-icons">functions</i> Takeoffdata</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_suppliers;?></span><br/>
												
											</div>
										</li>
                                        <li class="list-group-item clearfix">
											<div class="pull-left">
												<a href="<?php echo SURL;?>setup/templates"><i class="material-icons">phonelink_setup</i> Templates</a>
											</div>
											<div class="pull-right">
												<span class="label label-success pull-right"><?php echo $total_templates;?></span><br/>
												
											</div>
										</li>
										
									</ul><!-- /list-group -->
								</div><!-- /panel -->
							</div><!-- /.col -->
                    </div>
<script>
 $(function () {
  $('[data-toggle="tooltip"]').tooltip();
})
$(function () {
    Highcharts.chart('variation_container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Project Variations'
        },
        subtitle: {
            text: ''
        },
		credits: {
          enabled: false
        },
		exporting: { 
		    enabled: false
		},
        xAxis: {
            categories: [
                <?php echo $projects;?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'No Of Variations'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Variations',
            data: [<?php echo $variations;?>]

        }]
    });
});
$(function () {
    Highcharts.chart('sales_invoice_container', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Sales Invoices'
        },
        subtitle: {
            text: ''
        },
		credits: {
          enabled: false
        },
		exporting: { 
		    enabled: false
		},
        xAxis: {
            categories: [
                <?php echo $sales_invoice_projects;?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Sales Invoice Amount'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>${point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Projects',
            data: [<?php echo $invoice_amount;?>],
			color: '#f56700'

        }]
    });
});
$(function () {
    Highcharts.chart('supplier_invoice_container', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Supplier Invoices'
        },
        subtitle: {
            text: ''
        },
		credits: {
          enabled: false
        },
		exporting: { 
		    enabled: false
		},
        xAxis: {
            categories: [
                <?php echo $suppliers_invoice_projects;?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Suppliers Invoice Amount'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>${point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Projects',
            data: [<?php echo $suppliers_invoice_amount;?>],
			color: '#f56700'

        }]
    });
});

$(function () {
    Highcharts.chart('bank_account_container', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Bank Account'
        },
        subtitle: {
            text: ''
        },
		credits: {
          enabled: false
        },
		exporting: { 
		    enabled: false
		},
        xAxis: {
            categories: [
                <?php echo $bank_account_projects;?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Bank Balance'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>${point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Projects',
            data: [<?php echo $bank_account_amount;?>],
			color: '#f56700'

        }]
    });
});
</script>