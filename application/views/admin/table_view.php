<?php
echo "<div class='contentBlock-frame'><div class='contentBlock-center'><div class='contentBlock-wrap'>".
    "<div class='optionsPanel'><div class='uploadOptions'>".
    "<label for='prefixTag'>pefix</label><input type='text' name='prefixTag'>".
    "<label for='dateTag'>dateTag</label>".
    "<input type='checkbox' name='dateTag' checked>".
    "</div>".
    "<div class='btnPanel'>".
    "<input type='button' class='uploadAll' value='upLoadAll' onclick='upLoadAll()'>".
    "<input type='button' class='refresh' value='refresh' onclick='refreshTables()'>".
    "<input type='button' class='showLog' value='Log' onclick='showLog()'>".
    "</div></div>".
    "</div></div></div>".
    "<div class='contentBlock-frame'><div class='contentBlock-center'><div class='contentBlock-wrap'>".
    "<div class='tablesList'>";
require_once($_SERVER["DOCUMENT_ROOT"] . "/application/views/admin/tables_list.php");
echo "</div></div></div></div>".
    "<div class='modal'><div class='overlay'></div><div class='contentBlock-frame'><div class='contentBlock-center'>".
    "<div class='modal-right'><img src='/img/admin/closeModal.png' title='закрыть'></div>".
    "<div class='logPanel'><h3>action log:</h3></div>".
    "</div></div></div>";