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
$(document).ready(function() {
    setFormValidation('#SupplierInvoiceForm');
});
    change_value_invoice();
    var populated = false;
    var curr_supplier_id = 0;
    var curr_project_id = 0;
    var poorders=["I am not valid po"];
    var pccc=["I am not valid pc"];

    $(function() {
        $(".order_id_po").each(function(){poorders.push(this.value)});
        curr_supplier_id = $('#supplier_id').val();
    });


    function validateForm() {
       $(".notrequired").attr("required", true);
        if($("#SupplierInvoiceForm").valid()){
        var lstrow2 = $("#impcos1 tbody tr:last-child()").attr('tr_val');
        var lstrow1 = $("table#tablepc1 tbody tr:last").attr('ta_val');
        var status =  $('#supplierinvoicestatus').val(); var approve=1;
        if ((lstrow1 && lstrow1 > 0) || (lstrow2 && lstrow2 > 0)) {


            $(".quantitychange").each(function(){
                var ty=this.getAttribute('ty');
                var rno=this.getAttribute('rno');
                var invoicequantityold=$('#'+ty+'invoiceoriginalquantity'+rno).val();
                if(invoicequantityold==undefined){
                    invoicequantityold = 0;
                }
                var invoicequantity=$('#'+ty+'invoicequantity'+rno).val();
                var unorderqty=$('#'+ty+'orderqty'+rno).val();
                var uninvoicequantity=$('#'+ty+'uninvoicequantity'+rno).val();
                if((parseInt(invoicequantity)>(parseInt(uninvoicequantity)+parseInt(invoicequantityold))) && parseInt(uninvoicequantity)!=0 )
                 
                {
                    swal({
                    title: 'Error!',
                    text: 'Invoice quantity is greater than un-invoiced quantity or unordered quantity for an item in supplier invoice, Supplier invoice can not be approved.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);
                    approve=0;
                    return false;
                }
            });


            if(approve)
                return true;
            else
                return false;
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
            setFormValidation('#SupplierInvoiceForm');
        }
    }

    function removeall() {

        $('#podiv').html("");
        $('#pcdiv').html("");
        $('#impcos1 tbody').html("");
        $('#newcdiv').hide();
        $('#suppintot').hide();
        $("#varidescriptioin").removeAttr("required");
        $("#supplierinvoicevarstatus").removeAttr("required");

        populated = false;


    }
    function getpurchaseordermodal() {

        var project_id = $("#project_id").val();
        var supplier_id = $("#supplier_id").val();
        var last_row =   $("#podiv > div:last-child").attr('ta_val');
        poorders=["I am not valid po"]; $(".order_id_po").each(function(){poorders.push(this.value)});

        if (project_id !== 'undefined' && project_id > 0 && supplier_id > 0) {
            $.ajax({
                url:  base_url+'supplier_invoices/populate_purchase_order/',
                type: 'post',
                data: {value: project_id, supplier_id: supplier_id, last_row: last_row,poorders:poorders},
                success: function (result) {

                    var obj = jQuery.parseJSON(result);
                    if (obj.populatestage > 0)
                    {
                        $('#podiv').append(obj.returnhtml);
                        populated = true;
                    }
                    else{
                        $("#error_no_po_for_this_supplier").modal('show');
                    }

                }
            });

        } else if (project_id == 0) {

            alert("Please select project first");
        } else if (supplier_id == 0) {
            alert("Please select Supplier first");
        }
    }

   /* function getprojectcostingmodal() {

        var project_id = $("#project_id").val();
        var supplier_id = $("#supplier_id").val();
        var last_row = $("table#tablepc1 tbody tr:last").attr('ta_val');
        pccc=["I am not valid pc"]; $(".si_id_pc").each(function(){pccc.push(this.value)});

        if (project_id != 'undefined' && project_id > 0 && supplier_id > 0) {
            $.ajax({
                url: base_url+'supplier_invoices/populate_project_part_costing_rows/',
                type: 'post',
                data: {value: project_id, supplier_id: supplier_id,pccc:pccc,last_row:last_row},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    var obj = jQuery.parseJSON(result);
                    if (obj.populatestage > 0)
                    {
                        $('table#tablepc1 tbody').append(obj.returnhtml);
                        populated = true;
                    }
                    else{
                        $('table#tablepc1 tbody').append("");
                        $("#error_no_pc_for_this_supplier").modal('show');
                    }


                }
            });


        } else if (project_id == 0) {

            alert("Please select project first");
        } else if (supplier_id == 0) {
            alert("Please select Supplier first");
        }

    }*/

    function addMore() {
        $(".notrequired").removeAttr("required");
        if($("#SupplierInvoiceForm").valid()){
            var project_id = $("#project_id").val();
            var supplier_id = $("#supplier_id").val();
          
                $('#projecttitleimp').html($('#project_id option:selected').html());
    
                var last_row = $('#impcos1 tbody tr:last-child()').attr('tr_val');
    
                if (last_row === undefined) {
                    last_row = 0;
                }
    
                $.ajax({
                url: base_url+'supplier_invoices/importnew',
                type: 'post',
                data: {last_row:last_row, supplier_id: supplier_id, project_id:project_id},
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
                            setFormValidation('#ProjectVariationForm');
                            $('.selectpicker').selectpicker('refresh');
    						$('.selectComponent').select2({
    						placeholder: "Select Component",
    						templateResult: formatComponent,
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
           setFormValidation('#SupplierInvoiceForm'); 
           swal({
                title: 'Validation Error!',
                text: 'All fields are required.',
                type: 'error',
                confirmButtonClass: "btn btn-success",
                buttonsStyling: false
            }).catch(swal.noop);
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
    

    function LockProject() {
        var stt = $("#lockproject").val();
        if (stt == 1) {
            $("form input").attr('readonly', false);
            $("form select").attr('readonly', false);
            $("textarea").attr('readonly', false);
            $("form input[type='checkbox']").css('pointer-events', 'auto');
            $("form select").css('pointer-events', 'auto');
            $("#extemplate_id").css('pointer-events', 'auto');
            $("#exproject_id").css('pointer-events', 'auto');

            $("#iconlockproject .fa").removeClass('fa-lock');
            $("#iconlockproject .fa").addClass('fa-unlock');
            $('.readonlyme').each(function () {

                $(this).attr('readonly', true);
                $(this).css('pointer-events', 'none');

            });

            $("#lockproject").val(0);
        } else {
            $("form input").attr('readonly', true);
            $("textarea").attr('readonly', true);
            $("form select").attr('readonly', true);
            $("form input[type='checkbox']").css('pointer-events', 'none');
            $("#extemplate_id").css('pointer-events', 'none');
            $("#exproject_id").css('pointer-events', 'none');
            $("form select").css('pointer-events', 'none');

            $("#project_id").css('pointer-events', 'auto');
            $("#project_id").attr('readonly', false);



            $("#iconlockproject .fa").removeClass('fa-unlock');
            $("#iconlockproject .fa").addClass('fa-lock');

            $("#lockproject").val(1);
        }
    }

    function checkcreatvar(id) {

        if ($('#' + id).is(":checked")) {
            $("#createvariation").val('1');
            $('#createvariationwarn').show();
            $("#varidescriptioin").attr("required", "required");
            $("#supplierinvoicevarstatus").attr("required", "required");
        } else {
            $("#createvariation").val('0');
            $('#createvariationwarn').hide();
            $("#varidescriptioin").removeAttr("required");
            $("#supplierinvoicevarstatus").removeAttr("required");
        }
    }
    $("body").on('click', '.removeallbtn', function () {
    
    swal({
                title: 'Are you sure you want to delete all rows?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                
                        $('table#partstable tbody').html('');
                        $('table#impcos1 tbody').html('');
                        calculate();
						
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        }).catch(swal.noop);
				
            });
});

    
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

    $('body').on('change', '.quantitychange', function () {

        var quantity = $(this).val();
        
        /*if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
        ((event.which < 48 || event.which > 57) &&
          (event.which != 0 && event.which != 8))) {
        event.preventDefault();
      }
      if ((quantity.indexOf('.') != -1) &&
        (quantity.substring(quantity.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8)) {
        event.preventDefault();
         swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
          $(this).val(0);
          quantity = 0;
      }*/
        
        if(parseFloat(quantity)<0){
          swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
          $(this).val(0);
          quantity = 0;
        }
    
        var row_no = $(this).attr('rno');
       
        var ty = $(this).attr('ty');
        
        if (parseFloat(quantity) > parseFloat($('#' + ty + 'uninvoicequantity' + row_no).val()))
        {
            swal({
                title: 'Incorrect Quantity!',
                text: 'Invoice quantity can not be greater than uninvoiced quantity for purchase order or project costing part',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);

            $("#" + ty + "invoicequantity" + row_no).val(0);
            $("#" + ty + "invoicequantity" + row_no).focus();

        }

        quantity = $(this).val();
        var uc_cost = $('#' + ty + 'inuccost' + row_no).val();
        
        var subtotal = parseFloat(uc_cost) * parseFloat(quantity);
       
        if (isNaN(subtotal)) {
            subtotal = 0;
        }
       
        $("#" + ty + "insubtotal" + row_no).val(subtotal.toFixed(2));
        var mtotal = subtotal * (100 + parseFloat($("#" + ty + 'margin' + row_no).val())) / 100;
        $("#" + ty + "insubtotalmargin" + row_no).val(subtotal.toFixed(2));
        var budget = $('#' + ty + 'invoicebudget' + row_no).val();
        
        //var subtotal = budget - $('#' + ty + 'insubtotalmargin' + row_no).val();
        
        var subtotal = budget - $('#' + ty + 'insubtotal' + row_no).val();
        
        $("#" + ty + "invoicecostdiff" + row_no).val(subtotal.toFixed(2));
        if($('#'+ ty +'invoicequantity'+ row_no).val()!="0" && $('#'+ ty +'invoicebudget'+ row_no).val()!="0.00"){
        $('#current_unit_cost').val('$'+parseFloat($('#'+ ty +'inuccost'+ row_no).val()).toFixed(2));
        var invoice_unit_cost = parseFloat($('#'+ ty +'invoicebudget'+ row_no).val())/parseFloat($('#'+ ty +'invoicequantity'+ row_no).val());
        $('#invoice_unit_cost').val('$'+invoice_unit_cost.toFixed(2));
        $('#update_invoice_unit_cost').val(invoice_unit_cost);
        $('#update_rno').val(row_no);
        $('#update_component_id').val($('#componentfield'+ row_no).val());
        if($('#current_unit_cost').val()!=$('#invoice_unit_cost').val()){
          $('#componentCostModal').modal('show'); 
        
        }
        }
        
        calculate();
        calculateaddcost();

    });
    
    function calculate() {

        var total = 0;

        $(".invoicebudget").each(function () {


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
                
            $("#invoiceamountent").val("0.00");
            $("#invoiceamountnotent").val(invoiceamountist);

        } else {
            
            $("#invoiceamountent").val(total.toFixed(2));
            var diffintot = invoiceamountist-total;
			var invoiceamountnotent = parseFloat(diffintot);
            $("#invoiceamountnotent").val(invoiceamountnotent.toFixed(2));
            if(diffintot==0){
                
                $('.disableme').removeAttr('disabled');
                $('.selectpicker').selectpicker('refresh');
            }
            else
                $('.disableme').attr('disabled','disabled');
                $('.selectpicker').selectpicker('refresh');
        }
        calculateaddcost();
    }

    $("#invoiceamountist").on('blur', function () {
        if(isNaN($("#invoiceamountist").val()))
            $("#invoiceamountist").val(0);
        invoiceamountist = parseFloat($("#invoiceamountist").val());
        $("#invoiceamountist").attr("value", invoiceamountist);
        calculate();
    });

   $("body").on('blur','.invoicebudget', function () {
        var budget = $(this).val();
        if(parseFloat(budget)<0){
           swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
           budget = 0;
           $(this).val(budget);
        }
        var ty = $(this).attr('ty');
		var poinvoicebudget = parseFloat(budget);
		var row_no = $(this).attr('rno');
		$('#'+ty+row_no).val(poinvoicebudget.toFixed(2));
        
        if(ty != undefined){
        var subtotal = budget - parseFloat($('#' + ty + 'insubtotalmargin' + row_no).val());
        $("#" + ty + "invoicecostdiff" + row_no).val(subtotal.toFixed(2));}
        calculate();
        
    });
    $("body").on('blur','.invoicebudget1', function () {

        calculateaddcost();

    });

    function change_value_invoice(){
        var totalres = 0;
       
        $('.res_count').each(function() {
            var result = $(this).val();
            
            totalres = parseFloat(totalres) + parseFloat(result) ;
          
        });
        
        $('.include_in_variation').each(function() {
            var result2 = $(this).val();
            
            totalres = parseFloat(totalres) + parseFloat(result2) ;
          
        });
        
        if (isNaN(totalres)) {
            $("#total_cost").val("0.00");
            $('#createvariation').attr("checked", false);
            checkcreatvar('createvariation');
        }
        else{
            $("#total_cost").val(parseFloat(totalres).toFixed(2));
            if(parseFloat(totalres)==0){
                $('#createvariation').attr("checked", false);
                checkcreatvar('createvariation');
            }
            else{
                $('#createvariation').attr("checked", true);
                checkcreatvar('createvariation');
            }
        
        }
        
        calcuate_costing_totals();
    }

    function calculateaddcost(){
        var total = 0;
        var totalres2 = 0;
        $(".invoicebudget1").each(function () {
            var qty = $(this).val();
            var newtotal = parseFloat(qty);
            total += newtotal;
        });
        $('.include_in_variation').each(function() {
            var result2 = $(this).val();
            
            totalres2 = parseFloat(totalres2) + parseFloat(result2) ;
          
        });
        if (isNaN(total) || total == '') {


            $("#totaladd_cost").val(0);
            $("#totaladdclient_cost").val(0);
            $("#total_cost").val(0);
            $('#createvariation').attr("checked", false);
            checkcreatvar('createvariation');
        } else {
            $("#totaladd_cost").val(total.toFixed(2));
            $("#totaladdclient_cost").val(total.toFixed(2));
            $("#total_cost").val(totalres2.toFixed(2));
            if(parseFloat(totalres2)==0){
                $('#createvariation').attr("checked", false);
                checkcreatvar('createvariation');
            }
            else{
                $('#createvariation').attr("checked", true);
                checkcreatvar('createvariation');
            }
            
        }

        $(".invoicedifference").each(function () {
                var cost_value = $(this).val();
                var rno = $(this).attr("rno");
                 var ty = $(this).attr("ty");
                var invoiceAmount = $("#"+ty+"invoicebudget"+rno).val();
                //var invoiceAmount = $(this).parent('td').prev().find('input').val();
                if(cost_value!=0.00 && invoiceAmount>0){
                   $("#suppintot").show();
                   return false;
                }
                else{
                    var rowCount = $('#impcos1 >tbody >tr').length;
                    if(rowCount==0){
                       $("#suppintot").hide();
                    }
                }
           });
        calcuate_costing_totals();
    }

    $("#totaladdclient_cost").on('blur', function () {
        var valt = parseFloat($("#totaladdclient_cost").val());
        $("#total_cost").val(valt.toFixed(2));
        calcuate_costing_totals();

    });
    
    $('input[name="hide_from_summary"]'). click(function(){
        if($(this). prop("checked") == true){
        if($("#total_cost3").val()!=0 || $("#total_cost3").val()!=0.00 ){
           var price_rounding = (-1)*parseFloat($("#total_cost3").val());
            }
            else{
               var price_rounding = "0.00"; 
            }
           $("#price_rounding").val(parseFloat(price_rounding).toFixed(2));
           calcuate_costing_totals();
        }
        else{
           $("#price_rounding").val("0.00");
           calcuate_costing_totals();
        }
    });
    
    function calcuate_costing_totals() {

        var psubtotal1 = $("#total_cost").val();
        var oh_margin = isNaN($("#overhead_margin").val()) ? 0 : $("#overhead_margin").val();
        var p_margin = isNaN($("#profit_margin").val()) ? 0 : $("#profit_margin").val();
        var c_tax = isNaN($("#costing_tax").val()) ? 0 : $("#costing_tax").val();
        var psubtotal2 = isNaN($("#total_cost2").val()) ? 0 : $("#total_cost2").val();
        var psubtotal3 = isNaN($("#total_cost3").val()) ? 0 : $("#total_cost3").val();
        var price_rounding = isNaN($("#price_rounding").val()) ? 0 : parseFloat($("#price_rounding").val());


        var opercent = (parseFloat(oh_margin) / 100) * parseFloat(psubtotal1);
        var ppercent = (parseFloat(p_margin) / 100) * parseFloat(psubtotal1);
        var s2 = opercent + ppercent + parseFloat(psubtotal1);
        $("#total_cost2").val(s2);

        var tax_percent = (parseFloat(c_tax) / 100) * s2;
        var s3 = tax_percent + s2;
        $("#total_cost3").val(s3.toFixed(2));

        var s4 = price_rounding + parseFloat($("#total_cost3").val());

        $("#contract_price").val(parseFloat(s4).toFixed(2));
        
        update_variation('hide_from_summary', 'hide');

    }
    $('body').on('change', '.cal-on-change', function () {


        calcuate_costing_totals();

    });


    function removepuror(value){

        var i = poorders.indexOf("b");
        if(i != -1) {
            array.splice(i, 1);
        }
        poorders.push(this.value);
        $('#puror'+value).remove();
    }
    
    function update_component_unit_cost(){
        $('#componentCostModal').modal('hide'); 
        var rno = $('#update_rno').val();
        var component_id = $('#update_component_id').val();
        var unit_cost = $('#update_invoice_unit_cost').val();
         $.ajax({
                    url: base_url+'supplier_invoices/update_component_unit_cost/',
                    type: 'post',
                    data: {component_id: component_id,unit_cost:unit_cost},
                    beforeSend: function() {
                      //$('.loader').show();
                    },
                    success: function (result) {
                        //$('.loader').hide();
                    }
                });

        
    }
    
    function calculateInvoiceAmount(rno){ 
    var unit_cost = $('#niucostfield'+rno).val();
    var quantity = $('#nimanualqty'+rno).val();
    
    if(parseFloat(quantity)<0){
          swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
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
    change_value_invoice();
    }
    
    function update_variation(column_name, status=''){
        var id = $('#supplier_invoice_id').val();
        var type="invoice";
        var var_total = $('#contract_price').val();
        var var_round = $('#price_rounding').val();
        var var_number = $('#var_number').val();
        var column_value = 0;
        if(column_name=="hide_from_summary"){
        column_name="hide_from_sales_summary";
        if($("#hide_from_summary").is(':checked')){
            column_value = 1;
        }
        else{
            column_value=0;
        }
        }
        else{
            column_value = $('#'+column_name).val();
            column_name="variation_description";
        }
        $.ajax({
                url: base_url+'supplier_invoices/variation_update_ajax/',
                type: 'post',
                data: {var_number: var_number,column_name: column_name,column_value:column_value,id:id,var_total:var_total,var_round:var_round,type:type},
                beforeSend: function() {
                   if(status==""){
                    $('.loader').show();
                   }
                },
                success: function (result) {
                $('.loader').hide();
                if(result=="s"){
                    if(status==""){
                       toastr.success("Saved");
                }
                }
            }
        });
    }   
    
    function excludefromvariation(rno){
        var niniallowance = $("#niallowancefield"+rno).val();
        if(niniallowance!=0){
            $("#nilinetotalfield"+rno).removeClass("include_in_variation");
        }
        else{
            $("#nilinetotalfield"+rno).addClass("include_in_variation");
        }
         calculate();
    }
    
    function changeSpecificationValue(id, rno) {

        if ($('#' + id).is(":checked")) {
    
            $("#include_in_specification" + rno).val('1');
    
        } else {
    
            $("#include_in_specification" + rno).val('0');
    
        }

   }
   
   function changeAllowanceValue(id, rno) {

        if ($('#' + id).is(":checked")) {
    
            $("#client_allowance" + rno).val('1');
    
        } else {
    
            $("#client_allowance" + rno).val('0');
    
        }

   }
   
   function repopulate_all_available_components() {
        var costingId = $('#project_id').val();
        var supplier_invoice_id = $('#supplier_invoice_id').val();
        var last_row = $("table#tablepc1 tbody tr").length;
        
            if (last_row == 'undefined') {
                last_row = 0;
            }
            
        var last_row2 = $("table#tablepo1 tbody tr").length;
        
            if (last_row2 == 'undefined') {
                
            }
            else{
                last_row = parseFloat(last_row) + parseFloat(last_row2);
            }
       
            $.ajax({
                url: base_url+'supplier_invoices/repopulate_all_available_components',
                type: 'post',
                datatype: 'html',
                data: {last_row:last_row, costingId: costingId, supplier_invoice_id:supplier_invoice_id},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    $("#repopulateButton").attr("disabled", true);
                    $(".filter_section").css("display", "block");
                    var obj = jQuery.parseJSON(result);
                    if (obj.populatestage > 0)
                    {
                    $('#pcrepopultediv').html(obj.returnhtml);
                    populated = true;
                    }
                    else{
                       $("#error_no_pc_for_this_supplier").modal('show'); 
                    }
                }
            });
        
    }
    
     function change_supplier(value) {

        /*if (populated === true) {

            $("#change_supplierm").modal('show');
        } else
        {*/
            $('#divsupplierrefrence').show();
            $('#divinvoiceamountist').show();
            $('#divinvoicedate').show();
            $('#divinvoiceduedate').show();
            $('#suppintotal1').show();
			$('#suppintot').show();
            //getpurchaseordermodal();
            getprojectcostingmodal();
            curr_supplier_id = value;
        //}
    }
    
     function change_stage(value) {
        
        /*if (populated === true) {
            $("#change_stage").modal('show');
        } else
        {*/
            getprojectcostingmodal();
            curr_stage_id = value;
        //}
    }
    
     function getprojectcostingmodal() {

        var costingId = $("#project_id").val();
        var supplier_id = $("#supplier_id").val();
        var stage_id = $("#stage_id").val();
        var first_selected_text = $(".chosen-choices li:first span").text();
        var first_selected_value = $('select[name="supplier_id"] > option:contains('+first_selected_text+')').val();
        //$("#first_selected_supplier").val(first_selected_value);
        var supplier_invoice_id = $('#supplier_invoice_id').val();
        var last_row = $("table#tablepc1 tbody tr").length;
        
            if (last_row == 'undefined') {
                last_row = 0;
            }
            
        var last_row2 = $("table#tablepo1 tbody tr").length;
        
            if (last_row2 == 'undefined') {
                
            }
            else{
                last_row = parseFloat(last_row) + parseFloat(last_row2);
            }
        if (costingId != 'undefined' && costingId > 0) {
            $.ajax({
                url: base_url+'supplier_invoices/repopulate_all_available_components/',
                type: 'post',
                data: {last_row:last_row, costingId: costingId, supplier_id: supplier_id, stage_id:stage_id, supplier_invoice_id:supplier_invoice_id},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    $("#repopulateButton").attr("disabled", true);
                    $(".filter_section").css("display", "block");
                    var obj = jQuery.parseJSON(result);
                    if (obj.populatestage > 0)
                    {
                    $('#pcrepopultediv').html(obj.returnhtml);
                    populated = true;
                    }
                    else{
                       $('#pcrepopultediv').html("");
                       $("#error_no_pc_for_this_supplier").modal('show'); 
                    }
                }
            });


        } else if (project_id == 0) {

            alert("Please select project first");
        } else if (supplier_id == 0) {
            alert("Please select Supplier first");
        }

    }