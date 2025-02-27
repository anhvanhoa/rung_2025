<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Http\Requests\ProcessingAddRequest;
use App\Models\Breed;
use App\Models\Business;
use App\Models\BusinessBreed;
use App\Models\BusinessBusinessForm;
use App\Models\BusinessForm;
use App\Models\BusinessSource;
use App\Models\BusinessSupplier;
use App\Models\BusinessTechnology;
use App\Models\BusinessType;
use App\Models\Commune;
use App\Models\District;
use App\Models\Garden;
use App\Models\People;
use App\Models\Source;
use App\Models\Supplier;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class C_Database extends Controller
{
    public function processing()
    {
        return view("pages.db.processing");
    }

    public function processingData()
    {
        $data = Business::with("commune.district")
            ->with("businessType")
            ->with("businessForms")
            ->with("sources")
            ->with("owner")
            ->with("sources.source")
            ->where("type", Business::TYPE_PROCESSING)
            ->get();
        return $this->renderProcess($data);
    }

    private function renderProcess($data)
    {
        $html = "";
        foreach ($data as $i => $item) {
            $i += 1;
            $total = $item->workers_no_qual + $item->workers_deg;
            $sources = $item->sources->map(function ($source) {
                return $source->source->name;
            })->implode(", ");
            $html .= "<tr>";
            $html .= "<td>$i. $item->name</td>";
            $html .= '<td>' . $item->owner->name . '</td>';
            $html .= '<td>' . $item->business_registration . '</td>';
            $html .= '<td>' . $item->businessType->name . '</td>';
            $html .= '<td>' . $item->owner->phone . '</td>';
            $html .= '<td>' . $item->commune->district->name . '</td>';
            $html .= '<td>' . $item->commune->name . '</td>';
            $html .= '<td>' . $item->average_consumption . '</td>';
            $html .= '<td>' . $sources . '</td>';
            $html .= '<td>' . $total . '</td>';
            $html .= '<td> <div class="d-flex justify-content-center gap-1">';
            $html .= '<a href="' . route('db.processing.edit', $item->id) . '" data-toggle="tooltip" data-bs-custom-class="tooltip-info" data-bs-placement="bottom" data-bs-original-title="Chỉnh sửa" class="btn btn-icon btn-sm btn-info rounded-pill" aria-label="Chỉnh sửa">';
            $html .= '<i class="ri-quill-pen-ai-line"></i>';
            $html .= '</a>';
            $html .= '<a href="#" data-bs-href="' . route('db.processing.delete', $item->id) . '" data-toggle="tooltip" data-bs-custom-class="tooltip-danger" data-bs-placement="bottom" data-bs-original-title="Xóa" data-bs-toggle="modal" data-bs-target="#confirm_delete" class="btn btn-icon btn-sm btn-danger rounded-pill" aria-label="Xóa">';
            $html .= '<i class="ri-delete-bin-line"></i>';
            $html .= '</a>';
            $html .= '</div></td>';
            $html .= "</tr>";
        }
        return $html;
    }

    public function getProcessingAdd()
    {
        $businessTypes = BusinessType::all();
        $businessForms = BusinessForm::all();
        $districts = District::all();
        $communes = Commune::all();
        $sources = Source::all();
        $trees = Breed::where("type", Breed::TYPE_TREE)->get();
        return view("pages.db.processing-add", [
            "businessTypes" => $businessTypes,
            'businessForms' => $businessForms,
            'districts' => $districts,
            'communes' => $communes,
            'sources' => $sources,
            'trees' => $trees
        ]);
    }
    public function postProcessingAdd(ProcessingAddRequest $request)
    {
        try {
            $validated = $request->validated();
            DB::transaction(function () use ($validated) {
                $owner = People::create([
                    "name" => $validated['name'],
                    "phone" => $validated['phone'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $business = Business::create([
                    "name" => $validated['unit'],
                    "business_registration" => $validated['business_registration'],
                    "average_consumption" => $validated['average_consumption'],
                    "workers_no_qual" => $validated['workers_no_qual'],
                    "workers_deg" => $validated['workers_deg'],
                    "longitude" => $validated['longitude'],
                    "latitude" => $validated['latitude'],
                    "business_type_id" => $validated['business_type'],
                    "commune_code" => $validated['commune'],
                    "owner_id" => $owner->id,
                    "type" => Business::TYPE_PROCESSING,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $this->batchInsert(BusinessSource::class, 'source_id', $validated['source'], $business->id);
                $this->batchInsert(BusinessBreed::class, 'breed_id', $validated['primary'], $business->id);
                $this->batchInsert(BusinessBusinessForm::class, 'business_form_id', $validated['business_form'], $business->id);
            });

            return redirect()->route("db.processing")->with("success", "Thêm thành công");
        } catch (\Throwable $th) {
            return back()->with("err", $th->getMessage());
        }
    }

    /**
     * Hàm hỗ trợ chèn hàng loạt vào database.
     */
    private function batchInsert($model, $column, $values, $businessId)
    {
        $data = array_map(function ($value) use ($businessId, $column) {
            return [
                "business_id" => $businessId,
                $column => $value,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $values);

        $model::insert($data);
    }

    public function getProcessingDelete($id)
    {
        try {
            $business = Business::find($id);
            if (!$business) {
                return back()->with("err", "Không tìm thấy dữ liệu");
            }
            DB::transaction(function () use ($business) {
                BusinessSource::where("business_id", $business->id)->delete();
                BusinessBreed::where("business_id", $business->id)->delete();
                BusinessBusinessForm::where("business_id", $business->id)->delete();
                $business->delete();
                People::destroy($business->owner_id);
            });
            return redirect()->route("db.processing")->with("success", "Xóa thành công");
        } catch (\Throwable $th) {
            return back()->with("err", $th->getMessage());
        }
    }

    public function getProcessingEdit($id)
    {
        $business = Business::find($id);
        if (!$business) {
            return back()->with("err", "Không tìm thấy dữ liệu");
        }
        $businessTypes = BusinessType::all();
        $businessForms = BusinessForm::all();
        $districts = District::all();
        $communes = Commune::all();
        $sources = Source::all();
        $trees = Breed::where("type", Breed::TYPE_TREE)->get();
        return view("pages.db.processing-edit", [
            "businessTypes" => $businessTypes,
            'businessForms' => $businessForms,
            'districts' => $districts,
            'communes' => $communes,
            'sources' => $sources,
            'trees' => $trees,
            'business' => $business
        ]);
    }

    public function postProcessingEdit(ProcessingAddRequest $request)
    {
        $validated = $request->validated();
        $business = Business::find($request->id);
        if (!$business) {
            return back()->with("err", "Không tìm thấy dữ liệu");
        }

        try {
            DB::transaction(function () use ($validated, $business) {
                $owner = People::find($business->owner_id);
                $owner->update([
                    "name" => $validated['name'],
                    "phone" => $validated['phone'],
                    'updated_at' => now()
                ]);

                $business->update([
                    "name" => $validated['unit'],
                    "business_registration" => $validated['business_registration'],
                    "average_consumption" => $validated['average_consumption'],
                    "workers_no_qual" => $validated['workers_no_qual'],
                    "workers_deg" => $validated['workers_deg'],
                    "longitude" => $validated['longitude'],
                    "latitude" => $validated['latitude'],
                    "business_type_id" => $validated['business_type'],
                    "commune_code" => $validated['commune'],
                    'updated_at' => now()
                ]);

                BusinessSource::where("business_id", $business->id)->delete();
                BusinessBreed::where("business_id", $business->id)->delete();
                BusinessBusinessForm::where("business_id", $business->id)->delete();

                $this->batchInsert(BusinessSource::class, 'source_id', $validated['source'], $business->id);
                $this->batchInsert(BusinessBreed::class, 'breed_id', $validated['primary'], $business->id);
                $this->batchInsert(BusinessBusinessForm::class, 'business_form_id', $validated['business_form'], $business->id);
            });

            return redirect()->route("db.processing")->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            return back()->with("err", $th->getMessage());
        }
    }

    public function exportProcesExcel()
    {
        $header = [
            "STT",
            "X",
            "Y",
            "Tên doanh nghiệp, cá nhân, tổ chức khác",
            "Loại hình cơ sở",
            "Người đại diện",
            "Đăng ký KD",
            "Số điện thoại",
            "Mã Xã/Phường",
            "Xã/Phường",
            "Mã Quận/Huyện",
            "Quận/Huyện",
            "Loại hình kinh doanh",
            "Tổng khối lượng Gỗ sử dụng, tiêu thụ bình quân hằng năm đối với cở sở kinh doanh gỗ sản phẩm từ gỗ (m3)",
            "Nguồn gốc gỗ (nhập khẩu, khai thác từ RTN trong nước, rừng trồng…)",
            "Tổng số lao động",
            "Lao động có bằng cấp",
            "Lao động phổ thông",
            "Các loại gỗ sử dụng chính",
        ];

        $data = Business::with("commune.district")
            ->with("businessType")
            ->with("businessForms")
            ->with("sources")
            ->with("owner")
            ->with("sources.source")
            ->where("type", Business::TYPE_PROCESSING)
            ->get();

        $dataExcel = $data->map(function ($item, $i) {
            $i += 1;
            $total = $item->workers_no_qual + $item->workers_deg;
            $sources = $item->sources->map(function ($source) {
                return $source->source->name;
            })->implode(", ");
            return [
                $i,
                $item->longitude,
                $item->latitude,
                $item->name,
                $item->businessType->name,
                $item->owner->name,
                $item->business_registration,
                $item->owner->phone,
                $item->commune->code,
                $item->commune->name,
                $item->commune->district->code,
                $item->commune->district->name,
                $item->businessType->name,
                $item->average_consumption,
                $sources,
                $total,
                $item->workers_deg,
                $item->workers_no_qual,
                $item->sources->map(function ($source) {
                    return $source->source->name;
                })->implode(", ")
            ];
        });
        $alignment_width = [
            ['center', 8],   // STT
            ['center', 8],   // STT
            ['center', 8],   // STT
            ['left', 40],    // Tên doanh nghiệp, cá nhân, tổ chức khác
            ['left', 30],    // Loại hình cơ sở
            ['left', 32],    // Người đại diện
            ['left', 20],    // Đăng ký KD
            ['center', 16],  // Số điện thoại
            ['center', 12],  // Mã Xã/Phường
            ['left', 25],    // Xã/Phường
            ['center', 12],  // Mã Quận/Huyện
            ['left', 25],    // Quận/Huyện
            ['left', 30],    // Loại hình kinh doanh
            ['right', 40],   // Tổng khối lượng Gỗ sử dụng, tiêu thụ bình quân hàng năm
            ['left', 50],    // Nguồn gốc gỗ
            ['right', 18],   // Tổng số lao động
            ['right', 18],   // Lao động có bằng cấp
            ['right', 18],   // Lao động phổ thông
            ['left', 50],    // Các loại gỗ sử dụng chính
        ];

        $path = (new C_Excel)->export($header, $dataExcel, "processing", "processing", [1], [], [], $alignment_width);
        return redirect($path);
    }

    public function exportProcesPdf()
    {
        $header = [
            "STT",
            "X",
            "Y",
            "Tên doanh nghiệp, cá nhân, tổ chức khác",
            "Loại hình cơ sở",
            "Người đại diện",
            "Đăng ký KD",
            "Số điện thoại",
            "Mã Xã/Phường",
            "Xã/Phường",
            "Mã Quận/Huyện",
            "Quận/Huyện",
            "Loại hình kinh doanh",
            "Tổng khối lượng Gỗ sử dụng, tiêu thụ bình quân hằng năm đối với cở sở kinh doanh gỗ sản phẩm từ gỗ (m3)",
            "Nguồn gốc gỗ (nhập khẩu, khai thác từ RTN trong nước, rừng trồng…)",
            "Tổng số lao động",
            "Lao động có bằng cấp",
            "Lao động phổ thông",
            "Các loại gỗ sử dụng chính",
        ];

        $data = Business::with("commune.district")
            ->with("businessType")
            ->with("businessForms")
            ->with("sources")
            ->with("owner")
            ->with("sources.source")
            ->where("type", Business::TYPE_PROCESSING)
            ->get();

        $dataPdf = $data->map(function ($item, $i) {
            $i += 1;
            $total = $item->workers_no_qual + $item->workers_deg;
            $sources = $item->sources->map(function ($source) {
                return $source->source->name;
            })->implode(", ");
            return [
                $i,
                $item->longitude,
                $item->latitude,
                $item->name,
                $item->businessType->name,
                $item->owner->name,
                $item->business_registration,
                $item->owner->phone,
                $item->commune->code,
                $item->commune->name,
                $item->commune->district->code,
                $item->commune->district->name,
                $item->businessType->name,
                $item->average_consumption,
                $sources,
                $total,
                $item->workers_deg,
                $item->workers_no_qual,
                $item->sources->map(function ($source) {
                    return $source->source->name;
                })->implode(", ")
            ];
        })->toArray();
        $alignment_width = [
            ['center', 8],   // STT
            ['center', 8],   // STT
            ['center', 8],   // STT
            ['left', 40],    // Tên doanh nghiệp, cá nhân, tổ chức khác
            ['left', 30],    // Loại hình cơ sở
            ['left', 32],    // Người đại diện
            ['left', 20],    // Đăng ký KD
            ['center', 16],  // Số điện thoại
            ['center', 12],  // Mã Xã/Phường
            ['left', 25],    // Xã/Phường
            ['center', 12],  // Mã Quận/Huyện
            ['left', 25],    // Quận/Huyện
            ['left', 30],    // Loại hình kinh doanh
            ['right', 40],   // Tổng khối lượng Gỗ sử dụng, tiêu thụ bình quân hàng năm
            ['left', 50],    // Nguồn gốc gỗ
            ['right', 18],   // Tổng số lao động
            ['right', 18],   // Lao động có bằng cấp
            ['right', 18],   // Lao động phổ thông
            ['left', 50],    // Các loại gỗ sử dụng chính
        ];
        $folder = "processing";
        $fileName = "processing.pdf";

        $controller = new C_PDF();
        $controller->exportPdf($header, $dataPdf, "Cơ sở chế biến gỗ", $folder, $fileName, $alignment_width);
        return response()->download("$folder/$fileName");
    }

    public function breed()
    {
        return view("pages.db.breed");
    }
    public function getBreedAdd()
    {
        $businessTypes = BusinessType::all();
        $businessForms = BusinessForm::all();
        $districts = District::all();
        $communes = Commune::all();
        $suppliers = Supplier::all();
        $breeds = Breed::get();
        $irrigations = Technology::where("type", Technology::TYPE_IRRIGATION)->get();
        $nurseries = Technology::where("type", Technology::TYPE_NURSERY)->get();
        return view("pages.db.breed-add", [
            "businessTypes" => $businessTypes,
            'businessForms' => $businessForms,
            'districts' => $districts,
            'communes' => $communes,
            'suppliers' => $suppliers,
            'trees' => $breeds,
            'irrigations' => $irrigations,
            'nurseries' => $nurseries
        ]);
    }

    public function postBreedAdd(BusinessRequest $req)
    {
        try {
            $validated = $req->validated();
            DB::transaction(function () use ($validated) {
                $owner = People::create([
                    "name" => $validated['name'],
                    "phone" => $validated['phone'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $business = Business::create([
                    "name" => $validated['unit'],
                    "business_registration" => $validated['business_registration'],
                    "annual_revenue" => $validated['annual_revenue'],
                    "female_workers" => $validated['female_workers'],
                    "male_workers" => $validated['male_workers'],
                    "sell_trees_qty" => $validated['sell_trees_qty'],
                    "longitude" => $validated['longitude'],
                    "latitude" => $validated['latitude'],
                    "business_type_id" => $validated['business_type'],
                    "commune_code" => $validated['commune'],
                    "owner_id" => $owner->id,
                    "type" => Business::TYPE_MANUFACTRUE,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $technologies = array_merge([$validated['irrigation']], $validated['nursery']);
                $this->batchInsert(BusinessSupplier::class, 'supplier_id', $validated['supplier'], $business->id);
                $this->batchInsert(BusinessTechnology::class, 'technology_id', $technologies, $business->id);
                $this->batchInsert(BusinessBreed::class, 'breed_id', $validated['primary'], $business->id);
                $this->batchInsert(BusinessBusinessForm::class, 'business_form_id', $validated['business_form'], $business->id);
                Garden::create([
                    "business_id" => $business->id,
                    "acreage" => $validated['acreage'],
                    "type" => $validated['irrigation_type'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            });

            return redirect()->route("db.breed")->with("success", "Thêm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("err", $th->getMessage())->withInput();
        }
    }

    public function breedData()
    {
        $data = Business::with("commune.district")
            ->with("businessType")
            ->with("businessForms")
            ->with("suppliers")
            ->with("owner")
            ->with("primaryTrees")
            ->with("nurseries")
            ->with("garden")
            ->with("irrigation")
            ->where("type", Business::TYPE_MANUFACTRUE)
            ->get();
        return $this->renderBreed($data);
    }

    private function renderBreed($data)
    {
        $html = "";
        foreach ($data as $i => $item) {
            $i += 1;
            $total = $item->female_workers + $item->male_workers;
            $suppliers = $item->suppliers->map(function ($s) {
                return $s->name;
            })->implode(", ");
            $html .= "<tr>";
            $html .= "<td>$i. $item->name</td>";
            $html .= '<td>' . $item->owner->name . '</td>';
            $html .= '<td>' . $item->business_registration . '</td>';
            $html .= '<td>' . $item->businessType->name . '</td>';
            $html .= '<td>' . $item->owner->phone . '</td>';
            $html .= '<td>' . $item->commune->district->name . '</td>';
            $html .= '<td>' . $item->commune->name . '</td>';
            $html .= '<td>' . $item->sell_trees_qty . '</td>';
            $html .= '<td>' . $suppliers . '</td>';
            $html .= '<td>' . $total . '</td>';
            $html .= '<td> <div class="d-flex justify-content-center gap-1">';
            $html .= '<a href="' . route('db.breed.edit', $item->id) . '" data-toggle="tooltip" data-bs-custom-class="tooltip-info" data-bs-placement="bottom" data-bs-original-title="Chỉnh sửa" class="btn btn-icon btn-sm btn-info rounded-pill" aria-label="Chỉnh sửa">';
            $html .= '<i class="ri-quill-pen-ai-line"></i>';
            $html .= '</a>';
            $html .= '<a href="#" data-bs-href="' . route('db.breed.delete', $item->id) . '" data-toggle="tooltip" data-bs-custom-class="tooltip-danger" data-bs-placement="bottom" data-bs-original-title="Xóa" data-bs-toggle="modal" data-bs-target="#confirm_delete" class="btn btn-icon btn-sm btn-danger rounded-pill" aria-label="Xóa">';
            $html .= '<i class="ri-delete-bin-line"></i>';
            $html .= '</a>';
            $html .= '</div></td>';
            $html .= "</tr>";
        }
        return $html;
    }

    public function getBreedDelete($id)
    {
        try {
            $business = Business::find($id);
            if (!$business) {
                return back()->with("err", "Không tìm thấy dữ liệu");
            }
            DB::transaction(function () use ($business) {
                BusinessSupplier::where("business_id", $business->id)->delete();
                BusinessTechnology::where("business_id", $business->id)->delete();
                BusinessBreed::where("business_id", $business->id)->delete();
                BusinessBusinessForm::where("business_id", $business->id)->delete();
                Garden::where("business_id", $business->id)->delete();
                $business->delete();
                People::destroy($business->owner_id);
            });
            return redirect()->route("db.breed")->with("success", "Xóa thành công");
        } catch (\Throwable $th) {
            return back()->with("err", $th->getMessage());
        }
    }

    public function getBreedEdit($id)
    {
        $business = Business::find($id);
        if (!$business) {
            return back()->with("err", "Không tìm thấy dữ liệu");
        }
        $businessTypes = BusinessType::all();
        $businessForms = BusinessForm::all();
        $districts = District::all();
        $communes = Commune::all();
        $suppliers = Supplier::all();
        $breeds = Breed::get();
        $irrigations = Technology::where("type", Technology::TYPE_IRRIGATION)->get();
        $nurseries = Technology::where("type", Technology::TYPE_NURSERY)->get();
        return view("pages.db.breed-edit", [
            "businessTypes" => $businessTypes,
            'businessForms' => $businessForms,
            'districts' => $districts,
            'communes' => $communes,
            'suppliers' => $suppliers,
            'trees' => $breeds,
            'irrigations' => $irrigations,
            'nurseries' => $nurseries,
            'business' => $business
        ]);
    }

    public function postBreedEdit(BusinessRequest $req)
    {
        try {
            $validated = $req->validated();
            $business = Business::find($req->id);
            if (!$business) {
                return back()->with("err", "Không tìm thấy dữ liệu");
            }
            DB::transaction(function () use ($validated, $business) {
                $owner = People::find($business->owner_id);
                $owner->update([
                    "name" => $validated['name'],
                    "phone" => $validated['phone'],
                    'updated_at' => now()
                ]);
                $business->update([
                    "name" => $validated['unit'],
                    "business_registration" => $validated['business_registration'],
                    "annual_revenue" => $validated['annual_revenue'],
                    "female_workers" => $validated['female_workers'],
                    "male_workers" => $validated['male_workers'],
                    "sell_trees_qty" => $validated['sell_trees_qty'],
                    "longitude" => $validated['longitude'],
                    "latitude" => $validated['latitude'],
                    "business_type_id" => $validated['business_type'],
                    "commune_code" => $validated['commune'],
                    'updated_at' => now()
                ]);

                BusinessSupplier::where("business_id", $business->id)->delete();
                BusinessTechnology::where("business_id", $business->id)->delete();
                BusinessBreed::where("business_id", $business->id)->delete();
                BusinessBusinessForm::where("business_id", $business->id)->delete();
                Garden::where("business_id", $business->id)->delete();

                $technologies = array_merge([$validated['irrigation']], $validated['nursery']);
                $this->batchInsert(BusinessSupplier::class, 'supplier_id', $validated['supplier'], $business->id);
                $this->batchInsert(BusinessTechnology::class, 'technology_id', $technologies, $business->id);
                $this->batchInsert(BusinessBreed::class, 'breed_id', $validated['primary'], $business->id);
                $this->batchInsert(BusinessBusinessForm::class, 'business_form_id', $validated['business_form'], $business->id);
                Garden::create([
                    "business_id" => $business->id,
                    "acreage" => $validated['acreage'],
                    "type" => $validated['irrigation_type'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            });

            return redirect()->route("db.breed")->with("success", "Cập nhật thành công");
        } catch (\Throwable $th) {
            return back()->with("err", $th->getMessage());
        }
    }

    public function exportBreedExcel()
    {
        $header = [
            "STT",
            "X",
            "Y",
            "Tên doanh nghiệp, cá nhân, tổ chức khác",
            "Loại hình cơ sở",
            "Người đại diện",
            "Đăng ký KD",
            "Số điện thoại",
            "Mã Xã/Phường",
            "Xã/Phường",
            "Mã Quận/Huyện",
            "Quận/Huyện",
            "Loại hình kinh doanh",
            "Số lượng cây giống bán ra đối với cở sở kinh doanh giống cây Lâm Nghiệp (Vạn cây)",
            "Nguồn cung cấp hạt giống, cây giống",
            "Tổng số lao động",
            "Lao động nữ",
            "Lao động nam",
            "Các loại gỗ sử dụng chính",
        ];

        $data = Business::with("commune.district")
            ->with("businessType")
            ->with("businessForms")
            ->with("suppliers")
            ->with("owner")
            ->with("primaryTrees")
            ->with("nurseries")
            ->with("garden")
            ->with("irrigation")
            ->where("type", Business::TYPE_MANUFACTRUE)
            ->get();

        $dataExcel = $data->map(function ($item, $i) {
            $i += 1;
            $total = $item->female_workers + $item->male_workers;
            $suppliers = $item->suppliers->map(function ($s) {
                return $s->name;
            })->implode(", ");
            return [
                $i,
                $item->longitude,
                $item->latitude,
                $item->name,
                $item->businessType->name,
                $item->owner->name,
                $item->business_registration,
                $item->owner->phone,
                $item->commune->code,
                $item->commune->name,
                $item->commune->district->code,
                $item->commune->district->name,
                $item->businessType->name,
                $item->annual_revenue,
                $suppliers,
                $total,
                $item->female_workers,
                $item->male_workers,
                $item->sources->map(function ($source) {
                    return $source->source->name;
                })->implode(", ")
            ];
        });
        $alignment_width = [
            ['center', 8],   // STT
            ['center', 8],   // STT
            ['center', 8],   // STT
            ['left', 40],    // Tên doanh nghiệp, cá nhân, tổ chức khác
            ['left', 30],    // Loại hình cơ sở
            ['left', 32],    // Người đại diện
            ['left', 20],    // Đăng ký KD
            ['center', 16],  // Số điện thoại
            ['center', 12],  // Mã Xã/Phường
            ['left', 25],    // Xã/Phường
            ['center', 12],  // Mã Quận/Huyện
            ['left', 25],    // Quận/Huyện
            ['left', 30],    // Loại hình kinh doanh
            ['right', 40],   // Tổng khối lượng Gỗ sử dụng, tiêu thụ bình quân hàng năm
            ['left', 50],    // Nguồn gốc gỗ
            ['right', 18],   // Tổng số lao động
            ['right', 18],   // Lao động có bằng cấp
            ['right', 18],   // Lao động phổ thông
            ['left', 50],    // Các loại gỗ sử dụng chính
        ];

        $path = (new C_Excel)->export($header, $dataExcel, "processing", "processing", [1], [], [], $alignment_width);
        return redirect($path);
    }
}
