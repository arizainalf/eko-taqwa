<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refleksi;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class RefleksiController extends Controller
{
    use ApiResponder;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $refleksi = Refleksi::all();
        return $this->successResponse($refleksi, 'List of Refleksi retrieved successfully.');
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $refleksi = Refleksi::find($id);

        if (! $refleksi) {
            return $this->errorResponse('', 'Refleksi not found', 404);
        }

        return $this->successResponse($refleksi, 'Refleksi detail retrieved successfully.');
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
}
