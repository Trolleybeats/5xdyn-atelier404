@php
    use App\Models\TypeAppareil;
@endphp
<div class="mb-8 p-4 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4 ">Formulaire d'inscription</h2>
    <form method="POST" action="{{ route('interventions.store') }}" >
        @csrf
        <x-fieldset-client/>
        <fieldset class="mt-4 border rounded px-1 py-1
        ">
            <legend>Intervention</legend>
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
        <x-primary-button >Envoyer</x-primary-button>
    </form>
</div>
