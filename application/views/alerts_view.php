<?php
echo"<div class='contentBlock-frame'><div class='contentBlock-center'>".
    "<div class='contentBlock-wrap'>".
    "<div class='err-wrap'>".
    "<div class='ew-warning'>".
    "На этой странице отображаются ошибки, перехваченные приложением. Если вы здесь, значит что-то пошло не так.".
    "</div>".
    "<span class='ew-txt'>ОШИБКА</span>".
    "<span class='ew-code'>".$inclContent["code"]."</span>".
    "<span class='ew-h'>".$inclContent["h1"]."</span>";
if($inclContent["description"]){
    echo  "<div class='ew-detail'>".$inclContent["description"]."</div>";
}
echo "</div>".
    "</div>".
    "</div>".
    "</div>";