<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト詳細</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-fuchsia-500 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3">
                <h1 class="font-bold text-2xl text-white leading-tight">{{ $projectDetailInfo[0]->date }}</h1>
                </div>
            </div>
        </div>
    </div>


    <br>
    <h1 class="max-w-7xl mx-auto sm:px-6 lg:px-8 font-bold text-2xl text-gray-800 leading-tight">  ▼全体状況</h1>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">進捗ステータス</h1>
                    <hr>
                    <p>{{ $projectDetailInfo[0]->status }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">状況</h1>
                    <hr>
                    <p>{{ $projectDetailInfo[0]->projectOverview }}</p>
                </div>
            </div>
        </div>
    </div>
    <br>

    <h1 class="max-w-7xl mx-auto sm:px-6 lg:px-8 font-bold text-2xl text-gray-800 leading-tight">  ▼メンバー状況</h1>

    @foreach($projectDetailInfo as $projectDetailInfo)
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $projectDetailInfo->name }}</h1>
                        <hr><br>
                        <h1 class="font-semibold text-sm text-gray-800 leading-tight">消費工数</h1>
                        <hr>
                        <p>{{ $projectDetailInfo->result_man_hour }}</p>
                        <br>
                        <h1 class="font-semibold text-sm text-gray-800 leading-tight">状況</h1>
                        <hr>
                        <p>{{ $projectDetailInfo->memberOverview }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</x-guest-layout>