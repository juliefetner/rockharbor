<?php
$mailchimp = $theme->options('mailchimp_id');
?>
<div class="newsletter">
    <h3>E-Bulletin</h3>
    <form action="http://rockharbor.us4.list-manage.com/subscribe/post?u=185dbb9016568292b89c8731c&amp;id=06151f2612" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
        <input placeholder="Email Address" type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
        <input type="hidden" value="<?php echo $mailchimp; ?>" name="group[405][<?php echo $mailchimp; ?>]">
        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
    </form>
</div>
