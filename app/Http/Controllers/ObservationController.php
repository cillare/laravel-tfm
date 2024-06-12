<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Observation::query();
        $params = $request->all();

        if (!empty($params)) {
            foreach ($params as $field => $value) {
                if (in_array($field, ['species', 'amount', 'age', 'sex', 'province', 'location', 'initial_date', 'final_date'])) {
                    $query->where($field, $value);
                }

                if ($field === 'year') {
                    $query->where(function ($query) use ($value) {
                        $query->whereYear('initial_date', $value)
                            ->orWhereYear('final_date', $value);
                    });
                }
            }
        }

        $filteredObservations = $query->get();

        return response()->json($filteredObservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'species' => 'required|string',
            'amount' => 'required|integer|min:1',
            'age' => 'nullable|string',
            'sex' => 'nullable|string',
            'province' => 'required|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'initial_date' => 'nullable|date|date_format:Y-m-d',
            'final_date' => 'nullable|date|date_format:Y-m-d',
            'observer' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $observation = Observation::create($validatedData);

        return response()->json($observation, 201);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'species' => 'required|string',
            'amount' => 'required|integer|min:1',
            'age' => 'nullable|string',
            'sex' => 'nullable|string',
            'province' => 'required|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'initial_date' => 'nullable|date|date_format:Y-m-d',
            'final_date' => 'nullable|date|date_format:Y-m-d',
            'observer' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $observation = Observation::findOrFail($id);
        $observation->update($validatedData);

        return response()->json($observation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $observation = Observation::findOrFail($id);
        $observation->delete();

        return response()->json(['message' => 'Observació eliminada correctament'], 200);
    }
}
