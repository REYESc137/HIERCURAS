<!-- Footer Section (tonos más suaves) -->
<div class="pt-5 mt-5 container-fluid bg-[#8B4513] text-white-50 footer"> <!-- Marrón tierra para el footer -->
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
            <div class="row g-4">
                <div class="col-lg-3">
                    <a href="#">
                        <img src="{{ asset('assets/img/Hiercura_logo.png') }}" alt="Hiercura" width="70" height="70">
                        <h1 class="mb-0 text-white">Hiercura</h1>
                        <p class="mb-0 text-white-50">Cuidando tu salud, a lo natural</p>
                    </a>
                </div>
                <div class="col-lg-6">
                    @if (Auth::check() && Auth::user()->tipo_user_id != 3)
                    <form action="{{ route('payment')}}" method="post">
                        @csrf
                    <div class="mx-auto position-relative">
                        <input class="px-4 py-3 border-0 form-control w-100 rounded-pill" type="text" disabled
                            placeholder="Suscribete por $20 MXN al mes">
                            <input type="hidden" name="amount" value=20>
                        <button type="submit"
                            class="px-4 py-3 text-white border-0 btn btn-primary bg-[#6B8E23] position-absolute rounded-pill"
                            style="top: 0; right: 0;">Suscribirse</button>
                    </div>
                    </form>
                    @else
                    @if( !Auth::check() || Auth::user()->tipo_user_id != 3)
                    <div class="mx-auto position-relative">
                        <input class="px-4 py-3 border-0 form-control w-100 rounded-pill" type="text" disabled placeholder="Suscribete">
                        <a href="{{ route('login')}}" type="submit"
                            class="px-4 py-3 text-white border-0 btn btn-primary bg-[#6B8E23] position-absolute rounded-pill"
                            style="top: 0; right: 0;">Inicia  Sesión</a>
                    @endif
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>