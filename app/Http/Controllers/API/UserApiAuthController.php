<?php

namespace App\Http\Controllers\API;

use App\Helpers\Messages;
use App\Helpers\UserFcmTokenController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserApiAuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->get('email'))->first();
            if (Hash::check($request->get('password'), $user->password)) {
                $this->revokePreviousToken($user->id);
                // if (!$this->checkActiveTokens($user->id)) {
                $token = $user->createToken('BS');

                // $fcm = new UserFcmTokenController();
                // $fcm->sendNotification([User::whereNotNull('fcm_token')->get('fcm_token')], '', '', '');

                $user->setAttribute('token', $token->accessToken);
                return response()->json(['status' => true, 'message' => Messages::getMessage('LOGGED_IN_SUCCESSFULLY'), 'object' => $user,], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to login, please logout from other devices'], 401);
            }
            // } else {
            //     return response()->json(['status' => false, 'message' => 'Wrond password'], 400);
            // }
        } else {
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()], 400);
        }
    }

    public function pgtLogin(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->get('email'))->first();
            $this->revokePreviousToken($user->id);

            $response = Http::asForm()
                ->post('http://127.0.0.1:8001/oauth/token', [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'OT1my5v4yO2ZJS3IdGaREM2wIwIJJo1nHuTcRa03',
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'scope' => '*',
                ]);

            $user->setAttribute('token', $response->json()['access_token']);
            $user->setAttribute('refresh_token', $response->json()['refresh_token']);
            return response()->json(['status' => true, 'object' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()], 400);
        }
    }

    private function revokePreviousToken($userId)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->update([
                'revoked' => true
            ]);
    }

    private function checkActiveTokens($userId)
    {
        return DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->where('revoked', false)
            ->exists();
    }

    public function logout(Request $request)
    {
        $isLoggedOut = $request->user('api')->token()->revoke();
        return response()->json(
            [
                'status' => $isLoggedOut,
                'message' => $isLoggedOut ? 'Loggout out successfully' : 'Failed to logout'
            ],
            $isLoggedOut ? 200 : 400
        );
    }

    public function logoutPgt(Request $request)
    {
        $token = $request->user('api')->token();
        $refreshTokenRevoked = DB::table('oauth_refresh_tokens')->where('access_token_id', $token->id)->update([
            'revoked' => true
        ]);
        if ($refreshTokenRevoked) {
            $isRevoked = $token->revoke();
            return response()->json(
                [
                    'status' => $isRevoked,
                    'message' => $isRevoked ? 'Logged out successfully' : 'Error'
                ],
                $isRevoked ? 200 : 400
            );
        }
    }
}
