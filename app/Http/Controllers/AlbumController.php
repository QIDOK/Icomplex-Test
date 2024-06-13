<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AlbumController extends Controller
{
    public function view(int $id = null)
    {
        if($id && $photo = Photo::find($id))
            return view('photo', ['photo' => $photo]);

        return view('album');
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => ['string', 'nullable', "max:65535"],
            'image' => ['mimes:jpeg,jpg,png', 'required']
        ]);

        if(!$request->hasFile('image'))
            return redirect(route('album'));

        $image = $request->file('image');
        $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', "photos/$filename");

        $photo = Photo::create([
            'author_id' => Auth::user()->id,
            'path' => $filename,
            'comment' => $request->get('comment')
        ]);

        return json_encode([
            'success' => true,
            'card' => view('fragments.photo_card', ['photo' => $photo])->render()
        ]);
    }

    public function destroy(int $id = null)
    {
        if($id) {
            $photo = Photo::get($id);

            if($photo)
                $photo->delete();
        }

        return redirect(route('album'));
    }
}
