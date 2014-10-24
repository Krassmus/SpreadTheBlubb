<?php
/*
 *  Copyright (c) 2014  Rasmus Fuhse <fuhse@data-quest.de>
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License as
 *  published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 */

require_once 'app/controllers/plugin_controller.php';

class SettingsController extends PluginController {

    public function set_action() {
        PageLayout::setTabNavigation('/links/settings');
        Navigation::activateItem("/links/settings/blubber/spreadtheblubb");
        $this->request_token = $this->getTwitterRequestToken();

    }

    public function oauth_action($service) {
        if ($service === "twitter") {

        }
        if ($service === "facebook") {

        }
    }

    protected function getTwitterRequestToken() {
        $url = "https://api.twitter.com/oauth/request_token";
        $api_key = get_config("BLUBBER_TWITTER_CONSUMER_KEY");

        $r = curl_init($url);
        $time = time();
        $httpheader = array();

        $oauth_header = array(
            'oauth_consumer_key' => $api_key,
            'oauth_nonce' => md5($api_key."_request_".$time."_".uniqid()),
            'oauth_signature_method' => "HMAC-SHA1",
            'oauth_timestamp' => $time,
            'oauth_version' => "1.0"
        );
        $oauth_header['oauth_signature'] = $this->calculateSignature($url, "GET", $oauth_header);
        uksort($oauth_header, 'strcmp');

        $authorization_header = "";
        foreach ($oauth_header as $key => $value) {
            if ($authorization_header) {
                $authorization_header .= ", ";
            }
            $authorization_header .= rawurlencode($key).'="'.rawurlencode($value).'"';
        }
        $authorization_header = "OAuth ".$authorization_header;
        //die("Authorization: ".$authorization_header);
        $httpheader['Authorization'] = $authorization_header;

        curl_setopt($r, CURLOPT_HTTPHEADER, $httpheader);
        curl_setopt($r, CURLOPT_HEADER, false);
        curl_setopt($r, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($r, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($r);
        $error = curl_error($r);
        $header_size = curl_getinfo($r, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);
        if ($error) {
            throw new Exception($error);
        }
        //die($response);

        curl_close($r);

        $vars = array();
        foreach (explode("&", $response) as $string) {
            list($key, $value) = explode("=", $string);
            $vars[rawurldecode($key)] = rawurldecode($value);
        }
        //var_dump($vars);
        return $vars['oauth_token'];
    }

    private function calculateSignature($url, $method, $header) {
        uksort($header, 'strcmp');
        $parameter = "";
        foreach ($header as $key => $value) {
            if ($parameter !== "") {
                $parameter .= "&";
            }
            $parameter .= rawurlencode($key)."=".rawurlencode($value);
        }
        $base = strtoupper($method)."&".rawurlencode($url)."&".rawurlencode($parameter);
        $signing_key = rawurlencode(get_config("BLUBBER_TWITTER_CONSUMER_SECRET"))."&";

        $token = (base64_encode(hash_hmac("sha1", $base, $signing_key, true)));
        return $token;
    }

}




