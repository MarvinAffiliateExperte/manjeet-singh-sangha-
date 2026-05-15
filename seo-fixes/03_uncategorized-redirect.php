<?php
/**
 * Fix #3: Uncategorized-Artikel fixen + 301-Redirect
 *
 * PROBLEM (aus GSC-Daten):
 *   /uncategorized/abnehmen-ohne-hunger-bericht/ → Position 90, 285 Impressionen
 *   Seite liegt im WordPress-Standardpfad "uncategorized" – das schadet dem Ranking.
 *
 * LÖSUNG in 2 Schritten:
 *
 * Schritt 1 – Im WordPress-Admin:
 *   1. Artikel "abnehmen-ohne-hunger-bericht" öffnen
 *   2. Kategorie von "Unkategorisiert" → z.B. "Abnehmen" oder "Gesundheit" ändern
 *   3. Artikel speichern → neue URL: /gesundheit/abnehmen-ohne-hunger-bericht/
 *
 * Schritt 2 – 301-Redirect einrichten (entweder via .htaccess ODER diesen Code):
 */

// Option A: Redirect via PHP (in functions.php einfügen)
add_action( 'template_redirect', 'kurserfahr_fix_uncategorized_redirects' );

function kurserfahr_fix_uncategorized_redirects() {
    $redirects = array(
        // Format: 'alter-pfad' => 'neuer-pfad'
        '/uncategorized/abnehmen-ohne-hunger-bericht/' => '/gesundheit/abnehmen-ohne-hunger-bericht/',
        // Weitere uncategorized-Artikel hier ergänzen
    );

    $current_path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

    foreach ( $redirects as $old => $new ) {
        if ( rtrim( $current_path, '/' ) . '/' === $old ) {
            wp_redirect( home_url( $new ), 301 );
            exit;
        }
    }
}

/**
 * Option B: .htaccess-Einträge (schneller, vor PHP ausgeführt)
 * Diese Zeilen in die .htaccess im WordPress-Root einfügen,
 * VOR dem WordPress-Block (vor "# BEGIN WordPress"):
 *
 * # Fix uncategorized URLs
 * Redirect 301 /uncategorized/abnehmen-ohne-hunger-bericht/ /gesundheit/abnehmen-ohne-hunger-bericht/
 *
 * Präventivmaßnahme: Standard-Kategorie "Unkategorisiert" umbenennen
 * WordPress Admin → Beiträge → Kategorien → "Unkategorisiert" → umbenennen in "Allgemein"
 * UND Einstellungen → Schreiben → Standard-Kategorie auf eine thematisch passende Kategorie setzen.
 */
