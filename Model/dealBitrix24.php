<?php
require_once ('connectionBitrix24.php');

class DealBitrix24{
    public static function GET_Deal($array){
        $Url = 'crm.deal.get';        
        $data = http_build_query(array(
            'ID' => $array["data"]['FIELDS']["ID"]
        ));
        $result = ConnectionBitrix24::ExecutionConn($data,$Url);
        $result = json_decode($result, 1);
        ConnectionBitrix24:: writeToLog($result, 'GET deals');

        if($result['result']['STAGE_ID'] == 'WON'){
            DealBitrix24::WON_Deal($result);
        }
    }

    public static function WON_Deal($array){
        $Deal = $array['result']['OPPORTUNITY'];
        $ID_Company = $array['result']['COMPANY_ID'];
        $SaldoAtual = DealBitrix24::ListCompanyBank($ID_Company);
        $NovoSaldo = $SaldoAtual + $Deal;
        DealBitrix24::UpdateCompanyWON($ID_Company,$NovoSaldo);
    }


    public static function ListCompanyBank($ID_Company){
        $URL="crm.company.list"; 
        $data = http_build_query(array(
            'filter' => ["ID" => $ID_Company],
            'select' => ["UF_CRM_1592205695"]
        ));
        
        $result = ConnectionBitrix24::ExecutionConn($data,$URL);        
        $result = json_decode($result, 1);
        ConnectionBitrix24:: writeToLog($result, 'list company');

        if ($result['result']==NULL) {
            return 0;
        }
        else{
            return $result['result'][0]['UF_CRM_1592205695'];
       }
    }
    
    public static function UpdateCompanyWON($ID_Company,$NovoSaldo){
        $Url = 'crm.company.update';
        $data = http_build_query(array(
            'ID' => $ID_Company,
            'fields' => array(
            "UF_CRM_1592205695" => $NovoSaldo,
        ),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));
        $result = ConnectionBitrix24::ExecutionConn($data,$Url);
        $result = json_decode($result, 1);
        ConnectionBitrix24:: writeToLog($result, 'Update no saldo');
    }
}