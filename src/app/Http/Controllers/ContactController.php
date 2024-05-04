<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function index(Request $request)
    {
        $categories = Category::all();

        
        return view('index',compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {

        $validatedData = $request->validated();

        $contact= [
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'gender' => $request->input('gender'),
        'email' => $request->input('email'),
        'tell1' =>  $request->input('tell1'),
        'tell2' =>  $request->input('tell2'),
        'tell3' =>  $request->input('tell3'),
        'address' => $request->input('address'),
        'building' => $request->input('building'),
        'category_id' => $request->input('category_id'),
        'detail' => $request->input('detail'),
        ];
            
        $categories = Category::all();
        $request->session()->put('contact', $contact);

        
        return view('confirm',compact( 'categories','contact'));
    }

        public function edit(Request $request)
    {
        $contact = $request->session()->get('contact');
        $request->session()->put('contact', $contact);

        return redirect()->route('contacts.index')->with('contact', $contact);
    }


    public function submit(Request $request){

        if ($request->input('submit_action') === 'submit') {
        return $this->store($request);
        } elseif ($request->input('submit_action') === 'edit') {
        return $this->edit($request);
        }
    }

    public function store(Request $request)
    {
        $tell = $request->input('tell');


        $contact = [
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'gender' => $request->input('gender'),
        'email' => $request->input('email'),
        'address' => $request->input('address'),
        'category_id' => $request->input('selected_category_id'),
        'building' => $request->input('building'),
        'detail' => $request->input('detail'),
        'tell' => $tell,
        ];
        
        
        Contact::create($contact);

        $request->session()->forget('contact');
        
        return redirect()->route('thanks');
    }

    public function thanks()
    {
        $url = route('contacts.index');
        return view('thanks', compact('url'));
    }
}