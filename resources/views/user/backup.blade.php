<script>
    $(document).ready(function(e) {
        //-----------------------currency------------------------------
        function currency() {
            var status = true;
            try {
                $('.currency').each(function() {
                    var value = $(this).text();
                    // Loại bỏ các ký tự không phải số
                    var numericValue = parseFloat(value.replace(/[^0-9]/g, ''));
                    // Định dạng số theo định dạng tiền tệ
                    var formattedValue = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(numericValue);
                    // Cập nhật giá trị định dạng vào phần tử
                    $(this).text(formattedValue);
                });
            } catch (e) {
                status = false;
            }
            return status;
        }
        currency();

        // Biến lưu trữ các biến thể của sản phẩm
        var variants = @json($array_variants) || [];
        var attribute_value_ids = [];
        var current_item_id = 0;
        var product_id = $('.product_id').val();
        var total_attributes = $('.total_attributes').val();
        var total_stock = $("#update-stock").text();
        var sale_price = $("#sale-price").text();
        var regular_price = $("#regular-price").text();
        var percent_discount = $("#percent-discount").text();
        var variant_selected = false;
        var variant_id = null;
        var get_stock_variant_clicked = null;
        $('#sale-price, #regular-price, #percent-discount').hide();
        // Khi người dùng chọn một giá trị thuộc tính
        $(".attribute_item").click(function(e) {
            if ($(this).hasClass('able')) {
                var array_allow_click_attribute_values_id = [];
                var attributeValueId = $(this).data("id");
                // Kiểm tra nếu đang ở trạng thái active (được chọn)
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active'); // Xóa class active khi bỏ chọn
                    // Xoá id của thuộc tính được bỏ chọn khỏi mảng
                    attribute_value_ids = attribute_value_ids.filter(function(item) {
                        return item != attributeValueId;
                    });
                    // Nếu không còn thuộc tính nào được chọn, reset variant_selected
                    if (attribute_value_ids.length == 0 || variant_selected == true) {
                        variant_selected = false;
                        variant_id = null;
                    }
                    // Ẩn nút reset khi không còn thuộc tính nào được chọn
                    if (attribute_value_ids.length == 0) {
                        $('.reset_selected').hide();
                    }
                    // Cập nhật lại giá và số lượng sản phẩm
                    $('#sale-price, #regular-price, #percent-discount').hide();
                    $('#update-stock').text(total_stock);
                    get_stock_variant_clicked = null;
                    console.log(get_stock_variant_clicked);
                    //kiểm tra từng phần tử
                    $('.attribute_item').each(function() {
                        if (!$(this).hasClass('able')) {
                            $(this).removeClass('disabled');
                            $(this).addClass('able');
                        }
                    });
                    // Lọc các biến thể hợp lệ
                    variants.forEach(function(variant) {
                        var isSubset = attribute_value_ids.every(function(item) {
                            return variant['attribute_values'].includes(item);
                        });
                        if (isSubset && variant['stock'] > 0) {
                            variant['attribute_values'].forEach(function(
                                item_variant_attribute_value_id) {
                                if (!array_allow_click_attribute_values_id.includes(
                                        item_variant_attribute_value_id)) {
                                    array_allow_click_attribute_values_id.push(
                                        item_variant_attribute_value_id);
                                }
                            });
                        }
                    });
                    // Disable các item không hợp lệ
                    $('.able').each(function() {
                        var id_item_btn_click = $(this).data('id');
                        if (!array_allow_click_attribute_values_id.includes(id_item_btn_click)) {
                            $(this).removeClass('able active').addClass('disabled');
                        }
                    });
                } else {
                    var current_item = $(this).closest('.attribute_group').find('.attribute_item.active');
                    if (current_item.length && current_item.hasClass('active')) {
                        current_item.removeClass('active');
                        var current_item_id = current_item.data('id');

                        // Loại bỏ current_item_id khỏi attribute_value_ids
                        attribute_value_ids = attribute_value_ids.filter(item => item !== current_item_id);
                    }
                    // Thêm thuộc tính mới vào mảng
                    $(this).addClass('active');
                    attribute_value_ids.push(attributeValueId); // Thêm id thuộc tính vừa chọn vào mảng
                    // Hiển thị nút reset khi có thuộc tính được chọn
                    if (attribute_value_ids.length > 0) {
                        $('.reset_selected').show();
                    }
                    //Xử lý lọc thuộc tính khi người dùng chọn
                    variants.forEach(function(variant) {
                        var isSubset = attribute_value_ids.every(function(item) {
                            return variant['attribute_values'].includes(item);
                        });
                        if (isSubset && variant['stock'] > 0) {
                            variant['attribute_values'].forEach(function(
                                item_variant_attribute_value_id) {
                                if (!array_allow_click_attribute_values_id.includes(
                                        item_variant_attribute_value_id)) {
                                    array_allow_click_attribute_values_id.push(
                                        item_variant_attribute_value_id);
                                }
                            });
                        }
                    });
                    //Kiểm tra xem biến thể có liên kết với nhau không
                    function arraysEqualUnordered(arr1, arr2) {
                        if (arr1.length !== arr2.length) return false;
                        let sortedArr1 = arr1.slice().sort();
                        let sortedArr2 = arr2.slice().sort();
                        return sortedArr1.every((value, index) => value === sortedArr2[index]);
                    }
                    variants.some(function(variant) {
                        variant_selected = arraysEqualUnordered(variant['attribute_values'],
                            attribute_value_ids);
                        if (variant_selected) {
                            variant_id = variant['variant_id'];
                            $('#sale-price, #regular-price, #percent-discount').show();
                        }
                        console.log('Trạng thái của variant_selected là: ' + variant_selected);
                        return variant_selected;
                    });
                    // Disable các item không hợp lệ
                    array_allow_click_attribute_values_id.forEach(function(item) {
                        $('.able').each(function() {
                            var id_item_btn_click = $(this).data('id');
                            if (!array_allow_click_attribute_values_id.includes(
                                    id_item_btn_click)) {
                                $(this).removeClass('able active');
                                $(this).addClass('disabled');
                            }
                        });
                    });
                    e.preventDefault();
                    $('.attribute_group').each(function() {
                        attributeValuesId = $(this).data('id');
                        if (attribute_value_ids.includes(attributeValuesId)) {
                            $.ajax({
                                url: "{{ route('userProductDetailFocused') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    attribute_value_ids: attribute_value_ids,
                                    product_id: product_id
                                },
                                success: function(response) {
                                    if (response.status == "success") {
                                        var regular_price = response.data['regular_price'];
                                        var sale_price = response.data['sale_price'];
                                        var stock = response.data['stock'];
                                        var percent_discount = (100 - (sale_price /
                                            regular_price * 100)).toFixed(1);
                                        if (variant_selected) {
                                            if (sale_price && sale_price > 0) {
                                                $('#regular-price').text(regular_price)
                                                    .addClass('regular-price-css')
                                                    .removeClass('regular-price');
                                                $('#sale-price').text(sale_price);
                                                $('#update-stock').text(stock);
                                                $('#percent-discount')
                                                    .text("-" + percent_discount + "%");
                                                console.log(stock);
                                            } else {
                                                $('#regular-price').text(regular_price)
                                                    .addClass('regular-price')
                                                    .removeClass('regular-price-css');
                                                $('#sale-price, #percent-discount').hide();
                                                $('#update-stock').text(stock);
                                            }
                                            get_stock_variant_clicked = stock;
                                            console.log(get_stock_variant_clicked);
                                            currency();
                                        }
                                    } else {
                                        $('#update-stock').text(0);
                                        notification('error', 'Sản phẩm không có sẵn', 'Hết hàng');
                                        console.log('Response status is not success');
                                    }
                                },
                                error: function(xhr) {
                                    alert('Đã xảy ra lỗi trong quá trình xử lý yêu cầu.');
                                }
                            })
                        }
                    });
                }
            }
        });
        //------------------Handle increment and reduce quantity-------------------
        $('.reduce').click(function() {
            if (!variant_selected) {
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
        })
        $('.quantity').on('input', function() {
            if (!variant_selected) {
                $(this).val(1);
                $('.blink-border').addClass('animation-blink-border');
                setTimeout(() => {
                    $('.blink-border').removeClass('animation-blink-border');
                }, 950);
                notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
            } else {
                if (!Number($(this).val())) {
                    $(this).val(1);
                    notification('error', 'Vui lòng nhập số!', 'Lỗi');
                }
            }
        })
        $('.increment').click(function() {
            if (!variant_selected) {
                $('.blink-border').addClass('animation-blink-border');
                setTimeout(() => {
                    $('.blink-border').removeClass('animation-blink-border');
                }, 950);
                notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
            } else {
                if ($('.quantity').val() >= get_stock_variant_clicked) {
                    $('.blink-border-text').addClass('animation-blink-border');
                    setTimeout(() => {
                        $('.blink-border-text').removeClass('animation-blink-border');
                    }, 950);
                    notification('warning', 'Đã đạt đến số lượng tối đa trong kho!', 'Cảnh báo!');
                } else if ($('.quantity').val() >= 10) {
                    notification('warning', 'Mỗi lần chỉ được phép mua tối đa 10 sản phẩm!',
                        'Cảnh báo!');
                } else {
                    $('.quantity').val(function(i, val) {
                        return parseInt(val) + 1;
                    });
                }
            }
        })
        $('.add-to-cart').click(function() {
            if (!variant_selected) {
                $('.blink-border').addClass('animation-blink-border');
                setTimeout(() => {
                    $('.blink-border').removeClass('animation-blink-border');
                }, 950);
                notification('warning', 'Vui lòng chọn sản phẩm!', 'Cảnh báo!');
            } else {
                var quantity = $('.quantity').val();
                const url =
                    "{{ route('addToCart', ['variant_id' => ':variant_id', 'quantity' => ':quantity']) }}"
                    .replace(':variant_id', variant_id)
                    .replace(':quantity', quantity);
                window.location.href = url;
            }
        })

        //------------Xử lý reset selected-----------------------
        if (attribute_value_ids.length == 0) {
            $('.reset_selected').hide();
        }
        $('.reset_selected').click(function() {
            attribute_value_ids = [];
            $('.attribute_item').each(function() {
                if (!$(this).hasClass('able')) {
                    $(this).removeClass('disabled');
                    $(this).addClass('able active');
                }
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });
            $('#update-stock').text(total_stock);
            get_stock_variant_clicked = null;
            $('#sale-price, #regular-price, #percent-discount').hide();
            $('.reset_selected').hide();
            variant_selected = false;
        })

    });
</script>
