# SEO-Fixes für kurs-erfahrungen.com
**Basierend auf GSC-Daten: Letzte 3 Monate | Erstellt: Mai 2026**

---

## Reihenfolge der Umsetzung (nach Priorität)

### Fix #1 – SOFORT: Janson-Methode CTR reparieren
**Datei:** `02_meta-title-description.php`
**Aufwand:** 5 Minuten | **Impact:** Hoch (2.484 Impressionen, aktuell nur 0,76% CTR)

1. WordPress Admin → Seite `/product/die-janson-methode-erfahrungen/` öffnen
2. In Yoast/RankMath folgenden Title eintragen:
   ```
   Die Janson Methode Erfahrungen 2024 – Seriös oder nicht? Kritische Bewertung
   ```
3. Meta-Description:
   ```
   Janson Methode Erfahrungen: Was sagen echte Teilnehmer? Kosten, Inhalte & kritische
   Analyse – bevor du buchst, lies das. ✓ Unabhängige Bewertung.
   ```
4. Speichern → fertig.

---

### Fix #2 – SOFORT: Review Schema einbinden
**Datei:** `01_review-schema-json-ld.php`
**Aufwand:** 30 Minuten | **Impact:** Sehr hoch (Sternebewertungen in Google)

1. Code aus `01_review-schema-json-ld.php` in `functions.php` deines Child-Themes kopieren
2. Custom Fields anlegen (ACF Free reicht):
   - `review_rating` (Zahl, 1–5)
   - `review_count` (Zahl)
   - `review_body` (Text)
3. Für die Top-10-Seiten die Werte eintragen
4. Mit Google Rich Results Test prüfen: https://search.google.com/test/rich-results

---

### Fix #3 – Diese Woche: Uncategorized-Artikel fixen
**Datei:** `03_uncategorized-redirect.php`
**Aufwand:** 15 Minuten | **Impact:** Mittel

1. WordPress Admin → Beiträge → "abnehmen-ohne-hunger-bericht" öffnen
2. Kategorie von "Unkategorisiert" → "Gesundheit" (oder passende Kategorie) ändern
3. Speichern → WordPress erstellt automatisch Weiterleitung (wenn Redirection-Plugin aktiv)
4. Falls kein Plugin: `.htaccess`-Redirect aus Fix #3 manuell eintragen

---

### Fix #4 – Diese Woche: Interne Verlinkung
**Datei:** `04_internal-linking-quickwins.php`
**Aufwand:** 20 Minuten | **Impact:** Mittel-hoch (Push für alle Quick-Win-Seiten)

1. Code aus `04_internal-linking-quickwins.php` in `functions.php` kopieren
2. Teste auf einer Seite, dass Links korrekt gesetzt werden
3. Keywords-Liste nach Bedarf erweitern

---

### Fix #5 – Nächste Woche: Alle Meta-Descriptions auf 155 Zeichen auffüllen
**Datei:** `05_mobile-ctr-improvements.php`
**Aufwand:** 2–3 Stunden (alle Top-50-Seiten) | **Impact:** Mittel (Desktop-CTR)

Vorlagen aus `05_mobile-ctr-improvements.php` für alle wichtigen Seiten eintragen.

---

## Erwartete Ergebnisse nach 4–8 Wochen

| Maßnahme | Erwarteter Effekt |
|----------|-----------------|
| Janson-Methode Title/Meta | +80–150 Klicks/Monat |
| Review Schema | +20–40% CTR auf allen Schema-Seiten |
| Interne Verlinkung | 3–5 Seiten von Pos 12–15 auf Pos 8–10 |
| Meta-Descriptions Desktop | Desktop-CTR von 0,97% → 1,5–2% |
| Uncategorized fix | Pos 90 → langfristig Pos 30–40 |

---

## Überprüfung

- Google Search Console → Leistung → 3 Monate vor/nach Vergleich
- Rich Results Test für Schema-Validierung
- Screaming Frog für interne Link-Audit (kostenfrei bis 500 URLs)
