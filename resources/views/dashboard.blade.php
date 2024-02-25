<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト一覧</h2>
    </x-slot>

    <x-input-error :messages="$errors->all()" class="mt-2" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <table class="mx-auto text-sm w-11/12 border">
                    <thead class=" bg-fuchsia-400">
                        <tr>
                            <th class="px-6 py-3">プロジェクト名</th>
                            <th class="px-6 py-3">見積もり</th>
                            <th class="px-6 py-3">リリース予定日</th>
                            <th class="px-6 py-3">稼働予定月</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr class="text-center">
                            <td class="px-6 py-3 underline text-blue-500"><a href="{{ route('project.detail', ['project_id' => $project->project_id]) }}">{{ $project->project_name }}</a></td>
                            <td class="px-6 py-3">{{ $project->estimation }}</td>
                            <td class="px-6 py-3">{{ $project->release_date }}</td>
                            <td class="px-6 py-3">{{ $project->work_date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="relative overflow-x-auto">

    </div>

</x-app-layout>
