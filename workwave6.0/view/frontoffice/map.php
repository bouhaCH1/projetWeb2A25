<section class="ww-page">
    <h1>Nearby Network</h1>
    <form class="ww-filter" method="get"><input type="hidden" name="r" value="map"><input name="lat" value="<?= e((string)$lat) ?>" placeholder="Latitude"><input name="lng" value="<?= e((string)$lng) ?>" placeholder="Longitude"><input name="radius" value="<?= e((string)$radius) ?>" placeholder="Radius km"><button>Update</button></form>
    <div id="ww-map" data-lat="<?= e((string)$lat) ?>" data-lng="<?= e((string)$lng) ?>" data-freelancers='<?= e(json_encode($freelancers)) ?>' data-companies='<?= e(json_encode($companies)) ?>'></div>
    <div class="ww-grid-2">
        <section class="ww-box"><h2>Nearby Freelancers</h2><?php foreach ($freelancers as $f): ?><p><?= e($f['display_name']) ?> · <?= round((float)$f['distance_km'], 1) ?> km</p><?php endforeach; ?></section>
        <section class="ww-box"><h2>Nearby Companies</h2><?php foreach ($companies as $c): ?><p><?= e($c['display_name']) ?> · <?= round((float)$c['distance_km'], 1) ?> km</p><?php endforeach; ?></section>
    </div>
</section>
