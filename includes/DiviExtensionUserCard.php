<?php
function getBioProfile($data){
	$bio_profile = get_userdata($data['id']);
	$bio_profile->twitter = get_the_author_meta( 'twitter', $data['id'] );
	$bio_profile->facebook = get_the_author_meta( 'facebook', $data['id'] );
	$bio_profile->linkedin = get_the_author_meta( 'linkedin', $data['id'] );
	$bio_profile->direct_phone = get_the_author_meta( 'direct_phone', $data['id'] );
	$bio_profile->job_title = get_the_author_meta( 'job_title', $data['id'] );
	$bio_profile->description = get_the_author_meta( 'description', $data['id'] );
	$bio_profile->image = get_the_author_meta( 'image', $data['id'] );
	if($bio_profile->display_name!=""){
		$bio_profile->name = $bio_profile->display_name;
	} else {
		$bio_profile->name = $bio_profile->first_name . ' ' . $bio_profile->last_name;
	}
	$bio_profile->firstName = $bio_profile->first_name;
	$bio_profile->avatar = get_avatar_url($data['id']);
	$thumbnail_id = get_avatar_url($data['id']);
	$bio_profile->image_alt = $name;
	$bio_profile->url = $bio_profile->user_url;
	return $bio_profile;
}
add_action( 'rest_api_init', function () {
	register_rest_route( 'divieuc/v1', '/bio_profile/(?P<id>\d+)', array(
	  'methods' => 'GET',
	  'callback' => 'getBioProfile',
	  'args' => array(
		'id' => array(
		  'validate_callback' => function($param, $request, $key) {
			return is_numeric( $param );
		  }
		),
	  ),
	) );
  } );
class DIVIUSERCARD_DiviExtensionUserCard extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'diviusercard-divi-extension-user-card';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-extension-user-card';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * DIVIUSERCARD_DiviExtensionUserCard constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-extension-user-card', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new DIVIUSERCARD_DiviExtensionUserCard;
