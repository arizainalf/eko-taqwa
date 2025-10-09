<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tema;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    use ApiResponder;

    public function index()
    {
        $tema = Tema::all();

        return $this->successResponse($tema, 'List of Tema retrieved successfully.');
    }

    public function show(string $id)
    {
        $tema = Tema::find($id);

        if (! $tema) {
            return $this->errorResponse('', 'Tema not found', 404);
        }

        return $this->successResponse($tema, 'Tema detail retrieved successfully.');
    }

}
