@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl shadow-xl p-6 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                class="w-20 h-20 rounded-full object-cover border-4 border-white/30 shadow-lg">
                        @else
                            <div class="w-20 h-20 rounded-full flex items-center justify-center shadow-lg"
                                style="background-color: #efd856;">
                                <span class="text-3xl font-bold" style="color: #008e3c;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                        <p class="text-green-100 text-sm">{{ $user->email }}</p>
                        <span class="inline-block mt-1 px-3 py-0.5 text-xs font-semibold rounded-full capitalize"
                            style="background-color: #efd856; color: #006b2d;">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-right hidden md:block">
                    <p class="text-sm text-green-100">NIP</p>
                    <p class="text-lg font-bold">{{ $user->nip ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Profil -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-user-edit mr-2" style="color: #008e3c;"></i>
                            Informasi Profil
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Perbarui data profil dan alamat email Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        class="p-6">
                        @csrf
                        @method('patch')

                        <!-- Avatar Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                            <div class="flex items-center space-x-4">
                                <div id="avatarPreviewContainer">
                                    @if ($user->avatar)
                                        <img id="avatarPreview" src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                            class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                        <div id="avatarPreview"
                                            class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-100 border-2 border-gray-200">
                                            <i class="fas fa-user text-2xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="avatar"
                                        class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                                        <i class="fas fa-camera mr-2"></i>
                                        Pilih Foto
                                    </label>
                                    <input type="file" id="avatar" name="avatar"
                                        accept="image/jpg,image/jpeg,image/png" class="hidden"
                                        onchange="previewAvatar(this)">
                                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, atau PNG. Maks 2MB.</p>
                                </div>
                            </div>
                            @error('avatar')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                        required>
                                </div>
                                @error('name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                        required>
                                </div>
                                @error('email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIP -->
                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" id="nip" name="nip"
                                        value="{{ old('nip', $user->nip) }}"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('nip') border-red-500 @enderror">
                                </div>
                                @error('nip')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div>
                                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-briefcase"></i>
                                    </span>
                                    <input type="text" id="jabatan" name="jabatan"
                                        value="{{ old('jabatan', $user->jabatan) }}"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('jabatan') border-red-500 @enderror">
                                </div>
                                @error('jabatan')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No.
                                    Telepon</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="text" id="phone" name="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('phone') border-red-500 @enderror">
                                </div>
                                @error('phone')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <div class="relative">
                                    <span class="absolute top-3 left-3 text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <textarea id="address" name="address" rows="3"
                                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                                </div>
                                @error('address')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 text-white font-semibold text-sm rounded-lg shadow-md transition hover:shadow-lg"
                                style="background-color: #008e3c;" onmouseover="this.style.backgroundColor='#006b2d'"
                                onmouseout="this.style.backgroundColor='#008e3c'">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Akun -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-info-circle mr-2" style="color: #008e3c;"></i>
                            Info Akun
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Role</span>
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full capitalize"
                                style="background-color: #e6f9ed; color: #008e3c;">
                                {{ $user->role }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Status</span>
                            @if ($user->is_active)
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle mr-1"></i> Non-Aktif
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Bergabung</span>
                            <span
                                class="text-sm font-medium text-gray-800">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-lock mr-2" style="color: #008e3c;"></i>
                            Ubah Password
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">Gunakan password yang kuat dan unik.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.password') }}" class="p-6 space-y-4">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password
                                Saat Ini</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" id="current_password" name="current_password"
                                    class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('current_password') border-red-500 @enderror"
                                    required>
                            </div>
                            @error('current_password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password
                                Baru</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password"
                                    class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                    required>
                            </div>
                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                    required>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-2.5 text-white font-semibold text-sm rounded-lg shadow-md transition hover:shadow-lg"
                            style="background-color: #008e3c;" onmouseover="this.style.backgroundColor='#006b2d'"
                            onmouseout="this.style.backgroundColor='#008e3c'">
                            <i class="fas fa-key mr-2"></i>
                            Perbarui Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.getElementById('avatarPreviewContainer');
                    container.innerHTML = '<img id="avatarPreview" src="' + e.target.result +
                        '" alt="Avatar Preview" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
