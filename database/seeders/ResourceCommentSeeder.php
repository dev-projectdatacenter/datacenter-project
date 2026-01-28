<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResourceComment;

class ResourceCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            [
                'resource_id' => 1, // Serveur Dell PowerEdge
                'user_id' => 4, // Ouarda
                'content' => 'Ce serveur fonctionne très bien pour nos tests de charge. Les performances sont excellentes.',
            ],
            [
                'resource_id' => 2, // VM Ubuntu Dev 01
                'user_id' => 3, // Fatima Zahrae
                'content' => 'La VM a besoin de plus de RAM pour nos applications. Peut-on passer à 32GB ?',
            ],
            [
                'resource_id' => 3, // NAS Synology DS1821+
                'user_id' => 2, // Responsable Technique
                'content' => 'Le RAID 6 est bien configuré. Prochaine maintenance prévue le mois prochain.',
            ],
            [
                'resource_id' => 1, // Serveur Dell PowerEdge
                'user_id' => 1, // Chayma (Admin)
                'content' => 'Vérifier les mises à jour de sécurité ce week-end. Planifier un redémarrage.',
            ],
            [
                'resource_id' => 4, // Switch Cisco Catalyst 9300
                'user_id' => 4, // Ouarda
                'content' => 'Les ports 1-8 fonctionnent parfaitement. Attention au port 10 qui a des problèmes intermittents.',
            ],
            [
                'resource_id' => 2, // VM Ubuntu Dev 01
                'user_id' => 5, // Halima
                'content' => 'Installation terminée avec succès. L\'environnement de développement est prêt.',
            ],
            [
                'resource_id' => 4, // Switch Cisco Catalyst 9300
                'user_id' => 3, // Fatima Zahrae
                'content' => 'Configuration VLAN terminée. Tous les réseaux sont isolés correctement.',
            ],
            [
                'resource_id' => 3, // NAS Synology DS1821+
                'user_id' => 6, // Fatima
                'content' => 'Espace de stockage suffisant pour nos backups mensuels. Merci pour la configuration.',
            ],
        ];

        foreach ($comments as $comment) {
            ResourceComment::create($comment);
        }
    }
}
