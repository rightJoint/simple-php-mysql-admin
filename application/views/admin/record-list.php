<?php
$return['result']=true;
if($inclContent["table"]){
    $return['log']= "SUSSES: (".$inclContent["table"]->rowCount().") rows";
    $return['table'].= "<table>";
    $queryPosting_row = $inclContent["table"]->fetch(PDO::FETCH_ASSOC);
    if($queryPosting_row){
        $return['table'].="<tr class='caption'>";
        foreach ($queryPosting_row as $key=>$value){
            $return['table'].="<td>".$key."</td>";
        }
        $key_str = null;
        foreach ($inclContent["indexes"] as $index){
            $key_str .= $index."=".$queryPosting_row[$index]."&";
        }
        $key_str = substr($key_str, 0,strlen($key_str)-1);

        $return['table'].="</tr><tr>";
        foreach ($queryPosting_row as $key=>$value){
            $key_str = null;
            foreach ($inclContent["indexes"] as $index){
                $key_str .= $index."=".$queryPosting_row[$index]."&";
            }
            $key_str = substr($key_str, 0,strlen($key_str)-1);
            $return['table'].="<td>";
            if(in_array($key, $inclContent["indexes"])){
                $return['table'].= "<a href='javascript: void()' onclick='editRecord(\"$key_str\")'>".$value."</a>";
            }else{
                $return['table'].= $value;
            }

            $return['table'].="</td>";
        }
        $return['table'].="</tr>";
        if($inclContent["table"]->rowCount() >1){
            while ($queryPosting_row = $inclContent["table"]->fetch(PDO::FETCH_ASSOC)){
                $key_str = null;
                foreach ($inclContent["indexes"] as $index){
                    $key_str .= $index."=".$queryPosting_row[$index]."&";
                }
                $key_str = substr($key_str, 0,strlen($key_str)-1);

                $return['table'].="<tr>";

                foreach ($queryPosting_row as $key=>$value){
                    $return['table'].="<td>";
                    if(in_array($key, $inclContent["indexes"])){
                        $return['table'].= "<a href='javascript: void(0)' onclick='editRecord(\"$key_str\", 0)'>".$value."</a>";
                    }else{
                        $return['table'].= $value;
                    }
                }
                $return['table'].="</tr>";
            }
        }
    }

    $return['table'].= "</table>";
}else{
    $return['log']= "SUSSES: - rows ";
}
echo $return['log'].$return['table'];