<?php

namespace Engine\Console;

class Console extends Kernel
{
    protected $commands = [
        'new:crud' => 'newCrud',
        'new:controller' => 'newController',
        'new:model' => 'newModel',
        'new:migration' => 'newMigration',
        'serve' => 'serve',
    ];

    public function serve()
    {
        $this->runCommand('php -S localhost:8000 -t public');
    }

    public function newModel()
    {
        $name = Logger::ask('Model name: ');

        if (Logger::confirm('Do you want to create a migration for this model?')) {
            $this->newMigration($name);
        }
    }

    public function newMigration(string $tableName = '')
    {
        $name = 'create_' . $tableName . '_table';

        if (empty($tableName)) {
            $name = Logger::ask('Migration name: ');
            $tableName = Logger::ask('Table name: ');
        }

        if (Logger::confirm('Do you want to configure the table?')) {
            $table = $this->configureTable($tableName);
        }

        // $this->createMigration($name, $tableName);
    }

    public function configureTable()
    {

        $fields = [];
        $id = false;
        $timestamps = false;

        if (Logger::confirm('Do you want to add id?')) {
            $id = true;
        }

        if (Logger::confirm('Do you want to add timestamps?')) {
            $timestamps = true;
        }


        while (Logger::confirm('Do you want to add a new field?')) {
            $this->showColumns();
            Logger::indent('input: name type --flag1 --flag2 --flag3');
            $field = Logger::params('Field: ');
            $field = $this->parseField($field['params'][0], $field['params'][1], $field['flags']);
            if (!$field) {
                Logger::error('Invalid field!');
                continue;
            }
            $fields[] = $field;
            Logger::success('Field added!');
            Logger::log('Fields: ');
            $this->showCurrentFields($id, $timestamps, $fields);
        }


        var_dump($fields);
    }

    public function showCurrentFields(bool $id, bool $timestamps, array $fields)
    {
        if ($id) {
            array_unshift($fields, $this->parseField('id', 'integer', ['primary', 'unique']));
        }
        if ($timestamps) {
            $fields[] = $this->parseField('created_at', 'datetime', []);
            $fields[] = $this->parseField('updated_at', 'datetime', []);
        }

        Logger::table($fields, true, false);
    }

    public function showColumns()
    {
        $columnTypes = [
            'string' => 'The string field',
            'integer' => 'The integer field',
            'boolean' => 'The boolean field',
            'datetime' => 'The datetime field',
            'text' => 'The text that can be long',
            'float' => 'The float field',
        ];
        // $flags = ['primary', 'unique', 'nullable', 'default', 'length']; make this like the columnTypes
        $flags = [
            '--primary' => 'The primary key',
            '--unique' => 'The unique key',
            '--nullable' => 'The nullable key',
            '--default' => 'The default value, example: --default="John Doe"',
            '--length' => 'The length of the field, example: --length=255',
        ];

        Logger::nl();
        // Logger::log('Available column types: ');
        Logger::header('Available column types: ');
        Logger::details($columnTypes);
        // Logger::log('Available flags: ');
        Logger::header('Available flags: ');
        Logger::details($flags);
        Logger::nl();
    }

    public function parseField(string $name, string $type, array $flags)
    {
        if (!in_array($type, ['string', 'integer', 'boolean', 'datetime', 'text', 'float'])) {
            return false;
        }

        if (empty($name) || empty($type)) {
            return false;
        }

        $field = [
            'name' => $name,
            'type' => $type,
        ];

        $defaultFlags = [
            'primary' => false,
            'unique' => false,
            'nullable' => false,
            'default' => false,
            'length' => false,
        ];

        foreach ($flags as $flag) {
            if ($flag === 'primary') {
                $defaultFlags['primary'] = true;
            } elseif ($flag === 'unique') {
                $defaultFlags['unique'] = true;
            } elseif ($flag === 'nullable') {
                $defaultFlags['nullable'] = true;
            } elseif ($flag === 'default') {
                // the value is like this: --default="John Doe", parse it
                $value = explode('=', $flag);
                $value = str_replace('"', '', $value[1]);
                $defaultFlags['default'] = $value;
            } elseif ($flag === 'length') {
                // the value is like this: --length=255, parse it
                $value = explode('=', $flag);
                $field['length'] = $value[1];
            }
        }

        return array_merge($field, $defaultFlags);
    }
}
