<?php
include_once(__DIR__ . "/GlobalView/GeneralSettings.php");
include_once(__DIR__ . "/GlobalView/SocialButtons.php");
include_once(__DIR__ . "/GlobalView/WebMasterTools.php");
include_once(__DIR__ . "/GlobalView/ViewCount.php");


class GlobalView {
    private $size_array,$widgets_array,$menu_array;

    function __construct() {
        add_action("admin_menu",array(&$this,"global_theme_settings"));
        add_action("after_setup_theme",array(&$this,"advanced_settings"));
        add_action("init",array(&$this,"add_global_style"));
    }

    public function add_global_style(){
        wp_register_style("add-global-style",plugins_url("globalclass.css",__FILE__));
        wp_enqueue_style("add-global-style");
    }

    public function settings_defaults($size_array,$widgets_array,$menu_array) {
        $this->size_array       = $size_array;
        $this->widgets_array    = $widgets_array;
        $this->menu_array       = $menu_array;
    }
    /*
     * Temanın gelişmiş özelliklerinin eklenmesini sağlar.
     * Her tema yapışımızda tekrar tekrar öne çıkarılmış görsel, bir adet menu, bileşen özelliklerini eklemek yerine
     * Globalclass yüklendiği anda bu özellikler eklenmiş olur.
     *
     */
    public function advanced_settings(){
        //Öne çıkarılmış görsel özelliği ekler.
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'post-formats', array( 'video' ) );
        set_post_thumbnail_size( 360, 360, true);
        /*
        * size_array içinde yine diziler gelir.
        * Gelen dizilerde yeni eklenecek image sizeların, ismi ve boyutları gelir.
        */
        if($this->size_array != 0) {
            foreach($this->size_array as $sizes) {
                add_image_size($sizes[0],$sizes[1],$sizes[2],$sizes[3]);
            }
        }
        /*
         * Bileşen Desteği ekler.
         * Dizi şeklinde gelen bileşen bilgilerini bileşene çevirir.
         */
        if (function_exists('register_sidebar')){
            foreach($this->widgets_array as $widgets){
                register_sidebar(array(
                    'name'              => $widgets["name"],
                    'description'       => $widgets["description"],
                    'id'                => $widgets["id"],
                    'class'             => "sidebar",
                    'before_title'      => '<h4>',
                    'after_title'       => '</h4>',
                    'before_widget'     => '<aside class="aside">',
                    'after_widget'      => '</aside>'
                ));
            }
        }
        /*
         * Menu Desteği ekler.
         */
        register_nav_menus(
            $this->menu_array
        );
    }

    /*
     * Menu ekleme fonksiyonu.
     */
    public function nav_all_menus($menu_defaults) {
        $nav_menu_args = array(
            'theme_location'  => $menu_defaults[0],
            'container'       => $menu_defaults[1],
            'menu_class'      => $menu_defaults[2],
            'menu_id'         => $menu_defaults[3],
            'echo'            => true,
        );
        wp_nav_menu( $nav_menu_args );
    }

    /*
     * Bütün web sitelerinde kullandığımız, telefon, mail adresi, adres gibi header ayarlarını,
     * Footer da gösterilecek yazı, Gösterilecek logo gibi ayarlarını,
     * Kullanıcının sosyal medya hesaplarını yönetmemizi imkan sağlar.
     */
    private function global_theme_settings_defaults() {
        $menu = array(
            'page_title'    => "Genel Tema Ayarları",
            'menu_title'    => "Tema Ayarları",
            'capability'    => 'edit_theme_options',
            'menu_slug'     => 'theme-options',
            'callback'      => array(&$this,"global_theme_settings_ui")
        );
        return $menu;
    }

    public function global_theme_settings(){
        $get_menu_options   = $this->global_theme_settings_defaults();
        add_theme_page(
            $get_menu_options["page_title"],
            $get_menu_options["menu_title"],
            $get_menu_options["capability"],
            $get_menu_options["menu_slug"],
            $get_menu_options["callback"]
        );
    }

    /*
     * Ayarlar sayfasında tab menulerin çıkmasını sağlar.
     */
    private function theme_settings_tab_menu( $current ) {
        $tabs = array(
            'homepage'              => 'Genel Site Ayarları',
            'social'                => 'Sosyal Medya Ayarları',
            'img_settings'          => 'Logo ve Favicon',
            "seo_tools"             => "Seo Araçları"
        );
        echo '<div id="icon-themes" class="icon32"><br></div>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ):
            $class = ( $tab == $current ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='?page=theme-options&tab=$tab'>$name</a>";
        endforeach;
        echo '</h2>';
    }

    public function global_theme_settings_ui(){
        $tab_page = (isset($_GET["tab"])) ? $_GET["tab"]  : "homepage";
        $this->theme_settings_tab_menu($tab_page);

        switch($tab_page) {
            case("homepage"):
                general_settings_ui();
                break;
            case("social"):
                social_settings_ui();
                break;
            case("img_settings"):
                break;
            case("seo_tools"):
                wm_tools_func();
                break;
            default:
                break;
        }
    }


    /****************** Site Ön Yüzünde Yapılacak Değişiklikler Burada Kodlanacak ******************/

    public function social_button_settings(){
        social_settings_site();
    }
}
?>