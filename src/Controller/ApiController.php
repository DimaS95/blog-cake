<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 30.09.2017
 * Time: 11:20
 */

namespace App\Controller;




class ApiController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index ()
    {
        $articles = $this->loadModel('Articles')->find('all');
        $this->set([
            'articles' => $articles,
            '_serialize' => ['articles']
        ]);
    }
    public function view($id)
    {
        $article = $this->loadModel('Articles')->get($id);
        $this->set([
            'article' => $article,
            '_serialize' => ['article']
        ]);
    }
    public function create()
    {


        $article = $this->loadModel('Articles')->newEntity();
        if ($this->request->is('post')) {
            $article = $this->loadModel('Articles')->patchEntity($article, $this->request->data());

            $article->user_id = $this->Auth->user('id');
        }

        if($this->loadModel('Articles')->save($article)){
            $message = 'Saved';
        }
        else{
            $message = 'trouble';
        }
        $this->set([
            'message' => $message,
            'article' => $article,
            '_serialize' => ['message', 'article']
        ]);

    }
    public function edit($id)
    {
        $article = $this->loadModel('Article')->get($id);
        if($this->request->is('post', 'put'))
        {
            $article = $this->loadModel('Article')->patchEntity($article, $this->request->data());
            if($this->loadModel('Article')->save()){
                $message = 'Saved';
            }
            else{
                $message = 'trouble';
            }
            $this->set([
                'message' => $message,
                '_serialize' => ['message']
            ]);
        }
    }
    public function delete($id)
    {
        $article = $this->loadModel('Article')->get($id);
        $message = 'Deleted';
        if(!$this->loadModel('Article')->delete($article)){
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}