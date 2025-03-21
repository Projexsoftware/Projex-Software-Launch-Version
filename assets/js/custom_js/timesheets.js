    function addMore() {
            
            var last_row = $('#imp_timesheet_item tbody tr:last-child()').attr('row_no');

            if (last_row === undefined) {
                last_row = 1;
            }
            else{
                last_row = parseFloat(last_row)+1;
            }

            $.ajax({
            url: base_url+'timesheets/importnew',
            type: 'post',
            data: {last_row:last_row},
            beforeSend: function() {
              $('.loader').show();
            },
            success: function (data) {
                       $('.loader').hide();
                        $('#imp_timesheet_item tbody').append(data);
						$('.selectpicker').selectpicker('refresh');
						demo.initFormExtendedDatetimepickers();
            }
        });

    }
    
    $('body').on('click', '.deleterow', function () {

        var row = $(this).attr('rno');
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
                     $('#nitrnumber' + row).remove();
                });
        }
    });
    
    $("#TimeSheetForm").submit(function(e){
            if($("#TimeSheetForm").valid()){
            e.preventDefault();
            var form = this;
            var row_count =  $('#imp_timesheet_item').find('tbody').find('tr').length;
            if(row_count>0){
                    var status = $("#status").val();
                    swal({
                    title: 'Are you sure, you want to save this timesheet As '+status+'?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Yes, save it!',
                    buttonsStyling: false,
                    closeOnConfirm: true
                    }).then(function() {
                      form.submit();
                  });
            }
                else{
                    swal({
                    title: 'Error!',
                    text: 'Add at least one item to save this timesheet.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    })
                    e.preventDefault(e);
                }
            }
            else{
                setFormValidation('#TimeSheetForm');
            }
        });
    
    
    $(document).ready(function() {
            setFormValidation('#TimeSheetForm');
            
            
            $('#pending_dataTable').dataTable( {
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
        $('#approved_dataTable').dataTable( {
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
		$('#invoiced_dataTable').dataTable( {
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
		$('#draft_dataTable').dataTable( {
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
			
			$("#main").click(function() {
  $("#mini-fab").toggleClass('hidden');
});
        
    });
    
    
    function calculate_subtotal(rowno){
        var approved_hours = $("#approved_hours"+rowno).val();
        if (isNaN(approved_hours)) {
            approved_hours = 0;
        }
        var cost = $("#cost"+rowno).val();
         if (isNaN(cost) || cost=='') {
            cost = 0;
        }
        $("#cost"+rowno).val(parseFloat(cost).toFixed(2));
        
        var subtotal = parseFloat(approved_hours)*parseFloat(cost).toFixed(2);
        if (isNaN(subtotal)) {
            subtotal = 0;
        }
        $("#subtotal"+rowno).val(subtotal.toFixed(2));
        
        var total_subtotal = 0;
        var total_approved_hours = 0;
        
        $( ".subtotal_amount" ).each(function() {
          total_subtotal = parseFloat(total_subtotal) + parseFloat($( this ).val());
       });
       if (isNaN(total_subtotal)) {
            total_subtotal = 0;
        }
       $(".total_subtotal").html("<b>$"+total_subtotal.toFixed(2)+"</b>");
       
        $( ".approved_hours" ).each(function() {
          total_approved_hours = parseFloat(total_approved_hours) + parseFloat($( this ).val());
       });
       if (isNaN(total_approved_hours)) {
            total_approved_hours = 0;
        }
       $(".total_approved_hours").html("<b>"+total_approved_hours.toFixed(2)+"</b>");
        
    }
    
    $(document).ready(function() {
            
        $("#timesheet_form").submit(function(e){
            e.preventDefault();
            var form = this;
                 swal({
                    title: 'Are you sure, you want to save this timesheet As '+status+'?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Yes, save it!',
                    buttonsStyling: false,
                    closeOnConfirm: true
                 }).then(function() {
                      form.submit();
                  });
        });
    });