<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('broker.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|exists:devices,id',
            'voltage' => 'nullable|numeric',
            'current' => 'nullable|numeric',
            'power' => 'nullable|numeric',
            'energy' => 'nullable|numeric',
            'frequency' => 'nullable|numeric',
            'power_factor' => 'nullable|numeric|between:0,1',
            'temperature' => 'nullable|numeric',
            'humidity' => 'nullable|numeric|between:0,100',
            'measured_at' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the energy measurement
            $measurement = EnergyMeasurement::create([
                'device_id' => $request->device_id,
                'voltage' => $request->voltage ?? 0,
                'current' => $request->current ?? 0,
                'power' => $request->power ?? 0,
                'energy' => $request->energy ?? 0,
                'frequency' => $request->frequency ?? 0,
                'power_factor' => $request->power_factor ?? 0,
                'temperature' => $request->temperature ?? 0,
                'humidity' => $request->humidity ?? 0,
                'measured_at' => $request->measured_at ? Carbon::parse($request->measured_at) : now()
            ]);

            // Update device last seen at
            Device::where('id', $request->device_id)->update(['last_seen_at' => now()]);

            return response()->json([
                'status' => 'success',
                'message' => 'Measurement stored successfully',
                'data' => $measurement
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store measurement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
