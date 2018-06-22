<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Region;

class RegionRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Region::class;
    }

    public function getDropDownList()
    {
        return $this->model
                    ->select([
                        'id', 'name', 'parent_id'
                    ])
                    ->where('parent_id', null)
                    ->with(['regions' => function($q) {
                        $q->select([
                            'id', 'name', 'parent_id'
                        ]);
                    }])
                    ->get();
    }

    public function getRegions()
    {
        return $this->model
                    ->where('parent_id', null)
                    ->with(['regions'])
                    ->get();
    }

    public function store($data)
    {
        $region = $this->create($data);
        if (!$region->parent_id) {
            $region->load('regions');
        }

        return $region;
    }

    public function update($id, $data)
    {
        $region = $this->updateById($id, $data);

        if (!$region->parent_id) {
            $region->load('regions');
        }

        return $region;
    }
}
