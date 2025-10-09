<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fase;
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
        return $this->successResponse($fases, 'List of Fases retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'ikon'      => 'required|string|max:255',
            'deskripsi' => 'required|max:1000',
        ]);

        $fase = Fase::create([
            'nama'      => $request->nama,
            'ikon'      => $request->ikon,
            'deskripsi' => $request->deskripsi,
        ]);

        return $this->successResponse($fase, 'Fase created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fase = Fase::find($id);
        return $this->successResponse($fase, 'Fase detail retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
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
