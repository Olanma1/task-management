@extends('layouts.app')

@section('content')
<div class="flex flex-col justify-center min-h-screen overflow-hidden">
    <div class="w-full p-6 m-auto bg-white rounded shadow-lg ring-2 ring-purple-800/50 lg:max-w-md">
        <p class="text-2xl font-semibold text-center text-grey-200">Edit a project</p>
    <form method="POST" action="{{ route('user-update-project', [$project->id] )}}">
        @method('PUT')
        @csrf

        <div class="field">
            <label class="block text-bold text-gray-800" for="title">Title</label>
            <div class="control">
                <input type="text" class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40" name="title" placeholder="" value="{{ $project->title }}">
            </div>
        </div>
        <div class="field">
            <label class="block text-bold text-gray-800" for="description">Description</label>
            <div class="control">
                <textarea class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40" name="description">
                    {{ $project->description }}
                </textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="mt-4 px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600" type="submit">update project</button>
                <a  href="{{ route('user-view-one-project', ['project' => $project->id])}}" class="ml-6 text-purple-600">cancel</a>
            </div>
        </div>
    </div>
</div>
    </form>
    @endsection
