<div>
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
     <nav class="fixed top-4 md:top-1/2 left-0 md:-translate-y-1/2 ">
            <div class="content  rounded-r-2xl bg-gray-800  md:w-16.25 md:py-3 text-white ">
                <div class="p-2 block md:hidden">
                    <button id="menu-btn" class="icon py-1.5 px-1.75">
                        <iconify-icon icon="line-md:menu" class="text-3xl"></iconify-icon>
                    </button>
                </div>
                <ul id="mobile-menu" class=" max-h-0 md:max-h-100 overflow-hidden md:overflow-visible transition-all duration-300">
                    <x-nav-link
                        href="/home"
                        :icon="'line-md:home-twotone'"
                        :active="request()->is('home')">
                        Home
                    </x-nav-link>
                    <x-nav-link
                        href="/projek"
                        :icon="'line-md:folder'"
                        :active="request()->is('projek')">
                        Projek
                    </x-nav-link>
                    <x-nav-link
                        href="/tentang"
                        :icon="'line-md:account'"
                        :active="request()->is('tentang')">
                        Tentang Saya
                    </x-nav-link>
                    
                </ul>
            </div>
        </nav>

        

        <script>
            const menuBtn = document.getElementById("menu-btn");
            const mobileMenu = document.getElementById("mobile-menu");

            let open = false;

            menuBtn.addEventListener("click", () => {
                open = !open;

                if (open) {
                    mobileMenu.classList.remove("max-h-0");
                    mobileMenu.classList.add("max-h-96");
                } else {
                    mobileMenu.classList.remove("max-h-96");
                    mobileMenu.classList.add("max-h-0");
                }
            });
        </script>
</div>