@extends('layouts.app')

@section('content')
    <h1>Liste des personnes</h1>
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @elseif(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif
    
    <a href="{{ route('people.create') }}">Créer une nouvelle personne</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom complet</th>
                <th>Créateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
                <tr>
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                    <td>{{ $person->creator ? $person->creator->name : 'N/A' }}</td>
                    <td><a href="{{ route('people.show', $person->id) }}">Voir</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
