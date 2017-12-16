<?php

namespace App\Http\Controllers;

use App\CategoriesPage;
use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\EditPageRequest;
use App\Page;
use Illuminate\Http\Request;
use Mockery\Exception;

class PageController extends Controller
{
    public function index()
    {
        $categories = CategoriesPage::all();
        $pages = Page::all();
        return view('pages.show-page',['categories'=>$categories,'pages'=>$pages]);
    }

    public function getAdd()
    {
        $categories = CategoriesPage::all();
        return view('pages.add-page',['categories'=>$categories]);
    }

    public function postAdd(CreatePageRequest $request)
    {
        $page = new Page;
        $page->page_id = $request->page_id;
        $page->page_name = $request->page_name;
        $page->id_category = $request->id_category;
        try{
            $page->save();
            return redirect()->route('showPage')->with('message','Đã thêm thành công!!');
        }catch (Exception $e){
            return redirect()->back()->with('error','Lỗi kết nối cơ sở dữ liệu !');
        }
    }

    public function getEdit($id)
    {
        $categories = CategoriesPage::all();
        $page = Page::find($id);
        return view('pages.edit-page',['page'=>$page,'categories'=>$categories]);
    }

    public function postEdit(EditPageRequest $request,$id)
    {
        $page = Page::find($id);
        $page->page_name = $request->page_name;
        $page->id_category = $request->id_category;
        try{
            $page->save();
            return redirect()->route('showPage')->with('message','Sửa thành công !');
        }catch (Exception $e){
            return redirect()->back()->with('error','Lỗi kết nối cơ sở dữ liệu !');
        }
    }
    public function delete($id)
    {
        $page = Page::find($id);
        $page->delete();
        return redirect()->back()->with('message','Đã xóa thành công !!');
    }
}
