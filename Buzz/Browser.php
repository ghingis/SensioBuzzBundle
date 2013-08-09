<?php

namespace Sensio\Bundle\BuzzBundle\Buzz;

use Buzz\Browser as OldBrowser;
use Buzz\Client\ClientInterface;
use Buzz\Message\Factory\FactoryInterface;
use Buzz\Message\MessageInterface;
use Symfony\Component\HttpKernel\Debug\Stopwatch;

class Browser extends OldBrowser
{
    private $called;
    private $stopwatch;

    public function __construct(ClientInterface $client = null, FactoryInterface $factory = null, Stopwatch $stopwatch = null)
    {
        parent::__construct($client,$factory);
        $this->stopwatch = $stopwatch;
        $this->called = array();
    }
    /**
     * Sends a request.
     *
     * @param string $url     The URL to call
     * @param string $method  The request method to use
     * @param array  $headers An array of request headers
     * @param string $content The request content
     *
     * @return MessageInterface The response object
     */
    public function call($url, $method, $headers = array(), $content = '')
    {
        if ($this->stopwatch != null){
            $this->stopwatch->start("BuzzBrowser::call","buzz_network_io");
        }


        $return = parent::call($url, $method, $headers = array(), $content = '');


        if ($this->stopwatch != null){
            $event = $this->stopwatch->stop("BuzzBrowser::call",$url);
        }
        if (isset($event) && $event != null){
            $time = $event->getTotalTime();
        }else{
            $time = "Stopwatch missing";
        }
        array_push($this->called,array(
                "url" => $url,
                "time" => $time,
                "method" => $method,
                "headers" => $headers,
                "content" => $content,
            )
        );

        return $return;
    }

    public function getCalled()
    {
        return $this->called;
    }
}