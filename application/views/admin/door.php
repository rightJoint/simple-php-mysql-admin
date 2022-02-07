<?php
require_once ($_SERVER["DOCUMENT_ROOT"]."/application/views/admin/head_admin.php");
echo "<div class='adminDoor'>".
    "<form method='post' autocomplete='off'>".
    "<h1>Log in Admin</h1>";
if(isset($_SESSION['groups']['root']) and $_SESSION['groups']['root']===999){
    echo "<div class='bdUsrPanel'>You are: <strong>".$_SESSION['usrLogin']."</strong>".
        "<a href='?cmd=exit' class='exit'>Quit</a></div>";
}
if ($data["authErr"]){
    echo "<div class='pagewarning'>".$data["authErr"]."</div>";
}
echo "<input type='text' name='login' value='".$_POST['login']."' placeholder='Login...'>".
    "<input type='password' name='password' value='".$_POST["password"]."' placeholder='Password...'>".
    "<div class='btnBlock'><input type='submit' value='Submit'></div></form>".
    "</div>";