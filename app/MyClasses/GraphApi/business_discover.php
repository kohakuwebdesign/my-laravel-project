<?php
/*
 *
 * Getting instagram a user's metadata
 *  
 */

include 'define.php';

// get instagram account id endpoint
$userMetaDataEndpointFormat = ENDPOINT_BASE .'{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}&access_token={access-token}';
$userMetaDataEndpoint = ENDPOINT_BASE . $instagramAccountId;

// endpoint params
$igParams = array(
    'fields' => 'business_discovery.username(kohakuwebdesign){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}',
    'access_token' => $accessToken
);

// add paramst to endpoint
$userMetaDataEndpoint .= '?' . http_build_query($igParams);

// setup curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $userMetaDataEndpoint);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// make call and get response
$response = curl_exec($ch);

curl_close($ch);

$responseArray = json_decode($response, true);
echo '<pre>';
print_r($responseArray);
echo '</pre>';

unset($responseArray['data'][0]['access_token']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get instagram user metadata</title>
</head>
<body>
    <h2>Endpoint format: <?php echo $userMetaDataEndpointFormat;?></h2>    
</body>
</html>