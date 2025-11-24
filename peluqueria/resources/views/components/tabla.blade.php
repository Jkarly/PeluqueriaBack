<!-- resources/views/components/tabla.blade.php -->

<div class="overflow-x-auto rounded-lg shadow-sm">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-purple-900">
            <tr>
                @foreach ($columns as $col)
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        {{ $col }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($rows as $row)
                <tr class="hover:bg-purple-100 transition duration-150 ease-in-out">
                    @foreach ($row as $cell)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {!! $cell !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
