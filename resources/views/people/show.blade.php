@extends('layouts.app')

@section('content')
    <h1>Détails de la personne</h1>

    <!-- Informations de la personne -->
    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
        <h2>{{ $person->first_name }} {{ $person->last_name }}</h2>
        <p><strong>Nom de naissance :</strong> {{ $person->birth_name ?? 'Non défini' }}</p>
        <p><strong>Noms intermédiaires :</strong> {{ $person->middle_names ?? 'Non défini' }}</p>
        <p><strong>Date de naissance :</strong> {{ $person->date_of_birth ? \Carbon\Carbon::parse($person->date_of_birth)->format('d/m/Y') : 'Non défini' }}</p>
        <p><strong>Créé par :</strong> {{ $person->creator ? $person->creator->name : 'N/A' }}</p>
    </div>

    <!-- Liste des parents -->
    <div style="margin-bottom: 20px;">
        <h3>Parents</h3>
        @if($person->parents->count() > 0)
            <ul>
                @foreach($person->parents as $parent)
                    <li>
                        {{ $parent->first_name }} {{ $parent->last_name }}
                        <!-- Vous pouvez ajouter d'autres informations sur le parent ici -->
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun parent enregistré.</p>
        @endif
    </div>

    <!-- Liste des enfants -->
    <div style="margin-bottom: 20px;">
        <h3>Enfants</h3>
        @if($person->children->count() > 0)
            <ul>
                @foreach($person->children as $child)
                    <li>
                        {{ $child->first_name }} {{ $child->last_name }}
                        <!-- Vous pouvez ajouter d'autres informations sur l'enfant ici -->
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun enfant enregistré.</p>
        @endif
    </div>

    <!-- Lien de retour vers la liste -->
    <a href="{{ route('people.index') }}">Retour à la liste des personnes</a>
@endsection
