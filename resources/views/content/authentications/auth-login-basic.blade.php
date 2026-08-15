@extends('layouts/blankLayout')

@section('title', 'Iniciar Sesión')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-heading fw-bold"
                                    style="text-align: center;">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>

                        <p class="mb-6" style="text-align: center;">Por favor inicie sesión para comenzar</p>

                        <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="user" class="form-label">Usuario</label>
                                <input type="text" class="form-control @error('user') is-invalid @enderror" id="user"
                                    name="user" value="{{ old('user') }}" placeholder="Ingrese su usuario" autofocus />
                                @error('user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Contraseña</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit" id="btn-submit">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <span id="btn-text">Iniciar Sesión</span>
                                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none ms-2"
                                            role="status" aria-hidden="true"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const btnSubmit = document.getElementById('btn-submit');
            const btnText = document.getElementById('btn-text');
            const btnSpinner = document.getElementById('btn-spinner');

            if (form && btnSubmit) {
                form.addEventListener('submit', function () {
                    btnSubmit.disabled = true;
                    btnText.textContent = 'Cargando...';
                    btnSpinner.classList.remove('d-none');
                });
            }
        });
    </script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Acceso',
                    text: "{{ $errors->first() }}",
                    confirmButtonColor: '#696cff',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });
        </script>
    @endif
@endsection