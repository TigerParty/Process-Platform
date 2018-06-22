<?php
/**
 * Created by PhpStorm.
 * User: louis
 * Date: 06/03/2018
 * Time: 4:30 PM
 */

namespace App\Services;


use Ixudra\Curl\CurlService;

class ActivitiCurlService extends CurlService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('argo.activiti_url');
    }

    public function basicAuth()
    {
        return 'Authorization: Basic ' . base64_encode(config('argo.activiti_username') . ':' . config('argo.activiti_password'));
    }

    public function to($uri)
    {
        return parent::to($this->baseUrl . $uri);
    }

    public function getService($uri)
    {
        return $this->to($uri)
            ->withContentType('application/json')
            ->withHeader($this->basicAuth())
            ->returnResponseObject();
    }
}