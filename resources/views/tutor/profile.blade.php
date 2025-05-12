@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Анкета репетитора</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tutor.profile') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="about" class="form-label">О себе</label>
                            <textarea class="form-control @error('about') is-invalid @enderror" id="about" name="about" rows="5" required>{{ old('about', $tutor->about ?? '') }}</textarea>
                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="experience_years" class="form-label">Опыт преподавания (лет)</label>
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" id="experience_years" name="experience_years" value="{{ old('experience_years', $tutor->experience_years ?? '') }}" required>
                                @error('experience_years')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="hourly_rate" class="form-label">Стоимость занятия (руб/час)</label>
                                <input type="number" class="form-control @error('hourly_rate') is-invalid @enderror" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $tutor->hourly_rate ?? '') }}" required>
                                @error('hourly_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
    <label class="form-label">Предметы</label>
    <div id="subjects-container">
        @foreach($subjects as $subject)
            <div class="form-check subject-item">
                <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject{{ $subject->id }}"
                    {{ (is_array(old('subjects')) && in_array($subject->id, old('subjects'))) || (isset($tutor) && $tutor->subjects->contains($subject->id)) ? 'checked' : '' }}>
                <label class="form-check-label" for="subject{{ $subject->id }}">
                    {{ $subject->name }}
                </label>
            </div>
        @endforeach
    </div>
    <input type="text" id="new-subject-name" class="form-control mt-2" placeholder="Новый предмет">
    <button type="button" id="add-subject" class="btn btn-secondary btn-sm mt-2">Добавить предмет</button>
    @error('subjects')
        <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-subject').addEventListener('click', function() {
            const container = document.getElementById('subjects-container');
            const subjectNameInput = document.getElementById('new-subject-name');
            const newName = subjectNameInput.value.trim();
            if (newName === '') {
                alert('Введите название предмета');
                return;
            }

            // Генерируем уникальный id для нового предмета (можно по timestamp)
            const newId = 'new_' + Date.now();

            // Создаем новый элемент чекбокса
            const div = document.createElement('div');
            div.className = 'form-check subject-item';
            div.innerHTML = `
                <input class="form-check-input" type="checkbox" name="new_subjects[]" value="${newName}" id="${newId}" checked>
                <label class="form-check-label" for="${newId}">${newName}</label>
            `;
            container.appendChild(div);

            // Очищаем поле ввода
            subjectNameInput.value = '';
        });
    });
</script>


                        <div class="mb-3">
                            <label for="education_level" class="form-label">Уровень образования</label>
                            <select class="form-control @error('education_level') is-invalid @enderror" id="education_level" name="education_level" required>
                                <option value="secondary" {{ old('education_level', $tutor->education_level ?? '') == 'secondary' ? 'selected' : '' }}>Среднее</option>
                                <option value="bachelor" {{ old('education_level', $tutor->education_level ?? '') == 'bachelor' ? 'selected' : '' }}>Бакалавр</option>
                                <option value="master" {{ old('education_level', $tutor->education_level ?? '') == 'master' ? 'selected' : '' }}>Магистр</option>
                                <option value="phd" {{ old('education_level', $tutor->education_level ?? '') == 'phd' ? 'selected' : '' }}>Кандидат наук</option>
                                <option value="doctor" {{ old('education_level', $tutor->education_level ?? '') == 'doctor' ? 'selected' : '' }}>Доктор наук</option>
                            </select>
                            @error('education_level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video_presentation" class="form-label">Видеопрезентация (ссылка на YouTube)</label>
                            <input type="url" class="form-control @error('video_presentation') is-invalid @enderror" id="video_presentation" name="video_presentation" value="{{ old('video_presentation', $tutor->video_presentation ?? '') }}">
                            @error('video_presentation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Образование</label>
                            <div id="educations-container">
                                @if(old('educations') || (isset($educations) && $educations->count()))
                                    @foreach(old('educations') ?? $educations as $index => $education)
                                    <div class="education-item mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Учебное заведение</label>
                                                <input type="text" class="form-control" name="educations[{{ $index }}][institution]" value="{{ $education['institution'] ?? $education->institution }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Степень</label>
                                                <input type="text" class="form-control" name="educations[{{ $index }}][degree]" value="{{ $education['degree'] ?? $education->degree }}" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label">Специализация</label>
                                                <input type="text" class="form-control" name="educations[{{ $index }}][specialization]" value="{{ $education['specialization'] ?? $education->specialization }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Год окончания</label>
                                                <input type="number" class="form-control" name="educations[{{ $index }}][year_graduated]" value="{{ $education['year_graduated'] ?? $education->year_graduated }}" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-education">Удалить</button>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="education-item mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Учебное заведение</label>
                                                <input type="text" class="form-control" name="educations[0][institution]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Степень</label>
                                                <input type="text" class="form-control" name="educations[0][degree]" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label">Специализация</label>
                                                <input type="text" class="form-control" name="educations[0][specialization]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Год окончания</label>
                                                <input type="number" class="form-control" name="educations[0][year_graduated]" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-education">Удалить</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-education" class="btn btn-secondary btn-sm">Добавить образование</button>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Сохранить профиль</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Добавление нового блока образования
        document.getElementById('add-education').addEventListener('click', function() {
            const container = document.getElementById('educations-container');
            const index = container.querySelectorAll('.education-item').length;
            
            const newEducation = document.createElement('div');
            newEducation.className = 'education-item mb-3 p-3 border rounded';
            newEducation.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Учебное заведение</label>
                        <input type="text" class="form-control" name="educations[${index}][institution]" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Степень</label>
                        <input type="text" class="form-control" name="educations[${index}][degree]" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Специализация</label>
                        <input type="text" class="form-control" name="educations[${index}][specialization]" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Год окончания</label>
                        <input type="number" class="form-control" name="educations[${index}][year_graduated]" required>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-education">Удалить</button>
            `;
            
            container.appendChild(newEducation);
        });
        
        // Удаление блока образования
        document.getElementById('educations-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-education')) {
                const educationItem = e.target.closest('.education-item');
                if (document.querySelectorAll('.education-item').length > 1) {
                    educationItem.remove();
                } else {
                    alert('Должно быть указано хотя бы одно образование');
                }
            }
        });
    });
</script>
@endsection