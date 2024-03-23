<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">プロジェクト一覧</h2>
    </x-slot>

    <x-input-error :messages="$errors->all()" class="mt-2" />

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <table class="mx-auto w-full text-sm text-left border sm:rounded-lg">
                    <thead class="bg-indigo-400 text-white">
                        <tr class="border-b">
                            <th class="px-6 py-3">プロジェクト名</th>
                            <th class="px-6 py-3">見積もり(人日)</th>
                            <th class="px-6 py-3">リリース予定日</th>
                            <th class="px-6 py-3">稼働予定月</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $project->project_name }}</td>
                            <td class="px-6 py-3">{{ $project->estimation }}</td>
                            <td class="px-6 py-3">{{ $project->release_date }}</td>
                            <td class="px-6 py-3">{{ $project->work_date }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('project.detail', ['project_id' => $project->id]) }}" class="text-blue-600 hover:underline">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</x-app-layout>
