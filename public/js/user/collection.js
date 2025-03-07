let allProducts = []; // Biến để lưu trữ danh sách sản phẩm

$(document).ready(function() {
    fetchProducts();

    function fetchProducts() {
        $.ajax({
            url: '/api/products', // Đường dẫn API
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                allProducts = data; // Lưu trữ sản phẩm vào biến
                displayProducts(allProducts); // Hiển thị tất cả sản phẩm ban đầu
            },
            error: function(xhr, status, error) {
                console.error("Có lỗi xảy ra:", error);
            }
        });
    }

    // Hàm tìm kiếm sản phẩm
    // $(document).on('change','#search-input',function(){
    //     var valueInput = $(this).val();
    //     console.log(valueInput);
    // })


    window.filterProducts = function() {
        const searchInput = $('#search-input').val().toLowerCase();
        const filteredProducts = allProducts.filter(product => product.name.toLowerCase().includes(searchInput));



        displayProducts(filteredProducts); // Hiển thị sản phẩm đã lọc
    };

   
});



function toggleChildCategories(categoryId) {
    // Lấy trạng thái của danh mục cha
    let parentCheckbox = document.getElementById('category' + categoryId);
    let isChecked = parentCheckbox.checked;

    // Lấy tất cả các checkbox con của danh mục cha
    let childCheckboxes = document.querySelectorAll(`input[data-parent='${categoryId}']`);

    // Chọn hoặc bỏ chọn tất cả các danh mục con
    childCheckboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
        // Nếu danh mục con cũng có con, thực hiện đệ quy để chọn/bỏ chọn chúng
        toggleChildCategories(checkbox.getAttribute('data-id'));
    });
}

function filterByCategory() {
    const selectedCategories = [];
    const checkboxes = document.querySelectorAll('.custom-checkbox:checked');

    checkboxes.forEach((checkbox) => {
        selectedCategories.push(checkbox.value);
    });

    // Kiểm tra xem có danh mục nào được chọn không
    const apiUrl = selectedCategories.length > 0
        ? `/api/categories/products?categories=${selectedCategories.join(',')}`
        : `/api/products`; // API lấy tất cả sản phẩm

    // Gửi yêu cầu AJAX
    $.ajax({
        url: apiUrl,
        method: 'GET',
        success: function(response) {
            const allProducts = response.listProduct || response; // Chọn sản phẩm từ phản hồi
            displayProducts(allProducts); // Hiển thị sản phẩm
        },
        error: function(xhr) {
            console.error("Có lỗi xảy ra: ", xhr);
        }
    });
}



        
        // Hàm hiển thị sản phẩm
function displayProducts(products) {
    const productContainer = document.querySelector('.grid-section'); // Chọn nơi hiển thị sản phẩm
    productContainer.innerHTML = ''; // Xóa sản phẩm cũ

    if (products.length === 0) {
        // Nếu không có sản phẩm, hiển thị thông báo
        productContainer.innerHTML = '<p>Không có sản phẩm nào</p>';
        return;
     }

            products.forEach(product => {
                const productHTML = `
                    <div class="col">
                        <div class="product-box-3">
                            <div class="img-wrapper">
                                <div class="label-block">
                                    <a class="label-2 wishlist-icon" href="javascript:void(0)">
                                        <i class="iconsax" data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i>
                                    </a>
                                </div>
                                <div class="product-image">
                                    <a class="pro-first" href="product.html">
                                        <img class="bg-img" src="${product.image_url}" alt="${product.name}">
                                    </a>
                                    <a class="pro-sec" href="product.html">
                                        <img class="bg-img" src="${product.image_url}" alt="${product.name}">
                                    </a>
                                </div>
                                <div class="cart-info-icon">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart">
                                        <i class="iconsax" data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to card"></i>
                                    </a>
                                    <a href="compare.html">
                                        <i class="iconsax" data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Compare"></i>
                                    </a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view">
                                        <i class="iconsax" data-icon="eye" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-detail">
                                <ul class="rating">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                    <li>4.3</li>
                                </ul>
                                <a href="product.html">
                                    <h6>${product.name}</h6>
                                </a>
                                <p class="list-per">${product.description}</p>
                                <p>$${product.price} <del>$${product.original_price}</del></p>
                                <div class="listing-button">
                                    <a class="btn" href="cart.html">Quick Shop</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                productContainer.innerHTML += productHTML; // Thêm sản phẩm vào container
            });
        }
        
        
        // Thêm event listener cho checkbox
        document.querySelectorAll('.custom-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', filterByCategory);
        });
        
        

// function filterByCategory() {
//     const selectedCategories = [];
//     const checkboxes = document.querySelectorAll('.custom-checkbox:checked');
//     checkboxes.forEach((checkbox) => {
//         selectedCategories.push(checkbox.nextElementSibling.textContent);
//     });
//     // Thực hiện gọi API hoặc filter sản phẩm ở đây
//     console.log(selectedCategories);
// }


// let listAllProduct = [];
// Lấy danh sách sản phẩm bằng AJAX
// $.ajax({
//     url: '/api/products', // Đường dẫn API để lấy danh sách sản phẩm
//     type: 'GET',
//     dataType: 'json',
//     success: function (data) {
//         listAllProduct = data; // Lưu danh sách sản phẩm vào biến
//         renderProducts(listAllProduct); // Hiển thị sản phẩm lên trang
//     },
//     error: function (error) {
//         console.error("Lỗi khi tải danh sách sản phẩm:", error);
//     }
// });

// // Hàm hiển thị sản phẩm
// function renderProducts(products) {
//     const productGrid = document.querySelector('.grid-section');
//     productGrid.innerHTML = ""; // Xóa nội dung hiện tại

//     products.forEach(product => {
//         // Tạo HTML cho mỗi sản phẩm
//         const productHTML = `
//             <div>
//                 <div class="product-box-3">
//                     <div class="img-wrapper">
//                         <div class="label-block">
//                             <a class="label-2 wishlist-icon" href="javascript:void(0)">
//                                 <i class="iconsax" data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i>
//                             </a>
//                         </div>
//                         <div class="product-image">
//                             <a class="pro-first" href="product.html">
//                                 <img class="bg-img" src="../assets/images/product/product-3/20.jpg" alt="product">
//                             </a>
//                             <a class="pro-sec" href="product.html">
//                                 <img class="bg-img" src="../assets/images/product/product-3/3.jpg" alt="product">
//                             </a>
//                         </div>
//                         <div class="cart-info-icon">
//                             <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart">
//                                 <i class="iconsax" data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to card"></i>
//                             </a>
//                             <a href="compare.html">
//                                 <i class="iconsax" data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Compare"></i>
//                             </a>
//                             <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view">
//                                 <i class="iconsax" data-icon="eye" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i>
//                             </a>
//                         </div>
//                     </div>
//                     <div class="product-detail">
//                         <ul class="rating">
//                             <li><i class="fa-solid fa-star"></i></li>
//                             <li><i class="fa-solid fa-star"></i></li>
//                             <li><i class="fa-solid fa-star"></i></li>
//                             <li><i class="fa-solid fa-star"></i></li>
//                             <li><i class="fa-solid fa-star-half-stroke"></i></li>
//                             <li>4.3</li>
//                         </ul>
//                         <a href="product.html">
//                             <h6>${product.name}</h6>
//                         </a>
//                         <p class="list-per">${product.description}</p>
//                         <p>$190.00 <del>$210.00</del></p>
//                         <div class="listing-button">
//                             <a class="btn" href="cart.html">Quick Shop</a>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         `;
//         productGrid.innerHTML += productHTML; // Thêm sản phẩm vào lưới
//     });
// }





// function initializeProducts() {
//     const products = document.querySelectorAll('.product-box-3');
//     allProducts = Array.from(products);
// }

// function filterProducts() {
//     let input = document.getElementById('search-input').value.toLowerCase();
//     let productGrid = document.querySelector('.grid-section');
//     if (input === "") {
//         productGrid.innerHTML = "";
//         allProducts.forEach(function (product) {
//             productGrid.appendChild(product);
//         });
//         return;
//     }
//     let matchingProducts = [];
//     allProducts.forEach(function (product) {
//         let productName = product.querySelector('h6').innerText.toLowerCase();
//         if (productName.includes(input)) {
//             matchingProducts.push(product);
//         }
//     });
//     productGrid.innerHTML = "";
//     matchingProducts.forEach(function (product) {
//         productGrid.appendChild(product);
//     });
// }
// document.addEventListener('DOMContentLoaded', initializeProducts);

// //lọc sản phẩm theo danh mục

// //hiển thị danh mục
// function toggleChildCategories(categoryId) {
//     // Lấy trạng thái checked của danh mục cha
//     let isChecked = document.getElementById(`category${categoryId}`).checked;

//     // Lấy tất cả các checkbox
//     let checkboxes = document.querySelectorAll('input[name="categories[]"]');

//     // Lặp qua tất cả các checkbox
//     checkboxes.forEach(function (checkbox) {
//         // Kiểm tra nếu checkbox có data-parent là categoryId
//         if (checkbox.getAttribute('data-parent') == categoryId) {
//             checkbox.checked = isChecked; // Cập nhật trạng thái giống như danh mục cha

//             // Đệ quy: nếu danh mục này có con, tiếp tục chọn/bỏ chọn các con của nó
//             toggleChildCategories(checkbox.getAttribute('data-id'));
//         }
//     });
// }





// document.addEventListener('DOMContentLoaded', function () {
//     const checkboxes = document.querySelectorAll('input[name="categories[]"]');
//     checkboxes.forEach(checkbox => {
//         checkbox.addEventListener('change', filterProductsByCategory);
//     });
// });

// function filterProductsByCategory() {
//     //cái này lấy cái id danh mục đã chọn
//     let listAllProduct = []; 
//     $.ajax({
        
//     })




    // const selectedValues = Array.from(document.querySelectorAll('input[name="categories[]"]:checked')).map(
    //     checkbox => checkbox.value
    // );

    // if (selectedValues.length > 0) {
    //     console.log("Các danh mục đã chọn:", selectedValues);

    //     // Gọi AJAX để gửi danh mục đã chọn và nhận về danh sách sản phẩm
    //     $.ajax({
    //         type: 'GET', // Phương thức GET
    //         url: '{{ url(' / collection') }}', // URL route xử lý yêu cầu
    //         data: {
    //             categories: selectedValues.join(',') // Chuyển mảng danh mục thành chuỗi để gửi
    //         },
    //         success: function (response) {
    //             // Kiểm tra xem response có dữ liệu sản phẩm không
    //             if (response.listProduct && response.listProduct.length > 0) {
    //                 console.log("Danh sách sản phẩm:", response.listProduct);

    //                 // Xóa danh sách sản phẩm hiện tại (nếu có)
    //                 $('#product-list').empty();

    //                 // Hiển thị danh sách sản phẩm mới
    //                 response.listProduct.forEach(product => {
    //                     // Kiểm tra xem sản phẩm có giá trị hợp lệ hay không
    //                     if (product.name && product.price) {
    //                         $('#product-list').append(
    //                             `<div class="product-box-3">
    //                                 <h6>${product.name}</h6>
    //                                 <p class="list-per">${product.description}</p>
    //                                 <p>$${product.price} <del>$${product.original_price}</del></p>
    //                                 <div class="listing-button">
    //                                     <a class="btn" href="cart.html">Quick Shop</a>
    //                                 </div>
    //                             </div>`
    //                         );
    //                     }
    //                 });
    //             } else {
    //                 console.log("Không có sản phẩm nào được tìm thấy cho danh mục đã chọn.");
    //                 // Hiển thị thông báo nếu không có sản phẩm
    //                 $('#product-list').empty().append('<p>Không có sản phẩm nào được tìm thấy.</p>');
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error("Có lỗi xảy ra:", error);
    //             // Hiển thị thông báo lỗi cho người dùng
    //             $('#product-list').empty().append('<p>Đã xảy ra lỗi trong quá trình tải sản phẩm.</p>');
    //         }
    //     });
    // } else {
    //     console.log("Không có danh mục nào được chọn.");
    //     // Xóa danh sách sản phẩm nếu không có danh mục nào được chọn
    //     $('#product-list').empty().append('<p>Vui lòng chọn ít nhất một danh mục.</p>');
    // }
// }