<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            if($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $destination = 'logo';
                $path = Storage::disk('public')->put($destination, $file);

                $company = Company::where('id', $user->company_id)->update(['logo' => $path]);
                if($company)
                {
                    session()->flash('status', 'Successfully updated');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            session()->flash('status', $e->getMessage());
            return redirect()->back();
        }
    }
}
