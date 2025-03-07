function formatCurrency(amount) {
    amount = parseFloat(amount);
    if (isNaN(amount)) return "0 VND";
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}
document.addEventListener("DOMContentLoaded", function () {
    $('#total-payment').text("0₫");
    $('#total-discount').text("0₫");
    $('#total-price').text("0₫");
    $('#cart-progress span').text('(0 Sản phẩm)');
    $(document).on('change', '.product_checkbox', function () {
        var selectedAll = true;
        $('.product_checkbox').each(function () {
            if (!$(this).prop('checked')) {
                selectedAll = false;
            }
        })
        if (selectedAll) {
            $('#selectAllCheckbox').prop('checked', true);
        } else {
            $('#selectAllCheckbox').prop('checked', false);
        }
        updateTotalPrice();
        updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
    });

    // Lắng nghe sự thay đổi số lượng của sản phẩm
    $(document).on('input', '.quantity-input', async function () {
        var input = $(this);
        let currentVal = parseInt(input.val());
        var stock_of_variant = parseInt(input.attr('data-stock'));
        var price = parseFloat(input.attr('data-price'));
        var product_variant_id = parseFloat(input.closest('tr').attr('data-variant-id'));
        var cart_id = parseFloat(input.closest('tr').attr('data-cart-id'));
    
        // Kiểm tra nếu số lượng không hợp lệ
        if (isNaN(currentVal) || currentVal < 1) {
            input.val(1);
            notification('warning', 'Số lượng không hợp lệ!', 'Cảnh báo!');
            currentVal = 1;
        } else if (currentVal > stock_of_variant) {
            notification('warning', `Không được vượt quá số lượng tối đa trong kho: ${stock_of_variant}`, 'Cảnh báo!');
            input.val(stock_of_variant);
            currentVal = stock_of_variant;
        }
    
        // Gọi hàm cập nhật số lượng vào database
        try {
            let result = await updateQuantity(product_variant_id, cart_id, currentVal, "input");
            if (result) {
                let totalPrice = currentVal * price;
                input.closest('tr').find('.total-price').attr('data-price', totalPrice);
                input.closest('tr').find('.total-price').text(formatCurrency(totalPrice));
                updateTotalPrice();
                updateCartItemCount(); // Cập nhật số lượng sản phẩm được chọn
            }
        } catch (error) {
            console.error('Lỗi khi cập nhật số lượng:', error);
            notification('error', 'Có lỗi khi cập nhật số lượng!', 'Lỗi!');
        }
    });
    


    $('#selectAllCheckbox').change(function () {
        var isChecked = $(this).prop('checked');
        $('.product_checkbox').prop('checked', isChecked);
        updateTotalPrice();
        updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
    });

    $('.quantity_btn_plus').click(async function () {
        var btn_plus = $(this);
        var quantity = parseFloat(btn_plus.closest('.quantity').find('.quantity-input').val());
        var product_variant_id = parseFloat(btn_plus.closest('tr').attr('data-variant-id'));
        var cart_id = parseFloat(btn_plus.closest('tr').attr('data-cart-id'));
        var stock_of_variant = parseFloat(btn_plus.closest('.quantity').find('.quantity-input').attr('data-stock'));
        var new_quantity = quantity + 1;
        if (new_quantity > stock_of_variant) {
            notification('warning', ' Đã đạt số lượng tối đa!', 'Warning!', '2000');
        } else {
            var result = await updateQuantity(parseFloat(product_variant_id), parseFloat(cart_id), parseFloat(new_quantity), "plus");
            if (result) {
                btn_plus.closest('.quantity').find('.quantity-input').val(new_quantity);
                var price = btn_plus.closest('.quantity').find('.quantity-input').attr('data-price');
                //update total price
                btn_plus.closest('tr').find('.total-price').attr('data-price', new_quantity * price);
                btn_plus.closest('tr').find('.total-price').text(formatCurrency(new_quantity * price));
                updateTotalPrice();
                updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
            }
        }
    })
    $('.quantity_btn_minus').click(async function () {
        var btn_plus = $(this);
        var quantity = parseFloat(btn_plus.closest('.quantity').find('.quantity-input').val());
        var product_variant_id = parseFloat(btn_plus.closest('tr').attr('data-variant-id'));
        var cart_id = parseFloat(btn_plus.closest('tr').attr('data-cart-id'));
        var new_quantity = quantity - 1;
        if (new_quantity < 1) {
            notification('warning', ' Đã đạt số lượng tối thiểu!', 'Warning!', '2000');
        } else {
            var result = await updateQuantity(parseFloat(product_variant_id), parseFloat(cart_id), parseFloat(new_quantity), "minus");
            if (result) {
                btn_plus.closest('.quantity').find('.quantity-input').val(new_quantity);
                var price = btn_plus.closest('.quantity').find('.quantity-input').attr('data-price');
                //update total price
                btn_plus.closest('tr').find('.total-price').attr('data-price', new_quantity * price);
                btn_plus.closest('tr').find('.total-price').text(formatCurrency(new_quantity * price));
                updateTotalPrice();
                updateCartItemCount();  // Cập nhật số lượng sản phẩm được chọn
            }
        }
    })
    //  Khởi tạo giá trị tổng tiền ngay khi tải trang
    function updateTotalPrice() {
        let totalPayment = 0;
        let totalDiscount = 0;
        $('.cart_item').each(function () {
            const checkbox = $(this).find('.product_checkbox');
            if (checkbox.prop('checked')) {
                var regularPrice = parseFloat($(this).attr('data-regular-price'));  // Sử dụng .attr() để lấy giá trị của data attributes
                var salePrice = parseFloat($(this).attr('data-sale-price'));
                const quantity = parseInt($(this).find('.quantity-input').val());  // Lấy số lượng từ phần tử quantity-input trong .cart_item
                const totalItemPrice = regularPrice * quantity;
                const itemDiscount = regularPrice - salePrice;

                if (itemDiscount > 0) {
                    totalPayment += totalItemPrice;
                    totalDiscount += itemDiscount * quantity;
                } else {
                    totalPayment += totalItemPrice;
                }

                $(this).find('#total-price').text(formatCurrency(totalItemPrice));  // Cập nhật tổng giá cho dòng sản phẩm
            } else {
                $(this).find('#total-price').text('0₫');  // Cập nhật giá thành 0₫ nếu không được chọn
            }
        });
        $('#total-payment').text(formatCurrency(totalPayment));
        $('#total-discount').text(formatCurrency(totalDiscount));

        const totalPrice = totalPayment - totalDiscount;
        $('#total-price').text(formatCurrency(totalPrice));  // Cập nhật tổng tiền cuối cùng
    }
    function updateCartItemCount() {
        var selectedItemsCount = $('.product_checkbox:checked').length;  // Đếm số sản phẩm đã chọn
        $('.cart-progress span').text('(' + selectedItemsCount + ' Sản phẩm)');  // Cập nhật số lượng sản phẩm vào giao diện
    }

    $('#check_out').on('click', function () {
        var selected_cart_item = false;
        $('.product_checkbox').each(function () {
            if ($(this).prop('checked')) {
                selected_cart_item = true;
            }
        })

        if (selected_cart_item) {
            var cart_ids = [];
            $('.cart_item').each(function () {
                var product_item = $(this);
                if (product_item.find('.product_checkbox').prop('checked')) {
                    var cart_id = product_item.data('cart-id');
                    cart_ids.push(cart_id);
                }
            })
            if (cart_ids.length > 0) {
                console.log(cart_ids);
                $('#input_post_data_to_check_out').val(cart_ids);
                $('#is_cart').val(true);
                $('#form_post_data_to_check_out').submit();
            }
        } else {
            notification('warning', ' Vui lòng chọn sản phẩm cần thanh toán!', 'Warning!', '2000');
        }
    })
});

//xóa tất cả những sản phẩm trong giỏ hàng
document.getElementById('clearAllButton').addEventListener('click', function (event) {
    event.preventDefault(); // Ngừng gửi form ngay lập tức
    const confirmation = confirm("Bạn chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?");
    if (confirmation) {
        document.getElementById('clearAllForm').submit(); // Nếu xác nhận, gửi form
    }
});
async function updateQuantity(product_variant_id, cart_id, new_quantity, change_type) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeUpdateQuantity,
            method: "POST",
            data: {
                _token: csrf,
                new_quantity: new_quantity,
                product_variant_id: product_variant_id,
                cart_id: cart_id,
                change_type: change_type
            },
            success: function (response) {
                if (response.status == 200) {
                    resolve(true);
                } else {
                    notification('warning', response.message, 'Warning!', 2000);
                    resolve(false);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Unable to get catalog data!', 'Error');
                reject();
            }
        });
    })
}

$(document).ready(function () {
    const variantBox = document.getElementById("variantBox");
    const backButton = document.getElementById("backButton");
    const confirmButton = document.getElementById("confirmButton");

    let selectedVariantId = null; // ID biến thể được chọn
    let variants = []; // Danh sách biến thể
    let cartId = null; // ID giỏ hàng của sản phẩm hiện tại

    // Hiển thị hộp chọn biến thể
    $(document).on('click', '.variant-button', function (event) {
        event.stopPropagation();
        const button = $(this);
        const rect = button[0].getBoundingClientRect();
        variantBox.style.top = `${rect.bottom + window.scrollY}px`;
        variantBox.style.left = `${rect.left + window.scrollX}px`;
        variantBox.classList.add("active");

        cartId = button.closest('tr').data('cart-id'); // Lấy ID giỏ hàng
        const productId = button.closest('tr').data('product-id');
        const currentVariantId = button.closest('tr').data('variant-id');

        // Gọi API để lấy danh sách biến thể
        $.ajax({
            url: `/cart/product/${productId}/variants`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    variants = response.variants; // Lưu danh sách biến thể
                    const attributeData = response.attribute_data;
                    // console.log(attributeData);

                    displayAttributes(attributeData, variants, currentVariantId);
                } else {
                    console.log('Lỗi phản hồi:', response);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', status, error);
            }
        });
    });

    // Hiển thị các thuộc tính của sản phẩm
    function displayAttributes(attributeData, variants, currentVariantId) {
        const attributesContainer = $('#attributes-container');
        attributesContainer.empty(); // Xóa bỏ nội dung cũ

        if (!Array.isArray(attributeData)) {
            attributeData = Object.values(attributeData);
        }

        attributeData.forEach(function (attribute) {
            let attributeHtml = `
                <div class="attribute">
                    <h6 class="p-1">${attribute.name}:</h6>
                    <ul class="attribute-values">
                        ${attribute.attribute_values.map(function (value) {
                const { selectedClass, disabledClass } = getVariantClasses(value, attribute, variants, currentVariantId);
                return getAttributeHtml(value, attribute, selectedClass, disabledClass);
            }).join('')}
                    </ul>
                </div>
            `;
            attributesContainer.append(attributeHtml);
        });
    }
    function getVariantClasses(value, attribute, variants, currentVariantId) {
        let selectedClass = '';
        let disabledClass = '';

        // Thuộc tính của biến thể hiện tại
        const currentVariantAttributes = {};

        // Lấy các thuộc tính của biến thể hiện tại
        const currentVariant = variants.find(variant => variant.product_variant_id === parseInt(currentVariantId));
        if (currentVariant) {
            currentVariant.attributes.forEach(attr => {
                currentVariantAttributes[attr.attribute_id] = attr.value_id;
            });
        }

        // Biến thể trong giỏ hàng
        const cartItems = window.cartItems || [];
        // console.log(cartItems);

        // Lấy các biến thể khác trong giỏ hàng (cùng `product_id` nhưng khác `currentVariantId`)
        const cartVariants = cartItems.filter(item =>
            item.product_id === variants[0].product_id &&
            item.variant_id !== parseInt(currentVariantId)
        );

        // Lấy tất cả các giá trị hợp lệ cho thuộc tính
        const validAttributeValues = variants
            .filter(variant => {
                // Kiểm tra xem biến thể này có khớp với tất cả các thuộc tính hiện tại (trừ thuộc tính đang xét)
                return Object.keys(currentVariantAttributes).every(attrId => {
                    // Bỏ qua thuộc tính đang xét
                    if (parseInt(attrId) === attribute.id) return true;
                    return variant.attributes.some(attr =>
                        attr.attribute_id === parseInt(attrId) &&
                        attr.value_id === currentVariantAttributes[attrId]
                    );
                });
            })
            .flatMap(variant => variant.attributes.filter(attr => attr.attribute_id === attribute.id))
            .map(attr => attr.value_id);
        // console.log(validAttributeValues);

        // Kiểm tra nếu giá trị đang xét đã tồn tại trong giỏ hàng (disabled nếu tồn tại)
        const isValueDisabled = cartVariants.some(cartItem =>
            cartItem.attribute_values.some(cartAttr =>
                cartAttr.attribute_id === attribute.id && cartAttr.value_id === value.id
            ) &&
            Object.keys(currentVariantAttributes).every(attrId => {
                if (parseInt(attrId) === attribute.id) return true; // Bỏ qua thuộc tính hiện tại
                return cartItem.attribute_values.some(cartAttr =>
                    cartAttr.attribute_id === parseInt(attrId) &&
                    cartAttr.value_id === currentVariantAttributes[attrId]
                );
            })
        );

        // Xác định trạng thái `disabled` và `selected`
        if (currentVariant) {
            currentVariant.attributes.forEach(attr => {
                if (attr.attribute_id === attribute.id && attr.value_id === value.id) {
                    selectedClass = 'selected';
                }
            });
        }

        if (!validAttributeValues.includes(value.id) || isValueDisabled) {
            disabledClass = 'disabled';
        }

        return { selectedClass, disabledClass };
    }
    fetchCartItems().then(() => {
    });
    // Gọi API để lấy `cart_list`
    function fetchCartItems() {
        return fetch('/api/cart-items', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.cartItems = data.cart_list; // Lưu dữ liệu giỏ hàng vào biến toàn cục
                    // console.log('Cart Items:', window.cartItems);
                } else {
                    console.error('Failed to fetch cart items.');
                }
            })
            .catch(error => console.error('Error fetching cart items:', error));
    }


    // Tạo HTML cho thuộc tính
    function getAttributeHtml(value, attribute, selectedClass, disabledClass) {
        if (/^#[0-9A-F]{6}$/i.test(value.value)) { // Nếu giá trị là màu (mã hex)
            return `
                <li class="attribute_item ${selectedClass} ${disabledClass}" title="${value.name}"
                    style="background-color: ${value.value}; border: 1px solid rgba(var(--theme-default)); width: 40px; height: 40px; border-radius: 50%;"
                    data-attribute-id="${attribute.id}" data-value-id="${value.id}">
                </li>
            `;
        } else {
            return `
                <li>
                    <button type="button" class="btn-variant m-2 ${selectedClass} ${disabledClass}" style="width: 60px;height: 35px;"
                        data-attribute-id="${attribute.id}" data-value-id="${value.id}">
                        ${value.name}
                    </button>
                </li>
            `;
        }
    }

    // Đóng hộp variant khi nhấn nút "Trở lại"
    backButton.addEventListener("click", function () {
        resetDisabledVariants(); // Xóa trạng thái disabled
        variantBox.classList.remove("active");
    });

    // Đóng hộp variant khi nhấn ra ngoài
    document.addEventListener("click", function (event) {
        if (!variantBox.contains(event.target) && !event.target.closest('.variant-button')) {
            resetDisabledVariants(); // Xóa trạng thái disabled
            variantBox.classList.remove("active");
        }
    });

    let selectedAttributes = {};
    $(document).on('click', '.btn-variant, .attribute_item', function () {
        const selectedValueId = $(this).data('value-id');
        const selectedAttributeId = $(this).data('attribute-id');

        if ($(this).hasClass('selected')) {
            return;
        }

        $(this).closest('ul').find('.btn-variant, .attribute_item').removeClass('selected');
        $(this).addClass('selected');

        updateSelectedAttributes();
        updateDisabledState();
        updateSelectedVariant();
    });

    function updateSelectedAttributes() {
        selectedAttributes = {};
        $('.btn-variant.selected, .attribute_item.selected').each(function () {
            const attrId = $(this).data('attribute-id');
            const valueId = $(this).data('value-id');
            selectedAttributes[attrId] = valueId;
        });
    }
    function updateDisabledState() {
        const cartItems = window.cartItems || []; // Danh sách biến thể trong giỏ hàng
        const currentProductId = variants[0]?.product_id; // Lấy product_id từ variants (giả sử tất cả variants cùng product_id)
        // console.log(currentProductId);
        

        $('.btn-variant, .attribute_item').each(function () {
            const $element = $(this);
            const currentValueId = $element.data('value-id'); // ID của giá trị thuộc tính hiện tại
            const currentAttributeId = $element.data('attribute-id'); // ID của thuộc tính hiện tại
            const currentVariantAttributes = { ...selectedAttributes, [currentAttributeId]: currentValueId };
            const matchingVariant = variants.find(variant => {
                return variant.attributes.every(attr => currentVariantAttributes[attr.attribute_id] === attr.value_id);
            });
            if (!matchingVariant || matchingVariant.stock <= 0) {
                $element.addClass('disabled');
                return;
            }
            const isInCart = cartItems.some(item => {
                return item.product_id === currentProductId &&
                    item.variant_id === matchingVariant.product_variant_id;
            });
            if (isInCart && matchingVariant.product_variant_id === selectedVariantId) {
                increaseCartItemQuantity(matchingVariant.product_variant_id);
            }
            if (isInCart && matchingVariant.product_variant_id !== selectedVariantId) {
                $element.addClass('disabled');
            } else {
                $element.removeClass('disabled');
            }
        });
    }

    // Hàm tăng số lượng biến thể trong giỏ hàng
    function increaseCartItemQuantity(variantId) {
        const cartItems = window.cartItems || [];
        const cartItem = cartItems.find(item => item.variant_id === variantId);

        if (cartItem) {
            cartItem.quantity += 1; // Tăng số lượng lên 1
            // console.log(`Tăng số lượng biến thể có ID ${variantId} lên ${cartItem.quantity}`);
        }
    }

    function updateSelectedVariant() {
        const matchingVariants = variants.filter(variant => {
            const matchesSelected = Object.keys(selectedAttributes).every(attrId => {
                return variant.attributes.some(attr =>
                    attr.attribute_id === parseInt(attrId) &&
                    attr.value_id === selectedAttributes[attrId]
                );
            });

            return matchesSelected && variant.stock > 0;
        });

        selectedVariantId = matchingVariants.length > 0 ? matchingVariants[0].product_variant_id : null;

        if (selectedVariantId) {
            console.log("Biến thể đã chọn:", selectedVariantId);
        } else {
            console.log("Không tìm thấy biến thể phù hợp hoặc biến thể không còn hàng.");
        }
    }



    // Khi nhấn nút "Xác nhận"
    confirmButton.addEventListener("click", function () {
        if (selectedVariantId && cartId) {
            // Gửi yêu cầu Ajax để cập nhật biến thể giỏ hàng
            $.ajax({
                url: `product/{product_id}/update-variant`, // Đảm bảo đường dẫn này đúng
                type: 'POST',
                data: {
                    cart_id: cartId, // ID giỏ hàng
                    variant_id: selectedVariantId, // ID biến thể đã chọn
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                },
                success: function (response) {
                    if (response.success) {
                        notification('success', ' Sửa biến thể thành công!', 'Success!', '2000');
                        location.reload(); // Tải lại trang để cập nhật giỏ hàng
                    } else {
                        alert(response.message); // Hiển thị thông báo lỗi
                    }
                },
                error: function (xhr, status, error) {
                    notification('warning', ' Có lỗi trong quá trình chọn biến thể!', 'Warning!', '2000');
                    console.log('AJAX Error:', status, error);

                }
            });
        } else {
            alert("Vui lòng chọn một biến thể hợp lệ trước khi xác nhận.");
        }
    });

    // Xóa trạng thái disabled khỏi các nút
    function resetDisabledVariants() {
        $('.btn-variant, .attribute_item').removeClass('disabled');
    }
});



