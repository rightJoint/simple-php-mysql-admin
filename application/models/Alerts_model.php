<?php
class Alerts_model extends Model
{
    function __construct()
    {

    }

    public function get_data($appErr=null)
    {
        return $this->defineAlert($appErr);

    }
    private function defineAlert($appErr){
        $alertsArr['404']['title']='Не найдено';
        $alertsArr['404']['title_en']='Not found';
        $alertsArr['404']['h1']='Не найдено';
        $alertsArr['404']['h1_en']='Not found';
        $alertsArr['404']['img']='/source/alerts/img/404-not-found.jpg';
        $alertsArr['404']['respCode']=404;

        $alertsArr['stab']['title']='Реконструкция';
        $alertsArr['stab']['title_en']='Reconstruction';
        $alertsArr['stab']['h1']='Сайт временно на реконструкции';
        $alertsArr['stab']['h1_en']='Page temporarily on reconstruction';
        $alertsArr['stab']['img']='/source/alerts/img/stabErr.jpg';

        $alertsArr['access']['title']='Запрещен';
        $alertsArr['access']['title_en']='Forbidden';
        $alertsArr['access']['h1_en']='Доступ запрещен';
        $alertsArr['access']['h1_en']='Access denied';
        $alertsArr['access']['img']='/source/alerts/img/accessErr.jpg';
        $alertsArr['access']['respCode']=403;

        $alertsArr['connection']['title']='Подключение';
        $alertsArr['connection']['title_en']='Connection';
        $alertsArr['connection']['h1']='Подключение';
        $alertsArr['connection']['h1_en']='Connection';
        $alertsArr['connection']['img']='/source/alerts/img/connErr.jpg';

        $alertsArr['request']['title']='Request';
        $alertsArr['request']['title_en']='Request';
        $alertsArr['request']['h1']='Неправильные параметры запроса';
        $alertsArr['request']['h1_en']='Wrong request';
        $alertsArr['request']['img']='/source/alerts/img/requestErr.jpg';
        $alertsArr['request']['respCode']=400;

        $alertsArr['config']['title']='Конфигурация';
        $alertsArr['config']['title_en']='Configuration';
        $alertsArr['config']['h1']='Ошибка в конфигурации';
        $alertsArr['config']['h1_en']='Configuration error';
        $alertsArr['config']['img']='/source/alerts/img/connErr.jpg';

        $alertsArr['XXX']['title']='Неизвестная ошибка';
        $alertsArr['XXX']['title_en']='Unknown error';
        $alertsArr['XXX']['h1']='Неизвестная ошибка';
        $alertsArr['XXX']['h1_en']='Unknown error';
        $alertsArr['XXX']['img']='/source/alerts/img/XXX-unknownError.jpg';

        $errType=null;
        $errDescr=null;

        foreach ($alertsArr as $key=>$val){
            if(isset($appErr[$key])){
                $errType=$key;
                break;
            }
        }
        if($alertsArr[$errType]['respCode']){
            http_response_code($alertsArr[$errType]['respCode']);
        }

        $descrErr = $appErr[$errType]['description'];
        if ($_SESSION["lang"]=="en"){
            $dSuf = "_en";
            if($appErr[$errType]['description_en']){
                $descrErr = $appErr[$errType]['description_en'];
            }
        }

        return array(

            "h1" => $alertsArr[$errType]['h1'.$dSuf],
            "errType"=>$errType,
            "title" => $alertsArr[$errType]['title'.$dSuf],
            "description" => $descrErr,
            "code"=>$alertsArr[$errType]['respCode'],
        );

    }

}