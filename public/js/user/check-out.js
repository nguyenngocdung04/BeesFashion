function formatCurrency(amount) {
    amount = parseFloat(amount);
    if (isNaN(amount)) return "0 đ";
    return amount.toLocaleString('vi-VN') + "đ";
}


//===================================Lấy dữ liệu địa chỉ=======================================
var dataListAddresses = null;
var updated_default_address = false;

function getListAddresses() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetListAddresses,
            method: "POST",
            data: {
                _token: csrf
            },
            success: function (response) {
                if (response.status == 200) {
                    // notification('success', response.message, 'Lấy dữ liệu địa chỉ thành công!', '2000');
                    dataListAddresses = response.data;

                } else if (response.status == 404) {
                    notification('error', response.message, 'Có lỗi xảy ra!', '2000');
                } else {
                    notification('error', response.message, 'Có lỗi xảy ra!', '2000');
                }
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                reject();
            }
        })
    })
}
//================================Tải dữ liệu địa chỉ lên giao diện===============================
async function loadListAddresses() {
    const listAddresses = document.getElementById('listAddresses');
    listAddresses.innerHTML = "";
    await getListAddresses();
    updated_default_address = dataListAddresses['updated'];
    console.log(updated_default_address);

    if (dataListAddresses != null) {
        const colDiv = document.createElement("div");
        colDiv.classList.add("addressItem", "position-relative", "swiper-slide");

        const label = document.createElement("label");
        label.setAttribute("for", "address-billing-1");
        label.classList.add("labelAddressItem", "cspt", "w-100", "h-100");

        const deliveryBox = document.createElement("span");
        deliveryBox.classList.add("delivery-address-box", "d-flex", "flex-column", "w-100", "h-100", "justify-content-between");

        const flexRow = document.createElement("div");
        flexRow.classList.add("d-flex", "flex-row", "w-100");

        const formCheck = document.createElement("span");
        formCheck.classList.add("form-check", "me-4");

        const radioInput = document.createElement("input");
        radioInput.classList.add("custom-radio");
        radioInput.setAttribute("id", "address-billing-1");
        radioInput.setAttribute("type", "radio");
        radioInput.setAttribute("name", "radioAddress");
        if (dataListAddresses['is_default']) {
            radioInput.setAttribute("checked", "checked");
        }

        formCheck.appendChild(radioInput);

        const addressDetail = document.createElement("span");
        addressDetail.classList.add("address-detail", "w-100", "h-100");

        const addressInfo = [
            { tag: "span", class: "address-title no-select", content: "Nhà" },
            {
                tag: "span",
                class: "address-home" + (!dataListAddresses['updated'] ? " text-danger" : ""),
                content: "<span class='address-tag no-select'>Họ tên:</span> " + dataListAddresses['full_name']
            },
            {
                tag: "span",
                class: "address-home" + (!dataListAddresses['updated'] ? " text-danger" : ""),
                content: "<span class='address-tag no-select'>Địa chỉ:</span> " + dataListAddresses['address']
            },
            {
                tag: "span",
                class: "address-home" + (!dataListAddresses['updated'] ? " text-danger" : ""),
                content: "<span class='address-tag no-select'>Số điện thoại:</span> " + dataListAddresses['phone']
            },
        ];

        addressInfo.forEach(info => {
            const addressSpan = document.createElement("span");
            addressSpan.classList.add("address");

            addressSpan.innerHTML = `<span class="${info.class}">${info.content}</span>`;
            addressDetail.appendChild(addressSpan);
        });

        flexRow.appendChild(formCheck);
        flexRow.appendChild(addressDetail);

        const buttons = document.createElement("span");
        buttons.classList.add("buttons", "d-flex", "flex-row", "justify-content-center");

        if (!dataListAddresses['is_default']) {
            const setDefaultButton = document.createElement("a");
            setDefaultButton.classList.add("btn", "btn-light", "btn-sm", "btn_set_default_address", "rounded-0");
            setDefaultButton.setAttribute("href", "javascript:void(0)");
            setDefaultButton.textContent = "Đặt mặc định";
            buttons.appendChild(setDefaultButton);
        }

        const editButton = document.createElement("a");
        editButton.classList.add("btn", "btn-dark", "btn-sm", "btn_edit_default_address", "rounded-0");
        editButton.setAttribute("href", "javascript:void(0)");
        editButton.setAttribute("data-bs-toggle", "modal");
        editButton.setAttribute("data-bs-target", "#edit-default-address-modal");
        editButton.setAttribute("title", "Edit default address");
        editButton.setAttribute("tabindex", "0");
        editButton.setAttribute("data-full_name", dataListAddresses['full_name']);
        editButton.setAttribute("data-phone", dataListAddresses['phone']);
        editButton.setAttribute("data-address", dataListAddresses['address']);
        editButton.textContent = "Chỉnh sửa";

        buttons.appendChild(editButton);


        deliveryBox.appendChild(flexRow);
        deliveryBox.appendChild(buttons);

        label.appendChild(deliveryBox);

        colDiv.appendChild(label);
        if (dataListAddresses['is_default']) {
            const spanElement = document.createElement("span");
            spanElement.classList.add(
                "position-absolute",
                "top-0",
                "rounded-start",
                "ps-1",
                "pe-1",
                "text-white"
            );
            spanElement.style.backgroundColor = "#cca270";
            spanElement.style.right = "0px";
            spanElement.textContent = "Default";

            colDiv.appendChild(spanElement);
        }


        listAddresses.appendChild(colDiv);

        //Tải những địa chỉ khác
        if (dataListAddresses['list_address_others']) {

            dataListAddresses['list_address_others'].forEach(function (addressOrtherItem, index) {
                const colDiv = document.createElement("div");
                colDiv.classList.add("swiper-slide", "addressItem", "position-relative");

                const label = document.createElement("label");
                label.setAttribute("for", "address-billing-" + index + 2);
                label.classList.add("labelAddressItem", "cspt", "w-100", "h-100");

                const deliveryBox = document.createElement("span");
                deliveryBox.classList.add("delivery-address-box", "d-flex", "flex-column", "w-100", "h-100", "justify-content-between");

                const flexRow = document.createElement("div");
                flexRow.classList.add("d-flex", "flex-row", "w-100");

                const formCheck = document.createElement("span");
                formCheck.classList.add("form-check", "me-4");

                const radioInput = document.createElement("input");
                radioInput.classList.add("custom-radio");
                radioInput.setAttribute("id", "address-billing-" + index + 2);
                radioInput.setAttribute("type", "radio");
                radioInput.setAttribute("name", "radioAddress");
                if (addressOrtherItem['is_default']) {
                    radioInput.setAttribute("checked", "checked");
                }

                formCheck.appendChild(radioInput);

                const addressDetail = document.createElement("span");
                addressDetail.classList.add("address-detail", "w-100", "h-100");

                const addressInfo = [
                    { tag: "span", class: "address-title no-select", content: "Khác" },
                    { tag: "span", class: "address-home no-select", content: "<span class='address-tag'>Họ tên:</span> " + addressOrtherItem['full_name'] },
                    { tag: "span", class: "address-home no-select", content: "<span class='address-tag'>Địa chỉ:</span> " + addressOrtherItem['address'] },
                    { tag: "span", class: "address-home no-select", content: "<span class='address-tag'>Số điện thoại:</span> " + addressOrtherItem['phone_number'] },
                ];

                addressInfo.forEach(info => {
                    const addressSpan = document.createElement("span");
                    addressSpan.classList.add("address");
                    addressSpan.innerHTML = `<span class="${info.class}">${info.content}</span>`;
                    addressDetail.appendChild(addressSpan);
                });

                flexRow.appendChild(formCheck);
                flexRow.appendChild(addressDetail);

                const buttons = document.createElement("span");
                buttons.classList.add("buttons", "d-flex", "flex-row", "justify-content-center");

                if (!addressOrtherItem['is_default']) {
                    const setDefaultButton = document.createElement("a");
                    setDefaultButton.classList.add("btn", "btn-light", "btn-sm", "btn_set_default_address_other", "rounded-0");
                    setDefaultButton.setAttribute("href", "javascript:void(0)");
                    setDefaultButton.setAttribute("data-id", addressOrtherItem['id']);
                    setDefaultButton.textContent = "Đặt mặc định";
                    buttons.appendChild(setDefaultButton);
                }

                const editButton = document.createElement("a");
                editButton.classList.add("btn", "btn-dark", "btn-sm", "btn_edit_address_other", "rounded-0");
                editButton.setAttribute("href", "javascript:void(0)");
                editButton.setAttribute("data-bs-toggle", "modal");
                editButton.setAttribute("data-bs-target", "#edit-address-modal");
                editButton.setAttribute("title", "Edit address");
                editButton.setAttribute("tabindex", "0");
                editButton.setAttribute("data-id", addressOrtherItem['id']);
                editButton.setAttribute("data-full_name", addressOrtherItem['full_name']);
                editButton.setAttribute("data-phone_number", addressOrtherItem['phone_number']);
                editButton.setAttribute("data-address", addressOrtherItem['address']);
                editButton.textContent = "Chỉnh sửa";

                const deleteButton = document.createElement("a");
                deleteButton.classList.add("btn", "btn-danger", "btn-sm", "btn_delete_address_other", "rounded-0");
                deleteButton.setAttribute("href", "javascript:void(0)");
                deleteButton.setAttribute("data-id", addressOrtherItem['id']);
                deleteButton.textContent = "Xoá";


                buttons.appendChild(editButton);
                buttons.appendChild(deleteButton);

                deliveryBox.appendChild(flexRow);
                deliveryBox.appendChild(buttons);

                label.appendChild(deliveryBox);

                colDiv.appendChild(label);

                if (addressOrtherItem['is_default']) {
                    const spanElement = document.createElement("span");
                    spanElement.classList.add(
                        "position-absolute",
                        "top-0",
                        "rounded-start",
                        "ps-1",
                        "pe-1",
                        "text-white"
                    );
                    spanElement.style.backgroundColor = "#cca270";
                    spanElement.style.right = "0px";
                    spanElement.textContent = "Default";

                    colDiv.appendChild(spanElement);
                }

                listAddresses.appendChild(colDiv);
            })
        }
    }
}
loadListAddresses();
//================================Thêm mới địa chỉ=================================
$('#add-address-form').on('submit', function (event) {
    event.preventDefault();

    // Lấy dữ liệu từ form
    let full_name = $('#add-address-form').find('input[name="full_name"]').val().trim();
    let phone_number = $('#add-address-form').find('input[name="phone_number"]').val().trim();
    let address = $('#add-address-form').find('textarea[name="address"]').val().trim();
    let _token = $('input[name="_token"]').val();
    let url = $(this).attr('action');

    // Gửi AJAX request
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            full_name: full_name,
            phone_number: phone_number,
            address: address,
            _token: _token
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Đóng modal sau khi thành công
                $('#add-address').modal('hide');
                // Hiển thị thông báo thành công
                notification('success', response.message, 'Successfully!', 2000);
                // Xóa dữ liệu trong các ô input
                $('#add-address-form')[0].reset();
                $('#create-address-modal').modal('hide');
                loadListAddresses();
            }
        },
        error: function (error) {
            // Xử lý lỗi trả về từ server (validation errors)
            if (error.responseJSON && error.responseJSON.errors) {
                let errors = error.responseJSON.errors;

                // Xóa các thông báo lỗi cũ
                $('.invalid-feedback').remove();
                $('.form-control').removeClass('is-invalid');

                for (let key in errors) {
                    let input = $('input[name="' + key + '"]');
                    let textarea = $('textarea[name="' + key + '"]');
                    let errorMessage = errors[key][0];

                    // Thêm thông báo lỗi cho input
                    if (input.length) {
                        input.addClass('is-invalid');
                        let feedbackElement = input.siblings('.invalid-feedback');
                        if (feedbackElement.length) {
                            feedbackElement.text(errorMessage);
                        } else {
                            input.after('<div class="invalid-feedback">' + errorMessage + '</div>');
                        }
                    }

                    // Thêm thông báo lỗi cho textarea
                    if (textarea.length) {
                        textarea.addClass('is-invalid');
                        let feedbackElements = textarea.siblings('.invalid-feedback');

                        if (feedbackElements.length) {
                            feedbackElements.text(errorMessage);
                        } else {
                            textarea.after('<div class="invalid-feedback">' + errorMessage + '</div>');
                        }
                    }
                }
            } else {
                console.error('Unknown error occurred');
            }
        }

    });
});

//=======================================Sửa địa chỉ=========================================
//Form địa chỉ mặc định
$('#edit-default-address-modal').on('hidden.bs.modal', function () {
    $('#edit-default-address-form')[0].reset();
    // Xóa các class lỗi (nếu cần)
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});

$(document).on('click', '.btn_edit_default_address', function () {
    let url = '/check-out/edit-default-address/';

    // Lấy thông tin hiện tại từ các thẻ HTML và điền vào form
    let fullName = $(this).data('full_name');
    let phone = $(this).data('phone');
    let address = $(this).data('address');

    $('#edit-default-address-form').find('input[name="full_name"]').val(fullName);
    $('#edit-default-address-form').find('input[name="phone"]').val(phone);
    $('#edit-default-address-form').find('textarea[name="address"]').val(address);
    $('#edit-default-address-form').attr('action', url);
})
//==================================================Xử lý cập nhật địa chỉ khi submit form======================================================
$('#edit-default-address-form').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let url = $(this).attr('action');

    $.ajax({
        url: url,
        type: 'PUT',
        data: formData,
        success: function (response) {
            $('#edit-default-address-modal').modal('hide');
            notification('success', response.message, 'Successfully!', 2000);
            loadListAddresses();
        },
        error: function (error) {
            console.log(error.responseText);

            if (error.responseJSON && error.responseJSON.errors) {
                let errors = error.responseJSON.errors;
                // Xóa lỗi cũ
                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                for (let key in errors) {
                    let input = $('input[name="' + key + '"]');
                    let textarea = $('textarea[name="' + key + '"]');
                    let errorMessage = errors[key][0];

                    // Thêm thông báo lỗi cho input
                    if (input.length) {
                        input.addClass('is-invalid');
                        let feedbackElement = input.siblings('.invalid-feedback');
                        if (feedbackElement.length) {
                            feedbackElement.text(errorMessage);
                        } else {
                            input.after('<div class="invalid-feedback">' +
                                errorMessage + '</div>');
                        }
                    }

                    // Thêm thông báo lỗi cho textarea
                    if (textarea.length) {
                        textarea.addClass('is-invalid');
                        let feedbackElements = textarea.siblings(
                            '.invalid-feedback');
                        if (feedbackElements.length) {
                            feedbackElements.text(errorMessage);
                        } else {
                            textarea.after('<div class="invalid-feedback">' +
                                errorMessage + '</div>');
                        }
                    }
                }
            } else {
                console.error('Unknown error occurred');
            }
        }
    });
});

//Form địa chỉ khác
$('#edit-address-modal').on('hidden.bs.modal', function () {
    $('#edit-address-form')[0].reset();
    // Xóa các class lỗi (nếu cần)
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
});

$(document).on('click', '.btn_edit_address_other', function () {
    let id = $(this).data('id');
    let url = '/check-out/edit-address/' + id;

    // Lấy thông tin hiện tại từ các thẻ HTML và điền vào form
    let fullName = $(this).data('full_name');
    let phoneNumber = $(this).data('phone_number');
    let address = $(this).data('address');

    $('#edit-address-form').find('input[name="full_name"]').val(fullName);
    $('#edit-address-form').find('input[name="phone_number"]').val(phoneNumber);
    $('#edit-address-form').find('textarea[name="address"]').val(address);
    $('#edit-address-form').attr('action', url);
})

$('#edit-address-form').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let url = $(this).attr('action');

    $.ajax({
        url: url,
        type: 'PUT',
        data: formData,
        success: function (response) {
            $('#edit-address-modal').modal('hide');
            notification('success', response.message, 'Successfully!', 2000);
            loadListAddresses();
        },
        error: function (error) {
            console.log(error.responseText);

            if (error.responseJSON && error.responseJSON.errors) {
                let errors = error.responseJSON.errors;
                // Xóa lỗi cũ
                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                for (let key in errors) {
                    let input = $('input[name="' + key + '"]');
                    let textarea = $('textarea[name="' + key + '"]');
                    let errorMessage = errors[key][0];

                    // Thêm thông báo lỗi cho input
                    if (input.length) {
                        input.addClass('is-invalid');
                        let feedbackElement = input.siblings('.invalid-feedback');
                        if (feedbackElement.length) {
                            feedbackElement.text(errorMessage);
                        } else {
                            input.after('<div class="invalid-feedback">' +
                                errorMessage + '</div>');
                        }
                    }

                    // Thêm thông báo lỗi cho textarea
                    if (textarea.length) {
                        textarea.addClass('is-invalid');
                        let feedbackElements = textarea.siblings(
                            '.invalid-feedback');
                        if (feedbackElements.length) {
                            feedbackElements.text(errorMessage);
                        } else {
                            textarea.after('<div class="invalid-feedback">' +
                                errorMessage + '</div>');
                        }
                    }
                }
            } else {
                console.error('Unknown error occurred');
            }
        }
    });
});
//Xử lý xóa địa chỉ
$(document).on('click', '.btn_delete_address_other', function () {
    var address_id = $(this).data('id');
    document.getElementById('delete-address-form').action = routeDeleteAddress(address_id);
    $('#delete-address-modal').modal('show');
})

$('#delete-address-form').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let url = $(this).attr('action');

    $.ajax({
        url: url,
        type: 'DELETE',
        data: formData,
        success: async function (response) {
            $('#delete-address-modal').modal('hide');
            if (response.success) {
                notification('success', response.message, 'Successfully!', 2000);

                await loadListAddresses();

                document.querySelectorAll('.addressItem').forEach(function (item) {
                    let input = $(item).find('input[type="radio"],input[type="checkbox"]');
                    if (input.is(':checked')) {
                        if (!$(item).find('.btn_edit_address_other').data('id')) {
                            data_to_place_order['address_id'] = null;
                        } else {
                            data_to_place_order['address_id'] = $(item).find('.btn_edit_address_other').data('id');
                        }
                    }
                })
            }
        },
        error: function (error) {
            console.log(error.responseText);
        }
    });
});
$(document).on('click', '.btn_set_default_address_other', function () {
    var address_id = $(this).data('id');
    $.ajax({
        url: routeSetDefaultAddressOther(address_id),
        type: 'PUT',
        data: {
            _token: csrf
        },
        success: async function (response) {
            if (response.success) {
                notification('success', response.message, 'Successfully!', 2000);
                loadListAddresses();
            }
        },
        error: function (error) {
            console.log(error.responseText);
        }
    });
})
$(document).on('click', '.btn_set_default_address', function () {
    $.ajax({
        url: routeSetDefaultAddress,
        type: 'PUT',
        data: {
            _token: csrf
        },
        success: function (response) {
            if (response.success) {
                notification('success', response.message, 'Successfully!', 2000);
                loadListAddresses();
            }
        },
        error: function (error) {
            console.log(error.responseText);
        }
    });
})
//Xử lý chọn địa chỉ
$(document).off('click', '.labelAddressItem').on('click', '.labelAddressItem', function (e) {
    let addressId = $(this).find('.btn_edit_address_other').data('id'); // Lấy ID của địa chỉ

    if (!addressId) {
        if ($(this).find('.btn_edit_default_address').length > 0) {
            data_to_place_order['address_id'] = null;
        }
    } else {
        data_to_place_order['address_id'] = addressId;
    }
});
//====================================Lấy dữ liệu thông tin đơn hàng=====================================
//Tổng tiền phụ
var base_sub_total = $('#base_sub_total').val(); // Lấy giá trị tổng tiền phụ ở ô input
var sub_total = $('#sub_total'); // Lấy thẻ hiển thị tổng tiền phụ
var new_sub_total = $('#new_sub_total'); //Lấy thẻ hiển thị tổng tiền phụ mới
var new_sub_total_value = base_sub_total; // Tạo biến lưu giá trị tổng tiền phụ mới


//Mã giảm giá mà người dùng đã áp dụng
var showVoucher = $('#showVoucher'); // Lấy thẻ hiển thị mã giảm giá mà người dùng áp dụng

//Phí vận chuyển
var free_ship_status = $('#free_ship_status').val();//Lấy trạng thái vận chuyển
var base_shipping_price = $('#shipping_price').val();//Phí vận chuyển mặc định
var shipping_price_reduced = free_ship_status ? base_shipping_price : 0; //Phí vận chuyển được giảm

var applied_shipping_voucher = false;
//Voucher
var voucher_reduced = 0;
var applied_voucher = false;
//Thuế
var base_tax = $('#base_tax').val();


var base_payment_total = $('#inputPaymentTotal').val();
var paymentTotal = $('#paymentTotal');
var newPaymentTotal = $('#newPaymentTotal');
var new_payment_total_value = base_payment_total;

var check_out_data = {};
function getBaseDataCheckOut() {
    var list_variants = [];
    $('.variant_item').each(function () {
        var variant_item = {};
        variant_item['id'] = $(this).find('.variant_id').val();
        variant_item['quantity'] = $(this).find('.variant_quantity').val();
        variant_item['total_price'] = $(this).find('.variant_total_price').val();
        list_variants.push(variant_item);
    })
    check_out_data['sub_total'] = base_sub_total;
    check_out_data['product_variants'] = list_variants;
}
getBaseDataCheckOut();

var data_to_place_order = {};
function update_data_to_place_order() {
    var list_variants = [];
    $('.variant_item').each(function () {
        var variant_item = {};
        variant_item['id'] = $(this).find('.variant_id').val();
        variant_item['value_variants'] = $(this).find('.variant_values').val();
        variant_item['quantity'] = $(this).find('.variant_quantity').val();
        variant_item['price'] = $(this).find('.variant_price').val();
        variant_item['reduced_price'] = null;
        list_variants.push(variant_item);
    })
    data_to_place_order['is_cart'] = $('#status_cart').val() ? true : false;
    data_to_place_order['product_variants'] = list_variants;
    data_to_place_order['total_cost'] = base_sub_total;
    data_to_place_order['shipping_price'] = base_shipping_price;
    data_to_place_order['shipping_voucher'] = shipping_price_reduced;
    data_to_place_order['voucher'] = null;
    data_to_place_order['voucher_id'] = null;
    data_to_place_order['tax'] = base_tax;
    data_to_place_order['total_payment'] = base_payment_total;
    data_to_place_order['payment_method'] = null;

    var is_default_address = false;
    var address_id = null;
    document.querySelectorAll('.addressItem').forEach(function (item) {
        let input = $(item).find('input[type="radio"],input[type="checkbox"]');
        if (input.is(':checked')) {
            if (!$(item).find('.btn_edit_address_other ').data('id')) {
                is_default_address = true;
            }
        }
    })
    if (!is_default_address) {
        document.querySelectorAll('.addressItem').forEach(function (item) {
            let input = $(item).find('input[type="radio"],input[type="checkbox"]');
            if (input.is(':checked')) {
                address_id = $(item).find('.btn_edit_address_other ').data('id');
            }
        })
        data_to_place_order['address_id'] = address_id;

    } else {
        data_to_place_order['address_id'] = null;
    }
}
setTimeout(() => {
    update_data_to_place_order();
}, 2000);


//=======================================Xử lý nhập voucher======================================
var appliedVoucherStatus = false;
var has_product = $('.variant_item').length > 0 ? true : false;

//Lấy dữ liệu voucher từ db
var voucher_data_from_controller = null;
function getVoucherByCode(voucherCode) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetVoucherByCode,
            method: "POST",
            data: {
                _token: csrf,
                check_out_data: check_out_data,
                voucher_code: voucherCode
            },
            success: function (response) {
                if (response.success) {
                    console.log(response.data);
                    voucher_data_from_controller = response.data;
                    notification('success', response.message, 'Successfully!', 2000);
                } else {
                    voucher_data_from_controller = null;
                    notification('error', response.message, 'Error!', 2000);
                }
                resolve();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}
var variant_item_already_updated = [];
$(document).on('click', '#btnApplyVoucher', async function () {
    $('.container-spinner').removeClass('hidden');
    try {
        if (has_product) {
            if (!appliedVoucherStatus) {
                var voucherCode = $(this).closest('.coupon-code').find('#inputApplyVoucher').val();
                if (voucherCode != "") {
                    await getVoucherByCode(voucherCode);
                    if (voucher_data_from_controller != null) {
                        var voucher_id = voucher_data_from_controller['voucher_id'];
                        if (voucher_data_from_controller['type'] == "free_ship") {
                            var amount = voucher_data_from_controller['amount'];
                            if (amount >= base_shipping_price) {
                                shipping_price_reduced = base_shipping_price;
                                //Hiển thị tiêu đề
                                $('#titleAppliedDiscounts').removeClass('hidden');
                                //Hiển thị giá trị vận chuyển được giảm từ voucher
                                $('#liShippingVoucher').removeClass('hidden').find('#shipping_voucher').text(formatCurrency(shipping_price_reduced));
                                //Fix cứng mã voucher vào ô nhập mã voucher
                                $('#showVoucher').removeClass('hidden').find('#voucherCode').text(voucherCode);
                                //Tính số tiền thanh toán mới
                                new_payment_total_value = base_payment_total - shipping_price_reduced;
                                //Thêm gạch ngang vào giá thanh toán cũ và hiển thị giá thanh toán mới
                                $('#paymentTotal').addClass('text-decoration-line-through');
                                $('#newPaymentTotal').removeClass('hidden').text(formatCurrency(new_payment_total_value));

                                data_to_place_order['shipping_voucher'] = shipping_price_reduced;
                                //Đặt trạng thái áp dụng voucher là true
                                appliedVoucherStatus = true;
                                applied_shipping_voucher = true;
                            } else {
                                shipping_price_reduced = amount;
                                //Hiển thị tiêu đề
                                $('#titleAppliedDiscounts').removeClass('hidden');
                                //Hiển thị giá trị vận chuyển được giảm từ voucher
                                $('#liShippingVoucher').removeClass('hidden').find('#shipping_voucher').text(formatCurrency(shipping_price_reduced));
                                //Fix cứng mã voucher vào ô nhập mã voucher
                                $('#showVoucher').removeClass('hidden').find('#voucherCode').text(voucherCode);
                                //Tính số tiền thanh toán mới
                                new_payment_total_value = base_payment_total - shipping_price_reduced;
                                //Thêm gạch ngang vào giá thanh toán cũ và hiển thị giá thanh toán mới
                                $('#paymentTotal').addClass('text-decoration-line-through');
                                $('#newPaymentTotal').removeClass('hidden').text(formatCurrency(new_payment_total_value));

                                data_to_place_order['shipping_voucher'] = shipping_price_reduced;
                                //Đặt trạng thái áp dụng voucher là true
                                appliedVoucherStatus = true;
                                applied_shipping_voucher = true;
                            }
                        } else {
                            var cumulative_discount = 0;
                            var total_price_of_product = 0;
                            $('.variant_item').each(function () {
                                var variant_item = $(this);
                                var variant_id = variant_item.find('.variant_id').val();
                                // var variant_quantity = variant_item.find('.variant_quantity').val();
                                var variant_total_price = variant_item.find('.variant_total_price').val();
                                voucher_data_from_controller['variant_data'].forEach(function (variant_item_from_controlller) {
                                    if (variant_item_from_controlller)
                                        if (variant_item_from_controlller['variant_id'] == variant_id && !variant_item_already_updated.includes(variant_id)) {
                                            variant_item_already_updated.push(variant_id);
                                            total_price_of_product += variant_total_price;
                                            var value_reduced = 0;
                                            var reduce_price = variant_item_from_controlller['reduce_price'];
                                            if (variant_total_price > cumulative_discount + reduce_price) {
                                                value_reduced = cumulative_discount + reduce_price;
                                                variant_item.find('.p_value_reduced').removeClass('hidden').find('.value_reduced').text(formatCurrency(value_reduced));
                                                cumulative_discount = 0;
                                                voucher_reduced += parseFloat(value_reduced);
                                            } else if (variant_total_price < cumulative_discount + reduce_price) {
                                                console.log(cumulative_discount);
                                                value_reduced = variant_total_price;
                                                cumulative_discount = (reduce_price + cumulative_discount) - value_reduced;
                                                variant_item.find('.p_value_reduced').removeClass('hidden').find('.value_reduced').text(formatCurrency(value_reduced));
                                                voucher_reduced += parseFloat(value_reduced);
                                            } else {
                                                console.log(cumulative_discount);
                                                value_reduced = cumulative_discount + reduce_price;
                                                variant_item.find('.p_value_reduced').removeClass('hidden').find('.value_reduced').text(formatCurrency(value_reduced));
                                                cumulative_discount = 0;
                                                voucher_reduced += parseFloat(value_reduced);
                                            }
                                            data_to_place_order['product_variants'].forEach(function (item) {
                                                if (item['id'] == variant_id) {
                                                    item['reduced_price'] = value_reduced;
                                                }
                                            })
                                        }
                                })
                            })
                            console.log(voucher_reduced);
                            $('#titleAppliedDiscounts').removeClass('hidden');
                            if (voucher_reduced >= total_price_of_product) {
                                new_sub_total_value = base_sub_total - total_price_of_product;
                                $('#sub_total').addClass('text-decoration-line-through');
                                $('#new_sub_total').removeClass('hidden').text(formatCurrency(new_sub_total_value));
                                $('#liVoucher').find('#voucher').text(formatCurrency(total_price_of_product));
                            } else {
                                new_sub_total_value = base_sub_total - voucher_reduced;
                                $('#sub_total').addClass('text-decoration-line-through');
                                $('#new_sub_total').removeClass('hidden').text(formatCurrency(new_sub_total_value));
                                $('#liVoucher').find('#voucher').text(formatCurrency(voucher_reduced));
                            }

                            new_payment_total_value = parseFloat(new_sub_total_value) + parseFloat(base_tax) + parseFloat(base_shipping_price) - (parseFloat(shipping_price_reduced));

                            $('#paymentTotal').addClass('text-decoration-line-through');
                            $('#newPaymentTotal').removeClass('hidden').text(formatCurrency(new_payment_total_value));

                            $('#showVoucher').removeClass('hidden').find('#voucherCode').text(voucherCode);

                            $('#liVoucher').removeClass('hidden');

                            data_to_place_order['voucher'] = voucher_reduced;

                            appliedVoucherStatus = true;
                            applied_voucher = true;
                        }
                        data_to_place_order['voucher_id'] = voucher_id;
                        data_to_place_order['total_cost'] = new_sub_total_value;
                        data_to_place_order['total_payment'] = new_payment_total_value;
                    }
                } else {
                    notification('warning', 'Vui lòng không để trống trường nhập!', 'Warning!', 2000);
                }
            } else {
                notification('warning', 'Đã áp dụng voucher!', 'Cảnh báo!', 2000);
            }
        } else {
            notification('warning', 'Vui lòng quay lại giỏ hàng hoặc chi tiết sản phẩm để tiến hành mua sản phẩm!', 'Cảnh báo!', 2000);
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

$(document).on('click', '#cancelVoucher', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        if (applied_shipping_voucher == true) {
            shipping_price_reduced = free_ship_status ? base_shipping_price : 0;
            data_to_place_order['shipping_voucher'] = shipping_price_reduced;
            $('#liShippingVoucher').addClass('hidden');
            applied_shipping_voucher = false;
        } else if (applied_voucher = true) {
            voucher_reduced = 0;
            $('.variant_item').each(function () {
                var variant_id = $(this).find('.variant_id').val();
                var p_value_reduced = $(this).find('.p_value_reduced');
                if (!p_value_reduced.hasClass('hidden')) {
                    p_value_reduced.addClass('hidden');
                }
                variant_item_already_updated = variant_item_already_updated.filter(function (item) {
                    return item != variant_id;
                })
                data_to_place_order['product_variants'].forEach(function (item) {
                    if (item['id'] == variant_id) {
                        item['reduced_price'] = null;
                    }
                })
            })
            $('#sub_total').removeClass('text-decoration-line-through');
            $('#new_sub_total').addClass('hidden');
            $('#liVoucher').addClass('hidden');
            data_to_place_order['voucher'] = null;
            applied_voucher = false;
        }
        data_to_place_order['voucher_id'] = null;
        data_to_place_order['total_payment'] = base_payment_total;
        $('#inputApplyVoucher').val('');
        free_ship_status == false ? $('#titleAppliedDiscounts').addClass('hidden') : "";
        $('#showVoucher').addClass('hidden');

        $('#paymentTotal').removeClass('text-decoration-line-through');
        $('#newPaymentTotal').addClass('hidden');
        new_payment_total_value = base_payment_total;

        appliedVoucherStatus = false;
        notification('success', 'Bỏ áp dụng voucher thành công!', 'Successfully!', 2000);
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

$(document).on('click', '.payment-box', function () {
    data_to_place_order['payment_method'] = $(this).find('.custom-radio').attr('id');
})

//===============================================Tạo đơn hàng==============================================
function storeOrder(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeStoreOrder,
            method: "POST",
            data: {
                _token: csrf,
                data_to_store_order: data
            },
            success: function (response) {
                if (response.success) {
                    // console.log(response.data);
                    // return;
                    if (response.data['payment_method'] == "cod") {
                        $('#form_cod').attr('action', 'order-success/' + response.data['order_id']);
                        $('#form_cod').submit();
                    } else if (response.data['payment_method'] == "vnpay") {
                        $('#form_vnpay').find('.order_id').val(response.data['order_id']);
                        $('#form_vnpay').find('.amount').val(response.data['amount']);
                        $('#form_vnpay').submit();
                    } else if (response.data['payment_method'] == "momo") {
                        $('#form_momo').find('.order_id').val(response.data['order_id']);
                        $('#form_momo').find('.amount').val(response.data['amount']);
                        $('#form_momo').submit();
                    }
                } else {
                    notification('error', response.message, 'Error!', 3000);
                }
                resolve();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                reject();
            }
        })
    })
}

// ===================================================Đặt hàng==================================================
$('#place_order').on('click', async function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var check = true;
        // console.log(data_to_place_order);
        // return;

        var selected_payment_method = false;
        var payment_method = null;

        var is_default_address = false;
        var address_id = null;

        //Lấy phương thức thanh toán
        document.querySelectorAll('.payment-box').forEach(function (item) {
            let input = $(item).find('input[type="radio"], input[type="checkbox"]');
            if (input.is(':checked')) {
                selected_payment_method = true;
                payment_method = input.attr('id');
                data_to_place_order['payment_method'] = payment_method;
            }
        })
        //Lấy địa chỉ
        document.querySelectorAll('.addressItem').forEach(function (item) {
            let input = $(item).find('input[type="radio"],input[type="checkbox"]');
            if (input.is(':checked')) {
                if (!$(item).find('.btn_edit_address_other').data('id')) {
                    is_default_address = true;
                }
            }
        })

        if (is_default_address) {
            if (!updated_default_address) {
                check = false;
                notification('warning', 'Vui lòng cập nhật địa chỉ của bạn!', 'Warning', 3000);
            }
        } else {
            document.querySelectorAll('.addressItem').forEach(function (item) {
                let input = $(item).find('input[type="radio"],input[type="checkbox"]');
                if (input.is(':checked')) {
                    address_id = $(item).find('.btn_edit_address_other ').data('id');
                }
            })
        }

        if (!selected_payment_method) {
            check = false;
            notification('warning', "Vui lòng chọn phương thức thanh toán!", "Warning!", 3000);
        }
        if (!is_default_address && address_id == null) {
            check = false;
            notification('warning', 'Vui lòng chọn địa chỉ nhận hàng!', 'Warning', 3000);
        }
        if (!has_product) {
            check = false;
            notification('error', 'Vui lòng thêm sản phẩm để tiến hành đặt hàng!', 'Error!', 3000);
        }
        //Nếu tất cả dữ liệu đều hợp lệ thì chạy tiếp
        if (check) {
            await storeOrder(data_to_place_order);
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

