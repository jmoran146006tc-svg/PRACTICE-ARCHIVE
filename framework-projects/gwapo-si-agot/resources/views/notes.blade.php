<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>

<body class="bg-slate-50 min-h-screen p-8 flex items-center justify-center">
    <form action="/notes" class="w-full max-w-lg bg-white p-6 rounded-xl shadow-sm border border-slate-200" method="post">
        @csrf
        @method('POST')
        <label for="note" class="block text-sm font-semibold text-slate-700 mb-2">Your Note</label>

        <textarea name="note" id="note" rows="5" 
            class="w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-none text-slate-800"
            value="{{ count($lol) }}"></textarea>

        <div class="mt-4 flex justify-end">
            <button type="submit"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors focus:ring-4 focus:ring-indigo-100 outline-none shadow-sm">

                @forelse($lol as $item)
                    <li>{{ $item }}</li>
                @empty
                    <p>what</p>
                @endforelse
            </button>
        </div>
    </form>
    <ul>


    </ul>

</body>


</html>
