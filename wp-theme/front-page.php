<?php
/**
 * Front Page Template — NiauMen's Hair LP
 */

$tmpl = get_template_directory_uri();

// ── ACF フィールド取得（未設定時はデフォルト値を使用） ──────────────────────────

$line_url   = esc_url(get_field('line_url') ?: 'https://s.lmes.jp/landing-qr/2009758223-Cub3BzoX?uLand=nDXNhL');
$fv_main    = get_field('fv_main_slides')   ?: null;
$fv_bottom  = get_field('fv_bottom_slides') ?: null;
$fv_right   = get_field('fv_right_slides')  ?: null;
$shop_areas = get_field('shop_areas')        ?: null;

if (!$fv_main) {
    $fv_main = [
        ['image' => $tmpl . '/assets/images/fv-slide-1.jpg'],
        ['image' => $tmpl . '/assets/images/fv-slide-2.jpg'],
        ['image' => $tmpl . '/assets/images/fv-slide-3.jpg'],
    ];
}
if (!$fv_bottom) {
    $fv_bottom = [
        ['image' => $tmpl . '/assets/images/fv-bottom-1.jpg'],
        ['image' => $tmpl . '/assets/images/fv-bottom-2.jpg'],
        ['image' => $tmpl . '/assets/images/fv-bottom-3.jpg'],
    ];
}
if (!$fv_right) {
    $fv_right = [
        ['image' => $tmpl . '/assets/images/fv-right-1.png'],
        ['image' => $tmpl . '/assets/images/fv-right-2.png'],
        ['image' => $tmpl . '/assets/images/fv-right-3.png'],
    ];
}
if (!$shop_areas) {
    $shop_areas = [
        [
            'area_name' => '群馬エリア',
            'area_sub'  => '伊勢崎・太田・高崎',
            'shops'     => [
                ['shop_name' => 'Niau 連取店',                      'shop_image' => $tmpl . '/assets/images/shop-isesaki.jpg',  'shop_address' => '〒372-0818 伊勢崎市連取元町263-4',                                                          'shop_hours' => '10:00〜19:00（最終受付時間）',                         'shop_holiday' => '水曜日', 'shop_phone' => '0270-55-4165'],
                ['shop_name' => 'Niau 太田店',                      'shop_image' => $tmpl . '/assets/images/shop-ota.jpg',      'shop_address' => '〒373-0033 群馬県太田市西本町19-3ドリームワークスビル1階',                             'shop_hours' => '平日10:00〜19:00、土日祝9:00〜18:00（最終受付時間）', 'shop_holiday' => '水曜日', 'shop_phone' => '0276-56-4427'],
                ['shop_name' => 'Niau 高崎店',                      'shop_image' => $tmpl . '/assets/images/shop-takasaki.jpg', 'shop_address' => '〒370-0043 群馬県高崎市高関町368-1',                                                       'shop_hours' => '平日10:00〜19:00、土日祝9:00〜18:00（最終受付時間）', 'shop_holiday' => '水曜日', 'shop_phone' => '0270-29-6379'],
                ['shop_name' => 'Hwyl by Niau',                    'shop_image' => $tmpl . '/assets/images/shop-hwyl.jpg',     'shop_address' => '〒372-0821 群馬県伊勢崎市柴町2869-4',                                                      'shop_hours' => '平日10:00〜19:00、土日祝9:00〜18:00（最終受付時間）', 'shop_holiday' => '水曜日', 'shop_phone' => '0270-61-0084'],
                ['shop_name' => 'リオールバイニアウ(RE:ALL by Niau)', 'shop_image' => $tmpl . '/assets/images/shop-nitta.jpg',    'shop_address' => '〒370-0314 群馬県太田市新田市野井町597－8 Blissabove太田2FC号室',                       'shop_hours' => '平日10:00〜19:00、土日祝9:00〜18:00（最終受付時間）', 'shop_holiday' => '水曜日', 'shop_phone' => '0270-61-0084'],
            ],
        ],
        [
            'area_name' => '東京エリア',
            'area_sub'  => '新宿',
            'shops'     => [
                ['shop_name' => 'Niau 新宿店', 'shop_image' => $tmpl . '/assets/images/shop-shinjuku.jpg', 'shop_address' => '〒160-0023 東京都新宿区西新宿７丁目９−１２ スリーSビル４階', 'shop_hours' => '11:00〜21:00（最終受付 20:00）', 'shop_holiday' => '不定休', 'shop_phone' => '0270-61-0084'],
            ],
        ],
    ];
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="群馬・東京のメンズ専門美容室 NiauMen's Hair。あなたの「似合う」を見つけ、自信を引き出すヘアサロン。">
  <?php wp_head(); ?>
</head>
<body <?php body_class('niau-lp'); ?>>
<?php wp_body_open(); ?>

  <!-- ===== PC FIXED LEFT SIDEBAR ===== -->
  <aside class="sidebar-left" id="sidebarLeft">
    <div class="sidebar-left__logo">
      <img src="<?php echo $tmpl; ?>/assets/images/logo.png" alt="Niauにあう">
    </div>
    <nav class="sidebar-left__nav">
      <a href="#worries">よくあるお悩み</a>
      <a href="#reasons">お悩みの原因</a>
      <a href="#results">Niauの実績</a>
      <a href="#why-choose">NiauMen's Hairが選ばれる理由</a>
      <a href="#hair-catalog">ヘアーカタログ</a>
      <a href="#voices">お客様の声</a>
      <a href="#menu">メニュー・料金</a>
      <a href="#campaign">特別キャンペーンについて</a>
      <a href="#booking">ご予約方法</a>
      <a href="#shops">店舗一覧</a>
      <a href="#faq">よくあるご質問</a>
    </nav>
    <div class="sidebar-left__sns">
      <span>Official HomePage / SNS</span>
      <div class="sidebar-left__sns-icons">
        <a href="https://www.instagram.com/niau_official/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg>
        </a>
        <a href="https://niau.co.jp/" target="_blank" rel="noopener noreferrer" aria-label="Homepage">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1z"/></svg>
        </a>
      </div>
    </div>
  </aside>

  <!-- ===== PC FIXED RIGHT SIDEBAR ===== -->
  <aside class="sidebar-right" id="sidebarRight">
    <div class="sidebar-right__slideshow" id="slideshowRight">
      <div class="sidebar-right__slides">
        <?php foreach ($fv_right as $i => $row) : ?>
          <div class="sidebar-right__slide<?php echo $i === 0 ? ' active' : ''; ?>">
            <img src="<?php echo esc_url($row['image']); ?>" alt="NiauMen's Hair">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </aside>

  <!-- ===== MAIN CONTENT ===== -->
  <main class="main-content" id="mainContent">

    <!-- FV: First View / Hero -->
    <section class="hero" id="hero">
      <div class="hero__header">
        <div class="hero__logo">
          <img src="<?php echo $tmpl; ?>/assets/images/logo.png" alt="Niauにあう">
        </div>
        <span class="hero__badge">大人男性の美容室</span>
      </div>
      <div class="hero__slideshow" id="slideshowMain">
        <div class="hero__slides">
          <?php foreach ($fv_main as $i => $row) : ?>
            <div class="hero__slide<?php echo $i === 0 ? ' active' : ''; ?>">
              <img src="<?php echo esc_url($row['image']); ?>" alt="NiauMen's Hair スライド<?php echo $i + 1; ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="hero__content">
        <h1 class="hero__catch">
          <span class="hero__catch-line1">
            <em class="hero__catch-accent">その髪型</em>
            <span class="hero__catch-sub">本当にあなたに</span>
          </span>
          <span class="hero__catch-main">似合っていますか？</span>
        </h1>
        <p class="hero__desc">群馬・東京のメンズ専門美容室 NiauMen's Hairが、<br>あなたの「似合う」を見つけ、自信を引き出す</p>
      </div>
      <div class="hero__slideshow hero__slideshow--bottom" id="slideshowBottom">
        <div class="hero__slides">
          <?php foreach ($fv_bottom as $i => $row) : ?>
            <div class="hero__slide<?php echo $i === 0 ? ' active' : ''; ?>">
              <img src="<?php echo esc_url($row['image']); ?>" alt="NiauMen's Hair スタイル<?php echo $i + 1; ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="sidebar-right__text">Men's Hair salon Niau</div>
    </section>

  <!-- ===== FIXED CTA BAR ===== -->
  <div class="cta-bar" id="ctaBar">
    <a href="#booking" class="cta-bar__btn cta-bar__btn--counseling">
      無料カウンセリングを予約する
    </a>
    <a href="<?php echo $line_url; ?>" class="cta-bar__btn cta-bar__btn--line">
      <span class="cta-bar__line-icon">
        <img src="<?php echo $tmpl; ?>/assets/images/line-icon2.png" alt="LINE">
      </span>
      無料クーポンを受け取る
    </a>
  </div>

    <!-- SECTION: お悩み -->
    <section class="section worries" id="worries">
      <div class="section__inner">
        <h2 class="worries__title">
          <span class="worries__title-pre">こんな</span><span class="worries__title-key">お悩み</span><br>を抱えていませんか？
        </h2>
        <ul class="worries__list">
          <li class="worries__item" data-animate>
            <span class="worries__check">☑</span>
            <span>美容室に行くたびに「<strong>なんか違う</strong>」と感じる</span>
          </li>
          <li class="worries__item" data-animate>
            <span class="worries__check">☑</span>
            <span>自分に<strong>似合う髪型がわからない</strong></span>
          </li>
          <li class="worries__item" data-animate>
            <span class="worries__check">☑</span>
            <span>雑誌やSNSの髪型を頼んでも、<strong>仕上がりが違う</strong></span>
          </li>
          <li class="worries__item" data-animate>
            <span class="worries__check">☑</span>
            <span>美容室が多すぎて、<strong>どこが自分に合っているか迷う</strong></span>
          </li>
          <li class="worries__item" data-animate>
            <span class="worries__check">☑</span>
            <span><strong>スタイリングの再現ができず</strong>毎朝困っている</span>
          </li>
          <li class="worries__item" data-animate>
            <span class="worries__check">☑</span>
            <span>カウンセリングが短くて、<strong>思いをうまく伝えられない</strong></span>
          </li>
        </ul>
      </div>
    </section>

    <!-- SECTION: 解決 -->
    <section class="section solution" id="solution">
      <div class="section__inner">
        <p class="solution__sub" data-animate>その悩み</p>
        <p class="solution__main" data-animate><span class="solution__brand">NiauMen's Hair</span> なら解決できます</p>
      </div>
    </section>

    <!-- SECTION: お悩みの原因 -->
    <section class="section reasons" id="reasons">
      <div class="section__inner">
        <h2 class="reasons__title" data-animate>
          <strong>「なんか違う」</strong>が続く、<br>本当の理由
        </h2>
        <p class="reasons__desc" data-animate>美容室選びに失敗してしまう理由は、あなたの髪質や顔の個性を<br>深く理解せずに施術が進んでしまうことにあります。</p>
        <div class="reasons__grid">
          <div class="reasons__card" data-animate>
            <div class="reasons__card-icon">
              <img src="<?php echo $tmpl; ?>/assets/images/reasons__card-icon1.png" alt="アイコン">
            </div>
            <p>担当者が変わるたびに<br>スタイルが<br>リセットされる</p>
          </div>
          <div class="reasons__card" data-animate>
            <div class="reasons__card-icon">
              <img src="<?php echo $tmpl; ?>/assets/images/reasons__card-icon2.png" alt="アイコン">
            </div>
            <p>カウンセリングが短く<br>要望を伝えきれない</p>
          </div>
          <div class="reasons__card" data-animate>
            <div class="reasons__card-icon">
              <img src="<?php echo $tmpl; ?>/assets/images/reasons__card-icon3.png" alt="アイコン">
            </div>
            <p>「似合わせ」の提案なく、<br>希望通りに仕上げるだけ</p>
          </div>
          <div class="reasons__card" data-animate>
            <div class="reasons__card-icon">
              <img src="<?php echo $tmpl; ?>/assets/images/reasons__card-icon4.png" alt="アイコン">
            </div>
            <p>自宅でのスタイリング<br>方法を教えてもらえない</p>
          </div>
        </div>
        <p class="reasons__bottom" data-animate>
          <span class="reasons__brand">
            <img src="<?php echo $tmpl; ?>/assets/images/logo-gold.png" alt="Niauにあう">
          </span>は、その「なんか違う」の原因に<br>正面から向き合います。
        </p>
      </div>
    </section>

    <!-- SECTION: 実績 -->
    <section class="section results" id="results">
      <div class="section__inner">
        <p class="results__label" data-animate><span class="label-badge">美容業界が認める</span></p>
        <h2 class="results__title" data-animate>メンズ専門の<span class="results__title-key">実績</span></h2>
        <div class="results__cards">
          <div class="results__card" data-animate>
            <div class="results__card-num"><span class="text-gold num-large">6</span>年連続</div>
            <p class="results__card-text">ホットペッパービューティー<br>アワード受賞</p>
          </div>
          <div class="results__card" data-animate>
            <div class="results__card-label">リピート率</div>
            <div class="results__card-num"><span class="text-gold num-large">95</span>%以上</div>
          </div>
          <div class="results__card" data-animate>
            <div class="results__card-label">口コミ評価</div>
            <div class="results__card-num"><span class="text-gold num-large">4.7</span>以上<span class="results__card-sub">(全店舗平均)</span></div>
          </div>
          <div class="results__card" data-animate>
            <div class="results__card-label">パーマ比率</div>
            <div class="results__card-num"><span class="text-gold num-large">30</span>%超え<span class="results__card-sub">(業界トップクラス)</span></div>
          </div>
        </div>
        <p class="results__note" data-animate>群馬エリア・東京エリアを合わせ、<br>メンズ専門美容室として多くのお客様から支持されています。</p>
      </div>
    </section>

    <!-- SECTION: 選ばれる理由 -->
    <section class="section why-choose" id="why-choose">
      <div class="section__inner">
        <h2 class="why-choose__title" data-animate>
          <span class="why-choose__title-brand">NiauMen's<br>Hair</span>
          <span class="why-choose__title-sub">が選ばれる理由</span>
        </h2>
        <div class="why-choose__item" data-animate>
          <div class="why-choose__item-header">
            <span class="why-choose__num">— 01</span>
          </div>
          <div class="why-choose__image">
            <img src="<?php echo $tmpl; ?>/assets/images/reason-01.jpg" alt="パーマ技術・再現性の高さ">
            <h3 class="why-choose__item-title">パーマ技術・再現性の高さ</h3>
          </div>
          <p class="why-choose__item-desc">パーマ比率平均30%超え。「似合わせ」まで設計できる技術力で、サロンを出た後も同じスタイルを自宅で再現できるよう設計します。雰囲気だけのパーマではなく、あなたの骨格・髪質に合わせた本物の「似合う」を作ります。</p>
        </div>
        <div class="why-choose__item" data-animate>
          <div class="why-choose__item-header why-choose__item-header--left">
            <span class="why-choose__num">02 —</span>
          </div>
          <div class="why-choose__image">
            <img src="<?php echo $tmpl; ?>/assets/images/reason-02.jpg" alt="徹底した似合わせカウンセリング">
            <h3 class="why-choose__item-title">徹底した似合わせカウンセリング</h3>
          </div>
          <p class="why-choose__item-desc">お客様一人ひとりの要望を深くヒアリングし、理想の姿を明確化。過去の施術履歴や普段のスタイリング方法まで丁寧に確認することで、あなたにとって最適なスタイルを導き出します。</p>
        </div>
        <div class="why-choose__item" data-animate>
          <div class="why-choose__item-header">
            <span class="why-choose__num">— 03</span>
          </div>
          <div class="why-choose__image">
            <img src="<?php echo $tmpl; ?>/assets/images/reason-03.jpg" alt="自宅でも扱いやすいスタイル設計">
            <h3 class="why-choose__item-title">自宅でも扱いやすいスタイル設計</h3>
          </div>
          <p class="why-choose__item-desc">サロンの仕上がりで満足して終わりではありません。毎朝のスタイリングが楽になるよう、再現性を最優先にしたスタイル設計を行い、自宅でのセット方法もしっかりお伝えします。</p>
        </div>
        <div class="why-choose__item" data-animate>
          <div class="why-choose__item-header why-choose__item-header--left">
            <span class="why-choose__num">04 —</span>
          </div>
          <div class="why-choose__image">
            <img src="<?php echo $tmpl; ?>/assets/images/reason-04.jpg" alt="安心感のある接客と空間">
            <h3 class="why-choose__item-title">安心感のある接客と空間</h3>
          </div>
          <p class="why-choose__item-desc">声のトーン・距離感・コミュニケーション方法まで、お客様に合わせた接客を徹底。活気がありながらも落ち着ける空間で、初めてのご来店でもリラックスしてお過ごしいただけます。</p>
        </div>
        <div class="why-choose__item" data-animate>
          <div class="why-choose__item-header">
            <span class="why-choose__num">— 05</span>
          </div>
          <div class="why-choose__image">
            <img src="<?php echo $tmpl; ?>/assets/images/reason-05.jpg" alt="アフターカウンセリングと未来設計">
            <h3 class="why-choose__item-title">アフターカウンセリングと未来設計</h3>
          </div>
          <p class="why-choose__item-desc">施術後には、今回の内容の説明と次回のご提案をしっかり共有。「次はいつ来ればいい？」「どんな状態を目指す？」など、理想の髪を長く保つための未来設計まで一緒に考えます。</p>
        </div>
      </div>
    </section>

    <!-- SECTION: Hair Catalog -->
    <section class="section hair-catalog" id="hair-catalog">
      <div class="hair-catalog__header">
        <h2 class="hair-catalog__title">— Hair Catalog</h2>
      </div>
      <div class="hair-catalog__carousel">
        <button class="hair-catalog__arrow hair-catalog__arrow--prev" aria-label="前へ">&#8249;</button>
        <div class="hair-catalog__slides" id="hairCatalogSlides">
          <div class="hair-catalog__slide active">
            <img src="<?php echo $tmpl; ?>/assets/images/catalog-1.png" alt="ヘアカタログ1">
          </div>
          <div class="hair-catalog__slide">
            <img src="<?php echo $tmpl; ?>/assets/images/catalog-2.png" alt="ヘアカタログ2">
          </div>
          <div class="hair-catalog__slide">
            <img src="<?php echo $tmpl; ?>/assets/images/catalog-3.png" alt="ヘアカタログ3">
          </div>
          <div class="hair-catalog__slide">
            <img src="<?php echo $tmpl; ?>/assets/images/catalog-4.png" alt="ヘアカタログ4">
          </div>
          <div class="hair-catalog__slide">
            <img src="<?php echo $tmpl; ?>/assets/images/catalog-5.png" alt="ヘアカタログ5">
          </div>
        </div>
        <button class="hair-catalog__arrow hair-catalog__arrow--next" aria-label="次へ">&#8250;</button>
      </div>
    </section>

    <!-- SECTION: お客様の声 -->
    <section class="section voices" id="voices">
      <div class="section__inner">
        <p class="voices__label" data-animate>来店された</p>
        <h2 class="voices__title" data-animate>お客様の声</h2>
        <div class="voices__list">
          <div class="voices__item" data-animate>
            <div class="voices__quote-block">
              <span class="voices__qopen">&ldquo;</span>
              <p class="voices__headline">落ち着いて<br>施術を受ける事ができました</p>
              <span class="voices__qclose">&rdquo;</span>
            </div>
            <div class="voices__customer">
              <span class="voices__diamond">◆</span>
              <span>Tさん（男性/40代）</span>
              <span class="voices__diamond">◆</span>
            </div>
            <p class="voices__rating">総合 <strong>5</strong> <span class="voices__stars">★★★★★</span></p>
            <p class="voices__review">かなりいいですね。雰囲気も重くなく気取らない内装で落ち着いて施術を受ける事ができました。仕上がりも満足いくものでお任せでも今っぽく垢ぬけて清潔感が出ると思います。次回も宜しくお願いします。</p>
          </div>
          <div class="voices__item" data-animate>
            <div class="voices__quote-block">
              <span class="voices__qopen">&ldquo;</span>
              <p class="voices__headline">非常に満足いく仕上がりでした</p>
              <span class="voices__qclose">&rdquo;</span>
            </div>
            <div class="voices__customer">
              <span class="voices__diamond">◆</span>
              <span>Sさん（男性/30代）</span>
              <span class="voices__diamond">◆</span>
            </div>
            <p class="voices__rating">総合 <strong>5</strong> <span class="voices__stars">★★★★★</span></p>
            <p class="voices__review">カット＆パーマのメニューでお願いしました。オーダーした髪型について自分にあった提案だったりアドバイスを頂き細部への拘りを感じました！非常に満足いく仕上がりでした！お店の雰囲気もよくまた行きたいと思います。</p>
          </div>
          <div class="voices__item" data-animate>
            <div class="voices__quote-block">
              <span class="voices__qopen">&ldquo;</span>
              <p class="voices__headline">丁寧な施術で満足でした</p>
              <span class="voices__qclose">&rdquo;</span>
            </div>
            <div class="voices__customer">
              <span class="voices__diamond">◆</span>
              <span>Tさん（男性/30代）</span>
              <span class="voices__diamond">◆</span>
            </div>
            <p class="voices__rating">総合 <strong>5</strong> <span class="voices__stars">★★★★★</span></p>
            <p class="voices__review">セット方法も丁寧に教えて貰い自分でもチャレンジ出来そうな気がします！またよろしくお願いします！</p>
          </div>
          <div class="voices__item" data-animate>
            <div class="voices__quote-block">
              <span class="voices__qopen">&ldquo;</span>
              <p class="voices__headline">安心してお任せできます</p>
              <span class="voices__qclose">&rdquo;</span>
            </div>
            <div class="voices__customer">
              <span class="voices__diamond">◆</span>
              <span>Nさん（男性/30代）</span>
              <span class="voices__diamond">◆</span>
            </div>
            <p class="voices__rating">総合 <strong>5</strong> <span class="voices__stars">★★★★★</span></p>
            <p class="voices__review">何度も利用していますが、安心してお任せ出来るので助かります。今回のカラーも髪の状態を見て色を決めてくれたのでとても良い仕上がりになり気に入っています！</p>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION: メニュー・料金 -->
    <section class="section menu" id="menu">
      <div class="section__inner">
        <h2 class="menu__title" data-animate>メニュー・料金</h2>
        <p class="menu__subtitle" data-animate>（新規料金）</p>
        <div class="menu__area" data-animate>
          <h3 class="menu__area-title">群馬エリア</h3>
          <p class="menu__area-sub">伊勢崎・太田・高崎</p>
          <table class="menu__table">
            <thead><tr><th>メニュー</th><th>新規料金</th></tr></thead>
            <tbody>
              <tr><td>カット</td><td>¥4,950</td></tr>
              <tr><td>パーマ</td><td>¥9,900〜</td></tr>
              <tr><td>カラー</td><td>¥7,700</td></tr>
              <tr><td>トリートメント</td><td>¥3,850</td></tr>
              <tr><td>アイブロウ</td><td>¥2,750</td></tr>
            </tbody>
          </table>
        </div>
        <div class="menu__area" data-animate>
          <h3 class="menu__area-title">東京エリア</h3>
          <p class="menu__area-sub">新宿</p>
          <table class="menu__table">
            <thead><tr><th>メニュー</th><th>新規料金</th></tr></thead>
            <tbody>
              <tr><td>カット</td><td>¥6,600</td></tr>
              <tr><td>パーマ</td><td>¥9,900〜</td></tr>
              <tr><td>カラー</td><td>¥8,000</td></tr>
              <tr><td>トリートメント</td><td>¥3,850</td></tr>
              <tr><td>アイブロウ</td><td>¥2,750</td></tr>
            </tbody>
          </table>
        </div>
        <div class="menu__coupon" data-animate>
          <img src="<?php echo $tmpl; ?>/assets/images/coupon.png" alt="全メニュー対象の新規クーポンあり">
        </div>
      </div>
    </section>

    <!-- SECTION: キャンペーン -->
    <section class="section campaign" id="campaign">
      <div class="section__inner">
        <div class="campaign__box" data-animate>
          <p class="campaign__pre">今だけ！</p>
          <h2 class="campaign__title">初回限定キャンペーン</h2>
          <ul class="campaign__list">
            <li>✓ 男性限定<span class="text-gold">新規クーポン</span>プレゼント</li>
            <li>✓ 10日間の<span class="text-gold">無料お直し保証</span></li>
            <li>✓ LINEで<span class="text-gold">空き状況確認・相談</span>が気軽にできる</li>
          </ul>
          <p class="campaign__cta-label">＼ LINEで今すぐ ／</p>
          <a href="<?php echo $line_url; ?>" class="campaign__cta-btn" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo $tmpl; ?>/assets/images/line-icon.png" alt="LINE">
            無料クーポンを受け取る
          </a>
          <p class="campaign__note">※ 予告なく終了する場合があります。<br>ご来店後のお直しは適用外となる場合も、おますのでご注意ください。</p>
        </div>
      </div>
      <div class="campaign-right__text">Campaign</div>
    </section>

    <!-- SECTION: ご予約方法 -->
    <section class="section booking" id="booking">
      <div class="section__inner">
        <p class="booking__pre" data-animate>かんたん</p>
        <h2 class="booking__title" data-animate><em class="booking__title-accent">3STEP</em>で予約完了</h2>
        <div class="booking__steps">
          <div class="booking__step" data-animate>
            <div class="booking__step-icon booking__step-icon--line">
              <img src="<?php echo $tmpl; ?>/assets/images/line-icon2.png" alt="LINE">
            </div>
            <p class="booking__step-text">リンクから<br>LINE公式アカウントを<br>友だち追加</p>
          </div>
          <span class="booking__arrow">›</span>
          <div class="booking__step" data-animate data-delay="0.15">
            <div class="booking__step-icon booking__step-icon--coupon">
              <img src="<?php echo $tmpl; ?>/assets/images/ticket-icon.png" alt="チケット">
            </div>
            <p class="booking__step-text">登録後すぐに<br>新規クーポンが届きます</p>
          </div>
          <span class="booking__arrow">›</span>
          <div class="booking__step" data-animate data-delay="0.3">
            <div class="booking__step-icon booking__step-icon--calendar">
              <img src="<?php echo $tmpl; ?>/assets/images/calender.png" alt="カレンダー">
            </div>
            <p class="booking__step-text">LINEの「予約する」ボタン<br>から希望のメニューと<br>日時を選択して完了</p>
          </div>
        </div>
        <p class="booking__note" data-animate>※ お電話でのご予約も承っています</p>
      </div>
    </section>

    <!-- SECTION: 店舗一覧（ACF動的） -->
    <section class="section shops" id="shops">
      <div class="section__inner">
        <h2 class="shops__title" data-animate>店舗一覧</h2>

        <?php foreach ($shop_areas as $area) : ?>
          <h3 class="shops__area-title" data-animate><?php echo esc_html($area['area_name']); ?></h3>
          <?php if (!empty($area['area_sub'])) : ?>
            <p class="shops__area-sub" data-animate><?php echo esc_html($area['area_sub']); ?></p>
          <?php endif; ?>

          <?php foreach ($area['shops'] as $shop) : ?>
            <div class="shops__card" data-animate>
              <?php if (!empty($shop['shop_image'])) : ?>
                <div class="shops__card-image">
                  <img src="<?php echo esc_url($shop['shop_image']); ?>" alt="<?php echo esc_attr($shop['shop_name']); ?>">
                </div>
              <?php endif; ?>
              <h4 class="shops__card-name"><?php echo esc_html($shop['shop_name']); ?></h4>
              <table class="shops__info">
                <?php if (!empty($shop['shop_address'])) : ?>
                  <tr><th>住所</th><td><?php echo esc_html($shop['shop_address']); ?></td></tr>
                <?php endif; ?>
                <?php if (!empty($shop['shop_hours'])) : ?>
                  <tr><th>営業時間</th><td><?php echo esc_html($shop['shop_hours']); ?></td></tr>
                <?php endif; ?>
                <?php if (!empty($shop['shop_holiday'])) : ?>
                  <tr><th>定休日</th><td><?php echo esc_html($shop['shop_holiday']); ?></td></tr>
                <?php endif; ?>
                <?php if (!empty($shop['shop_phone'])) : ?>
                  <tr><th>電話番号</th><td><?php echo esc_html($shop['shop_phone']); ?></td></tr>
                <?php endif; ?>
              </table>
            </div>
          <?php endforeach; ?>
        <?php endforeach; ?>

      </div>
    </section>

    <!-- SECTION: FAQ -->
    <section class="section faq" id="faq">
      <div class="section__inner">
        <h2 class="faq__title" data-animate>よくあるご質問</h2>
        <div class="faq__list">
          <div class="faq__item" data-animate>
            <button class="faq__question" aria-expanded="true">
              <span class="faq__q">Q.</span>
              <span>メンズ専門とのことですが、どんな髪型でも相談できますか？</span>
              <span class="faq__toggle">−</span>
            </button>
            <div class="faq__answer active">
              <p>はい。ビジネス向けの清潔感ヘアから、おしゃれなパーマスタイルまで幅広く対応しています。初回カウンセリングで理想のスタイルをヒアリングしますので、まずはお気軽にご相談ください。</p>
            </div>
          </div>
          <div class="faq__item" data-animate>
            <button class="faq__question" aria-expanded="false">
              <span class="faq__q">Q.</span>
              <span>パーマは初めてなので不安です。</span>
              <span class="faq__toggle">＋</span>
            </button>
            <div class="faq__answer"><p>初めての方でも安心していただけるよう、カウンセリングで薬剤やデザインをしっかりご説明してから施術いたします。お気軽にご相談ください。</p></div>
          </div>
          <div class="faq__item" data-animate>
            <button class="faq__question" aria-expanded="false">
              <span class="faq__q">Q.</span>
              <span>カウンセリングに時間はかかりますか？</span>
              <span class="faq__toggle">＋</span>
            </button>
            <div class="faq__answer"><p>初回は15〜20分程度お時間をいただいています。お客様のライフスタイルやご希望を丁寧にお聞きし、最適なスタイルをご提案いたします。</p></div>
          </div>
          <div class="faq__item" data-animate>
            <button class="faq__question" aria-expanded="false">
              <span class="faq__q">Q.</span>
              <span>仕上がりが気に入らなかった場合はどうなりますか？</span>
              <span class="faq__toggle">＋</span>
            </button>
            <div class="faq__answer"><p>施術後10日以内であれば無料でお直しいたします。お気軽にご連絡ください。</p></div>
          </div>
          <div class="faq__item" data-animate>
            <button class="faq__question" aria-expanded="false">
              <span class="faq__q">Q.</span>
              <span>ホットペッパービューティー以外でも予約できますか？</span>
              <span class="faq__toggle">＋</span>
            </button>
            <div class="faq__answer"><p>はい、LINE公式アカウントやお電話でもご予約を承っています。お気軽にお問い合わせください。</p></div>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer" id="footer">
      <div class="footer__inner">
        <h3 class="footer__brand">NiauMen's Hair</h3>
        <p class="footer__sub">メンズ専門美容室｜群馬・東京</p>
        <nav class="footer__nav">
          <a href="https://niau.co.jp/" target="_blank" rel="noopener noreferrer">公式サイト</a>
          <a href="https://niau.co.jp/privacy-policy" target="_blank" rel="noopener noreferrer">プライバシーポリシー</a>
          <a href="https://www.instagram.com/niau_official/" target="_blank" rel="noopener noreferrer">Instagram</a>
        </nav>
        <p class="footer__copy">&copy; NiauMen's Hair All Rights Reserved.</p>
      </div>
    </footer>

  </main>

<?php wp_footer(); ?>
</body>
</html>
