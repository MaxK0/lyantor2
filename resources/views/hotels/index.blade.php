@extends('layout')

@section('content')
    <main class="main">
        <section class="title__section hotel__section">
            <div class="container">
                <h1>Путеводитель<br> Лянтор</h1>
                <h2>Отели</h2>
            </div>
        </section>

        <section class="filters">
            <div class="container">
                <form method="GET" class="form filter-form">
                    <div class="form__blocks">
                        <input type="text" name="search" class="input"
                               placeholder="Поиск по названию или описанию"
                               value="{{ request('search') }}">

                        <select name="sort_by" class="select">
                            <option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>
                                По рейтингу
                            </option>
                            <option value="popularity" {{ request('sort_by') == 'popularity' ? 'selected' : '' }}>
                                По популярности
                            </option>
                        </select>

                        <select name="sort_order" class="select">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                                По убыванию
                            </option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>
                                По возрастанию
                            </option>
                        </select>

                        <button type="submit" class="filter-btn btn-main">Применить</button>
                    </div>
                </form>
            </div>
        </section>

        <section class="hotels__section">
            <div class="container">
                <div class="attractions">
                    @foreach($hotels as $hotel)
                        <div class="attraction">
                            <div class="attraction__imgs">
                                <svg class="arrow left" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.22236 9.37817L12.5573 4.06567C12.9261 3.69849 13.5223 3.69849 13.8871 4.06567L14.7737 4.94849C15.1424 5.31567 15.1424 5.90942 14.7737 6.2727L10.9961 10.0422L14.7776 13.8079C15.1463 14.175 15.1463 14.7688 14.7776 15.1321L13.8911 16.0188C13.5223 16.386 12.9261 16.386 12.5612 16.0188L7.22628 10.7063C6.85362 10.3391 6.85362 9.74536 7.22236 9.37817Z"
                                        fill="#E8D5D1" />
                                </svg>

                                @if($hotel->images->isNotEmpty())
                                    @foreach($hotel->images as $image)
                                        <img class="attraction__img {{ $loop->first ? 'active' : '' }}"
                                             src="{{ asset('storage/'.$image->image) }}"
                                             alt="{{ $hotel->title }}">
                                    @endforeach
                                @endif

                                <svg class="arrow right" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.7776 10.7063L9.44265 16.0188C9.07391 16.386 8.47765 16.386 8.11283 16.0188L7.22628 15.136C6.85754 14.7688 6.85754 14.175 7.22629 13.8118L11.0039 10.0422L7.22236 6.27661C6.85362 5.90942 6.85362 5.31567 7.22236 4.95239L8.10891 4.06567C8.47765 3.69849 9.07391 3.69849 9.43873 4.06567L14.7737 9.37817C15.1464 9.74536 15.1464 10.3391 14.7776 10.7063Z"
                                        fill="#E8D5D1" />
                                </svg>
                            </div>

                            <div class="attraction__content">
                                <h3>{{ $hotel->title }}</h3>

                                <div class="attraction-rating">
                                    <div class="rating-stars">
                                        @include('partials.rating-stars', [
                                            'rating' => $hotel->reviews_avg_rating ?? 0
                                        ])
                                    </div>
                                </div>

                                <div class="attraction-hotel-info">
                                    <p>★ {{ $hotel->stars }} звезд</p>
                                    <p>📍 {{ $hotel->address }}</p>
                                    <p>📞 {{ $hotel->phone }}</p>
                                </div>

                                <details class="details">
                                    <summary class="details__summary">Подробнее</summary>
                                    <div class="details__content information">
                                        @if($hotel->short_description)
                                            {!! nl2br(e($hotel->short_description)) !!}
                                        @else
                                            Описание отсутствует
                                        @endif
                                    </div>
                                </details>

                                <div class="attraction__btn">
                                    <a href="{{ route('hotels.show', $hotel) }}" class="btn-main">
                                        Узнать больше
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination">
                    {{ $hotels->appends(request()->query())->links() }}
                </div>
            </div>
        </section>
    </main>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll('.attraction__imgs');

        sections.forEach(section => {
            const leftArrow = section.querySelector('.arrow.left');
            const rightArrow = section.querySelector('.arrow.right');
            const images = section.querySelectorAll('.attraction__img');
            let currentIndex = 0;

            function showImage(index) {
                images.forEach((img, i) => {
                    img.classList.toggle('active', i === index);
                });
            }

            leftArrow.addEventListener('click', function () {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(currentIndex);
            });

            rightArrow.addEventListener('click', function () {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(currentIndex);
            });

            showImage(currentIndex);
        });
    });
</script>
