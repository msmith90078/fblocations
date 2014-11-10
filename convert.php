#!/usr/bin/php
<?php

require 'vendor/autoload.php';

$MY_IPINFO_DB_KEY = 'get your own key from http://ipinfodb.com/register.php :)';

use Flintstone\Flintstone;
$options = ['dir' => '.'];
$ipsdb = Flintstone::load('ipsdb', $options);

$a = file_get_contents('security.htm');
if (!$a) {
    printf("Couldn't find security.htm file!\n");
    exit;
}
preg_match('/<h2>IP Addresses<\/h2><ul><li>(.*?)<\/li><\/ul><h2>/', $a, $matches);
$b = $matches[1];
$c = preg_replace('/<\/li><li>/','_',$b);
$d = explode('_',$c);

printf("Found %d locations stored in your security.htm file\n", count($d));


$locs = [
    "type" => "FeatureCollection",
    "features" => []
];

foreach($d as $ip) {

    if ($ip == '' or !filter_var($ip, FILTER_VALIDATE_IP)) {
        continue;
    }

    if (!$details = $ipsdb->get($ip)) {
        $json = @file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=$MY_IPINFO_DB_KEY&ip=$ip&format=json");
        $details = json_decode($json, true);
        $ipsdb->set($ip, $details);

        // be nice
        sleep(1);
    }

    $locs["features"][] = [ "geometry" => [ "type" => "Point", "coordinates" => [
        (float)$details["longitude"],
        (float)$details["latitude"]
    ]]];
}

file_put_contents("locations.json", json_encode($locs, JSON_PRETTY_PRINT));

printf("Everything is written to locations.json\nVisit index.html to see the result\nEnjoy!\n");

