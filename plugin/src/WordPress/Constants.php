<?php

declare(strict_types=1);

namespace DRPT\WordPress;

/**
 * Plugin-wide constants.
 *
 * Centralises values that are referenced across multiple classes or that
 * benefit from a single source of truth (e.g. option key names, REST namespace).
 *
 * Values tightly coupled to a single class (e.g. TokenIssuer meta keys,
 * IssueEndpoint::NO_EXPIRY_SECONDS) remain in their respective classes.
 */
final class Constants
{
    // ── REST API ─────────────────────────────────────────────────────────────

    public const REST_NAMESPACE = 'preview-token/v1';

    public const ROUTE_TOKEN   = '/token';
    public const ROUTE_PREVIEW = '/preview';

    /** Post statuses that may be previewed via a token. */
    public const PREVIEWABLE_STATUSES = ['draft', 'pending', 'future'];

    // ── wp_options keys ──────────────────────────────────────────────────────

    public const OPTION_FRONTEND_URL        = 'drpt_frontend_url';
    public const OPTION_ALLOWED_ORIGINS     = 'drpt_allowed_origins';
    public const OPTION_MIN_CAPABILITY      = 'drpt_min_capability';
    public const OPTION_RATE_LIMIT_REQUESTS = 'drpt_rate_limit_requests';
    public const OPTION_RATE_LIMIT_WINDOW   = 'drpt_rate_limit_window';
    public const OPTION_ALLOW_NO_EXPIRY         = 'drpt_allow_no_expiry';
    public const OPTION_SKIP_HTTPS_CHECK        = 'drpt_skip_https_check';
    public const OPTION_ALLOW_EXTERNAL_ISSUANCE = 'drpt_allow_external_issuance';

    // ── Action / filter hooks ─────────────────────────────────────────────────

    // HOOK_TOKEN_ISSUED is defined on TokenIssuer::HOOK_TOKEN_ISSUED (Token layer owns it)
    public const HOOK_TOKEN_USED                = 'drpt_token_used';
    public const HOOK_INVALID_TOKEN             = 'drpt_invalid_token';
    public const HOOK_RATE_LIMIT_EXCEEDED       = 'drpt_rate_limit_exceeded';
    public const HOOK_CAPABILITY_DENIED         = 'drpt_capability_denied';
    public const HOOK_CLEANUP_TOKENS            = 'drpt_cleanup_tokens';
    public const HOOK_SETTINGS_RENDER_TOKENS_TAB = 'drpt_settings_render_tokens_tab';
    public const FILTER_PREVIEW_RESPONSE_DATA   = 'drpt_preview_response_data';

    // ── admin-post actions & nonce bases ─────────────────────────────────────

    public const ADMIN_ACTION_DELETE_TOKEN   = 'drpt_delete_token';
    public const ADMIN_ACTION_DELETE_EXPIRED = 'drpt_delete_expired';
    // Nonce: NONCE_DELETE_TOKEN . "_{$post_id}"
    public const NONCE_DELETE_TOKEN   = 'drpt_delete_token';
    public const NONCE_DELETE_EXPIRED = 'drpt_delete_expired';

    // ── Settings page ─────────────────────────────────────────────────────────

    public const SETTINGS_PAGE_SLUG = 'draft-preview-token';
    public const SETTINGS_GROUP     = 'drpt_settings';
    public const SETTINGS_SECTION   = 'drpt_main';

    // ── Script handles ────────────────────────────────────────────────────────

    public const SCRIPT_SIDEBAR        = 'drpt-sidebar';
    public const SCRIPT_QUICK_EDIT     = 'drpt-quick-edit';
    public const SCRIPT_CLASSIC_EDITOR = 'drpt-classic-editor';
    public const SCRIPT_SETTINGS       = 'drpt-settings';

    // ── JS global variable names (wp_localize_script) ─────────────────────────

    public const JS_PREVIEW_DATA  = 'drptPreviewData';
    public const JS_SETTINGS_DATA = 'drptSettingsData';

    // ── HTML element IDs ─── kept in sync with constants.ts ELEMENT_* ─────────

    public const ELEMENT_CLASSIC_ROOT     = 'drpt-classic-meta-box-root';
    public const ELEMENT_ORIGINS_LIST     = 'drpt-origins-list';
    public const ELEMENT_ADD_ORIGIN       = 'drpt-add-origin';
    public const ELEMENT_WILDCARD_WARNING = 'drpt-wildcard-warning';

    // ── CSS classes ─── kept in sync with constants.ts CLASS_* ───────────────

    public const CLASS_ORIGIN_ROW    = 'drpt-origin-row';
    public const CLASS_REMOVE_ORIGIN = 'drpt-remove-origin';

    // ── data attributes ─── kept in sync with constants.ts ATTR_* ────────────

    public const ATTR_PANEL  = 'data-drpt-panel';
    public const ATTR_ACTION = 'data-drpt-action';

    // ── Meta box ID ───────────────────────────────────────────────────────────

    public const META_BOX_ID = 'drpt-preview';

    // ── Transient key prefixes ────────────────────────────────────────────────

    public const TRANSIENT_PREFIX_RATE_LIMITER = 'drpt_rl_';

    // ── Audit log ─────────────────────────────────────────────────────────────

    public const LOG_PREFIX        = '[drpt]';
    /** Name of the PHP define() constant set in the plugin bootstrap file. */
    public const DEFINE_PLUGIN_FILE = 'DRPT_PLUGIN_FILE';
    /** Name of the PHP define() constant users set in wp-config.php. */
    public const DEFINE_LOG_FILE        = 'DRPT_LOG_FILE';
    public const DEFINE_SKIP_HTTPS_CHECK = 'DRPT_SKIP_HTTPS_CHECK';

    private function __construct() {}
}
