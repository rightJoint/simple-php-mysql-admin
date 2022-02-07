<?php
echo "<div class='contentBlock-frame'><div class='contentBlock-center'><div class='contentBlock-wrap'>".
    "<div class='statusPanel'>".
    "<h2>State:</h2><div class='lineBlock'>";
if($inclContent["connRes"]==true){
    echo "<span>Connection to SQL - database:</span><span class='statusOk'>Established</span>";
}else{
    echo "<span>Problem to connect SQL - database:</span><span class='statusFail'>FAIL</span>".
        "<p>debug info: <br>";
    if(!file_exists($_SERVER["DOCUMENT_ROOT"].$inclContent["pathToConn"])){
        echo "Cant read connection file: ".$inclContent["pathToConn"]." ";
    }
    if($inclContent["connErr"]){
        echo "<div class='result-info fail'>".$inclContent["connErr"]."</div>";
    }

    echo "</p>";
}
echo "</div>".
    "</div>".
    "<div class='settingsPanel'>".
    "<form class='form-option' enctype='multipart/form-data' method='post'>".
    "<h2>Settings:</h2>".
    "<input type='hidden' name='saveFlag' value='y'>";
foreach ($inclContent["connSettings"] as $opt => $oVal) {
    echo "<div class='form-option-line'>" .
        "<label>" . $opt . ":</label>";
    if($opt == "CONN_DB"){
        echo "<input type='text' name='" . $opt . "' list='dbname' value='".$oVal."'>".
            "<datalist id='dbname'>";
            while ($dbRow = $inclContent["dbList"]->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='".$dbRow["Database"]."' ";
                echo ">";
            }
    }else{
        echo "<input type='text' name='" . $opt . "' value='" . $oVal . "'>";
    }



        echo "</div>";
}
echo "<div class='form-option-cntrl'><input type='submit' name='saveCon' value='Save'></div>" .
    "</div>";


echo "</form>".
    "</div></div></div>";