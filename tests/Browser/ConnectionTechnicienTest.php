<?php

use App\Models\User;

use Laravel\Dusk\Browser;

test('allows authenticated user to see the dashboard', function () {
    $this->browse(function (Browser $browser) {
        $user = User::find(2); // Assurez-vous que cet utilisateur existe dans votre base de données de test
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Technicien');
    });
});
