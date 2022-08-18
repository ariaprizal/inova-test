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

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Registrasi</title>
</head>
<body>
    <div class="flex justify-center items-center py-4 h-full">
        <div class="w-2/4 h-full shadow rounded-md py-4 mt-20">
            <h1 class= "text-center mt-4 text-xl">Regitrasi Pasien</h1>
                @if(session('success'))
                    <h5 class="text-blue-400 text-center"> {{session('success')}}</h5>
                @endif
            <form action="{{route('save.register')}}" method="post" enctype="multipart/form-data" class="flex flex-col h-auto w-full ml-5 mt-7" >
                @csrf
                <div class="my-4">
                    <input class="text-center @error('name') ring-1 ring-red-500 @enderror h-10 w-11/12 bg-transparent shadow-xl border-b mx-2 border-indigo-500 rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none focus:ring-1 focus:ring-red-500 " type="text" name="name" id="name" placeholder="Masukan Nama Lengkap"  value="{{ old('name') }}">
                    @error('name')
                             <div class="text-red-500 ml-4 text-xs">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-4">
                    <input class="text-center @error('identity') ring-1 ring-red-500 @enderror h-10 w-11/12 bg-transparent shadow-xl border-b mx-2 border-indigo-500 rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none focus:ring-1 focus:ring-red-500 " type="text" name="identity" id="identity" placeholder="Masukan Nomor KTP"  value="{{ old('identity') }}">
                    @error('identity')
                             <div class="text-red-500 ml-4 text-xs">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-4">
                    <input class="text-center @error('password') ring-1 ring-red-500 @enderror h-10 w-11/12 bg-transparent shadow-xl border-b mx-2 border-indigo-500 rounded-md placeholder-gray-700 focus:placeholder-transparent focus:outline-none focus:ring-1 focus:ring-red-500 " type="password" name="password" id="password" placeholder="Password" >
                    @error('password')
                             <div class="text-red-500 ml-4 text-xs">{{$message}}</div>
                    @enderror
                </div>
                
                <div class="my-4">
                    <button type="submit" class="transition shadow-xl mx-2 duration-500 ease-in-out bg-gray-200 hover:bg-gray-600 transform hover:-translate-y-1 hover:text-white hover:scale-105 px-8 py-2 rounded-md">Registrasi</button>
                    <a href=" {{route('login')}} " class="transition shadow-xl mx-2 duration-500 ease-in-out bg-gray-200 hover:bg-gray-600 transform hover:-translate-y-1 hover:text-white hover:scale-105 px-8 py-2 rounded-md">Login</a>
                </div>
            </form>
        </div>
    </div>





    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>