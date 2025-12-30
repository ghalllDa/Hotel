<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Foto Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Foto ini akan ditampilkan di dashboard dan navbar.
        </p>
    </header>

    <form method="POST"
          action="{{ route('profile.photo.update') }}"
          enctype="multipart/form-data"
          class="mt-6 space-y-4">
        @csrf

        <div class="flex items-center gap-4">
            <img
                src="{{ auth()->user()->profile_photo
                    ? asset('storage/' . auth()->user()->profile_photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                class="h-20 w-20 rounded-full object-cover border"
            >

            <input type="file"
                   name="profile_photo"
                   class="block w-full text-sm text-gray-600"
                   required>
        </div>

        <x-input-error :messages="$errors->get('profile_photo')" />

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan Foto</x-primary-button>

            @if (session('status') === 'photo-updated')
                <p class="text-sm text-gray-600">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
