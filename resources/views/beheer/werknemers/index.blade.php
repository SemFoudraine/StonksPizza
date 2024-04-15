<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="pt-20 bg-gray-100">
    @include('header')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <section class="container mx-auto p-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($roles as $role)
            <div class="max-w-5xl p-7 bg-white border border-gray-200 rounded-lg shadow">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">
                    {{ ucfirst($role->name) }} (<span
                        id="user-count-{{ $role->id }}">{{ $role->users->count() }}</span>)
                </h5>
                <ul id="role-users-{{ $role->id }}" class="mb-3 font-normal text-gray-700">
                    @foreach ($role->users as $user)
                    <li class="flex items-center justify-between bg-gray-100 rounded p-2">
                        <span class="text-sm md:text-base truncate">{{ $user->name }} - {{ $user->email }}</span>
                        <form action="{{ route('removeFromRole') }}" method="POST" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>
                    </li>
                @endforeach
                </ul>
                <div class="p-4 border-t border-gray-200">
                    <form action="{{ route('assignRole') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <input type="text" name="user_email" placeholder="Gebruiker e-mail" class="flex-1 px-4 py-2 border rounded">
                            <button type="submit" class="px-4 py-2 bg-stonks-groen text-white rounded hover:bg-stonks-groen2">
                                Toevoegen
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="modal-{{ $role->id }}"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full flex items-center justify-center">
                <!-- Modal content -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="mb-4">Voeg een gebruiker toe aan {{ $role->name }}</h2>
                    <input type="text" id="user-search-{{ $role->id }}" placeholder="Zoek op naam of email"
                        oninput="searchUsers(this.value, '{{ $role->id }}')" class="border px-2 py-1 rounded">
                    <ul id="search-results-{{ $role->id }}"></ul>
                    <button onclick="closeModal('{{ $role->id }}')"
                        class="px-3 mt-4 py-2 text-white bg-red-500 rounded">Sluiten</button>
                </div>
            </div>
        @endforeach
</body>

</html>


