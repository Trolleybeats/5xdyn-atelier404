@props(['faqs'])
<div class="mb-8 p-4 bg-white rounded shadow">
<h2 class="text-2xl font-bold mb-4">FAQ</h2>
@forelse($faqs as $faq)
<div class="mb-6 p-4 bg-gray-50 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-indigo-700 mb-2">{{ $faq['question'] }}</h2>
    <p class="text-gray-800">{{ $faq['reponse'] }}</p>
</div>
@empty
<p>Rien dans la FAQ</p>
@endforelse
</div>
