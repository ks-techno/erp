<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Defi\TblDefiCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Validator;
use Webpatser\Uuid\Uuid;

class CountryController extends Controller
{

    private static function Constants()
    {
        return [
            'title' => 'Country',
            'list_url' => '/setting/country/list',
            'form_url' => '/setting/country/form'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['form_url'] = self::Constants()['form_url'];
        if ($request->ajax()) {
            $draw = 'all';
            $columns = " uuid,name,country_status ";
            $orderBy1  = " name asc ";
            $orderBy2  = "";
            /* Start Query */
            $dataSql = "select $columns from tbl_defi_country ";
            $dataSql .= "order by $orderBy1 $orderBy2";
            $allData = DB::select($dataSql);
            /* End Query */

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);

            $entries = [];
            foreach ($allData as $row) {
                $entry_status = $this->getStatusTitle()[$row->country_status];
                $urlEdit = $data['form_url'] . '/' . $row->uuid;
                $urlDel = 'javascript:;';

                $actions = '<div class="text-end">';
                $actions .= '<div class="d-inline-flex">';
                $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                $actions .= '<a href="'.$urlDel.'" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                $actions .= '</div>'; // end dropdown-menu
                $actions .= '</div>'; // end d-inline-flex
                $actions .= '<a href="'.$urlEdit.'" class="item-edit"><i data-feather="edit"></i></a>';
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->name,
                    '<div class="text-center"><span class="badge rounded-pill ' . $entry_status['class'] . '">' . $entry_status['title'] . '</span></div>',
                    $actions,
                ];
            }
            $result = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $entries,
                'form_url' => $data['form_url'],
            ];
            return response()->json($result);
        }

        return view('setting.country.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$uuid = null)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];

        if (isset($uuid)) {
            if (TblDefiCountry::where('uuid', $uuid)->exists()) {

                $data['form_type'] = 'edit';
                $data['action'] = 'Update';
                $data['uuid'] = $uuid;
                $data['current'] = TblDefiCountry::where('uuid', $uuid)->first();

            } else {
                abort('404');
            }
        } else {
            $data['form_type'] = 'new';
            $data['action'] = 'Save';
        }

       return view('setting.country.form', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $uuid = null)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
        }

        DB::beginTransaction();
        try {

            if (isset($uuid)) {
                $country = TblDefiCountry::where('uuid', $uuid)->first();
            } else {
                $country = new TblDefiCountry();
                $country->uuid = self::uuid();
            }
            $country->name = self::strUCWord($request->name);
            $country->country_status = isset($request->country_status) ? "1" : "0";
            $country->save();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        if (isset($uuid)) {
            $data['redirect'] = self::Constants()['list_url'];
            return $this->jsonSuccessResponse($data, 'Successfully updated');
        } else {
            $data['redirect'] = self::Constants()['form_url'];
            return $this->jsonSuccessResponse($data, 'Successfully created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }
}
