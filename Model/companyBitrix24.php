<?php
require_once ('connectionBitrix24.php');

class CompanyBitrix24{
    public static function AddCompany($name_da_empresa,$CNPJ){
        $URL="crm.company.add"; 
        $data = http_build_query(array(
            'fields' => array(
                "TITLE" => $name_da_empresa,
                "OPENED" => "Y",
                "UF_CRM_1592106903" => $CNPJ
                ),
                'params' => array("REGISTER_SONET_EVENT" => "Y")
            ));
        $result = ConnectionBitrix24::ExecutionConn($data,$URL);
        $result = json_decode($result, 1);
        ConnectionBitrix24::writeToLog($result, 'new company');
    }

    public static function ListCompany($CNPJ){
        $URL="crm.company.list"; 
        $data = http_build_query(array(
            'filter' => ["UF_CRM_1592106903" => $CNPJ],
            'select' => ["ID"]
            ));        
        $result = ConnectionBitrix24::ExecutionConn($data,$URL);        
        $result = json_decode($result, 1);
        ConnectionBitrix24::writeToLog($result, 'checa se CNPJ já existe');

        if ($result['result']==NULL) {
            return NULL;
        }
        else{
            return $result['result'][0]['ID'];
       }
    }

    public static function UpdateCompany($id,$name_da_empresa){
        $Url = 'crm.company.update';
        $data = http_build_query(array(
            'ID' => $id,
            'fields' => array(
            "TITLE" =>  $name_da_empresa,
            ),
            'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));
        $result = ConnectionBitrix24::ExecutionConn($data,$Url);
        $result = json_decode($result, 1);
        ConnectionBitrix24:: writeToLog($result, 'Update em company');
    }

    public static function AddCompanyContact($company_id,$contact_id){
        $Url = 'crm.company.contact.add';
        $data = http_build_query(array(
            'ID' => $company_id,
            'fields' => array(
                "CONTACT_ID" => $contact_id
                )
        ));
        $result = ConnectionBitrix24::ExecutionConn($data,$Url);
        $result = json_decode($result, 1);
        ConnectionBitrix24:: writeToLog($result, 'add a contact to the specified company');
    }
}
