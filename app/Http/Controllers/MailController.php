<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Personnel;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function news_letter_store(Request $request)
    {
        $attrs = $request->validate([
            'email' => 'nullable||string',
        ]);

        $attrs['ip'] = $request->ip();
        $attrs['ip2'] = $request->getClientIp();

        if(isset($attrs['email']) && !Subscribe::whereEmail($attrs['email'])->exists()){

            try {
                $subscribe = new Subscribe();
                $subscribe->email = $attrs['email'];
                $subscribe->address = json_encode([
                    'ip' => $attrs['ip'],
                    'ip2' => $attrs['ip2'],
                ]);
                $subscribe->save();

                Mail::send('email.welcome_subscribe', [], function ($message) use ($attrs) {
                    $message->to($attrs['email']);
                    $message->subject('Abonné privilégé du BARM');
                });
            } catch (\Throwable $th) {
                return back()->with('success', 'Vérifiez maintenant votre courrier électronique pour confirmer votre abonnement.');
            }


        }

        return back()->with('success', 'Vérifiez maintenant votre courrier électronique pour confirmer votre abonnement.');
    }

    public function subscribes()
    {

        return view('dashboard.mail.subscribes', [
            'title' => 'Liste des abonnées',
            'subscribes' => Subscribe::orderByDesc('created_at')->get(),
        ]);

    }

    public function create_mail()
    {

        return view('dashboard.mail.mail', [
            'title' => 'Envoie de mail',
            'data' => [
                'subscribes' => Subscribe::orderByDesc('created_at')->get(),
                'personals' => Personnel::orderByDesc('created_at')->get(),
                'adherents' => Candidature::orderByDesc('created_at')->get(),
            ],
        ]);

    }

    public function send_mail(Request $request)
    {

        $attrs = $request->validate([
            'subscribes_id' => 'nullable|array|min:1',
            'personals_id' => 'nullable|array|min:1',
            'adherents_id' => 'nullable|array|min:1',
            'all' => 'nullable|in:personals,subscribes,adherents,all',
            'subject' => 'required|string',
            'description' => 'required|string',
        ]);

        $emails = [];
        $subject = $attrs['subject'];

        if(isset($attrs['all'])){
            switch ($attrs['all']){
                case "personals" :
                    $personals = Personnel::all();
                    foreach ($personals as $key => $personal){
                        if($personal->user->email)
                            $emails[] = $personal->user->email;
                    }
                    break;
                case "subcribes" :
                    $subscribes = Subscribe::all();
                    foreach ($subscribes as $key => $subscribe){
                        if($subscribe->email)
                            $emails[] = $subscribe->email;
                    }
                    break;
                case "adherents" :
                    $adherents = Personnel::all();
                    foreach ($adherents as $key => $adherent){
                        if($adherent->user->email)
                            $emails[] = $adherent->user->email;
                    }
                    break;
                case "all" :
                    break;
                default;

            }
        }
        elseif(isset($attrs['subscribes_id'])){
            foreach ($attrs['subscribes_id'] as $key => $_id){
                $subscribe = Subscribe::find($_id);
                if($subscribe && $subscribe->email)
                    $emails[] = $subscribe->email;
            }
        }
        elseif(isset($attrs['personals_id'])){
            foreach ($attrs['personals_id'] as $key => $_id){
                $personal = Personnel::find($_id);
                if($personal && $personal->user->email)
                    $emails[] = $personal->user->email;
            }
        }
        elseif(isset($attrs['adherents_id'])){
            foreach ($attrs['adherents_id'] as $key => $_id){
                $adherent = Candidature::find($_id);
                if($adherent && $adherent->user->email)
                    $emails[] = $adherent->user->email;
            }
        }

        Mail::send('email.mail', ['data' => $attrs['description']], function ($message) use ($emails, $subject) {
            $message->to($emails);
            $message->subject($subject);
        });

        dd($request->except('_token'));


    }

    public function map($type, $id){

        try{
            if($type === 'subscribe'){
                $subscribe = Subscribe::find($id);

                if($subscribe && $subscribe->address) {

                    $ip = file_get_contents("http://ip-api.com/php/" . json_decode($subscribe->address)->ip . '?lang=fr');
                    $address = unserialize($ip);

                    if ($address['status'] != 'success')
                        return abort(403);

                    return view('map', compact('address'));
                }
            }
        }catch (\Throwable $th){
            return abort(500);
        }



        return '{code : 403}';


    }

}
