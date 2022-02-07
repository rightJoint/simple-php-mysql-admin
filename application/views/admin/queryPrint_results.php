<?php
$return['result']=true;
if($inclContent->rowCount() > 0){
    $return['log']= "SUSSES: (".$inclContent->rowCount().") rows";
    $return['table'].= "<table>";
    $queryPosting_row = $inclContent->fetch(PDO::FETCH_ASSOC);
    $return['table'].="<tr class='caption'>";
    foreach ($queryPosting_row as $key=>$value){
        $return['table'].="<td>".$key."</td>";
    }
    $return['table'].="</tr><tr>";
    foreach ($queryPosting_row as $key=>$value){
        $return['table'].="<td>".$value."</td>";
    }
    $return['table'].="</tr>";
    if($inclContent->rowCount() >1){
        while ($queryPosting_row = $inclContent->fetch(PDO::FETCH_ASSOC)){
            $return['table'].="<tr>";
            foreach ($queryPosting_row as $key=>$value){
                $return['table'].="<td>".$value."</td>";
            }
            $return['table'].="</tr>";
        }
    }
    $return['table'].= "</table>";
}else{
    $return['log']= "SUSSES: - rows";
}
