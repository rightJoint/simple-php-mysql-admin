<?php
include ($_SERVER["DOCUMENT_ROOT"]."/application/views/admin/includeFunction.php");
echo "<form class='form-option filter' enctype='multipart/form-data' method='post'>".
    "<div class='form-option-cntrl'>".
    "<input type='button' value='addOne' onclick='editRecord(null, 1)'>".
    "<input type='button' value='applyFilter' onclick='filterRecords()'>".
    "</div>";

foreach ($inclContent as $columnNane=>$cData){
    echo "<div class='form-option-line'>" .
        "<label for='".$columnNane."' ";
    if($cData["indexes"]){
        echo "class='pk'";
    }elseif ($cData["DATA_TYPE"]=="tinyint"){
        echo "class='tinyint'";
    }else{
        echo "class='zp'";
    }
    echo ">". $columnNane . ":</label>" .
        getTnputType($cData["DATA_TYPE"], $columnNane, null, null, 0, 0).
        "</div>";
}
echo "<div class='form-option-line'>" .
    "<label for='Limit_1' class='lm'>LIMIT_1:</label>" .
    "<input type='number' name='limit_1' value='0'>".
    "</div>".
    "<div class='form-option-line'>" .
    "<label for='Limit_2' class='lm'>LIMIT_2:</label>" .
    "<input type='number' name='limit_2' value='100'>".

    "<div class='form-option-cntrl'><input type='button' value='applyFilter' onclick='filterRecords()'></div>" .
    "</form>";