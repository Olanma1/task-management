<div class="bg-white p-5 rounded-lg shadow mt-9" style="height: 200px">
    <h3 class="text-xl mb-0">
        Invite user
    </h3>
        <form action="{{ route('user-invite-team', [$project->id]) }}" method="POST" class="text-right">
            @csrf
            @method('POST')
                <div class="control">
                    <input type="text" required class="block w-full px-4 py-2 mt-2
                    text-purple-700 bg-white border rounded-md
                    focus:border-purple-400 focus:ring-purple-300 focus:outline-none
                    focus:ring focus:ring-opacity-40"
                    name="email">
                </div>
            <button class="text-sm ml-4 mt-4 px-4 py-2 text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600"
                type="submit">
                Invite
            </button>
        </form>
</div>
