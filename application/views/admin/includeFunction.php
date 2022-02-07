<?php
function getTnputType($inputType, $name=null, $namespace=null, $id=null, $value=null, $option = 0, $readonly=null)
{
    //$inputType - like DATA_TYPE
    //$name - input name
    //$namespace - input namespace
    //$id - input id
    //$value - input value
    //$option - use text DATA_TYPE as input or textarea
    //$readonly - lock field

    if($id){
        $id_print = "id='".$id."'";
    }
    if($name){
        $name_print = "name=";
        if($namespace){
            $name_print .=$namespace."[".$name."]'";
        }else{
            $name_print .=$name;
        }
    }
    if(($option==0 and $value) or ($option==1 and isset($value))) {
        if ($inputType == "text" and $option == 1) {
            $value_print = $value;
        } else {
            $value_print = " value='" . $value . "'";

        }
    }

    if($inputType == "tinyint" or $inputType == "int"){
        return "<input type='number' ".$name_print." ".$id_print." ".$value_print." ".$readonly.">";
    }elseif (($inputType == "text" and $option==0) or $inputType == "datetime"
        or $inputType == "varchar" or $inputType == "time" or $inputType == "float"){
        return "<input type='text' ".$name_print." ".$id_print." ".$value_print." ".$readonly.">";
    }elseif ($inputType == "text" and $option==1){
        return "<label></label><textarea ".$name_print." ".$id_print.">".$value_print."</textarea>";
    }elseif ($inputType == "date"){
        return "<input type='date' ".$name_print." ".$id_print." ".$value_print." ".$readonly.">";
    }else{
        return $inputType;
    }
}