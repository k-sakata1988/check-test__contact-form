<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index (){
        $categories = Category::all();
        return view ('index',compact('categories'));
    }
    public function confirm(ContactRequest $request){
        if (!$request->isMethod('post')) {
            return redirect('/');
        }

        $contact = $request->only([
            'first_name','last_name','gender','email','tel1','tel2','tel3','address','building','category_id','detail'
        ]);
        $request->session()->put('contact', $contact);
        return view('confirm', compact('contact'));
    }
    public function store(Request $request){
        $contactData = $request->only([
            'first_name','last_name','gender','email','tel','address','building','category_id','detail'
        ]);
        if(empty($contactData['gender'])){
            return redirect('/')->with('error','性別が選択されていません');
        }

        Contact::create($contactData);
        return view('thanks');
    }
    public function edit(Request $request){
        $contact = $request->session()->get('contact',[]);
        $categories = Category::all();

        return view ('index', compact('contact','categories'));
    }
}
