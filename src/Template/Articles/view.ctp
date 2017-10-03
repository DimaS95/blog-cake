


<section style="text-align:  center;">

 <article>


            <h2><?= $article->title ?></h2>
<br/>
<p><?= $article->body ?></p>
<br/>

<img src = "<?= '/upload/'.$article->image; ?>"></img>


 </article>
<p>Author:</p> <?php foreach ($users as $user): ?>
<?= $this->Html->link($user->username, ['controller' => 'Users','action' => 'articles','_full' => true, $user->id]) ?>

<?php endforeach; ?>
</p>

            <?= $article->created->format(DATE_RFC850) ?>
    </section>
<div style = "margin-left: 100px">
 <h1>Add Comment</h1>
    <?php
        echo $this->Form->create($comment);
        echo $this->Form->control('name');
        echo $this->Form->control('text');

        echo $this->Form->button(__('Save Comment'));
        echo $this->Form->end();
    ?>
<div class = "container">
 <?php foreach ($comments as $comm): ?>
    <h4><?= $comm->name ?></h4>
    <?= $comm->text ?>
    <br/>
    <?php endforeach; ?>
</div>



 </div>
