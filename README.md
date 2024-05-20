# Gerador de QR Code

## Requisitos:
<ul>
    <li>Biblioteca GD</li>
</ul>

### Verificar se a extensão GD está instalada:
```
php -m | grep gd
```
Se a extensão GD estiver instalada, esse comando retornará "gd". Caso contrário, não retornará nada.

<hr>

### Para instalar:
```
sudo apt-get install php7.2-gd
sudo systemctl restart apache
```

## Execução (exemplo):
```
curl -X POST http://localhost/phpqrcode/index.php -d '{"value":"https://hsist.com.br"}' -H "Content-Type: application/json"
```