<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fase;
use App\Models\Mapel;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

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
        $fase = Fase::find($id);
        return $this->successResponse($fase, 'Fase detail retrieved successfully.');
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'      => 'sometimes|required|string|max:255',
            'ikon'      => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required|text|max:1000',
        ]);

        $fase = Fase::find($id);

        if (! $fase) {
            return $this->errorResponse('Fase not found', 404);
        }

        $fase->update($request->only(['nama', 'ikon', 'deskripsi']));

        return $this->successResponse($fase, 'Fase updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fase = Fase::find($id);
        $fase->delete();
        return $this->successResponse([], 'Fase deleted successfully.');
    }
}
