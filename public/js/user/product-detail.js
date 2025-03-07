$(document).ready(function () {
    function currency() {
        try {
            $('.currency').each(function () {
                // Lấy giá trị hiện tại
                const value = $(this).text().trim();
                // Lọc bỏ các ký tự không phải số và dấu phân cách
                const numericValue = parseFloat(value.replace(/[^\d]/g, ''));
                // Kiểm tra giá trị hợp lệ
                if (!isNaN(numericValue)) {
                    // Định dạng giá trị sang VND
                    let formattedValue = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND',
                    }).format(numericValue);
                    formattedValue = formattedValue.replace(/\s?₫/, 'đ');
                    $(this).text(formattedValue);
                }
            });
            return true;
        } catch (error) {
            console.error('Lỗi định dạng tiền tệ:', error);
            return false;
        }
    }
    currency();
    const variants = array_variants;
    let attributeValueIds = [];
    let variantSelected = false;
    let variantId = null;
    let getStockVariantClicked = null;
    const totalStock = $("#update-stock").text();
    const productId = $('.product_id').val();
    $('#sale-price, #regular-price, #percent-discount, .reset_selected').hide()
    //------------- Đặt lại trạng thái khi bấm nút reset --------------
    function resetAttributes() {
        attributeValueIds = [];
        $('.attribute_item').removeClass('active disabled').addClass('able');
        $('#update-stock').text(totalStock);
        $('#sale-price, #regular-price, #percent-discount').hide();
        $('#price, #regular, #discount').show();
        $('.reset_selected').hide();
        variantSelected = false;
        getStockVariantClicked = null;
    }
    //------------- Cập nhật giá và số lượng --------------
    function updatePrices(response) {
        const {
            sale_price,
            regular_price,
            real_stock
        } = response.data;
        const percentDiscount = (100 - (sale_price / regular_price * 100)).toFixed(1);

        getStockVariantClicked = real_stock; // Lưu giá trị real_stock

        if (variantSelected) {
            if (sale_price > 0) {
                $('#regular-price').text(regular_price);
                $('#sale-price').text(sale_price);
                $('#update-stock').text(real_stock);
                $('#percent-discount').text(`-${percentDiscount}%`);
            } else {
                $('#sale-price').text(regular_price);
                $('#regular-price').text(regular_price);
                $('#percent-discount').text(`Hot!`);
                $('#update-stock').text(real_stock);
            }
            currency();
        }
    }
    //-------- Lấy thông tin biến thể dựa trên thuộc tính đã chọn ----------
    function handleAjax(attributeValueIds) {
        $.ajax({
            url: routeUserProductDetailFocused,
            type: "POST",
            data: {
                _token: csrf,
                attribute_value_ids: attributeValueIds,
                product_id: productId,
            },
            success(response) {
                if (response.status === "success") {
                    updatePrices(response);
                } else {
                    $('#update-stock').text(0);
                    notification('error', 'Sản phẩm không có sẵn', 'Hết hàng');
                }
            },
            error(xhr) {
                console.error('AJAX error:', xhr.responseText);
                alert('Đã xảy ra lỗi trong quá trình xử lý yêu cầu.');
            },
        });
    }

    //----------Khi 1 thuộc tính được chọn-----------------
    $(".attribute_item").click(function () {
        if (!$(this).hasClass('able')) return;
        // Lấy và cập nhật danh sách các giá trị thuộc tính đã chọn
        const attributeValueId = $(this).data("id");
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            attributeValueIds = attributeValueIds.filter((id) => id !== attributeValueId);
        } else {
            $(this).addClass('active');
            attributeValueIds.push(attributeValueId);
        }
        if (attributeValueIds.length > 0) {
            $('.reset_selected').show();
        } else {
            $('.reset_selected').hide();
        }
        // Xác định các thuộc tính khác có thể chọn được
        const arrayAllowClickAttributeValueIds = [];
        variants.forEach((variant) => {
            const isSubset = attributeValueIds.every((id) => variant.attribute_values.includes(id));
            if (isSubset && variant.stock > 0) {
                variant.attribute_values.forEach((id) => {
                    if (!arrayAllowClickAttributeValueIds.includes(id)) {
                        arrayAllowClickAttributeValueIds.push(id);
                    }
                });
            }
        });
        // Cập nhật trạng thái các thuộc tính trên giao diện
        $('.attribute_item').each(function () {
            const id = $(this).data('id');
            if (arrayAllowClickAttributeValueIds.includes(id)) {
                $(this).removeClass('disabled').addClass('able');
            } else {
                $(this).removeClass('able active').addClass('disabled');
            }
        });
        // Tìm biến thể phù hợp với thuộc tính đã chọn
        const variant = variants.find((v) =>
            v.attribute_values.length === attributeValueIds.length &&
            v.attribute_values.every((id) => attributeValueIds.includes(id))
        );
        // Cập nhật trạng thái sản phẩm và hiển thị giá
        if (variant) {
            variantSelected = true;
            variantId = variant.variant_id;
            getStockVariantClicked = variant.stock;
            handleAjax(attributeValueIds);
            $('#price, #regular, #discount').hide();
            $('#sale-price, #regular-price, #percent-discount').show();
        } else {
            variantSelected = false;
            variantId = null;
            $('#update-stock').text(totalStock);
            $('#price, #regular, #discount').show();
            $('#sale-price, #regular-price, #percent-discount').hide();
        }
    });

    //----------------------- Reset Button ----------------------
    $('.reset_selected').click(resetAttributes);

    //----------------------- Quantity Handlers ----------------------
    $('.reduce').click(function () {
        if (!variantSelected) {
            $('.blink-border').addClass('animation-blink-border');
            setTimeout(() => {
                $('.blink-border').removeClass('animation-blink-border');
            }, 950);
            notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
        } else {
            if ($('.quantity').val() <= 1) {
                $('.quantity').val(1);
            } else {
                $('.quantity').val($('.quantity').val() - 1);
            }
        }
    });

    $('.increment').click(function () {
        if (!variantSelected) {
            $('.blink-border').addClass('animation-blink-border');
            setTimeout(() => {
                $('.blink-border').removeClass('animation-blink-border');
            }, 950);
            notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
        } else {
            if ($('.quantity').val() >= getStockVariantClicked) {
                $('.blink-border-text').addClass('animation-blink-border');
                setTimeout(() => {
                    $('.blink-border-text').removeClass('animation-blink-border');
                }, 950);
                notification('warning', 'Đã đạt đến số lượng tối đa trong kho!', 'Cảnh báo!');
            }else {
                $('.quantity').val(function (i, val) {
                    return parseInt(val) + 1;
                });
            }
        }
    });

    $('.quantity').on('input', function () {
        let currentVal = parseInt($(this).val());
        let maxStock = getStockVariantClicked;
        if (!variantSelected) {
            $('.blink-border').addClass('animation-blink-border');
            setTimeout(() => {
                $('.blink-border').removeClass('animation-blink-border');
            }, 950);
            notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
            $(this).val(1);
        } else {
            if (isNaN(currentVal) || currentVal < 1) {
                $(this).val(1);
                notification('warning', 'Số lượng không hợp lệ!', 'Cảnh báo!');
            } else if (currentVal > maxStock) {
                $(this).val(maxStock);
                notification('warning', `Không được vượt quá số lượng tối đa trong kho: ${maxStock}`, 'Cảnh báo!');
            }
        }
    });

    $('.add-to-cart').click(function () {
        if (!variantSelected) {
            $('.blink-border').addClass('animation-blink-border');
            setTimeout(() => {
                $('.blink-border').removeClass('animation-blink-border');
            }, 950);
            notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
        } else {
            const quantity = $('.quantity').val();
            $.ajax({
                url: routeAddToCart,
                method: 'POST',
                data: {
                    _token: csrf,
                    variant_id: variantId,
                    quantity: quantity
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response.cartCount);
                        // Cập nhật số lượng giỏ hàng trong header
                        $('.shoping-prize .cart-count').text(response.cartCount);
                        notification('success', response.message, 'Thành công!');
                        //Thông báo hết hàng
                    } else if (response.status === 'warning') {
                        notification('warning', response.message, 'Cảnh báo!');
                        //Thông báo chưa đăng nhập
                    } else if (response.status === 'unauthenticated') {
                        notification('warning', response.message, 'Cảnh báo!');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    reject();
                }
            });
        }
    });
    //Xử lý đặt hàng
    $('#buy_now').on('click', function (e) {
        if (!variantSelected) {
            $('.blink-border').addClass('animation-blink-border');
            setTimeout(() => {
                $('.blink-border').removeClass('animation-blink-border');
            }, 950);
            notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
        } else {
            const quantity = $('.quantity').val();
            $('#input_post_data_to_check_out').val(variantId);
            $('#quantity').val(quantity);
            $('#is_cart').val(false);
            $('#form_post_data_to_check_out').submit();
        }
    })
})
