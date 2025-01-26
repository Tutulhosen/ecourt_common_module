@extends('dashboard.inc.emc.layouts.app')

@section('content')

    <style>
        .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            @if (Request::is('appeal/trial_date_list'))
                @if (Auth::user()->role_id == 27 ||
                        Auth::user()->role_id == 6 ||
                        Auth::user()->role_id == 34 ||
                        Auth::user()->role_id == 25)
                    <div class="card-toolbar">
                        <a href="{{ route('appeal.hearingTimeUpdate') }}" class="btn btn-sm btn-primary font-weight-bolder">
                            <i class="la la-edit"></i>শুনানির সময় পরিবর্তন
                        </a>
                    </div>
                @endif
            @endif

            @if (Auth::user()->role_id == 5)
                <div class="card-toolbar">
                    <a href="{{ url('case/add') }}" class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-plus"></i>নতুন মামলা এন্ট্রি
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body overflow-auto">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            {{-- @include('appeal.search') --}}
            @php
                $today = date('Y-m-d', strtotime(now()));
                $today_time = date('H:i:s', strtotime(now()));
            @endphp
            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-customStyle2 font-size-h6">
                    <tr style="text-align: justify">
                        <th scope="col">ক্রমিক নং</th>
                        {{-- <th scope="col">ক্রমিক নং</th> --}}
                        <th scope="col" style="">সার্টিফিকেট অবস্থা</th>
                        <th scope="col">মামলা নম্বর</th>
                        @if (globalUserInfo()->role_id == 34)
                            <th scope="col">জেলা</th>
                            @elseif(globalUserInfo()->role_id == 6)
                                <th scope="col">উপজেলা</th>
                        @endif
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">জেনারেল সার্টিফিকেট আদালত</th>
                        <th scope="col">পরবর্তী তারিখ</th>
                        <th scope="col">পদক্ষেপ</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="{{route('gcc.appeal.edit')}}">সংশোধন ও প্রেরণsa</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="tg-bn">1</td>
                        <td> sdf</td> {{-- Helper Function for Bangla Status --}}
                        <td>3423</td>
                        <td>sdfsdf</td>
                      
                            
                      
                  
                            <td>
                                
                               fgd
                            </td>
                       
                        <td>ghjg</td>
                        <td>jghjhgj</td>

                        <td>
                            <div class="btn-group float-right">
                                <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">বিস্তারিত তথ্য</a>

                                    <a class="dropdown-item" href="">সংশোধন ও প্রেরণ</a>
                                      
                                           
                                       
                                </div>
                            </div>
                        </td>
                    </tr>

                        
                    
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{-- {!! $results->links() !!} --}}
            </div>
        </div>
        <!--end::Card-->

    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}
    @section('scripts')
        <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
               <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
             -->


        <!--end::Page Scripts-->
    @endsection
