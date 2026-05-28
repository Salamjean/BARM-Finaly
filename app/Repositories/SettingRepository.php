<?php

namespace App\Repositories;

use App\Models\Ad;
use App\Models\AdImage;
use App\Models\NewsCast;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\Team;
use Illuminate\Support\Facades\File;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use PhpParser\Node\Expr\New_;


//use Your Model

/**
 * Class SettingRepository.
 */
class SettingRepository extends BaseRepository
{

    public $models;
    public function __construct(string $model)
    {
        return $this->models = $model;
    }
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        switch ($this->models) {
            case 'setting':
                return Setting::class;
                break;
            case 'ad':
                return Ad::class;
                break;
            case 'new':
                return NewsCast::class;
                break;
            case 'team':
                return Team::class;
                break;
            case 'partner':
                return Partner::class;
                break;

            default:
                return Setting::class;
                break;
        }
    }

    public function find(string $id)
    {
        return $this->model()::find($id);
    }

    public function findOtherField(string $field, string $value)
    {
        return $this->model()::where($field, $value)->first();
    }

    public function index()
    {
        if ($this->models == 'setting')
            return $this->model()::all();
        else
            return $this->model()::orderByDESC('created_at')->get();
    }

    public function store(array $data): string
    {
        try {

            switch ($this->models) {
                case 'setting':

                    $setting = $this->findOtherField('name', 'app_name');
                    $setting->value = $data['app_name'];
                    $setting->save();

                    $setting = $this->findOtherField('name', 'app_fullname');
                    $setting->value = $data['app_fullname'];
                    $setting->save();

                    $setting = $this->findOtherField('name', 'app_url');
                    $setting->value = $data['app_url'];
                    $setting->save();

                    $setting = $this->findOtherField('name', 'meta_title');
                    $setting->value = $data['meta_title'];
                    $setting->save();

                    $setting = $this->findOtherField('name', 'meta_description');
                    $setting->value = $data['meta_description'];
                    $setting->save();

                    $setting = $this->findOtherField('name', 'meta_url');
                    $setting->value = $data['meta_url'];
                    $setting->save();

                    $setting = $this->findOtherField('name', 'app_pointing_start_from');
                    $setting->value = $data['app_pointing_start_from'];
                    $setting->save();

                    $setting = $this->findOtherField('name', 'app_pointing_end_to');
                    $setting->value = $data['app_pointing_end_to'];
                    $setting->save();

                    if(isset($data['tawk_to'])){
                        $setting = $this->findOtherField('name', 'tawk_to');
                        $setting->value = $data['tawk_to'];
                        $setting->save();
                    }

                    if (isset($data['app_phone'])) {
                        $setting = $this->findOtherField('name', 'app_phone');
                        $setting->value = $data['app_phone'];
                        $setting->save();
                    }

                    if (isset($data['app_mail'])) {
                        $setting = $this->findOtherField('name', 'app_mail');
                        $setting->value = $data['app_mail'];
                        $setting->save();
                    }

                    if (isset($data['app_address'])) {
                        $setting = $this->findOtherField('name', 'app_address');
                        $setting->value = $data['app_address'];
                        $setting->save();
                    }

                    if (isset($data['app_map'])) {
                        $setting = $this->findOtherField('name', 'app_map');
                        $setting->value = $data['app_map'];
                        $setting->save();
                    }

                    if (isset($data['app_logo'])) {

                        $setting = $this->findOtherField('name', 'app_logo');

                        $app_logo = time() . '.' . $data['app_logo']->getClientOriginalExtension();
                        $path = saveByEnv() .  'data/images' . "/" . $app_logo;
                        \Image::make($data['app_logo']->getRealPath())->resize(150, 150)->save($path);

                        $setting->value = 'data/images/' . $app_logo;
                        $setting->save();
                    }

                    if (!file_exists(public_path('data/images')))
                        mkdir(public_path('data/images'), 0755, true);

                    if (isset($data['meta_image'])) {

                        $setting = $this->findOtherField('name', 'meta_image');

                        $meta_image = time() . '.' . $data['meta_image']->getClientOriginalExtension();
                        $path = saveByEnv() .  'data/images' . "/" . $meta_image;
                        \Image::make($data['meta_image']->getRealPath())->save($path);

                        $setting->value = 'data/images/' . $meta_image;
                        $setting->save();
                    }

                    return MESSAGES['setting']['update'];
                    break;
                case 'ad':

                    $insert = new Ad();

                    $insert->title = $data['title'];
                    if (isset($data['description']))
                        $insert->description = $data['description'];
                    $insert->save();

                    foreach ($data['images'] as $key => $value) {

                        $image = new AdImage();
                        $image->ad_id = $insert->id;

                        $filename = time() . $key . '.' . $value->getClientOriginalExtension();

                        if (!file_exists(public_path('data/images/ads')))
                            mkdir(public_path('data/images/ads'), 0755, true);

                        $path = saveByEnv() .  'data/images/ads' . "/" . $filename;
                        \Image::make($value->getRealPath())->save($path);

                        $image->image = 'data/images/ads/' . $filename;
                        $image->save();
                    }

                    return MESSAGES['ad']['store'];
                    break;
                case 'new':

                    $insert = new NewsCast();


                    $insert->title = $data['title'];

                    if (isset($data['description']))
                        $insert->description = $data['description'];

                    if (!file_exists(public_path('data/images/news')))
                        mkdir(public_path('data/images/news'), 0755, true);

                    $image = time() . '.' . $data['image']->getClientOriginalExtension();
                    $path = saveByEnv() .  'data/images/news' . "/" . $image;
                    \Image::make($data['image']->getRealPath())->save($path);

                    $insert->image = 'data/images/news/' . $image;
                    $insert->save();
                    return MESSAGES['new']['store'];
                    break;
                case 'team':

                    $insert = new Team();


                    $insert->name = $data['name'];
                    $insert->job = $data['job'];
                    if (isset($data['link_fb']))
                        $insert->facebook = $data['link_fb'];
                    if (isset($data['link_x']))
                        $insert->x = $data['link_x'];
                    if (isset($data['link_insta']))
                        $insert->insta = $data['link_insta'];
                    if (isset($data['link_linkedin']))
                        $insert->linkedin = $data['link_linkedin'];

                    if (!file_exists(public_path('data/images/teams')))
                        mkdir(public_path('data/images/teams'), 0755, true);

                    $image = time() . '.' . $data['image']->getClientOriginalExtension();
                    $path = saveByEnv() .  'data/images/teams' . "/" . $image;
                    \Image::make($data['image']->getRealPath())->save($path);

                    $insert->image = 'data/images/teams/' . $image;
                    $insert->save();

                    return MESSAGES['team']['store'];
                    break;

                case 'partner':

                    $insert = new Partner();

                    $insert->name = $data['name'];

                    if (!file_exists(public_path('data/images/partners')))
                        mkdir(public_path('data/images/partners'), 0755, true);

                    $image = time() . '.' . $data['image']->getClientOriginalExtension();
                    $path = saveByEnv() .  'data/images/partners' . "/" . $image;
                    \Image::make($data['image']->getRealPath())->save($path);

                    $insert->image = 'data/images/partners/' . $image;
                    $insert->save();

                    return MESSAGES['partner']['store'];
                    break;

                default:
                    return back();
                    break;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id): string
    {
        try {

            switch ($this->models) {
                case 'ad':

                    $insert = $this->find($id);

                    $insert->title = $data['title'];
                    if (isset($data['description']))
                        $insert->description = $data['description'];
                    $insert->save();

                    if (isset($data['images'])) {
                        foreach ($data['images'] as $key => $value) {

                            $image = new AdImage();
                            $image->ad_id = $insert->id;

                            $filename = time() . $key . '.' . $value->getClientOriginalExtension();
                            $path = public_path(saveByEnv() .  'data/images/ads') . "/" . $filename;
                            \Image::make($value->getRealPath())->save($path);

                            $image->image = 'data/images/ads/' . $filename;
                            $image->save();
                        }
                    }

                    return MESSAGES['ad']['update'];
                    break;
                case 'new':

                    $insert = $this->find($id);

                    $insert->title = $data['title'];
                    if (isset($data['description']))
                        $insert->description = $data['description'];

                    if (isset($data['image'])) {

                        if (File::exists($insert->image))
                            File::delete($insert->image);

                        $image = time() . '.' . $data['image']->getClientOriginalExtension();
                        $path = public_path(saveByEnv() .  'data/images/news') . "/" . $image;
                        \Image::make($data['image']->getRealPath())->save($path);

                        $insert->image = 'data/images/news/' . $image;
                    }

                    $insert->save();
                    return MESSAGES['new']['update'];
                    break;
                case 'team':
                    $insert = $this->find($id);


                    $insert->name = $data['name'];
                    if (isset($data['link_fb']))
                        $insert->facebook = $data['link_fb'];
                    if (isset($data['link_x']))
                        $insert->x = $data['link_x'];
                    if (isset($data['link_insta']))
                        $insert->insta = $data['link_insta'];
                    if (isset($data['link_linkedin']))
                        $insert->linkedin = $data['link_linkedin'];

                    if (isset($data['image'])) {

                        if (File::exists($insert->image))
                            File::delete($insert->image);

                        $image = time() . '.' . $data['image']->getClientOriginalExtension();
                        $path = public_path(saveByEnv() .  'data/images/teams') . "/" . $image;
                        \Image::make($data['image']->getRealPath())->save($path);

                        $insert->image = 'data/images/teams/' . $image;
                    }
                    $insert->save();

                    return MESSAGES['team']['update'];
                    break;

                case 'partner':
                    $insert = $this->find($id);


                    $insert->name = $data['name'];

                    if (isset($data['image'])) {

                        if (File::exists($insert->image))
                            File::delete($insert->image);

                        $image = time() . '.' . $data['image']->getClientOriginalExtension();
                        $path = public_path(saveByEnv() .  'data/images/partners') . "/" . $image;
                        \Image::make($data['image']->getRealPath())->save($path);

                        $insert->image = 'data/images/partners/' . $image;
                    }
                    $insert->save();

                    return MESSAGES['partner']['update'];
                    break;


                default:
                    return back();
                    break;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
