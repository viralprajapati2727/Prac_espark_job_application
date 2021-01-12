
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
            <div class="card">
                <h1>Job Application Details</h1>
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
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_script')
@endsection