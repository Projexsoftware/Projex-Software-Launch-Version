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
if ($class_name == "help") {
	
?>

<script src="<?php echo JS;?>custom_js/admin/help.js"></script>

<?php } 

if ($class_name == "profile" || $class_name == "change_password") {
	
?>

<script src="<?php echo JS;?>custom_js/admin/users.js"></script>

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
			    file: {
				extension: "Only PDF file is allowed",
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
			    else if ( element.attr("name")=="file"){
                   $(".file-error").html(error);
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
	$('.filterSupplierzComponent').select2({
		placeholder: "Select Component",
		templateResult: formatComponent,
		ajax: {
		  type:'post',
		  url: "<?php echo base_url(); ?>ajax/filterSupplierzComponents",
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
      $("#addNewComponentForm")[0].reset();
    });
</script>

