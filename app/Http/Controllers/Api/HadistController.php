<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hadist;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class HadistController extends Controller
{
    use ApiResponder;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hadist = Hadist::all();
        return $this->successResponse($hadist, 'List of Hadist retrieved successfully.');
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
        $hadist = Hadist::find($id);
        if (! $hadist) {
            return $this->errorResponse('', 'Hadist not found', 404);
        }
        return $this->successResponse($hadist, 'Hadist detail retrieved successfully.');
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

    public function search(Request $request)
    {
        $query = $request->input('query');

        $hadist = Hadist::where('judul', 'like', "%{$query}%")
            ->orWhere('isi', 'like', "%{$query}%")
            ->get();

        return $this->successResponse($hadist, 'Search results retrieved successfully.');
    }
}
