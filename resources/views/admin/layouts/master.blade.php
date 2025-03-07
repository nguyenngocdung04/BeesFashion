<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('theme/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('theme/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Notification library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- Slimselect -->
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>

    <!-- RateYo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @yield('style-libs')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                @include('admin.layouts.header')
                <!-- End of Topbar -->
                @yield('content')
            </div>
            <!-- Footer -->
            @include('admin.layouts.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{route('logout')}}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('theme/admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('theme/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('theme/admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('theme/admin/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://kit.fontawesome.com/be9ed8669f.js" crossorigin="anonymous"></script>

    <!-- Notification library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.js.map"></script>
    <!-- Notification function -->
    <script>
        function notification(type, data, title, timeOut = "10000") {
            $(document).ready();
            $(function() {
                Command: toastr[type](data, title);
                toastr.options = {
                    closeButton: true,
                    debug: false,
                    newestOnTop: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    preventDuplicates: true,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: timeOut,
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                };
            });
        };
        const csrf = "{{ csrf_token() }}";
        //Route variable SHOW
        const routeImportingGoods = "{{route('admin.importingGoods')}}";
        //Route variable CREATE and EDIT
        const routeGetAllAttributes = "{{route('admin.getAllAttributes')}}";

        const routeGetAllCategories = "{{route('admin.getAllCategories')}}";
        const routeCreateNewCategory = "{{route('admin.createNewCategory')}}";
        const routeCheckCategoryById = "{{route('admin.checkCategoryById')}}";

        const routeGetAllBrands = "{{route('admin.getAllBrands')}}";
        const routeCreateNewBrand = "{{route('admin.createNewBrand')}}";
        const routeCheckBrandById = "{{route('admin.checkBrandById')}}";

        const routeGetProductSku = "{{route('admin.getProductSku')}}";
        const routeGetProductVariationSku = "{{route('admin.getProductVariationSku')}}";

        const routeGetAllAttributeValuesById = "{{ route('admin.getAllAttributeValuesById') }}";
        const routeAddNewAttributeValueById = "{{ route('admin.addNewAttributeValueById') }}";

        //Route variable CREATE
        const routeStoreProduct = "{{route('admin.products.store')}}";
        //Route variable EDIT
        const routeGetOldProductData = "{{route('admin.getOldProductData')}}";

        function returnRouteUpdateProduct(id) {
            return "{{route('admin.products.update',':id')}}".replace(':id', id);
        }

        //Thông báo cố định
    </script>

    <!-- Slim Select -->
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js">
        new SlimSelect({
            select: '#selectElement'
        })
    </script>

    <!-- AnimeJs
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.js"></script>-->

    <!-- Tinymce -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.0.0/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#productDescription',
            plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
            automatic_uploads: true,
            license_key: 'gpl'
        });
        // tinymce.init({
        //     selector: '#oldProductDescription',
        //     plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
        //     automatic_uploads: true,
        // });
    </script>

    <!-- RateYo -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <!-- Link libs -->
    @yield('script-libs')

    <!-- Short notification commands -->

    <script>
        @if(session('statusSuccess'))
        var message = @json(session('statusSuccess'));
        notification('success', message, 'Thông báo!');
        @elseif(session('statusError'))
        var message = @json(session('statusError'));
        notification('error', message, 'Thông báo!');
        @elseif(session('statusWarning'))
        var message = @json(session('statusWarning'));
        notification('warning', message, 'Cảnh báo!');
        @endif
    </script>
</body>

</html>