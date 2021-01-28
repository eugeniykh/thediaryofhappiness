<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
class UserController extends Controller
{

    public function login(Request $request)  {
        $google_redirect_url = route('login');
        $gClient = new \Google_Client();
        $gClient->setApplicationName(env('services.google.app_name'));
        $gClient->setClientId(env('services.google.client_id'));
        $gClient->setClientSecret(env('services.google.client_secret'));
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey(env('services.google.api_key'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile',
        ));
        try {
            $google_oauthV2 = new \Google_Service_Oauth2($gClient);
            if ($request->get('code')) {
                $gClient->authenticate($request->get('code'));
                $request->session()->put('token', $gClient->getAccessToken());
            }
            if ($request->session()->get('token')) {
                $gClient->setAccessToken($request->session()->get('token'));
            }
            if ($gClient->getAccessToken()) {
                // for logged in user, get details from google using access token
                $guser = $google_oauthV2->userinfo->get();
                $user = User::where('email', $guser['email'])->first();
                if (!$user) {
                    $user = new User;
                    $user->email = $guser['email'];
                    $user->name = $guser['givenName'];
                }
                $user->api_token = str_random(60);
                $user->save();
                Auth::login($user);
                return redirect()->route('home');
            } else {
                // for Guest user, get google login url
                return $this->redirectToGoogleLogin($gClient);
            }
        } catch (\Google_Service_Exception $ex) {
            return $this->redirectToGoogleLogin($gClient);
        }
    }

    private function redirectToGoogleLogin(\Google_Client $gClient) {
        $authUrl = $gClient->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        return redirect('/');
    }
}
