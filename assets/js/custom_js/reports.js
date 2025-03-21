$.validator.addMethod('uniqueTrackingReport', function(value) {
			
         var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'reports/verify_tracking_report',
                type: 'post',
			    data:{title: value},
	}); 

    if(result.responseText == '0') return true; else return false;
    
} , "Please enter a unique tracking report name");

$.validator.addMethod('uniqueEditTrackingReport', function(value) {
	    var id = $('#tracking_report_id').val();		
        var result = $.ajax({ 
                              
			    async:false, 
                url:base_url + 'reports/verify_tracking_report',
                type: 'post',
			    data:{title: value, id:id},
	  }); 

         if(result.responseText == '0') return true; else return false;

             } , "Please enter a unique tracking report name");

$(document).ready(function() {
    setFormValidation('#reportForm');
     setFormValidation('#trackingForm');
 });
 
 function addCommas(nStr){
 nStr += '';
 var x = nStr.split('.');
 var x1 = x[0];
 var x2 = x.length > 1 ? '.' + x[1] : '';
 var rgx = /(\d+)(\d{3})/;
 while (rgx.test(x1)) {
  x1 = x1.replace(rgx, '$1' + ',' + '$2');
 }
 return x1 + x2;
}

$('#project_id').change( function(){
        
        $('.update_bank_interest').hide();
		$('.report_btn').hide();
		var project_id = $('#project_id').val();
		     $.ajax({
            url: base_url+"reports/get_report_by_project_id", 
            type:'post', 
            data:{project_id:this.value}, 
            beforeSend: function() {
              $('.loader').show();
            },
            success: function(str){
                $('.loader').hide();
                $('.update_bank_interest').show();
                $('.variation_btn_container').show();
                $('.cash_transfers_btn_container').show();
                $('.sales_invoices_btn_container').show();
                $('.sales_credits_btn_container').show();
                $('.supplier_invoices_btn_container').show();
                $('.supplier_credits_btn_container').show();
            var obj = jQuery.parseJSON(str);
            var total = obj.tcegst+(obj.tcegst*(100+parseFloat(obj.costing_tax))/100)+obj.tcegst;
			var tcigst = (obj.tcegst)+(obj.tcegst*(100+parseFloat(obj.costing_tax))/100);
            
            $('#total_cost').text(addCommas(obj.total_cost));
            $('#overhead_margin').val(obj.overhead_margin);
            $('#profit_margin').val(obj.profit_margin);
            $('#total_cost2').text(addCommas(obj.total_cost2));
            $('#costing_tax').val(obj.costing_tax);
            $('#total_cost3').text(addCommas(obj.total_cost3));
            $('#price_rounding').val(obj.price_rounding);
            $('#contract_price').text(addCommas(obj.contract_price));
			var profit1 = $("#total_cost2").text().split(',').join('')-$('#total_cost').text().split(',').join('');
                        //alert(profit1);
		    //var tax1 = 100+parseFloat(($('#costing_tax').val())/100);
                    var tax1 = parseFloat(($('#costing_tax').val())/100);
                    
		    //var total_profit = profit1 + (profit1*tax1);
		    
		    //New Formula
		    var total_profit = parseFloat($("#contract_price").text().split(',').join(''))-parseFloat($("#total_cost").text().split(',').join('')*((100+parseFloat(obj.costing_tax))/100));
            $('#projectedprofit').text(addCommas(total_profit.toFixed(2)));
            
            $('#extracostvare').text(addCommas(obj.extracostvare));
            $('#extracostvari').text(addCommas((obj.extracostvare*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            $('#extrasalevar').text(addCommas(parseFloat(obj.extrasalevar).toFixed(2)));
            $('#proextrasalevar').text(addCommas((obj.extrasalevar-parseFloat($('#extracostvari').text().split(',').join(''))).toFixed(2)));
            $('#extracostpovare').text(addCommas(parseFloat(obj.extracostpovare).toFixed(2)));
            $('#extracostpovari').text(addCommas((parseFloat(obj.extracostpovare)*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            $('#extrasalepovar').text(addCommas(parseFloat(obj.extrasalepovar).toFixed(2)));
            $('#proextrasalepovar').text(addCommas((obj.extrasalepovar-parseFloat($('#extracostpovari').text().split(',').join(''))).toFixed(2)));
            $('#extracostsivare').text(addCommas(parseFloat(obj.extracostsivare).toFixed(2)));
            $('#extracostsivari').text(addCommas((obj.extracostsivare*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            $('#extrasalesivar').text(addCommas(parseFloat(obj.extrasalesivar).toFixed(2)));
            $('#proextrasalesivar').text(addCommas((obj.extrasalesivar-parseFloat($('#extracostsivari').text().split(',').join(''))).toFixed(2)));
            
            $('#extracostscvare').text(addCommas(parseFloat(obj.extracostscvare).toFixed(2)));
            $('#extracostscvari').text(addCommas((obj.extracostscvare*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            $('#sipaidbysc').text(addCommas((obj.extracostscvare*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            $('#extrasalescvar').text(addCommas(parseFloat(obj.extrasalescvar).toFixed(2)));
            $('#proextrasalescvar').text(addCommas((obj.extrasalescvar-parseFloat($('#extracostscvari').text().split(',').join(''))).toFixed(2)));
            
            $('#extracostallowe').text(addCommas(parseFloat(obj.extracostallowe).toFixed(2)));
            $('#extracostallowi').text(addCommas((obj.extracostallowe*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            //$('#extrasalesallow').text(addCommas(parseFloat(obj.extrasaleallow).toFixed(2)));
            $('#extrasalesallow').text(addCommas(parseFloat($('#extracostallowi').text().split(',').join('')).toFixed(2)));
            $('#proextrasaleallow').text(addCommas(((parseFloat($('#extrasalesallow').text().split(',').join('')))-(parseFloat($('#extracostallowi').text().split(',').join('')))).toFixed(2)));
            
            $('#suppliercreditscreated').text(addCommas(parseFloat(((parseFloat(obj.total_credit_notes)*(parseFloat(obj.costing_tax))/100))+(parseFloat(obj.total_credit_notes))).toFixed(2)));
           
           
            //New Changings
            /*var updated_project_cost = (parseFloat(($("#total_cost").text().split(',').join('')*((100+parseFloat(obj.costing_tax))/100)))+parseFloat($('#extracostvari').text().split(',').join(''))+parseFloat($('#extracostpovari').text().split(',').join(''))+parseFloat($("#extracostsivari").text().split(',').join(''))+parseFloat($("#extracostallowi").text().split(',').join('')))-parseFloat($('#suppliercreditscreated').text().split(',').join(''));
            $('#updatepcostigst').text(addCommas(parseFloat(updated_project_cost).toFixed(2)));*/
            
            var updated_project_cost = (parseFloat(($("#total_cost").text().split(',').join('')*((100+parseFloat(obj.costing_tax))/100)))+parseFloat($('#extracostvari').text().split(',').join(''))+parseFloat($('#extracostpovari').text().split(',').join(''))+parseFloat($("#extracostsivari").text().split(',').join(''))+parseFloat($("#extracostallowi").text().split(',').join('')))-(parseFloat($("#extracostscvari").text().split(',').join('')));
            $('#updatepcostigst').text(addCommas(parseFloat(updated_project_cost).toFixed(2)));
           
            var updated_project_contract_price = parseFloat($("#contract_price").text().split(',').join(''))+parseFloat($('#extrasalevar').text().split(',').join(''))+parseFloat($('#extrasalepovar').text().split(',').join(''))+parseFloat($("#extrasalesivar").text().split(',').join(''))+parseFloat($("#extrasalesallow").text().split(',').join(''))+parseFloat($("#extrasalescvar").text().split(',').join(''));
        
            $('#updatepcpigst').text(addCommas(parseFloat(updated_project_contract_price).toFixed(2)));
            
             
            //$('#updateproigst').text(addCommas((+parseFloat($('#projectedprofit').text().split(',').join(''))+parseFloat($('#proextrasalevar').text().split(',').join(''))+parseFloat($('#proextrasalepovar').text().split(',').join(''))+parseFloat($('#proextrasalesivar').text().split(',').join(''))+parseFloat($('#proextrasaleallow').text().split(',').join(''))).toFixed(2)));
            $('#updateproigst').text(addCommas((parseFloat(updated_project_contract_price)-parseFloat(updated_project_cost)).toFixed(2)));
           
            $('#prodiff').text(addCommas((parseFloat($('#updateproigst').text().split(',').join(''))-parseFloat($('#projectedprofit').text().split(',').join(''))).toFixed(2)));
            $('#cash_transfers').text(addCommas(parseFloat(obj.totalcashtransfers).toFixed(2)));
            $('#supplierinvoicecreated').text(addCommas((obj.totalsupplierinvoicecreated*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            $('#salesinvoicecreated').text(addCommas(parseFloat(obj.totalsalesinvoicecreated).toFixed(2)));
            
            $('#salescreditcreated').text(addCommas(parseFloat(obj.totalsalescredits).toFixed(2)));
            
            $('#sipaid').text(addCommas((obj.totalsupplierinvoicepaid*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            //$('#sipaid').text(parseFloat(obj.totalsupplierinvoicepaid).toFixed(2));
            $('#salesinpaid').text(addCommas(parseFloat(obj.totalsalesinvoicepaid).toFixed(2)));
            
            var salesinunpaid = parseFloat($('#salesinvoicecreated').text().split(',').join(''))-parseFloat($('#salescreditcreated').text().split(',').join(''))-parseFloat($('#salesinpaid').text().split(',').join(''));
            $('#salesinunpaid').text(addCommas(parseFloat(salesinunpaid).toFixed(2)));
            
            var futuresalesin = parseFloat($('#updatepcpigst').text().split(',').join(''))-parseFloat($('#salesinpaid').text().split(',').join(''));
            $('#futuresalesin').text(addCommas(parseFloat(futuresalesin).toFixed(2)));

            var bankinterest = parseFloat(obj.totalbankinterest);
            $("#bankinterest").val(addCommas(bankinterest));
            //$('#ci_total').text(parseFloat(((parseFloat(obj.total_credit_invoices)*(parseFloat(obj.costing_tax))/100))+(parseFloat(obj.total_credit_invoices))).toFixed(2));
    
            //var supplierinvoiceunpaid = parseFloat($('#supplierinvoicecreated').text().split(',').join(''))-parseFloat($('#suppliercreditscreated').text().split(',').join(''))-parseFloat($('#sipaid').text().split(',').join(''));
           var supplierinvoiceunpaid = parseFloat($('#supplierinvoicecreated').text().split(',').join(''))-parseFloat($('#sipaid').text().split(',').join(''))-parseFloat($('#sipaidbysc').text().split(',').join(''));
           
            $("#supplierinvoiceunpaid").text(addCommas(parseFloat(supplierinvoiceunpaid).toFixed(2)));
           
           
            var futuresupplierinvoices = (parseFloat($('#updatepcostigst').text().split(',').join(''))-(parseFloat($('#supplierinvoicecreated').text().split(',').join('')))-parseFloat($('#suppliercreditscreated').text().split(',').join('')));
             
            $('#futuresupplierinvoices').text(addCommas(parseFloat(futuresupplierinvoices).toFixed(2)));
            
            var bankbalance = parseFloat((($('#salesinpaid').text().split(',').join('')-$('#sipaid').text().split(',').join('')-$('#cash_transfers').text().split(',').join(''))+parseFloat($('#suppliercreditscreated').text().split(',').join('')))+bankinterest).toFixed(2);
           
            $('#bankbalance').text(addCommas(bankbalance));
            
            var future_cash_required = parseFloat($('#supplierinvoiceunpaid').text().split(',').join(''))+parseFloat($('#futuresupplierinvoices').text().split(',').join(''));
            $('#future_cash_required').text(addCommas(parseFloat(future_cash_required).toFixed(2)));
            
            var future_cash_available = parseFloat($('#salesinunpaid').text().split(',').join(''))+parseFloat($('#futuresalesin').text().split(',').join(''))+parseFloat($('#bankbalance').text().split(',').join(''));
            $('#future_cash_available').text(addCommas(parseFloat(future_cash_available).toFixed(2)));
            
            var projected_final_cash = parseFloat($('#future_cash_available').text().split(',').join(''))-parseFloat($('#future_cash_required').text().split(',').join(''));
            $('#projected_final_cash').text(addCommas(parseFloat(projected_final_cash).toFixed(2)));
           
            $('#report').show();
			if($('#project_id').val()!=""){
			 $('.report_btn').show();
			}
			else{
				$('.report_btn').hide();
			}
                
            }
            });
    });
    
$('body').on('blur', '.cal-on-change', function () {

        calcuate_costing_totals();

    });
    
$('body').on('blur', '.cal-on-changebi', function () {


        var bi=parseFloat($(this).val());
        var bankbalance = parseFloat((($('#salesinpaid').text().split(',').join('')-$('#sipaid').text().split(',').join('')-$('#cash_transfers').text().split(',').join(''))+parseFloat($('#suppliercreditscreated').text().split(',').join('')))+bi).toFixed(2);
           
        $('#bankbalance').text(addCommas(bankbalance));
        
        var future_cash_required = parseFloat($('#supplierinvoiceunpaid').text().split(',').join(''))+parseFloat($('#futuresupplierinvoices').text().split(',').join(''));
            $('#future_cash_required').text(addCommas(parseFloat(future_cash_required).toFixed(2)));
            
            var future_cash_available = parseFloat($('#salesinunpaid').text().split(',').join(''))+parseFloat($('#futuresalesin').text().split(',').join(''))+parseFloat($('#bankbalance').text().split(',').join(''));
            $('#future_cash_available').text(addCommas(parseFloat(future_cash_available).toFixed(2)));
            
            var projected_final_cash = parseFloat($('#future_cash_available').text().split(',').join(''))-parseFloat($('#future_cash_required').text().split(',').join(''));
            $('#projected_final_cash').text(addCommas(parseFloat(projected_final_cash).toFixed(2)));

    });
    
function calcuate_costing_totals() {
        
        var psubtotal1 = $("#total_cost").text().split(',').join('');
        var oh_margin = isNaN($("#overhead_margin").val()) ? 0 : $("#overhead_margin").val();
        var p_margin = isNaN($("#profit_margin").val()) ? 0 : $("#profit_margin").val();
        var c_tax = isNaN($("#costing_tax").val()) ? 0 : $("#costing_tax").val();
        var psubtotal2 = isNaN($("#total_cost2").text().split(',').join('')) ? 0 : $("#total_cost2").text().split(',').join('');
        var psubtotal3 = isNaN($("#total_cost3").text()) ? 0 : $("#total_cost3").text().split(',').join('');
        var price_rounding = isNaN($("#price_rounding").val()) ? 0 : parseFloat($("#price_rounding").val());


        var opercent = (parseFloat(oh_margin) / 100) * parseFloat(psubtotal1);
        var ppercent = (parseFloat(p_margin) / 100) * parseFloat(psubtotal1);
        var s2 = opercent + ppercent + parseFloat(psubtotal1);
        $("#total_cost2").text(s2.toFixed(2));

        var tax_percent = (parseFloat(c_tax) / 100) * s2;
        var s3 = tax_percent + parseFloat(s2);
        $("#total_cost3").text(s3.toFixed(2));

        var s4 = price_rounding + s3;

        $("#contract_price").text(s4.toFixed(2));
        $('#tcigst').text((parseFloat($('#tcegst').text().split(',').join(''))*(100+parseFloat(c_tax))/100).toFixed(2));
        $('#extracostvari').text((parseFloat($('#extracostvare').text().split(',').join(''))*(100+parseFloat(c_tax))/100).toFixed(2));
        $('#extracostpovari').text((parseFloat($('#extracostpovare').text().split(',').join(''))*(100+parseFloat(c_tax))/100).toFixed(2));       
        $('#extracostsivari').text((parseFloat($('#extracostsivare').text().split(',').join(''))*(100+parseFloat(c_tax))/100).toFixed(2));
        var profit1 = $("#total_cost2").text().split(',').join('')-$('#total_cost').text().split(',').join('');
		var tax1 = 100+parseFloat(($('#costing_tax').val())/100);
		var total_profit = profit1 + (profit1*tax1);
        $('#projectedprofit').text(total_profit.toFixed(2));
        //$('#projectedprofit').text((parseFloat($("#contract_price").text())-parseFloat($('#tcigst').text())).toFixed(2));
        //$('#updateproigst').text((parseFloat($('#projectedprofit').text().split(',').join(''))+parseFloat($('#proextrasalevar').text().split(',').join(''))+parseFloat($('#proextrasalepovar').text().split(',').join(''))+parseFloat($('#proextrasalesivar').text().split(',').join(''))+parseFloat($('#suppliercreditscreated').text().split(',').join(''))).toFixed(2));
        
		var updated_project_cost = (parseFloat(($("#total_cost").text().split(',').join('')*((100+parseFloat(obj.costing_tax))/100)))+parseFloat($('#extracostvari').text().split(',').join(''))+parseFloat($('#extracostpovari').text().split(',').join(''))+parseFloat($("#extracostsivari").text().split(',').join(''))+parseFloat($("#extracostallowi").text().split(',').join('')))-(parseFloat($("#extracostscvari").text().split(',').join('')));
        $('#updatepcostigst').text(addCommas(parseFloat(updated_project_cost).toFixed(2)));
           
        var updated_project_contract_price = (parseFloat($("#contract_price").text().split(',').join(''))+parseFloat($('#extrasalevar').text().split(',').join(''))+parseFloat($('#extrasalepovar').text().split(',').join(''))+parseFloat($("#extrasalesivar").text().split(',').join(''))+parseFloat($("#extrasalesallow").text().split(',').join('')))-parseFloat($("#extrasalescvar").text().split(',').join(''));
        
        $('#updatepcpigst').text(addCommas(parseFloat(updated_project_contract_price).toFixed(2)));
            
             
            //$('#updateproigst').text(addCommas((+parseFloat($('#projectedprofit').text().split(',').join(''))+parseFloat($('#proextrasalevar').text().split(',').join(''))+parseFloat($('#proextrasalepovar').text().split(',').join(''))+parseFloat($('#proextrasalesivar').text().split(',').join(''))+parseFloat($('#proextrasaleallow').text().split(',').join(''))).toFixed(2)));
        $('#updateproigst').text(addCommas((parseFloat(updated_project_contract_price)-parseFloat(updated_project_cost)).toFixed(2)));
           
		   
		$('#prodiff').text((parseFloat($('#updateproigst').text().split(',').join(''))-parseFloat($('#projectedprofit').text().split(',').join(''))).toFixed(2));         
	}
    
function get_variations(type){
        var project_id = $('#project_id').val();
        if(!($("#"+type+"_variations").hasClass('in'))){
            $.ajax({
            url: base_url+"reports/get_variations", 
            type:'post', 
            data:'project_id='+project_id+'&type='+type, 
            beforeSend: function() {
              $('.loader').show();
            },
            success: function(result){
                 $('.loader').hide();
                 $("#"+type+"_variations").html(result);
                 if(type=="normal"){
                    $('#partstable').dataTable( {
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
                 else if(type=="suppinvo"){
                    $('#partstable2').dataTable( {
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
                 else if(type=="supcredit"){
                    $('#partstable4').dataTable( {
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
                 else{
                    $('#partstable3').dataTable( {
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
            }
            });
        }
    }
    
function get_cash_transfers(){
        var project_id = $('#project_id').val();
            $.ajax({
                url: base_url+"reports/get_cash_transfers", 
                type:'post', 
                data:'project_id='+project_id, 
                beforeSend: function() {
                  $('.loader').show();
                },
                success: function(result){
                    
                    $('.loader').hide();
                    $("#cash_transfers_list").html(result);
                    $('#cash_transfers_table').dataTable({
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
    
function get_sales_invoices(){
        var project_id = $('#project_id').val();
            $.ajax({
            url: base_url+"reports/get_sales_invoices", 
            type:'post', 
            data:'project_id='+project_id, 
            beforeSend: function() {
              $('.loader').show();
            },
            success: function(result){
                
                $('.loader').hide();
                $("#sales_invoices_list").html(result);
                $('#sales_invoices_table').dataTable( {
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
    
function get_sales_credits(){
        var project_id = $('#project_id').val();
        $.ajax({
            url: base_url+"reports/get_sales_credits", 
            type:'post', 
            data:'project_id='+project_id, 
            beforeSend: function() {
              $('.loader').show();
            },
            success: function(result){
                
                $('.loader').hide();
                $("#sales_credits_list").html(result);
                $('#sales_credits_table').dataTable( {
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
    
function get_supplier_invoices(type=""){
        var project_id = $('#project_id').val();
            if(type=="allowance"){
                var methodName = "get_allowance_invoices";
            }
            else{
                methodName = "get_credit_invoices";
            }
            $.ajax({
            url: base_url+"reports/"+methodName, 
            type:'post', 
            data:'project_id='+project_id+'&type='+type, 
            beforeSend: function() {
              $('.loader').show();
            },
            success: function(result){
                
                $('.loader').hide();
                if(type==""){
                $("#supplier_invoices_list").html(result);
                $('#credit_invoices_table').dataTable( {
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
                else{
                    $("#allowance_invoices_list").html(result);
                    $('#allowance_invoices_table').dataTable( {
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
                
            }
            });
    }
    
function get_supplier_credits(){
        var project_id = $('#project_id').val();
            $.ajax({
            url: base_url+"reports/get_credit_notes", 
            type:'post', 
            data:'project_id='+project_id, 
            beforeSend: function() {
              $('.loader').show();
            },
            success: function(result){
                
                $('.loader').hide();
                $("#supplier_credits_list").html(result);
                $('#credit_notes_table').dataTable( {
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
    
$('#update_bank_interest').click( function(){
        if($("#reportForm").valid()){
    		var bank_interest = $('#bankinterest').val();
    		$('#bankinterest').val(parseFloat(bank_interest).toFixed(2));
    		var project_id = $('#project_id').val();
    		     $.ajax({
                url: base_url+"reports/update_bank_interest", 
                type:'post', 
                data:{project_id:project_id,bank_interest:bank_interest}, 
                beforeSend: function() {
                  $('.loader').show();
                },
                success: function(str){
                    $('.loader').hide();
                }
    		     });
        }
        else{
            $("#reportForm").validate();
        }
    });
$('#bankinterest').blur( function(){
		var bank_interest = $('#bankinterest').val();
		if(bank_interest!=""){
		$('#bankinterest').val(parseFloat(bank_interest).toFixed(2));
		}
		else{
		    $('#bankinterest').val("0.00");
		}
     });
     
function get_project_summary() {
        var project_id= $('#project_summary_project_id').val();
		var start_date= $('#invoice_start_date').val();
		var end_date= $('#invoice_end_date').val();
		if($("#reportForm").valid()){
        $.ajax({
            url: base_url+'reports/get_project_summary/',
            type: 'POST',
            data: {project_id: project_id,start_date:start_date,end_date:end_date},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.project_report_container').html(result);
            }
        });
		}
		else{
		    setFormValidation('#reportForm');
		}

    }
$('.project_summary_filters').click( function(){
      get_project_summary();
}); 



$('.work_in_progress_filters').click( function(){
		var project_id = $('#work_inprogress_project_id').val();
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		
		if($("#reportForm").valid()){
		     $.ajax({
            url: base_url+"reports/getworkinprogressbyprj_id", 
            type:'post', 
            data:{project_id:project_id,start_date:start_date,end_date:end_date}, 
            beforeSend: function() {
              $('.loader').show();
            },
            success: function(str){
            $('.loader').hide();
            $(".reportBtn").show();
            var obj = jQuery.parseJSON(str);
            var total = obj.tcegst+(obj.tcegst*(100+parseFloat(obj.costing_tax))/100)+obj.tcegst;
			var tcigst = (obj.tcegst)+(obj.tcegst*(100+parseFloat(obj.costing_tax))/100);
            
            //Updated Project Budget Including GST
            var total_cost = parseFloat(obj.total_cost*((100+parseFloat(obj.costing_tax))/100));
            var extra_cost_var = (parseFloat(obj.extracostvare)*(100+parseFloat(obj.costing_tax))/100).toFixed(2);
            var extra_cost_po = parseFloat(parseFloat(obj.extracostpovare)*(100+parseFloat(obj.costing_tax))/100).toFixed(2);
            var extra_cost_si = parseFloat(obj.extracostsivare*(100+parseFloat(obj.costing_tax))/100).toFixed(2);
            var extra_cost_allowance= parseFloat(obj.extracostallowe*(100+parseFloat(obj.costing_tax))/100).toFixed(2);
            var extracostscvari = parseFloat(obj.extracostscvare*(100+parseFloat(obj.costing_tax))/100).toFixed(2);
            var total_supplier_credits = parseFloat(((parseFloat(obj.total_credit_notes)*(parseFloat(obj.costing_tax))/100))+(parseFloat(obj.total_credit_notes))).toFixed(2);
            var updated_project_cost = (parseFloat(total_cost)+parseFloat(extra_cost_var)+parseFloat(extra_cost_po)+parseFloat(extra_cost_si)+parseFloat(extra_cost_allowance))-parseFloat(extracostscvari);
            
            $('#updatepcostigst').text(addCommas(parseFloat(updated_project_cost).toFixed(2)));
            
            //Updated Project Contract 
            var contract_price = obj.contract_price;
            var extra_sale_var = parseFloat(obj.extrasalevar).toFixed(2);
            var extra_sale_po = parseFloat(obj.extrasalepovar).toFixed(2);
            var extra_sale_si = parseFloat(obj.extrasalesivar).toFixed(2);
            var extra_sale_allowance = parseFloat(obj.extrasaleallow).toFixed(2);
            var extrasalescvar = parseFloat(obj.extrasalescvar).toFixed(2);
            var updated_project_contract_price = (parseFloat(contract_price)+parseFloat(extra_sale_var)+parseFloat(extra_sale_po)+parseFloat(extra_sale_si)+parseFloat(extra_cost_allowance))-parseFloat(extrasalescvar);
        
            $('#updatepcpigst').text(addCommas(parseFloat(updated_project_contract_price).toFixed(2)));
            
            //Projected Profit
            var total_profit = parseFloat($('#updatepcpigst').text().split(',').join(''))-parseFloat($('#updatepcostigst').text().split(',').join(''));
            $('#projectedprofit').text(addCommas(total_profit.toFixed(2)));
            
            //contigency_value_including_gst
            var contigency_of_contract_budget = $("#contigency_of_contract_budget").val();
            if(contigency_of_contract_budget==""){
                contigency_of_contract_budget = 0;
            }
            var contigency_value_including_gst = parseFloat(updated_project_cost)*(parseFloat(contigency_of_contract_budget)/100);
            $('#contigency_value_including_gst').text(addCommas(parseFloat(contigency_value_including_gst).toFixed(2)));
            
            var projected_profit_after_contigency = parseFloat(total_profit) - parseFloat(contigency_value_including_gst);
            $("#projected_profit_after_contigency").text(addCommas(parseFloat(projected_profit_after_contigency).toFixed(2)));
            
            $('#supplierinvoicecreated').text(addCommas((obj.totalsupplierinvoicecreated*(100+parseFloat(obj.costing_tax))/100).toFixed(2)));
            $('#salesinvoicecreated').text(addCommas(parseFloat(obj.totalsalesinvoicecreated).toFixed(2)));
            
            var job_completion_progress = ((parseFloat(obj.totalsalesinvoicecreated).toFixed(2))/parseFloat(updated_project_contract_price))*100;
            $("#job_completion_progress").text(parseFloat(job_completion_progress).toFixed(2));
            
            var upd_cont_bud_inc_con_gst = parseFloat(updated_project_cost)+parseFloat(contigency_value_including_gst);
            $("#upd_cont_bud_inc_con_gst").text(addCommas(parseFloat(upd_cont_bud_inc_con_gst).toFixed(2)));
            var supplier_invoices_based_on_per_completed = (parseFloat(parseFloat($('#job_completion_progress').text().split(',').join(''))/100))*(parseFloat($('#upd_cont_bud_inc_con_gst').text().split(',').join('')));
            $("#supplier_invoices_based_on_per_completed").text(addCommas(parseFloat(supplier_invoices_based_on_per_completed).toFixed(2)));
            
            var work_in_progress_value = parseFloat(supplier_invoices_based_on_per_completed)-parseFloat($('#supplierinvoicecreated').text().split(',').join(''));
            $("#work_in_progress_value").text(addCommas(parseFloat(work_in_progress_value).toFixed(2)));
            }
            });
		}
		else{
			setFormValidation('#reportForm');
		}
        
    });
    
$('body').on('blur', '.calculate-on-change', function () {


        calculate_costing_totals();

    });
    
function calculate_costing_totals() {

            //contigency_value_including_gst
            var contigency_of_contract_budget = $("#contigency_of_contract_budget").val();
            
            if(contigency_of_contract_budget==""){
                contigency_of_contract_budget = 0;
            }
            var contigency_value_including_gst = parseFloat($('#updatepcostigst').text().split(',').join(''))*(parseFloat(contigency_of_contract_budget)/100);
            $('#contigency_value_including_gst').text(addCommas(parseFloat(contigency_value_including_gst).toFixed(2)));
            
            var projected_profit_after_contigency = parseFloat($('#projectedprofit').text().split(',').join('')) - parseFloat(contigency_value_including_gst);
            $("#projected_profit_after_contigency").text(addCommas(parseFloat(projected_profit_after_contigency).toFixed(2)));
            
            var upd_cont_bud_inc_con_gst = parseFloat($('#updatepcostigst').text().split(',').join(''))+parseFloat(contigency_value_including_gst);
            $("#upd_cont_bud_inc_con_gst").text(addCommas(parseFloat(upd_cont_bud_inc_con_gst).toFixed(2)));
            /*var supplier_invoices_based_on_per_completed = (parseFloat($('#supplierinvoicecreated').text().split(',').join(''))*(parseFloat($('#job_completion_progress').text().split(',').join(''))/100));
            $("#supplier_invoices_based_on_per_completed").text(addCommas(parseFloat(supplier_invoices_based_on_per_completed).toFixed(2)));*/
            
             var supplier_invoices_based_on_per_completed = (parseFloat(parseFloat($('#job_completion_progress').text().split(',').join(''))/100))*(parseFloat($('#upd_cont_bud_inc_con_gst').text().split(',').join('')));
            $("#supplier_invoices_based_on_per_completed").text(addCommas(parseFloat(supplier_invoices_based_on_per_completed).toFixed(2)));
            
            var work_in_progress_value = parseFloat(supplier_invoices_based_on_per_completed)-parseFloat($('#supplierinvoicecreated').text().split(',').join(''));
            $("#work_in_progress_value").text(addCommas(parseFloat(work_in_progress_value).toFixed(2)));
    }
    
function get_project_budget_vs_actual_report() {
        var project_id= $('#budget_vs_actual_project_id').val();
        $('#report_project_id').val(project_id);
        $.ajax({
            url: base_url+'reports/get_project_budget_vs_actual_report/',
            type: 'POST',
            data: {project_id: project_id},
            beforeSend: function() {
              $('.loader').show();
          },
          success: function (result) {
            $('.loader').hide();
            $('.project_budget_vs_actual_report_container').html(result);
        }
    });

    }
    
function changeReportType(report_type, requestFrom){
      $('#report_type').val(report_type);
      if(requestFrom=="budget_vs_actual"){
        var project_id= $('#budget_vs_actual_project_id').val();
      }
      else if(requestFrom=="component_unordered_items"){
        var project_id= $('#component_unordered_items_project_id').val();
      }
      else if(requestFrom=="uninvoiced_components"){
         var project_id= $('#uninvoiced_components_project_id').val();
      }
      else if(requestFrom=="project_suppliers"){
         var project_id= $('#supplier_project_id').val();
      }
      else if(requestFrom=="project_transactions"){
         var project_id= $('#transactions_project_id').val();
      }
      else{
        var project_id= $('#unordered_items_project_id').val();
      }
      $('#report_project_id').val(project_id);
}

function get_project_unordered_items() {
        var project_id= $('#unordered_items_project_id').val();
		$('#report_project_id').val(project_id);
        $.ajax({
            url: base_url+'reports/get_project_unordered_items/',
            type: 'POST',
            data: {project_id: project_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.project_report_container').html(result);
            }
        });

}

function get_component_unordered_items() {
        var project_id= $('#component_unordered_items_project_id').val();
		$('#report_project_id').val(project_id);
        $.ajax({
            url: base_url+'reports/get_component_unordered_items/',
            type: 'POST',
            data: {project_id: project_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.project_report_container').html(result);
            }
        });

    }
    
function get_project_uninvoiced_items() {
        var project_id= $('#uninvoiced_components_project_id').val();
        $('#report_project_id').val(project_id);
        $.ajax({
            url: base_url+'reports/get_project_uninvoiced_components/',
            type: 'POST',
            data: {project_id: project_id},
            beforeSend: function() {
              $('.loader').show();
          },
          success: function (result) {
            $('.loader').hide();
            $('.project_report_container').html(result);
        }
    });

    }
    
function get_project_suppliers() {
        var project_id= $('#supplier_project_id').val();
		$('#report_project_id').val(project_id);
        $.ajax({
            url: base_url+'reports/get_project_suppliers/',
            type: 'POST',
            data: {project_id: project_id},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.project_report_container').html(result);
            }
        });

    }
    
function get_updated_project_costing() {
        var project_id= $('#costing_project_id').val();
        $('#report_project_id').val(project_id);
        $.ajax({
            url: base_url+'reports/get_updated_project_costing/',
            type: 'POST',
            data: {project_id: project_id},
            beforeSend: function() {
              $('.loader').show();
          },
          success: function (result) {
            $('.loader').hide();
            $('.project_report_container').html(result);
          }
        });

    }
    
function get_updated_specifications() {
        var project_id= $('#specification_project_id').val();
        $('#report_project_id').val(project_id);
        $.ajax({
            url: base_url+'reports/get_updated_specifications/',
            type: 'POST',
            data: {project_id: project_id},
            beforeSend: function() {
              $('.loader').show();
          },
          success: function (result) {
            $('.loader').hide();
            $('.project_report_container').html(result);
        }
    });
}

function filter_projects() {
        var project_id= $('#transactions_project_id').val();
        var transaction_type = $('#transaction_type').val();
		$('#report_project_id').val(project_id);
		$('#report_transaction_type').val(transaction_type);
        $.ajax({
            url: base_url+'reports/get_filter_projects/',
            type: 'POST',
            data: {project_id: project_id, transaction_type:transaction_type},
            beforeSend: function() {
               $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.project_report_container').html(result);
            }
        });

    }
    
function validateForm() {
    if($("#trackingForm").valid()){
        var is_selected =0;
        $("#partstable tbody tr").each(function(){
        var is_checked = $(this).find("input[name='select[]']").is(':checked');
        //total+=parseFloat($(this).parent().next('td').find('.amount').text());
        if(is_checked){
            is_selected = 1;
        }
     })
       if(is_selected==1){
        return true;
       }else{
            swal({
                           title: 'Error!',
                           text: 'Select atleast 1 row to save this report.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        }).catch(swal.noop);
            return false;
       }
    }
    else{
        setFormValidation('#trackingForm');
    }
        
    }

    function getCostingbyProject(id) {

    var lstrow = ($("table#partstable tbody tr:last-child()").attr('tr_val')) ? $("table#partstable tbody tr:last-child()").attr('tr_val') : 0;

    $.ajax({
        url: base_url+'ajax/get_project_costing_tracking/'+id,
        method: 'post',
        datatype: 'json',
        data: {id: id, last_row: lstrow},
        beforeSend: function() {
              $('.loader').show();
            },
        success: function (result) {
            $('.loader').hide();
            response = jQuery.parseJSON(result);
            $('#newcdiv').show();
            $('table#partstable tbody').html(response.rData);
            $("#addbtn").val(response.counter);
            $("#removebtn").val(response.counter);


        }
    });

}
calculate_total();
function select_part(){
    calculate_total();
}

$('body').on('click','.select_all',function(){
        if ($('.select_all:checked').length > 0){
            $('.selected_items').prop("checked", true);
            calculate_total();
        }
        else{
               $('.selected_items').prop("checked", false);  
            }
});

function calculate_total(){
    var total = 0;
    var costing_parts = '';
    $("#partstable tbody tr").each(function(){
        var is_checked = $(this).find("input[name='select[]']").is(':checked');
        if(is_checked){
            $(this).find("input[name='is_selected[]']").val(1);
            var line_total = $(this).find("input[name='linttotal[]']").val();
            var costing_part_id = $(this).find("input[name='costing_part_id[]']").val();
            costing_parts += costing_part_id+',';
            total = parseFloat(total) + parseFloat(line_total);
        }
    })
    costing_parts = costing_parts.slice(0,-1);
     $("#partstable tfoot #total_count").html(total.toFixed(2));
     $("#total_amount").val(total);
     $("#selected_costing_parts").val(costing_parts);
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
                
                        $('#trnumber' + row).remove();  
                        calculate_total();
						
						swal({
                           title: 'Deleted!',
                           text: 'Your record has been deleted.',
                           type: 'success',
                           confirmButtonClass: "btn btn-success",
                           buttonsStyling: false
                        })	
				
            });
    });
    
    function changeComponentReportType(report_type){
      $('#report_type').val(report_type);
      var supplier_id = $("#supplier").val();
      $('#report_supplier_id').val(supplier_id);
    }
    
    $("#supplier").change(function () {
		var supplier_id = $(this).val();
		$.ajax({
	        url: base_url+"reports/get_supplier_components",
	        type: "post",
	        data: "supplier_id="+supplier_id,
	        success: function (response) {
	           $(".supplier_components_container").html(response);
	        }
		});
	});
	
	 