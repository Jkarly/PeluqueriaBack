@props(['url', 'texto'])

<a href="{{ $url }}" class="inline-block mt-6 bg-purple-900 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded shadow transition duration-200">
    + {{ $texto }}
</a>
