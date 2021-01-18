
@extends('layouts.app')

@section('content')
@php
    $WorkExperience = $referenceContact = $locations = null;
    $is_edit = $exp_count = $reference_count = 0;

    if(!empty($profile)){
        $is_edit = 1;
        $education = $profile->education;
        $sscData = $education->where('type','ssc')->first(); 
        $hscData = $education->where('type','hsc')->first(); 
        $beData = $education->where('type','be')->first(); 
        $meData = $education->where('type','me')->first();

        $WorkExperience = $profile->experience;
        $referenceContact = $profile->reference;
        $locations = $profile->location->pluck('location_id')->toArray();
        $technologyknown = $profile->technologyknown;
        $languageknown = $profile->languageknown;
    }


@endphp
<div class="container">
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
          @endif
        @endforeach
        {{-- @dump($errors)  --}}
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3>Job Application </h3>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-3"> {{ __('Logout') }}</a>
                    <a href="{{ route('view-detail') }}" class="px-3"> {{ __('View Details') }}</a>
                    <a href="{{ route('destroy') }}" class="px-3"> {{ __('Delete') }}</a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>
                </div>
                <div class="card-body">
                    <form id="postJobForm" action="{{ route('job.store') }}" method="POST">
                        @csrf
                        <h1>Job Application Form</h1>
                        <div class="tab">
                            <div class="row">
                                <div class="col-4">
                                    <p><input type="text" placeholder="First name..." class="@error('fname') is-invalid @enderror" name="fname" value="{{ $is_edit ? $profile->first_name : old('fname') }}">
                                    @error('fname') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                <p><input type="text" placeholder="Last name..." class="@error('lname') is-invalid @enderror" name="lname" value="{{ $is_edit ? $profile->last_name : old('lname') }}">
                                    @error('lname') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </p>
                                </div>                                
                                <div class="col-4">
                                    <p><input type="text" placeholder="Email..." name="email" class="@error('email') is-invalid @enderror" value="{{ Auth::user()->email }}" readonly>
                                    @error('email') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p><input type="text" placeholder="Address 1..." class="@error('address1') is-invalid @enderror" name="address1" value="{{ $is_edit ? $profile->address1 : old('address1') }}">
                                    @error('address1') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror   
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p><input type="text" placeholder="Address 2..." name="address2" value="{{ $is_edit ? $profile->address2 : old('address2') }}"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p><input type="text" placeholder="State..." name="state" class="@error('state') is-invalid @enderror" value="{{ $is_edit ? $profile->state : old('state') }}">
                                    @error('state') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p><input type="text" placeholder="City..." name="city" class="@error('city') is-invalid @enderror" value="{{ $is_edit ? $profile->city : old('city') }}">
                                    @error('city') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p><input type="text" placeholder="Zip Code..." name="postcode" class="@error('postcode') is-invalid @enderror" value="{{ $is_edit ? $profile->postcode : old('postcode') }}">
                                    @error('postcode') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p><input type="text" placeholder="Phone Number..." name="phone_number" class="@error('phone_number') is-invalid @enderror" value="{{ $is_edit ? $profile->phone_number : old('phone_number') }}">
                                    @error('phone_number') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p>
                                        <input type="text" placeholder="Date Of Birth..." name="dob" class="birthdate" value="{{ old('dob', isset($profile->dob)? (\Carbon\Carbon::createFromFormat('Y-m-d',$profile->dob)->format('d/m/Y')):'' ) }}">
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p>
                                        <label>Gender: </label>
                                        <input type="radio" value="male" name="gender" class="radio"  {{ ($is_edit ? ($profile->gender == 'male' ? 'checked' : '') : 'checked' ) }}> Male
                                        <input type="radio" value="female" name="gender" class="radio" {{ ($is_edit ? ($profile->gender == 'female' ? 'checked' : '') : '' ) }}> Female
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p>
                                        <label>RelationShip Status : </label>
                                        <select class="" name="relation">
                                            <option value="single" {{ ($is_edit ? ($profile->relation == 'single' ? 'selected' : '') : '' ) }}>Single</option>
                                            <option value="married" {{ ($is_edit ? ($profile->relation == 'married' ? 'selected' : '') : '' ) }}>Married</option>
                                        </select>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h3>Education Details:</h3>
                            <div class="row">
                                <div class="col-12">
                                    <h5>SSC Result:</h5>
                                </div>
                                <div class="col-4">
                                    <p>
                                        <input type="text" placeholder="Name Of Board..." name="ssc[nob]" class="@error('ssc.nob') is-invalid @enderror" value="{{ $is_edit && isset($sscData->nob) ? $sscData->nob : old('ssc[nob]') }}">
                                        @error('ssc.nob') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p>
                                        <input type="text" placeholder="Passing Year..." name="ssc[year]" class="@error('ssc.year') is-invalid @enderror" value="{{ $is_edit && isset($sscData->year) ? $sscData->year : old('ssc[year]') }}">
                                        @error('ssc.year') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p>
                                        <input type="text" class="@error('ssc.percentage') is-invalid @enderror" placeholder="Percentage..." name="ssc[percentage]" value="{{ $is_edit && isset($sscData->percentage) ? $sscData->percentage : old('ssc[percentage]') }}">
                                        @error('ssc.percentage') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5>HSC / Diploma Result:</h5>
                                </div>
                                <div class="col-4">
                                    <p>
                                        <input type="text" class="@error('hsc.nob') is-invalid @enderror" placeholder="Name Of Board..." name="hsc[nob]" value="{{ $is_edit && isset($hscData->nob) ? $hscData->nob : old('hsc[nob]') }}">
                                        @error('hsc.nob') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p>
                                        <input type="text" class="@error('hsc.year') is-invalid @enderror" placeholder="Passing Year..." name="hsc[year]" value="{{ $is_edit && isset($hscData->year) ? $hscData->year : old('hsc[year]') }}">
                                        @error('hsc.year') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p>
                                        <input type="text" class="@error('hsc.percentage') is-invalid @enderror" placeholder="Percentage..." name="hsc[percentage]" value="{{ $is_edit && isset($hscData->percentage) ? $hscData->percentage : old('hsc[percentage]') }}">
                                        @error('hsc.percentage') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5>Bachelor Degree:</h5>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('be.course') is-invalid @enderror" placeholder="Course Name..." name="be[course]" value="{{ $is_edit && isset($beData->course_name) ? $beData->course_name : old('be[course]') }}">
                                        @error('be.course') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('be.university') is-invalid @enderror" placeholder="University..." name="be[university]" value="{{ $is_edit && isset($beData->university) ? $beData->university : old('be[university]') }}">
                                        @error('be.university') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('be.year') is-invalid @enderror" placeholder="Passing Year..." name="be[year]" value="{{ $is_edit && isset($beData->year) ? $beData->year : old('be[year]') }}">
                                        @error('be.year') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('be.percentage') is-invalid @enderror" placeholder="Percentage..." name="be[percentage]" value="{{ $is_edit && isset($beData->percentage) ? $beData->percentage : old('be[percentage]') }}">
                                        @error('be.percentage') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5>Master Degree:</h5>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('me.course') is-invalid @enderror" placeholder="Course Name..." name="me[course]" value="{{ $is_edit && isset($meData->course_name) ? $meData->course_name : old('me[course]') }}">
                                        @error('me.course') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('me.university') is-invalid @enderror" placeholder="University..." name="me[university]" value="{{ $is_edit && isset($meData->university) ? $meData->university : old('me[university]') }}">
                                        @error('me.university') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('me.year') is-invalid @enderror" placeholder="Passing Year..." name="me[year]" value="{{ $is_edit && isset($meData->year) ? $meData->year : old('me[year]') }}">
                                        @error('me.year') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p>
                                        <input type="text" class="@error('me.percentage') is-invalid @enderror" placeholder="Percentage..." name="me[percentage]" value="{{ $is_edit && isset($meData->percentage) ? $meData->percentage : old('me[percentage]') }}">
                                        @error('me.percentage') 
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h3>Work Experience:</h3>
                            <div class="row">
                                <div class="col-12" id="work-eperieance">
                                    @php $exp_count = 0; @endphp
                                    <div class="work-exp-details">
                                        @if(isset($WorkExperience) && !empty($WorkExperience) && $WorkExperience->count())
                                            @php $exp_total = count($WorkExperience) - 1; @endphp
                                            @foreach($WorkExperience as $work)
                                                <div class="work-exp-item">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:;" class="ml-auto delete-work-exp">X</a>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <input type="text" name="exp[{{ $exp_count }}][company_name]" placeholder="Company Name" class="form-control company_name @error('exp.'.$exp_count.'.company_name') is-invalid @enderror" value="{{ ($is_edit) ? $work->company_name : old('exp.'.$exp_count.'.company_name') }}">
                                                            @error('exp.'.$exp_count.'.company_name') 
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text" name="exp[{{ $exp_count }}][designation]" placeholder="Designation" class="form-control designation @error('exp.'.$exp_count.'.designation') is-invalid @enderror" value="{{ ($is_edit) ? $work->designation : old('exp.'.$exp_count.'.designation') }}">
                                                            @error('exp.'.$exp_count.'.designation') 
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text" name="exp[{{ $exp_count }}][from]" placeholder="From" class="form-control birthdate from @error('exp.'.$exp_count.'.from') is-invalid @enderror" value="{{ old('exp.'.$exp_count.'.from', isset($work->from)? (\Carbon\Carbon::createFromFormat('Y-m-d',$work->from)->format('d/m/Y')):'' ) }}">
                                                            @error('exp.'.$exp_count.'.from') 
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror                                                        
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text" name="exp[{{ $exp_count }}][to]" placeholder="To" class="form-control birthdate to @error('exp.'.$exp_count.'.to') is-invalid @enderror" value="{{ old('exp.'.$exp_count.'.to', isset($work->to)? (\Carbon\Carbon::createFromFormat('Y-m-d',$work->to)->format('d/m/Y')):'' ) }}">
                                                            @error('exp.'.$exp_count.'.to') 
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="exp[{{ $exp_count }}][work_id]" class="id" value="{{ $work->id }}">
                                                </div>
                                                @php $exp_count++; @endphp
                                            @endforeach
                                        @else
                                            <div class="work-exp-item">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:;" class="ml-auto delete-work-exp">X</a>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                    <input type="text" name="exp[{{ $exp_count }}][company_name]" placeholder="Company Name" class="form-control company_name @if(Arr::has($errors->get('exp.*'), 'exp.'.$exp_count.'.company_name')) is-invalid @endif" value="{{ ($is_edit) ? $work->company_name : old('exp.'.$exp_count.'.company_name') }}">
                                                    @error('exp.'.$exp_count.'.company_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                    <div class="col-3">
                                                    <input type="text" name="exp[{{ $exp_count }}][designation]" placeholder="Designation" class="form-control designation @if(Arr::has($errors->get('exp.*'), 'exp.'.$exp_count.'.designation')) is-invalid @endif" value="{{ ($is_edit) ? $work->designation : old('exp.'.$exp_count.'.designation') }}">
                                                    @error('exp.'.$exp_count.'.designation')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                    <div class="col-3">
                                                    <input type="text" name="exp[{{ $exp_count }}][from]" placeholder="From" class="form-control birthdate from @if(Arr::has($errors->get('exp.*'), 'exp.'.$exp_count.'.from')) is-invalid @endif" value="{{ old('exp.'.$exp_count.'.from', isset($work->from)? (\Carbon\Carbon::createFromFormat('Y-m-d',$work->from)->format('d/m/Y')):'' ) }}">
                                                    @error('exp.'.$exp_count.'.from')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                    <div class="col-3">
                                                    <input type="text" name="exp[{{ $exp_count }}][to]" placeholder="To" class="form-control birthdate to @if(Arr::has($errors->get('exp.*'), 'exp.'.$exp_count.'.to')) is-invalid @endif" value="{{ old('exp.'.$exp_count.'.to', isset($work->to)? (\Carbon\Carbon::createFromFormat('Y-m-d',$work->to)->format('d/m/Y')):'' ) }}">
                                                    @error('exp.'.$exp_count.'.to')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                            <button type="button" class="btn btn-primary btn-sm btn-add-more-exp"><i class="icon-plus2"></i> Add More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Language Known</h3>
                                    <div class="languges-option">
                                        @forelse (config('constant.LANGUAGE') as $key => $item)
                                            @php
                                                $language_id = $is_read = $is_write = $is_speak = 0;
                                                if($is_edit){
                                                    $languageData = $languageknown->where('language_id', $item)->first();
                                                    if(!empty($languageData)){
                                                        $language_id = $languageData->language_id;
                                                        $is_read = $languageData->is_read;
                                                        $is_write = $languageData->is_write;
                                                        $is_speak = $languageData->is_speak;
                                                    }
                                                }
                                            @endphp
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="checkbox" class="form-check-input lang-name @error('language') is-invalid @enderror" data-key={{ $key }} data-id={{ $item }} id="{{ $key.$item }}" name="language[{{ $item }}]" value="1" {{ $is_edit && $language_id == $item ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $key.$item }}">{{ $key }}</label>
                                                    </div>
                                                    @error('language') 
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap parent-checkbox">
                                                        <input type="checkbox" class="sub-checkbox form-check-input lang-option{{ $item }}" id="read{{ $item }}" name="read[{{ $item }}]" value="1" {{ $is_edit && $is_read ? 'checked' : '' }} {{ $is_edit && $language_id == $item ? '' : 'disabled' }}>
                                                        <label class="form-check-label" for="read{{ $item }}">Read</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap parent-checkbox">
                                                        <input type="checkbox" class="sub-checkbox form-check-input lang-option{{ $item }}" id="write{{ $item }}" name="write[{{ $item }}]" value="2" {{ $is_edit && $is_write ? 'checked' : '' }} {{ $is_edit && $language_id == $item ? '' : 'disabled' }}>
                                                        <label class="form-check-label" for="write{{ $item }}">Write</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap parent-checkbox">
                                                        <input type="checkbox" class="sub-checkbox form-check-input lang-option{{ $item }}" id="speak{{ $item }}" name="speak[{{ $item }}]" value="3" {{ $is_edit && $is_speak ? 'checked' : '' }} {{ $is_edit && $language_id == $item ? '' : 'disabled' }}>
                                                        <label class="form-check-label" for="speak{{ $item }}">Speak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3>Technologies you know</h3>
                                    <div class="technology-option">
                                        @forelse (config('constant.TECHNOLOGIES') as $key => $item)
                                            @php
                                                $technology_id = $tech_value = 0;
                                                if($is_edit){
                                                    $technologyData = $technologyknown->where('technology_id', $item)->first();
                                                    if(!empty($technologyData)){
                                                        $technology_id = $technologyData->technology_id;
                                                        $level = $technologyData->level;
                                                    }
                                                }
                                            @endphp
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="checkbox" class="form-check-input prog-lang-name" data-key={{ $key }} data-id={{ $item }} id="{{ $key.$item }}" name="technology[{{ $item }}]" value="1" {{ $is_edit && $technology_id == $item ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $key.$item }}">{{ $key }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap parent-radio">
                                                        <input type="radio" class="sub-radio form-check-input prog-lang-option{{ $item }}" id="beginer{{ $item }}" name="technology{{ $item }}" value="1" {{ $is_edit && $technology_id == $item && $level ==1 ? 'checked' : '' }}  {{ $is_edit && $technology_id == $item ? '' : 'disabled' }}>
                                                        <label class="form-check-label" for="beginer{{ $item }}">Beginer</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap parent-radio">
                                                        <input type="radio" class="sub-radio form-check-input prog-lang-option{{ $item }}" id="mediator{{ $item }}" name="technology{{ $item }}" value="2" {{ $is_edit && $technology_id == $item && $level ==2 ? 'checked' : '' }}  {{ $is_edit && $technology_id == $item ? '' : 'disabled' }}>
                                                        <label class="form-check-label" for="mediator{{ $item }}">Mediator</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap parent-radio">
                                                        <input type="radio" class="sub-radio form-check-input prog-lang-option{{ $item }}" id="expert{{ $item }}" name="technology{{ $item }}" value="3" {{ $is_edit && $technology_id == $item && $level ==3 ? 'checked' : '' }}  {{ $is_edit && $technology_id == $item ? '' : 'disabled' }}>
                                                        <label class="form-check-label" for="expert{{ $item }}">Expert</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h3>Reference Contact:</h3>
                            <div class="row">
                                <div class="col-12" id="reference-contact">
                                    @php $exp_count = 0; @endphp
                                    <div class="reference-contact-details">
                                        @if(isset($referenceContact) && !empty($referenceContact) && $referenceContact->count())
                                            @php $reference_total = count($referenceContact) - 1; @endphp
                                            @foreach($referenceContact as $reference)
                                                <div class="reference-item">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:;" class="ml-auto delete-reference-contact">X</a>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <input type="text" name="reference[{{ $reference_count }}][name]" placeholder="Name" class="form-control name @error('reference.'.$reference_count.'.name') is-invalid @enderror" value="{{ ($is_edit) ? $reference->name : old('reference.'.$reference_count.'.name') }}">
                                                            @error('reference.'.$reference_count.'.name') 
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" name="reference[{{ $reference_count }}][phone]" placeholder="Contact Number" class="form-control phone @error('reference.'.$reference_count.'.phone') is-invalid @enderror" value="{{ ($is_edit) ? $reference->phone : old('reference.'.$reference_count.'.phone') }}">
                                                            @error('reference.'.$reference_count.'.phone') 
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" name="reference[{{ $reference_count }}][relation]" placeholder="Relation" class="form-control relation" value="{{ ($is_edit) ? $reference->relation : old('reference.'.$reference_count.'.relation') }}">
                                                            @error('reference.'.$reference_count.'.relation') 
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="reference[{{ $reference_count }}][reference_contact_id]" class="id" value="{{ $reference->id }}">
                                                </div>
                                                @php $reference_count++; @endphp
                                            @endforeach
                                        @else
                                            <div class="reference-item">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:;" class="ml-auto delete-reference-contact">X</a>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="text" name="reference[{{ $reference_count }}][name]" placeholder="Name" class="form-control name @error('reference.'.$reference_count.'.name') is-invalid @enderror" value="{{ old('reference.'.$reference_count.'.name') }}">
                                                        @error('reference.'.$reference_count.'.name') 
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" name="reference[{{ $reference_count }}][phone]" placeholder="Contact Number" class="form-control phone @error('reference.'.$reference_count.'.phone') is-invalid @enderror" value="{{ old('reference.'.$reference_count.'.phone') }}">
                                                        @error('reference.'.$reference_count.'.phone') 
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" name="reference[{{ $reference_count }}][relation]" placeholder="Relation" class="form-control relation @error('reference.'.$reference_count.'.relation') is-invalid @enderror" value="{{ old('reference.'.$reference_count.'.relation') }}">
                                                        @error('reference.'.$reference_count.'.relation') 
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                            <button type="button" class="btn btn-primary btn-sm btn-add-more-reference"><i class="icon-plus2"></i> Add More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h3>Preferances:</h3>
                            <div class="row">
                                <div class="col-4">
                                    <select class="" multiple="multiple" name="locations[]">
                                        @forelse (config('constant.LOCATIONS') as $key => $item)
                                            <option value="{{ $key }}" {{ $is_edit && in_array($key, $locations) ? 'selected' : '' }}>{{ $item }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-4">
                                    <p><input type="text" name="notice_period" class="@error('notice_period') is-invalid @enderror" placeholder="Notice period" class="form-control" value="{{ $is_edit ? $profile->notice_period : old('notice_period') }}">
                                    @error('notice_period') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                    <p><input type="text" name="expected_ctc" class="@error('expected_ctc') is-invalid @enderror" placeholder="Expacted CTC" class="form-control" value="{{ $is_edit ? $profile->expected_ctc : old('expected_ctc') }}">
                                    @error('expected_ctc') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                    <p><input type="text" name="current_ctc" class="@error('current_ctc') is-invalid @enderror" placeholder="Current CTC" class="form-control" value="{{ $is_edit ? $profile->current_ctc : old('current_ctc') }}">
                                    @error('current_ctc') 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p>
                                        <label>Department : </label>
                                        <select class="" name="department_id">
                                            @forelse (config('constant.DEPARTMENTS') as $key => $item)
                                                <option value="{{ $key }}" {{ $is_edit && $profile->department_id == $key ? 'selected' : '' }}>{{ $item }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div style="overflow:auto;">
                            <div style="float:right; margin-top: 5px;">
                                <button type="button" class="previous">Previous</button>
                                <button type="button" class="next">Next</button>
                                <button type="button" class="submit">Submit</button>
                            </div>
                        </div>
                        <!-- Circles which indicates the steps of the form: -->
                        {{-- <div style="text-align:center;margin-top:40px;">
                            <span class="step">1</span>
                            <span class="step">2</span>
                            <span class="step">3</span>
                            <span class="step">4</span>
                            <span class="step">5</span>
                            <span class="step">6</span>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_script')
<script>
    var is_form_edit = false;
    var ex_count = parseInt("{{ $exp_count }}");
    var reference_count = parseInt("{{ $reference_count }}");
</script>
<script src="{{ asset('js/moment.min.js') }}" defer></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" defer></script>
<script src="{{ asset('js/validate.min.js') }}" defer></script>
<script src="{{ asset('js/custom.js') }}" defer></script>
@endsection