<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ayat;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class AyatController extends Controller
{
    use ApiResponder;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ayat = Ayat::all();
        return $this->successResponse($ayat, 'List of Ayat retrieved successfully.');
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
        $ayat = Ayat::find($id);
        if (! $ayat) {
            return $this->errorResponse('', 'Ayat not found', 404);
        }
        return $this->successResponse($ayat, 'Ayat detail retrieved successfully.');
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

        $ayat = Ayat::where('teks', 'LIKE', "%{$query}%")
            ->orWhere('arti', 'LIKE', "%{$query}%")
            ->get();

        return $this->successResponse($ayat, 'Search results retrieved successfully.');
    }
}
