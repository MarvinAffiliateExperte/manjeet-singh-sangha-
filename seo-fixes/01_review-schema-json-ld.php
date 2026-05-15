<?php
/**
 * Fix #1: Review Schema (JSON-LD) für alle Experten- und Produktseiten
 *
 * Einfügen in: functions.php deines Child-Themes
 * ODER als eigenes Plugin hochladen
 *
 * Was es macht: Fügt strukturierte Daten (Bewertungssterne) in Google ein.
 * Das erhöht CTR auf allen Review-Seiten um geschätzt 20–40%.
 */

add_action( 'wp_head', 'kurserfahr_review_schema' );

function kurserfahr_review_schema() {
    if ( ! is_singular( array( 'post', 'page', 'product', 'experte' ) ) ) {
        return;
    }

    $post_id      = get_the_ID();
    $post_title   = get_the_title();
    $post_url     = get_permalink();
    $author       = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
    $date_pub     = get_the_date( 'Y-m-d', $post_id );
    $date_mod     = get_the_modified_date( 'Y-m-d', $post_id );

    // Bewertungswert aus Custom Field holen (ACF oder beliebiges Plugin)
    // Felder anlegen: review_rating (1-5), review_count, review_body
    $rating       = get_post_meta( $post_id, 'review_rating', true );
    $review_count = get_post_meta( $post_id, 'review_count', true );
    $review_body  = get_post_meta( $post_id, 'review_body', true );

    // Nur ausgeben wenn Bewertungsdaten vorhanden
    if ( empty( $rating ) ) {
        return;
    }

    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'Review',
        'name'            => $post_title,
        'url'             => $post_url,
        'datePublished'   => $date_pub,
        'dateModified'    => $date_mod,
        'author'          => array(
            '@type' => 'Person',
            'name'  => $author,
        ),
        'publisher'       => array(
            '@type' => 'Organization',
            'name'  => 'kurs-erfahrungen.com',
            'url'   => 'https://kurs-erfahrungen.com',
        ),
        'reviewRating'    => array(
            '@type'       => 'Rating',
            'ratingValue' => (float) $rating,
            'bestRating'  => 5,
            'worstRating' => 1,
        ),
        'reviewBody'      => $review_body ?: wp_trim_words( get_the_excerpt(), 50 ),
        'itemReviewed'    => array(
            '@type' => 'Product',
            'name'  => $post_title,
            'url'   => $post_url,
        ),
    );

    // Aggregierte Bewertung nur ausgeben wenn review_count vorhanden
    if ( ! empty( $review_count ) ) {
        $schema['itemReviewed']['aggregateRating'] = array(
            '@type'       => 'AggregateRating',
            'ratingValue' => (float) $rating,
            'reviewCount' => (int) $review_count,
            'bestRating'  => 5,
            'worstRating' => 1,
        );
    }

    echo '<script type="application/ld+json">' . PHP_EOL;
    echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
    echo PHP_EOL . '</script>' . PHP_EOL;
}
