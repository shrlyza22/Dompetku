<section>
    <header>
        <h2 class="text-lg font-bold text-stone-800 dark:text-stone-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data"
          x-data="{
              previewUrl: '{{ $user->avatar ?? '' }}',
              removeAvatar: false,
              handleFile(e) {
                  const file = e.target.files[0];
                  if (file) {
                      this.previewUrl = URL.createObjectURL(file);
                      this.removeAvatar = false;
                  }
              },
              triggerRemove() {
                  this.previewUrl = '';
                  this.removeAvatar = true;
                  this.$refs.avatarInput.value = '';
              }
          }">
        @csrf
        @method('patch')

        {{-- ===== FOTO PROFIL ===== --}}
        <div>
            <label class="block text-sm font-bold text-stone-700 dark:text-stone-300 mb-3">
                {{ __('Foto Profil') }}
            </label>

            <div class="flex items-center gap-5">
                {{-- Preview Avatar --}}
                <div class="relative shrink-0">
                    <div class="w-20 h-20 rounded-full overflow-hidden ring-4 ring-clay-200 dark:ring-stone-700 shadow-md">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" alt="Avatar Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-clay-300 to-blush-300 text-white text-2xl font-extrabold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </template>
                    </div>
                    {{-- Camera icon overlay --}}
                    <label for="avatar-upload" class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-clay-500 hover:bg-clay-600 text-white flex items-center justify-center cursor-pointer shadow-md transition active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </label>
                </div>

                {{-- Upload Actions --}}
                <div class="flex flex-col gap-2">
                    <label for="avatar-upload"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-clay-700 dark:text-clay-300 bg-clay-50 dark:bg-stone-800 hover:bg-clay-100 dark:hover:bg-stone-700 cursor-pointer transition active:scale-95 border border-clay-200 dark:border-stone-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        {{ __('Pilih Foto') }}
                    </label>

                    <button type="button" x-show="previewUrl" @click="triggerRemove()"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-blush-600 dark:text-blush-400 bg-blush-50 dark:bg-stone-800 hover:bg-blush-100 dark:hover:bg-stone-700 border border-blush-200 dark:border-stone-700 transition active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('Hapus Foto') }}
                    </button>

                    <p class="text-xs text-stone-400 dark:text-stone-500">
                        JPG, PNG, WebP · Maks 2MB
                    </p>
                </div>

                {{-- Hidden inputs --}}
                <input type="file" id="avatar-upload" name="avatar" x-ref="avatarInput"
                       @change="handleFile($event)" accept="image/*" class="hidden">
                <input type="hidden" name="remove_avatar" :value="removeAvatar ? '1' : '0'">
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        {{-- ===== NAMA ===== --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- ===== EMAIL ===== --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-stone-700 dark:text-stone-300">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-stone-600 dark:text-stone-400 hover:text-clay-600 dark:hover:text-clay-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-clay-500 dark:focus:ring-offset-stone-900">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-sm text-sage-600 dark:text-sage-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-semibold text-sage-600 dark:text-sage-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
