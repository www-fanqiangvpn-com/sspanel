<?php

declare(strict_types=1);

use App\Interfaces\MigrationInterface;
use App\Services\DB;

return new class() implements MigrationInterface {
    public function up(): int
    {
        DB::getPdo()->exec(
            "CREATE TABLE `alive_ip` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `nodeid` int(11) DEFAULT NULL,
                `userid` int(11) DEFAULT NULL,
                `ip` varchar(255) DEFAULT NULL,
                `datetime` bigint(20) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `announcement` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `date` datetime DEFAULT NULL,
                `content` text DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `bought` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `userid` bigint(20) DEFAULT NULL,
                `shopid` bigint(20) DEFAULT NULL,
                `datetime` bigint(20) DEFAULT NULL,
                `renew` bigint(20) DEFAULT NULL,
                `coupon` varchar(255) DEFAULT NULL,
                `price` decimal(12,2) DEFAULT NULL,
                `is_notified` tinyint(1) DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `code` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `code` varchar(255) DEFAULT NULL,
                `type` int(11) DEFAULT NULL,
                `number` decimal(12,2) DEFAULT NULL,
                `isused` int(11) DEFAULT 0,
                `userid` bigint(20) DEFAULT NULL,
                `usedatetime` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `config` (
                `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '??????',
                `item` varchar(255) DEFAULT NULL COMMENT '???',
                `value` varchar(2048) DEFAULT NULL,
                `class` varchar(255) DEFAULT 'default' COMMENT '????????????',
                `is_public` int(11) DEFAULT 0 COMMENT '?????????????????????',
                `type` varchar(255) DEFAULT NULL COMMENT '?????????',
                `default` varchar(255) DEFAULT NULL COMMENT '?????????',
                `mark` varchar(255) DEFAULT NULL COMMENT '??????',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `coupon` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `code` varchar(255) DEFAULT NULL,
                `onetime` int(11) DEFAULT NULL,
                `expire` bigint(20) DEFAULT NULL,
                `shop` varchar(255) DEFAULT NULL,
                `credit` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `detect_ban_log` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_name` varchar(255) DEFAULT NULL COMMENT '?????????',
                `user_id` bigint(20) unsigned DEFAULT NULL COMMENT '?????? ID',
                `email` varchar(255) DEFAULT NULL COMMENT '????????????',
                `detect_number` int(11) DEFAULT NULL COMMENT '??????????????????',
                `ban_time` int(11) DEFAULT NULL COMMENT '??????????????????',
                `start_time` bigint(20) DEFAULT NULL COMMENT '??????????????????',
                `end_time` bigint(20) DEFAULT NULL COMMENT '??????????????????',
                `all_detect_number` int(11) DEFAULT NULL COMMENT '??????????????????',
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `detect_list` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `text` varchar(255) DEFAULT NULL,
                `regex` varchar(255) DEFAULT NULL,
                `type` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `detect_log` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` bigint(20) unsigned DEFAULT NULL,
                `list_id` bigint(20) unsigned DEFAULT NULL,
                `datetime` bigint(20) unsigned DEFAULT NULL,
                `node_id` int(11) DEFAULT NULL,
                `status` int(11) DEFAULT 0,
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`),
                KEY `node_id` (`node_id`),
                KEY `list_id` (`list_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `docs` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `date` datetime DEFAULT NULL,
                `title` varchar(255) DEFAULT NULL,
                `content` varchar(255) DEFAULT NULL,
                `markdown` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `email_queue` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `to_email` varchar(255) DEFAULT NULL,
                `subject` varchar(255) DEFAULT NULL,
                `template` varchar(255) DEFAULT NULL,
                `array` longtext DEFAULT NULL,
                `time` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `email_verify` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `email` varchar(255) DEFAULT NULL,
                `ip` varchar(255) DEFAULT NULL,
                `code` varchar(255) DEFAULT NULL,
                `expire_in` bigint(20) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `gift_card` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `card` text DEFAULT NULL COMMENT '??????',
                `balance` int(11) DEFAULT NULL COMMENT '??????',
                `create_time` int(11) DEFAULT NULL COMMENT '????????????',
                `status` int(11) DEFAULT NULL COMMENT '????????????',
                `use_time` int(11) DEFAULT NULL COMMENT '????????????',
                `use_user` int(11) DEFAULT NULL COMMENT '????????????',
                PRIMARY KEY (`id`),
                KEY `id` (`id`),
                KEY `status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `invoice` (
                `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '??????ID',
                `user_id` int(11) DEFAULT NULL COMMENT '????????????',
                `order_id` int(11) DEFAULT NULL COMMENT '??????ID',
                `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '????????????' CHECK (json_valid(`content`)),
                `price` double DEFAULT NULL COMMENT '????????????',
                `status` varchar(255) DEFAULT NULL COMMENT '????????????',
                `create_time` int(11) DEFAULT NULL COMMENT '????????????',
                `update_time` int(11) DEFAULT NULL COMMENT '????????????',
                `pay_time` int(11) DEFAULT NULL COMMENT '????????????',
                PRIMARY KEY (`id`),
                KEY `id` (`id`),
                KEY `user_id` (`user_id`),
                KEY `order_id` (`order_id`),
                KEY `status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `link` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `token` varchar(255) DEFAULT NULL,
                `userid` bigint(20) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `token` (`token`),
                UNIQUE KEY `userid` (`userid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `login_ip` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `userid` bigint(20) unsigned DEFAULT NULL,
                `ip` varchar(255) DEFAULT NULL,
                `datetime` bigint(20) DEFAULT NULL,
                `type` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `userid` (`userid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `node` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `type` int(11) DEFAULT NULL,
                `server` varchar(255) DEFAULT NULL,
                `custom_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '{}' COMMENT '???????????????' CHECK (json_valid(`custom_config`)),
                `info` text DEFAULT '',
                `status` varchar(255) DEFAULT '',
                `sort` int(11) DEFAULT NULL,
                `traffic_rate` float DEFAULT 1,
                `node_class` int(11) DEFAULT 0,
                `node_speedlimit` double NOT NULL DEFAULT 0 COMMENT '????????????',
                `node_connector` int(11) DEFAULT 0,
                `node_bandwidth` bigint(20) DEFAULT 0,
                `node_bandwidth_limit` bigint(20) DEFAULT 0,
                `bandwidthlimit_resetday` int(11) DEFAULT 0,
                `node_heartbeat` bigint(20) DEFAULT 0,
                `online_user` int(11) DEFAULT 0 COMMENT '??????????????????',
                `node_ip` varchar(255) DEFAULT NULL,
                `node_group` int(11) DEFAULT 0,
                `mu_only` tinyint(1) DEFAULT 0,
                `online` tinyint(1) DEFAULT 1,
                `gfw_block` tinyint(1) DEFAULT 0,
                `password` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `order` (
                `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '??????ID',
                `user_id` int(11) DEFAULT NULL COMMENT '????????????',
                `product_id` int(11) DEFAULT NULL COMMENT '??????ID',
                `product_type` varchar(255) DEFAULT NULL COMMENT '????????????',
                `product_name` varchar(255) DEFAULT NULL COMMENT '????????????',
                `product_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '????????????' CHECK (json_valid(`product_content`)),
                `coupon` varchar(255) DEFAULT NULL COMMENT '???????????????',
                `price` double DEFAULT NULL COMMENT '????????????',
                `status` varchar(255) DEFAULT NULL COMMENT '????????????',
                `create_time` int(11) DEFAULT NULL COMMENT '????????????',
                `update_time` int(11) DEFAULT NULL COMMENT '????????????',
                PRIMARY KEY (`id`),
                KEY `id` (`id`),
                KEY `user_id` (`user_id`),
                KEY `product_id` (`product_id`),
                KEY `status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `payback` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `total` decimal(12,2) DEFAULT NULL,
                `userid` bigint(20) DEFAULT NULL,
                `ref_by` bigint(20) DEFAULT NULL,
                `ref_get` decimal(12,2) DEFAULT NULL,
                `datetime` bigint(20) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `paylist` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `userid` bigint(20) unsigned DEFAULT NULL,
                `total` decimal(12,2) DEFAULT NULL,
                `status` int(11) DEFAULT 0,
                `tradeno` varchar(255) DEFAULT NULL,
                `datetime` bigint(20) DEFAULT 0,
                PRIMARY KEY (`id`),
                KEY `userid` (`userid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `product` (
                `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '??????ID',
                `type` varchar(255) DEFAULT NULL COMMENT '??????',
                `name` varchar(255) DEFAULT NULL COMMENT '??????',
                `price` double DEFAULT NULL COMMENT '??????',
                `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '??????' CHECK (json_valid(`content`)),
                `limit` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '????????????' CHECK (json_valid(`limit`)),
                `status` int(11) DEFAULT NULL COMMENT '????????????',
                `create_time` int(11) DEFAULT NULL COMMENT '????????????',
                `update_time` int(11) DEFAULT NULL COMMENT '????????????',
                `sale_count` int(11) DEFAULT NULL COMMENT '???????????????',
                `stock` int(11) DEFAULT NULL COMMENT '??????',
                PRIMARY KEY (`id`),
                KEY `id` (`id`),
                KEY `type` (`type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `shop` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `price` decimal(12,2) DEFAULT NULL,
                `content` text DEFAULT NULL,
                `auto_renew` int(11) DEFAULT NULL,
                `auto_reset_bandwidth` int(11) DEFAULT 0,
                `status` int(11) DEFAULT 1,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `stream_media` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `node_id` int(11) DEFAULT NULL COMMENT '??????id',
                `result` text DEFAULT NULL COMMENT '????????????',
                `created_at` int(11) DEFAULT NULL COMMENT '????????????',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `telegram_session` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `user_id` bigint(20) DEFAULT NULL,
                `type` int(11) DEFAULT NULL,
                `session_content` varchar(255) DEFAULT NULL,
                `datetime` bigint(20) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `ticket` (
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) DEFAULT NULL,
                `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '' COMMENT '????????????' CHECK (json_valid(`content`)),
                `userid` bigint(20) DEFAULT NULL,
                `datetime` bigint(20) DEFAULT NULL,
                `status` varchar(255) DEFAULT '' COMMENT '????????????',
                `type` varchar(255) DEFAULT 'other' COMMENT '????????????',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `user` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '??????ID',
                `user_name` varchar(255) DEFAULT NULL COMMENT '?????????',
                `email` varchar(255) DEFAULT NULL COMMENT 'E-Mail',
                `pass` varchar(255) DEFAULT NULL COMMENT '????????????',
                `passwd` varchar(255) DEFAULT NULL COMMENT '????????????',
                `uuid` char(36) NOT NULL COMMENT 'UUID',
                `t` bigint(20) unsigned DEFAULT 0 COMMENT '??????????????????',
                `u` bigint(20) unsigned DEFAULT 0 COMMENT '????????????????????????',
                `d` bigint(20) unsigned DEFAULT 0 COMMENT '????????????????????????',
                `transfer_total` bigint(20) unsigned DEFAULT 0 COMMENT '????????????????????????',
                `transfer_enable` bigint(20) unsigned DEFAULT 0 COMMENT '????????????????????????',
                `port` smallint(6) unsigned NOT NULL COMMENT '??????',
                `last_detect_ban_time` datetime DEFAULT '1989-06-04 00:05:00' COMMENT '??????????????????????????????',
                `all_detect_number` int(11) DEFAULT 0 COMMENT '??????????????????',
                `last_check_in_time` bigint(20) unsigned DEFAULT 0 COMMENT '??????????????????',
                `reg_date` datetime DEFAULT NULL COMMENT '????????????',
                `invite_num` int(11) DEFAULT 0 COMMENT '??????????????????',
                `money` decimal(10,2) NOT NULL DEFAULT 0.00,
                `ref_by` bigint(20) unsigned DEFAULT 0 COMMENT '?????????ID',
                `method` varchar(255) DEFAULT 'rc4-md5' COMMENT 'Shadowsocks????????????',
                `reg_ip` varchar(255) DEFAULT '127.0.0.1' COMMENT '??????IP',
                `node_speedlimit` double NOT NULL DEFAULT 0 COMMENT '????????????',
                `node_iplimit` smallint(6) unsigned NOT NULL DEFAULT 0 COMMENT '???????????????IP???',
                `node_connector` int(11) DEFAULT 0 COMMENT '????????????????????????',
                `is_admin` tinyint(1) DEFAULT 0 COMMENT '???????????????',
                `im_type` int(11) DEFAULT 1 COMMENT '??????????????????',
                `im_value` varchar(255) DEFAULT '' COMMENT '????????????',
                `last_day_t` bigint(20) DEFAULT 0 COMMENT '??????????????????????????????',
                `sendDailyMail` tinyint(1) DEFAULT 0 COMMENT '??????????????????',
                `class` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '??????',
                `class_expire` datetime DEFAULT '1989-06-04 00:05:00' COMMENT '??????????????????',
                `expire_in` datetime DEFAULT '2099-06-04 00:05:00',
                `theme` varchar(255) DEFAULT NULL COMMENT '????????????',
                `ga_token` varchar(255) DEFAULT NULL,
                `ga_enable` int(11) DEFAULT 0,
                `remark` text DEFAULT '' COMMENT '??????',
                `node_group` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '????????????',
                `is_banned` int(11) DEFAULT 0 COMMENT '????????????',
                `banned_reason` varchar(255) DEFAULT '' COMMENT '????????????',
                `telegram_id` bigint(20) DEFAULT 0,
                `expire_notified` tinyint(1) DEFAULT 0,
                `traffic_notified` tinyint(1) DEFAULT 0,
                `forbidden_ip` varchar(255) DEFAULT '',
                `forbidden_port` varchar(255) DEFAULT '',
                `auto_reset_day` int(11) DEFAULT 0,
                `auto_reset_bandwidth` decimal(12,2) DEFAULT 0.00,
                `api_token` char(36) NOT NULL DEFAULT '' COMMENT 'API ??????',
                `use_new_shop` smallint(6) NOT NULL DEFAULT 0 COMMENT '?????????????????????',
                `is_dark_mode` int(11) DEFAULT 0,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uuid` (`uuid`),
                UNIQUE KEY `email` (`email`),
                UNIQUE KEY `ga_token` (`ga_token`),
                KEY `user_name` (`user_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `user_coupon` (
                `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '?????????ID',
                `code` varchar(255) DEFAULT NULL COMMENT '?????????',
                `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '???????????????' CHECK (json_valid(`content`)),
                `limit` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '???????????????' CHECK (json_valid(`limit`)),
                `create_time` int(11) DEFAULT NULL COMMENT '????????????',
                `expire_time` int(11) DEFAULT NULL COMMENT '????????????',
                PRIMARY KEY (`id`),
                KEY `id` (`id`),
                KEY `code` (`code`),
                KEY `expire_time` (`expire_time`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `user_hourly_usage` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` bigint(20) unsigned DEFAULT NULL,
                `traffic` bigint(20) DEFAULT NULL,
                `hourly_usage` bigint(20) DEFAULT NULL,
                `datetime` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `user_invite_code` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `code` varchar(255) DEFAULT NULL,
                `user_id` bigint(20) unsigned DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                `updated_at` timestamp NULL DEFAULT '2016-05-31 15:00:00',
                PRIMARY KEY (`id`),
                UNIQUE KEY `code` (`code`),
                UNIQUE KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `user_password_reset` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `email` varchar(255) DEFAULT NULL,
                `token` varchar(255) DEFAULT NULL,
                `init_time` int(11) DEFAULT NULL,
                `expire_time` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `user_subscribe_log` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `user_name` varchar(255) DEFAULT NULL COMMENT '?????????',
                `user_id` bigint(20) unsigned DEFAULT NULL COMMENT '?????? ID',
                `email` varchar(255) DEFAULT NULL COMMENT '????????????',
                `subscribe_type` varchar(255) DEFAULT NULL COMMENT '?????????????????????',
                `request_ip` varchar(255) DEFAULT NULL COMMENT '?????? IP',
                `request_time` datetime DEFAULT NULL COMMENT '????????????',
                `request_user_agent` text DEFAULT NULL COMMENT '?????? UA ??????',
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE `user_token` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `token` varchar(255) DEFAULT NULL,
                `user_id` bigint(20) unsigned DEFAULT NULL,
                `create_time` bigint(20) unsigned DEFAULT NULL,
                `expire_time` bigint(20) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
        );

        return 2023020100;
    }

    public function down(): int
    {
        echo "No reverse operation for initial migration\n";

        return 2023020100;
    }
};
