<?php
## Koshka#83151370

use GuzzleHttp\Client;

error_reporting(E_ERROR);
ini_set('display_errors', 1);


try {
    require_once __DIR__ . '/vendor/autoload.php';

    $options = json_decode(file_get_contents(__DIR__ . '/options.json'), true);

    $cookie_file_name = __DIR__ . '/test.cookie';
    $cookiePlugin = new \GuzzleHttp\Cookie\CookieJar();


    $client = new Client([
//        'base_uri' => 'http://sr1.resto-service.ru:18001',
//        'base_uri' => 'http://94.130.139.76:18001',
        'base_uri' => 'http://10.0.0.2:18001',
        'cookies' => $cookiePlugin,
        'timeout' => 2.0,
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0',
        ],
    ]);

    $response = $client->request(
        'POST',
        '/resto/j_spring_security_check',
        ['form_params'=>[
            'j_username' => $options['iikoLogin'],
            'j_password' => $options['iikoPass'],
        ]]);


    $now = new DateTime();
    $dateFormat = 'd.m.Y';
    $urlParams = [
        'dateFrom' => $now->format($dateFormat),
        'dateTo' => $now->format($dateFormat),
        'presetId' => '8b64c3a3-391c-4dc6-abb7-5bb85627198a',
    ];

    $response = $client->request('GET', '/resto/service/reports/report.jspx?' . http_build_query($urlParams));
    $xmlRaw = $response->getBody();

    $p = xml_parser_create();
    xml_parse_into_struct($p, $xmlRaw, $vals, $index);
    xml_parser_free($p);

    $value = ceil($vals[$index['DISHAMOUNTINT'][0]]['value'] ?: false);

} catch (Exception $e) {
    $value = "---";
    $msg = $e->getMessage();
}
echo json_encode(["number" => $value, 'msg' => $msg, 'date' => $now->format($dateFormat),'xml'=>$xmlRaw,'total'=> $options['total']]);