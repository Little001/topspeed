$( document ).ready(function() {
    var page = window.location.pathname;
    
    if(document.URL.indexOf("sluzby.html") >= 0){
        $('body').css('background-image', 'none');
        $('.menu-background').css('background-color','rgba(0, 0, 0, 1)');
        $('.content-background').css('background', '#360000');
        $('.content-background').css('background', '-moz-linear-gradient(top,  #360000 0%, #fd0000 100%)'); 
        $('.content-background').css('background', '-webkit-linear-gradient(top,  #360000 0%,#fd0000 100%)');
        $('.content-background').css('background', 'linear-gradient(to bottom,  #360000 0%,#fd0000 100%)');
        $('.content-background').css('filter', 'progid:DXImageTransform.Microsoft.gradient( startColorstr="#360000", endColorstr="#fd0000",GradientType=0 )'); 
    }
    if(document.URL.indexOf("auta.html") >= 0){
        $('body').css({'background-image' : "url('Images/desert.jpg')"});
    }
});



