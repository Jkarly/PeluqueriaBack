@extends('layouts.plantilla')

@section('title', 'Home')

@section('header-right')
    <x-navbar />
@endsection

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-pink-500 to-purple-600 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl">
                            <span class="block">Glory Beauty Salon</span>
                            <span class="block text-pink-200">Beauty as a gift</span>
                        </h1>
                        <p class="mt-3 text-base text-pink-100 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Glory Beauty Salon offers the latest and highest quality services for you and all your family members. We specialize in all beauty treatments and our team is fully professional and innovative.
                        </p>
                        <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-pink-50 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                    READ MORE
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"  src="{{ asset('storage/images/home.jpg') }}" alt="Beauty Salon Interior">
        </div>
    </div>

    

    <!-- Services Overview Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Cosmetic Service -->
                <div class="text-center p-6 bg-pink-50 rounded-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg">
                    <div class="w-16 h-16 bg-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">COSMETIC</h3>
                    <div class="h-px w-12 bg-pink-500 mx-auto mb-4"></div>
                    <p class="text-gray-600 text-sm">
                        some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything.
                    </p>
                </div>

                <!-- Nails Service -->
                <div class="text-center p-6 bg-pink-50 rounded-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg">
                    <div class="w-16 h-16 bg-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">NAILS</h3>
                    <div class="h-px w-12 bg-pink-500 mx-auto mb-4"></div>
                    <p class="text-gray-600 text-sm">
                        some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything.
                    </p>
                </div>

                <!-- Hairdressing Service -->
                <div class="text-center p-6 bg-pink-50 rounded-lg transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg">
                    <div class="w-16 h-16 bg-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">HAIRDRESSING</h3>
                    <div class="h-px w-12 bg-pink-500 mx-auto mb-4"></div>
                    <p class="text-gray-600 text-sm">
                        some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything.
                    </p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    Read More
                </a>
            </div>
        </div>
    </div>
    <!-- Featured Services Carousel -->
    <div class="py-16 bg-gradient-to-br from-white to-pink-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Featured Services
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Discover our most popular beauty treatments and services
                </p>
            </div>

            <!-- Carousel Container -->
            <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                <!-- Carousel Slides -->
                <div id="serviceCarousel" class="carousel flex transition-transform duration-700 ease-in-out">
                    <!-- Slide 1 - Hair Styling -->
                    <div class="carousel-slide min-w-full flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-8 md:p-12 bg-gradient-to-r from-purple-500 to-pink-500 text-white flex flex-col justify-center">
                            <span class="text-sm font-semibold tracking-wider uppercase opacity-80 mb-2">Premium Service</span>
                            <h3 class="text-3xl font-bold mb-4">Hair Styling & Coloring</h3>
                            <p class="text-lg mb-6">Transform your look with our expert hair styling and coloring services. From classic cuts to vibrant colors, we create the perfect style for you.</p>
                            <div class="flex space-x-4">
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">From $75</span>
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">60-90 min</span>
                            </div>
                            <a href="#" class="mt-8 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-pink-50 w-fit transition-all duration-300 transform hover:scale-105">
                                BOOK NOW
                            </a>
                        </div>
                        <div class="md:w-1/2">
                            <img class="w-full h-64 md:h-full object-cover" src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Hair Styling Service">
                        </div>
                    </div>
                    
                    <!-- Slide 2 - Facial Treatments -->
                    <div class="carousel-slide min-w-full flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-8 md:p-12 bg-gradient-to-r from-pink-500 to-purple-500 text-white flex flex-col justify-center">
                            <span class="text-sm font-semibold tracking-wider uppercase opacity-80 mb-2">Luxury Treatment</span>
                            <h3 class="text-3xl font-bold mb-4">Facial & Skin Care</h3>
                            <p class="text-lg mb-6">Rejuvenate your skin with our premium facial treatments. Using only the highest quality products to give you a radiant, glowing complexion.</p>
                            <div class="flex space-x-4">
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">From $90</span>
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">45-75 min</span>
                            </div>
                            <a href="#" class="mt-8 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-pink-50 w-fit transition-all duration-300 transform hover:scale-105">
                                BOOK NOW
                            </a>
                        </div>
                        <div class="md:w-1/2">
                            <img class="w-full h-64 md:h-full object-cover" src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Facial Treatment">
                        </div>
                    </div>
                    
                    <!-- Slide 3 - Nail Art -->
                    <div class="carousel-slide min-w-full flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-8 md:p-12 bg-gradient-to-r from-purple-600 to-pink-600 text-white flex flex-col justify-center">
                            <span class="text-sm font-semibold tracking-wider uppercase opacity-80 mb-2">Creative Design</span>
                            <h3 class="text-3xl font-bold mb-4">Nail Art & Manicure</h3>
                            <p class="text-lg mb-6">Express your style with our creative nail art and luxurious manicure services. From classic French to intricate designs, we've got you covered.</p>
                            <div class="flex space-x-4">
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">From $45</span>
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">30-60 min</span>
                            </div>
                            <a href="#" class="mt-8 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-pink-50 w-fit transition-all duration-300 transform hover:scale-105">
                                BOOK NOW
                            </a>
                        </div>
                        <div class="md:w-1/2">
                            <img class="w-full h-64 md:h-full object-cover" src="https://images.unsplash.com/photo-1607778833979-44b6ea63b59c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Nail Art Service">
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Controls -->
                <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-pink-600 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-pink-600 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300"></button>
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300"></button>
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 lg:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Our Beauty Salon
                    </h2>
                    <div class="mt-6 space-y-4 text-lg text-gray-600">
                        <p>
                            Glory offers beauty services of an utmost level to all LA residents and guests who are looking for high-quality beauty care.
                        </p>
                        <p>
                            Our Beauty Salon is based on the belief that our customers' needs are of the utmost importance. Our entire team is committed to meeting those needs. As a result, a high percentage of our business is from regular customers.
                        </p>
                        <p>
                            All our salons in LA are uniquely designed to offer our clients the best beauty, hairstyling, and skin care experiences.
                        </p>
                        <p class="font-semibold text-pink-600">
                            We are responsible for the quality of the services you receive!
                        </p>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0">
                    <img class="w-full rounded-lg shadow-lg transition-all duration-500 hover:shadow-2xl" src="https://images.unsplash.com/photo-1595475706256-7ad6d0d5b7ac?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Beauty Salon Team">
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    A Variety of Beauty Services
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    We offer a full range of salon treatments and styling services provided by a team of professional stylists.
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Hair Services -->
                <div class="bg-pink-50 p-8 rounded-lg text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg">
                    <img class="w-20 h-20 mx-auto mb-4 rounded-full object-cover" src="https://images.unsplash.com/photo-1560869713-7d0a0a3e4b0a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Hair Styling">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Hair Styling</h3>
                    <p class="text-gray-600">
                        Professional haircuts, coloring, and styling services tailored to your unique personality.
                    </p>
                </div>

                <!-- Makeup Services -->
                <div class="bg-pink-50 p-8 rounded-lg text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg">
                    <img class="w-20 h-20 mx-auto mb-4 rounded-full object-cover" src="https://images.unsplash.com/photo-1596464716127-f2a82984de30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Makeup Services">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Makeup Artistry</h3>
                    <p class="text-gray-600">
                        Flawless makeup application for every occasion, from natural day looks to glamorous evening makeup.
                    </p>
                </div>

                <!-- Nail Services -->
                <div class="bg-pink-50 p-8 rounded-lg text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg">
                    <img class="w-20 h-20 mx-auto mb-4 rounded-full object-cover" src="https://images.unsplash.com/photo-1607778833979-44b6ea63b59c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Nail Services">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Nail Care</h3>
                    <p class="text-gray-600">
                        Manicures, pedicures, and nail art designs to complete your perfect look.
                    </p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    BOOK NOW
                </a>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Our Professional Team
                </h2>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Karen York -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                    <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1551833994-15c3b7f0f4c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Karen York">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900">Karen York</h3>
                        <p class="text-pink-600 font-medium">Cosmetologist</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                    <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1580618672591-eb180b1a973f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1169&q=80" alt="Sarah Johnson">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900">Sarah Johnson</h3>
                        <p class="text-pink-600 font-medium">Senior Stylist</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                    <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1594824947933-d0501ba2fe65?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Maria Rodriguez">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900">Maria Rodriguez</h3>
                        <p class="text-pink-600 font-medium">Skincare Specialist</p>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden text-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                    <img class="w-full h-64 object-cover" src="https://images.unsplash.com/photo-1580618864180-f6d7d39b8ff6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1169&q=80" alt="Emily Chen">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900">Emily Chen</h3>
                        <p class="text-pink-600 font-medium">Nail Artist</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    VIEW ALL TEAM
                </a>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-gradient-to-r from-pink-500 to-purple-600 py-16 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold sm:text-4xl">
                    Contact Us
                </h2>
                <p class="mt-4 text-xl text-pink-100">
                    Ready to experience the Glory difference? Get in touch with us today!
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Visit Our Salon</h3>
                    <p class="text-pink-100">123 Beauty Avenue<br>Los Angeles, CA 90001</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Call Us</h3>
                    <p class="text-pink-100">(+71) 1234567890<br>demo@gmail.com</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-pink-50 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    BOOK APPOINTMENT
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('serviceCarousel');
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        let currentIndex = 0;
        const totalSlides = slides.length;
        
        // Function to update carousel position
        function updateCarousel() {
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
            
            // Update active indicator
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('bg-opacity-100', 'w-6');
                    indicator.classList.remove('bg-opacity-50', 'w-3');
                } else {
                    indicator.classList.remove('bg-opacity-100', 'w-6');
                    indicator.classList.add('bg-opacity-50', 'w-3');
                }
            });
        }
        
        // Next slide
        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateCarousel();
        }
        
        // Previous slide
        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateCarousel();
        }
        
        // Go to specific slide
        function goToSlide(index) {
            currentIndex = index;
            updateCarousel();
        }
        
        // Event listeners
        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => goToSlide(index));
        });
        
        // Auto-advance carousel
        let autoSlide = setInterval(nextSlide, 5000);
        
        // Pause auto-advance on hover
        carousel.addEventListener('mouseenter', () => {
            clearInterval(autoSlide);
        });
        
        carousel.addEventListener('mouseleave', () => {
            autoSlide = setInterval(nextSlide, 5000);
        });
        
        // Initialize carousel
        updateCarousel();
    });
</script>

<style>
    .carousel {
        display: flex;
        transition: transform 0.7s ease-in-out;
    }
    
    .carousel-slide {
        min-width: 100%;
        box-sizing: border-box;
    }
    
    .carousel-indicator {
        transition: all 0.3s ease;
    }
    
    /* Add some subtle animations for page elements */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease-out;
    }
</style>
@endsection