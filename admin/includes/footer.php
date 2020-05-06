</div><br><br>
<div class="col-md-12 text-center">&copy; Copyright 2017-2019 BOUTIQUE.</div>

  <script>
    function updateSizes(){
      var sizeString = '';
      for(var i=1; i <= 12; i++){
        if (jQuery('#size' + i).val() !='') {
          sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
        }
      }
      jQuery('#sizes').val(sizeString);
    }
    function get_child_option(selected){
      if (typeof selected == 'undefined') {
        var selected = '';
      }
      var parentID = jQuery('#parent').val();
      jQuery.ajax({
        url: '/ecom/admin/parsers/child_categories.php',
        type: 'POST',
        data: {parentID : parentID, selected: selected},
        success: function(data){
          jQuery('#child').html(data);
        },
        error: function(){alert("Something went wrong with the child option.")},
      });
    }
    jQuery('select[name="parent"]').change(function(){
      get_child_option();
    });
  </script>

</body>
</html>
