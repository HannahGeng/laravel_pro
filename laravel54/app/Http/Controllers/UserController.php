<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 15:23
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    //个人设置页面
    public function setting()
    {
        $user = \Auth::user();
        return view("user.setting",compact("user"));
    }

    //个人设置行为
    public function settingStore(Request $request)
    {
        //验证
        $this->validate(request(),[
            'name'=>'required|min:3'
        ]);

        //逻辑
        $name = request("name");
        $user = Auth::user();

        if ($name != $user->name)
        {
            if (User::where("name",$name)->count() > 0)
            {
                return back()->withErrors("用户名已经被占用");
            }
            $user->name = request("name");
        }

        if ($request->file('avatar'))
        {
            $path = $request->file('avatar')->storePublicly(\Auth::id());
            $user->avatar = "/storage/".$path;
        }

        $user->save();

        //渲染
        return back();
    }
}