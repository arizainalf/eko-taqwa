<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    use ApiResponder;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kuis = Kuis::all();
        return $this->successResponse($kuis, 'List of Kuis retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kuis = Kuis::find($id);
        if (! $kuis) {
            return $this->errorResponse('', 'Kuis not found', 404);
        }
        return $this->successResponse($kuis, 'Kuis detail retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getRandomKuis($tema_id, $limit)
    {
        $kuis = Kuis::where('tema_id', $tema_id)->inRandomOrder()->limit($limit)->get();
        return $this->successResponse($kuis, 'Random Kuis retrieved successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $kuis  = Kuis::where('question', 'LIKE', "%$query%")
            ->orWhere('option_a', 'LIKE', "%$query%")
            ->orWhere('option_b', 'LIKE', "%$query%")
            ->orWhere('option_c', 'LIKE', "%$query%")
            ->orWhere('option_d', 'LIKE', "%$query%")
            ->get();

        return $this->successResponse($kuis, 'Search results retrieved successfully.');
    }
}
