@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section vh-100 d-flex align-items-center ">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-3 fw-bold mb-4">
                    <span class="text-gradient">Освойте</span> любой предмет
                    <span class="d-block">с лучшими репетиторами</span>
                </h1>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 rounded-pill">
                        Начать бесплатно
                    </a>
                    @else
                    <a href="{{ auth()->user()->isTutor() ? route('tutor.dashboard') : route('student.tutors.index') }}" 
                       class="btn btn-outline-dark btn-lg px-5 rounded-pill">
                        Перейти в кабинет
                    </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="hero-illustration position-relative">
                    <div class="circle-blur"></div>
                    <img src="/public/images/main.webp" 
                         class="img-fluid position-relative rounded-3" 
                         alt="Обучение">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card p-4 rounded-4 shadow-sm">
                    <div class="icon-box  mb-3">
                        <i class="bi bi-person-check fs-2"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Эксперты</h3>
                    <p>Преподаватели с подтвержденной квалификацией и опытом</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 rounded-4 shadow-sm">
                    <div class="icon-box  mb-3">
                        <i class="bi bi-clock-history fs-2"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Гибкий график</h3>
                    <p>Выбирайте удобное время для занятий 24/7</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 rounded-4 shadow-sm">
                    <div class="icon-box  mb-3">
                        <i class="bi bi-currency-exchange fs-2"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Цены от 500₽</h3>
                    <p>Доступные варианты для любого бюджета</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Subject Carousel -->
<section class="py-5">
    <div class="container">
        <h2 class="display-5 fw-bold text-center mb-5">Выберите предмет</h2>
        <div class="row g-4">
            @foreach(['Математика', 'Физика', 'Химия', 'Программирование', 'Английский', 'История'] as $subject)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="#" class="subject-card d-block text-center p-3 rounded-3 text-decoration-none">
                    <div class="subject-icon mb-3 mx-auto">
                        <i class="bi bi-calculator fs-1"></i>
                    </div>
                    <span class="fw-medium">{{ $subject }}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="display-4 fw-bold">10K+</div>
                <div class="text-muted">Учеников</div>
            </div>
            <div class="col-md-3">
                <div class="display-4 fw-bold">950+</div>
                <div class="text-muted">Репетиторов</div>
            </div>
            <div class="col-md-3">
                <div class="display-4 fw-bold">99%</div>
                <div class="text-muted">Удовлетворенности</div>
            </div>
            <div class="col-md-3">
                <div class="display-4 fw-bold">24/7</div>
                <div class="text-muted">Поддержка</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Начните обучение сегодня</h2>
        <p class="lead mb-4">Первое занятие бесплатно!</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 rounded-pill">
            Попробовать бесплатно
        </a>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .text-gradient {
        background: linear-gradient(45deg, #0d6efd, #00b4d8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .hero-illustration {
        transform: rotate(3deg);
    }
    
    .circle-blur {
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(rgba(13, 110, 253, 0.1), transparent 70%);
        filter: blur(80px);
        z-index: 0;
    }
    
    .feature-card {
        transition: transform 0.3s ease;
        background: white;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
    }
    
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    
    .subject-card {
        transition: all 0.3s ease;
        color: var(--bs-dark);
        background: rgba(13, 110, 253, 0.05);
    }
    
    .subject-card:hover {
        background: rgba(13, 110, 253, 0.1);
        transform: scale(1.05);
    }
    
    .subject-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 50%;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
</style>
@endpush