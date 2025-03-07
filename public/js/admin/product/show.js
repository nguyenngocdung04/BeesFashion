$(document).ready(function () {
    //Hiển thị số sao
    const productStar = $('#productStarRating').text();
    $("#productRate").rateYo({
        rating: productStar,
        fullStar: false,
        precision: 1,
        starWidth: "25px",
        readOnly: true,
        ratedFill: "#ffff00",
        // onSet: function (rating, rateYoInstance) {
        //     alert("Đánh giá của bạn là: " + rating);
        // },
    });
});
//-----------------------------------------------Handle copy sku----------------------------------------------
$('.copySku').click(function () {
    var content = $(this).find('.contentSku').text();
    navigator.clipboard.writeText(content)
        .then(() => {
            notification('success', "Đã sao chép: " + content, 'Copy successfully!', '1200');
        })
        .catch(err => {
            notification('error', "Lỗi sao chép: " + content, 'Error!', '1200');
        });
})

var productVariantId = -1;
$('.btnImportingGoods').click(function () {
    productVariantId = $(this).closest('tr').find('.productVariantId').text();
})

$(document).on('click', '#doneImportingGoods', function () {
    var validityCheck = true;
    var quantity = $('.quantityImportPrice').val();
    var importPrice = $('.importPrice').val();
    if (!quantity) {
        notification('error', 'Vui lòng nhập quantity!', 'Thiếu thông tin!', '3000');
        validityCheck = false;
    } else {
        if (!Number.isInteger(Number(quantity))) {
            notification('error', 'Quantity phải là số nguyên!', 'Sai kiểu dữ liệu!', '3000');
            validityCheck = false;
        }
    }
    if (!importPrice) {
        notification('error', 'Vui lòng nhập import price!', 'Thiếu thông tin!', '3000');
        validityCheck = false;
    } else {
        if (!Number(importPrice)) {
            notification('error', 'Import price phải là số!', 'Sai kiểu dữ liệu!', '3000');
            validityCheck = false;
        }
    }
    if (validityCheck && productVariantId != -1) {
        $.ajax({
            url: routeImportingGoods,
            method: "POST",
            data: {
                _token: csrf,
                product_variant_id: productVariantId,
                quantity: quantity,
                import_price: importPrice
            },
            success: function (response) {
                if (response.status == 200) {
                    notification('success', response.message, 'Importing gooods successfully!', '1000');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    notification('error', response.message, 'Error!', '1000');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                notification('error', 'Something went wrong!', 'Error!', '3000');
            }
        })
    }
})