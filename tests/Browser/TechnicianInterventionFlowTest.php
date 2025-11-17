<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;
use App\Models\Intervention;
use App\Models\Attribution;
use App\Models\Client;
use App\Models\TypeAppareil;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TechnicianInterventionFlowTest extends DuskTestCase
{
    // Use migrations instead of transactional refresh for Dusk browser tests.
    // Transactions are not visible to the separate browser process which
    // causes the Dusk login route to not find users created inside a
    // transaction (resulting in null being passed to the auth guard).
    use DatabaseMigrations;

    protected TypeAppareil $typeAppareil;
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        // Use firstOrCreate so tests won't fail if seeders already created
        // these records (avoids UNIQUE constraint violations).
        $this->typeAppareil = TypeAppareil::firstOrCreate([
            'nom' => 'Ordinateur',
        ]);
        $this->client = Client::firstOrCreate([
            'nom' => 'Client Test',
        ], [
            'email' => 'client.test@example.test',
            'telephone' => '0123456789',
        ]);
    }

    public function test_technician_can_login_and_see_mes_interventions_link()
    {
        $tech = User::factory()->create([
            'role' => 'technicien',
            'name' => 'Technicien Test',
            'email' => 'tech@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($tech) {
            $browser->loginAs($tech)
                    ->visit('/dashboard')
                    ->assertSeeLink('Mes Interventions')
                    ->clickLink('Mes Interventions')
                    ->assertPathIs('/tech/interventions');
        });
    }

    public function test_technician_can_view_assigned_intervention_list()
    {
        $tech = User::factory()->create(['role' => 'technicien']);
        $intervention = Intervention::factory()->create([
            'client_id' => $this->client->id,
            'type_appareil_id' => $this->typeAppareil->id,
            'statut' => 'Nouvelle_demande',
        ]);

        Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $tech->id,
        ]);

        $this->browse(function (Browser $browser) use ($tech) {
            $browser->loginAs($tech)
                    ->visit(route('tech.interventions.index'))
                    ->assertSee('Mes Interventions')
                    ->assertSee('Client Test')
                    ->assertSee('Ordinateur');
        });
    }

    public function test_technician_cannot_see_interventions_assigned_to_others()
    {
        $tech1 = User::factory()->create(['role' => 'technicien']);
        $tech2 = User::factory()->create(['role' => 'technicien']);

        $intervention = Intervention::factory()->create([
            'client_id' => $this->client->id,
            'type_appareil_id' => $this->typeAppareil->id,
        ]);

        // Assign only to tech2
        Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $tech2->id,
        ]);

        $this->browse(function (Browser $browser) use ($tech1) {
            $browser->loginAs($tech1)
                    ->visit(route('tech.interventions.index'))
                    ->assertDontSee('Client Test');
        });
    }

    public function test_technician_can_view_and_edit_assigned_intervention()
    {
        $tech = User::factory()->create(['role' => 'technicien']);
        $intervention = Intervention::factory()->create([
            'client_id' => $this->client->id,
            'type_appareil_id' => $this->typeAppareil->id,
            'statut' => 'Nouvelle_demande',
            'priorite' => 'moyenne',
        ]);

        Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $tech->id,
        ]);

        $this->browse(function (Browser $browser) use ($tech, $intervention) {
            $browser->loginAs($tech)
                    ->visit(route('tech.interventions.index'))
                    ->clickLink('Détails') // or adjust selector to match your view
                    ->assertSee('Client Test')
                    ->assertSee('Ordinateur')
                    ->clickLink('Modifier')
                    ->select('statut', 'Diagnostic')
                    ->select('priorite', 'elevee')
                    // The form button is labeled in French in the app
                    ->press("Mettre à jour")
                    ->assertSee('Intervention mise à jour avec succès');

            // We assert the success flash message above; database persistence is covered
            // by integration tests elsewhere. If you want to assert DB-level changes
            // here, avoid transactional test helpers and refresh the model.
        });
    }

    public function test_technician_cannot_access_unassigned_intervention()
    {
        $tech1 = User::factory()->create(['role' => 'technicien']);
        $tech2 = User::factory()->create(['role' => 'technicien']);

        $intervention = Intervention::factory()->create([
            'client_id' => $this->client->id,
            'type_appareil_id' => $this->typeAppareil->id,
        ]);

        Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $tech2->id,
        ]);

        $this->browse(function (Browser $browser) use ($tech1, $intervention) {
            $browser->loginAs($tech1)
                    ->visit(route('tech.interventions.show', $intervention))
                    // Should see a 403 forbidden page when accessing an unassigned intervention
                    ->assertSee('403');
        });
    }

    public function test_admin_can_view_all_interventions()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $tech = User::factory()->create(['role' => 'technicien']);

        $intervention = Intervention::factory()->create([
            'client_id' => $this->client->id,
            'type_appareil_id' => $this->typeAppareil->id,
        ]);

        Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $tech->id,
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit('/dashboard')
            ->assertSeeLink('Gérer les Interventions')
            ->clickLink('Gérer les Interventions')
            // Admin index lists device types; assert the device name is present
            ->assertSee('Ordinateur');
        });
    }

    public function test_latest_attribution_determines_access()
    {
        $tech1 = User::factory()->create(['role' => 'technicien']);
        $tech2 = User::factory()->create(['role' => 'technicien']);

        $intervention = Intervention::factory()->create([
            'client_id' => $this->client->id,
            'type_appareil_id' => $this->typeAppareil->id,
        ]);

        // First attribution to tech1
        Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $tech1->id,
        ]);

        // Second attribution to tech2 (latest)
        Attribution::factory()->create([
            'intervention_id' => $intervention->id,
            'user_id' => $tech2->id,
        ]);

        $this->browse(function (Browser $browser) use ($tech1, $tech2) {
            // tech1 should NOT see it anymore
            $browser->loginAs($tech1)
                    ->visit(route('tech.interventions.index'))
                    ->assertDontSee('Client Test');

            // tech2 SHOULD see it
            $browser->logout()
                    ->loginAs($tech2)
                    ->visit(route('tech.interventions.index'))
                    ->assertSee('Client Test');
        });
    }

    public function test_unauthenticated_user_redirected_to_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('tech.interventions.index'))
                    ->assertPathIs('/login');
        });
    }
}
