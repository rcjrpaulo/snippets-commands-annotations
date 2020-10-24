<?php

$root = getcwd();
$envPath = $root.'/.env';

$version = get_assets_version($envPath);
$newVersion = $version + 1;

replace_env_line($envPath, 'ASSETS_VERSION='.$version, 'ASSETS_VERSION='.$newVersion);


function get_assets_version($envPath)
{
    $envContent = file_get_contents($envPath);
    preg_match('#ASSETS_VERSION=(\d)+#', $envContent,$assetsLine);
    preg_match('#(\d)+#', $assetsLine[0],$version);

    return $version[0];
}

function replace_env_line($envPath, $actualLine, $newLine)
{
    $envContent = file_get_contents($envPath);
    $newEnvContent = str_replace($actualLine, $newLine, $envContent);
    file_put_contents($envPath, $newEnvContent);
}