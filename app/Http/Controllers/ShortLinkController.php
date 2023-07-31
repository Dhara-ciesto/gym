<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shortLinks = ShortLink::latest()->get();

        return view('shortenLink', compact('shortLinks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if ($request->isMethod('post')) {

               $request->validate([
           'link' => 'required|'
        ]);

        $input['link'] = $request->link;
        $input['code'] = str_random(6);
        // dd($input);
        ShortLink::create($input);
            return redirect('generate-shorten-link')
             ->with('success', 'Shorten Link Generated Successfully!');
            }
        else{

        }

       return view('shortenLink');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenLink($code)
    {

        $find = ShortLink::where('code', $code)->first();
         // dd($find->link);
        return redirect()->to('https://'.$find['link']);
    }
}
