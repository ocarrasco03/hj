<?php

/**
 * Global CDN link helper function
 *
 * @param string $asset
 * @return string
 */
function cdn($asset)
{
    // Verify if CDN URLs are present in the config file
    if (config('cdn.domains'))
        return asset($asset);

    // Get file name incl extension and CDN URLs
    $cdns = config('cdn.domains');
    $assetName = basename($asset);

    // Remove query string
    $assetName = explode('?', $assetName);
    $assetName = $assetName[0];

    // Select the CDN URL based on the extension
    foreach ($cdns as $cdn => $types) {
        if (preg_match('/^.*\.(' . $types . ')$/i', $assetName))
            return cdnPath($cdn, $asset);
    }

    // In case of no match use the last in the array
    end($cdns);

    return cdnPath(key($cdns), $asset);
}

/**
 * CDN url path
 *
 * @param string $cdn
 * @param string $asset
 * @return string
 */
function cdnPath($cdn, $asset)
{
    return config('cdn.protocol') . '://' . rtrim($cdn, '/') . '/' . ltrim($asset, '/');
}
