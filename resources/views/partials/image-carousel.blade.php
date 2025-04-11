<div class="attraction__imgs">
    <svg class="arrow left" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M7.22236 9.37817L12.5573 4.06567C12.9261 3.69849 13.5223 3.69849 13.8871 4.06567L14.7737 4.94849C15.1424 5.31567 15.1424 5.90942 14.7737 6.2727L10.9961 10.0422L14.7776 13.8079C15.1463 14.175 15.1463 14.7688 14.7776 15.1321L13.8911 16.0188C13.5223 16.386 12.9261 16.386 12.5612 16.0188L7.22628 10.7063C6.85362 10.3391 6.85362 9.74536 7.22236 9.37817Z"
            fill="#E8D5D1" />
    </svg>

    @if($images->isNotEmpty())
        @foreach($images as $image)
            <img class="attraction__img {{ $loop->first ? 'active' : '' }}"
                 src="{{ asset('storage/'.$image->image) }}"
                 alt="{{ $title }}">
        @endforeach
    @endif

    <svg class="arrow right" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M14.7776 10.7063L9.44265 16.0188C9.07391 16.386 8.47765 16.386 8.11283 16.0188L7.22628 15.136C6.85754 14.7688 6.85754 14.175 7.22629 13.8118L11.0039 10.0422L7.22236 6.27661C6.85362 5.90942 6.85362 5.31567 7.22236 4.95239L8.10891 4.06567C8.47765 3.69849 9.07391 3.69849 9.43873 4.06567L14.7737 9.37817C15.1464 9.74536 15.1464 10.3391 14.7776 10.7063Z"
            fill="#E8D5D1" />
    </svg>
</div>

@push('scripts')
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
@endpush
