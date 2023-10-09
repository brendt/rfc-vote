<div class="p-5">
    <div class="flex justify-end items-center mb-4">
        <div class="flex space-x-2">
            <x-form.input
                type="text"
                placeholder="Search..."
                wire:model.debounce="search"
                label="Search a user"
            />
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-5 overflow-x-auto">
        <table class="table-auto w-full text-sm mb-3">
            <thead>
            <tr>
                <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                    Username
                </th>
                <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                    Name
                </th>
                <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                    Email
                </th>
                <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                    Reputation
                </th>
                <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                    Badge
                </th>

                <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-center ">
                    Action
                </th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
                @forelse($users as $user)
                    <tr>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">
                            <x-profile.username :user="$user"/>
                        </td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                            {{ $user->name }}
                        </td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                            {{ $user->email }}
                        </td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                            {{ $user->reputation }}
                        </td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                            <x-profile.flair :user="$user"/>
                        </td>

                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">
                            <div class="flex justify-end space-x-2">
                                <x-buttons.main-small-solid
                                    class="mr-2"
                                    href="{{ action([\App\Http\Controllers\UserEditController::class,'edit'],['user' => $user]) }}"
                                >
                                    <x-icons.pen class="w-4 h-4" />
                                    Edit
                                </x-buttons.main-small-solid>

                                @if($isDeletingId === $user->id )
                                    <x-buttons.main-small-solid
                                        wire:click="deleteUser({{ $user->id }})"
                                        class="!border-disagree !text-disagree"
                                    >
                                        Are you sure?
                                    </x-buttons.main-small-solid>

                                @else
                                    <x-buttons.main-small-solid
                                        wire:click="$set('isDeletingId','{{ $user->id }}')"
                                        class="!border-disagree !text-disagree"
                                    >
                                        Delete
                                    </x-buttons.main-small-solid>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400 text-center"
                            colspan="4">
                            No User
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $users->links('vendor.pagination.tailwind') }}
    </div>
</div>
