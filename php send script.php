<?php

// Payload data you want to send to Android device(s)
// (it will be accessible via intent extras)    
$data = array( 'message' => 'Hello World!' );

// The recipient registration tokens for this notification
// http://developer.android.com/google/gcm/ 

// Sender til Jacob's telefon
$ids = array( 'eUvwSTTTfKs:APA91bH5WSBcvCTOAUwTUk8HmEfycRNgwq-qW44chDcZJeIwP9JGBnNhNWhRjr73m-Jk-QekECTUwHcDtRA4au6K6JXMKv3x3eHw6y2xoJ5i3KfpI2wWLwAH1cJLu3_EbAhYFkQGuIqk', 
				'cHPQWU18yDo:APA91bGnd25uekhMGrxnjg_S1nctAa4l8L7UMKmK3tKu_8SZe07M7H6y7Mm9n7bCHYRVtvDx7q0aphdWS0sMhaRhdz3bwG8OErhLMz9615x_Iyb9zzNtqXwKtnb0eoulOOS_Q-IsIto6');

$topics = ( '/topics/prosa' );

// Send a GCM push
sendGoogleCloudMessage(  $data, $ids, $topics );

function sendGoogleCloudMessage( $data, $ids, $topics )
{
    // Insert real GCM API key from Google APIs Console
    // https://code.google.com/apis/console/        
    $apiKey = 'AIzaSyDlSW-tiv8wO6oGfFodn_n98bKj6L5Lg4Q';

    // Define URL to GCM endpoint
    $url = 'https://gcm-http.googleapis.com/gcm/send';

    // Set GCM post variables (device IDs and push payload)     
    $post = array(
		'to' => $topics,
		//'registration_ids'  => $ids,
		'data'	=> $data,
	);
	

    // Set CURL request headers (authentication and type)       
    $headers = array( 
		'Authorization: key=' . $apiKey,
		'Content-Type: application/json'
	);

    // Initialize curl handle       
    $ch = curl_init();

    // Set URL to GCM endpoint      
    curl_setopt( $ch, CURLOPT_URL, $url );

    // Set request method to POST       
    curl_setopt( $ch, CURLOPT_POST, true );

    // Set our custom headers       
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

    // Get the response back as string instead of printing it       
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    // Set JSON post data
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

    // Actually send the push   
    $result = curl_exec( $ch );

    // Error handling
    if ( curl_errno( $ch ) )
    {
        echo 'GCM error: ' . curl_error( $ch );
    }

    // Close curl handle
    curl_close( $ch );

    // Debug GCM response       
    echo $result;
}
?>