<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト詳細</h2>
    </x-slot>

    <x-input-error :messages="$errors->all()" class="mt-2" />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        {{-- 日付見出し --}}
        <div class="flex justify-between items-center bg-fuchsia-400 overflow-hidden shadow-sm sm:rounded-lg p-3 font-bold text-2xl leading-tight">
            {{ $dispPrjDetailDto->date }}
        </div>

        <form method="POST" action="{{ route('project.detail.update') }}">
            @csrf

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
                                <option value="0" @if($dispPrjDetailDto->status === "オンスケ") selected @endif>オンスケ</option>
                                <option value="1" @if($dispPrjDetailDto->status === "遅延") selected @endif>遅延</option>
                                <option value="2" @if($dispPrjDetailDto->status === "前倒し") selected @endif>前倒し</option>
                            </x-input-pulldown>
                        </div>
                    </div>
                </div>

                <div class="py-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">状況</h1>
                            <hr>
                            <x-input-textarea name="overview">{{ $dispPrjDetailDto->project_overview }}</x-input-textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-fuchsia-100 p-2 mt-6 sm:rounded-lg">
                <h1 class=" font-bold text-2xl text-gray-800 leading-tight">▼メンバー状況</h1>

                @foreach ($dispPrjMemDetailDtoList as $dispPrjMemDetailDto)
                <div class="py-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $dispPrjMemDetailDto->name }}</h1>
                            <input type="hidden" name="user_id[]" value="{{ $dispPrjMemDetailDto->id }}">
                            <hr><br>
                            <h1 class="font-semibold text-sm text-gray-800 leading-tight">消費工数</h1>
                            <hr>
                            <x-input-pulldown name="result_man_hour[]" class="h-10">
                                @for ($i = 0; $i <= 12; $i+=0.5) 
                                    <option value={{ $i }} @if($dispPrjMemDetailDto->result_man_hour == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </x-input-pulldown>
                            <h1 class="font-semibold text-sm text-gray-800 leading-tight">状況</h1>
                            <hr>
                            <x-input-textarea name="member_overview[]">{{ $dispPrjMemDetailDto->member_overview }}
                            </x-input-textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-between">
                <x-secondary-button class="mt-6" :onclick=$back_url>戻る</x-secondary-button>
                <x-primary-button class="mt-6">更新</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>