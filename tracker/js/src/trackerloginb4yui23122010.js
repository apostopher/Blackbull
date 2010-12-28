/* Author: Rahul Devaskar

*/
(function($){
  var remember = 0;
  $("#loginfrm").submit(function(){
    remember = $("#remember").attr('checked')?1:0;
    $.ajax({
      type: "POST",
      url: "/serverscripts/portfolio/trackerlogin.php",
      data:({'username':$.trim($("#trackeruser").val()),
             'password' :$.trim($("#trackerpass").val()),
             'remember':remember}),
      dataType: "json",
      success: function(response){
        if(response){
          if(response.id != '0'){
            if(response.portfolio == '1'){
              window.location.replace("http://www.blackbull.in/tracker");
            }else{
              $("#loginformholder").slideUp("slow");
              $("#newfolioholder").slideDown("slow");
            }
          }else{
            alert("login failed");
          }
        }else{
          alert("login failed");
        }
      },
      error: function(response){}
    });
    return false;
  });
  $("#newfoliofrm").submit(function(){
    $.ajax({
      type: "POST",
      url: "/serverscripts/portfolio/foliocreate.php",
      data:({'portfolio':$.trim($("#folioname").val()),'remember':remember}),
      dataType: "json",
      success: function(response){
        if(response.success > 0){
          window.location.replace("http://www.blackbull.in/tracker");
        }else{
          alert("Portfolio creation failed");
        }
      },
      error: function(response){
      }
    });
    return false;
  });
})(this.jQuery);