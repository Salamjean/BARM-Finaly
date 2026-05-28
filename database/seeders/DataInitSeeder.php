<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\AdImage;
use App\Models\NewsCast;
use App\Models\Partner;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //teams
        $teams = [
            ['name' => 'COLONEL AKE-DANHO STEPHANE ERIC', 'role' => 'CHEF BARM', 'personal' => 'dg', 'image' => 'test/1710596447.jpeg'],
            ['name' => 'M. DIABATE OUMAROU', 'role' => 'GESTIONNAIRE DES RESSOURCES HUMAINES', 'personal' => 'personal', 'image' => null],
        ];

        foreach ($teams as $team){
            $t = new Team();
            $t -> name = $team['name'];
            $t -> job = $team['role'];
            $t -> personal = $team['personal'];
            $t -> image = $team['image'];
            $t -> save();
        }

        //partners
        $partners = [
            ['name' => 'KKS TECHNOLOGIES', 'image' => 'test/1710596568.jpeg'],
            ['name' => 'ANADER', 'image' => 'test/1710596582.png'],
            ['name' => 'FIDRA', 'image' => 'test/1710922150.jfif'],
        ];

        foreach ($partners as $partner){
            $t = new Partner();
            $t -> name = $partner['name'];
            $t -> image = $partner['image'];
            $t -> save();
        }

        //news and ads
        $news = [
            [
                'title' => 'Côte d’Ivoire / Réinsertion des Militaires à la retraite dans le domaine de l’entrepreneuriat : le BARM consolide sa collaboration avec ses partenaires',
                'image' => 'test/1624608732IMG-20210624-WA0025.jpg',
                'description'  => 'La Salle des Conférences de l’Hôtel Palm-Club d’Abidjan a abrité ce jeudi 24 juin 2021, la signature d’une convention entre le Bureau d’Accompagnement à la Reconversion des Militaires (BARM) et les différentes structures techniques que sont : - l’AGEFOP – l’ANADER – l’INIE – le FIDRA et la FPS-CI. Il s’agit d’une convention relative au programme d’appui à la reconversion des ex-militaires sur la deuxième phase du Contrat de Désendettement et de Développement (C2D). La mise en œuvre de ce programme initiée par la BARM vise à offrir une opportunité aux ex-militaires de créer des TPE et PME au travers des formations techniques sur l’entrepreneuriat. Dans ce projet l’AGEFOP sera chargée d’encadrer les bénéficiaires dans le domaine de l’artisanat. L’INIE et la PFS-CI s’occupera du volet commerce à Abidjan et à l’intérieur du pays. L’ANADER quant à elle se chargera de la formation des ex-militaires dans le domaine agro-pastoral. « Je rappelle que toutes les formations dans le cadre de ce projet, sont couplées par une formation en entrepreneuriat pour la création d’entreprises », a souligné le Directeur Général de l’AGEFOP, Bamoudien TRAORE, qui représentait l’ensemble des partenaires techniques et financiers à cette cérémonie. Pour sa part, le Colonel AKE DANHO, Chef du BARM a tenu à remercier l’ensemble des partenaires techniques et financiers pour leur soutien. « Cet aboutissement est le fruit des efforts conjugués du BARM et de ses fidèles partenaires que je tiens à remercier infiniment pour leur sollicitude, leur extrême patience et leur foi en la réussite du projet, car depuis la signature des conventions cadre le 30 décembre 2019, l’attente fut longue. »A-t-il indiqué. Notons que sur environ 5600 candidats éligibles, 2108 sont à ce jour effectivement inscrit au programme. Parmi eux, 1932 sont désireux d’entreprendre, 106 se sont orientés vers les emplois salariés du secteur privé et 70 souhaitent une insertion dans des emplois de la fonction publique. Créée en mai 2018, le Bureau d’Accompagnement à la Reconversion des Militaires (BARM), est chargé de la reconversion des Militaires et Gendarmes admis à faire valoir leur droit à la retraite soit à la limite d’âge ou par départ volontaire, soit pour convenance personnelle ou raison de santé, afin de leur faciliter une insertion dans la vie civile. '
            ],
        ];

        foreach ($news as $new){

            $t = new NewsCast();
            $t -> title = $new['title'];
            $t -> image = $new['image'];
            $t -> save();

            $t = new Ad();
            $t -> title = $new['title'];
            $t -> description = $new['description'];
            $t -> save();

            $im = new AdImage();
            $im -> ad_id = $t -> id;
            $im -> image = $new['image'];
            $im -> save();
        }
    }
}
