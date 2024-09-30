@extends('layouts.main')
@section('content')

<!-- Content -->
<div class="page-content bg-white">

    <!-- contact area -->


 

             
                
                <div class="section-full content-inner-2 bg-white"
                style="background-image:url({{ asset('images/lines.png') }}); background-position:bottom; background-repeat:no-repeat; background-size: 100%;">
                <div class="container">
                    <div class="section-head text-black text-center">
                        <h2 class="m-b0">Jobseeker Membership Plans</h2>
                        <p>Registering on Angel-jobs.mt gives you access to a wide variety of job opportunities from different industries and companies.</p>
                    </div>
                    <!-- Pricing table-1 Columns 3 with gap -->
                    <div class="section-content box-sort-in button-example mt-md-5 mt-3">
                        <div class="pricingtable-row">
                            <div class="row max-w1000 m-auto">
                                <div class="col-sm-12 col-md-6 p-lr0">
                                    <div class="pricingtable-wrapper style2">
                                        <div class="pricingtable-inner">
                                            <div class="pricingtable-price">
                                                 @php
                                                     $plan = getData('jobseeker_plan',['id','plan_amount','plan_name','plan_duration','plan_offers'],['id'=>2,'is_deleted'=>'No']);
                                                     $plan_id = $plan[0]->id;
                                                     $amount = $plan[0]->plan_amount;
                                                     $plan_name = $plan[0]->plan_name;
                                                     $plan_offers = $plan[0]->plan_offers;
                                                     $plan_duration = ceil($plan[0]->plan_duration / 30);
                                                 @endphp
                                                <h4 class="font-weight-300 m-t10 m-b0">{{ $plan_name}}</h4>
                                                <div class="pricingtable-bx"> € <span>{{$amount}}</span> / {{$plan_duration}} Months </div>
                                            </div>
                                            {!! $plan_offers !!}<br>
                                            <div class="m-t20">
                                                @if (session()->has('js_username'))
                                                     <a class="site-button radius-xl" href="{{ route('js_buy_plan', ['plan_id' => $plan_id, 'amount' => $amount])}}"><span class="p-lr30">Buy Now</span></a>
                                                @else
                                                     <a class="site-button radius-xl" href="{{ route('js_login')}}"><span class="p-lr30">Buy Now</span></a>
                                                @endif
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 p-lr0">
                                    <div class="pricingtable-wrapper style2 text-white active">
                                        <div class="pricingtable-inner">
                                            <div class="pricingtable-price">
                                                   @php
                                                     $plan = getData('jobseeker_plan',['id','plan_amount','plan_name','plan_duration','plan_offers'],['id'=>3,'is_deleted'=>'No']);
                                                     $plan_id = $plan[0]->id;
                                                     $amount = $plan[0]->plan_amount;
                                                     $plan_name = $plan[0]->plan_name;
                                                     $plan_offers = $plan[0]->plan_offers;
                                                     $plan_duration = ceil($plan[0]->plan_duration / 30);
                                                 @endphp
                                                <h4 class="font-weight-300 m-t10 m-b0">{{ $plan_name}}</h4>
                                                <div class="pricingtable-bx"> € <span>{{$amount}}</span> / {{$plan_duration}} Months </div>
                                            </div>
                                           {!! $plan_offers !!}<br>
                                            <div class="m-t20">
                                                 @if (session()->has('js_username'))
                                                     <a class="site-button radius-xl" href="{{ route('js_buy_plan', ['plan_id' => $plan_id, 'amount' => $amount])}}" style="background: white;color: #3a9df1;"><span class="p-lr30">Buy Now</span></a>
                                                @else
                                                     <a class="site-button radius-xl" href="{{ route('js_login')}}" style="background: white;color: #3a9df1;"><span class="p-lr30">Buy Now</span></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>

 
            </div>
     
  
    <!-- contact area  END -->
</div>
<!-- Content END-->




<!-- Import footer  -->
@endsection()