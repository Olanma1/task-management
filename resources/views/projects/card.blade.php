    <div class="bg-white p-5 rounded-lg shadow" style="height: 200px">
        <h3 class="font-normal text-xl mb-3 -ml-5 border-l-4 border-purple-700 pl-4">
            <a href="{{ route('user-view-one-project', ['project' => $project->id])}}">{{ $project->title }}</a>
        </h3>
        <div class="text-gray-300 mb-12">{{ Str::limit($project->description, $limit = 50, $end = '...') }}</div>
        <footer>
            <form action="{{ route('user-delete-project', [$project->id]) }}" method="POST" class="text-right">
                @csrf
                @method('DELETE')
                <button class="text-sm text-red-400" type="submit">Delete</button>
            </form>
        </footer>
    </div>
</div>
