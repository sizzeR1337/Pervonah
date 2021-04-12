<?php

$tokens = [
		'token',
		'token2' 
	  ]; // tokens like ['test', 'test2', 'test3'];
$message = 'my message'; // not array cos useless
$owner_id = '-184006546' // insert vk id

$id = file_get_contents('last_id.txt');

foreach($tokens as $token){
	
		$request_params = array(
			'owner_id' => $owner_id,
			'count' => 1,
			'filter' => 'owner',
			'access_token' => $token,
			'v' => '5.130'
		);
		$get_params = http_build_query($request_params);
		
		$response = file_get_contents('https://api.vk.com/method/wall.get?'.$get_params);
		$response = json_decode($response, true);
		
		$last_id = $response['response']['items'][0]['id'];
		
		var_dump($last_id);
		
		if($id < $last_id){
			
			$request_params = array(
				'owner_id' => $owner_id,
				'post_id' => $last_id,
				'message' => $message,
				'guid' => rand(1, 2147483647),
				'access_token' => $token,
				'v' => '5.130'
			);
			$get_params = http_build_query($request_params);
			
			$response = file_get_contents('https://api.vk.com/method/wall.createComment?'.$get_params);
			
			var_dump($response);
			
			file_put_contents('last_id.txt', $last_id);
			
		}
}

?>
