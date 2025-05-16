@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <!-- Tutor Profile Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Мой профиль</h5>
                </div>
                <div class="card-body">
                    @if($tutor->photo)
                        <img src="{{ asset('storage/' . $tutor->photo) }}" class="rounded-circle mb-3" width="120" height="120" alt="Фото профиля">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-secondary"></i>
                        </div>
                    @endif
                    
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ $tutor->education_level }}</p>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Опыт:</span>
                        <strong>{{ $tutor->experience_years }} {{ trans_choice('год|года|лет', $tutor->experience_years) }}</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ставка:</span>
                        <strong>{{ $tutor->hourly_rate }} ₽/час</strong>
                    </div>
                    
                    <a href="{{ route('tutor.profile') }}" class="btn btn-outline-primary btn-block mt-3">
                        <i class="fas fa-edit"></i> Редактировать профиль
                    </a>
                </div>
            </div>
            
            <!-- Subjects Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Мои предметы</h5>
                </div>
                <div class="card-body">
                    @if($tutor->subjects->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($tutor->subjects as $subject)
                                <li class="list-group-item">{{ $subject->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Вы еще не добавили предметы</p>
                        <a href="{{ route('tutor.profile') }}" class="btn btn-sm btn-outline-primary">Добавить предметы</a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Statistics Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Статистика</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="text-primary">24</h2>
                                    <p class="text-muted mb-0">Занятий проведено</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="text-primary">4.8</h2>
                                    <p class="text-muted mb-0">Средний рейтинг</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="text-primary">5</h2>
                                    <p class="text-muted mb-0">Постоянных учеников</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Reviews -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Последние отзывы</h5>
                    <a href="#" class="text-white">Все отзывы</a>
                </div>
                <div class="card-body">
                    @if($reviews->count() > 0)
                        <div class="list-group">
                            @foreach($reviews as $review)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0">{{ $review->student->name }}</h6>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-empty' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $review->comment }}</p>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">У вас пока нет отзывов</p>
                    @endif
                </div>
            </div>
            
            <!-- Upcoming Lessons -->
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ближайшие занятия</h5>
                    <a href="#" class="text-white">Все занятия</a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Математика</h6>
                                    <small class="text-muted">Иван Петров</small>
                                </div>
                                <div class="text-right">
                                    <div class="text-primary">Завтра, 15:00</div>
                                    <small class="text-muted">1 час 30 мин</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Физика</h6>
                                    <small class="text-muted">Анна Сидорова</small>
                                </div>
                                <div class="text-right">
                                    <div class="text-primary">Послезавтра, 18:00</div>
                                    <small class="text-muted">1 час</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    
    .list-group-item:first-child {
        border-top: none;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endpush