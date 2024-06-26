<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function index()
    {
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
            $this->res['status']=true;
            $this->res['dataset']=$result;
            $this->res['message']='Data Retreived!';
        }    

        return response()->json($this->res);
    }


    public function invoice_view(){
        $invoiceDetail = DB::table('invoices_status')->paginate(10);
        
        if ($invoiceDetail) {
            $this->res['status']=true;
            $this->res['dataset']=$invoiceDetail;
            $this->res['message']='Data Retreived!';
        }
        
        return response()->json($this->res);
    }

    public function receipt_view(){

        $receiptDetail = DB::table('receipt_details')->paginate(10);
        
        if ($receiptDetail) {
            $this->res['status']=true;
            $this->res['dataset']=$receiptDetail;
            $this->res['message']='Data Retreived!';
        }
        
        return response()->json($this->res);
    }

    public function client_Summary(){
        $clientSummary = DB::select('CALL GetClientSummary()');

        if ($clientSummary) {
            $this->res['status']=true;
            $this->res['dataset']=$clientSummary;
            $this->res['message']='Data Retreived!';
        }
        
        return response()->json($this->res);
    }
}
