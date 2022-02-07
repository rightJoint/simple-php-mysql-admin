<?php
class Model_Admin{
    public $DB;
    public $connRes = false;
    public $pathToConn = "/source/_conf/db_conn.php";
    public $pathToUsrList ="/source/_conf/admin/adminUsers.php";
    public $tables = array(
        "tables" => null,
        "result" => array(
            "log" => null,
            "err" => null,
        ),
        "options" => array(
            "pathToTablesList" =>  "/data/db/tablesList/",  // create query files
            "pathToDbUpload" => "/data/db/",                // where from download/upload tables content
            "tableExtFile"=>".php",                         // create and download/upload files extension
            "lower_case_table_names" => true,               // use true on windows or false on linux
        ),
    );

    public $adminModules = array(
        "server" => array(
            "aliasMenu" => "Server",
            "altText" => "Set up connection to mySql server and database",
            "img" => "/img/admin/server_logo.jpg",
        ),
        "adminUsers" => array(
            "aliasMenu" => "Users",
            "altText" => "Users list, add or delete user",
            "img" => "/img/admin/adminUsers_logo.jpg",
        ),
        "sql" => array(
            "aliasMenu" => "SQL",
            "altText" => "SQL-injections. Execute query",
            "img" => "/img/admin/sql_logo.png",
        ),
        "tables" => array(
            "aliasMenu" => "Tables",
            "altText" => "Action with tables: create, drop, clear, upload, download",
            "img" => "/img/admin/tables_logo.png",
        ),
        "queryPrint" => array(
            "aliasMenu" => "Print query",
            "altText" => "Output of select query",
            "img" => "/img/admin/queryPrint_logo.png",
        ),
        "editRecords" => array(
            "aliasMenu" => "editRecords",
            "altText" => "Edit records, add records to tables",
            "img" => "/img/admin/editRecords.png",
        )
    );

    function __construct()
    {
        $this->adminDbConnect();
    }

    function adminDbConnect()
    {
        $this->DB = new DB($this->pathToConn);
        $this->connRes =  $this->DB->connectDb();
        if(!isset($this->DB->connSettings["CONN_LOC"])){
            $this->DB->connSettings["CONN_LOC"] = null;
        }
        if(!isset($this->DB->connSettings["CONN_USER"])){
            $this->DB->connSettings["CONN_USER"] = null;
        }
        if(!isset($this->DB->connSettings["CONN_PW"])){
            $this->DB->connSettings["CONN_PW"] = null;
        }
        if(!isset($this->DB->connSettings["CONN_DB"])){
            $this->DB->connSettings["CONN_DB"] = null;
        }
    }

    // find create query files for create option
    public function tables_init()
    {
        $this->tables["result"]['log'] = null;
        $this->tables["result"]['err'] = false;
        foreach (glob($_SERVER["DOCUMENT_ROOT"].$this->tables["options"]["pathToTablesList"]."*".$this->tables["options"]["tableExtFile"]) as $filename){
            $trimTableName = substr(basename($filename),0, strlen(basename($filename))-strlen($this->tables["options"]["tableExtFile"]));
            if($this->tables["options"]["lower_case_table_names"]){
                $this->tables["tables"][strtolower($trimTableName)]['list']=true;
            }else{
                $this->tables["tables"][$trimTableName]['list']=true;
            }
        }
    }

    // find tables in database and compare with create query files
    public function dbCompare()
    {
        $query_text = "SELECT TABLE_NAME, TABLE_ROWS FROM `information_schema`.`tables` WHERE
    `table_schema` = '".$this->DB->connSettings['CONN_DB']."';";
        $query_res = $this->DB->query($query_text);
        while ($query_row = $query_res->fetch(PDO::FETCH_ASSOC)) {
            $trimTableName = $query_row['TABLE_NAME'];
            if($this->tables["options"]["lower_case_table_names"]){
                $trimTableName = strtolower($trimTableName);
            }
            if($this->tables["tables"][$trimTableName]["list"]){
                $this->tables["tables"][$trimTableName]['exist'] = true;
                $this->tables["tables"][$trimTableName]['qty'] = $query_row['TABLE_ROWS'];
            }else{
                $this->tables["tables"][$query_row['TABLE_NAME']]["list"] = false;
                $this->tables["tables"][$query_row['TABLE_NAME']]['exist'] = true;
                $this->tables["tables"][$query_row['TABLE_NAME']]['qty'] = $query_row['TABLE_ROWS'];
            }
        }
    }

    public function get_data()
    {
        return array(
            "head" => array(
                "title" => "Admin-home",
                "description" => "Admin-home",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/default.css",
                    "/css/admin/header.css",
                    "/css/admin/startView.css",
                ),
                "scripts"=>array(
                    "/source/js/googleapis.js",
                    "/js/admin/adminHeader.js",
                )
            ),
            "h1" => "Admin-home",
            "includes" => array(
                "application/views/admin/startView.php" => null,
            ),
            "adminModules" => $this->adminModules,
            "connRes"=>$this->connRes,
        );
    }
    public function door_data()
    {
        return array(
            "head" => array(
                "title" => "LogIn Admin",
                "description" => "LogIn Admin",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/door.css",
                ),
                "scripts"=>array(
                )
            ),
            "h1" => "LogIn Admin",
            "includes" => array(
                "application/views/admin/door.php" => null,
            ),
        );
    }

    public function server_data()
    {
        $dbList = $this->DB->query("SHOW DATABASES;");

        return array(
            "head" => array(
                "title" => "Server",
                "description" => "Set up connection to mySql server and database",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/default.css",
                    "/css/admin/header.css",
                    "/css/admin/server.css",
                ),
                "scripts"=>array(
                    "/source/js/googleapis.js",
                    "/js/admin/adminHeader.js",
                )
            ),
            "h1" => "Server",
            "includes" => array(
                "application/views/admin/server_view.php" => array(
                    "connRes"=>$this->connRes,
                    "connErr"=>$this->DB->err,
                    "connSettings" =>$this->DB->connSettings,
                    "pathToConn" =>$this->pathToConn,
                    "dbList"=>$dbList,
                ),
            ),
            "adminModules" => $this->adminModules,
            "connRes"=>$this->connRes,
        );
    }

    public function queryPrint_data()
    {
        return array(
            "head" => array(
                "title" => "printQuery",
                "description" => "Output of select query",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/default.css",
                    "/css/admin/header.css",
                    "/css/admin/sql.css",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/css/preloader.css",
                ),
                "scripts"=>array(
                    "/source/js/googleapis.js",
                    "/js/admin/adminHeader.js",
                    "/js/admin/queryPrint.js",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/js/jquery.preloader.min.js",
                )
            ),
            "h1" => "printQuery",
            "includes" => array(
                "application/views/admin/queryPrint_view.php" => null,
            ),
            "adminModules" => $this->adminModules,
            "connRes"=>$this->connRes,
        );
    }

    public function sql_data()
    {
        return array(
            "head" => array(
                "title" => "Sql",
                "description" => "SQL-injections. Execute query",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/default.css",
                    "/css/admin/header.css",
                    "/css/admin/sql.css",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/css/preloader.css",
                ),
                "scripts"=>array(
                    "/source/js/googleapis.js",
                    "/js/admin/adminHeader.js",
                    "/js/admin/sql.js",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/js/jquery.preloader.min.js",
                )
            ),
            "h1" => "Sql",
            "includes" => array(
                "application/views/admin/sql_view.php" => null,
            ),
            "adminModules" => $this->adminModules,
            "connRes"=>$this->connRes,
        );
    }

    public function adminUsers_data()
    {
        return array(
            "head" => array(
                "title" => "AdminUsers",
                "description" => "Add or delete admin user",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/default.css",
                    "/css/admin/header.css",
                    "/css/admin/users.css",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/css/preloader.css",
                ),
                "scripts"=>array(
                    "/source/js/googleapis.js",
                    "/js/admin/adminHeader.js",
                    "/js/admin/users.js",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/js/jquery.preloader.min.js",
                )
            ),
            "h1" => "AdminUsers",
            "includes" => array(
                "application/views/admin/users.php" => array(
                    "pathToUsrList" =>$this->pathToUsrList,
                ),
            ),
            "adminModules" => $this->adminModules,
            "connRes"=>$this->connRes,
        );
    }

    public function tables_data()
    {
        $this->tables_init();
        $this->dbCompare();
        return array(
            "head" => array(
                "title" => "tables",
                "description" => "Action with tables: create, drop, clear, upload, download",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/default.css",
                    "/css/admin/header.css",
                    "/css/admin/tables.css",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/css/preloader.css",
                ),
                "scripts"=>array(
                    "/source/js/googleapis.js",
                    "/js/admin/adminHeader.js",
                    "/js/admin/tables.js",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/js/jquery.preloader.min.js",
                )
            ),
            "h1" => "tables",
            "includes" => array(
                "application/views/admin/table_view.php" => $this->tables,
            ),
            "adminModules" => $this->adminModules,
            "connRes"=>$this->connRes,
        );
    }

    public function editRecords_data()
    {
        $this->tables_init();
        $this->dbCompare();
        return array(
            "head" => array(
                "title" => "Edit records",
                "description" => "Edit records, add records to tables",
                "shortcut_icon" => "/img/admin/admin.png",
                "styles" => array(
                    "/css/admin/default.css",
                    "/css/admin/header.css",
                    "/css/admin/tables.css",
                    "/css/admin/sql.css",
                    "/css/admin/editRecord.css",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/css/preloader.css",
                ),
                "scripts"=>array(
                    "/source/js/googleapis.js",
                    "/js/admin/adminHeader.js",
                    "/js/admin/editRecords.js",
                    "/source/js/Elegant-Loading-Indicator-jQuery-Preloader/src/js/jquery.preloader.min.js",
                )
            ),
            "h1" => "Edit records",
            "includes" => array(
                "application/views/admin/editRecords_view.php" => $this->tables,
            ),
            "adminModules" => $this->adminModules,
            "connRes"=>$this->connRes,
        );
    }

    public function uploadAllTables()
    {
        $return = array(
            "log" => null,
            "err" => false,
        );
        $start_time = microtime(true);
        $return['log'].="Action: upLoadAll<br>";
        $orderBy=null;
        $return['log'].="prefixTag=".$_GET['prefixTag']."<br>dateTag=".$_GET["dateTag"]."<br>";
        foreach ($this->tables["tables"] as $table => $value) {
            if ($this->tables["tables"][$table]['exist'] === true) {
                $query_text = "select * from " . $table . " " . $orderBy;
                $query_res = $this->DB->query($query_text);
                if ($query_res->rowCount() == 0) {
                    $return['log'].= $table . "-->> nothing to upload<br>";
                } else {

                    $result = $this->uploadTable($table, $_GET['prefixTag'], $_GET["dateTag"], $this->tables["options"]["tableExtFile"]);
                    $return['log'].=$result["log"];
                }
            }
        }
        $return['log'].= date('Y-m-d H:i:s').'</br>';
        $end_time = microtime(true);
        $return['log'].= 'lead time: '.($end_time-$start_time);
        return $return;
    }

    public function uploadTable($tableName, $prefixTag, $dateTag, $extension = ".php"){
        $orderBy=null;

        $return=array(
            "log" => null,
            "err" => 0,
        );

        $query_text = "select * from ".$tableName." ".$orderBy;
        $query_res = $this->DB->query($query_text);
        if ($query_res->rowCount() == 0){
            $return['log'].= "nothing to upload<br>";
        }else
        {
            $queryToInsert = null;
            $queryToInsert_temp = "(";
            $queryToInsert .= "insert into ".$tableName." (\r";
            $query_row = $query_res->fetch(PDO::FETCH_ASSOC);
            foreach ($query_row as $key => $value) {
                if ($value == null) {
                    $queryToInsert_temp .= "null, ";
                } else {
                    $queryToInsert_temp .= "'" . $value . "', ";
                }
                $queryToInsert .= $key . ", ";
            }
            $queryToInsert = substr($queryToInsert, 0, strlen($queryToInsert) - 2) . ")\r values \r";
            $queryToInsert_temp = substr($queryToInsert_temp, 0, strlen($queryToInsert_temp) - 2) . "), \r";
            $queryToInsert .= $queryToInsert_temp;
            while ($query_row = $query_res->fetch(PDO::FETCH_ASSOC)) {
                $queryToInsert .= "(";
                foreach ($query_row as $key => $value) {
                    if ($value == null) {
                        $queryToInsert .= "null, ";
                    } else {
                        $queryToInsert .= "'" . $value  . "', ";
                    }
                }
                $queryToInsert = substr($queryToInsert, 0, strlen($queryToInsert) - 2) . "), \r";
            }
            $queryToInsert = substr($queryToInsert, 0, strlen($queryToInsert) - 3);
            if($prefixTag){
                $file = htmlspecialchars($prefixTag)."-".$tableName;
            }else{
                $file = $tableName;
            }
            if($dateTag=='true'){
                $file .="_".date( 'Ymd_His');
            }
            $file.=$extension;
            if(!file_put_contents($_SERVER["DOCUMENT_ROOT"]."/".$this->tables["options"]["pathToDbUpload"].$file, $queryToInsert)){
                $return['err'].= $tableName."--> cant write file";
            }else{
                $return['log'].= $tableName."--> success<br>";
            }
        }
        return $return;
    }

    public function clearTable($tableName)
    {
        return $this->DB->query("delete from ".$tableName);
    }

    public function createTable($tableName){
        require_once ($_SERVER["DOCUMENT_ROOT"].$this->tables["options"]["pathToTablesList"].$tableName.$this->tables["options"]["tableExtFile"]);
        return $this->DB->query("create table ".$tableName." ".$query_text);
    }

    public function downloadTable($tableName)
    {
        if($queryToInsert=@file_get_contents( $tableName)){
            return $this->DB->query($queryToInsert);
        }else{
            return false;
        }
    }

    public function dropTable($tableName)
    {
        return $this->DB->query("drop table ".$tableName);
    }



    function makeRecFilter()
    {
        $filter_qry = "select * from ".$_POST["tableName"]." ";
        $indexes_res = $this->DB->query("SHOW INDEXES IN ".$_POST["tableName"]);
        $indexes = array();

        while ($indexes_row = $indexes_res->fetch(PDO::FETCH_ASSOC)){
            $indexes[]=$indexes_row["Column_name"];
        }

        $varchar_res  = $this->DB->query("SELECT COLUMN_NAME, DATA_TYPE from INFORMATION_SCHEMA.COLUMNS ".
            "where table_schema = '". $this->DB->connSettings["CONN_DB"]."' and table_name = '".$_POST["tableName"]."' and (DATA_TYPE='varchar' or DATA_TYPE='text')");
        $varchar = array();

        while ($varchar_row = $varchar_res->fetch(PDO::FETCH_ASSOC)){
            $varchar[]=$varchar_row["COLUMN_NAME"];
        }

        $filter_where = null;

        foreach ($_POST as $k=>$v) {
            if(!in_array($k, array("tableName", "applyFilterRec", "limit_1", "limit_2")) ){
                if($v){
                    if(in_array($k, $varchar)){
                        $filter_where.=$k." like '%".$v."%' and ";
                    }else{
                        $filter_where.=$k."='".$v."' and ";
                    }
                }
            }
        }

        if($filter_where){
            $filter_where = " where ".$filter_where;
        }

        $filter_where = substr($filter_where, 0 , strlen($filter_where)-4);
        $filter_qry.=$filter_where;
        $filter_qry.= " limit ";
        $lm_1 = 0;
        $lm_2 = 100;

        if($_POST["limit_1"]){
            $lm_1 = $_POST["limit_1"];
        }
        if($_POST["limit_2"]){
            $lm_2 = $_POST["limit_2"];
        }

        $filter_qry.= $lm_1.", ".$lm_2;

        return array(
            "indexes" => $indexes,
            "table" =>$this->DB->query($filter_qry),
        );
    }

    public function prepareEditRec($tableName)
    {
        $Record = $this->DB->getRecordStructure($tableName);

        foreach ($_POST as $pKey=>$pVal){
            if(!in_array($pKey, array("editRec", "tableName", "addOneFlag"))){
                $Record[$pKey]["curVal"] = $pVal;
            }
        }

        return $this->DB->copyRecord($tableName, $Record);
    }
}