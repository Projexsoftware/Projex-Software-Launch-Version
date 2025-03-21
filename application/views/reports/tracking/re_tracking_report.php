<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Track Report</h4> 
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
                                    <table class="table table-striped table-no-bordered table-hover print_table" cellspacing="0" width="100%" style="width:100%" >
                                        <tr class="pro_title">
                                                                    <td colspan="5">Tracking Report for <?php echo $tracking_report->project_title;?></td>
                                                        </tr>
                                                        <tr class="gro_title">
                                                            <td colspan="5">Family Group : <?php echo $tracking_report->title;?></td>        
                                                        </tr>
                                                        <tr>
                                                            <th >Stage</th>
                                                            <th >Part</th>
                                                            <th >Component</th>
                                                            <th >Budget</th>
                                                            <th >Actual</th>
                                                        </tr>
                                                        <?php 
                                                        if($group_parts){
                                                            $total_budget=0;
                                                             $total_actual=0;
                                                            $get_parts = json_decode($group_parts);
                                                            
                                                            $i=0;
                                                            foreach($get_parts as $part){
                                                                $total_budget +=number_format($part->budget, 2, ".", "");
                                                                
                                                                $total_actual +=number_format($part->actual,2, ".", "");
                                                                ?>                    
                                                         <tr>
                                                            <td ><?php echo $part->stage_name;?></td>
                                                            <td ><?php echo $part->costing_part_name;?></td>
                                                            <td ><?php echo $part->component_name;?></td>
                                                            <td ><?php echo number_format($part->budget,2);?></td>
                                                            <td ><?php echo number_format($part->actual,2);?></td>
                                                        </tr>
                                                        <?php $i++;}
                                                    }
                                                    ?>
                                                    <tr>
                                                            <td><strong>Total</strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><strong><?php echo number_format($total_budget,2);?></strong></td>
                                                             <td><strong><?php echo number_format($total_actual,2);?></strong></td>
                                                        </tr>     
                                                        
                                    </table>
                                    <div id="graphContainer">
                                            <div class="row">
                                                       <div class="col-lg-12">
                                                        <div id="retrack_line_chart" style="min-width: 310px; height: 400px; margin: 30px auto"></div>
                                                       </div>
                                                    </div>
                                           <br/>
                                            <div class="row">
                                                       <div class="col-lg-12">
                                                        <div id="retrack_bar_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                                       </div>
                                                    </div>
                                    </div>
                                    
                                            <div class="col-lg-4 " style="margin-top: 20px;"> 
                                            <form method="post" action="<?php echo base_url('reports/pdf_tracking/'.$tracking_report->id);?>">
                                                 <div id="images">
                                                     <input type="hidden" value="" name="line_chart" id="line_chart_image">
                                                 </div>
                                                  <button type="Submit" class="btn btn-success exportPDFBtn">Export as PDF</button>
                                            </form>
                                </div>
        </div>
    </div>
</div>


   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script type="text/javascript" src="<?php echo JS;?>highcharts-gantt.js"></script>
<script type="text/javascript" src="<?php echo JS;?>exporting.js"></script>
<script>
    var group_parts = '<?php echo $group_parts;?>';
var group_parts_stages = '<?php echo $group_parts_stages;?>';
var categories = [];
var data_budget = [];
var data_actual = [];
var result = JSON.parse(group_parts);
//console.log(result);
if(group_parts){
    $.each(result,function(i,v){
        categories.push(v.component_name+" ("+v.stage_name+")");
        data_budget.push(parseFloat(v.budget));
        if(v.actual){
            data_actual.push(parseFloat(v.actual));
        }else{
            data_actual.push(0);
        }
        
    })
}


     $(function () {
    Highcharts.chart('retrack_line_chart', {

        chart: {
            type: 'line'
        },
        credits: {
    enabled: false
},
        title: {
            text: '<?php echo $tracking_report->title;?> Tracking'
        },        
        xAxis: {
            categories: [
                ''
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: 'Budget',
           data: data_budget,//[2500, 3000, 5000, 3600, 2700, 6000, 2750, 2620],
            color: '#0d67bd'

        },{
            name: 'Actual',
           data: data_actual,//[2200, 2200, 4500, 3300, 3000, 5000, 0,0],
            color: '#f56700'

        }]
    });
///////////////// this is to save the chart as png /////////////////
    
});

$(function () {
    Highcharts.chart('retrack_bar_chart', {

    title: {
        text: ''
    },
    credits: {
    enabled: false
    },
    xAxis: {
        categories: categories,//['Site set up', 'Labour', 'Floor', 'Frames', 'Roof','Cladding','Interior Lining','Finishing']
    },
    yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
    
    series: [{
            type: 'column',
            name: 'Budget',
            data: data_budget,//[2500, 3000, 5000, 3600, 2700, 6000, 2750, 2620],
            color: '#0d67bd',
            showInLegend: false

        },{
            type: 'column',
            name: 'Actual',
           data: data_actual,//[2200, 2200, 4500, 3300, 3000, 5000, 0,0],
            color: '#f56700',
            showInLegend: false

        }]
    

});
    
    ///////////////// this is to save the chart as png /////////////////
    var options = {

         title: {
        text: ''
    },
    xAxis: {
        categories: categories,//['Site set up', 'Labour', 'Floor', 'Frames', 'Roof','Cladding','Interior Lining','Finishing']
    },
    yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
    
    series: [{
            type: 'column',
            name: 'Budget',
            data: data_budget,//[2500, 3000, 5000, 3600, 2700, 6000, 2750, 2620],
            color: '#0d67bd',
            showInLegend: false

        },{
            type: 'column',
            name: 'Actual',
           data: data_actual,//[2200, 2200, 4500, 3300, 3000, 5000, 0,0],
            color: '#f56700',
            showInLegend: false

        }]
    }
   

    // URL to Highcharts export server
    var exportUrl = 'https://export.highcharts.com/';

    // POST parameter for Highcharts export server
    var object = {
        options: JSON.stringify(options),
        type: 'image/png'
    };

    // Ajax request
    $.ajax({
        type: 'post',
        url: exportUrl,
        data: object,
        success: function (data) {
            //Submit data from your server
             // Ajax request
            $.ajax({
                type: 'post',
                url: base_url+"reports/savecharts",
                data: {'url' : exportUrl+data},
                success: function (data2) {
                  $(".highcharts-button-symbol").css("display", "none");
                  var element = document.getElementById("graphContainer");
                  html2canvas(element).then(function(canvas) {
                  var myImage = canvas.toDataURL("image/jpeg,1.0");
                  $("#line_chart_image").val(myImage);
                   $(".highcharts-button-symbol").css("display", "block");
                  
                });
                $(".exportPDFBtn").css("display", "block");
                }
            });
        }
    });
});
    
    

</script>
