    function get_completed_job_cash_transfers(){
         $.ajax({
            url: base_url+'cash_transfers/get_completed_job_cash_transfers',
            type: 'post',
            data: {},
            beforeSend: function() {
                      $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $(".completed_cash_transfers").html(result);
                $("#completedTab").attr("onclick","");
                $('#completedJobsCashTransfers').dataTable( {
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
    
    function getsupplierbycostingid(value) {
        
            curr_project_id = value;
            if (value == 0) {

                $("#divsupplierforcurrentcosting").hide();
                
            } else {


                $.ajax({
                    url: base_url+'ajax/getsupplier/',
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
                        $("#divsupplierforcurrentcosting").show();
                    }
                });


            }
    }
    
     function changeproject() {

        getsupplierbycostingid($('#project_id').val());
    }
    
    $(document).ready(function() {
        setFormValidation('#CashTransferForm');
    });
    
    