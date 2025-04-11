@extends('layout')

@section('content')
    <main class="main">
        <section class="attraction-detail">
            <div class="container">

                <!-- Карусель изображений (3 в ряд) -->
                <div class="image-gallery">
                    <div class="gallery-container">
                        @if($hotel->images->count() > 3)
                            <button class="gallery-arrow prev" aria-label="Previous image">
                                <svg viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.22236 9.37817L12.5573 4.06567C12.9261 3.69849 13.5223 3.69849 13.8871 4.06567L14.7737 4.94849C15.1424 5.31567 15.1424 5.90942 14.7737 6.2727L10.9961 10.0422L14.7776 13.8079C15.1463 14.175 15.1463 14.7688 14.7776 15.1321L13.8911 16.0188C13.5223 16.386 12.9261 16.386 12.5612 16.0188L7.22628 10.7063C6.85362 10.3391 6.85362 9.74536 7.22236 9.37817Z" fill="#E8D5D1"/>
                                </svg>
                            </button>
                        @endif

                        <div class="gallery-grid">
                            @foreach($hotel->images as $image)
                                <div class="gallery-item">
                                    <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $hotel->title }}">
                                </div>
                            @endforeach
                        </div>

                        @if($hotel->images->count() > 3)
                            <button class="gallery-arrow next" aria-label="Next image">
                                <svg viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.7776 10.7063L9.44265 16.0188C9.07391 16.386 8.47765 16.386 8.11283 16.0188L7.22628 15.136C6.85754 14.7688 6.85754 14.175 7.22629 13.8118L11.0039 10.0422L7.22236 6.27661C6.85362 5.90942 6.85362 5.31567 7.22236 4.95239L8.10891 4.06567C8.47765 3.69849 9.07391 3.69849 9.43873 4.06567L14.7737 9.37817C15.1464 9.74536 15.1464 10.3391 14.7776 10.7063Z" fill="#E8D5D1"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Основная информация -->
                <div class="attraction-info">
                    <h1 class="attraction-title">{{ $hotel->title }}</h1>

                    <!-- Кол-во звезд -->
                    <div>
                        <h3>Количество звезд:</h3>
                        <p>{{ $hotel->stars }}</p>
                    </div>

                    <div>
                        <h3>Количество комнат:</h3>
                        <p>{{ $hotel->rooms }}</p>
                    </div>

                    <!-- Адрес -->
                    <div class="address">
                        <h3>Адрес:</h3>
                        <p>{{ $hotel->address ?? 'Адрес отсутствует' }}</p>
                    </div>

                    <!-- Описание -->
                    <div class="description">
                        <h3>Описание:</h3>
                        <p class="information">{{ nl2br(e($hotel->description)) ?? 'Описание отсутствует' }}</p>
                    </div>

                    <div class="hotel-contacts">
                        <h3>Контактная информация:</h3>
                        <p><strong>Телефон:</strong> {{ $hotel->phone ?? '-' }}</p>
                        <p><strong>Почта:</strong> {{ $hotel->email ?? '-' }}</p>
                        <p><strong>Сайт:</strong> {{ $hotel->site ?? '-' }}</p>
                    </div>

                    <!-- Рейтинг -->
                    <div class="rating-section">
                        <h3>Рейтинг:</h3>
                        <div class="average-rating">
                            @include('partials.rating-stars', ['rating' => $hotel->reviews_avg_rating])
                            <span class="rating-value">{{ number_format($hotel->reviews_avg_rating, 1) }}/5</span>
                        </div>
                        <p>На основе {{ $hotel->reviews_count ?? 0 }} отзывов</p>
                    </div>
                </div>

                <!-- Отзывы -->
                <div class="reviews-section">
                    <h2>Отзывы посетителей</h2>

                    <!-- Форма добавления отзыва -->
                    <div class="review-form">
                        <form id="reviewForm" action="{{ route('hotels.review') }}" method="POST">
                            @csrf
                            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                            <div class="form-group review-form-rating">
                                <label>Ваша оценка:</label>
                                <div class="rating-input">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                                        <label for="star{{ $i }}">★</label>
                                    @endfor
                                </div>
                                @error('rating')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" class="input review-input" name="name" placeholder="Имя" required>
                                @error('name')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <textarea name="comment" class="input review-input" placeholder="Ваш отзыв..." required></textarea>
                                @error('comment')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            @error('message')
                            <p class="error">{{ $message }}</p>
                            @enderror

                            <button type="submit" class="btn-main">Оставить отзыв</button>
                        </form>
                    </div>

                    <!-- Список отзывов -->
                    <div class="reviews-list">
                        @foreach($reviews as $review)
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-rating">
                                        @include('partials.rating-stars', ['rating' => $review->rating])
                                    </div>
                                    <span class="review-date">{{ $review->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <p class="review-comment">{{ $review->comment }}</p>
                            </div>
                        @endforeach

                        <!-- Пагинация -->
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const galleries = document.querySelectorAll('.gallery-container');

        galleries.forEach(gallery => {
            const grid = gallery.querySelector('.gallery-grid');
            const prevBtn = gallery.querySelector('.gallery-arrow.prev');
            const nextBtn = gallery.querySelector('.gallery-arrow.next');

            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', () => {
                    grid.scrollBy({ left: -grid.offsetWidth, behavior: 'smooth' });
                });

                nextBtn.addEventListener('click', () => {
                    grid.scrollBy({ left: grid.offsetWidth, behavior: 'smooth' });
                });
            }
        });
    });
</script>
