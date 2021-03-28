<?php
class HttpUser
{
    public function Request($URL)
    {
        try {
            //$curl_h = curl_init("https://www.dotabuff.com/players/66296404/matches?enhance=overview&page=1");
            $curl_h = curl_init($URL);

            curl_setopt(
                $curl_h,
                CURLOPT_HTTPHEADER,
                array(
                    'User-Agent: NoBrowser v0.1 beta',
                )
            );

            # do not output, but store to variable
            curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl_h);

            return $response;

        } catch (Exception $e) {
            echo ("An error occured while making the GET request. Error Message: " + $e->getMessage());
        }
    }
}
