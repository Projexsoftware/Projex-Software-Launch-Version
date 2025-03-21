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
setFormValidation('#SalesCreditsNotesForm');
});

function get_completed_job_sales_credits_notes(){
         $.ajax({
            url: base_url+'sales_credits_notes/get_completed_job_sales_credits_notes',
            type: 'post',
            data: {},
            beforeSend: function() {
                      $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $(".completed_sales_credits_notes").html(result);
                $('#completedJobsSalesCreditsNotes').dataTable( {
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
    
    function calculate() {

        var total = 0;
        var tax = 0;
        var tax_type = $("#tax_type").val();
        

        $(".invoicebudget").each(function () {


            var qty = $(this).val();
            var newtotal = parseFloat(qty);
            total += newtotal;       

        });
        
        
        if (isNaN(total) || total == '') {
                
             $(".subtotal").text("0.00");
             $("#subtotal").val("0.00");
             //$("#total_credit").val("0.00");
             $(".total_tax").text("0.00");
             $("#total_tax").val("0.00");
             $(".total").text("0.00");
             $("#total").val("0.00");
             
             if(tax_type=="Exclusive"){
            $(".tax_type").text("Tax on Purchases (15%)");
            $(".tax_rate").text("Total Tax 15.00%");
            $(".tax_container").show();
            }
            else if(tax_type=="Inclusive"){
            $(".tax_type").text("Tax on Purchases (15%)");
            $(".tax_rate").text("Includes Tax 15.00%");
            $(".tax_container").show();
            }
            else{
                $(".tax_type").text("No Tax");
                $(".tax_rate").text("");
                $(".tax_container").hide();
            }
             

        } else {
            if(tax_type=="Exclusive"){
                tax = (15/100)*total;
                
            $(".total_tax").text(tax.toFixed(2));
            $("#total_tax").val(tax.toFixed(2));
            $(".tax_type").text("Tax on Purchases (15%)");
            $(".tax_rate").text("Total Tax 15.00%");
            $(".tax_container").show();
            }
            else if(tax_type=="Inclusive"){
                tax = (3*total)/23;
                
            $(".total_tax").text(tax.toFixed(2));
            $("#total_tax").val(tax.toFixed(2));
            $(".tax_type").text("Tax on Purchases (15%)");
            $(".tax_rate").text("Includes Tax 15.00%");
            $(".tax_container").show();
            }
            else{
                tax = 0;
                $(".total_tax").text(tax.toFixed(2));
                $("#total_tax").val(tax.toFixed(2));
                $(".tax_type").text("No Tax");
                $(".tax_rate").text("");
                $(".tax_container").hide();
            }
            $(".subtotal").text(total.toFixed(2));
            $("#subtotal").val(total.toFixed(2));
            
            if(tax_type=="Exclusive"){
            $(".total").text((tax+total).toFixed(2));
            $("#total").val((tax+total).toFixed(2));
            }
            else{
                 $(".total").text((total).toFixed(2));
                 $("#total").val((total).toFixed(2));
            }
        }
        
    }
    
    $(document).ready(function() {
            
        $("#SalesCreditsNotesForm").submit(function(e){
                var total = $("#subtotal").val();
                var total_credit  = $("#total_credit").val();
                var status = $("#status").val();
                if(status == "Approved"){
                if(total==total_credit || total==parseFloat(total_credit).toFixed(2)){
                }
                else{
                    toastr.error("The totals do not match");
                    e.preventDefault(e);
                }
                }
                else{ 
                }
                
        });
    });
    
    function checkStatus(status){
        $("#selected_status").val(status);
        if(status=="" || status != "Allocated"){
            $(".allocate_container").hide();
            $('#sales_invoice_id').removeAttr('required');
            
        }
        else{
            $(".allocate_container").show();
            $('#sales_invoice_id').attr('required','required');
        }
        
    }
    
    function checkOutstandingAmount(amount){
        if(amount!=""){
        var total = $("#total").val();
        var supplier = $("#supplier_invoice_id :selected").text().split("(");
        console.log(supplier);
        var amount = supplier[1].split(")");
        $("#outstanding_amount").val(amount[0]);
        
        if(parseFloat(total)>parseFloat(amount[0])){
            toastr.error("Credit Note amount cannot be greater than supplier invoice outstanding amount");
            $('#update_btn').attr('disabled','disabled');
            
        }
        else{
            $('#update_btn').removeAttr('disabled');
        }
        }
        else{
             $('#update_btn').removeAttr('disabled');
        }
        
    }

