<?php


namespace App\Controller;


class ArticlesController extends AppController
{
    public function index()
    {
        $articles = $this->Articles->find('all');
        $this->set(compact('articles'));
    }

    public function view()
    {
        $id = $this->request->param('pass.0');
        $article = $this->Articles->get($id);
        $users = $this->loadModel('Users')->find('author', ['id' => $article->user_id]);

        $viewed = $article->viewed;
        $article->viewed = $viewed + 1;
        $this->Articles->save($article);

        $comment = $this->loadModel('Comments')->newEntity();
        if ($this->request->is('post')) {
            $comment = $this->loadModel('Comments')->patchEntity($comment, $this->request->data());

            $comment->article_id = $article->id;

            if ($this->loadModel('Comments')->save($comment)) {
                $this->Flash->success(__('Your comment has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }

        $comments = $this->loadModel('Comments')->find('comments', ['id' => $article->id]);



        $this->set([
            'article' => $article,
            'users' => $users,
            'comments' => $comments,
            'comment' => $comment

        ]);



    }

    public function add()
    {

        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $request = $this->request->data();
            $article = $this->Articles->patchEntity($article, $this->request->data());
            // Added this line
            $article->user_id = $this->Auth->user('id');

            $file = $request['image'];
            $ext  = substr(strtolower(strrchr($file['name'], '.')), 1);
            $arr_ext = array('jpg', 'jpeg', 'png');

            if(in_array($ext, $arr_ext))
            {
                //do the actual uploading of the file. First arg is the tmp name, second arg is
                //where we are putting it
                if(move_uploaded_file($file['tmp_name'], WWW_ROOT . '/upload' . DS . $file['name']))
                {
                    $article->image = $file['name'];
                }
            }


            // You could also do the following
            //$newData = ['user_id' => $this->Auth->user('id')];
            //$article = $this->Articles->patchEntity($article, $newData);
            if ($this->Articles->save($article)) {

                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);


    }


    public function edit($id = null)
    {
        $article = $this->Articles->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->data());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set('article', $article);
    }


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function popular()
    {
        $articles = $this->Articles->find('popular');
        $this->set(compact('articles'));


    }
    public function isAuthorized($user)
    {
        // All registered users can add articles
        if ($this->request->param('action') === 'add') {
            return true;
        }

        // The owner of an article can edit and delete it
        if (in_array($this->request->param('action'), ['edit', 'delete'])) {
            $articleId = (int)$this->request->param('pass.0');
            if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }


}