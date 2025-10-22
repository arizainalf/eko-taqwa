<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Device",
 *     description="Manajemen data Device (perangkat pengguna)"
 * )
 */
class DeviceController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Post(
     *     path="/api/device",
     *     summary="Daftarkan device baru",
     *     tags={"Device"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id", "name"},
     *             @OA\Property(property="device_id", type="string", example="1234-5678-ABCD"),
     *             @OA\Property(property="name", type="string", example="HP Ariza")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="string", example="1"),
     *                 @OA\Property(property="device_id", type="string", example="1234-5678-ABCD"),
     *                 @OA\Property(property="name", type="string", example="HP Ariza")
     *             ),
     *             @OA\Property(property="message", type="string", example="Device created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal (misalnya name sudah terdaftar)"
     *     )
     * )
     */
    public function create(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string|max:255',
            'name'      => 'required|string|max:255|unique:device',
        ]);

        $device = Device::where('device_id', $request->device_id)->first();

        if (! $device) {

            $newdevice = Device::create([
                'device_id' => $request->device_id,
                'name'      => $request->name,
            ]);

            $data = [
                'device' => $newdevice,
            ];

            return $this->successResponse($data, 'Device created successfully.');
        } else {
            $device->name = $request->name;
            $device->save();
            $data = [
                'device' => $device,
            ];

            return $this->successResponse($data, 'Devidata: ce has been created before.');
        }

    }

    /**
     * @OA\Get(
     *     path="/api/device/{id}",
     *     summary="Lihat detail device berdasarkan ID",
     *     tags={"Device"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Device ID unik (UUID atau string ID perangkat)",
     *         @OA\Schema(type="string", example="1234-5678-ABCD")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="device_id", type="string", example="1234-5678-ABCD"),
     *                 @OA\Property(property="name", type="string", example="HP Ariza")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $device = Device::where('device_id', $id)->first();

        if (! $device) {
            return $this->errorResponse('Device not found', 404);
        }

        return $this->successResponse($device);
    }
}
