<?php
require_once ($_SERVER["DOCUMENT_ROOT"]."/application/views/admin/head_admin.php");
echo "<body>".
    "<div class='page-wrap'>";
require_once ($_SERVER["DOCUMENT_ROOT"]."/application/views/admin/header_admin.php");
foreach ($data["includes"] as $inclFile => $inclContent){
    include $inclFile;
}
echo "<div class='contentBlock-frame dark ft'><div class='contentBlock-center'>".
    "<div class='contentBlock-wrap'>";
require_once ($_SERVER["DOCUMENT_ROOT"]."/application/views/admin/footer_admin.php");
echo "</div></div></div>".
    "</div>".
    "</body>"."</html>";