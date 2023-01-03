<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            'Adress' => null,
        ];

        // Let's checkout payment page is it working
        return response()->json([
            'status' => 'true',
            'data' => $response,
        ]);
    }

    public function OrderStatus(Request $request)
    {
        $getitem = OrderData::where('order_id',$request['order_id'])->get();
        $paymentstauts = $request->all();
        //check if payment
        $signatureStatus = $this->SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );

        if ($signatureStatus == true) {



            if (!MyOrders::where('Order_Id', $request->rzp_paymentid)->exists()) {
                $addorder = new MyOrders;
                $addorder->User_Id = $request->auth_id;
                $addorder->Item_Id = $request->item_id;
                $addorder->Order_Id = $request->rzp_paymentid;
                $addorder->Status = 'Success';
                $addorder->Save();

                $email = auth()->user()->email;
                $body = [
                    'name' => ucwords(strtolower(auth()->user()->name)),
                    'item_name' => $getitem->Item_Name,
                    'url_a' => route('LoginIndex')
                ];


            }


            $odstatus = 'Active';
            return view('User.OrderStatus', compact('getitem', 'paymentstauts', 'odstatus'));
        } else {

            if (!MyOrders::where('Order_Id', $request->rzp_paymentid)->exists()) {
                $addorder = new MyOrders;
                $addorder->User_Id = $request->auth_id;
                $addorder->Item_Id = $request->item_id;
                $addorder->Order_Id = $request->rzp_paymentid;
                $addorder->Status = 'Failed';
                $addorder->Save();
            }

            $odstatus = 'Failed';
            return view('User.OrderStatus', compact('getitem', 'paymentstauts', 'odstatus'));

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