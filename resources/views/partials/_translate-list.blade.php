<style>
    body{background:white!important;}
</style>
<p class="text-lg text-center font-bold m-5">Classic Table Design</p>
<table class="rounded-t-lg m-5 w-5/6 mx-auto bg-gray-200 text-gray-800">
    <tr class="text-left border-b-2 border-gray-300">
        <th class="px-4 py-3">KEY</th>
        <th class="px-4 py-3">Description</th>
        <th class="px-4 py-3">Action</th>
    </tr>

    <tr class="bg-gray-100 border-b border-gray-200">
        <td class="px-4 py-3">{{ $home }}</td>
        <td class="px-4 py-3">{{ $login}}</td>

        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
            <a href="#" class="text-blue-400 hover:text-blue-600 underline">Edit</a>
            <a href="#" class="text-blue-400 hover:text-blue-600 underline pl-6">Remove</a>
        </td>
    </tr>

</table>

<!-- classic design -->
