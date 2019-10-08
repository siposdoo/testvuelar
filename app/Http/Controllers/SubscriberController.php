<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use App\Http\Requests;
use App\Http\Resources\Subscriber as SubscriberResource;
use App\Jobs\SendVerificationEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class SubscriberController extends Controller
{
    use Notifiable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if($request->input('filter')>-1)
       {
        $subscribers = Subscriber::where('payment', '=', $request->input('filter'))->orderBy('created_at', 'desc')->paginate(15); 
        return SubscriberResource::collection($subscribers);  
      }
      else
      {
        
        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(15);
        return SubscriberResource::collection($subscribers);  
      }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pretplatnik = $request->isMethod('put') ? Subscriber::findOrFail($request->sub_id) : new Subscriber;
        if (!$request->isMethod('put')) {
            $pretplatnik->sent_citat = 0;
        }

        $pretplatnik->id = $request->input('sub_id');
        $pretplatnik->payment = $request->input('payment');
        $pretplatnik->email = $request->input('email');
        $pretplatnik->email_token=Str::random(60);
        if ($p = Subscriber::where('email', '=', $request->input('email'))->first()) {
            $pretplatnik->id=$p->id;
            if ($pretplatnik->save()) {
                $pretplatnik->updated = true;
                return new SubscriberResource($pretplatnik);
            }
        } else {
            if ($pretplatnik->save()) {
                dispatch(new SendVerificationEmail($pretplatnik)); 

                return new SubscriberResource($pretplatnik);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pretplatnik = Subscriber::findOrFail($id);
        return new  SubscriberResource($pretplatnik);
    }

    /**
     * Display the specified resource by email.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbyemail($email)
    {
        $pretplatnik = Subscriber::where('email', '=', $email)->withTrashed()->first();
        return new  SubscriberResource($pretplatnik);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pretplatnik =   Subscriber::findOrFail($id);


        if ($pretplatnik->delete()) {
            return new SubscriberResource($pretplatnik);
        }
    }
}
