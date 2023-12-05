<nav x-data="{ openSidebar: false }" class="max-w-screen-md lg:max-w-screen-lg mx-auto">
    <x-stack-layout row class="flex justify-between h-20 bg-white shadow-md p-4">
        <a class="flex items-center gap-2 h-full border-zinc-200 pr-4 sm:pr-0"
            href="{{ url('/') }}">
            <x-logos.light-logo class="w-[50px] sm:w-[100px]"/>
            <h1 class="font-bold text-2xl whitespace-nowrap border-l sm:border-none pl-2">
                🚀 NarrowBlast (HACKED)
            </h1>
        </a>

        <button class="block md:hidden"
                type="button"
                @click="openSidebar = true"
                aria-label="{{ __('Toggle navigation') }}">
            <x-icons.menu width="32px"
                          height="32px" />
        </button>

        <div x-cloak class="md:flex justify-start sm:justify-end w-full sm:min-w-[360px] z-50 items-center bg-white bottom-0 top-0 right-0 flex fixed md:static p-4 md:p-0 shadow-md md:shadow-none gap-4 flex-col md:flex-row"
            :class="{ 'hidden md:flex': !openSidebar }">
            <button class="block md:hidden self-end"
                    type="button"
                    @click="openSidebar = false"
                    aria-label="{{ __('Toggle navigation') }}">
                <x-icons.close width="32px"
                               height="32px"/>
            </button>

            <x-stack-layout row class="items-center">
                @guest
                    <x-buttons.link href="{{ route('login') }}">{{ __('Login') }}</x-buttons.link>
                @else
                    <x-stack-layout class="items-stretch text-center flex-col md:flex-row">
                        <x-buttons.link
                            center
                            target="_blank"
                            href="{{ url('https://login.curio.codes') }}">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </x-buttons.link>

                        <div class="md:hidden w-full">
                            @livewire('credit-counter', ['center' => true])
                        </div>

                        <form action="{{ route('logout') }}"
                            method="POST">
                            @csrf
                            <x-buttons.primary submit class="w-full">
                                {{ __('Logout') }}
                            </x-buttons.primary>
                        </form>

                        <x-stack-layout column class="md:hidden items-stretch">
                            <x-buttons.link href="{{ route('shop.index') }}" icon="shopping-cart" center>
                                @lang('app.shop')
                            </x-buttons.link>
                            <x-buttons.link href="{{ route('shop.inventory') }}" icon="archive-box" center>
                                @lang('app.inventory')
                            </x-buttons.link>
                            <x-buttons.link href="{{ route('slides.manage') }}" icon="presentation-chart-bar" center>
                                @lang('app.slides_manage')
                            </x-buttons.link>
                            @if(!config('app.disable_invite_system') || auth()->user()->isSuperAdmin())
                            <x-buttons.link href="{{ route('slides.inviteEnter') }}" icon="qr-code" center>
                                @lang('app.enter_invite_code')
                            </x-buttons.link>
                            @endif
                            @if(Auth::user()->isSuperAdmin())
                            <x-buttons.link href="{{ route('filament.admin.pages.dashboard') }}"
                                center
                                icon="lock-closed"
                                target="_blank">
                                @lang('app.admin_panel')
                            </x-buttons.link>
                            @endif
                        </x-stack-layout>
                    </x-stack-layout>
                @endguest
            </x-stack-layout>
        </div>
    </x-stack-layout>

    @auth
        <x-stack-layout tight row class="hidden md:flex md:rounded-b items-stretch shadow-md overflow-clip">
            <x-stack-layout row class="py-2 px-4 items-center grow bg-zinc-300/25 flex-wrap">
                <x-buttons.link href="{{ route('shop.index') }}" icon="shopping-cart">
                    @lang('app.shop')
                </x-buttons.link>
                <x-buttons.link href="{{ route('shop.inventory') }}" icon="archive-box">
                    @lang('app.inventory')
                </x-buttons.link>
                <x-buttons.link href="{{ route('slides.manage') }}" icon="presentation-chart-bar">
                    @lang('app.slides_manage')
                </x-buttons.link>
                @if(!config('app.disable_invite_system') || auth()->user()->isSuperAdmin())                <x-buttons.link href="{{ route('slides.inviteEnter') }}" icon="qr-code">
                    @lang('app.enter_invite_code')
                </x-buttons.link>
                @endif
                @if(Auth::user()->isSuperAdmin())
                <x-buttons.link href="{{ route('filament.admin.pages.dashboard') }}"
                    icon="lock-closed"
                    target="_blank">
                    @lang('app.admin_panel')
                </x-buttons.link>
                @endif
            </x-stack-layout>

            @livewire('credit-counter')
        </x-stack-layout>
    @endauth
</nav>
