//lưu CODE voucher
document.querySelectorAll('.copy-content').forEach(element => {
    element.addEventListener('click', function () {
        const voucherCode = this.getAttribute('data-code'); // Lấy mã voucher
        const originalText = this.textContent; // Lưu nội dung ban đầu

        // Sao chép mã vào clipboard
        navigator.clipboard.writeText(voucherCode).then(() => {
            // Hiển thị "Đã chép"
            this.textContent = this.getAttribute('data-copied-text');


            // Trả lại nội dung ban đầu sau 3 giây
            setTimeout(() => {
                this.textContent = originalText;
            }, 3000);

        }).catch(err => {
            notification('error', 'Lỗi khi sao chép: ', 'Error!', '2000');
        });
    });
});


$(document).ready(function () {
    // Khi người dùng thay đổi giá trị trong input số lượng
    $(document).on('input', '#quantity', function () {
        const quantityInput = $(this);

        // Kiểm tra xem tất cả các thuộc tính đã được chọn hay chưa
        if (!isAttributesSelected()) {
            // Nếu chưa chọn đủ thuộc tính, không cho phép thay đổi số lượng
            notification('warning', 'Vui lòng chọn đầy đủ các thuộc tính trước khi thay đổi số lượng.', 'Warning!', '2000');
            // Khôi phục lại giá trị trước khi thay đổi
            quantityInput.val(1);  // Hoặc giá trị mặc định
            return;
        }

        const currentQuantity = parseInt(quantityInput.val()) || 1; // Đảm bảo giá trị hợp lệ (nếu không phải số thì mặc định là 1)
        const maxQuantity = parseInt($('#total-stock').text()) || 0; // Số lượng tối đa có sẵn

        // Nếu số lượng vượt quá số lượng có sẵn, điều chỉnh về số lượng tối đa
        if (currentQuantity > maxQuantity) {
            quantityInput.val(maxQuantity);
            notification('warning', `Số lượng tối đa có sẵn là: ${maxQuantity}`, 'Warning!', '2000');
        }

        // Nếu số lượng nhỏ hơn 1, điều chỉnh về giá trị tối thiểu (1)
        if (currentQuantity < 1) {
            quantityInput.val(1);
        }
    });

    // Xử lý khi nhấn nút giảm số lượng
    $(document).on('click', '.reduce', function () {
        const quantityInput = $('#quantity');
        let currentQuantity = parseInt(quantityInput.val()) || 1;

        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1).trigger('input');
        }
    });

    // Xử lý khi nhấn nút tăng số lượng
    $(document).on('click', '.increment', function () {
        const quantityInput = $('#quantity');
        let currentQuantity = parseInt(quantityInput.val()) || 1;
        const maxQuantity = parseInt($('#total-stock').text()) || 0;

        if (currentQuantity < maxQuantity) {
            quantityInput.val(currentQuantity + 1).trigger('input');
        } else {
            notification('warning', `Số lượng tối đa có sẵn là: ${maxQuantity}`, 'Warning!', '2000');
        }
    });

    // Kiểm tra xem tất cả các thuộc tính đã được chọn chưa
    function isAttributesSelected() {
        let isSelected = true;

        // Kiểm tra tất cả các nhóm thuộc tính
        $('.attribute_group').each(function () {
            const activeItems = $(this).find('.attribute_item.active').length;
            if (activeItems === 0) {
                isSelected = false;  // Nếu có nhóm thuộc tính chưa được chọn, trả về false
            }
        });

        return isSelected; // Trả về true nếu tất cả các thuộc tính đã được chọn
    }
});


$(document).on('click', '.quick-view-btn', function (event) {
    event.preventDefault();
    const productId = $(this).data('product-id');
    openQuickView(productId);
});

// Xử lý đóng modal
$(document).on('click', '#close_modal', function () {
    var attributes_container = document.getElementById('attributes-container');
    attributes_container.innerHTML = "";
    $('#quantity').val(1);
})

// Hàm mở modal Quick View
function openQuickView(productId) {
    // Hiển thị modal với loading
    const modal = $('#quick-view');
    modal.modal('show');
    modal.find('#product-image').attr('src', 'path/to/loading-image.gif'); // Loading image tạm thời
    modal.find('#product-name, #product-sku, #product-price').text('Loading...');
    modal.find('.color-list, .size-list, .default-list').empty(); // Xóa dữ liệu cũ

    // Gửi yêu cầu API lấy dữ liệu chi tiết sản phẩm
    $.ajax({
        url: `/get-product-details/${productId}`,
        method: 'GET',
        success: function (response) {
            // Lưu productId vào modal
            modal.data('product-id', productId); // Lưu productId vào data của modal

            // Gọi hàm hiển thị dữ liệu sản phẩm vào modal
            displayProductDetailsInModal(response);
            initializeAttributeSelection(response);
        },
        error: function (xhr, status, error) {
            notification('error', 'Không thể tải dữ liệu sản phẩm. Vui lòng thử lại.');
            modal.modal('hide');
        }
    });
}

function processAttributes(product) {
    const groupedAttributes = {};

    // Lấy danh sách thuộc tính từ dữ liệu
    Object.values(product.array_attributes).forEach((attribute) => {
        const attributeGroup = {
            id: attribute.id,
            name: attribute.name,
            type: attribute.type,
            values: []
        };

        // Lấy các giá trị thuộc tính
        attribute.attribute_values.forEach((value) => {
            attributeGroup.values.push({
                id: value.id,
                name: value.name,
                value: value.value || null // Xử lý trường hợp không có giá trị
            });
        });

        groupedAttributes[attribute.id] = attributeGroup;
    });

    return groupedAttributes;
}

// Hàm hiển thị dữ liệu sản phẩm vào modal
function displayProductDetailsInModal(product) {
    const modal = $('#quick-view');

    // Hiển thị thông tin cơ bản
    modal.find('#product-name').text(product.name);
    modal.find('#product-sku').text(`SKU: ${product.sku}`);
    $('#btn_view_detail_of_quick_view_product').attr('href', 'productDetail/' + product.sku);
    // Lọc các biến thể có sale_price và regular_price
    const variantsWithSalePrice = product.array_variants.filter((variant) => variant.sale_price !== null);
    const variantsWithoutSalePrice = product.array_variants.filter((variant) => variant.sale_price === null);

    // Tính toán giá thấp nhất và cao nhất
    let minPrice, maxPrice;

    if (variantsWithSalePrice.length > 0) {
        minPrice = Math.min(...variantsWithSalePrice.map(variant => variant.sale_price));
        maxPrice = variantsWithoutSalePrice.length > 0
            ? Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price))
            : Math.max(...variantsWithSalePrice.map(variant => variant.sale_price));
    } else {
        minPrice = Math.min(...variantsWithoutSalePrice.map(variant => variant.regular_price));
        maxPrice = Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price));
    }

    // Hiển thị giá
    if (minPrice === maxPrice) {
        modal.find('#product-price').text(new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(minPrice));
    } else {
        modal.find('#product-price').text(new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(minPrice) + ' - ' + new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(maxPrice));
    }

    modal.find('#product-image').attr('src', product.imageUrl);

    // Cập nhật ảnh liên quan
    const swiperWrapper = modal.find('.modal-slide-2 .swiper-wrapper');
    swiperWrapper.empty();
    product.relatedImages.forEach((image) => {
        swiperWrapper.append(`
            <div class="swiper-slide">
                <img class="img-fluid" src="${image}" alt="Product Image">
            </div>
        `);
    });

    // Hiển thị các thuộc tính
    const attributesContainer = modal.find('.attributes-container');
    attributesContainer.empty();

    Object.values(product.array_attributes).forEach((attribute) => {
        let html = `
            <div class="attribute-section">
                <p>${attribute.name}</p>
                <div class="attribute_group ${attribute.type}" data-id="${attribute.id}">
                    <ul class="${attribute.type}-variant">`;

        attribute.attribute_values.forEach((value) => {
            if (attribute.type === 'color') {
                html += `
                    <li class="attribute_item able" title="${value.name}" 
                        style="background-color: ${value.value};" 
                        data-id="${value.id}">
                    </li>`;
            } else {
                html += `
                    <li class="attribute_item able" title="${value.name}" 
                        data-id="${value.id}">
                        ${value.name}
                    </li>`;
            }
        });

        html += `
                    </ul>
                </div>
            </div>`;
        attributesContainer.append(html);
    });

    modal.modal('show');
}

// Xử lý chọn thuộc tính
function initializeAttributeSelection(product) {
    const variants = product.array_variants;
    let selectedAttributes = [];

    // Hiển thị tổng stock ban đầu
    const totalStock = variants.reduce((sum, variant) => sum + variant.stock, 0);
    $('#quick-view #total-stock').text(totalStock);

    $(document).off('click', '.attribute_item').on('click', '.attribute_item', function (e) {
        e.preventDefault();
        if ($(this).hasClass('disabled')) return;

        const attributeValueId = $(this).data('id');
        const isSelected = $(this).hasClass('active');

        // Cập nhật trạng thái chọn thuộc tính
        if (isSelected) {
            $(this).removeClass('active');
            selectedAttributes = selectedAttributes.filter((id) => id !== attributeValueId);
        } else {
            $(this).addClass('active');
            selectedAttributes.push(attributeValueId);
        }

        // Tính tổng stock của các biến thể phù hợp với thuộc tính đã chọn
        const partialMatchingVariants = variants.filter((variant) =>
            selectedAttributes.every((id) => variant.attribute_values.includes(id))
        );
        const stockSum = partialMatchingVariants.reduce((sum, variant) => sum + variant.stock, 0);

        // Hiển thị tổng stock tương ứng
        $('#quick-view #total-stock').text(stockSum);

        // Tìm biến thể khớp hoàn toàn với các thuộc tính đã chọn
        const exactMatchingVariant = variants.find((variant) => {
            const sortedSelected = [...selectedAttributes].sort();
            const sortedVariantAttributes = [...variant.attribute_values].sort();

            return JSON.stringify(sortedSelected) === JSON.stringify(sortedVariantAttributes) && variant.stock > 0;
        });

        if (exactMatchingVariant) {
            // Nếu tìm thấy biến thể khớp hoàn toàn
            selectedVariantId = exactMatchingVariant.variant_id;
            const priceToShow = exactMatchingVariant.sale_price || exactMatchingVariant.regular_price;
            $('#quick-view #product-price').text(new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            }).format(priceToShow));
        } else {
            // Nếu không khớp hoàn toàn, hiển thị giá mặc định
            const variantsWithSalePrice = product.array_variants.filter(variant => variant.sale_price !== null);
            const variantsWithoutSalePrice = product.array_variants.filter(variant => variant.sale_price === null);
            let minPrice, maxPrice;

            if (variantsWithSalePrice.length > 0) {
                minPrice = Math.min(...variantsWithSalePrice.map(variant => variant.sale_price));
                maxPrice = variantsWithoutSalePrice.length > 0
                    ? Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price))
                    : Math.max(...variantsWithSalePrice.map(variant => variant.sale_price));
            } else {
                minPrice = Math.min(...variantsWithoutSalePrice.map(variant => variant.regular_price));
                maxPrice = Math.max(...variantsWithoutSalePrice.map(variant => variant.regular_price));
            }

            $('#quick-view #product-price').text(
                minPrice === maxPrice
                    ? new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(minPrice)
                    : new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(minPrice) + ' - ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(maxPrice)
            );
        }

        // Cập nhật trạng thái các thuộc tính khả dụng
        updateAttributeStates(selectedAttributes, variants);
    });
}


// Cập nhật trạng thái thuộc tính
function updateAttributeStates(selectedAttributes, variants) {
    const availableAttributes = new Set();

    variants.forEach((variant) => {
        const isCompatible = selectedAttributes.every((id) => variant.attribute_values.includes(id));
        if (isCompatible && variant.stock > 0) {
            variant.attribute_values.forEach((id) => availableAttributes.add(id));
        }
    });

    $('.attribute_item').each(function () {
        const id = $(this).data('id');

        if (availableAttributes.has(id)) {
            // Thuộc tính khả dụng
            $(this).removeClass('disabled').addClass('able');
        } else {
            // Thuộc tính không khả dụng
            $(this).removeClass('able active').addClass('disabled');
        }
    });
}

$(document).on('click', '#add-to-cart-btn', function (event) {
    event.preventDefault();

    // Kiểm tra xem đã chọn đầy đủ thuộc tính chưa
    const unselectedAttributes = [];

    // Kiểm tra các thuộc tính chưa được chọn
    $('.attribute_group').each(function () {
        const activeItems = $(this).find('.attribute_item.active').length;

        // Lấy tên thuộc tính từ phần tử <p> chứa tên thuộc tính
        const attributeName = $(this).closest('.attribute-section').find('p').text().trim();

        if (activeItems === 0) {
            unselectedAttributes.push(attributeName); // Lấy tên thuộc tính nếu chưa chọn
        }
    });

    // Nếu có thuộc tính chưa chọn, hiển thị thông báo lỗi
    if (unselectedAttributes.length > 0) {
        notification('warning', `Vui lòng chọn các thuộc tính sau: ${unselectedAttributes.join(', ')}`, 'Warning!', '2000');
        return; // Ngừng tiếp tục nếu chưa chọn đầy đủ
    }

    var quantity = $('#quantity').val(); // Lấy giá trị từ input số lượng

    // Kiểm tra giá trị số lượng hợp lệ
    if (!quantity || quantity <= 0 || isNaN(quantity)) {
        notification('warning', 'Số lượng không hợp lệ!', 'Warning!', '2000');
        return;
    }

    // Thực hiện hành động thêm vào giỏ hàng
    addToCart(selectedVariantId, quantity);
});


//Lấy dữ liệu khi người dùng bấm thêm giỏ hàng
function addToCart(variantId, quantity) {
    $.ajax({
        url: '/cart/add',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: {
            variant_id: variantId,
            quantity: quantity
        },
        success: function (response) {
            if (response.success) {
                // Cập nhật số lượng trong giỏ hàng
                $('.shoping-prize .cart-count').text(response.cartCount);
                var successMessage = $('#fancybox-add-to-cart');
                successMessage.removeClass('hide').addClass('show');
                
                $('#quantity').val(1);
                
                setTimeout(function () {
                    successMessage.removeClass('show').addClass('hide');
                }, 2000);

                // Đóng modal quick-view
                $('#quick-view').modal('hide');
            } else {
                // Hiển thị thông báo lỗi từ server
                notification('warning', response.message || 'Đã xảy ra lỗi. Vui lòng thử lại.', 'Thông báo', 2000);
            }
        },
        error: function (xhr) {
            // Xử lý lỗi HTTP hoặc không xác định
            if (xhr.status === 401) {
                notification('warning', 'Vui lòng đăng nhập để sử dụng chức năng này.', 'Cảnh báo!', 2000);
            } else if (xhr.status === 400) {
                const response = JSON.parse(xhr.responseText);
                notification('warning', response.message || 'Dữ liệu không hợp lệ.', 'Thông báo', 2000);
            } else {
                notification('warning', 'Vui lòng đăng nhập để sử dụng chức năng này.', 'Cảnh báo!', 2000);
            }
        }
    });
}


//Hiển thị ngày giờ đếm ngược
document.addEventListener("DOMContentLoaded", function () {
    const countdownElements = document.querySelectorAll(".expire");

    countdownElements.forEach(el => {
        const endDate = new Date(el.dataset.endDate).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endDate - now;

            if (distance <= 0) {
                el.querySelector(".countdown").textContent = "Đã hết hạn";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            el.querySelector(".countdown").textContent = `${days} ngày ${hours}:${minutes}:${seconds}`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});



//Lấy thông tin voucher
$(document).ready(function () {
    $('.save-content').on('click', function () {
        const $this = $(this);
        const voucherId = $this.data('id');
        const saveText = $this.data('save-text');

        // Gửi yêu cầu lưu voucher
        $.ajax({
            url: '/save-voucher',
            method: 'POST',
            data: {
                id: voucherId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status == 'success') {
                    notification('success', response.message, 'Thành công!');
                    $this.text(saveText);
                } else if (response.status === 'error') {
                    notification('warning', response.message, 'Thông báo!');
                }
            },
            error: function (xhr, status, error) {
                notification('warning', 'Vui vòng đăng nhập để sử dụng chức năng này!', 'Warning!', '2000');

            }
        });
    });
});

//Thêm sản phẩm yêu thích
$('.wishlist-icon').click(function () {
    const $this = $(this);
    const productId = $(this).data('id');

    $.ajax({
        url: '/wishlist/add',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId
        },
        success: function (response) {

            if (response.status == 'success') {

                $('.cart_qty_cls').text(response.wishCount);
                notification('success', response.message, 'Thành công!');

            } else if (response.status === 'error') {
                notification('warning', response.message, 'Thông báo!');
            }
        },
        error: function (xhr, status, error) {
            notification('warning', 'Vui vòng đăng nhập để sử dụng chức năng này!', 'Warning!', '2000');
        }
    });
});

//Xóa sản phẩm khỏi trang yêu thích
$(document).on('click', '.delete-button', function () {
    const $this = $(this); // Lấy nút được nhấn
    const productId = $this.data('id'); // Lấy ID sản phẩm từ thuộc tính `data-id`

    $.ajax({
        url: '/wishlist/delete',
        method: 'POST', // Laravel yêu cầu POST, nhưng bạn sẽ spoof DELETE
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
            _method: 'DELETE', // Spoof method DELETE
            product_id: productId, // Dữ liệu cần thiết
        },
        success: function (response) {

            if (response.status === 'success') {
                // Hiển thị thông báo thành công
                notification('success', response.message, 'Thành công!');

                // Xóa toàn bộ box sản phẩm
                $this.closest('.col').remove();
                location.reload();
            } else if (response.status === 'error') {
                // Hiển thị thông báo lỗi từ server
                notification('warning', response.message, 'Thông báo!');
            }
        },
        error: function (xhr, status, error) {
            notification('warning', ' Không có sản phẩm này trong yêu thích!', 'Warning!', '2000');

        },
    });
});




