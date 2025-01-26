<nav x-data="{ open: false }" @keydown.window.escape="open = false">
    <div class="container mx-auto">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between flex-grow">
                <div class="flex-shrink-0">
                    <h1 class="text-lg font-semibold tracking-widest uppercase">
                        <div class="flex items-center h-7" style="">
                            <img class="w-[7em] h-[2em] lg:w-[12.5625em] lg:h-[3.75em] me-14"
                                src="{{ asset('images/logo_court.jpeg') }}" alt="E-Court" width="100%"
                                height="100%" />
                            <p style="background: #EBEDF3 ">
                                <a href="#"
                                    class="flex flex-row items-center px-3 py-2 text-sm font-medium rounded-md text-[#0E9242]">
                                    <svg width="23" height="18" viewBox="0 0 23 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.3906 4.9043C11.4648 4.83008 11.5762 4.79297 11.6875 4.79297C11.7617 4.79297 11.873 4.83008 11.9473 4.9043L18.8125 10.5078V16.5938C18.8125 16.9277 18.5156 17.1875 18.2188 17.1875H14.0254C13.7285 17.1875 13.4316 16.9277 13.4316 16.5938V13.0312C13.4316 12.7344 13.1719 12.4375 12.8379 12.4375H10.4629C10.166 12.4375 9.86914 12.7344 9.86914 13.0312V16.5938C9.86914 16.9277 9.60938 17.1875 9.3125 17.1875H5.15625C4.82227 17.1875 4.5625 16.9277 4.5625 16.5938V10.5449L11.3906 4.9043ZM22.1895 8.72656C22.3008 8.80078 22.375 8.94922 22.375 9.06055C22.375 9.17188 22.3379 9.2832 22.2637 9.35742L21.2988 10.5078C21.2246 10.6191 21.1133 10.6562 20.9648 10.6562C20.8535 10.6562 20.7422 10.6191 20.668 10.5449L11.9473 3.38281C11.873 3.30859 11.7617 3.27148 11.6875 3.27148C11.5762 3.27148 11.4648 3.30859 11.3906 3.38281L2.66992 10.5449C2.5957 10.6191 2.48438 10.6562 2.37305 10.6562C2.22461 10.6562 2.11328 10.6191 2.03906 10.5078L1.07422 9.35742C1.03711 9.2832 0.962891 9.17188 0.962891 9.06055C0.962891 8.94922 1.03711 8.80078 1.14844 8.72656L10.5371 0.970703C10.834 0.748047 11.2422 0.599609 11.6875 0.599609C12.0957 0.599609 12.5039 0.748047 12.8008 0.970703L16.1406 3.7168V1.04492C16.1406 0.785156 16.3262 0.599609 16.5859 0.599609H18.6641C18.8867 0.599609 19.1094 0.785156 19.1094 1.04492V6.16602L22.1895 8.72656Z"
                                            fill="#0BA14A" />
                                    </svg>
                                    <span class="ml-2">হোম</span>
                                </a>
                            </p>
                        </div>
                    </h1>
                </div>


            </div>
            <div class="hidden lg:block">
                <div class="flex items-center ml-4 md:ml-6">
                    <div @click.away="open = false" class="relative ml-3" x-data="{ open: false }">
                        <div class="flex items-center gap-5" @click="open = !open">
                            <div>
                                <button
                                    class="flex items-center max-w-xs text-sm text-white rounded-full focus:outline-none focus:shadow-solid"
                                    id="user-menu" aria-label="User menu" aria-haspopup="true"
                                    x-bind:aria-expanded="open">
                                    <img class="w-8 h-8 rounded-full"
                                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="" />
                                </button>
                            </div>
                            <div>
                                <p class="text-[16px]" style="cursor: pointer">{{ Auth::user()->name }}</p>
                                <p class="text-[12px] text-gray-600" style="cursor: pointer">
                                    {{ Auth::user()->designation }}</p>
                                {{-- @dd() --}}
                                {{-- <p class="text-[10px]">উপসচিব</p> --}}
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open, 'rotate-0': !open }"
                                class="w-4 h-4 mt-1 transform " style="cursor: pointer" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opaity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 w-48 mt-2 origin-top-right rounded-md shadow-lg">
                            <div class="py-1 bg-white rounded-md shadow-xs">
                                {{--  <a href="#"
                                    class="flex flex-row items-center px-4 py-2 text-sm text-gray-700 focus:text-gray-900 hover:text-gray-900 focus:outline-none hover:bg-gray-100 focus:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span class="ml-2">Your Profile</span>
                                </a>
                                <a href="#"
                                    class="flex flex-row items-center px-4 py-2 text-sm text-gray-700 focus:text-gray-900 hover:text-gray-900 focus:outline-none hover:bg-gray-100 focus:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-settings">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg>
                                    <span class="ml-2">Settings</span>
                                </a> --}}
                                {{-- <div>
                                    <a href="{{ route('logout.custom') }}"
                                        class="btn btn-sm btn-light-primary font-bold py-2 px-5"
                                        style="background-color:#bb2d3b"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="text-white mr-2">
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4m8-8v16M3 12l9-9 9 9" />
                                            </svg>
                                        </span>
                                        <span class="text-white">{{ __('লগ আউট') }}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout.custom') }}" method="POST"
                                        class="hidden">
                                        @csrf
                                    </form>
                                </div> --}}
                                <div>
                                    <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        href="{{ route('logout.custom') }}"
                                        class="flex flex-row items-center px-4 py-2 text-sm text-red-500 hover:text-red-700 hover:bg-red-100 focus:outline-none focus:text-red-700 focus:bg-red-100"
                                        style="background: ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-log-out">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12">
                                            </line>
                                        </svg>
                                        <span class="ml-2">লগ আউট</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout.custom') }}" method="POST"
                                        class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex -mr-2 lg:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white"
                    x-bind:aria-label="open ? 'Close main menu' : 'Main menu'" x-bind:aria-expanded="open">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

</nav>
{{-- source : https://codepen.io/janheise/pen/JjdwXyz --}}
