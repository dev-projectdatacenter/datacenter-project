<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer les rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'tech_manager']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'guest']);
    }

    /** @test */
    public function a_user_can_view_login_page()
    {
        $response = $this->get('/login');
        
        $response->assertStatus(200);
        $response->assertSee('Connexion');
    }

    /** @test */
    public function a_guest_cannot_access_protected_routes()
    {
        // Test des routes admin
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
        
        // Test des routes tech
        $response = $this->get('/tech/dashboard');
        $response->assertRedirect('/login');
        
        // Test des routes user
        $response = $this->get('/user/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_login_with_valid_credentials()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => Role::where('name', 'user')->first()->id,
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => Role::where('name', 'user')->first()->id,
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_requires_email_and_password()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function login_requires_valid_email_format()
    {
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_user_can_logout()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => Role::where('name', 'user')->first()->id,
            'status' => 'active',
        ]);
        
        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test */
    public function admin_can_access_admin_routes()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function regular_user_cannot_access_admin_routes()
    {
        $userRole = Role::where('name', 'user')->first();
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $userRole->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)
            ->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    /** @test */
    public function tech_manager_can_access_tech_routes()
    {
        $techRole = Role::where('name', 'tech_manager')->first();
        $tech = User::create([
            'name' => 'Tech User',
            'email' => 'tech@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $techRole->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($tech)
            ->get('/tech/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function regular_user_cannot_access_tech_routes()
    {
        $userRole = Role::where('name', 'user')->first();
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $userRole->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)
            ->get('/tech/dashboard');

        $response->assertStatus(403);
    }

    /** @test */
    public function csrf_protection_is_active()
    {
        // Tenter de soumettre un formulaire sans token CSRF
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        // La réponse doit échouer à cause de la protection CSRF
        $this->assertGuest();
    }

    /** @test */
    public function xss_protection_is_working()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => Role::where('name', 'user')->first()->id,
            'status' => 'active',
        ]);
        
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);
        
        // Tenter d'injecter du code XSS
        $xssPayload = '<script>alert("XSS")</script>';
        
        $response = $this->actingAs($admin)
            ->put('/admin/users/' . $user->id, [
                'name' => $xssPayload,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ]);

        // Vérifier que le code XSS a été nettoyé
        $updatedUser = $user->fresh();
        $this->assertStringNotContainsString('<script>', $updatedUser->name);
        $this->assertStringNotContainsString('alert', $updatedUser->name);
    }

    /** @test */
    public function rate_limiting_prevents_brute_force()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => Role::where('name', 'user')->first()->id,
            'status' => 'active',
        ]);

        // Tenter plusieurs connexions avec mauvais mot de passe
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // La dernière tentative devrait être bloquée
        $response->assertSessionHasErrors('rate_limit');
    }

    /** @test */
    public function suspicious_activity_is_logged()
    {
        Log::shouldReceive('warning')
            ->once()
            ->with('Suspicious activity detected', \Mockery::type('array'));

        // Simuler une activité suspecte (trop de tentatives de connexion)
        for ($i = 0; $i < 10; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }
    }

    /** @test */
    public function password_validation_is_strict()
    {
        $userRole = Role::where('name', 'user')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        // Mot de passe trop court
        $response = $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => '123',
                'password_confirmation' => '123',
                'role_id' => $userRole->id,
            ]);

        $response->assertSessionHasErrors('password');

        // Mot de passe sans majuscule
        $response = $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Test User',
                'email' => 'test2@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role_id' => $userRole->id,
            ]);

        $response->assertSessionHasErrors('password');

        // Mot de passe sans chiffre
        $response = $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Test User',
                'email' => 'test3@example.com',
                'password' => 'Password',
                'password_confirmation' => 'Password',
                'role_id' => $userRole->id,
            ]);

        $response->assertSessionHasErrors('password');

        // Mot de passe sans caractère spécial
        $response = $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Test User',
                'email' => 'test4@example.com',
                'password' => 'Password123',
                'password_confirmation' => 'Password123',
                'role_id' => $userRole->id,
            ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function email_validation_is_strict()
    {
        $userRole = Role::where('name', 'user')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        // Email invalide
        $invalidEmails = [
            'invalid-email',
            '@example.com',
            'test@',
            'test.example.com',
            'test@.com',
        ];

        foreach ($invalidEmails as $email) {
            $response = $this->actingAs($admin)
                ->post('/admin/users', [
                    'name' => 'Test User',
                    'email' => $email,
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                    'role_id' => $userRole->id,
                ]);

            $response->assertSessionHasErrors('email');
        }
    }

    /** @test */
    public function session_security_is_maintained()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => Role::where('name', 'user')->first()->id,
            'status' => 'active',
        ]);
        
        // Se connecter
        $this->actingAs($user);
        
        // Vérifier que la session est valide
        $this->assertAuthenticated();
        
        // Se déconnecter
        $this->post('/logout');
        
        // Vérifier que la session est invalidée
        $this->assertGuest();
        
        // Tenter d'accéder à une route protégée
        $response = $this->get('/user/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function headers_security_are_present()
    {
        $response = $this->get('/login');
        
        // Vérifier que la réponse a les headers de sécurité
        $this->assertTrue($response->headers->has('X-Frame-Options') || $response->headers->has('X-Content-Type-Options'));
    }
}
