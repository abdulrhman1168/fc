<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use Modules\Auth\Entities\Core\User;
use Auth;
use Modules\Auth\Classes\AzureAuthentication;
use Modules\MobileApp\Entities\PushToken;

use Lcobucci\JWT\Parser;

use DB;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a New controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth-user')->except(['showLoginForm', 'login', 'ssoAuthorize', 'apiLogin', 'apiLogout']);
        $this->middleware('auth:api')->only(['apiLogout']);
    }

    /**
    * Show login form
    */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route($this->redirectTo);
        }

        return view('auth::login');
    }

    /**
    * Login user
    */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'username' => 'required',
        'password' => 'required'
      ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                             ->withErrors($validator)
                             ->with('error_login', 'invalid_login');
        }

        $userName = $request->username;

        if (strpos($userName, '@mu.edu.sa') == false) {
            $userName .= '@mu.edu.sa';
        }

        $credentials = [
          'email' => $userName,
          'password' => $request->password
      ];

        $user = User::isValidCredentials($credentials);

        if ($user != false) {
            Auth::login($user, true);
            return redirect()->route($this->redirectTo);
        } else {
            return redirect()->route('login')
                             ->withInput($request->except('password'))
                             ->with('error_login', 'invalid_login');
        }
    }

    public function ssoAuthorize(Request $request)
    {
      $email = AzureAuthentication::authorize($request);

      $user = User::whereRaw('LOWER(user_mail) = ?', [strtolower($email)])->first();

      if ($user != false) {
          Auth::login($user, true);
          return redirect()->route($this->redirectTo);
      } else {
          return redirect(env('AZURE_LOG_OUT_URL'));
      }

    }

    public function logout()
    {
        Auth::logout();

        if (env('AUTH_METHOD') == 'azure') {
            return redirect(env('AZURE_LOG_OUT_URL'));
        } else {
            return redirect()->route('login');
        }

    }

    public function apiLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userName = $request->username;

        if (strpos($userName, '@mu.edu.sa') == false) {
            $userName .= '@mu.edu.sa';
        }

        $credentials = [
          'email' => $userName,
          'password' => $request->password
      ];

        $user = User::isValidCredentials($credentials);

        if ($user != false) {

            Auth::login($user, true);
            $success['token'] =  $user->createToken('APIAPP')->accessToken;
 
            return response()->json($success, 200); 
        } else {

            return response()->json([ 'error' => 'Invalid login'], 401); 

        }
    }

    public function apiLogout(Request $request)
    {
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');
        $revoked = DB::table('oauth_access_tokens')->where('id', '=', $id)->update(['revoked' => 1]);
        
        $validatedData = \Validator::make($request->all(), [

            'token' => 'required',
            
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }

        $token = PushToken::where('token' ,$request->token);
        
        $token->delete();

        return response()->json(['success' => true], 200);
    }
    
}
