<?php

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
 * Ngubah date dari format database ke yang mudah dibaca
 * 2017-1-31 jadi 31-1-2017
 */
function date_view($date, $format = 'd-m-Y')
{
    $time = strtotime($date);
    if (!$time) {
        return '';
    }
    return date($format, $time);
}

/**
 * Ngubah date dari format view ke database
 * 31-1-2017 jadi 2017-1-31
 * kalo lagi iseng, coba buka ini.
 * http://php.net/manual/en/datetime.createfromformat.php
 */
function date_database($date, $format = 'd-m-Y')
{
    try {
        return Carbon::createFromFormat($format, $date)->toDateTimeString();
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Ngubah time dari format database ke yang mudah dibaca
 * 2017-1-31 06:35:12 jadi 31-1-2017 06:35
 */
function time_view($time, $format = 'H:i')
{
    $time = strtotime($time);
    if (!$time) {
        return '';
    }
    return date($format, $time);
}

/**
 * Ngubah date dari format database ke yang mudah dibaca
 * 2017-1-31 06:35:12 jadi 31-1-2017 06:35
 */
function datetime_view($date, $format = 'd-m-Y H:i')
{
    $time = strtotime($date);
    if (!$time) {
        return '';
    }
    return date($format, $time);
}

/**
 * Ngubah date dari format view ke database
 * 31-1-2017 jadi 2017-1-31
 * kalo lagi iseng, coba buka ini.
 * http://php.net/manual/en/datetime.createfromformat.php
 */
function datetime_database($date, $format = 'd-m-Y H:i')
{
    try {
        return Carbon::createFromFormat($format, $date)->toDateTimeString();
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Ngubah angka format uang ke integer normal
 * 12,500,000 jadi 12500000
 */
function unaccounting($number)
{
    return str_replace(',', '', $number);
}

function hari($hari)
{
    switch ($hari) {
        case '1': return 'Senin';
        case '2': return 'Selasa';
        case '3': return 'Rabu';
        case '4': return 'Kamis';
        case '5': return 'Jumat';
        case '6': return 'Sabtu';
        case '7': return 'Minggu';
        default: return $hari;
    }
}

function terbilang($x)
{
    $abil = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    if ($x < 12)
        return " " . $abil[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . "belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return " seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return " seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}


/* guzzle */
function apiGET($url){
    $client = new Client();
    $result = $client->request('GET', $url);
    $body = $result->getBody();
    $data =  json_decode($body->getContents());
    return $data;
}

function apiPOST($url){
    $client = new Client();
    $result = $client->request('POST', $url);
    dd($result);
    $body = $result->getBody();
    $data =  json_decode($body->getContents());
    return $data;
}

function apiPOSTbody($url,$image){
    $client = new Client(); 
    $result = $client->post($url, [
    'json' => [
                'Hostname'=> '',
                'Domainname'=> '',
                'User'=> '',
                'AttachStdin'=> false,
                'AttachStdout'=> true,
                'AttachStderr'=> true,
                'Tty'=> false,
                'OpenStdin'=> false,
                'StdinOnce'=> false,
                'Env'=> [ 'FOO=bar', 'BAZ=quux' ],
                'Entrypoint'=> '',
                'Cmd'=> [ 'date' ],
                'Image'=> $image,
                'Volumes'=> [
                   '/volumes/data' => new stdClass() 
                ],
                'WorkingDir'=> '',
                'NetworkDisabled'=> false,
                'MacAddress'=> '12:34:56:78:9a:bc',
                'ExposedPorts'=> 
                [ 
                    '22/tcp'=> new stdClass() 
                ],
                'StopSignal'=> 'SIGTERM',
                'StopTimeout'=> 10
            ]
]);
    // dd($result);
    $body = $result->getBody();
    // dd($body);
    $data =  json_decode($body->getContents());
    // dd($data);

    return $data;
}

function apiDELETE($url){
    $client = new Client();
    $result = $client->request('DELETE', $url);
    $body = $result->getBody();
    $data =  json_decode($body->getContents());
    return $data;
}
