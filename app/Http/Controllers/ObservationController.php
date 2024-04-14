<?php

namespace App\Http\Controllers;
use App\Models\Observation;

use Illuminate\Http\Request;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Observation::query();

        $params = $request->all();

        foreach ($params as $field => $value) {
            if (in_array($field, ['species', 'amount', 'age', 'sex', 'province', 'location', 'initial_date', 'final_date'])) {
                $query->where($field, $value);
            }
        }

        if ($field === 'year') {
            $query->where(function ($query) use ($value) {
                $query->whereYear('initial_date', $value)
                      ->orWhereYear('final_date', $value);
            });
        }

        $filteredObservations = $query->get();

        return response()->json($filteredObservations);
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
        $request->validate([
            'species' => 'required|string',
            'amount' => 'required|integer|min:1',
            'age' => 'nullable|string',
            'sex' => 'nullable|string',
            'province' => 'required|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'initial_date' => 'nullable|date|date_format:Y-m-d',
            'final_date' => 'nullable|date|date_format:Y-m-d',
            'observer' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $observation = new Observation([
            'species' => $request->get('species'),
            'amount' => $request->get('amount'),
            'age' => $request->get('age'),
            'sex' => $request->get('sex'),
            'province' => $request->get('province'),
            'location' => $request->get('location'),
            'latitude' => $request->get('latitude'),
            'initial_date' => $request->get('initial_date'),
            'final_date' => $request->get('final_date'),
            'observer' => $request->get('observer'),
            'image' => $request->get('image'),
        ]);

        $observation->save();

        return response()->json($observation);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $observation = Observation::findOrFail($id);
        return response()->json($observation);
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
        $observation = Observation::findOrFail($id);

        $observation->update([
            'species' => $request->species,
            'amount' => $request->amount,
            'age' => $request->age,
            'sex' => $request->sex,
            'province' => $request->province,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'initial_date' => $request->initial_date,
            'final_date' => $request->final_date,
            'observer' => $request->observer,
            'image' => $request->image,
        ]);

        return response()->json($observation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $observation = Observation::findOrFail($id);
        $observation->delete();
        return response()->json("Record Deleted Successfully");
    }
}
