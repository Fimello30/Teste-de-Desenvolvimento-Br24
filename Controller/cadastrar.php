<?php
require_once ('../Model/connectionBitrix24.php');
require_once ('../Model/contactBitrix24.php');
require_once ('../Model/companyBitrix24.php');

$CheckID_Company = CompanyBitrix24::ListCompany($_REQUEST['CNPJ']);
$CheckID_Contact = ContactBitrix24::ListContact($_REQUEST['CPF']);
if($CheckID_Company == NULL && $CheckID_Contact == NULL){
    CompanyBitrix24::AddCompany($_REQUEST['name_da_empresa'],$_REQUEST['CNPJ']);
    ContactBitrix24::AddContact($_REQUEST['name'], $_REQUEST['phone'], $_REQUEST['email'],$_REQUEST['CPF']);
    
    $CheckID_Company = CompanyBitrix24::ListCompany($_REQUEST['CNPJ']);
    $CheckID_Contact = ContactBitrix24::ListContact($_REQUEST['CPF']);
    CompanyBitrix24::AddCompanyContact($CheckID_Company,$CheckID_Contact);
    echo '<meta http-equiv="refresh" content="1; url=../View/cadastroRealizado.html">';
}

elseif($CheckID_Company == NULL && $CheckID_Contact != NULL){
    CompanyBitrix24::AddCompany($_REQUEST['name_da_empresa'],$_REQUEST['CNPJ']);
    ContactBitrix24::UpdateContact($CheckID_Contact,$_REQUEST['name'], $_REQUEST['phone'], $_REQUEST['email']);
    
    $CheckID_Company = CompanyBitrix24::ListCompany($_REQUEST['CNPJ']);
    CompanyBitrix24::AddCompanyContact($CheckID_Company,$CheckID_Contact);
    echo '<meta http-equiv="refresh" content="1; url=../View/cadastroRealizado.html">';
}

elseif($CheckID_Company != NULL && $CheckID_Contact == NULL){
    CompanyBitrix24::UpdateCompany($CheckID_Company,$_REQUEST['name_da_empresa']);
    ContactBitrix24::AddContact($_REQUEST['name'], $_REQUEST['phone'], $_REQUEST['email'],$_REQUEST['CPF']);
    
    $CheckID_Contact = ContactBitrix24::ListContact($_REQUEST['CPF']);
    CompanyBitrix24::AddCompanyContact($CheckID_Company,$CheckID_Contact);
    echo '<meta http-equiv="refresh" content="1; url=../View/cadastroRealizado.html">';
}


else{
    ContactBitrix24::UpdateContact($CheckID_Contact,$_REQUEST['name'], $_REQUEST['phone'], $_REQUEST['email']);
    CompanyBitrix24::UpdateCompany($CheckID_Company,$_REQUEST['name_da_empresa']);

    CompanyBitrix24::AddCompanyContact($CheckID_Company,$CheckID_Contact);
    echo '<meta http-equiv="refresh" content="1; url=../View/cadastroAtualizado.html">';

}