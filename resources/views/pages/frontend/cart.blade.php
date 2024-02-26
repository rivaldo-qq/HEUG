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
                    <a href="#" aria-label="current-page">Shopping Cart</a>
                </li>
            </ul>
        </div>
    </section>
    <!-- END: BREADCRUMB -->

    <!-- START: COMPLETE YOUR ROOM -->
    <section class="md:py-16">
        <div class="container mx-auto px-4">
            <div class="flex -mx-4 flex-wrap">
                <div class="w-full px-4 mb-4 md:w-8/12 md:mb-0" id="shopping-cart">
                    <div class="flex flex-start mb-4 mt-8 pb-3 border-b border-gray-200 md:border-b-0">
                        <h3 class="text-2xl">Shopping Cart</h3>
                    </div>

                    <div class="border-b border-gray-200 mb-4 hidden md:block">
                        <div class="flex flex-start items-center pb-2 -mx-4">
                            <div class="px-4 flex-none">
                                <div class="" style="width: 90px">
                                    <h6>Photo</h6>
                                </div>
                            </div>
                            <div class="px-4 w-5/12">
                                <div class="">
                                    <h6>Product</h6>
                                </div>
                            </div>
                            <div class="px-4 w-5/12">
                                <div class="">
                                    <h6>Price</h6>
                                </div>
                            </div>
                            <div class="px-4 w-5/12">
                                <div class="">
                                    <h6>quantity</h6>
                                </div>
                            </div>
                            <div class="px-4 w-5/12">
                                <div class="">
                                    <h6>total</h6>
                                </div>
                            </div>
                            <div class="px-4 w-2/12">
                                <div class="text-center">
                                    <h6>Action</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- START: ROW 1 -->
                    @forelse ($carts as $item)
                        <div class="flex flex-start flex-wrap items-center mb-4 -mx-4" data-row="1">
                            <div class="px-4 flex-none">
                                <div class="" style="width: 90px; height: 90px">
                                    <img src="{{ $item->product->galleries()->exists() ? Storage::url($item->product->galleries->first()->url) : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88B8AAsUB4ZtvXtIAAAAASUVORK5CYII=' }}"
                                        alt="chair-1" class="object-cover rounded-xl w-full h-full" />
                                </div>
                            </div>
                            <div class="px-4 w-auto flex-1 md:w-5/12">
                                <div class="">
                                    <h6 class="font-semibold text-lg md:text-xl leading-8">
                                        {{ $item->product->name }}
                                    </h6>
                                    <span class="text-sm md:text-lg">{{ $item->product->category->name }}</span>
                                    <h6 class="font-semibold text-base md:text-lg block md:hidden">
                                        IDR {{ number_format($item->product->price) }}
                                    </h6>
                                    <h6 class="font-semibold text-base md:text-lg block md:hidden">
                                        {{ $item->quantity }}
                                    </h6>
                                    <h6 class="font-semibold text-base md:text-lg block md:hidden">
                                        {{ $item->total }}
                                    </h6>
                                </div>
                            </div>
                            <div class="px-4 w-auto flex-none md:flex-1 md:w-5/12 hidden md:block">
                                <div class="">
                                    <h6 class="font-semibold text-lg">IDR {{ number_format($item->product->price) }}</h6>
                                </div>
                            </div>
                            <div class="px-4 w-auto flex-none md:flex-1 md:w-5/12 hidden md:block">
                                <div class="">
                                    <h6 class="font-semibold text-lg">{{ $item->quantity }}</h6>
                                </div>
                            </div>
                            <div class="px-4 w-auto flex-none md:flex-1 md:w-5/12 hidden md:block">
                                <div class="">
                                    <h6 class="font-semibold text-lg">{{ $item->total }}</h6>
                                </div>
                            </div>
                            <div class="px-4 w-2/12">
                                <div class="text-center">
                                    <form action="{{ route('cart-delete', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 border-none focus:outline-none px-3 py-1">
                                            X
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p id="cart-empty" class="text-center py-8">
                            Ooops... Cart is empty
                            <a href="{{ route('index') }}" class="underline">Shop Now</a>
                        </p>
                    @endforelse

                    <!-- END: ROW 1 -->

                </div>
                <div class="w-full md:px-4 md:w-4/12" id="shipping-detail">
                    <div class="bg-gray-100 px-4 py-6 md:p-8 md:rounded-3xl">
                        <div class="text-center">
                            <a href="{{ route('bayaronline') }}" target="_blank"
                                class="bg-pink-400 text-black hover:bg-black hover:text-pink-400 rounded-full px-8 py-3 mt-4 inline-block flex-none transition duration-200">
                                Bayar online</a>
                        </div>
                    </div>
                    <div class="bg-gray-100 px-4 py-6 md:p-8 md:rounded-3xl">
                        <div class="text-center">
                            <a href="{{ route('bayarcash') }}" target="_blank"
                                class="bg-pink-400 text-black hover:bg-black hover:text-pink-400 rounded-full px-8 py-3 mt-4 inline-block flex-none transition duration-200">
                                Bayar Cash</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: COMPLETE YOUR ROOM -->
@endsection
