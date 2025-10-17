<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fase;
use App\Models\Mapel;
use App\Traits\ApiResponder;

class FaseController extends Controller
{
    use ApiResponder;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fases = Fase::all();
        $mapel = Mapel::count();

        $data = [
            'fase'        => $fases,
            'total_mapel' => $mapel,
        ];
        return $this->successResponse($data, 'List of Fases retrieved successfully.');
    }
    public function show(string $id)
    {
        $fase  = Fase::find($id);
        $mapel = Mapel::all();

        $data = [
            'fase'  => $fase,
            'mapel' => $mapel,
        ];
        if (! $fase) {
            return $this->errorResponse('', 'Fase not found', 404);
        }
        return $this->successResponse($data, 'Fase detail retrieved successfully.');
    }
}
