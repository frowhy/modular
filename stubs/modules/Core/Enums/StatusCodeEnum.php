<?php


namespace Modules\Core\Enums;

class StatusCodeEnum extends BaseEnum
{
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    const HTTP_EARLY_HINTS = 103;           // RFC8297
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918

    /**
     * @deprecated
     */
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const HTTP_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    protected const __ = [
        self::HTTP_CONTINUE => 'continue',
        self::HTTP_SWITCHING_PROTOCOLS => 'switching_protocols',
        self::HTTP_PROCESSING => 'processing',
        self::HTTP_EARLY_HINTS => 'early_hints',
        self::HTTP_OK => 'ok',
        self::HTTP_CREATED => 'created',
        self::HTTP_ACCEPTED => 'accepted',
        self::HTTP_NON_AUTHORITATIVE_INFORMATION => 'non_authoritative_information',
        self::HTTP_NO_CONTENT => 'no_content',
        self::HTTP_RESET_CONTENT => 'reset_content',
        self::HTTP_PARTIAL_CONTENT => 'partial_content',
        self::HTTP_MULTI_STATUS => 'multi_status',
        self::HTTP_ALREADY_REPORTED => 'already_reported',
        self::HTTP_IM_USED => 'im_used',
        self::HTTP_MULTIPLE_CHOICES => 'multiple_choices',
        self::HTTP_MOVED_PERMANENTLY => 'moved_permanently',
        self::HTTP_FOUND => 'found',
        self::HTTP_SEE_OTHER => 'see_other',
        self::HTTP_NOT_MODIFIED => 'not_modified',
        self::HTTP_USE_PROXY => 'use_proxy',
        self::HTTP_TEMPORARY_REDIRECT => 'temporary_redirect',
        self::HTTP_PERMANENTLY_REDIRECT => 'permanent_redirect',
        self::HTTP_BAD_REQUEST => 'bad_request',
        self::HTTP_UNAUTHORIZED => 'unauthorized',
        self::HTTP_PAYMENT_REQUIRED => 'payment_required',
        self::HTTP_FORBIDDEN => 'forbidden',
        self::HTTP_NOT_FOUND => 'not_found',
        self::HTTP_METHOD_NOT_ALLOWED => 'method_not_allowed',
        self::HTTP_NOT_ACCEPTABLE => 'not_acceptable',
        self::HTTP_PROXY_AUTHENTICATION_REQUIRED => 'proxy_authentication_required',
        self::HTTP_REQUEST_TIMEOUT => 'request_timout',
        self::HTTP_CONFLICT => 'conflict',
        self::HTTP_GONE => 'gone',
        self::HTTP_LENGTH_REQUIRED => 'length_required',
        self::HTTP_PRECONDITION_FAILED => 'precondition_failed',
        self::HTTP_REQUEST_ENTITY_TOO_LARGE => 'payload_too_large',
        self::HTTP_REQUEST_URI_TOO_LONG => 'uri_too_long',
        self::HTTP_UNSUPPORTED_MEDIA_TYPE => 'unsupported_media_type',
        self::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE => 'range_not_satisfiable',
        self::HTTP_EXPECTATION_FAILED => 'expectation_failed',
        self::HTTP_I_AM_A_TEAPOT => 'i_am_a_teapot',
        self::HTTP_MISDIRECTED_REQUEST => 'misdirected_request',
        self::HTTP_UNPROCESSABLE_ENTITY => 'unprocessable_entity',
        self::HTTP_LOCKED => 'locked',
        self::HTTP_FAILED_DEPENDENCY => 'failed_dependency',
        self::HTTP_TOO_EARLY => 'too_early',
        self::HTTP_UPGRADE_REQUIRED => 'upgrade_required',
        self::HTTP_PRECONDITION_REQUIRED => 'precondition_required',
        self::HTTP_TOO_MANY_REQUESTS => 'too_many_requests',
        self::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE => 'request_header_fields_too_large',
        self::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS => 'unavailable_for_legal_reasons',
        self::HTTP_INTERNAL_SERVER_ERROR => 'internal_server_error',
        self::HTTP_NOT_IMPLEMENTED => 'not_implemented',
        self::HTTP_BAD_GATEWAY => 'bad_gateway',
        self::HTTP_SERVICE_UNAVAILABLE => 'service_unavailable',
        self::HTTP_GATEWAY_TIMEOUT => 'gateway_timeout',
        self::HTTP_VERSION_NOT_SUPPORTED => 'http_version_not_supported',
        self::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL => 'variant_also_negotiates',
        self::HTTP_INSUFFICIENT_STORAGE => 'insufficient_storage',
        self::HTTP_LOOP_DETECTED => 'loop_detected',
        self::HTTP_NOT_EXTENDED => 'not_extended',
        self::HTTP_NETWORK_AUTHENTICATION_REQUIRED => 'network_authentication_required',
    ];
}
