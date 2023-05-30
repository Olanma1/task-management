<div class="bg-white p-5 rounded-lg shadow mt-9 text-sm" style="height: 200px">
    <ul>
        @foreach ($project->activity as $activity)
            <li>
                @if ($activity->description === 'created')
                    {{ $activity->user->name }} created the project
                @elseif ($activity->description === 'create_task')
                {{ $activity->user->name }} created {{ $activity->subject->body }}
                @elseif ($activity->description === 'completed_task')
                {{ $activity->user->name }} completed {{ $activity->subject->body }}
                @elseif ($activity->description === 'updated')
                @if (count($activity->changes['after']) == 1)
                {{ $activity->user->name }} updated the {{ key($activity->changes['after']) }} of the project
                @else
                {{ $activity->user->name }} updated the project
                @endif
                @elseif ($activity->description === 'completed_task')
                {{ $activity->user->name }} completed {{ $activity->subject }}
                @elseif ($activity->description === 'incompleted_task')
                {{ $activity->user->name }} marked {{ $activity->subject->body }} incompleted
                @endif
                <span class="text-blue-400">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>
</div>
