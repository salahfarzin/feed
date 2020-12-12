<?php

namespace Ahoraian\Feed\Reader\Driver;

use Ahoraian\Feed\Reader\Exception\RuntimeException;

class CurlDriver implements HttpDriverInterface
{

    /**
     * @param $url
     * @param \DateTime|null $lastModified
     * @return Response|mixed
     */
    public function getResponse($url, \DateTime $lastModified = null)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_TIMECONDITION, CURL_TIMECOND_IFMODSINCE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
        if ($lastModified) {
            curl_setopt($curl, CURLOPT_TIMEVALUE, $lastModified->getTimestamp());
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
        $curlReturn = curl_exec($curl);

        if (!$curlReturn) {
            $err = curl_error($curl);
            throw new RuntimeException("$url is not reachable: {$err}");
        }

        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        curl_close($curl);

        $headerString = substr($curlReturn, 0, $headerSize);
        $body = substr($curlReturn, $headerSize);

        preg_match('/(?<version>\S+) (?P<code>\d+) (?P<message>\V+)/', $headerString, $headers);

        $response = new Response();
        $response->setBody($body);
        $response->setStatusCode($headers['code']);
        $response->setHeaders($headers);

        return $response;
    }
}