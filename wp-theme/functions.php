<?php
/**
 * Niau LP Theme — functions.php
 */

// ── テーマサポート ────────────────────────────────────────────────────────────
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['style', 'script']);
});

// ── WordPressデフォルトスタイルを除去（LP専用） ────────────────────────────────
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
}, 20);

// ── LP アセット読み込み ────────────────────────────────────────────────────────
add_action('wp_enqueue_scripts', function () {
    $ver  = '1.0.0';
    $tmpl = get_template_directory_uri();

    // Google Fonts
    wp_enqueue_style(
        'niau-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Noto+Sans+JP:wght@400;500;700;900&display=swap',
        [],
        null
    );

    // LP スタイルシート
    wp_enqueue_style('niau-lp', $tmpl . '/assets/css/style.css', ['niau-fonts'], $ver);

    // GSAP
    wp_enqueue_script('gsap',    'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',             [], null, true);
    wp_enqueue_script('gsap-st', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',    ['gsap'], null, true);

    // LP メインJS
    wp_enqueue_script('niau-lp-main', $tmpl . '/assets/js/main.js', ['gsap-st'], $ver, true);
});

// ── ACF ローカルフィールドグループ ───────────────────────────────────────────────
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'   => 'group_niau_lp',
        'title' => 'LPページ設定',
        'fields' => [

            // ── FV メインスライド ──────────────────────────────────────────
            [
                'key'          => 'field_fv_main_slides',
                'label'        => 'FV メインスライド画像',
                'name'         => 'fv_main_slides',
                'type'         => 'repeater',
                'instructions' => 'ファーストビュー中央のスライド画像（推奨：3枚）',
                'min'          => 1,
                'max'          => 6,
                'layout'       => 'block',
                'button_label' => '＋ 画像を追加',
                'sub_fields'   => [
                    [
                        'key'           => 'field_fv_main_slide_img',
                        'label'         => '画像',
                        'name'          => 'image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'medium',
                    ],
                ],
            ],

            // ── FV ボトムスライド ──────────────────────────────────────────
            [
                'key'          => 'field_fv_bottom_slides',
                'label'        => 'FV ボトムスライド画像',
                'name'         => 'fv_bottom_slides',
                'type'         => 'repeater',
                'instructions' => 'ファーストビュー下部のスライド画像（推奨：3枚）',
                'min'          => 1,
                'max'          => 6,
                'layout'       => 'block',
                'button_label' => '＋ 画像を追加',
                'sub_fields'   => [
                    [
                        'key'           => 'field_fv_bottom_slide_img',
                        'label'         => '画像',
                        'name'          => 'image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'medium',
                    ],
                ],
            ],

            // ── FV サイドバー右スライド ────────────────────────────────────
            [
                'key'          => 'field_fv_right_slides',
                'label'        => 'FV サイドバー右スライド画像',
                'name'         => 'fv_right_slides',
                'type'         => 'repeater',
                'instructions' => 'PC表示時、右サイドに表示されるスライド画像（推奨：3枚）',
                'min'          => 1,
                'max'          => 6,
                'layout'       => 'block',
                'button_label' => '＋ 画像を追加',
                'sub_fields'   => [
                    [
                        'key'           => 'field_fv_right_slide_img',
                        'label'         => '画像',
                        'name'          => 'image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'medium',
                    ],
                ],
            ],

            // ── LINE 遷移先 URL ────────────────────────────────────────────
            [
                'key'           => 'field_line_url',
                'label'         => 'LINE 遷移先 URL',
                'name'          => 'line_url',
                'type'          => 'url',
                'instructions'  => '「無料クーポンを受け取る」ボタンのリンク先 LINE URL を入力してください。',
                'default_value' => 'https://s.lmes.jp/landing-qr/2009758223-Cub3BzoX?uLand=nDXNhL',
                'placeholder'   => 'https://s.lmes.jp/...',
            ],

            // ── 店舗一覧 ───────────────────────────────────────────────────
            [
                'key'          => 'field_shop_areas',
                'label'        => '店舗一覧',
                'name'         => 'shop_areas',
                'type'         => 'repeater',
                'instructions' => 'エリアごとに店舗情報を入力してください。',
                'layout'       => 'block',
                'button_label' => '＋ エリアを追加',
                'sub_fields'   => [
                    [
                        'key'         => 'field_area_name',
                        'label'       => 'エリア名',
                        'name'        => 'area_name',
                        'type'        => 'text',
                        'placeholder' => '例：群馬エリア',
                        'required'    => 1,
                    ],
                    [
                        'key'         => 'field_area_sub',
                        'label'       => 'エリアサブテキスト',
                        'name'        => 'area_sub',
                        'type'        => 'text',
                        'placeholder' => '例：伊勢崎・太田・高崎',
                    ],
                    [
                        'key'          => 'field_shops',
                        'label'        => '店舗',
                        'name'         => 'shops',
                        'type'         => 'repeater',
                        'layout'       => 'block',
                        'button_label' => '＋ 店舗を追加',
                        'sub_fields'   => [
                            [
                                'key'      => 'field_shop_name',
                                'label'    => '店舗名',
                                'name'     => 'shop_name',
                                'type'     => 'text',
                                'required' => 1,
                            ],
                            [
                                'key'           => 'field_shop_image',
                                'label'         => '店舗画像',
                                'name'          => 'shop_image',
                                'type'          => 'image',
                                'return_format' => 'url',
                                'preview_size'  => 'medium',
                            ],
                            [
                                'key'   => 'field_shop_address',
                                'label' => '住所',
                                'name'  => 'shop_address',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_shop_hours',
                                'label' => '営業時間',
                                'name'  => 'shop_hours',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_shop_holiday',
                                'label' => '定休日',
                                'name'  => 'shop_holiday',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_shop_phone',
                                'label' => '電話番号',
                                'name'  => 'shop_phone',
                                'type'  => 'text',
                            ],
                        ],
                    ],
                ],
            ],

        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'menu_order'      => 0,
    ]);
});
