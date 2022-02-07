<?php
class Controller_admin extends Controller
{

    function __construct()
    {
        $this->model = new Model_Admin();
        $this->view = new View();
        if(!$this->checkAccess()){
            exit;
        }
    }

    function checkAccess()
    {
        $pageErr = null;
        if(isset($_SESSION['groups']['root']) and $_SESSION['groups']['root']>10) {
            return true;
        }else{
            if((isset($_POST['login']) and $_POST['login']!=null) or (isset($_POST['password'])and $_POST['password']!=null)){
                $postErr=null;
                $bdUsers=json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].$this->model->pathToUsrList));
                foreach ($bdUsers as $usr=>$pw){
                    if($_POST['login']==$usr and hash_equals($pw, crypt($_POST['password'], $pw)))
                    {
                        $_SESSION['groups']['root']=999;
                        $_SESSION['adminAlias']=$_POST['login'];;
                        $page = "Location: /admin/";
                        header($page);
                    }
                }
                $pageErr='wrong login or password';
            }
            $data = $this->model->door_data();
            $data["authErr"] = $pageErr;
            $this->view->generate(null, 'admin/door.php', $data);
        }
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate(null, 'admin/template_admin.php', $data);
    }

    function action_server()
    {
        // submit server setting form
        if($_POST['saveFlag']=='y'){
            foreach($this->model->DB->connSettings as $key =>$value){
                $this->model->DB->connSettings[$key]=$_POST[$key];
            }
            file_put_contents($_SERVER["DOCUMENT_ROOT"].$this->model->DB->pathToConn, json_encode($this->model->DB->connSettings));
            $this->model->adminDbConnect();
        }

        $data = $this->model->server_data();
        $this->view->generate(null, 'admin/template_admin.php', $data);
    }

    function action_queryPrint()
    {
        if(isset($_POST['queryText'])){
            if($data = $this->model->DB->query($_POST['queryText']." LIMIT ".$_POST['qp-limit']))
            {
                $log = $this->view->generateAjax(null, "admin/queryPrint_results.php", $data, true);
            }else{
                $log["result"] = false;
                $log["err"] = "select query fail";
            }
            $this->view->generateJson($log);
        }else{
            $data = $this->model->queryPrint_data();
            $this->view->generate(null, 'admin/template_admin.php', $data);
        }
    }

    function action_sql()
    {
        if(isset($_POST['queryText'])){
            $queryPosting_text = $_POST['queryText'];
            $queryPosting['result']=false;
            $queryPosting['log']=null;

            if($queryPosting_res = $this->model->DB->query($queryPosting_text)){
                $queryPosting['result']=true;
                if($queryPosting_res->rowCount() > 0){
                    $queryPosting['log']= "SUSSES: (".$queryPosting_res->rowCount().") rows";
                }else{
                    $queryPosting['log']= "SUSSES: - rows";
                }
            }else{
                $queryPosting['log'] = "QUERY FAIL";
            }
            $this->view->generateJson($queryPosting);
        }else{
            $data = $this->model->sql_data();
            $this->view->generate(null, 'admin/template_admin.php', $data);
        }
    }

    function action_adminUsers(){
        if($_POST['addAdmUsrFlag']==='y'){
            $addUsrRes['result']=false;
            $addUsrRes['log']=null;
            include ($_SERVER["DOCUMENT_ROOT"]."/source/accessorial_class.php");
            if(accessorialClass::checkLogin($_POST['newUsrName'])){
                if(accessorialClass::checkPassword($_POST['newUsrPass'])){
                    $bdUsers=json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].$this->model->pathToUsrList), true);
                    $findDoubleUsr=false;
                    foreach ($bdUsers as $usr=>$pw){
                        if($usr==$_POST['newUsrName'])
                        {
                            $findDoubleUsr=true;
                            break;
                        }
                    }
                    if($findDoubleUsr){
                        $addUsrRes['log']='login reserved';
                    }else{
                        $bdUsers[$_POST['newUsrName']]=crypt($_POST['newUsrPass']);
                        if(file_put_contents($_SERVER["DOCUMENT_ROOT"].$this->model->pathToUsrList,
                            json_encode($bdUsers, true))){
                            $addUsrRes['result']=true;
                            $addUsrRes['log']='Success';
                        }else{
                            $addUsrRes['log']='password unacceptable';
                        }
                    }
                }else{
                    $addUsrRes['log'].="login unacceptable";
                }
            }else{
                $addUsrRes['log'].="login unacceptable 2";
            }
            $this->view->generateJson($addUsrRes);
        }elseif (isset($_GET['action']) and $_GET['action']=='refreshUsers'){
            $this->view->generateAjax(null, "admin/users_list.php", array("pathToUsrList"=>$this->model->pathToUsrList));
        }elseif (isset($_GET["dropUser"]) and $_GET["dropUser"]!=null){
            $bdUsers=json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].$this->model->pathToUsrList), true);
            unset($bdUsers[$_GET["dropUser"]]);
            if(file_put_contents($_SERVER["DOCUMENT_ROOT"]."/source/_conf/admin/adminUsers.php",
                json_encode($bdUsers, true))){
            }
            $this->view->generateAjax(null, "admin/users_list.php", array("pathToUsrList"=>$this->model->pathToUsrList));
        }else{
            $data = $this->model->adminUsers_data();
            $this->view->generate(null, 'admin/template_admin.php', $data);
        }
    }

    function action_tables()
    {
        if($_GET['action']==="refreshTables"){
            $this->model->tables_init();
            $this->model->dbCompare();
            $this->view->generateAjax(null, 'admin/tables_list.php', $this->model->tables);
        }
        elseif($_GET['action']==="upLoadAll"){
            $this->model->tables_init();
            $this->model->dbCompare();
            $data = $this->model->uploadAllTables();
            $this->view->generateJson($data);
        }elseif ( in_array($_GET['action'],
            array("clear", "download", "drop", "create", "upLoad"))){
            $start_time = microtime(true);

            if($_GET['action'] == "clear"){
                if($this->model->clearTable($_GET['tableName'])){
                    $data["err"] = 0;
                }else{
                    $data["err"] = "clear table fail";
                }
            }elseif ($_GET['action'] == "download"){
                if($this->model->downloadTable($_GET['dwlTable'])){
                    $data["err"] = 0;
                }else{
                    $data["err"] = "insert table fail";
                }
                $inclContent["curTable"] = $_GET['tableName'];
            }elseif ($_GET['action'] == "drop"){
                if($this->model->dropTable($_GET['tableName'])){
                    $data["err"] = 0;
                }else{
                    $data["err"] = "drop table fail";
                }
            }elseif ($_GET['action'] == "create"){
                if($this->model->createTable($_GET['tableName'])){
                    $data["err"] = 0;
                }else{
                    $data["err"] = "create table fail";
                }
            }
            elseif ($_GET['action'] == "upLoad"){
                $data = $this->model->uploadTable($_GET['tableName'], $_GET['prefixTag'], $_GET["dateTag"], $this->model->tables["options"]["tableExtFile"]);
            }

            $this->model->tables["tables"][$_GET['tableName']]['list']=true;
            $this->model->dbCompare();
            $inclContent = $this->model->tables;
            $inclContent["curTable"] = $_GET['tableName'];
            $data["row"] = $this->view->generateAjax(null, "admin/table_cells.php", $inclContent, true);
            $end_time = microtime(true);
            $data['log'].="Action: ".$_GET["action"]."<br>".
                "<ul>Options:<li>tableName--> ".$_GET['tableName']."</li></ul>".
                date( 'Y-m-d H:i:s').'</br>'.
                'lead time: '.($end_time-$start_time);

            $this->view->generateJson($data);
        }
        else{
            $data = $this->model->tables_data();
            $this->view->generate(null, 'admin/template_admin.php', $data);
        }
    }
    function action_editRecords()
    {
        if(isset($_POST['tableSelector'])){
            $data = $this->model->DB->getRecordStructure($_POST['tableSelector']);

            if($data){
                $this->view->generateAjax(null, "admin/recordsFilter.php", $data);
            }
        }elseif ($_POST["applyFilterRec"]){

            $data = $this->model->makeRecFilter();
            $this->view->generateAjax(null, "admin/record-list.php", $data);
        }elseif ($_POST["editRec"]){
            //shows form for edit and add record
            $addOneRecFlag = false;
            if($_POST["addOneFlag"]){
                $addOneRecFlag = true;
                $data = $this->model->DB->getRecordStructure($_POST["tableName"]);
            }else{
                $data = $this->model->prepareEditRec($_POST["tableName"])["record"];
            }

            $this->view->generateAjax(null, "admin/editOneRecord.php",
                array("tableName"=>$_POST["tableName"],
                    "structure"=>$data,
                    "addOneRecFlag"=>$addOneRecFlag,
                ));
        }elseif ($_POST["editRecFlag"]){
            $record = $this->model->DB->getRecordStructure($_POST["tableName"]);




            //update record
            if($_POST["editRecFlag"]==1){
                foreach ($record as $field=>$fData){
                    if($fData["indexes"]){
                        $record[$field]["curVal"] = $_POST["oneRec"][$field];
                    }
                }
                $copy=$this->model->DB->copyRecord($_POST["tableName"], $record);
                if($copy["result"]){
                    foreach ($copy["record"] as $field=>$fData){
                        $copy["record"][$field]["curVal"] = $_POST["oneRec"][$field];
                    }
                    $data = $this->model->DB->updateRecord($_POST["tableName"], $copy["record"]);
                }else{
                    $data = array(
                        "result"=>0,
                        "log" => "cant copy record",
                    );
                }
            }
            //insert record
            elseif($_POST["editRecFlag"]==2){
                foreach ($record as $field=>$fData){
                    $record[$field]["curVal"] = $_POST["oneRec"][$field];
                }
                $data = $this->model->DB->insertRecord($_POST["tableName"], $record);
            }
            //delete record
            elseif($_POST["editRecFlag"]==3){
                foreach ($record as $field=>$fData){
                    if($fData["indexes"]){
                        $record[$field]["curVal"] = $_POST["oneRec"][$field];
                    }
                }

                $data =$this->model->DB->deleteRecord($_POST["tableName"], $record);
            }
            $this->view->generateJson($data);
        }
        else{
            $data = $this->model->editRecords_data();
            $this->view->generate(null, 'admin/template_admin.php', $data);
        }
    }
}