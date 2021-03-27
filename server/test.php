<?php 
$curl_h = curl_init("https://www.dotabuff.com/players/66296404/matches?enhance=overview&page=2");

curl_setopt($curl_h, CURLOPT_HTTPHEADER,
    array(
        'User-Agent: NoBrowser v0.1 beta',
    )
);

# do not output, but store to variable
curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl_h);
echo $response;
?>