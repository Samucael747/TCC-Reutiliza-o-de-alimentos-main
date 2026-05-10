@echo off
REM Script para diagnosticar e iniciar MySQL no XAMPP

echo ===============================================
echo Verificando status do MySQL/MariaDB
echo ===============================================
echo.

REM Verificar se MySQL está rodando
netstat -ano | findstr ":3306" >nul
if %errorlevel% equ 0 (
    echo [OK] MySQL/MariaDB esta rodando na porta 3306
) else (
    echo [ERRO] MySQL/MariaDB nao esta respondendo na porta 3306
    echo.
    echo Tentando iniciar XAMPP...
    echo.
    
    REM Tentar encontrar e iniciar XAMPP
    if exist "C:\xampp\xampp-control.exe" (
        echo Iniciando XAMPP Control Panel...
        start "" "C:\xampp\xampp-control.exe"
        echo.
        echo [INSTRUCOES]
        echo 1. Clique no botao START ao lado de "MySQL" ou "MariaDB"
        echo 2. Aguarde ate aparecer "Running"
        echo 3. Depois abra no navegador: http://localhost/xampp/htdocs/TCC-Reutiliza-o-de-alimentos-main/TCC_Reutiliza%%C3%%A7%%C3%%A3o%%20de%%20alimentos/atividade/php/teste_conexao.php
    ) else (
        echo XAMPP nao foi encontrado em C:\xampp
        echo Procure pelo local de instalacao do XAMPP e inicie o MySQL manualmente
    )
)

echo.
echo ===============================================
echo Teste de conexao PHP
echo ===============================================
echo.
echo Abra no navegador:
echo http://localhost/xampp/htdocs/TCC-Reutiliza-o-de-alimentos-main/TCC_Reutiliza%%C3%%A7%%C3%%A3o%%20de%%20alimentos/atividade/php/teste_conexao.php
echo.
pause
