
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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card application-detail">
                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}">Back</a>
                    <h1>Job Application Details</h1>
                </div>
                <ul>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>First Name</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->first_name }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Last Name</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->last_name }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Email</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->user->email }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Address1</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->address1 }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Address2</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->address2 }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>State</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->state }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>City</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->city }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Postcode</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->postcode }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Phone</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->phone }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Date Of Birth</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->dob }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Gender</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ ucfirst($profile->gender) }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Marital Status</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ ucfirst($profile->relation) }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Notice Period</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->notice_period }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Expected Salary</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->expected_ctc }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Current Salary</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ $profile->current_ctc }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-4">
                                <h4>Department</h4>
                            </div>
                            <div class="col-8">
                                <p>{{ config('constant.DEPARTMENTS')[$profile->department_id] }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#home">Education</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#menu1">Work Experience</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#menu2">Language & Technology</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#menu3">Reference</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#menu4">Preferred Locations</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="home" class="container tab-pane active"><br>
                            @php
                                $education = $profile->education;
                                $sscData = $education->where('type','ssc')->first(); 
                                $hscData = $education->where('type','hsc')->first(); 
                                $beData = $education->where('type','be')->first(); 
                                $meData = $education->where('type','me')->first();
                            @endphp     
                            <div class="details">
                                <h3>SSC</h3>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Name Of Board</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($sscData->nob) ? $sscData->nob : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Passing Year</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($sscData->year) ? $sscData->year : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Percentage</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($sscData->percentage) ? $sscData->percentage : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="details">
                                <h3>HSC</h3>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Name Of Board</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($hscData->nob) ? $hscData->nob : ''}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Passing Year</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($hscData->year) ? $hscData->year : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Percentage</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($hscData->percentage) ? $hscData->percentage : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="details">
                                <h3>Bachelor Degree</h3>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Course name</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($beData->course_name) ? $beData->course_name : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>University</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($beData->university) ? $beData->university : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Passing Year</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($beData->year) ? $beData->year : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Percentage</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($beData->percentage) ? $beData->percentage : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="details">
                                <h3>Master Degree</h3>
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Course name</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($meData->course_name) ? $meData->course_name : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>University</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($meData->university) ? $meData->university : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Passing Year</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($meData->year) ? $meData->year : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-4">
                                                <h4>Percentage</h4>
                                            </div>
                                            <div class="col-8">
                                                <p>{{ isset($meData->percentage) ? $meData->percentage : '' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>  
                        </div>
                        <div id="menu1" class="container tab-pane fade"><br>
                            <div class="details">
                                @php $WorkExperience = $profile->experience; @endphp
                                @foreach ($WorkExperience as $experience)    
                                    <ul>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Company Name</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($experience->company_name) ? $experience->company_name : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Designation</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($experience->designation) ? $experience->designation : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>From</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($experience->from) ? $experience->from : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>To</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($experience->to) ? $experience->to : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                        <div id="menu2" class="container tab-pane fade"><br>
                            <div class="details">
                                <div class="row">
                                    <div class="col-6">
                                        <h3>Language Known</h3>
                                        @php $languageknown = $profile->languageknown; @endphp
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
                                                        <input type="checkbox" class="form-check-input" id="{{ $key.$item }}" name="language[{{ $item }}]" value="1" {{ $is_edit && $language_id == $item ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $key.$item }}">{{ $key }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="checkbox" class="form-check-input" id="read{{ $item }}" name="read[{{ $item }}]" value="1" {{ $is_edit && $is_read ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="read{{ $item }}">Read</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="checkbox" class="form-check-input" id="write{{ $item }}" name="write[{{ $item }}]" value="2" {{ $is_edit && $is_write ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="write{{ $item }}">Write</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="checkbox" class="form-check-input" id="speak{{ $item }}" name="speak[{{ $item }}]" value="3" {{ $is_edit && $is_speak ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="speak{{ $item }}">Speak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <div class="col-6">
                                        <h3>Technologies you know</h3>
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
                                                        <input type="checkbox" class="form-check-input" id="{{ $key.$item }}" name="technology[{{ $item }}]" value="1" {{ $is_edit && $technology_id == $item ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $key.$item }}">{{ $key }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="radio" class="form-check-input" id="beginer{{ $item }}" name="technology{{ $item }}" value="1" {{ $is_edit && $technology_id == $item && $level ==1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="beginer{{ $item }}">Beginer</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="radio" class="form-check-input" id="mediator{{ $item }}" name="technology{{ $item }}" value="2" {{ $is_edit && $technology_id == $item && $level ==2 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mediator{{ $item }}">Mediator</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-wrap">
                                                        <input type="radio" class="form-check-input" id="expert{{ $item }}" name="technology{{ $item }}" value="3" {{ $is_edit && $technology_id == $item && $level ==3 ? 'checked' : '' }}>
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
                        <div id="menu3" class="container tab-pane fade"><br>
                            <div class="details">
                                @php $references = $profile->reference; @endphp
                                @foreach ($references as $reference)    
                                    <ul>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Name</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($reference->name) ? $reference->name : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Phone Number</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($reference->phone) ? $reference->phone : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Relation</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($reference->relation) ? $reference->relation : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                        <div id="menu4" class="container tab-pane fade"><br>
                            <div class="details">
                                @php $locations = $profile->location; @endphp
                                @foreach ($locations as $location)    
                                    <ul>
                                        <li>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Location</h4>
                                                </div>
                                                <div class="col-8">
                                                    <p>{{ isset($location->location_id) ? config('constant.LOCATIONS')[$location->location_id] : '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_script')
@endsection