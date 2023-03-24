<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class InvitationController extends Controller
{
    public function get(Request $request){
        if (!$request->session()->has('ulid')) {
            return abort(403);
        }

        $requested_ulid = $request->session()->get('ulid');
        if (!isset($requested_ulid)){
            return abort(403);
        }

        $requested_user = User::find($requested_ulid);
        if(!$requested_user->is_admin){
            return abort(403);
        }

        return view('admin/invitation', [
            'invitation_link' => URL::temporarySignedRoute(
                'signup.get', now()->addMinutes(30)
            )
        ]
        );
    }
}
