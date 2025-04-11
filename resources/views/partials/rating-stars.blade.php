@php
    $rating = min(5, max(0, $rating));
    $fullStars = floor($rating);
    $halfStar = ceil($rating - $fullStars);
@endphp

<div class="rating-stars">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $fullStars)
            <i class="fa-solid fa-star"></i>
        @elseif($i == $fullStars + 1 && $halfStar)
            <i class="fa-solid fa-star-half"></i>
        @else
            <i class="fa-regular fa-star"></i>
        @endif
    @endfor
</div>
