<?php
use \App\Services\Front\Front;
use \App\Core\Framework;
?>
<div style="margin: 0 auto;background-color: #cdcdcd;height: auto;width: 60%;border-radius: 4px;">
    <div style="padding-top: 15px;padding-bottom: 20px;text-align: center;"><a href="<?= Framework::getUrl('app_home'); ?>" target="_blank"><img src="<?= Framework::getResourcesPath('images/logoSiteSignIn.svg'); ?>" alt=""></a></div>
    <div style="margin: 0 auto;border: solid 1.5px #5d5d5d;width: 80%;"></div>
    <div style="text-align: center"><p style="line-break: strict;"><?= $content; ?></p></div>
    <div style="margin: 0 auto;border: solid 1.5px #5d5d5d;width: 80%;"></div>
    <div style="text-align: center; padding: 7px 10px;margin: 7px 10px;"><a href="<?= Framework::getUrl('app_home'); ?>" target="_blank"><button style="cursor: pointer;display: inline-block;font-weight: 700;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;padding: 0.3rem 0.55rem;font-size: 1rem;border-radius: 0.25rem;border-style: solid;color: #FFFFFF;background-color: #30475e;border-color: #30475e"><?= Front::getSiteName(); ?></button></a></div>
</div>
