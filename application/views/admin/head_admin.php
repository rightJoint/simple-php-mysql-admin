<?php
echo "<!DOCTYPE html>".
    "<html lang='en-Us'>".
    "<head>".
    "<meta http-equiv='content-type' content='text/html; charset=utf-8'/>".
    "<meta name='viewport' content='width=device-width, initial-scale=1.0'>".
    "<meta name='description' content='".$data["head"]["description"]."'/>".
    "<meta name='robots' content='noindex'>".
    "<title>".$data["head"]["title"]."</title>".
    "<link rel='SHORTCUT ICON' href='".$data["head"]["shortcut_icon"]."' type='image/png'>";
foreach ($data["head"]["styles"] as $style => $stLink){
    echo "<link rel='stylesheet' href='".$stLink."' type='text/css' media='screen, projection'/>";
}
foreach ($data["head"]["scripts"] as $script => $scrSrc){
    echo "<script src='".$scrSrc."'></script>";
}
echo "</head>";