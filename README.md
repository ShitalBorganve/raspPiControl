Um das raspPiControl betreiben zu koennen geht wie folgt vor:


- apt-get install apache2 php5
- sudo visudo

Dort findet Ihr:
```
User privilege specification
root    ALL=(ALL) ALL
pi      ALL=(ALL) NOPASSWD: ALL
```
dies ergaenzt Ihr wie folgt:
```
User privilege specification
root    ALL=(ALL) ALL
pi      ALL=(ALL) NOPASSWD: ALL
apache  ALL=(ALL) NOPASSWD: /sbin/shutdown
www-data ALL=(ALL) NOPASSWD: /sbin/shutdown
```

- Pi haendisch rebooten
- Dateien nach /var/www (oder einen Unterordner) kopieren
- Adminpasswort in der config.php ändern
- http://name-oder-ip-des-pie/(evtl. Unterordner)
- Spass haben :)
