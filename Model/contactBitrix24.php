<?php
require_once ('connectionBitrix24.php');

class ContactBitrix24{
    public static function AddContact($name,$phone,$email,$CPF){
        $URL="crm.contact.add"; 
    
        $data = http_build_query(array(
            'fields' => array(
                "NAME" => $name,
                "OPENED" => "Y",
                "PHONE" => array(array("VALUE" => $phone, "VALUE_TYPE" => "WORK")),
                "EMAIL" => array(array("VALUE" => $email, "VALUE_TYPE" => "WORK")),
                "UF_CRM_1592106833" => $CPF
            ),
            'params' => array("REGISTER_SONET_EVENT" => "Y")
            ));
        $result = ConnectionBitrix24::ExecutionConn($data,$URL);
        $result = json_decode($result, 1);
        ConnectionBitrix24::writeToLog($result, 'new contact');
    }

    public static function ListContact($CPF){
        $URL="crm.contact.list";     
        $data = http_build_query(array(
            'filter' => ["UF_CRM_1592106833" => $CPF],
            'select' => [ "ID"]
            ));
        $result = ConnectionBitrix24::ExecutionConn($data,$URL);
        $result = json_decode($result, 1);
        ConnectionBitrix24::writeToLog($result, 'checa se CPF já existe');
        
        if ($result['result']==NULL) {
            return NULL;
        }
        else{
            return $result['result'][0]['ID'];
       }
    }

    public static function UpdateContact($id,$name,$phone,$email){
        $Url = 'crm.contact.update';
        $data = http_build_query(array(
            'ID' => $id,
            'fields' => array(
            "NAME" => $name,
            "OPENED" =>"Y", 
            "PHONE" => array(array("VALUE" => $phone, "VALUE_TYPE" => "WORK" )),
            "EMAIL" => array(array("VALUE" => $email, "VALUE_TYPE" => "WORK" ))
        ),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));
        $result = ConnectionBitrix24::ExecutionConn($data,$Url);
        $result = json_decode($result, 1);
        ConnectionBitrix24:: writeToLog($result, 'Update contact');
    }
}
