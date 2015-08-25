<?php

use Picturae\Genealogy\Client;
use Picturae\Genealogy\Date;
use Picturae\Genealogy\URL;

// Make sure you run composer install first
require __DIR__ . '/../vendor/autoload.php';

// Change to your API key
$apiKey = '509544d0-1c67-11e4-9016-c788dee409dc';

$url = new URL;
$client = new Client($apiKey);

// Fetch all data when we are on a detail page
$deed = null;
$persons = null;
$register = null;
if ($url->isDeedDetail()) {
    $id = $url->getDeedUUID();
    $deed = $client->getDeed($id);
    if (!empty($deed)) {
        $persons = $client->getPersons(['q' => 'deed_id:"' . $deed->id . '"'])->person;
        $register = $client->getRegister($deed->register_id);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8 />
	<title>Genealogy demo</title>

        <script src="//images.memorix.nl/topviewer/1.0/src/topviewer.compressed.js?v=1.0" type="text/javascript"></script>
        <!-- Genealogy JS -->
        <script src="//webservices.picturae.com/genealogy/dist/js/deps.min.js"></script>
        <script src="//webservices.picturae.com/genealogy/dist/js/partials/partials.min.js"></script>
        <script src="//webservices.picturae.com/genealogy/dist/js/app.js"></script>
        <script type="text/javascript" src="//assets.pinterest.com/js/pinit.js" data-pin-build="parsePins"></script>

        <link rel="stylesheet" href="//webservices.picturae.pro/genealogy/dist/css/genealogy.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ng-dialog/0.3.0/css/ngDialog.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ng-dialog/0.3.0/css/ngDialog-theme-plain.min.css">

        <!--[if lte IE 9]>
            <script type="text/javascript" src="http://webservices.picturae.com/genealogy/js/xdomain/xdomain.min.js"></script>
            <script>
                xdomain.slaves({
                    "http://webservices.picturae.com": "/genealogy/proxy.html"
                });
            </script>
        <![endif]-->
        <base href="http://localhost/" />

        <?php if (!empty($register->metadata->type_title)): // add opengraph title ?>
            <meta property="og:title" content="<?=htmlspecialchars($register->metadata->type_title)?>" />
        <?php endif;?>

        <?php if (!empty($deed->asset[0]->{'thumb.large'})): // add opengraph image ?>
            <meta property="og:image" content="<?=$deed->asset[0]->{'thumb.large'}?>" />
        <?php endif;?>
</head>
<body>
    <noscript>
        <?php if (!empty($register->metadata->naam)):?>
            <h1><?=htmlspecialchars($register->metadata->naam)?></h1>
        <?php endif;?>
        <h2>Register</h2>
        <ul class="register">
            <?php if (!empty($register->metadata->type_title)):?>
                <li>
                    <span class="label">Source</span>
                    <span class="value"><?=$register->metadata->type_title?></span>
                </li>
            <?php endif;?>
            <?php if (!empty($register->metadata->archiefnummer)):?>
                <li>
                    <span class="label">Archive number</span>
                    <span class="value"><?=$register->metadata->archiefnummer?></span>
                </li>
            <?php endif;?>
            <?php if (!empty($register->metadata->inventarisnummer)):?>
                <li>
                    <span class="label">Inventory number</span>
                    <span class="value"><?=$register->metadata->inventarisnummer?></span>
                </li>
            <?php endif;?>
            <?php if (!empty($register->metadata->gemeente)):?>
                <li>
                    <span class="label">Municipality</span>
                    <span class="value"><?=$register->metadata->gemeente?></span>
                </li>
            <?php endif;?>
        </ul>

        <h2>Deed</h2>
        <ul>
            <?php if (!empty($deed->metadata->nummer)):?>
                <li>
                    <span class="label">Archive number</span>
                    <span class="value"><?=$deed->metadata->nummer?></span>
                </li>
            <?php endif;?>
            <?php if (!empty($deed->metadata->datum)):?>
                <li>
                    <span class="label">Date</span>
                    <span class="value"><?=(new Date($deed->metadata->datum))->getFormat()?></span>
                </li>
            <?php endif;?>
        </ul>

        <h2>Person(s)</h2>
        <ul class="persons">
            <?php foreach ($persons as $person):  // Provide a html fallback for persons on this page ?>
                <li itemscope itemtype="http://schema.org/Person">
                    <?php if (!empty($person->metadata->type_title)) :?>
                        <h4><?=htmlspecialchars($person->metadata->type_title)?></h4>
                    <?php endif;?>
                    <?php if (!empty($person->metadata->voornaam)) :?>
                        <span itemprop="givenName"><?=htmlspecialchars($person->metadata->voornaam)?></span>
                    <?php endif;?>
                    <?php if (!empty($person->metadata->tussenvoegsel)) :?>
                        <span itemprop="additionalName"><?=htmlspecialchars($person->metadata->tussenvoegsel)?></span>
                    <?php endif;?>
                    <?php if (!empty($person->metadata->achternaam)) :?>
                        <span itemprop="familyName"><?=htmlspecialchars($person->metadata->achternaam)?></span>
                    <?php endif;?>
                </li>
            <?php endforeach;?>
        </ul>
    </noscript>
    <div id="pic-genealogy"
        ui-view
        data-url="http://webservices.picturae.com/genealogy/"
        data-api-key="<?=$apiKey?>"
        data-pagination-rows="25"
        data-language="en_GB"></div>
</body>
</html>