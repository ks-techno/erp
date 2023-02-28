<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Validator;
use Illuminate\Validation\Rule;

class CityController extends Controller
{

    private static function Constants()
    {
        $name = 'city';

        return [
            'title' => 'City',
            'list_url' => route('setting.city.index'),
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
            'view' => "$name-view",
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
        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];
        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = City::with('country','region')->where('id','<>',0)->orderByName();

            $allData = $dataSql->get();

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);
            $delete_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['delete'])){
                $delete_per = true;
            }
            $edit_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['edit'])){
                $edit_per = true;
            }
            $entries = [];
            foreach ($allData as $row) {
                $urlEdit = route('setting.city.edit',$row->uuid);
                $urlDel = route('setting.city.destroy',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->country->name,
                    $row->region->name,
                    $row->name,
                    $actions,
                ];
            }
            $result = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $entries,
            ];
            return response()->json($result);
        }

        return view('setting.city.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $data['countries'] = Country::with('regions')->OrderByName()->get();
       // dd($data['countries']->toArray());
        return view('setting.city.create', compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cities',
            'region_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'region_id.required' => 'Region is required',
            'region_id.not_in' => 'Region is required',
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

            $region = Region::where('id',$request->region_id)->first();

            City::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'country_id' => $region->country_id,
                'region_id' => $request->region_id,
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('setting.city.index');
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
    public function edit(Request $request,$id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];
        $data['countries'] = Country::with('regions')->OrderByName()->get();
        if(City::where('uuid',$id)->exists()){

            $data['current'] = City::where('uuid',$id)->first();

        }else{
            abort('404');
        }

        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }
        return view('setting.city.edit', compact('data'));
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
        $ignoreId = City::where('uuid',$id)->first();
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => ["required",Rule::unique('cities')->ignore($ignoreId->id)],
            'region_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'region_id.required' => 'Region is required',
            'region_id.not_in' => 'Region is required',
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
            $region = Region::where('id',$request->region_id)->first();

            City::where('uuid',$id)
                ->update([
                'name' => self::strUCWord($request->name),
                'country_id' => $region->country_id,
                'region_id' => $request->region_id,
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
        return $this->redirect()->route('setting.city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = [];
        DB::beginTransaction();
    
        try {
            $city = City::where('uuid', $id)->firstOrFail();
    
            // Check if any related instances exist
            if ($city->customers()->exists() || $city->dealers()->exists() || $city->staff()->exists()) {
                throw new \Exception('Cannot delete city that is related to a customer, dealer, or staff.');
            }
    
            // No related instances found, proceed with deletion
            $city->delete();
            
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
    
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }
    

    public function getCityByRegion(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        try{

            $data['cities'] = City::where(['region_id'=>$request->region_id,'country_id'=>$request->country_id])->get();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, '', 200);
    }
}
