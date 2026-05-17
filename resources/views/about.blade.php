<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot:title>

        
        <section class="w-dvw h-dvh  flex justify-center items-center bg-gray-50">
            <div class="md:mx-[5%]  self-center">
                <div class="md:w-[900px] md:h-[400px] rounded-2xl overflow-hidden bg-white  shadow-lg flex">
                    <div class="left flex-2 bg-red-700 overflow-hidden">
                        <img class="w-full h-full object-cover" src="{{ asset('images/logo.png') }}"  alt="">
                    </div>
                    <div class="right flex-4 p-6 px-9">
                        <h2 class="text-4xl font-bold mb-8 font-display mt-3"> Card Profile</h2>
                        <ul class="*:text-2xl *:font-mono *:mb-2">
                            <li>
                                Nama: {{ $nama }}
                            </li>
                            <li>
                                Nim: {{ $nim }}
                            </li>
                            <li>
                                Prodi: {{ $prodi }}
                            </li>
                            <li>
                                Mata Kuliah: {{ $matakuliah }}
                            </li>
                            <li>
                                Framework: {{ $framework }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


</x-layout>
