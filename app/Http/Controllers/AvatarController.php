<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avatar;
use Illuminate\Support\Str;

class AvatarController extends Controller
{
    public function index()
    {
        $avatars = Avatar::orderBy("created_at")->get();

        return view("avatars.index", [
            "avatars" => $avatars
        ]);
    }

    public function create()
    {
        return view('avatars.create');
    }

    public function show()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "price" => "required",
            "avatar_image" => "required|image|mimes:jpg,png,jpeg,gif,svg|max:2028"
        ]);

        $urlResponse = cloudinary()->upload($request->file('avatar_image')->getRealPath(), ["folder" => "football-quiz"])->getSecurePath();

        $avatar = new Avatar;
        $avatar->id = Str::uuid()->toString();
        $avatar->avatar_name = $request->name;
        $avatar->avatar_url = $urlResponse;
        $avatar->price = $request->price;

        $avatar->save();

        return redirect()->route("avatars.index")->with("success", "Avatar Added Successfully");
    }

    public function edit($id)
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        if (!preg_match($pattern, $id) == 1) {
            abort(404);
        }

        $avatar = Avatar::findOrFail($id);
        return view("avatars.edit", ["avatar" => $avatar]);
    }

    public function update(Request $request)
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        if (!preg_match($pattern, $request->hidden_id) == 1) {
            abort(404);
        }

        $request->validate([
            "name" => "required",
            "price" => "required",
            "avatar_image" => "image|mimes:jpg,png,jpeg,gif,svg|max:2028"
        ]);

        $avatar = Avatar::find($request->hidden_id);
        $avatar->id = Str::uuid()->toString();
        $avatar->avatar_name = $request->name;
        if ($request->avatar_image != "") {
            $urlResponse = cloudinary()->upload($request->file('avatar_image')->getRealPath(), ["folder" => "football-quiz"])->getSecurePath();
            $avatar->avatar_url = $urlResponse;
        }
        $avatar->price = $request->price;

        $avatar->save();

        return redirect()->route("avatars.index")->with("success", "Avatar Updated Successfully");
    }

    public function destroy($id)
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        if (!preg_match($pattern, $id) == 1) {
            abort(404);
        }

        $avatar = Avatar::find($id);
        $avatar->delete();

        return redirect()->route("avatars.index")->with("success", "Avatar Deleted Successfully");
    }
}
