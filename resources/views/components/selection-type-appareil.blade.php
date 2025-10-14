<div>
    <select
        {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
        @forelse ($collection as $item)
            <option value="{{ $item->id }}">{{ $item->nom }}</option>
        @empty
            <option value = "aucun">aucun appareils</option>
        @endforelse
        <option value="nouveau">Appareil inconnu</option>
    </select>

</div>
