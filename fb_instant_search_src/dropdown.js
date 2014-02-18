$(document).ready(function(){
  $("#drop").click(function(){
    $("#drop").show();
  });
$(".dim").click(function(){
    $("#drop").show();
   
  });

 $("body").click
(
  function(e)
  {
    if(e.target.className !== "dropdownlist" && e.target.className !== "dim" && e.target.className != "detail_content_wrap" && e.target.className !== "img_instant")
    {
      $("#drop").hide();
    }
  }
);

});



