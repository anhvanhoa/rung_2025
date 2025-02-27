@extends('layouts.main')
@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">
                                Chỉnh sửa cơ sở sản xuất giống
                            </h4>
                        </div>

                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('db.breed') }}" class="btn btn-sm btn-primary"><i
                                    class="ri-list-view me-1"></i>Danh sách</a>
                        </div>
                    </div>

                    <div class="card-body pb-0">
                        <form action="{{ route('db.breed.post-edit', $business->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tên doanh nghiệp, cá nhân, tổ chức khác</label>
                                        <input required class="form-control" type="text" name="unit" autocomplete="off"
                                            placeholder="Nhập tên doanh nghiệp, cá nhân, tổ chức khác"
                                            value="{{ $business->name }}">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Người đại diện</label>
                                        <input required class="form-control" type="text" name="name" autocomplete="off"
                                            placeholder="Tên người đại diện" value="{{ $business->owner->name }}">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Loại hình cơ sở</label>
                                        <select required class="form-control sumoSelect" id="business_type"
                                            name="business_type">
                                            @foreach ($businessTypes as $bt)
                                                <option value="{{ $bt->id }}" @if ($bt->id == $business->business_type_id)
                                                selected @endif>
                                                    {{ $bt->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Hình thức kinh doanh</label>
                                        @php
                                            $businessFormIds = $business->businessForms->pluck('id')->toArray();
                                        @endphp
                                        <select style="height: 40px;" required class="form-control sumoSelect"
                                            id="business_form" multiple name="business_form[]">
                                            @foreach ($businessForms as $bf)
                                                <option value="{{ $bf->id }}" @if (in_array($bf->id, $businessFormIds)) selected
                                                @endif>
                                                    {{ $bf->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Đăng ký kinh doanh</label>
                                        <input class="form-control" type="text" name="business_registration"
                                            autocomplete="off" placeholder="Nhập số đăng ký"
                                            value="{{ $business->business_registration }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input class="form-control" type="text" name="phone" autocomplete="off"
                                            placeholder="Nhập số điện thoại" value="{{ $business->owner->phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Quận/Huyện</label>
                                        <select required class="form-control sumoSelect" id="district" name="district">
                                            @foreach ($districts as $d)
                                                <option value="{{ $d->code }}" @if ($d->code == $business->commune->district->code) selected @endif>
                                                    {{ $d->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Xã/Phường/Thị Trấn</label>
                                        <select required class="form-control sumoSelect" id="commune" name="commune">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nguồn cung</label>
                                        @php
                                            $supplierIds = $business->suppliers->pluck('id')->toArray();
                                        @endphp
                                        <select required style="height: 40px;" class="form-control sumoSelect" id="supplier"
                                            name="supplier[]" multiple>
                                            @foreach ($suppliers as $s)
                                                <option value="{{ $s->id }}" @if (in_array($s->id, $supplierIds)) selected
                                                @endif>
                                                    {{ $s->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nhân công nữ</label>
                                        <input class="form-control" type="number" name="female_workers" autocomplete="off"
                                            placeholder="Nhập số nhân công" value="{{ $business->female_workers }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nhân công nam</label>
                                        <input class="form-control" type="number" name="male_workers" autocomplete="off"
                                            placeholder="Nhập số nhân công" value="{{ $business->male_workers }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">SL cây giống bán ra đối với CSKD giống cây Lâm Nghiệp (Vạn
                                            cây)</label>
                                        <input required class="form-control" type="number" name="sell_trees_qty"
                                            autocomplete="off" placeholder="Nhập SL cây giống bán ra"
                                            value="{{ $business->sell_trees_qty }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Các loại giống chính</label>
                                        @php
                                            $treeIds = $business->primaryTrees->pluck('breed_id')->toArray();
                                        @endphp
                                        <select required style="height: 40px;" class="form-control sumoSelect" id="primary"
                                            name="primary[]" multiple>
                                            @foreach ($trees as $t)
                                                <option value="{{ $t->id }}" @if (in_array($t->id, $treeIds)) selected @endif>
                                                    {{ $t->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Hệ thống tưới</label>
                                        <select required style="height: 40px;" class="form-control sumoSelect"
                                            id="irrigation" name="irrigation">
                                            @foreach ($irrigations as $i)
                                                <option value="{{ $i->id }}" @if ($i->id == $business->irrigation->first()->id)
                                                selected @endif>
                                                    {{ $i->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Công nghệ vườn ươm</label>
                                        @php
                                            $nurseryIds = $business->nurseries->pluck('id')->toArray();
                                        @endphp
                                        <select required style="height: 40px;" class="form-control sumoSelect" id="nursery"
                                            name="nursery[]" multiple>
                                            @foreach ($nurseries as $n)
                                                <option value="{{ $n->id }}" @if (in_array($n->id, $nurseryIds)) selected
                                                @endif>
                                                    {{ $n->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Doanh Thu hàng năm</label>
                                        <input required class="form-control" type="number" name="annual_revenue"
                                            autocomplete="off" placeholder="Nhập doanh thu"
                                            value="{{ $business->annual_revenue }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="mb-3 col">
                                            <label class="form-label">Diện tích</label>
                                            <input required class="form-control" type="number" name="acreage"
                                                autocomplete="off" placeholder="Nhập diện tích"
                                                value="{{ $business->garden->acreage }}">
                                        </div>
                                        <div class="mb-3 col">
                                            <label class="form-label">Loại hình vườn ươm</label>
                                            <select required style="height: 40px;" class="form-control sumoSelect"
                                                id="irrigation_type" name="irrigation_type">
                                                <option value="fixed" @if ($business->garden->type == 'fixed') selected @endif>
                                                    Cố định
                                                </option>
                                                <option value="dynamic" @if ($business->garden->type == 'dynamic') selected
                                                @endif>
                                                    Linh động
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="mb-3 col">
                                            <label class="form-label">Tọa độ X</label>
                                            <input class="form-control" type="number" name="longitude" autocomplete="off"
                                                placeholder="Nhập tọa độ X" value="{{ $business->longitude }}">
                                        </div>
                                        <div class="mb-3 col">
                                            <label class="form-label">Tọa độ Y</label>
                                            <input class="form-control" type="number" name="latitude" autocomplete="off"
                                                placeholder="Nhập tọa độ Y" value="{{ $business->latitude }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sticky-bottom d-flex align-items-center justify-content-end border-top border-dashed"
                                style="background-color: var(--abstack-card-bg)">
                                <div class="d-flex align-items-center" style="padding-top: 1.5rem; margin-bottom: 1.5rem">
                                    <button class="btn btn-success" type="submit"><i class="ri-save-line me-1"></i>Thực
                                        hiện</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const renderSelect = (el, data, district, select) => {
            destroySumoSelect(el)
            const res = data.filter(i => i.district_code == district)
            el.html("")
            res.forEach(i => {
                let selected = '';
                if (select == i.code) {
                    selected = 'selected'
                }
                el.append(`<option ${selected} value="${i.code}">${i.name}</option>`)
            })
            initSumoSelect(el, 'Vui lòng chọn')
        }

        $(document).ready(function () {
            initSumoSelect($('#business_type, #business_form, #district, #commune, #supplier, #irrigation, #nursery, #primary'), 'Vui lòng chọn')
            {
                const val = $("#district").val();
                const select = @json($business->commune->code);
                renderSelect($("#commune"), @json($communes), val, select)
            }
        });

        $("#district").on("change", function () {
            renderSelect($("#commune"), @json($communes), $(this).val())
        })

    </script>
@endsection
