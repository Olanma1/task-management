@extends('layouts.app')

@section('content')
    <h1>Create a project</h1>
    <form method="POST" action="/">
        @csrf

        <div class="field">
            <label class="label" for="title">Title</label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="">
            </div>
        </div>
        <div class="field">
            <label class="label" for="description">Description</label>
            <div class="control">
                <textarea class="textarea" name="description"></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button" type="submit">Create project</button>
            </div>
        </div>
    </form>
    @endsection
