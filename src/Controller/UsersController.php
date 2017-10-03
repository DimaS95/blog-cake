<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['add', 'logout', 'articles']);
    }

    public function login()
    {
        if (is_object($this->Auth)) {
            if ($this->Auth->user() !== null) {
                $this->redirect("/articles");

            }
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function listing()
    {


            $this->set('users', $this->Users->find('all'));


    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $count = $this->loadModel('Articles')->find('UsersPosts', ['id' => $user->id]);

        $this->set('user', $user);
        $this->set('count', $count);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user['role'] = 'author';
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function profile()
    {
        $user = $this->Auth->user();
        $id = $user['id'];
       // $users = $this->Users->find('Author', ['id' => $id]);

        if($user['role'] === 'admin'){
            $articles = $this->loadModel('Articles')->find('all');
          $this->set([
                'id' => $id,
                'articles' => $articles,
                'user' => $user
            ]);

        }else {
            $articles = $this->loadModel('Articles')->find('personal',
                ['id' => $id]);


            $this->set([
                'id' => $id,
                'articles' => $articles,
                'user' => $user
            ]);
        }
    }

    public function isAuthorized($currentUser)
    {
        $user = $this->Auth->user();


        // The owner of an article can edit and delete it
        if (in_array($this->request->param('action'), ['profile'])) {

            if ($user['id'] == $currentUser['id']) {
                return true;
            }




        }







        return parent::isAuthorized($currentUser);
    }

    public function articles()
    {
        $id = $this->request->param('pass.0');
        $users = $this->Users->find('Author', ['id' => $id]);
        $articles = $this->loadModel('Articles')->find('personal',
            ['id' => $id]);

        $this->set([
            'id' => $id,
            'articles' => $articles,
            'users' => $users
        ]);
    }

}
