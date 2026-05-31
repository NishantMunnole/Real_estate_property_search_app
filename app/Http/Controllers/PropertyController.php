<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;

use Gemini\Laravel\Facades\Gemini;
use Gemini\Enums\ResponseMimeType;
use Gemini\Data\GenerationConfig;
use Illuminate\Http\Client\ConnectionException;
use Exception;
use GrahamCampbell\ResultType\Success;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::with('type')->get();
        $propertyType = PropertyType::all();

        // dd($properties);

        return view('properties', compact(
            'properties',
            'propertyType'
        ));
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

        $validated = $request->validate([
            'propertyTitle' => 'required|max:255',
            'propertyDescription' => 'required|string',
            'price' => 'required|min:1',
            'propertyType' => 'required|exists:property_type,id',
            'city' => 'required|string|max:100',
            'images' => 'required|image|mimes:jpg,jpeg,png,webp'

        ]);


        // Image Upload
        if ($request->hasFile('images')) {

            $imageName = time() . '.' .
                $request->images->extension();

            $request->images->move(
                public_path('property-images'),
                $imageName
            );
        }


        // Save Data
        $data = Property::create([
            'title' => $validated['propertyTitle'],
            'description' => $validated['propertyDescription'],
            'price' => $validated['price'],
            'property_type_id' => $validated['propertyType'],
            'city' => $validated['city'],
            'image' => $imageName ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Property Added Successfully',
            'property' => $data, // optional: include the saved property
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->property_id;

        $validated = $request->validate([
            'propertyTitle' => 'required|max:255',
            'propertyDescription' => 'required|string',
            'price' => 'required|min:1',
            'propertyType' => 'required|exists:property_type,id',
            'city' => 'required|string|max:100',
            // 'images' => 'required|image|mimes:jpg,jpeg,png,webp'

        ]);

        try {
            $property = Property::with('type')->findOrfail($id);

            $data = $property->update([
                'title' => $validated['propertyTitle'],
                'description' => $validated['propertyDescription'],
                'price' => $validated['price'],
                'property_type_id' => $validated['propertyType'],
                'city' => $validated['city'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Property Added Successfully',
                'property' => $property, // optional: include the saved property
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not find property',
            ]);
        }
    }

    public function generateDescription(Request $request)
    {
        $title = $request->title;
        $type = $request->type;
        $city = $request->city;
        $prompt = "
            Generate a professional and attractive real-estate property description for:

            Property Title: $title
            Property Type: $type
            City: $city

            Make it sound luxurious and market friendly.
        ";

        try {
            // 3. Request Gemini 2.5 Flash
            $response = Gemini::generativeModel(model: 'gemini-2.5-flash')
                ->generateContent($prompt);

            $description = $response->text();

            return response()->json([
                'success' => true,
                'description' => $description
            ]);
        } catch (Exception $e) {
            // 4. Catch rate limits (429) or other API issues gracefully
            if (str_contains($e->getMessage(), '429') || str_contains($e->getMessage(), 'RESOURCE_EXHAUSTED')) {
                return response()->json([
                    'success' => false,
                    'error' => 'The AI generator is currently busy due to free tier limits. Please wait a minute and try again.'
                ], 429);
            }

            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred while generating the description.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $property = Property::with('type')->findOrfail($id);

            // Delete image if needed
            if ($property->image && file_exists(public_path('property-images/' . $property->image))) {

                unlink(public_path('property-images/' . $property->image));
            }

            $property->delete();

            return response()->json([
                'success' => true,
                'message' => 'Property Deleted Successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ]);
        }
    }

    public function search(Request $request)
    {
        try {

            $properties = Property::with('type')->where('city', 'LIKE', '%' . $request->city . '%')->get();

            return response()->json([
                'success' => true,
                'properties' => $properties

            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ]);
        }
    }
}
