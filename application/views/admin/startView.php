<?php
echo "<div class='contentBlock-frame'><div class='contentBlock-center'><div class='contentBlock-wrap'>".
    "<p><strong>Use menu for beginning</strong></p><div class='contentMenu'>";
foreach ($data["adminModules"] as $key=>$value){
    $printMenuItem_flag=false;
    if ($data["connRes"]){
        $printMenuItem_flag=true;
    }elseif($key=="server" or $key=="adminUsers"or $key=="sql"){
        $printMenuItem_flag=true;
    }elseif($key=='sql' and $data["connRes"]){
        $printMenuItem_flag=true;
    }
    if($printMenuItem_flag){
        echo "<div class='contentCell'>".
            "<div class='contentCell-img'>".
            "<img src='".$value["img"]."'>".
            "</div><div class='contentCell-text'>".
            "<a href='/admin/".$key."/'>".$data["adminModules"][$key]['aliasMenu']."</a>".
            "<p>".$data["adminModules"][$key]['altText']."</p></div></div>";
    }
}
echo "</div></div></div></div>";