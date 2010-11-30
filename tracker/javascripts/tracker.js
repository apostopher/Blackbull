/* Author: Rahul Devaskar

*/
(function($){
  $(".menuitem a").click(function(){
    if($(this).hasClass("active")){
      return true;
    }
    $(".active").removeClass("active");
    $(this).addClass("active");
  });
})(this.jQuery);










