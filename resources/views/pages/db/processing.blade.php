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
                            <h4 class="header-title">Danh sách nhân sự</h4>
                        </div>

                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">

                            <a href="{{route('db.processing.add')}}" class="btn btn-sm btn-primary"><i
                                    class="ri-add-line me-1"></i>Thêm
                                mới</a>
                        </div>
                    </div>

                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <div class="row gy-2 gx-1 align-items-center">
                                <div class="col-auto" style="align-self: end;">
                                    <button type="button" id="filter" class="btn btn-sm btn-info">
                                        <i class="ri-filter-line me-2"></i>
                                        Lọc dữ liệu
                                    </button>
                                </div>

                                <div class="col-auto" style="align-self: end;">
                                    <button type="button" id="export" class="btn btn-sm btn-success">
                                        <i class="ri-download-line me-2"></i>
                                        Export
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover dt-responsive nowrap w-100 fixed-header-datatable">
                            <thead>
                                <tr>
                                    <th>Tên cơ sở chế biến</th>
                                    <th>Người đại diện</th>
                                    <th>Số đăng ký</th>
                                    <th>Loại hình cơ sở</th>
                                    <th>Điện thoại</th>
                                    <th>Quận/Huyện</th>
                                    <th>Xã/Phường</th>
                                    <th>Tổng KL tiêu thụ (m<sup>3</sup>)</th>
                                    <th>Nguồn gốc</th>
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
        var a = $('.fixed-header-datatable');
        const loadData = async () => {
            const response = await getData('GET', '{{ route('db.processing-data') }}', {},
                @json(csrf_token()));
            return response;
        }

        const renderTable = (data) => {
            data.map((item,i) => {
                const sources = item.sources.map((source) => source.source.name).join(', ');
                $('#body_data').append(`
                        <tr>
                            <td>${i+1}. ${item.name}</td>
                            <td>${item.owner.name}</td>
                            <td>${item.business_registration}</td>
                            <td>${item.business_type.name}</td>
                            <td>${item.owner.phone}</td>
                            <td>${item.commune.district.name}</td>
                            <td>${item.commune.name}</td>
                            <td>${item.average_consumption}</td>
                            <td>${sources}</td>
                            <td>${item.workers_no_qual + item.workers_deg}</td>
                            <td>
                                ACTION
                            </td>
                        </tr>
                    `);
            })
            createDataTable(a);
        }

        $(document).ready(async function () {
            renderTable(await loadData());
        });
    </script>
@endsection
