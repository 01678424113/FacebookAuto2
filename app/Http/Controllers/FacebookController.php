<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Illuminate\Http\Request;
use Facebook;
use Mockery\Exception;
use Session;
use URL;

class FacebookController extends Controller
{
    private $fb;

    public function __construct()
    {
        $this->fb = new Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => env('FACEBOOK_API_VERSION'),
        ]);
    }

    public function facebookLogin(Request $request)
    {
        $user = User::find(Session::get('id_user'));
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = ['public_profile,email'];
        $loginURL = $helper->getLoginUrl(action('FacebookController@facebookLoginCallback'), $permissions);
        return view('pages.index', ['login_url' => $loginURL,'user'=>$user]);
    }

    public function facebookLoginCallback(Request $request)
    {
        $helper = $this->fb->getRedirectLoginHelper();

        $helper->getPersistentDataHandler()->set('state', $request->input('state'));

        try {
            session_start();

            $accessToken = $helper->getAccessToken();
            // OAuth 2.0 client handler
            $oAuth2Client = $this->fb->getOAuth2Client();

            // Exchanges a short-lived access token for a long-lived one
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            $this->fb->setDefaultAccessToken($accessToken);
            $response = $this->fb->get('/me?feilds=email,name');
            $usernode = $response->getGraphUser();
            $user_name = $usernode->getName();
            $user_id = $usernode->getId();
            Session::put('user_name',$user_name);

            $user = User::where('user_id',$user_id)->first();
            if(!empty($user)){
                $id_user = $user->id;
                Session::put('id_user',$id_user);
                if(!empty($user->access_token_full)){
                    Session::put('accessToken_user',$user->access_token_full);
                    return redirect('/');
                }else{
                    return redirect('/');
                }
            }else{
                $user_new = new User;
                $user_new->user_id = $user_id;
                $user_new->name = $user_name;
                $user_new->password = md5(123456);
                try{
                    $user_new->save();
                    $user = User::where('user_id',$user_id)->first();
                    $id_user = $user->id;
                    Session::put('id_user',$id_user);
                    return redirect('/');
                }catch (Exception $e){
                    return redirect()->back()->with('error','Lỗi kết nối cơ sở dữ liệu');
                }
            }
        } catch (\Exception $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Exception $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public function facebookLogout()
    {
        session_start();

        Session::flush();

        return redirect('/');
    }

    public function getAccesstokenFullPermission()
    {
       return view('facebook.getAccessTokenFullPermission');
    }

    public function cURL($method = 'GET', $url = false, $data){
        $c = curl_init();
        $user_agents = array(
            "Mozilla/5.0 (Linux; Android 5.0.2; Andromax C46B2G Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/60.0.0.16.76;]",
            "[FBAN/FB4A;FBAV/35.0.0.48.273;FBDM/{density=1.33125,width=800,height=1205};FBLC/en_US;FBCR/;FBPN/com.facebook.katana;FBDV/Nexus 7;FBSV/4.1.1;FBBK/0;]",
            "Mozilla/5.0 (Linux; Android 5.1.1; SM-N9208 Build/LMY47X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36",
            "Mozilla/5.0 (Linux; U; Android 5.0; en-US; ASUS_Z008 Build/LRX21V) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.8.0.718 U3/0.8.0 Mobile Safari/534.30",
            "Mozilla/5.0 (Linux; U; Android 5.1; en-US; E5563 Build/29.1.B.0.101) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.10.0.796 U3/0.8.0 Mobile Safari/534.30",
            "Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; Celkon A406 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"
        );
        $useragent = $user_agents[array_rand($user_agents)];
        $opts = array(
            CURLOPT_URL => ($url ? $url : 'https://api.facebook.com/restserver.php').($method == 'GET' ? '?'.http_build_query($data) : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => $useragent
        );
        if($method == 'POST'){
            $opts[CURLOPT_POST] = true;
            $opts[CURLOPT_POSTFIELDS] = $data;
        }
        curl_setopt_array($c, $opts);
        $d = curl_exec($c);
        curl_close($c);
        return $d;
    }
    public function postAccesstokenFullPermission(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        Session::put('username',$username);
        Session::put('password',$password);


        $data = [
            "api_key" => "882a8490361da98702bf97a021ddc14d",
            "credentials_type" => "password",
            "email" => Session::get('username'),
            "format" => "JSON",
            "generate_machine_id" => "1",
            "generate_session_cookies" => "1",
            "locale" => "en_US",
            "method" => "auth.login",
            "password" => Session::get('password'),
            "return_ssl_resources" => "0",
            "v" => "1.0"
        ];
        $sig = "";
        foreach($data as $key => $value){
            $sig .= "$key=$value";
        }
        $sig .= '62f8ce9f74b12f84c123cc23437a4a32';
        $data['sig'] = md5($sig);
        try{
            $response = $this->cURL('GET', false, $data);
            $response = json_decode($response);

            $user = User::find(Session::get('id_user'));

            $user->access_token_full = $response->access_token;
            $user->save();
            Session::put('accessToken_user',$response->access_token);
            return redirect()->route('home');
        }catch (Exception $e){
            return redirect()->back()->with('error','Tài khoản chưa được xác thực. Bạn vui lòng đăng nhập vào facebook.com để tiến hành xác thực tài khoản !');
        };

    }
}
