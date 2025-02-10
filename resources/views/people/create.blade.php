@extends('layouts.app')

@section('content')
    <h1>Créer une nouvelle personne</h1>

    <form action="{{ route('people.store') }}" method="POST">
        @csrf
        <div>
            <label for="first_name">Prénom :</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
            @error('first_name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="last_name">Nom :</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
            @error('last_name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="birth_name">Nom de naissance :</label>
            <input type="text" name="birth_name" id="birth_name" value="{{ old('birth_name') }}">
            @error('birth_name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="middle_names">Noms intermédiaires :</label>
            <input type="text" name="middle_names" id="middle_names" value="{{ old('middle_names') }}">
            @error('middle_names')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="date_of_birth">Date de naissance :</label>
            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
            @error('date_of_birth')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Enregistrer</button>
    </form>
@endsection
