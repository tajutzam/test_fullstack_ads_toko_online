@extends('layouts.seller')

@section('content')
    <div class="bg-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Products Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="h-12 w-12 text-blue-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2H5a2 2 0 0 0 -2 2z" />
                        <path d="M3 11h18" />
                    </svg>
                    <div class="ml-4">
                        <h2 class="text-lg font-medium text-gray-800">Total Products</h2>
                        <p class="text-2xl font-bold text-gray-600">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="h-12 w-12 text-green-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2H5a2 2 0 0 0 -2 2z" />
                        <path d="M5 11l4 4l4 -4" />
                    </svg>
                    <div class="ml-4">
                        <h2 class="text-lg font-medium text-gray-800">Total Orders</h2>
                        <p class="text-2xl font-bold text-gray-600">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
