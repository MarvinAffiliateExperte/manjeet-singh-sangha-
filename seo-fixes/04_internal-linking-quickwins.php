<?php
/**
 * Fix #4: Automatische interne Verlinkung für Quick-Win-Seiten
 *
 * ZIEL: Die 12 Seiten in Position 11–20 mit hohem Impressionsvolumen
 * durch interne Links stärken → schneller auf Seite 1.
 *
 * Methode: Beim Erscheinen bestimmter Keywords im Fließtext automatisch
 * auf die Zielseite verlinken. Nur beim ersten Vorkommen pro Seite.
 */

add_filter( 'the_content', 'kurserfahr_auto_internal_links' );

function kurserfahr_auto_internal_links( $content ) {
    // Nur auf Einzelbeiträgen/Seiten
    if ( ! is_singular() ) {
        return $content;
    }

    // Format: 'Keyword im Text' => 'Ziel-URL'
    // Quelle: GSC Quick-Win-Seiten (Pos 11–20, >100 Impressionen)
    $link_map = array(
        'Janson Methode'           => 'https://kurs-erfahrungen.com/product/die-janson-methode-erfahrungen/',
        'Saman Shiripour'          => 'https://kurs-erfahrungen.com/experte/saman-shiripour/',
        'Rendite Rakete'           => 'https://kurs-erfahrungen.com/product/rendite-rakete-saman-shiripour/',
        '80-20 System'             => 'https://kurs-erfahrungen.com/product/80-20-system-max-mueller/',
        'Max Müller'               => 'https://kurs-erfahrungen.com/product/80-20-system-max-mueller/',
        'Alex Schreiner'           => 'https://kurs-erfahrungen.com/experte/alex-schreiner/',
        'SimpleFree Academy'       => 'https://kurs-erfahrungen.com/product/simplyfree-academy-von-alex-schreiner/',
        'Barbara Formann'          => 'https://kurs-erfahrungen.com/experte/barbara-formann/',
        'Etsy Masterclass'         => 'https://kurs-erfahrungen.com/product/etsy-masterclass-von-lotti/',
        'Lotti Masterclass'        => 'https://kurs-erfahrungen.com/product/etsy-masterclass-von-lotti/',
        'The Affiliate Code'       => 'https://kurs-erfahrungen.com/product/the-affiliate-code-by-marek-ruehl/',
        'Marek Rühl'               => 'https://kurs-erfahrungen.com/product/the-affiliate-code-by-marek-ruehl/',
        'MMNews Club'              => 'https://kurs-erfahrungen.com/product/mmnews-club-erfahrungen/',
        'Marcel Schlee'            => 'https://kurs-erfahrungen.com/experte/marcel-schlee/',
        'Bettina Suvi Rode'        => 'https://kurs-erfahrungen.com/experte/bettina-suvi-rode/',
        'Dekonstruktion im Menschen' => 'https://kurs-erfahrungen.com/product/dekonstruktion-im-menschen-buch/',
        'Andreas Sadlowski'        => 'https://kurs-erfahrungen.com/experte/andreas-sadlowski/',
    );

    $current_url = get_permalink();
    $already_linked = array();

    foreach ( $link_map as $keyword => $url ) {
        // Nicht auf die eigene Seite verlinken
        if ( rtrim( $url, '/' ) === rtrim( $current_url, '/' ) ) {
            continue;
        }
        // Nur beim ersten Vorkommen verlinken
        if ( isset( $already_linked[ $url ] ) ) {
            continue;
        }
        // Nicht innerhalb von Tags ersetzen (einfache Sicherung)
        $pattern     = '/(?<!["\'>])(' . preg_quote( $keyword, '/' ) . ')(?![^<]*>)/u';
        $replacement = '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $keyword . ' Erfahrungen' ) . '">' . $keyword . '</a>';
        $new_content = preg_replace( $pattern, $replacement, $content, 1, $count );
        if ( $count > 0 ) {
            $content = $new_content;
            $already_linked[ $url ] = true;
        }
    }

    return $content;
}
