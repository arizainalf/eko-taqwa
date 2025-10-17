<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Traits\ApiResponder;

class MapelController extends Controller
{
    use ApiResponder;

    public function index()
    {
        $mapel = Mapel::all();
        return $this->successResponse($mapel, 'List of Mapel retrieved successfully.');
    }
    public function fase(string $id)
    {
        $mapel = Mapel::all();
        $data  = [
            'mapel'   => $mapel,
            'fase_id' => $id,
        ];
        return $this->successResponse($data, 'List of Mapel by Fase retrieved successfully.');
    }

}
