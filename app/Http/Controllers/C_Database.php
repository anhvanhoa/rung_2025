<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessingAddRequest;
use App\Models\Breed;
use App\Models\Business;
use App\Models\BusinessBreed;
use App\Models\BusinessBusinessForm;
use App\Models\BusinessForm;
use App\Models\BusinessSource;
use App\Models\BusinessType;
use App\Models\Commune;
use App\Models\District;
use App\Models\People;
use App\Models\Source;
use Illuminate\Http\Request;
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
        return $data;
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

            $owner = People::create([
                "name" => $validated['name'],
                "phone" => $validated['phone']
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
                "type" => Business::TYPE_PROCESSING
            ]);

            $dataSource = array_map(function($i) use($business): array {
                return [
                    "business_id" => $business->id,
                    "source_id" => $i
                ];
            }, $validated['source']);

            $dataPrimary = array_map(function($i) use($business): array {
                return [
                    "business_id" => $business->id,
                    "breed_id" => $i
                ];
            }, $validated['primary']);

            $dataForms = array_map(function($i) use($business): array {
                return [
                    "business_id" => $business->id,
                    "business_form_id" => $i
                ];
            }, $validated['business_form']);

            BusinessSource::create($dataSource);
            BusinessBreed::create($dataPrimary);
            BusinessBusinessForm::create($dataForms);

            return redirect()->route("db.processing")->with("success", "Thêm thành công");
        } catch (\Throwable $th) {
            return back()->with("err", $th->getMessage());
        }
    }
}
