<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト詳細</h2>
    </x-slot>

    <x-input-error :messages="$errors->all()" class="mt-2" />

    <div class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8">
        {{-- 日付見出しと日付指定フォーム --}}
        <div class="flex justify-between items-center bg-fuchsia-400 overflow-hidden shadow-sm sm:rounded-lg p-3 font-bold text-2xl leading-tight">
            {{ $project_detail[0]->date }}
            <form method="POST" action="{{ route('project.detail', [$project_detail[0]->project_id]) }}">
                @csrf
                <input type="hidden" name="project_id" value={{ $project_detail[0]->project_id }}>

                <div class="flex">
                    <input id="date" class="block w-40 rounded-lg" type="date" name="date" required />
                    <x-primary-button class="ml-4">日付指定</x-primary-button>
                </div>
            </form>
        </div>

        {{-- プロジェクト詳細 --}}
        <div class="bg-fuchsia-100 p-2 mt-6 sm:rounded-lg">
            <h1 class="font-bold text-2xl text-gray-800 leading-tight">▼全体状況</h1>

            <div class="py-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">進捗ステータス</h1>
                        <hr>
                        <p>{{ $project_detail[0]->status }}</p>
                    </div>
                </div>
            </div>

            <div class="py-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">状況</h1>
                        <hr>
                        <p>{{ $project_detail[0]->project_overview }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-fuchsia-100 p-2 mt-6 sm:rounded-lg">
            <h1 class=" font-bold text-2xl text-gray-800 leading-tight">▼メンバー状況</h1>

            @foreach ($project_detail as $tmp_project_detail)
                <div class="py-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $tmp_project_detail->name }}
                            </h1>
                            <hr><br>
                            <h1 class="font-semibold text-sm text-gray-800 leading-tight">消費工数</h1>
                            <hr>
                            <p>{{ $tmp_project_detail->result_man_hour }}</p>
                            <br>
                            <h1 class="font-semibold text-sm text-gray-800 leading-tight">状況</h1>
                            <hr>
                            <p>{{ $tmp_project_detail->member_overview }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end">
            <form method="GET" action="{{ route('project.detail.edit', $project_detail[0]->project_id, $project_detail[0]->date) }}">
                @csrf
                <input type="hidden" name="project_id" value={{ $project_detail[0]->project_id }}>
                <input type="hidden" name="date" value={{ $project_detail[0]->date }}>
                <x-primary-button class="mt-6">編集</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
