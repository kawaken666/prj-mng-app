<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト詳細</h2>
    </x-slot>

    <x-input-error :messages="$errors->all()" class="mt-2" />

    <div class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8">

        {{-- 日付見出し --}}
        <div class="flex justify-between items-center bg-fuchsia-400 overflow-hidden shadow-sm sm:rounded-lg p-3 font-bold text-2xl leading-tight">
            {{ $project_detail[0]->date }}
        </div>

        <form method="POST" action="{{ route('project.detail.update') }}">
            {{-- プロジェクト詳細 --}}
            <div class="bg-fuchsia-100 p-2 mt-6 sm:rounded-lg">
                <div class="flex justify-between">
                    <h1 class="font-bold text-2xl text-gray-800 leading-tight">▼全体状況</h1>
                </div>

                <div class="py-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">進捗ステータス</h1>
                            <hr>
                            <x-input-pulldown name="status">
                                <option value="0" @if($project_detail[0]->status === "オンスケ") selected @endif>オンスケ</option>
                                <option value="1" @if($project_detail[0]->status === "遅延") selected @endif>遅延</option>
                                <option value="2" @if($project_detail[0]->status === "前倒し") selected @endif>前倒し</option>
                            </x-input-pulldown>
                        </div>
                    </div>
                </div>

                <div class="py-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">状況</h1>
                            <hr>
                            <x-input-textarea name="overview">{{ $project_detail[0]->project_overview }}</x-input-textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-fuchsia-100 p-2 mt-6 sm:rounded-lg">
                <h1 class=" font-bold text-2xl text-gray-800 leading-tight">▼メンバー状況</h1>

                @foreach ($project_detail as $project_detail)
                    <div class="py-3">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ $project_detail->name }}</h1>
                                <hr><br>
                                <h1 class="font-semibold text-sm text-gray-800 leading-tight">消費工数</h1>
                                <hr>
                                <x-input-pulldown name="status" class="h-10">
                                    <option value="0" @if($project_detail->result_man_hour === 0) selected @endif>0</option>
                                    <option value="0.5" @if($project_detail->result_man_hour === 0.5) selected @endif>0.5</option>
                                    <option value="1" @if($project_detail->result_man_hour === 1.0) selected @endif>1</option>
                                    <option value="1.5" @if($project_detail->result_man_hour === 1.5) selected @endif>1.5</option>
                                    <option value="2" @if($project_detail->result_man_hour === 2) selected @endif>2</option>
                                    <option value="2.5" @if($project_detail->result_man_hour === 2.5) selected @endif>2.5</option>
                                    <option value="3" @if($project_detail->result_man_hour === 3) selected @endif>3</option>
                                    <option value="3.5" @if($project_detail->result_man_hour === 3.5) selected @endif>3.5</option>
                                    <option value="4" @if($project_detail->result_man_hour === 4) selected @endif>4</option>
                                    <option value="4.5" @if($project_detail->result_man_hour === 4.5) selected @endif>4.5</option>
                                    <option value="5" @if($project_detail->result_man_hour === 5) selected @endif>5</option>
                                    <option value="5.5" @if($project_detail->result_man_hour === 5.5) selected @endif>5.5</option>
                                    <option value="6" @if($project_detail->result_man_hour === 6) selected @endif>6</option>
                                    <option value="6.5" @if($project_detail->result_man_hour === 6.5) selected @endif>6.5</option>
                                    <option value="7" @if($project_detail->result_man_hour === 7) selected @endif>7</option>
                                    <option value="7.5" @if($project_detail->result_man_hour === 7.5) selected @endif>7.5</option>
                                    <option value="8" @if($project_detail->result_man_hour === 8) selected @endif>8</option>
                                    <option value="8.5" @if($project_detail->result_man_hour === 8.5) selected @endif>8.5</option>
                                    <option value="9" @if($project_detail->result_man_hour === 9) selected @endif>9</option>
                                    <option value="9.5" @if($project_detail->result_man_hour === 9.5) selected @endif>9.5</option>
                                    <option value="10" @if($project_detail->result_man_hour === 10) selected @endif>10</option>
                                    <option value="10.5" @if($project_detail->result_man_hour === 10.5) selected @endif>10.5</option>
                                    <option value="11" @if($project_detail->result_man_hour === 11) selected @endif>11</option>
                                    <option value="11.5" @if($project_detail->result_man_hour === 11.5) selected @endif>11.5</option>
                                    <option value="12" @if($project_detail->result_man_hour === 12) selected @endif>12</option>
                                </x-input-pulldown>
                                <h1 class="font-semibold text-sm text-gray-800 leading-tight">状況</h1>
                                <hr>
                                <x-input-textarea name="overview">{{ $project_detail->member_overview }}</x-input-textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
</x-app-layout>
