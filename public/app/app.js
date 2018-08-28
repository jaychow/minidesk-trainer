$(function(){
    var split = window.location.href.split('/');
    var uri_seg = split[split.length-1];
    uri_seg =  window.location.href;
    $('#navbar-collapse').find('a').each(function(i, li){
        if($(li).attr('href') == uri_seg){
            $(li).closest('li').addClass('active');
        }
    });
});
