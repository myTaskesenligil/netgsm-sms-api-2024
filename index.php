<?php 

class SendSMS{

    public $message;
    public $phone;
    private $postURL;
    private $smsTitle;
    private $username;
    private $password;
    
    public function __construct(){
        $this->username = 'USERNAME';
        $this->password = 'PASSWORD';
        $this->smsTitle = 'TITLE';
        $this->postURL = 'http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl/';
    }

    private function post($xmlData){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->postURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xmlData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function send(){

        $xmlData = '<?xml version="1.0"?>
                    <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                        <SOAP-ENV:Body>
                            <ns3:smsGonder1NV2 xmlns:ns3="http://sms/">
                                <username>'.$this->username.'</username>
                                <password>'.$this->password.'</password>
                                <header>'.$this->smsTitle.'</header>
                                <msg>'.$this->message.'</msg>
                                <gsm>'.$this->phone.'</gsm>
                                <filter>0</filter>
                                <encoding>TR</encoding>
                            </ns3:smsGonder1NV2>
                        </SOAP-ENV:Body>
                    </SOAP-ENV:Envelope>';
        $response = $this->post($xmlData);

        return $response;

    }

}

$smsService = new SendSMS();

$smsService->phone = '5XXXXXXXXX';
$smsService->message = 'Hello World';
$resp = $smsService->send();

var_dump($resp);
?>