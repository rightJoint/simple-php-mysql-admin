<?php
echo "<h2>Users list</h2>".
"<div class='usersList-line caption'>".
"<div class='usersList-line-name'>usersName</div>".
"<div class='usersList-line-del'>delUser</div>".
"</div>";

$bdUsers=json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].$inclContent["pathToUsrList"]));
foreach ($bdUsers as $usr=>$pw){
    echo "<div class='usersList-line'>".
        "<div class='usersList-line-name'>".$usr."</div>".
        "<div class='usersList-line-del'>".
        "<img src='/img/admin/drop-icon.png' onclick='dropAdminUsr(".'"'.$usr.'"'.")'>".
        "</div>".
        "</div>";
}