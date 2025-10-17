<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cp;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class CpController extends Controller
{
    use ApiResponder;
    public function index()
    {
        $cp = Cp::all();
        return $this->successResponse($cp, 'List of Cp retrieved successfully.');
    }

    public function faseMapel(string $faseId, string $mapelId)
    {
        $cp = Cp::where('fase_id', $faseId)
            ->where('mapel_id', $mapelId)
            ->get();

        if (! $cp) {
            return $this->errorResponse('', 'Cp not found', 404);
        }
        return $this->successResponse($cp, 'List of Cp by Fase and Mapel retrieved successfully.');
    }

    public function show(string $id)
    {
        $cp = Cp::find($id);
        if (! $cp) {
            return $this->errorResponse('', 'Cp not found', 404);
        }
        return $this->successResponse($cp, 'Cp detail retrieved successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $cp = Cp::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('deskripsi', 'LIKE', "%{$query}%")
            ->get();

        return $this->successResponse($cp, 'Search results retrieved successfully.');
    }
}
