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
                            <h4 class="header-title">Cơ sở chế biến gỗ</h4>
                        </div>

                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{route('db.processing.add')}}" class="btn btn-sm btn-primary">
                                <i class="ri-add-line me-1"></i>
                                Thêm mới
                            </a>
                            <div class="col-auto dropstart">
                                <a style="padding: 8px;" class="btn btn-secondary btn-sm" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i data-lucide="ellipsis-vertical"></i>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{route('db.processing.export-excel')}}">Xuất
                                            excel</a></li>
                                    <li><a class="dropdown-item" href="{{route('db.processing.export-pdf')}}">Xuất PDF</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-header border-bottom border-dashed">
                        <div class="row gy-2 gx-1 align-items-center">
                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <label class="form-label">Loại hình cơ sở</label>
                                <div class="SumoSelect">
                                    <select class="form-control form-control-sm sumoSelect" multiple="" id="business_type"
                                        name="business_type[]">
                                        @foreach($businessTypes as $b)
                                            <option value="{{$b->id}}" selected>{{$b->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <label class="form-label">Quận/Huyện</label>
                                <div class="SumoSelect">
                                    <select class="form-control form-control-sm sumoSelect" id="district" name="district">
                                        <option value="" hidden style="pointer-events: none;">
                                            -- Chọn quận/huyện --
                                        </option>
                                        @foreach($districts as $d)
                                            <option value="{{$d->code}}">{{$d->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <label class="form-label">Xã/Phường</label>
                                <div class="SumoSelect">
                                    <select class="form-control form-control-sm sumoSelect" id="commune" name="commune">
                                        @foreach($communes as $c)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto" style="align-self: end;">
                                <button type="button" id="filter" class="btn btn-sm btn-info">
                                    <i class="ri-filter-line me-2"></i>
                                    Lọc dữ liệu
                                </button>
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
        const loadData = async (param = {}) => {
            const response = await getData('GET', '{{ route('db.processing-data') }}', param,
                @json(csrf_token()));
            return response;
        }
        const renderSelect = (el, data, district) => {
            destroySumoSelect(el)
            const res = data.filter(i => i.district_code == district)
            el.html("")
            el.append(`<option value="" hidden> -- Chọn xã/phường --</option>`)
            res.forEach(i => el.append(`<option value="${i.code}">${i.name}</option>`))
            initSumoSelect(el, 'Vui lòng chọn')
        }

        $(document).ready(function () {
            {
                const val = $("#district").val();
                renderSelect($("#commune"), @json($communes), val)
            }
        });

        $("#district").on("change", function () {
            renderSelect($("#commune"), @json($communes), $(this).val())
        })
    </script>
    <script src="/pages/js/db-processing.js"></script>
@endsection
