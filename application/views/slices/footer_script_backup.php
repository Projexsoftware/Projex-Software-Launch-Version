<style>

  html, body {
    margin: 0;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #myCalendar {
    max-width: 900px;
    margin: 40px auto;
  }

</style>
<!--   Core JS Files   -->
<script src="<?php echo JS;?>jquery-ui.min.js"></script>
<script src="<?php echo JS;?>bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo JS;?>material.min.js" type="text/javascript"></script>
<script src="<?php echo JS;?>perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Library for adding dinamically elements -->
<script src="<?php echo JS;?>arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo JS;?>jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<!-- Promise Library for SweetAlert2 working on IE -->
<script src="<?php echo JS;?>es6-promise-auto.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo JS;?>moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="<?php echo JS;?>chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?php echo JS;?>jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="<?php echo JS;?>bootstrap-notify.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?php echo JS;?>bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?php echo JS;?>jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="<?php echo JS;?>nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?php echo JS;?>jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?php echo JS;?>jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="<?php echo JS;?>sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo JS;?>jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->

<!--<script src="<?php echo JS;?>fullcalendar.min.js"></script>-->
<script src='<?php echo JS;?>fullcalendar.min.js'></script>
<script src='<?php echo JS;?>scheduler.min.js'></script>

<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?php echo JS;?>jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo JS;?>material-dashboard.js?v=1.2.0"></script>
<!-- Summer Notes -->
<script src="<?php echo JS;?>summernote.js"></script>
<!--DateRange Picker-->
<script type="text/javascript" src="<?php echo JS;?>moment.min.js"></script>
<script type="text/javascript" src="<?php echo JS;?>daterangepicker.min.js"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo JS;?>highcharts.js"></script>
<script src="<?php echo JS;?>exporting.js"></script>
<script src="<?php echo JS;?>nerdamer.core.js"></script>
<script src='<?php echo ASSETS; ?>dropzone/dist/dropzone.js'></script>
<!--Ckeditor-->
<script src="<?php echo JS;?>ckeditor/ckeditor.js"></script>
<script src="<?php echo JS;?>demo.js"></script>
<!-- Select2 -->
<script src="<?php echo JS;?>select2.full.js"></script>

<!-- Toaster -->
<script src="<?php echo JS;?>toastr.min.js"></script>

<?php
$current_url = & get_instance(); 
$class_name = $current_url->router->fetch_class();
$method_name = $current_url->router->fetch_method();
        
if ($class_name == "roles") {
	
?>

<script src="<?php echo JS;?>custom_js/roles.js"></script>

<?php } 

if ($class_name == "users" || $class_name == "profile" || $class_name == "change_password" || $class_name == "xero_settings") {
	
?>

<script src="<?php echo JS;?>custom_js/users.js"></script>

<?php }

if ($class_name == "manage") {
	
?>

<script src="<?php echo JS;?>custom_js/manage.js"></script>

<?php }

if ($class_name == "setup") {
	
?>

<script src="<?php echo JS;?>custom_js/setup.js"></script>

<?php }

if ($class_name == "project_costing") {
	
?>

<script src="<?php echo JS;?>custom_js/project_costing.js"></script>

<?php }

if ($class_name == "confirmed_estimate") {
	
?>

<script src="<?php echo JS;?>custom_js/confirmed_estimate.js"></script>

<?php }

if ($class_name == "project_variations") {
	
?>

<script src="<?php echo JS;?>custom_js/project_variations.js"></script>

<?php }

if ($class_name == "purchase_orders") {
	
?>

<script src="<?php echo JS;?>custom_js/purchase_orders.js"></script>

<?php }

if ($class_name == "cash_transfers") {
	
?>

<script src="<?php echo JS;?>custom_js/cash_transfers.js"></script>

<?php }

if ($class_name == "timesheets") {
	
?>

<script src="<?php echo JS;?>custom_js/timesheets.js"></script>

<?php }
if ($class_name == "tickets") {
	
?>

<link href="<?php echo CSS;?>tickets.css" rel="stylesheet">
<script src="<?php echo JS;?>custom_js/tickets.js"></script>

<?php }

if ($class_name == "tasks") {
	
?>

<script src="<?php echo JS;?>custom_js/tasks.js"></script>

<?php }

if ($class_name == "checklists") {
	
?>

<script src="<?php echo JS;?>custom_js/checklists.js"></script>

<?php }

if ($class_name == "reminders") {
	
?>

<script src="<?php echo JS;?>custom_js/reminder.js"></script>

<?php }

if ($class_name == "projects") {
?>

  <script src="<?php echo ASSETS;?>anychart/anychart-base.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script src="<?php echo ASSETS;?>anychart/anychart-ui.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script src="<?php echo ASSETS;?>anychart/anychart-exports.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script src="<?php echo ASSETS;?>anychart/anychart-gantt.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script src="<?php echo ASSETS;?>anychart/anychart-data-adapter.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <link rel="stylesheet" href="<?php echo ASSETS;?>anychart/anychart-ui.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4" />
  <link rel="stylesheet" href="<?php echo ASSETS;?>anychart/anychart-font.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4" />

  <script src="<?php echo JS;?>custom_js/projects.js"></script>

<?php }


if ($class_name == "reports") {
	
?>

<script src="<?php echo JS;?>custom_js/reports.js"></script>

<?php }

if ($class_name == "templates") {
	
?>

<script src="<?php echo JS;?>custom_js/templates.js"></script>

<?php }

if ($class_name == "dashboard") {

?>

<script type="text/javascript">
    $(document).ready(function() {

	// Javascript method's body can be found in assets/js/demos.js
    demo.initDashboardPageCharts();

	demo.initVectorMap();
	});
</script>

<?php } ?>
		
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });
        
        $('.datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });


        var table = $('#datatables').DataTable();

        // Edit record
        /*table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });*/

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
	
	function setFormValidation(id) {
        $(id).validate({
            messages: {
                privatekey_certificate:{
                 extension: "Please select .pem certificate",
                },
                publickey_certificate:{
                 extension: "Please select .cer certificate",
                },
            },
            errorPlacement: function(error, element) {
				if(element.attr('name')=="privatekey_certificate"){
				    error.insertAfter(".privatekey_certificate_error");
				}
				else if(element.attr('name')=="publickey_certificate"){
				    error.insertAfter(".publickey_certificate_error");
				}
				else{
                error.insertAfter(element);
                
                $(element).closest('div').addClass('has-error');
				}
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        setFormValidation("#addNewComponentForm");
        demo.initFormExtendedDatetimepickers();
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD/MM/Y'
            }
        });
    });
    $(function(){
    $(".notification_item").hide();
    $(".notification_item").slice(0, 5).show(); // select the first ten
    $("#load").click(function(e){ // click event for load more
        e.preventDefault();
        $(".notification_item:hidden").slice(0, 5).show(); // select next 10 hidden divs and show them
        if($(".notification_item:hidden").length == 0){ // check if any hidden divs still exist
            $("#load").hide(); // alert if there are none left
        }
    });

    $(".activity_item").hide();
    $(".activity_item").slice(0, 3).show(); // select the first ten
    $("#load_activities").click(function(e){ // click event for load more
        e.preventDefault();
        $(".activity_item:hidden").slice(0, 3).show(); // select next 10 hidden divs and show them
        if($(".activity_item:hidden").length == 0){ // check if any hidden divs still exist
            $("#load_activities").hide(); // alert if there are none left
        }
    });
});

//setInterval("yourAjaxCall()",30000);
function yourAjaxCall(){
    $.ajax({
            url: '<?php echo SURL. 'notifications/get_latest_notifications' ?>',
            type: 'post',
            data: {},
            success: function (result) {
                $(".project_notifications").html(result);
            }
        });
}

$.date = function(orginaldate) { 
    var date = new Date(orginaldate);
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date =  year + "-" + month + "-" + day; 
    return date;
};

var chart;
function load_calendar(daterange=""){
$('.loader').show();
$("#myGanttChart").html("");
anychart.onDocumentReady(function() {
  // The data used in this sample can be obtained from the CDN
  // https://cdn.anychart.com/samples/gantt-live-editing/project-chart-editing/data.json
  
  var data_source = "";
  
  if(daterange!=""){
      data_source = '<?php echo SURL;?>projects/data/<?php echo $this->uri->segment(3);?>/'+daterange;
  }
  else{
      data_source = '<?php echo SURL;?>projects/data/<?php echo $this->uri->segment(3);?>';
  }

  anychart.data.loadJsonFile(data_source, function(data) {
      
    // required variables for custom interactivity
    var startChanged = false;
    var endChanged = false;
    var eventStorage = {taskId: null, timestamps: [null, null]};
    
    // create data tree on raw data
    var treeData = anychart.data.tree(data, 'as-table');

    // create project gantt chart
    chart = anychart.ganttProject();

    // set data for the chart
    chart.data(treeData);

    // set pixel position of the main splitter
    chart.splitterPosition(200);
    
    var dataGrid = chart.dataGrid();
    dataGrid.column(0).collapseExpandButtons(true);
    
    // settings for the first column
  dataGrid.column(0).width(25).format(function(item) {
    return "";
  }).title().text("");
  
  // settings for the second column
  dataGrid.column(1).format(function(item) {
    return item.get("name");
  }).title().text("Stages");

  // disable buttons in the second column
  dataGrid.column(1).collapseExpandButtons(false);

  // customize the data view
  dataGrid.column(1).depthPaddingMultiplier(0);
  <?php if($current_role==1 || $current_role==2){ ?>
    // make chart editable
    chart.edit(true);
  <?php } ?>
    
    chart.getTimeline().tooltip().format(function (e) {
  var item = e['item'];
  return '';});

    // set container id for the chart
    $("#myGanttChart").html("");
    chart.container('myGanttChart');
    
    //alert(document.getElementById('myGanttChart').offsetHeight);
    
    chart.getTimeline().tasks().labels(false);
    chart.getTimeline().milestones().labels(false);
    chart.getTimeline().groupingTasks().labels(false);
    chart.getTimeline().groupingTasks().height(20);
    //chart.timeLineHeight(80);
    
    //milestones
    
    var timeLine = chart.getTimeline();
    
    var currentHeader = timeLine.header();
    //currentHeader.midLevel(false);
    
    var elements = timeLine.groupingTasks();
    
    elements.offset('33%');
    
    // Set rendering settings.
    var milestones = timeLine.elements();
    milestones.stroke('none');
    
    var defaultDrawer = milestones.rendering().drawer();
    
    milestones.rendering({drawer: drawer});
    
    chart.contextMenu(false);
    
    
    var scale = chart.xScale();

    // Set zoom levels.
    scale.zoomLevels([
        [
            {unit: 'day', count: 1},
            {unit: 'month', count: 1},
            {unit: 'year', count: 1}
        ]
    ]);
    
    // initiate chart drawing
    chart.draw();
    $('.loader').hide();
    
    setFullHeight();
    
     var scale = chart.xScale();

    // Get total visible dates set.
    var getTotalRange = scale.getTotalRange();

    var totalMin = anychart.format.dateTime(new Date(getTotalRange.min), 'dd MMMM yyyy');
    var totalMax = anychart.format.dateTime(new Date(getTotalRange.max), 'dd MMMM yyyy');
    
    var date1 = new Date(totalMin);
    var date2 = new Date(totalMax);
    var date2 = date2.setDate(date2.getDate() + 1);
    

    var weekendDays = 0;
    dayMilliseconds = 1000 * 60 * 60 * 24;
    var sat_weekend_dates = [];
    var sun_weekend_dates = [];
    var d = 0;
    while (date1 <= date2) {
    var day = date1.getDay();
    var month = date1.getMonth();
    var year = date1.getYear();
    var no_of_days = new Date(year, month, 0).getDate();
    if(no_of_days==28 || no_of_days==31 || no_of_days==29 || no_of_days==30){
    if (day == 0 || day == 6) {
        if(day==6){
            var from = $.date(date1);
            sat_weekend_dates.push(from);
            d=1;
        }
        else{
            var to =  $.date(new Date(+date1 + dayMilliseconds));
            sun_weekend_dates.push(to);
            if(d==0){
               sat_weekend_dates.push(""); 
            }
        }
        
    }
    
    date1 = new Date(+date1 + dayMilliseconds);
    }
    else{
        if (day == 0 || day == 1) {
        if(day==0){
            var from = anychart.format.dateTime(new Date(date1), 'yyyy-MM-dd');
            
            sat_weekend_dates.push(from);
        }
        else{
            var to = anychart.format.dateTime(new Date(+date1 + dayMilliseconds), 'yyyy-MM-dd');
            sun_weekend_dates.push(to);
        }
        
    }
    
    date1 = new Date(+date1 + dayMilliseconds);
    }
    d++;
    }
    
    /*console.log(sat_weekend_dates);
    console.log(sun_weekend_dates);*/
    var i;
    
    for(i=0;i<sat_weekend_dates.length;i++){
        if(sun_weekend_dates[i]!=undefined){
        timeLine.rangeMarker(i, {from: sat_weekend_dates[i], to: sun_weekend_dates[i]});
        }
        else{
            var m1 = sat_weekend_dates[i]+"T24:00";
            var m2 = sat_weekend_dates[i];
           timeLine.rangeMarker(i, {from: m1, to: m2}); 
        }
    }
    
    function drawer() {

    defaultDrawer.call(this);

  }

   treeData.listen("treeItemUpdate", eventHandler);
    
   var requestId = requestAnimationFrame(function check() {
    if (startChanged && endChanged) {
      // stop listening the tree events
      treeData.unlisten("treeItemUpdate", eventHandler);
      // calculate the timeshift
      var timeShift = anychart.format.parseDateTime(eventStorage.timestamps[1]).getTime() -
          anychart.format.parseDateTime(eventStorage.timestamps[0]).getTime();
      // find the modified task
      var rootTask = treeData.search('id', eventStorage.taskId);
      var connectTo = rootTask.get('connectTo');
      // try to move connected tasks
      moveRelatedTasks(connectTo, timeShift);
      startChanged = false;
      endChanged = false;
    } else {
      startChanged = false;
      endChanged = false;
    }
    requestAnimationFrame(check);
  });

  //helper to separate moving and changing duration events
  function eventHandler(e) {
    // store the current scroll position
    var editedRow = chart.scrollTo();
    // return the scroller to the previous position after redrawing the chart
    chart.listenOnce('chartDraw', function() {
      chart.scrollTo(editedRow)
    })
    // check what task fields were modified by LiveEdit
    
    if (e.path[0] == 'actualStart')
      startChanged = true;
    if (e.path[0] == 'actualEnd')
      endChanged = true;
    // store all required task information for further processing
    eventStorage.taskId = e.item.get('id');
    eventStorage.timestamps.shift();
    eventStorage.timestamps.push(e.item.get('actualEnd'));
    if (startChanged && endChanged) {
        var project_id = $("#original_project_id").val();
      var id = e.item.get('id');
      var actualStart = new Date(e.item.get('actualStart'));
      var actualStart = actualStart.toLocaleDateString();
      var actualEnd = new Date(e.item.get('actualEnd'));
      var actualEnd = actualEnd.toLocaleDateString();
      $.ajax({
                type:'POST',
                url:base_url+'projects/update_project_item_connecting_duration',
                data: {id:id,actualEnd:actualEnd,actualStart:actualStart,project_id:project_id},
                success:function(result){
                    $(".project_end_date").text(result);
                    swal({
                        title: "Task Duration Updated!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }).catch(swal.noop);
                    }
             });
    }
    if(endChanged==true && startChanged==false){
    var field = e.field;
    if(field == "actualStart"){
         var value = e.item.get('actualStart');
      }
      else{
         var value = e.item.get('actualEnd'); 
      }
    var value = new Date(value);
    var value = value.toLocaleDateString();
    var id = e.item.get('id');
      
    var project_id = $("#original_project_id").val();
      
      $.ajax({
                type:'POST',
                url:base_url+'projects/update_project_item_duration',
                data: {id:id,field:field,value:value,project_id:project_id},
                success:function(result){
                    if(field == "actualEnd"){
                    $(".project_end_date").text(result);
                    swal({
                        title: "Task Duration Updated!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }).catch(swal.noop);
                    }
                }
             });
    }
    
  }

  function moveRelatedTasks(connectTo, timeShift) {
    // if the task has connected one
    if (connectTo) {
      // find the task
      var task = treeData.search('id', connectTo);
      // calculate new task position and apply it
        var newActualStart = anychart.format.parseDateTime(task.get('actualStart')).getTime() + timeShift;
        var newActualEnd = anychart.format.parseDateTime(task.get('actualEnd')).getTime() + timeShift;
      task.set('actualStart', newActualStart);
      task.set('actualEnd', newActualEnd);
      var project_id = $("#original_project_id").val();
      var id = task.get('id');
      var actualStart = new Date(newActualStart);
      var actualStart = actualStart.toLocaleDateString();
      var actualEnd = new Date(newActualEnd);
      var actualEnd = actualEnd.toLocaleDateString();
      $.ajax({
                type:'POST',
                url:base_url+'projects/update_project_item_connecting_duration',
                data: {id:id,actualEnd:actualEnd,actualStart:actualStart,project_id:project_id},
                success:function(result){
                    $(".project_end_date").text(result);
                    swal({
                        title: "Task Duration Updated!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }).catch(swal.noop);
                    }
             });
      // find connected task
      connectTo = task.get('connectTo');
      // try to move the connected task
      moveRelatedTasks(connectTo, timeShift);
    }
    // if the task doesn't have connected one it means that 
    // the chain is finished and we can start listening treeData events 
    treeData.listen("treeItemUpdate", eventHandler);
  }

   /*treeData.listen("treeItemUpdate", function (e) {
      editedRow = chart.scrollTo();
      setTimeout(scrollBack, 100, editedRow)
      var field = e.field;
      if(field == "actualStart"){
         var value = e.item.get('actualStart');
      }
      else{
         var value = e.item.get('actualEnd'); 
      }
      var value = new Date(value);
      var value = value.toLocaleDateString();
      //Its id.
      var id = e.item.get('id');
      
      var project_id = $("#original_project_id").val();
      
      $.ajax({
                type:'POST',
                url:base_url+'projects/update_project_item_duration',
                data: {id:id,field:field,value:value,project_id:project_id},
                success:function(result){
                    if(field == "actualEnd"){
                    $(".project_end_date").text(result);
                    swal({
                        title: "Task Duration Updated!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }).catch(swal.noop);
                    }
                }
             }); 
    
    
    });*/

  });
});

}

function scrollBack(editedRow) {
  chart.scrollTo(editedRow)
}

function setFullHeight(){
        // calculate required DIV height and apply it
        var traverser = chart.data().getTraverser();
        var rowHeight = chart.defaultRowHeight();
        var strokeThickness = chart.rowStroke().thickness || 1;
        var chartTotalHeight = 0;
        while (traverser.advance()) {
          if (traverser.get('rowHeight')) {
            chartTotalHeight += traverser.get('rowHeight');
          } else {
            chartTotalHeight += rowHeight;
          }
          if (strokeThickness != null || strokeThickness != undefined) {
            chartTotalHeight += strokeThickness;
          }
        }
        chartTotalHeight += chart.headerHeight() + 1;
        var container = chart.container().container();
        container.style.height = chartTotalHeight + 'px';
        chart.height(chartTotalHeight);
    }

function fullscreen(){
        chart.fullScreen(true);
        var container = chart.container().container();
        chart.height(null);
        container.style.height = '100%';
        chart.listenOnce('chartDraw', function() {
        chart.listen('chartDraw', exitFullScreen); 
        });
    }
function exitFullScreen() {
      if (!chart.fullScreen()) {
        setFullHeight();
        chart.unlisten('chartDraw', exitFullScreen);
      }
}

$(".view_ganttchart").click(function(){
    var date_range = $("#daterange").val();
    date_range = date_range.split("/").join("-")
    load_calendar(date_range);
});
$('body').on('click','.project_notifications a',function(){
    $.ajax({
            url: '<?php echo SURL. 'notifications/read_all_notifications' ?>',
            type: 'post',
            data: {},
            success: function (result) {
                $(".project_notifications").html(result);
            }
    });
});

//Component Live Search
function formatComponent(component) {
  if (!component.id) {
    return component.text;
  }
  if(component.image==""){
    return component.text;  
  }
  var $component = $(
    '<span><img src="'+component.image+'" class="img-component" /> ' + component.text + '</span>'
  );
  return $component;
};
$(document).ready(function () {
    
    $('.selectComponent').select2({
		placeholder: "Select Component",
		templateResult: formatComponent,
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/components",
		  data: function (params) {
			return {
			  searchTerm: params.term // search term
			};
		   },
			  dataType: 'json',
			},
			
	});
	$('.selectStage').select2({
		placeholder: "Select Stage",
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/stages",
		  data: function (params) {
			return {
			  searchTerm: params.term // search term
			};
		   },
			  dataType: 'json',
			},
			
	 });
});

$(document).on('submit','#addNewComponentForm',function(e){
    e.preventDefault();
    $(".component_name_error").text("");
        $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#progressFileBarComponent").text(percentComplete+"%");
                        $("#progressFileBarComponent").css("width", percentComplete+"%");
                          }
                        }, false);
                    
                        return xhr;
                },
                url: base_url+'manage/addcomponentbyquicklink', 
                type: "POST",            
                data: new FormData(this), 
                contentType: false,       
                cache: false,             
                processData:false,
                beforeSend: function(){
                    $("#add_new_component").val("Please Wait Component is adding....");
                    $("#add_new_component").attr("disabled", "true");
                },
                success: function(result){
                    $("#add_new_component").val("Add");
                    $("#progressFileBarComponent").text("0%");
                    $("#progressFileBarComponent").css("width", "0%");
                    $("#add_new_component").attr("disabled", false);
                    if(result!="error" && result!="Component Already exists"){
                      $("#addNewComponentForm")[0].reset();
                      swal({
                        title: "Component Added!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }).catch(swal.noop);
                      $('#addNewComponentModal').modal('hide');
                    }
                    else{
                        if(result=="error"){
                        swal({
                        title: "Error in adding new component please try again!",
                        text: "",
                        timer: 2000,
                        showConfirmButton: false,
                        type: "error"
                    }).catch(swal.noop);
                        }
                        else{
                            $(".component_name_error").text(result);
                        }
                    }
                }
     });
    });
    
    $(document).on('click','#addcomponentbtn',function(e){
      $("#addNewComponentForm")[0].reset();
    });


</script>

