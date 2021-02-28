<?php
/*
 *
 * Getting facebook pages
 *  
 */
include 'define.php';

// get pages endpoint
$pagesEndpointFormat = ENDPOINT_BASE . 'me/accounts?access_token={access_token}';
$pagesEndpoint = ENDPOINT_BASE . 'me/accounts';

// endpoint params
$pageParams = array(
    'access_token' => $accessToken
);

// add paramst to endpoint
$pagesEndpoint .= '?' . http_build_query($pageParams);


// setup curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $pagesEndpoint);
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
    <title>Get User's Pages(Facebook Pages)</title>
</head>
<body>
    <h2>Endpoint format: <?php echo $pagesEndpointFormat;?></h2>
</body>
</html>