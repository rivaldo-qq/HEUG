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
                    <a href="#" aria-label="current-page">Form Pembayaran cash</a>
                </li>
            </ul>
        </div>
    </section>
    <!-- END: BREADCRUMB -->

    <!-- START: COMPLETE YOUR ROOM -->
    <section class="md:py-16">
        <div class="container mx-auto px-4">
            <div class="flex -mx-4 flex-wrap">
                <div class="w-full md:px-4 md:w-4/12" id="shipping-detail">
                    <div class="bg-gray-100 px-4 py-6 md:p-8 md:rounded-3xl">
                        <form id = "co-form" action="{{ route('bayarkasir') }}" method="POST">
                            @csrf
                            <div class="flex flex-start mb-6">
                                <h3 class="text-2xl">Harap isi data dengan benar</h3>
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="complete-name" class="text-sm mb-2">Complete Name</label>
                                <input data-input name="name" type="text" id="complete-name"
                                    class="border-gray-200 border rounded-lg px-4 py-2 bg-white text-sm focus:border-blue-200 focus:outline-none"
                                    placeholder="Input your name" />
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="email" class="text-sm mb-2">Email Address</label>
                                <input data-input name="email" type="email" id="email"
                                    class="border-gray-200 border rounded-lg px-4 py-2 bg-white text-sm focus:border-blue-200 focus:outline-none"
                                    placeholder="Input your email address" />
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="address" class="text-sm mb-2">Address</label>
                                <input data-input type="text" name="address" id="address"
                                    class="border-gray-200 border rounded-lg px-4 py-2 bg-white text-sm focus:border-blue-200 focus:outline-none"
                                    placeholder="Input your address" />
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="phone-number" class="text-sm mb-2">Phone Number</label>
                                <input data-input type="tel" name="phone" id="phone-number"
                                    class="border-gray-200 border rounded-lg px-4 py-2 bg-white text-sm focus:border-blue-200 focus:outline-none"
                                    placeholder="Input your phone number" />
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="phone-number" class="text-sm mb-2">booking date</label>
                                <input data-input type="text" name="book_date" id="phone-number"
                                    class="border-gray-200 border rounded-lg px-4 py-2 bg-white text-sm focus:border-blue-200 focus:outline-none"
                                    placeholder="Input your booking date" />
                            </div>

                            <div class="flex flex-col mb-4">
                                <label for="phone-number" class="text-sm mb-2">Jenis Meja</label>
                                <select name="tables_id"
                                    class="border-gray-200 border rounded-lg px-4 py-2 bg-white text-sm focus:border-blue-200 focus:outline-none">
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" value="online" name="payment"
                                    class="bg-pink-400 text-black hover:bg-black hover:text-pink-400 focus:outline-none w-full py-3 rounded-full text-lg focus:text-black transition-all duration-200 px-6">
                                    Bayar
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: COMPLETE YOUR ROOM -->
@endsection
