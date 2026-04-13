<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Manager</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 min-h-screen p-8 font-sans text-gray-800">

    <div class="max-w-4xl mx-auto">
        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-10">
            <h2 class="text-2xl font-bold mb-6 text-indigo-600">Create Profile</h2>

            <form action="/profile" method="post" class="space-y-5">
                @csrf
                @method('POST')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-1">Name</label>
                        <input type="text" name="name" id="name"
                            class="w-full border-gray-300 border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-semibold mb-1">Age</label>
                        <input type="number" name="age" id="age"
                            class="w-full border-gray-300 border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label for="program" class="block text-sm font-semibold mb-1">Program</label>
                        <input type="text" name="program" id="program"
                            class="w-full border-gray-300 border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full border-gray-300 border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-semibold mb-2">Gender</p>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="gender" value="male"
                                    class="text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2">Male</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="gender" value="female"
                                    class="text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2">Female</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-semibold mb-2">Hobbies</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach (['Reading', 'Gaming', 'Coding', 'Sports', 'Music'] as $hobby)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="hobbies[]" value="{{ strtolower($hobby) }}"
                                        class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm">{{ $hobby }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <label for="bio" class="block text-sm font-semibold mb-1">Short Biography</label>
                    <textarea name="bio" id="bio" rows="3"
                        class="w-full border-gray-300 border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition"></textarea>
                </div>

                <button type="submit"
                    class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-lg active:transform active:scale-95">
                    Submit Profile
                </button>
            </form>
        </div>

        <!-- Display Section -->
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Registered Profiles</h2>
        @if (session()->has('profile'))
            <form action="/delete-profile" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="mt-6 w-full py-2 border border-red-200 text-red-500 rounded-lg hover:bg-red-50 transition text-sm font-semibold">
                    Delete All Profiles
                </button>
        @endif
        </form>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if (session()->has('profile'))

                @foreach (session('profile') as $user)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-indigo-600">{{ $user['name'] ?? 'Anonymous' }}</h3>
                                <p class="text-xs text-gray-400 uppercase tracking-widest">
                                    {{ $user['program'] ?? 'No Program' }}</p>
                            </div>
                            <span
                                class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded uppercase">{{ $user['gender'] ?? 'N/A' }}</span>
                        </div>

                        <div class="space-y-2 text-sm">
                            <p><span class="font-semibold text-gray-500">Age:</span> {{ $user['age'] ?? 'N/A' }}</p>
                            <p><span class="font-semibold text-gray-500">Email:</span> {{ $user['email'] ?? 'N/A' }}</p>
                            <p>
                                <span class="font-semibold text-gray-500">Hobby:</span>
                                <span class="capitalize">
                                    {{ isset($user['hobbies']) ? implode(', ', $user['hobbies']) : 'None' }}
                                </span>
                            </p>
                            <p class="italic text-gray-600 mt-3 border-l-2 border-gray-200 pl-3"><span>
                                    "{{ $user['bio'] ?? 'No bio provided...' }}" </p>
                        </div>



                    </div>
                @endforeach
            @else
                <div
                    class="col-span-full bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-12 text-center">
                    <p class="text-gray-400 italic">No profiles found. Fill out the form above to get started!</p>
                </div>
            @endif
        </div>
    </div>

</body>

</html>
