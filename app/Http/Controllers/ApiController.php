<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function index()
    {
        $this->res = ['status'=>false,'message'=>'Invalid Request.','errors'=>[],'data'=>[],'status_code'=>200];

        $result =DB::table('persons_address_view')->select('*')->get()->toArray();

        if(!empty($result))
        {
            $formattedData = [];
            foreach ($result as $row) {
                $formattedData[] = [
                    'id' => $row->id,
                    'first_name' => $row->first_name,
                    'last_name' => $row->last_name,
                    'email' => $row->email,
                    'address_id' => $row->address_id, // Assuming a property exists
                    'country' => $row->country,
                    'state' => $row->state,
                    'city' => $row->city,
                ];
            }
            $this->res['data']=$result;
            $this->res['message']='Data Retreived!';
        }    

        return response()->json($this->res,$this->res['status_code']);

    }
}
