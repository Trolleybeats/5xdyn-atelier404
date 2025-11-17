<?php

use App\Models\User;
use Laravel\Dusk\Browser;

test('allows authenticated user to see the dashboard', function () {
    $this->browse(function (Browser $browser) {
        // Create an admin user for the test so the Dusk login route can find it.
        $user = User::factory()->create(['role' => 'admin']);
    $browser->loginAs($user)
        ->visit('/dashboard')
        ->assertSee('Gérer les Interventions');
    });
});
