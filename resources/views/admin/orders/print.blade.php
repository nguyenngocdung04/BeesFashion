<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Phiếu Hóa Đơn</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('theme/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('theme/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Notification library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Slimselect -->
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">

    <!-- RateYo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        p,
        table {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .invoice-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .barcode {
            text-align: center;
            /* Căn giữa nội dung */
            display: inline-block;
            /* Đảm bảo mã vạch giữ nguyên kích thước */
            width: 100%;
            /* Chiếm toàn bộ chiều rộng */
        }

        .barcode img {
            width: auto;
            max-width: 300px;
            /* Hoặc bất kỳ giới hạn cụ thể nào */
            height: auto;
        }


        .customer-info,
        .order-info {
            margin-bottom: 20px;
        }

        h3 {
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        p {
            margin: 5px 0;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .product-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .cod {
            font-size: 50px;
            font-weight: bold;
        }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 4px;
        }

        .total .amount {
            color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div>
                {!! $barcode !!}
            </div>
            <div>
                #{{ $order->id }}
            </div>

        </div>

        <div class="customer-info">
            <h3>Thông Tin Khách Hàng</h3>
            <p><strong>Tên:</strong> {{ $order->full_name }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone_number }}</p>
        </div>
        <div class="order-info">
            <h3>Thông Tin Đơn Hàng</h3>
            <strong>Phương Thức Thanh Toán:</strong>
            <p class="cod">
                @if ($order->payment_method === 'cod')
                    COD
                @else
                    Thanh toán online
                @endif
            </p>
        </div>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                $subTotal = 0; // Biến để tính tổng tiền hàng
            @endphp
                @foreach ($order->order_details as $detail)
                @php
                    $lineTotal = $detail->quantity * $detail->original_price; // Thành tiền của mỗi sản phẩm
                    $subTotal += $lineTotal; // Cộng dồn vào tổng tiền hàng
                @endphp
                    <tr>
                        <td style="white-space: normal; word-wrap: break-word; max-width: 300px;"><strong>{{ $detail->product_variant->product->name }} {{ $detail->product_variant->SKU }}</strong></td>
                        <td>x{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->original_price, 0, ',', '.') }}</td>
                        <td>{{ number_format($detail->quantity * $detail->original_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total">
            <p style="margin-bottom: 10px;"><strong>Tổng Tiền Hàng:</strong> {{ number_format($subTotal, 0, ',', '.') }}đ</p>
            <p style="margin-bottom: 10px;"><strong>Giảm Giá:</strong> {{ number_format($order->voucher, 0, ',', '.') }}đ</p>
            <p style="margin-bottom: 10px;"><strong>Phí Vận Chuyển:</strong> {{ number_format($order->shipping_voucher, 0, ',', '.') }}đ</p>
            <p style="margin-bottom: 10px;"><strong>Thuế:</strong> {{ number_format($order->tax, 0, ',', '.') }}đ</p>
            <p style="margin-top: 20px; font-size: 20px; color: red;"><strong>Tổng Thanh Toán:</strong> {{ number_format($order->total_payment, 0, ',', '.') }}đ</p>
        </div>
    </div>
</body>

</html>
