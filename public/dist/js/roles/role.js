$('.allcheck').click(function(event) {
    "use strict";
    var acname=$(this).attr('title');
    var mid=$(this).attr('usemap');
    var myclass=acname+'_'+mid;
    $("."+myclass).prop('checked', $(this).prop("checked"));
    
  });