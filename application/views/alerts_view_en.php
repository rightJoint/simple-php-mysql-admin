<?php
echo"<div class='contentBlock-frame'><div class='contentBlock-center'>".
    "<div class='contentBlock-wrap'>".
    "<div class='err-wrap'>".
    "<div class='ew-warning'>".
    "At this page displaying catched errors. If you are here, something went wrong.".
    "</div>".
    "<span class='ew-txt'>Error occured</span>".
    "<span class='ew-code'>".$inclContent["code"]."</span>".
    "<span class='ew-h'>".$inclContent["h1"]."</span>";
if($inclContent["description"]){
    echo  "<div class='ew-detail'>".$inclContent["description"]."</div>";
}
echo "</div>".
    "</div>".
    "</div>".
    "</div>";