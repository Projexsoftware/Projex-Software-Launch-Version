    $.validator.addMethod("atLeastOneChecked", function(value, element) {
        // Check if at least one checkbox is checked
        return $('input[name="selectTemplate[]"]:checked').length > 0;
    }, "Please check at least one template.");
    
   $.validator.addMethod('uniqueStage', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_stage',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique stage");
	
	$.validator.addMethod('uniqueEditStage', function(value) {
	    var id = $('#stage_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_stage',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique stage");

    $.validator.addMethod('uniqueTakeoffdata', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_takeoffdata',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique take off data");
	
	$.validator.addMethod('uniqueEditTakeoffdata', function(value) {
	    var id = $('#takeof_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'setup/verify_takeoffdata',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique take off data");
             
     $.validator.addMethod('uniqueTemplate', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_template',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique template name");
	
	$.validator.addMethod('uniqueEditTemplate', function(value) {
	    var id = $('#template_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'setup/verify_template',
                type: 'post',
			    data:{name: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique template name");
             
    $.validator.addMethod('uniquePart', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_part',
                type: 'post',
			    data:{name: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique part");
	
	$.validator.addMethod('uniqueEditPart', function(value) {
	    var id = $('#part_id').val();		
        var result = $.ajax({ 
			    async:false, 
                url:base_url + 'setup/verify_part',
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
    
    $.validator.addMethod('ckrequired', function (value, element, params) {
    var idname = jQuery(element).attr('id');
    var messageLength =  jQuery.trim ( CKEDITOR.instances[idname].getData() );
    return !params  || messageLength.length !== 0;
}, "Detail is required");
             
    $(document).ready(function() {
        setFormValidation('#StageForm');
        setFormValidation('#TakeoffdataForm');
        setFormValidation('#TemplateForm');
        setFormValidation('#EmailMessageForm');
        setFormValidation('#TemplateDownloadForm');
    });
    
    var sereal_count = 0;
    
    $(document).ready(function () {
        calculate();
        $('[data-toggle="tooltip"]').tooltip();
    });

     function modelid(title) {
        $('#modelnumber').val(title);
        var rowno = title.split("_");
        sereal_count = 0;
        $('.addoperator').val('').css('display', 'none');
        $('.addnumber').val('').css('display', 'none');
        $('.addtakeOffData').val('').css('display', 'none');
        $("#addformulavalue").html("");
        $('#formulainput').text('');
        $('#formulatext').text('');
        $('#formulavalue').text('');
        $('.remove_operator').hide();
        $('.remove_number').hide();
        $('.remove_takeoff').hide();
        $('.formula-created').hide();
        $('#is_rounded').prop("checked", false); 
        
        var formula = $("#formulaqty"+title).val();
		  if(formula==0 || formula==""){
				$('#modelnumber').val(title);
				$('#modelforrow').val(rowno[2]);
				$('#simpleModal').modal('show');
		  }
		  else{
			var part_id = $("#tpl_part_id"+rowno[2]).val();
			var formula_qty = $('#formulaqty'+title).val();
			var formula_text = $('#formulatext'+title).val();
			var is_rounded = $('#is_rounded'+title).val();
			$.ajax({
			url: base_url+'supplierz/edit_formula/',
			type: 'post',
			data: {part_id: part_id,formula_qty:formula_qty,formula_text,formula_text,is_rounded:is_rounded},
			beforeSend: function() {
					  $('.loader').show();
					},
					success: function (result) {
					   $('.loader').hide();
					   $('.update-modal-container').html(result);
					   $('#updatemodelnumber').val(title);
					   $('#updatemodelforrow').val(rowno);
					   $('#updateFormulaModal').modal('show');
					   $('.selectpicker').selectpicker('refresh');
					   var formula = $(".updateoperator").length;
                       var formula_2 = $(".updatetakeOffData").length;
                        
                       var formula_3 = $(".updatenumber").length;
                        
                       var total_inputs = (formula + formula_2 + formula_3 );
					   sereal_count = total_inputs;
					 }
				   });

		  }
    }
    function menulQuantity(title) {

        $('#viewquanity' + title).text('');
        $('#formula' + title).val('');
        $('#formulaqty' + title).val('');
        $('#formulatext' + title).val('');
    }
    
     function GetFormula() {
        if (sereal_count == 0) {
            $(".formula-error").show();
            return false;
        }
        $(".formula-error").hide();
        $(".formula-created").show();
        $('#formulainput').text('');
        $('#formulavalue').text('');
        $('#formulatext').text('');
        var partid = $('#modelnumber').val();
        var formula = $(".addoperator").length;
        // alert(formula);
        var formula_2 = $(".addtakeOffData").length;
        
        var formula_3 = $(".addnumber").length;
        
        var total_inputs = (formula + formula_2 + formula_3 )-3;
        var k = 1;
		var i=0;
        var my_formula = '';
        var my_formula_values = '';
        var my_formula_text = '';
		var selected_ids = new Array();
		var todid = 0;

        for (k; k <= total_inputs; k++) {
            var current_selector = '[my-check="sereal'+k+'"]';
            if ($(current_selector).attr('name') == 'takeoffdata') {
               var current_value = "|"+$(current_selector).val();
            }
            else{
                var current_value = $(current_selector).val();
            }

            if ($(current_selector).attr('name') == 'operator') {
                var current_formula_value = $(current_selector).val();
            }
            else if ($(current_selector).attr('name') == 'takeoffdata') {
                var current_formula_value = $(current_selector).find("option:selected").attr("title");
				selected_ids[i]= $(current_selector).find("option:selected").val();
				var tod_id = $(current_selector).find("option:selected").attr("tod_id");
				todid = todid+",'"+tod_id+"'";
				i++;
            }
            else {
                var current_formula_value = $(current_selector).val();
				 
            }
            if ($(current_selector).attr('name') == 'operator') {
                var current_formula_text = $(current_selector).find("option:selected").val();
            }
            else if ($(current_selector).attr('name') == 'takeoffdata_number') {
                var current_formula_text = $(current_selector).val();
            }
            else{
                 var current_formula_text = $(current_selector).find("option:selected").text();
            }
            my_formula_text+= current_formula_text;
            my_formula_values+= current_formula_value;
            //alert(my_formula_values);
            my_formula+= current_value;
            my_formula+= ',';
        }
        /*if (formula == 0) {
            
            $('#formula' + partid).val($('#takeoffdata').find("option:selected").attr("title"));

        }
        else {*/
            
            $("#formulainput").append(my_formula);
            $("#formulavalue").append(my_formula_values);
            $("#formulatext").append("Formula : "+my_formula_text);

            
            $('#formula' + partid).val($('#formulainput').text());

            // $('#formulaqty' + partid).val($('#formulavalue').text());
            $('#formulaqty' + partid).val($('#formulainput').text());
            $('#formulatext' + partid).val($('#formulatext').text());
            $('#is_rounded' + partid).val($('#is_rounded').val());
            $('#my_id' + partid).html($('#formulatext').text());
            //$('#my_id_stage_' + partid).html($('#formulatext').text());
            var rowNo = partid.split("_");
            $('.calculatedFormula'+rowNo[2]).attr("data-container", "body");
            $('.calculatedFormula'+rowNo[2]).attr("data-toggle", "tooltip");
            $('.calculatedFormula'+rowNo[2]).attr("data-original-title", $('#formulatext').text());
            $('[data-toggle="tooltip"]').tooltip();


       // }
    } //end GetFormula


    var removeTakeoff = $(".addformula").length;

    if (removeTakeoff == 2)
    {
        $(".removeTakeoffDiv").hide();
    }
    function removeTakeoffDiv() {
        var addformula = $(".addformula").length;
        if (addformula > 1)
        {
            $("#addformula" + addformula).remove();
        }
        if (addformula == 2)
        {
            $(".removeTakeoffDiv").hide();
        }
    }
	
	function remove_operator() {
        sereal_count = new Number(sereal_count - 1);
        var addformula = $(".addoperator").length;
        if (addformula > 1)
        {
            $("#addoperator" + addformula).remove();
        }
        if (addformula == 2)
        {
            $(".remove_operator").hide();
        }
        
        reset_sereal_count();

    }
	
	function remove_takeoff() {
        sereal_count = new Number(sereal_count - 1);
        var addformula = $(".addtakeOffData").length;
        addformula--;
        if (addformula > 0)
        {
            $("#addtakeOffData" + addformula).remove();
        }
        if (addformula == 1)
        {
            $(".remove_takeoff").hide();
        }
        
        reset_sereal_count();

    }
    
     function remove_number() {
        sereal_count = new Number(sereal_count - 1);
        var addformula = $(".addnumber").length;
        if (addformula > 1)
        {
            $("#addnumber" + addformula).remove();
        }
        if (addformula == 2)
        {
            $(".remove_number").hide();
        }
        reset_sereal_count();

    }
	
	function addMoreoperators() {
        $(".remove_operator").show();
        sereal_count = new Number(sereal_count + 1);
        var num = $('.addoperator').length;
        var newNum = new Number(num + 1);
        var newElem = $('#addoperator0').clone().attr('id', 'addoperator' + newNum).appendTo("div#addformulavalue");
        $('#addoperator' + newNum + ' ' +'select').attr('my-check', 'sereal'+sereal_count);
        $('#addoperator' + newNum + ' ' +'select').addClass('formula_field');
        
        $('div #addoperator' + newNum + ' #operator' + num).attr('id', 'operator' + newNum);
        $('#addoperator' + newNum).show();
    }
	
	function addMoreTakeoff() {
        
        // Show the remove button
        $(".remove_takeoff").show();
        
        // Increment the serial count
        sereal_count = Number(sereal_count + 1);
        
        // Get the current count of .addtakeOffData elements
        var num = $('#addformulavalue .addtakeOffData').length;
        var newNum = num + 1;
         
        // Clone the element and update attributes
        var newElem = $('#addtakeOffData0').clone().attr('id', 'addtakeOffData' + newNum);
        newElem.find('select').attr('my-check', 'sereal' + sereal_count);
        newElem.find('select').attr('id', 'takeoffdata' + newNum);
        newElem.find('select').addClass('selectpicker');
        newElem.find('select').attr('data-live-search', 'true');
        newElem.find('select').attr('data-style', 'select-with-transition');
        
        // Append the cloned element to the container
        newElem.appendTo("#addformulavalue");
        
        // Re-initialize the selectpicker after cloning
        newElem.find('select').selectpicker();
        
        
        newElem.find('#takeoffdata'+newNum).addClass('formula_field');
    
        // Show the newly cloned element
        newElem.show();

    }
   
    function addMoreNumber() {
        $(".remove_number").show();
        sereal_count = new Number(sereal_count + 1);
        var num = $('.addnumber').length;
        if (num == 1) {
            var test_num = '';
        }
        else {
            test_num = new Number(num - 1);
        }
        var newNum = new Number(num + 1);
        var newElem = $('#addnumber0').clone().attr('id', 'addnumber' + newNum).appendTo("div#addformulavalue");
        $('#addnumber' + newNum + ' ' +'input').attr('my-check', 'sereal'+sereal_count);
        $('[my-check="sereal'+sereal_count+'"]').val('');
        $('#addnumber' + newNum + ' ' +'input').addClass('formula_field');
        $('div #addnumber' + newNum + ' #takeoffdata_number' + test_num).attr('id', 'takeoffdata_number' + num);
        $('#addnumber' + newNum).show();
    }


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
    
    function supplierzComponentVal(th){
        value = $(th).val();

        row_no = $(th).attr('rno');
        $.post(base_url+"setup/getSupplierzCompnent", {value: value})
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
    
    function changeQTYType(th) {

        var fieldno = $(th).attr('qtype_number');

        if (th.value.toLowerCase() == "manual") {
           $(".formula_btn"+fieldno).addClass("disabled");
           $(".formula_btn"+fieldno).attr("href", "");
           $("#manualqty"+fieldno).attr("required", true);
        }
        else {
           $(".formula_btn"+fieldno).removeClass("disabled");
           $("#manualqty"+fieldno).removeAttr("required");
        }

    }
    function CreateComponent() {
        var value = $('#component').attr('value');
        var str = $('#comopoentdivid').attr('value');

        var cdiv_id = str.replace("addcomponent", "");
        $.post(base_url+"component/getfullcompnent", {value: value})
                .done(function (data) {
                    var str = data;
                    $('#componentdiv' + cdiv_id).append(str);

                });
    }


    function calculate() {

        var total = 0;
        var val = 0;

        $(".quty").each(function () {
            var id = $(this).attr('title');
            var stage = $(this).attr('alt');
            var cost = $('#clonedStage' + stage + ' #clonedInput' + id + ' #component_uc' + id).val();


            var qty = $(this).val();
            var newtotal = parseFloat(qty) * parseFloat(cost);
            total += newtotal;




            if (isNaN(total) || total == '') {
                $("#total").val(0);
            } else {
                $("#total").val(total);
            }



        });
    }

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

        var lastrow = $("table#partstable tbody tr:last-child()").attr('tr_val');

        if (lastrow == undefined || lastrow=="") {
            lastrow = 0;
        }
        else{
            lastrow = parseInt(lastrow)+1;
        }

        $.ajax({
            url: base_url+"setup/populate_new_template_row",
            type: 'post',
            data: {next_row: lastrow},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('table#partstable tbody').append(result);
                setFormValidation('#TemplateForm');
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

function getTemplatingbyTemplate(id) {
    
        //Removing Default Item
        if($("table tbody tr.defaultItem").length){
            $("table tbody tr.defaultItem").remove();
        }
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";


        });
        var lstrow = ($("table tbody tr").length)-1;
        
        if (lstrow == undefined) {
            lstrow = 0;
        }
        else{
            lstrow = parseInt(lstrow)+parseInt(1);
        }

        $.ajax({
            url: base_url+"setup/get_templating_by_template/"+id,
            type: 'POST',
            datatype: 'json',
            data: {id: id, last_row: lstrow, todid: todid},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                response = $.parseJSON(result);
                $('table#partstable tbody').append(response.rData);
                setFormValidation('#TemplateForm');
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
				$('.selectpicker').selectpicker('refresh');
            }
        });


    }
    
function getTemplatingbySupplierzTemplate(id) {
    
        //Removing Default Item
        if($("table tbody tr.defaultItem").length){
            $("table tbody tr.defaultItem").remove();
        }
        var todid = "0";
        $(".tod_rows").each(function () {
            todid = todid + ",'" + $(this).attr('tod_id') + "'";


        });
        var lstrow = ($("table tbody tr").length)-1;
        
        if (lstrow == undefined) {
            lstrow = 0;
        }
        else{
            lstrow = parseInt(lstrow)+parseInt(1);
        }

        $.ajax({
            url: base_url+"setup/get_templating_by_supplierz_template/"+id,
            type: 'POST',
            datatype: 'json',
            data: {id: id, last_row: lstrow, todid: todid},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                //response = $.parseJSON(result);
                response = result;
                $('table#partstable tbody').append(response.rData);
                $("#template_name").val(response.templateName);
                $("#template_name").parent("div").addClass("is-focused");
                $("#template_desc").val(response.templateDesc);
                $("#template_desc").parent("div").addClass("is-focused");
                setFormValidation('#TemplateForm');
				$('.filterSupplierzComponent').select2({
            		placeholder: "Select Component",
            		templateResult: formatComponent,
            		ajax: {
            		  type:'post',
            		  url: base_url+"ajax/getSupplierzComponents",
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
				$('.selectpicker').selectpicker('refresh');
            }
        });


    }
    
function getTemplatingbyProject(id) {
    
    //Removing Default Item
    if($("table tbody tr.defaultItem").length){
            $("table tbody tr.defaultItem").remove();
    }
    var lstrow = ($("table tbody tr").length)-1;
        
    if (lstrow == undefined) {
         lstrow = 0;
    }
    else{
         lstrow = parseInt(lstrow)+parseInt(1);
    }

    $.ajax({
        url: base_url+'setup/get_previous_project_costing',
        method: 'post',
        datatype: 'json',
        data: {id: id, last_row: lstrow},
        beforeSend: function() {
              $('.loader').show();
        },
        success: function (result) {
            $('.loader').hide();
                response = $.parseJSON(result);
                $('table#partstable tbody').append(response.rData);
                setFormValidation('#TemplateForm');
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
				$('.selectpicker').selectpicker('refresh');
        }
    });

}

$('.import-file-button').on('click', function (e) {
        if($("#TemplateCSVForm").valid()){
            let files = new FormData(), // you can consider this as 'data bag'
            url = base_url+'setup/import_component_by_csv';
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
                        $('.selectpicker').selectpicker('refresh');
                        calculate();
                        $("#TemplateCSVForm")[0].reset();
                    }
                    
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
        else{
            setFormValidation("#TemplateCSVForm");
        }
    });
    
     $.validator.addMethod('uniqueEmail', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_email',
                type: 'post',
			    data:{email: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique email");
	
	$.validator.addMethod('uniqueEditEmail', function(value) {
	    var id = $('#user_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_email',
                type: 'post',
			    data:{email: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique email");

    $(document).ready(function() {
        setFormValidation('#UserForm');
    });
	
	$.validator.addMethod('uniqueRole', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_role',
                type: 'post',
			    data:{role_title: value},
	}); 

    if(result.responseText == '0') return true; else return false;

    } , "Please enter a unique role");
	
	$.validator.addMethod('uniqueEditRole', function(value) {
	    var id = $('#role_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'setup/verify_role',
                type: 'post',
			    data:{role_title: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique role");


    $(document).ready(function() {
        setFormValidation('#RoleForm');
    });
    
    function checkbox_item(id){
        if($("#"+id ).prop( "checked" )==false){
          $(".child_"+id).prop( "checked", false ); 
          $(".sub_child_"+id).prop( "checked", false ); 
        }
        else{
            $(".child_"+id).prop( "checked", true );
            $(".sub_child_"+id).prop( "checked", true ); 
        }
    }
    
    function checkbox_child_items(id){
        if($("#"+id ).prop( "checked" )==false){
          $(".sub_"+id).prop( "checked", false ); 
        }
        else{
            $(".sub_"+id).prop( "checked", true ); 
        }
    }
   
   function checkbox_parent_item(id, type, parent_id = 0){
    if(type == "subchild"){
        $("#menu_"+parent_id).prop( "checked", true);
        $("#child_menu_"+id).prop( "checked", true);
    }
    else{
       $("#"+id).prop( "checked", true);
    }
  }
  
  function update_addMoreoperators() {
  $(".remove_operator").show();
  sereal_count = new Number(sereal_count + 1);
  var num = $('.updateoperator').length;
  if (num == 0) {
    var test_num = '';
  }
  else {
    test_num = new Number(num - 1);
  }
  var newNum = new Number(num + 1);
  var newElem = $('#updateoperator0').clone().attr('id', 'updateoperator' + newNum).appendTo("div#updateformulavalue");
  $('#updateoperator' + newNum).attr('class', 'updateoperator');
  $('#updateoperator' + newNum + ' ' +'select').attr('my-check', 'updatesereal'+sereal_count);
  $('#updateoperator' + newNum + ' ' +'select').addClass('formula_field');
  $('div #updateoperator' + newNum + ' ' +'select').attr('id', 'operator' + newNum);
  $('div #updateoperator' + newNum + ' #operator' + newNum).addClass("formula_field");
  $('#updateoperator' + newNum).show();
}

    function update_addMoreTakeoff() {
        // Show the remove button
        $(".remove_takeoff").show();
        
        // Increment the serial count
        sereal_count = Number(sereal_count + 1);
        
        // Get the current count of .addtakeOffData elements
        var num = $('.updatetakeOffData').length;
        var newNum = num + 1;
         
        // Clone the element and update attributes
        var newElem = $('#updatetakeOffData0').clone().attr('id', 'updatetakeOffData' + newNum);
        newElem.addClass('updatetakeOffData');
        newElem.find('select').attr('my-check', 'updatesereal' + sereal_count);
        newElem.find('select').attr('id', 'takeoffdata' + newNum);
        newElem.find('select').addClass('selectpicker');
        newElem.find('select').attr('data-live-search', 'true');
        newElem.find('select').attr('data-style', 'select-with-transition');
        
        // Append the cloned element to the container
        newElem.appendTo("#updateformulavalue");
        
        // Re-initialize the selectpicker after cloning
        newElem.find('select').selectpicker();
        
        newElem.find('#takeoffdata'+newNum).addClass('formula_field');
    
        // Show the newly cloned element
        newElem.show();
    }

   function update_addMoreNumber() {
  $(".remove_number").show();
  sereal_count = new Number(sereal_count + 1);
  var num = $('.updatenumber').length;
  if (num == 0) {
    var test_num = '';
  }
  else {
    test_num = new Number(num - 1);
  }
  var newNum = new Number(num + 1);
  var newElem = $('#updatenumber0').clone().attr('id', 'updatenumber' + newNum).appendTo("div#updateformulavalue");
  $('#updatenumber' + newNum).attr('class', 'updatenumber');
  $('#updatenumber' + newNum + ' ' +'input').attr('my-check', 'updatesereal'+sereal_count);
  $('#updatenumber' + newNum + ' ' +'input').addClass('formula_field');
  $('[my-check="sereal'+sereal_count+'"]').val('');
  $('div#updatenumber' + newNum + ' ' +'input').attr('id', 'takeoffdata_number' + newNum);
  $('div#updatenumber' + newNum + ' #takeoffdata_number' + newNum).addClass("formula_field");
  $('#updatenumber' + newNum).show();
}

    function reset_sereal_count(){
          var i = 1;
          $(".bootstrap-select").removeClass("formula_field").removeAttr("my-check");
          $('.formula_field').each(function() {
          $( this ).attr('my-check', 'sereal'+i);
          i++;
          });
    }

function update_popup_remove_operator() {
  sereal_count = new Number(sereal_count - 1);
  var addformula = $(".updateoperator").length;
  if (addformula > 0)
  {
    $("#updateoperator" + addformula).remove();
  }
  if (addformula == 1)
  {
    $(".remove_operator").hide();
  }
  
  var i = 1;
  $( ".formula_field" ).each(function() {
  $( this ).attr('my-check', 'updatesereal'+i);
  i++;
  });

}

function update_popup_remove_takeoff() {
  sereal_count = new Number(sereal_count - 1);
  var addformula = $(".updatetakeOffData").length;
  if (addformula > 0)
  {
    $("#updatetakeOffData" + addformula).remove();
  }
  if (addformula == 1)
  {
    $(".remove_takeoff").hide();
  }
  $(".bootstrap-select").removeClass("formula_field").removeAttr("my-check");
  var i = 1;
  $( ".formula_field" ).each(function() {
  $( this ).attr('my-check', 'updatesereal'+i);
  i++;
  });

}

function update_popup_remove_number() {
  sereal_count = new Number(sereal_count - 1);
  var addformula = $(".updatenumber").length;
  if (addformula > 0)
  {
    $("#updatenumber" + addformula).remove();
  }
  if (addformula == 1)
  {
    $(".remove_number").hide();
  }
  
  var i = 1;
  $( ".formula_field" ).each(function() {
  $( this ).attr('my-check', 'updatesereal'+i);
  i++;
  });

}

function GetUpdateFormula() {
  if (sereal_count == 0) {
    $(".formula-error").show();
    return false;
  }
  $(".formula-error").hide();
  $(".formula-created").show();
  $('#updateformulainput').text('');
  $('#updateformula').text('');
  $('#updateformulatext').text('');
  var partid = $('#updatemodelnumber').val();
  var formula = $(".updateoperator").length;
        // alert(formula);
        var formula_2 = $(".updatetakeOffData").length;
        
        var formula_3 = $(".updatenumber").length;
        
        var total_inputs = (formula + formula_2 + formula_3 );
        var k = 1;
        var i=0;
        var my_formula = '';
        var my_formula_values = '';
        var my_formula_text = '';
        var selected_ids = new Array();
        var todid = 0;

        for (k; k <= total_inputs; k++) {
          var current_selector = '[my-check="updatesereal'+k+'"]';
          if ($(current_selector).attr('name') == 'takeoffdata') {
           var current_value = "|"+$(current_selector).val();
         }
         else{
          var current_value = $(current_selector).val();
        }

        if ($(current_selector).attr('name') == 'operator') {
          var current_formula_value = $(current_selector).val();
        }
        else if ($(current_selector).attr('name') == 'takeoffdata') {
          var current_formula_value = $(current_selector).find("option:selected").attr("title");
          selected_ids[i]= $(current_selector).find("option:selected").val();
          var tod_id = $(current_selector).find("option:selected").attr("tod_id");
          todid = todid+",'"+tod_id+"'";
          i++;
        }
        else {
          var current_formula_value = $(current_selector).val();

        }
        if ($(current_selector).attr('name') == 'operator') {
          var current_formula_text = $(current_selector).find("option:selected").val();
        }
        else if ($(current_selector).attr('name') == 'takeoffdata_number') {
          var current_formula_text = $(current_selector).val();
        }
        else{
         var current_formula_text = $(current_selector).find("option:selected").text();
       }
       my_formula_text+= current_formula_text;
       my_formula_values+= current_formula_value;
            my_formula+= current_value;
            my_formula+= ',';
          }
          /*if (formula == 0) {

            $('#formula' + partid).val($('#takeoffdata').find("option:selected").attr("title"));

          }
          else {*/
            $("#updateformulainput").append(my_formula);
            $("#updateformula").append(my_formula_values);
            $("#updateformulatext").append("Formula : "+my_formula_text);
			$(".existing_formula").hide();
            
            $('#formula' + partid).val($('#updateformulainput').text());

            // $('#formulaqty' + partid).val($('#formulavalue').text());
            $('#formulaqty' + partid).val($('#updateformulainput').text());
            $('#formulatext' + partid).val($('#updateformulatext').text());
			var is_rounded = 0;
			if($('#is_rounded_update').prop("checked") == true){
				is_rounded = 1;
			}
			$('#is_rounded' + partid).val(is_rounded);
            $('#my_id' + partid).html($('#updateformulatext').text());
            var rowNo = partid.split("_");
            $('.calculatedFormula'+rowNo[2]).removeAttr("data-container");
            $('.calculatedFormula'+rowNo[2]).removeAttr("data-toggle");
            $('.calculatedFormula'+rowNo[2]).removeAttr("data-original-title");
            $('.calculatedFormula'+rowNo[2]).attr("data-container", "body");
            $('.calculatedFormula'+rowNo[2]).attr("data-toggle", "tooltip");
            $('.calculatedFormula'+rowNo[2]).attr("data-original-title", $('#updateformulatext').text());
            $('[data-toggle="tooltip"]').tooltip();
          //}
    }
    
    
    function gettemplates(supplier_id){
            $.ajax({
            url: base_url+'setup/getsupplierztemplates/',
            type: 'post',
            data: {supplier_id: supplier_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $(".templates_container").html(result);
                $('#dataTableTemplates').dataTable( {
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
        
    function select_template(template_id, supplier_id){
            $("#template_id").val(template_id);
            $("#to_supplier_id").val(supplier_id);
    }
    
    $("#TemplateDownloadForm").submit(function(e){
        e.preventDefault();
        var form = this;
        if($("#TemplateDownloadForm").valid()){
            var selectedTemplates = [];
            $('.selectTemplate').each(function(index) {
                selectedTemplates.push($(this).val());
            });
            $.ajax({
                url: base_url+"setup/checkSelectedTemplates",
                type: 'post',
                data: {selectedTemplates: selectedTemplates},
                beforeSend: function() {
                  $('.loader').show();
                },
                success: function (result) {
                    $('.loader').hide();
                        if(result == "success"){
                             form.submit();
                        }
                        else{
                            swal({
                                title: 'Duplicate Template(s) Found!',
                                text: "Template "+result+" already exists. If you continue download your existing template will be overwritten. Do you wish to proceed? Yes/No.",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No',
                                buttonsStyling: false,
                                closeOnConfirm: true
                                }).then(function() {
                                  form.submit();
                              });
                        }
                    }
        });
        }
        
    });
    
    $('body').on('click', '#selectAll', function () {
        if($(this).prop("checked") == true){
            $(".selectTemplate").prop("checked", true);
        }
        else{
            $(".selectTemplate").prop("checked", false);
        }
         
    });
    
$(document).on('click','.add-takeoffdata-btn',function(){
    
    if($("#TakeoffdataForm").valid()){
    var data = $("#TakeoffdataForm").serialize();
    
    $.ajax({
        type:'POST',
        url:base_url+'setup/add_new_takeoffdata_shortcut_process',
        data: data,
        success:function(result){
            if(result.status == 'success'){
                 $('#takeoffdata0').html(result.data);
                 var takeoffdataCount = $("#addformulavalue .addtakeOffData").length;
                 if(takeoffdataCount){
                     for(i=1;i<=takeoffdataCount;i++){
                        var currentVal = $('#takeoffdata'+i).val();
                        $('#takeoffdata'+i).html(result.data);
                        $('#takeoffdata'+i).val(currentVal);
                     }
                 }
                 $('.selectpicker').selectpicker('refresh');
                 $("#TakeoffdataForm")[0].reset();
                 swal({
                           title: 'Added',
                           text: 'New Take Off Data Successfully Added!',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
            }
            else{
                swal({
                    title: 'Error!',
                    text: result.message,
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                });
            }
        }
    }); 
    
    }
    else{
        $("#TakeoffdataForm").validate();
    }
});

$(document).on('click','.add-takeoffdataBtn',function(){
    
    if($("#updateTakeoffdataForm").valid()){
    var data = $("#updateTakeoffdataForm").serialize();
    
    $.ajax({
        type:'POST',
        url:base_url+'setup/add_new_takeoffdata_shortcut_process',
        data: data,
        success:function(result){
            if(result.status == 'success'){
                 $('#takeoffdata0').html(result.data);
                 var updateTakeOffDataCount = $(".updatetakeOffData").length;
                 if(updateTakeOffDataCount){
                     for(i=1;i<=updateTakeOffDataCount;i++){
                        var currentVal = $('#takeoffdata'+i).val();
                        $('#takeoffdata'+i).html(result.data);
                        $('#takeoffdata'+i).val(currentVal);
                     }
                 }
                 $('.selectpicker').selectpicker('refresh');
                 $("#updateTakeoffdataForm")[0].reset();
                 swal({
                           title: 'Added',
                           text: 'New Take Off Data Successfully Added!',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        });
            }
            else{
                swal({
                    title: 'Error!',
                    text: result.message,
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                });
            }
        }
    }); 
    
    }
    else{
        $("#updateTakeoffdataForm").validate();
    }
});

function testFormula(mode) {
            if($("#testFormulaForm"+mode).valid()){
                var formula = computedFormula;
                if(formula!=""){
                    var n = 0;
                    var number = 0;
                    var newf = formula.replace(/,/g, '');
                    var pattern = /[0-9]+/g;
                    var matches = newf.match(pattern);
        			var d3 = formula;
                    for(var i=0;i<matches.length;i++){
        				var d2 = parseFloat($("#takeOffData"+mode+(matches[i])).val());
        				d3 = d3.replace("|"+matches[i]+",", d2);
        			}
        			d3 = d3.replace(/,/g, '');
                    number = nerdamer(d3).evaluate();
                    
        			if (isNaN(number)) {
                        number = 0;
                    }
                    var is_rounded = $("#is_rounded").val();
            
            
                    if(isFloat(number)){
        				if(is_rounded==1){
        				     $("#computedFormula"+mode).text(Math.ceil(number));
        				}
        				else{
        				     $("#computedFormula"+mode).text(parseFloat(number).toFixed(2));
        				}
            		}
                    else{
                            if(is_rounded==1){
            				   $("#computedFormula"+mode).text(Math.ceil(eval(number.toString())));
                            }
                            else{
                                $("#computedFormula"+mode).text(parseFloat(eval(number.toString())).toFixed(2));
                            }
            	    }
                }
        }
        else{
            $("#testFormulaForm"+mode).validate();
        }
    }
    
    function isFloat(n){
       return Number(n) === n && n % 1 !== 0;
    }
    
    var computedFormula = "";
    
    $('body').on('click','#testFormulaTab',function(){
        var mode = $(this).attr("mode");
        if(mode == "Add"){
        var formula = $("#addformulavalue .addoperator").length;
        var formula_2 = $("#addformulavalue .addtakeOffData").length;
        var formula_3 = $("#addformulavalue .addnumber").length;
        }
        else{
            var formula = $(".updateoperator").length;
            var formula_2 = $(".updatetakeOffData").length;
            var formula_3 = $(".updatenumber").length;
        
            var total_inputs = (formula + formula_2 + formula_3 );
        }
        
        var total_inputs = (formula + formula_2 + formula_3 );
        var k = 1;
        var my_formula_text = '';
        var my_formula_value = '';
        var takeoffdata_inputs = '';
		var selected_ids = new Array();
		var todid = 0;
        for (k; k <= total_inputs; k++) {
            var current_selector = (mode == "Add")?'[my-check="sereal'+k+'"]':'[my-check="updatesereal'+k+'"]';

            if ($(current_selector).attr('name') == 'operator') {
                var current_formula_value = $(current_selector).val()+",";
                var current_formula_text = $(current_selector).find("option:selected").val();
                var takeOffDataRow = "";
            }
            else if ($(current_selector).attr('name') == 'takeoffdata') {
                 var current_formula_value = "|"+$(current_selector).val()+",";
    			 var current_formula_text = $(current_selector).find("option:selected").text();
    			 var takeOffDataRow = '<tr tod_id="'+$(current_selector).val()+'"><td style="width:250px;">'+current_formula_text+'<strong class="text-danger"> *</strong></td><td><input class="form-control" type="text" name="takeOffData'+mode+$(current_selector).val()+'" id="takeOffData'+mode+$(current_selector).val()+'" placeholder ="Enter Value" value="" required> </td></tr>';
            }
            else {
                var current_formula_value = $(current_selector).val()+",";
                var current_formula_text = $(current_selector).val();
                var takeOffDataRow = "";
				 
            }
            
            my_formula_text+= current_formula_text;
            my_formula_value+= current_formula_value;
            takeoffdata_inputs+=takeOffDataRow;
        }
    
        computedFormula = my_formula_value;
        
        
        $("#computedFormula"+mode).html('<font color="red">No Results Found!</font>');
            
        if(my_formula_text == ""){
            $("#computedFormulaText"+mode).text("");
            $('#testFormulaForm'+mode+' tr:not(:last)').remove();
            $("#testFormulaForm"+mode+" .actionRow").hide();
        }
        else{
            $("#computedFormulaText"+mode).text("").append("Formula : "+my_formula_text);
            $('#testFormulaForm'+mode+' tr:not(:last)').remove();
            $("#testFormulaForm"+mode+" .actionRow").before(takeoffdata_inputs);
            $("#testFormulaForm"+mode+" .actionRow").show();
        }
    });