<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Box Icon -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            font-family: 'nunito';
            background-image: url('/images/bg-login.jpg');
            background-size: contain;
        }
    </style>

    <title>Home</title>
</head>
<body>
    <div class="w-full pb-10 px-20 my-5">
        <h1 class="text-center text-3xl mb-5">Daftar Riwayat Perawatan {{Auth::user()->name}} </h1>
        <table class="table table-bordered table-users ">
            <thead class="text-center">
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>KTP</th>
                    <th>Wilayah</th>
                    <th>Tindakan</th>
                    <th>Obat</th>
                    <th>Biaya</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="w-full flex font-extrabold ml-6 mt-32 ">
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="text-xl shadow-2xl  " href="#"><i class='bx bx-log-out mr-4'></i>Log Out</button>
            </form>
        </div>
    </div>






    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script type="text/javascript">
        $(function () {   

            let table = $('.table-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('home') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'identity',
                    name: 'identity'
                },
                {
                    data: 'region',
                    name: 'region'
                },
                {
                    data: 'action',
                    name: 'action'
                },
                {
                    data: 'medicine',
                    name: 'medicine'
                },
                {
                    data: 'total_price',
                    name: 'total_price'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ]
            });
        });
    </script>
</body>
</html>