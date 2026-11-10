# Biblioteca virtuală: Thriller și Mister

Expoziție digitală cu 12 romane thriller și mister. Proiect universitar.

## Tehnologii
- HTML5 semantic și CSS responsiv (Flexbox, Grid)
- PHP 8 (PDO)
- MySQL (prin XAMPP)
- Git / GitHub

## Pagini
| Pagină | Fișier | Conținut |
| --- | --- | --- |
| Acasă | `index.php` | Prezentare și 3 cărți recomandate (din baza de date) |
| Colecție | `colectie.php` | Cele 12 cărți, cu filtru după subgen și căutare |
| Detaliu carte | `detaliu.php?id=N` | O singură pagină-șablon, pentru oricare dintre cărți |
| Despre | `despre.php` | Prezentarea expoziției și statistici din baza de date |
| Contact | `contact.php` | Formular care salvează mesajele în baza de date |

## Structura proiectului
- `includes/`: partea comună a paginilor (`db.php`, `functions.php`, `header.php`, `footer.php`)
- `css/style.css`: stilurile site-ului
- `database.sql`: tabelele și cele 12 exponate de test
- `config.example.php`: model pentru fișierul de configurare

## Instalare
1. Instalează XAMPP și pornește Apache și MySQL.
2. Clonează depozitul în `C:\xampp\htdocs\biblioteca`.
3. Importă `database.sql` din phpMyAdmin (http://localhost/phpmyadmin). Scriptul creează baza `biblioteca`.
4. Copiază `config.example.php` ca `config.php` și completează datele de conectare.
5. Deschide http://localhost/biblioteca/.

## Baza de date
Baza `biblioteca`, cu tabelele: `autori`, `genuri`, `carti`, `carti_genuri`, `contact_mesaje`.
- un autor are mai multe cărți (relație 1:N, `carti.id_autor`);
- o carte poate avea mai multe subgenuri, iar un subgen apare la mai multe cărți (relație N:M, prin `carti_genuri`).

## Stadiu
- Etapa 2: mediul de lucru și pagina „Hello” conectată la baza de date.
- Etapa 3: paginile principale și secundare, meniul, scheletul grafic responsiv, 12 exponate de test, pagina de colecție și cea de detaliu alimentate din baza de date.