$(document).ready(function(){
    $(".adminMenu img").click(function(){
        var frame =  $(this).parent().find(".adminMenu-link-frame");
        if ($(frame).hasClass("open")) {
            $(frame).removeClass("open");
        } else {
            $(frame).addClass("open");
        }
    })
});