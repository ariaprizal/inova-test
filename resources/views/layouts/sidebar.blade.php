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

    <!-- Box Icon -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <title>@yield('title')</title>

    <style>
        body {
            font-family: 'nunito';
            background-image: url('/images/bg-login.jpg');
            background-size: contain;
        }
    </style>


</head>

<body class=" lg:h-screen w-full h-full  lg:flex lg:justify-center">
    <div class=" lg:px-4 lg:h-auto backdrop-filter backdrop-blur-lg lg:my-2 shadow-2xl lg:flex lg:flex-row flex flex-col lg:overflow-hidden w-full h-full  ">
        <!-- Sidebar Menu -->
        <div class="lg:hidden  bg-pink-500 pl-4 flex items-center ">
            <h2 id="burger"><i class='bx bx-menu font-extrabold text-white  text-4xl shadow-2xl py-4'></i></h2>
            <h3 class="font-bold text-xl ml-20"> {{(Auth::user())->name}} </h3>
        </div>
        <div class=" lg:w-1/5 lg:block bg-pink-600 h-screen w-2/3 hidden" id="sidebar">

            <!-- Menu -->
            <div class="  h-screen flex flex-col justify-center ">

                <div class="w-full flex font-extrabold lg:mb-14 ml-5">
                    <img src="https://www.inovamedika.com/image/logo-default.png" alt="" class="w-4/5">
                </div>
                <div class="w-full flex font-extrabold ml-6 my-2  ">
                    <a class="text-white  text-xl shadow-2xl " href="{{route('dashboard')}}"><i class='bx bx-male mr-4'></i>Pasien</a>
                </div>
                <div class="w-full flex font-extrabold ml-6 my-2  ">
                    <a class="text-white  text-xl shadow-2xl " href="{{route('employee')}}"><i class='bx bxs-user mr-4'></i>Pegawai</a>
                </div>
                <div class="w-full flex font-extrabold ml-6 my-2  ">
                    <a class="text-white  text-xl shadow-2xl " href="{{route('action')}}"><i class='bx bx-plus-medical mr-4'></i>Tindakan</a>
                </div>
                <div class="w-full flex font-extrabold ml-6 my-2  ">
                    <a class="text-white  text-xl shadow-2xl " href="{{route('medicine')}}"><i class='bx bxs-capsule mr-4'></i>Obat</a>
                </div>
                <div class="w-full flex font-extrabold ml-6 my-2  ">
                    <a class="text-white  text-xl shadow-2xl " href="{{route('region')}}"><i class='bx bxs-pin mr-4'></i>Wilayah</a>
                </div>
                <div class="w-full flex font-extrabold ml-6 mt-32 ">
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="text-white  text-xl shadow-2xl  " href="#"><i class='bx bx-log-out mr-4'></i>Log Out</button>
                    </form>
                </div>
            </div>
            <!-- End Menu -->
        </div>
        <!-- End Sidebar Menu -->
        <div class=" lg:h-full w-full h-screen lg:overflow-y-auto bg-gray-100 ">
            @yield('content')
        </div>


    </div>








    <script>
        const burger = document.getElementById('burger');
        const sidebar = document.getElementById('sidebar');

        burger.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    </script>
    
    
</body>


</html>