<?php
namespace App\MyClasses;

class MecabApi
{
    /*
     * Get response from MecabApi
     *
     * @param string $text
     * @return array
     */
    public function getResponse($text)
    {
        $text = urlencode($text);
        $endpoint = config('app.mecab_api_endpoint');
        $url = $endpoint.'?text='.$text;

        $json = file_get_contents($url);
        $array = json_decode($json, true);

        return $array;
    }
}
