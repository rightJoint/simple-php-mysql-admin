function addNewUser()
{
    $("[name='newUsrName']").val();
    $("[name='newUsrPass']").val();

    var posting = $.post( "", "addAdmUsrFlag=y&newUsrName="+$("[name='newUsrName']").val()+"&newUsrPass="+$("[name='newUsrPass']").val());
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
            $('.result-info').removeClass("fail");
            $('.result-info').addClass("well");
            $(".usersList").preloader({
                text: 'loading',
                percent: '',
                duration: '',
                zIndex: '',
                setRelative: true
            });
            $.get( "", {action: "refreshUsers"} )
                .done(function( resp_data ) {
                    //var response=JSON.parse(data);
                    $('.usersList').html(resp_data);
                    $('.usersList').preloader('remove');
                });
        }else{
            $('.result-info').removeClass("well");
            $('.result-info').addClass("fail");
        }
        $('.result-info').preloader('remove');
    });
}

function dropAdminUsr(usrName)
{
    $(".usersList").preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    });
    $.get( "", {dropUser: usrName} )
        .done(function( data ) {
            $('.usersList').html(data);
            $('.usersList').preloader('remove');
        });
}