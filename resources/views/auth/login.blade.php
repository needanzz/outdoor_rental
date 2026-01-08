<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Outdoor Rental System</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        body {
            /* Gambar Background Alam (Camping) */
            background: url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
        }
        .login-card {
            /* Efek Kaca (Glassmorphism) */
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.5);
        }
        .icon-object {
            border-width: 3px;
        }
    </style>
</head>

<body>

    <div class="page-content">

        <div class="content-wrapper">

            <div class="content d-flex justify-content-center align-items-center">

                <form class="login-form" method="POST" action="{{ route('login') }}" style="width: 100%; max-width: 400px;">
                    @csrf
                    
                    <div class="card mb-0 login-card">
                        <div class="card-body">
                            
                            {{-- LOGO & JUDUL --}}
                            <div class="text-center mb-3">
                                <div class="icon-object border-slate-300 text-slate-300">
                                    <i class="icon-tent"></i>
                                </div>
                                <h5 class="mb-0">Outdoor Rental Login</h5>
                                <span class="d-block text-muted">Masuk ke akun anda untuk memulai</span>
                            </div>

                            {{-- INPUT EMAIL --}}
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- INPUT PASSWORD --}}
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- TOMBOL LOGIN --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Sign in <i class="icon-circle-right2 ml-2"></i>
                                </button>
                            </div>

                            {{-- REGISTER LINK --}}
                            <div class="text-center">
                                <a href="{{ route('register') }}" class="text-slate-600">Belum punya akun? Daftar disini</a>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>