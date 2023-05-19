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
            <a href="{{ route('user-create-project')}}">New project</a>
        </button>
    </div>
</header>

<main>
    <div class="lg:flex">
        <div class="lg:w-3/4 px-3 mb-6">
            <div class="mb-6">
                <h2 class="text-gray-400 font-bold mb-3">Tasks</h2>
                <div class="bg-white p-5 rounded-lg shadow mb-3">
                    <h3 class="font-normal text-xl mb-3 pl-4">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </h3>
                </div>
                <div class="bg-white p-5 rounded-lg shadow mb-3">
                    <h3 class="font-normal text-xl mb-3 pl-4">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </h3>
                </div>
                <div class="bg-white p-5 rounded-lg shadow mb-3">
                    <h3 class="font-normal text-xl mb-3 pl-4">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </h3>
                </div>
                <div class="bg-white p-5 rounded-lg shadow mb-3">
                    <h3 class="font-normal text-xl mb-3 pl-4">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </h3>
                </div>
            </div>
                <div>
                    <h2 class="text-gray-400 font-bold mb-3">Notes</h2>
                    <div class="bg-white p-5 rounded-lg shadow">
                    <textarea class="font-normal text-xl mb-3 pl-4 w-full" style="min-height: 150px">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi commodi provident distinctio? Non ipsam quibusdam perferendis? Cupiditate obcaecati ea ipsa mollitia possimus eaque, unde eum accusamus quibusdam. Iure, cum nesciunt.
                    </textarea>
                </div>
        </div>
        </div>
        <div class="lg:w-1/4 px-3 mt-9">
             @include('projects.card')
        </div>
    </div>
    </div>
</main>

@endsection
