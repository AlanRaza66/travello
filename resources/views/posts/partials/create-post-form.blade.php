<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Créer une publication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Remplis les informations pour créer un poste sur un voyage.') }}
        </p>
    </header>
    <form class="w-full mt-4" method="POST" action="{{ route('post.store', ['user' => $user]) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="grid justify-center w-full grid-cols-1 gap-4 md:grid-cols-2">

            <div class="col-span-1">
                <div>
                    <x-input-label for="location" :value="__('Localisation')" />
                    <x-text-input id="location" name="location" type="text" class="block w-full mt-1" required
                        autofocus autocomplete="localisation" :value="old('location')" />
                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                </div>
                <div class="mt-2">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea focusable id="description" name="description" class="block w-full mt-1"
                        :value="old('description')" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
                <x-primary-button class="mt-2">Publier</x-primary-button>
            </div>
            <div class="col-span-1">
                <x-input-label for="picture" :value="__('Photo de couverture')" />
                <div
                    class="flex items-center justify-center w-full rounded-md cursor-pointer bg-slate-200 aspect-square">
                    <img id="preview" class="hidden object-cover w-full h-full rounded-md"
                        alt="Aperçu de l'image sélectionnée">
                </div><input name="picture" id="picture" type="file" accept=".jpeg, .jpg, .png, .webp"
                    class="hidden" />
                <x-input-error class="mt-2" :messages="$errors->get('picture')" />

            </div>
        </div>
    </form>
</section>
<script>
    const pictureInput = document.getElementById('picture');
    const previewImg = document.getElementById('preview');

    previewImg.parentElement.addEventListener('click', () => {
        pictureInput.click();
    });

    pictureInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
