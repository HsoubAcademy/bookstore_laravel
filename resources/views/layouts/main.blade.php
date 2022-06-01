<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>مكتبة حسوب</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f0f0f0;
        }

        .bg-cart {
            background-color: #ffc107;
            color: #fff
        }

        .score {
            display: block;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }
        .score-wrap {
            display: inline-block;
            position: relative;
            height: 19px;
        }
        .score .stars-active {
            color: #FFCA00;
            position: relative;
            z-index: 10;
            display: block;
            overflow: hidden;
            white-space: nowrap;
        }
        .score .stars-inactive {
            color: lightgrey;
            position: absolute;
            top: 0;
            left: 0;
        }

        .rating {
            overflow: hidden;
            display: inline-block;
            position: relative;
            font-size: 20px;
        }
        .rating-star {
            padding: 0 5px;
            margin: 0;
            cursor: pointer;
            display: block;
            float: left;
        }
        .rating-star:after {
            position: relative;
            font-family: "Font Awesome 5 Free";
            content: '\f005';
            color: lightgrey;
        }
        .rating-star.checked ~ .rating-star:after,
        .rating-star.checked:after {
            content: '\f005';
            color: #FFCA00;
        }
        .rating:hover .rating-star:after {
            content: '\f005';
            color: lightgrey;
        }
        .rating-star:hover ~ .rating-star:after,
        .rating .rating-star:hover:after {
            content: '\f005';
            color: #FFCA00;
        }
    </style>
    @yield('head')

</head>
<body dir="rtl" style="text-align: right">
        <div>
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">مكتبة حسوب</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('cart.view') }}">
                                        @if(Auth::user()->booksInCart()->count() > 0)
                                            <span class="badge bg-secondary">{{ Auth::user()->booksInCart()->count() }}</span>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                            العربة 
                                        <i class="fas fa-shopping-cart"></i> 
                                    </a>
                                </li>
                            @endauth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gallery.categories.index') }}">
                                        التصنيفات                                        
                                    <i class="fas fa-list"></i> 
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gallery.publishers.index') }}">
                                    الناشرون                                         
                                    <i class="fas fa-table"></i> 
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gallery.authors.index') }}">
                                    المؤلفون                                         
                                    <i class="fas fa-pen"></i> 
                                </a>
                            </li>

                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('my.product') }}">
                                        مشترياتي     
                                        <i class="fas fa-basket-shopping"></i> 
                                    </a>
                                </li>
                            @endauth
                        </ul>
                        
                        <ul class="navbar-nav mr-auto">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('إنشاء حساب') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown justify-content-left">
                                    <a id="navbarDropdown" class="nav-link" href="#" data-bs-toggle="dropdown">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-left px-2 text-right mt-2">
                                        @can('update-books')
                                            <a href="{{ route('admin.index') }}" class="dropdown-item">لوحة الإدارة</a>
                                        @endcan
                                    
                                        <div class="pt-4 pb-1 border-t border-gray-200">
                                            <div class="flex items-center px-4">
                                                <div>
                                                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                                </div>
                                            </div>

                                            <div class="mt-3 space-y-1">
                                                <!-- Account Management -->
                                                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                                    {{ __('الملف الشخصي') }}
                                                </x-jet-responsive-nav-link>

                                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                                        {{ __('API Tokens') }}
                                                    </x-jet-responsive-nav-link>
                                                @endif

                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}" x-data>
                                                    @csrf

                                                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                                        {{ __('تسجيل خروج') }}
                                                    </x-jet-responsive-nav-link>
                                                </form>

                                                <!-- Team Management -->
                                                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                                    <div class="border-t border-gray-200"></div>

                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        {{ __('Manage Team') }}
                                                    </div>

                                                    <!-- Team Settings -->
                                                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                                                        {{ __('Team Settings') }}
                                                    </x-jet-responsive-nav-link>

                                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                                            {{ __('Create New Team') }}
                                                        </x-jet-responsive-nav-link>
                                                    @endcan

                                                    <div class="border-t border-gray-200"></div>

                                                    <!-- Team Switcher -->
                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        {{ __('Switch Teams') }}
                                                    </div>

                                                    @foreach (Auth::user()->allTeams() as $team)
                                                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/fc1e322aff.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')
</body>
</html>