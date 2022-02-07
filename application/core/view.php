<?php
class View
{
    function generate($content_view, $template_view, $data = null)
    {
        if($template_view == "template_view.php"){
            if($_SESSION["lang"]=="en"){
                $template_view = "template_view_en.php";
            }
        }
        include 'application/views/'.$template_view;
        global $mct, $server;
        $mct["end_time"] = microtime(true);
        echo "<script>$('body').after('<span style=".'"'.
            " color: silver; position: relative; bottom: 1.2em; left: 0,5em; ".
            " display: block; height:0; width:0; font-size:0.7em;".'"'.">".
            strval($mct['end_time']-$mct['start_time'])."</span>')</script>";
        unset($_SESSION["auth"]);
    }
    function generateJson($data)
    {
        echo json_encode($data, true);
    }
    function generateAjax($content_view=null, $template_view=null, $inclContent = null, $returnFlag = false)
    {
        if($content_view){
            include 'application/views/'.$content_view;
        }elseif($template_view){
            include 'application/views/'.$template_view;
        }else{
            echo $inclContent;
        }
        if($returnFlag){
            return $return;
        }
    }
}