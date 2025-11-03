@php
    $faqs = [
        [
            'question' => "Qui peut venir à l'Atelier 404 ?",
            'reponse' => "L'Atelier 404 est ouvert à tous les citoyens, étudiants et personnels qui souhaitent faire réparer leur matériel informatique."
        ],
        [
            'question' => "Quels types d'appareils sont pris en charge ?",
            'reponse' => "Nous réparons principalement les ordinateurs portables, fixes, smartphones, tablettes et petits équipements numériques."
        ],
        [
            'question' => "Faut-il prendre rendez-vous ?",
            'reponse' => "Non, il suffit de venir pendant les horaires d'ouverture ou de remplir le formulaire de contact en ligne."
        ],
        [
            'question' => "La réparation est-elle payante ?",
            'reponse' => "Non, toutes les interventions sont gratuites. Seuls les éventuels composants à remplacer restent à la charge du propriétaire."
        ],
        [
            'question' => "Qui réalise les réparations ?",
            'reponse' => "Les réparations sont effectuées par des étudiants en informatique, encadrés par des enseignants et techniciens professionnels."
        ],
        [
            'question' => "Quels sont les horaires d'ouverture ?",
            'reponse' => "Consultez la page d'accueil pour les horaires actualisés de l'Atelier 404."
        ],

    ];
@endphp
<x-guest-layout>
{{-- Message de succès --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

{{-- Présentation Atelier 404 --}}
<div class="mb-8 p-4 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-2">Bienvenue à l'Atelier 404</h1>
    <p class="text-gray-700">
        L'Atelier 404 est le repair café étudiant de la section informatique, ouvert à tous. Encadrés par des enseignants, nos étudiants proposent gratuitement la réparation d'équipements informatiques pour les citoyens. Face à l'afflux croissant de demandes, l'Atelier 404 s'engage à offrir un service professionnel, convivial et accessible, favorisant l'entraide, l'apprentissage et le réemploi du matériel numérique.
    </p>
</div>
{{-- formulaire --}}
<x-formulaire-intervention ></x-formulaire-intervention>
{{-- localisation --}}
<x-localisation></x-localisation>
{{-- faq --}}

<x-faq :faqs=$faqs></x-faq>

</x-guest-layout>
