<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <title>Document</title>
</head>

<body class="pt-20 bg-gray-100">
    @include('header')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <section class="container mx-auto p-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($roles as $role)
            <div class="max-w-5xl p-7 bg-white border border-gray-200 rounded-lg shadow">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">{{ $role->name }} ({{ $role->users->count() }})
                </h5>
                <ul class="mb-3 font-normal text-gray-700">
                    @foreach ($role->users as $user)
                        <li class="flex items-center space-x-4">
                            <span>{{ $user->name }} - {{ $user->email }}</span>
                            <button onclick="removeUserFromRole('{{ $user->id }}', '{{ $role->id }}')"
                                class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
                <button onclick="openModal('{{ $role->id }}')"
                    class="px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 focus:ring-1 focus:outline-none focus:ring-stonks-groen2">
                    Toevoegen
                </button>
            </div>

            <div id="modal-{{ $role->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 h-full w-full flex items-center justify-center">
                <!-- Modal content -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="mb-4">Voeg een gebruiker toe aan {{ $role->name }}</h2>
                    <input type="text" id="user-search-{{ $role->id }}" placeholder="Zoek op naam of email" oninput="searchUsers(this.value, '{{ $role->id }}')" class="border px-2 py-1 rounded">
                    <ul id="search-results-{{ $role->id }}"></ul>
                    <button onclick="closeModal('{{ $role->id }}')" class="px-3 mt-4 py-2 text-white bg-red-500 rounded">Sluiten</button>
                </div>
            </div>

        @endforeach

        <script>
            function openModal(roleId) {
                document.getElementById('modal-' + roleId).classList.remove('hidden');
            }

            function closeModal(roleId) {
                document.getElementById('modal-' + roleId).classList.add('hidden');
            }

            function searchUsers(query, roleId) {
                fetch(`/search-users?q=${query}`)
                    .then(response => response.json())
                    .then(users => {
                        const resultsContainer = document.getElementById('search-results-' + roleId);
                        resultsContainer.innerHTML = '';
                        users.forEach(user => {
                            const li = document.createElement('li');
                            li.textContent = `${user.name} - ${user.email} `;

                            const addButton = document.createElement('button');
                            addButton.textContent = 'Toevoegen';
                            addButton.className =
                                'ml-2 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600';
                            addButton.onclick = () => addUserToRole(user.id, roleId);

                            li.appendChild(addButton);
                            resultsContainer.appendChild(li);
                        });
                    });
            }

            function addUserToRole(userId, roleId) {
                fetch('/add-user-to-role', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            role_id: roleId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Gebruiker toegevoegd aan de rol!");
                            closeModal(roleId);
                        } else {
                            alert("Fout: " + data.error);
                        }
                    });
            }

            function removeUserFromRole(userId, roleId) {
                fetch('/remove-user-from-role', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            role_id: roleId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Gebruiker verwijderd uit de rol!");
                            location.reload(); // Refresh de pagina of update de UI.
                        } else {
                            throw new Error(data.error || 'Onbekende fout opgetreden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Er is een fout opgetreden: ' + error.message);
                    });
            }
        </script>

    </section>
</body>

</html>
