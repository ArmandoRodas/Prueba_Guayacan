<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceType;
use Illuminate\Http\Request;

class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deviceTypes = DeviceType::orderBy('name')->paginate(10);
        return view('device_types.index', compact('deviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('device_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60|unique:device_types,name',
        ]);

        DeviceType::create($data);
        return redirect()->route('device-types.index')->with('success', 'Device type created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceType $deviceType)
    {
        return view('device_types.edit', compact('deviceType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceType $deviceType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60|unique:device_types,name,' . $deviceType->id,
        ]);

        $deviceType->update($data);
        return redirect()->route('device-types.index')->with('success', 'Device type updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceType $deviceType)
    {
        $deviceType->delete();
        return redirect()->route('device-types.index')->with('success', 'Device type deleted.');
    }
}
