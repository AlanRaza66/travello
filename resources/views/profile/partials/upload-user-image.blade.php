<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Photo de profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Mets à jour ta photo de profil.') }}
        </p>
    </header>
    <div class="flex items-center justify-between">
        <div class="flex items-center justify-center gap-4 mt-2">
            <div class="h-[56px] w-[56px] rounded-[50%] overflow-hidden">
                @if ($user->picture !== null)
                    <img src={{ asset($user->picture) }} width="166" height="166"
                        class="object-contain object-center w-full h-full" />
                @else
                    <img src={{ asset('/avatar.jpg') }} width="166" height="166"
                        class="object-contain object-center w-full h-full" />
                @endif
            </div>
            <p class="font-bold">{{ $user->name }}</p>
            <x-primary-button class="ml-6" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'upload-image')">
                Modifier la photo
            </x-primary-button>
        </div>
    </div>
    <div>
        <x-input-error class="mt-2" :messages="$errors->get('picture')" />
    </div>
    <x-modal name="upload-image">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Modifier la photo de profil') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Tu peux importer une nouvelle photo ou supprimer celle qui est existante.') }}
            </p>
            <div class="flex justify-end mt-6">

                <x-primary-button id="import-button">
                    {{ __('Importer') }}
                </x-primary-button>
                <form id="upload-form" action="{{ route('profile.picture.upload') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="file" name="picture" id="picture" accept=".jpeg, .jpg, .png, .webp"
                        class="hidden" />
                </form>

                <x-secondary-button x-on:click="$dispatch('close')" class="ms-3">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Supprimer') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</section>

<script>
    document.getElementById('import-button').addEventListener('click', function() {
        document.getElementById('picture').click();
    });

    document.getElementById('picture').addEventListener('change', function() {
        if (this.files.length > 0) {
            document.getElementById('upload-form').submit();
        }
    });
</script>
