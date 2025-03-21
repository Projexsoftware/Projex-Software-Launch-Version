
$(document).ready(function() {
setFormValidation('#SendScheduleReportForm');
});

$('#summary_type').change(function(){
    var report_type = $(this).val();
    if(report_type == "log"){
        $(".datepicker-section").show();
    }
    else{
        $(".datepicker-section").hide();
    }
});

$('.view_project_summary').click(function(){
    setFormValidation('#ProjectSummaryForm');
    if($("#ProjectSummaryForm").valid()){
          var data = $("#ProjectSummaryForm").serialize();
          $.ajax({
                type:'POST',
                url:base_url+'scheduling/reports/get_project_summary',
                data: data,
                beforeSend: function(){
                     $(".project_summary_container").html('');
                     $('.loader').show();
                },
                success:function(result){
                    $('.loader').hide();
                    $(".project_summary_container").html(result);
                }
             });  
          }
          else{
             $("#ProjectSummaryForm").validate();
          }
 });
 
 $('.view_daily_summary').click(function(){
    setFormValidation('#DailySummaryForm');
    if($("#DailySummaryForm").valid()){
          var data = $("#DailySummaryForm").serialize();
          $.ajax({
                type:'POST',
                url:base_url+'scheduling/reports/get_daily_summary',
                data: data,
                beforeSend: function(){
                     $(".daily_summary_container").html('');
                     $('.loader').show();
                },
                success:function(result){
                    $('.loader').hide();
                    $(".daily_summary_container").html(result);
                }
             });  
          }
          else{
             $("#DailySummaryForm").validate();
          }
 });
 
 

$('.view_project_schedule').click(function(){
    setFormValidation('#ProjectSummaryForm');
    if($("#ProjectScheduleForm").valid()){
          var data = $("#ProjectScheduleForm").serialize();
          $.ajax({
                type:'POST',
                url:base_url+'scheduling/reports/get_project_schedule',
                data: data,
                beforeSend: function(){
                     $(".project_schedule_container").html('');
                     $('.loader').show();
                },
                success:function(result){
                    $('.loader').hide();
                    // Set to 00:00:00:000 today
                    var today = new Date(),
                        day = 1000 * 60 * 60 * 24,
                        map = Highcharts.map,
                        dateFormat = Highcharts.dateFormat,
                        series,
                        jobs;
                    
                    // Set to 00:00:00:000 today
                    today.setUTCHours(0);
                    today.setUTCMinutes(0);
                    today.setUTCSeconds(0);
                    today.setUTCMilliseconds(0);
                    today = today.getTime();
                    
                    var obj = JSON.parse(result)
                    
                    jobs = obj.items;
                    
                    if(jobs.length>0){
                    
                    series = jobs.map(function (job, i) {
                       if(job.task_name!=""){ 
                        var data = job.tasks.map(function (task) {
                    
                        return {
                            id: 'task-' + i,
                            assignedTo: task.assignedTo,
                            start: Date.UTC(task.start_year, task.start_month, task.start_day),
                            end: Date.UTC(task.end_year, task.end_month, task.end_day),
                            color: task.color,
                            borderColor: task.color,
                            y: i
                        };
                    });
                    
                    return {
                        name: job.task_name,
                        data: data,
                        current: job.tasks[0]
                    };
                }});
                
                var min = obj.min.split(", ");
                var max = obj.max.split(", ");
                Highcharts.ganttChart('project_schedule_container', {
                    
                    chart: {
                        events: {
                          load: function() {
                            var chart = this;
                            chart.xAxis[0].labelGroup.element.childNodes.forEach(function(label) {
                              if (label.innerHTML === 'S') {
                                label.style.fill = 'red';
                                label.style['font-weight'] = 900;
                              }
                            })
                          }
                        }
                      },
                      exporting: {
                            filename: 'Project Schedule For '+obj.project_name
                      },
                      navigator: {
                        enabled: true,
                        liveRedraw: true,
                        series: {
                            type: 'gantt',
                            pointPlacement: 0.5,
                            pointPadding: 0.25
                        },
                        yAxis: {
                            min: 0,
                            max: 3,
                            reversed: true,
                            categories: []
                        }
                    },
                    scrollbar: {
                        enabled: true
                    },
                    series: series,
                    credits: false,
                    title: {
                        text: 'Project Schedule For '+obj.project_name
                    },
                    tooltip: {
                        pointFormat: '<span>Who: {point.assignedTo}</span><br/><span>From: {point.start:%A, %m/%d/%Y}</span><br/><span>To: {point.end:%A, %m/%d/%Y}</span>'
                    },
                    xAxis: {
                        labels: {
                        useHTML: true,
            			formatter() {
            			    const day = String(new Date(this.value)).slice(0, 3);
                            if (day === 'Sat' || day === 'Sun') {
                              return `<span style="color: red">${Highcharts.dateFormat('%a',this.value)}</span><br>
                                				<span style="color: red">${Highcharts.dateFormat('%e. %b',this.value)}</span> `
                            }
       
            				return `
            				<span>${Highcharts.dateFormat('%a',this.value)}</span><br>
            				<span>${Highcharts.dateFormat('%e. %b',this.value)}</span>
            				
            				`
	
            			}
                        },
                        tickWidth: 300,
                        currentDateIndicator: {
                            width: 1,
                            dashStyle: 'dot',
                            color: 'red',
                            label: {
                                format: '%m/%d/%Y'
                            }
                        },
                        type: 'datetime',
                        
                        tickInterval: day,
                        plotBands: obj.plotBands,
                        gridLineWidth: 0.5,
                        min: Date.UTC(min[0], min[1], min[2]),
                        max: Date.UTC(max[0], max[1], max[2])
                    },
                    yAxis: {
                        
                        type: 'category',
                        grid: {
                            columns: [{
                                title: {
                                    text: 'Job'
                                },
                                categories: map(series, function (s) {
                                    return s.name;
                                })
                            }, {
                                title: {
                                    text: 'Who'
                                },
                                categories: map(series, function (s) {
                                    return s.current.assignedTo;
                                })
                            }/*,
                            {
                                title: {
                                    text: 'From'
                                },
                                categories: map(series, function (s) {
                                    if((parseInt(s.current.start_month)+1)<10){
                                        return "0"+(parseInt(s.current.start_month)+1)+"/"+s.current.start_day+"/"+s.current.start_year;
                                    }
                                    else{
                                    return (parseInt(s.current.start_month)+1)+"/"+s.current.start_day+"/"+s.current.start_year;
                                    }
                                })
                            },
                            {
                                title: {
                                    text: 'To'
                                },
                                categories: map(series, function (s) {
                                    if((parseInt(s.current.end_month)+1)<10){
                                      return "0"+(parseInt(s.current.end_month)+1)+"/"+s.current.end_day+"/"+s.current.end_year;
                                    }
                                    else{
                                       return (parseInt(s.current.end_month)+1)+"/"+s.current.end_day+"/"+s.current.end_year; 
                                    }
                                })
                            }*/]
                        }
                    }
                });
                
                $(".project_schedule_chart").show();
                $(".btn-schedule-export").show();
                    }
                    else{
                        $("#project_schedule_container").html("");
                        $(".btn-schedule-export").hide();
                        $(".project_schedule_chart").hide();
                    }
                                    
                                }
                             });  
          }
          else{
             $("#ProjectScheduleForm").validate();
          }
 });
 $('.btn-schedule-export').click(function(){
 Highcharts.charts[0].exportChart({
        type: 'application/pdf'
    });
});

