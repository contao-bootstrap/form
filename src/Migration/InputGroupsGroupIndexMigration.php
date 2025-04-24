<?php

declare(strict_types=1);

namespace ContaoBootstrap\Form\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Override;

use function is_numeric;
use function serialize;

final class InputGroupsGroupIndexMigration extends AbstractMigration
{
    public function __construct(private readonly Connection $connection)
    {
    }

    #[Override]
    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();
        if (! $schemaManager->tablesExist(['tl_form_field'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_form_field');
        if (! isset($columns['bs_inputGroup'])) {
            return false;
        }

        $affected = (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM tl_form_field WHERE bs_inputGroup LIKE \'a:1:{i:0;%\'',
        );

        return $affected > 0;
    }

    #[Override]
    public function run(): MigrationResult
    {
        $result = $this->connection->fetchAllAssociative(
            'SELECT * FROM tl_form_field WHERE bs_inputGroup LIKE \'a:1:{i:0;%\'',
        );

        foreach ($result as $row) {
            $templates = [];

            foreach (StringUtil::deserialize($row['bs_inputGroup'], true) as $key => $template) {
                if (is_numeric($key)) {
                    $key  = (int) $key;
                    $key += 1;
                }

                $templates[$key] = $template;
            }

            $this->connection->update(
                'tl_form_field',
                ['bs_inputGroup' => serialize($templates)],
                ['id' => $row['id']],
            );
        }

        return $this->createResult(true);
    }
}
