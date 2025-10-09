<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    use ApiResponder;
    public function create(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string|max:255',
            'name'      => 'required|string|max:255|unique:device',
        ]);

        $device = Device::create([
            'device_id' => $request->device_id,
            'name'      => $request->name,
        ]);

        return response()->json([
            'data'    => $device,
            'message' => 'Device created successfully',
        ]);

    }

    public function show($id)
    {
        $device = Device::where('device_id', $id)->first();

        if (! $device) {
            return $this->errorResponse('Device not found', 404);
        }

        return $this->successResponse($device);
    }
}
