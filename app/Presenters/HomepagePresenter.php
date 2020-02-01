<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Database\Context as DB;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    private $database;

    public function __construct(DB $database)
    {
        $this->database = $database;
    }

    public function renderDefault()
    {
        $this->template->ideas = $this->database->table('ideas')
            ->order('create_date DESC')
            ->limit(20);
    }
}
