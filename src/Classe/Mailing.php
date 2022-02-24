<?php

namespace App\Class;

use Mailjet\Client;
use Mailjet\Resources;

class Mailing
{
    private $apiKey = "0b39fdf2cf29616148c6f6ee5f82e00f";
    
    private $secretKey = "59b207bbb7ef6dbb70e2c72359abb929";

    public function envoyer($idModele, $emailDest, $nameDest, $subject, $emailContent, $emailUser)
    {
        $mj = new Client($this->apiKey, $this->secretKey, true,['version' => 'v3.1']);
        
        $body = [
          'Messages' => [
            [
              'From' => [
                'Email' => "samuel.debaer@gmail.com",
                'Name' => "Admin"
              ],
              'To' => [
                [
                  'Email' => $emailDest,
                  'Name' => $nameDest
                ]
              ],
              'TemplateID' => $idModele,
              'TemplateLanguage' => true,
              'Subject' => $subject,
              'Variables' => [
                  'emailContent' => $emailContent,
                  'email' =>$emailUser
            ]
          ]
          ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
        
     
}

public function contacter($idModele, $emailSource, $nameSource, $subject, $emailContent)
    {
        $mj = new Client($this->apiKey, $this->secretKey, true,['version' => 'v3.1']);
        
        $body = [
          'Messages' => [
            [
              'From' => [
                'Email' => $emailSource,
                  'Name' => $nameSource
              ],
              'To' => [
                [
                  'Email' => "gsvlad@hotmail.com",
                'Name' => "Admin"
                ]
              ],
              'TemplateID' => $idModele,
              'TemplateLanguage' => true,
              'Subject' => $subject,
              'Variables' => [
                  'emailContent' => $emailContent,
                  'emailSource'=> $emailSource,
                  'nameSource' => $nameSource
            ]
          ]
          ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
        
     
}
} 
?>