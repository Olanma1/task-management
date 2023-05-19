<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Management</title>
</head>
<body>

    <h1>Task Management</h1>

    <ul>
        @forelse ($projects as $project)

        <li>
            <a href="{{ route('user-view-one-project', ['project' => $project->id]) }}">
                {{ $project->title }}
            </a>
        </li>

        @empty

        <li>
            No Projects yet.
        </li>

        @endforelse
    </ul>
</body>
</html>
