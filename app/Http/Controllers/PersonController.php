<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $people = People::with('creator')->get();

        return view('people.index', compact('people'));
    }

    public function show($id)
    {
        $person = People::with(['children', 'parents', 'creator'])->findOrFail($id);

        return view('people.show', compact('person'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birth_name'    => 'nullable|string|max:255',
            'middle_names'  => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        $validatedData['created_by'] = Auth::id();

        // first_name
        $validatedData['first_name'] = ucfirst(strtolower($validatedData['first_name']));

        // middle_names
        if (isset($validatedData['middle_names']) && trim($validatedData['middle_names']) !== '') {
            $names = explode(',', $validatedData['middle_names']);
            $formattedNames = array_map(function($name) {
                return ucfirst(strtolower(trim($name)));
            }, $names);
            $validatedData['middle_names'] = implode(', ', $formattedNames);
        } else {
            $validatedData['middle_names'] = null;
        }

        // last_name 
        $validatedData['last_name'] = strtoupper($validatedData['last_name']);

        // birth_name
        if (isset($validatedData['birth_name']) && trim($validatedData['birth_name']) !== '') {
            $validatedData['birth_name'] = strtoupper($validatedData['birth_name']);
        } else {
            $validatedData['birth_name'] = $validatedData['last_name'];
        }

        // date_of_birth
        if (isset($validatedData['date_of_birth']) && !empty($validatedData['date_of_birth'])) {
            $validatedData['date_of_birth'] = date('Y-m-d', strtotime($validatedData['date_of_birth']));
        } else {
            $validatedData['date_of_birth'] = null;
        }

        try {
            People::create($validatedData);
            return redirect()->route('people.index')
                     ->with('success', 'Personne créée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création d\'une personne: ' . $e->getMessage());
            return redirect()->route('people.index')->with('error', 'Une erreur est survenue lors de la création de la personne.');
        }
    }


}

