<?php
 // Verifica se i campi dei cookies sono popolati
    $banner_text = get_theme_mod('banner_text_setting');
    $enable_analytics = get_theme_mod('cookies_settings_consent_analytics', false);
    $enable_marketing_cookies = get_theme_mod('cookies_settings_consent_marketing', false);
    $enable_social_cookies = get_theme_mod('cookies_settings_consent_social', false);
    $enable_youtube_cookies = get_theme_mod('cookies_settings_consent_youtube', false);
?>

<!-- COOKIE SETTINGS -->
<div class="modal fade" id="cookieModal" tabindex="-1" aria-labelledby="cookieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cookieModalLabel"><?php echo esc_html__('Preferenze Cookies', 'wp-digital-italia'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo esc_attr__('Chiudi', 'wp-digital-italia'); ?>"></button>
            </div>
            <div class="modal-body">
                <?php if($enable_analytics): ?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input cookie-option" id="cookies_settings_consent_analytics">
                        <label class="form-check-label" for="cookies_settings_consent_analytics"><?php echo esc_html__('Abilita cookies di Analytics', 'wp-digital-italia'); ?></label>
                    </div>
                <?php endif; ?>
                <?php if($enable_marketing_cookies): ?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input cookie-option" id="cookies_settings_consent_marketing">
                        <label class="form-check-label" for="cookies_settings_consent_marketing"><?php echo esc_html__('Abilita cookies di Marketing', 'wp-digital-italia'); ?></label>
                    </div>
                <?php endif; ?>
                <?php if($enable_social_cookies): ?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input cookie-option" id="cookies_settings_consent_social">
                        <label class="form-check-label" for="cookies_settings_consent_social"><?php echo esc_html__('Abilita cookies Social', 'wp-digital-italia'); ?></label>
                    </div>
                <?php endif; ?>
                <?php if($enable_youtube_cookies): ?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input cookie-option" id="cookies_settings_consent_youtube">
                        <label class="form-check-label" for="cookies_settings_consent_youtube"><?php echo esc_html__('Abilita cookies di YouTube', 'wp-digital-italia'); ?></label>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo esc_html__('Chiudi', 'wp-digital-italia'); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- /COOKIES SETTINGS -->

<?php
$privacy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
if ( ! $privacy_url ) {
    $privacy_page = get_page_by_path( 'privacy' );
    $privacy_url  = $privacy_page ? get_permalink( $privacy_page ) : '';
}
$default_text = __( 'Questo sito utilizza cookie tecnici di navigazione e di sessione per garantire un miglior servizio di navigazione del sito, e cookie analitici per raccogliere informazioni sull\'utilizzo del sito da parte degli utenti. Per saperne di più, o per disabilitare i cookie o abilitarne solo alcuni, consulta la nostra', 'wp-digital-italia' );
?>
<section class="cookiebar dci-cookiebar fade" aria-labelledby="dci-cookiebar-title" aria-label="<?php echo esc_attr__('Gestione dei cookies', 'wp-digital-italia'); ?>">
    <button type="button" class="dci-cookiebar__close" data-bs-accept="cookiebar" data-dci-consent="necessary" aria-label="<?php echo esc_attr__('Chiudi e usa solo i cookie tecnici', 'wp-digital-italia'); ?>">
        <?php echo dci_icon( 'close', 'icon' ); ?>
    </button>
    <h2 id="dci-cookiebar-title" class="dci-cookiebar__title"><?php echo esc_html__('Usiamo i cookie', 'wp-digital-italia'); ?></h2>
    <p class="dci-cookiebar__text">
        <?php echo esc_html( ! empty( $banner_text ) ? $banner_text : $default_text ); ?>
        <?php if ( $privacy_url ) : ?> <a href="<?php echo esc_url( $privacy_url ); ?>"><?php echo esc_html__('Cookie Policy', 'wp-digital-italia'); ?></a>.<?php endif; ?>
    </p>
    <div class="dci-cookiebar__buttons">
        <button type="button" class="dci-cb dci-cb--dark" data-bs-accept="cookiebar" data-dci-consent="necessary"><?php echo esc_html__('Solo cookies tecnici', 'wp-digital-italia'); ?></button>
        <button type="button" class="dci-cb dci-cb--green" data-bs-accept="cookiebar" data-dci-consent="all"><?php echo esc_html__('Accetta tutti', 'wp-digital-italia'); ?></button>
        <a href="#" id="cookies-settings" class="dci-cb dci-cb--dark"><?php echo esc_html__('Cambia le impostazioni', 'wp-digital-italia'); ?></a>
    </div>
</section>
