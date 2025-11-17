<?php

use App\Models\User;

use Laravel\Dusk\Browser;

test('user can see own interventions', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create(['role' => 'technicien']);

        // Use firstOrCreate to avoid UNIQUE/NOT NULL constraint violations if seeders already ran
        $type = \App\Models\TypeAppareil::firstOrCreate(['nom' => 'Ordinateur']);
        $client = \App\Models\Client::firstOrCreate(
            ['nom' => 'Client Test'],
            ['email' => 'client.test@example.test', 'telephone' => '0123456789']
        );
        $intervention = \App\Models\Intervention::factory()->create([
            'client_id' => $client->id,
            'type_appareil_id' => $type->id,
        ]);
        \App\Models\Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $user->id,
        ]);

        $browser->loginAs($user)
                ->visit('/tech/interventions')
                ->assertSee('Détails');
    });
});
