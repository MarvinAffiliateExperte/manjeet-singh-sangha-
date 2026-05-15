<?php
/**
 * Fix #2: Optimierte Meta-Titles und Meta-Descriptions
 *
 * Einfügen in: functions.php deines Child-Themes
 * Voraussetzung: Kein anderes SEO-Plugin (Yoast/RankMath) überschreibt diese Werte.
 * → Wenn du Yoast/RankMath nutzt: Die Muster unten direkt in den jeweiligen
 *   Seiten-Einstellungen des Plugins pflegen (keine PHP-Änderung nötig).
 *
 * QUICK-WIN PRIORITÄTEN laut GSC-Auswertung (nach Impressionen):
 *
 * 1. /product/die-janson-methode-erfahrungen/  → 2.484 Imp, Pos 7,7, CTR 0,76% ← KRITISCH
 * 2. /experte/saman-shiripour/                 → 636 Imp, Pos 13,5
 * 3. /experte/rheumafrei/                      → 587 Imp, Pos 10,8
 * 4. /product/90-tage-challenge-sjard/         → 543 Imp, Pos 42,5
 * 5. /product/80-20-system-max-mueller/        → 466 Imp, Pos 13,2
 */

// -----------------------------------------------------------------------
// EMPFOHLENE TITLE-FORMEL FÜR REVIEW-SEITEN:
// [Name/Produkt] Erfahrungen [Jahr] – Seriös, Kosten & Kritik | kurs-erfahrungen.com
// -----------------------------------------------------------------------

// Konkrete Titles zum Eintragen (Yoast SEO / RankMath / direkt im Editor):

$seo_titles = array(

    // Janson Methode – KRITISCHSTER FIX (2.484 Impressionen, CTR nur 0,76%)
    'janson-methode' => array(
        'title'       => 'Die Janson Methode Erfahrungen 2024 – Seriös oder nicht? Kritische Bewertung',
        'description' => 'Janson Methode Erfahrungen: Was sagen echte Teilnehmer? Kosten, Inhalte & kritische Analyse – bevor du buchst, lies das. ✓ Unabhängige Bewertung.',
    ),

    // Saman Shiripour – 636 Impressionen, Pos 13,5
    'saman-shiripour' => array(
        'title'       => 'Saman Shiripour Erfahrungen 2024 – Rendite Rakete seriös? Kosten & Kritik',
        'description' => 'Saman Shiripour Erfahrungen: Ist die Rendite Rakete ihr Geld wert? ✓ Echte Teilnehmerberichte, Kosten & unabhängige Bewertung auf kurs-erfahrungen.com.',
    ),

    // Rheumafrei – 587 Impressionen, Pos 10,8
    'rheumafrei' => array(
        'title'       => 'Rheumafrei Erfahrungen 2024 – Kurs seriös? Kosten, Kritik & Bewertung',
        'description' => 'Rheumafrei Erfahrungen & Kritik: Was taugt das Programm wirklich? ✓ Kosten, Inhalte & Teilnehmerbewertungen – unabhängig geprüft.',
    ),

    // 90 Tage Challenge Sjard – 543 Impressionen, Pos 42,5
    '90-tage-challenge-sjard' => array(
        'title'       => 'Sjard 90 Tage Challenge Erfahrungen 2024 – Seriös, Kosten & Kritik',
        'description' => 'Sjard 90-Tage-Challenge Erfahrungen: Lohnt sich der Kurs? Kosten, Inhalte & Teilnehmerberichte – ehrlich & unabhängig bewertet.',
    ),

    // 80-20 System Max Müller – 466 Impressionen, Pos 13,2
    '80-20-system-max-mueller' => array(
        'title'       => '80-20 System Max Müller Erfahrungen 2024 – Seriös oder Abzocke?',
        'description' => '80-20 System von Max Müller: Echte Erfahrungen, Kosten & kritische Bewertung. ✓ Ist der Kurs sein Geld wert? Unabhängige Analyse.',
    ),

    // Barbara Formann – 332 Impressionen, Pos 15,6
    'barbara-formann' => array(
        'title'       => 'Barbara Formann Erfahrungen 2024 – Medium & Coaching seriös? Kritik',
        'description' => 'Barbara Formann Erfahrungen: Was sagen Teilnehmer? Kosten, Methoden & kritische Bewertung des Mediumship-Coachings. ✓ Unabhängig geprüft.',
    ),

    // Alex Schreiner – 404 Impressionen, Pos 16,6
    'alex-schreiner' => array(
        'title'       => 'Alex Schreiner Erfahrungen 2024 – Kosten, Kritik & Bewertung',
        'description' => 'Alex Schreiner Erfahrungen: Lohnt sich SimpleFree Academy? ✓ Echte Teilnehmerstimmen, Kosten & unabhängige Analyse.',
    ),
);

// Ausgabe-Beispiel (ohne SEO-Plugin):
add_action( 'wp_head', 'kurserfahr_custom_meta_tags', 1 );

function kurserfahr_custom_meta_tags() {
    // Diesen Block nur aktivieren wenn KEIN Yoast / RankMath aktiv!
    if ( function_exists( 'wpseo_init' ) || function_exists( 'rank_math' ) ) {
        return; // SEO-Plugin übernimmt – Titel/Descriptions dort pflegen
    }

    if ( ! is_singular() ) {
        return;
    }

    $post_id    = get_the_ID();
    $custom_desc = get_post_meta( $post_id, '_custom_meta_description', true );

    if ( $custom_desc ) {
        echo '<meta name="description" content="' . esc_attr( $custom_desc ) . '">' . PHP_EOL;
    }
}
