<?php
require 'vendor/autoload.php';
require 'config.php';
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\client;
try{
$client = new Client(['verify'  =>  'cacert.pem']);
$res  =  $client ->request( 'GET' , 'https://accounts.google.com/.well-known/openid-configuration');
$discoveryjson = json_decode((String)$res->getBody());
$tokenEndpoint = $discoveryjson->token_endpoint;
$userinfoEndpoint = $discoveryjson->userinfo_endpoint;
$res= $client->request('POST' , $tokenEndpoint,
[ 'form_params' => [
     'code' => $_GET['code'],
    'client_id' => GOOGLE_ID,
    'client_secret'=>GOOGLE_SECRET,
    'redirect_uri'=>'http://localhost:8000/connect.php',
    'grant_type'=>"authorization_code" ]
]);
$access = json_decode($res->getBody())->access_token;
$res=$client->request('GET',$userinfoEndpoint,
[
    'headers'=>[
        'Authorization' => 'Bearer' . $access
    ]
]
);
$res=json_decode($res->getBody());
if($res->email_verified === true){
    session_start();
    $_SESSION['email']=$res->email;
    header('Location:/secret.php');
    exit();
}
}catch(ClientException $exeception){
dd($exeception->getMessage());
}
dd((string)$res->getBody());

?>