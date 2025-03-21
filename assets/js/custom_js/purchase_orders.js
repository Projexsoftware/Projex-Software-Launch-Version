    var added_parts = ["I m not valid part"];
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
        setFormValidation('#PurchaseOrderForm');
        /*var url = window.location.href;
        var segments = url.split( '/' );
        var action = segments[5];
        if(action=="porder" && segments[6]==undefined){
        setPartsForStages();
        }*/
    });
    
    var sereal_count = 0;
    
    $(document).ready(function () {
        //calculate();
    });
    
    function componentval(th) {
        value = $(th).val();

        row_no = $(th).attr('rno');
        $.post(base_url+"setup/getcompnent", {value: value})
                .done(function (data) {
                    var str = data;
                    var obj = $.parseJSON(str);
                    $('#uomfield' + row_no).val(obj.component_uom);
					var ucost_field= parseFloat(obj.component_uc);
                    $('#ucostfield' + row_no).val(ucost_field.toFixed(2));
                    $('#supplierfield' + row_no).val(obj.supplier_id);
                    $('#supplierfieldname' + row_no).val(obj.supplier_name);
                    calculate();
                }, "json");
    }
    
    function calculate(is_remove_all="") {
        
    if(is_remove_all!=""){
         $("#nipototal").hide();
         $("#PurchaseOrderForm")[0].reset();
    }
    else{
     var total_order_amount = 0;
     $(".total_order").each(function () {
         var row_no = $(this).attr("rno");
         var total_order = $("#total_order"+row_no).val();
         total_order_amount +=parseFloat(total_order);
         if(total_order>0){
         var unit_cost = $("#pmlinetotalfield"+row_no).val();
         var total_differenece = parseFloat(total_order)-parseFloat(unit_cost);
        
         if(total_differenece>0){
             $("#marginaddprojectcost_line"+row_no).val(parseFloat(total_differenece).toFixed(2));
         }
         else{
             $("#marginaddprojectcost_line"+row_no).val(0.00);
         }
         }
     });
        var total = 0;
        var val = 0;
        var total_order_cost = 0;
        
        $(".marginaddprojectcost_line").each(function () {
            total += parseFloat($(this).val());
        });
        
        $(".marginaddcost_line").each(function () {
            total += parseFloat($(this).val());
        });
        $(".total_order_cost").each(function () {
            total_order_cost += parseFloat($(this).val());
        });
        if (isNaN(total_order_cost) || (total_order_cost == '' && (total_order_amount=='' || total_order_amount==0))) {
                $("#total_cost").val("0.00"); $("#totaladd_cost").val("0.00");
                $('#creatvariation').attr("checked", false);
                checkcreatvar('creatvariation');
            } else {
                $("#total_cost").val(total_order_cost.toFixed(2)); $("#totaladd_cost").val(total_order_cost.toFixed(2));
                $('#creatvariation').attr("checked", true);
                checkcreatvar('creatvariation');
            }
    
        calcuate_costing_totals();
    }
}

    $('body').on('change', '.cal-on-change', function () {
        calcuate_costing_totals();
    });

    function getComponent(id) {
        $('#comopoentdivid').val(id);
    }

    var cloneIndex = $(".clonedInput").length;
    var clonedStage = $(".clonedStage").length;

    if (clonedStage == 1)
    {
        $(".remove-stage").hide();
    }
    if (cloneIndex == 1)
    {
        $(".remove").hide();
    }

    function removeDiv(val, num) {

        var cloneIndex = $(".clonedInput").length;
        if (cloneIndex > 1)
        {
            var partcount = $("#clonedStage" + val + " #stagecount" + val).val();
            var partnewcount = parseInt(num) - 1;
            var count = parseInt(partcount);
            if (partnewcount == 1)
            {
                $('#clonedStage' + val + ' .remove').hide();
            }
            $("#clonedStage" + val + " #stagecount" + val).val(partnewcount);
            $('#StageComponent' + val + ' #clonedInput' + num).remove();
        }
    }

    function removeStage(val) {
        if (val <= 2)
        {
            $('.remove-stage').hide();
        }
        $('#clonedStage' + val).remove();
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
                
                        $("#trnumber"+row).remove();
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

    function addMore(val) {
        var costingId = $('#costing_id').val();
        var supplier_id = $('#supplier_id').val();
        var stage_id = $('#supplier_stage_id').val();
        var lastRowIndex = 0, val;
        $("table#partstable tbody tr:not('[class^=nopartadded]')").each(function() {
          val = parseInt($(this).attr("tr_val"));
          if (val > lastRowIndex) {
            lastRowIndex = val;
          }
        });
        var lastRowIndex2 = 0, val;
        $("table#impneworder tbody tr:not('[class^=nopartadded]')").each(function() {
          val = parseInt($(this).attr("tr_val"));
          if (val > lastRowIndex2) {
            lastRowIndex2 = val;
          }
        });
        var last_row = lastRowIndex;
           
            if (lastRowIndex == undefined || lastRowIndex2 == undefined) {
                last_row = 0;
            }
            if (lastRowIndex2 > 0) {
                last_row = lastRowIndex2;
            }

            $.ajax({
                url: base_url+'purchase_orders/populate_new_costing_row/',
                method: 'post',
                data: {last_row: last_row},
                beforeSend: function() {
                  $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    $('table#impneworder tbody').append(result);
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
                    populatedb=true;
                    /*lstrow = $("table#impneworder tbody tr:last-child()").attr('tr_val');
                    $.ajax({
                        url: base_url+'purchase_orders/getcomponentbysupplier/',
                        type: 'post',
                        data: {supplier_id: supplier_id},
                        success: function (result1) {
                            console.log(result1);
                            $('#componentfield' + lstrow).html(result1);
                            $('.selectpicker').selectpicker('refresh');
                            $('#componentfield' + lstrow).attr('required', '');
                            $('#manualqty' + lstrow).val(0);
                        }

                    });*/

                    /*var lstrow = $("table#impneworder tbody tr:last-child()").attr('tr_val');

                    $('#stagefield' + lstrow).val(stage_id);
                    $('#supplierfield' + lstrow).addClass("readonlyme");
                    $('#stagefield' + lstrow).addClass("readonlyme");
                    $('#ucostfield' + lstrow).addClass("readonlyme");
                    $('#uomfield' + lstrow).addClass("readonlyme");*/
                }

            });

            $("#impnopartadded").hide();
            $('#nipototal').show();
    }
    
    function addMorePart(val) {

        $("#add-more-row").show();
        var lastrow = $(".partstable:last tbody tr:last-child()").attr('tr_val');
    
        if (lastrow == 'undefined' || lastrow==undefined) {
            lastrow = 0;
        }
        else{
        lastrow = parseInt(lastrow)+1;
        }
        
        var lastrow2 = $("table#add-more-row tbody tr:last-child()").attr('tr_val');
        if (lastrow2 == 'undefined' || lastrow2==undefined) {
            lastrow2 = 0;
        }
        else{
        lastrow = parseInt(lastrow2)+1;
        }
        
        $.ajax({
            url: base_url+"project_costing/populate_new_costing_row",
            type: 'post',
            data: {last_row: lastrow},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('table#add-more-row tbody').append(result);
                setFormValidation('#ProjectCostingForm');
                $('.selectpicker').selectpicker('refresh');
            }
        });

    }

    function changeAllowanceValue(id, rno) {

    if ($('#' + id).is(":checked")) {
        $("#" + id).val('1');
        $("#allowance" + rno).val('1');
    } else {
        $("#allowance" + rno).val('0');
    }
}

function changeSpecificationValue(id, rno) {

    if ($('#' + id).is(":checked")) {
        $("#include_in_specification" + rno).val('1');
    } else {
        $("#include_in_specification" + rno).val('0');
    }
}
    function CheckCostEstimation() {
    
        var check = false;
        $(".costestimation").each(function () {
            var value = $(this).val();
            if (value == 'estimated') {
                check = true;
    
            }
        });
        if (check == true) {
            $("#estimatewarning").show();
        }
        else {
            $("#estimatewarning").hide();
        }
    
    }
    
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip(); 
    });
    
    function calcuate_costing_totals() {
        var psubtotal1 = $("#total_cost").val();
    
        var oh_margin = isNaN($("#overhead_margin").val()) ? 0 : $("#overhead_margin").val();
        var p_margin = isNaN($("#profit_margin").val()) ? 0 : $("#profit_margin").val();
        var c_tax = isNaN($("#costing_tax").val()) ? 0 : $("#costing_tax").val();
        var psubtotal2 = isNaN($("#total_cost2").val()) ? 0 : $("#total_cost2").val();
        var psubtotal3 = isNaN($("#total_cost3").val()) ? 0 : $("#total_cost3").val();
    
        var opercent = (parseFloat(oh_margin) / 100) * parseFloat(psubtotal1);
        var ppercent = (parseFloat(p_margin) / 100) * parseFloat(psubtotal1);
        var s2 = opercent + ppercent + parseFloat(psubtotal1);
        $("#total_cost2").val(s2.toFixed(2));
    
        var tax_percent = (parseFloat(c_tax) / 100) * s2;
        var s3 = tax_percent + s2;
        $("#total_cost3").val(s3.toFixed(2));
        $("#contract_price").val((parseFloat(s3)+parseFloat($("#price_rounding").val())).toFixed(2));
        
        update_variation('hide_from_summary', 'no_msg');
    }

    function calculateTotal(rowno, ty) {

    if (ty == undefined)
        ty = '';

    var mqty = parseFloat($("#" + ty + "manualqty" + rowno).val());
    /*if ((event.which != 46 || mqty.indexOf('.') != -1) &&
        ((event.which < 48 || event.which > 57) &&
          (event.which != 0 && event.which != 8))) {
        event.preventDefault();
      }
      if ((mqty.indexOf('.') != -1) &&
        (mqty.substring(mqty.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8)) {
        event.preventDefault();
         swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
           $("#" + ty + "manualqty" + rowno).val(0);
           mqty = 0;
      }*/
    
    if(parseFloat(mqty)<0){
          swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
          $("#" + ty + "manualqty" + rowno).val(0);
          mqty = 0;
    }
        
    var ucost = parseFloat($("#" + ty + "ucostfield" + rowno).val());
    
    if(parseFloat(ucost)<0){
           swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
           ucost = 0;
           $("#" + ty + "ucostfield" + rowno).val(ucost);
    }
    
    if (isNaN(mqty)) {
        mqty = 0;
        swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        $("#" + ty + "manualqty" + rowno).val(0);
        $("#" + ty + "linetotalfield" + rowno).val(0);
    } else if (parseFloat(mqty) > ($("#" + ty + "reqquantity" + rowno).val())) {
        swal({
                title: 'Error!',
                text: 'Order quantity cannot be greater than available quantity.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        mqty = 0;
        $("#" + ty + "manualqty" + rowno).val(0);
        $("#" + ty + "linetotalfield" + rowno).val(0);
    }

    if (isNaN(ucost)) {
        ucost = 0;
        swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        $("#" + ty + "ucostfield" + rowno).val(0);
        $("#" + ty + "linetotalfield" + rowno).val(0);
    } else {
        ucost = ucost;
    }
    
    var row_total = parseFloat(mqty) * parseFloat(ucost);
    
    $('#' + ty + 'linetotalfield' + rowno).val(row_total.toFixed(2));
    $('#' + ty + 'useradditionalcost' + rowno).val(row_total.toFixed(2));
    var margin = parseFloat($("#" + ty + "marginfield" + rowno).val());
    if (isNaN(margin)) {
        margin = 0;
    }

    var marginline = (margin / 100) * row_total;
    var vtotal = marginline + row_total;
    $("#" + ty + "margin_linefield" + rowno).val(vtotal.toFixed(2));
    marginline = (margin / 100) * $("#useradditionalcost" + rowno).val();
    var vtotal = marginline + parseFloat($("#useradditionalcost" + rowno).val());
    $('#marginaddcost_line' + rowno).val(vtotal.toFixed(2));
    calculate();
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
                        calculate($is_remove_all=true);
						
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        }).catch(swal.noop);
				
            });
});

    function validateForm() {
        if($("#PurchaseOrderForm").valid()){
            var lstrow = $('#partstable > tbody').find('tr:not("[class^=nopartadded]")').length;
            
            var newlstrow = $('#impneworder > tbody').find('tr:not("[class^=nopartadded]")').length;
            var is_submit = false;
            if (lstrow > 0 || newlstrow > 0) {
                $(".quantity_ordered").each(function () {
                    if($(this).val()!=0){
                     is_submit = true;
                     return false;
                    }
                });
                if(is_submit==true){
                    $("td .selectpicker").attr('disabled', false);
                    $("td input[type='checkbox']").attr('disabled', false);
                    return true;
                }
                else{
                swal({
                    title: 'Error!',
                    text: 'Ordered Quantity should not be 0.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);
                    $(".autoPurchaseOrder").prop("checked", false);
                    return false;
                }
            }
            else {
                swal({
                    title: 'Error!',
                    text: 'Add at least one part to save this purchase order.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);
                    $(".autoPurchaseOrder").prop("checked", false);
                    return false;
            }
        }
        else{
            setFormValidation('#PurchaseOrderForm');
            $(".autoPurchaseOrder").prop("checked", false);
        }
    }
    
    function validateAutomaticForm(){
        var lstrow = $("table tbody tr:last-child()").attr('tr_val');
        if (lstrow && lstrow > 0) {
            return true;
        }
        else{
            swal({
                title: 'Error!',
                text: 'Add at least one part to save this purchase order.',
                type: 'error',
                confirmButtonClass: "btn btn-success",
                buttonsStyling: false
                }).catch(swal.noop);
            return false;
        }
    }
    
    $('body').on('click', '.autoPurchaseOrder', function () {
        if($(this).is(':checked')){
            $("#PurchaseOrderForm").attr("action", base_url+"purchase_orders/automatic_purchase_order_process");
            $("#purchaseorderstatus").removeAttr("required");
            $("#first_selected_supplier").removeAttr("required");
            $(".add-new-item").attr("disabled", true);
            setPartsForStages();
            //$("#PurchaseOrderForm").submit();
        }
        else{
            $("#PurchaseOrderForm").attr("action", base_url+"purchase_orders/manual_purchase_order_process");
            $("#purchaseorderstatus").attr("required", true);
            $(".add-new-item").attr("disabled", false);
            $("#first_selected_supplier").attr("required", true);
            setPartsForStages();
        }
    });

    $('body').on('click', '.updateunitcost', function () {

        var row_no = $(this).attr('rno');
        var component_id = $("#componentfield"+row_no).val();
        var supplier_id = $("#supplierfield"+row_no).val();
        var costing_part_id = $("#costing_part_id"+row_no).val();
        $.ajax({
            url: base_url+'setup/getcompnent',
            type: 'POST',
            data: {value: component_id,supplier_id:supplier_id,costing_part_id:costing_part_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (data) {
                $('.loader').hide();
                    if(data=="error"){
                        var prev_value = $( "body" ).data("prev");
                        $('#componentfield' + row_no + ' option[value="' + prev_value + '"]').attr('selected', 'selected');
                        $('.selectpicker').selectpicker('refresh');
                        swal({
                            title: 'Error!',
                            text: 'Purchase order has been created. This line cannot be changed.',
                            type: 'error',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        }).catch(swal.noop);
                    }
                    else{
                    var str = data;
                    var obj = jQuery.parseJSON(str);
                    $('#ucostfield' + row_no).val(parseFloat(obj.component_uc).toFixed(2));
                    calculate();
                    calculateTotal(row_no);
                }
            }
        });
        
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
    
    function get_completed_job_purchase_orders(){
         $.ajax({
            url: base_url+'purchase_orders/get_completed_job_purchase_orders',
            type: 'post',
            data: {},
            beforeSend: function() {
                      $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $(".completed_purchase_orders").html(result);
                $('#completedJobsPurchaseOrders').DataTable({
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
            }
        });
    }
    
    var added_parts = ["I m not valid part"];
    var supplier_id_g = 0;
    var stage_id_g = 0;
    var populateda=false;
    var populatedb=false;
    
    function getCostingbysupplier(id) {
    var a = true;

   /* if (supplier_id_g > 0 && (populatedb==true || populateda==true))
        a = sweetConfirm('Do you really want to change supplier?', 'All data will be removed!\n\Press cancel to retain your data or press ok to change supplier', function (confirmed){*/
        if (id !="") {
                supplier_id_g = id;
                $('#supplier_id').val(supplier_id_g);
                $('.selectpicker').selectpicker('refresh');
                added_parts = ["I m not valid part"];
                supplier_id_g = id;
                var costing_id = $("#costing_id").val();
        
                $("#partstable tbody").html('<tr id="nopartadded">   <td colspan="15">  No part added yet </td> </tr>');
                $("#impneworder tbody").html('<tr id="impnopartadded">   <td colspan="15">  No part added yet </td> </tr>');
        
                added_parts = ["I m not valid part"];populateda=false; populatedb=false;
        
                $('#total_cost').val("0.00"); 
                $('#creatvariation').attr("checked", false);
                checkcreatvar('creatvariation');
                calcuate_costing_totals();
        
                $.ajax({
                    url: base_url+'purchase_orders/getCostingStagesByCostingandSupplier/'+id,
                    type: 'post',
                    datatype: 'json',
                    data: {supplier_id: id, costing_id: costing_id},
                    success: function (result) {
                        response = jQuery.parseJSON(result);
                        $('#supplier_stage_id').html(response.option);
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
                setPartsForStages();
                
            }
        else if (id == 0 && a == true) {
        supplier_id_g = id;
        $('#supplier_stage_id').html('<option value="0"> Select Stage </option>');
        $("#partstable tbody").html('<tr id="nopartadded">   <td colspan="15">  No part added yet </td> </tr>');
        $("#impneworder tbody").html('<tr id="impnopartadded">   <td colspan="15">  No part added yet </td> </tr>');
    } else{
        $('#supplier_id').val(supplier_id_g);
    }
        

    setPartsForStages();

}

    function getCostingSuppliers(costingId){
        $.ajax({
                url: base_url+'purchase_orders/getCostingSuppliers',
                type: 'post',
                data: {costingId: costingId},
                beforeSend: function() {
                  
                },
                success: function (response) {
                   $(".suppliersContainer").html(response);
                   $('.selectpicker').selectpicker('refresh');
                }
            });
    }
    
    function getCostingStages(costingId){
        $.ajax({
                url: base_url+'purchase_orders/getCostingStages',
                type: 'post',
                data: {costingId: costingId},
                beforeSend: function() {
                  
                },
                success: function (response) {
                   $(".stagesContainer").html(response);
                   $('.selectpicker').selectpicker('refresh');
                }
            });
    }
    
    function getCostingParts() {
        var costingId = $('#costing_id').val();
        getCostingSuppliers(costingId);
        getCostingStages(costingId);
        var stage_id = $('#supplier_stage_id').val();
        var supplier_id = $('#supplier_id').val();
        $.ajax({
            url: base_url+'purchase_orders/get_projects_part_for_porder',
            type: 'post',
            data: {stage_id: stage_id, costingId: costingId, added_parts: added_parts, supplier_id: supplier_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (response) {
               $('.loader').hide();
               populatedb = true;
               $('table#partstable tbody').html(response);
            }
        });
    }

   function setPartsForStages() {

        var costingId = $('#costing_id').val();
        var stage_id = $('#supplier_stage_id').val();
        var supplier_id = $('#supplier_id').val();
        if(supplier_id!=""){
            $("#autoSupplierPurchaseOrder").attr("disabled", false);
        }
        else{
            $("#autoSupplierPurchaseOrder").attr("disabled", true);
            $("#autoSupplierPurchaseOrder").prop("checked", false);
        }
        if(stage_id!=""){
            $("#autoStagePurchaseOrder").attr("disabled", false);
        }
        else{
             $("#autoStagePurchaseOrder").attr("disabled", true);
             $("#autoStagePurchaseOrder").prop("checked", false);
        }
        var is_auto_purchase_order = false;
        if($("#autoSupplierPurchaseOrder").is(":checked") || $("#autoStagePurchaseOrder").is(":checked")){
            is_auto_purchase_order = true;
        }
        $.ajax({
            url: base_url+'purchase_orders/get_projects_part_for_porder',
            type: 'post',
            data: {stage_id: stage_id, costingId: costingId, added_parts: added_parts, supplier_id: supplier_id, is_auto_purchase_order:is_auto_purchase_order},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (response) {
               $('.loader').hide();
               populatedb = true;
               $('table#partstable tbody').html(response);
            }
        });
    }
    
    function checkcreatvar(id) {
        if ($('#' + id).is(":checked")) {
            $("#creatvariation").val('1');
            $('#creatvariationwarn').show();
            $("#varidescriptioin").attr("required", "required");
            $("#purchaseordervarstatus").attr("required", "required");
        } else {
            $("#creatvariation").val('0');
            $('#creatvariationwarn').hide();
            $("#varidescriptioin").removeAttr("required");
            $("#purchaseordervarstatus").removeAttr("required");
        }
   }
  
function repopulate_all_available_components() {
        var costingId = $('#costing_id').val();
        var porder_id = $('#porder_id').val();
       var last_row = 0;
            var elstrow = $("table#partstable tbody tr:not('[class^=nopartadded]')").length;
            var lstrow = $("table#impneworder tbody tr:not('[class^=nopartadded]')").length;
            if (elstrow == undefined) {
                elstrow = 0;
            }
            if (lstrow == undefined) {
                lstrow = 0;
            }
            
            last_row =parseInt(lstrow)+parseInt(elstrow);
       
            $.ajax({
                url: base_url+'purchase_orders/repopulate_all_available_components',
                type: 'post',
                datatype: 'html',
                data: {last_row:last_row, costingId: costingId, porder_id:porder_id},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    $("#repopulateButton").attr("disabled", true);
                    $(".filter_section").css("display", "block");
                    if(result!=""){
                        populated = true;

                        $('table#partstable tbody').append(result);
                        $("table#partstable tbody #nopartadded").hide();

                        calculate();
                    }
                    else{
                        populated = false;
                        $("#error_no_pc_for_this_project").modal("show");
                    }
                }
            });
        
    }
    
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
    
        $("#total_cost2").val(s2.toFixed(2));
    
        var tax_percent = (parseFloat(c_tax) / 100) * s2;
        var s3 = tax_percent + s2;
    
        $("#total_cost3").val(s3.toFixed(2));
    
        var s4 = price_rounding + parseFloat($("#total_cost3").val());
    
        $("#contract_price").val(parseFloat(s4).toFixed(2));
    }
    
    $(document).ready(function() {
    $("body").on("click", 'span.edit', function (e) {
        var dad = $(this).parent();
        dad.find('span.status_label').hide();
        dad.find('select').show().focus();
    });
    $("body").on("focusout", 'select', function (e) {
        var dad = $(this).parent();
        $(this).hide();
        dad.find('span.status_label').show();
    });
    });
    
    function update_status(id){
        var status = $('#status_'+id).val();
        var supplier_invoice_id = $('#supplier_invoice_id_'+id).val();
        $.ajax({
            url: base_url+'purchase_orders/update_status/',
            type: 'post',
            data: {id: id,status:status,supplier_invoice_id:supplier_invoice_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (response) {
               $('.loader').hide();
               $('.status_container_'+id).html(response);
               $('.selectpicker').selectpicker('refresh');
            }
        });
   }
   
   function calculate_total_order(){
     var total_order_amount = 0;
     $(".total_order").each(function () {
         var row_no = $(this).attr("rno");
         var total_order = $("#total_order"+row_no).val();
         total_order_amount +=parseFloat(total_order);
         if(total_order>0){
         var unit_cost = $("#pmlinetotalfield"+row_no).val();
         var total_differenece = parseFloat(total_order)-parseFloat(unit_cost);
        
         if(total_differenece>0){
             $("#marginaddprojectcost_line"+row_no).val(parseFloat(total_differenece).toFixed(2));
         }
         else{
             $("#marginaddprojectcost_line"+row_no).val(0.00);
         }
         }
     });
      var total = 0;
    var val = 0;
    
    $(".marginaddprojectcost_line").each(function () {
        total += parseFloat($(this).val());
    });
    $(".marginaddcost_line").each(function () {
        total += parseFloat($(this).val());
    });
    if (isNaN(total) || (total == '' && (total_order_amount=='' || total_order_amount==0))) {
            $("#total_cost").val("0.00"); $("#totaladd_cost").val("0.00");
            $('#creatvariation').attr("checked", false);
            checkcreatvar('creatvariation');
        } else {
            $("#total_cost").val(total.toFixed(2)); $("#totaladd_cost").val(total.toFixed(2));
            $('#creatvariation').attr("checked", true);
            checkcreatvar('creatvariation');
        }

    calcuate_costing_totals();
}
   
   function calculate_order_total(rowid) {
       $("#order_unit_cost"+rowid).val(parseFloat($("#order_unit_cost"+rowid).val()).toFixed(2));
        var orderunitcost = $("#order_unit_cost"+rowid).val();
        if(parseFloat(orderunitcost)<0){
               swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
               orderunitcost = $("#pmucostfield"+rowid).val()
               $("#order_unit_cost"+rowid).val(orderunitcost);
            }
        var order_qty = $("#pmmanualqty"+rowid).val();
        if(parseFloat($("#order_unit_cost"+rowid).val()).toFixed(2)==$("#order_unit_cost"+rowid).val()){
              var order_cost = $("#order_unit_cost"+rowid).val();
        }
        else{
          
            var order_cost = parseFloat($("#order_unit_cost"+rowid).val()).toFixed(2);
        }
        var unit_cost = $("#pmucostfield"+rowid).val();
        var component_id = $("#pmcomponentfield"+rowid).val();
        check_unit_cost();
        if(order_cost!=unit_cost){
            $("#componentCostModal #update_component_id").val(component_id);
            $("#componentCostModal #update_invoice_unit_cost").val(order_cost);
            $("#componentCostModal #invoice_unit_cost").val(order_cost);
            $("#componentCostModal #current_unit_cost").val(unit_cost);
            $('#componentCostModal').modal('show'); 
        }
         var line_total = $("#pmlinetotalfield"+rowid).val();
         var line_total_cost = parseFloat(line_total)*order_qty;
         var subtotal = (parseFloat(order_qty)*parseFloat(order_cost)) - parseFloat(line_total);
         $("#total_order"+rowid).val(subtotal.toFixed(2));
         calculate_total_order();
         calculate();
    }
    
    function check_unit_cost(){
        var is_display=0;
        $(".unit_cost").each(function() {
        var rowid = $(this).attr("rowno");
        if(parseFloat($("#order_unit_cost"+rowid).val()).toFixed(2)==$("#order_unit_cost"+rowid).val()){
            var order_cost = $("#order_unit_cost"+rowid).val();
        }
        else{
            var order_cost = parseFloat($("#order_unit_cost"+rowid).val()).toFixed(2);
        }
        var unit_cost = $("#pmucostfield"+rowid).val();
        if(order_cost!=unit_cost){
           $('#nipototal').show();
           is_display=1;
        }
        });
        if(is_display==0){
            var tableCount = $('#impneworder tbody tr.new_item_row').length;
            if(tableCount==0){
            $('#nipototal').hide();
            }
        }
        calculate();
}

    $('body').on('blur', '#totaladd_cost', function () {
        $("#total_cost").val($("#totaladd_cost").val());
        
        var total_order_amount = 0;
         $(".total_order").each(function () {
             var row_no = $(this).attr("rno");
             var total_order = $("#total_order"+row_no).val();
             total_order_amount+=total_order;
             if(total_order>0){
             var unit_cost = $("#pmlinetotalfield"+row_no).val();
             var total_differenece = parseFloat(total_order)-parseFloat(unit_cost);
            
             if(total_differenece>0){
                 $("#marginaddprojectcost_line"+row_no).val(parseFloat(total_differenece).toFixed(2));
             }
             else{
                 $("#marginaddprojectcost_line"+row_no).val(0.00);
             }
             }
         });
        
        if($("#totaladd_cost").val()>0 || (total_order_amount!="" && total_order_amount!=0)){
         $('#creatvariation').attr("checked", true);
         checkcreatvar('creatvariation');
     }
     else{
         $('#creatvariation').attr("checked", false);
         checkcreatvar('creatvariation'); 
     }
     calcuate_costing_totals();
 });

    function update_component_unit_cost(){
        $('#componentCostModal').modal('hide'); 
        var rno = $('#update_rno').val();
        var component_id = $('#update_component_id').val();
        var unit_cost = $('#update_invoice_unit_cost').val();
         $.ajax({
                    url: base_url+'purchase_orders/update_component_unit_cost',
                    type: 'post',
                    data: {component_id: component_id,unit_cost:unit_cost},
                    beforeSend: function() {
                    },
                    success: function (result) {
                    }
                });
    }
    
    function sweetConfirm(title, message, callback) {
        var a =true;
        swal({
            title: title,
            text: message,
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Ok',
            buttonsStyling: false
        }).then((confirmed) => {
            callback(confirmed==true);
        }).catch(swal.noop);
   }
   
   function getCostingbyFilter(id) {

    var costingId = $('#costing_id').val();
     var supplier_id = $("#supplier_id").val();
        var stage_id = $("#stage_id").val();
        var porder_id = $('#porder_id').val();
        $(".repopulate_row").remove();
        var lstrow = $('#partstable tbody tr').length;
            if (lstrow == 'undefined') {
                lstrow = 0;
            }
       
            $.ajax({
                url: base_url+'purchase_orders/repopulate_all_available_components',
                type: 'post',
                datatype: 'html',
                data: {last_row:lstrow, costingId: costingId, porder_id:porder_id, stage_id:stage_id, supplier_id:supplier_id},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    $("#repopulateButton").attr("disabled", true);
                    $(".filter_section").css("display", "block");
                    if(result!=""){
                        populated = true;
                        $('table#partstable tbody').append(result);
                        $("#nopartadded").hide();

                        calculate();
                    }
                    else{
                        populated = false;
                        $("#error_no_pc_for_this_project").modal("show");
                    }
                }
            });

}
   
   function getCostingbysupplierauto(value){
	
	$('#populateifnoorder').html("");
	$('#actionsaveorview').html('<input type="submit" class="btn btn-default" value="Save Order">');
		
	var costing_id = $("#costing_id").val();
	
	$("#partstable tbody").html('<tr id="nopartadded">   <td colspan="8">  No part added yet </td> </tr>');
	    
		
			$("#stagediv").hide();
			$("#sstages").html('<option value="" >Select Stage</option>');
			$('.selectpicker').selectpicker('refresh');
			
			var supplier=value;
			var stage=0;
			
			$.ajax({
				url: base_url+'purchase_orders/populate_supplier',
				type: 'post',
				data: {supplier: supplier, prj_costing_id:costing_id, stage: 0},
				beforeSend: function() {
                   $('.loader').show();
                },
				success: function (result) {
				    
				    $('.loader').hide();
				
				   $('#populate_supplier').html(result);
				 
				   if(($('#populateany').val()==0)){
					
					$('#actionsaveorview').html('<a class="btn btn-default" href="'+base_url+'purchase_orders">View Orders</a>');
                               
					$('#populateifnoorder').html('<div class="alert alert-info"><strong>Info!</strong> No Component need to set purchase order. You can view already submitted purchase orders by clicking below button</div>');		
					 
				 } 
				 if(value>0){
				     $("#stagediv").show();
			
			
			$.ajax({
				url: base_url+'purchase_orders/getCostingStagesByCostingandSupplier/' + value,
				type: 'post',
				datatype: 'json',
				data: {supplier_id: value,costing_id : costing_id},
				beforeSend: function() {
                   $('.loader').show();
                },
				success: function (result) {
				    $('.loader').hide();
					response = jQuery.parseJSON(result);
					console.log(response.option);
					$('#sstages').html(response.option);
					$('.selectpicker').selectpicker('refresh');
				

				}
			});
				 }
				}
			});
			
		/*else if(value>0){
			
			$("#stagediv").show();
			
			
			$.ajax({
				url: base_url+'purchase_orders/getCostingStagesByCostingandSupplier/' + value,
				type: 'post',
				datatype: 'json',
				data: {supplier_id: value,costing_id : costing_id},
				beforeSend: function() {
                   $('.loader').show();
                },
				success: function (result) {
				    $('.loader').hide();
					response = jQuery.parseJSON(result);
					console.log(response.option);
					$('#sstages').html(response.option);
					$('.selectpicker').selectpicker('refresh');
				

				}
			});
			$('#populate_supplier').html('<table id="partstable" class="table table-no-bordered table-striped table-hover"><thead><tr><th>Stage</th><th>Part</th><th>Component</th><th>Supplier</th><th>QTY</th><th>Unit Of Measure</th><th>Unit Cost</th><th>Line Total</th></tr></thead><tbody></tbody></table>');
			$("#partstable tbody").html('<tr id="nopartadded">   <td colspan="15">  No part added yet </td> </tr>');
		}*/
		
		/*else if(value==-1){
		
		
		$("#stagediv").hide();
		$('#actionsaveorview').html('<input type="submit" class="btn btn-default" value="Save Order">');
		$('#populate_supplier').html('<table id="partstable" class="table table-no-bordered table-striped table-hover"><thead><tr><th>Stage</th><th>Part</th><th>Component</th><th>Supplier</th><th>QTY</th><th>Unit Of Measure</th><th>Unit Cost</th><th>Line Total</th></tr></thead><tbody></tbody></table>');
			
                               
		$('#populateifnoorder').html("");		
					
		$("#partstable tbody").html('<tr id="nopartadded">   <td colspan="15">  No part added yet </td> </tr>');
	    
		}*/
		
	
	};
	
	
	
	function getorderbysupplierandstage(value){
	    var prj_costing_id = $("#costing_id").val();
		$('#populateifnoorder').html("");
                $('#actionsaveorview').html('<input type="submit" class="btn btn-default" value="Save Order">');
	
		if(value!=0){
			
			
			var supplier = $("#parent_supplier_id").val();
			if (supplier == 'undefined') {
				supplier = 0;
			}	
	
			$.ajax({
				url: base_url+'purchase_orders/populate_supplier',
				type: 'post',
				data: {supplier: supplier, prj_costing_id:prj_costing_id, stage: value},
				success: function (result) {
				  
				
				
				 $('#populate_supplier').html(result);
				 if(($('#populateany').val()==0)){
					
					$('#actionsaveorview').html('<a class="btn btn-default" href="'+base_url+'purchase_orders">View Orders</a>');
                               
					$('#populateifnoorder').html('<div class="alert alert-info"><strong>Info!</strong> No Component need to set purchase order. You can view already submitted purchase orders by clicking below button</div>');		
				 }	 

				}
			});
	
		}
		else{
			
			$("#partstable tbody").html('<tr id="nopartadded">   <td colspan="15">  No part added yet </td> </tr>');
	 
		}
		
		
		
	}
	
	
	$( document ).ready(function() {
        $('.hidemeop3').each(function () {$(this).hide()});
        $('.hidemeop').each(function () {$(this).hide()});
        $('.hidemeop2').each(function () {$(this).hide()});
         
        
    });
function ssissuepurchaseorder(){	
	w=window.open();
	w.document.write($('#porderpanel').html());
	w.print();
	w.close();	
	
};

function issuepurchaseorder(elem)
    {
        $("#button_type").val(1);
        Popup($('.porderpanel').html());
    }

    function Popup(data)
    {
        var email_supplier = $("#email_supplier").is(":checked");
   if(email_supplier){
            swal({
                title: 'Purchase order is ready to be mailed.',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                buttonsStyling: false
            }).then(function() {
                
                $("#formWizard1").submit();
                
            });
    }else{
        var mywindow = window.open('', 'new div', 'height=500,width=800');
        mywindow.document.write('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>my div</title>');
       
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();
       } 
        return true;
    }
    
    function send_order_direct_to_supplier(){
        swal({
                title: 'Purchase order is ready to be send directly to supplier.',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                buttonsStyling: false
            }).then(function() {
                
                       $("#button_type").val(2);
                       $("#formWizard1").submit();
				
            });
    }
    
   
    function spost(id) {

        if ($('#' + id).is(":checked")) {
            $(".hidemeop2").show();
        } else {
            $(".hidemeop2").hide();
        }
    }
    
    function show_comments(id) {

        if ($('#' + id).is(":checked")) {
            $(".hidemecomments").show();
        } else {
            $(".hidemecomments").hide();
        }
    }
    
    function showComponentDescription(id) {

        if ($('#' + id).is(":checked")) {
            $(".component_description").show();
        } else {
            $(".component_description").hide();
        }
    }
    
    
    function siipc(id) {

        if ($('#' + id).is(":checked")) {
            $(".hidemeop3").show();
        } else {
            $(".hidemeop3").hide();
        }
    }
    
    function scic(id) {

        if ($('#' + id).is(":checked")) {
            $(".hidemeop").show();
        } else {
            $(".hidemeop").hide();
        }
    }

    function show_email_msg() {
        var email_supplier = $("#email_supplier").is(":checked");

         if(email_supplier){
            $("#email_message").show();
            } else {
                $("#email_message").hide();
            }
    }

	
	