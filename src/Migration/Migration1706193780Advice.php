<?php

namespace Crehler\Advice\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1706193780Advice extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1_706_193_780;
    }

    public function update(Connection $connection): void
    {
        $adviceQuery = <<<SQL
CREATE TABLE IF NOT EXISTS `crehler_advice` (
    `id` BINARY(16) NOT NULL,
    `product_stream_id` BINARY(16) NOT NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (id),
    CONSTRAINT `fk.crehler_advice.product_stream_id` FOREIGN KEY (`product_stream_id`)
        REFERENCES `product_stream` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
SQL;

        $adviceTranslationQuery = <<<SQL
CREATE TABLE IF NOT EXISTS `crehler_advice_translation` (
    `crehler_advice_id` BINARY(16) NOT NULL,
    `language_id` BINARY(16) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` MEDIUMTEXT NOT NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`crehler_advice_id`, `language_id`),
    CONSTRAINT `fk.crehler_advice_translation.crehler_advice_id` FOREIGN KEY (`crehler_advice_id`)
        REFERENCES `crehler_advice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.crehler_advice_translation.language_id` FOREIGN KEY (`language_id`)
        REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
SQL;
        $adviceRelationQuery = <<<SQL
CREATE TABLE IF NOT EXISTS `crehler_advice_sales_channel` (
    `crehler_advice_id` BINARY(16) NOT NULL,
    `sales_channel_id` BINARY(16) NOT NULL,
    PRIMARY KEY (`crehler_advice_id`, `sales_channel_id`),
    CONSTRAINT `fk.crehler_advice_sales_channel.crehler_advice_id` FOREIGN KEY (`crehler_advice_id`)
        REFERENCES `crehler_advice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.crehler_advice_sales_channel.sales_channel_id` FOREIGN KEY (`sales_channel_id`)
        REFERENCES `sales_channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
SQL;

        $connection->executeStatement($adviceQuery);
        $connection->executeStatement($adviceRelationQuery);
        $connection->executeStatement($adviceTranslationQuery);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }

}