@extends('layouts.frontend')

@section('content')
    <!-- START: BREADCRUMB -->
    <section class="bg-gray-100 py-8 px-4">
        <div class="container mx-auto">
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('index') }}">Home</a>
                </li>
                <li>
                    <a href="#">{{ $table->name }}</a>
                </li>
                <li>
                    <a href="#" aria-label="current-page">Details</a>
                </li>
            </ul>
        </div>
    </section>
    <!-- END: BREADCRUMB -->

    <!-- START: DETAILS -->
    <section class="container mx-auto">
        <div class="flex flex-wrap my-4 md:my-12">
            <div class="w-full md:hidden px-4">
                <h2 class="text-5xl font-semibold">{{ $table->name }}</h2>
            </div>
            <div class="flex-1">
                <div class="slider">
                    <div class="thumbnail">
                        <div class="px-2">
                            @foreach ($table->galleries as $item)
                                <div class="item {{ $loop->first ? 'selected' : '' }}"
                                    data-img="{{ Storage::url($item->url) }}">
                                    <img src="{{ Storage::url($item->url) }}" alt="front"
                                        class="object-cover w-full h-full rounded-lg" />
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="preview">
                        <div class="item rounded-lg h-full overflow-hidden">
                            <img src="{{ $table->galleries()->exists() ? Storage::url($table->galleries->first()->url) : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88B8AAsUB4ZtvXtIAAAAASUVORK5CYII=' }}"
                                alt="front" class="object-cover w-full h-full rounded-lg" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 px-4 md:p-6">
                <h2 class="text-5xl font-semibold">{{ $table->name }}</h2>



                <hr class="my-8" />

                <h6 class="text-xl font-semibold mb-4">About the product</h6>
                <div class="text-xl leading-7 mb-6">
                    {!! $table->description !!}
                </div>
            </div>
        </div>
    </section>
    <!-- END: DETAILS -->

    <!-- START: COMPLETE YOUR ROOM -->

    <!-- END: COMPLETE YOUR ROOM -->
@endsection
