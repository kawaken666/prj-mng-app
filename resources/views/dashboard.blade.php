<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト一覧</h2>
    </x-slot>

    <x-input-error :messages="$errors->all()" class="mt-2" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="table-auto text-center border-2">
                        <tr>
                            <th class="border-2" bgcolor="violet">プロジェクト名</th>
                            <th class="border-2" bgcolor="violet">見積もり</th>
                            <th class="border-2" bgcolor="violet">リリース予定日</th>
                            <th class="border-2" bgcolor="violet">稼働予定月</th>
                        </tr>
                        @foreach($projects as $project)
                            <tr>
                                <td class="border-2 underline text-blue-500"><a href="{{ route('project.detail', ['project_id' => $project->project_id]) }}">{{ $project->project_name }}</a></td>
                                <td class="border-2">{{ $project->estimation }}</td>
                                <td class="border-2">{{ $project->release_date }}</td>
                                <td class="border-2">{{ $project->work_date }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
