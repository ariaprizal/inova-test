<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Login</title>
    <style>
        body {
            font-family: 'nunito';
        }

        input[type=identity],
        input[type=password] {
            transition: all .25s ease-in;
        }

        input[type=identity]:focus,
        input[type=password]:focus {
            width: 18rem;
        }

        .side {
            /* background-image: url('/images/logo.png'); */
            background-size: cover;
            background-position: center;
        }
        .shadow{
            box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
        }
    </style>

</head>

<body class="relative ">
    <div class="lg:w-full lg:h-screen  lg:flex justify-center items-center shadow-md drop-shadow-md flex flex-col">
        <div class="lg:h-auto lg:w-2/3 lg:flex lg:justify-center h-screen w-full shadow">
            <div class="lg:w-1/2 lg:h-auto h-60 w-auto lg:pl-10  side">
                <img src="https://www.inovamedika.com/image/logo-default.png" alt="" class=" object-contain w-full h-full lg:pl-2 px-3">
            </div>
            <form class="lg:w-1/2 lg:pb-6 flex flex-col items-center pt-10  h-auto pb-4" action="{{route('login.process')}}" method="post">
                @csrf
                <div class="my-2">
                    <h3 class="text-center text-2xl font-semibold -mb-4">Login</h3>
                    @if(session('error'))
                        <h5 class="text-blue-400 text-center mt-4 -mb-8"> {{session('error')}}</h5>
                    @elseif(session('success'))
                        <h5 class="text-blue-400 text-center mt-4 -mb-8"> {{session('success')}}</h5>
                    @endif
                </div>
                <div class="my-4">
                    @error('login-error')
                    <h3 class="text-red-600">{{$message}}</h3>
                    @enderror
                </div>
                <div class="my-4">
                    <input class="text-center h-10 w-56 bg-transparent shadow-lg rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none focus:ring-1 focus:ring-red-500 @error('identity') ring-1 ring-red-500 @enderror" type="text" name="identity" id="identity" placeholder="Masukan No KTP" required value="{{ old('identity') }}">
                    @error('identity')
                             <div class="text-red-500 text-xs">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-4">
                    <input class="text-center h-10 w-56 bg-transparent shadow-lg rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none focus:ring-1 focus:ring-red-500 @error('password') ring-1 ring-red-500 @enderror" type="password" name="password" id="password" placeholder="Password" required value="{{ old('password') }}">
                    @error('password')
                             <div class="text-red-500 text-xs">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-4">
                    <input class="" type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <div class="my-4">
                    <button type="submit" class="transition duration-500 ease-in-out bg-gray-200 hover:bg-gray-600 transform hover:-translate-y-1 hover:text-white hover:scale-105 px-8 py-2 rounded-md">Log In</button>
                    <a href=" {{route('register')}} " class="transition duration-500 ease-in-out bg-gray-200 hover:bg-gray-600 transform hover:-translate-y-1 hover:text-white hover:scale-105 px-8 py-2 rounded-md">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>