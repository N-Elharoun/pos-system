<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.company_name', 'My Company');
        $this->migrator->add('general.company_email', 'info@mycompany.com');
        $this->migrator->add('general.company_phone', '123-456-7890');
        $this->migrator->add('general.company_logo', 'logo.png');
    }
};
