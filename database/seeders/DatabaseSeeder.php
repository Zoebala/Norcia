<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        /*----------------------------------------------------------------
                Définition des rôles
        -----------------------------------------------------------------*/
        // DB::table("roles")->insert([
        //         [
        //             "name"=>"Admin",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"PDG",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"DOp",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"DProd",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"DCom",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"Vendeur",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"Gestionnaire",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"DRH",
        //             "guard_name"=>"web"

        //         ],
        //         [
        //             "name"=>"Client",
        //             "guard_name"=>"web"

        //         ],
        // ]);
        /*----------------------------------------------------------------
                Définition Utilisateur Admin
        -----------------------------------------------------------------*/
        // $user=User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        // ]);

        // $user->assignRole("Admin");

         /*----------------------------------------------------------------
                Définition des permissions
          -----------------------------------------------------------------*/
        // DB::table("permissions")->insert(
        //     [
        //         [
        //             "name"=>"Create Annees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Departements",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Fonctions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Employes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Presences",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Fournisseurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Produits",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Pointventes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Stocks",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Clients",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Commandes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Entrees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Productions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Sorties",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create users",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Roles",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Permissions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Create Vendeurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Annees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Departements",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Vendeurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Fonctions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Employes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Presences",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Fournisseurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Produits",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Pointventes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Stocks",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Clients",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Commandes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Entrees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Productions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Sorties",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update users",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Roles",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Update Permissions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Annees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Vendeurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Departements",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Fonctions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Employes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Presences",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Fournisseurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Produits",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Pointventes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Stocks",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Clients",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Commandes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Entrees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Productions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Sorties",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete users",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Roles",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"Delete Permissions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Annees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Departements",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Vendeurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Fonctions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Employes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Presences",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Fournisseurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Produits",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Pointventes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Stocks",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Clients",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Commandes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Entrees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Productions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Sorties",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny users",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Roles",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"DeleteAny Permissions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Annees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Departements",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Vendeurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Fonctions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Employes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Presences",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Fournisseurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Produits",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Pointventes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Stocks",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Clients",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Commandes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Entrees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Productions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Sorties",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny users",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Roles",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"ViewAny Permissions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Annees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Departements",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Vendeurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Fonctions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Employes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Presences",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Fournisseurs",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Produits",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Pointventes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Stocks",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Clients",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Commandes",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Entrees",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Productions",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Sorties",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View users",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Roles",
        //             "guard_name"=>"web",
        //         ],
        //         [
        //             "name"=>"View Permissions",
        //             "guard_name"=>"web",
        //         ],

        //     ]
        // );

         /*----------------------------------------------------------------
                Attribution des permissions à des rôles
         -----------------------------------------------------------------*/

        $PDG=Role::findByName("PDG");
        $PDG->givePermissionTo([
                "ViewAny Annees",
                "ViewAny Fonctions",
                "ViewAny Departements",
                "ViewAny Presences",
                "ViewAny Employes",
                "ViewAny Fournisseurs",
                "ViewAny Stocks",
                "ViewAny Clients",
                "ViewAny Commandes",
                "ViewAny Vendeurs",
                "ViewAny Produits",
                "ViewAny Pointventes",
                "ViewAny Entrees",
                "ViewAny sorties",
                "ViewAny Users",
                "Update Users",

        ]);
        $DRH=Role::findByName("DRH");
        $DRH->givePermissionTo([
            "ViewAny Annees",
            "ViewAny Departements",
            "ViewAny Fonctions",
            "Create Fonctions",
            "Delete Fonctions",
            "Update Fonctions",
            "DeleteAny Fonctions",
            "ViewAny Employes",
            "Create Employes",
            "Update Employes",
            "Delete Employes",
            "DeleteAny Employes",
            "ViewAny Presences",
            "Create Presences",
            "Update Presences",
            "Delete Presences",
            "DeleteAny Presences",
            "ViewAny Users",
            "Update Users",
        ]);
        $Gestionnaire=Role::findByName("Gestionnaire");
        $Gestionnaire->givePermissionTo([
            "ViewAny Annees",
            "ViewAny Departements",
            "ViewAny Stocks",
            "Create Stocks",
            "Delete Stocks",
            "DeleteAny Stocks",
            "DeleteAny Stocks",
            "ViewAny Vendeurs",
            "ViewAny Users",
            "Update Users",
        ]);
        $DCom=Role::findByName("DCom");
        $DCom->givePermissionTo([
            "ViewAny Annees",
            "ViewAny Departements",
            "ViewAny Commandes",
            "Create Commandes",
            "Update Commandes",
            "Delete Commandes",
            "DeleteAny Commandes",
            "ViewAny Produits",
            "ViewAny Stocks",
            "ViewAny Sorties",
            "Create Sorties",
            "Update Sorties",
            "Delete Sorties",
            "DeleteAny Sorties",
            "ViewAny Cliens",
            "Create Cliens",
            "Update Cliens",
            "Delete Cliens",
            "DeleteAny Cliens",
            "ViewAny Vendeurs",
            "Create Vendeurs",
            "Update Vendeurs",
            "Delete Vendeurs",
            "DeleteAny Vendeurs",
            "ViewAny Users",
            "Update Users",
        ]);
        $DProd=Role::findByName("DProd");
        $DProd->givePermissionTo([
            "ViewAny Annees",
            "ViewAny Departements",
            "ViewAny Produits",
            "ViewAny Entrees",
            "Create Entrees",
            "Update Entrees",
            "Delete Entrees",
            "DeleteAny Entrees",
            "ViewAny Productions",
            "Create Productions",
            "Update Productions",
            "Delete Productions",
            "DeleteAny Productions",
            "ViewAny Users",
            "Update Users",

        ]);
        $DOp=Role::findByName("DOp");
        $DOp->givePermissionTo([
            "ViewAny Annees",
            "ViewAny Departements",
            "ViewAny Fournisseurs",
            "ViewAny Commandes",
            "ViewAny Produits",
            "ViewAny Stocks",
            "ViewAny Entrees",
            "ViewAny Productions",
            "ViewAny Sorties",
            "ViewAny Users",
            "Update Users",
        ]);
        $Vendeur=Role::findByName("Vendeur");
        $Vendeur->givePermissionTo([
            "ViewAny Annees",
            "ViewAny Produits",
            "ViewAny Sorties",
            "Create Sorties",
            "Update Sorties",
            "Delete Sorties",
            "DeleteAny Sorties",
            "ViewAny Users",
            "Update Users",
        ]);
        $Client=Role::findByName("Client");
        $Client->givePermissionTo([
            "ViewAny Annees",
            "ViewAny Produits",
            "ViewAny Commandes",
            "Create Commandes",
            "ViewAny Users",
            "Update Users",
        ]);
    }
}
