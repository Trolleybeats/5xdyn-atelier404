<?php

use App\Models\User;

use Laravel\Dusk\Browser;

test('allows authenticated user to see the dashboard', function () {
    $this->browse(function (Browser $browser) {
        // Create a technician user for the test
        $user = User::factory()->create(['role' => 'technicien']);
    $browser->loginAs($user)
        ->visit('/dashboard')
        ->assertSee('Mes Interventions');
    });
});
