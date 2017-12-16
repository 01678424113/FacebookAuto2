<?php

namespace App\Http\Controllers;

use App\CategoriesPage;
use App\User;
use App\Group;
use Cookie;
use Illuminate\Http\Request;
use Facebook;
use Facebook\FacebookApp;
use Facebook\FacebookClient;
use Facebook\FacebookResponse;
use Facebook\Authentication\AccessToken;
use Facebook\FacebookRequest;
use Session;


class CategoriesPageController extends Controller
{
    public function getPostGroupMe()
    {
        $categories = CategoriesPage::all();
        return view('groups.post-group-me',['categories'=>$categories]);
    }
    public function getPostGroupId()
    {
        $categories = CategoriesPage::all();
        return view('groups.post-group-id',['categories'=>$categories]);
    }
    public function getPostGroupCategory()
    {
        $categories = CategoriesPage::all();
        return view('groups.post-group-category',['categories'=>$categories]);
    }

    public function getPostPage()
    {
        return view('pages.post-page');
    }
    public function getAccessTokenPage()
    {
        session_start();
        //Config App
        $access_token_user = Session::get('accessToken_user');
        $app = new FacebookApp(env('FACEBOOK_APP_ID'), env('FACEBOOK_APP_SECRET'));
        $fb = new Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID_ANDROID'),
            'app_secret' => env('FACEBOOK_APP_SECRET_ANDROID'),
            'default_graph_version' => env('FACEBOOK_API_VERSION'),
        ]);
        //Khởi tạo biến session chứa mảng các access token page
        $list_access_token = array();

        //Tách danh sách id đã nhập thành mảng
        if(!empty($_POST['page_ids'])){
            $page_ids = $_POST['page_ids'];
            $page_ids_list = explode(';', $page_ids);
            //Chạy vòng lặp để lấy access token của từng page
            foreach ($page_ids_list as $page_id) {
                $page_id = trim($page_id);
                if( $page_id == ""){
                    break;
                }

                $request = new FacebookRequest(
                    $app,
                    $access_token_user,
                    'GET', '/' . $page_id,
                    array('fields' => 'access_token'));
                // Send the request to Graph

                try {

                    $response = $fb->getClient()->sendRequest($request);
                   
                    $graphNode = $response->getGraphNode();
                    Session::put('list_access_token',$graphNode['access_token']);
                    $list_access_token[] = Session::get('list_access_token');
                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                    // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
            }
            Session::put('list_access_token',$list_access_token);
            Session::put('page_ids',$page_ids_list);
            return redirect()->back();
        }else{
            Session::flush();
            return redirect()->back();
        }
    }

    public function reset()
    {
        $_POST = [''];
        return redirect()->back();
    }

    public function index()
    {
        $categories = CategoriesPage::all();
        return view('category.show',['categories'=>$categories]);
    }


    public function getAdd()
    {
        return view('category.add');
    }

    public function postAdd(Request $request)
    {
        $category = new CategoriesPage;
        $category->name = $request->category_name;
        try{
            $category->save();
            return redirect()->route('showCategory')->with('message','Đã thêm thành công !');
        }catch (Exception $e){
            return redirect()->back()->with('error','Lỗi kết nối cơ sở dữ liệu !');
        }
    }

    public function getEdit($id)
    {
        $category = CategoriesPage::find($id);
        return view('category.edit',['category'=>$category]);
    }
    public function postEdit(Request $request,$id)
    {
        $category = CategoriesPage::find($id);
        $category->name = $request->category_name;

        try{
            $category->save();
            return redirect()->route('showCategory')->with('message','Sửa thành công !');
        }catch (Exception $e){
            return redirect()->back()->with('error','Lỗi kết nối cơ sở dữ liệu !');
        }
    }

    public function delete($id)
    {
        $category = CategoriesPage::find($id);
        $category->delete();
        return redirect()->back()->with('message','Đã xóa thành công !!');
    }

}
