<h1><?= _("Blubber an andere Netzwerke andocken") ?></h1>

<section class="contentbox">
    <header>
        <h1><?= _("Twitter") ?></h1>
    </header>

    <div style="margin: 10px;">

        <div style="text-align: center;">
            <?= \Studip\LinkButton::create(_("Verbindung zu Twitter herstellen"), URLHelper::getURL("https://api.twitter.com/oauth/authenticate", array('auth_token' => get_config("BLUBBER_TWITTER_API_KEY")))) ?>
        </div>

    </div>
</section>

