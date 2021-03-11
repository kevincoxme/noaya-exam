<?php

namespace App\Http\Controllers\Api\v1;

use App\Company;
use App\Http\Controllers\Controller;
use App\Mail\UsersRegistered;
use App\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Ui\Presets\React;

class CompanyController extends Controller
{
    public function all()
    {
        $companies = Company::orderByDesc('id')->get();
        return response()->json(['response' => $companies]);
    }

    public function store(Request $request)
    {
        try {
            $path = null;

            if($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $destination = 'logo';
                $path = Storage::disk('public')->put($destination, $file);
            }

            if(empty($request->id))
            {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'logo' => $path
                ];

                $result = Company::create($data);
            }
            else
            {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];

                if(!empty($path))
                {
                    $data['logo'] = $path;
                }

                Company::where('id', $request->id)->update($data);
                $result = Company::find($request->id);
            }

            return response()->json(['response' => $result]);

        } catch (\Exception $e) {
            return response()->json(['response' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $result = Company::find($id);

            if($result)
            {
                if(Storage::disk('public')->exists($result->logo))
                {
                    Storage::disk('public')->delete($result->logo);
                }

                User::where('company_id', $result->id)->delete();
                $result->delete();
            }

            return response()->json(['response' => $result]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function storeEmployee(Request $request)
    {
        try {
            $password = substr(md5(mt_rand()), 0, 7);
            if(empty($request->id))
            {
                $data = [
                    'email' => $request->email,
                    'raw_password' => $password,
                    'password' => Hash::make($password),
                    'name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'is_active' => $request->active,
                    'company_id' => $request->company_id,
                    'phone'=> $request->phone,
                ];

                $result = User::create($data);
                Mail::to($result->email)->send(new UsersRegistered($result));
            }
            else
            {
                $data = [
                    'email' => $request->email,
                    'name' => $request->first_name,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'is_active' => $request->active,
                    'phone'=> $request->phone,
                ];

                User::where('id', $request->id)->update($data);
                $result = User::find($request->id);
            }

            return response()->json(['response' => $result]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function allEmployee($id)
    {
        try {
            $company_id = $id;
            $result = User::where('company_id', $company_id)->orderByDesc('id')->get();

            return response()->json(['response' => $result]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function deleteEmployee($id)
    {
        try {
            $result = User::find($id);

            if($result)
            {
                $result->delete();
            }

            return response()->json(['response' => $result]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
