@php
    use App\Models\TypeAppareil;
@endphp
<div>
    <form method="POST" action="{{-- route('client.create') --}}">
        @csrf
        <fieldset>
            {{-- Nom --}}
            <div>
                <x-input-label for="nom" :value="__('Nom')" />
                <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')"
                    required />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            {{-- Telephone --}}
            <div>
                <x-input-label for="telephone" :value="__('telephone')" />
                <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')"
                    required />
                <x-input-error :messages="$errors->get('tel')" class="mt-2" />
            </div>
        </fieldset>
        <fieldset>
            {{-- type Appareil --}}
            <div>

                <x-input-label for="typeAppareil" :value="__('typeAppareil')" />
                <x-selection-type-appareil id="typeAppareil" name="typeAppareil" :collection="TypeAppareil::getAll()"
                    class="block mt-1 w-full"></x-selection-type-appareil>
                <x-input-error :messages="$errors->get('typeAppareil')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="description" :value="__('description')" />
                <textarea name="description" id="description" class="w-full" ></textarea>
            </div>
        </fieldset>
    </form>
</div>
