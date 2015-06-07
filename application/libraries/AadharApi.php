<?php

class AadharApi{

    public $url = 'https://ac.khoslalabs.com/hackgate/hackathon/';

    function __construct() {
        parent::__construct();
    }

    public function TestAadhar() {
        $this->AuthOnlyUidWithDemo("", "121003", "Amit Kumar Gupta");
        // $this->GenerateAadharOtp("","121003");
        $resp = $this->AuthUidWithOtp("", "121003", "819098");
        $table = "<table>
                <tr><td colspan=2><img alt='Embedded Image' src='data:image/png;base64," . $resp['kyc']['photo'] . " ' /></td></tr>
                <tr><td>UID</td><td>" . $resp['aadhaar-id'] . "</td></tr>
                <tr><td>Name</td><td>" . $resp['kyc']['poi']['name'] . "</td></tr>
                <tr><td>Dob</td><td>" . $resp['kyc']['poi']['dob'] . "</td></tr>
                <tr><td>Gender</td><td>" . $resp['kyc']['poi']['gender'] . "</td></tr>
                <tr><td>co</td><td>" . $resp['kyc']['poa']['co'] . "</td></tr>
                <tr><td>street</td><td>" . $resp['kyc']['poa']['street'] . "</td></tr>
                <tr><td>vtc</td><td>" . $resp['kyc']['poa']['vtc'] . "</td></tr>
                <tr><td>subdist</td><td>" . $resp['kyc']['poa']['subdist'] . "</td></tr>
                <tr><td>dist</td><td>" . $resp['kyc']['poa']['dist'] . "</td></tr>
                <tr><td>state</td><td>" . $resp['kyc']['poa']['state'] . "</td></tr>
                <tr><td>pc</td><td>" . $resp['kyc']['poa']['pc'] . "</td></tr>
                <tr><td>po</td><td>" . $resp['kyc']['poa']['po'] . "</td></tr>
                    </table>";
        echo("<br><br>" . $table);
    }

    public function GenerateAadharOtp($uid, $pin, $channel = "SMS") {

        $AythReq = '{"aadhaar-id":"' . $uid . '",
                    "location":{
                    "type":"pincode",
                    "pincode":"' . $pin . '"
                    },
                    "channel":"' . $channel . '"
                    }';
        $AuthUrl = $this->url . "otp";
        $resp = $this->httprequest($AuthUrl, $AythReq);
        return $resp['success']; //Array ( [success] => 1 [aadhaar-reference-code] => e0972d7003e74deeaf619fc92a0e00c7 )
    }

    public function AuthUidWithOtp($uid, $pin, $otp) {

        $AuthUrl = $this->url . "kyc/raw";
        $AythReq = '{
                   "consent": "Y",
                   "auth-capture-request":
                          {"aadhaar-id": "' . $uid . '",
                          "location": {"type": "pincode", "pincode": "' . $pin . '"},
                          "modality": "otp",
                          "device-id": "public",
                          "otp": "' . $otp . '",
                          "certificate-type": "preprod"
                         }
                 }';
        $resp = $this->httprequest($AuthUrl, $AythReq);
        return $resp; //Array ( [kyc] => Array ( [aadhaar-id] => 357515288428 [photo] => xxx[poi] => Array ( [name] => Amit Kumar Gupta [dob] => 01-01-1985 [gender] => M ) [poa] => Array ( [co] => S/O: Hari Om Gupta [street] => BAZAR KALAN [house] => H NO-52 [vtc] => Ujhani Grameen [subdist] => Bisauli [dist] => Budaun [state] => Uttar Pradesh [pc] => 243639 [po] => Ujhani ) [local-data] => Array ( ) ) [aadhaar-id] => 357515288428 [success] => 1 [aadhaar-reference-code] => 8b63dd17d3094787bcee0836351071ce ) 
    }

    public function AuthOnlyUidWithDemo($uid, $pin, $name) {

        $AuthUrl = $this->url . "auth/raw";
        $AythReq = '{"aadhaar-id": "' . $uid . '",
                  "location": {"type": "pincode", "pincode": "' . $pin . '"},
                  "modality": "demo",
                  "certificate-type": "preprod",
                  "demographics": {
                  "name": {"matching-strategy": "exact","name-value": "' . $name . '"}
                }}';
        $resp = $this->httprequest($AuthUrl, $AythReq);
        return $resp; //Array ( [success] => 1 [aadhaar-reference-code] => e1ef2ad719fb49beae6a0980bffd442c )
    }

    public function httprequest($AuthUrl, $AythReq) {
        $headers = array("Content-type: application/json", "Content-length: " . strlen($AythReq), "Connection: close");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $AuthUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $AythReq);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $errtext = curl_error($ch);
        $errnum = curl_errno($ch);
        $commInfo = @curl_getinfo($ch);
        $user1 = curl_close($ch);
        $response = json_decode($response, true);
        print_r($response);
        return $response;
    }

}