$('body').on('keyup', '.search_supplierz_users', function () {
    var keyword = $(this).val();
    if(keyword!=""){
        $.ajax({
            url: base_url+'online_store/filter_supplierz_users/',
            type: 'post',
            data: {keyword:keyword},
            beforeSend: function() {
            //$('.loader').show();
            },
            success: function (result) {
                $('.supplierz_users_container').show();
                $('.supplierz_users_container').html(result);
            }
        });
    }
    else{
        $('.supplierz_users_container').hide();
    }
});

$('body').on('keyup', '.search_categories', function () {
    var keyword = $(this).val();
    if(keyword!=""){
        $.ajax({
            url: base_url+'online_store/filter_categories/',
            type: 'post',
            data: {keyword:keyword},
            beforeSend: function() {
            //$('.loader').show();
            },
            success: function (result) {
                $('.categories_container').show();
                $('.categories_container').html(result);
            }
        });
    }
    else{
        $('.supplierz_users_container').hide();
    }
});

$('body').on('click', '.supplierz_user', function () {
    var id = $(this).attr("id");
    $("#supplier"+id).prop("checked", true);
    $('.supplierz_users_container').hide();
    setFilter();
});

$('body').on('click', '.category-item', function () {
    var id = $(this).attr("id");
    $("#category"+id).prop("checked", true);
    $('.categories_container').hide();
    setFilter();
});


$('body').on('click', '.reset_filters', function () {
    $(".online_store_filter").prop("checked", false);
    resetFilterButtonToggle();
    setFilter();
});

$('body').on('click', '.remove_filter', function () {
    var id = $(this).attr("id");
    var type = $(this).attr("type");
    $(this).parent("span").remove();
    $("#"+type+id).prop("checked", false);
    setFilter();

});

$('body').on('click', '.online_store_filter', function () {
    setFilter();
    resetFilterButtonToggle();
});

$('body').on('change', '#differentaddress', function () {
    if($(this).prop("checked") == true){
        $(".different_address").show();
    }
    else{
            $(".different_address").hide();
    }
    
});

$('body').on('change', '#sort_by', function () {
    var type = $(this).val();
    var page = $(".pagination li.active").attr("data-ci-pagination-page");
    var categories = [];
    $( ".categoryFilter" ).each(function() {
      if($(this).is(":checked")){
          if($(this).val()==0){
              categories.push($(this).val());
          }
          else{
          categories.push($(".categoryLabel"+$(this).val()).text());
          }
              }
    });
    var suppliers = [];
    $( ".supplierFilter" ).each(function() {
      if($(this).is(":checked")){
          suppliers.push($(this).val());
    }
    });
    
    $.ajax({
            url: base_url+'online_store/search/',
            type: 'post',
            data: {categories:categories,suppliers:suppliers,type:type},
            beforeSend: function() {
               $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.shop_container').html(result);
                $(".pagination li.active").removeClass("active");
                $( 'a[ data-ci-pagination-page=' + page + ']' ).parent("li").addClass("active");
            }
        });
});

$('body').on('click', '.pagination li a', function (e) {
    e.preventDefault();
    var page = $(this).attr("data-ci-pagination-page");
    var categories = [];
    $( ".categoryFilter" ).each(function() {
      if($(this).is(":checked")){
          if($(this).val()==0){
              categories.push($(this).val());
          }
          else{
          categories.push($(".categoryLabel"+$(this).val()).text());
          }
              }
    });
    var suppliers = [];
    $( ".supplierFilter" ).each(function() {
      if($(this).is(":checked")){
          suppliers.push($(this).val());
    }
    });
    
    $.ajax({
            url: base_url+'online_store/search/'+page,
            type: 'post',
            data: {categories:categories,suppliers:suppliers},
            beforeSend: function() {
               $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.shop_container').html(result);
                $(".pagination li.active").removeClass("active");
                $( 'a[ data-ci-pagination-page=' + page + ']' ).parent("li").addClass("active");
            }
        });
});

function setFilter(){
    $(".setFiltersContainer").html("");
    var categories = [];
    $( ".categoryFilter" ).each(function() {
      if($(this).is(":checked")){
          if($(this).val()==0){
              categories.push($(this).val());
              $(".categoryFilter").prop("checked", false);
              $(this).prop("checked", true);
          }
          else{
          categories.push($(".categoryLabel"+$(this).val()).text());
          }
          var selectedFilter = $(".categoryLabel"+$(this).val()).text();
          $(".setFiltersContainer").append("<span class='text-warning'>"+selectedFilter+" <i type='category' id="+$(this).val()+" class='fa fa-remove remove_filter'></i></span>");
      }
    });
    var suppliers = [];
    $( ".supplierFilter" ).each(function() {
      if($(this).is(":checked")){
          if($(this).val()==0){
            $(".supplierFilter").prop("checked", false);
            $(this).prop("checked", true); 
          }
          suppliers.push($(this).val());
          var selectedFilter = $(".supplierLabel"+$(this).val()).text();
          $(".setFiltersContainer").append("<span class='text-warning'>"+selectedFilter+" <i type='supplier' id="+$(this).val()+" class='fa fa-remove remove_filter'></i></span>");
      }
    });
    
    $.ajax({
            url: base_url+'online_store/search/',
            type: 'post',
            data: {categories:categories,suppliers:suppliers},
            beforeSend: function() {
               $('.loader').show();
            },
            success: function (result) {
                $('.loader').hide();
                $('.shop_container').html(result);
            }
        });
    
}

function resetFilterButtonToggle(){
    var isFilterSet = $('input:checkbox:checked').length;
    if(isFilterSet>0){
        $(".reset_filters").show();
    }
    else{
        $(".reset_filters").hide();
    }
}


/*===================================*
	20. PRODUCT COLOR JS
	*===================================*/
	$('.product_color_switch span').each(function() {
		var get_color = $(this).attr('data-color');
		$(this).css("background-color", get_color);
	});
	
	$('.product_color_switch span,.product_size_switch span').on("click", function() {
		$(this).siblings(this).removeClass('active').end().addClass('active');
	});
	
	$("body").on("click", ".plus", function () {  
		if ($(this).prev().val()) {
			$(this).prev().val(+$(this).prev().val() + 1);
		}
	});
	
	$("body").on("click", ".minus", function () {  
		if ($(this).next().val() > 1) {
			if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
		}
	});
	
	$( '.dropdown-menu a.dropdown-toggler' ).on( 'click', function () {
			//var $el = $( this );
			//var $parent = $( this ).offsetParent( ".dropdown-menu" );
			if ( !$( this ).next().hasClass( 'show' ) ) {
				$( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
			}
			var $subMenu = $( this ).next( ".dropdown-menu" );
			$subMenu.toggleClass( 'show' );
			
			$( this ).parent( "li" ).toggleClass( 'show' );
	
			$( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function () {
				$( '.dropdown-menu .show' ).removeClass( "show" );
			} );
			
			return false;
	});
	var image = $('#product_img');
	//var zoomConfig = {};
	var zoomActive = false;
	
    zoomActive = !zoomActive;
	if(zoomActive) {
		if ($(image).length > 0){
			$(image).elevateZoom({
				cursor: "crosshair",
				easing : true, 
				gallery:'pr_item_gallery',
				zoomType: "inner",
				galleryActiveClass: "active"
			}); 
		}
	}
	else {
		$.removeData(image, 'elevateZoom');//remove zoom instance from image
		$('.zoomContainer:last-child').remove();// remove zoom container from DOM
	}
    $("body").on("click", ".btn-addtocart", function () { 
            var id = $(this).attr("id");
            var name = $('#name'+id).val();
			var price = $('#price'+id).val();
			var category = $('#category'+id).val();
            var quantity= $('#quantity'+id).val();
            var supplier = $('#supplier'+id).val();
            var supplierz = $('#supplierz'+id).val();
            var image= $('#image'+id).val();
	        var request_url = base_url+"online_store/add_to_cart";
			var view_cart = base_url+"online_store/cart";
			var currentObj = $(this);
            
                jQuery.post(
				request_url, 
                {flag: true, supplier:supplier, category:category, name:name, price:price, id:id, quantity:quantity, image:image, supplierz:supplierz},
                function (responseText) {
				if(responseText!="fail"){
				$('#popup'+id).click();
				$('.cart_count').text(responseText.cart_items_count);
				$('.cart_total_amount').text(responseText.cart_total);
				$(".cart_box").html(responseText.cart_items);
				$(".cart_total").html('<strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">PKR</span></span>'+responseText.cart_total);
				currentObj.removeClass("btn-addtocart");
				$(".btn-addtocart-"+id).removeClass("btn-addtocart");
				$(".btn-add-to-cart").hide();
				$(".btn-addtocart-"+id).text("VIEW CART");
				$(".btn-addtocart-"+id).attr("href", base_url+"online_store/cart");
                                    }
                                }, 
                                "json"
			);
});

$("body").on("click", ".btn-add-to-wishlist", function () { 
            var id = $(this).attr("id");
            var currentObj = $(this);
            var request_url = base_url+"online_store/add_to_wishlist";
                jQuery.post(
				request_url, 
                {id:id},
                function (responseText) {
				if(responseText!="fail"){
				swal({
                    title: 'Congratulations!',
                    text: 'Component has been added to wishlist',
                    type: 'success',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                }).catch(swal.noop);
				 $('.wishlist_count').text(responseText.wishlist_items);
				 currentObj.removeClass("btn-add-to-wishlist").removeClass("wishlist-icon").addClass("wishlist-active-icon").addClass("btn-remove-from-wishlist");
				 currentObj.attr("id", responseText.wishlist_rowid);
                }
            }, 
            "json"
	);
});

$("body").on("click", ".btn-remove-from-wishlist", function () { 
            var id = $(this).attr("id");
            var currentObj = $(this);
            var request_url = base_url+"online_store/remove_wishlist_ajax";
                jQuery.post(
				request_url, 
                {id:id},
                function (responseText) {
				if(responseText!="fail"){
				 swal({
                    title: 'Congratulations!',
                    text: 'Component has been removed from wishlist',
                    type: 'success',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false
                }).catch(swal.noop);
				 $('.wishlist_count').text(responseText.wishlist_items);
				 currentObj.removeClass("btn-remove-from-wishlist").removeClass("wishlist-active-icon").addClass("wishlist-icon").addClass("btn-add-to-wishlist");
				 currentObj.attr("id", responseText.wishlist_rowid);
                }
            }, 
            "json"
	);
});

$("body").on("click", ".add-to-cart-wishlist-btn", function () { 
            var id = $(this).attr("id");
            var name = $('#name'+id).val();
			var price = $('#price'+id).val();
			var category = $('#category'+id).val();
            var quantity= $('#quantity'+id).val();
            var supplier = $('#supplier'+id).val();
            var supplierz = $('#supplierz'+id).val();
            var image= $('#image'+id).val();
            var currentObj = $(this);
            var request_url = base_url+"online_store/add_to_cart";
                jQuery.post(
				request_url, 
                {flag: true, supplier:supplier, category:category, name:name, price:price, id:id, quantity:quantity, image:image, supplierz:supplierz},
                function (responseText) {
				if(responseText=="fail"){
				  alert("Sorry we are unable to add this product into cart");
				}
				else if(responseText=="out of stock"){
				    alert("Sorry You cannot add this product into cart. This product is Out of Stock");
				}
                else{
                   $('.cart_count').text(responseText.cart_items_count);
    				$('.cart_total_amount').text(responseText.cart_total);
    				$(".cart_box").html(responseText.cart_items);
    				$(".cart_total").html('<strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">PKR</span></span>'+responseText.cart_total);
    			    currentObj.removeClass("add-to-cart-wishlist-btn");
    				currentObj.text("VIEW CART");
    				currentObj.attr("href", base_url+"online_store/cart"); 
                }
            }, 
            "json"
	);
});

$("body").on("click", ".btn-placeorder", function () { 
            if($("#PlaceOrderForm").valid()){
                var data = $("#PlaceOrderForm").serialize();
                $.ajax({
                   type:'POST',
                   url: base_url+"online_store/your_order",
                   data: data,
                   beforeSend: function() {
                        $(".btn-placeorder").html('Please Wait....');
                        $(".btn-placeorder").attr('disabled',true);
                    },
                   success:function(result){
                            window.location.href = result;
                    }
                });
            }
            else{
                $("#PlaceOrderForm").validate()
            }
});
