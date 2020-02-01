<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


final class IdeaPresenter extends Nette\Application\UI\Presenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function renderShow($ideaId)
    {
        $this->template->idea = $this->database->table('ideas')
            ->get($ideaId);
    }

    protected function createComponentCommentForm()
    {
        $form = new Form;
        $form->addText('name', 'Your Name:')
            ->setRequired();
        $form->addText('email', 'Your email:');
        $form->addText('body', 'Comment:')
            ->setRequired();
        $form->addSubmit('send', 'Publish');
        $form->onSuccess[] = array($this, 'commentFormSucceeded');

        return $form;        
    }

    public function commentFormSucceeded($form, $values)
    { 
        $ideaId = $this->getParameter('ideaId');
        $this->database->table('comments')->insert(array(
            'idea_id' => $ideaId,
            'name' => $values->name,
            'email' => $values->email,
            'body' => $values->body,
        ));

        $this->flashMessage('Thank you.', 'success');
        $this->redirect('this');
    }
}
