<?php

use App\Models\User;

use Laravel\Dusk\Browser;

test('user can not see client list', function () {
    $this->browse(function (Browser $browser) {
        // Create a technician user for the test
        $user = User::factory()->create(['role' => 'technicien']);
        $browser->loginAs($user)
            ->visit('/admin/clients')
            ->assertSee('403');
    });
});
