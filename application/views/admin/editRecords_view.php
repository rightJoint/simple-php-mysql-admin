<?php
echo "<div class='contentBlock-frame'><div class='contentBlock-center'>".
    "<div class='contentBlock-wrap'>".
    "<div class='er-wrap'>".
    "<div class='table-selector'>".
    "<form class='form-option tbl-shift'>".
    "<label>Shift table:</label>".
    "<select id='table-selector' onchange='prepareFilters()'>";
foreach ($inclContent["tables"] as $tableName=>$tData){
    if($tData["exist"]){
        echo "<option value='".$tableName."'>".$tableName."</option>";
    }
}
echo "</select></form></div>".
    "<div class='table-filter'>1. choose table to set filter options</div>".
    "<div class='query-result-table'>".
    "2. apply filter to display records-list<br>".
    "3. Click on key field to edit record<br>".
    "</div>".
    "</div>".
    "</div></div></div>".






    "<div class='fo-wrap'>".
    "<div id='id01' class='modal'>".
    "<form class='modal-content form-option animate'>"."<div class='imgcontainer'>".
    "<span ".
    "onclick='document.getElementById(".'"id01"'.").style.display=".'"none"'."'".
    " class='close' title='Закрыть'>&times;</span>".
    "</div>".
    "<div class='result-info well'></div>".
    "<div class='edit-rec-fields'></div>".



    "</form>".
    "</div>".
    "</div>";


