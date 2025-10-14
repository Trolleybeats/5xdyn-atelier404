@php
    $faqs = [
        [
            'question' => 'Test',
            'reponse' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea soluta molestiae aliquid obcaecati sed accusamus omnis. Deleniti libero maxime distinctio ea nulla, adipisci autem necessitatibus magnam id fuga dolorum dolore?'
        ]
];

@endphp
<x-guest-layout>
{{-- présentation atelier 404 --}}

{{-- formulaire --}}
<x-formulaire-intervention></x-formulaire-intervention>
{{-- localisation --}}
<x-localisation></x-localisation>
{{-- faq --}}
@forelse($faqs as $faq)
<x-faq :faq=$faq></x-faq>
@empty
<p>Rien dans la FAQ</p>
@endforelse
</x-guest-layout>
