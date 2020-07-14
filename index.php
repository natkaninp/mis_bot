<?php
    $accessToken = "DxRB7paYXRW42FbZilF07llTECGxenTd36Z8kAgT6qo4GYYHJrdau5SF+0sLVAGJPTVoaU42ZTRq8rpfb1KZQ2Ljvcq04R4GLbeS1w37A6kJvuhTXGhhFLypeTgkhdgcUuLcLewfW1DZAjZcfeyh3QdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
    $command = substr($message,0,strpos($message," "));
#ตัวอย่าง Message Type "Text"
    if($message == "สวัสดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Sticker"
    else if($message == "ฝันดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = "46";
        replyMsg($arrayHeader,$arrayPostData);
    }else if($message == "เราชื่อปิงปองนะ"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "ปิงปอง MIS หล่อๆ ที่เข้ามีตติ้งกับเราวันก่อนใช่ป่าวคะ";
        replyMsg($arrayHeader,$arrayPostData);
    }

    switch ($command) {
        case "":
            $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "MP5 งงคำสั่งเจ้า";
            replyMsg($arrayHeader,$arrayPostData);
            break;
        case "addjob";
            $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "MP5 add job หื้อเรียบร้อยค่ะ";
            replyMsg($arrayHeader,$arrayPostData);
            
            $get_data = callAPI('GET', 'http://10.50.10.5:8000/Service1.svc/rest/InsertSmartOvenIMS/MIS,999,0,082033,PT1234567', false);
            $response = json_decode($get_data, true);
            $errors = $response['response']['errors'];
            $data = $response['response']['data'][0];       
            break;
          }



    function replyMsg($arrayHeader,$arrayPostData){
            $strUrl = "https://api.line.me/v2/bot/message/reply";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$strUrl);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close ($ch);
        }
       exit;

  
     /*Return HTTP Request 200*/
     http_response_code(200);
    ?>
