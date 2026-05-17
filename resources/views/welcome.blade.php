<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot:title>
        
        <section>
            <div class="md:mx-[5%] ">
                <div class=" flex gap-5 justify-end">
                    <div class="left flex-3  flex flex-col items-end">
                        <h1 class="text-end font-bold text-5xl md:text-8xl lg:text-9xl md:max-w-[90%] font-display mt-80">
                            Eko ramadani
                        </h1>
                        <p class="text-end md:text-lg max-w-[85%] md:max-w-[70%] text-gray-700">Saya seorang backend developer yang fokus membangun sistem server, API, dan database yang stabil serta efisien untuk mendukung pengembangan aplikasi modern dan skalabel.</p>
                    </div>
                    <div class="right p-2 flex-1 bg-red-200">
                        <div class="content ">
                            
                        </div>
                    </div>
                </div>
                <div class="flex gap-5 justify-end mt-4 flex-col lg:flex-row pr-4 md:p4-0 ">
                    <div class="left relative flex justify-end order-2 lg:order-1  p-2">
                        <ul class="flex items-center gap-4 h-full lg:absolute lg:top-0 md:-top-4 md:right-full w-max ">
                            <li>
                                <a href="" class="w-15 h-15 grid hover:-translate-y-0.5 duration-150  rounded-full bg-blue-700 hover:bg-blue-600 shadow-blue-400 shadow-md">
                                    <iconify-icon icon="line-md:linkedin" class="text-3xl self-center text-white"></iconify-icon>
                                </a>
                            </li>
                            <li>
                                <a href="" class="w-15 h-15 grid hover:-translate-y-0.5 duration-150  rounded-full bg-gray-700 hover:bg-gray-600 shadow-gray-500 shadow-md">
                                    <iconify-icon icon="line-md:github-twotone" class="text-3xl self-center text-white"></iconify-icon>
                                </a>
                            </li>
                            <li>
                                <a href="" class="w-15 h-15 grid hover:-translate-y-0.5 duration-150  rounded-full bg-linear-to-tr from-yellow-400 via-pink-500 to-purple-600 shadow-[0_0_40px_rgba(238,42,123,0.5)] ">
                                    <iconify-icon icon="line-md:instagram" class="text-3xl self-center text-white"></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="right order-1">
                        <h2 class="text-end text-2xl md:text-4xl lg:text-7xl ">
                            Back-End Developer
                        </h2>
                    </div>
                </div>
            </div>
        </section>


</x-layout>
