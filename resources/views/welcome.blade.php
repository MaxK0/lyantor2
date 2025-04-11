@extends('layout')

@section('content')
    <section id="about" class="section">
        <div class="container">
            <h2 class="section-title">О городе</h2>
            <div class="grid-2">
                <div>
                    <p>Лянтор – единственный город и самый крупный населённый пункт Сургутского района. Расположен в зоне северной тайги на левом берегу реки Пим в месте впадения в неё реки Вачим-Ягун.</p>
                    <p>Находится в 95 км к северо-западу от Сургута и в 485 км от Ханты-Мансийска.</p>
                </div>
                <div class="about-smth">
                    <p><strong>Население:</strong> 42,329 тыс. человек, включая 381 представителя коренных народов.</p>
                    <p><strong>Градообразующее предприятие:</strong> НГДУ «Лянторнефть» ПАО «Сургутнефтегаз».</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="section-title">Символика города</h2>
            <div class="symbols-container">
                <div class="symbol-card">
                    <img src="{{ asset('/img/lyantor_gerb.png') }}" alt="Герб Лянтора">
                    <h3>Герб</h3>
                    <p>Основа герба – прямоугольный щит с фигурной линией. В центре – медведь на фоне серебряной полусферы, олицетворяющий гору.</p>
                </div>
                <div class="symbol-card">
                    <img src="{{ asset('/img/lyantor_flag.png') }}" alt="Флаг Лянтора">
                    <h3>Флаг</h3>
                    <p>По утвержденным в России правилам флаг точно повторяет герб. Дата принятия символики – 26.10.2006 г.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="section-title">История города</h2>
            <p>Река Пим своими изгибами напоминает очертания валенка, который в Сибири в старину называли пимом, что и дало имя реке, а затем и поселку.</p>
            <p>В 70-х годах было открыто крупное месторождение нефти, названное по красивому озеру – Лент-тора ("Снежное озеро" с хантыйского). В 1992 году поселок получил статус города.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="section-title">Контакты</h2>
            <div class="contact-info">
                <p><strong>Телефон:</strong> 8 (34638) 64-001</p>
                <p><strong>Почта:</strong> AdmLyantor@mail.ru</p>
                <p><strong>Официальный сайт:</strong> <a href="http://www.AdmLyantor.ru" style="color: var(--color-active);">www.AdmLyantor.ru</a></p>
            </div>
        </div>
    </section>
@endsection
