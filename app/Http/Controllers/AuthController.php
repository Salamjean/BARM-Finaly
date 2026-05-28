<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Role;
use App\Models\Submission;
use App\Models\User;
use App\Repositories\SmsRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function signIn(string $user = 'client'): View
    {

        return view('auth.login.auth');
    }

    //extra dev

    public function extra(Request $request)
    {
        if ($request->user == 'client') {
            $request->validate([
                'mecano' => 'required|string',
                'password' => 'required|string',
            ]);
            $cred = $request->only('mecano', 'password');

            if (Auth::attempt(['email' => $cred['mecano'], 'password' => $cred['password']])) {
                if (Auth::user()->status == 1) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                } else {
                    Auth::logout();
                    return back()->withErrors(['error' => 'Votre compte est inactif. Veuillez vous rendre au BARM pour l\activation.']);
                }
            }

            return back()->withErrors(['error', 'Mécano/Matricule ou mot de passe incorrect !']);
        }
    }

    public function login(Request $request)
    {
        $request->validate(['user' => 'required|in:admin,personal,partner,client']);

        $request->validate([
            'mecano' => 'required|string',
            'password' => 'required|string',
        ]);

        $cred = $request->only('mecano', 'password');

        if (Auth::attempt([
            'email' => $cred['mecano'],
            'password' => $cred['password'],
        ])) {
            if (Auth::user()->status == 1) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            } else {

                Auth::logout();
                return back()->with('error', 'Votre compte est inactif. Veuillez vous rendre au BARM pour l\activation.');
            }
        }

        $this->extra($request);

        return back()->withErrors(['error' => 'Mécano/Matricule ou mot de passe incorrect !']);
    }

    public function signOut(): View
    {
        return view('auth.register', ['title' => 'Page d\'inscription']);
    }

    public function register(Request $request)
    {

        $attrs = $request->validate([
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'phone_number' => 'required|string|size:10|unique:submissions,phone_number',
            'mecano' => 'required|string|unique:users,mecano',
            'type_piece' => 'required|string',
            'no_card' => 'required|string|unique:submissions,no_card',
            'email' => 'nullable|email|unique:users,email',
            'birth_date' => 'required|date',
            'gender' => 'required|string',
            'ethnic' => 'nullable|string',
            'religion' => 'nullable|string',
        ]);

        try {

            $password = generateRandomString(8);

            // Create new user
            $user = User::create([
                'mecano' => $attrs['mecano'],
                'email' => $attrs['email'] ?? null,
                'username' => strtoupper($attrs['last_name']) . " " . ucfirst(strtolower($attrs['first_name'])),
                'lastname' => strtoupper($attrs['last_name']),
                'firstname' => ucfirst(strtolower($attrs['first_name'])),
                'password' => Hash::make($password),
                'status' => '1',
            ]);

            // Create new submission
            $submission = Candidature::create([
                'user_id' => $user->id,
                'phone_number' => $attrs['phone_number'],
                'type_piece' => mb_strtoupper($attrs['type_piece']),
                'no_card' => $attrs['no_card'],
                'birth_date' => $attrs['birth_date'],
                'gender' => $attrs['gender'],
                'ethnic' => $attrs['ethnic'],
                'religion' => $attrs['religion'],
            ]);

            //send mail
            if (isset($attrs['email']))
                Mail::send('email.welcome_adherent', ['user' => $user, 'submission' => $submission, 'password' => $password], function ($message) use ($attrs) {
                    $message->to($attrs['email']);
                    $message->subject('Code de confirmation');
                });

            //role assignment
            $role = Role::where('name', 'CANDIDAT')->first();
            $user->roles()->sync([$role->id]);

            //SMS
            $message = "Votre inscription a été validée. Votre mot de passe par défaut : $password";
            (new SmsRepository($submission->phone_number, $message))->send();

            return redirect("/login?mecano=$user->mecano")->with('success', MESSAGES['client']['store']);
        } catch (Throwable $e) {
            //dd($e);
        }
    }

    public function forgot_password(string $user)
    {

        return view('auth.forgot_password.forgot_password', ['user' => $user]);
    }

    public function two_step(Request $request)
    {

        $code = rand(10000, 99999);
        $token = rand(10000000000000000, 99999999999999999);

        if (isset($request->phone_number) && $request->phone_number && $request->user === 'adherent') {

            $can = Candidature::wherePhoneNumber($request->phone_number)->first();

            if (!$can)
                return back()->with('error', 'Veuillez vous inscrire auprès d\'un conseillé BARM.');

            //send mail
            if ($can->user->email)
                Mail::send('email.welcome_adherent', ['user' => $can->user, 'submission' => $can, 'password' => $code], function ($message) use ($can) {
                    $message->to($can->user->email);
                    $message->subject('Code de confirmation');
                });

            //SMS
            $message = "Votre code pour réintialiser le mot de passe votre mot de passe est $code";
            (new SmsRepository($can->phone_number, $message))->send();
        }

        if (isset($request->email) && $request->email) {
            $user = User::whereEmail($request->email)->first();

            if (!$user)
                return back()->with('error', 'Email non trouvé.');

            //send mail
            if ($user->email)
                Mail::send('email.forgot_password', ['user' => $user, 'password' => $code], function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Code de confirmation');
                });

            //SMS
            if ($user->email) {
                $message = "Votre code pour réintialiser votre mot de passe est $code";
                (new SmsRepository($user->phone, $message))->send();
            }
        }

        if (!isset($request->email) && !isset($request->phone_number))
            abort(403);

        $verif = DB::table('password_reset_tokens')->select('*')
            ->where('email', $request->email ?? $request->phone_number)->first();

        if ($verif)
            DB::table('password_reset_tokens')->where(['email' => $request->email ?? $request->phone_number])->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email ?? $request->phone_number,
            'token' => $token,
            'code' => $code,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return view('auth.forgot_password.forgot_password_two_step', [
            'user' => $request->user,
            'phoneOrEmail' => $request->email ?? $request->phone_number,
        ])->with('success', 'Code envoyé.');
    }

    public function three_step(Request $request)
    {

        $request->validate([
            'phoneOrEmail' => 'required',
            'user' => 'required',
            'otp' => 'required|numeric',
        ]);

        $verif = DB::table('password_reset_tokens')->select('*')
            ->where('email', $request->phoneOrEmail)
            ->where('code', $request->otp)->first();

        if (!$verif)
            return back()->with('error', 'Code non valide.');

        $password = generateRandomString(8);

        if ($request->user == 'adherent') {

            $can = Candidature::where('phone_number', $request->phoneOrEmail)->first();
            $user = $can->user;
            $user->password = Hash::make($password);
            $user->save();

            $message = "Votre nouveau mot de passe votre par default est $password";
            (new SmsRepository($can->phone_number, $message))->send();
        } else {

            $user = User::whereEmail($request->phoneOrEmail)->first();
            $user->password = Hash::make($request->password);
            $user->save();
        }

        DB::table('password_reset_tokens')->where(['email' => $request->phoneOrEmail])->delete();


        return to_route('login')->with('success', 'Votre mot de passe a été modifié vec succès');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/login');
    }
}
