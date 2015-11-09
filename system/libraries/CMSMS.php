<?php

class CMSMS
{
  static public function buildMessageXml($recipient, $message) {
    $xml = new SimpleXMLElement('<MESSAGES/>');

    $authentication = $xml->addChild('AUTHENTICATION');
    $authentication->addChild('PRODUCTTOKEN', 'c8d45176-7082-4dcc-8e55-0b50d075d4a7');

    $msg = $xml->addChild('MSG');
    $msg->addChild('FROM', 'Monopolion');
    $msg->addChild('TO', $recipient);
    $msg->addChild('MINIMUMNUMBEROFMESSAGEPARTS', 1);
    $msg->addChild('MAXIMUMNUMBEROFMESSAGEPARTS', 8);
    $msg->addChild('BODY', htmlentities($message));
    
    return $xml->asXML();
  }

  static public function sendMessage($recipient, $message) {

    $xml = self::buildMessageXml($recipient, $message);

    $ch = curl_init(); // cURL v7.18.1+ and OpenSSL 0.9.8j+ are required
    curl_setopt_array($ch, array(
        CURLOPT_URL            => 'https://sgw01.cm.nl/gateway.ashx',
        CURLOPT_HTTPHEADER     => array('Content-Type: application/xml'),
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $xml,
        CURLOPT_RETURNTRANSFER => true
      )
    );

    $response = curl_exec($ch);

    curl_close($ch);

    return $response;
  }
  public static function buildBulkMessageXml($recipients,$message){
    $xml = new SimpleXMLElement('<MESSAGES/>');
    
    $authentication = $xml->addChild('AUTHENTICATION');
    $authentication->addChild('PRODUCTTOKEN', 'c8d45176-7082-4dcc-8e55-0b50d075d4a7');
    
    foreach($recipients as $recipient){
        $recipient = explode('|',$recipient);
        
        $text_content = str_replace('{first_name}', $recipient[2], $message);
        $text_content = str_replace('{last_name}', $recipient[3], $text_content);
        
        $msg = $xml->addChild('MSG');
        $msg->addChild('FROM', 'Monopolion');
        $msg->addChild('TO', $recipient[0]);
        $msg->addChild('MINIMUMNUMBEROFMESSAGEPARTS', 1);
        $msg->addChild('MAXIMUMNUMBEROFMESSAGEPARTS', 8);
        $msg->addChild('BODY', $text_content);
    }
    return $xml->asXML();
  }
  
  public static function sendBulkMessage($recipients,$message){
    $xml = self::buildBulkMessageXml($recipients, $message);

    $ch = curl_init(); // cURL v7.18.1+ and OpenSSL 0.9.8j+ are required
    curl_setopt_array($ch, array(
        CURLOPT_URL            => 'https://sgw01.cm.nl/gateway.ashx',
        CURLOPT_HTTPHEADER     => array('Content-Type: application/xml'),
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $xml,
        CURLOPT_RETURNTRANSFER => true
      )
    );

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

}
?>