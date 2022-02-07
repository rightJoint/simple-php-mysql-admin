<?php
echo "<div class='contentBlock-frame'><div class='contentBlock-center'><div class='contentBlock-wrap'>".
    "<div class='add-user'>".
    "<h2>Add admin-user</h2>".
    "<form class='form-option'>".
    "<div class='form-option-line'>".
    "<label for='newUsrName'>newUsrName: </label>".
    "<input type='text' name='newUsrName'>".
    "</div>".
    "<div class='form-option-line'><label for='newUsrPass'>newUsrPass: </label>".
    "<input type='password' name='newUsrPass'>".
    "</div>".
    "<div class='form-option-cntrl'>".
    "<input type='button' value='addNewUsr' onclick='addNewUser()'></div>".
    "<div class='result-info'></div>".
    "</div>".
    "</form>".
    "</div>".
    "<div class='usersList'>";
 include ($_SERVER["DOCUMENT_ROOT"]."/application/views/admin/users_list.php");

echo "</div></div></div>";