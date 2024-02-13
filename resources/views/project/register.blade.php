<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">プロジェクト登録</h2>
    </x-slot>

    <x-input-error :messages="$errors->all()" class="mmax-w-7xl p-4 sm:px-6 lg:px-8" />
    
    <form method="POST" action="{{ route('project.store') }}">
        @csrf

        <!-- プロジェクト名 -->
        <div class="mt-4 mx-40">
            <x-input-label for="project_name">プロジェクト名</x-input-label>
            <x-text-input id="project_name" class="block mt-1 w-9/12" type="text" name="project_name" :value="old('project_name')" required autofocus autocomplete="project_name" />
            <x-input-error :messages="$errors->get('project_name')" class="mt-2" />
        </div>

        <!-- 見積もり工数（人日） -->
        <div class="mt-4 mx-40">
            <x-input-label for="estimation">見積もり工数（人日）</x-input-label>
            <x-number-input id="estimation" class="block mt-1 w-9/12" name="estimation" min='1' :value="old('estimation')" required />
            <x-input-error :messages="$errors->get('estimation')" class="mt-2" />
        </div>

        <!-- リリース予定日 -->
        <div class="mt-4 mx-40">
            <x-input-label for="release_date">リリース予定日</x-input-label>
            <input id="release_date" class="block mt-1 w-9/12 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="date" name="release_date" required/>
            <x-input-error :messages="$errors->get('release_date')" class="mt-2" />
        </div>

        <!-- 稼働予定月 -->
        <div class="mt-4 mx-40">
            <x-input-label for="work_date">稼働予定月</x-input-label>
            <input id="work_date" class="block mt-1 w-9/12 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="month" name="work_date" required />
            <x-input-error :messages="$errors->get('work_date')" class="mt-2" />
        </div>

        <!-- メンバ登録 -->
        <div class="mt-4 mx-40">
            <x-input-label>メンバー</x-input-label>
            @foreach($users as $user)
                <input class='ml-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' id="member" type="checkbox" name="member[]" value="{{ $user->id }}"> {{ $user->name }}
            @endforeach
        </div>
        <div class="flex items-center mt-4 mx-40">
            <x-primary-button class="ml-4">登録</x-primary-button>
        </div>
    </form>
</x-guest-layout>