<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot:title>

    <section class=" bg-gray-50 w-dvw h-dvh  flex justify-center items-center">
        <div class="max-w-6xl mx-auto">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:-translate-y-2 transition duration-300">
                    <img 
                        src="{{ asset('images/project1.jpg') }}" 
                        alt="Project 1"
                        class="w-full h-52 object-cover"
                    >

                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Website Portfolio
                        </h2>

                        <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                            Website portfolio modern menggunakan Laravel dan Tailwind CSS 
                            dengan desain clean dan responsive.
                        </p>

                        <div class="flex gap-2 mt-4 flex-wrap">
                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                Laravel
                            </span>

                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                Tailwind
                            </span>
                        </div>

                        <a href="#"
                            class="inline-block mt-6 bg-black text-white px-5 py-2 rounded-xl hover:bg-gray-800 transition">
                            Lihat Projek
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:-translate-y-2 transition duration-300">
                    <img 
                        src="{{ asset('images/project2.jpg') }}" 
                        alt="Project 2"
                        class="w-full h-52 object-cover"
                    >

                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Aplikasi Kasir
                        </h2>

                        <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                            Sistem kasir sederhana dengan fitur manajemen produk, 
                            transaksi, dan laporan penjualan.
                        </p>

                        <div class="flex gap-2 mt-4 flex-wrap">
                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                PHP
                            </span>

                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                MySQL
                            </span>
                        </div>

                        <a href="#"
                            class="inline-block mt-6 bg-black text-white px-5 py-2 rounded-xl hover:bg-gray-800 transition">
                            Lihat Projek
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:-translate-y-2 transition duration-300">
                    <img 
                        src="{{ asset('images/project3.jpg') }}" 
                        alt="Project 3"
                        class="w-full h-52 object-cover"
                    >

                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            UI Landing Page
                        </h2>

                        <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                            Landing page modern dengan animasi halus dan fokus 
                            pada pengalaman pengguna.
                        </p>

                        <div class="flex gap-2 mt-4 flex-wrap">
                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                HTML
                            </span>

                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                Tailwind
                            </span>
                        </div>

                        <a href="#"
                            class="inline-block mt-6 bg-black text-white px-5 py-2 rounded-xl hover:bg-gray-800 transition">
                            Lihat Projek
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layout>