<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psy\Util\Json;
use Razorpay\Api\Api;
use App\Models\OrderData;

class RazorPayController extends Controller
{
    private $razorpayId = 'rzp_test_m1OAr8kH5ccuZ2'; //test
    private $razorpayKey = '5xo9kj0NuEDxjDmY55a7O4mW';


    public function BuyNow(Request $request)
    {
        $request->validate(['order_id' => 'required|exists:order_data,order_id']);
        $getitem = OrderData::where('order_id', $request['order_id'])->first();

        $receiptId = Str::random(20);

        // Create an object of razorpay
        $api = new Api($this->razorpayId, $this->razorpayKey);


        // In razorpay you have to convert rupees into paise we multiply by 100
        // Currency will be INR
        // Creating order
        $order = $api->order->create(
            array(
                'receipt' => $receiptId,
                'amount' => $getitem->amount * 100,
                'currency' => 'INR'
            )
        );

        $response = [
            'product_order_id' => $getitem->order_id,
            'orderId' => $order['id'],
            'razorpayId' => $this->razorpayId,
            'amount' => $getitem->amount * 100,
            'currency' => 'INR',
            'name' => $request->user()->name,
            'mobile_number' => auth()->user()->phone,
            'email' => $request->user()->email,
            'Address' => null,
        ];

        // Let's checkout payment page is it working
        return response()->json([
            'status' => 'true',
            'data' => $response,
        ]);
    }

    // public function Callback(Request $request)
// {
//         return $request->all();
// }




    public function Callback(Request $request)
    {
        $api = new Api($this->razorpayId, $this->razorpayKey);
        $request->validate([
            'rzp_signature' => 'required',
            'rzp_paymentid' => 'required',
            'rzp_orderid' => 'required',
            'product_order_id' => 'required|exists:order_data,order_id',
        ]);
        $paymentstauts = $request->all();
        //check if payment
        $signatureStatus = $this->SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );
       
        if ($signatureStatus == true) {
           // $data = $api->order->fetch($request->rzp_orderid);
           
                OrderData::where('order_id', $request->product_order_id)->update([
                    'status' => 'placed',
                    'payment_id' => $request->rzp_paymentid,
                    
                ]);
                return response()->json([
                    'status' => 'true',
                    'message' => 'Payment SuccessFully',
                ]);
            
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Payment Failed',
            ]);


        }
    }
    // In this function we return boolean if signature is correct
    private function SignatureVerify($_signature, $_paymentId, $_orderId)
    {
        try {
            // Create an object of razorpay class
            $api = new Api($this->razorpayId, $this->razorpayKey);
            $attributes = array('razorpay_signature' => $_signature, 'razorpay_payment_id' => $_paymentId, 'razorpay_order_id' => $_orderId);
            $order = $api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            // If Signature is not correct its give a excetption so we use try catch
            return false;
        }
    }
}