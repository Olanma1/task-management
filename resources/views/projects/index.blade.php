@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3">
        <div class="flex justify-between items-center w-full">
            <h2>My projects</h2>
            <button
                class="px-4 py-2 text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600">
                <a href="{{ route('user-create-project')}}">New project</a>
            </button>
        </div>
    </header>

    <main class="flex flex-wrap -mx-3">
        @forelse ($projects as $project)
        <div class="w-1/4 px-3 pb-6">
            @include('projects.card')
        @empty
            <div>No Projects yet.</div>
        @endforelse
    </main>
@endsection
