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
<script src="<?php echo JS;?>nouislider.js" type="text/javascript"></script>
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
$folderName = $this->uri->segment(1);
$current_url = & get_instance(); 
$class_name = $current_url->router->fetch_class();
$method_name = $current_url->router->fetch_method();
if($class_name == "terms_and_conditions"){
?>
<script>
$.validator.addMethod('ckrequired', function (value, element, params) {
    var idname = jQuery(element).attr('id');
    var messageLength =  jQuery.trim ( CKEDITOR.instances[idname].getData() );
    return !params  || messageLength.length !== 0;
}, "Detail is required");
             
    $(document).ready(function() {
        setFormValidation('#TermsForm');
    });
</script>
<?php
}
if ($class_name == "online_store") {
	
?>

<link rel="stylesheet" href="<?php echo CSS;?>online_store.css">
<script src="<?php echo JS;?>custom_js/online_store.js"></script>

<?php }
if ($class_name == "roles") {
	
?>

<script src="<?php echo JS;?>custom_js/roles.js"></script>

<?php } 
if ($class_name == "designz") {
	
?>

<script src="<?php echo JS;?>custom_js/designz.js"></script>
<?php
if ($class_name == "designz" && $method_name == "index") {
?>
<script>
    /*========= Range Slider 1 =========*/
    $('body').on('keyup', '#search_design', function () {
        filterdata();

    })
    var connectSlider1 = document.getElementById('connect1');
    <?php
        $r1min = 10;
        $r1max = 400;
        if ($this->session->userdata('r1min')) {
            $r1min = $this->session->userdata('r1min');
            $r1max = $this->session->userdata('r1max');
        }
    ?>
        var r1min = '<?php echo $r1min; ?>';
        var r1max = '<?php echo $r1max; ?>';
    noUiSlider.create(connectSlider1, {
        start: [r1min, r1max],
        connect: false,
        step:1,
        decimal:false,
        range: {
            'min': 10,
            'max': 400,
        
        }
    });

    var snapValues1 = [
        document.getElementById('slider-snap-value-lower1'),
        document.getElementById('slider-snap-value-upper2')
    ];

    connectSlider1.noUiSlider.on('update', function (values, handle) {
        snapValues1[handle].innerHTML = Math.round(values[handle]);
    });

    connectSlider1.noUiSlider.on('change', function (values, handle) {
        filterdata();
    });

    /*========= Range Slider 2 =========*/

    var connectSlider2 = document.getElementById('connect2');
    <?php
        $r2min = 1;
        $r2max = 6;
        if ($this->session->userdata('r2min')) {
            $r2min = $this->session->userdata('r2min');
            $r2max = $this->session->userdata('r2max');
        }
    ?>
        var r2min = '<?php echo $r2min; ?>';
        var r2max = '<?php echo $r2max; ?>';
    noUiSlider.create(connectSlider2, {
        start: [r2min, r2max],
        connect: false,
        step:1,
        decimal:false,
        range: {
            'min': 1,
            'max': 6,
        
        }
    });

    var snapValues2 = [
        document.getElementById('slider-snap-value-lower2'),
        document.getElementById('slider-snap-value-upper3')
    ];

    connectSlider2.noUiSlider.on('update', function (values, handle) {
        snapValues2[handle].innerHTML = Math.round(values[handle]);
    });

    connectSlider2.noUiSlider.on('change', function (values, handle) {
        filterdata();
    });

    /*========= Range Slider 3 =========*/

    var connectSlider3 = document.getElementById('connect3');


    <?php
        $r3min = 0;
        $r3max = 4;
        if ($this->session->userdata('r3min')) {
            $r3min = $this->session->userdata('r3min');
            $r3max = $this->session->userdata('r3max');
        }
    ?>
        var r3min = '<?php echo $r3min; ?>';
        var r3max = '<?php echo $r3max; ?>';
    noUiSlider.create(connectSlider3, {
        start: [r3min, r3max],
        connect: false,
        step:1,
        decimal:false,
        range: {
            'min': 0,
            'max': 4, 
        },
    });

    var snapValues3 = [
        document.getElementById('slider-snap-value-lower4'),
        document.getElementById('slider-snap-value-upper5')
    ];

    connectSlider3.noUiSlider.on('update', function (values, handle) {

        snapValues3[handle].innerHTML = Math.round(values[handle]);

    });

    connectSlider3.noUiSlider.on('change', function (values, handle) {
        filterdata();
    });
    /*========= Range Slider 4 =========*/

    var connectSlider4 = document.getElementById('connect4');

    <?php
        $r4min = 0;
        $r4max = 4;
        if ($this->session->userdata('r4min')) {
            $r4min = $this->session->userdata('r4min');
            $r4max = $this->session->userdata('r4max');
        }
    ?>
        var r4min = '<?php echo $r4min; ?>';
        var r4max = '<?php echo $r4max; ?>';
    noUiSlider.create(connectSlider4, {
        start: [r4min, r4max],
        connect: false,
        
        step:1,
        decimal:false,
        range: {
            'min': 0,
            'max': 4
        }
    });

    var snapValues4 = [
        document.getElementById('slider-snap-value-lower6'),
        document.getElementById('slider-snap-value-upper7')
    ];

    connectSlider4.noUiSlider.on('update', function (values, handle) {
        snapValues4[handle].innerHTML = Math.round(values[handle]);
    });

    connectSlider4.noUiSlider.on('change', function (values, handle) {


        filterdata();
    });
    
     /*========= Range Slider storey =========*/

    var connectSlider6 = document.getElementById('connect6');

    <?php
        $storey1 = 1;
        $storey2 = 4;
        if ($this->session->userdata('storey1')) {
            $storey1 = $this->session->userdata('storey1');
            $storey2 = $this->session->userdata('storey2');
        }
    ?>
        var storey1 = '<?php echo $storey1; ?>';
        var storey2 = '<?php echo $storey2; ?>';
    noUiSlider.create(connectSlider6, {
        start: [storey1, storey2],
        connect: false,
        
        step:1,
        decimal:false,
        range: {
            'min': 1,
            'max': 4
        }
    });

    var snapValues6 = [
        document.getElementById('slider-snap-value-lower10'),
        document.getElementById('slider-snap-value-upper11')
    ];

    connectSlider6.noUiSlider.on('update', function (values, handle) {
        snapValues6[handle].innerHTML = Math.round(values[handle]);
    });

    connectSlider6.noUiSlider.on('change', function (values, handle) {
        filterdata();
    });
    function filterdata() {

        var sort_order = $("#sort_order").val();
        
        r1min = $('#slider-snap-value-lower1').html();
        r1max = $('#slider-snap-value-upper2').html();
        
        r2min = $('#slider-snap-value-lower2').html();
        r2max = $('#slider-snap-value-upper3').html();

        r3min = $('#slider-snap-value-lower4').html();
        r3max = $('#slider-snap-value-upper5').html();

        r4min = $('#slider-snap-value-lower6').html();
        r4max = $('#slider-snap-value-upper7').html();

         storey1 = $('#slider-snap-value-lower10').html();
         storey2 = $('#slider-snap-value-upper11').html();

        search_design = $('#search_design').val();
        
        $.ajax({
            url: "<?php echo SURL . '/designz/ajax_filter' ?>",
            type: "POST",
            data: {r1min: r1min, r1max: r1max, r2min: r2min, r2max: r2max, r3min: r3min, r3max: r3max, r4min: r4min, r4max: r4max, storey1: storey1, storey2: storey2, search_design: search_design, sort_order:sort_order},
            success: function (data) {
                    $("#fdata").html(data);
            }
        });
    }
    filterdata();
</script>

<?php  if(isset($_POST['search_filter']) && $_POST['search_filter']!=''){?>
<script>
    $("#filter_design").val('<?php echo $_POST['search_filter']?>');
</script>

<?php } }
else { ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

    $('.carousel').carousel({
    interval: 2000, // Set the slide interval in milliseconds
    ride: 'carousel' // Automatically start the carousel
});
</script>
<?php } }

if ($class_name == "users" || $class_name == "profile" || $class_name == "change_password" || $class_name == "xero_settings" || $class_name == "payment_settings") {
	
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

if ($class_name == "supplier_invoices" && $method_name == "add_invoice") {
	
?>

<script src="<?php echo JS;?>custom_js/add_supplier_invoice.js"></script>

<?php }

if ($class_name == "supplier_invoices" && $method_name == "viewinvoice") {
	
?>

<script src="<?php echo JS;?>custom_js/view_supplier_invoice.js"></script>

<?php }

if ($class_name == "price_book_requests") {
	
?>

<script src="<?php echo JS;?>custom_js/price_book_requests.js"></script>

<?php }

if ($class_name == "supplierz") {
$method_array = explode("_", $method_name);	
if(in_array("component", $method_array)){
?>
<script src="<?php echo JS;?>custom_js/components.js"></script>
<?php } else{ ?>

<script src="<?php echo JS;?>custom_js/supplierz.js"></script>

<?php } }

if ($class_name == "sales_invoices") {
	
?>

<script src="<?php echo JS;?>custom_js/sales_invoices.js"></script>

<?php }

if ($class_name == "sales_credits_notes") {
	
?>

<script src="<?php echo JS;?>custom_js/sales_credits_notes.js"></script>

<?php }

if ($class_name == "supplier_credits") {
	
?>

<script src="<?php echo JS;?>custom_js/supplier_credits.js"></script>

<?php }

if ($class_name == "cash_transfers") {
	
?>

<script src="<?php echo JS;?>custom_js/cash_transfers.js"></script>

<?php }

if ($class_name == "timesheets" && $method_name != "add_invoice") {
	
?>

<script src="<?php echo JS;?>custom_js/timesheets.js"></script>

<?php } 

if ($class_name == "timesheets" && $method_name == "add_invoice") {
?>

<script src="<?php echo JS;?>custom_js/add_supplier_invoice.js"></script>

<?php }

if ($class_name == "tickets") {
	
?>

<link href="<?php echo CSS;?>tickets.css" rel="stylesheet">
<script src="<?php echo JS;?>custom_js/tickets.js"></script>

<?php }
if ($class_name == "tasks" && $folderName!="supplierz_buildz") {
	
?>

<script src="<?php echo JS;?>custom_js/tasks.js"></script>

<?php }

if ($class_name == "public_holidays") {
	
?>

<script src="<?php echo JS;?>custom_js/public_holidays.js"></script>

<?php }

if ($class_name == "checklists" && $folderName!="supplierz_buildz") {
	
?>

<script src="<?php echo JS;?>custom_js/checklists.js"></script>

<?php }

if ($class_name == "checklists" && $folderName=="supplierz_buildz") {
	
?>

<script src="<?php echo JS;?>custom_js/supplierz_buildz/checklists.js"></script>

<?php }

if ($class_name == "tasks" && $folderName=="supplierz_buildz") {
	
?>

<script src="<?php echo JS;?>custom_js/supplierz_buildz/tasks.js"></script>

<?php }

if ($class_name == "reminders") {
	
?>

<script src="<?php echo JS;?>custom_js/reminder.js"></script>

<?php }

if ($class_name == "projects" && $folderName=="buildz") {
?>

<script src="<?php echo JS;?>custom_js/scheduling/projects.js"></script>

<?php
}
if ($class_name == "projects" && $folderName=="scheduling") {
?>
  <script src="<?php echo ASSETS;?>Gantt/libs/jquery/jquery.livequery.1.1.1.min.js"></script>
    <!--Gantt-->
  <script src="<?php echo ASSETS;?>Gantt/libs/jquery/jquery.timers.js"></script>

  <script src="<?php echo ASSETS;?>Gantt/libs/utilities.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/forms.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/date.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/dialogs.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/layout.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/i18nJs.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/jquery/dateField/jquery.dateField.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/jquery/JST/jquery.JST.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/libs/jquery/valueSlider/jquery.mb.slider.js"></script>

  <script type="text/javascript" src="<?php echo ASSETS;?>Gantt/libs/jquery/svg/jquery.svg.min.js"></script>
  <script type="text/javascript" src="<?php echo ASSETS;?>Gantt/libs/jquery/svg/jquery.svgdom.1.8.js"></script>


  <script src="<?php echo ASSETS;?>Gantt/ganttUtilities.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/ganttTask.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/ganttDrawerSVG.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/ganttZoom.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/ganttGridEditor.js"></script>
  <script src="<?php echo ASSETS;?>Gantt/ganttMaster.js"></script> 
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
  <script src="<?php echo JS;?>custom_js/scheduling/projects.js"></script>
  
  <script>
    $(document).on('click','.print_ganttchart',function(){
            $('.loader').show();
            $(".splitBox1").attr("id", "splitBox1");
            $(".splitBox2").attr("id", "splitBox2");
            let scrollWidth1 = document.getElementById("splitBox1").scrollWidth;
            let scrollWidth2 = document.getElementById("splitBox2").scrollWidth;
            let totalWidth = parseFloat(scrollWidth1) + parseFloat(scrollWidth2);
            let scrollHeight = document.getElementById("splitBox1").scrollHeight;
            
            //$(".splitBox1").width(scrollWidth1);
            $(".splitBox1").css("width", scrollWidth1);
            $(".vSplitBar").css("left", scrollWidth1);
            $(".splitBox2").css("left", scrollWidth1);
            //$(".splitBox2").width(scrollWidth2);
            $(".splitBox2").css("width", scrollWidth2);
            $(".splitBox2").css("height", "100%");
            
            $("#TWGanttArea").width(totalWidth);
            $("#TWGanttArea").css("width", totalWidth);
            $("#TWGanttArea").css("height", scrollHeight);
            $("#TWGanttArea").css("overflow", "hidden auto");
            var element = document.getElementById("TWGanttArea");

            html2canvas(element).then(function(canvas) {
                var myImage = canvas.toDataURL("image/jpeg,1.0");
                
                // Adjust width and height
                var imgWidth = (canvas.width * 20) / 240;
                var imgHeight = (canvas.height * 5) / 60;
                // jspdf changes
                var project_name = "<?php echo get_scheduling_project_name($this->uri->segment(4));?>";
                var hratio = canvas.height/canvas.width
                var pdf = new jsPDF('l','pt','a4');
         var width = pdf.internal.pageSize.width;    
        var height = width * hratio
                pdf.setFontSize(20);
                pdf.text(20, 40, project_name);
                pdf.addImage(myImage, 'JPEG', 20, 60, width-60, height-20);
                pdf.save(project_name+'.pdf');
                $('.loader').hide();
                $(".splitBox2").width("100%");
                //$(".splitBox2").css("overflow", "hidden auto");
            });


		});
		</script>

<?php }


if ($class_name == "reports" && $folderName!="buildz") {
	
?>
<script src="<?php echo JS;?>custom_js/reports.js"></script>

<?php }

if ($class_name == "reports" && $folderName=="buildz") {
	
?>
<script type="text/javascript" src="<?php echo JS;?>highcharts-gantt.js"></script>
<script type="text/javascript" src="<?php echo JS;?>exporting.js"></script>
<script src="<?php echo JS;?>custom_js/scheduling/reports.js"></script>

<?php }
if ($class_name == "templates" && $folderName=="buildz") {
	
?>
<script src="<?php echo JS;?>custom_js/scheduling/templates.js"></script>

<?php }

if ($class_name == "templates" && $folderName=="supplierz_buildz") {
	
?>
<script src="<?php echo JS;?>custom_js/supplierz_buildz/templates.js"></script>

<?php }

if ($class_name == "templates" && $folderName!="buildz" && $folderName!="supplierz_buildz") {
	
?>

<script src="<?php echo JS;?>custom_js/templates.js"></script>

<?php }

if ($class_name == "dashboard") {

?>
<script src="<?php echo JS;?>highcharts.js"></script>
<script src="<?php echo JS;?>exporting.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

	// Javascript method's body can be found in assets/js/demos.js
	//demo.initVectorMap();
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
            ignore: ":hidden",
            messages: {
                privatekey_certificate:{
                 extension: "Please select .pem certificate",
                },
                publickey_certificate:{
                 extension: "Please select .cer certificate",
                },
                attachment: {
				accept: "Only PDF files are allowed",
			    },
			    importcsv:{
                 extension: "Only CSV files are allowed.",
                },
			    
            },
            errorPlacement: function(error, element) {
				if(element.attr('name')=="privatekey_certificate"){
				    error.insertAfter(".privatekey_certificate_error");
				}
				else if(element.attr('name')=="publickey_certificate"){
				    error.insertAfter(".publickey_certificate_error");
				}
				else if($(element).hasClass("selectStage") || $(element).hasClass("selectComponent")){
                                var newPosition = $(element).next("span.select2-container");
                                error.insertAfter(newPosition);
                                var id = $(element).attr("id");
                                $("#"+id+"-error").css("display", "inherit");
                }
                else if ( element.attr("name")=="attachment"){
                   $(".attachment-error").html(error);
			    }
			    else if ( element.attr("name")=="selectTemplate[]"){
                   $("#error-container").html(error);
			    }
				else{
                error.insertAfter(element);
                
                $(element).closest('div').addClass('has-error');
				}
				var panel = element.closest('.panel-collapse');
            if (panel.length && !panel.hasClass('in')) {
                panel.collapse('show');
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
            url: '<?php echo SCURL. 'notifications/get_latest_notifications' ?>',
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


$('body').on('click','.project_notifications1 a',function(){
    $.ajax({
            url: '<?php echo SCURL. 'notifications/read_all_notifications' ?>',
            type: 'post',
            data: {},
            success: function (result) {
                $(".project_notifications").html(result);
            }
    });
});

$('body').on('click','.add_more',function(){
    var len = $('.add_another_project_container').length;
    $( ".add_another_project_container:eq(0)" ).clone().insertBefore( ".add_more_container" );
    $( ".add_another_project_container:eq("+len+")" ).find(".last_object").after("<a class='btn btn-danger btn-fill btn_less'>Remove this Project</a>");
    var previous_index = (len+parseInt(1))-parseInt(1);
    $( ".add_another_project_container:eq("+previous_index+") input" ).val(0);
    $( ".add_another_project_container:eq("+previous_index+") input.project_name" ).val('');
    $(".add_another_project_container").each(function(index) {
        var prefix = "["+index+"]";
        $(this).find("input").each(function() {
           var name_value = this.name.split("[");
           $(this).attr("name", name_value[0]+prefix);
           //this.name = this.name.replace('[]', prefix); 
        });
    });
});

$(document).on('click', ".btn_less", function (){
		    var len = $('.add_another_project_container').length;
		    if(len>1){
		        $(this).parents('.add_another_project_container').remove();
		    }
		});

$(document).ready(function() {
        setFormValidation('#CashFlowForm');
});

$('.datepickerinput').datepicker({
        format: 'dd/mm/yyyy',
        datesDisabled:<?php echo get_public_holidays();?>,
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
	 
	 $('.selectComponentSupplier').select2({
		placeholder: "Select Supplier",
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/componentSuppliers",
		  data: function (params) {
			return {
			  searchTerm: params.term // search term
			};
		   },
			  dataType: 'json',
			},
			
	 });
	 
	 $('.selectFromProject').select2({
		placeholder: "Select From Project",
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/existingProjects",
		  data: function (params) {
			return {
			  searchTerm: params.term // search term
			};
		   },
			  dataType: 'json',
			},
			
	 });
	 
	 $('.selectFromTemplate').select2({
		placeholder: "Select From Template",
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/existingTemplates",
		  data: function (params) {
			return {
			  searchTerm: params.term // search term
			};
		   },
			  dataType: 'json',
			},
			
	 });
	 
	 $('.selectSupplierzStage').select2({
		placeholder: "Select Stage",
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/getSupplierzStages",
		  data: function (params) {
			return {
			  searchTerm: params.term // search term
			};
		   },
			  dataType: 'json',
			},
			
	});
	 
	$('.selectSupplierzComponent').select2({
		placeholder: "Select Component",
		templateResult: formatComponent,
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/getSupplierzComponents",
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
	  $(".selectComponentSupplier").empty().trigger('change')
      $("#addNewComponentForm")[0].reset();
    });
    
    $('input[type=number]').on('wheel', function(e){
       return false;
    });
    
    $('input[type=number]').on('mousewheel',function(e){ $(this).blur(); });
    
    // Disable keyboard scrolling
    $('input[type=number]').on('keydown',function(e) {
        var key = e.charCode || e.keyCode;
        // Disable Up and Down Arrows on Keyboard
        if(key == 38 || key == 40 ) {
    	e.preventDefault();
        } else {
    	return;
        }
    });
</script>

