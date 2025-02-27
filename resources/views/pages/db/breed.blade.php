@extends('layouts.main')
@section('head')
    <link href="assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Cơ sở sản xuất giống</h4>
                        </div>

                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{route('db.breed.add')}}" class="btn btn-sm btn-primary">
                                <i class="ri-add-line me-1"></i>
                                Thêm mới
                            </a>
                            <div class="col-auto dropstart">
                                <a style="padding: 8px;" class="btn btn-secondary btn-sm" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i data-lucide="ellipsis-vertical"></i>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{route('db.processing.export-excel')}}">Xuất excel</a></li>
                                    <li><a class="dropdown-item" href="{{route('db.processing.export-pdf')}}">Xuất PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover dt-responsive nowrap w-100 fixed-header-datatable">
                            <thead>
                                <tr>
                                    <th>Tên cơ sở</th>
                                    <th>Người đại diện</th>
                                    <th>Số đăng ký</th>
                                    <th>Loại hình cơ sở</th>
                                    <th>Điện thoại</th>
                                    <th>Quận/Huyện</th>
                                    <th>Xã/Phường</th>
                                    <th>SL bán ra KD cây Lâm Nghiệp</th>
                                    <th>Nguồn cung</th>
                                    <th>Tổng số LD</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="body_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script>
        const loadData = async () => {
            const response = await getData('GET', '{{ route('db.breed-data') }}', {},
                @json(csrf_token()));
            return response;
        }
    </script>
    <script src="/pages/js/db-breed.js"></script>
@endsection
