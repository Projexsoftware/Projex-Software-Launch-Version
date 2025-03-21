
    $(document).ready(function() {
        setFormValidation('#ConfirmedEstimateForm');
    });

    $('body').on('click','.select_all',function(){
        if ($('.select_all:checked').length > 0){
            $('.selected_items').prop("checked", true);
        }
        else{
               $('.selected_items').prop("checked", false);  
            }
    });
    $('body').on('change','#project_id',function(){
        var project_id = $("#project_id").val();
        if(project_id==""){
            alert("Please select project");
            $(".suppliers_container").html("");
        }
        else{
                $.ajax({
                     url: base_url+"confirmed_estimate/get_suppliers", 
                     type: "POST",            
                     data: "project_id="+project_id,
                     cache : false,
                     processData: false,
                     beforeSend: function() {
                        $('.loader').show();
                     },
                    success: function(data)   // A function to be called if request succeeds
                    {
                        $('.loader').hide();
                        $(".suppliers_container").html(data);
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
        }
     });
    $('body').on('change','.search_options',function(){
         var project_id = $("#project_id").val();
        var supplier_id = $("#supplier_id").val();
        if(project_id==""){
            alert("Please select project");
            $(".parts_container").html("");
        }
        else if(supplier_id==""){
            alert("Please select supplier");
            $(".parts_container").html("");
        }
        else{
                $.ajax({
                     url: base_url+"confirmed_estimate/get_parts", 
                     type: "POST",            
                     data: "project_id="+project_id+"&supplier_id="+supplier_id,
                     cache : false,
                     processData: false,
                     beforeSend: function() {
                        $('.loader').show();
                     },
                    success: function(data)   // A function to be called if request succeeds
                    {
                        $('.loader').hide();
                        $(".parts_container").html(data);
                        $("#selected_project_id").val(project_id);
                        $("#selected_supplier_id").val(supplier_id);
                    }
                });
        }
     });
    $('body').on('click','.search_parts',function(){
        var project_id = $("#project_id").val();
        var supplier_id = $("#supplier_id").val();
        if(project_id==""){
            alert("Please select project");
        }
        else if(supplier_id==""){
            alert("Please select supplier");
        }
        else{
                $.ajax({
                     url: base_url+"confirmed_estimate/get_parts", 
                     type: "POST",            
                     data: "project_id="+project_id+"&supplier_id="+supplier_id,
                     cache : false,
                     processData: false,
                     beforeSend: function() {
                        $('.loader').show();
                     },
                    success: function(data)   // A function to be called if request succeeds
                    {
                        $('.loader').hide();
                        $(".parts_container").html(data);
                        $("#selected_project_id").val(project_id);
                        $("#selected_supplier_id").val(supplier_id);
                    }
                });
        }
    });
    
    $("#ConfirmedEstimateForm").submit(function(e){
            if($("#ConfirmedEstimateForm").valid()){
            e.preventDefault();
            var form = this;
            if ($('.selected_items:checked').length > 0){
                    var status = $("#status").val();
                    swal({
                    title: 'Are you sure you want to send all selected parts for confirmation?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'Yes, send it!',
                    buttonsStyling: false,
                    closeOnConfirm: true
                    }).then(function() {
                      form.submit();
                  });
            }
                else{
                    swal({
                    title: 'Error!',
                    text: 'Please select atleast one part.',
                    type: 'error',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                    })
                    e.preventDefault(e);
                }
            }
            else{
                setFormValidation('#ConfirmedEstimateForm');
            }
        });

	
	