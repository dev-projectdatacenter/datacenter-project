<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::where('email', 'admin@test.com')->first();

if (!$user) {
  echo "User admin@test.com not found.\n";
  exit;
}

echo "User found: " . $user->name . "\n";
echo "Role ID: " . $user->role_id . "\n";

$user->load('role');

if ($user->role) {
  echo "Role Name: '" . $user->role->name . "'\n";
  echo "Normalized Role Name: '" . strtolower($user->role->name) . "'\n";
} else {
  echo "Role relation is null.\n";
}

$hierachy = [
  'guest' => 0,
  'user' => 1,
  'tech_manager' => 2,
  'admin' => 3,
];

if ($user->role) {
  $roleName = strtolower($user->role->name);
  if (isset($hierachy[$roleName])) {
    echo "Role exists in hierarchy. Value: " . $hierachy[$roleName] . "\n";
  } else {
    echo "Role NOT in hierarchy.\n";
  }
}
