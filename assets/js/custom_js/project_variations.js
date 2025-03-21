    $.validator.addMethod('uniqueVariation', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'project_variations/verify_variation',
                type: 'post',
			    data:{name: value},
	}); 
	
	if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique Initiated Variation");
	
	$.validator.addMethod('uniqueEditVariation', function(value) {
		 var id = $("#variation_id").val();
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'project_variations/verify_variation',
                type: 'post',
			    data:{name: value, id:id},
	});

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique Initiated Variation");
	
             
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
        setFormValidation('#ProjectVariationForm');
    });
    
    var sereal_count = 0;
    
    $(document).ready(function () {
        calculate();
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
                    $('.selectpicker').selectpicker('refresh');
                    calculate();
                }, "json");
    }
    
    function calculate($is_remove_all="") {
    var total = 0;
    var val = 0;
    var vstotaol = 0;
    if($is_remove_all==""){
    $(".additionalcost").each(function () {
        total = parseFloat(total)+parseFloat($(this).val());
    });
            
    $("#total_cost").val(parseFloat(total).toFixed(2));
    calcuate_costing_totals();
   
    }
    else{
            
            $("#total_cost").val(vstotaol.toFixed(2));
            calcuate_costing_totals();
            $("#price_rounding").val(vstotaol.toFixed(2));
            $("#contract_price").val(vstotaol.toFixed(2));
            $("#hide_from_summary").prop("checked", false);
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
        var lastRowIndex = 0, val;
        $("table#partstable tbody tr").each(function() {
          val = parseInt($(this).attr("tr_val"));
          if (val > lastRowIndex) {
            lastRowIndex = val;
          }
        });
        var lastrow = lastRowIndex;
        if (lastrow == 'undefined' || lastrow==undefined) {
            lastrow = 0;
        }
        
        var project_id = $("#project_id").val();
        if(project_id==""){
            swal({
                title: 'Validation Error!',
                text: 'Please select project first',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        }
        else{
            $.ajax({
                url: base_url+"project_variations/populate_new_costing_row_for_variation",
                type: 'post',
                data: {last_row: lastrow, project_id:project_id},
                beforeSend: function() {
                  $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                    $('table#partstable tbody').prepend(result);
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

    function getCostingbyTemplate(id) {

    var todid = "0";
    $(".tod_rows").each(function () {
        todid = todid + ",'" + $(this).attr('tod_id') + "'";


    });

    var lstrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
    $.ajax({
        url: base_url+'project_costing/get_costing_by_template/'+ id,
        type: 'POST',
        datatype: 'json',
        data: {id: id, last_row: lstrow, todid: todid},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            $('.loader').hide();
            response = jQuery.parseJSON(result);
            $('table#partstable tbody').append(response.rData);
            $('#table-for-tod').html(response.tData);
            $('.selectpicker').selectpicker('refresh');
            calculate();
        }
    });


}

    function getCostingbyEditTemplate(id){
        
        $("#add-more-row").show();
        
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";
    
    
        });
    
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
        url: base_url+'project_costing/get_costing_by_template/'+ id,
        type: 'POST',
        datatype: 'json',
        data: {id: id, last_row: lastrow, todid: todid},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            $('.loader').hide();
            response = jQuery.parseJSON(result);
            $('table#add-more-row tbody').append(response.rData);
            $('#table-for-tod').html(response.tData);
            $('.selectpicker').selectpicker('refresh');
            calculate();
        }
    });
        
    }

function getCostingbyProject(id) {
    
    var lstrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
    
    if(lstrow=="undefined" || lstrow==undefined){
        lstrow = 0;
    }

    $.ajax({
        url: base_url+'project_costing/get_previous_project_costing',
        method: 'post',
        datatype: 'json',
        data: {id: id, last_row: lstrow},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            response = jQuery.parseJSON(result);
            $('.loader').hide();
            $('table#partstable tbody').append(response.rData);
            $('.selectpicker').selectpicker('refresh');

        }
    });

}

function getCostingbyEditProject(id) {
    
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
        url: base_url+'project_costing/get_previous_project_costing',
        method: 'post',
        datatype: 'json',
        data: {id: id, last_row: lastrow},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            response = jQuery.parseJSON(result);
            $('.loader').hide();
            $('table#add-more-row tbody').append(response.rData);
            $('.selectpicker').selectpicker('refresh');

        }
    });

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

function LockProject2() {
    var stt = $("#lockproject").val();
    if (stt == 0) {
        $("form input").attr('readonly', false);
        $("form select").attr('readonly', false);
        $("form input[type='checkbox']").css('pointer-events', 'auto');
        $("form select").css('pointer-events', 'auto');
        $("#extemplate_id").css('pointer-events', 'auto');
        $("#exproject_id").css('pointer-events', 'auto');

        $("#iconlockproject .fa").removeClass('fa-lock');
        $("#iconlockproject .fa").addClass('fa-unlock');

        $("#lockproject").val(0);
    } else {
        $("form input").attr('readonly', true);
        $("form select").attr('readonly', true);
        $("form input[type='checkbox']").css('pointer-events', 'none');
        $("#extemplate_id").css('pointer-events', 'none');
        $("#exproject_id").css('pointer-events', 'none');
        $("form select").css('pointer-events', 'none');

        $("#project_id").css('pointer-events', 'auto');
        $("#project_id").attr('readonly', false);

        $("#iconlockproject .fa").removeClass('fa-lock');
        $("#iconlockproject .fa").addClass('fa-unlock');

        $("#lockproject").val(1);
    }
}
    function changeLockToUnLockStatus(rno){
        var lock = $("#linelock" + rno).val();
        if (lock == 0) {
            $("#trnumber" + rno + " td input").attr('readonly', false);
            $("#trnumber" + rno + " td select").attr('readonly', false);
            $('.selectpicker').selectpicker('refresh')
            $("#trnumber" + rno + " td textarea").attr('readonly', false);
            $("#trnumber" + rno + " td input[type='checkbox']").attr('disabled', false);
            $("#iconlock" + rno).removeClass('btn-danger');
            $("#iconlock" + rno).addClass('btn-success');
            $(".lock_icon_type"+rno).text("lock_open");
            $("#linelock" + rno).val(0);
            $(".deleterow"+ rno).show();
            $(".updateunitcost"+ rno).show();

        }
        else {
            $("#trnumber" + rno + " td input").attr('readonly', true);
            $("#trnumber" + rno + " td select").attr('readonly', true);
            $('.selectpicker').selectpicker('refresh');
            $("#trnumber" + rno + " td textarea").attr('readonly', true);
            $("#trnumber" + rno + " td input[type='checkbox']").attr('disabled', true);
            $("#linelock" + rno).val(1);
            $("#iconlock" + rno).removeClass('btn-success');
            $("#iconlock" + rno).addClass('btn-danger');
            $(".lock_icon_type"+rno).text("lock");
            $(".deleterow"+ rno).hide();
            $(".updateunitcost"+ rno).hide();
        }
        
    }
    function LockProject()
    {
        var lock = $("#lockproject").val();

        if (lock == 1) {
            $("td input").attr('readonly', false);
            $("td .selectpicker").attr('disabled', false);
            $('.selectpicker').selectpicker('refresh')
            $("td textarea").attr('readonly', false);
            $("td input[type='checkbox']").attr('disabled', false);
            $("#iconlockproject").removeClass('btn-danger');
            $("#iconlockproject").addClass('btn-success');
            $(".lock_project_icon_type").text("lock_open");
            $("#lockproject").val(0);

        }
        else {
             $("td input").attr('readonly', true);
            $("td .selectpicker").attr('disabled', true);
            $('.selectpicker').selectpicker('refresh')
            $("td textarea").attr('readonly', true);
            $("td input[type='checkbox']").attr('disabled', true);
            $("#iconlockproject").removeClass('btn-success');
            $("#iconlockproject").addClass('btn-danger');
            $(".lock_project_icon_type").text("lock");
            $("#lockproject").val(1);
        }
    }

    function changeLockStatus(rno)
    {
        var lock = $("#linelock" + rno).val();

        if (lock == 1) {
            $("#trnumber" + rno + " td input").attr('readonly', false);
            $("#trnumber" + rno + " td select").attr('disabled', false);
            $('.selectpicker').selectpicker('refresh')
            $("#trnumber" + rno + " td textarea").attr('readonly', false);
            $("#trnumber" + rno + " td input[type='checkbox']").attr('disabled', false);
            $("#iconlock" + rno).removeClass('btn-danger');
            $("#iconlock" + rno).addClass('btn-success');
            $(".lock_icon_type"+rno).text("lock_open");
            $("#linelock" + rno).val(0);
            $(".deleterow"+ rno).show();
            $(".updateunitcost"+ rno).show();

        }
        else {
            $("#trnumber" + rno + " td input").attr('readonly', true);
            $("#trnumber" + rno + " td select").attr('disabled', true);
            $('.selectpicker').selectpicker('refresh')
            $("#trnumber" + rno + " td textarea").attr('readonly', true);
            $("#trnumber" + rno + " td input[type='checkbox']").attr('disabled', true);
            $("#linelock" + rno).val(1);
            $("#iconlock" + rno).removeClass('btn-success');
            $("#iconlock" + rno).addClass('btn-danger');
            $(".lock_icon_type"+rno).text("lock");
            $(".deleterow"+ rno).hide();
            $(".updateunitcost"+ rno).hide();
        }
    }
    
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip(); 
    });
    
    function CalculateTakeoffData() {
        $(".formulaqtty").each(function () {
            var id = $(this).attr('id');
            var rno = $(this).attr('rno');
            var formula = $("#formulaqty_stage_" + rno).val();
            var n = 0;
            var number = 0;
            var newf = formula.replace(/,/g, '');
            var pattern = /[0-9]+/g;
            //var pattern = /[a-z]+/g;
            var matches = newf.match(pattern);
			var d3 = formula;
            for(var i=0;i<matches.length;i++){
				var d2 = parseFloat($("#toffdata" + (matches[i])).val());
				d3 = d3.replace("|"+matches[i]+",", d2);
			}
			d3 = d3.replace(/,/g, '');
			
            number = nerdamer(d3).evaluate();
            
			if (isNaN(number)) {
                number = 0;
            }
            var is_rounded = $("#is_rounded" + rno).val();
            
            if(isFloat(number)){
				if(is_rounded==1){
				     $("#manualqty" + rno).val(Math.ceil(number));
				}
				else{
				     $("#manualqty" + rno).val(parseFloat(number).toFixed(2));
				}
			}
            else{
                if(is_rounded==1){
				   $("#manualqty" + rno).val(Math.ceil(eval(number.toString())));
                }
                else{
                    $("#manualqty" + rno).val(parseFloat(eval(number.toString())).toFixed(2));
                }
			}
        });
        calculateLineTotal();
    }
    
    function isFloat(n){
    return Number(n) === n && n % 1 !== 0;
}
function  calculateLineTotal() {
    $(".qty").each(function () {
        var id = $(this).attr('id');
        var rno = $(this).attr('rno');
        var formula = $("#formulaqty_stage_" + rno).val();


        var qty = $("#manualqty" + rno).val();
        var ucost = $("#ucostfield" + rno).val();
        $("#ucostfield" + rno).val(parseFloat(ucost).toFixed(2));
        var total = parseFloat(qty) * parseFloat(ucost);
        if (isNaN(total)) {
            total = 0;
        }
        $("#linetotalfield" + rno).val(total.toFixed(2));

        var margin = parseFloat($("#marginfield" + rno).val());
        if (isNaN(margin)) {
            margin = 0;
        }
        var marginline = (margin / 100) * total;
        var vtotal = marginline + total;
        if (isNaN(vtotal)) {
            vtotal = 0;
        }
        $('#margin_linefield'+rno).val(parseFloat(vtotal).toFixed(2));
    });
    calculate();
}

    function changeBoomMobileValue(id, rno) {

        if ($('#' + id).is(":checked")) {
            $("#hide_from_boom_mobile" + rno).val('1');
        }
        else {
            $("#hide_from_boom_mobile" + rno).val('0');
        }
    }
    
    function changeAllowanceValue(id, rno) {

        if ($('#' + id).is(":checked")) {
            $("#" + id).val('1');
            $("#allowance" + rno).val('1');
        }
        else {
            $("#allowance" + rno).val('0');
        }
    }
    
    function changeSpecificationValue(id, rno) {
    
        if ($('#' + id).is(":checked")) {
            $("#include_in_specification" + rno).val('1');
        }
        else {
            $("#include_in_specification" + rno).val('0');
        }
    }
    
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

    $('body').on('change', '.roundme', function () {
      var s6=$("#total_cost3").val();
      var s7=$("#price_rounding").val();
      var s8 = parseFloat(s6)+parseFloat(s7);
      $("#contract_price").val(s8.toFixed(2));
    });
    
     function calculateTotal(rowno) {

        var aqty = $("#manualqty" + rowno).val();

        var mqty = $("#changeqty" + rowno).val();

        var updqty = $("#updatedqty" + rowno).val();

        var ucost = $("#ucostfield" + rowno).val();
        
        if(parseFloat(ucost)<0){
            swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
            
           ucost = 0;
           
           $("#ucostfield" + rowno).val(parseFloat(ucost).toFixed(2));
        }


        if (isNaN(mqty)) {

            mqty = 0;

        }

        if (isNaN(ucost)) {
            ucost = 0;

        }

        var row_total = parseFloat(mqty) * parseFloat(ucost);

        $('#additionalcost' + rowno).val(row_total.toFixed(2));
        $('#useradditionalcost' + rowno).val(row_total.toFixed(2));

        var linetotalfield = parseFloat(updqty) * parseFloat(ucost);

        $('#linetotalfield' + rowno).val(linetotalfield.toFixed(2));



        var margin = parseFloat($("#marginfield" + rowno).val());

        if (isNaN(margin)) {



            margin = 0;

        }

        row_total = parseFloat(updqty) * parseFloat(ucost);

        var marginline = (margin / 100) * row_total;

        var vtotal = marginline + row_total;

        $('#margin_linefield' + rowno).val(vtotal.toFixed(2));

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
        if($("#ProjectVariationForm").valid()){
            var lstrow = $('#partstable > tbody').find('tr').length;
            var is_submit = false;
            if (lstrow > 0) {
                $(".changeQty").each(function () {
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
                    text: 'Change Quantity should not be 0.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);
                return false;
                }
                
            }
            else {
                swal({
                    title: 'Error!',
                    text: 'Add at least one part to save this variation.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    }).catch(swal.noop);
                return false;
            }
        }
        else{
            setFormValidation('#ProjectVariationForm');
        }
    }

    function showcolumn(type) {
        var column = $("#column_"+type).is(":checked");

         if(column){
            $("."+type).show();
            } else {
                $("."+type).hide();
            }
    }
    
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
    
    function ValidateDocumentForm(){
        
        if ( $( ".dz-preview" ).length ) {
            return true;
        }
        else{
           swal({
                            title: 'Error!',
                            text: 'Please upload atleast one document or file.',
                            type: 'error',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        }).catch(swal.noop);
           return false;
        }
    }
    
    $('body').on('click','.delete_all',function(){
        if ($('.selected_items:checked').length > 0){
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
                var data = $("#form_documents").serialize();
           
				$.ajax({
					type:'POST',
					url:base_url+"project_costing/delete_all_documents",
					data: data,
					cache : false,
                    processData: false,
					beforeSend: function() {
                        $('.loader').show();
                     },
					success:function(result){
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        }).catch(swal.noop);	
                        $('.loader').hide();
                        $(".documents_container").html(result);
                        $("#form_documents")[0].reset();
					}
                }); 
                			
				
            });
        }
        else{
              swal({
                            title: 'Error!',
                            text: 'Please select atleast one document.',
                            type: 'error',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        }).catch(swal.noop);
            }
    });
    
    $('body').on('click','.set_as_private',function(){
        if ($('.selected_items:checked').length > 0){
             swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, Set as private!',
                buttonsStyling: false
            }).then(function() {
                var data = $("#form_documents").serialize();
           
				$.ajax({
					type:'POST',
					url:base_url+"project_costing/set_as_private",
					data: data,
					beforeSend: function() {
                        $('.loader').show();
                     },
					success:function(result){
					    $('.loader').hide();
                        $(".documents_container").html(result);
                        $("#form_documents")[0].reset();
						swal({
                           title: 'Done!',
                           text: 'Your record has been set as private.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        }).catch(swal.noop);	
					}
                }); 
                			
				
            });
        }
        else{
              swal({
                            title: 'Error!',
                            text: 'Please select atleast one document.',
                            type: 'error',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        }).catch(swal.noop);
            }
    });
    
    $('body').on('click','.set_as_share',function(){
        if ($('.selected_items:checked').length > 0){
             swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, Set as share!',
                buttonsStyling: false
            }).then(function() {
                var data = $("#form_documents").serialize();
           
				$.ajax({
				    async:false,
					type:'POST',
					url:base_url+"project_costing/set_as_share",
					data: data,
					beforeSend: function() {
                        $('.loader').show();
                     },
					success:function(result){
					    $('.loader').hide();
                        $(".documents_container").html(result);
                        $("#form_documents")[0].reset();
						swal({
                           title: 'Done!',
                           text: 'Your record has been set as share.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        }).catch(swal.noop);
					}
                }); 
                			
				
            });
        }
        else{
              swal({
                            title: 'Error!',
                            text: 'Please select atleast one document.',
                            type: 'error',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        }).catch(swal.noop);
            }
    });
    
    $('body').on('click','.select_all',function(){
        if ($('.select_all:checked').length > 0){
            $('.selected_items').prop("checked", true);
        }
        else{
               $('.selected_items').prop("checked", false);  
            }
    });
    
    var populated = false;
    var curr_project_id = "";
    var curr_stage_id = "";
    var curr_supplier_id = "";
    
    function get_completed_job_variations(){
         $.ajax({
            url: base_url+'project_variations/get_completed_job_variations',
            type: 'post',
            data: {},
            beforeSend: function() {
                      $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $(".completed_variations").html(result);
                $("#completedTab").attr("onclick","");
                $('#completedJobsVariations').DataTable({
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
    
   function get_stages(project_id){
       
       if (populated === true) {

            $("#change_project").modal('show');
        } else {
        curr_project_id = project_id;
        if (project_id != 'undefined' && project_id > 0) {

            $.post(base_url+"project_variations/getCostingStages", {value: project_id})

                .done(function (data) {
                    $('table#partstable tbody').html("");

                    var str = data;

                    var obj = jQuery.parseJSON(str);
                    
                    $('#costing_id').val(obj.costing_id);
                    $('#extstages').html(obj.option);
                    $('.selectpicker').selectpicker('refresh');
                    getParts(0, "project");
                    get_suppliers();
                    
                });

        } else {
  
            $('#extstages').html('<option value="">Select Stage</option>');
            $('.selectpicker').selectpicker('refresh');
            swal({
                title: 'Validation Error!',
                text: 'Please select project first',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
      
        }
        }
   }
   
   function get_suppliers(){
       
       var costing_id = $("#costing_id").val();
       var stage_id = $("#extstages").val();
      
       if (costing_id != 'undefined' && costing_id > 0) {

            $.post(base_url+"project_variations/get_costing_suppliers", {costing_id: costing_id,stage_id:stage_id})

                .done(function (data) {

                    var str = data;

                    var obj = jQuery.parseJSON(str);
                    
                    $('#extsuppliers').html(obj.option);
                    $('.selectpicker').selectpicker('refresh');


                });

        } else {
  
            $('#extsuppliers').html('<option value="">Select Supplier</option>');
            $('.selectpicker').selectpicker('refresh');
            
      
        }
   }
   
   function getParts(val, type) {
        var project_id = $("#project_id").val();
        var supplier_id = $("#extsuppliers").val();
        var stage_id = $("#extstages").val();
        /*if(populated==true && type=="stage"){
            $("#change_stage").modal("show");
        }
        else if(populated==true && type=="supplier"){
            $("#change_supplier").modal("show");
        }
        else{
        if(type == "stage"){
            var stage_id = val;
            var supplier_id = $("#extsuppliers").val();
            curr_stage_id = stage_id;
            curr_supplier_id = supplier_id;
        }
        else if(type == "supplier"){
              var supplier_id = val;
              var stage_id = $("#extstages").val();
              curr_stage_id = stage_id;
              curr_supplier_id = supplier_id;
        }
        else{
             
             curr_stage_id = "";
             curr_supplier_id = "";
        }
        if(supplier_id==""){
        get_suppliers();
        }*/
        
        var costingId = $('#costing_id').val();
      
        if(project_id!=""){
                $.ajax({
                    url: base_url+'project_variations/getCostingParts',
                    type: 'post',
                    datatype: 'html',
                    data: {stage_id: stage_id, supplier_id:supplier_id, costingId: costingId},
                    beforeSend: function() {
                      $('.loader').show();
                    },
                    success: function (result) {
                    $('.loader').hide();
                    if(result!=""){
                        populated = true;
                        
                        $('table#partstable tbody').html(result);

                       $('.selectpicker').selectpicker('refresh');

                    calculate();
                    }
                    else{
                        $('table#partstable tbody').html('');
                        populated = false;
                        if(supplier_id=="" && stage_id!=""){
                        $("#error_no_pc_for_this_stage").modal("show");
                        }
                        else if(supplier_id=="" && stage_id=="")
                        $("#error_no_pc_for_this_project").modal("show");
                        else{
                           $("#error_no_pc_for_this_supplier").modal("show"); 
                        }
                    }
                    }
                });
       }
       else{
           $('table#partstable tbody').html('');
       }
    }
    
    function changeproject() {
        populated = false;
        getParts(0, "project");
        get_stages($('#project_id').val());
        get_suppliers();

    }
    
    function donotchangeproject() {

        $('#project_id').val(curr_project_id);
        $('.selectpicker').selectpicker('refresh')

    }
    
    function changestage() {

        populated = false;
        getParts($('#extstages').val(), "stage");

    }

    function donotchangestage() {
    
        $('#extstages').val(curr_stage_id);
        $('#extsuppliers').val(curr_supplier_id);
        $('.selectpicker').selectpicker('refresh')

    }
    
    function changesupplier() {

        populated = false;
        getParts($('#extsuppliers').val(), "supplier");

    }

    function donotchangesupplier() {

        $('#extstages').val(curr_stage_id);
        $('#extsuppliers').val(curr_supplier_id);
        $('.selectpicker').selectpicker('refresh')

    }
    
    function add_client_additional_cost(rowno){
        var additional_cost = $('#additionalcost' + rowno).val();
        $('#useradditionalcost' + rowno).val(additional_cost);
    }
    
    function calculateUpdatedTotal(rno) {
       var changeQty = $("#changeqty" + rno).val();
       var avQty = $("#manualqty" + rno).val();
       var costing_part_id = $("#costing_part_id"+rno).val();
       var project_id = $("#project_id").val();
       if(costing_part_id > 0 && (parseFloat(changeQty)>=parseFloat(avQty))){
       $.ajax({
                url: base_url+'project_variations/check_component_in_purchase_order/',
                type: 'post',
                dataType: 'json',
                data: {costing_part_id:costing_part_id, project_id:project_id},
                success: function (result) {
                    console.log(result);
                if(result.message=="fail"){
                    swal({
                        title: 'Error!',
                        text: "A Purchase Order has been created that includes this component. To proceed, cancel the purchase order that includes this component, then issue an updated purchase order.",
                        type: 'warning',
                        confirmButtonClass: "btn btn-warning",
                        buttonsStyling: false,
                        html: '<h6>Purchase Order Number: '+result.purchase_order_id+'</h6><p>A Purchase Order has been created that includes this component. To proceed, cancel the purchase order that includes this component, then issue an updated purchase order.</p><a class="btn btn-success btn-sm" target="_Blank" href="'+base_url+'purchase_orders/pporder/'+result.purchase_order_id+'">View Purchase Order</a>'
                    }).catch(swal.noop);
                    $("#changeqty" + rno).val(0);
                    var changeQty = $("#changeqty" + rno).val();
                    var avQty = $("#manualqty" + rno).val();
                    var upQty = parseFloat(avQty) + parseFloat(changeQty);
                    $("#updatedqty" + rno).val(parseFloat(upQty).toFixed(2));
            
                    calculateTotal(rno);
            
                    $("#my_id_linetotal_" + rno).html(parseFloat($("#linetotalfield" + rno).val()).toFixed(2));
            
                    $("#my_id_additionalcost_" + rno).html(parseFloat($("#additionalcost" + rno).val()).toFixed(2));
            
                    calculate();
        
                }
                else{
        
        /*if ((event.which != 46 || changeQty.indexOf('.') != -1) &&
        ((event.which < 48 || event.which > 57) &&
          (event.which != 0 && event.which != 8))) {
        event.preventDefault();
      }
      if ((changeQty.indexOf('.') != -1) &&
        (changeQty.substring(changeQty.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8)) {
        event.preventDefault();
         swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
          $("#changeqty" + rno).val(0);
          changeQty = 0;
      }*/

        var newQty = parseFloat(-1) * parseFloat(changeQty);
        if(changeQty<0 && newQty>avQty){
            $("#changeqty" + rno).val(0);
            swal({
                title: 'Incorrect Quantity!',
                text: 'You cannot enter Change Quantity more than Uninvoiced Quantity',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        }
        
        var avQty = $("#manualqty" + rno).val();

        var changeQty = $("#changeqty" + rno).val();
       
        var upQty = parseFloat(avQty) + parseFloat(changeQty);

        $("#updatedqty" + rno).val(parseFloat(upQty).toFixed(2));

        calculateTotal(rno);

        $("#my_id_linetotal_" + rno).html(parseFloat($("#linetotalfield" + rno).val()).toFixed(2));

        $("#my_id_additionalcost_" + rno).html(parseFloat($("#additionalcost" + rno).val()).toFixed(2));

        calculate();
        

                }
                }
            });
       }
       else{
           var avQty = $("#manualqty" + rno).val();
        
        /*if ((event.which != 46 || changeQty.indexOf('.') != -1) &&
        ((event.which < 48 || event.which > 57) &&
          (event.which != 0 && event.which != 8))) {
        event.preventDefault();
      }
      if ((changeQty.indexOf('.') != -1) &&
        (changeQty.substring(changeQty.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8)) {
        event.preventDefault();
         swal({
                title: 'Incorrect Quantity!',
                text: 'Please enter correct quantity',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
          $("#changeqty" + rno).val(0);
          changeQty = 0;
      }*/

        var newQty = parseFloat(-1) * parseFloat(changeQty);
       
        if(changeQty<0 && newQty>avQty){
            $("#changeqty" + rno).val(0);
            swal({
                title: 'Incorrect Quantity!',
                text: 'You cannot enter Change Quantity more than Uninvoiced Quantity',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        }
        
        var avQty = $("#manualqty" + rno).val();

        var changeQty = $("#changeqty" + rno).val();
       
        var upQty = parseFloat(avQty) + parseFloat(changeQty);

        $("#updatedqty" + rno).val(parseFloat(upQty).toFixed(2));

        calculateTotal(rno);

        $("#my_id_linetotal_" + rno).html(parseFloat($("#linetotalfield" + rno).val()).toFixed(2));

        $("#my_id_additionalcost_" + rno).html(parseFloat($("#additionalcost" + rno).val()).toFixed(2));

        calculate();
       }
        
    }
    
    $("body").on('change', '.useradditionalcost', function () {

        var rno = $(this).attr('rno');

        var margin = parseFloat($("#marginfield" + rno).val());

        var marginline = (margin / 100) * $("#useradditionalcost" + rno).val();

        var additional_cost = parseFloat($("#useradditionalcost" + rno).val());

        $("#useradditionalcost" + rno).val(additional_cost.toFixed(2));

        var vtotal = marginline + parseFloat($("#useradditionalcost" + rno).val());

        $('#marginaddcost_line' + rno).val(vtotal.toFixed(2));



        calculate();



    });
    
    function update_variation(column_name, msg=""){
        var id = $('#variation_id').val();
        var type ="variation";
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
                url: base_url+'project_variations/variation_update_ajax/',
                type: 'post',
                data: {var_number: var_number,column_name: column_name,column_value:column_value,id:id,var_total:var_total,var_round:var_round,type:type},
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (result) {
                $('.loader').hide();
                if(msg==""){
                if(result=="s"){
                    swal({
                          title: "Data Saved!",
                          text: "",
                          type: 'success',
                          confirmButtonClass: "btn btn-success",
                          buttonsStyling: false
                       });
                }
                }
                }
            });
    }
    
    function printhtmlvariation(){
        var mywindow = window.open();
        mywindow.document.write($('#printvariation').html());
    }
    
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
    
    function printvariation() {
        
        var mywindow = window.open();
        mywindow.document.write($('#printvariation').html());
        mywindow.print();
        mywindow.close();
        return true;

    }
    
    function setstagesformodal() {
        $("#extstages").val("");
        $("#extparts").val("");
        var project_id = $("#project_id").val();
        if (project_id != 'undefined' && project_id > 0) {
            $("#extpartmodal").modal('show');
        } else {

            swal({
                title: 'Validation Error!',
                text: 'Please select project first',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        }
    }

    function getExistingParts(val) {
        var costingId = $('#costing_id').val();
        $.post(base_url+"project_variations/getCostingPartsbyProject", {value: val, costingId: costingId})
            .done(function (data) {
                $('#extparts').html(data);
        });
    }
    
    function importSelectedPart() {

        var project_id = $("#project_id").val();
        var costing_part = $("#extparts").val();
        var stage_id = $("#extstages").val();
        if (stage_id == 0 || costing_part == 0) {
            swal({
                title: 'Validation Error!',
                text: 'All fields are required',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
        } else {
            var lstrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
            if (lstrow == 'undefined') {
                lstrow = 0;
            }

            $.ajax({
                url: base_url+'project_variations/populate_new_costing_row_by_cost_id/',
                type: 'post',
                data: {last_row: lstrow, costing_part: costing_part},
                success: function (result) {
                   if(result==""){
                       swal({
                            title: 'Error!',
                            text: 'No Data Found',
                            type: 'warning',
                            confirmButtonClass: "btn btn-warning",
                            buttonsStyling: false
                        }).catch(swal.noop);
                   }
                   else{
                    $('table#partstable tbody').append(result);
                    $('.selectpicker').selectpicker('refresh');
                    calculate();
                   }

                }
            });


            /*$.ajax({
                url: base_url+'project_variations/get_component_id/',
                type: 'get',
                data: {last_row: project_id, costingpart: costing_part, stageid: stage_id},
                dataType: "json",
                success: function (result) {
                    if (result.is_exist == 1)
                    {
                        var r = confirm("You Have Already Place order for this do u want to replace!");

                        if (r == true)
                        {
                            x = result.purchaser_id;
                            var previous_val = $("#hidden_val").val();
                            var present_val = previous_val + x + ',';
                            $("#hidden_val").val(present_val);

                        }
                    }



                }
            });*/
            $("#nopartadded").hide();
            $("#extpartmodal").modal('hide');
        }
    }
    
    $('body').on('click','.btn-issue-variation',function(){
             var variation_id = $("#variation_id").val();
             swal({
                title: 'Are you sure you want to issue variation?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, Issue Variation!',
                cancelButtonText: 'No',
                buttonsStyling: false
            }).then(function() {
                 
                window.location.href = base_url+"project_variations/variationsform/"+variation_id;			
				
            });
    });
    
    function repopulate_all_available_components() {
    
        var costingId = $('#costing_id').val();
        var variation_id = $('#variation_id').val();
        var lstrow = $('#partstable tbody tr').length;
            if (lstrow == 'undefined') {
                lstrow = 0;
            }
            $.ajax({
                url: base_url+'project_variations/repopulate_all_available_components',
                type: 'post',
                datatype: 'html',
                data: {last_row:lstrow, costingId: costingId, variation_id:variation_id},
                beforeSend: function() {
                    $('#loading-overlay').show();
                },
                success: function (result) {
                    $('#loading-overlay').hide();
                    $("#repopulateButton").attr("disabled", true);
                    if(result!=""){
                        populated = true;

                        $('table#partstable tbody').append(result);

                        calculate();
                    }
                    else{
                        populated = false;
                        $("#error_no_pc_for_this_project").modal("show");
                    }
                }
            });
        
    }



	
	