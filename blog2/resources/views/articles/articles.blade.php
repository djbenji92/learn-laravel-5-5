@extends('layouts.app')


@section('content')
    <h1>Nos articles</h1>
    @forelse ($articles as $article)
        <h2>{{ $article->titre }}</h2>
        <p>{{ $article->contenu }}</p>
    @empty
        <h2>Aucun article</h2>
    @endforelse
@endsection
