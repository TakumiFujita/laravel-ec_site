@extends('layout')
@section('title', 'プロフィール編集')

@section('content')

    <body>
        @if (session('message'))
            <div class="col-8 mx-auto alert alert-success">{{ session('message') }}</div>
        @endif

        @if ($errors->any())
            <div class="col-8 mx-auto alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </x-slot>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                    @if ($role_id === 1)
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <h4 class="mb-3">役割付与・削除　※adminユーザーにのみ表示</h4>
                            <table class="w-full text-left border">
                                <thead class="uppercase bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 border">役割</th>
                                        <th scope="col" class="px-6 py-3 border">付与</th>
                                        <th scope="col" class="px-6 py-3 border">削除</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300">
                                    @foreach ($roles as $role)
                                        <tr class="border">
                                            <td class="px-6 py-3">
                                                {{ $role->name }}
                                            </td>
                                            <td class="px-6 py-3">
                                                <form method="post" action="{{ route('role.attach', $user) }}">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="role" value="{{ $role->id }}">
                                                    <button
                                                        class="bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">ロール追加</button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-3">
                                                <form method="post" action="{{ route('role.detach', $user) }}">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="role" value="{{ $role->id }}">
                                                    <button
                                                        class="bg-red-600 hover:bg-red-500 text-white rounded px-4 py-2">ロール削除</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </x-app-layout>

    </body>
@endsection
