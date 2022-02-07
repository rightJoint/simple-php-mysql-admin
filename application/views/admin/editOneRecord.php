<?php
$h2 = "edit one record of ";
$jsParam = 1;
$btn_text = "Update";
if($inclContent["addOneRecFlag"]){
    $h2 = "add one record to ";
    $jsParam = 2;
    $btn_text="addOne";
}
echo "<h2> ".$h2.$inclContent["tableName"]."</h2>";

include ($_SERVER["DOCUMENT_ROOT"]."/application/views/admin/includeFunction.php");

echo "<div class='form-option-cntrl'><input type='button' value='".$btn_text."' onclick='updoRec(".$jsParam.")'></div>";

foreach ($inclContent["structure"] as $columnName=>$cData){
    echo "<div class='form-option-line'>" .
        "<label for='".$columnName."' ";
    $readonly = null;
    if($cData["indexes"]){
        echo "class='pk'";
        if($jsParam == 1){
            $readonly = " readonly ";
        }
    }elseif ($cData["DATA_TYPE"]=="tinyint"){
        echo "class='tinyint'";
    }
    echo ">" . $columnName . ":</label>".
        getTnputType($cData["DATA_TYPE"], $columnName,"oneRec", null, $cData["curVal"], 1, $readonly).
        "</div>";
}

echo "<div class='form-option-cntrl'>";

if($jsParam != 2){
    echo "<input type='button' value='del' onclick='updoRec(3)'>";
}

echo "<input type='button' value='".$btn_text."' onclick='updoRec(".$jsParam.")'>".
    "</div>";
