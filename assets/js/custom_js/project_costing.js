    $.validator.addMethod('uniquePart', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'project_costing/verify_part',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique part");
	
	$.validator.addMethod('uniqueEditPart', function(value) {
	    var id = $('#part_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'project_costing/verify_part',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique part");
             
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
        setFormValidation('#ProjectCostingForm');
    });
    
    $('body').on('change', '#project_costing_type', function () {
        var project_costing_type = $(this).val();
        if(project_costing_type=="Manual"){
            $(".manual_project_costing_container").show();
            $(".csv_container").hide();
        }
        else{
            $(".manual_project_costing_container").hide();
            $(".csv_container").show();
        }
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
                    $('#componentDescription' + row_no).val(obj.component_des);
                    $('#uomfield' + row_no).val(obj.component_uom);
					var ucost_field= parseFloat(obj.component_uc);
                    $('#ucostfield' + row_no).val(ucost_field.toFixed(2));
                    $('#order_unit_cost' + row_no).val(ucost_field.toFixed(2));
                    $('#supplierfield' + row_no).val(obj.supplier_id);
                    $('#supplierfieldname' + row_no).val(obj.supplier_name);
                    if(obj.image!=""){
                      $("#component_img"+row_no).html('<img src="'+base_url+'assets/components/thumbnail/'+obj.image+'" style="width: 80px; height: 50px;">');
                    }
                    else{
                           $("#component_img"+row_no).html('<img src="'+base_url+'assets/img/image_placeholder.jpg" style="width: 80px; height: 50px;">'); 
                    }
                    $('.selectpicker').selectpicker('refresh');
                    calculateTotal(row_no);
                    calculate();
                }, "json");
    }
    
    function calculate() {
        var total = 0;
        var val = 0;
        var vstotaol = 0;
      
        $(".qty").each(function () {
    
            var id = $(this).attr('id');
            var stage = $(this).attr('rno');
            var cost = $('#trnumber' + stage + ' #ucostfield' + stage).val();
            var qty = $(this).val();
            var newtotal = parseFloat(qty) * parseFloat(cost);
            var psubtoal = $('#linetotalfield' + stage).val();
            total += newtotal;
            vstotaol = parseFloat(vstotaol) + parseFloat(psubtoal);
           
                if (isNaN(total) || total == '') {
                    $("#total_cost").val(0);
                    $(".projectSubtotal").text("0.00");
                }
    
                else {
                    $("#total_cost").val(vstotaol.toFixed(2));
                    $(".projectSubtotal").text(vstotaol.toFixed(2));
                }
    
                calcuate_costing_totals();
                
                //Calculate Stage Subtotal
                var stage_id = $("#stagefield"+stage).val();
                var stage_subtotal = 0;
                
                /*$(".line_margin_"+stage_id).each(function () {
                    stage_subtotal =parseFloat(stage_subtotal)+parseFloat($(this).val());
                });
                $(".sub_total_"+stage_id).text("Stage Sub-total : "+parseFloat(stage_subtotal).toFixed(2));*/
        
                
            });
            
        var totalProfitMargin = 0.00;
        
        $(".profitMargin").each(function () {
            totalProfitMargin = parseFloat(totalProfitMargin) + parseFloat($(this).val());
        });
        
        $(".sumOfMargins").text(parseFloat(totalProfitMargin).toFixed(2));
        var projectSubtotal = $("#total_cost").val();
        var totalLineMargins = parseFloat(projectSubtotal) + parseFloat(totalProfitMargin);
        $(".totalLineMargins").text(parseFloat(totalLineMargins).toFixed(2));
        $("#line_margins").val(parseFloat(totalLineMargins).toFixed(2));
        
        calcuate_costing_totals();
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
						
						/*swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })*/	
				
            });
    });
    
    $('body').on('click','.select_all',function(){
      if($(this). prop("checked") == true){
          $(".selected_component"). prop("checked", true);
      }
      else{
          $(".selected_component"). prop("checked", false);
      }   
    });
    
    $('body').on('click','.select_all_items',function(){
      if($(this). prop("checked") == true){
          $("#add-more-row .selected_items"). prop("checked", true);
      }
      else{
          $("#add-more-row .selected_items"). prop("checked", false);
      }   
    });
    
    $('body').on('change','#document_type',function(){
        var type = $(this).val();
        var project_id = $("#project_id").val();
        if(type!=""){
            $.ajax({
                         url: base_url+"project_costing/get_component_documents", 
                         type: "POST",            
                         data: {type:type, project_id:project_id},
                         beforeSend: function() {
                            $('.loader').show();
                         },
                        success: function(result) 
                        {
                            $('.loader').hide();
                            $(".components_container").html(result);
                        }
            });
        }
    });

    function addMore(val) {

        var lastrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
        if (lastrow == 'undefined' || lastrow==undefined) {
            lastrow = 0;
        }
        else{
        lastrow = parseInt(lastrow)+1;
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
                $('table#partstable tbody').append(result);
                setFormValidation('#ProjectCostingForm');
                $(".component_description").hide();
                $('.selectpicker').selectpicker('refresh');
                $('.selectItemComponent').select2({
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
				$('.selectItemStage').select2({
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
    
    function checkEnableColumns(){
        var column1 = $("#column_status").is(":checked");

             if(column1){
                $(".status").show();
                } else {
                    $(".status").hide();
                }
                var column2 = $("#column_include").is(":checked");
    
             if(column2){
                $(".include").show();
                } else {
                    $(".include").hide();
                }
                
            var column3 = $("#column_comments").is(":checked");
    
             if(column3){
                $(".comments").show();
                } else {
                    $(".comments").hide();
                }
             var column4 = $("#column_boom_mobile").is(":checked");
    
             if(column4){
                $(".boom_mobile").show();
                } else {
                    $(".boom_mobile").hide();
                }
                var column5 = $("#column_component_description").is(":checked");
             if(column5){
                $(".component_description").show();
                } else {
                    $(".component_description").hide();
                }
                
                var column6 = $("#column_add_task_to_schedule").is(":checked");
             if(column6){
                $(".add_task_to_schedule").show();
                } else {
                    $(".add_task_to_schedule").hide();
                }
                var column7 = $("#column_subcategory").is(":checked");
                if(column7){
                    $(".subcategory").show();
                } else {
                    $(".subcategory").hide();
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
					
			     checkEnableColumns();
            }
        });

    }

    function getCostingbyTemplate(id) {

    var todid = "0";
    $(".tod_rows").each(function () {
        todid = todid + ",'" + $(this).attr('tod_id') + "'";


    });

    var lstrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
    var project_id = $("#current_project_id").val();
    var is_takeoffdata_exists = $("#is_takeoffdata_exists").val();
    $.ajax({
        url: base_url+'project_costing/get_costing_by_template/'+ id,
        type: 'POST',
        datatype: 'json',
        data: {id: id, last_row: lstrow, todid: todid, project_id:project_id, is_takeoffdata_exists:is_takeoffdata_exists},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            $('.loader').hide();
            response = result;
            $('table#partstable tbody').append(response.rData);
            if(is_takeoffdata_exists==0){
              $('#table-for-tod').html(response.tData);
              $("#is_takeoffdata_exists").val(1);
            }
            else{
              $(response.tData).insertAfter(".last_takeoff_data");
            }
            $(".tod_rows").each(function () {
            var tdText = $(this).attr("tod_id");
            $(".tod_rows")
                .filter(function () { 
                    return tdText == $(this).attr("tod_id"); 
                })
                .not(":first")
                .remove();
            });
            var takeoffdatas = "";
            $(".tod_rows").each(function () {
                takeoffdatas = takeoffdatas+$(this).attr('tod_id')+",";
            });
            $("#takeoffdatas").val(takeoffdatas);
            $(".component_description").hide();
            $('.selectpicker').selectpicker('refresh');
            $('.selectTemplateComponent').select2({
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
			$('.selectTemplateStage').select2({
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
        
        var project_id = $("#current_project_id").val();
        var is_takeoffdata_exists = $("#is_takeoffdata_exists").val();
        
        $.ajax({
        url: base_url+'project_costing/get_costing_by_template/'+ id,
        type: 'POST',
        datatype: 'json',
        data: {id: id, last_row: lastrow, todid: todid, project_id:project_id,is_takeoffdata_exists:is_takeoffdata_exists},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            $('.loader').hide();
            response = result;
            $('table#add-more-row tbody').append(response.rData);
            if(is_takeoffdata_exists==0){
              $('#table-for-tod').html(response.tData);
              $("#is_takeoffdata_exists").val(1);
            }
            else{
              $(response.tData).insertAfter(".last_takeoff_data");
            }
            $(".tod_rows").each(function () {
            var tdText = $(this).attr("tod_id");
        
            $(".tod_rows")
                .filter(function () { 
                    return tdText == $(this).attr("tod_id"); 
                })
                .not(":first")
                .remove();
            });
            var takeoffdatas = "";
            $(".tod_rows").each(function () {
                takeoffdatas = takeoffdatas+$(this).attr('tod_id')+",";
            });
            $("#takeoffdatas").val(takeoffdatas);
            $('.selectpicker').selectpicker('refresh');
            $('.selectTemplateComponent').select2({
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
			$('.selectTemplateStage').select2({
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
			checkEnableColumns();
            calculate();
        }
    });
        
    }

function getCostingbyProject(id) {
    
    var lstrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
    
        if (lstrow == 'undefined' || lstrow==undefined) {
            lstrow = 0;
        }
        else{
        lstrow = parseInt(lstrow)+1;
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
            //response = jQuery.parseJSON(result);
            response = result;
            $('.loader').hide();
            $('table#partstable tbody').append(response.rData);
            $(".component_description").hide();
            $('.selectpicker').selectpicker('refresh');
            $('.selectProjectComponent').select2({
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
			$('.selectProjectStage').select2({
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
					 calculate();
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
            //response = jQuery.parseJSON(result);
            response = result;
            $('.loader').hide();
            $('table#add-more-row tbody').append(response.rData);
            $('.selectpicker').selectpicker('refresh');
            $('.selectProjectComponent').select2({
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
			$('.selectProjectStage').select2({
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
			checkEnableColumns();
			calculate();

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
        $(".selectStage").attr('readonly', false);
        $(".selectComponent").attr('readonly', false);
        $("form input[type='checkbox']").css('pointer-events', 'auto');
        $("form select").css('pointer-events', 'auto');
        $("#extemplate_id").css('pointer-events', 'auto');
        $("#exproject_id").css('pointer-events', 'auto');

        $("#iconlockproject .fa").removeClass('fa-lock');
        $("#iconlockproject .fa").addClass('fa-unlock');

        $("#lockproject").val(0);
    } else {
        $("form input").attr('readonly', true);
        $(".selectStage").attr('readonly', true);
        $(".selectComponent").attr('readonly', true);
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
            $("#trnumber" + rno + " td input[type='checkbox']").attr('readonly', false);
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
            $('.selectpicker').selectpicker('refresh')
            $("#trnumber" + rno + " td textarea").attr('readonly', true);
            $("#trnumber" + rno + " td input[type='checkbox']").attr('readonly', true);
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
            $(".selectStage").attr('readonly', false);
            $(".selectComponent").attr('readonly', false);
            $('.selectpicker').selectpicker('refresh')
            $("td textarea").attr('readonly', false);
            $("td input[type='checkbox']").attr('readonly', false);
            $("#iconlockproject").removeClass('btn-danger');
            $("#iconlockproject").addClass('btn-success');
            $(".lock_project_icon_type").text("lock_open");
            $("#lockproject").val(0);
            $(".lock_icon_type").parent().removeClass('btn-danger');
            $(".lock_icon_type").parent().addClass('btn-success');
            $(".lock_icon_type").text("lock_open");
            $(".deleterow").css("display", "block");

        }
        else {
            $("td input").attr('readonly', true);
            $(".selectStage").attr('readonly', true);
            $(".selectComponent").attr('readonly', true);
            $('.selectpicker').selectpicker('refresh');
            $("td textarea").attr('readonly', true);
            $("td input[type='checkbox']").attr('readonly', true);
            $("#iconlockproject").removeClass('btn-success');
            $("#iconlockproject").addClass('btn-danger');
            $(".lock_project_icon_type").text("lock");
            $("#lockproject").val(1);
            $(".lock_icon_type").parent().removeClass('btn-success');
            $(".lock_icon_type").parent().addClass('btn-danger');
            $(".lock_icon_type").text("lock");
            $(".deleterow").css("display", "none");
        }
    }

    function changeLockStatus(rno)
    {
        var lock = $("#linelock" + rno).val();

        if (lock == 1) {
            $("#trnumber" + rno + " td input").attr('readonly', false);
            $("#trnumber" + rno + " td select").attr('readonly', false);
            $("#trnumber" + rno + " td .selectpicker").attr('readonly', false);
            $('.selectpicker').selectpicker('refresh')
            $("#trnumber" + rno + " td textarea").attr('readonly', false);
            $("#trnumber" + rno + " td input[type='checkbox']").attr('readonly', false);
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
            $("#trnumber" + rno + " td .selectpicker").attr('readonly', true);
            $('.selectpicker').selectpicker('refresh')
            $("#trnumber" + rno + " td textarea").attr('readonly', true);
            $("#trnumber" + rno + " td input[type='checkbox']").attr('readonly', true);
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
            if(formula!=""){
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
            var is_rounded = $("#is_rounded_stage_" + rno).val();
            
            
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
    
    function changeAddTaskToScheduleValue(id, rno) {

        if ($('#' + id).is(":checked")) {
            $("#add_task_to_schedule" + rno).val('1');
        }
        else {
            $("#add_task_to_schedule" + rno).val('0');
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
        var linemargins = $("#line_margins").val();
    
        var oh_margin = isNaN($("#overhead_margin").val()) ? 0 : $("#overhead_margin").val();
        var p_margin = isNaN($("#profit_margin").val()) ? 0 : $("#profit_margin").val();
        var c_tax = isNaN($("#costing_tax").val()) ? 0 : $("#costing_tax").val();
        //var psubtotal2 = isNaN($("#total_cost2").val()) ? 0 : $("#total_cost2").val();
        //var psubtotal3 = isNaN($("#total_cost3").val()) ? 0 : $("#total_cost3").val();
    
        var ppercent = (parseFloat(p_margin) / 100) * parseFloat(psubtotal1);
        $(".calculatedProfitMargin").text(ppercent.toFixed(2));
        var profitMarginSubtotal = parseFloat(linemargins) + ppercent;
        $("#profitMarginSubtotal").val(profitMarginSubtotal.toFixed(2));
        $(".profitMarginSubtotal").text(profitMarginSubtotal.toFixed(2));
        
        var profitMarginSubtotalValue = $("#profitMarginSubtotal").val();
        var opercent = (parseFloat(oh_margin) / 100) * parseFloat(psubtotal1);
        $(".calculatedOverheadMargin").text(opercent.toFixed(2));
        var overheadMarginSubtotal = parseFloat(profitMarginSubtotalValue) + opercent;
        $("#overheadMarginSubtotal").val(overheadMarginSubtotal.toFixed(2));
        $(".overheadMarginSubtotal").text(overheadMarginSubtotal.toFixed(2));
        $("#total_cost2").val(overheadMarginSubtotal.toFixed(2));
        
        var overheadMarginSubtotalValue = $("#overheadMarginSubtotal").val();
    
        var tax_percent = (parseFloat(c_tax) / 100) * overheadMarginSubtotalValue;
        var gstSubtotal = parseFloat(tax_percent) + parseFloat(overheadMarginSubtotalValue);
        $(".calculatedGST").text(tax_percent.toFixed(2));
        $(".gstSubtotal").text(gstSubtotal.toFixed(2));
        $("#gstSubtotal").val(gstSubtotal.toFixed(2));
        $("#total_cost3").val(gstSubtotal.toFixed(2));
        var contractPrice = (parseFloat(gstSubtotal)+parseFloat($("#price_rounding").val())).toFixed(2);
        $(".priceRoundingSubtotal").text(contractPrice);
        $("#priceRoundingSubtotal").val(contractPrice);
        $("#contract_price").val(contractPrice);
    }


    
    $('body').on('change', '.roundme', function () {
      var s6=$("#total_cost3").val();
      var s7=$("#price_rounding").val();
      var s8 = parseFloat(s6)+parseFloat(s7);
      $("#contract_price").val(s8.toFixed(2));
      $(".priceRoundingSubtotal").text(s8.toFixed(2));
      $("#priceRoundingSubtotal").val(s8.toFixed(2));
    });
    
    $('body').on('change', '.profitMargin', function () {
        var totalProfitMargin = 0.00;
        $(".profitMargin").each(function () {
            totalProfitMargin = parseFloat(totalProfitMargin) + parseFloat($(this).val());
        });
        $(".sumOfMargins").text(parseFloat(totalProfitMargin).toFixed(2));
        var projectSubtotal = $("#total_cost").val();
        var totalLineMargins = parseFloat(projectSubtotal) + parseFloat(totalProfitMargin);
        $("#line_margins").val(parseFloat(totalLineMargins).toFixed(2));
        $(".totalLineMargins").text(parseFloat(totalLineMargins).toFixed(2));
        calcuate_costing_totals();
    });
    
    function calculateTotal(rowno) {
    var mqty = $("#manualqty" + rowno).val();
    var ucost = $("#ucostfield" + rowno).val();
    
    if(mqty!="" && ucost!=""){
        if(parseFloat(mqty)<0){
            	swal({
                    title: 'Incorrect Quantity!',
                    text: 'Please enter correct quantity.',
                    type: 'warning',
                    confirmButtonClass: "btn btn-warning",
                    buttonsStyling: false
                })	
            $("#manualqty" + rowno).val(0);
            mqty = 0;
        }
        if(parseFloat(ucost)<0){
            swal({
                title: 'Incorrect Currency Value!',
                text: 'Please enter positive value only.',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            })
           ucost = 0;
        }
    
        if(parseFloat($("#order_unit_cost"+rowno).val()).toFixed(2)==$("#order_unit_cost"+rowno).val()){
              var order_cost = $("#order_unit_cost"+rowno).val();
        }
        else{
          
            var order_cost = parseFloat($("#order_unit_cost"+rowno).val()).toFixed(2);
        }
  
        var unit_cost = $("#ucostfield"+rowno).val();
        var component_id = $("#componentfield"+rowno).val();
        
        if(order_cost!=unit_cost && order_cost!="0.00"){
            $("#componentCostModal #update_component_id").val(component_id);
            $("#componentCostModal #update_invoice_unit_cost").val(unit_cost);
            $("#componentCostModal #invoice_unit_cost").val(unit_cost);
            $("#componentCostModal #current_unit_cost").val(order_cost);
            $('#componentCostModal').modal('show'); 
        }
    
        $("#ucostfield" + rowno).val(parseFloat(ucost).toFixed(2));
        var line_total = parseFloat($("#linetotal" + rowno).val());
    
        if (isNaN(mqty)) {
            mqty = 0;
        } else {
            mqty = mqty;
        }
        if (isNaN(ucost)) {
            ucost = 0;
        } else {
            ucost = ucost;
        }

        var row_total = mqty * ucost;
    
        $('#linetotalfield' + rowno).val(row_total.toFixed(2));
    
        var margin = parseFloat($("#marginfield" + rowno).val());
        if (isNaN(margin)) {
            margin = 0;
        }
        var marginline = (margin / 100) * row_total;
        var vtotal = marginline + row_total;
        if (isNaN(vtotal)) {
            vtotal = 0;
        }
        $('#margin_linefield' + rowno).val(parseFloat(vtotal).toFixed(2));
        calculate();
    }
}

function update_component_unit_cost(){
        $('#componentCostModal').modal('hide'); 
        var rno = $('#update_rno').val();
        var component_id = $('#update_component_id').val();
        var unit_cost = $('#update_invoice_unit_cost').val();
         $.ajax({
                    url: base_url+'project_costing/update_component_unit_cost/',
                    type: 'post',
                    data: {component_id: component_id,unit_cost:unit_cost},
                    beforeSend: function() {
                      //$('#loading-overlay').show();
                    },
                    success: function (result) {
                        //$('#loading-overlay').hide();
                    }
                });

        
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

    function validateForm() {
        var lstrow = $('#partstable > tbody').find('tr').length;
        var newItemRow = $('#add-more-row > tbody').find('tr').length;
        var project_costing_type = $("#project_costing_type").val();
        if (lstrow > 0 || newItemRow>0) {
            /*$("td .selectpicker").attr('disabled', false);
            $("select").attr('disabled', false);
            $("td input[type='checkbox']").attr('disabled', false);*/
            return true;
        }
        else {
            swal({
                title: 'Error!',
                text: 'Add at least one part to save this costing.',
                type: 'error',
                confirmButtonClass: "btn btn-success",
                buttonsStyling: false
                })
            return false;
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
              $('#loading-overlay').show();
            },
            success: function (data) {
                $('#loading-overlay').hide();
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
                        });
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
                        });
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
                        $('#loading-overlay').show();
                     },
					success:function(result){
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })	
                        $('#loading-overlay').hide();
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
                        });
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
                        $('#loading-overlay').show();
                     },
					success:function(result){
					    $('#loading-overlay').hide();
                        $(".documents_container").html(result);
                        $("#form_documents")[0].reset();
						swal({
                           title: 'Done!',
                           text: 'Your record has been set as private.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })	
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
                        });
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
                        $('#loading-overlay').show();
                     },
					success:function(result){
					    $('#loading-overlay').hide();
                        $(".documents_container").html(result);
                        $("#form_documents")[0].reset();
						swal({
                           title: 'Done!',
                           text: 'Your record has been set as share.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })	
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
                        });
            }
    });
    
    $('body').on('click','.select_all_line_items',function(){
        var stage_id = $(this).attr("stage_id");
        if ($('.select_all_line_items:checked').length > 0){
            $('#collapseOne'+stage_id+' #partstable .selected_items').prop("checked", true);
        }
        else{
               $('#collapseOne'+stage_id+' #partstable .selected_items').prop("checked", false);  
            }
    });
    
    
    
    //Estimate Request
    
    $(document).ready(function() {
              setFormValidation('#ProjectEstimateForm');
    });
    
    if($('#DropzoneContainer').length){
    
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("#DropzoneContainer", {
  url: base_url+"project_costing/send_estimate_request",                        
  autoProcessQueue: false,
  uploadMultiple: true,
  renameFile: false,
  paramName: "files",
  maxFilesize: 15,
  init: function(){
      
        

        let thisDropzone = this; // Closure
        thisDropzone.on("error", function (file, message) {
                        toastr.error(message);
                        this.removeFile(file);
                    }); 
       
        
        thisDropzone.on('sendingmultiple', function(file, xhr, formData){
            formData.append('project_id', $("#project_id").val());
            formData.append('supplier_id', $("#supplier_id").val());
            formData.append('description', $("#description").val());
            $("#send_for_estimate").attr("disabled",true);
            $("#loading-overlay").show();
        });
        thisDropzone.on("thumbnail", function(file) {
            if ( $( ".dz-preview" ).length ){
              $("#upload_document-error").remove();
             }   
        });
        
        thisDropzone.on("successmultiple", function(file, response) {
            toastr.success(response);
            $("#ProjectEstimateForm")[0].reset();
            thisDropzone.removeAllFiles(true); 
            $("#send_for_estimate").attr("disabled",false);
            $("#loading-overlay").hide();
        });    
            
    }
});

    }
$('#send_for_estimate').click(function(e){ 
    if($("#ProjectEstimateForm").valid()){
        if ( $( ".dz-preview" ).length ){
             myDropzone.processQueue();
              $("#upload_document-error").remove();
        }   
        else {
          $(".dropzone_error").append('<label id="upload_document-error" class="error" for="upload_document-error">Please upload atleast one document or file.</label>');
        }
     
    }
    else{
        if( !($( ".dz-preview" ).length )){
            $(".dropzone_error").append('<label id="upload_document-error" class="error" for="upload_document-error">Please upload atleast one document or file.</label>');
           
        }
       $("#ProjectEstimateForm").validate(); 
    }
                   
 
});

$('#description').keypress(function(){

    if(this.value.length > 100){
        
    }
    else{
    $("#remainingCharacters").html((100 - this.value.length));
    }
});

$('#description').keydown(function(){

    if(this.value.length > 100){
        
    }
    else{
    $("#remainingCharacters").html((100 - this.value.length));
    }
});

 $('body').on('click','.hide_list',function(){
        $(".add_new_project").show();
        $(".project_list").hide();
    });
    
    $('body').on('click','.show_list',function(){
        $(".add_new_project").hide();
        $(".project_list").show();
    });
    
     $.validator.addMethod('uniqueProject', function(value) {
                 var result = $.ajax({ 
                                      
        			    async:false, 
                        url:base_url+"manage/verify_project",
                        type: 'post',
        			    data:{name: value},
        	}); 
        
            if(result.responseText == '0') return true; else return false;
        
            } , "Please enter a unique Project Title");
            
            
        $('body').on('click','.add_project_btn',function(){
            if($("#ProjectForm").valid()){
                var formdata = $("#ProjectForm").serialize();
                $.ajax({
                url: base_url+"project_costing/add_new_project/",
                type: 'post',
                data: formdata,
				beforeSend: function() {
                    $(".add_project_btn").val("Please Wait....."); 
                    $(".add_project_btn").attr("disabled", true); 
                },
                success: function (result) {
                    $("#project_id").html(result);
                    $("#ProjectForm")[0].reset();
                    swal({
                           title: 'Done!',
                           text: 'New Project Added sucessfully',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    $(".add_project_btn").val("Add Project"); 
                    $(".add_project_btn").attr("disabled", false);
                    $('.selectpicker').selectpicker('refresh');
                    $(".control-label").css("top", "-7px");
                    $("#addNewProject .close").click();
                }
            });
            }
            else{
               $("#ProjectForm").validate();
            }
    });
    
    $.validator.addMethod('uniqueClient', function(value) {
                 var result = $.ajax({ 
                                      
        			    async:false, 
                        url:base_url+"manage/verify_client_email",
                        type: 'post',
        			    data:{email: value},
        	}); 
        
            if(result.responseText == '0') return true; else return false;
        
            } , "Client Already Exists");
            
            
    $('body').on('click','.add_client_btn',function(){
            if($("#ClientForm").valid()){
                var formdata = $("#ClientForm").serialize();
                $.ajax({
                url: base_url+"project_costing/add_new_client/",
                type: 'post',
                data: formdata,
				beforeSend: function() {
                    $(".add_client_btn").val("Please Wait....."); 
                    $(".add_client_btn").attr("disabled", true); 
                },
                success: function (result) {
                    $("#client_id").html(result);
                    $("#ClientForm")[0].reset();
                    swal({
                           title: 'Done!',
                           text: 'New Client Added sucessfully',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
                    $(".add_client_btn").val("Add Client"); 
                    $(".add_client_btn").attr("disabled", false);
                    $('.selectpicker').selectpicker('refresh');
                    $(".control-label").css("top", "-7px");
                    $("#addNewClient .close").click();
                    
                }
            });
            }
            else{
               $("#ClientForm").validate();
            }
    });
    
    $('body').on('click','.hide_client_list',function(){
        $(".add_new_client").show();
        $(".client_list").hide();
    });
    
    $('body').on('click','.show_client_list',function(){
        $(".add_new_client").hide();
        $(".client_list").show();
    });
      $('.edit-import-file-button').on('click', function (e) {
        if($("#ProjectCostingCSVForm").valid()){
            let files = new FormData(), // you can consider this as 'data bag'
            url = base_url+'project_costing/import_component_by_csv';
            var fileName = $('#importcsv')[0].files;
            files.append('importcsv', fileName[0]); // append selected file to the bag named 'file'
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
            files.append('last_row', lastrow);
        
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: files,
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (response) {
                    if(response == "Only CSV files are allowed."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("Only CSV files are allowed.");
                    }
                    else if(response == "File format is wrong. Please upload correct file."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("File format is wrong. Please upload correct file.");
                    }
                    else{
                        $('.loader').hide();
                        $('table#add-more-row tbody').append(response); 
                        calculate();
                        $('.selectpicker').selectpicker('refresh');
                        $("#ProjectCostingCSVForm")[0].reset();
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        else{
            setFormValidation("#ProjectCostingCSVForm");
        }
    });
    
    $('.import-file-button').on('click', function (e) {
        if($("#ProjectCostingCSVForm").valid()){
            let files = new FormData(), // you can consider this as 'data bag'
            url = base_url+'project_costing/import_component_by_csv';
            var fileName = $('#importcsv')[0].files;
            files.append('importcsv', fileName[0]); // append selected file to the bag named 'file'
            var lastrow = $("table#partstable tbody tr:last-child()").attr('tr_val');
            if (lastrow == 'undefined' || lastrow==undefined) {
                lastrow = 0;
            }
            else{
            lastrow = parseInt(lastrow)+1;
            }
            files.append('last_row', lastrow);
        
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: files,
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function (response) {
                    if(response == "Only CSV files are allowed."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("Only CSV files are allowed.");
                    }
                    else if(response == "File format is wrong. Please upload correct file."){
                        $(".import_file_error").show();
                        $(".import_file_error").html("File format is wrong. Please upload correct file.");
                    }
                    else{
                        $('.loader').hide();
                        $('table#partstable tbody').append(response); 
                        calculate();
                        $('.selectpicker').selectpicker('refresh');
                        $("#ProjectCostingCSVForm")[0].reset();
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        else{
            setFormValidation("#ProjectCostingCSVForm");
        }
    });
    


	
	