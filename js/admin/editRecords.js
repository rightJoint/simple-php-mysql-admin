function prepareFilters() {
    var posting = $.post( "", "tableSelector="+$("#table-selector").val());
    $(".er-wrap").preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    });
    posting.done(function( data ) {
        $(".table-filter").html(data);
        $(".query-result-table").html(null);
        $('.er-wrap').preloader('remove');
    });

}
function filterRecords() {
    var posting = $.post( "", "applyFilterRec=1&tableName="+$("#table-selector").val()+"&"+$(".form-option.filter").serialize());
    $(".er-wrap").preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    });
    posting.done(function( data ) {
        $(".query-result-table").html(data);
        $('.er-wrap').preloader('remove');
    });
}
function editRecord(keyVal, addFlag) {
    //shows form for edit and add record
    var reqParams =  "editRec=1&tableName=" + $("#table-selector").val() + "&";
    if(addFlag == 1){
        reqParams+="addOneFlag=1";
    }else{
        reqParams+=keyVal;
    }
    $("#id01").css("display", "block");
    $("#id01").css("visibility", "visible");
    var posting = $.post("",reqParams);
    $(".form-option.modal-content").preloader({
        text: 'loading',
        percent: '',
        duration: '',
        zIndex: '',
        setRelative: true
    });
    posting.done(function (data) {
        $(".form-option.modal-content .result-info").html('');
        $("#id01 .edit-rec-fields").html(data);
        //$(".query-result-table").html(data);
        //$('.er-wrap').preloader('remove');
        $('.form-option.modal-content').preloader('remove');
    });



}

function updoRec(param) {
    let cancelAction = false;
    if(param==3){
        let text = "Are you sure to delete record?";
        if (confirm(text) != true) {
            cancelAction = true;
        }
    }
    if(!cancelAction){
        var posting = $.post("", "editRecFlag="+param+"&tableName=" + $("#table-selector").val() + "&"+$(".form-option.modal-content").serialize());

        $(".form-option.modal-content").preloader({
            text: 'loading',
            percent: '',
            duration: '',
            zIndex: '',
            setRelative: true
        });


        posting.done(function (data) {
            var response=JSON.parse(data);

            if(response.result==1){
                $(".form-option.modal-content .result-info").html(response.log);
                $(".form-option.modal-content .result-info").removeClass("fail");
                $(".form-option.modal-content .result-info").addClass("well");
            }else{
                $(".form-option.modal-content .result-info").html(response.log);
                $(".form-option.modal-content .result-info").removeClass("well");
                $(".form-option.modal-content .result-info").addClass("fail");
            }


        });
        $('.form-option.modal-content').preloader('remove');
    }
}