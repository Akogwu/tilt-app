@extends('layouts.client')

@section('content')
    <section class="section-header bg-soft pb-0 mb-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center flex flex-col align-items-center">
                    <img src="/images/result-celebration.svg" class="w-1/2 h-1/2"  alt="">
                    <h1 class="display-1 font-bold text-primary">Congratulations</h1>
                    <p class="lead">You completed the test. Let’s see the result.</p>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </section>

    <section class="my-4">
        <div class="container">
            <div class="shadow bg-white w-full h-full rounded">
                <div class="flex flex-col align-items-center py-4 bg-gray-50 relative">
                    <img src="/images/tilt-logo.svg" class="h-20 w-20 absolute top-3 left-5" alt="">
                    <div class="block w-40 h-40 overflow-hidden rounded-full mb-3 ">
                        <img class="object-cover h-full w-full  " src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;s=aa3a807e1bbdfd4364d1f449eaa96d82" alt="" aria-hidden="true">
                    </div>
                    <div class="text-center">
                        <div class="text-gray-900 font-bold text-xl mb-1">{{ $user->name }}</div>
                        <div class="text-gray-600 font-semibold text-md mb-2">{{ $user->email }}</div>
                    </div>
                    <div class="p-2 border border-1 border-indigo-700 rounded-lg bg-white">
                        <span class="">Here is a summary of your result</span>
                    </div>
                </div>

                <div class="p-4 md:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-5">
                    @if($testResult)
                        @foreach($testResult as $result)
                            <!--Card 1-->
                                <div class=" w-full lg:max-w-full lg:flex">
                                    <div class="h-48 lg:h-auto flex lg:w-10 bg-{{$result['color']}} flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" title="{{$result['group_name']}}">
                                        <span class="text-white w-full  transform rotate-0 sm:rotate-0  md:-rotate-90 align-self-center ">{{ $result['group_name'] }}</span>
                                    </div>
                                    <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">

                                        <div class="mb-3 flex flex-col sm:flex-col md:flex-row items-center">
                                            <div class="icon w-8 h-8">
                                        <span>
                                            <i class="fa fa-{{$result['icon']}} fa-5x icon-{{ $result['color'] }} w-10 h-10"></i>
                                        </span>
                                            </div>
                                            <div class="description pl-3 border-b border-{{$result['color']}} border-opacity-50 mb-3">
                                                <p class="text-gray-700 text-base mb-0 p-2 border-success border-1">
                                                    {{$result['description']}}
                                                </p>
                                            </div>
                                        </div>

                                        @foreach($result['sections'] as $section)
                                            <div class="mb-2">
                                                <p class="text-gray-700 text-sm">{{$section['recommendation']}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                        @endforeach
                    @endif
                    </div>
                </div>
                </div>
            </div>

        <div class="container">
            <div class="flex flex-col align-items-center py-6">
                <a href="{{route('print-result')}}" type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fa fa-print pr-1"></i>
                    Print complete result.
                </a>
            </div>
        </div>

    </section>
@endsection
