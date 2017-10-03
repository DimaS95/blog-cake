
<h1>Blog articles</h1>


<!-- Here's where we loop through our $articles query object, printing out article info -->

  <section style="margin-left: 50px">
    <?php foreach ($articles as $article): ?>
 <article>

            <br/>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
<br/>
            <?= $article->created->format(DATE_RFC850) ?>

 <article>
 <br/>
    <?php endforeach; ?>
    </section>
