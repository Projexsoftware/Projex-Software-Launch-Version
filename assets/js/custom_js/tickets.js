
    $(document).ready(function() {
        setFormValidation('#TicketForm');
    });
    
     $("#reply_form").validate({
        ignore : [],
        rules: {
        ticket_body:{    
            required:true
        }
    }
            });

    
$("#reply_form").on('submit',(function(e) {
e.preventDefault();
if($("#reply_form").valid()){
var ticket_body = CKEDITOR.instances['ticket_body'].getData();
if(ticket_body==""){
    alert("Please enter your reply");
}
else{

var data = new FormData(this);
data.append('content', CKEDITOR.instances['ticket_body'].getData());
    $.ajax({
url: base_url+"tickets/reply_to_ticket", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: data,
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
beforeSend: function() {
              $('#loading-overlay').show();
            },
success: function(data)   // A function to be called if request succeeds
{
    $('#loading-overlay').hide();
    $(".replies_container").html(data);
    $("#reply_form")[0].reset();
    $('.dz-preview').hide();
    $('.dz-message').show();
    CKEDITOR.instances['ticket_body'].setData('');
    $('html, body').animate({
        scrollTop: $("#TicketReplies").offset().top
    }, 1000);
}
});
}
}
else{
   $("#reply_form").validate();
}
}));


$('body').on('click','.myImg',function(){
    imageSrc = $(this).attr("original_img");
    
    swal({
                title: '',
                html: '<div class="form-group">' +
                    '<img src="'+imageSrc+'"/>' +
                    '</div>',
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Close',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            })
});

