<?php

// declare(strict_types=1);

namespace Post\Controller;

use Post\Form\PostForm;
use Post\Model\Post;
use Post\Model\PostTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(PostTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->table->fetchAll(),
        ]);
    }

    public function tambahAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        $form = new PostForm();
        $form->get('submit')->setValue('Simpan');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $post = new Post();
        $form->setInputFilter($post->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $post->exchangeArray($form->getData());
        $this->table->savePost($post);
        return $this->redirect()->toRoute('post');
    }

    public function viewAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        return [
            'id'    => $id,
            'post' => $this->table->getPost($id),
        ];
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('post', ['action' => 'add']);
        }

        // Retrieve the post with the specified id. Doing so raises
        // an exception if the post is not found, which should result
        // in redirecting to the landing page.
        try {
            $post = $this->table->getPost($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('post', ['action' => 'index']);
        }

        $form = new PostForm();
        $form->bind($post);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($post->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->savePost($post);
        } catch (\Exception $e) {
        }

        // Redirect to post list
        return $this->redirect()->toRoute('post', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deletePost($id);
            }

            // Redirect to list of posts
            return $this->redirect()->toRoute('post');
        }

        return [
            'id'    => $id,
            'post' => $this->table->getPost($id),
        ];
    }
}
