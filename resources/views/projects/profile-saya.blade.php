<x-app-layout>
    <!-- Ini bagian Header (yang sudah muncul di gambarmu) -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Saya') }}
        </h2>
    </x-slot>

    <!-- Ini bagian Konten Utama (yang akan mengisi area abu-abu) -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Informasi Akun</h3>
                    
                    <div class="mb-2">
                        <strong>Nama:</strong> {{ Auth::user()->name }}
                    </div>
                    
                    <div class="mb-2">
                        <strong>Email:</strong> {{ Auth::user()->email }}
                    </div>
                    
                    <div class="mb-2">
                        <strong>Role:</strong> <span class="uppercase">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>