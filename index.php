<?php

use Guzzle\Plugin\Cookie\CookieJar\FileCookieJar;
use Guzzle\Plugin\Cookie\CookiePlugin;

try {
    require_once __DIR__ . '/vendor/autoload.php';

    $cookie_file_name = __DIR__ . '/test.cookie';
    $cookiePlugin = new CookiePlugin(new FileCookieJar($cookie_file_name));


    $client = new \Guzzle\Http\Client([
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0'
        ],
    ]);
    $client->addSubscriber($cookiePlugin);

    $request = $client->createRequest(
        'POST',
        'http://sr1.resto-service.ru:18001/resto/j_spring_security_check',
        [], [
        'j_username' => 'web',
        'j_password' => '999999',
    ],
        []);

    $response = $request->send();


    $now = new DateTime();

    $dateFormat = 'd.m.Y';

    $urlParams = [
        'dateFrom' => $now->format($dateFormat),
        'dateTo' => $now->add(DateInterval::createFromDateString('day'))->format($dateFormat),
        'presetId' => '8b64c3a3-391c-4dc6-abb7-5bb85627198a',
    ];

    $request = $client->createRequest('GET', 'http://sr1.resto-service.ru:18001/resto/service/reports/report.jspx?' . http_build_query($urlParams));

    $response = $request->send();

    $xmlRaw = $response->getBody(1);

    $p = xml_parser_create();
    xml_parse_into_struct($p, $xmlRaw, $vals, $index);
    xml_parser_free($p);

    $value = ceil($vals[$index['DISHAMOUNTINT'][0]]['value'] ?: false);
    echo '<h1>ЗА сегодня было приготовлено вот столько '. ($value).'</h1>>';

} catch (Exception $e) {
var_dump($e);

}