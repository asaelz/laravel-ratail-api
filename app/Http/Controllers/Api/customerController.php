<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class customerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        if ($customers-> isEmpty()) {
            $data = [
                'message' => 'No se encontraron registros',
                'status' => 200
            ];
            return response() -> json($data, 404);
        }

        $data = [
            'customers' => $customers,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function saveCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'register'=> 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $customer = Customer::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'register'=> $request->register
        ]);

        if (!$customer){
            $data = [
                'message' => 'Error al crear cliente',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'customer' => $customer,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function getCustomer($id)
    {
        $customer = Customer::find($id);

        if (!$customer)
        {
            $data = [
                'message' => "Cliente no encontrado",
                'status' => 404
            ];
    
            return response()->json($data, 404);
        }

        $data = [
            'customer' => $customer,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::find($id);

        if (!$customer)
        {
            $data = [
                'message' => "Cliente no encontrado",
                'status' => 404
            ];
    
            return response()->json($data, 404);
        }

        $customer -> delete();
        $data = [
            'message' => "Cliente eliminado",
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer)
        {
            $data = [
                'message' => "Cliente no encontrado",
                'status' => 404
            ];
    
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'register'=> 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $customer->fullname = $request->fullname;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->register = $request->register;

        $customer->save();
        $data = [
            'message' => 'Cliente actualizado',
            'customer' => $customer,
            'status' => 200
        ];

        return response()->json($data, 200);

    }
}
