<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	$data = json_decode(file_get_contents('php://input'), true);

	require('Notification.php');

    //$pMethod = $data["method"];
    //$pTitle = $data["title"];
    //$pMessage = $data["message"];
    //$pTokens = explode(',' $data["tokens"]);

    $pMethod = "sendNotification";
    $pTitle = "From server";
    $pMessage = "Custom message";
    $pTokens = explode(',', "dqhNJb6wSC-8pHdL9X4ZZr:APA91bFT4_TUxNeDUnk_GEopvPSSbu5WNpn0jp1pqgx6Q2IZS-1ZRr1_kNLgrIlu0VPrc2YjECc1u6ZUG3amqjea75ySQ06kanZ7gYLWJCj2UrVDe8ATvDlXGUSYvG4Aq2gW2llusPnz");
    
    $length = count($pTokens);
    for($i = 0; $i < $length; $i++) {
        echo $pTokens[$i];
        echo "<br>";
        echo "<br>";
    }      
    
	function sendNotification($title, $message, $tokens){
		$notification = new Notification();
		$response=$notification->sendNotificationByTopic($title, $message, $tokens);
		
		return $response;
	}
	
	switch ($pMethod) {
		case "sendNotification":{
			$response=sendNotification($pTitle, $pMessage, $pTokens);
			break;
		}
			
		default:{
			$response["success"]=104;
			$response["message"]='El método indicado no se encuentra registrado';
		}
	}
	
	echo json_encode ($response)
?>
