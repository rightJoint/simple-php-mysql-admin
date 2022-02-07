<?php
//echo "<pre>";
//print_r($inclContent["tables"]);
echo "<div class='table-line caption'><div class='table-cell tblName'>Table</div>".
    "<div class='table-cell tblLst'>Lst</div>".
    "<div class='table-cell tblExt'>Ext</div>".
    "<div class='table-cell tblAct'>action</div><div class='table-cell tblDwlTag'>target table</div></div>";
foreach ($inclContent["tables"] as $table=>$tData) {
    $inclContent["curTable"] = $table;
    echo "<div class='table-line'>";
    $return=null;
    include($_SERVER["DOCUMENT_ROOT"] . "/application/views/admin/table_cells.php");
    echo $return;
    echo "</div>";
}