<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div id="<?= $this->pageSlug ?>" class="wrap">
    <?= settings_errors( null, null, true ) ?>
    <h1><?= $this->pageTitle ?></h1>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?= do_settings_sections($this->pageSlug) ?>
        <?= submit_button() ?>
    </form>
    <hr>
    <h3>Shortcodes</h3>
    <p>Bulletin Shortcode: [bulletins]</p>
    <p>Cover shortcode: [bulletin_cover]</p>
	<p>Signup shortcode: [bulletin_signup]</p>
    <hr>
    <h3>Shortcode Parameters - Will override plugin settings.</h3>
    <ul>
        <li>"id" - Integer, 4 digit Diocesan bulletin ID</li>
        <li>"quantity" - Integer, Number of bulletins to display. Max is 12. (Not supported by Cover shortcode)</li>
        <li>"title" - Label of the bulletin, will be the published date of the bulletin if left blank.</li>
		<li>"open_in_new_tab" - Boolean, whether or not to open bulletins in a new tab.</li>
		<li>"show_signup" - Boolean, whether or not to show the Email Notificaiton signup section.  Applies to basic list.</li>
		<li>"format" - Name of template to use.  Options are "Accordion" and "Tabs".  Defaults to basic list.</li>
		<li>"offset" - Integer, number of weeks to skip.</li>
    </ul>
    <hr>
	<h3>Custom Format</h3>
	<p>This plugin supports custom theme driven formats.  Should you want to create your own format, simply copy /templates/default.php as a starting point, and paste it in /your-theme/dpi-bulletins/.  Rename the file to be the name of your format.  For example, if you wanted to use [bulletins format="Masonry"], you would name the file masonry.php.  You can add a your-format.js and your-format.css file to /your-theme/dpi-bulletins/ where your-format uses the same name, ie masonry.css.</p>
     <ul>
        <li>"id" - Integer, 4 digit Diocesan bulletin ID</li>
        <li>"quantity" - Integer, Number of bulletins to display. Max is 12. (Not supported by Cover shortcode)</li>
        <li>"title" - Label of the bulletin, will be the published date of the bulletin if left blank.</li>
		<li>"open_in_new_tab" - Boolean, whether or not to open bulletins in a new tab.</li>
		<li>"format" - Name of template to use.  Options are "Accordion" and "Tabs".  Defaults to basic list.</li>
		<li>"offset" - Integer, number of weeks to skip.</li>
    </ul>
    <hr>
    <h3>Getting the raw data</h3>
    <p>In some cases it's easier to work with a raw array of bulletins instead of using the shortcodes or widget.</p>
    <pre style="background-color: #004852">
<code style="background: none; color: springgreen;">
	<span style="color: orangered">$Controller</span> = Bulletins\Plugin\Controller::getInstance();
	<span style="color: orangered">$bulletinID</span> = $Controller->getBulletinID();
	<span style="color: orangered">$bulletins</span> = $Controller->Transport->getBulletins($bulletinID, 10);
	
	<span style="color: #ddd">
	// $bulletins will be an array of arrays where each item represents a bulletin:
	//
	// Array(
	//    [07-30-2018.pdf] => Array(
	//        'date' => '2018-07-30',
	//        'links' => Array(
	//            'bulletin' => '//link to bulletin pdf',
	//            'cover' => '//link to bulletin cover'
	//        ),
	//        'new_tab' => false
	//    ),
	//    [07-23-2018.pdf] => Array(
	//        'date' => '2018-07-23',
	//        'links' => Array(
	//            'bulletin' => '//link to bulletin pdf',
	//            'cover' => '//link to bulletin cover'
	//        ),
	//        'new_tab' => false
	//    ),
	//    etc...
	// );
	//
	// In the case that there is an error or the $bulletinID is not valid $Controller->Transport->getBulletins() will return false.
	</span>
</code>
    </pre>
</div>