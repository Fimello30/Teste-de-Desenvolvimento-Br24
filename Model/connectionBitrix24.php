<?php

class ConnectionBitrix24{
    /**
     * Write data to log file.
     *
     * @param mixed $data
     * @param string $title
     *
     * @return bool
     */


    public static function writeToLog($data, $title = '') {
        $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s") . "\n";
        $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
        $log .= print_r($data, 1);
        $log .= "\n------------------------\n";
        file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
        return true;
    }

    public static function ExecutionConn($queryData,$URL){
        $queryUrl = 'https://b24-mowx23.bitrix24.com.br/rest/1/0srzm0w5eq0gfwtm/'. $URL;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
