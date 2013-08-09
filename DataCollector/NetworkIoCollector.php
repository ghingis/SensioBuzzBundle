<?php

namespace Sensio\Bundle\BuzzBundle\DataCollector;

use Sensio\Bundle\BuzzBundle\Buzz\Browser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class NetworkIoCollector extends DataCollector
{
    private $service;
    private $stopwatch;

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'called' => $this->service->getCalled(),
        );
    }

    public function setNetworkIoService(Browser $service)
    {
        $this->service = $service;
    }

    public function getCalled()
    {
        return $this->data['called'];
    }

    public function getName()
    {
        return 'network_io';
    }
}