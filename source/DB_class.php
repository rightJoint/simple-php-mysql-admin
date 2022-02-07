<?php
class DB extends PDO
{
    public $err = null;
    public $pathToConn;
    public $connSettings;

    function __construct($pathToConn){
        $this->pathToConn = $pathToConn;
        if(!$this->connSettings=json_decode(@file_get_contents($_SERVER["DOCUMENT_ROOT"].$this->pathToConn), true)){
            $this->err = true;
        }
    }

    function connectDb()
    {
        try {
            parent::__construct('mysql:host='.$this->connSettings["CONN_LOC"].';',
                $this->connSettings["CONN_USER"], $this->connSettings["CONN_PW"]);
            if($this->query("use ".$this->connSettings["CONN_DB"])){
                return true;
            }else {
                $this->err = "use database error";
                return false;
            }
        }catch (Exception $e) {
            $this->err = $e->getMessage();
        }
    }

    public function getRecordStructure($tableName, $fileStructure_path = null){
        $Record = array();
        if($fileStructure_path){
            //parse create table file
        }else{
            $datatype_res  = $this->query("SELECT COLUMN_NAME, DATA_TYPE from INFORMATION_SCHEMA.COLUMNS ".
                "where table_schema = '". $this->connSettings["CONN_DB"]."' and table_name = '".$tableName."'");

            if($datatype_res){
                while ($datatype_row = $datatype_res->fetch(PDO::FETCH_ASSOC)){
                    $Record[$datatype_row["COLUMN_NAME"]]["indexes"] = 0;
                    $Record[$datatype_row["COLUMN_NAME"]]["DATA_TYPE"] = $datatype_row["DATA_TYPE"];
                }
            }

            $indexes_res = $this->query("SHOW INDEXES IN ".$tableName);
            if($indexes_res){
                while ($indexes_row = $indexes_res->fetch(PDO::FETCH_ASSOC)){
                    $Record[$indexes_row["Column_name"]]["indexes"] = 1;
                }
            }
        }
        return $Record;
    }

    public function copyRecord($tableName, $Record){
        $query_text="select * from ".$tableName." where ";
        foreach ($Record as $fieldName=>$fieldInfo) {
            if ($fieldInfo["indexes"]) {
                $query_text.=$fieldName."='".$fieldInfo["curVal"]."' and " ;
            }
        }
        $query_text = substr($query_text, 0, strlen($query_text)-4);
        $query_res = $this->query($query_text);
        if($query_res->rowCount()===1){
            $result=$query_res->fetch(PDO::FETCH_ASSOC);
            foreach ($Record as $fieldName=>$fieldInfo) {
                $Record[$fieldName]["curVal"] = $result[$fieldName];
                $Record[$fieldName]["fetchVal"] = $result[$fieldName];
            }
            return array(
                "result"=>1,
                "log"=>"copyRecord success",
                "record"=>$Record,
            );
        }else{
            return array(
                "result"=>0,
                "log"=>"copyRecord fail",
                "record"=>$Record,
            );
        }
    }

    function insertRecord($tableName, $Record){
        $insert_qry = "insert into ".$tableName." (";
        $insert_fields = null;
        $insert_values = null;
        foreach ($Record as $fieldName=>$fieldInfo) {
            $insert_fields.=$fieldName.", ";
            if($fieldInfo["curVal"]==null){
                $insert_values.="null, ";
            }else{
                $insert_values.="'".$fieldInfo["curVal"]."', ";
            }
        }
        $insert_fields = substr($insert_fields, 0, strlen($insert_fields)-2);
        $insert_values = substr($insert_values, 0, strlen($insert_values)-2);
        $insert_qry.=$insert_fields.") values (".$insert_values.")";


        if($this->query($insert_qry)){

            foreach ($Record as $fieldName=>$fieldInfo) {
                if ($fieldInfo["indexes"]) {
                    $Record[$fieldName]["curVal"]=$this->lastInsertId($fieldName);
                }
            }
            return array(
                "result"=>1,
                "log"=>"insertRecord success",
                "record"=>$Record,
            );
        }

        return array(
            "result"=>0,
            "log"=>"insertRecord fail",
            "record"=>$Record,
        );
    }

    public function updateRecord($tableName, $Record){
        $query_text="update ".$tableName." set ";
        $q_where = " where ";
        $q_fields = null;
        foreach ($Record as $fieldName=>$fieldInfo) {
            if ($fieldInfo["indexes"]) {
                $q_where.=$fieldName."='";
                if($fieldInfo["fetchVal"]){
                    $q_where.=$fieldInfo["fetchVal"];
                }else{
                    $q_where.=$fieldInfo["curVal"];
                }
                $q_where.="' and " ;
            }else{
                if($fieldInfo["fetchVal"]!=$fieldInfo["curVal"]){
                    $q_fields.=$fieldName."=";
                    if($fieldInfo["curVal"]==null){
                        $q_fields.="null, ";
                    }else{
                        $q_fields.="'".$fieldInfo["curVal"]."', ";
                    }
                }
            }
        }

        $q_where = substr($q_where, 0, strlen($q_where)-4);
        $q_fields = substr($q_fields, 0, strlen($q_fields)-2);
        if($q_fields){
            if($this->query($query_text.$q_fields.$q_where)){
                return array(
                    "result"=>1,
                    "log"=>"updateRecord success",
                );
            }else{
                return array(
                    "result"=>0,
                    "log"=>"updateRecord updateOne query fail",
                );
            }
        }else{
            return array(
                "result"=>1,
                "log"=>"updateRecord nothing to update",
            );
        }
    }

    function deleteRecord($tableName, $Record){
        $q_where = null;
        foreach ($Record as $fieldName=>$fieldInfo) {
            if ($fieldInfo["indexes"]) {
                $q_where.=$fieldName."='".$fieldInfo["curVal"]."' and ";
            }
        }
        $q_where = substr($q_where, 0, strlen($q_where)-4);

        if($this->query("delete from ".$tableName." where ".$q_where)){
            return array(
                "result"=>1,
                "log"=>"deleteRecord success",
            );
        }else{
            return array(
                "result"=>0,
                "log"=>"deleteRecord fail",
            );
        }
    }
}