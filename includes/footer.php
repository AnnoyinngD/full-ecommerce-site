</div><br><br>
<div class="col-md-12 text-center">&copy; Copyright 2017-2019 BOUTIQUE.</div>

<script>

  jQuery(window).scroll(function(){
    var vscroll = jQuery(this).scrollTop();
    jQuery('#logotext').css({
      "transform" : "translate(0px, "+vscroll/2+"px)"
    });
    jQuery('#back-flower').css({
      "transform" : "translate("+0+vscroll/5+"px, -"+vscroll/12+"px)"
    });
    jQuery('#for-flower').css({
      "transform" : "translate(0px, -"+vscroll/2+"px)"
    });
  });

  function detailsmodal(id){

    var data = {"id" : id};
    jQuery.ajax({
      url : '/ecom/includes/detailsmodal.php',
      method : "post",
      data : data,
      success : function(data){
        jQuery('body').append(data);
        jQuery('#details-modal').modal('toggle');
      },
      error : function() {
        alert("error");
      }
    });

  }
//Update_cart

  function update_cart(mode,edit_id,edit_size){
    var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
    jQuery.ajax({
      url : '/ecom/admin/parsers/update_cart.php',
      method : "post",
      data : data,
      success : function(){location.reload();},
      error : function(){alert("Something went wrong")},
    });
  }

// Add to cart function
  function add_to_cart(){
    jQuery('#modal_errors').html("");
    var size = jQuery('#size').val();
    var quantity = jQuery('#quantity').val();
    var available = jQuery('#available').val();
    var error = '';
    var data = jQuery('#add_product_form').serialize();
    if (size == '' || quantity == '' || quantity == 0) {
      error += '<p class="text-danger text-center">You must choose a size and Quantity.</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else if (quantity > available) {
            error += '<p class="text-danger text-center">There aare only '+available+' Available.</p>';
            jQuery('#modal_errors').html(error);
            return;
    }else {
      jQuery.ajax({
        url : '/ecom/admin/parsers/add_cart.php',
        method : 'post',
        data : data,
        success : function(){
          location.reload();
        },
        error : function(){alert("Something went wrong!");}
      });
    }
  }

</script>

</body>
</html>
