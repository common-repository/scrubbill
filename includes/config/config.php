<?php
/**
 * Configs used throughout the plugin.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

define( 'SCRUBBILL_DIR', trailingslashit( dirname( dirname( __DIR__ ) ) ) );
define( 'SCRUBBILL_URL', trailingslashit( plugins_url( 'scrubbill', dirname( dirname( __DIR__ ) ) ) ) );
