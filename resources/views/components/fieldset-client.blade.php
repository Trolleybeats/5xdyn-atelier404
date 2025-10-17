<fieldset class="mt-4 border rounded px-1 py-1">
    <legend> Client</legend>
    {{-- Nom --}}
    <div>
        <x-input-label for="nom" :value="__('Nom')" />
        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required />
        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
    </div>
    <!-- Email Address -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    {{-- Telephone --}}
    <div>
        <x-input-label for="telephone" :value="__('telephone')" />
        <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')"
            required />
        <x-input-error :messages="$errors->get('tel')" class="mt-2" />
    </div>
    {{-- adresse --}}
    <div>
        <x-input-label for="adresse" :value="__('adresse')" />
        <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')"
            required />
        <x-input-error :messages="$errors->get('tel')" class="mt-2" />
    </div>
</fieldset>
