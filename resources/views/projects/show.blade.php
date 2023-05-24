@extends('layouts.app')

@section('content')
<header class="flex items-center mb-3">
    <div class="flex justify-between items-center w-full">
        <p class="text-grey text-sm ml-4">
            <a href="{{ route('user-get-project')}}">My projects</a>/
                {{ $project->title }}
            </p>
        <button
            class="px-4 py-2 text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600">
            <a href="{{ route('user-edit-project', ['project' => $project->id])}}">Edit project</a>
        </button>
    </div>
</header>

<main>
    <div class="lg:flex">
        <div class="lg:w-3/4 px-3 mb-6">
            <div class="mb-6">
                <h2 class="text-gray-400 font-bold mb-3">Tasks</h2>
                @foreach ($project->tasks as $tasks)
                <div class="bg-white p-5 rounded-lg shadow mb-3">
                    <form action="{{ route('user-update-project-task', [$project->id, $tasks->id] )}}" method="POST"> @method('PUT')
                        @csrf
                        <div class="flex">
                            <input type="text" value="{{ $tasks->body }}" class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40 {{ $tasks->completed ? 'changed': '' }}" name="body">
                            <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $tasks->completed ? 'checked': '' }}>
                        </div>
                    </form>
                </div>
                @endforeach
                <div class="bg-white p-5 rounded-lg shadow mb-3">
                    <h3 class="font-normal text-xl mb-3 pl-4">
                        <form action="{{ route('user-add-project-task', [$project->id] )}}" method="POST">
                            @csrf
                            <input class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="add tasks..." name="body" />
                        </form>
                    </h3>
                </div>
            </div>
                <div>
                    <h2 class="text-gray-400 font-bold mb-3">Notes</h2>
                    <form action="{{ route('user-update-project', ['project' => $project->id])}}" method="POST">
                            <div class="bg-white p-5 rounded-lg shadow">
                                @method('PUT')
                                @csrf
                                <textarea class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40" name="notes" placeholder="Add more notes to this task..." style="min-height: 150px">
                                {{ $project->notes }}
                                </textarea>
                            </div>
                                <button type="submit" class=" mt-6 px-4 py-2 text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600">
                                    Save
                                </button>
                        </form>
                </div>
            </div>
            <div class="lg:w-1/4 px-3 mt-9">
                @include('projects.card')
            </div>
        </div>
    </div>
</main>

@endsection
