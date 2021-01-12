<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use Session;
use Carbon\Carbon;
use stdClass;
use App\User;


class JobController extends Controller
{
    public function index(){
        return view('welcome');
    }
    public function fillForm(){
        $profile = Auth::user()->profile;
        return view('home',compact('profile'));
    }
    public function update(Request $request){

        DB::beginTransaction();
        try{
            $user = Auth::user();
            $dob = Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');

            $created_at = $updated_at = date('Y-m-d H:i:s');
            if($request->has('profile_id')){
                $created_at = null;
            } else {
                $updated_at = null;
            }

            $profile = $user->profile()->updateOrCreate(
                ['user_id' => $user->id],[
                "dob" => $dob,
                "first_name" => $request->fname,
                "last_name" => $request->lname,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'state' => $request->state,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'phone' => $request->phone,                    
                'gender' => $request->gender,                    
                'relation' => $request->relation,                    
                'notice_period' => $request->notice_period,                    
                'expected_ctc' => $request->expected_ctc,                    
                'current_ctc' => $request->current_ctc,                    
                'department_id' => $request->department_id,                            
                'created_at' => $created_at,                            
                'updated_at' => $updated_at,                            
            ]);

            /*
            * save user education data
            */
            // $profile->education()->delete();
            if(!empty($request->ssc['nob'])){
                $profile->education()->updateOrCreate(
                    ['profile_id' => $profile->id, 'type' => 'ssc'],
                    ['nob' => $request['ssc']['nob'], 'year' => $request['ssc']['year'], 'percentage' => $request['ssc']['percentage']]);
            }
            if(!empty($request->hsc['nob'])){
                $profile->education()->updateOrCreate(
                    ['profile_id' => $profile->id, 'type' => 'hsc'],
                    ['nob' => $request['hsc']['nob'], 'year' => $request['hsc']['year'], 'percentage' => $request['hsc']['percentage']]);
            }
            if(!empty($request->be['course'])){
                $profile->education()->updateOrCreate(
                    ['profile_id' => $profile->id, 'type' => 'be'],
                    ['course_name' => $request['be']['course'], 'university' => $request['be']['university'], 'year' => $request['be']['year'], 'percentage' => $request['be']['percentage']]);
            }
            if(!empty($request->me['course'])){
                $profile->education()->updateOrCreate(
                    ['profile_id' => $profile->id, 'type' => 'me'],
                    ['course_name' => $request['me']['course'], 'university' => $request['me']['university'], 'year' => $request['me']['year'], 'percentage' => $request['me']['percentage']]);
            }

            /*
            * save user work experience data
            */
            if(!empty($request->exp) && !empty($request->exp[0]['company_name'])){
                $profile->experience()->delete();
                foreach ($request->exp as $key => $experience) {
                    $userExperiences[] = ['profile_id' => $profile->id, 'company_name' => $experience['company_name'], 'designation' => $experience['designation'], 'from' => Carbon::createFromFormat('d/m/Y', $experience['from'])->format('Y-m-d'), 'to' => Carbon::createFromFormat('d/m/Y', $experience['to'])->format('Y-m-d')];
                }

                $profile->experience()->insert($userExperiences);
            }

            /*
            * save language known data
            */
            if(!empty($request->language)){
                foreach ($request->language as $key => $language) {
                    $is_read = $is_write = $is_speak = 0;
                    if(!empty($request->read)){
                        $read_keys = array_keys($request->read);
                        if(in_array($key, $read_keys)){
                            $is_read = 1;
                        }
                    }
                    if(!empty($request->write)){
                        $write_keys = array_keys($request->write);
                        if(in_array($key, $write_keys)){
                            $is_write = 1;
                        }
                    }
                    if(!empty($request->speak)){
                        $speak_keys = array_keys($request->speak);
                        if(in_array($key, $speak_keys)){
                            $is_speak = 1;
                        }
                    }

                    $languageknown[] = ['profile_id' => $profile->id, 'language_id' => $key, 'is_read' => $is_read, 'is_write' => $is_write, 'is_speak' => $is_speak];
                }
                $profile->languageknown()->insert($languageknown);
            }
            
            /*
            * save technologyknown data
            */
            if(!empty($request->technology)){
                $profile->technologyknown()->delete();
                foreach ($request->technology as $key => $technology) {
                    $level = 'technology'.$key;
                    $technologyknown[] = ['profile_id' => $profile->id, 'technology_id' => $key, 'level' => $request->$level];
                }
                $profile->technologyknown()->insert($technologyknown);
            }

            /*
            * save reference data
            */
            if(!empty($request->reference)){
                $profile->reference()->delete();
                foreach ($request->reference as $key => $reference) {
                    $references[] = ['profile_id' => $profile->id, 'name' => $reference['name'], 'phone' => $reference['phone'], 'relation' => $reference['relation']];
                }
                $profile->reference()->insert($references);
            }

            /*
            * save location data
            */
            if(!empty($request->locations)){
                $profile->location()->delete();
                foreach ($request->locations as $key => $location) {
                    $locations[] = ['profile_id' => $profile->id, 'location_id' => $location];
                }
                $profile->location()->insert($locations);
            }

            DB::commit();

            Session::flash('alert-success', 'Your job application has been saved successfully');
            return redirect()->route('home');
        } catch(Exception $e){
            Log::emergency('job application save Exception:: Message:: '.$e->getMessage().' line:: '.$e->getLine().' Code:: '.$e->getCode().' file:: '.$e->getFile());
            DB::rollback();
            Session::flash('alert-danger', 'Something went wrong, Please try again!!');
            return redirect()->route('home');
        }
    }
    public function detail(){
        try{
            $profile = Auth::user()->profile;
            if(empty($profile)){
                Session::flash('alert-danger', 'Data Not Found!!');
                return redirect()->route('home');    
            }
            return view('detail',compact('profile'));

        } catch(Exception $e){
            Log::emergency('job application detail Exception:: Message:: '.$e->getMessage().' line:: '.$e->getLine().' Code:: '.$e->getCode().' file:: '.$e->getFile());
            DB::rollback();
            Session::flash('alert-danger', 'Something went wrong, Please try again!!');
            return redirect()->route('home');
        }
    }
}
