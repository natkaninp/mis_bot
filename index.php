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
	 case "MP5addjob5";
		$jsonText = ['type' => 'image',
			     'originalContentUrl' => 'http://10.50.10.5:8000/Service1.svc/rest/InsertSmartOvenIMS/MIS,999,0,082033,PT1234567',
			     'previewImageUrl'=> 'http://10.50.10.5:8000/Service1.svc/rest/InsertSmartOvenIMS/MIS,999,0,082033,PT1234567'
			    ];
		$reply_token = $arrayJson['events'][0]['replyToken'];
		$data = [
			'replyToken' => $reply_token,
			'messages' => [$jsonText]	  
			];
		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
		$send_result = send_reply_message($API_URL.'/reply',$arrayHeader, $post_body);

		break;
	case "MP5addjob6";
          	$jsonText = ['type' => 'template',
			     'altText' => 'This is a buttons template',
			     'template'=> ['type' => 'buttons'
					   ,'thumbnailImageUrl' => "https://th.wiktionary.org/wiki/cat#/media/%E0%B9%84%E0%B8%9F%E0%B8%A5%E0%B9%8C:Gatto_europeo4.jpg"
					   ,'imageAspectRatio' => "rectangle"
					   ,'imageSize' => "cover"
					   ,'imageBackgroundColor' => "#FFFFFF"
					   ,'title' => "Menu"
					   ,'text' => 'รบกวนกดปุ่ม confirm ด้วยค่ะ'
					   ,'defaultAction' => ['type' => 'uri', 'label' => 'Confirm','uri' => 'http://10.50.10.5:8000/Service1.svc/rest/InsertSmartOvenIMS/MIS,999,0,082033,PT1234567']
					   ,'actions' => [['type' => 'uri', 'label' => 'Confirm','uri' => 'http://10.50.10.5:8000/Service1.svc/rest/InsertSmartOvenIMS/MIS,999,0,082033,PT1234567']] 
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
		$replyToken = $arrayJson['events'][0]['replyToken'];
		$userId = $arrayJson['events'][0]['source']['userId'];
		$type = $arrayJson['events'][0]['type'];

		$LINEProfileDatas['url'] = "https://api.line.me/v2/bot/profile/".$userId;
		$LINEProfileDatas['token'] = $accessToken;

		$resultsLineProfile = getLINEProfile($LINEProfileDatas);
		/*
		$LINEUserProfile = json_decode($resultsLineProfile['message'],true);
		$displayName = $LINEUserProfile['displayName'];
		
		$client = new \Google_Client();
		$client->setApplicationName('Google Sheets API PHP Quickstart');
		$client->setScopes(\Google_Service_Sheets::SPREADSHEETS);
		$client->setAuthConfig(__DIR__.'/amiable-nova-283403-c39da954a89c.json');
		$client->setAccessType('offline');

		$service = new \Google_Service_Sheets($client);
		$spreadsheetId = "1CNvcz0JfS7-MoN7LjAhwCMchGd3W-soxD5EDYEWAdAg";

		// updateData($spreadsheetId,$service);
		insertData($spreadsheetId,$service,$displayName);*/
		    
		$arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
		$arrayPostData['messages'][0]['type'] = "text";
		$arrayPostData['messages'][0]['text'] = $resultsLineProfile."MP5 บันทึกข้อความเรียบร้อยค่ะ";
		replyMsg($arrayHeader,$arrayPostData);
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
	function insertData($spreadsheetId,$service,$displayName)
	    {
		// $range = 'congress!D2:F1000000';
		    //INSERT DATA
		    $range = 'a2';
		    $values = [
			[$displayName],
		    ];
		    $body = new Google_Service_Sheets_ValueRange([
			'values' => $values
		    ]);
		    $params = [
			'valueInputOption' => 'RAW'
		    ];
		    $insert = [
			'insertDataOption' => 'INSERT_ROWS'
		    ];
		    $result = $service->spreadsheets_values->append(
			$spreadsheetId,
			$range,
			$body,
			$params,
			$insert
		    );
	    }

	function updateData($spreadsheetId,$service)
	    {
		$range = 'a2:b2';
		$values = [
			["Test","Test"],
		    ];
		    $body = new Google_Service_Sheets_ValueRange([
			'values' => $values
		    ]);
		$params = [
			'valueInputOption' => 'RAW'
		    ];
		    $result = $service->spreadsheets_values->update(
			$spreadsheetId,
			$range,
			$body,
			$params
		    );
	    }

	    function getData($spreadsheetId,$service)
	    {
		// GET DATA
		    $range = 'congress!D2:F1000000';
			$response = $service->spreadsheets_values->get($spreadsheetId, $range);
			$values = $response->getValues();

			if(empty($values)){
				print "No Data Found.\n";
			}else{
				foreach ($values as $row) {
					echo $row[0]."<br/>";
				}
			}
	    }
  
     /*Return HTTP Request 200*/
     http_response_code(200);
    ?>
