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
var populated = false;
var curr_supplier_id = 0;
var curr_project_id = 0;
var creditamountist =0.00;
  $(document).ready(function() {
       setFormValidation('#SupplierCreditForm');
  });
function validateForm() {
        if ($('#createvariation').is(":checked")) {
           $(".notrequired").attr("required", true);
        }
        else{
           $(".notrequired").removeAttr("required");
        }
        
        $("#suppliercreditstatus").attr("required", true);
        
        if($("#SupplierCreditForm").valid()){
            var lstrow3 = $("#impcos1 tbody tr:last-child()").attr('tr_val');
            var lstrow2 = $("table#tablepc tbody tr:last").attr('ta_val');
            var lstrow1 = $("table#tablepo1 tbody tr:last").attr('to_val');
            if ((lstrow1 && lstrow1 > 0) || (lstrow2 && lstrow2 > 0) || (lstrow3 && lstrow3 > 0)) {
                return true;
            } else {
                swal({
                    title: 'Error!',
                    text: 'Add at least one part to save this supplier invoice.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);
                return false;
            }
        }
        else{
            setFormValidation('#SupplierCreditForm');
        }
    }

function checkcreatvar(id) {

        if ($('#' + id).is(":checked")) {
            $("#createvariation").val('1');
            $('#createvariationwarn').show();
            $("#varidescriptioin").attr("required", "required");
            $("#suppliercreditvarstatus").attr("required", "required");
        } else {
            $("#createvariation").val('0');
            $('#createvariationwarn').hide();
            $("#varidescriptioin").removeAttr("required");
            $("#suppliercreditvarstatus").removeAttr("required");
        }
    }
    
  function calcuate_costing_totals() {
        var psubtotal1 = $("#total_cost").val();
        var oh_margin = isNaN($("#overhead_margin").val()) ? 0 : $("#overhead_margin").val();
        var p_margin = isNaN($("#profit_margin").val()) ? 0 : $("#profit_margin").val();
        var c_tax = isNaN($("#costing_tax").val()) ? 0.00 : $("#costing_tax").val();
        var psubtotal2 = isNaN($("#total_cost2").val()) ? 0.00 : $("#total_cost2").val();
        var psubtotal3 = isNaN($("#total_cost3").val()) ? 0.00 : $("#total_cost3").val();
        var price_rounding = isNaN($("#price_rounding").val()) ? 0.00 : parseFloat($("#price_rounding").val());


        var opercent = (parseFloat(oh_margin) / 100) * parseFloat(psubtotal1);
        var ppercent = (parseFloat(p_margin) / 100) * parseFloat(psubtotal1);
        var s2 = opercent + ppercent + parseFloat(psubtotal1);
        $("#total_cost2").val(s2.toFixed(2));

        var tax_percent = (parseFloat(c_tax) / 100) * s2;
        var s3 = tax_percent + s2;
        $("#total_cost3").val(s3.toFixed(2));
        
       
        if($('input[name="hide_from_summary"]').is(":checked")){
        if($("#total_cost3").val()!=0 || $("#total_cost3").val()!=0.00 ){
           var price_rounding = (-1)*parseFloat($("#total_cost3").val());
            }
            else{
               var price_rounding = "0.00"; 
            }
           $("#price_rounding").val(parseFloat(price_rounding).toFixed(2));
        }
        else{
           $("#price_rounding").val("0.00");
        }
        
        var price_rounding = isNaN($("#price_rounding").val()) ? 0.00 : parseFloat($("#price_rounding").val());
        
        var s4 = price_rounding + parseFloat($("#total_cost3").val());

        $("#contract_price").val(parseFloat(s4).toFixed(2));

    }
    
function calculateInvoiceAmount(rno){ 
    var unit_cost = $('#niucostfield'+rno).val();
    var quantity = $('#nimanualqty'+rno).val();
    
    if(parseFloat(quantity)<0){
          swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
          $('#nimanualqty'+rno).val(0);
          quantity = 0;
    }
    
    var invoice_amount = parseFloat(unit_cost)*parseFloat(quantity);
    $('#nilinetotalfield'+rno).val(invoice_amount.toFixed(2));
    calculate();
    if(quantity!="" && invoice_amount!=""){
    calculateaddcost();
    }
    }
    
function addMore() {
        $(".notrequired").removeAttr("required");
        $("#suppliercreditstatus").removeAttr("required");
        if($("#SupplierCreditForm").valid()){
        var project_id = $("#project_id").val();
        var supplier_id = $("#supplier_id").val();
            $('#projecttitleimp').html($('#project_id option:selected').html());

            var last_row = $('#impcos1 tbody tr:last-child()').attr('tr_val');

            if (last_row === undefined) {
                last_row = 0;
            }

            $.ajax({
            url: base_url+'supplier_credits/importnew',
            type: 'post',
            data: {last_row:last_row, supplier_id: supplier_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (data) {
                       $('.loader').hide();
                        var str = data;
                        var obj = jQuery.parseJSON(str);
                        var last_row = $('#impcos1 tbody tr:last-child()').attr('tr_val');
                        if (last_row === undefined) {
                            last_row = 0;
                        }
                        last_row++;
                        console.log(obj.html1);
                        $('#impcos1 tbody').append(obj.html1);
                        $("#nisupplierfield" + last_row).css('pointer-events', 'none');


                        populated = true;
                        $('#suppintot').show();
                        $('#newcdiv').show();
						$('.selectComponent').select2({
						placeholder: "Select Component",
						ajax: {
						  type:'post',
						  url: base_url+"ajax/components",
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
						  url: base_url+"ajax/stages",
						  data: function (params) {
							return {
							  searchTerm: params.term // search term
							};
						   },
							  dataType: 'json',
							},
							
					 });
            }
        });

        }
        else{
             setFormValidation('#SupplierCreditForm');
        }

    }
    
$('body').on('change', '.quantitychange', function () {

        var quantity = $(this).val();
        
        if(parseFloat(quantity)<0){
          swal({
                    title: 'Incorrect Quantity! ',
                    text: 'Please enter correct quantity',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);
          $(this).val(0);
          quantity = 0;
        }
    
        var row_no = $(this).attr('rno');
       
        var ty = $(this).attr('ty');
        
        var invoicequantityold=$('#'+ty+'invoiceoriginalquantity'+row_no).val();
        if(invoicequantityold==undefined){
            invoicequantityold = 0;
        }

        if (parseInt(quantity) > parseInt($('#' + ty + 'uninvoicequantity' + row_no).val())+parseInt(invoicequantityold))
        {
            
            swal({
                    title: 'Incorrect Quantity! ',
                    text: 'Supplier Credit quantity can not be greater than invoiced quantity for project costing part',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);

            $("#" + ty + "suppliercreditquantity" + row_no).val(0);
            $("#" + ty + "suppliercreditquantity" + row_no).focus();

        }

        quantity = $(this).val();
        var uc_cost = $('#' + ty + 'inuccost' + row_no).val();
        
        var subtotal = parseFloat(uc_cost) * parseFloat(quantity);
       
        if (isNaN(subtotal)) {
            subtotal = 0;
        }
    
       
        $("#" + ty + "suppliercreditamount" + row_no).val(subtotal.toFixed(2));
        
        calculate();
        calculateaddcost();

    });
    
function getsupplierbycostingid(value) {
        if (populated === true) {
            $("#change_project").modal('show');
        } else {
                curr_project_id = value;

                $.ajax({
                    url: base_url+'supplier_credits/getsupplier/',
                    type: 'post',
                    datatype: 'json',
                    data: {costing_id: value},
                    beforeSend: function() {
                      $('.loader').show();
                    },
                    success: function (result) {
                        $('.loader').hide();
                        $('#supplier_id').html(result);
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
        }
    }
    
function componentval(row_no) {

        var component_id = $("#nicomponentfield"+row_no).val();
        $.ajax({
                url: base_url+'setup/getcompnent',
                type: 'post',
                data: {value: component_id},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    var obj = jQuery.parseJSON(result);
                    $('#niuomfield' + row_no).val(obj.component_uom);
                    $('#niucostfield' + row_no).val(obj.component_uc);
                    $('#nisupplierfieldname' + row_no).val(obj.supplier_name);
                    $('#nisupplierfield' + row_no).val(obj.supplier_id);
                    calculate();
                    calculateInvoiceAmount(row_no);
                    calculateaddcost();
                    
                }
            });
    }
    
     function calculate() {

        var total = 0;
        

        $(".invoicebudget").each(function () {


            var qty = $(this).val();
            var newtotal = parseFloat(qty);
            total += newtotal;       

        });
        $(".invoicebudget1").each(function () {


            var qty = $(this).val();
            var newtotal = parseFloat(qty);
            total += newtotal;       

        });
        $(".allowancebudget").each(function () {


            var qty = $(this).val();
            var newtotal = parseFloat(qty);
            total += newtotal;       

        });
        if (isNaN(total) || total == '') {
                
            $("#creditamountent").val("0.00");
            $("#creditamountnotent").val(creditamountist);

        } else {
            
            $("#creditamountent").val(total.toFixed(2));
            var diffintot = creditamountist-total.toFixed(2);
			var creditamountnotent = parseFloat(diffintot);
            $("#creditamountnotent").val(creditamountnotent.toFixed(2));
            if(diffintot==0){
                
                $('.disableme').removeAttr('disabled');
            }
            else
                $('.disableme').attr('disabled','disabled')
        }
        calculateaddcost();
    }
    
    function calculateaddcost(){
		
        var total = 0;
		var total1 = 0;
        
        $(".invoicebudget").each(function () {
            var qty = $(this).val();
            if(qty!="allowance"){
            var newtotal = parseFloat(qty);
            total += newtotal; 
            }
        });
		total1 += total;
		$(".invoicedifference").each(function () {
			
            var qty1 = $(this).val();
            if(qty1!="allowance"){
            var newtotal1 = parseFloat(qty1);
            total1 += newtotal1;    
            }
        });
         if (isNaN(total) || (total == '' && total1=='')) {
            $("#totaladd_cost").val("0.00");
            $("#totaladdclient_cost").val("0.00");
            $("#total_cost").val("0.00");
            $('#createvariation').attr("checked", false);
            checkcreatvar('createvariation');
        } else {
           
            $("#totaladd_cost").val(total1.toFixed(2));
            $("#totaladdclient_cost").val(total1.toFixed(2));
            $("#total_cost").val(total1.toFixed(2));
            $('#createvariation').attr("checked", true);
            checkcreatvar('createvariation');
        }
        
        calcuate_costing_totals();
    }
    
    
    $('body').on('click', '.deleterow', function () {

        var row = $(this).attr('rno');
        swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                
                        $("#nitrnumber"+row).remove();
                        calculate();
						
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })	
				
            });
    });
    
    function changeproject() {

        removeall();
        getsupplierbycostingid($('#project_id').val());
    }

    function donotchangeproject() {

        $('#project_id').val(curr_project_id);

    }

    function changesupplier() {

        removeall();
        change_supplier($('#supplier_id').val());

    }

    function donotchangesupplier() {

        $('#supplier_id').val(curr_supplier_id);

    }
    
    function removeall() {

        $('#podiv').html("");
        $('#pcdiv').html("");
        $('#impcos1 tbody').html("");
        $('#newcdiv').hide();
        $('#suppintot').hide();
        $("#varidescriptioin").removeAttr("required");
        $("#suppliercreditvarstatus").removeAttr("required");
                       
        populated = false;


    }
    
    
     function change_supplier(value) {

        if (populated === true) {

            $("#change_supplierm").modal('show');
        } else
        {
            getprojectcostingmodal();
            curr_supplier_id = value;
        }
    }
    
    $("#creditamountist").on('blur', function () {
        if(isNaN($("#creditamountist").val()))
            $("#creditamountist").val(0);
        creditamountist = parseFloat($("#creditamountist").val());
        calculate();
    });
    
    function getprojectcostingmodal() {

        var project_id = $("#project_id").val();
        var supplier_id = $("#supplier_id").val();


        if (project_id != 'undefined' && project_id > 0 && supplier_id > 0) {
            $.ajax({
                url: base_url+'supplier_credits/populate_project_part_costing/',
                type: 'post',
                data: {value: project_id, supplier_id: supplier_id},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                     $('.loader').hide();
                    var obj = jQuery.parseJSON(result);
                    if (obj.populatestage > 0)
                    {
                    $('#pcdiv').html(obj.returnhtml);
                    populated = true;
                    }
                    else{
                       $("#error_no_pc_for_this_supplier").modal('show'); 
                    }
                    
                }
            });

        } 

    }
    
    