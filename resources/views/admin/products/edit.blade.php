@extends('admin.layouts.master')

@section('title')
Tạo mới sản phẩm
@endsection

@section('style-libs')
<link rel="stylesheet" href="{{asset('css/admin/product/edit.css')}}">
@endsection


@section('script-libs')
<script src="{{asset('js/admin/product/edit.js')}}"></script>
@endsection

@section('content')
<div class="mb-2 ml-3">
    <a href="{{route('admin.products.index')}}" class="btn btn-dark text-white text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>
<div class="card shadow mb-4">
    <h1 class="h2 mt-3 text-center text-gray-800 fw-bold">Cập nhật sản phẩm <b class="titleOldProductName"></b></h1>
    <div class="card-body">
        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            <div class="mt-1 d-flex justify-content-end">
                <span class="btn btn-success hidden" id="publishBtn">Cập nhật</span>
            </div>
            @csrf
            <div class="mt-3 shadow mb-3 bg-body-tertiary rounded">
                <div class="w-100 border-bottom p-2 d-flex justify-content-between align-items-center cspt no-select hoverTextBlack" id="baseProductSwitch">
                    <span class="font-weight-bold">Thông tin cơ bản của sản phẩm</span>
                    <i class="fas fa-chevron-up fa-xl" id="chevronBaseProduct"></i>
                </div>
                <div class="d-flex flex-row mt-2 p-3 justify-content-between" id="baseProduct" data-baseproduct="show">
                    <div class="w-50">
                        <div class="mb-3" hidden>
                            <label for="" class="form-label">ID</label>
                            <input type="text" name="id" class="form-control" id="oldProductId" value="{{$id}}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Mã sản phẩm</label>
                            <input type="text" name="sku" class="form-control oldProductSku" placeholder="Nhập mã cho sản phẩm">
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control oldProductName" placeholder="Nhập tên cho sản phẩm">
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control oldProductDescription" id="oldProductDescription" cols="40" rows="4" placeholder="Nhập mô tả cho sản phẩm"></textarea>
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="" class="form-label">Trạng thái</label>
                            <input type="checkbox" name="is_active" class="oldProductActive">
                        </div>
                        <div class="shadow bg-body-tertiary rounded mb-3" id="category-container">
                            <div class="w-100 border-bottom p-2 d-flex justify-content-between align-items-center cspt no-select hoverTextBlack productCategoryTitle">
                                <li class="text-primary no-select font-weight-bold">Danh mục sản phẩm</li>
                                <i class="fas fa-chevron-up fa-lg" id="chevronProductCategory"></i>
                            </div>
                            <div id="contentCategoryContainer" class="pb-2" data-productcategory="show">
                                <div class="p-2">
                                    <span class="cspt no-select btn btn-outline-primary btn-sm" id="btnOpenCloseFormAddCategory">+ Thêm mới danh mục</span>
                                    <div class="formAddNewCategory w-50 p-2 hidden">
                                        <input type="text" class="form-control form-control-sm categoryName m-2" placeholder="Nhập tên danh mục mới">
                                        <select name="" id="selectNewCategory" class="form-control form-control-sm m-2">
                                            <!-- <option value="">&mdash;Parent category&mdash;</option> -->
                                        </select>
                                        <span class="btn btn-success btn-sm" id="addNewCategoryBtn">Thêm mới danh mục</span>
                                    </div>
                                </div>
                                <div id="contentCategory" class="category-scroll-container">
                                    <!-- Hiển thị danh sách danh mục ở đây -->
                                </div>
                            </div>
                        </div>
                        <div class="shadow bg-body-tertiary rounded mb-3" id="brand-container">
                            <div class="w-100 border-bottom p-2 d-flex justify-content-between align-items-center cspt no-select hoverTextBlack productBrandTitle">
                                <li class="text-primary no-select font-weight-bold">Thương hiệu sản phẩm</li>
                                <i class="fas fa-chevron-up fa-lg" id="chevronProductBrand"></i>
                            </div>
                            <div id="contentBrandContainer" class="pb-2" data-productbrand="show">
                                <div class="p-2">
                                    <span class="cspt no-select btn btn-outline-primary btn-sm" id="btnOpenCloseFormAddBrand">+ Thêm mới thương hiệu</span>
                                    <div class="formAddNewBrand w-50 p-2 hidden">
                                        <input type="text" class="form-control form-control-sm brandName m-2" placeholder="Nhập tên thương hiệu mới">
                                        <span class="btn btn-success btn-sm" id="addNewBrandBtn">Thêm mới thương hiệu</span>
                                    </div>
                                </div>
                                <div id="contentBrand" class="brand-scroll-container">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ml-3 d-flex flex-column w-50">
                        <div class="mb-5">
                            <div class="d-flex justify-content-between">
                                <li class="text-primary no-select no-bullet">Ảnh chính</li>
                            </div>
                            <div class="row row-cols-5 w-100 mt-2" id="mainImagePreview">
                                <div class="col mb-2">
                                    <div class="card d-flex" style="width: 100px; height: 100px; border: 2px dashed #6c757d;">
                                        <div class="form-group text-center">
                                            <label for="imageUpload" class="form-label" style="cursor: pointer;">
                                                <svg width="20" height="20" fill="#6c757d" class="bi bi-cloud-upload mt-2" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c1.657 0 3.156.832 4.094 2.122a3.993 3.993 0 0 1 4.902 4.252A4.5 4.5 0 0 1 14.5 16h-13a4.5 4.5 0 0 1-.93-8.906 5.53 5.53 0 0 1 3.836-5.752zM7.5 8.5V12a.5.5 0 0 0 1 0V8.5H11a.5.5 0 0 0 0-1H8.5V5a.5.5 0 0 0-1 0v2.5H5a.5.5 0 0 0 0 1h2.5z" />
                                                </svg>
                                                <div class="mt-2">Bấm để tải lên</div>
                                            </label>
                                            <input type="file" class="form-control d-none" id="imageUpload" name="image" multiple accept="image/*" onchange="previewImage(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <div class="d-flex justify-content-between">
                                <li class="text-primary no-select no-bullet">Thư viện ảnh</li>
                                <span class="text-dange" id="removeAllImagesBtn">Xóa tất cả</span>
                            </div>
                            <div class="row row-cols-5 w-100 mt-2" id="imagePreview">
                                <div class="col mb-2">
                                    <div class="card d-flex" style="width: 100px; height: 100px; border: 2px dashed #6c757d;">
                                        <div class="form-group text-center">
                                            <label for="imageUploads" class="form-label" style="cursor: pointer;">
                                                <svg width="20" height="20" fill="#6c757d" class="bi bi-cloud-upload mt-2" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c1.657 0 3.156.832 4.094 2.122a3.993 3.993 0 0 1 4.902 4.252A4.5 4.5 0 0 1 14.5 16h-13a4.5 4.5 0 0 1-.93-8.906 5.53 5.53 0 0 1 3.836-5.752zM7.5 8.5V12a.5.5 0 0 0 1 0V8.5H11a.5.5 0 0 0 0-1H8.5V5a.5.5 0 0 0-1 0v2.5H5a.5.5 0 0 0 0 1h2.5z" />
                                                </svg>
                                                <div class="mt-2">Bấm để tải lên</div>
                                            </label>
                                            <input type="file" class="form-control d-none" id="imageUploads" name="images[]" multiple accept="image/*" onchange="previewImages(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <div class="d-flex justify-content-between">
                                <li class="text-primary no-select no-bullet">Videos</li>
                                <span class="text-dange" id="removeAllVideosBtn">Xóa tất cả</span>
                            </div>
                            <div class="row row-cols-4 w-100 mt-2" id="videoPreview">
                                <div class="col mb-2">
                                    <div class="card d-flex" style="width: 100px; height: 100px; border: 2px dashed #6c757d;">
                                        <div class="form-group text-center">
                                            <label for="videoUpload" class="form-label" style="cursor: pointer;">
                                                <svg width="20" height="20" fill="#6c757d" class="bi bi-cloud-upload mt-2" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c1.657 0 3.156.832 4.094 2.122a3.993 3.993 0 0 1 4.902 4.252A4.5 4.5 0 0 1 14.5 16h-13a4.5 4.5 0 0 1-.93-8.906 5.53 5.53 0 0 1 3.836-5.752zM7.5 8.5V12a.5.5 0 0 0 1 0V8.5H11a.5.5 0 0 0 0-1H8.5V5a.5.5 0 0 0-1 0v2.5H5a.5.5 0 0 0 0 1h2.5z" />
                                                </svg>
                                                <div class="mt-2">Bấm để tải lên</div>
                                            </label>
                                            <input type="file" class="form-control d-none" id="videoUpload" name="videos[]" multiple accept="video/*" onchange="previewVideos(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shadow mb-3 bg-body-tertiary rounded">
                <div class="w-100 border-bottom p-2 d-flex justify-content-between align-items-center cspt no-select hoverTextBlack" id="baseCustomVariantsSwitch">
                    <span class="font-weight-bold">Tùy chỉnh biến thể</span>
                    <i class="fas fa-chevron-up fa-xl" id="chevronCustomVariants"></i>
                </div>
                <div class="p-3 d-flex flex-row" id="customVariants" data-customVariants="show">
                    <!-- Tùy chỉnh thuộc tính -->
                    <div class="w-50 mr-4">
                        <li class="text-primary">Thuộc tính</li>
                        <div class="mt-2 border-bottom d-flex flex-row pb-3">
                            <span class="btn btn-primary btn-sm mr-2 no-wrap" id="addNewAttribute">Thêm mới</span>
                            <div class="w-50" id="loadAttributeData">
                                <select name="selectAddExisting" id="selectAddExisting" multiple>
                                    <option data-placeholder="true"></option>
                                </select>
                            </div>
                        </div>
                        <div id="attributeItems" class="attribute-scroll-container pr-3">
                            <!-- Danh sách thuộc tính ở đây -->
                        </div>
                        <div class="mt-3">
                            <span class="btn btn-primary btn-sm disabledButton" id="saveAttributesBtn">Lưu thuộc tính</span>
                        </div>
                    </div>

                    <!-- Tạo biến thể -->
                    <div class="w-50">
                        <li class="text-primary">Biến thể</li>
                        <div class="mt-2 border-bottom d-flex flex-row pb-3 align-items-center justify-content-between">
                            <div class="d-flex flex-row">
                                <span class="btn btn-primary btn-sm mr-2 no-wrap" id="generateVariations">Tạo biến thể tự động</span>
                                <span class="btn btn-primary btn-sm mr-2 no-wrap" id="addManually"> Thêm thủ công</span>
                            </div>
                        </div>
                        <p align="center" class="notificationNoVariationsYet hidden">Chưa có biến thể nào. Tạo chúng từ tất cả các thuộc tính đã thêm hoặc thêm biến thể mới theo cách thủ công.</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>
                                <p class="notificationQuantityVariations mr-5"></p>
                            </div>
                            <div class="d-flex flex-column align-items-end w-25">
                                <select name="" id="" class="form-control controlVariationsSelect bg-primary btn-sm text-white">
                                    <option value="">Thao tác</option>
                                    <option value="1" class="addImportPriceForVariationsNoHaveValue">Nhập "giá nhập" cho tất cả các biến thể chưa có giá nhập</option>
                                    <option value="2" class="addRegularPriceForVariationsNoHaveValue">Nhập "giá bán thông thường" cho tất cả các biến thể chưa có giá bán thông thường</option>
                                    <option value="3" class="addSalePriceForVariationsNoHaveValue">Nhập "giá bán đã giảm" cho tất cả các biến thể chưa có giá bán đã giảm</option>
                                    <option value="4" class="addStockForVariationsNoHaveValue">Nhập "số lượng" cho tất cả các biến thể chưa có số lượng</option>
                                    <option value="5" class="addImportPriceAllForVariations">Nhập "giá nhập" cho tất cả các biến thể</option>
                                    <option value="6" class="addRegularPriceAllForVariations">Nhập "giá bán thông thường" cho tất cả các biến thể</option>
                                    <option value="7" class="addSalePriceForAllVariations">Nhập "giá bán đã giảm" cho tất cả các biến thể</option>
                                    <option value="8" class="addStockForAllVariations">Nhập "số lượng" cho tất cả các biến thể</option>
                                    <!-- English version -->
                                    <!-- <option value="1" class="addImportPriceForVariationsNoHaveValue">Enter "import price" for all variants that do not have an  import price</option>
                                    <option value="2" class="addRegularPriceForVariationsNoHaveValue">Enter "regular price" for all variants that do not have an regular price</option>
                                    <option value="3" class="addSalePriceForVariationsNoHaveValue">Enter "sale price" for all variants that do not have a sale price</option>
                                    <option value="4" class="addStockForVariationsNoHaveValue">Enter "quantity" for all variants that do not have a quantity</option>
                                    <option value="5" class="addImportPriceAllForVariations">Enter "import price" for all variants</option>
                                    <option value="6" class="addRegularPriceAllForVariations">Enter "regular price" for all variants</option>
                                    <option value="7" class="addSalePriceForAllVariations">Enter "sale price" for all variants</option>
                                    <option value="8" class="addStockForAllVariations">Enter "quantity" for all variants</option> -->
                                </select>
                                <span class="btn btn-danger btn-sm mt-2 no-wrap deleteAllVariations">Xóa tất cả biến thể</span>
                            </div>
                        </div>
                        <div id="variations" class="pt-2">
                            <!-- <div class="cspt pb-2 variationItem">
                                <div class="border-bottom d-flex flex-row justify-content-between pb-2 no-select variationItemTitle" data-status="hidden">
                                    <div class="d-flex flex-row align-items-center">
                                        <strong class="text-dark mr-2">#1</strong>
                                        <select name="" id="" class="form-control mr-2">
                                            <option value="">Any color</option>
                                        </select>
                                        <select name="" id="" class="form-control mr-2">
                                            <option value="">Any color</option>
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center flex-row">
                                        <i class="fas fa-bars fa-sm" style="margin-right:12px;"></i>
                                        <span class="text-danger cspt no-select mr-2 removeVariationItemBtn" id="" style="font-size:14px">Remove</span>
                                        <span class="text-primary cspt no-select mr-2" id="" style="font-size:14px">Edit</span>
                                    </div>
                                </div>
                                <div class="border-bottom p-3 variationItemContent hidden">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="w-50 mr-4 d-flex flex-row justify-content-around">
                                            <div class="card d-flex" style="width: 100px; height: 100px; border: 2px dashed #6c757d;">
                                                <div class="form-group text-center">
                                                    <label for="variationImage" class="form-label cspt">
                                                        <div class="mt-2">
                                                            <i class="fas fa-upload fa-lg"></i>
                                                        </div>
                                                        <div class="mt-2">Click to upload</div>
                                                    </label>
                                                    <input type="file" class="form-control d-none variationImageInput" id="variationImage" name="variation" accept="image/*" onchange="previewVariationImage(this)">
                                                </div>
                                            </div>
                                            <div class="previewVariationImage rounded position-relative" style="width: 100px; height: 100px;">
                                            </div>
                                        </div>
                                        <div class="w-50">
                                            <div class="d-flex flex-column">
                                                <label for="" class="badge text-left">SKU</label>
                                                <input type="text" class="form-control skuInput" placeholder="Enter variation's SKU...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex flex-column mt-3">
                                            <label for="" class="badge text-left d-flex flex-row">Import price <p class="text-danger ml-1 mb-0">(*)</p></label>
                                            <input type="number" class="form-control importPriceInput" placeholder="Enter variation's  import price...">
                                        </div>
                                        <div class="d-flex flex-row justify-content-between mt-3">
                                            <div class="d-flex flex-column w-50 mr-4">
                                                <label for="" class="badge text-left">Regular price (đ)</label>
                                                <input type="number" class="form-control regularPriceInput" placeholder="Enter variation's regular price...">
                                            </div>
                                            <div class="d-flex flex-column w-50">
                                                <label for="" class="badge text-left">Sale price (đ)</label>
                                                <input type="number" class="form-control salePriceInput" placeholder="Enter variation's sale price...">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column mt-3">
                                            <label for="" class="badge text-left">Stock</label>
                                            <input type="number" class="form-control stockInput" placeholder="Enter variation's sale price...">
                                        </div>
                                        <div class="d-flex flex-column mt-3">
                                            <label for="" class="badge text-left">Active</label>
                                            <select name="" id="" class="form-control activeSelect">
                                                <option value="true" selected>Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination" style="display: none;">
                                <a href="#" class="page-link" id="firstPage">
                                    << </a>
                                        <a href="#" class="page-link" id="prevPage">
                                            < </a>
                                                <select id="pageSelect" class="form-control">
                                                    <!-- Các tùy chọn trang sẽ được thêm vào đây -->
                                                </select>
                                                <a href="#" class="page-link" id="nextPage">></a>
                                                <a href="#" class="page-link" id="lastPage">>></a>
                            </div>
                        </div>
                        <div>
                            <span class="btn btn-primary btn-sm checkVariationsStatus">Kiểm tra</span>
                            <span class="btn btn-success btn-sm disabledButton saveVariations">Lưu biến thể</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container-spinner position-fixed d-flex justify-content-center align-items-center w-100 h-100 hidden">
    <div class="overlay"></div>
    <div class="spinner-border text-primary" id="loadingSpinner" role="status">
    </div>
</div>
@endsection