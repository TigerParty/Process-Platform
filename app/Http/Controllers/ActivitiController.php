<?php
/**
 * Created by PhpStorm.
 * User: louis
 * Date: 08/03/2018
 * Time: 10:37 AM
 */

namespace App\Http\Controllers;


use App\Services\ActivitiCurlService;
use Illuminate\Http\Request;

class ActivitiController extends Controller
{
    private $activitiService;

    public function __construct(ActivitiCurlService $activitiCurlService)
    {
        $this->activitiService = $activitiCurlService;
    }

    public function getApi(Request $request)
    {
        $response = $this->activitiService->getService($request->input('url'))
            ->withData($request->except('url'))
            ->get();

        return response()->json(json_decode($response->content), $response->status);
    }

    public function postApi(Request $request)
    {
        $response = $this->activitiService->getService($request->input('url'))
            ->withData($request->except('url'))
            ->asJsonRequest()
            ->post();

        return response()->json(json_decode($response->content), $response->status);
    }
}