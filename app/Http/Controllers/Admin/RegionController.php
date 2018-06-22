<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Region\StoreRequest;
use App\Http\Requests\Admin\Region\UpdateRequest;
use App\Repositories\RegionRepository;

class RegionController extends Controller
{
    private $regionRepository;

    public function __construct() {
        $this->regionRepository = new RegionRepository;
    }

    public function index()
    {
        return view('cms.location.index');
    }


    //-- API functions

    public function indexApi()
    {
        $regions = $this->regionRepository->getRegions();

        return response()->json([
            'regions' => $regions
        ], 200);
    }

    public function storeApi(StoreRequest $request)
    {
        info("RegionController@storeApi", $request->all());

        $region = $this->regionRepository->store($request->all());

        return response()->json($region, 200);
    }

    public function updateApi(UpdateRequest $request, $id)
    {
        info("RegionController@updateApi", $request->all());

        $region = $this->regionRepository->update($id, $request->all());

        return response()->json($region, 200);
    }

    public function deleteApi($id)
    {
        info("RegionController@deleteApi", [
            'id' => $id
        ]);

        $result = $this->regionRepository->deleteById($id);

        return response()->json($result, 200);
    }
}
