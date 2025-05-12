@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ $tutor->user->photo_url }}" class="rounded-circle img-thumbnail mb-3" 
                        alt="{{ $tutor->user->name }}" style="width: 200px; height: 200px; object-fit: cover;">
                    
                    <h3>{{ $tutor->user->name }}</h3>
                    
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <span class="text-warning fs-4 me-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($tutor->average_rating))
                                    <i class="bi bi-star-fill"></i>
                                @elseif($i == ceil($tutor->average_rating) && ($tutor->average_rating - floor($tutor->average_rating) >= 0.5)
                                    <i class="bi bi-star-half"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                        </span>
                        <span class="fs-5">{{ number_format($tutor->average_rating, 1) }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-success fs-5">{{ $tutor->formatted_price }}</span>
                    </div>
                    
                    <div class="d-grid gap-2">
                        @auth
                            @if(auth()->user()->isStudent())
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactModal">
                                    <i class="bi bi-envelope"></i> Написать сообщение
                                </button>
                                
                                @if(!$alreadyReviewed)
                                    <button class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                        <i class="bi bi-pencil"></i> Оставить отзыв
                                    </button>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Войти для связи
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-telephone"></i> Контакты
                </div>
                <div class="card-body">
                    <p><i class="bi bi-envelope"></i> {{ $tutor->user->email }}</p>
                    <p><i class="bi bi-phone"></i> {{ $tutor->user->phone }}</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-book"></i> Предметы
                </div>
                <div class="card-body">
                    @foreach($tutor->subjects as $subject)
                        <span class="badge bg-primary me-1 mb-1">{{ $subject->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-person-lines-fill"></i> О репетиторе
                </div>
                <div class="card-body">
                    <h5 class="card-title">О себе</h5>
                    <p class="card-text">{{ $tutor->about }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5><i class="bi bi-award"></i> Опыт</h5>
                            <p>{{ $tutor->experience_years }} лет преподавания</p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="bi bi-mortarboard"></i> Образование</h5>
                            <p>{{ $tutor->education_level_translated }}</p>
                        </div>
                    </div>
                    
                    @if($tutor->video_presentation)
                        <div class="mt-4">
                            <h5><i class="bi bi-camera-reels"></i> Видеопрезентация</h5>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ getYouTubeId($tutor->video_presentation) }}" 
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-building"></i> Образование
                </div>
                <div class="card-body">
                    @foreach($tutor->educations as $education)
                    <div class="mb-3 pb-3 border-bottom">
                        <h5>{{ $education->institution }}</h5>
                        <p class="mb-1">{{ $education->degree }}, {{ $education->specialization }}</p>
                        <p class="text-muted">Год окончания: {{ $education->year_graduated }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-chat-square-text"></i> Отзывы ({{ $tutor->reviews_count }})</span>
                </div>
                <div class="card-body">
                    @if($tutor->reviews->isEmpty())
                        <p class="text-muted">Пока нет отзывов.</p>
                    @else
                        @foreach($tutor->reviews as $review)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $review->student->name }}</strong>
                                    <span class="text-warning ms-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                </div>
                                <small class="text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                            </div>
                            <p class="mt-2 mb-0">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@auth
@if(auth()->user()->isStudent())
<!-- Modal Contact -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Написать {{ $tutor->user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('tutors.contact', $tutor->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ваше сообщение</label>
                        <textarea class="form-control" name="message" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(!$alreadyReviewed)
<!-- Modal Review -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Оставить отзыв</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('tutors.review', $tutor->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Оценка</label>
                        <select class="form-select" name="rating" required>
                            <option value="5">Отлично</option>
                            <option value="4">Хорошо</option>
                            <option value="3">Удовлетворительно</option>
                            <option value="2">Плохо</option>
                            <option value="1">Очень плохо</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Комментарий</label>
                        <textarea class="form-control" name="comment" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endif
@endauth

@endsection

@push('scripts')
<script>
    // Инициализация модальных окон
    document.addEventListener('DOMContentLoaded', function() {
        const contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
        const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
        
        @if($errors->has('message'))
            contactModal.show();
        @endif
        
        @if($errors->has('rating') || $errors->has('comment'))
            reviewModal.show();
        @endif
    });
</script>
@endpush