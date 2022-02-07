<?php
class accessorialClass
{
    public static function mkAlias($toTranslit)
    {
        $str = null;
        if (isset($toTranslit) and $toTranslit != null) {
            $converter = array(
                'а' => 'a', 'б' => 'b', 'в' => 'v',
                'г' => 'g', 'д' => 'd', 'е' => 'e',
                'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
                'и' => 'i', 'й' => 'y', 'к' => 'k',
                'л' => 'l', 'м' => 'm', 'н' => 'n',
                'о' => 'o', 'п' => 'p', 'р' => 'r',
                'с' => 's', 'т' => 't', 'у' => 'u',

                'ф' => 'f', 'х' => 'h', 'ц' => 'c',
                'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
                'ь' => '', 'ы' => 'y', 'ъ' => '',
                'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

                'А' => 'A', 'Б' => 'B', 'В' => 'V',
                'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
                'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
                'И' => 'I', 'Й' => 'Y', 'К' => 'K',
                'Л' => 'L', 'М' => 'M', 'Н' => 'N',
                'О' => 'O', 'П' => 'P', 'Р' => 'R',
                'С' => 'S', 'Т' => 'T', 'У' => 'U',
                'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
                'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
                'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
                'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',

                ' ' => '-'
            );
            $str = strtr($toTranslit, $converter);
            $str = strtolower($str);
            $str = preg_replace("/[^a-zA-Z0-9-]/", '', $str);
            $str = trim($str, "-");
            $str = preg_replace('/-{2,}/', '-', $str);
        }
        return $str;
    }

    public static function checkLogin($login)
    {
        if (preg_match('/^[a-z]{1}[0-9a-z-._]{2,15}$/imsiu', $login) == 0){
            return false;
        }
        return true;
    }

    public static function checkPassword($pass)
    {
        if (preg_match('/^[a-z]{1}[0-9a-z-._]{2,15}$/imsiu', $pass) == 0){
            return false;
        }else{
            return true;
        }
    }

    public static function checkEmail($eMail)
    {
        if (filter_var($eMail, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }
    public static function checkClientName($clientName)
    {
        if (preg_match('/^[a-zа-я]{1}[0-9a-zа-я-._ ]{2,15}$/imsiu', $clientName) == 0){
            return false;
        }
        return true;
    }

    public static function GUID()
    {
        if (function_exists('com_create_guid') === true){
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

}