<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json; charset=utf-8");

include "config.php";
include "functions.php";
$status = new Main();

foreach ($ips as $server => $ip) {
    $servers[] = array (
        "server" => $server,
        "status" => $status->getMCStatus($ip)
    );
}

foreach ($websites as $website => $url) {
    $websiteslist[] = array (
        "website" => $website,
        "status" => $status->getWebsiteStatus($url)
    );
}

$return[] = array (
    "websites" => $websiteslist,
    "servers" => $servers
);

echo json_encode($return);