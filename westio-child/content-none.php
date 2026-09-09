<?php
/**
 * Child theme override of the parent's "no posts found" template.
 *
 * Differs from the parent (westio/content-none.php) in two ways:
 * - Drops the "Ready to publish your first post? Get started here." line
 *   on the empty blog archive (admin-only prompt, not meant for visitors).
 * - Translates per Polylang's current language instead of relying on
 *   theme .mo files, matching the pattern already used in
 *   inc/footer-settings.php and template-parts/header.php.
 */

$wc_lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'az';

$wc_strings = [
    'az' => [
        'title'     => 'Heç nə tapılmadı',
        'search'    => 'Axtarış şərtlərinizə uyğun heç nə tapılmadı. Zəhmət olmasa fərqli açar sözlərlə yenidən cəhd edin.',
        'not_found' => 'Axtardığınızı tapa bilmədik. Axtarış köməkçi ola bilər.',
    ],
    'ru' => [
        'title'     => 'Ничего не найдено',
        'search'    => 'По вашему запросу ничего не найдено. Попробуйте использовать другие ключевые слова.',
        'not_found' => 'Нам не удалось найти то, что вы искали. Возможно, поиск поможет.',
    ],
    'en' => [
        'title'     => 'Nothing Found',
        'search'    => 'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
        'not_found' => 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.',
    ],
];

$wc_t = $wc_strings[$wc_lang] ?? $wc_strings['en'];
?>
<div class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php echo esc_html($wc_t['title']); ?></h1>
	</header><!-- .page-header -->

	<?php if (is_search()) : ?>
		<div class="page-content">
			<p><?php echo esc_html($wc_t['search']); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .page-content -->
	<?php elseif (!is_home()) : ?>
		<div class="page-content">
			<p><?php echo wp_kses_post($wc_t['not_found']); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .page-content -->
	<?php endif; ?>
</div><!-- .no-results -->
