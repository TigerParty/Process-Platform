<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    private $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function indexApi()
    {
        $regions = $this->regionRepository->getDropDownList();

        return response()->json([
            'regions' => $regions
        ], 200);
    }
}
