<?php
/**
 * Odin_Contact_Form class.
 *
 * Built Contact Forms.
 *
 * @package  Odin
 * @category Contact Form
 * @author   WPBrasil
 * @version  2.3.0
 */
class Odin_Contact_Form extends Odin_Front_End_Form {

	/**
	 * Mail content type.
	 *
	 * @var array
	 */
	protected $content_type = 'text/plain';

	/**
	 * Mail subject.
	 *
	 * @var string
	 */
	protected $subject = '';

	/**
	 * Mail Reply-To.
	 *
	 * @var string
	 */
	protected $reply_to = '';

	/**
	 * Contact Form construct.
	 *
	 * @param string $id              Form id.
	 * @param mixed  $to              String with recipient or array with recipients.
	 * @param array  $cc              Array with CC recipients.
	 * @param array  $bcc             Array with BCC recipients.
	 * @param array  $attributes      Form attributes.
	 * @param array  $attachment_type file or url in email body.
	 */
	public function __construct( $id, $to, $cc = array(), $bcc = array(), $attributes = array(), $attachment_type = 'file' ) {
		$this->id              = $id;
		$this->to              = $to;
		$this->cc              = $cc;
		$this->bcc             = $bcc;
		$this->attributes      = $attributes;
		$this->attachment_type = $attachment_type;

		parent::__construct( $this->id, '', 'post', $this->attributes );

		// Hooks send_mail.
		add_action( 'odin_front_end_form_submitted_data_' . $this->id, array( $this, 'send_mail' ), 1, 2 );
	}

	/**
	 * Set the mail content type.
	 *
	 * @param string $content_type Mail content type.
	 */
	public function set_content_type( $content_type ) {
		if ( 'html' == $content_type ) {
			$this->content_type = 'text/html';
		}
	}

	/**
	 * Set the mail subject.
	 *
	 * @param string $subject Mail subject.
	 */
	public function set_subject( $subject ) {
		$this->subject = $subject;
	}

	/**
	 * Mail Reply-To.
	 *
	 * @param string
	 */
	public function set_reply_to( $reply_to ) {
		$this->reply_to = $reply_to;
	}

	/**
	 * Process the sent form data.
	 *
	 * @param  array $submitted_data Submitted data.
	 * @param  array $$attachments   Submitted attachments.
	 *
	 * @return array                 Processed sent data.
	 */
	protected function process_submitted_form_data( $submitted_data, $attachments ) {
		$data = array();

		// Process the fields.
		if ( ! empty( $this->fields ) && ! empty( $submitted_data ) ) {
			foreach ( $this->fields as $fieldset ) {
				foreach ( $fieldset['fields'] as $field ) {
					if ( 'file' != $field['type'] ) {
						$id    = $field['id'];
						$label = isset( $field['label'] ) ? $field['label'] : $id;

						$data[ $label ] = $submitted_data[ $id ];
					} elseif ( 'file' == $field['type'] && 'url' == $this->attachment_type ) {
						$id    = $field['id'];
						$label = isset( $field['label'] ) ? $field['label'] : $id;
						$url   = $attachments[ $id ]['url'];

						$data[ $label ] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';
					}
				}
			}
		}

		return $data;
	}

	/**
	 * Build the mail message.
	 *
	 * @param  array  $submitted_data Form submitted data.
	 * @param  array  $$attachments   Form submitted attachments.
	 *
	 * @return string                 Mail HTML message.
	 */
	protected function build_mail_message( $submitted_data, $attachments ) {
		// Sets the message header.
		$message = apply_filters( 'odin_contact_form_message_header_' . $this->id, '' );

		// Gets the submitted data.
		$data = $this->process_submitted_form_data( $submitted_data, $attachments );

		// Sets the message content.
		foreach ( $data as $label => $value ) {
			if ( 'text/html' == $this->content_type ) {
				$message .= sprintf( '<strong>%s:</strong>%s', wp_kses( $label, array() ), wpautop( wp_kses( $value, array() ) ) );
			} else {
				$message .= sanitize_text_field( $label . ': ' . $value ) . PHP_EOL;
			}
		}

		// Sets the message footer.
		$message .= apply_filters( 'odin_contact_form_message_footer_' . $this->id, '' );

		return $message;
	}

	/**
	 * Build the mail subject.
	 *
	 * @param  array  $submitted_data Form submitted data.
	 *
	 * @return string                 Mail subject.
	 */
	protected function build_mail_subject( $submitted_data ) {
		if ( ! empty( $this->subject ) ) {
			$subject = $this->subject;

			// Create the placeholders.
			$placeholders = array_merge(
				array(
					'form_id' => $this->id,
					'sent_date' => date( get_option( 'date_format' ) ),
					'sent_time' => date( get_option( 'time_format' ) )
				),
				$submitted_data
			);

			// Process the placeholders.
			foreach ( $placeholders as $placeholder => $value ) {
				$subject = str_replace( '[' . $placeholder . ']', sanitize_text_field( $value ), $subject );
			}

			return $subject;
		} else {
			// Default subject.
			return sprintf(
				__( 'Message sent by the form %s in %s at %s', 'odin' ),
				$this->id,
				date( get_option( 'date_format' ) ),
				date( get_option( 'time_format' ) )
			);
		}
	}

	/**
	 * Get attachments paths.
	 *
	 * @param  array $attachments Submitted attachments.
	 *
	 * @return array              Paths.
	 */
	protected function get_attachments_paths( $attachments ) {
		$paths = array();

		foreach ( $attachments as $attachment ) {
			$paths[] = $attachment['file'];
		}

		return $paths;
	}

	/**
	 * Format the mail headers.
	 *
	 * @param  array  $submitted_data Form submitted data.
	 *
	 * @return array                  Mail headers.
	 */
	protected function format_mail_headers( $submitted_data ) {
		$headers = array();

		// Cc.
		if ( ! empty( $this->cc ) ) {
			foreach ( $this->cc as $cc ) {
				$headers[] = 'Cc: ' . $cc;
			}
		}

		// Bc.
		if ( ! empty( $this->bcc ) ) {
			foreach ( $this->bcc as $bcc ) {
				$headers[] = 'Bcc: ' . $bcc;
			}
		}

		// Reply-To.
		if ( ! empty( $this->reply_to ) ) {
			$headers[] = 'Reply-To: ' . sanitize_email( $submitted_data[ $this->reply_to ] );
		}

		// Content type.
		if ( 'text/html' == $this->content_type ) {
			$headers[] = 'Content-type: text/html; charset=' . get_bloginfo( 'charset' );
		}

		return apply_filters( 'odin_contact_form_mail_headers_' . $this->id, $headers );
	}

	/**
	 * Send the mail.
	 *
	 * @param array $submitted_data Submitted form data.
	 */
	public function send_mail( $submitted_data, $attachments ) {
		if ( ! empty( $submitted_data ) ) {
			// Mail subject.
			$subject = $this->build_mail_subject( $submitted_data );

			// Mail message.
			$message = $this->build_mail_message( $submitted_data, $attachments );

			// Mail headers.
			$headers = $this->format_mail_headers( $submitted_data );

			// Send mail.
			if ( 0 < count( $attachments ) && 'file' == $this->attachment_type ) {
				$files = $this->get_attachments_paths( $attachments );
			} else {
				$files = '';
			}

			wp_mail( $this->to, $subject, $message, $headers, $files );
		}
	}

}
