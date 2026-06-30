# BigDataCorp

To obtain access keys, contact the company.

https://docs.bigdatacorp.com.br/plataforma/reference/autenticacao-e-seguranca

## CNPJ format support

`getCpfOrCnpj` and `getCnpj` accept both the legacy all-numeric CNPJ (14 digits) and the new Brazilian alphanumeric CNPJ standard (12 alphanumeric characters followed by 2 numeric check digits). The document can be passed with or without mask (dots, slash, dash):

```php
$Bigdatacorp->getCpfOrCnpj('11.222.333/0001-81'); // legacy numeric CNPJ
$Bigdatacorp->getCpfOrCnpj('12.ABC.345/01DE-35'); // new alphanumeric CNPJ
```
