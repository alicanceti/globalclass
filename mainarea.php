<?php
/*
 * Plugin Name: Global Class.
 * Plugin URI: http://www.medyasef.com
 * Description: Global Class tema yapımında size yardımcı olacak fonksiyonlar içerir. Her tema yapışınızda baştan yapmanı gereken şeyleri basite indirger.
 * Favicon ekleme, Logo ekleme, Sitenin alt üst taraflarında gözükecek iletişim bölümlerini içerir. Aynı zamanda yüklendiği anda menu desteği ve bileşen
 * desteği de ekler. Aynı zamanda başka eklentiye ihtiyaç duymadan makale okunma sayısını tutar.
 * Version: 1.0
 * Author: Olkun Mustafa
 * Author URI: http://www.medyasef.com
 */

/*
 * DB kayıt işlemlerinde kullanılacak isimleri global hale getiriyoruz.
 * Bu şekilde sürekli hangi ismin ne şekilde kullanıdğı aramasından kurtulmuş oluyoruz.
 */
define("SOCIAL_THEME_SETTINGS","social_theme_settings");
define("GOOGLE_ANALYTICS_CODE","google_analytics_code");
define("HOME_PAGE_SETTINGS","home_page_settings");
define( "GLOBAL_CLASS_PATH",dirname( __FILE__ ) );

include_once(__DIR__ . "/GlobalView.php");
$global_model       = new GlobalModel();
$global_controller  = new GlobalController($global_model);

/*
 * Öne çıkarılmış görsel adı ve boyutları buradan belirlenecek.
 * 1. eleman öne çıkarılmış görselin adı,
 * 2. ve 3. eleman boyutları,
 * 4. eleman crop nesnesi. (True kırpar)
 */
$size_array_args        = array(
    array("index_page",360,204,true),
    array("category_page",304,304,true),
    array("headlines",252,248,true)
);
/*
 * Sidebarlar ekler.
 */
$widget_array_args      = array(
    array(
        'name'              => 'Genel Sidebar',
        'description'       => 'Tüm alanlarda gözükecek bileşen',
        'id'                => 'karatekeates',
    )
);
/*
 * Menu desteği eklenmiş siteye menu alanları ekler.
 * Sitede farklı yerdelerde farklı menuler kullanmak için kullanılır.
 */
$menu_array_args        = array(
    "header"        => "Birincil Menu",
    "top-menu"      => "Top Menu"
);

/*
 * Admin panele koyulacak tüm formlar buraya koyulacak.
 */
$form_ui            = new FormUi();
$global_view        = new GlobalView($global_controller,$form_ui);
$global_view->settings_defaults($size_array_args,$widget_array_args,$menu_array_args);

/*
 * Sayfaya menu desteği eklemez,
 * Menu desteği eklenmiş sayfaya menuler eklenmesinde yardımcı fonksiyon olarak kullanılır.
 * Menu alanları eklemek için $menu_array_args değişkenini incele.
 */
function nav_menu_ms($menu_array){
    global $global_view;
    $global_view->nav_all_menus($menu_array);
}

/*
 * Sitenin görünen arayüzünde, admin panelden eklenmiş sosyal ağ paylaşım linklerinin
 * Buton halinde görüntülenmesini sağlar.
 */
function social_buttons(){
    global $global_view;
    $global_view->social_button_settings();
}

/*
 * Genellikle sitenin single ve category sayfalarında görüntülenmek üzere tasarlanmış olan,
 * Yazının görüntülenme sayısını ve giriş tarihini geçmiş zaman cinsinden verir.
 */
function blogs_views_data(){
    global $global_view;
    $global_view->blog_views_count_and_data();
}

/*
 * Görüntülenme sayısının halini int değerinde verir.
 */
function blogs_view_count(){
    global $post,$global_controller;
    return $global_controller->get_view_count($post->ID);
}


/*
 * Google Analytics Code ve Web Master Araçları Kodlarının Ototmaitk olarak yerleştirilmesi için kullanılır.
 */
add_action("wp_head","ms_google_analytics_code");
function ms_google_analytics_code(){
    $get_analytics_code     = get_option(GOOGLE_ANALYTICS_CODE);
    if(!empty($get_analytics_code)) echo stripslashes($get_analytics_code);
}

?>