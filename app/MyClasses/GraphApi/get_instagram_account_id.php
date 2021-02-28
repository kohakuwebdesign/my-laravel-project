<?php
/*
 *
 * Getting instagram account id (instagram business account id)
 *  
 */

include 'define.php';

// get instagram account id endpoint
$instagramAccountIdEndpointFormat = ENDPOINT_BASE .'{page-id}?fields=instagram_business_account&access_token={access_token}';
$instagramAccountIdEndpoint = ENDPOINT_BASE . $pageId;

// endpoint params
$igParams = array(
    'fields' => 'instagram_business_account',
    'access_token' => $accessToken
);

// add paramst to endpoint
$instagramAccountIdEndpoint .= '?' . http_build_query($igParams);

// setup curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $instagramAccountIdEndpoint);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// make call and get response
$response = curl_exec($ch);

curl_close($ch);

$responseArray = json_decode($response, true);
var_dump($responseArray);

unset($responseArray['data'][0]['access_token']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get instagram account id</title>
</head>
<body>
    <h2>Endpoint format: <?php echo $instagramAccountIdEndpointFormat;?></h2>
    <h2>Instagram Business Account ID: <?php echo $responseArray['id'];?></h2>
</body>
</html>