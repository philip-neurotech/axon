<?php
namespace ElementorPro\Modules\Forms\Classes;

use Elementor\Utils;
use ElementorPro\Modules\Forms\Module;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Ajax_Handler {

	public $is_success = true;
	public $messages = [
		'success' => [],
		'error' => [],
	];
	public $data = [];
	public $errors = [];

	private $current_form;

	const SUCCESS = 'success';
	const ERROR = 'error';
	const FIELD_REQUIRED = 'required_field';
	const INVALID_FORM = 'invalid_form';
	const SERVER_ERROR = 'server_error';
	const SUBSCRIBER_ALREADY_EXISTS = 'subscriber_already_exists';

	public static function is_form_submitted() {
		return Utils::is_ajax() && isset( $_POST['action'] ) && 'elementor_pro_forms_send_form' === $_POST['action'];
	}

	public static function get_default_messages() {
		return [
			self::SUCCESS => __( 'The form was sent successfully!', 'elementor-pro' ),
			self::ERROR => __( 'There\'s something wrong... Please fill in the required fields.', 'elementor-pro' ),
			self::FIELD_REQUIRED => __( 'Required', 'elementor-pro' ),
			self::INVALID_FORM => __( 'There\'s something wrong... The form is invalid.', 'elementor-pro' ),
			self::SERVER_ERROR => __( 'Server error. Form not sent.', 'elementor-pro' ),
			self::SUBSCRIBER_ALREADY_EXISTS => __( 'Subscriber already exist.', 'elementor-pro' ),
		];
	}

	public static function get_default_message( $id, $settings ) {
		if ( ! empty( $settings['custom_messages'] ) ) {
			$field_id = $id . '_message';
			if ( isset( $settings[ $field_id ] ) ) {
				return $settings[ $field_id ];
			}
		}

		$default_messages = self::get_default_messages();

		return isset( $default_messages[ $id ] ) ? $default_messages[ $id ] : __( 'Unknown', 'elementor-pro' );
	}

	public function ajax_send_form() {
		$post_id = $_POST['post_id'];

		$form_id = $_POST['form_id'];

		$elementor = Plugin::elementor();

		$meta = $elementor->db->get_plain_editor( $post_id );

		$form = Module::find_element_recursive( $meta, $form_id );

		if ( ! $form ) {
			$this
				->add_error_message( self::get_default_message( self::INVALID_FORM, $form['settings'] ) )
				->send();
		}

		if ( ! empty( $form['templateID'] ) ) {
			$global_meta = $elementor->db->get_plain_editor( $form['templateID'] );
			$form = $global_meta[0];
		}

		// restore default values
		$widget = $elementor->elements_manager->create_element_instance( $form );
		$form['settings'] = $widget->get_active_settings();
		$form['settings']['id'] = $form_id;

		$this->current_form = $form;

		if ( empty( $form['settings']['form_fields'] ) ) {
			$this
				->add_error_message( self::get_default_message( self::INVALID_FORM, $form['settings'] ) )
				->send();
		}

		$record = new Form_Record( $_POST['form_fields'], $form );

		if ( ! $record->validate( $this ) ) {
			$this
				->add_error( $record->get( 'errors' ) )
				->add_error_message( self::get_default_message( self::ERROR, $form['settings'] ) )
				->send();
		}

		$module = Module::instance();

		$actions = $module->get_form_actions();

		foreach ( $actions as $action ) {
			if ( in_array( $action->get_name(), $form['settings']['submit_actions'] ) ) {
				$action->run( $record, $this );
			}
		}

		$activity_log = $module->get_component( 'activity_log' );
		if ( $activity_log ) {
			$activity_log->run( $record, $this );
		}

		$cf7db = $module->get_component( 'cf7db' );
		if ( $cf7db ) {
			$cf7db->run( $record, $this );
		}

		do_action( 'elementor_pro/forms/new_record', $record, $this );

		$this->send();
	}

	public function add_success_message( $message ) {
		$this->messages['success'][] = $message;

		return $this;
	}

	public function add_response_data( $key, $data ) {
		$this->data[ $key ] = $data;

		return $this;
	}

	public function add_error_message( $message ) {
		$this->messages['error'][] = $message;
		$this->set_success( false );

		return $this;
	}

	public function add_error( $field, $message = '' ) {
		if ( is_array( $field ) ) {
			$this->errors += $field;
		} else {
			$this->errors[ $field ] = $message;
		}

		$this->set_success( false );

		return $this;
	}

	public function set_success( $bool ) {
		$this->is_success = $bool;

		return $this;
	}

	public function send() {
		if ( $this->is_success ) {
			wp_send_json_success( [
				'message' => $this->get_default_message( self::SUCCESS, $this->current_form['settings'] ),
				'data' => $this->data,
			] );
		}

		if ( empty( $this->messages['error'] ) && ! empty( $this->errors ) ) {
			$this->add_error_message( $this->get_default_message( self::INVALID_FORM, $this->current_form['settings'] ) );
		}

		$error_msg = __( 'There\'s something wrong...', 'elementor-pro' );
		if ( current_user_can( 'edit_post', $_POST['post_id'] ) ) {
			$this->add_error_message( __( 'This Message is not visible for site visitors.', 'elementor-pro' ) );
			$error_msg = implode( '<br>', $this->messages['error'] );
		}

		wp_send_json_error( [
			'message' => $error_msg,
			'errors' => $this->errors,
			'data' => $this->data,
		] );
	}

	public function __construct() {
		add_action( 'wp_ajax_elementor_pro_forms_send_form', [ $this, 'ajax_send_form' ] );
		add_action( 'wp_ajax_nopriv_elementor_pro_forms_send_form', [ $this, 'ajax_send_form' ] );
	}
}
