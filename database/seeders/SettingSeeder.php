<?php

namespace Database\Seeders;

use App\Models\IpConfig;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ips = ['41.66.35.163', '127.0.0.1'];
        foreach ($ips as $value) {
            $ip = new IpConfig();
            $ip->ip = $value;
            $ip->save();
        }


        $data = [
            [
                'name' => 'app_name',
                'value' => 'BARM',
                'type' => 'other',
            ],
            [
                'name' => 'app_fullname',
                'value' => 'Bureau d\'Accompagnement à la Reconversion des Militaires',
                'type' => 'other',
            ],
            [
                'name' => 'app_logo',
                'value' => '/data/images/logo.jpeg',
                'type' => 'other',
            ],
            [
                'name' => 'app_url',
                'value' => env('APP_URL'),
                'type' => 'other',
            ],
            [
                'name' => 'app_env',
                'value' => env('APP_ENV'),
                'type' => 'system',
            ],
            [
                'name' => 'app_debug',
                'value' => env('APP_DEBUG'),
                'type' => 'system',
            ],
            [
                'name' => 'app_version',
                'value' => '1.0.0',
                'type' => 'system',
            ],
            [
                'name' => 'php_version',
                'value' => '8.1',
                'type' => 'system',
            ],
            [
                'name' => 'laravel_version',
                'value' => '10.10',
                'type' => 'system',
            ],
            [
                'name' => 'meta_title',
                'value' => 'BARM',
                'type' => 'other',
            ],
            [
                'name' => 'meta_description',
                'value' => 'Bureau d\'Accompagnement à la Reconversion des Militaires',
                'type' => 'other',
            ],
            [
                'name' => 'meta_url',
                'value' => env('APP_URL'),
                'type' => 'other',
            ],
            [
                'name' => 'meta_image',
                'value' => '/data/images/logo.jpeg',
                'type' => 'other',
            ],
            [
                'name' => 'app_mail',
                'value' => 'contact@kks-technologies.com',
                'type' => 'other',
            ],
            [
                'name' => 'app_address',
                'value' => 'Abidjan, cocody, CI',
                'type' => 'other',
            ],
            [
                'name' => 'app_phone',
                'value' => '0777130569',
                'type' => 'other',
            ],
            [
                'name' => 'app_pointing_start_from',
                'value' => '08:30',
                'type' => 'pointing',
            ],
            [
                'name' => 'app_pointing_end_to',
                'value' => '17:30',
                'type' => 'pointing',
            ],
            [
                'name' => 'tawk_to',
                'value' => '<!--Start of Tawk.to Script-->
                            <script type="text/javascript">
                            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                            (function(){
                            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                            s1.async=true;
                            s1.src=\'https://embed.tawk.to/6659dcfe981b6c564776d597/1hv7gegs8\';
                            s1.charset=\'UTF-8 \';
                            s1.setAttribute(\'crossorigin\',\'*\');
                            s0.parentNode.insertBefore(s1,s0);
                            })();
                            </script>
                            <!--End of Tawk.to Script-->',
                'type' => 'plugin',
            ],

            [
                'name' => 'app_map',
                'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15888.61570530824!2d-3.9828515!3d5.3935015!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc195e6e62ee2e7%3A0x5b18d4f56418facf!2sBARM%20(Bureau%20d&#39;Accompagnement%20%C3%A0%20la%20Reconversion%20des%20Militaires)!5e0!3m2!1sfr!2sci!4v1710351336678!5m2!1sfr!2sci" height="450" style="border:0;width:100vw;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'type' => 'plugin',
            ],


        ];

        foreach ($data as $key => $value) {
            $setting = new Setting();
            $setting->name = $value['name'];
            $setting->value = $value['value'];
            $setting->type = $value['type'];
            $setting->save();
        }

        $mkdir = [
            'demande_manuscrite',
            'cv',
            'id_card',
            'carte_pro',
            'fiche_engagement',
            'fiche_individuelle',
            'docs_favorable_opinion',
            'fiche_inscription',
            'arrete_radiation',
            'certificat',
            'file_authorization',
            'cards',
            'marriages',
            'childs',
            'plan_affaire',
            'photo',
            'pa',
            'file_account_opening',
            'file_disbursement',
            'report_file_disbursement',
            'report_file',

            'bilancompetence',
            'contrat',
            'cr_commission',
            'cvlm',
            'formation',
        ];

        $mainDirectory = public_path("data/docs");

        if (file_exists($mainDirectory)) {
            $files = array_diff(scandir($mainDirectory), array('.', '..'));

            foreach ($files as $file) {
                $path = "$mainDirectory/$file";
                if (is_dir($path)) {
                    $subFiles = array_diff(scandir($path), array('.', '..'));
                    foreach ($subFiles as $subFile) {
                        unlink("$path/$subFile");
                    }
                    rmdir($path);
                } else {
                    unlink($path);
                }
            }
            rmdir($mainDirectory);
        }

        mkdir($mainDirectory, 0755, true);

        foreach ($mkdir as $key => $folder) {
            $subDirectory = "$mainDirectory/$folder";
            if (!file_exists($subDirectory)) {
                mkdir($subDirectory, 0755, true);
            }
        }

        
    }
}
