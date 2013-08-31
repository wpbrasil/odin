<?php
/**
 * Odin_Contact_Form class.
 *
 * Built Contact Forms.
 *
 * @package  Odin
 * @category Contact Form
 * @author   WPBrasil
 * @version  2.0.0
 */
class Odin_Contact_Form extends Odin_Front_End_Form {

    /**
     * Mail content type.
     *
     * @var array
     */
    protected $content_type = 'text/plain';

    /**
     * Contact Form construct.
     *
     * @param string $id         Form id.
     * @param mixed  $to         String with recipient or array with recipients.
     * @param array  $cc         Array with CC recipients.
     * @param array  $bcc        Array with BCC recipients.
     * @param array  $attributes Form attributes.
     */
    public function __construct( $id, $to, $cc = array(), $bcc = array(), $attributes = array() ) {
        $this->id         = $id;
        $this->to         = $to;
        $this->cc         = $cc;
        $this->bcc        = $bcc;
        $this->attributes = $attributes;

        parent::__construct( $this->id, '', 'post', $this->attributes );

        // Hooks send_mail.
        add_action( 'odin_front_end_form_submitted_data_' . $this->id, array( $this, 'send_mail' ) );
    }

    /**
     * Set the mail content type.
     *
     * @param string $content_type Mail content type.
     */
    public function set_content_type( $content_type ) {
        if ( 'html' == $content_type )
            $this->content_type = 'text/html';
    }

    /**
     * Process the sent form data.
     *
     * @param  array $submitted_data Submitted data.
     *
     * @return array                 Processed sent data.
     */
    protected function process_submitted_form_data( $submitted_data ) {
        $data = array();

        // Process the fields.
        if ( ! empty( $this->fields ) && ! empty( $submitted_data ) ) {
            foreach ( $this->fields as $fieldset ) {
                foreach ( $fieldset['fields'] as $field ) {
                    $id       = $field['id'];
                    $label    = isset( $field['label'] ) ? $field['label'] : $id;

                    $data[ $label ] = $submitted_data[ $id ];
                }
            }
        }

        return $data;
    }

    /**
     * Build the mail message.
     *
     * @param  array  $submitted_data Form submitted data.
     *
     * @return string                 Mail HTML message.
     */
    protected function build_mail_message( $submitted_data ) {
        $message = '';

        // Sets the message header.
        $message .= do_action( 'odin_contact_form_message_header_' . $this->id );

        // Gets the submitted data.
        $data = $this->process_submitted_form_data( $submitted_data );

        // Sets the message content.
        foreach ( $data as $label => $value ) {
            if ( 'text/html' == $this->content_type )
                $message .= sprintf( '<strong>%s:</strong>%s', strip_tags( $label ), wpautop( strip_tags( $value ) ) );
            else
                $message .= sanitize_text_field( $label . ': ' . $value ) . PHP_EOL;
        }

        // Sets the message footer.
        $message .= do_action( 'odin_contact_form_message_footer_' . $this->id );

        return $message;
    }

    /**
     * Format the mail headers.
     *
     * @return array Mail headers.
     */
    protected function format_mail_headers() {
        $headers = array();

        // Cc.
        if ( ! empty( $this->cc ) ) {
            foreach ( $this->cc as $cc )
                $headers[] = 'Cc: ' . $cc;
        }

        // Bc.
        if ( ! empty( $this->bcc ) ) {
            foreach ( $this->bcc as $bcc )
                $headers[] = 'Bcc: ' . $bcc;
        }

        // Content type.
        if ( 'text/html' == $this->content_type )
            $headers[] = 'Content-type: text/html; charset=' . get_bloginfo( 'charset' );

        return $headers;
    }

    /**
     * Send the mail.
     *
     * @param  array $submitted_data Submitted form data.
     *
     * @return void
     */
    public function send_mail( $submitted_data ) {
        if ( ! empty( $submitted_data ) ) {
            $message = $this->build_mail_message( $submitted_data );
            $headers = $this->format_mail_headers();

            // Send mail.
            wp_mail( $this->to, 'The subject', $message, $headers );
        }
    }

}
