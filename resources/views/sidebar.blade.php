<nav class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white dark:bg-gray-900 flex flex-wrap items-center justify-between relative md:w-64 lg:w-72 z-10 sm:py-4 px-6">
    <div class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
        <div class="flex flex-row items-center justify-between overflow-visible md:pb-2 md:py-4 w-full">
            <a class="md:block text-left text-zinc-600 dark:text-gray-200 mr-0 inline-block  text-sm uppercase font-bold px-0 w-fit" href="index{{ $useDotHtml ? '.html' : '' }}"> {{ $siteName }} </a> <!-- Dark mode switch -->
            
            @include('laradocgen::components.theme-button') 

            <button class="cursor-pointer text-black dark:text-white opacity-50 md:hidden pl-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" type="button" onclick="toggleNavbar('example-collapse-sidebar')" title="Open menu">
                <svg class="dark:fill-white" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                </svg>
            </button>
        </div>
        <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden" id="example-collapse-sidebar">
            <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-zinc-200">
                <div class="flex flex-wrap">
                    <div class="w-9/12"> <a class="md:block text-left md:pb-2 text-zinc-600 dark:text-zinc-300 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0" href="index{{ $useDotHtml ? '.html' : '' }}"> {{ $siteName }} </a> </div>
                    <div class="w-3/12 flex justify-end">
                        <button type="button" class="cursor-pointer text-black dark:text-white opacity-50 md:hidden pl-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" onclick="toggleNavbar('example-collapse-sidebar')" title="Close menu">
                            <svg class="dark:fill-white" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            {{-- <form class="mt-6 mb-4 md:hidden">
                <div class="mb-3 pt-0"> <input type="text" placeholder="Search" class="px-3 py-2 h-12 border border-solid  border-zinc-500 placeholder-zinc-300 text-zinc-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" /> </div>
            </form>
            <hr class="my-4 md:min-w-full" /> --}}
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                @if(count($links))
                @foreach ($links as $link)
                @if($link->slug == $page->slug) 
                <li id="sidebar-active" class="items-center">
                    <a class="text-pink-500 hover:text-pink-600 text-xs uppercase py-3 font-bold block" href="{{ $link->slug }}{{ $useDotHtml ? '.html' : '' }}">
                        {{ $link->title }}
                    </a>
                </li>
                @else 
                <li class="items-center"> <a class="text-zinc-700 dark:text-gray-200 hover:text-zinc-500 text-xs uppercase py-3 font-bold block" href="{{ $link->slug }}{{ $useDotHtml ? '.html' : '' }}"> {{ $link->title }} </a> </li>
                @endif
                @endforeach 
                @else
                <li id="sidebar-active" class="items-center">
                    <a class="text-pink-500 hover:text-pink-600 text-xs uppercase py-3 font-bold block" href="index{{ $useDotHtml ? '.html' : '' }}">
                        Index
                    </a>
                </li>
                @if($realtime)
                <li class="items-center text-sm">
                    Links will be automatically added to the sidebar as you create your Markdown pages
                </li>
                @endif
                @endif
            </ul>
            <div class="mt-auto">
                <hr class="my-3 md:min-w-full" />
                <h6 class="md:min-w-full text-zinc-600 dark:text-gray-300 text-xs uppercase font-bold block py-1 no-underline"> <a href="/">Back to App</a> </h6>
            </div>
        </div>
    </div>
</nav>