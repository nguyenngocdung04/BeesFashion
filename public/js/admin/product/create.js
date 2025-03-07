//---------------------------------------------------Show and hidden form---------------------------------------------------
function switchShowHidden(form, dataForm, chevron, statusFixed = "") {
    if (statusFixed == "") {
        var status = $(form).data(dataForm);

        if (status) {
            if (status === "show") {
                $(form).data(dataForm, 'hidden');
                $(form).addClass('hidden');
                if (chevron) {
                    $(chevron).removeClass('fa-chevron-up');
                    $(chevron).addClass('fa-chevron-down');
                }
            } else {
                $(form).data(dataForm, 'show');
                $(form).removeClass('hidden');
                if (chevron) {
                    $(chevron).addClass('fa-chevron-up');
                    $(chevron).removeClass('fa-chevron-down');
                }
            }
        } else {
            console.log(form);

            if (form.hasClass('hidden')) {
                $(form).removeClass('hidden');
            } else {
                $(form).addClass('hidden');
            }
        }

    } else {
        console.log(form);

        if (statusFixed === "show" && form.hasClass('hidden')) {
            $(form).removeClass('hidden');
        } else if (statusFixed === "hidden" && !form.hasClass('hidden')) {
            $(form).addClass('hidden');
        }
    }

}

function convertToSlug(str) {
    // Loại bỏ dấu và chuyển thành chữ thường
    str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // Thay thế các ký tự không phải là chữ và số thành dấu "-"
    str = str.replace(/[^a-zA-Z0-9]+/g, '-');

    // Chuyển chuỗi thành chữ thường
    str = str.toLowerCase();

    // Loại bỏ dấu "-" thừa ở đầu và cuối chuỗi
    str = str.replace(/^-+|-+$/g, '');

    return str;
}
//BASE PRODUCT
// switchShowHidden('#baseProduct', 'baseproduct', '#chevronBaseProduct');
// switchShowHidden('#customVariants', 'customvariants', '#chevronCustomVariants');
// switchShowHidden('#contentCategoryContainer', 'productcategory', '#chevronProductCategory');
// switchShowHidden('#contentBrandContainer', 'productbrand', '#chevronProductBrand');
$(document).on('click', '#baseProductSwitch', function () {
    switchShowHidden('#baseProduct', 'baseproduct', '#chevronBaseProduct');
});
//Open/close VARIATIONS
$(document).on('click', '#baseCustomVariantsSwitch', function () {
    switchShowHidden('#customVariants', 'customvariants', '#chevronCustomVariants');
});
$(document).on('click', '.productCategoryTitle', function () {
    switchShowHidden('#contentCategoryContainer', 'productcategory', '#chevronProductCategory');
});
$(document).on('click', '.productBrandTitle', function () {
    switchShowHidden('#contentBrandContainer', 'productbrand', '#chevronProductBrand');
});

//---------------------------------------------Load all categoies--------------------------------------------
var categories = [];
function getAllCategories() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetAllCategories,
            method: "POST",
            data: {
                _token: csrf
            },
            success: function (response) {
                categories = response.data;
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể lấy được dữ liệu danh mục sản phẩm!', 'Lỗi');
                reject();
            }
        });
    })
}

function createCategoryList(categories, indent = 0) {
    const container = document.createElement("div");
    container.classList.add("listCategories");

    categories.forEach(category => {
        // Tạo checkbox và label cho mỗi danh mục
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.className = "categoryItem";
        checkbox.id = category.id;
        checkbox.style.transform = 'scale(1.2)';

        const label = document.createElement("label");
        label.classList.add("m-0", "ml-2");
        label.textContent = category.name;

        // Tạo container cho mỗi category item
        const item = document.createElement("div");
        item.classList.add("d-flex", "flex-row", "align-items-center", "pl-2", "pr-2", "categoryItem");
        item.style.marginLeft = `${indent}px`;

        item.appendChild(checkbox);
        item.appendChild(label);
        container.appendChild(item);

        // Đệ quy với danh mục con
        if (category.subcategories && category.subcategories.length > 0) {
            const subcategories = createCategoryList(category.subcategories, indent + 20);
            container.appendChild(subcategories);
        }
    });

    return container;
}

// Gọi hàm và thêm danh mục vào HTML
async function loadCategories() {
    await getAllCategories();

    document.getElementById("contentCategory").appendChild(createCategoryList(categories));

    const selectElement = document.getElementById('selectNewCategory');
    selectElement.innerHTML = `<option value="">&mdash; Parent category &mdash;</option>` + createCategoryOptions(categories);
}
loadCategories();
//-----------------------------------------Open/close form add category------------------------------------
$(document).on('click', '#btnOpenCloseFormAddCategory', function () {
    if ($(this).next('.formAddNewCategory').hasClass('hidden')) {
        $(this).next('.formAddNewCategory').removeClass('hidden');
    } else {
        $(this).next('.formAddNewCategory').addClass('hidden');
    }
})
//--------------------------------------Add category in select parent category--------------------------------
function createCategoryOptions(categories, level = 0) {
    let options = "";

    categories.forEach(category => {
        // Tạo độ thụt lề cho từng cấp bằng cách thêm các khoảng trắng
        const indent = "&nbsp;".repeat(level * 3); // mỗi cấp sẽ có thêm 3 khoảng trắng
        options += `<option class="level-${level}" value="${category.id}">${indent}${category.name}</option>`;

        // Gọi đệ quy để thêm các danh mục con nếu có
        if (category.subcategories && category.subcategories.length > 0) {
            options += createCategoryOptions(category.subcategories, level + 1);
        }
    });

    return options;
}

//--------------------------------------Add new category by ajax-------------------------------------
function createNewCategoryByAjax(name, parent_id) {
    if (parent_id) {
        $.ajax({
            url: routeCreateNewCategory,
            method: "POST",
            data: {
                _token: csrf,
                category_name: name,
                parent_category_id: parent_id
            },
            success: function (response) {

            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể tạo mới danh mục, vui lòng thử lại!', 'Lỗi');
                reject();
            }
        });
    } else {
        $.ajax({
            url: routeCreateNewCategory,
            method: "POST",
            data: {
                _token: csrf,
                category_name: name
            },
            success: function (response) {

            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể tạo mới danh mục, vui lòng thử lại!', 'Lỗi');
                reject();
            }
        });
    }
}
$(document).on('click', '#addNewCategoryBtn', async function () {
    var categoryName = $('.categoryName').val();
    var parentCategoryId = $('#selectNewCategory').val();
    if (categoryName) {
        if (parentCategoryId) {
            $('.container-spinner').removeClass('hidden');
            try {
                await createNewCategoryByAjax(categoryName, parentCategoryId);
                $('#contentCategory').find('.listCategories')[0].remove();
                $('#selectNewCategory').html('');
                loadCategories();
                $('.categoryName').val('');
            } catch (error) {
                console.error('Error:', error);
            } finally {
                $('.container-spinner').addClass('hidden');
                notification('success', 'Tạo mới danh mục thành côngcông!', 'Thành công!', '1000');
            }
        } else {
            $('.container-spinner').removeClass('hidden');
            try {
                await createNewCategoryByAjax(categoryName, '');
                $('#contentCategory').find('.listCategories')[0].remove();
                $('#selectNewCategory').html('');
                loadCategories();
                $('.categoryName').val('');
            } catch (error) {
                console.error('Error:', error);
            } finally {
                $('.container-spinner').addClass('hidden');
                notification('success', 'Tạo mới danh mục thành côngcông!', 'Thành công!', '1000');
            }
        }
    } else {
        notification('warning', 'Bạn cần nhập tên danh mục!', 'Cảnh báo!', '3000');
    }
})
//----------------------------------------------------Check category by ajax-----------------------------------------------------
function checkCategoryByAjax(categoryId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeCheckCategoryById,
            method: "POST",
            data: {
                _token: csrf,
                category_id: categoryId
            },
            success: function (response) {
                if (response.status == 200) {
                    resolve(true);
                } else {
                    notification('error', response.message, 'Lỗi!', '3000');
                    resolve(false);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                notification('error', 'Không thể kiểm tra danh mục bằng ID!', 'Lỗi!', '3000');
                reject();
            }
        })
    })
}
//-----------------------------------------------------Load brand by ajax-------------------------------------------------------------
var brands = [];
function getAllBrands() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetAllBrands,
            method: "POST",
            data: {
                _token: csrf
            },
            success: function (response) {
                if (response.status == 200) {
                    brands = response.data;
                    console.log(brands);
                } else {
                    console.log(response.message);
                }
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể lấy được dữ liệu thương hiệu!', 'Lỗi');
                reject();
            }
        });
    })
}
//-------------------------------------------------------Load all brand to html-----------------------------------------------------------
async function loadAllBrands() {
    await getAllBrands();
    if (brands.length > 0) {
        const container = document.createElement("div");
        container.classList.add("listBrands");
        brands.forEach(function (brand) {
            const checkbox = document.createElement("input");
            checkbox.type = "radio";
            checkbox.className = "brandItem";
            checkbox.id = brand.id;
            checkbox.name = "brand";
            checkbox.style.transform = 'scale(1.2)';

            const label = document.createElement("label");
            label.classList.add("m-0", "ml-2");
            label.textContent = brand.name;

            // Tạo container cho mỗi category item
            const item = document.createElement("div");
            item.classList.add("d-flex", "flex-row", "align-items-center", "pl-2", "pr-2", "brandItem");

            item.appendChild(checkbox);
            item.appendChild(label);
            container.appendChild(item);
        })
        document.getElementById("contentBrand").appendChild(container);
    } else {
        console.log("Không có thương hiệu nào để hiển thị!");
    }
}
loadAllBrands();
//----------------------------------------------------Create new brand by ajax------------------------------------------------------
var checkNewBrandName = true;
function createNewBrandByAjax(brandName) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeCreateNewBrand,
            method: "POST",
            data: {
                _token: csrf,
                brand_name: brandName,
            },
            success: function (response) {
                if (response.status == 409) {
                    checkNewBrandName = false;
                    notification('error', response.message, 'Lỗi!', '3000');
                    resolve(false);
                } else if (response.status == 200) {
                    checkNewBrandName = true;
                    resolve(true);
                } else {
                    notification('error', 'Có lỗi xảy ra khi tạo mới thương hiệu, vui lòng thử lại!', 'Lỗi!', '3000');
                    resolve(false);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể tạo mới thương hiệu, vui lòng thử lại!', 'Lỗi');
                reject(new Error('Ajax request failed'));
            }
        });
    });
}
//----------------------------------------------------Check brand by ajax-----------------------------------------------------
function checkBrandByAjax(brandId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeCheckBrandById,
            method: "POST",
            data: {
                _token: csrf,
                brand_id: brandId
            },
            success: function (response) {
                if (response.status == 200) {
                    resolve(true);
                } else {
                    notification('error', response.message, 'Lỗi!', '3000');
                    resolve(false);
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                notification('error', 'Không thể kiểm tra thương hiệu bằng ID!', 'Lỗi!', '3000');
                reject();
            }
        })
    })
}
//--------------------------------------------------------Add new brand------------------------------------------------------
$(document).on('click', '#addNewBrandBtn', async function () {
    checkNewBrandName = true;
    var brandName = $('.brandName').val();
    if (brandName) {
        $('.container-spinner').removeClass('hidden');
        try {
            const result = await createNewBrandByAjax(brandName);
            if (result && checkNewBrandName) {
                var listBrands = $('#contentBrand').find('.listBrands')[0];
                if (listBrands) {
                    listBrands.remove();
                }
                loadAllBrands();
                $('.brandName').val('');
                notification('success', 'Tạo mới thương hiệu thành công!', 'Thành công!', '1000');
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    } else {
        notification('warning', 'Bạn cần nhập tên thương hiệu!', 'Cảnh báo!', '3000');
    }
});

//-----------------------------------------Open/close form add brand------------------------------------
$(document).on('click', '#btnOpenCloseFormAddBrand', function () {
    if ($(this).next('.formAddNewBrand').hasClass('hidden')) {
        $(this).next('.formAddNewBrand').removeClass('hidden');
    } else {
        $(this).next('.formAddNewBrand').addClass('hidden');
    }
})
//---------------------------------------------------Upload images---------------------------------------------------
var imageName;
var mainImageFile = null;

var imageNames = [];
var selectedImages = [];
//Xử lý xem trước ảnh sau khi chọn ảnh
function previewImage(input) {
    const previewContainer = document.getElementById('mainImagePreview');

    const maxSizeMB = 2; // Giới hạn dung lượng tối đa (MB)
    const maxSizeBytes = maxSizeMB * 1024 * 1024; // Chuyển đổi sang byte

    if (input.files.length > 0) {
        const file = input.files[0];
        mainImageFile = file;
        if (file.size > maxSizeBytes) {
            notification('error', `Kích thước tệp vượt quá ${maxSizeMB}MB. Vui lòng chọn tệp nhỏ hơn.`, 'Lỗi');
            input.value = ''; // Reset input nếu ảnh quá lớn
            return;
        }
        $('.container-spinner').removeClass('hidden');
        try {
            if (imageName) {
                if (imageName != file.name) {
                    $('#mainImagePreview').find('.divImg').remove();
                    imageName = file.name;
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        //Tạo một khối mới để bọc img
                        const divBlock = document.createElement('div');
                        divBlock.className = 'position-relative divImg d-flex justify-content-center';
                        // Tạo một thẻ img mới
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'rounded p-1 col img ml-2 mb-2';
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.setAttribute('data-filename', file.name);
                        //Tạo một nút xóa
                        const removeImgBtn = document.createElement('i');
                        removeImgBtn.className = 'position-absolute fas fa-trash text-danger cs-pt';
                        removeImgBtn.style.cursor = 'pointer';
                        removeImgBtn.style.right = '-2px';
                        removeImgBtn.style.top = '-5px';
                        removeImgBtn.id = 'removeMainImgBtn';
                        //Thêm ảnh và nút xóa vào khối
                        divBlock.appendChild(img);
                        divBlock.appendChild(removeImgBtn);
                        // Thêm ảnh vào container
                        previewContainer.appendChild(divBlock);
                    }
                    reader.readAsDataURL(file);
                    notification('success', 'Ảnh đã được tải lên thành công!', 'Thành công', 2000);
                } else {
                    notification('warning', 'Ảnh đã tồn tại', 'Cảnh báo');
                };
            } else {
                imageName = file.name;
                const reader = new FileReader();
                reader.onload = function (e) {
                    //Tạo một khối mới để bọc img
                    const divBlock = document.createElement('div');
                    divBlock.className = 'position-relative divImg d-flex justify-content-center';
                    // Tạo một thẻ img mới
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded p-1 col img ml-2 mb-2';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.setAttribute('data-filename', file.name);
                    //Tạo một nút xóa
                    const removeImgBtn = document.createElement('i');
                    removeImgBtn.className = 'position-absolute fas fa-trash text-danger cs-pt';
                    removeImgBtn.style.cursor = 'pointer';
                    removeImgBtn.style.right = '-2px';
                    removeImgBtn.style.top = '-5px';
                    removeImgBtn.id = 'removeMainImgBtn';
                    //Thêm ảnh và nút xóa vào khối
                    divBlock.appendChild(img);
                    divBlock.appendChild(removeImgBtn);
                    // Thêm ảnh vào container
                    previewContainer.appendChild(divBlock);
                }
                reader.readAsDataURL(file);
                notification('success', 'Ảnh đã được tải lên thành công!', 'Thành công', 2000);
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    } else {
        $('#mainImagePreview').find('.divImg').remove();
        mainImageFile = null;
        imageName = '';
    }
    console.log(mainImageFile);
}
function previewImages(input) {
    const previewContainer = document.getElementById('imagePreview');

    const maxSizeMB = 2; // Giới hạn dung lượng tối đa (MB)
    const maxSizeBytes = maxSizeMB * 1024 * 1024; // Chuyển đổi sang byte
    $('.container-spinner').removeClass('hidden');
    try {
        if (input.files) {
            Array.from(input.files).forEach(file => {
                if (file.size > maxSizeBytes) {
                    notification('error', `Kích thước tệp vượt quá ${maxSizeMB}MB. Vui lòng chọn tệp nhỏ hơn.`, 'Lỗi');
                    input.value = ''; // Reset input nếu ảnh quá lớn
                    return;
                }
                if (!imageNames.includes(file.name)) {
                    imageNames.push(file.name);
                    selectedImages.push(file);
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        //Tạo một khối mới để bọc img
                        const divBlock = document.createElement('div');
                        divBlock.className = 'position-relative divImgs d-flex justify-content-center';
                        // Tạo một thẻ img mới
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'rounded p-1 col img ml-2 mb-2';
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.setAttribute('data-filename', file.name);
                        //Tạo một nút xóa
                        const removeImgBtn = document.createElement('i');
                        removeImgBtn.className = 'position-absolute fas fa-trash text-danger cs-pt';
                        removeImgBtn.style.cursor = 'pointer';
                        removeImgBtn.style.right = '-2px';
                        removeImgBtn.style.top = '-5px';
                        removeImgBtn.id = 'removeImgBtn';
                        //Thêm ảnh và nút xóa vào khối
                        divBlock.appendChild(img);
                        divBlock.appendChild(removeImgBtn);
                        // Thêm ảnh vào container
                        previewContainer.appendChild(divBlock);
                    }
                    reader.readAsDataURL(file);
                    notification('success', 'Ảnh đã được tải lên thành công!', 'Thành công', 2000);
                } else {
                    notification('warning', 'Ảnh đã tồn tại', 'Cảnh báo', 2000);
                };
            });
            // Reset lại giá trị của thẻ input sau khi xử lý
            input.value = '';
        }
        //Kiểm tra nếu có ảnh được tải lên thì hiển thị nút xóa tất cả
        if (imageNames.length != 0) {
            const removeAllImagesBtn = document.getElementById('removeAllImagesBtn');
            removeAllImagesBtn.style.display = 'block';
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
}
//------------------------------------------------------Xử lý xóa ảnh đơn (từng cái một)---------------------------------------------------
$(document).on('click', '#removeImgBtn', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        //Lấy thẻ img được xóa
        const imgElm = $(this).closest('.divImgs').find('.img');
        //Lấy tên file
        const imgSrcRemove = imgElm.data('filename');
        //Xóa tên file khỏi mảng lưu trữ tên file
        imageNames = imageNames.filter(function (item) {
            return item != imgSrcRemove;
        })
        //Xóa đối tượng file trong mảng lưu trữ files
        selectedImages = selectedImages.filter(function (item) {
            return item.name != imgSrcRemove;
        })
        //Nếu mảng rỗng (không còn ảnh nào) thì ẩn nút 'xóa tất cả'
        if (imageNames.length == 0) {
            const removeAllImagesBtn = document.getElementById('removeAllImagesBtn');
            removeAllImagesBtn.style.display = 'none';
        }
        //Xóa thẻ div bao bọc thẻ img được click xóa
        imgElm.closest('.divImgs').remove();
        notification('success', 'Ảnh đã được xóa thành công!', 'Thành công', 2000);
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
// -----------------------------------------------------Xóa ảnh chính của sản phẩm---------------------------------------------------
$(document).on('click', '#removeMainImgBtn', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        //Lấy thẻ img được xóa
        const imgElm = $(this).closest('.divImg').find('.img');
        //Đặt biến lưu trữ file thành rỗng
        imageName = '';
        //Đặt giá trị của thẻ input thành rỗng
        document.getElementById('imageUpload').value = '';
        //Xóa thẻ div bao bọc thẻ img được click xóa
        imgElm.closest('.divImg').remove();
        mainImageFile = null;
        notification('success', 'Ảnh đã được xóa thành công!', 'Thành công', 2000);
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

//----------------------------------------------------------Xử lý xóa tất cả ảnh-------------------------------------------------
$(document).on('click', '#removeAllImagesBtn', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        $('#imagePreview').find('.divImgs').remove();
        imageNames = [];
        selectedImages = [];
        const removeAllImagesBtn = document.getElementById('removeAllImagesBtn');
        removeAllImagesBtn.style.display = 'none';
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

//---------------------------------------------------Upload videos---------------------------------------------------

let videoNames = [];
let selectedVideos = [];
//Xử lý xem trước video sau khi chọn video
function previewVideos(input) {
    const previewContainer = document.getElementById('videoPreview');

    const maxSizeMB = 50; // Giới hạn dung lượng tối đa (MB)
    const maxSizeBytes = maxSizeMB * 1024 * 1024; // Chuyển đổi sang byte
    $('.container-spinner').removeClass('hidden');
    try {
        if (input.files) {
            Array.from(input.files).forEach(file => {
                if (file.size > maxSizeBytes) {
                    notification('error', `Kích thước tệp vượt quá ${maxSizeMB}MB. Vui lòng chọn tệp nhỏ hơn.`, 'Lỗi');
                    input.value = ''; // Reset input nếu video quá lớn
                    return;
                }

                if (!videoNames.includes(file.name)) {
                    videoNames.push(file.name);
                    selectedVideos.push(file);
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        //Tạo một khối mới để bọc video
                        const divBlock = document.createElement('div');
                        divBlock.className = 'position-relative divVideo d-flex justify-content-center';
                        // Tạo một thẻ video mới
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.className = 'rounded p-1 col video ml-2 mb-2';
                        video.width = 600;
                        video.style.objectFit = 'cover';
                        video.controls = true;
                        video.setAttribute('data-filename', file.name);
                        //Tạo một nút xóa
                        const removeVideoBtn = document.createElement('i');
                        removeVideoBtn.className = 'position-absolute fas fa-trash text-danger cs-pt';
                        removeVideoBtn.style.cursor = 'pointer';
                        removeVideoBtn.style.right = '-6px';
                        removeVideoBtn.style.top = '-5px';
                        removeVideoBtn.id = 'removeVideoBtn';
                        //Thêm video và nút xóa vào khối
                        divBlock.appendChild(video);
                        divBlock.appendChild(removeVideoBtn);
                        // Thêm video vào container
                        previewContainer.appendChild(divBlock);
                    }
                    reader.readAsDataURL(file);
                    notification('success', 'Video đã được tải lên thành công!', 'Thành công', 2000);
                } else {
                    notification('warning', 'Video đã tồn tại', 'Cảnh báo');
                };
            });
            // Reset lại giá trị của thẻ input sau khi xử lý
            input.value = '';
        }
        //Kiểm tra nếu có video được tải lên thì hiển thị nút xóa tất cả
        if (videoNames.length != 0) {
            const removeAllVideosBtn = document.getElementById('removeAllVideosBtn');
            removeAllVideosBtn.style.display = 'block';
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
}
//Xử lý xóa video đơn (từng cái một)
$(document).on('click', '#removeVideoBtn', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        //Lấy thẻ video được xóa
        const videoElm = $(this).closest('.divVideo').find('.video');
        //Lấy tên file
        const videoSrcRemove = videoElm.data('filename');
        //Xóa tên file khỏi mảng lưu trữ tên file
        videoNames = videoNames.filter(function (item) {
            return item != videoSrcRemove;
        })
        //Xóa đối tượng file trong mảng lưu trữ files
        selectedVideos = selectedVideos.filter(function (item) {
            return item.name != videoSrcRemove;
        })
        //Nếu mảng rỗng (không còn video nào) thì ẩn nút 'xóa tất cả'
        if (videoNames.length == 0) {
            const removeAllVideosBtn = document.getElementById('removeAllVideosBtn');
            removeAllVideosBtn.style.display = 'none';
        }
        //Xóa thẻ div bao bọc thẻ video được click xóa
        videoElm.closest('.divVideo').remove();
        notification('success', 'Video đã được xóa thành công!', 'Thành công', 2000);
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

//Xử lý xóa tất cả video
$(document).on('click', '#removeAllVideosBtn', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        $('#videoPreview').find('.divVideo').remove();
        videoNames = [];
        selectedVideos = [];
        const removeAllVideosBtn = document.getElementById('removeAllVideosBtn');
        removeAllVideosBtn.style.display = 'none';
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})


//---------------------------------------------------Variants---------------------------------------------------
//Initialize Select attributes
var slimSelectAddExisting;
// var slimSelectExistingAttributeValues;
$(function () {
    slimSelectAddExisting = new SlimSelect({
        select: '#selectAddExisting',
        settings: {
            placeholderText: 'Thêm thuộc tính đã có',
            keepOrder: true
        },
    });
});
//Load Attribute Data
let attributeDataOptions = [];
const seenAttributeIds = new Set();

function getAttributeData() {
    $.ajax({
        url: routeGetAllAttributes,
        method: "POST",
        data: {
            _token: csrf
        },
        success: function (response) {
            if (attributeDataOptions.length > 0) {
                response.data.forEach(function (item) {
                    if (!seenAttributeIds.has(item.id)) {
                        seenAttributeIds.add(item.id);
                        attributeDataOptions.push(item);
                    }
                });
            } else {
                response.data.forEach(function (item) {
                    seenAttributeIds.add(item.id);
                    attributeDataOptions.push(item);
                });
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            notification('error', 'Không thể lấy được dữ liệu thuộc tính, vui lòng thử lại!', 'Lỗi');
        }
    })
}
getAttributeData();
setInterval(getAttributeData, 5000);

$('#loadAttributeData').click(function () {
    var selectAddExisting = document.getElementById('selectAddExisting');

    var checkOption = $('#selectAddExisting').find('.optionSelectAddExisting');
    $('.container-spinner').removeClass('hidden');
    try {
        if (checkOption.length != 0) {
            $('#selectAddExisting').find('.optionSelectAddExisting').each(function () {
                if (attributeDataOptions.some(existingItem => existingItem.id === $(this).val())) {
                    attributeDataOptions.forEach(function (item) {
                        var option = document.createElement('option');
                        option.value = item['id'];
                        option.text = item['name'];
                        option.className = 'optionSelectAddExisting';
                        selectAddExisting.appendChild(option);
                    })
                }
            })
        } else {
            attributeDataOptions.forEach(function (item) {
                var option = document.createElement('option');
                option.value = item['id'];
                option.text = item['name'];
                option.className = 'optionSelectAddExisting';
                selectAddExisting.appendChild(option);
            })
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})

//-------------------------------------------------------------Handle event change options----------------------------------------------------------------
var selectStorage = {};
$('#selectAddExisting').off('change').on('change', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        //Tạo biến lưu trữ các thuộc tính đã được chọn
        const currentSelected = $(this).val() || [];
        //Tạo biến để lưu trữ tất cả các khối giao diện tùy chỉnh thuộc tính hiện có trên giao diện
        const attributeItem = $('.attributeItem');
        //Nếu có ít nhất 1 thuộc tính được chọn thì chạy tiếp
        if (currentSelected.length > 0) {
            //Lặp qua từng khối giao diện tùy chỉnh thuộc tính hiện có trên giao diện
            attributeItem.each(function () {
                //Lấy id của thuộc tính ví dụ 1, 2 ,3
                const attributeId = $(this).data('id');

                //Nếu id thuộc tính tồn tại thì chạy tiếp
                if (attributeId) {
                    var attributeIdStr = attributeId.toString();
                    //Tạo biến lưu trữ thuộc tính id của thẻ select của phần tử này
                    var idAttribute = $(this).find('.selectExistingAttributeValues').attr('id');
                    //Tạo biến để lưu trữ kết quả trả về, true nếu id của thuộc tính trong khối giao diện này nằm trong những giá trị đã chọn ở thẻ select, false nếu ngược lại
                    const existsInCurrentSelected = currentSelected.includes(attributeIdStr);
                    //Tạo biến để lưu trữ kết quả trả về, nếu true nếu id của thuộc tính trong khối giao diện này nằm trong biến lưu trữ những thuộc tính có sẵn trong db, false nếu ngược lại
                    const existsInAttributeDataOptions = attributeDataOptions.some(function (item) {
                        return item.id == attributeIdStr;
                    });
                    //Kiểm tra nếu phần tử này không nằm trong những giá trị ở thẻ select và nằm trong biến lưu trữ những thuộc tính có sẵn trong db thì xóa phần tử này đi
                    if (!existsInCurrentSelected && existsInAttributeDataOptions) {
                        //Nếu id thuộc tính của phần tử này tồn tại thì xóa nó khỏi đối tượng lưu trữ những thẻ select đã được khởi tạo bởi slim select
                        if (idAttribute) {
                            delete selectStorage[idAttribute];
                            // Xóa khỏi selectStorage khi thuộc tính bị xóa
                        }
                        $(this).remove(); //Xóa phần tử
                        var check = true;
                        $('.selectExistingAttributeValues').each(function () {
                            var getId = $(this).attr('id');
                            if (getId) {
                                var currentSelected = $(this).val();
                                if (!currentSelected.length) {
                                    check = false
                                    return false;
                                }
                            }
                        });

                        if (!check) {
                            attributeValuesSelectStatus = false;
                        } else {
                            attributeValuesSelectStatus = true;
                        }
                        if (attributeValuesTextareaStatus && attributeTitleInputStatus && attributeValuesSelectStatus) {
                            saveAttributesBtnStatus = true;
                            saveAttributesBtn.classList.remove('disabledButton'); // Bỏ lớp vô hiệu hóa khỏi nút lưu
                        } else {
                            saveAttributesBtnStatus = false;
                            saveAttributesBtn.classList.add('disabledButton'); // Thêm lớp vô hiệu hóa vào nút lưu
                        }
                    }
                }
            });
            //lặp qua tất cả các thuộc tính đã được chọn
            currentSelected.forEach(function (id) {
                //Nếu không tìm thấy phần tử nào có id thuộc tính đã chọn trong những thuộc tính đã chọn thì chạy tiếp
                if ($('#attributeItems').find(`.attributeItem[data-id="${id}"]`).length === 0) {
                    //Tạo biến lưu trữ tên thuộc tính được chọn nhưng chưa thêm vào giao diện
                    const optionText = $('#selectAddExisting option[value="' + id + '"]').text();
                    //Tạo biến lưu giao diện
                    var newElement = `
                <div class="border-bottom attributeItem" data-id="${id}" data-status="show">
                                    <div class="d-flex justify-content-between cspt border-bottom align-items-center p-1 attributeItemTittle no-select">
                                        <span class="d-flex align-items-center font-weight-bold text-dark commonTitle">${optionText}</span>
                                        <div class="d-flex align-items-center">
                                            <span class="text-danger cspt no-select mr-2" id="removeAttributeItem" style="font-size:14px">Xóa</span>
                                            <i class="fas fa-chevron-up fa-md p-2 hoverTextBlack" id="chevronAttributeItem"></i>
                                        </div>
                                    </div>
                                    <div class="attributeItemContent pb-3" data-status="show">
                                        <div class="d-flex flex-row">
                                            <div class="w-25 mr-2">
                                                <label for="" class="small">Tên:</label>
                                                <input type="text" class="form-control" id="attributeNameInput" name="attributeItem[]" placeholder="f.e. size or color" value="${optionText}" disabled>
                                            </div>
                                            <div class="d-flex flex-column w-75" style="margin-top:3.2px">
                                                <label for="" class="small">Giá trị:</label>
                                                <div class="customSelectExistingAttributeValues">
                                                    <select class="selectExistingAttributeValues" name="selectExistingAttributeValues" id="selectExistingAttributeValues${id}" data-slimselectinitialized="false" multiple>
                                                        <option data-placeholder="true"></option>
                                                    </select>
                                                </div> 
                                                <div class="d-flex flex-row justify-content-between mt-2">
                                                    <div class="d-flex flex-row">
                                                        <span class="btn btn-outline-info btn-sm selectAllAttributeValuesBtn">Chọn tất cả</span>
                                                        <span class="btn btn-outline-dark btn-sm ml-2 selectNoneAttributeValuesBtn">Bỏ chọn tất cả</span>
                                                    </div>
                                                    <span class="btn btn-success btn-sm btnToCreateNewAttributeValue">Thêm mới giá trị</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                `;
                    //Thêm thuộc tính có sẵn vào giao diện tùy chỉnh
                    $('#attributeItems').append(newElement);
                    attributeValuesSelectStatus = false;
                    saveAttributesBtn.classList.add('disabledButton');

                    //Tạo biến lưu trữ thuộc tính id của phần từ vừa được thêm mới
                    var selectId = "selectExistingAttributeValues" + id;
                    // Kiểm tra nếu thẻ select của phần tử này trong selectStorage chưa được lưu thì khởi tạo slimselect cho phần tử này
                    if (!selectStorage[selectId]) {
                        // Khởi tạo SlimSelect
                        var slimSelectInstance = new SlimSelect({
                            select: '#' + selectId,
                            settings: {
                                placeholderText: 'Chọn giá trị',
                                maxSelected: 6,
                            },
                        });
                        // Lưu SlimSelect vào selectStorage
                        selectStorage[selectId] = {
                            instance: slimSelectInstance,
                            options: [],// Mảng để lưu các tùy chọn đã thêm
                            selectedValues: []// Mảng để lưu các giá trị đã chọn
                        }
                    }

                    //Tạo biến lưu trữ thẻ title của phần tử vừa được thêm
                    // const addedElement = $('.attributeItemTittle').last();
                    //Chạy hàm thu và mở rộng
                    // switchShowHidden(addedElement.next('.attributeItemContent'), 'status', addedElement.find('#chevronAttributeItem'));
                    console.log('Textarea:' + attributeValuesTextareaStatus);
                    console.log('Input:' + attributeTitleInputStatus);
                    console.log('Select:' + attributeValuesSelectStatus);
                    console.log('=====================XONG=====================');
                    return;
                }
            })
        } else {
            //Nếu không có thuộc tính có sẵn nào được chọn (đã bỏ chọn hết) thì lặp qua tất cả các giao diện phần tử thuộc tính
            attributeItem.each(function () {
                //Tạo biến lưu trữ id của phần tử hiện tại
                const attributeId = $(this).data('id');
                const idAttribute = $(this).find('.selectExistingAttributeValues').attr('id');

                //Tạo biến lưu trữ kết quả trả về của phần tử hiện tại nằm trong đối tượng lưu trữ các thuộc tính có sẵn trong db, giá trị trả về là true/false
                const existsInDb = attributeDataOptions.some(function (item) {
                    return item.id == attributeId;
                })
                //Nếu id của phần tử hiện tại không nằm trong currentSelected và nằm trong db thì xóa phần tử này đi
                if (!currentSelected.includes(attributeId) && existsInDb) {
                    if (idAttribute) {
                        // Xóa khỏi selectStorage khi thuộc tính bị xóa
                        delete selectStorage[idAttribute];
                    }
                    $(this).remove();
                }
            });
            var check = true;
            $('.selectExistingAttributeValues').each(function () {
                var getId = $(this).attr('id');
                if (getId) {
                    var currentSelected = $(this).val();
                    if (!currentSelected.length) {
                        check = false
                        return false;
                    }
                }
            });

            if (!check) {
                attributeValuesSelectStatus = false;
            } else {
                attributeValuesSelectStatus = true;
            }
            if ($('.attributeItem').length == 0) {
                attributeTitleInputStatus = true;
                attributeValuesTextareaStatus = true;
            } else {
                $('.attributeItem').each(function () {
                    var checkText = $(this).find('.attributeNameInput').val();
                    var checkTextarea = $(this).find('.attributeValuesTextarea').val();
                    if ($(this).find('.attributeNameInput').length > 0) {
                        if (checkText) {
                            attributeTitleInputStatus = true;
                        } else {
                            attributeTitleInputStatus = false;
                        }
                        if (checkTextarea) {
                            attributeValuesTextareaStatus = true;
                        } else {
                            attributeValuesTextareaStatus = false;
                        }
                    } else {
                        attributeTitleInputStatus = true;
                        attributeValuesTextareaStatus = true;
                        return;
                    }
                })
            }

            if (attributeValuesTextareaStatus && attributeTitleInputStatus && attributeValuesSelectStatus) {
                saveAttributesBtnStatus = true;
                saveAttributesBtn.classList.remove('disabledButton'); // Bỏ lớp vô hiệu hóa khỏi nút lưu
            } else {
                saveAttributesBtnStatus = false;
                saveAttributesBtn.classList.add('disabledButton'); // Thêm lớp vô hiệu hóa vào nút lưu
            }
            console.log('Textarea:' + attributeValuesTextareaStatus);
            console.log('Input:' + attributeTitleInputStatus);
            console.log('Select:' + attributeValuesSelectStatus);
            console.log('=====================XONG=====================');


            if ($('.attributeItem').length == 0) {
                saveAttributesBtn.classList.add('disabledButton');
                saveAttributesBtnStatus = false;
            }
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//------------------------------Show/Hidden attribute form content----------------------------------
// $('.attributeItemTittle').each(function () {
//     switchShowHidden($(this).next('.attributeItemContent'), 'status', $(this).find('#chevronAttributeItem'));
// });
$(document).on('click', '.attributeItemTittle', function () {
    switchShowHidden($(this).next('.attributeItemContent'), 'status', $(this).find('#chevronAttributeItem'));
});
//----------------------------------Remove attribute item------------------------------------
// Xử lý sự kiện khi người dùng bấm vào nút xóa thuộc tính
$(document).on('click', '#removeAttributeItem', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        // Hiển thị xác nhận để người dùng đồng ý hoặc hủy việc xóa
        var isConfirmed = confirm('If you remove this attribute, customers will no longer be able to purchase some variations of this product.');
        if (isConfirmed) {
            // Lấy thẻ chứa thuộc tính cần xóa
            var $attributeItem = $(this).closest('.attributeItem');
            // Lấy id của thuộc tính
            const attributeId = $attributeItem.data('id');
            if (attributeId) {
                // Kiểm tra nếu id thuộc tính tồn tại trong attributeDataOptions
                var existed = attributeDataOptions.some(item => item.id == attributeId);
                if (existed) {
                    // Lấy các giá trị thuộc tính đã được chọn trong SlimSelect
                    var selectedValues = slimSelectAddExisting.getSelected();
                    if (selectedValues.includes(attributeId.toString())) {
                        // Xóa attributeId khỏi danh sách các giá trị đã chọn
                        selectedValues = selectedValues.filter(function (item) {
                            return item != attributeId.toString();
                        });
                        selectedValues = selectedValues ? selectedValues : [];

                        if (selectedValues) {
                            // Tạo danh sách dữ liệu option mới cho SlimSelect
                            var newSelectedOptionData = [];
                            selectedValues.forEach(function (item) {
                                var itemAttribute = attributeDataOptions.find(dataItem => dataItem.id == item);
                                if (itemAttribute) {
                                    newSelectedOptionData.push({
                                        text: itemAttribute.name,
                                        value: itemAttribute.id
                                    });
                                }
                            });

                            // Cập nhật lại giá trị đã chọn trong SlimSelect
                            slimSelectAddExisting.setSelected(newSelectedOptionData.map(option => option.value));
                        } else {
                            // Nếu không có giá trị nào, đặt SlimSelect về rỗng
                            slimSelectAddExisting.setSelected([]);
                        }
                    } else {
                        // Nếu attributeId không nằm trong selectedValues, hiển thị thông báo lỗi
                        notification('error', "Có lỗi xảy ra, vui lòng thử lại!", 'Lỗi');
                    }
                }
            }
            // Kiểm tra nếu tồn tại thẻ attributeItem, xóa nó
            if ($attributeItem.length) {
                $attributeItem.remove();
            } else {
                // Nếu không tìm thấy thẻ, thông báo lỗi
                notification('error', 'Có lỗi xảy ra, vui lòng thử lại!', 'Lỗi');
            }
            var check = true;
            $('.selectExistingAttributeValues').each(function () {
                var getId = $(this).attr('id');
                if (getId) {
                    var currentSelected = $(this).val();
                    if (!currentSelected.length) {
                        check = false
                        return false;
                    }
                }
            });

            if (!check) {
                attributeValuesSelectStatus = false;
            } else {
                attributeValuesSelectStatus = true;
            }
            console.log('Textarea:' + attributeValuesTextareaStatus);
            console.log('Input:' + attributeTitleInputStatus);
            console.log('Select:' + attributeValuesSelectStatus);
            console.log('=====================XONG=====================');

            //Check textarea
            var checkTextarea = $('.attributeItem').find('.attributeValuesTextarea');
            if (!checkTextarea.length) {
                attributeValuesTextareaStatus = true;
            }
            var checkInput = $('.attributeItem').find('.attributeNameInput');

            if (checkInput.length == 0) {
                attributeTitleInputStatus = true;
            }
            if ($('.attributeItem').length == 0) {
                saveAttributesBtnStatus = false;
                saveAttributesBtn.classList.add('disabledButton');
                attributeValuesTextareaStatus = true;
                attributeTitleInputStatus = true;
                console.log('Textarea:' + attributeValuesTextareaStatus);
                console.log('Input:' + attributeTitleInputStatus);
                console.log('Select:' + attributeValuesSelectStatus);
                console.log('=====================XONG=====================');
            } else {
                // var textFlag = true;
                // var textareaFlag = true;
                $('.attributeItem').each(function () {
                    var checkText = $(this).find('.attributeNameInput').val();
                    var checkTextarea = $(this).find('.attributeValuesTextarea').val();
                    if ($(this).find('.attributeNameInput').length > 0) {
                        if (checkText) {
                            attributeTitleInputStatus = true;
                        } else {
                            attributeTitleInputStatus = false;
                        }
                        if (checkTextarea) {
                            attributeValuesTextareaStatus = true;
                        } else {
                            attributeValuesTextareaStatus = false;
                        }
                    } else {
                        attributeTitleInputStatus = true;
                        attributeValuesTextareaStatus = true;
                        return;
                    }
                })
                console.log('Textarea:' + attributeValuesTextareaStatus);
                console.log('Input:' + attributeTitleInputStatus);
                console.log('Select:' + attributeValuesSelectStatus);
                console.log('=====================XONG=====================');
            }
            if (attributeValuesTextareaStatus && attributeTitleInputStatus && attributeValuesSelectStatus) {
                saveAttributesBtnStatus = true;
                saveAttributesBtn.classList.remove('disabledButton'); // Bỏ lớp vô hiệu hóa khỏi nút lưu
            } else {
                saveAttributesBtnStatus = false;
                saveAttributesBtn.classList.add('disabledButton'); // Thêm lớp vô hiệu hóa vào nút lưu
            }
            if ($('.attributeItem').length == 0) {
                saveAttributesBtn.classList.add('disabledButton');
                saveAttributesBtnStatus = false;
            }
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
});

//Biến toàn cục xử lý nhập thuộc tính và giá trị thuộc tính
var attributeTitleInputStatus = false;
var attributeValuesTextareaStatus = false;
var attributeValuesSelectStatus = true;
var saveAttributesBtnStatus = false;
var saveAttributesBtn = document.getElementById('saveAttributesBtn');
// --------------------------------------------Xử lý thêm mới 1 form thuộc tính----------------------------------------------
$(document).on('click', '#addNewAttribute', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        // Tạo giao diện mới cho thuộc tính
        var newElement = `<div class="border-bottom attributeItem" data-id="" data-status="show">
                                <div class="d-flex justify-content-between cspt border-bottom align-items-center p-1 attributeItemTittle no-select">
                                    <span class="d-flex align-items-center attributeTitle commonTitle">Thuộc tính mới</span>
                                    <div class="d-flex align-items-center">
                                        <span class="text-danger cspt no-select mr-2" id="removeAttributeItem" style="font-size:14px">Xóa</span>
                                        <i class="fas fa-chevron-up fa-md p-2 hoverTextBlack" id="chevronAttributeItem"></i>
                                    </div>
                                </div>
                                <div class="attributeItemContent pb-3" data-status="show">
                                    <div class="d-flex flex-row">
                                        <div class="w-25 mr-2">
                                            <label for="" class="small">Tên:</label>
                                            <input type="text" class="form-control attributeNameInput" id="" name="attributeItem" placeholder="f.e. size or color">
                                        </div>
                                        <div class="d-flex flex-column w-75" style="margin-top:3.2px">
                                            <label for="" class="small">Giá trịtrị:</label>
                                            <textarea name="" id="" class="form-control attributeValuesTextarea" rows="3" placeholder="Nhập các tùy chọn để khách hàng lựa chọn, ví dụ: “Green” hoặc “XL”. Sử dụng “|” để phân tách các tùy chọn khác nhau."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
        // Thêm phần tử mới vào vùng chứa attributeItems
        $('#attributeItems').append(newElement);

        // Kiểm tra trạng thái của các biến kiểm tra đầu vào
        if (attributeTitleInputStatus || attributeValuesTextareaStatus) {
            // Nếu bất kỳ biến nào đang true, đặt lại chúng thành false
            attributeTitleInputStatus = false;
            attributeValuesTextareaStatus = false;

            // Nếu nút lưu không có class disabledButton thì thêm class này vào để vô hiệu hóa nút
            if (!saveAttributesBtn.classList.contains('disabledButton')) {
                saveAttributesBtn.classList.add('disabledButton');
                saveAttributesBtnStatus = false;
            }
        }
        console.log('Textarea:' + attributeValuesTextareaStatus);
        console.log('Input:' + attributeTitleInputStatus);
        console.log('Select:' + attributeValuesSelectStatus);
        console.log('=====================XONG=====================');
        // Lấy phần tử vừa thêm vào và gán sự kiện ẩn/hiện cho nó
        const addedElement = $('.attributeItemTittle').last();
        switchShowHidden(addedElement.next('.attributeItemContent'), 'status', addedElement.find('#chevronAttributeItem'));
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
});

// -----------------------------------Theo dõi người dùng nhập tên thuộc tính-------------------------------------------
$(document).on('change', '.attributeNameInput', function (event) {
    // Lấy giá trị nhập vào của phần tử đang nhập
    var name = $(this).val();
    // Lấy thẻ hiển thị tiêu đề của thuộc tính đang nhập
    var attributeTitle = $(this).closest('.attributeItem').find('.attributeTitle');
    // Thiết lập biến để kiểm tra xem có trường nhập tên nào trong tất cả form thiết lập thuộc tính để trống hay không
    var checkAttributeNameInputs = true;
    // Tạo biến để kiểm tra xem cần reset giá trị hay không
    var resetValue = false;

    // Cập nhật tiêu đề thuộc tính với giá trị nhập vào
    attributeTitle.text(name);
    attributeTitle.addClass('font-weight-bold text-dark');

    // Duyệt qua tất cả các trường nhập tên thuộc tính để kiểm tra nếu có trường nào trống
    $('.attributeNameInput').each(function () {
        if (!$(this).val().trim()) {
            checkAttributeNameInputs = false;
            return false;
        }
    });

    // Cập nhật trạng thái kiểm tra tên thuộc tính
    if (checkAttributeNameInputs) {
        attributeTitleInputStatus = true;
    } else {
        attributeTitleInputStatus = false;
    }

    // Nếu tên thuộc tính trống, đặt tiêu đề lại thành 'New attribute' và xóa định dạng
    if (!name.trim()) {
        attributeTitle.text('New attribute');
        attributeTitle.removeClass('font-weight-bold text-dark');
    }

    // Kiểm tra nếu cả hai điều kiện tiêu đề và giá trị văn bản textarea hợp lệ, bật nút lưu
    if (attributeTitleInputStatus && attributeValuesTextareaStatus && attributeValuesSelectStatus) {
        saveAttributesBtn.classList.remove('disabledButton');
        saveAttributesBtnStatus = true;
    } else {
        saveAttributesBtnStatus = false;
        saveAttributesBtn.classList.add('disabledButton');
    }

    // Kiểm tra xem tên thuộc tính đã tồn tại trong giao diện hay chưa
    $('.commonTitle').each(function () {
        // Bỏ qua trường đang nhập hiện tại
        if ($(this).closest('.attributeItem').find('.attributeNameInput')[0] === event.target) {
            return;
        }
        // Nếu tên đã tồn tại, reset giá trị và thông báo lỗi
        if ($(this).text().toLowerCase() == name.toLowerCase()) {
            resetValue = true;
            attributeTitle.text('New attribute');
            attributeTitle.removeClass('font-weight-bold text-dark');
            notification('error', 'Tên thuộc tính đã tồn tại, vui lòng nhập tên khác hoặc chọn thuộc tính có sẵn!', 'Lỗi');
        }
    });

    // Kiểm tra xem tên thuộc tính đã tồn tại trong dữ liệu attributeDataOptions hay chưa
    attributeDataOptions.forEach(function (item) {
        if (item.name == name) {
            resetValue = true;
            notification('warning', 'Tên thuộc tính đã tồn tại, vui lòng nhập tên khác hoặc chọn thuộc tính có sẵn!', 'Cảnh báo');
            attributeTitle.text('New attribute');
            attributeTitle.removeClass('font-weight-bold text-dark');
            // Nếu tên hoặc giá trị không hợp lệ, tắt nút lưu
            if (attributeTitleInputStatus) {
                attributeTitleInputStatus = false;
                // attributeValuesTextareaStatus = false;
                if (!saveAttributesBtn.classList.contains('disabledButton')) {
                    saveAttributesBtnStatus = false;
                    saveAttributesBtn.classList.add('disabledButton');
                }
            }
        }
    });

    // Nếu cần reset giá trị, đặt lại trường nhập và tắt nút lưu
    if (resetValue) {
        $(this).val('');
        attributeTitleInputStatus = false;
        saveAttributesBtn.classList.add('disabledButton');
        saveAttributesBtnStatus = false;
    }
    console.log('Textarea:' + attributeValuesTextareaStatus);
    console.log('Input:' + attributeTitleInputStatus);
    console.log('Select:' + attributeValuesSelectStatus);
    console.log('=====================XONG=====================');
});

//--------------------------------- Xử lý sự kiện khi người dùng thay đổi nội dung của các ô nhập giá trị thuộc tính-----------------------------------
$(document).on('change', '.attributeValuesTextarea', function () {
    // Biến để kiểm tra nếu tất cả các ô nhập đều đã có giá trị
    var checkAttributeValueTextarea = true;

    // Duyệt qua tất cả các ô nhập giá trị thuộc tính
    $('.attributeValuesTextarea').each(function () {
        // Nếu ô nhập nào không có giá trị thì đặt biến kiểm tra thành false
        if ($(this).val().length == 0) {
            checkAttributeValueTextarea = false;
            attributeValuesTextareaStatus = false; // Đặt trạng thái của ô nhập thành false
        }
    });
    if (checkAttributeValueTextarea) {
        attributeValuesTextareaStatus = true;
    }
    console.log('Textarea:' + attributeValuesTextareaStatus);
    console.log('Input:' + attributeTitleInputStatus);
    console.log('Select:' + attributeValuesSelectStatus);
    console.log('=====================XONG=====================');

    // Kiểm tra nếu tất cả các ô nhập có giá trị và tiêu đề thuộc tính hợp lệ thì kích hoạt nút lưu
    if (checkAttributeValueTextarea && attributeTitleInputStatus && attributeValuesSelectStatus) {
        saveAttributesBtn.classList.remove('disabledButton'); // Bỏ lớp vô hiệu hóa khỏi nút lưu
        saveAttributesBtnStatus = true;
    } else {
        saveAttributesBtnStatus = false;
        saveAttributesBtn.classList.add('disabledButton'); // Thêm lớp vô hiệu hóa vào nút lưu
    }
});

// ----------------------------------------------Xử lý lấy giá trị thuộc tính từ db------------------------------------------------
//Tạo đối tượng lưu trữ các giá trị thuộc tính đã được load
var attributeValueDataOptionsMap = {};
//Tạo đối tượng lưu trữ id của các giá trị thuộc tính
const seenAttributeValueIds = new Set();
//Hàm lấy dữ liệu giá trị thuộc tính từ db
function getAttributeValueData(attributeId) {
    //Một Promise là một đối tượng đại diện cho một giá trị có thể chưa có sẵn ngay lập tức, nhưng sẽ có vào một thời điểm nào đó trong tương lai (ví dụ như kết quả của một cuộc gọi AJAX).
    //resolve và reject là hai hàm được truyền vào bên trong Promise để báo hiệu rằng công việc bất đồng bộ (ở đây là cuộc gọi AJAX) đã hoàn tất
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetAllAttributeValuesById,
            method: "POST",
            data: {
                attribute_id: attributeId,
                _token: csrf
            },
            success: function (response) {
                // ------Xử lý dữ liệu từ response------
                //Nếu đối tượng attributeValueDataOptionsMap không tìm thấy khóa có id là attributeId thì tạo một khóa mới với giá trị của khóa là attributeId và đặt một mảng rỗng
                if (!attributeValueDataOptionsMap[attributeId]) {
                    attributeValueDataOptionsMap[attributeId] = [];
                }
                //Lặp qua các giá trị trả về từ controller
                response.data.forEach(function (item) {
                    //Nếu trong khóa attributeId của đối tượng attributeValueDataOptionsMap không có các giá trị từ response.data thì chạy tiếp lệnh
                    if (!attributeValueDataOptionsMap[attributeId].some(existingItem => existingItem.id === item.id)) {
                        //Thêm giá trị đó vào khóa attributeId
                        attributeValueDataOptionsMap[attributeId].push(item);
                    }
                })
                // console.log(attributeValueDataOptionsMap);

                //resolve(): Được gọi khi tác vụ bất đồng bộ hoàn tất thành công. Khi gọi resolve(),
                // promise chuyển sang trạng thái fulfilled, và bất kỳ logic nào được đính kèm với .then() sẽ được thực thi.
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể lấy được dữ liệu giá trị thuộc tính!', 'Lỗi');
                //reject(): Được gọi khi tác vụ bất đồng bộ gặp lỗi hoặc thất bại. Khi bạn gọi reject(),
                //promise chuyển sang trạng thái rejected, và bất kỳ logic nào được đính kèm với .catch() sẽ được thực thi.
                reject();
            }
        });
    })
}

//------------------------- Xử lý sự kiện khi người dùng bấm vào danh sách chọn giá trị thuộc tính để hiển thị danh sách giá trị thuộc tính-----------------------------------
$(document).on('click', '.customSelectExistingAttributeValues', async function () {
    $('.container-spinner').removeClass('hidden');
    try {
        // Lấy id của thẻ select bên trong phần tử được nhấn
        var elementId = $(this).find('.selectExistingAttributeValues').attr('id');
        // Lấy id của thuộc tính từ id của thẻ select (giả định id có dạng "selectExistingAttributeValues{attributeId}")
        var attributeId = parseInt(elementId.match(/\d+/)[0]);

        // Gọi hàm lấy dữ liệu giá trị thuộc tính từ DB và đợi kết quả trả về
        await getAttributeValueData(attributeId);

        // Lấy thẻ select bằng id đã lấy trước đó
        var selectExistingAttributeValues = document.getElementById(elementId);

        // Lấy tất cả các option hiện tại trong thẻ select
        var existingOptions = $(selectExistingAttributeValues).find('.optionSelectAttributeValueAddExisting');

        // Tạo một tập hợp (set) để lưu trữ các id của các option đã tồn tại
        var existingOptionIds = new Set();

        // Kiểm tra xem thẻ select đã có option nào chưa
        if (existingOptions.length > 0) {
            // Nếu có, thêm các id của các option hiện tại vào tập hợp
            existingOptions.each(function () {
                existingOptionIds.add($(this).val());
            });

            // Kiểm tra xem dữ liệu giá trị thuộc tính đã được tải và lưu trữ trong attributeValueDataOptionsMap hay chưa
            if (attributeValueDataOptionsMap[attributeId]) {
                // Lặp qua các giá trị thuộc tính từ attributeValueDataOptionsMap
                attributeValueDataOptionsMap[attributeId].forEach(function (item) {
                    // Nếu id của giá trị thuộc tính chưa có trong tập hợp existingOptionIds thì tạo và thêm option mới
                    if (!existingOptionIds.has(item.id.toString())) {
                        console.log(item);
                        var option = document.createElement('option');
                        option.value = item['id'];
                        option.text = item['name'];
                        option.style.color = item['value'];
                        option.style.fontWeight = "bold";
                        option.className = 'optionSelectAttributeValueAddExisting';
                        option.setAttribute('data-color', item['value']);
                        selectExistingAttributeValues.appendChild(option);
                    }
                });
            } else {
                // Nếu không có dữ liệu nào cho thuộc tính này trong attributeValueDataOptionsMap, hiển thị thông báo cảnh báo
                notification('warning', 'Không có dữ liệu nào có sẵn cho thuộc tính này.', 'Cảnh báo');
            }
        } else {
            // Nếu thẻ select chưa có option nào, thêm tất cả các option từ attributeValueDataOptionsMap
            if (attributeValueDataOptionsMap[attributeId.toString()]) {
                attributeValueDataOptionsMap[attributeId].forEach(function (item) {
                    console.log(item);

                    var option = document.createElement('option');
                    option.value = item['id'];
                    option.text = item['name'];
                    option.style.color = item['value'];
                    option.style.fontWeight = "bold";
                    option.className = 'optionSelectAttributeValueAddExisting';
                    option.setAttribute('data-color', item['value']);
                    selectExistingAttributeValues.appendChild(option);
                });
            } else {
                // Nếu không có dữ liệu nào cho thuộc tính này trong attributeValueDataOptionsMap, hiển thị thông báo cảnh báo
                notification('warning', 'Không có dữ liệu nào có sẵn cho thuộc tính này.', 'Cảnh báo');
            }
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
});


//-------------------------------------------------------------Handle event change options----------------------------------------------------------------
$(document).on('change', '.selectExistingAttributeValues', function () {
    var check = true;
    $('.selectExistingAttributeValues').each(function () {
        var getId = $(this).attr('id');
        if (getId) {
            var currentSelected = $(this).val();
            if (!currentSelected.length) {
                check = false
                return false;
            }
        }
    });

    if (!check) {
        attributeValuesSelectStatus = false;
    } else {
        attributeValuesSelectStatus = true;
    }
    console.log('Textarea:' + attributeValuesTextareaStatus);
    console.log('Input:' + attributeTitleInputStatus);
    console.log('Select:' + attributeValuesSelectStatus);
    console.log('=====================XONG=====================');

    if (attributeValuesTextareaStatus && attributeTitleInputStatus && attributeValuesSelectStatus) {
        saveAttributesBtnStatus = true;
        saveAttributesBtn.classList.remove('disabledButton'); // Bỏ lớp vô hiệu hóa khỏi nút lưu
    } else {
        saveAttributesBtnStatus = false;
        saveAttributesBtn.classList.add('disabledButton'); // Thêm lớp vô hiệu hóa vào nút lưu
    }
});


//-----------------------------------Xử lý khi người dùng bấm nút chọn tất cả giá trị thuộc tính-----------------------------------
//Hàm kiểm tra sự kiện người dùng bấm nút chọn tất cả giá trị tt
$(document).on('click', '.selectAllAttributeValuesBtn', async function () {
    //Tạo biến lưu trữ id của thẻ select trong phần tử đang được click
    var selectElementId = $(this).closest('.attributeItemContent').find('.selectExistingAttributeValues').attr('id');
    var attributeId = parseInt(selectElementId.match(/\d+/)[0]);
    await getAttributeValueData(attributeId);
    console.log(attributeValueDataOptionsMap);

    // Lấy thẻ select bằng id đã lấy trước đó
    var selectExistingAttributeValues = document.getElementById(selectElementId);

    // Lấy tất cả các option hiện tại trong thẻ select
    var existingOptions = $('#' + selectElementId).find('.optionSelectAttributeValueAddExisting');

    // Tạo một tập hợp (set) để lưu trữ các id của các option đã tồn tại
    var existingOptionIds = new Set();

    // Kiểm tra xem thẻ select đã có option nào chưa
    if (existingOptions.length > 0) {
        // Nếu có, thêm các id của các option hiện tại vào tập hợp
        existingOptions.each(function () {
            existingOptionIds.add($(this).val());
        });

        // Kiểm tra xem dữ liệu giá trị thuộc tính đã được tải và lưu trữ trong attributeValueDataOptionsMap hay chưa
        if (attributeValueDataOptionsMap[attributeId]) {
            // Lặp qua các giá trị thuộc tính từ attributeValueDataOptionsMap
            attributeValueDataOptionsMap[attributeId].forEach(function (item) {

                // Nếu id của giá trị thuộc tính chưa có trong tập hợp existingOptionIds thì tạo và thêm option mới
                if (!existingOptionIds.has(item.id.toString())) {
                    console.log(item);
                    var option = document.createElement('option');
                    option.value = item['id'];
                    option.text = item['name'];
                    option.style.color = item['value'];
                    option.style.fontWeight = "bold";
                    option.className = 'optionSelectAttributeValueAddExisting';
                    option.setAttribute('data-color', item['value']);
                    selectExistingAttributeValues.appendChild(option);
                }
            });
        } else {
            // Nếu không có dữ liệu nào cho thuộc tính này trong attributeValueDataOptionsMap, hiển thị thông báo cảnh báo
            notification('warning', 'Không có dữ liệu có sẵn cho thuộc tính này.', 'Cảnh báo');
        }
    } else {
        // Nếu thẻ select chưa có option nào, thêm tất cả các option từ attributeValueDataOptionsMap
        if (attributeValueDataOptionsMap[attributeId.toString()]) {
            // Xóa SlimSelect hiện tại
            if (selectStorage[selectElementId]) {
                selectStorage[selectElementId].instance.destroy();
            }
            for (item of attributeValueDataOptionsMap[attributeId]) {
                var option = document.createElement('option');
                option.value = item['id'];
                option.text = item['name'];
                option.style.color = item['value'];
                option.style.fontWeight = "bold";
                option.className = 'optionSelectAttributeValueAddExisting';
                option.setAttribute('data-color', item['value']);
                selectExistingAttributeValues.appendChild(option);
            }
            // Khởi tạo lại SlimSelect
            selectStorage[selectElementId].instance = new SlimSelect({
                select: '#' + selectElementId,
                settings: {
                    placeholderText: 'Chọn các giá trị',
                },
            });
        } else {
            // Nếu không có dữ liệu nào cho thuộc tính này trong attributeValueDataOptionsMap, hiển thị thông báo cảnh báo
            notification('warning', 'Không có dữ liệu có sẵn cho thuộc tính này.', 'Cảnh báo');
        }
    }

    // Tạo danh sách dữ liệu option mới cho SlimSelect
    var newSelectedOptionData = [];
    for (let item of attributeValueDataOptionsMap[attributeId]) {
        newSelectedOptionData.push({
            text: item.name,
            value: item.id
        });
        if (newSelectedOptionData.length >= 6) {
            break; // Dừng vòng lặp khi đạt 6 phần tử
        }
    }
    // // Cập nhật lại giá trị đã chọn trong SlimSelect
    selectStorage[selectElementId].instance.setSelected(newSelectedOptionData.map(option => option.value));
})

//-----------------------------------Xử lý khi người dùng bấm nút bỏ chọn tất cả giá trị thuộc tính-----------------------------------
$(document).on('click', '.selectNoneAttributeValuesBtn', function () {
    var selectElementId = $(this).closest('.attributeItemContent').find('.selectExistingAttributeValues').attr('id');
    selectStorage[selectElementId].instance.setSelected([]);
})
//-----------------------------------Hàm thêm mới giá trị thuộc tính-----------------------------------
function addNewAttributeValue(attributeId, newAttributeValue) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeAddNewAttributeValueById,
            method: 'POST',
            data: {
                attribute_id: attributeId,
                new_attribute_value: newAttributeValue,
                _token: csrf
            },
            success: function (response) {
                if (response.status == 400) {
                    notification('error', response.message, 'Lỗi');
                } else {
                    if (!attributeValueDataOptionsMap[attributeId]) {
                        attributeValueDataOptionsMap[attributeId] = [];
                    }
                    attributeValueDataOptionsMap[attributeId].push(response.data);
                    notification('success', response.message, 'Thành công', 2000);
                }
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Giá trị thuộc tính đã tồn tại!', 'Lỗi');
                reject();
            }
        })
    })
}
//-----------------------------------Xử lý khi người dùng bấm nút tạo mới giá trị thuộc tính-----------------------------------
$(document).on('click', '.btnToCreateNewAttributeValue', async function () {
    //Tạo biến lưu trữ id của thẻ select trong phần tử đang được click
    var selectElementId = $(this).closest('.attributeItemContent').find('.selectExistingAttributeValues').attr('id');
    var attributeId = parseInt(selectElementId.match(/\d+/)[0]);
    var newAttributeValue = prompt('Please enter new attribute value:');
    if (newAttributeValue) {
        await addNewAttributeValue(attributeId, newAttributeValue);
        console.log(attributeValueDataOptionsMap[attributeId]);

    }
})
//--------------------------------------Save attributes-------------------------------------
var attributeData = [];
var generateVariationData = [];
$('#saveAttributesBtn').click(function () {
    if (saveAttributesBtnStatus) {
        attributeData = [];
        $('.container-spinner').removeClass('hidden');
        try {
            $('.attributeItem').each(function () {
                var attribute = {};
                var checkNameInput = $(this).find('.attributeNameInput');
                if (checkNameInput.length > 0) {
                    var attributeName = checkNameInput.val();
                    attribute.attributeName = attributeName;
                    var baseAttributeValues = $(this).find('.attributeValuesTextarea').val();
                    var attributeValues = [...new Set(baseAttributeValues.split('|').map(function (item) {
                        return item.trim();
                    }))];
                    attributeValues = attributeValues.filter(function (item) {
                        return item != "";
                    })
                    attribute.attributeValues = attributeValues;
                } else {
                    var attributeId = $(this).data('id');
                    attribute.attributeId = attributeId;
                    var attributeName = $(this).find('.commonTitle').text();
                    attribute.attributeName = attributeName;
                    attribute.attributeValues = [];
                    var attributeValues = $(this).find('.selectExistingAttributeValues').val();
                    attributeValues.forEach(function (item) {
                        $(this).find('.selectExistingAttributeValues option').each(function () {
                            if ($(this).text() != '' && $(this).val() == item) {
                                attributeValue = {
                                    attributeValueId: item,
                                    attributeValueName: $(this).text(),
                                    attributeValueColor: $(this).data('color')
                                };
                                attribute.attributeValues.push(attributeValue);
                            }
                        })
                    }, this);
                }
                attributeData.push(attribute);
                if ($(this).attr('data-status') === "show") {
                    $(this).attr('data-status', 'hidden'); // Sử dụng attr để cập nhật HTML
                    $(this).find('.attributeItemContent').addClass('hidden');
                    var chevron = $(this).find('.chevronAttributeItem');
                    if (chevron.length > 0) {
                        chevron.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    }
                }
            })
            attributeData.forEach(function (attributeItem) {
                var attributeIdOrName = attributeItem['attributeId'] ? attributeItem['attributeId'] : attributeItem['attributeName'];
                var variationItems = $('#variations').find('.variationItem');
                variationItems.each(function () {
                    var listSelects = $(this).find('.listSelects');
                    var selects = listSelects.find('select');
                    var getSelectIdOrNameOfVariation = [];
                    console.log(selects);

                    selects.each(function () {
                        var selectItem = $(this);
                        var selectIdOrName = selectItem.attr('id') ? selectItem.attr('id') : selectItem.attr('name');
                        getSelectIdOrNameOfVariation.push(selectIdOrName);
                    })
                    if (!getSelectIdOrNameOfVariation.includes(attributeIdOrName.toString())) {
                        var newSelect = $('<select>').addClass('form-control mr-2 selectAttributeValues');
                        attributeItem['attributeId'] ? newSelect.attr('id', attributeItem['attributeId']) : newSelect.attr('name', attributeItem['attributeName']);
                        var newOption = $('<option>').text("Select " + attributeItem['attributeName']).css('color', '#a8a8a8').css('font-style', 'italic');
                        newSelect.append(newOption);
                        attributeItem['attributeValues'].forEach(function (attributeValueItem) {
                            var attributeValueIdOrName = attributeValueItem['attributeValueId'] ? attributeValueItem['attributeValueId'] : attributeValueItem;
                            var attributeValueName = attributeValueItem['attributeValueName'] ? attributeValueItem['attributeValueName'] : attributeValueItem;
                            newOption = $('<option>').val(attributeValueIdOrName).text(attributeValueName).css('font-weight', 'bold');
                            if (attributeValueItem['attributeValueColor']) {
                                newOption = newOption.css('color', attributeValueItem['attributeValueColor']);
                            }
                            newSelect.append(newOption);
                        })
                        listSelects.append(newSelect);
                    } else {
                        selects.each(function () {
                            var selectItem = $(this);
                            var options = selectItem.find('option');
                            var optionIdOrName = [];
                            options.each(function () {
                                var optionItem = $(this);
                                optionIdOrName.push(optionItem.val());
                            })
                            var getSelectIdOrName = selectItem.attr('id') ? selectItem.attr('id') : selectItem.attr('name');
                            if (getSelectIdOrName == attributeIdOrName) {
                                attributeItem['attributeValues'].forEach(function (attributeValueItem) {
                                    var attributeValueIdOrName = attributeValueItem['attributeValueId'] ? attributeValueItem['attributeValueId'] : attributeValueItem;
                                    var attributeValueName = attributeValueItem['attributeValueName'] ? attributeValueItem['attributeValueName'] : attributeValueItem;
                                    if (!optionIdOrName.includes(attributeValueIdOrName)) {
                                        var newOption = $('<option>').val(attributeValueIdOrName).text(attributeValueName).css('font-weight', 'bold');
                                        if (attributeValueItem['attributeValueColor']) {
                                            newOption = newOption.css('color', attributeValueItem['attributeValueColor']);
                                        }
                                        selectItem.append(newOption);
                                    }
                                })
                            }
                        })
                    }
                })
            })
        } catch (error) {
            console.error('Error:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
            console.log(attributeData);
            if (attributeData.length > 0) {
                generateVariationData = attributeData;
                document.getElementById('generateVariations').classList.remove('disabledButton');
                document.getElementById('addManually').classList.remove('disabledButton');
                notification('success', 'Lưu thuộc tính thành công!', 'Thành công!', '1000');
            }
        }
    } else {
        notification('error', 'Thuộc tính chưa hợp lệ, vui lòng chọn đầy đủ!', 'Lỗi!', '3000');
    }
})
//------------------------------------------Handle generate variations------------------------------------------
var notificationQuantityVariations = $('.notificationQuantityVariations');
var notificationNoVariationsYet = $('.notificationNoVariationsYet');
var controlVariationsSelect = $('.controlVariationsSelect');
var deleteAllVariations = $('.deleteAllVariations');
var checkVariationsStatus = $('.checkVariationsStatus');
var saveVariations = $('.saveVariations');
var saveVariationsStatus = false;
function createRequiredMark() {
    var p = document.createElement('p');
    p.className = "text-danger ml-1 mb-0";
    p.textContent = "(*)";
    return p;
}
$('#generateVariations').click(function () {
    if (generateVariationData.length > 0) {
        var confirmGenerateVariation = confirm('Bạn có muốn tạo tất cả các biến thể không? Thao tác này sẽ tạo ra một biến thể mới cho mọi tổ hợp có thể có của các thuộc tính biến thể!');
        if (confirmGenerateVariation) {
            $('.container-spinner').removeClass('hidden');
            try {
                var totalVariations = 1;
                generateVariationData.forEach(function (attributeItem) {
                    totalVariations = totalVariations * attributeItem.attributeValues.length;
                })
                var variations = [];
                function createVariations(index, currentVariation) {
                    // Nếu đã đến cuối danh sách thuộc tính, lưu biến thể hiện tại vào mảng
                    if (index === generateVariationData.length) {
                        variations.push(currentVariation);
                        return;
                    }
                    // Lặp qua các giá trị thuộc tính của thuộc tính hiện tại
                    generateVariationData[index].attributeValues.forEach(function (attributeValueItem) {
                        // Tạo một biến thể mới dựa trên biến thể hiện tại
                        var newVariation = currentVariation.slice(); // sao chép mảng hiện tại

                        var valueToStore = attributeValueItem.attributeValueId || attributeValueItem;
                        newVariation.push(valueToStore); // thêm giá trị mới // thêm giá trị mới
                        createVariations(index + 1, newVariation); // gọi đệ quy cho thuộc tính tiếp theo
                    });
                }
                createVariations(0, []);
                console.log(variations);

                var divVariations = document.getElementById('variations');
                divVariations.innerHTML = '';
                for (var i = 0; i < totalVariations; i++) {
                    var divVariationItem = document.createElement('div');
                    divVariationItem.className = 'cspt pb-2 variationItem';

                    var divVariationItemTitle = document.createElement('div');
                    divVariationItemTitle.className = 'border-bottom d-flex flex-row justify-content-between pb-2 no-select variationItemTitle';
                    divVariationItemTitle.setAttribute('data-status', 'hidden');

                    var divSelects = document.createElement('div');
                    divSelects.className = 'd-flex flex-row align-items-center listSelects';

                    var strongIndex = document.createElement('strong');
                    strongIndex.className = 'text-dark mr-2';
                    strongIndex.textContent = '#' + (i + 1);

                    divSelects.appendChild(strongIndex);

                    generateVariationData.forEach(function (item) {
                        var select = document.createElement('select');
                        select.className = 'form-control mr-2 selectAttributeValues';
                        if (item.attributeId) {
                            select.id = item.attributeId;
                        } else {
                            select.name = item.attributeName;
                        }

                        var optionDefault = document.createElement('option');
                        optionDefault.textContent = 'Chọn ' + item.attributeName;
                        optionDefault.value = '';
                        optionDefault.style.color = "#a8a8a8";
                        optionDefault.style.fontStyle = "italic";
                        select.appendChild(optionDefault);

                        item.attributeValues.forEach(function (attributeValueItem) {
                            var option = document.createElement('option');
                            option.value = attributeValueItem.attributeValueId || attributeValueItem;
                            option.text = attributeValueItem.attributeValueName || attributeValueItem;
                            if (attributeValueItem.attributeValueColor) {
                                option.style.color = attributeValueItem.attributeValueColor;
                            }
                            option.style.fontWeight = "bold";
                            if (attributeValueItem.attributeValueId) {
                                variations.forEach(function (variationItem, index) {
                                    if (index === i) {
                                        variationItem.forEach(function (item) {
                                            if (item == attributeValueItem.attributeValueId) {
                                                option.setAttribute('selected', '');
                                            }
                                        })
                                    }
                                })
                            } else {
                                variations.forEach(function (variationItem, index) {
                                    if (index === i) {
                                        variationItem.forEach(function (item) {
                                            if (item == attributeValueItem) {
                                                option.setAttribute('selected', '');
                                            }
                                        })
                                    }
                                })
                            }
                            select.appendChild(option);
                        })
                        divSelects.appendChild(select);
                    })
                    divVariationItemTitle.appendChild(divSelects);

                    var divActionButton = document.createElement('div');
                    divActionButton.className = 'd-flex align-items-center flex-row';

                    var iBars = document.createElement('i');
                    iBars.className = 'fas fa-bars fa-sm';
                    iBars.style.marginRight = '12px';

                    divActionButton.appendChild(iBars);

                    var spanRemoveButton = document.createElement('span');
                    spanRemoveButton.className = 'text-danger cspt no-select mr-2 removeVariationItemBtn';
                    spanRemoveButton.style.fontSize = '14px';
                    spanRemoveButton.textContent = 'Xóa';

                    divActionButton.appendChild(spanRemoveButton);

                    var spanEditButton = document.createElement('span');
                    spanEditButton.className = 'text-primary cspt no-select mr-2';
                    spanEditButton.style.fontSize = '14px';
                    spanEditButton.textContent = 'Sửa';

                    divActionButton.appendChild(spanEditButton);

                    divVariationItemTitle.appendChild(divActionButton);

                    var divVariationItemContent = document.createElement('div');
                    divVariationItemContent.className = 'border-bottom p-3 variationItemContent hidden';

                    var divPart1 = document.createElement('div');
                    divPart1.className = 'd-flex flex-row justify-content-between';

                    var divImage = document.createElement('div');
                    divImage.className = 'w-50 mr-4 d-flex flex-row justify-content-around';

                    var divCustomWidthHeightUploadImage = document.createElement('div');
                    divCustomWidthHeightUploadImage.className = 'card d-flex';
                    divCustomWidthHeightUploadImage.style.width = '100px';
                    divCustomWidthHeightUploadImage.style.height = '100px';
                    divCustomWidthHeightUploadImage.style.border = '2px dashed #6c757d';

                    var divImageElements = document.createElement('div');
                    divImageElements.className = 'form-group text-center';

                    var labelImage = document.createElement('label');
                    labelImage.className = 'form-label cspt';
                    labelImage.setAttribute('for', 'variationImage' + (i + 1));

                    var divIconUpload = document.createElement('div');
                    divIconUpload.className = 'mt-2';

                    var iIconUpload = document.createElement('i');
                    iIconUpload.className = 'fas fa-upload fa-lg';

                    divIconUpload.appendChild(iIconUpload);

                    var divClickToUploadText = document.createElement('div');
                    divClickToUploadText.className = 'mt-2';
                    divClickToUploadText.textContent = 'Bấm để tải lên';
                    labelImage.appendChild(divIconUpload);
                    labelImage.appendChild(divClickToUploadText);

                    var inputImage = document.createElement('input');
                    inputImage.type = 'file';
                    inputImage.className = 'form-control d-none variationImageInput';
                    inputImage.id = 'variationImage' + (i + 1);
                    inputImage.name = 'variation';
                    inputImage.setAttribute('accept', 'image/*');
                    inputImage.setAttribute('onchange', 'previewVariationImage(this)');

                    divImageElements.appendChild(labelImage);
                    divImageElements.appendChild(inputImage);
                    divCustomWidthHeightUploadImage.appendChild(divImageElements);

                    var divPreviewVariationImage = document.createElement('div');
                    divPreviewVariationImage.className = 'position-relative previewVariationImage rounded';
                    divPreviewVariationImage.style.width = '100px';
                    divPreviewVariationImage.style.height = '100px';

                    divImage.appendChild(divCustomWidthHeightUploadImage);
                    divImage.appendChild(divPreviewVariationImage);

                    var divSkuInput = document.createElement('div');
                    divSkuInput.className = 'w-50';

                    var divSkuInputElements = document.createElement('div');
                    divSkuInputElements.className = 'd-flex flex-column';

                    var labelSku = document.createElement('label');
                    labelSku.className = 'badge text-left';
                    labelSku.textContent = 'SKU (Có thể bỏ trống để tạo tự động)';

                    var inputSku = document.createElement('input');
                    inputSku.type = 'text';
                    inputSku.className = 'form-control skuInput';
                    inputSku.placeholder = "Enter variation's SKU...";

                    divSkuInputElements.appendChild(labelSku);
                    divSkuInputElements.appendChild(inputSku);
                    divSkuInput.appendChild(divSkuInputElements);
                    divPart1.appendChild(divImage);
                    divPart1.appendChild(divSkuInput);

                    var divPart2 = document.createElement('div');
                    divPart2.className = 'mt-3';

                    var divImportPrice = document.createElement('div');
                    divImportPrice.className = "d-flex flex-column mt-3";

                    var labelImportPrice = document.createElement('label');
                    labelImportPrice.className = 'badge text-left d-flex flex-row';
                    labelImportPrice.textContent = 'Import price (đ)';
                    labelImportPrice.appendChild(createRequiredMark());

                    var inputImportPrice = document.createElement('input');
                    inputImportPrice.type = 'number';
                    inputImportPrice.className = 'form-control importPriceInput';
                    inputImportPrice.placeholder = "Enter variation's import price...";

                    divImportPrice.appendChild(labelImportPrice);
                    divImportPrice.appendChild(inputImportPrice);

                    var divRegularAndSalePrice = document.createElement('div');
                    divRegularAndSalePrice.className = 'd-flex flex-row justify-content-between mt-3';

                    var divRegularPrice = document.createElement('div');
                    divRegularPrice.className = 'd-flex flex-column w-50 mr-4';

                    var labelRegularPrice = document.createElement('label');
                    labelRegularPrice.className = 'badge text-left d-flex flex-row';
                    labelRegularPrice.textContent = 'Regular price (đ)';
                    labelRegularPrice.appendChild(createRequiredMark());

                    var inputRegularPrice = document.createElement('input');
                    inputRegularPrice.type = 'number';
                    inputRegularPrice.className = 'form-control regularPriceInput';
                    inputRegularPrice.placeholder = "Enter variation's regular price...";

                    divRegularPrice.appendChild(labelRegularPrice);
                    divRegularPrice.appendChild(inputRegularPrice);

                    var divSalePrice = document.createElement('div');
                    divSalePrice.className = 'd-flex flex-column w-50';

                    var labelSalePrice = document.createElement('label');
                    labelSalePrice.className = 'badge text-left';
                    labelSalePrice.textContent = 'Sale price (đ)';

                    var inputSalePrice = document.createElement('input');
                    inputSalePrice.type = 'number';
                    inputSalePrice.className = 'form-control salePriceInput';
                    inputSalePrice.placeholder = "Enter variation's sale price...";

                    divSalePrice.appendChild(labelSalePrice);
                    divSalePrice.appendChild(inputSalePrice);

                    divRegularAndSalePrice.appendChild(divRegularPrice);
                    divRegularAndSalePrice.appendChild(divSalePrice);

                    var divStock = document.createElement('div');
                    divStock.className = 'd-flex flex-column mt-3';

                    var labelStock = document.createElement('label');
                    labelStock.className = 'badge text-left d-flex flex-row';
                    labelStock.textContent = 'Stock';
                    labelStock.appendChild(createRequiredMark());

                    var inputStock = document.createElement('input');
                    inputStock.type = 'number';
                    inputStock.className = 'form-control stockInput';
                    inputStock.placeholder = "Enter variation's stock price...";

                    divStock.appendChild(labelStock);
                    divStock.appendChild(inputStock);

                    var divActive = document.createElement('div');
                    divActive.className = 'd-flex flex-column mt-3';

                    var labelActive = document.createElement('label');
                    labelActive.className = 'badge text-left';
                    labelActive.textContent = 'Active';

                    var selectActive = document.createElement('select');
                    selectActive.className = 'form-control activeSelect';

                    var optionYes = document.createElement('option');
                    optionYes.value = 'true';
                    optionYes.setAttribute('selected', '');
                    optionYes.textContent = 'Yes';

                    var optionNo = document.createElement('option');
                    optionNo.value = 'false';
                    optionNo.textContent = 'No';

                    selectActive.appendChild(optionYes);
                    selectActive.appendChild(optionNo);

                    divActive.appendChild(labelActive);
                    divActive.appendChild(selectActive);

                    divPart2.appendChild(divImportPrice);
                    divPart2.appendChild(divRegularAndSalePrice);
                    divPart2.appendChild(divStock);
                    divPart2.appendChild(divActive);

                    divVariationItemContent.appendChild(divPart1);
                    divVariationItemContent.appendChild(divPart2);

                    divVariationItem.appendChild(divVariationItemTitle);
                    divVariationItem.appendChild(divVariationItemContent);

                    divVariations.appendChild(divVariationItem);
                }

                updateDisabledOptions();
                var variationItems = $('#variations').find('.variationItem');
                if (variationItems.length > 0) {
                    //Ẩn chữ thông báo
                    $('.notificationNoVariationsYet').addClass('hidden');

                    notification('success', 'Tạo biến thể tự động thành công!', 'Thành công!', '1000');
                }
                $('.notificationQuantityVariations').text(totalVariations + ' biến thể chưa có giá, vui lòng nhập giá nhập cho các biến thể này.!');
                // if (totalVariations == 1) {
                //     $('.notificationQuantityVariations').text(totalVariations + ' variation do not have prices. Variations (and their attributes) that do not have prices will not be shown in your store.');
                // } else {
                //     $('.notificationQuantityVariations').text(totalVariations + ' variations do not have prices. Variations (and their attributes) that do not have prices will not be shown in your store.');
                // }
                controlVariationsSelect.removeClass('hidden');
                deleteAllVariations.removeClass('hidden');
                checkVariationsStatus.removeClass('hidden');
                saveVariations.removeClass('hidden').addClass('disabledButton');
                saveVariationsStatus = false;
                //Phân trang
                pagination();
            } catch (error) {
                console.error('Error:', error);
            } finally {
                $('.container-spinner').addClass('hidden');
            }
        }
    } else {
        notification('warning', 'Bạn cần thêm ít nhất một thuộc tính!', 'Cảnh báo!', '3000');
        // notification('warning', 'You need to add attribute(s)!', 'Cảnh báo!','3000');
    }
})
//-----------------------------------------Pagination-----------------------------------------
function pagination() {
    var totalVariations = $('.variationItem').length; // Tổng số biến thể
    var variationsPerPage = 5; // Số biến thể hiển thị trên mỗi trang
    var totalPages = Math.ceil(totalVariations / variationsPerPage); // Tổng số trang
    var currentPage = 1; // Trang hiện tại

    function displayVariations(page) {
        $('.variationItem').hide(); // Ẩn tất cả biến thể
        var startIndex = (page - 1) * variationsPerPage; // Tính chỉ số bắt đầu
        var endIndex = startIndex + variationsPerPage; // Tính chỉ số kết thúc
        $('.variationItem').slice(startIndex, endIndex).show(); // Hiển thị biến thể

        // Chỉ cập nhật phân trang nếu có nhiều hơn một trang
        if (totalPages > 1) {
            updatePagination(page); // Cập nhật thông tin phân trang
            $('.pagination').show(); // Hiển thị phân trang
        } else {
            $('.pagination').hide(); // Ẩn phân trang nếu chỉ có một trang
        }
    }

    function updatePagination(currentPage) {
        var pageSelect = $('#pageSelect'); // Thẻ select chứa các trang
        pageSelect.empty(); // Xóa nội dung trước đó

        // Thêm các tùy chọn số trang vào thẻ select
        for (var i = 1; i <= totalPages; i++) {
            var option = $('<option></option>').text(i).val(i); // Tạo tùy chọn trang
            if (i === currentPage) {
                option.attr('selected', 'selected'); // Đánh dấu trang hiện tại
            }
            pageSelect.append(option); // Thêm tùy chọn vào select
        }

        // Thêm sự kiện khi thay đổi lựa chọn trang
        pageSelect.off('change').on('change', function () {
            var page = parseInt($(this).val());
            displayVariations(page); // Hiển thị biến thể trên trang đã chọn
        });

        // Thêm nút đầu tiên
        var firstPageLink = $('#firstPage');
        firstPageLink.off('click').on('click', function (e) {
            e.preventDefault();
            displayVariations(1); // Hiển thị trang đầu tiên
        });

        // Thêm nút trang trước
        var prevPageLink = $('#prevPage');
        prevPageLink.off('click').on('click', function (e) {
            e.preventDefault();
            if (currentPage > 1) {
                displayVariations(currentPage - 1); // Hiển thị trang trước
            }
        });

        // Thêm nút trang tiếp theo
        var nextPageLink = $('#nextPage');
        nextPageLink.off('click').on('click', function (e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                displayVariations(currentPage + 1); // Hiển thị trang tiếp theo
            }
        });

        // Thêm nút cuối cùng
        var lastPageLink = $('#lastPage');
        lastPageLink.off('click').on('click', function (e) {
            e.preventDefault();
            displayVariations(totalPages); // Hiển thị trang cuối cùng
        });
    }

    $(document).ready(function () {
        displayVariations(currentPage); // Hiển thị trang đầu tiên
    });
}

//---------------------Ngăn không cho cú click áp dụng vào phần tử cha khi click vào thẻ select------------------------
$(document).on('click', '.variationItem select', function (event) {
    event.stopPropagation();
});
//----------------------Ngăn không cho cú click áp dụng vào phần tử cha khi click vào nút xóa-----------------------
$(document).on('click', '.variationItem .removeVariationItemBtn', function (event) {
    event.stopPropagation();
    var confirmRemove = confirm('Bạn có chắc chắn muốn xóa biến thể này không?');
    // var confirmRemove = confirm('Are you sure you want to remove this variation?');
    if (confirmRemove) {
        var variationItemOfThisElement = $(this).closest('.variationItem');
        variationItemOfThisElement.remove();
        var variationItems = $('.variationItem');
        var totalVariations = variationItems.length;
        if (totalVariations > 0) {
            //Vietnamese version
            if (totalVariations == 1) {
                notificationQuantityVariations.text(totalVariations + ' biến thể chưa có giá, vui lòng nhập giá nhập cho các biến thể này.!');
            } else {
                notificationQuantityVariations.text(totalVariations + ' biến thể chưa có giá, vui lòng nhập giá nhập cho các biến thể này.!');
            }
            //English version
            // if (totalVariations == 1) {
            //     notificationQuantityVariations.text(totalVariations + ' variation do not have prices. Variations (and their attributes) that do not have prices will not be shown in your store.');
            // } else {
            //     notificationQuantityVariations.text(totalVariations + ' variations do not have prices. Variations (and their attributes) that do not have prices will not be shown in your store.');
            // }

            //Cập nhật lại số thứ tự
            variationItems.each(function (index) {
                var strongIndex = $(this).find('strong');
                strongIndex.text('#' + (index + 1));
            })
            pagination();
        } else {
            notificationQuantityVariations.text('');
            notificationNoVariationsYet.removeClass('hidden');
            controlVariationsSelect.addClass('hidden');
            deleteAllVariations.addClass('hidden');
            checkVariationsStatus.addClass('hidden');
            saveVariations.addClass('hidden disabledButton');
            saveVariationsStatus = false;
        }
    }
});
//------------------------------Open/close variation item when click------------------------------
$(document).on('click', '.variationItemTitle', function () {
    switchShowHidden($(this).next('.variationItemContent'), '', '');
})
//--------------------------------------------Add 1 variation--------------------------------------
$(document).on('click', '#addManually', function () {
    if (!$(this).hasClass('disabledButton')) {
        var totalVariations = 1;
        generateVariationData.forEach(function (attributeItem) {
            totalVariations = totalVariations * attributeItem.attributeValues.length;
        })
        var totalVariationItems = $('.variationItem').length;
        $('.container-spinner').removeClass('hidden');
        try {
            if (totalVariationItems < totalVariations) {
                var divVariations = document.getElementById('variations');

                var divVariationItem = document.createElement('div');
                divVariationItem.className = 'cspt pb-2 variationItem';

                var divVariationItemTitle = document.createElement('div');
                divVariationItemTitle.className = 'border-bottom d-flex flex-row justify-content-between pb-2 no-select variationItemTitle';

                var divSelects = document.createElement('div');
                divSelects.className = 'd-flex flex-row align-items-center listSelects';

                var strongIndex = document.createElement('strong');
                strongIndex.className = 'text-dark mr-2';
                strongIndex.textContent = '#' + (totalVariationItems + 1);

                divSelects.appendChild(strongIndex);

                generateVariationData.forEach(function (item) {
                    var select = document.createElement('select');
                    select.className = 'form-control mr-2 selectAttributeValues';
                    if (item.attributeId) {
                        select.id = item.attributeId;
                    } else {
                        select.name = item.attributeName;
                    }
                    var optionDefault = document.createElement('option');
                    optionDefault.textContent = 'Chọn ' + item.attributeName;
                    optionDefault.value = '';
                    optionDefault.style.color = "#a8a8a8";
                    optionDefault.style.fontStyle = "italic";
                    select.appendChild(optionDefault);

                    item.attributeValues.forEach(function (attributeValueItem) {
                        var option = document.createElement('option');
                        option.value = attributeValueItem.attributeValueId || attributeValueItem;
                        option.text = attributeValueItem.attributeValueName || attributeValueItem;
                        if (attributeValueItem.attributeValueColor) {
                            option.style.color = attributeValueItem.attributeValueColor;
                        }
                        option.style.fontWeight = "bold";
                        select.appendChild(option);
                    })
                    divSelects.appendChild(select);
                })
                divVariationItemTitle.appendChild(divSelects);

                var divActionButton = document.createElement('div');
                divActionButton.className = 'd-flex align-items-center flex-row';

                var iBars = document.createElement('i');
                iBars.className = 'fas fa-bars fa-sm';
                iBars.style.marginRight = '12px';

                divActionButton.appendChild(iBars);

                var spanRemoveButton = document.createElement('span');
                spanRemoveButton.className = 'text-danger cspt no-select mr-2 removeVariationItemBtn';
                spanRemoveButton.style.fontSize = '14px';
                spanRemoveButton.textContent = 'Xóa';

                divActionButton.appendChild(spanRemoveButton);

                var spanEditButton = document.createElement('span');
                spanEditButton.className = 'text-primary cspt no-select mr-2';
                spanEditButton.style.fontSize = '14px';
                spanEditButton.textContent = 'Sửa';

                divActionButton.appendChild(spanEditButton);

                divVariationItemTitle.appendChild(divActionButton);

                var divVariationItemContent = document.createElement('div');
                divVariationItemContent.className = 'border-bottom p-3 variationItemContent hidden';

                var divPart1 = document.createElement('div');
                divPart1.className = 'd-flex flex-row justify-content-between';

                var divImage = document.createElement('div');
                divImage.className = 'w-50 mr-4 d-flex flex-row justify-content-around';

                var divCustomWidthHeightUploadImage = document.createElement('div');
                divCustomWidthHeightUploadImage.className = 'card d-flex';
                divCustomWidthHeightUploadImage.style.width = '100px';
                divCustomWidthHeightUploadImage.style.height = '100px';
                divCustomWidthHeightUploadImage.style.border = '2px dashed #6c757d';

                var divImageElements = document.createElement('div');
                divImageElements.className = 'form-group text-center';

                var labelImage = document.createElement('label');
                labelImage.className = 'form-label cspt';
                labelImage.setAttribute('for', 'variationImage' + (totalVariationItems + 1));

                var divIconUpload = document.createElement('div');
                divIconUpload.className = 'mt-2';

                var iIconUpload = document.createElement('i');
                iIconUpload.className = 'fas fa-upload fa-lg';

                divIconUpload.appendChild(iIconUpload);

                var divClickToUploadText = document.createElement('div');
                divClickToUploadText.className = 'mt-2';
                divClickToUploadText.textContent = 'Bấm để tải lên';
                labelImage.appendChild(divIconUpload);
                labelImage.appendChild(divClickToUploadText);

                var inputImage = document.createElement('input');
                inputImage.type = 'file';
                inputImage.className = 'form-control d-none variationImageInput';
                inputImage.id = 'variationImage' + (totalVariationItems + 1);
                inputImage.name = 'variation';
                inputImage.setAttribute('accept', 'image/*');
                inputImage.setAttribute('onchange', 'previewVariationImage(this)');

                divImageElements.appendChild(labelImage);
                divImageElements.appendChild(inputImage);
                divCustomWidthHeightUploadImage.appendChild(divImageElements);

                var divPreviewVariationImage = document.createElement('div');
                divPreviewVariationImage.className = 'previewVariationImage rounded position-relative';
                divPreviewVariationImage.style.width = '100px';
                divPreviewVariationImage.style.height = '100px';

                divImage.appendChild(divCustomWidthHeightUploadImage);
                divImage.appendChild(divPreviewVariationImage);

                var divSkuInput = document.createElement('div');
                divSkuInput.className = 'w-50';

                var divSkuInputElements = document.createElement('div');
                divSkuInputElements.className = 'd-flex flex-column';

                var labelSku = document.createElement('label');
                labelSku.className = 'badge text-left';
                labelSku.textContent = 'SKU (Có thể bỏ trống để tạo tự động)';

                var inputSku = document.createElement('input');
                inputSku.type = 'text';
                inputSku.className = 'form-control skuInput';
                inputSku.placeholder = "Enter variation's SKU...";

                divSkuInputElements.appendChild(labelSku);
                divSkuInputElements.appendChild(inputSku);
                divSkuInput.appendChild(divSkuInputElements);
                divPart1.appendChild(divImage);
                divPart1.appendChild(divSkuInput);

                var divPart2 = document.createElement('div');
                divPart2.className = 'mt-3';

                var divImportPrice = document.createElement('div');
                divImportPrice.className = "d-flex flex-column mt-3";

                var labelImportPrice = document.createElement('label');
                labelImportPrice.className = 'badge text-left d-flex flex-row';
                labelImportPrice.textContent = 'Import price (đ)';
                labelImportPrice.appendChild(createRequiredMark());

                var inputImportPrice = document.createElement('input');
                inputImportPrice.type = 'number';
                inputImportPrice.className = 'form-control importPriceInput';
                inputImportPrice.placeholder = "Enter variation's import price...";

                divImportPrice.appendChild(labelImportPrice);
                divImportPrice.appendChild(inputImportPrice);

                var divRegularAndSalePrice = document.createElement('div');
                divRegularAndSalePrice.className = 'd-flex flex-row justify-content-between mt-3';

                var divRegularPrice = document.createElement('div');
                divRegularPrice.className = 'd-flex flex-column w-50 mr-4';

                var labelRegularPrice = document.createElement('label');
                labelRegularPrice.className = 'badge text-left d-flex flex-row';
                labelRegularPrice.textContent = 'Regular price (đ)';
                labelRegularPrice.appendChild(createRequiredMark());

                var inputRegularPrice = document.createElement('input');
                inputRegularPrice.type = 'number';
                inputRegularPrice.className = 'form-control regularPriceInput';
                inputRegularPrice.placeholder = "Enter variation's regular price...";

                divRegularPrice.appendChild(labelRegularPrice);
                divRegularPrice.appendChild(inputRegularPrice);

                var divSalePrice = document.createElement('div');
                divSalePrice.className = 'd-flex flex-column w-50';

                var labelSalePrice = document.createElement('label');
                labelSalePrice.className = 'badge text-left';
                labelSalePrice.textContent = 'Sale price (đ)';

                var inputSalePrice = document.createElement('input');
                inputSalePrice.type = 'number';
                inputSalePrice.className = 'form-control salePriceInput';
                inputSalePrice.placeholder = "Enter variation's sale price...";

                divSalePrice.appendChild(labelSalePrice);
                divSalePrice.appendChild(inputSalePrice);

                divRegularAndSalePrice.appendChild(divRegularPrice);
                divRegularAndSalePrice.appendChild(divSalePrice);

                var divStock = document.createElement('div');
                divStock.className = 'd-flex flex-column mt-3';

                var labelStock = document.createElement('label');
                labelStock.className = 'badge text-left d-flex flex-row';
                labelStock.textContent = 'Stock';
                labelStock.appendChild(createRequiredMark());

                var inputStock = document.createElement('input');
                inputStock.type = 'number';
                inputStock.className = 'form-control stockInput';
                inputStock.placeholder = "Enter variation's stock price...";

                divStock.appendChild(labelStock);
                divStock.appendChild(inputStock);

                var divActive = document.createElement('div');
                divActive.className = 'd-flex flex-column mt-3';

                var labelActive = document.createElement('label');
                labelActive.className = 'badge text-left';
                labelActive.textContent = 'Active';

                var selectActive = document.createElement('select');
                selectActive.className = 'form-control activeSelect';

                var optionYes = document.createElement('option');
                optionYes.value = 'true';
                optionYes.setAttribute('selected', '');
                optionYes.textContent = 'Yes';

                var optionNo = document.createElement('option');
                optionNo.value = 'false';
                optionNo.textContent = 'No';

                selectActive.appendChild(optionYes);
                selectActive.appendChild(optionNo);

                divActive.appendChild(labelActive);
                divActive.appendChild(selectActive);

                divPart2.appendChild(divImportPrice);
                divPart2.appendChild(divRegularAndSalePrice);
                divPart2.appendChild(divStock);
                divPart2.appendChild(divActive);

                divVariationItemContent.appendChild(divPart1);
                divVariationItemContent.appendChild(divPart2);

                divVariationItem.appendChild(divVariationItemTitle);
                divVariationItem.appendChild(divVariationItemContent);

                divVariations.appendChild(divVariationItem);
                pagination();
                updateDisabledOptions();

                $('.notificationNoVariationsYet').addClass('hidden');
                totalVariations = $('.variationItem').length;

                $('.notificationQuantityVariations').text(totalVariations + ' biến thể chưa có giá nhập và giá bán thông thường, vui lòng nhập đầy đủ các trường thông tin cho các biến thể này.!');
                // if (totalVariations == 1) {
                //     $('.notificationQuantityVariations').text(totalVariations + ' variation do not have prices. Variations (and their attributes) that do not have prices will not be shown in your store.');
                // } else {
                //     $('.notificationQuantityVariations').text(totalVariations + ' variations do not have prices. Variations (and their attributes) that do not have prices will not be shown in your store.');
                // }
                controlVariationsSelect.removeClass('hidden');
                deleteAllVariations.removeClass('hidden');
                checkVariationsStatus.removeClass('hidden');
                saveVariations.removeClass('hidden');
                saveVariations.addClass('disabledButton');
                saveVariationsStatus = false;
            } else {
                notification('warning', 'Đã đạt đến số lượng biến thể tối đa có thể tạo ra!', 'Tối đa!')
                // notification('warning', 'Maximum number of variants that can be created has been reached!', 'Has reached its maximum!')
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            $('.container-spinner').addClass('hidden');
        }
    } else {
        notification('warning', 'Bạn cần thêm ít nhất một thuộc tính!', 'Cảnh báo!', '3000');
        // notification('warning', 'You need to add attribute(s)!', 'Cảnh báo!','3000');
    }
})
//-------------------------------------------Delete all variations-------------------------------------------
$(document).on('click', '.deleteAllVariations', function () {
    var confirmDeleteAllVariations = confirm('Bạn có muốn xóa tất cả các biến thể không?');
    $('.container-spinner').removeClass('hidden');
    try {
        if (confirmDeleteAllVariations) {
            $('.variationItem').each(function () {
                $(this).remove();
            })
            notificationQuantityVariations.text('');
            notificationNoVariationsYet.removeClass('hidden');
            controlVariationsSelect.addClass('hidden');
            deleteAllVariations.addClass('hidden');
            checkVariationsStatus.addClass('hidden');
            saveVariations.addClass('hidden disabledButton');
            saveVariationsStatus = false;
            pagination();
            notification('success', 'Đã xóa tất cả biến thể thành công!', 'Thành công!', '1000');
            // notification('success', 'Remove all variations successfully!', 'Thành công!','1000');
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//---------------------------------------------Change variation image---------------------------------------------
function previewVariationImage(input) {
    saveVariations.addClass('disabledButton');
    saveVariationsStatus = false;
    const maxSizeMB = 2; // Giới hạn dung lượng tối đa (MB)
    const maxSizeBytes = maxSizeMB * 1024 * 1024; // Chuyển đổi sang byte
    $('.container-spinner').removeClass('hidden');
    try {
        var variationItem = $(input).closest('.variationItemContent');
        if (input.files.length > 0) {
            const file = input.files[0];

            if (file.size > maxSizeBytes) {
                notification('error', `Kích thước tệp vượt quá ${maxSizeMB}MB. Vui lòng chọn tệp nhỏ hơn!`, 'Lỗi', '2000');
                // notification('error', `Kích thước tệp vượt quá ${maxSizeMB}MB. Vui lòng chọn tệp nhỏ hơn.`, 'Lỗi', '2000');
                input.value = ''; // Reset input nếu ảnh quá lớn
                return;
            }
            var checkPreviewVariationImage = variationItem.find('.variationImage');

            const reader = new FileReader();
            if (checkPreviewVariationImage.length > 0) {
                var fileName = checkPreviewVariationImage.data('variationimagefilename');
                if (fileName != file.name) {
                    variationItem.find('.previewVariationImage').html('');
                    reader.onload = function (e) {
                        const divPreviewVariationImage = variationItem.find('.previewVariationImage')[0];

                        // Tạo một thẻ img mới
                        const variationImage = document.createElement('img');
                        variationImage.src = e.target.result;
                        variationImage.className = 'rounded variationImage w-100 h-100';
                        variationImage.style.objectFit = 'cover';
                        variationImage.setAttribute('data-variationimagefilename', file.name);
                        //Tạo một nút xóa
                        const iRemoveVariationImage = document.createElement('i');
                        iRemoveVariationImage.className = 'position-absolute fas fa-trash text-danger cspt';
                        iRemoveVariationImage.style.cursor = 'pointer';
                        iRemoveVariationImage.style.right = '-5px';
                        iRemoveVariationImage.style.top = '-7px';
                        iRemoveVariationImage.id = 'removeVariationImage';
                        //Thêm ảnh và nút xóa vào khối
                        divPreviewVariationImage.appendChild(variationImage);
                        divPreviewVariationImage.appendChild(iRemoveVariationImage);
                    }
                    reader.readAsDataURL(file);
                    notification('success', 'Đã tải ảnh lên thành công!', 'Thành công', '2000');
                    // notification('success', 'Image uploaded successfully', 'Thành công', '2000');
                } else {
                    notification('warning', 'Ảnh đã tồn tại (đã được tải lên)', 'Cảnh báo', '2000');
                    // notification('warning', 'Image already exists', 'Cảnh báo', '2000');
                }
            } else {
                reader.onload = function (e) {
                    const divPreviewVariationImage = variationItem.find('.previewVariationImage')[0];
                    console.log(divPreviewVariationImage);
                    // Tạo một thẻ img mới
                    const variationImage = document.createElement('img');
                    variationImage.src = e.target.result;
                    variationImage.className = 'rounded variationImage w-100 h-100';
                    variationImage.style.objectFit = 'cover';
                    variationImage.setAttribute('data-variationimagefilename', file.name);
                    //Tạo một nút xóa
                    const iRemoveVariationImage = document.createElement('i');
                    iRemoveVariationImage.className = 'position-absolute fas fa-trash text-danger cspt';
                    iRemoveVariationImage.style.cursor = 'pointer';
                    iRemoveVariationImage.style.right = '-5px';
                    iRemoveVariationImage.style.top = '-7px';
                    iRemoveVariationImage.id = 'removeVariationImage';
                    //Thêm ảnh và nút xóa vào khối
                    divPreviewVariationImage.appendChild(variationImage);
                    divPreviewVariationImage.appendChild(iRemoveVariationImage);
                }
                reader.readAsDataURL(file);
                notification('success', 'Đã tải ảnh lên thành công!', 'Thành công', '2000');
                // notification('success', 'Image uploaded successfully', 'Thành công', '2000');
            }
        } else {
            variationItem.find('.previewVariationImage').html('');
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
}

//---------------------------------------Remove preview variation image-------------------------------------
$(document).on('click', '#removeVariationImage', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        var input = $(this).closest('.variationItemContent').find('.variationImageInput').attr('id');
        document.getElementById(input).value = '';
        $(this).closest('.previewVariationImage').html('');
        saveVariations.addClass('disabledButton');
        saveVariationsStatus = false;
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//---------------------------------------Xử lý thay đổi giá trị thuộc tính trong thẻ select của biến thể-------------------------------------
var existingVariations = [];
$(document).on('change', '.selectAttributeValues', function () {
    updateDisabledOptions();
})
function arraysAreEqual(arr1, arr2) {
    if (arr1.length !== arr2.length) return false;
    return arr1.every(value => arr2.includes(value)) && arr2.every(value => arr1.includes(value));
}

function updateDisabledOptions() {
    existingVariations = [];
    if ($('.variationItem').length > 0) {
        $('.variationItem').each(function () {
            var thisVariation = $(this);
            var selectAttributeValues = [];

            thisVariation.find('.selectAttributeValues').each(function () {
                var thisSelect = $(this);
                thisSelect.find('option').each(function () {
                    var thisOption = $(this);
                    if (thisOption.attr('disabled')) {
                        thisOption.attr('disabled', false);
                        thisOption.css('background-color', '');
                    }
                })
                selectAttributeValues.push(thisSelect.val());
            })
            existingVariations.push(selectAttributeValues);
        })
        $('.variationItem').each(function () {
            var thisVariation = $(this);
            thisVariation.find('.selectAttributeValues').each(function (index1) {
                var ortherSelects = [];
                var thisSelect = $(this);
                var valueOfSelect1 = thisSelect.val();
                thisVariation.find('.selectAttributeValues').each(function (index2) {
                    var thisSelect2 = $(this);
                    if (index1 != index2) {
                        ortherSelects.push(thisSelect2.val());
                    }
                })
                // console.log("Mảng ortherSelects sau khi được thêm dữ liệu: " + ortherSelects);

                thisSelect.find('option').each(function () {
                    var thisOption = $(this);
                    // console.log("Giá trị của option hiện tại: " + thisOption.val());
                    // console.log("Giá trị của thẻ select: " + valueOfSelect1);

                    if (thisOption.val() != valueOfSelect1) {
                        ortherSelects.push(thisOption.val());
                        // console.log("Mảng ortherSelects sau khi được cập nhật dữ liệu: " + ortherSelects);
                        for (const item of existingVariations) {
                            if (arraysAreEqual(item, ortherSelects)) {
                                // console.log("Giá trị của item: " + item);
                                // console.log("Giá trị của ortherSelects: " + ortherSelects);
                                // console.log("Đã bị trùng lặp -> vô hiệu hóa!");

                                thisOption.attr('disabled', true);
                                thisOption.css('background-color', '#b4b4bf');
                                break;
                            }
                        }
                        ortherSelects = ortherSelects.filter(function (item) {
                            return item != thisOption.val();
                        })
                        // console.log("Mảng ortherSelects sau khi được xóa dữ liệu: " + ortherSelects);
                    }
                })
            })
        })
    }
    console.log(existingVariations);

}
//--------------------------------------Check for data type of input---------------------------------------
function checkNumberInput(input, typeInput = null) {
    saveVariations.addClass('disabledButton');
    saveVariationsStatus = false;
    if (input.val() < 0) {
        input.val('');
        notification('warning', 'Giá trị phải lớn hơn hoặc bằng 0!', 'Cảnh báo!', '3000');
        return false;
    }
    if (typeInput == 'stock') {
        let value = parseFloat(input.val().replace(',', '.'));
        if (!Number.isInteger(value)) {
            input.val('');
            return false;
        } else {
            return true;
        }
    } else {
        if (isNaN(parseFloat(input.val())) && !Number(parseFloat(input.val()))) {
            input.val('');
            return false;
        } else {
            return true;
        }
    }
}

$(document).on('change', '.importPriceInput', function () {
    checkNumberInput($(this));
    const salePrice = $(this).closest('.variationItemContent').find('.salePriceInput');
    if (salePrice.val()) {
        if (parseFloat(salePrice.val()) <= parseFloat($(this).val())) {
            $(this).val('');
            notification('warning', 'Giá nhập phải nhỏ hơn giá bán đã giảm!', 'Cảnh báo!', '3000');
        }
    }
    var countImportPrice = 0;
    var countRegularPrice = 0;
    $('.variationItem').each(function () {
        var importPriceInput = $(this).find('.importPriceInput').val();
        var regularPriceInput = $(this).find('.regularPriceInput').val();
        if (!importPriceInput) {
            countImportPrice++;
        }
        if (!regularPriceInput) {
            countRegularPrice++;
        }
    })
    if (countImportPrice != 0 && countRegularPrice != 0) {

    }
    if (countImportPrice != 0 && countRegularPrice != 0) {
        $('.notificationQuantityVariations').removeClass('hidden');
        $('.notificationQuantityVariations').text(countImportPrice + ' biến thể chưa có giá nhập và ' + countRegularPrice + ' biến thể chưa có giá bán thông thường, vui lòng nhập đầy đủ các trường thông tin này.!');
    } else if (countImportPrice != 0 && countRegularPrice == 0) {
        $('.notificationQuantityVariations').removeClass('hidden');
        $('.notificationQuantityVariations').text(countImportPrice + ' biến thể chưa có giá nhập, vui lòng nhập đầy đủ các trường thông tin này.!');
    } else if (countImportPrice == 0 && countRegularPrice != 0) {
        $('.notificationQuantityVariations').removeClass('hidden');
        $('.notificationQuantityVariations').text(countRegularPrice + ' biến thể chưa có giá bán thông thường, vui lòng nhập đầy đủ các trường thông tin này.!');
    } else {
        $('.notificationQuantityVariations').addClass('hidden');
    }
})

$(document).on('click', '.regularPriceInput', function () {
    const importPrice = $(this).closest('.variationItemContent').find('.importPriceInput');
    if (importPrice.val() == '') {
        notification('warning', 'Bạn cần nhập giá nhập trước!', 'Cảnh báo!', '3000');
        importPrice.focus();
    }
})

$(document).on('change', '.regularPriceInput', function () {
    const importPrice = $(this).closest('.variationItemContent').find('.importPriceInput');
    if (importPrice.val() == '') {
        notification('warning', 'Bạn cần nhập giá nhập trước!', 'Cảnh báo!', '3000');
        importPrice.focus();
        $(this).val('');
    }
    const salePrice = $(this).closest('.variationItemContent').find('.salePriceInput');
    if (checkNumberInput($(this))) {
        if (importPrice.val()) {
            if (parseFloat(importPrice.val()) >= parseFloat($(this).val())) {
                $(this).val('');
                notification('warning', 'Vui lòng nhập giá bán thông thường lớn hơn giá nhập!', 'Cảnh báo!', '3000');
            }
        }
        if (salePrice.val()) {
            if (parseFloat(salePrice.val()) >= parseFloat($(this).val())) {
                $(this).val(parseFloat(salePrice.val()) + 1);
                notification('warning', 'Vui lòng nhập giá bán thông thường lớn hơn giá bán đã giảm!', 'Cảnh báo!', '3000');
                // notification('warning', 'Please enter greater than sale price!', 'Cảnh báo!','3000');
            }
        }
    } else {
        if (salePrice.val()) {
            salePrice.val('');
        }
    }
    var countImportPrice = 0;
    var countRegularPrice = 0;
    $('.variationItem').each(function () {
        var importPriceInput = $(this).find('.importPriceInput').val();
        var regularPriceInput = $(this).find('.regularPriceInput').val();
        if (!importPriceInput) {
            countImportPrice++;
        }
        if (!regularPriceInput) {
            countRegularPrice++;
        }
    })
    if (countImportPrice != 0 && countRegularPrice != 0) {
        $('.notificationQuantityVariations').removeClass('hidden');
        $('.notificationQuantityVariations').text(countImportPrice + ' biến thể chưa có giá nhập và ' + countRegularPrice + ' biến thể chưa có giá bán thông thường, vui lòng nhập đầy đủ các trường thông tin này.!');
    } else if (countRegularPrice != 0 && countImportPrice == 0) {
        $('.notificationQuantityVariations').removeClass('hidden');
        $('.notificationQuantityVariations').text(countRegularPrice + ' biến thể chưa có giá bán thông thường, vui lòng nhập đầy đủ các trường thông tin này.!');
    } else if (countRegularPrice == 0 && countImportPrice != 0) {
        $('.notificationQuantityVariations').removeClass('hidden');
        $('.notificationQuantityVariations').text(countRegularPrice + ' biến thể chưa có giá nhập, vui lòng nhập đầy đủ các trường thông tin này.!');
    } else {
        $('.notificationQuantityVariations').addClass('hidden');
    }
})

$(document).on('click', '.salePriceInput', function () {
    const regularPrice = $(this).closest('.variationItemContent').find('.regularPriceInput');
    if (regularPrice.val() == '') {
        notification('warning', 'Bạn cần nhập giá bán thông thường trước!', 'Cảnh báo!', '3000');
        regularPrice.focus();
    }
})

$(document).on('change', '.salePriceInput', function () {
    checkNumberInput($(this));
    if (checkNumberInput($(this))) {
        const importPriceInput = $(this).closest('.variationItemContent').find('.importPriceInput').val();
        const regularPriceInput = $(this).closest('.variationItemContent').find('.regularPriceInput').val();
        if (regularPriceInput) {
            if (parseFloat(regularPriceInput) <= parseFloat($(this).val())) {
                $(this).val(regularPriceInput - 1);
                notification('warning', 'Vui nhập giá bán đã giảm nhỏ hơn giá bán thông thường!', 'Cảnh báo!', '3000');
                // notification('warning', 'Please enter less than regular price!', 'Cảnh báo!','3000');
            }
        } else {
            $(this).val('');
            notification('warning', 'Bạn cần nhập giá bán thông thường trước!', 'Cảnh báo!', '3000');
            // notification('warning', 'You need enter regular price first!', 'Cảnh báo!','3000');
        }
        if (importPriceInput) {
            if (parseFloat(importPriceInput) >= parseFloat($(this).val())) {
                $(this).val('');
                $(this).focus();
                notification('warning', 'Vui nhập giá bán đã giảm lớn hơn giá nhập!', 'Cảnh báo!', '3000');
                // notification('warning', 'Please enter greater than import price!', 'Cảnh báo!','3000');
            }
        }
    }
})
$(document).on('change', '.stockInput', function () {
    checkNumberInput($(this), 'stock');
})
//--------------------------------------Check for duplicate value---------------------------------------
$(document).on('change', '.skuInput', function () {
    saveVariations.addClass('disabledButton');
    saveVariationsStatus = false;
    var thisElement = $(this);
    var valueInput = thisElement.val();
    thisElement.val(convertToSlug(thisElement.val()));
    $('.skuInput').each(function () {
        if ($(this).val() == valueInput && thisElement[0] !== this) {
            var index = $(this).closest('.variationItem').find('strong').text();
            thisElement.val('');
            notification('warning', 'Trùng lặp SKU với biến thể ' + index, 'Cảnh báo!', '3000');
            // notification('warning', 'Duplicate value with variation ' + index, 'Cảnh báo!','3000');
        }
    })
})
//-----------------------------------Add values for all variations---------------------------------
function addValues(messageInput, classInput, message, forAll) {
    var value = prompt(messageInput);
    $('.container-spinner').removeClass('hidden');
    try {
        if (value) {
            saveVariations.addClass('disabledButton');
            saveVariationsStatus = false;
            if (!Number(value)) {
                notification('error', 'Vui lòng nhập số!', 'Lỗi!', '3000');
                // notification('error', 'Please enter number!', 'Lỗi!','3000');
            } else {
                $(classInput).each(function () {
                    if (forAll == false) {
                        if ($(this).val() == '') {
                            $(this).val(value);
                        }
                    } else {
                        $(this).val(value);
                    }
                })
                if (classInput == '.importPriceInput') {
                    var check = true;
                    $('.regularPriceInput').each(function () {
                        if ($(this).val() == '') {
                            check = false;
                        }
                    })
                    if (check) {
                        $('.notificationQuantityVariations').addClass('hidden');
                    }
                }
                if (classInput == '.regularPriceInput') {
                    var check = true;
                    $('.importPriceInput').each(function () {
                        if ($(this).val() == '') {
                            check = false;
                        }
                    })
                    if (check) {
                        $('.notificationQuantityVariations').addClass('hidden');
                    }
                }
                notification('success', message, 'Thành công!', '1000');
            }
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
}
$(document).on('change', '.controlVariationsSelect', function () {
    //Vietnamese version
    if ($(this).val() == 1) {
        addValues('Nhập "giá nhập" cho tất cả các biến thể chưa có giá nhập', '.importPriceInput', 'Thêm giá nhập cho tất cả các biến thể chưa có giá nhập thành công!', false);
    } else if ($(this).val() == 2) {
        addValues('Nhập "giá bán thông thường" cho tất cả các biến thể chưa có giá bán thông thường', '.regularPriceInput', 'Thêm giá bán thông thường cho tất cả các biến thể chưa có giá bán thông thường thành công!', false);
    } else if ($(this).val() == 3) {
        addValues('Nhập "giá bán đã giảm" cho tất cả các biến thể chưa có giá bán đã giảm', '.salePriceInput', 'Thêm giá bán đã giảm cho tất cả các biến thể chưa có giá bán đã giảm thành công!', false);
    } else if ($(this).val() == 4) {
        addValues('Nhập "số lượng" cho tất cả các biến thể chưa có số lượng', '.stockInput', 'Thêm số lượng cho tất cả các biến thể chưa có số lượng thành công!', false);
    } else if ($(this).val() == 5) {
        addValues('Nhập "giá nhập" cho tất cả các biến thể', '.importPriceInput', 'Thêm giá nhập cho tất cả các biến thể thành công!', true);
    } else if ($(this).val() == 6) {
        addValues('Nhập "giá bán thông thường" cho tất cả các biến thể', '.regularPriceInput', 'Thêm giá bán thông thường cho tất cả các biến thể thành công!', true);
    } else if ($(this).val() == 7) {
        addValues('Nhập "giá bán đã giảm" cho tất cả các biến thể', '.salePriceInput', 'Thêm giá bán đã giảm cho tất cả các biến thể thành công!', true);
    } else if ($(this).val() == 8) {
        addValues('Nhập "số lượng" cho tất cả các biến thể', '.stockInput', 'Thêm số lượng cho tất cả các biến thể thành công!', true);
    }
    //English version
    // if ($(this).val() == 1) {
    //     addValues('Enter "import price" for all variants without import price', '.importPriceInput', 'Added import price to all variants without import price successfully!', false);
    // } else if ($(this).val() == 2) {
    //     addValues('Enter "regular price" for all variants without regular price', '.regularPriceInput', 'Added regular price to all variants without regular price successfully!', false);
    // } else if ($(this).val() == 3) {
    //     addValues('Enter "sale price" for all variants without sale price', '.salePriceInput', 'Added sale price to all variants without sale price successfully!', false);
    // } else if ($(this).val() == 4) {
    //     addValues('Enter "quantity" for all variants without quantity', '.stockInput', 'Added quantity for all variants without quantity successfully!', false);
    // } else if ($(this).val() == 5) {
    //     addValues('Enter "import price" for all variants', '.importPriceInput', 'Added import price for all variants successfully!', true);
    // } else if ($(this).val() == 6) {
    //     addValues('Enter "regular price" for all variants', '.regularPriceInput', 'Added regular price for all variants successfully!', true);
    // } else if ($(this).val() == 7) {
    //     addValues('Enter "sale price" for all variants', '.salePriceInput', 'Added sale price for all variants successfully!', true);
    // } else if ($(this).val() == 8) {
    //     addValues('Enter "quantity" for all variants', '.stockInput', 'Added quantity for all variants successfully!', true);
    // }
})

//------------------------------Check all variations---------------------------------
$(document).on('click', '.checkVariationsStatus', function () {
    saveVariations.addClass('disabledButton');
    saveVariationsStatus = false;
    var variationsIndex = [];
    var check = true;
    var checkSelectAttribute = false;

    var checkRegularAndSalePrice = true;
    var regularAndSalePriceVariationsIndex = [];

    var checkImportAndSalePrice = true;
    var importSaleVariationsIndex = [];

    var failedVariations = [];
    $('.container-spinner').removeClass('hidden');
    try {
        $('.variationItem').each(function () {
            checkSelectAttribute = false;
            $(this).find('.variationItemTitle').find('select').each(function () {
                if ($(this).val() != '') {
                    console.log($(this).val());
                    checkSelectAttribute = true;
                    return false;
                }
            })
            if (!checkSelectAttribute) {
                check = false;
                if ($.inArray($(this), failedVariations) === -1) {
                    failedVariations.push($(this));
                }
                return false;
            }
            var index = $(this).find('strong').text();
            var importPriceInput = $(this).find('.importPriceInput').val();
            var regularPriceInput = $(this).find('.regularPriceInput').val();
            var salePriceInput = $(this).find('.salePriceInput').val();
            var stockInput = $(this).find('.stockInput').val();

            if (!Number(importPriceInput) && importPriceInput != '') {
                notification('error', 'Giá nhập của biến thể ' + index + ' phải là số!');
                if ($.inArray($(this), failedVariations) === -1) {
                    failedVariations.push($(this));
                }
                check = false;
                return false;
            }
            if (!Number(regularPriceInput) && regularPriceInput != '') {
                notification('error', 'Giá bán thông thường của biến thể ' + index + ' phải là số!');
                if ($.inArray($(this), failedVariations) === -1) {
                    failedVariations.push($(this));
                }
                check = false;
                return false;
            }
            if (!Number(salePriceInput) && salePriceInput != '') {
                notification('error', 'Giá bán đã giảm của biến thể ' + index + ' phải là số!');
                if ($.inArray($(this), failedVariations) === -1) {
                    failedVariations.push($(this));
                }
                check = false;
                return false;
            }
            if (salePriceInput != '' && parseFloat(salePriceInput) >= parseFloat(regularPriceInput)) {
                checkRegularAndSalePrice = false;
                regularAndSalePriceVariationsIndex.push(index);
                if ($.inArray($(this), failedVariations) === -1) {
                    failedVariations.push($(this));
                }
            }
            if (salePriceInput != '' && parseFloat(salePriceInput) <= parseFloat(importPriceInput)) {
                checkImportAndSalePrice = false;
                importSaleVariationsIndex.push(index);
                if ($.inArray($(this), failedVariations) === -1) {
                    failedVariations.push($(this));
                }
            }

            if (!regularPriceInput || !stockInput || !importPriceInput) {
                check = false;
                variationsIndex.push(index);
                if ($.inArray($(this), failedVariations) === -1) {
                    failedVariations.push($(this));
                }
            } else {
                switchShowHidden($(this).find('.variationItemContent'), '', '', 'hidden');
            }
        })
        if (!checkSelectAttribute) {
            notification('warning', 'Vui lòng chọn ít nhất 1 thuộc tính từ thẻ select của biến thể', 'Cảnh báo!', '3000');
            failedVariations.forEach(function (item) {
                switchShowHidden(item.find('.variationItemContent'), '', '', 'show');
                $('#variations').prepend(item);
            })
        } else if (!check && variationsIndex.length > 0) {
            saveVariations.addClass('disabledButton');
            saveVariationsStatus = false;
            notification('warning', 'Biến thể ' + variationsIndex.join(', ') + ' không được để trống thông tin!', 'Cảnh báo!', '3000');
            failedVariations.forEach(function (item) {
                switchShowHidden(item.find('.variationItemContent'), '', '', 'show');
                $('#variations').prepend(item);
            })
        } else if (!checkRegularAndSalePrice) {
            notification('error', 'Giá bán thông thường của biến thể ' + regularAndSalePriceVariationsIndex.join(', ') + ' phải lớn hơn giá bán đã giảm!');
            failedVariations.forEach(function (item) {
                switchShowHidden(item.find('.variationItemContent'), '', '', 'show');
                $('#variations').prepend(item);
            })
        } else if (!checkImportAndSalePrice) {
            notification('error', 'Giá nhập của biến thể ' + importSaleVariationsIndex.join(', ') + ' phải nhỏ hơn giá bán đã giảm!');
            failedVariations.forEach(function (item) {
                switchShowHidden(item.find('.variationItemContent'), '', '', 'show');
                $('#variations').prepend(item);
            })
        }
        if (check && checkRegularAndSalePrice && checkImportAndSalePrice) {
            saveVariations.removeClass('disabledButton');
            saveVariationsStatus = true;
        } else {
            saveVariations.addClass('disabledButton');
            saveVariationsStatus = false;
        }
        // pagination();
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//----------------------------------------Save variations-----------------------------------------
var variationDataHasBeenSaved = [];
$(document).on('click', '.saveVariations', function () {
    $('.container-spinner').removeClass('hidden');
    try {
        if (saveVariationsStatus) {
            variationDataHasBeenSaved = [];
            $('.variationItem').each(function () {
                var variationData = {};
                variationData.variationAttributeData = [];
                var selects = $(this).find('.variationItemTitle').find('select');
                var name = '';
                selects.each(function (index) {
                    var variationValue = {};
                    if ($(this).attr('id')) {
                        variationValue.attributeId = $(this).attr('id');
                        variationValue.attributeValueId = $(this).val();
                    } else {
                        variationValue.attributeName = $(this).attr('name');
                        variationValue.attributeValue = $(this).val();
                    }
                    variationData.variationAttributeData.push(variationValue);
                    if (index > 0 && $(this).val() != '') {
                        name += '-';
                    }
                    var selectedText = $(this).find('option:selected').text();
                    if ($(this).val() != '') {
                        name += selectedText;
                    }

                    console.log(selectedText);

                })
                const index = $(this).find('strong').text();

                variationData.name = name;

                const image = $(this).find('.variationImageInput')[0];
                variationData.image_data = image.files[0] ? image.files[0] : null;

                var sku = $(this).find('.skuInput');
                sku = sku.val() ? sku.val() : '';
                variationData.sku = sku;

                const importPrice = $(this).find('.importPriceInput');
                variationData.import_price = importPrice.val();

                const regularPrice = $(this).find('.regularPriceInput');
                variationData.regular_price = regularPrice.val();

                const salePrice = $(this).find('.salePriceInput');
                variationData.sale_price = salePrice.val();

                const stock = $(this).find('.stockInput');
                variationData.stock = stock.val();

                const active = $(this).find('.activeSelect');
                variationData.active = active.val();

                console.log(regularPrice.val());
                console.log(salePrice.val());

                if (parseFloat(regularPrice.val()) < parseFloat(salePrice.val())) {
                    notification('warning', 'Giá bán đã giảm phải nhỏ hơn giá bán thông thường của!', 'Variation ' + index + '!');
                    // notification('warning', 'Sale price need less than regular price!', 'Variation ' + index + '!');
                    return false;
                }
                variationDataHasBeenSaved.push(variationData);
            })
            notification('success', 'Lưu biến thể thành công!.', 'Thành công!', '1000');
            console.log(variationDataHasBeenSaved);
        } else {
            notification('error', 'Có lỗi xảy ra khi lưu biến thể, vui lòng kiểm tra lại dữ liệu của các biến thể.', 'Lỗi!', '3000');
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        $('.container-spinner').addClass('hidden');
    }
})
//----------------------------------------SUBMIT FORM---------------------------------------
//-------------------------------------Create product by ajax-------------------------------------
function createNewProduct(productData) {
    return new Promise((resolve, reject) => {
        var formData = new FormData();

        // Duyệt qua `productData` và thêm vào `formData`
        formData.append('baseInformation[sku]', productData.baseInformation.sku);
        formData.append('baseInformation[name]', productData.baseInformation.name);
        formData.append('baseInformation[description]', productData.baseInformation.description);
        formData.append('baseInformation[status]', productData.baseInformation.status);

        //Thêm thương hiệu
        formData.append('brandId', productData.brandId);

        // Thêm main image
        formData.append('mainImage', productData.image);

        // Thêm hình ảnh khác
        productData.images.forEach((image, index) => {
            formData.append(`images[${index}]`, image);
        });

        // Thêm video
        productData.videos.forEach((video, index) => {
            formData.append(`videos[${index}]`, video);
        });

        // Thêm các danh mục ID
        productData.categoriesId.forEach((categoryId, index) => {
            formData.append(`categoriesId[${index}]`, categoryId);
        });

        // Thêm các biến thể
        productData.variations.forEach((variation, index) => {
            // Thêm các thuộc tính khác của biến thể
            formData.append(`variations[${index}][active]`, variation.active);
            formData.append(`variations[${index}][import_price]`, variation.import_price);
            formData.append(`variations[${index}][regular_price]`, variation.regular_price);
            formData.append(`variations[${index}][name]`, variation.name);
            formData.append(`variations[${index}][sale_price]`, variation.sale_price);
            formData.append(`variations[${index}][sku]`, variation.sku);
            formData.append(`variations[${index}][stock]`, variation.stock);

            // Thêm image_data nếu có
            if (variation.image_data) {
                formData.append(`variations[${index}][image_data]`, variation.image_data);
            }

            // Thêm variationAttributeData
            variation.variationAttributeData.forEach((attribute, attrIndex) => {
                if (attribute.attributeId) {
                    formData.append(`variations[${index}][variationAttributeData][${attrIndex}][attributeId]`, attribute.attributeId);
                } else {
                    formData.append(`variations[${index}][variationAttributeData][${attrIndex}][attributeName]`, attribute.attributeName);
                }
                if (attribute.attributeValueId) {
                    formData.append(`variations[${index}][variationAttributeData][${attrIndex}][attributeValueId]`, attribute.attributeValueId);
                } else {
                    formData.append(`variations[${index}][variationAttributeData][${attrIndex}][attributeValue]`, attribute.attributeValue);
                }
            });
        });
        // Thêm CSRF token
        formData.append('_token', csrf);

        $.ajax({
            url: routeStoreProduct,
            method: 'POST',
            data: formData,
            processData: false, // Không xử lý `formData`
            contentType: false, // Không đặt `Content-Type`
            success: function (response) {
                if (response.status == 400) {
                    notification('error', response.message, 'Lỗi');
                } else {
                    notification('success', response.message, 'Thành công', 2000);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Có lỗi xảy ra, vui lòng thử lại!', 'Lỗi');
                reject();
            }
        });
    });
}
var statusProductSku = true;
function checkProductSku(input) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetProductSku,
            method: "POST",
            data: {
                sku: input,
                _token: csrf
            },
            success: function (response) {
                if (response.status == 400) {
                    statusProductSku = false;
                }
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể lấy được dữ liệu để kiểm tra mã sản phẩm!', 'Lỗi');
                reject();
            }
        });
    })
}
$(document).on('change', '.productSku', async function () {
    $(this).val(convertToSlug($(this).val()));
    await checkProductSku($(this).val());
    if (!statusProductSku) {
        notification('warning', 'Mã sản phẩm đã tồn tại, vui lòng thử lại!', 'Cảnh báo!', '3000');
        statusProductSku = true;
        $(this).val('');
    }
})
var statusProductSkuVariation = true;
function checkProductSkuVariation(input) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: routeGetProductVariationSku,
            method: "POST",
            data: {
                sku: input,
                _token: csrf
            },
            success: function (response) {
                if (response.status == 400) {
                    statusProductSkuVariation = false;
                }
                resolve();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                notification('error', 'Không thể lấy được mã sản phẩm để kiểm tra sự tồn tại!', 'Lỗi');
                reject();
            }
        });
    })
}
$(document).on('change', '.skuInput', async function () {
    await checkProductSkuVariation($(this).val());
    if (!statusProductSkuVariation) {
        notification('warning', 'Mã biến thể đã tồn tại, vui lòng thử lại!', 'Cảnh báo!', '3000');
        statusProductSkuVariation = true;
        $(this).val('');
    }
})
$(document).on('click', '#publishBtn', async function () {
    var productData = {
        baseInformation: {
            sku: '',
            name: '',
            description: '',
            status: ''
        },
        image: null,
        images: [], // Để rỗng vì đây là mảng
        videos: [], // Để rỗng vì đây là mảng
        categoriesId: [], // Để rỗng vì đây là mảng
        brandId: '', // Để rỗng vì đây là mảng
        variations: [] // Để rỗng vì đây là mảng
    };
    var checkData = true;

    // Lấy dữ liệu các trường đầu vào
    var productSku = $('.productSku').val();
    var productName = $('.productName').val();
    var productDescription = tinymce.get('productDescription').getContent();
    var productActive = $('.productActive').prop("checked");

    // Kiểm tra tính hợp lệ của các trường
    if (!productSku) {
        checkData = false;
        notification('warning', 'Vui lòng nhập SKU cho sản phẩm!', 'Cảnh báo!', '3000');
    }
    if (!productName) {
        checkData = false;
        notification('warning', 'Vui lòng nhập tên cho sản phẩm!', 'Cảnh báo!', '3000');
    }
    if (!productDescription) {
        checkData = false;
        notification('warning', 'Vui lòng nhập mô tả cho sản phẩm!', 'Cảnh báo!', '3000');
    }

    // Kiểm tra hình ảnh chính
    if (mainImageFile == null) {
        checkData = false;
        notification('warning', 'Vui lòng tải ảnh lên cho sản phẩm!', 'Cảnh báo!', '3000');
    }

    // Lấy danh sách danh mục đã chọn
    for (const element of $('.categoryItem')) {
        if ($(element).prop("checked")) {
            var getCategoryId = $(element).attr('id');
            var checkCategory = await checkCategoryByAjax(getCategoryId);
            if (checkCategory) {
                productData.categoriesId.push(getCategoryId);
            } else {
                checkData = false;
                notification('error', 'Một danh mục được chọn không tồn tại trong cơ sở dữ liệu!', 'Lỗi!', '3000');
                break;
            }
        }
    }
    for (const element of $('.brandItem')) {
        if ($(element).prop("checked")) {
            var getBrandId = $(element).attr('id');
            var checkBrand = await checkBrandByAjax(getBrandId);
            if (checkBrand) {
                productData.brandId = getBrandId;
            } else {
                checkData = false;
                notification('error', 'Thương hiệu được chọn không tồn tại trong cơ sở dữ liệu!', 'Lỗi!', '3000');
                break;
            }
        }
    }

    $('.brandItem').each(async function () {
        if ($(this).prop("checked")) {
            var getBrandId = $(this).attr('id');
            productData.brandId = getBrandId;
        }
    });

    // Kiểm tra biến thể sản phẩm
    if (!variationDataHasBeenSaved.length || !saveVariationsStatus) {
        checkData = false;
        notification('warning', "Thêm ít nhất một biến thể nếu bạn chưa thêm. Nếu bạn thực hiện bất kỳ thay đổi nào đối với biến thể, hãy nhấp vào nút lưu biến thể.", 'Cảnh báo!', '3000');
    }

    // Nếu tất cả các dữ liệu hợp lệ, thêm chúng vào `productData`
    if (checkData) {
        var checkNumberOfUploadedFiles = 1;
        checkNumberOfUploadedFiles += selectedImages.length + selectedVideos.length + variationDataHasBeenSaved.length;
        if (checkNumberOfUploadedFiles >= 30) {
            notification('warning', 'Số lượng file gửi lên quá giới hạn, mỗi lần chỉ được gửi tối đa 30 files', 'Quá nhiều files được gửi lên!', '5000');
        } else {
            productData.baseInformation.sku = productSku;
            productData.baseInformation.name = productName;
            productData.baseInformation.description = productDescription;
            productData.baseInformation.status = productActive;
            productData.image = mainImageFile;
            productData.images = selectedImages;
            productData.videos = selectedVideos;
            productData.variations = variationDataHasBeenSaved;
            console.log(productData);
            $('.container-spinner').removeClass('hidden');

            try {
                await createNewProduct(productData);
            } catch (error) {
                console.error('Error:', error);
            } finally {
                $('.container-spinner').addClass('hidden');
            }
        }
    } else {
        notification('error', 'Dữ liệu không hợp lệ, vui lòng kiểm tra lại!', 'Lỗi!', '3000');
    }
});
