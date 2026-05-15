<?php
/**
 * Fix #5: Desktop-CTR verbessern (aktuell 0,97% vs. 4,92% Mobil)
 *
 * PROBLEM: Desktop-Nutzer klicken 5x seltener.
 * URSACHE: Snippet-Texte sind für Mobilanzeige optimiert (kurz),
 *          auf Desktop sieht der Nutzer mehr Zeichen → leerer Eindruck.
 *
 * LÖSUNG: Meta-Descriptions auf 155–160 Zeichen auffüllen,
 *         Zahlen & Emojis (✓) am Anfang für Aufmerksamkeit.
 *
 * Checkliste für Meta-Descriptions auf Desktop-Seiten:
 *
 * FORMEL:  ✓ [Konkreter Nutzen] + [soziales Proof/Zahl] + [Call-to-Action]
 * LÄNGE:   155–160 Zeichen (Desktop zeigt mehr als Mobil)
 * KEYWORD: Hauptkeyword in den ersten 60 Zeichen
 *
 * Beispiele (direkt in Yoast/RankMath eintragen):
 *
 * --- Janson Methode ---
 * ✓ Janson Methode Erfahrungen: 342 Suchanfragen pro Monat – was sagen echte Teilnehmer?
 *   Kosten, Inhalte & unabhängige Kritik. Jetzt lesen, bevor du buchst.
 * (158 Zeichen)
 *
 * --- Community-Mitgliedschaft Test ---
 * ✓ Community-Mitgliedschaft Test: Unabhängige Bewertung von Kurs-Erfahrungen.com.
 *   Lohnt es sich? Kosten, Funktionen & ehrliche Teilnehmermeinungen im Überblick.
 * (160 Zeichen)
 *
 * --- Estefano Delano ---
 * ✓ Estefano Delano Erfahrungen: Seriöser Coach oder Hype? Kosten, Kursinhalte &
 *   kritische Stimmen von echten Teilnehmern – kompakt & ehrlich bewertet.
 * (155 Zeichen)
 */

/**
 * Zusätzlich: Breadcrumb-Schema hinzufügen
 * Breadcrumbs erhöhen die Sichtbarkeit im Desktop-SERP durch zusätzliche Zeile.
 */
add_action( 'wp_head', 'kurserfahr_breadcrumb_schema' );

function kurserfahr_breadcrumb_schema() {
    if ( ! is_singular() ) {
        return;
    }

    $categories = get_the_category();
    if ( empty( $categories ) ) {
        return;
    }

    $cat     = $categories[0];
    $post_id = get_the_ID();

    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => array(
            array(
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => 'Startseite',
                'item'     => home_url( '/' ),
            ),
            array(
                '@type'    => 'ListItem',
                'position' => 2,
                'name'     => esc_html( $cat->name ),
                'item'     => get_category_link( $cat->term_id ),
            ),
            array(
                '@type'    => 'ListItem',
                'position' => 3,
                'name'     => get_the_title( $post_id ),
                'item'     => get_permalink( $post_id ),
            ),
        ),
    );

    echo '<script type="application/ld+json">' . PHP_EOL;
    echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
    echo PHP_EOL . '</script>' . PHP_EOL;
}
