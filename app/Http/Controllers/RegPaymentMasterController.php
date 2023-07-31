<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegPaymentMaster;
use Illuminate\Validation\Rule;

class RegPaymentMasterController extends Controller
{
    public function addregpaymenttype(Request $request)
    {

        $method = $request->method();
        if ($request->isMethod('post')) {
            $request->validate([
                'regpaymentname' => 'required|max:255|min:2|unique:regpaymentmaster,regpaymentname',
                'companyname' => 'required|max:255|min:2',
                'copersonname' => 'required|max:255|min:2',
                'contactno' =>   'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'gstno' => 'nullable|max:15|min:2',
                'amount' => 'required|between:1,10'
            ], ['regpaymentname.unique' => 'Type is already taken']);


            $regpayment =     RegPaymentMaster::create([

                'regpaymentname' => $request['regpaymentname'],
                'companyname' => $request['companyname'],
                'copersonname' => $request['copersonname'],
                'contactno' => $request['contactno'],
                'gstno' => $request['gstno'],
                'amount' => $request['amount'],
            ]);

            return redirect('regpaymenttype')->withSuccess('Type Succesfilly Added');
        }

        return view('admin.registration.addregpaymenttype');
    }
    public function regpaymenttype(Request $request)
    {
        $regpaymentype = RegPaymentMaster::where('status', 1)->get()->all();
        return view('admin.registration.regpaymenttype', compact('regpaymentype'));
    }
    public function  editregpaymenttype($id, Request $request)
    {

        $method = $request->method();
        $regpayment = RegPaymentMaster::findOrFail($id);


        if ($request->isMethod('post')) {
            $request->validate(
                [
                    'regpaymentname' => ['required', Rule::unique('regpaymentmaster')->ignore($id, 'regpaymentid')],

                ],
                ['regpaymentname.unique' => 'Reg payment Type is already exists']
            );


            $regpayment->regpaymentname = $request->regpaymentname;
            $regpayment->companyname = $request->companyname;
            $regpayment->copersonname = $request->copersonname;
            $regpayment->contactno = $request->contactno;
            $regpayment->gstno = $request->gstno;
            $regpayment->amount = $request->amount;

            $regpayment->save();

            return redirect('regpaymenttype')->withSuccess('Type Succesfilly Edited');
        }

        return view('admin.registration.editregpayment', compact('regpayment'));
    }
}
