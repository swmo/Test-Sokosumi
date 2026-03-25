# Freiwilligen-Helfer Plattform

Eine Symfony-Webanwendung zur Vermittlung von freiwilligen Helfern an Einsaetze und Veranstaltungen.

## Voraussetzungen

- PHP 8.2 oder hoeher
- Composer
- PHP-Erweiterungen: sqlite3, xml, mbstring, intl, curl, zip

## Installation

### 1. Repository klonen

```bash
git clone <repository-url>
cd <projekt-verzeichnis>
```

### 2. Abhaengigkeiten installieren

```bash
composer install
```

### 3. Datenbank einrichten

Die Anwendung verwendet SQLite. Die Datenbank wird automatisch im `var/`-Verzeichnis erstellt.

```bash
# Migration ausfuehren
php bin/console doctrine:migrations:migrate --no-interaction

# Testdaten laden (Admin-Benutzer und Beispiel-Einsaetze)
php bin/console doctrine:fixtures:load --no-interaction
```

### 4. Entwicklungsserver starten

```bash
php -S localhost:8000 -t public/
```

Die Anwendung ist dann unter `http://localhost:8000` erreichbar.

## Standard-Zugangsdaten

### Administrator
- **E-Mail:** admin@example.com
- **Passwort:** admin123

### Testbenutzer
- **E-Mail:** maria.mueller@example.com / thomas.schmidt@example.com / anna.weber@example.com
- **Passwort:** password123

## Funktionen

### Oeffentlicher Bereich
- **Startseite** mit Liste bevorstehender Einsaetze
- **Einsatz-Detailseite** mit vollstaendigen Informationen und Anmeldefunktion
- **Registrierung** fuer neue Helfer
- **Anmeldung** mit E-Mail und Passwort
- Anzeige verfuegbarer Plaetze (z.B. "3 von 10 Plaetzen verfuegbar")
- Ausgebucht-Anzeige bei vollen Einsaetzen

### Admin-Bereich (/admin)
- **Dashboard** mit Uebersicht ueber Einsaetze und Teilnehmerzahlen
- **Einsatzverwaltung** - Erstellen, Bearbeiten und Loeschen von Einsaetzen
- **Anmeldungen anzeigen** - Sehen, wer sich fuer welchen Einsatz angemeldet hat
- **Benutzerverwaltung** - Uebersicht registrierter Benutzer

## Technische Details

- **Framework:** Symfony 7.2
- **Datenbank:** SQLite mit Doctrine ORM
- **Templates:** Twig mit Bootstrap 5 (CDN)
- **Authentifizierung:** Symfony Security Bundle
- **Formulare:** Symfony Forms mit Validierung
