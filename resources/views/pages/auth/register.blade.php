<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Daftar | Sistem Peminjaman Ruangan</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div
                    class="col-lg-4 col-md-6 col-12 min-vh-100 d-flex justify-content-center align-items-center bg-whitef">
                    <div class="">
                        <br>
                        <h1 class="text-primary font-weight-bold">Login</h4>
                            <h4 class="font-weight-bold text-dark">
                                Sistem Peminjaman Ruangan
                            </h4>
                            {{-- <p class="text-muted">
                                @if (session('status'))
                                    Password berhasil di ubah silahkan login kembali.
                                @else
                                    Harap login menggunakan email dan password anda.
                                @endif
                            </p> --}}
                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="fullname">FullName</label>
                                    <input id="fullname" type="text" class="form-control" name="fullname" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Pilih Status</label>
                                    <select id="status" class="form-control" name="status" required
                                        onchange="toggleAdditionalInputs()">
                                        <option value="">Pilih Status</option>
                                        <option value="Mahasiswa">Mahasiswa</option>
                                        <option value="Dosen">Dosen</option>
                                    </select>
                                </div>

                                <div class="form-group d-none" id="nim-group">
                                    <label for="nim">NIM</label>
                                    <input id="nim" type="text" class="form-control" name="nim">
                                </div>

                                <div class="form-group d-none" id="nip-group">
                                    <label for="nip">NIP</label>
                                    <input id="nip" type="text" class="form-control" name="nip">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input id="confirm-password" type="password" class="form-control"
                                        name="confirm_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="whatsapp">Nomor WhatsApp</label>
                                    <input id="whatsapp" type="text" class="form-control" name="whatsapp" required>
                                </div>

                                <div class="form-group text-left">
                                    <a href="{{ route('password.request') }}" class="">
                                        Lupa Password?
                                    </a>
                                </div>

                                <div class="d-block bg-danger">
                                    <button class="btn btn-primary btn-lg btn-block">Daftar</button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                            </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 d-none d-md-block"
                    style="background-repeat: no-repeat; background-size: cover"
                    data-background="https://www.darmajaya.ac.id/wp-content/uploads/3-161.jpg">
                </div>
            </div>
        </section>
    </div>

     <!-- General JS Scripts -->
     <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
     <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
     <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
     <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
     <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
     <script src="{{ asset('js/stisla.js') }}"></script>
 
     <!-- Template JS File -->
     <script src="{{ asset('js/scripts.js') }}"></script>
     <script src="{{ asset('js/custom.js') }}"></script>
 
     <!-- Custom Script -->
     <script>
         function toggleAdditionalInputs() {
             const status = document.getElementById('status').value;
             const nimGroup = document.getElementById('nim-group');
             const nipGroup = document.getElementById('nip-group');
 
             if (status === 'Mahasiswa') {
                 nimGroup.classList.remove('d-none');
                 nipGroup.classList.add('d-none');
             } else if (status === 'Dosen') {
                 nipGroup.classList.remove('d-none');
                 nimGroup.classList.add('d-none');
             } else {
                 nimGroup.classList.add('d-none');
                 nipGroup.classList.add('d-none');
             }
         }
     </script>
</body>

</html>
