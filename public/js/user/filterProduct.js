// Hàm để lấy giá trị tham số từ URL


function loadAllProducts() {
    $.ajax({
        url: 'api/products/all', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = response.products; // Danh sách sản phẩm
            const globalMinPrice = response.minPrice; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPrice; // Giá lớn nhất toàn cục

            // console.log(products);
            renderProducts(products, globalMinPrice, globalMaxPrice);

            // Hiển thị giá toàn cục
            // const priceRangeElement = document.getElementById("price-range");
            // priceRangeElement.innerHTML = globalMinPrice === globalMaxPrice
            //     ? `Giá: $${globalMinPrice}`
            //     : `Giá: $${globalMinPrice} - $${globalMaxPrice}`;
        },
        error: function (error) {
            console.error("Có lỗi xảy ra khi lấy sản phẩm:", error);
        }
    });
}
function loadBestselingProducts() {
    $.ajax({
        url: 'api/products/bestselingproduct', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = response.products; // Danh sách sản phẩm
            const globalMinPrice = response.minPrice; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPrice; // Giá lớn nhất toàn cục

            console.log(products);
            renderProducts(products, globalMinPrice, globalMaxPrice);

            // Hiển thị giá toàn cục
            const priceRangeElement = document.getElementById("price-range");
            priceRangeElement.innerHTML = globalMinPrice === globalMaxPrice
                ? `Giá: $${globalMinPrice}`
                : `Giá: $${globalMinPrice} - $${globalMaxPrice}`;
        },
        error: function (error) {
            console.error("Có lỗi xảy ra khi lấy sản phẩm:", error);
        }
    });
}
function loadNewProducts() {
    $.ajax({
        url: 'api/products/getNewProduct', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = response.products; // Danh sách sản phẩm
            const globalMinPrice = response.minPrice; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPrice; // Giá lớn nhất toàn cục

            console.log(products);
            renderProducts(products, globalMinPrice, globalMaxPrice);

            // Hiển thị giá toàn cục
            const priceRangeElement = document.getElementById("price-range");
            priceRangeElement.innerHTML = globalMinPrice === globalMaxPrice
                ? `Giá: $${globalMinPrice}`
                : `Giá: $${globalMinPrice} - $${globalMaxPrice}`;
        },
        error: function (error) {
            console.error("Có lỗi xảy ra khi lấy sản phẩm:", error);
        }
    });
}

function loadDescProducts() {
    $.ajax({
        url: 'api/products/getDescPriceProducts', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = Array.isArray(response.products)
                ? response.products
                : Object.values(response.products);
            // console.log(products);

            const globalMinPrice = response.minPrice; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPrice;
            renderProducts(products, globalMinPrice, globalMaxPrice);

        },
        error: function (error) {
            console.error("Có lỗi xảy ra khi lấy sản phẩm:", error);
        }
    });
}
function loadEscProducts() {
    $.ajax({
        url: 'api/products/getEscPriceProducts', // URL đến API `getAllProducts`
        method: 'GET',
        success: function (response) {
            const products = response.products; // Danh sách sản phẩm
            const globalMinPrice = response.minPrice; // Giá nhỏ nhất toàn cục
            const globalMaxPrice = response.maxPrice; // Giá lớn nhất toàn cục

            // console.log(products);
            renderProducts(products, globalMinPrice, globalMaxPrice);

            // Hiển thị giá toàn cục
            const priceRangeElement = document.getElementById("price-range");
            priceRangeElement.innerHTML = globalMinPrice === globalMaxPrice
                ? `Giá: $${globalMinPrice}`
                : `Giá: $${globalMinPrice} - $${globalMaxPrice}`;
        },
        error: function (error) {
            console.error("Có lỗi xảy ra khi lấy sản phẩm:", error);
        }
    });
}

// Hàm hiển thị sản phẩm
function renderProducts(products) {
    const productGrid = $('.grid-section');
    productGrid.empty(); // Xóa nội dung hiện tại

    if (!Array.isArray(products) || products.length === 0) {
        productGrid.html(`
            <div class=" justify-content-center ">
                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/search/a60759ad1dabe909c46a.png" alt="timmm">
                <p>Hic. Không có sản phẩm nào. Bạn thử tắt điều kiện lọc và tìm lại nhé?</p>
            </div>
        `);
        return;
    }


    products.forEach(product => {
        const minPrice = product.variant_sale_price_min !== null
            ? Number(product.variant_sale_price_min).toLocaleString()
            : "N/A";
        const maxPrice = product.variant_sale_price_max !== null
            ? Number(product.variant_sale_price_max).toLocaleString()
            : "N/A";

        const displayPrice = minPrice === maxPrice ? `${minPrice}đ` : `${minPrice}đ - ${maxPrice}đ`;
        const averageRating = product.averageRating !== undefined ? product.averageRating : 5.0; // Nếu chưa có đánh giá, mặc định là 5 sao
        // console.log(product);
        
        // const totalReviews = product.rating?.total_reviews || 0;
        // console.log(averageStar);

        const productHTML = `
            <div>
                <div class="product-box-3">
                    <div class="img-wrapper">
                        <div class="label-block">
                            <a class="wishlistIcon label-2 " data-id="${product.id }">
                                <i class="fa-regular fa-heart" title="Thêm vào yêu thích"></i>
                            </a>
                        </div>
                        <div class="product-image">
                            <a class="pro-img" href="${product.productURL}"> 
                                <img class="bg-imgd" src="${product.image_url}" alt="product">
                            </a>
                        </div>
                        <div class="cart-info-icon"> 
                            <a class="add-to-cart quick-view-btn" href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0" data-product-id="${product.id}">
                                <i title="Thêm vào giỏ hàng" class="fa-solid fa-cart-shopping" data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip" ></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-detail">
                        <a href="${product.productURL}">
                            <h6 >${product.name}</h6>
                        </a>
                        <ul class="ratingd d-flex">
                            <li><p id="price-range">${displayPrice}</p></li>
                             <li>${averageRating} <i class="fa-solid fa-star"></i></li>
                        </ul>
                        <div class="listing-button">
                            <a class="btn" href="cart.html">Quick Shop</a>
                        </div>
                    </div>
                </div>
            </div>            
        `;
        productGrid.append(productHTML); // Thêm sản phẩm vào lưới
    });
}


$(document).ready(function () {
    // Lắng nghe các sự kiện trên các bộ lọc
    $('#filterBestSelling').on('click', function () {
        loadBestselingProducts();
    });

    $('#filterNewArrivals').on('click', function () {
        loadNewProducts();
    });
    $('#priceSort').change(function () {
        const selectedValue = $(this).val();  // Lấy giá trị của option được chọn

        if (selectedValue === 'price_desc') {
            loadDescProducts();  // Gọi hàm loadDescProducts khi chọn "Giá: Cao - Thấp"
        } else if (selectedValue === 'price_asc') {
            loadEscProducts();
        }
    });

    // Lắng nghe sự kiện thay đổi trên các bộ lọc
    // $('input.category-checkbox, input.brand-checkbox').on('change', function () {
    //     updateSelectedFilters();
    // });

    // Gọi hàm loadAllProducts khi trang được tải    
    const searchValue = getQueryParam('search'); // Lấy giá trị 'name' từ URL
    const searchCate = getQueryParam('category'); // Lấy giá trị 'name' từ URL
    const searchBrand = getQueryParam('brand'); // Lấy giá trị 'name' từ URL

    if (searchValue) {
        // Điền vào ô tìm kiếm nếu có giá trị 'name' trong URL
        document.getElementById('search-input').value = searchValue;
        filterProducts(searchValue);
    } else if (searchCate) {
        const categoryIds = searchCate.split(','); // Tách chuỗi categories thành mảng ID

        var categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        categoryCheckboxes.forEach(function (checkbox) {
            var cate_id = checkbox.getAttribute('data-id'); // Lấy 'data-id' của checkbox
            var parent_id = checkbox.getAttribute('data-parent'); // Lấy 'data-parent' của checkbox (nếu có)

            // Nếu cate_id nằm trong danh sách categoryIds thì đánh dấu checkbox
            if (categoryIds.includes(cate_id)) {
                checkbox.checked = true;  // Đánh dấu checkbox là checked

                // Kiểm tra nếu đó là danh mục cha (data-parent rỗng hoặc không có)
                if (!parent_id) {
                    // Nếu là danh mục cha, tự động tick tất cả các danh mục con của nó
                    document.querySelectorAll('.category-checkbox[data-parent="' + cate_id + '"]').forEach(function (childCheckbox) {
                        childCheckbox.checked = true;  // Đánh dấu checkbox con là checked
                    });
                }
            }
        });
        filterProducts();
    } else if(searchBrand) {

        const brandID = searchBrand.split(','); // Tách chuỗi categories thành mảng ID

        var brandCheckboxes = document.querySelectorAll('.brand-checkbox');
        brandCheckboxes.forEach(function (checkbox) {
            var brand_id = checkbox.getAttribute('data-id'); // Lấy 'data-id' của checkbox
            console.log(brand_id);

            if (brandID.includes(brand_id)) {
                checkbox.checked = true;  // Đánh dấu checkbox là checke
    
            }
        });
        filterProducts();
    }else{
        
        loadAllProducts();
    }

    // Hàm cập nhật các lựa chọn đã chọn và hiển thị vào .title_selected
    function updateSelectedFilters() {
        var selectedCategories = [];
        var selectedBrands = [];
        var selectedColors = [];
        var minPrice = $('input[type="range"]:first').val();  // Giá trị min của khoảng giá
        var maxPrice = $('input[type="range"]:last').val();  // Giá trị max của khoảng giá

        // Lấy các danh mục đã chọn
        $('input.category-checkbox:checked').each(function () {
            var categoryName = $(this).siblings('label').text();
            selectedCategories.push(categoryName);
        });

        // Lấy các thương hiệu đã chọn
        $('input.brand-checkbox:checked').each(function () {
            var brandName = $(this).siblings('label').text();
            selectedBrands.push(brandName);
        });

        // Lấy các màu đã chọn
        // $('ul.color-variant li.selected').each(function () {
        //     var color = $(this).data('color');
        //     selectedColors.push(color);
        // });

        // Hiển thị các lựa chọn đã chọn trong phần title_selected
        var selectedFiltersHTML = '';
        var titleSelectedHTML = '';

        // Thêm dòng "Bạn đã chọn" trước phần hiển thị bộ lọc
        titleSelectedHTML += '<p style="font-weight: bold; font-size: 16px; color: #333; margin-bottom: 10px;">Bạn đã chọn:</p> ';

        // Hiển thị khoảng giá nếu có
        // if (minPrice && maxPrice) {
        //     selectedFiltersHTML += `<div class="selected-item" data-type="price" data-min="${minPrice}" data-max="${maxPrice}">
        //         Giá: ${minPrice}đ - ${maxPrice}đ <span class="remove-filter">x</span>
        //     </div>`;
        // }

        // Hiển thị danh mục nếu có
        if (selectedCategories.length > 0) {
            selectedFiltersHTML += `<div class="selected-item d-flex align-items-center" data-type="category" data-values="${selectedCategories.join(',')}">
            ${selectedCategories.join(', ')} <i class="remove-filter fas fa-x ms-1 fw-bold fa-md text-danger cspt"></i>
        </div>`;
        }

        // Hiển thị thương hiệu nếu có
        if (selectedBrands.length > 0) {
            selectedFiltersHTML += `<div class="selected-item d-flex align-items-center mt-2" data-type="brand" data-values="${selectedBrands.join(',')}">
            ${selectedBrands.join(', ')} <i class="remove-filter fas fa-x ms-1 fw-bold fa-md text-danger cspt"></i>
        </div>`;
        }

        // Hiển thị màu sắc nếu có
        // if (selectedColors.length > 0) {
        //     selectedFiltersHTML += `<div class="selected-item" data-type="color" data-values="${selectedColors.join(',')}">
        //         Màu: ${selectedColors.join(', ')} <span class="remove-filter">x</span>
        //     </div>`;
        // }

        // Cập nhật phần title_selected với các lựa chọn đã chọn
        $('#title_selected').html(titleSelectedHTML);
        $('#selected_items').html(selectedFiltersHTML);

        // Kiểm tra xem có bất kỳ lựa chọn nào không, nếu không thì ẩn dòng chữ "Bạn đã chọn"
        if ($('.div_selected_items .selected-item').length === 0) {
            // Ẩn dòng chữ "Bạn đã chọn"
            $('.div_selected_items p').hide();
        } else {
            // Hiển thị dòng chữ "Bạn đã chọn" nếu có ít nhất một lựa chọn
            $('.div_selected_items p').show();
        }
    }

    // Xử lý sự kiện nhấp vào dấu x để xóa bộ lọc
    $(document).on('click', '.remove-filter', function () {
        var filterType = $(this).parent().data('type');
        // var filterValues = $(this).parent().data('values');

        // Cập nhật lại các bộ lọc dựa trên loại và giá trị đã chọn
        if (filterType === 'price') {
            $('input[type="range"]').val([0, 1000000]); // Reset khoảng giá
        } else if (filterType === 'category') {
            $('input.category-checkbox').prop('checked', false); // Bỏ chọn các danh mục
        } else if (filterType === 'brand') {
            $('input.brand-checkbox').prop('checked', false); // Bỏ chọn các thương hiệu
        }// else if (filterType === 'color') {
        //     $('ul.color-variant li').removeClass('selected'); // Bỏ chọn các màu
        // }

        // Cập nhật lại phần đã chọn sau khi xóa
        updateSelectedFilters();


        filterProducts();
    });


});

window.onload = function () {
    const url = new URL(window.location.href);

    if (url.searchParams.has('brand')) {
        url.searchParams.delete('brand'); // Xóa tham số 'brand'
        window.history.replaceState({}, document.title, url.toString()); // Cập nhật URL mà không tải lại trang
    }

    if (url.searchParams.has('category')) {
        url.searchParams.delete('category'); // Xóa tham số 'category'
        window.history.replaceState({}, document.title, url.toString()); // Cập nhật URL mà không tải lại trang
    }
    if (url.searchParams.has('search')) {
        url.searchParams.delete('search'); // Xóa tham số 'category'
        window.history.replaceState({}, document.title, url.toString()); // Cập nhật URL mà không tải lại trang
    }
};



//chọn danh mục cha thì chọn cả danh mục con
function toggleChildCategories(parentId) {
    const isChecked = $('#category' + parentId).is(':checked');
    // Lặp qua tất cả các checkbox danh mục con có parentId tương ứng
    $('.custom-checkbox[data-parent="' + parentId + '"]').each(function () {
        $(this).prop('checked', isChecked); // Đặt trạng thái của checkbox con giống trạng thái của cha
    });
    filterProducts();
}



function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param); // Lấy giá trị của tham số, hoặc null nếu không có tham số này
}

// Hàm lọc sản phẩm
function filterProducts(searchValue,) {

    const searchInput = searchValue;
    const selectedCategories = [];
    const selectedBrands = [];
    const minPrice = $('#range-slider-min').val();
    const maxPrice = $('#range-slider-max').val();

    // Lấy các danh mục đã chọn
    $('.category-checkbox:checked').each(function () {
        selectedCategories.push($(this).val());
    });

    // Lấy các thương hiệu đã chọn
    $('.brand-checkbox:checked').each(function () {
        selectedBrands.push($(this).val());
    });

    // Nếu không có bộ lọc nào, gọi lại để hiển thị toàn bộ sản phẩm
    if (!searchInput && selectedCategories.length === 0 && !minPrice && !maxPrice && selectedBrands.length === 0) {
        loadAllProducts(); // Chỉ gọi một lần
        return;
    }

    // Gửi yêu cầu Ajax với các bộ lọc
    $.ajax({
        url: '/api/products/filter',
        method: 'GET',
        data: {
            name: searchInput,
            categories: selectedCategories.join(','), // Nối các ID danh mục
            brands: selectedBrands.join(','), // Danh sách ID thương hiệu
        },
        success: function (response) {
            const products = response.listProduct || response;
            renderProducts(products);
        },
        error: function (xhr) {
            console.error("Có lỗi xảy ra: ", xhr);
        }
    });
}

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
            notification('error', 'Lỗi khi sao chép: ', err);
        });
    });
});


$(document).on('click', '.wishlistIcon', function () {
    const $this = $(this);
    const productId = $this.data('id'); // Lấy ID sản phẩm
    const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Lấy CSRF token từ thẻ meta

    if (!productId) {
        console.error('ID sản phẩm không hợp lệ.');
        return;
    }

    $.ajax({
        url: '/wishlist/add',
        method: 'POST',
        data: {
            _token: csrfToken,
            product_id: productId
        },
        success: function (response) {
            if (response.status === 'success') {
                // Cập nhật số lượng sản phẩm yêu thích
                $('.cart_qty_cls').text(response.wishCount);

                // Hiển thị thông báo thành công
                notification('success', response.message, 'Thành công!');

                // Cập nhật giao diện (ví dụ: đổi biểu tượng trái tim thành đã thích)
                // $this.find('i').removeClass('fa-regular fa-heart').addClass('fa-solid fa-heart').attr('title', 'Đã thêm vào yêu thích');
            } else if (response.status === 'error') {
                // Hiển thị cảnh báo nếu có lỗi
                notification('warning', response.message, 'Thông báo!');
            }
        },
        error: function (xhr) {
            // Hiển thị thông báo lỗi nếu không thành công
            Toastify({
                text: "Không thể thêm sản phẩm vào yêu thích. Vui lòng thử lại.",
                duration: 2500,
                close: true,
            }).showToast();
        }
    });
});




$(document).ready(function () {
    // Khi nhấn nút giảm
    $('.reduce').on('click', function () {
        var quantity = parseInt($('#quantity').val()); // Lấy giá trị hiện tại của input
        if (quantity > 1) {
            $('#quantity').val(quantity - 1); // Giảm số lượng
        }
    });

    // Khi nhấn nút tăng
    $('.increment').on('click', function () {
        var quantity = parseInt($('#quantity').val()); // Lấy giá trị hiện tại của input
        if (quantity < 10) { // Kiểm tra xem số lượng đã bằng 10 chưa
            $('#quantity').val(quantity + 1); // Tăng số lượng
        } else {
            notification('error', 'Số lượng không thể vượt quá 10!'); // Hiển thị thông báo nếu vượt quá 10
        }
    });

    // Khi người dùng nhập trực tiếp vào input
    $('#quantity').on('input', function () {
        var quantity = parseInt($(this).val()); // Lấy giá trị từ input
        if (quantity < 1) {
            $(this).val(1); // Nếu nhập vào giá trị nhỏ hơn 1, đặt lại là 1
        } else if (quantity > 10) {
            $(this).val(10); // Nếu nhập vào giá trị lớn hơn 10, đặt lại là 10
            notification('error', 'Số lượng không thể vượt quá 10!');
        }
    });
});




$(document).on('click', '.quick-view-btn', function (event) {
    event.preventDefault();
    const productId = $(this).data('product-id');
    openAddToCart(productId);
});
//Xử lý đóng modal
$(document).on('click', '#close_modal', function () {
    var attributes_container = document.getElementById('attributes-container');
    attributes_container.innerHTML = "";
    $('#quantity').val(1);
})
// Hàm mở modal Quick View
function openAddToCart(productId) {
    // Hiển thị modal với loading
    const modal = $('#addtocart');
    modal.modal('show');
    modal.find('#product-image').attr('src', 'path/to/loading-image.gif'); // Loading image tạm thời
    modal.find('#product-name, #product-sku, #product-price, #product-description').text('Loading...');
    modal.find('.color-list, .size-list, .default-list').empty(); // Xóa dữ liệu cũ

    // Gửi yêu cầu API lấy dữ liệu chi tiết sản phẩm
    $.ajax({
        url: `/getProductDetail/${productId}`,
        method: 'GET',
        success: function (response) {
            // Lưu productId vào modal
            modal.attr('data-product-id', productId); // Lưu productId vào data của modal
            // console.log(325235);

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
    const modal = $('#addtocart');

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
    $('#addtocart #total-stock').text(totalStock);

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
        $('#addtocart #total-stock').text(stockSum);

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
            $('#addtocart #product-price').text(new Intl.NumberFormat('vi-VN', {
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

            $('#addtocart #product-price').text(
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
                $('#addtocart').modal('hide');
                notification('success', response.message || 'Thêm vào giỏ hàng thành công.', 'Thông báo', 2000);
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
                notification('error', 'Đã xảy ra lỗi không xác định. Vui lòng thử lại.', 'Lỗi!', 2000);
            }
        }
    });
}
$(document).on('change', '#search-input', function () {
    filterProducts($(this).val());
})
// $('#search-input').on('keyup', filterProducts); // Thay 'change' bằng 'keyup'
$('.custom-checkbox, .color-checkbox, .brand-checkbox').on('change', filterProducts);

