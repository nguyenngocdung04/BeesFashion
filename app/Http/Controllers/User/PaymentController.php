<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Status;
use App\Models\Status_order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function vnpay_payment(Request $request)
    {
        $order_id = $request->input('order_id');
        $amount = $request->input('amount');

        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TmnCode = config('vnpay.vnp_TmnCode'); //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_Returnurl = route('checkout.vnpay_return');
        $vnp_apiUrl = config('vnpay.vnp_apiUrl');
        $apiUrl = config('vnpay.apiUrl');
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = $order_id; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $amount; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = null; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }
    public function vnpay_return(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');

        $payment_data = [
            'order_id' => $request->input('vnp_TxnRef'),
            'user_id' => Auth::user()->id,
            'amount' => $request->input('vnp_Amount') / 100,
            'note' => $request->input('vnp_OrderInfo'),
            'payment_method' => "vnpay",
            'response_code' => $vnp_ResponseCode,
            'bank_code' => $request->input('vnp_BankCode'),
            'transaction_code' => $request->input('vnp_TransactionNo'),
            'pay_type' => $request->input('vnp_CardType'),
            'pay_date' => Carbon::createFromFormat('YmdHis', $request->input('vnp_PayDate')),
            'status' => ($vnp_ResponseCode === '00' && $vnp_TransactionStatus === '00') ? 'success' : 'failed'
        ];

        Payment::create($payment_data);

        if ($payment_data['status'] == 'success') {
            $get_order_statuses = Status_order::with('status')->where('order_id', $request->input('vnp_TxnRef'))->get();
            if ($get_order_statuses) {
                $status_finded_status_processing = false;
                foreach ($get_order_statuses as $order_status) {
                    if ($order_status->status->name == "Processing") {
                        $status_finded_status_processing = true;
                        $get_status_pending = Status::where('name', "Pending")->first();
                        if ($get_status_pending) {
                            $check_status_pending = Status_order::where('status_id', $get_status_pending->id)->where('order_id', $request->input('vnp_TxnRef'))->first();
                            if (!$check_status_pending) {
                                Status_order::create([
                                    'status_id' => $get_status_pending->id,
                                    'order_id' => $request->input('vnp_TxnRef')
                                ]);
                            }
                        } else {
                            $new_status_pending = Status::create([
                                'name' => "Pending"
                            ]);
                            Status_order::create([
                                'status_id' => $new_status_pending->id,
                                'order_id' => $request->input('vnp_TxnRef')
                            ]);
                        }
                    }
                }
                if (!$status_finded_status_processing) {
                    $get_status_processing = Status::where('name', "Processing")->first();
                    if ($get_status_processing) {
                        Status_order::create([
                            'status_id' => $get_status_processing->id,
                            'order_id' => $request->input('vnp_TxnRef')
                        ]);
                    } else {
                        $new_status_processing = Status::create([
                            'name' => "Processing"
                        ]);
                        Status_order::create([
                            'status_id' => $new_status_processing->id,
                            'order_id' => $request->input('vnp_TxnRef')
                        ]);
                    }
                    $get_status_pending = Status::where('name', "Pending")->first();
                    if ($get_status_pending) {
                        $check_status_pending = Status_order::where('status_id', $get_status_pending->id)->where('order_id', $request->input('vnp_TxnRef'))->first();
                        if (!$check_status_pending) {
                            Status_order::create([
                                'status_id' => $get_status_pending->id,
                                'order_id' => $request->input('vnp_TxnRef')
                            ]);
                        }
                    } else {
                        $new_status_pending = Status::create([
                            'name' => "Pending"
                        ]);
                        Status_order::create([
                            'status_id' => $new_status_pending->id,
                            'order_id' => $request->input('vnp_TxnRef')
                        ]);
                    }
                }
            } else {
                $get_status_processing = Status::where('name', "Processing")->first();
                if ($get_status_processing) {
                    Status_order::create([
                        'status_id' => $get_status_processing->id,
                        'order_id' => $request->input('vnp_TxnRef')
                    ]);
                } else {
                    $new_status_processing = Status::create([
                        'name' => "Processing"
                    ]);
                    Status_order::create([
                        'status_id' => $new_status_processing->id,
                        'order_id' => $request->input('vnp_TxnRef')
                    ]);
                }
                $get_status_pending = Status::where('name', "Pending")->first();
                if ($get_status_pending) {
                    $check_status_pending = Status_order::where('status_id', $get_status_pending->id)->where('order_id', $request->input('vnp_TxnRef'))->first();
                    if (!$check_status_pending) {
                        Status_order::create([
                            'status_id' => $get_status_pending->id,
                            'order_id' => $request->input('vnp_TxnRef')
                        ]);
                    }
                } else {
                    $new_status_pending = Status::create([
                        'name' => "Pending"
                    ]);
                    Status_order::create([
                        'status_id' => $new_status_pending->id,
                        'order_id' => $request->input('vnp_TxnRef')
                    ]);
                }
            }
            return redirect()->route('order_success', ['id' => $request->input('vnp_TxnRef')]);
        } else {
            return redirect()->route('order_failed', ['id' => $request->input('vnp_TxnRef')]);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = intval($request->input('amount'));
        $orderId = $request->input('order_id') . "_" . time();
        $redirectUrl = route('checkout.momo_return');
        $ipnUrl = route('checkout.momo_return');
        $extraData = "";

        $requestId = time() . "";
        $requestType = "captureWallet";
        // $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        if ($jsonResult['payUrl']) {
            header('Location: ' . $jsonResult['payUrl']);
        } else {
            echo "Vui lòng tải lại trang!";
        }
        die();
    }
    public function momo_return(Request $request)
    {
        $resultCode = $request->input('resultCode');
        $order_id = (int) explode('_', $request->input('orderId'))[0];
        $payment_data = [
            'order_id' => $order_id,
            'user_id' => Auth::user()->id,
            'amount' => $request->input('amount'),
            'note' => $request->input('orderInfo'),
            'payment_method' => "momo",
            'response_code' => $resultCode,
            'bank_code' => $request->input('payType'),
            'transaction_code' => $request->input('transId'),
            'pay_type' => $request->input('orderType'),
            'request_id' => $request->input('requestId'),
            'partner_code' => $request->input('partnerCode'),
            'pay_date' => Carbon::createFromTimestampMs($request->input('responseTime')),
            'status' => ($resultCode == '0') ? 'success' : 'failed'
        ];

        $new_payment = Payment::create($payment_data);

        if ($payment_data['status'] == 'success') {
            $get_order_by_id = Order::find($order_id);
            if ($get_order_by_id) {
                $get_order_by_id->payment_id = $new_payment->id;
                $get_order_by_id->save();
            } else {
                return redirect()->route('order_failed', ['id' => $order_id]);
            }
            $get_order_statuses = Status_order::with('status')->where('order_id', $order_id)->get();
            if ($get_order_statuses) {
                $status_finded_status_processing = false;
                foreach ($get_order_statuses as $order_status) {
                    if ($order_status->status->name == "Processing") {
                        $status_finded_status_processing = true;
                        $get_status_pending = Status::where('name', "Pending")->first();
                        if ($get_status_pending) {
                            $check_status_pending = Status_order::where('status_id', $get_status_pending->id)->where('order_id', $order_id)->first();
                            if (!$check_status_pending) {
                                Status_order::create([
                                    'status_id' => $get_status_pending->id,
                                    'order_id' => $order_id
                                ]);
                            }
                        } else {
                            $new_status_pending = Status::create([
                                'name' => "Pending"
                            ]);
                            Status_order::create([
                                'status_id' => $new_status_pending->id,
                                'order_id' => $order_id
                            ]);
                        }
                    }
                }
                if (!$status_finded_status_processing) {
                    $get_status_processing = Status::where('name', "Processing")->first();
                    if ($get_status_processing) {
                        Status_order::create([
                            'status_id' => $get_status_processing->id,
                            'order_id' => $order_id
                        ]);
                    } else {
                        $new_status_processing = Status::create([
                            'name' => "Processing"
                        ]);
                        Status_order::create([
                            'status_id' => $new_status_processing->id,
                            'order_id' => $order_id
                        ]);
                    }
                    $get_status_pending = Status::where('name', "Pending")->first();
                    if ($get_status_pending) {
                        $check_status_pending = Status_order::where('status_id', $get_status_pending->id)->where('order_id', $order_id)->first();
                        if (!$check_status_pending) {
                            Status_order::create([
                                'status_id' => $get_status_pending->id,
                                'order_id' => $order_id
                            ]);
                        }
                    } else {
                        $new_status_pending = Status::create([
                            'name' => "Pending"
                        ]);
                        Status_order::create([
                            'status_id' => $new_status_pending->id,
                            'order_id' => $order_id
                        ]);
                    }
                }
            } else {
                $get_status_processing = Status::where('name', "Processing")->first();
                if ($get_status_processing) {
                    Status_order::create([
                        'status_id' => $get_status_processing->id,
                        'order_id' => $order_id
                    ]);
                } else {
                    $new_status_processing = Status::create([
                        'name' => "Processing"
                    ]);
                    Status_order::create([
                        'status_id' => $new_status_processing->id,
                        'order_id' => $order_id
                    ]);
                }
                $get_status_pending = Status::where('name', "Pending")->first();
                if ($get_status_pending) {
                    $check_status_pending = Status_order::where('status_id', $get_status_pending->id)->where('order_id', $order_id)->first();
                    if (!$check_status_pending) {
                        Status_order::create([
                            'status_id' => $get_status_pending->id,
                            'order_id' => $order_id
                        ]);
                    }
                } else {
                    $new_status_pending = Status::create([
                        'name' => "Pending"
                    ]);
                    Status_order::create([
                        'status_id' => $new_status_pending->id,
                        'order_id' => $order_id
                    ]);
                }
            }
            return redirect()->route('order_success', ['id' => $order_id]);
        } else {
            return redirect()->route('order_failed', ['id' => $order_id]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
