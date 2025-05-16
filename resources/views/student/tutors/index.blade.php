@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Поиск репетиторов</h1>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Фильтры</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('tutors.index') }}">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Предмет</label>
                            <select class="form-select" id="subject" name="subject">
                                <option value="">Все предметы</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                                                        <label class="form-label">Цена за час</label>
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="От" name="price_from" 
                                        value="{{ request('price_from') }}" min="0">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="До" name="price_to" 
                                        value="{{ request('price_to') }}" min="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="experience" class="form-label">Минимальный опыт (лет)</label>
                            <input type="number" class="form-control" id="experience" name="experience" 
                                value="{{ request('experience') }}" min="0">
                        </div>
                        
                        <div class="mb-3">
                            <label for="education_level" class="form-label">Уровень образования</label>
                            <select class="form-select" id="education_level" name="education_level">
                                <option value="">Любой</option>
                                <option value="secondary" {{ request('education_level') == 'secondary' ? 'selected' : '' }}>Среднее</option>
                                <option value="bachelor" {{ request('education_level') == 'bachelor' ? 'selected' : '' }}>Бакалавр</option>
                                <option value="master" {{ request('education_level') == 'master' ? 'selected' : '' }}>Магистр</option>
                                <option value="phd" {{ request('education_level') == 'phd' ? 'selected' : '' }}>Кандидат наук</option>
                                <option value="doctor" {{ request('education_level') == 'doctor' ? 'selected' : '' }}>Доктор наук</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="sort" class="form-label">Сортировка</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="">По умолчанию</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена по возрастанию</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена по убыванию</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>По рейтингу</option>
                                <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>По опыту</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-2">Применить</button>
                        <a href="{{ route('tutors.index') }}" class="btn btn-outline-secondary w-100">Сбросить</a>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-info text-white">Помощь в выборе</div>
                <div class="card-body">
                    <p class="small">Используйте фильтры, чтобы найти идеального репетитора. Обращайте внимание на:</p>
                    <ul class="small">
                        <li>Рейтинг и отзывы</li>
                        <li>Опыт преподавания</li>
                        <li>Образование и квалификацию</li>
                        <li>Стоимость занятий</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            @if($tutors->isEmpty())
                <div class="alert alert-info">
                    По вашим критериям не найдено репетиторов. Попробуйте изменить параметры поиска.
                </div>
            @else
                <div class="row row-cols-1 g-4">
                    @foreach($tutors as $tutor)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="row g-0 h-100">
                                <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                                    <img src="{{ $tutor->user->photo_url }}" class="rounded-circle img-thumbnail" 
                                        alt="{{ $tutor->user->name }}" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body h-100 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="card-title mb-2">
                                                <a href="tutors/{{ $tutor->id }}" class="text-decoration-none">
                                                    {{ $tutor->user->name }}
                                                </a>
                                            </h5>
                                            <span class="badge bg-success fs-6">{{ $tutor->formatted_price }}</span>
                                        </div>
                                        
                                        <div class="mb-2">
                                            @foreach($tutor->subjects as $subject)
                                                <span class="badge bg-primary me-1">{{ $subject->name }}</span>
                                            @endforeach
                                        </div>
                                        
                                        <p class="card-text flex-grow-1">{{ Str::limit($tutor->about, 200) }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <div>
                                                <span class="text-muted me-3">
                                                    <i class="bi bi-person-badge"></i> Опыт: {{ $tutor->experience_years }} лет
                                                </span>
                                                <span class="text-muted">
                                                    <i class="bi bi-mortarboard"></i> {{ $tutor->education_level_translated }}
                                                </span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center">
                                                <span class="text-warning me-1">
                                                    <i class="bi bi-star-fill"></i>
                                                    {{ number_format($tutor->average_rating, 1) }}
                                                </span>
                                                <small class="text-muted">({{ $tutor->reviews_count }} отзывов)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $tutors->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .badge.bg-primary {
        background-color: #0d6efd !important;
    }
    .text-warning {
        color: #ffc107 !important;
    }
</style>
@endpush