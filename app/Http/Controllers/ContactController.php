<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Validator;
use Mail;
use App\Models\Mail\ContactUsEmail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contactUsNew = ContactUs::with('user')->where('query_status' , 'N')->paginate(5);
        $contactUsReplied = ContactUs::with('user')->where('query_status' , 'R')->paginate(5);

        if(!$request->has('currentTab'))
        $contactUsReplied->setPath(url("/contact?currentTab=Replied"));

        return view('admin.contact.index', compact('contactUsNew','contactUsReplied'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_reply' => 'required'
        ]);

        if ($validator->fails())
        {
            return response(['status' => false , 'errors'=>$validator->errors()], 200);
        }

        Mail::to($request->user_email)->send(new ContactUsEmail($request->admin_reply));

        if(count(Mail::failures()) == 0){

            // user_id is primary key
            ContactUs::where('id' , $request->user_id)->update([
                'admin_reply' => $request->admin_reply,
                'query_status' => 'R'
            ]);

            return response()->json(['status' => true ,'success' => 'Mail sent successfully.'], 200);
        }

        else{
            return response()->json(['status' => false ,'errors' => 'Mail not sent.'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
