<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased min-h-screen bg-slate-50">
        <div class="relative flex items-start justify-center min-h-screen sm:items-center sm:pt-0">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0 mb-8 justify-center">
                    <div class="px-4 text-lg text-slate-500 border-r border-slate-400 tracking-wider">
                        @yield('code')
                    </div>
                    <div class="ml-4 text-lg text-slate-500 uppercase tracking-wider">
                        @yield('message')
                    </div>
                </div>
                
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-slate-800 mb-4">
                        @yield('friendly_message', 'Something went wrong.')
                    </h1>
                    <p class="text-slate-600 mb-8">
                        @yield('description', 'We are having trouble loading this page. Please try again later.')
                    </p>
                    <a href="/" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 transition duration-150 ease-in-out shadow-sm gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Return Home
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
