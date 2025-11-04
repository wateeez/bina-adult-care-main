$ErrorActionPreference = 'Stop'
if (Get-Command composer -ErrorAction SilentlyContinue) {
    Write-Output "Composer already installed:"; composer --version
    exit 0
}

$installer = 'composer-setup.php'
Write-Output 'Downloading installer...'
Invoke-WebRequest -Uri 'https://getcomposer.org/installer' -OutFile $installer -UseBasicParsing

Write-Output 'Downloading installer signature...'
$sigResponse = Invoke-WebRequest -Uri 'https://composer.github.io/installer.sig' -UseBasicParsing
if ($sigResponse.Content -is [byte[]]) {
    $sig = [System.Text.Encoding]::UTF8.GetString($sigResponse.Content).Trim()
} else {
    $sig = $sigResponse.Content.ToString().Trim()
}

Write-Output 'Computing local hash...'
$hash = (Get-FileHash -Algorithm SHA384 -Path $installer).Hash.ToLower()

if ($hash -ne $sig.ToLower()) {
    Write-Error 'ERROR: Invalid installer signature'
    Remove-Item $installer -ErrorAction SilentlyContinue
    exit 1
}

Write-Output 'Signature OK. Running installer...'
& 'C:\xampp\php\php.exe' $installer --install-dir='C:\xampp\php' --filename='composer.phar'

Write-Output 'Writing composer.bat wrapper...'
Set-Content -Path 'C:\xampp\php\composer.bat' -Value '@ECHO OFF`r`nphp "%~dp0composer.phar" %*' -Encoding Ascii

Remove-Item $installer -ErrorAction SilentlyContinue

Write-Output 'Verifying composer...'
composer --version
