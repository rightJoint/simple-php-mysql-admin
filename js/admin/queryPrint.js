function queryPrint()
{
    var posting = $.post( "", "queryText="+$("textarea").val()+"&qp-limit="+$("[name='qp-limit']").val());
    $(".result-info").preloader({
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
            //$('.res-frame').addClass("active");
            $('.result-info').removeClass("fail");
            $('.result-info').addClass("well");
        }else{
            //$('.res-frame').removeClass("active");
            $('.result-info').removeClass("well");
            $('.result-info').addClass("fail");
        }
        if(response.table!=null){
            $(".query-result-table").html(response.table);
        }
        $('.result-info').preloader('remove');
    });
}