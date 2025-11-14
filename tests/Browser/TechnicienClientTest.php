<?php

use App\Models\User;

use Laravel\Dusk\Browser;

test('user can not see client list', function () {
    $this->browse(function (Browser $browser) {
        $user = User::find(2); // Assurez-vous que cet utilisateur existe dans votre base de données de test
        $browser->loginAs($user)
            ->visit('/admin/clients')
            ->assertSee('403');
    });
});
