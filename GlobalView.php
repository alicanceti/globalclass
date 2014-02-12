<?php
include_once(__DIR__ . "/GlobalModel.php");
include_once(__DIR__ . "/GlobalController.php");
include_once(__DIR__ . "/FormUi.php");
include_once(__DIR__ . "/FormUi.php");
include_once(__DIR__ . "/GlobalView/GeneralSettings.php");


class GlobalView {
    private $globalcontroller,$form_ui,$size_array,$widgets_array,$menu_array;

    function __construct(GlobalController $controller,FormUi $form_ui)
    {
        $this->globalcontroller = $controller;
        $this->form_ui          = $form_ui;
        add_action("admin_menu",array(&$this,"global_theme_settings"));
        add_action("after_setup_theme",array(&$this,"advanced_settings"));
        add_action("admin_print_styles",array(&$this,"add_global_style"));
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
     * Ayarlar sayfasında tabmenulerin çıkmasını sağlar.
     */
    private function theme_settings_tab_menu( $current ) {
        $tabs = array(
            'homepage'              => 'Üst Kısım Ayarları',
            'social'                => 'Sosyal Medya Ayarları',
            'footer'                => 'Footer Ayarları',
            "googleanalytics"       => "Google Analytics",
            "webmastersettings"     => "Google Web Master Code"
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

        //Gelen post değerlerinin kontrolünü yapıp db ye kaydını yapılmasını sağlar.
        $get_post_val       =   $this->globalcontroller->forms_save_settings();
        switch($tab_page) {
            case("homepage"):
                general_settings_ui();
                break;
            case("social"):
                $this->form_ui->SocialPage($get_post_val);
                break;
            case("footer"):
                break;
            case("googleanalytics"):
                $this->form_ui->GoogleAnalytics($get_post_val);
                break;
            case("webmastersettings"):
                break;
            default:
                break;
        }
    }

    //----------------- Sitenin ziyaretçi arayüzünde kullanılması gereken fonksiyonlar burada belirtilmiştir ------------------------------------

    /*
     * Siteye Eklenen Sosyal Ağların butonlarını ekler.
     * TODO bu kısımın css ayarlarını panelden yapılacak hale getirmek iyi olacaktır diye düşünüyorum.
     */
    public function social_button_settings(){
        $get_social_buttons     = get_option(SOCIAL_THEME_SETTINGS);
        if(!empty($get_social_buttons)):
            echo "<ul class='ul-table social_links'>";
            foreach($get_social_buttons as $id => $link) :
                if($link !=  null) :
                    echo "<li><a id='" . $id . "' href='" . $link . "'></a></li>";
                endif;
            endforeach;
            echo "</ul>";
        endif;
    }

    /*
     *
     */
    public function blog_views_count_and_data($id="",$class="content_attribute margin_bottom"){
        global $post;
        ?>

        <ul class="blog_attr <?php echo $class; ?>" id="<?php echo $id; ?>">
            <li><span class="glyphicon glyphicon-eye-open"></span><?php echo $this->globalcontroller->get_view_count($post->ID) . " Defa Okundu"; ?></li>
            <li><span class="glyphicon glyphicon-dashboard"></span><?php echo $this->globalcontroller->get_date_from_pass_time($post->ID); ?></li>
        </ul>

    <?php
    }
}
?>