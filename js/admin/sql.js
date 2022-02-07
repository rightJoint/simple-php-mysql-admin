function mkQuery()
{
    var posting = $.post( "", "queryText="+$("textarea").val());
    $(".query-result").preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    });
    posting.done(function( data ) {
        var response=JSON.parse(data);
        $('.result-info').html(response.log);
        if(response.result == true){
            $('.result-info').removeClass("fail");
            $('.result-info').addClass("well");
        }else{
            $('.result-info').removeClass("well");
            $('.result-info').addClass("fail");
        }
        $('.query-result').preloader('remove');
    });
}