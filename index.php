<?php
    $accessToken = "DxRB7paYXRW42FbZilF07llTECGxenTd36Z8kAgT6qo4GYYHJrdau5SF+0sLVAGJPTVoaU42ZTRq8rpfb1KZQ2Ljvcq04R4GLbeS1w37A6kJvuhTXGhhFLypeTgkhdgcUuLcLewfW1DZAjZcfeyh3QdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    $API_URL = 'https://api.line.me/v2/bot/message';

    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
    $command = "NA";
	if(substr($message,0,3) == "MP5"){
   	 $command = substr($message,0,strpos($message," "));
	}
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

if($command <>"NA"){
    switch ($command) {
        case "MP5addjob1";
            $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "http://10.50.10.5:8000/Service1.svc/rest/InsertSmartOvenIMS/MIS,999,0,082033,PT1234567";
            replyMsg($arrayHeader,$arrayPostData);
            break;
        case "MP5addjob2";
		$reply_message = '';
		$reply_token = $arrayJson['events'][0]['replyToken'];
		$text = "MP5 รับทราบค่ะ";
		$data = [
			'replyToken' => $reply_token,
			'messages' => [['type' => 'text', 'text' => $text ]]
			];
		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
		$send_result = send_reply_message($API_URL.'/reply',$arrayHeader, $post_body);

		//$jsonPostData = json_encode($arrayPostData);
		//send_reply_message($API_URL.'/reply', $arrayHeader,$jsonPostData);
		break;
	 case "MP5addjob3";
		$emojiText = ['index' => 0, 'productId' => '5ac1bfd5040ab15980c9b435', 'emojiId' => '001'];
		$jsonText = ['type' => 'text',
			     'text' => "$ MP5 รับทราบค่ะ",
			     'emojis'=> [$emojiText]
			    ];
		$reply_token = $arrayJson['events'][0]['replyToken'];
		$data = [
			'replyToken' => $reply_token,
			'messages' => [$jsonText]	  
			];
		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
		$send_result = send_reply_message($API_URL.'/reply',$arrayHeader, $post_body);

		break;
 	case "MP5addjob4";
		$actionText = [['type' => 'message', 'label' => 'OK','text' => 'yes'],['type' => 'message', 'label' => 'NO','text' => 'no']];
          	$jsonText = ['type' => 'template',
			     'altText' => 'this is a confirm template',
			     'template'=> ['type' => 'confirm', 
					   'text' => 'Confirm add job หน่อยค่ะ',
					   'actions' => [['type' => 'message', 'label' => 'OK','text' => 'yes'],
						        ['type' => 'message', 'label' => 'NO','text' => 'no']
						      ] 
					  ]
			    ];
		 $reply_token = $arrayJson['events'][0]['replyToken'];
		 $data = [
			'replyToken' => $reply_token,
			'messages' => [$jsonText]	  
			];
		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
		$send_result = send_reply_message($API_URL.'/reply',$arrayHeader, $post_body);
		break;
	 case "MP5addjob";
		$jsonText = ['type' => 'uri',
			     'label' => 'กดเพื่อ confirm โตยเจ้า',
			     'linkUri'=> 'http://10.50.10.5:8000/Service1.svc/rest/InsertSmartOvenIMS/MIS,999,0,082033,PT1234567',
			     'area' => ['x' => 0, 'y' => 0, 'width' => 100, 'height' => 200]
			    ];
		$reply_token = $arrayJson['events'][0]['replyToken'];
		$data = [
			'replyToken' => $reply_token,
			'messages' => [$jsonText]	  
			];
		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
		$send_result = send_reply_message($API_URL.'/reply',$arrayHeader, $post_body);

		break;
	default:
		    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
		    $arrayPostData['messages'][0]['type'] = "text";
		    $arrayPostData['messages'][0]['text'] = "MP5 งงคำสั่งเจ้า";
		    replyMsg($arrayHeader,$arrayPostData);
		    break;
          }

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

	function send_reply_message($url, $post_header, $post_body)
	{
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    $result = curl_exec($ch);
	    curl_close($ch);

	    //return $result;
	}

  
     /*Return HTTP Request 200*/
     http_response_code(200);
    ?>
