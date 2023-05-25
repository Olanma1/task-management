<div class="bg-white p-5 rounded-lg shadow mt-9 text-sm" style="height: 200px">
    <ul>
        @foreach ($project->activity as $activity)
            <li>
                @if ($activity->description === 'created')
                    You created the project
                @elseif ($activity->description === 'create_task')
                    You created a task
                @elseif ($activity->description === 'completed_task')
                    You completed a task
                @elseif ($activity->description === 'updated')
                    You updated a task
                @elseif ($activity->description === 'completed_task')
                    You completed a task
                @elseif ($activity->description === 'incompleted_task')
                    You marked a task incompleted
                @endif
                <span class="text-blue-400">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>
</div>
