<?php
global $server;

echo "<div class='contentBlock-frame dark'>".
    "<div class='contentBlock-center'><div class='contentBlock-wrap'><header>".
    "<div class='adminMenu'><img src='/img/menu-icon.png'><div class='adminMenu-link-frame'>".
    "<div class='adminMenu-link'><a href='/admin/'>Admin-home</a></div>";
foreach ($data["adminModules"] as $key=>$value){
    $printMenuItem_flag = false;
    $printMenuItem_flag = false;
    if ($data["connRes"]) {
        $printMenuItem_flag = true;
    } elseif ($key == "server" or $key == "adminUsers" or $key == "sql") {
        $printMenuItem_flag = true;
    }
    if ($printMenuItem_flag) {
        echo "<div class='adminMenu-link'>".
            "<a href='/admin/" . $key . "/'>" . $data["adminModules"][$key]['aliasMenu'] . "</a>".
            "</div>";
    }
}
echo "<div class='adminMenu-link'><a href='/'>Home (site)</a></div></div></div>".
    "<div class='avatar'>You are: ".$_SESSION['adminAlias']."</div><h1>";
if(!$server['reqUri_expl'][2]){
    echo "Admin-home";
}else{
    echo $data["adminModules"][$server['reqUri_expl'][2]]['aliasMenu'];
}
echo "</h1><div class='btnPanel'>".
    "<a class='exit' href='?cmd=exit'><img src='/img/exit.png'></a></div></header></div></div></div>";