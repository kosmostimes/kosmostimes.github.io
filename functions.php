<?php
class Main
{
    public function getWebsiteStatus($host) {
        if (@explode(';', $host)[1] == "maint") {
            return "2";
        }
        if ($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {
            fclose($socket);
            return "1";
        } else {
            return "0";
        }
    }

    public function getMCStatus($ip)
    {
        if (@explode(';', $ip)[1] == "maint") {
            return "2";
        }
        $json["url"] = file_get_contents("https://api.mcsrvstat.us/2/" . $ip);
        $json["decode"] = json_decode($json["url"], "1");
        if ($json["decode"]["online"]) {
            return "1";
        } else {
            return "0";
        }
    }
}