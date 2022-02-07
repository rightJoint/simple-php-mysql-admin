$(document).ready(function(){
    $('.modal-right').click(function (){
        $('.modal, .overlay').css({'opacity': 0, 'visibility': 'hidden'});
    });
})

function tables(el){
    var tableName=null;
    if($(el).parent().parent().find("div:first").html()!==undefined){
        tableName=$(el).parent().parent().find("div:first").html();
    }
    var action = $(el).attr("action");
    $(el).parent().preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    })
    var dwlTable=null;
    if(action=='download'){
        dwlTable=($(el).parent().parent().find("option:selected").val());
    }
    $.get( "?action="+action+"&tableName="+tableName+"&dwlTable="+dwlTable+
        "&prefixTag="+$(".optionsPanel [name='prefixTag']").val()+"&dateTag="+$(".optionsPanel [name='dateTag']").prop("checked") )
        .done(function( data ) {
            $(el).parent().preloader("remove");
            var response=JSON.parse(data);
            if(response.err==0){
                $('.logPanel h3').after("<div class='success'>"+response.log+"</div>");
            }else{
                $('.logPanel h3').after("<div class='fail'>"+response.log+"<span>"+response.err+"</span></div>");
            }
            $(el).parent().parent().html(response.row);
        });
}

function upLoadAll() {
    $(".optionsPanel").preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    })
    $.get( "?action=upLoadAll"+"&prefixTag="+$(".optionsPanel [name='prefixTag']").val()+
        "&dateTag="+$(".optionsPanel [name='dateTag']").prop("checked") )
        .done(function( data ) {
            $(".optionsPanel").preloader("remove");
            var response=JSON.parse(data);
            if(response.err==0){
                $('.logPanel h3').after("<div class='success'>"+response.log+"</div>");
            }else{
                $('.logPanel h3').after("<div class='fail'>"+response.log+"<span>"+response.err+"</span></div>");
            }


        });
    refreshTables();
}

function refreshTables(){

    $('.tablesList').preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    });
    $.get( "/admin/tables/", {action: "refreshTables"} )
        .done(function( data ) {
            $('.tablesList').html(data);
            $('.tablesList').preloader('remove');
        });
}

function showLog(){
    $('.modal, .modal .overlay').css({'opacity': 1, 'visibility': 'visible'});
}