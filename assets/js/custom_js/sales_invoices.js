$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});

$.validator.addMethod("uniques", function(value, element) {
        var parentForm = $(element).closest('form');
        var timeRepeated = 0;
        if (value != '') {
            $(parentForm.find(':text')).each(function () {
                if ($(this).val() === value) {
                    timeRepeated++;
                }
            });
        }
        return timeRepeated === 1 || timeRepeated === 0;
    
    }, "You have already entered this part name");
    $.validator.addMethod('validUrl', function(value, element) {
    var url = $.validator.methods.url.bind(this);
    return url(value, element) || url('http://' + value, element);
  }, 'Please enter a valid URL');
$(document).ready(function() {
    setFormValidation('#SalesInvoiceForm');
   // setFormValidation('#formtemppayment');
    setFormValidation('#InvoiceReceiptForm');
    setFormValidation('#SalesReceiptForm');
    $(".edit-input").attr('style','display:none !important');
    $("body").on("click", 'span.edit', function (e) {
        var dad = $(this).parent();
        var id = $(this).attr("id");
        dad.find('span.status_label').hide();
        $("#status_"+id).attr('style','display:block !important');
    });
    $("body").on("blur", 'select', function (e) {
        var id = $(this).attr("id");
        $(this).hide();
        var span_id = id.split("_");
        $("#"+span_id[1]).show();
    });
});
$('body').on('click', '.btn-save-payment', function () {
    if($("#formtemppayment").valid()){
         $("#formtemppayment").submit();
    }
    else{
        setFormValidation('#formtemppayment');
    }
    
});

$('body').on('click', '.closeBtn', function () {
        swal({
                title: 'Unsave data will be removed on Close. Are you sure you want to close?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, close it!',
                buttonsStyling: false
            }).then(function() {
                         window.location.assign(base_url+"sales_invoices");
            });
    });
    
    
$('body').on('click', '.deletereceiptrow', function () {

        var row = $(this).attr('rno');
        var type = $(this).attr('itype');

        if (row > 0) {
             swal({
                title: 'Are you sure you want to remove this selected row?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, close it!',
                buttonsStyling: false
            }).then(function() {
                $('#'+type + row).remove();
                
                var total=0;

                $(".subtotal").each( function(){
                    total+=parseFloat($(this).text().replace(/\,/g,''));

                });
                
                $("#receipt_total_amount").val(total.toFixed(2));
            });
        }
    });
    
$('body').on('click', '.deleteinvoicerow', function () {

        var row = $(this).attr('rno');
        var type = $(this).attr('itype');
        
        if (row > 0) {
            swal({
                title: 'Are you sure you want to remove this selected row?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, close it!',
                buttonsStyling: false
            }).then(function() {
                         $('#'+type + row).remove();
                        var total=0;
                        $(".subtotal").each( function(){
                            total+=parseFloat($(this).text().replace(/\,/g,''));
                        });
                        $("#invoice_total_amount").val(total.toFixed(2));
            });
        }
    });
    
    function printsalesinvoice() {
    
        var mywindow = window.open();
       
        $('.printsaleinvoice').hide();
        mywindow.document.write($('#printsaleinvoice').html());
        mywindow.print();
        mywindow.close();
        return true;

    }

    function printhtmlinvoice(){
      var mywindow = window.open();  
      mywindow.document.write($('#printsaleinvoice').html());  
    }
    
     $('#receipt_payment').blur(function(){
        if(  parseFloat($(this).val().replace(/\,/g,'')) > parseFloat($('#invoice_total_amount').val().replace(/\,/g,'')) ){
            swal({
                title: 'Incorrect Amount!',
                text: 'Receipt amount can not be greater than outstanding amount.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
            $(this).val("0.00");
        }

    });


function update_status_from_xero(){
    
    $.ajax({
            url: base_url+'login/sales_invoices_payment/',
            type: 'post',
            data: {},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (response) {
               $('.loader').hide();
                window.location.assign(base_url+"sales_invoices");
            }
        });
}

$("body").on("click", '.invoice_amount_checkbox', function () {
    var id = $(this).attr("id");
    var projectId = $("#project_id").val();
    var amount = 0;
    var invoice_amount_checkbox = 0;
    if($(this).prop("checked") == true){
       amount = $("#amount"+id).val();
       invoice_amount_checkbox = 1;
    }
    $.ajax({
            url: base_url+'ajax/update_invoice_amount/',
            type: 'post',
            data: {id:id,amount:amount,type:'allowance',projectId:projectId,invoice_amount_checkbox:invoice_amount_checkbox},
            success: function (response) {
               //$(".allowancetable_container").html(response);
               getProjectInvoices(projectId);
            }
        });
});
$("body").on("click", '.variation_amount_checkbox', function () {
    var id = $(this).attr("id");
    var projectId = $("#project_id").val();
    var amount = 0;
    var invoice_amount_checkbox = 0;
    if($(this).prop("checked") == true){
       amount = $("#variationAmount"+id).val();
       invoice_amount_checkbox = 1;
    }
    $.ajax({
            url: base_url+'ajax/update_invoice_amount/',
            type: 'post',
            data: {id:id,amount:amount,type:'variation',projectId:projectId,invoice_amount_checkbox:invoice_amount_checkbox},
            success: function (response) {
               //$(".variationtable_container").html(response);
               getProjectInvoices(projectId);
            }
        });
});
function get_completed_job_sales_invoices(){
         $.ajax({
            url: base_url+'sales_invoices/get_completed_job_sales_invoices',
            type: 'post',
            data: {},
            beforeSend: function() {
                      $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $(".completed_sales_invoices").html(result);
                $('#completedJobsSalesInvoices').dataTable( {
                				"pagingType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    destroy: true,
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records",
                    }
                });
                $(".edit-input").attr('style','display:none !important');

            }
        });
    }
    
function getProjectInvoices(id) {
        if(id>0){
			$('#report_project_id').val(id);
            var last_row = $('#paymenttable tbody tr:nth-last-child(2)').attr('tr_val');
            if (last_row==undefined)
                last_row=0;
			$('#report_last_row').val(last_row);
            $.ajax({
                url: base_url+'sales_invoices/get_all_by_project/',
                type: 'post',
                data: {projectId: id, type: 'allowance', last_row:last_row},
                success: function (result) {
                    
                    response = jQuery.parseJSON(result);
                    
                    $('#allowancetable tbody').html(response.allowance);
                    $('#allowancepaymenttable tbody').html(response.allowance_invoices_payments)
                    
 
                    $('#allowancetable tbody tr th').css("background-color", "#C0B9B9");
                    $('#allowancepaymenttable tbody tr th').css("background-color", "#C0B9B9");
                    
                    $('#contractprice').html('$'+response.contractprice);
                    
                    tallowance=response.totaldiff;
                    
                                        
                    $('#variationtable tbody').html(response.variation);
                    
 
                    $('#variationtable tbody tr th').css("background-color", "#C0B9B9");
                    
                    tvarhid=response.totalvars;
                    
                    $('#tallowancevar').text( Math.abs(( parseFloat(tallowance) + parseFloat(tvarhid) )).toFixed(2) );

                    if(parseFloat(tallowance) + parseFloat(tvarhid) < 0 ){
                        $('#signtallowancevar').text('-');
                    }
                    
                   $('#paymenttable tbody').html(response.payment);
				   $('.report_btn a').attr("href", base_url+"sales_invoices/report/"+response.project_id);
                   

                   $('#paymenttable tbody tr th').css("background-color", "#C0B9B9");
                                   
                    
                }
            });
            $('#populatetables').show();
                   
        }
        else
            $('#populatetables').hide();
            
            
    }

function addMore() {

        var project_id = $("#project_id").val();
        var last_row = $('#paymenttable tbody tr:nth-last-child(2)').attr('tr_val');
        if (last_row === undefined) {
                last_row = 0;
        }    

        if (project_id == 0) {

            alert("Please select project first");
        } else{

            $.post(base_url+"sales_invoices/add_new_temp_payment", {project_id:project_id, last_row:last_row, balance: $('#lastbalance').text() })
                    .done(function (data) {
                        var str = data;


                        var obj = jQuery.parseJSON(str);
                        var last_row = $('#paymenttable tbody tr:nth-last-child(2)').attr('tr_val');
                        if (last_row === undefined) {
                            last_row = 0;
                        }
                        last_row++;
                        
                        $(obj.newitem).insertBefore($("#paymenttable tbody tr.allowancesRow"));
                        $(".add_new_payment").attr("disabled", "true");

                    });

        }
    }

    $('body').on('click', '.deletepaymentrow', function () {
        var row = $(this).attr('tr_val');
        var id = $(this).attr('id');
        if (row > 0) {
            swal({
                title: 'Are you sure, you want to remove the selected row?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                
                $.post(base_url+"sales_invoices/delete_payment", {id:id})
                .done(function (data) {
                    $('#trnumber' + row).remove();
                    $(".add_new_payment").attr("disabled", "false");
                });

            });
        }
    });
