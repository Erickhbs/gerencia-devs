# Gerencia-Devs

Um projeto para o gerente da associação Devs do RN poder ter melhor acesso às informações da associação

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

Seu sistema operacional ser Windows
Você precisa do XAMPP intalado e do PHP
ter um editor já configurado para PHP ou VISUAL STUDIO CODE

### 🔧 Instalação

instalação do XAMPP:
    deve se instalar o xampp para ter acesso ao servidor
    MySQL e para uma instalação rapida do PHP
    ter algum editor de texto de sua preferencia

```
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe/download
```
caso não tenha um editor, aconselho o uso do VISUAL STUDIO CODE
```
https://code.visualstudio.com/
```
clique em instalar e é só prosseguir com a intalação normal no windows em ambos os softwares.
Até finalizar e inicializar algumas alterações

Após isso, vá te o local do arquivo onde está intalado o XAMPP 
um exemplo de como está o path na minha maquina:
```
C:\xampp
```
E ir na pasta que está em:
```
C:\xampp\htdocs
```
Comando no PowerShell:
```
cd ..
cd ..
cd .\xampp\htdocs\
```
Apague tudo, baixe o zip do projeto e extraia dentro da pasta.

Caso esteja utilizando o VISUAL STUDIO CODE, algumas coisas precisam ser
Feitas para que ele identifique o PHP que veio junto ao XAMPP.
Primeiro de tudo abra o editor!

Vá em/ou:
```
file -> preferences -> settings
```
```
arquivo -> preferencias -> configurações
```
<img src="/img/guide-1.png" alt="print-1">

Vá em/ou:
```
extensions -> PHP -> Edit in settings.json
```
```
extensões -> PHP -> Editar em settings.json
```
<img src="/img/guide-2.png" alt="print-2">

escreva, caso não haja, ou modifique adicionando o path da sua máquina:

<img src="/img/guide-3.png" alt="print-3">

A com isso seu ambiente está pronto! :)

## ⚙️ Executando os testes

iniciar os servidores que serão usados Apache e MySQL:

<img src="/img/guide-4.png" alt="print-4">

Abra o navegador de sua escolha para ver se os servidores inicializaram corretamente e digite:

MySQL:

```
http://localhost/phpmyadmin/index.php
```
<img src="/img/guide-5.png" alt="print-5">

Apache:
```
http://localhost
```
<img src="/img/guide-6.png" alt="print-6">
Caso já tenha extraido o arquivo zip dentro da pasta, a pasta do projeto estrá à mostra, basta clicar!

E para editar o código, basta abrir a pasta no editor pelo PowerShell.
### Caso haja algum erro no powerShell, mude as barras invertidas!
```
cd .\xampp\htdocs\gerencia-dev\
code .
```

## 🛠️ Construído com

Mencione as ferramentas que você usou para criar seu projeto

* [PHP](https://www.php.net/manual/en/index.php) - A linguagem de programação usada
* [XAMPP](https://www.apachefriends.org/docs/) - Gerente de Servidores

## 🎁 Expressões de gratidão

* Espero que apreciem o que foi feito, está incompleto mas foi um trabalho honesto;
* Ainda terminarei após o feedback, para honrar o tempo estipulado;
* agradeço pela oportunidade de poder aprender e desenvolver com esta linguagem!;
